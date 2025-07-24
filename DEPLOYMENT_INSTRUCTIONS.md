# PSA-NASHIK Deployment Instructions

## Issues Fixed

### 1. Data Synchronization Issue
- **Root Cause**: React Query cache configuration with `staleTime: Infinity` preventing fresh data fetches
- **Fix Applied**: Modified `client/src/lib/queryClient.ts` to use `staleTime: 0` and `refetchOnWindowFocus: true`
- **Additional**: Added refresh button to manually invalidate cache

### 2. Logo Display Issue  
- **Root Cause**: Hardcoded development path `/src/assets/psa-logo.png` not working in production
- **Fix Applied**: Updated `client/src/components/layout/sidebar.tsx` to use proper Vite asset import
- **Result**: Logo now properly bundled as `assets/psa-logo-CLas-00W.png` in build

## Deployment Steps

### Step 1: Copy Built Files to Production Server
```bash
# On production server (194.238.23.217)
cd /var/www/psa-nashik

# Backup current files
cp -r dist/public dist/public.backup.$(date +%Y%m%d_%H%M%S)

# Copy new built files (you'll need to transfer these files)
# The built files are in: /workspace/PSA-NASHIK/dist/public/
# - index.html
# - assets/psa-logo-CLas-00W.png  
# - assets/index-CAV9p-Wn.js
# - assets/index-D7E52AxT.css
```

### Step 2: Restart the Service
```bash
# Restart the PSA service
sudo systemctl restart psa-nashik

# Verify service is running
sudo systemctl status psa-nashik

# Check logs if needed
sudo journalctl -u psa-nashik -f
```

### Step 3: Verify Fixes
1. **Logo Fix**: Visit http://194.238.23.217 - logo should display correctly
2. **Data Sync**: Visit http://194.238.23.217/students - click "Refresh" button to test cache invalidation
3. **Fresh Data**: Data should update immediately when refresh is clicked

## Files Modified

### 1. client/src/lib/queryClient.ts
```typescript
// Changed from:
staleTime: Infinity

// To:
staleTime: 0,
refetchOnWindowFocus: true
```

### 2. client/src/components/layout/sidebar.tsx
```typescript
// Added import:
import psaLogo from "@/assets/psa-logo.png";

// Changed from:
src="/src/assets/psa-logo.png"

// To:
src={psaLogo}
```

### 3. client/src/pages/students.tsx
```typescript
// Added refresh functionality:
import { useQueryClient } from "@tanstack/react-query";
import { RefreshCw } from "lucide-react";

const handleRefresh = () => {
  queryClient.invalidateQueries({ queryKey: ['/api/students'] });
};

// Added refresh button in UI
```

## Expected Results After Deployment

1. **Logo**: PSA logo displays correctly in sidebar
2. **Data Sync**: Students page shows real-time data from database
3. **Cache Control**: Refresh button forces fresh data fetch
4. **Performance**: Data refreshes automatically when window gains focus

## Troubleshooting

If issues persist after deployment:

1. **Clear Browser Cache**: Hard refresh (Ctrl+F5) to clear old cached assets
2. **Check Console**: Open browser dev tools to see any JavaScript errors
3. **Verify API**: Test http://194.238.23.217/api/students directly
4. **Check Service**: Ensure psa-nashik service is running on port 5000

## Database Verification

Current database should contain:
- Rahul Sharma (PSA001)
- Priya Patel (PSA002) 
- Amit Kumar (PSA003)

If UI shows different data, the cache fix will resolve this.