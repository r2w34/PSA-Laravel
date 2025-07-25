#!/usr/bin/env node

// Simple database seeding script
import { neon } from '@neondatabase/serverless';
import dotenv from 'dotenv';

// Load environment variables
dotenv.config();

const DATABASE_URL = process.env.DATABASE_URL;

if (!DATABASE_URL) {
  console.error('❌ DATABASE_URL not found in environment variables');
  process.exit(1);
}

console.log('🌱 Starting database seeding...');
console.log('📊 Database URL:', DATABASE_URL.replace(/:[^:]*@/, ':****@'));

const sql = neon(DATABASE_URL);

async function seedDatabase() {
  try {
    console.log('🔍 Checking current database state...');
    
    // Check current counts
    const sportsCount = await sql`SELECT COUNT(*) as count FROM sports`;
    const batchesCount = await sql`SELECT COUNT(*) as count FROM batches`;
    const studentsCount = await sql`SELECT COUNT(*) as count FROM students`;
    
    console.log(`📈 Current state: ${sportsCount[0].count} sports, ${batchesCount[0].count} batches, ${studentsCount[0].count} students`);
    
    // Insert sports if they don't exist
    console.log('🏃 Seeding sports...');
    const sportsData = [
      {
        name: 'Cricket',
        description: 'Learn cricket fundamentals and advanced techniques',
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
        description: 'Football training for all skill levels',
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
        description: 'Basketball fundamentals and team play',
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
    
    for (const sport of sportsData) {
      const existing = await sql`SELECT id FROM sports WHERE name = ${sport.name}`;
      if (existing.length === 0) {
        await sql`
          INSERT INTO sports (name, description, fee_structure, is_active)
          VALUES (${sport.name}, ${sport.description}, ${JSON.stringify(sport.feeStructure)}, true)
        `;
        console.log(`✅ Added sport: ${sport.name}`);
      } else {
        console.log(`⏭️  Sport already exists: ${sport.name}`);
      }
    }
    
    // Get sports for batch creation
    const sports = await sql`SELECT id, name FROM sports ORDER BY id`;
    console.log(`🏃 Found ${sports.length} sports for batch creation`);
    
    // Insert batches
    console.log('📚 Seeding batches...');
    const batchesData = [
      { sportName: 'Cricket', name: 'Morning Cricket Batch', skillLevel: 'beginner', schedule: { days: ['monday', 'wednesday', 'friday'], time: '6:00 AM - 7:30 AM' }, maxCapacity: 20 },
      { sportName: 'Cricket', name: 'Evening Cricket Batch', skillLevel: 'intermediate', schedule: { days: ['tuesday', 'thursday', 'saturday'], time: '5:00 PM - 6:30 PM' }, maxCapacity: 15 },
      { sportName: 'Football', name: 'Morning Football Batch', skillLevel: 'beginner', schedule: { days: ['monday', 'wednesday', 'friday'], time: '7:00 AM - 8:30 AM' }, maxCapacity: 18 },
      { sportName: 'Football', name: 'Evening Football Batch', skillLevel: 'advanced', schedule: { days: ['tuesday', 'thursday', 'saturday'], time: '6:00 PM - 7:30 PM' }, maxCapacity: 12 },
      { sportName: 'Basketball', name: 'Morning Basketball Batch', skillLevel: 'intermediate', schedule: { days: ['monday', 'wednesday', 'friday'], time: '8:00 AM - 9:30 AM' }, maxCapacity: 16 },
      { sportName: 'Basketball', name: 'Evening Basketball Batch', skillLevel: 'beginner', schedule: { days: ['tuesday', 'thursday', 'saturday'], time: '4:00 PM - 5:30 PM' }, maxCapacity: 20 }
    ];
    
    for (const batch of batchesData) {
      const sport = sports.find(s => s.name === batch.sportName);
      if (sport) {
        const existing = await sql`SELECT id FROM batches WHERE name = ${batch.name}`;
        if (existing.length === 0) {
          await sql`
            INSERT INTO batches (name, sport_id, schedule, max_capacity, skill_level, is_active)
            VALUES (${batch.name}, ${sport.id}, ${JSON.stringify(batch.schedule)}, ${batch.maxCapacity}, ${batch.skillLevel}, true)
          `;
          console.log(`✅ Added batch: ${batch.name}`);
        } else {
          console.log(`⏭️  Batch already exists: ${batch.name}`);
        }
      }
    }
    
    // Get batches for student creation
    const batches = await sql`
      SELECT b.id, b.name, b.skill_level, s.name as sport_name 
      FROM batches b 
      JOIN sports s ON b.sport_id = s.id 
      ORDER BY b.id
    `;
    console.log(`📚 Found ${batches.length} batches for student creation`);
    
    // Insert students
    console.log('👥 Seeding students...');
    const studentsData = [
      { name: 'Rahul Sharma', phone: '9876543210', email: 'rahul.sharma@email.com', skillLevel: 'beginner', batchType: 'Cricket' },
      { name: 'Priya Patel', phone: '9876543211', email: 'priya.patel@email.com', skillLevel: 'intermediate', batchType: 'Football' },
      { name: 'Amit Kumar', phone: '9876543212', email: 'amit.kumar@email.com', skillLevel: 'beginner', batchType: 'Basketball' },
      { name: 'Sneha Gupta', phone: '9876543213', email: 'sneha.gupta@email.com', skillLevel: 'advanced', batchType: 'Football' },
      { name: 'Vikram Singh', phone: '9876543214', email: 'vikram.singh@email.com', skillLevel: 'intermediate', batchType: 'Cricket' },
      { name: 'Anita Desai', phone: '9876543215', email: 'anita.desai@email.com', skillLevel: 'beginner', batchType: 'Basketball' },
      { name: 'Rohit Verma', phone: '9876543216', email: 'rohit.verma@email.com', skillLevel: 'intermediate', batchType: 'Basketball' },
      { name: 'Kavya Nair', phone: '9876543217', email: 'kavya.nair@email.com', skillLevel: 'beginner', batchType: 'Cricket' }
    ];
    
    let studentCounter = 1;
    for (const student of studentsData) {
      const studentId = `STU${String(studentCounter).padStart(3, '0')}`;
      
      // Find appropriate batch
      const batch = batches.find(b => 
        b.sport_name === student.batchType && 
        b.skill_level === student.skillLevel
      );
      
      if (batch) {
        const existing = await sql`SELECT id FROM students WHERE phone = ${student.phone}`;
        if (existing.length === 0) {
          // Get sport ID
          const sport = sports.find(s => s.name === student.batchType);
          
          await sql`
            INSERT INTO students (student_id, name, phone, email, sport_id, batch_id, skill_level, is_active, joining_date)
            VALUES (${studentId}, ${student.name}, ${student.phone}, ${student.email}, ${sport.id}, ${batch.id}, ${student.skillLevel}, true, NOW())
          `;
          console.log(`✅ Added student: ${student.name} (${studentId}) - ${student.batchType} ${student.skillLevel}`);
          studentCounter++;
        } else {
          console.log(`⏭️  Student already exists: ${student.name}`);
        }
      } else {
        console.log(`⚠️  No suitable batch found for ${student.name} (${student.batchType} ${student.skillLevel})`);
      }
    }
    
    // Final count
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
    
    const allStudents = await sql`
      SELECT s.*, sp.name as sport_name, b.name as batch_name
      FROM students s
      LEFT JOIN sports sp ON s.sport_id = sp.id
      LEFT JOIN batches b ON s.batch_id = b.id
      LIMIT 5
    `;
    console.log(`👥 Sample students: ${allStudents.length} found`);
    allStudents.forEach(student => {
      console.log(`   - ${student.name} (${student.student_id}) - ${student.sport_name}`);
    });
    
  } catch (error) {
    console.error('❌ Error seeding database:', error);
    process.exit(1);
  }
}

// Run the seeding
seedDatabase().then(() => {
  console.log('✅ Seeding script completed successfully');
  process.exit(0);
}).catch(error => {
  console.error('❌ Seeding script failed:', error);
  process.exit(1);
});