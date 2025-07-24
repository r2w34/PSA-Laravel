// Browser console script to seed the database
// Copy and paste this into the browser console on the production site

(async function seedDatabaseFromBrowser() {
  console.log('🌱 Starting database seeding from browser...');
  
  try {
    // First, let's try the seeding endpoint
    console.log('🔍 Trying seeding endpoint...');
    
    const seedResponse = await fetch('/api/seed-database', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({})
    });
    
    if (seedResponse.ok) {
      const result = await seedResponse.json();
      console.log('✅ Seeding endpoint worked!', result);
      return;
    } else {
      console.log('⚠️ Seeding endpoint not available, trying alternative approach...');
    }
    
    // Alternative: Try to create data through existing endpoints
    console.log('🏃 Creating sports through API...');
    
    const sportsData = [
      { name: 'Cricket', description: 'Cricket training and coaching', isActive: true },
      { name: 'Football', description: 'Football training', isActive: true },
      { name: 'Basketball', description: 'Basketball training', isActive: true }
    ];
    
    const createdSports = [];
    for (const sport of sportsData) {
      try {
        const response = await fetch('/api/sports', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(sport)
        });
        
        if (response.ok) {
          const createdSport = await response.json();
          createdSports.push(createdSport);
          console.log(`✅ Created sport: ${sport.name}`);
        } else {
          console.log(`⚠️ Failed to create sport: ${sport.name}`);
        }
      } catch (error) {
        console.log(`❌ Error creating sport ${sport.name}:`, error);
      }
    }
    
    // Create batches
    console.log('📚 Creating batches...');
    const batchesData = [
      { name: 'Morning Cricket Batch', sportId: createdSports[0]?.id, skillLevel: 'beginner', maxCapacity: 20, schedule: { days: ['monday', 'wednesday', 'friday'], time: '6:00 AM - 7:30 AM' } },
      { name: 'Morning Football Batch', sportId: createdSports[1]?.id, skillLevel: 'beginner', maxCapacity: 18, schedule: { days: ['monday', 'wednesday', 'friday'], time: '7:00 AM - 8:30 AM' } },
      { name: 'Morning Basketball Batch', sportId: createdSports[2]?.id, skillLevel: 'intermediate', maxCapacity: 16, schedule: { days: ['monday', 'wednesday', 'friday'], time: '8:00 AM - 9:30 AM' } }
    ];
    
    const createdBatches = [];
    for (const batch of batchesData) {
      if (batch.sportId) {
        try {
          const response = await fetch('/api/batches', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(batch)
          });
          
          if (response.ok) {
            const createdBatch = await response.json();
            createdBatches.push(createdBatch);
            console.log(`✅ Created batch: ${batch.name}`);
          } else {
            console.log(`⚠️ Failed to create batch: ${batch.name}`);
          }
        } catch (error) {
          console.log(`❌ Error creating batch ${batch.name}:`, error);
        }
      }
    }
    
    // Create students
    console.log('👥 Creating students...');
    const studentsData = [
      { name: 'Rahul Sharma', phone: '9876543210', email: 'rahul.sharma@email.com', skillLevel: 'beginner', sportId: createdSports[0]?.id, batchId: createdBatches[0]?.id },
      { name: 'Priya Patel', phone: '9876543211', email: 'priya.patel@email.com', skillLevel: 'beginner', sportId: createdSports[1]?.id, batchId: createdBatches[1]?.id },
      { name: 'Amit Kumar', phone: '9876543212', email: 'amit.kumar@email.com', skillLevel: 'intermediate', sportId: createdSports[2]?.id, batchId: createdBatches[2]?.id },
      { name: 'Test Student', phone: '9999999999', email: 'test@email.com', skillLevel: 'beginner', sportId: createdSports[0]?.id, batchId: createdBatches[0]?.id }
    ];
    
    let studentCounter = 1;
    for (const student of studentsData) {
      if (student.sportId && student.batchId) {
        try {
          const studentData = {
            ...student,
            studentId: `STU${String(studentCounter).padStart(3, '0')}`,
            isActive: true,
            joiningDate: new Date().toISOString()
          };
          
          const response = await fetch('/api/students', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(studentData)
          });
          
          if (response.ok) {
            const createdStudent = await response.json();
            console.log(`✅ Created student: ${student.name} (STU${String(studentCounter).padStart(3, '0')})`);
            studentCounter++;
          } else {
            const error = await response.text();
            console.log(`⚠️ Failed to create student: ${student.name}`, error);
          }
        } catch (error) {
          console.log(`❌ Error creating student ${student.name}:`, error);
        }
      }
    }
    
    console.log('🎉 Database seeding completed!');
    console.log('🔍 Testing search functionality...');
    
    // Test search
    const searchResponse = await fetch('/api/students?search=test&limit=10');
    if (searchResponse.ok) {
      const searchResult = await searchResponse.json();
      console.log(`✅ Search test: Found ${searchResult.total || searchResult.students?.length || 0} students`);
    }
    
  } catch (error) {
    console.error('❌ Error during seeding:', error);
  }
})();

// Instructions:
console.log(`
🌱 Database Seeding Script for PSA Nashik
==========================================

To use this script:
1. Open the browser console (F12)
2. Navigate to the PSA Nashik application
3. Make sure you're logged in as an admin
4. Copy and paste this entire script into the console
5. Press Enter to run

The script will:
- Try to use the seeding endpoint if available
- Fall back to creating data through individual API endpoints
- Create 3 sports, 3 batches, and 4 students
- Test the search functionality

After running, you should be able to search for students in the Fees page.
`);