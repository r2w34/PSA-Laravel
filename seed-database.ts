import { Pool } from 'pg';
import { drizzle } from 'drizzle-orm/node-postgres';
import { sports, batches, students, users } from "./shared/schema";
import bcrypt from 'bcrypt';

const connectionString = process.env.DATABASE_URL || "postgresql://psa_user:psa_password@localhost:5432/psa_nashik";
const pool = new Pool({ connectionString });
const db = drizzle(pool);

async function seedDatabase() {
  try {
    console.log("🌱 Starting database seeding...");

    // 1. Add sample sports
    console.log("📊 Adding sample sports...");
    const sampleSports = [
      { name: "Cricket", description: "Traditional cricket training", isActive: true },
      { name: "Football", description: "Football skills development", isActive: true },
      { name: "Basketball", description: "Basketball fundamentals", isActive: true },
      { name: "Tennis", description: "Tennis coaching", isActive: true },
      { name: "Badminton", description: "Badminton training", isActive: true }
    ];

    const insertedSports = [];
    for (const sport of sampleSports) {
      try {
        const [insertedSport] = await db.insert(sports).values(sport).returning();
        insertedSports.push(insertedSport);
        console.log(`✅ Added sport: ${sport.name}`);
      } catch (error) {
        console.log(`⚠️  Sport ${sport.name} might already exist, skipping...`);
      }
    }

    // Get all sports (existing + newly inserted)
    const allSports = await db.select().from(sports);
    console.log(`📊 Total sports in database: ${allSports.length}`);

    // 2. Add sample batches
    console.log("🏃 Adding sample batches...");
    const sampleBatches = [
      // Cricket batches
      {
        name: "Morning Cricket Beginners",
        sportId: allSports.find(s => s.name === "Cricket")?.id || 1,
        coachId: null,
        schedule: { days: ["monday", "wednesday", "friday"], time: "6:00 AM - 8:00 AM" },
        maxCapacity: 20,
        currentCapacity: 0,
        skillLevel: "beginner",
        isActive: true
      },
      {
        name: "Evening Cricket Advanced",
        sportId: allSports.find(s => s.name === "Cricket")?.id || 1,
        coachId: null,
        schedule: { days: ["tuesday", "thursday", "saturday"], time: "5:00 PM - 7:00 PM" },
        maxCapacity: 20,
        currentCapacity: 0,
        skillLevel: "advanced",
        isActive: true
      },
      // Football batches
      {
        name: "Morning Football Training",
        sportId: allSports.find(s => s.name === "Football")?.id || 2,
        coachId: null,
        schedule: { days: ["monday", "wednesday", "friday"], time: "7:00 AM - 9:00 AM" },
        maxCapacity: 25,
        currentCapacity: 0,
        skillLevel: "intermediate",
        isActive: true
      },
      {
        name: "Weekend Football Camp",
        sportId: allSports.find(s => s.name === "Football")?.id || 2,
        coachId: null,
        schedule: { days: ["saturday", "sunday"], time: "4:00 PM - 6:00 PM" },
        maxCapacity: 30,
        currentCapacity: 0,
        skillLevel: "beginner",
        isActive: true
      },
      // Basketball batches
      {
        name: "Basketball Fundamentals",
        sportId: allSports.find(s => s.name === "Basketball")?.id || 3,
        coachId: null,
        schedule: { days: ["tuesday", "thursday"], time: "8:00 AM - 10:00 AM" },
        maxCapacity: 15,
        currentCapacity: 0,
        skillLevel: "beginner",
        isActive: true
      }
    ];

    const insertedBatches = [];
    for (const batch of sampleBatches) {
      try {
        const [insertedBatch] = await db.insert(batches).values(batch).returning();
        insertedBatches.push(insertedBatch);
        console.log(`✅ Added batch: ${batch.name}`);
      } catch (error) {
        console.log(`⚠️  Batch ${batch.name} might already exist, skipping...`);
      }
    }

    // Get all batches
    const allBatches = await db.select().from(batches);
    console.log(`🏃 Total batches in database: ${allBatches.length}`);

    // 3. Add sample admin user
    console.log("👤 Adding sample admin user...");
    const hashedPassword = await bcrypt.hash('admin123', 10);
    try {
      const [adminUser] = await db.insert(users).values({
        username: 'admin',
        email: 'admin@psanashik.com',
        password: hashedPassword,
        role: 'admin',
        isActive: true
      }).returning();
      console.log(`✅ Added admin user: ${adminUser.username}`);
    } catch (error) {
      console.log(`⚠️  Admin user might already exist, skipping...`);
    }

    // 4. Add sample students
    console.log("🎓 Adding sample students...");
    const sampleStudents = [
      {
        studentId: "PSA001",
        name: "Arjun Sharma",
        phone: "9876543210",
        email: "arjun.sharma@email.com",
        dateOfBirth: new Date("2008-05-15"),
        address: "123 MG Road, Nashik",
        emergencyContact: "9876543211",
        sportId: allSports.find(s => s.name === "Cricket")?.id || 1,
        batchId: allBatches.find(b => b.name.includes("Cricket"))?.id || 1,
        joiningDate: new Date("2024-01-15"),
        isActive: true,
        skillLevel: "beginner"
      },
      {
        studentId: "PSA002",
        name: "Priya Patel",
        phone: "9876543212",
        email: "priya.patel@email.com",
        dateOfBirth: new Date("2009-08-22"),
        address: "456 College Road, Nashik",
        emergencyContact: "9876543213",
        sportId: allSports.find(s => s.name === "Football")?.id || 2,
        batchId: allBatches.find(b => b.name.includes("Football"))?.id || 2,
        joiningDate: new Date("2024-02-01"),
        isActive: true,
        skillLevel: "intermediate"
      },
      {
        studentId: "PSA003",
        name: "Rahul Desai",
        phone: "9876543214",
        email: "rahul.desai@email.com",
        dateOfBirth: new Date("2007-12-10"),
        address: "789 Gangapur Road, Nashik",
        emergencyContact: "9876543215",
        sportId: allSports.find(s => s.name === "Basketball")?.id || 3,
        batchId: allBatches.find(b => b.name.includes("Basketball"))?.id || 3,
        joiningDate: new Date("2024-01-20"),
        isActive: true,
        skillLevel: "advanced"
      },
      {
        studentId: "PSA004",
        name: "Sneha Kulkarni",
        phone: "9876543216",
        email: "sneha.kulkarni@email.com",
        dateOfBirth: new Date("2008-03-18"),
        address: "321 Panchavati, Nashik",
        emergencyContact: "9876543217",
        sportId: allSports.find(s => s.name === "Tennis")?.id || 4,
        batchId: allBatches[0]?.id || 1, // Fallback to first batch
        joiningDate: new Date("2024-02-15"),
        isActive: true,
        skillLevel: "beginner"
      },
      {
        studentId: "PSA005",
        name: "Vikram Singh",
        phone: "9876543218",
        email: "vikram.singh@email.com",
        dateOfBirth: new Date("2009-06-25"),
        address: "654 Satpur, Nashik",
        emergencyContact: "9876543219",
        sportId: allSports.find(s => s.name === "Cricket")?.id || 1,
        batchId: allBatches.find(b => b.name.includes("Cricket") && b.skillLevel === "advanced")?.id || 1,
        joiningDate: new Date("2024-01-10"),
        isActive: true,
        skillLevel: "advanced"
      },
      {
        studentId: "PSA006",
        name: "Anita Joshi",
        phone: "9876543220",
        email: "anita.joshi@email.com",
        dateOfBirth: new Date("2008-11-30"),
        address: "987 Cidco, Nashik",
        emergencyContact: "9876543221",
        sportId: allSports.find(s => s.name === "Badminton")?.id || 5,
        batchId: allBatches[0]?.id || 1, // Fallback to first batch
        joiningDate: new Date("2024-03-01"),
        isActive: true,
        skillLevel: "intermediate"
      },
      {
        studentId: "PSA007",
        name: "Karan Mehta",
        phone: "9876543222",
        email: "karan.mehta@email.com",
        dateOfBirth: new Date("2007-09-14"),
        address: "147 Deolali, Nashik",
        emergencyContact: "9876543223",
        sportId: allSports.find(s => s.name === "Football")?.id || 2,
        batchId: allBatches.find(b => b.name.includes("Weekend Football"))?.id || 2,
        joiningDate: new Date("2024-01-25"),
        isActive: true,
        skillLevel: "beginner"
      },
      {
        studentId: "PSA008",
        name: "Pooja Agarwal",
        phone: "9876543224",
        email: "pooja.agarwal@email.com",
        dateOfBirth: new Date("2008-07-08"),
        address: "258 Ashok Stambh, Nashik",
        emergencyContact: "9876543225",
        sportId: allSports.find(s => s.name === "Basketball")?.id || 3,
        batchId: allBatches.find(b => b.name.includes("Basketball"))?.id || 3,
        joiningDate: new Date("2024-02-10"),
        isActive: true,
        skillLevel: "intermediate"
      }
    ];

    for (const student of sampleStudents) {
      try {
        const [insertedStudent] = await db.insert(students).values(student).returning();
        console.log(`✅ Added student: ${student.name} (${student.studentId})`);
      } catch (error) {
        console.log(`⚠️  Student ${student.name} might already exist, skipping...`);
      }
    }

    // Final count
    const totalStudents = await db.select().from(students);
    console.log(`🎓 Total students in database: ${totalStudents.length}`);

    console.log("🎉 Database seeding completed successfully!");
    console.log("\n📋 Summary:");
    console.log(`   Sports: ${allSports.length}`);
    console.log(`   Batches: ${allBatches.length}`);
    console.log(`   Students: ${totalStudents.length}`);
    console.log("\n🔐 Admin Login:");
    console.log("   Username: admin");
    console.log("   Password: admin123");

  } catch (error) {
    console.error("❌ Error seeding database:", error);
  } finally {
    await pool.end();
  }
}

seedDatabase();