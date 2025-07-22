import { Pool } from 'pg';
import { drizzle } from 'drizzle-orm/node-postgres';
import { students, batches } from "./shared/schema";
import { eq } from "drizzle-orm";

const connectionString = process.env.DATABASE_URL || "postgresql://psa_user:secure_password_change_me@localhost:5432/psa_nashik";
const pool = new Pool({ connectionString });
const db = drizzle(pool);

async function updateStudentBatches() {
  try {
    console.log("Updating student batch assignments...");

    // Get all students
    const allStudents = await db.select().from(students);
    console.log("Found students:", allStudents.length);

    // Get all batches
    const allBatches = await db.select().from(batches);
    console.log("Found batches:", allBatches.length);

    // Update each student with an appropriate batch
    for (const student of allStudents) {
      // Find a batch that matches the student's sport and skill level
      let appropriateBatch = allBatches.find(batch => 
        batch.sportId === student.sportId && 
        batch.skillLevel === student.skillLevel
      );

      // If no exact match, find any batch for the same sport
      if (!appropriateBatch) {
        appropriateBatch = allBatches.find(batch => batch.sportId === student.sportId);
      }

      if (appropriateBatch) {
        await db.update(students)
          .set({ batchId: appropriateBatch.id })
          .where(eq(students.id, student.id));
        
        console.log(`Updated student ${student.name} (${student.studentId}) with batch: ${appropriateBatch.name}`);
      } else {
        console.log(`No appropriate batch found for student ${student.name}`);
      }
    }

    console.log("Student batch assignments updated successfully!");
    
  } catch (error) {
    console.error("Error updating student batches:", error);
  } finally {
    await pool.end();
  }
}

updateStudentBatches();