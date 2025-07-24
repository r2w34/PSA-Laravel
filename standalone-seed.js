// Standalone database seeding script for production
// This can be run directly on the production server

console.log('🌱 PSA Nashik Database Seeding Script');
console.log('=====================================');

// Check if we're in a Node.js environment
if (typeof require === 'undefined') {
  console.error('❌ This script must be run in Node.js environment');
  process.exit(1);
}

// Try to load the neon client
let sql;
try {
  const { neon } = require('@neondatabase/serverless');
  
  // Get database URL from environment or use default
  const DATABASE_URL = process.env.DATABASE_URL || 'postgresql://root:password@localhost:5432/psa_nashik';
  
  console.log('📊 Database URL:', DATABASE_URL.replace(/:[^:]*@/, ':****@'));
  sql = neon(DATABASE_URL);
} catch (error) {
  console.error('❌ Failed to load database client:', error.message);
  console.log('💡 Make sure @neondatabase/serverless is installed:');
  console.log('   npm install @neondatabase/serverless');
  process.exit(1);
}

async function seedDatabase() {
  try {
    console.log('🔍 Checking current database state...');
    
    // Check if tables exist
    const tablesResult = await sql`
      SELECT table_name 
      FROM information_schema.tables 
      WHERE table_schema = 'public' 
      AND table_name IN ('sports', 'batches', 'students')
    `;
    
    console.log(`📋 Found ${tablesResult.length} tables: ${tablesResult.map(t => t.table_name).join(', ')}`);
    
    if (tablesResult.length === 0) {
      console.error('❌ Database tables not found. Make sure the database schema is created.');
      return;
    }
    
    // Check current counts
    const studentsCount = await sql`SELECT COUNT(*) as count FROM students`;
    const sportsCount = await sql`SELECT COUNT(*) as count FROM sports`;
    const batchesCount = await sql`SELECT COUNT(*) as count FROM batches`;
    
    console.log(`📊 Current state: ${sportsCount[0].count} sports, ${batchesCount[0].count} batches, ${studentsCount[0].count} students`);
    
    if (studentsCount[0].count > 0) {
      console.log('✅ Database already has students. Skipping seeding to avoid duplicates.');
      console.log('💡 If you want to re-seed, please clear the database first.');
      return;
    }
    
    console.log('🌱 Starting database seeding...');
    
    // 1. Seed Sports
    console.log('🏃 Adding sports...');
    const sportsData = [
      {
        name: 'Cricket',
        description: 'Cricket training and coaching for all skill levels',
        feeStructure: {
          baseAmount: 1000,
          skillLevels: {
            beginner: 1000,
            intermediate: 1500,
            advanced: 2000
          }
        }
      },
      {
        name: 'Football',
        description: 'Football training and team building',
        feeStructure: {
          baseAmount: 800,
          skillLevels: {
            beginner: 800,
            intermediate: 1200,
            advanced: 1800
          }
        }
      },
      {
        name: 'Basketball',
        description: 'Basketball fundamentals and advanced techniques',
        feeStructure: {
          baseAmount: 900,
          skillLevels: {
            beginner: 900,
            intermediate: 1300,
            advanced: 1900
          }
        }
      }
    ];
    
    const insertedSports = [];
    for (const sport of sportsData) {
      try {
        const result = await sql`
          INSERT INTO sports (name, description, fee_structure, is_active, created_at, updated_at)
          VALUES (${sport.name}, ${sport.description}, ${JSON.stringify(sport.feeStructure)}, true, NOW(), NOW())
          RETURNING id, name
        `;
        insertedSports.push(result[0]);
        console.log(`✅ Added sport: ${sport.name} (ID: ${result[0].id})`);
      } catch (error) {
        console.log(`⚠️  Sport ${sport.name} might already exist:`, error.message);
        // Try to get existing sport
        const existing = await sql`SELECT id, name FROM sports WHERE name = ${sport.name}`;
        if (existing.length > 0) {
          insertedSports.push(existing[0]);
          console.log(`📋 Using existing sport: ${sport.name} (ID: ${existing[0].id})`);
        }
      }
    }
    
    // 2. Seed Batches
    console.log('📚 Adding batches...');
    const batchesData = [
      { sportName: 'Cricket', name: 'Morning Cricket Batch', skillLevel: 'beginner', schedule: { days: ['monday', 'wednesday', 'friday'], time: '6:00 AM - 7:30 AM' }, maxCapacity: 20 },
      { sportName: 'Cricket', name: 'Evening Cricket Batch', skillLevel: 'intermediate', schedule: { days: ['tuesday', 'thursday', 'saturday'], time: '5:00 PM - 6:30 PM' }, maxCapacity: 15 },
      { sportName: 'Football', name: 'Morning Football Batch', skillLevel: 'beginner', schedule: { days: ['monday', 'wednesday', 'friday'], time: '7:00 AM - 8:30 AM' }, maxCapacity: 18 },
      { sportName: 'Football', name: 'Evening Football Batch', skillLevel: 'advanced', schedule: { days: ['tuesday', 'thursday', 'saturday'], time: '6:00 PM - 7:30 PM' }, maxCapacity: 12 },
      { sportName: 'Basketball', name: 'Morning Basketball Batch', skillLevel: 'intermediate', schedule: { days: ['monday', 'wednesday', 'friday'], time: '8:00 AM - 9:30 AM' }, maxCapacity: 16 },
      { sportName: 'Basketball', name: 'Evening Basketball Batch', skillLevel: 'beginner', schedule: { days: ['tuesday', 'thursday', 'saturday'], time: '4:00 PM - 5:30 PM' }, maxCapacity: 20 }
    ];
    
    const insertedBatches = [];
    for (const batch of batchesData) {
      const sport = insertedSports.find(s => s.name === batch.sportName);
      if (sport) {
        try {
          const result = await sql`
            INSERT INTO batches (name, sport_id, schedule, max_capacity, current_capacity, skill_level, is_active, created_at)
            VALUES (${batch.name}, ${sport.id}, ${JSON.stringify(batch.schedule)}, ${batch.maxCapacity}, 0, ${batch.skillLevel}, true, NOW())
            RETURNING id, name, skill_level
          `;
          insertedBatches.push({ ...result[0], sport_name: batch.sportName });
          console.log(`✅ Added batch: ${batch.name} (ID: ${result[0].id})`);
        } catch (error) {
          console.log(`⚠️  Batch ${batch.name} might already exist:`, error.message);
        }
      } else {
        console.log(`❌ Sport not found for batch: ${batch.name}`);
      }
    }
    
    // 3. Seed Students
    console.log('👥 Adding students...');
    const studentsData = [
      { name: 'Rahul Sharma', phone: '9876543210', email: 'rahul.sharma@email.com', skillLevel: 'beginner', sportName: 'Cricket' },
      { name: 'Priya Patel', phone: '9876543211', email: 'priya.patel@email.com', skillLevel: 'beginner', sportName: 'Football' },
      { name: 'Amit Kumar', phone: '9876543212', email: 'amit.kumar@email.com', skillLevel: 'intermediate', sportName: 'Basketball' },
      { name: 'Sneha Gupta', phone: '9876543213', email: 'sneha.gupta@email.com', skillLevel: 'advanced', sportName: 'Football' },
      { name: 'Vikram Singh', phone: '9876543214', email: 'vikram.singh@email.com', skillLevel: 'intermediate', sportName: 'Cricket' },
      { name: 'Anita Desai', phone: '9876543215', email: 'anita.desai@email.com', skillLevel: 'beginner', sportName: 'Basketball' },
      { name: 'Rohit Verma', phone: '9876543216', email: 'rohit.verma@email.com', skillLevel: 'intermediate', sportName: 'Basketball' },
      { name: 'Test Student', phone: '9999999999', email: 'test@email.com', skillLevel: 'beginner', sportName: 'Cricket' }
    ];
    
    let studentCounter = 1;
    for (const student of studentsData) {
      const studentId = `STU${String(studentCounter).padStart(3, '0')}`;
      
      // Find appropriate sport and batch
      const sport = insertedSports.find(s => s.name === student.sportName);
      const batch = insertedBatches.find(b => 
        b.sport_name === student.sportName && 
        b.skill_level === student.skillLevel
      );
      
      if (sport && batch) {
        try {
          const result = await sql`
            INSERT INTO students (student_id, name, phone, email, sport_id, batch_id, skill_level, is_active, joining_date, created_at)
            VALUES (${studentId}, ${student.name}, ${student.phone}, ${student.email}, ${sport.id}, ${batch.id}, ${student.skillLevel}, true, NOW(), NOW())
            RETURNING id, name, student_id
          `;
          console.log(`✅ Added student: ${student.name} (${studentId}) - ${student.sportName} ${student.skillLevel}`);
          studentCounter++;
        } catch (error) {
          console.log(`⚠️  Student ${student.name} might already exist:`, error.message);
        }
      } else {
        console.log(`❌ No suitable sport/batch found for ${student.name} (${student.sportName} ${student.skillLevel})`);
      }
    }
    
    // Final verification
    const finalSportsCount = await sql`SELECT COUNT(*) as count FROM sports`;
    const finalBatchesCount = await sql`SELECT COUNT(*) as count FROM batches`;
    const finalStudentsCount = await sql`SELECT COUNT(*) as count FROM students`;
    
    console.log('🎉 Database seeding completed!');
    console.log(`📊 Final state: ${finalSportsCount[0].count} sports, ${finalBatchesCount[0].count} batches, ${finalStudentsCount[0].count} students`);
    
    // Test search functionality
    console.log('🔍 Testing search functionality...');
    const searchResults = await sql`
      SELECT s.*, sp.name as sport_name, b.name as batch_name
      FROM students s
      LEFT JOIN sports sp ON s.sport_id = sp.id
      LEFT JOIN batches b ON s.batch_id = b.id
      WHERE s.name ILIKE '%test%' OR s.phone ILIKE '%test%' OR s.student_id ILIKE '%test%'
      LIMIT 5
    `;
    console.log(`🔍 Search for 'test': ${searchResults.length} results`);
    
    if (searchResults.length > 0) {
      console.log('✅ Search functionality working correctly!');
      searchResults.forEach(student => {
        console.log(`   - ${student.name} (${student.student_id}) - ${student.sport_name}`);
      });
    }
    
  } catch (error) {
    console.error('❌ Error during seeding:', error);
    throw error;
  }
}

// Run the seeding
if (require.main === module) {
  seedDatabase()
    .then(() => {
      console.log('✅ Seeding completed successfully!');
      console.log('🎯 You can now test the search functionality in the application.');
      process.exit(0);
    })
    .catch(error => {
      console.error('❌ Seeding failed:', error);
      process.exit(1);
    });
}

module.exports = { seedDatabase };