// Production database seeding script
// This script should be run on the production server

const { neon } = require('@neondatabase/serverless');

// Get database URL from environment or use a default
const DATABASE_URL = process.env.DATABASE_URL || 'postgresql://root:password@localhost:5432/psa_nashik';

console.log('🌱 Production Database Seeding Script');
console.log('📊 Connecting to database...');

const sql = neon(DATABASE_URL);

async function seedProductionDatabase() {
  try {
    // Check current state
    console.log('🔍 Checking current database state...');
    
    const studentsCount = await sql`SELECT COUNT(*) as count FROM students`;
    console.log(`👥 Current students: ${studentsCount[0].count}`);
    
    if (studentsCount[0].count > 0) {
      console.log('✅ Database already has students. Skipping seeding.');
      return;
    }
    
    console.log('🌱 Database is empty. Starting seeding process...');
    
    // Insert sports
    const sportsData = [
      { name: 'Cricket', description: 'Cricket training and coaching', feeStructure: { baseAmount: 1000, skillLevels: { beginner: 1000, intermediate: 1500, advanced: 2000 } } },
      { name: 'Football', description: 'Football training and coaching', feeStructure: { baseAmount: 800, skillLevels: { beginner: 800, intermediate: 1200, advanced: 1800 } } },
      { name: 'Basketball', description: 'Basketball training and coaching', feeStructure: { baseAmount: 900, skillLevels: { beginner: 900, intermediate: 1300, advanced: 1900 } } }
    ];
    
    console.log('🏃 Adding sports...');
    for (const sport of sportsData) {
      await sql`
        INSERT INTO sports (name, description, fee_structure, is_active)
        VALUES (${sport.name}, ${sport.description}, ${JSON.stringify(sport.feeStructure)}, true)
        ON CONFLICT (name) DO NOTHING
      `;
      console.log(`✅ Sport: ${sport.name}`);
    }
    
    // Get sports
    const sports = await sql`SELECT id, name FROM sports ORDER BY id`;
    
    // Insert batches
    console.log('📚 Adding batches...');
    const batchesData = [
      { sportName: 'Cricket', name: 'Morning Cricket Batch', skillLevel: 'beginner', schedule: { days: ['monday', 'wednesday', 'friday'], time: '6:00 AM - 7:30 AM' }, maxCapacity: 20 },
      { sportName: 'Football', name: 'Morning Football Batch', skillLevel: 'beginner', schedule: { days: ['monday', 'wednesday', 'friday'], time: '7:00 AM - 8:30 AM' }, maxCapacity: 18 },
      { sportName: 'Basketball', name: 'Morning Basketball Batch', skillLevel: 'intermediate', schedule: { days: ['monday', 'wednesday', 'friday'], time: '8:00 AM - 9:30 AM' }, maxCapacity: 16 }
    ];
    
    for (const batch of batchesData) {
      const sport = sports.find(s => s.name === batch.sportName);
      if (sport) {
        await sql`
          INSERT INTO batches (name, sport_id, schedule, max_capacity, skill_level, is_active)
          VALUES (${batch.name}, ${sport.id}, ${JSON.stringify(batch.schedule)}, ${batch.maxCapacity}, ${batch.skillLevel}, true)
        `;
        console.log(`✅ Batch: ${batch.name}`);
      }
    }
    
    // Get batches
    const batches = await sql`
      SELECT b.id, b.name, b.skill_level, s.name as sport_name 
      FROM batches b 
      JOIN sports s ON b.sport_id = s.id 
      ORDER BY b.id
    `;
    
    // Insert students
    console.log('👥 Adding students...');
    const studentsData = [
      { name: 'Rahul Sharma', phone: '9876543210', email: 'rahul.sharma@email.com', skillLevel: 'beginner', batchType: 'Cricket' },
      { name: 'Priya Patel', phone: '9876543211', email: 'priya.patel@email.com', skillLevel: 'beginner', batchType: 'Football' },
      { name: 'Amit Kumar', phone: '9876543212', email: 'amit.kumar@email.com', skillLevel: 'intermediate', batchType: 'Basketball' },
      { name: 'Sneha Gupta', phone: '9876543213', email: 'sneha.gupta@email.com', skillLevel: 'beginner', batchType: 'Cricket' },
      { name: 'Vikram Singh', phone: '9876543214', email: 'vikram.singh@email.com', skillLevel: 'beginner', batchType: 'Football' },
      { name: 'Test Student', phone: '9999999999', email: 'test@email.com', skillLevel: 'beginner', batchType: 'Cricket' }
    ];
    
    let studentCounter = 1;
    for (const student of studentsData) {
      const studentId = `STU${String(studentCounter).padStart(3, '0')}`;
      
      const batch = batches.find(b => 
        b.sport_name === student.batchType && 
        b.skill_level === student.skillLevel
      );
      
      if (batch) {
        const sport = sports.find(s => s.name === student.batchType);
        
        await sql`
          INSERT INTO students (student_id, name, phone, email, sport_id, batch_id, skill_level, is_active, joining_date)
          VALUES (${studentId}, ${student.name}, ${student.phone}, ${student.email}, ${sport.id}, ${batch.id}, ${student.skillLevel}, true, NOW())
        `;
        console.log(`✅ Student: ${student.name} (${studentId})`);
        studentCounter++;
      }
    }
    
    // Final verification
    const finalCount = await sql`SELECT COUNT(*) as count FROM students`;
    console.log(`🎉 Seeding completed! Total students: ${finalCount[0].count}`);
    
  } catch (error) {
    console.error('❌ Error:', error);
    throw error;
  }
}

// Export for use as module or run directly
if (require.main === module) {
  seedProductionDatabase()
    .then(() => {
      console.log('✅ Production seeding completed');
      process.exit(0);
    })
    .catch(error => {
      console.error('❌ Production seeding failed:', error);
      process.exit(1);
    });
}

module.exports = { seedProductionDatabase };