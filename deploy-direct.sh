#!/bin/bash

# PSA Nashik Student Fix Deployment Script
echo "🚀 Starting PSA Nashik Student Fix Deployment..."

# Stop current application
echo "📛 Stopping current application..."
pkill -f "node.*psa-nashik"
sleep 2

# Backup current deployment
echo "💾 Creating backup..."
BACKUP_DIR="/var/www/psa-nashik/dist.backup.$(date +%Y%m%d_%H%M%S)"
cp -r /var/www/psa-nashik/dist "$BACKUP_DIR"
echo "✅ Backup created at: $BACKUP_DIR"

# Create the fixed files directly
echo "🔧 Applying student creation fix..."

# Fix student-form.tsx
cat > /tmp/student-form-fix.js << 'EOF'
// Fixed mutation function for student creation
const createStudentMutation = useMutation({
  mutationFn: async (data) => {
    const response = await apiRequest('POST', '/api/students', data);
    return response.json();
  },
  onSuccess: (data) => {
    console.log('Student created successfully:', data);
    queryClient.invalidateQueries({ queryKey: ['students'] });
    setOpen(false);
    reset();
    toast({
      title: "Success",
      description: "Student added successfully!",
    });
  },
  onError: (error) => {
    console.error('Error creating student:', error);
    toast({
      title: "Error",
      description: error.message || "Failed to add student",
      variant: "destructive",
    });
  },
});
EOF

# Apply the fix to the production files
echo "📝 Updating production files..."

# Since we can't easily patch the minified files, let's rebuild from source
cd /var/www/psa-nashik

# Check if we have source files
if [ -d "client" ]; then
    echo "📦 Rebuilding from source..."
    
    # Apply the fix to source files
    if [ -f "client/src/components/students/student-form.tsx" ]; then
        # Create a backup of the original
        cp client/src/components/students/student-form.tsx client/src/components/students/student-form.tsx.backup
        
        # Apply the fix using sed
        sed -i 's/return await apiRequest("POST", url, data);/const response = await apiRequest("POST", url, data); return response.json();/g' client/src/components/students/student-form.tsx
        
        echo "✅ Fixed student-form.tsx"
    fi
    
    # Fix other mutation files
    for file in client/src/pages/coaches.tsx client/src/pages/settings.tsx client/src/pages/batches.tsx client/src/pages/sports.tsx client/src/pages/communications.tsx; do
        if [ -f "$file" ]; then
            cp "$file" "$file.backup"
            sed -i 's/return await apiRequest("POST", url, data);/const response = await apiRequest("POST", url, data); return response.json();/g' "$file"
            sed -i 's/return await apiRequest("PUT", url, data);/const response = await apiRequest("PUT", url, data); return response.json();/g' "$file"
            echo "✅ Fixed $file"
        fi
    done
    
    # Rebuild the application
    echo "🔨 Building application..."
    npm run build
    
    if [ $? -eq 0 ]; then
        echo "✅ Build successful"
    else
        echo "❌ Build failed, restoring backup..."
        rm -rf dist
        cp -r "$BACKUP_DIR" dist
        echo "🔄 Backup restored"
        exit 1
    fi
else
    echo "❌ Source files not found. Cannot rebuild."
    echo "Please upload the fixed dist files manually."
    exit 1
fi

# Start the application
echo "🚀 Starting application..."
cd dist
nohup node index.js > /var/log/psa-nashik.log 2>&1 &

# Wait and verify
sleep 5

if pgrep -f "node.*psa-nashik" > /dev/null; then
    PID=$(pgrep -f 'node.*psa-nashik')
    echo "✅ Application started successfully!"
    echo "📊 Process ID: $PID"
    echo "📋 Log file: /var/log/psa-nashik.log"
    echo "🌐 Application URL: http://45.194.46.109:3000"
    echo ""
    echo "🧪 Test the fix:"
    echo "1. Go to http://45.194.46.109:3000/students"
    echo "2. Click 'Add Student'"
    echo "3. Fill the form and submit"
    echo "4. You should see 'Student added successfully!' instead of 'Failed to add student'"
else
    echo "❌ Application failed to start"
    echo "📋 Last 20 lines of log:"
    tail -20 /var/log/psa-nashik.log
    echo ""
    echo "🔄 Restoring backup..."
    pkill -f "node.*psa-nashik"
    rm -rf dist
    cp -r "$BACKUP_DIR" dist
    cd dist
    nohup node index.js > /var/log/psa-nashik.log 2>&1 &
    echo "✅ Backup restored"
fi

echo "🏁 Deployment script completed!"
EOF