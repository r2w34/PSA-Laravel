import { Pool } from 'pg';
import { drizzle } from 'drizzle-orm/node-postgres';
import { batches, sports } from "./shared/schema";

const connectionString = process.env.DATABASE_URL || "postgresql://psa_user:psa_password@localhost:5432/psa_nashik";
const pool = new Pool({ connectionString });
const db = drizzle(pool);

async function addSampleBatches() {
  try {
    console.log("Adding sample batches...");

    // Get existing sports
    const existingSports = await db.select().from(sports);
    console.log("Existing sports:", existingSports);

    // Sample batches for each sport
    const sampleBatches = [
      // Cricket batches
      {
        name: "Morning Cricket Batch",
        sportId: existingSports.find(s => s.name === "Cricket")?.id || 1,
        coachId: null,
        schedule: {
          days: ["monday", "wednesday", "friday"],
          time: "6:00 AM - 8:00 AM"
        },
        maxCapacity: 20,
        currentCapacity: 0,
        skillLevel: "beginner",
        isActive: true
      },
      {
        name: "Evening Cricket Batch",
        sportId: existingSports.find(s => s.name === "Cricket")?.id || 1,
        coachId: null,
        schedule: {
          days: ["tuesday", "thursday", "saturday"],
          time: "5:00 PM - 7:00 PM"
        },
        maxCapacity: 20,
        currentCapacity: 0,
        skillLevel: "intermediate",
        isActive: true
      },
      // Football batches
      {
        name: "Morning Football Batch",
        sportId: existingSports.find(s => s.name === "Football")?.id || 2,
        coachId: null,
        schedule: {
          days: ["monday", "wednesday", "friday"],
          time: "7:00 AM - 9:00 AM"
        },
        maxCapacity: 25,
        currentCapacity: 0,
        skillLevel: "beginner",
        isActive: true
      },
      {
        name: "Evening Football Batch",
        sportId: existingSports.find(s => s.name === "Football")?.id || 2,
        coachId: null,
        schedule: {
          days: ["tuesday", "thursday", "saturday"],
          time: "4:00 PM - 6:00 PM"
        },
        maxCapacity: 25,
        currentCapacity: 0,
        skillLevel: "advanced",
        isActive: true
      },
      // Basketball batches
      {
        name: "Morning Basketball Batch",
        sportId: existingSports.find(s => s.name === "Basketball")?.id || 3,
        coachId: null,
        schedule: {
          days: ["monday", "wednesday", "friday"],
          time: "8:00 AM - 10:00 AM"
        },
        maxCapacity: 15,
        currentCapacity: 0,
        skillLevel: "intermediate",
        isActive: true
      },
      {
        name: "Evening Basketball Batch",
        sportId: existingSports.find(s => s.name === "Basketball")?.id || 3,
        coachId: null,
        schedule: {
          days: ["tuesday", "thursday", "saturday"],
          time: "6:00 PM - 8:00 PM"
        },
        maxCapacity: 15,
        currentCapacity: 0,
        skillLevel: "advanced",
        isActive: true
      }
    ];

    // Insert batches
    for (const batch of sampleBatches) {
      await db.insert(batches).values(batch);
      console.log(`Added batch: ${batch.name}`);
    }

    console.log("Sample batches added successfully!");
    
  } catch (error) {
    console.error("Error adding sample batches:", error);
  } finally {
    await pool.end();
  }
}

addSampleBatches();