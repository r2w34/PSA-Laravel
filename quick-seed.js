// Quick seeding script for production
const fetch = require('node-fetch');

async function seedDatabase() {
  console.log('🌱 Starting quick database seeding...');
  
  const baseUrl = 'http://194.238.23.217';
  
  try {
    // Create sports first
    console.log('🏃 Creating sports...');
    const sportsData = [
      { name: 'Cricket', description: 'Cricket training and coaching', isActive: true, monthlyFee: 1500 },
      { name: 'Football', description: 'Football training', isActive: true, monthlyFee: 1200 },
      { name: 'Basketball', description: 'Basketball training', isActive: true, monthlyFee: 1000 }
    ];
    
    const createdSports = [];
    for (const sport of sportsData) {
      try {
        const response = await fetch(`${baseUrl}/api/sports`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Cookie': 'connect.sid=s%3AyourSessionId' // You'll need to get this from browser
          },
          body: JSON.stringify(sport)
        });
        
        if (response.ok) {
          const createdSport = await response.json();
          createdSports.push(createdSport);
          console.log(`✅ Created sport: ${sport.name}`);
        } else {
          console.log(`⚠️ Failed to create sport: ${sport.name} - ${response.status}`);
        }
      } catch (error) {
        console.log(`❌ Error creating sport ${sport.name}:`, error.message);
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
          const response = await fetch(`${baseUrl}/api/batches`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Cookie': 'connect.sid=s%3AyourSessionId'
            },
            body: JSON.stringify(batch)
          });
          
          if (response.ok) {
            const createdBatch = await response.json();
            createdBatches.push(createdBatch);
            console.log(`✅ Created batch: ${batch.name}`);
          } else {
            console.log(`⚠️ Failed to create batch: ${batch.name} - ${response.status}`);
          }
        } catch (error) {
          console.log(`❌ Error creating batch ${batch.name}:`, error.message);
        }
      }
    }
    
    // Create students
    console.log('👥 Creating students...');
    const studentsData = [
      { name: 'Rahul Sharma', phone: '9876543210', email: 'rahul.sharma@email.com', skillLevel: 'beginner', sportId: createdSports[0]?.id, batchId: createdBatches[0]?.id },
      { name: 'Priya Patel', phone: '9876543211', email: 'priya.patel@email.com', skillLevel: 'beginner', sportId: createdSports[1]?.id, batchId: createdBatches[1]?.id },
      { name: 'Amit Kumar', phone: '9876543212', email: 'amit.kumar@email.com', skillLevel: 'intermediate', sportId: createdSports[2]?.id, batchId: createdBatches[2]?.id },
      { name: 'Test Student', phone: '9999999999', email: 'test@email.com', skillLevel: 'beginner', sportId: createdSports[0]?.id, batchId: createdBatches[0]?.id },
      { name: 'Test Student 2', phone: '9999999998', email: 'test2@email.com', skillLevel: 'intermediate', sportId: createdSports[1]?.id, batchId: createdBatches[1]?.id }
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
          
          const response = await fetch(`${baseUrl}/api/students`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Cookie': 'connect.sid=s%3AyourSessionId'
            },
            body: JSON.stringify(studentData)
          });
          
          if (response.ok) {
            const createdStudent = await response.json();
            console.log(`✅ Created student: ${student.name} (STU${String(studentCounter).padStart(3, '0')})`);
            studentCounter++;
          } else {
            const error = await response.text();
            console.log(`⚠️ Failed to create student: ${student.name} - ${response.status} - ${error}`);
          }
        } catch (error) {
          console.log(`❌ Error creating student ${student.name}:`, error.message);
        }
      }
    }
    
    console.log('🎉 Database seeding completed!');
    
    // Test search
    console.log('🔍 Testing search functionality...');
    const searchResponse = await fetch(`${baseUrl}/api/students?search=test&limit=10`, {
      headers: {
        'Cookie': 'connect.sid=s%3AyourSessionId'
      }
    });
    
    if (searchResponse.ok) {
      const searchResult = await searchResponse.json();
      console.log(`✅ Search test: Found ${searchResult.total || searchResult.students?.length || 0} students`);
      console.log('Students:', searchResult.students?.map(s => s.name) || []);
    } else {
      console.log(`⚠️ Search test failed: ${searchResponse.status}`);
    }
    
  } catch (error) {
    console.error('❌ Error during seeding:', error);
  }
}

// Instructions
console.log(`
🌱 Quick Database Seeding Script for PSA Nashik
===============================================

This script will seed the production database with sample data.
You need to:
1. Get your session cookie from the browser (F12 > Application > Cookies)
2. Replace 'yourSessionId' with your actual session ID
3. Run: node quick-seed.js

The script will create:
- 3 sports (Cricket, Football, Basketball)
- 3 batches (one for each sport)
- 5 students (including 2 test students)
`);

if (require.main === module) {
  seedDatabase();
}

module.exports = { seedDatabase };