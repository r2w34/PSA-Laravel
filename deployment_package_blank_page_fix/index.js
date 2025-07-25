var __defProp = Object.defineProperty;
var __getOwnPropNames = Object.getOwnPropertyNames;
var __esm = (fn, res) => function __init() {
  return fn && (res = (0, fn[__getOwnPropNames(fn)[0]])(fn = 0)), res;
};
var __export = (target, all) => {
  for (var name in all)
    __defProp(target, name, { get: all[name], enumerable: true });
};

// shared/schema.ts
var schema_exports = {};
__export(schema_exports, {
  achievementHistory: () => achievementHistory,
  activities: () => activities,
  activitiesRelations: () => activitiesRelations,
  attendance: () => attendance,
  attendanceRelations: () => attendanceRelations,
  badges: () => badges,
  batches: () => batches,
  batchesRelations: () => batchesRelations,
  campaignMessages: () => campaignMessages,
  campaignMessagesRelations: () => campaignMessagesRelations,
  campaigns: () => campaigns,
  campaignsRelations: () => campaignsRelations,
  coachAttendance: () => coachAttendance,
  coaches: () => coaches,
  coachesRelations: () => coachesRelations,
  communications: () => communications,
  customReports: () => customReports,
  customReportsRelations: () => customReportsRelations,
  geofences: () => geofences,
  icons: () => icons,
  insertAchievementHistorySchema: () => insertAchievementHistorySchema,
  insertActivitySchema: () => insertActivitySchema,
  insertAttendanceSchema: () => insertAttendanceSchema,
  insertBadgeSchema: () => insertBadgeSchema,
  insertBatchSchema: () => insertBatchSchema,
  insertCampaignMessageSchema: () => insertCampaignMessageSchema,
  insertCampaignSchema: () => insertCampaignSchema,
  insertCoachAttendanceSchema: () => insertCoachAttendanceSchema,
  insertCoachSchema: () => insertCoachSchema,
  insertCommunicationSchema: () => insertCommunicationSchema,
  insertCustomReportSchema: () => insertCustomReportSchema,
  insertGeofenceSchema: () => insertGeofenceSchema,
  insertIconSchema: () => insertIconSchema,
  insertLocationTrackingSchema: () => insertLocationTrackingSchema,
  insertMessageTemplateSchema: () => insertMessageTemplateSchema,
  insertPaymentGatewaySchema: () => insertPaymentGatewaySchema,
  insertPaymentSchema: () => insertPaymentSchema,
  insertPermissionSchema: () => insertPermissionSchema,
  insertReportExecutionSchema: () => insertReportExecutionSchema,
  insertSavedQuerySchema: () => insertSavedQuerySchema,
  insertSettingSchema: () => insertSettingSchema,
  insertSportSchema: () => insertSportSchema,
  insertStudentBadgeSchema: () => insertStudentBadgeSchema,
  insertStudentPointsSchema: () => insertStudentPointsSchema,
  insertStudentSchema: () => insertStudentSchema,
  insertUserRoleSchema: () => insertUserRoleSchema,
  insertUserSchema: () => insertUserSchema,
  locationTracking: () => locationTracking,
  messageTemplates: () => messageTemplates,
  paymentGateways: () => paymentGateways,
  payments: () => payments,
  paymentsRelations: () => paymentsRelations,
  permissions: () => permissions,
  reportExecutions: () => reportExecutions,
  reportExecutionsRelations: () => reportExecutionsRelations,
  savedQueries: () => savedQueries,
  savedQueriesRelations: () => savedQueriesRelations,
  selectAchievementHistorySchema: () => selectAchievementHistorySchema,
  selectActivitySchema: () => selectActivitySchema,
  selectAttendanceSchema: () => selectAttendanceSchema,
  selectBadgeSchema: () => selectBadgeSchema,
  selectBatchSchema: () => selectBatchSchema,
  selectCampaignMessageSchema: () => selectCampaignMessageSchema,
  selectCampaignSchema: () => selectCampaignSchema,
  selectCoachAttendanceSchema: () => selectCoachAttendanceSchema,
  selectCoachSchema: () => selectCoachSchema,
  selectCommunicationSchema: () => selectCommunicationSchema,
  selectCustomReportSchema: () => selectCustomReportSchema,
  selectGeofenceSchema: () => selectGeofenceSchema,
  selectIconSchema: () => selectIconSchema,
  selectLocationTrackingSchema: () => selectLocationTrackingSchema,
  selectMessageTemplateSchema: () => selectMessageTemplateSchema,
  selectPaymentGatewaySchema: () => selectPaymentGatewaySchema,
  selectPaymentSchema: () => selectPaymentSchema,
  selectPermissionSchema: () => selectPermissionSchema,
  selectReportExecutionSchema: () => selectReportExecutionSchema,
  selectSavedQuerySchema: () => selectSavedQuerySchema,
  selectSettingSchema: () => selectSettingSchema,
  selectSportSchema: () => selectSportSchema,
  selectStudentBadgeSchema: () => selectStudentBadgeSchema,
  selectStudentPointsSchema: () => selectStudentPointsSchema,
  selectStudentSchema: () => selectStudentSchema,
  selectUserRoleSchema: () => selectUserRoleSchema,
  selectUserSchema: () => selectUserSchema,
  settings: () => settings,
  sports: () => sports,
  sportsRelations: () => sportsRelations,
  studentBadges: () => studentBadges,
  studentPoints: () => studentPoints,
  students: () => students,
  studentsRelations: () => studentsRelations,
  userRoles: () => userRoles,
  users: () => users,
  usersRelations: () => usersRelations
});
import { pgTable, text, serial, integer, boolean, timestamp, decimal, jsonb, date } from "drizzle-orm/pg-core";
import { relations } from "drizzle-orm";
import { createInsertSchema, createSelectSchema } from "drizzle-zod";
var users, coaches, sports, batches, students, payments, attendance, activities, communications, settings, icons, paymentGateways, campaigns, campaignMessages, messageTemplates, customReports, reportExecutions, savedQueries, usersRelations, coachesRelations, sportsRelations, batchesRelations, studentsRelations, paymentsRelations, attendanceRelations, activitiesRelations, campaignsRelations, campaignMessagesRelations, customReportsRelations, reportExecutionsRelations, savedQueriesRelations, insertUserSchema, selectUserSchema, insertSportSchema, selectSportSchema, insertBatchSchema, selectBatchSchema, insertStudentSchema, selectStudentSchema, insertPaymentSchema, selectPaymentSchema, insertAttendanceSchema, selectAttendanceSchema, insertActivitySchema, selectActivitySchema, insertCommunicationSchema, selectCommunicationSchema, insertSettingSchema, selectSettingSchema, insertIconSchema, selectIconSchema, insertPaymentGatewaySchema, selectPaymentGatewaySchema, insertCoachSchema, selectCoachSchema, insertCampaignSchema, selectCampaignSchema, insertCampaignMessageSchema, selectCampaignMessageSchema, insertMessageTemplateSchema, selectMessageTemplateSchema, insertCustomReportSchema, selectCustomReportSchema, insertReportExecutionSchema, selectReportExecutionSchema, insertSavedQuerySchema, selectSavedQuerySchema, locationTracking, geofences, coachAttendance, userRoles, permissions, insertLocationTrackingSchema, selectLocationTrackingSchema, insertGeofenceSchema, selectGeofenceSchema, insertCoachAttendanceSchema, selectCoachAttendanceSchema, insertUserRoleSchema, selectUserRoleSchema, insertPermissionSchema, selectPermissionSchema, badges, studentBadges, studentPoints, achievementHistory, insertBadgeSchema, selectBadgeSchema, insertStudentBadgeSchema, selectStudentBadgeSchema, insertStudentPointsSchema, selectStudentPointsSchema, insertAchievementHistorySchema, selectAchievementHistorySchema;
var init_schema = __esm({
  "shared/schema.ts"() {
    "use strict";
    users = pgTable("users", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      email: text("email").unique(),
      phone: text("phone").notNull().unique(),
      password: text("password"),
      // hashed password for authentication
      role: text("role").notNull().default("student"),
      // student, coach, admin, staff, manager
      permissions: jsonb("permissions").default({}),
      isActive: boolean("is_active").default(true),
      lastLogin: timestamp("last_login"),
      profileImageUrl: text("profile_image_url"),
      createdBy: integer("created_by").references(() => users.id),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    coaches = pgTable("coaches", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      email: text("email").unique(),
      phone: text("phone").notNull(),
      specialization: text("specialization").notNull(),
      experience: integer("experience").default(0),
      qualifications: text("qualifications"),
      isActive: boolean("is_active").default(true),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    sports = pgTable("sports", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      description: text("description"),
      feeStructure: jsonb("fee_structure").notNull(),
      // { baseAmount, skillLevels: {beginner: 1000, intermediate: 1500, advanced: 2000} }
      isActive: boolean("is_active").default(true),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    batches = pgTable("batches", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      sportId: integer("sport_id").references(() => sports.id),
      coachId: integer("coach_id").references(() => coaches.id),
      schedule: jsonb("schedule").notNull(),
      // { days: ['monday', 'wednesday'], time: '6:00 AM - 7:30 AM' }
      maxCapacity: integer("max_capacity").notNull(),
      currentCapacity: integer("current_capacity").default(0),
      skillLevel: text("skill_level").notNull(),
      // beginner, intermediate, advanced
      isActive: boolean("is_active").default(true),
      createdAt: timestamp("created_at").defaultNow()
    });
    students = pgTable("students", {
      id: serial("id").primaryKey(),
      userId: integer("user_id").references(() => users.id),
      studentId: text("student_id").unique().notNull(),
      // STU001, STU002, etc.
      name: text("name").notNull(),
      phone: text("phone").notNull(),
      email: text("email"),
      dateOfBirth: date("date_of_birth"),
      address: text("address"),
      emergencyContact: jsonb("emergency_contact"),
      // { name, phone, relation }
      medicalNotes: text("medical_notes"),
      sportId: integer("sport_id").references(() => sports.id),
      batchId: integer("batch_id").references(() => batches.id),
      skillLevel: text("skill_level").notNull(),
      joiningDate: timestamp("joining_date").defaultNow(),
      isActive: boolean("is_active").default(true),
      profileImageUrl: text("profile_image_url"),
      createdAt: timestamp("created_at").defaultNow()
    });
    payments = pgTable("payments", {
      id: serial("id").primaryKey(),
      studentId: integer("student_id").references(() => students.id),
      amount: decimal("amount", { precision: 10, scale: 2 }).notNull(),
      paymentType: text("payment_type").notNull(),
      // monthly, registration, tournament
      paymentMethod: text("payment_method").notNull(),
      // cash, upi, card, online
      status: text("status").notNull().default("pending"),
      // pending, completed, failed
      transactionId: text("transaction_id"),
      receiptNumber: text("receipt_number"),
      paymentDate: timestamp("payment_date"),
      dueDate: timestamp("due_date"),
      monthYear: text("month_year"),
      // "2025-01" for monthly payments
      notes: text("notes"),
      createdAt: timestamp("created_at").defaultNow()
    });
    attendance = pgTable("attendance", {
      id: serial("id").primaryKey(),
      studentId: integer("student_id").references(() => students.id),
      batchId: integer("batch_id").references(() => batches.id),
      date: date("date").notNull(),
      status: text("status").notNull(),
      // present, absent, late, excused
      markedBy: integer("marked_by").references(() => users.id),
      markedAt: timestamp("marked_at").defaultNow(),
      notes: text("notes")
    });
    activities = pgTable("activities", {
      id: serial("id").primaryKey(),
      type: text("type").notNull(),
      // student_enrolled, payment_received, attendance_marked, etc.
      description: text("description").notNull(),
      userId: integer("user_id").references(() => users.id),
      entityId: integer("entity_id"),
      // ID of the related entity (student, payment, etc.)
      entityType: text("entity_type"),
      // student, payment, attendance, etc.
      metadata: jsonb("metadata"),
      // Additional data about the activity
      createdAt: timestamp("created_at").defaultNow()
    });
    communications = pgTable("communications", {
      id: serial("id").primaryKey(),
      type: text("type").notNull(),
      // sms, whatsapp, email
      recipient: text("recipient").notNull(),
      // phone or email
      message: text("message").notNull(),
      status: text("status").notNull().default("pending"),
      // pending, sent, delivered, failed
      sentAt: timestamp("sent_at"),
      deliveredAt: timestamp("delivered_at"),
      templateId: text("template_id"),
      campaignId: text("campaign_id"),
      metadata: jsonb("metadata"),
      createdAt: timestamp("created_at").defaultNow()
    });
    settings = pgTable("settings", {
      id: serial("id").primaryKey(),
      category: text("category").notNull(),
      // general, payments, notifications, appearance, security
      key: text("key").notNull().unique(),
      value: jsonb("value").notNull(),
      description: text("description"),
      isActive: boolean("is_active").default(true),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    icons = pgTable("icons", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      category: text("category").notNull(),
      // sports, actions, navigation, misc
      svgPath: text("svg_path").notNull(),
      isDefault: boolean("is_default").default(false),
      isActive: boolean("is_active").default(true),
      createdAt: timestamp("created_at").defaultNow()
    });
    paymentGateways = pgTable("payment_gateways", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      // stripe, paypal, razorpay, paytm
      displayName: text("display_name").notNull(),
      configuration: jsonb("configuration").notNull(),
      // API keys, webhook URLs, etc.
      isActive: boolean("is_active").default(false),
      isDefault: boolean("is_default").default(false),
      supportedMethods: jsonb("supported_methods").default([]),
      // card, upi, wallet, netbanking
      fees: jsonb("fees").default({}),
      // transaction fees structure
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    campaigns = pgTable("campaigns", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      description: text("description"),
      type: text("type").notNull(),
      // welcome, fee_reminder, attendance_followup, birthday, event, custom
      status: text("status").notNull().default("draft"),
      // draft, active, paused, completed
      trigger: text("trigger").notNull(),
      // manual, scheduled, automated
      targetAudience: jsonb("target_audience").notNull(),
      // { type: 'all' | 'sport' | 'batch' | 'custom', filters: {} }
      messageTemplate: jsonb("message_template").notNull(),
      // { text, media, buttons, variables }
      schedule: jsonb("schedule"),
      // { startDate, endDate, time, frequency }
      automationRules: jsonb("automation_rules"),
      // { conditions, actions }
      analytics: jsonb("analytics").default({}),
      // { sent, delivered, read, replied, failed }
      createdBy: integer("created_by").references(() => users.id),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow(),
      lastRunAt: timestamp("last_run_at")
    });
    campaignMessages = pgTable("campaign_messages", {
      id: serial("id").primaryKey(),
      campaignId: integer("campaign_id").references(() => campaigns.id),
      recipient: text("recipient").notNull(),
      // phone number
      studentId: integer("student_id").references(() => students.id),
      messageContent: text("message_content").notNull(),
      status: text("status").notNull().default("pending"),
      // pending, sent, delivered, read, failed
      whatsappMessageId: text("whatsapp_message_id"),
      sentAt: timestamp("sent_at"),
      deliveredAt: timestamp("delivered_at"),
      readAt: timestamp("read_at"),
      errorMessage: text("error_message"),
      metadata: jsonb("metadata"),
      // Additional tracking data
      createdAt: timestamp("created_at").defaultNow()
    });
    messageTemplates = pgTable("message_templates", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      category: text("category").notNull(),
      // greeting, reminder, notification, promotional
      language: text("language").notNull().default("en"),
      content: jsonb("content").notNull(),
      // { text, media, buttons, variables }
      variables: jsonb("variables"),
      // Available merge variables
      isActive: boolean("is_active").default(true),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    customReports = pgTable("custom_reports", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      description: text("description"),
      category: text("category").notNull(),
      // students, payments, attendance, performance, financial
      queryConfig: jsonb("query_config").notNull(),
      // { tables, fields, filters, groupBy, orderBy, joins }
      chartConfig: jsonb("chart_config"),
      // { type, xAxis, yAxis, series, colors }
      isPublic: boolean("is_public").default(false),
      isScheduled: boolean("is_scheduled").default(false),
      scheduleConfig: jsonb("schedule_config"),
      // { frequency, time, recipients, format }
      createdBy: integer("created_by").references(() => users.id),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow(),
      lastRunAt: timestamp("last_run_at")
    });
    reportExecutions = pgTable("report_executions", {
      id: serial("id").primaryKey(),
      reportId: integer("report_id").references(() => customReports.id),
      status: text("status").notNull().default("pending"),
      // pending, running, completed, failed
      result: jsonb("result"),
      // Generated report data
      metadata: jsonb("metadata"),
      // Execution details, file paths, etc.
      executedBy: integer("executed_by").references(() => users.id),
      executedAt: timestamp("executed_at").defaultNow(),
      completedAt: timestamp("completed_at"),
      errorMessage: text("error_message")
    });
    savedQueries = pgTable("saved_queries", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      description: text("description"),
      queryConfig: jsonb("query_config").notNull(),
      isPublic: boolean("is_public").default(false),
      createdBy: integer("created_by").references(() => users.id),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    usersRelations = relations(users, ({ many }) => ({
      students: many(students),
      batchesAsCoach: many(batches),
      attendanceMarked: many(attendance),
      activities: many(activities)
    }));
    coachesRelations = relations(coaches, ({ many }) => ({
      batches: many(batches)
    }));
    sportsRelations = relations(sports, ({ many }) => ({
      batches: many(batches),
      students: many(students)
    }));
    batchesRelations = relations(batches, ({ one, many }) => ({
      sport: one(sports, { fields: [batches.sportId], references: [sports.id] }),
      coach: one(users, { fields: [batches.coachId], references: [users.id] }),
      students: many(students),
      attendance: many(attendance)
    }));
    studentsRelations = relations(students, ({ one, many }) => ({
      user: one(users, { fields: [students.userId], references: [users.id] }),
      sport: one(sports, { fields: [students.sportId], references: [sports.id] }),
      batch: one(batches, { fields: [students.batchId], references: [batches.id] }),
      payments: many(payments),
      attendance: many(attendance)
    }));
    paymentsRelations = relations(payments, ({ one }) => ({
      student: one(students, { fields: [payments.studentId], references: [students.id] })
    }));
    attendanceRelations = relations(attendance, ({ one }) => ({
      student: one(students, { fields: [attendance.studentId], references: [students.id] }),
      batch: one(batches, { fields: [attendance.batchId], references: [batches.id] }),
      markedBy: one(users, { fields: [attendance.markedBy], references: [users.id] })
    }));
    activitiesRelations = relations(activities, ({ one }) => ({
      user: one(users, { fields: [activities.userId], references: [users.id] })
    }));
    campaignsRelations = relations(campaigns, ({ one, many }) => ({
      createdBy: one(users, { fields: [campaigns.createdBy], references: [users.id] }),
      messages: many(campaignMessages)
    }));
    campaignMessagesRelations = relations(campaignMessages, ({ one }) => ({
      campaign: one(campaigns, { fields: [campaignMessages.campaignId], references: [campaigns.id] }),
      student: one(students, { fields: [campaignMessages.studentId], references: [students.id] })
    }));
    customReportsRelations = relations(customReports, ({ one, many }) => ({
      createdBy: one(users, { fields: [customReports.createdBy], references: [users.id] }),
      executions: many(reportExecutions)
    }));
    reportExecutionsRelations = relations(reportExecutions, ({ one }) => ({
      report: one(customReports, { fields: [reportExecutions.reportId], references: [customReports.id] }),
      executedBy: one(users, { fields: [reportExecutions.executedBy], references: [users.id] })
    }));
    savedQueriesRelations = relations(savedQueries, ({ one }) => ({
      createdBy: one(users, { fields: [savedQueries.createdBy], references: [users.id] })
    }));
    insertUserSchema = createInsertSchema(users);
    selectUserSchema = createSelectSchema(users);
    insertSportSchema = createInsertSchema(sports);
    selectSportSchema = createSelectSchema(sports);
    insertBatchSchema = createInsertSchema(batches);
    selectBatchSchema = createSelectSchema(batches);
    insertStudentSchema = createInsertSchema(students).omit({
      id: true,
      studentId: true,
      createdAt: true
    });
    selectStudentSchema = createSelectSchema(students);
    insertPaymentSchema = createInsertSchema(payments).omit({
      id: true,
      createdAt: true
    });
    selectPaymentSchema = createSelectSchema(payments);
    insertAttendanceSchema = createInsertSchema(attendance).omit({
      id: true,
      markedAt: true
    });
    selectAttendanceSchema = createSelectSchema(attendance);
    insertActivitySchema = createInsertSchema(activities).omit({
      id: true,
      createdAt: true
    });
    selectActivitySchema = createSelectSchema(activities);
    insertCommunicationSchema = createInsertSchema(communications);
    selectCommunicationSchema = createSelectSchema(communications);
    insertSettingSchema = createInsertSchema(settings);
    selectSettingSchema = createSelectSchema(settings);
    insertIconSchema = createInsertSchema(icons);
    selectIconSchema = createSelectSchema(icons);
    insertPaymentGatewaySchema = createInsertSchema(paymentGateways);
    selectPaymentGatewaySchema = createSelectSchema(paymentGateways);
    insertCoachSchema = createInsertSchema(coaches);
    selectCoachSchema = createSelectSchema(coaches);
    insertCampaignSchema = createInsertSchema(campaigns).omit({
      id: true,
      createdAt: true,
      updatedAt: true,
      lastRunAt: true
    });
    selectCampaignSchema = createSelectSchema(campaigns);
    insertCampaignMessageSchema = createInsertSchema(campaignMessages).omit({
      id: true,
      createdAt: true
    });
    selectCampaignMessageSchema = createSelectSchema(campaignMessages);
    insertMessageTemplateSchema = createInsertSchema(messageTemplates).omit({
      id: true,
      createdAt: true,
      updatedAt: true
    });
    selectMessageTemplateSchema = createSelectSchema(messageTemplates);
    insertCustomReportSchema = createInsertSchema(customReports).omit({
      id: true,
      createdAt: true,
      updatedAt: true,
      lastRunAt: true
    });
    selectCustomReportSchema = createSelectSchema(customReports);
    insertReportExecutionSchema = createInsertSchema(reportExecutions).omit({
      id: true,
      executedAt: true,
      completedAt: true
    });
    selectReportExecutionSchema = createSelectSchema(reportExecutions);
    insertSavedQuerySchema = createInsertSchema(savedQueries).omit({
      id: true,
      createdAt: true,
      updatedAt: true
    });
    selectSavedQuerySchema = createSelectSchema(savedQueries);
    locationTracking = pgTable("location_tracking", {
      id: serial("id").primaryKey(),
      userId: integer("user_id").references(() => users.id),
      latitude: decimal("latitude", { precision: 10, scale: 8 }).notNull(),
      longitude: decimal("longitude", { precision: 11, scale: 8 }).notNull(),
      accuracy: integer("accuracy"),
      // GPS accuracy in meters
      timestamp: timestamp("timestamp").defaultNow(),
      isWithinGeofence: boolean("is_within_geofence").default(false),
      geofenceId: integer("geofence_id").references(() => geofences.id),
      trackingType: text("tracking_type").default("manual"),
      // manual, automatic, attendance
      metadata: jsonb("metadata").default({}),
      createdAt: timestamp("created_at").defaultNow()
    });
    geofences = pgTable("geofences", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      description: text("description"),
      centerLatitude: decimal("center_latitude", { precision: 10, scale: 8 }).notNull(),
      centerLongitude: decimal("center_longitude", { precision: 11, scale: 8 }).notNull(),
      radius: integer("radius").notNull(),
      // radius in meters
      isActive: boolean("is_active").default(true),
      createdBy: integer("created_by").references(() => users.id),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    coachAttendance = pgTable("coach_attendance", {
      id: serial("id").primaryKey(),
      coachId: integer("coach_id").references(() => coaches.id),
      batchId: integer("batch_id").references(() => batches.id),
      date: date("date").notNull(),
      checkInTime: timestamp("check_in_time"),
      checkOutTime: timestamp("check_out_time"),
      checkInLocation: jsonb("check_in_location"),
      // {lat, lng, accuracy}
      checkOutLocation: jsonb("check_out_location"),
      isGpsVerified: boolean("is_gps_verified").default(false),
      geofenceVerified: boolean("geofence_verified").default(false),
      status: text("status").default("absent"),
      // present, absent, late, early_leave
      notes: text("notes"),
      verifiedBy: integer("verified_by").references(() => users.id),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    userRoles = pgTable("user_roles", {
      id: serial("id").primaryKey(),
      name: text("name").unique().notNull(),
      displayName: text("display_name").notNull(),
      description: text("description"),
      permissions: jsonb("permissions").default([]),
      isActive: boolean("is_active").default(true),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    permissions = pgTable("permissions", {
      id: serial("id").primaryKey(),
      name: text("name").unique().notNull(),
      displayName: text("display_name").notNull(),
      description: text("description"),
      category: text("category").notNull(),
      // users, students, payments, attendance, etc.
      isActive: boolean("is_active").default(true),
      createdAt: timestamp("created_at").defaultNow()
    });
    insertLocationTrackingSchema = createInsertSchema(locationTracking).omit({
      id: true,
      createdAt: true
    });
    selectLocationTrackingSchema = createSelectSchema(locationTracking);
    insertGeofenceSchema = createInsertSchema(geofences).omit({
      id: true,
      createdAt: true,
      updatedAt: true
    });
    selectGeofenceSchema = createSelectSchema(geofences);
    insertCoachAttendanceSchema = createInsertSchema(coachAttendance).omit({
      id: true,
      createdAt: true,
      updatedAt: true
    });
    selectCoachAttendanceSchema = createSelectSchema(coachAttendance);
    insertUserRoleSchema = createInsertSchema(userRoles).omit({
      id: true,
      createdAt: true,
      updatedAt: true
    });
    selectUserRoleSchema = createSelectSchema(userRoles);
    insertPermissionSchema = createInsertSchema(permissions).omit({
      id: true,
      createdAt: true
    });
    selectPermissionSchema = createSelectSchema(permissions);
    badges = pgTable("badges", {
      id: serial("id").primaryKey(),
      name: text("name").notNull(),
      description: text("description").notNull(),
      icon: text("icon").notNull(),
      color: text("color").notNull(),
      category: text("category").notNull(),
      // attendance, payment, performance, milestones
      requirements: jsonb("requirements").notNull(),
      // JSON object with achievement requirements
      points: integer("points").notNull().default(0),
      rarity: text("rarity").notNull().default("common"),
      // common, rare, epic, legendary
      isActive: boolean("is_active").notNull().default(true),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    studentBadges = pgTable("student_badges", {
      id: serial("id").primaryKey(),
      studentId: integer("student_id").references(() => students.id),
      badgeId: integer("badge_id").references(() => badges.id),
      earnedAt: timestamp("earned_at").defaultNow(),
      progress: jsonb("progress"),
      // JSON object tracking progress toward badge
      isDisplayed: boolean("is_displayed").notNull().default(true),
      createdAt: timestamp("created_at").defaultNow()
    });
    studentPoints = pgTable("student_points", {
      id: serial("id").primaryKey(),
      studentId: integer("student_id").references(() => students.id),
      totalPoints: integer("total_points").notNull().default(0),
      monthlyPoints: integer("monthly_points").notNull().default(0),
      lastUpdated: timestamp("last_updated").defaultNow(),
      level: integer("level").notNull().default(1),
      experiencePoints: integer("experience_points").notNull().default(0),
      createdAt: timestamp("created_at").defaultNow(),
      updatedAt: timestamp("updated_at").defaultNow()
    });
    achievementHistory = pgTable("achievement_history", {
      id: serial("id").primaryKey(),
      studentId: integer("student_id").references(() => students.id),
      action: text("action").notNull(),
      // badge_earned, points_awarded, level_up
      description: text("description").notNull(),
      points: integer("points").notNull().default(0),
      metadata: jsonb("metadata"),
      // Additional data about the achievement
      createdAt: timestamp("created_at").defaultNow()
    });
    insertBadgeSchema = createInsertSchema(badges).omit({
      id: true,
      createdAt: true,
      updatedAt: true
    });
    selectBadgeSchema = createSelectSchema(badges);
    insertStudentBadgeSchema = createInsertSchema(studentBadges).omit({
      id: true,
      createdAt: true
    });
    selectStudentBadgeSchema = createSelectSchema(studentBadges);
    insertStudentPointsSchema = createInsertSchema(studentPoints).omit({
      id: true,
      createdAt: true,
      updatedAt: true
    });
    selectStudentPointsSchema = createSelectSchema(studentPoints);
    insertAchievementHistorySchema = createInsertSchema(achievementHistory).omit({
      id: true,
      createdAt: true
    });
    selectAchievementHistorySchema = createSelectSchema(achievementHistory);
  }
});

// server/db.ts
import dotenv from "dotenv";
import { Pool } from "pg";
import { drizzle } from "drizzle-orm/node-postgres";
var pool, db;
var init_db = __esm({
  "server/db.ts"() {
    "use strict";
    init_schema();
    dotenv.config();
    if (!process.env.DATABASE_URL) {
      throw new Error(
        "DATABASE_URL must be set. Did you forget to provision a database?"
      );
    }
    pool = new Pool({ connectionString: process.env.DATABASE_URL });
    db = drizzle(pool, { schema: schema_exports });
  }
});

// server/storage.ts
import { eq, desc, asc, and, or, gte, lte, count, sum, like, sql } from "drizzle-orm";
var DatabaseStorage, storage;
var init_storage = __esm({
  "server/storage.ts"() {
    "use strict";
    init_schema();
    init_db();
    DatabaseStorage = class {
      // User operations
      async getUser(id) {
        const [user] = await db.select().from(users).where(eq(users.id, id));
        return user;
      }
      async getUserByPhone(phone) {
        const [user] = await db.select().from(users).where(eq(users.phone, phone));
        return user;
      }
      async getUserByEmail(email) {
        const [user] = await db.select().from(users).where(eq(users.email, email));
        return user;
      }
      async createUser(userData) {
        const [user] = await db.insert(users).values(userData).returning();
        return user;
      }
      async updateUser(id, updates) {
        const [user] = await db.update(users).set({ ...updates, updatedAt: /* @__PURE__ */ new Date() }).where(eq(users.id, id)).returning();
        return user;
      }
      async updateUserLastLogin(id) {
        const [user] = await db.update(users).set({ lastLogin: /* @__PURE__ */ new Date(), updatedAt: /* @__PURE__ */ new Date() }).where(eq(users.id, id)).returning();
        return user;
      }
      async getUsers() {
        return await db.select().from(users).orderBy(asc(users.name));
      }
      async updateUserRole(id, role) {
        const [user] = await db.update(users).set({ role }).where(eq(users.id, id)).returning();
        return user;
      }
      async updateUserPermissions(id, permissions2) {
        const [user] = await db.update(users).set({ permissions: permissions2 }).where(eq(users.id, id)).returning();
        return user;
      }
      async activateUser(id) {
        const [user] = await db.update(users).set({ isActive: true }).where(eq(users.id, id)).returning();
        return user;
      }
      async deactivateUser(id) {
        const [user] = await db.update(users).set({ isActive: false }).where(eq(users.id, id)).returning();
        return user;
      }
      async getPermissions() {
        return await db.select().from(permissions).orderBy(asc(permissions.category), asc(permissions.name));
      }
      // Mobile-specific methods
      async getStudentByPhone(phone) {
        const [student] = await db.select().from(students).where(eq(students.phone, phone));
        return student;
      }
      async getCoachByPhone(phone) {
        const [coach] = await db.select().from(coaches).where(eq(coaches.phone, phone));
        return coach;
      }
      async getStudentsByCoach(coachId) {
        return await db.select().from(students).where(eq(students.coachId, coachId));
      }
      async getBatchesByCoach(coachId) {
        return await db.select().from(batches).where(eq(batches.coachId, coachId));
      }
      async getTodayAttendanceByCoach(coachId) {
        const today = (/* @__PURE__ */ new Date()).toISOString().split("T")[0];
        return await db.select().from(attendance).where(eq(attendance.date, today));
      }
      async getWeeklyClassesByCoach(coachId) {
        return await db.select().from(batches).where(eq(batches.coachId, coachId));
      }
      async getTodayClassesByCoach(coachId) {
        return await db.select().from(batches).where(eq(batches.coachId, coachId));
      }
      async getRecentAttendanceByCoach(coachId) {
        return await db.select().from(attendance).limit(10);
      }
      async getStudentAttendanceStats(studentId) {
        const totalAttendance = await db.select().from(attendance).where(eq(attendance.studentId, studentId));
        const presentCount = totalAttendance.filter((a) => a.status === "present").length;
        const percentage = totalAttendance.length > 0 ? Math.round(presentCount / totalAttendance.length * 100) : 0;
        return {
          totalClasses: totalAttendance.length,
          percentage,
          presentCount
        };
      }
      async getStudentPaymentStats(studentId) {
        const payments2 = await db.select().from(payments2).where(eq(payments2.studentId, studentId));
        const totalPaid = payments2.reduce((sum3, p) => sum3 + p.amount, 0);
        const pendingPayments = payments2.filter((p) => p.status === "pending");
        const upcomingAmount = pendingPayments.reduce((sum3, p) => sum3 + p.amount, 0);
        return {
          totalPaid,
          upcomingAmount
        };
      }
      async getStudentBadgeStats(studentId) {
        const badges2 = await db.select().from(studentBadges).where(eq(studentBadges.studentId, studentId));
        const points = await db.select().from(studentPoints).where(eq(studentPoints.studentId, studentId));
        return {
          totalBadges: badges2.length,
          totalPoints: points[0]?.totalPoints || 0,
          currentLevel: points[0]?.level || 1
        };
      }
      async getUpcomingClassesByStudent(studentId) {
        const student = await this.getStudent(studentId);
        if (!student?.batchId) return [];
        return await db.select().from(batches).where(eq(batches.id, student.batchId));
      }
      async getRecentBadgesByStudent(studentId) {
        return await db.select().from(studentBadges).where(eq(studentBadges.studentId, studentId)).limit(5);
      }
      async getStudentAttendanceHistory(studentId) {
        return await db.select().from(attendance).where(eq(attendance.studentId, studentId)).limit(50);
      }
      async getStudentPaymentHistory(studentId) {
        return await db.select().from(payments).where(eq(payments.studentId, studentId)).limit(50);
      }
      async getStudentAchievements(studentId) {
        return await db.select().from(studentBadges).where(eq(studentBadges.studentId, studentId));
      }
      // Coach operations
      async getCoach(id) {
        const [coach] = await db.select().from(coaches).where(eq(coaches.id, id));
        return coach;
      }
      async getCoaches(isActive) {
        const conditions = isActive !== void 0 ? [eq(coaches.isActive, isActive)] : [];
        return await db.select().from(coaches).where(and(...conditions)).orderBy(asc(coaches.name));
      }
      async createCoach(coachData) {
        const [coach] = await db.insert(coaches).values(coachData).returning();
        return coach;
      }
      async updateCoach(id, updates) {
        const [coach] = await db.update(coaches).set({ ...updates, updatedAt: /* @__PURE__ */ new Date() }).where(eq(coaches.id, id)).returning();
        return coach;
      }
      async deleteCoach(id) {
        try {
          const batchesWithCoach = await db.select().from(batches).where(eq(batches.coachId, id));
          if (batchesWithCoach.length > 0) {
            throw new Error(`Cannot delete coach: ${batchesWithCoach.length} batches are still assigned to this coach`);
          }
          const result = await db.delete(coaches).where(eq(coaches.id, id));
          return result.rowCount > 0;
        } catch (error) {
          console.error("Error deleting coach:", error);
          throw error;
        }
      }
      // Student operations
      async getStudent(id) {
        const [student] = await db.select().from(students).where(eq(students.id, id));
        return student;
      }
      async getStudentByStudentId(studentId) {
        const [student] = await db.select().from(students).where(eq(students.studentId, studentId));
        return student;
      }
      async getStudents(filters) {
        const conditions = [];
        if (filters?.sportId) conditions.push(eq(students.sportId, filters.sportId));
        if (filters?.batchId) conditions.push(eq(students.batchId, filters.batchId));
        if (filters?.isActive !== void 0) conditions.push(eq(students.isActive, filters.isActive));
        if (filters?.search) {
          conditions.push(
            or(
              like(students.name, `%${filters.search}%`),
              like(students.phone, `%${filters.search}%`),
              like(students.studentId, `%${filters.search}%`)
            )
          );
        }
        const whereClause = conditions.length > 0 ? and(...conditions) : void 0;
        const [studentsResult, totalResult] = await Promise.all([
          db.select().from(students).where(whereClause).limit(filters?.limit || 50).offset(filters?.offset || 0).orderBy(desc(students.createdAt)),
          db.select({ count: count() }).from(students).where(whereClause)
        ]);
        return {
          students: studentsResult,
          total: totalResult[0]?.count || 0
        };
      }
      async createStudent(studentData) {
        const [student] = await db.insert(students).values(studentData).returning();
        return student;
      }
      async updateStudent(id, updates) {
        const [student] = await db.update(students).set(updates).where(eq(students.id, id)).returning();
        return student;
      }
      async deleteStudent(id) {
        try {
          await db.transaction(async (tx) => {
            await tx.delete(payments).where(eq(payments.studentId, id));
            await tx.delete(attendance).where(eq(attendance.studentId, id));
            await tx.delete(studentBadges).where(eq(studentBadges.studentId, id));
            await tx.delete(studentPoints).where(eq(studentPoints.studentId, id));
            await tx.delete(achievementHistory).where(eq(achievementHistory.studentId, id));
            await tx.delete(students).where(eq(students.id, id));
          });
          return true;
        } catch (error) {
          console.error("Error deleting student:", error);
          throw error;
        }
      }
      // Sport operations
      async getSport(id) {
        const [sport] = await db.select().from(sports).where(eq(sports.id, id));
        return sport;
      }
      async getSports(isActive) {
        try {
          const whereClause = isActive !== void 0 ? eq(sports.isActive, isActive) : void 0;
          const allSports = await db.select().from(sports).where(whereClause).orderBy(asc(sports.name));
          if (!allSports || allSports.length === 0) {
            return [];
          }
          const allStudents = await db.select().from(students).where(eq(students.isActive, true));
          const sportStudentCounts = allStudents.reduce((acc, student) => {
            if (student.sportId) {
              acc[student.sportId] = (acc[student.sportId] || 0) + 1;
            }
            return acc;
          }, {});
          const sportsWithCount = allSports.map((sport) => ({
            ...sport,
            studentsCount: sportStudentCounts[sport.id] || 0
          }));
          return sportsWithCount;
        } catch (error) {
          console.error("Error in getSports:", error);
          return [];
        }
      }
      async getSportByName(name) {
        const [sport] = await db.select().from(sports).where(eq(sports.name, name)).limit(1);
        return sport;
      }
      async createSport(sportData) {
        const [sport] = await db.insert(sports).values(sportData).returning();
        return sport;
      }
      async updateSport(id, updates) {
        const [sport] = await db.update(sports).set(updates).where(eq(sports.id, id)).returning();
        return sport;
      }
      // Batch operations
      async getBatch(id) {
        const [batch] = await db.select().from(batches).where(eq(batches.id, id));
        return batch;
      }
      async getBatches(filters) {
        const conditions = [];
        if (filters?.sportId) conditions.push(eq(batches.sportId, filters.sportId));
        if (filters?.coachId) conditions.push(eq(batches.coachId, filters.coachId));
        if (filters?.isActive !== void 0) conditions.push(eq(batches.isActive, filters.isActive));
        const whereClause = conditions.length > 0 ? and(...conditions) : void 0;
        return db.select().from(batches).where(whereClause).orderBy(asc(batches.name));
      }
      async createBatch(batchData) {
        const [batch] = await db.insert(batches).values(batchData).returning();
        return batch;
      }
      async updateBatch(id, updates) {
        const [batch] = await db.update(batches).set(updates).where(eq(batches.id, id)).returning();
        return batch;
      }
      async updateBatchCapacity(id, increment) {
        const [batch] = await db.update(batches).set({
          currentCapacity: sql`${batches.currentCapacity} + ${increment}`
        }).where(eq(batches.id, id)).returning();
        return batch;
      }
      async deleteBatch(id) {
        try {
          const studentsInBatch = await db.select().from(students).where(eq(students.batchId, id));
          if (studentsInBatch.length > 0) {
            throw new Error(`Cannot delete batch: ${studentsInBatch.length} students are still assigned to this batch`);
          }
          const result = await db.delete(batches).where(eq(batches.id, id));
          return (result.rowCount ?? 0) > 0;
        } catch (error) {
          console.error("Error deleting batch:", error);
          throw error;
        }
      }
      // Payment operations
      async getPayment(id) {
        const [payment] = await db.select().from(payments).where(eq(payments.id, id));
        return payment;
      }
      async getPayments(filters) {
        const conditions = [];
        if (filters?.studentId) conditions.push(eq(payments.studentId, filters.studentId));
        if (filters?.status) conditions.push(eq(payments.status, filters.status));
        if (filters?.monthYear) conditions.push(eq(payments.monthYear, filters.monthYear));
        if (filters?.search) {
          const searchConditions = or(
            like(students.name, `%${filters.search}%`),
            like(students.studentId, `%${filters.search}%`),
            like(payments.receiptNumber, `%${filters.search}%`)
          );
          conditions.push(searchConditions);
        }
        const whereClause = conditions.length > 0 ? and(...conditions) : void 0;
        const baseQuery = db.select({
          // Payment fields
          id: payments.id,
          studentId: payments.studentId,
          amount: payments.amount,
          paymentMethod: payments.paymentMethod,
          status: payments.status,
          monthYear: payments.monthYear,
          receiptNumber: payments.receiptNumber,
          paidAt: payments.paidAt,
          createdAt: payments.createdAt,
          updatedAt: payments.updatedAt,
          // Student fields
          studentName: students.name,
          studentStudentId: students.studentId,
          studentPhone: students.phone
        }).from(payments).leftJoin(students, eq(payments.studentId, students.id)).where(whereClause);
        const [paymentsResult, totalResult] = await Promise.all([
          baseQuery.limit(filters?.limit || 50).offset(filters?.offset || 0).orderBy(desc(payments.createdAt)),
          db.select({ count: count() }).from(payments).leftJoin(students, eq(payments.studentId, students.id)).where(whereClause)
        ]);
        const paymentsWithStudents = paymentsResult.map((row) => ({
          id: row.id,
          studentId: row.studentId,
          amount: row.amount,
          paymentMethod: row.paymentMethod,
          status: row.status,
          monthYear: row.monthYear,
          receiptNumber: row.receiptNumber,
          paidAt: row.paidAt,
          createdAt: row.createdAt,
          updatedAt: row.updatedAt,
          student: row.studentName ? {
            name: row.studentName,
            studentId: row.studentStudentId,
            phone: row.studentPhone
          } : null
        }));
        return {
          payments: paymentsWithStudents,
          total: totalResult[0]?.count || 0
        };
      }
      async createPayment(paymentData) {
        const [payment] = await db.insert(payments).values(paymentData).returning();
        return payment;
      }
      async updatePayment(id, updates) {
        const [payment] = await db.update(payments).set(updates).where(eq(payments.id, id)).returning();
        return payment;
      }
      async getPendingPayments() {
        return db.select().from(payments).where(eq(payments.status, "pending")).orderBy(desc(payments.dueDate));
      }
      async getRevenueStats(startDate, endDate) {
        const now = /* @__PURE__ */ new Date();
        const thisMonthStart = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastMonthStart = new Date(now.getFullYear(), now.getMonth() - 1, 1);
        const lastMonthEnd = new Date(now.getFullYear(), now.getMonth(), 0);
        const [totalResult, thisMonthResult, lastMonthResult] = await Promise.all([
          db.select({ total: sum(payments.amount) }).from(payments).where(eq(payments.status, "completed")),
          db.select({ total: sum(payments.amount) }).from(payments).where(and(
            eq(payments.status, "completed"),
            gte(payments.paymentDate, thisMonthStart)
          )),
          db.select({ total: sum(payments.amount) }).from(payments).where(and(
            eq(payments.status, "completed"),
            gte(payments.paymentDate, lastMonthStart),
            lte(payments.paymentDate, lastMonthEnd)
          ))
        ]);
        const total = Number(totalResult[0]?.total || 0);
        const thisMonth = Number(thisMonthResult[0]?.total || 0);
        const lastMonth = Number(lastMonthResult[0]?.total || 0);
        const growth = lastMonth > 0 ? (thisMonth - lastMonth) / lastMonth * 100 : 0;
        return { total, thisMonth, lastMonth, growth };
      }
      // Attendance operations
      async getAttendance(id) {
        const [attendanceRecord] = await db.select().from(attendance).where(eq(attendance.id, id));
        return attendanceRecord;
      }
      async getAttendanceByDate(date2, batchId) {
        const conditions = [eq(attendance.date, date2)];
        if (batchId) conditions.push(eq(attendance.batchId, batchId));
        return db.select().from(attendance).where(and(...conditions));
      }
      async getStudentAttendance(studentId, startDate, endDate) {
        const conditions = [eq(attendance.studentId, studentId)];
        if (startDate) conditions.push(gte(attendance.date, startDate.toISOString().split("T")[0]));
        if (endDate) conditions.push(lte(attendance.date, endDate.toISOString().split("T")[0]));
        return db.select().from(attendance).where(and(...conditions)).orderBy(desc(attendance.date));
      }
      async markAttendance(attendanceData) {
        const [attendanceRecord] = await db.insert(attendance).values(attendanceData).returning();
        return attendanceRecord;
      }
      async updateAttendance(id, updates) {
        const [attendanceRecord] = await db.update(attendance).set(updates).where(eq(attendance.id, id)).returning();
        return attendanceRecord;
      }
      async getAttendanceStats(batchId, date2) {
        const dateStr = date2?.toISOString().split("T")[0] || (/* @__PURE__ */ new Date()).toISOString().split("T")[0];
        const conditions = [eq(attendance.date, dateStr)];
        if (batchId) conditions.push(eq(attendance.batchId, batchId));
        const [totalResult, presentResult] = await Promise.all([
          db.select({ count: count() }).from(attendance).where(and(...conditions)),
          db.select({ count: count() }).from(attendance).where(and(...conditions, eq(attendance.status, "present")))
        ]);
        const total = totalResult[0]?.count || 0;
        const present = presentResult[0]?.count || 0;
        const absent = total - present;
        const percentage = total > 0 ? present / total * 100 : 0;
        return { total, present, absent, percentage };
      }
      // Activity operations
      async getActivities(limit = 50, offset = 0) {
        const [activitiesResult, totalResult] = await Promise.all([
          db.select().from(activities).limit(limit).offset(offset).orderBy(desc(activities.createdAt)),
          db.select({ count: count() }).from(activities)
        ]);
        return {
          activities: activitiesResult,
          total: totalResult[0]?.count || 0
        };
      }
      async createActivity(activityData) {
        const [activity] = await db.insert(activities).values(activityData).returning();
        return activity;
      }
      // Communication operations
      async getCommunications(filters) {
        const conditions = [];
        if (filters?.type) conditions.push(eq(communications.type, filters.type));
        if (filters?.status) conditions.push(eq(communications.status, filters.status));
        const whereClause = conditions.length > 0 ? and(...conditions) : void 0;
        const [communicationsResult, totalResult] = await Promise.all([
          db.select().from(communications).where(whereClause).limit(filters?.limit || 50).offset(filters?.offset || 0).orderBy(desc(communications.createdAt)),
          db.select({ count: count() }).from(communications).where(whereClause)
        ]);
        return {
          communications: communicationsResult,
          total: totalResult[0]?.count || 0
        };
      }
      async createCommunication(communicationData) {
        const [communication] = await db.insert(communications).values(communicationData).returning();
        return communication;
      }
      async updateCommunication(id, updates) {
        const [communication] = await db.update(communications).set(updates).where(eq(communications.id, id)).returning();
        return communication;
      }
      // Dashboard analytics
      async getDashboardStats() {
        const [
          totalStudentsResult,
          activeStudentsResult,
          revenueResult,
          pendingFeesResult,
          todayAttendanceResult,
          sportsDistributionResult,
          recentActivitiesResult
        ] = await Promise.all([
          db.select({ count: count() }).from(students),
          db.select({ count: count() }).from(students).where(eq(students.isActive, true)),
          db.select({ total: sum(payments.amount) }).from(payments).where(eq(payments.status, "completed")),
          db.select({ total: sum(payments.amount) }).from(payments).where(eq(payments.status, "pending")),
          this.getAttendanceStats(),
          db.select({
            sportId: students.sportId,
            count: count()
          }).from(students).where(eq(students.isActive, true)).groupBy(students.sportId),
          db.select().from(activities).limit(10).orderBy(desc(activities.createdAt))
        ]);
        const sportsData = await db.select().from(sports);
        const sportsMap = new Map(sportsData.map((sport) => [sport.id, sport.name]));
        const totalStudents = totalStudentsResult[0]?.count || 0;
        const sportsDistribution = sportsDistributionResult.map((item) => ({
          sport: sportsMap.get(item.sportId) || "Unknown",
          count: item.count,
          percentage: totalStudents > 0 ? item.count / totalStudents * 100 : 0
        }));
        return {
          totalStudents,
          activeStudents: activeStudentsResult[0]?.count || 0,
          totalRevenue: Number(revenueResult[0]?.total || 0),
          pendingFees: Number(pendingFeesResult[0]?.total || 0),
          todayAttendance: todayAttendanceResult.percentage,
          sportsDistribution,
          recentActivities: recentActivitiesResult
        };
      }
      // Reports
      async getMonthlyRevenueReport(year) {
        const months = [
          "January",
          "February",
          "March",
          "April",
          "May",
          "June",
          "July",
          "August",
          "September",
          "October",
          "November",
          "December"
        ];
        const results = await Promise.all(
          months.map(async (month, index) => {
            const monthYear = `${year}-${String(index + 1).padStart(2, "0")}`;
            const [result] = await db.select({ total: sum(payments.amount) }).from(payments).where(and(
              eq(payments.status, "completed"),
              like(payments.monthYear, `${monthYear}%`)
            ));
            return {
              month,
              revenue: Number(result?.total || 0)
            };
          })
        );
        return results;
      }
      async getStudentReport(filters) {
        const conditions = [eq(students.isActive, true)];
        if (filters?.sportId) conditions.push(eq(students.sportId, filters.sportId));
        if (filters?.batchId) conditions.push(eq(students.batchId, filters.batchId));
        return db.select().from(students).where(and(...conditions)).orderBy(asc(students.name));
      }
      async getAttendanceReport(startDate, endDate, batchId) {
        const conditions = [
          gte(attendance.date, startDate.toISOString().split("T")[0]),
          lte(attendance.date, endDate.toISOString().split("T")[0])
        ];
        if (batchId) conditions.push(eq(attendance.batchId, batchId));
        const attendanceData = await db.select({
          studentId: attendance.studentId,
          status: attendance.status
        }).from(attendance).where(and(...conditions));
        const studentIds = Array.from(new Set(attendanceData.map((a) => a.studentId).filter((id) => id !== null)));
        const studentsData = await db.select().from(students).where(sql`${students.id} IN ${studentIds}`);
        const studentsMap = new Map(studentsData.map((s) => [s.id, s]));
        const studentStats = studentIds.map((studentId) => {
          const studentAttendance = attendanceData.filter((a) => a.studentId === studentId);
          const totalClasses = studentAttendance.length;
          const presentClasses = studentAttendance.filter((a) => a.status === "present").length;
          const absentClasses = totalClasses - presentClasses;
          const percentage = totalClasses > 0 ? presentClasses / totalClasses * 100 : 0;
          return {
            student: studentsMap.get(studentId),
            totalClasses,
            presentClasses,
            absentClasses,
            percentage
          };
        });
        return { students: studentStats };
      }
      // Settings operations
      async getSetting(key) {
        const [setting] = await db.select().from(settings).where(eq(settings.key, key));
        return setting;
      }
      async getSettings(category) {
        const conditions = category ? [eq(settings.category, category)] : [];
        return await db.select().from(settings).where(and(...conditions));
      }
      async setSetting(key, value, category = "general") {
        const [setting] = await db.insert(settings).values({ key, value, category }).onConflictDoUpdate({
          target: settings.key,
          set: { value, updatedAt: /* @__PURE__ */ new Date() }
        }).returning();
        return setting;
      }
      async updateSetting(key, value) {
        const [setting] = await db.update(settings).set({ value, updatedAt: /* @__PURE__ */ new Date() }).where(eq(settings.key, key)).returning();
        return setting;
      }
      // Icons operations
      async getIcons(category) {
        const conditions = category ? [eq(icons.category, category)] : [];
        return await db.select().from(icons).where(and(...conditions));
      }
      async getIcon(id) {
        const [icon] = await db.select().from(icons).where(eq(icons.id, id));
        return icon;
      }
      async createIcon(iconData) {
        const [icon] = await db.insert(icons).values(iconData).returning();
        return icon;
      }
      async updateIcon(id, updates) {
        const [icon] = await db.update(icons).set(updates).where(eq(icons.id, id)).returning();
        return icon;
      }
      async deleteIcon(id) {
        const result = await db.delete(icons).where(eq(icons.id, id));
        return result.rowCount > 0;
      }
      // Payment gateways operations
      async getPaymentGateways() {
        return await db.select().from(paymentGateways);
      }
      async getPaymentGateway(id) {
        const [gateway] = await db.select().from(paymentGateways).where(eq(paymentGateways.id, id));
        return gateway;
      }
      async createPaymentGateway(gatewayData) {
        const [gateway] = await db.insert(paymentGateways).values(gatewayData).returning();
        return gateway;
      }
      async updatePaymentGateway(id, updates) {
        const [gateway] = await db.update(paymentGateways).set({ ...updates, updatedAt: /* @__PURE__ */ new Date() }).where(eq(paymentGateways.id, id)).returning();
        return gateway;
      }
      async deletePaymentGateway(id) {
        const result = await db.delete(paymentGateways).where(eq(paymentGateways.id, id));
        return result.rowCount > 0;
      }
      // Campaign operations
      async getCampaigns(filters) {
        try {
          let query = db.select().from(campaigns);
          if (filters?.status) {
            query = query.where(eq(campaigns.status, filters.status));
          }
          if (filters?.type) {
            query = query.where(eq(campaigns.type, filters.type));
          }
          return await query.orderBy(campaigns.createdAt);
        } catch (error) {
          console.error("Error fetching campaigns:", error);
          return [];
        }
      }
      async getCampaign(id) {
        try {
          const [campaign] = await db.select().from(campaigns).where(eq(campaigns.id, id));
          return campaign;
        } catch (error) {
          console.error("Error fetching campaign:", error);
          return void 0;
        }
      }
      async createCampaign(campaignData) {
        const [campaign] = await db.insert(campaigns).values(campaignData).returning();
        return campaign;
      }
      async updateCampaign(id, updates) {
        try {
          const [campaign] = await db.update(campaigns).set({ ...updates, updatedAt: /* @__PURE__ */ new Date() }).where(eq(campaigns.id, id)).returning();
          return campaign;
        } catch (error) {
          console.error("Error updating campaign:", error);
          return void 0;
        }
      }
      async deleteCampaign(id) {
        try {
          await db.delete(campaigns).where(eq(campaigns.id, id));
          return true;
        } catch (error) {
          console.error("Error deleting campaign:", error);
          return false;
        }
      }
      // Campaign message operations
      async getCampaignMessages(campaignId) {
        try {
          return await db.select().from(campaignMessages).where(eq(campaignMessages.campaignId, campaignId)).orderBy(campaignMessages.createdAt);
        } catch (error) {
          console.error("Error fetching campaign messages:", error);
          return [];
        }
      }
      async createCampaignMessage(messageData) {
        const [message] = await db.insert(campaignMessages).values(messageData).returning();
        return message;
      }
      async updateCampaignMessage(id, updates) {
        try {
          const [message] = await db.update(campaignMessages).set(updates).where(eq(campaignMessages.id, id)).returning();
          return message;
        } catch (error) {
          console.error("Error updating campaign message:", error);
          return void 0;
        }
      }
      async getCampaignAnalytics(campaignId) {
        try {
          const messages = await this.getCampaignMessages(campaignId);
          const sent = messages.filter((m) => m.status === "sent" || m.status === "delivered" || m.status === "read").length;
          const delivered = messages.filter((m) => m.status === "delivered" || m.status === "read").length;
          const read = messages.filter((m) => m.status === "read").length;
          const failed = messages.filter((m) => m.status === "failed").length;
          const deliveryRate = sent > 0 ? Math.round(delivered / sent * 100) : 0;
          const readRate = delivered > 0 ? Math.round(read / delivered * 100) : 0;
          return { sent, delivered, read, failed, deliveryRate, readRate };
        } catch (error) {
          console.error("Error fetching campaign analytics:", error);
          return { sent: 0, delivered: 0, read: 0, failed: 0, deliveryRate: 0, readRate: 0 };
        }
      }
      // Message template operations
      async getMessageTemplates(category) {
        try {
          let query = db.select().from(messageTemplates).where(eq(messageTemplates.isActive, true));
          if (category) {
            query = query.where(eq(messageTemplates.category, category));
          }
          return await query.orderBy(messageTemplates.createdAt);
        } catch (error) {
          console.error("Error fetching message templates:", error);
          return [];
        }
      }
      async getMessageTemplate(id) {
        try {
          const [template] = await db.select().from(messageTemplates).where(eq(messageTemplates.id, id));
          return template;
        } catch (error) {
          console.error("Error fetching message template:", error);
          return void 0;
        }
      }
      async createMessageTemplate(templateData) {
        const [template] = await db.insert(messageTemplates).values(templateData).returning();
        return template;
      }
      async updateMessageTemplate(id, updates) {
        try {
          const [template] = await db.update(messageTemplates).set({ ...updates, updatedAt: /* @__PURE__ */ new Date() }).where(eq(messageTemplates.id, id)).returning();
          return template;
        } catch (error) {
          console.error("Error updating message template:", error);
          return void 0;
        }
      }
      async deleteMessageTemplate(id) {
        try {
          await db.delete(messageTemplates).where(eq(messageTemplates.id, id));
          return true;
        } catch (error) {
          console.error("Error deleting message template:", error);
          return false;
        }
      }
      // Custom Reports methods
      async createCustomReport(report) {
        const [newReport] = await db.insert(customReports).values(report).returning();
        return newReport;
      }
      async getCustomReports(filters) {
        let query = db.select().from(customReports);
        if (filters?.category) {
          query = query.where(eq(customReports.category, filters.category));
        }
        if (filters?.createdBy) {
          query = query.where(eq(customReports.createdBy, filters.createdBy));
        }
        return await query.orderBy(desc(customReports.createdAt));
      }
      async getCustomReport(id) {
        const [report] = await db.select().from(customReports).where(eq(customReports.id, id));
        return report;
      }
      async updateCustomReport(id, updates) {
        const [report] = await db.update(customReports).set({ ...updates, updatedAt: /* @__PURE__ */ new Date() }).where(eq(customReports.id, id)).returning();
        return report;
      }
      async deleteCustomReport(id) {
        await db.delete(customReports).where(eq(customReports.id, id));
      }
      // Report Executions methods
      async createReportExecution(execution) {
        const [newExecution] = await db.insert(reportExecutions).values(execution).returning();
        return newExecution;
      }
      async getReportExecutions(reportId) {
        let query = db.select().from(reportExecutions);
        if (reportId) {
          query = query.where(eq(reportExecutions.reportId, reportId));
        }
        return await query.orderBy(desc(reportExecutions.executedAt));
      }
      async getReportExecution(id) {
        const [execution] = await db.select().from(reportExecutions).where(eq(reportExecutions.id, id));
        return execution;
      }
      async updateReportExecution(id, updates) {
        const [execution] = await db.update(reportExecutions).set(updates).where(eq(reportExecutions.id, id)).returning();
        return execution;
      }
      // Saved Queries methods
      async createSavedQuery(query) {
        const [newQuery] = await db.insert(savedQueries).values(query).returning();
        return newQuery;
      }
      async getSavedQueries(createdBy) {
        let query = db.select().from(savedQueries);
        if (createdBy) {
          query = query.where(eq(savedQueries.createdBy, createdBy));
        }
        return await query.orderBy(desc(savedQueries.createdAt));
      }
      async getSavedQuery(id) {
        const [query] = await db.select().from(savedQueries).where(eq(savedQueries.id, id));
        return query;
      }
      async updateSavedQuery(id, updates) {
        const [query] = await db.update(savedQueries).set({ ...updates, updatedAt: /* @__PURE__ */ new Date() }).where(eq(savedQueries.id, id)).returning();
        return query;
      }
      async deleteSavedQuery(id) {
        await db.delete(savedQueries).where(eq(savedQueries.id, id));
      }
      // Badge operations
      async getBadges() {
        return await db.select().from(badges).orderBy(asc(badges.name));
      }
      async getBadge(id) {
        const [badge] = await db.select().from(badges).where(eq(badges.id, id));
        return badge;
      }
      async getBadgeByName(name) {
        const [badge] = await db.select().from(badges).where(eq(badges.name, name));
        return badge;
      }
      async createBadge(badgeData) {
        const [badge] = await db.insert(badges).values(badgeData).returning();
        return badge;
      }
      async updateBadge(id, updates) {
        const [badge] = await db.update(badges).set({ ...updates, updatedAt: /* @__PURE__ */ new Date() }).where(eq(badges.id, id)).returning();
        return badge;
      }
      async deleteBadge(id) {
        const result = await db.delete(badges).where(eq(badges.id, id));
        return result.rowCount > 0;
      }
      // Student badge operations
      async getStudentBadges(studentId) {
        return await db.select().from(studentBadges).where(eq(studentBadges.studentId, studentId));
      }
      async createStudentBadge(studentBadgeData) {
        const [studentBadge] = await db.insert(studentBadges).values(studentBadgeData).returning();
        return studentBadge;
      }
      async updateStudentBadge(id, updates) {
        const [studentBadge] = await db.update(studentBadges).set(updates).where(eq(studentBadges.id, id)).returning();
        return studentBadge;
      }
      // Student points operations
      async getStudentPoints(studentId) {
        const [points] = await db.select().from(studentPoints).where(eq(studentPoints.studentId, studentId));
        return points;
      }
      async createStudentPoints(studentPointsData) {
        const [points] = await db.insert(studentPoints).values(studentPointsData).returning();
        return points;
      }
      async addStudentPoints(studentId, points) {
        const existingPoints = await this.getStudentPoints(studentId);
        if (existingPoints) {
          await db.update(studentPoints).set({
            totalPoints: existingPoints.totalPoints + points,
            experiencePoints: existingPoints.experiencePoints + points,
            lastUpdated: /* @__PURE__ */ new Date()
          }).where(eq(studentPoints.studentId, studentId));
        } else {
          await this.createStudentPoints({
            studentId,
            totalPoints: points,
            experiencePoints: points,
            monthlyPoints: points,
            level: 1
          });
        }
      }
      async updateStudentLevel(studentId, level) {
        await db.update(studentPoints).set({ level, lastUpdated: /* @__PURE__ */ new Date() }).where(eq(studentPoints.studentId, studentId));
      }
      async getStudentAttendanceCount(studentId) {
        const [result] = await db.select({ count: count() }).from(attendance).where(and(
          eq(attendance.studentId, studentId),
          eq(attendance.status, "present")
        ));
        return result.count || 0;
      }
      async getStudentPayments(studentId) {
        return await db.select().from(payments).where(eq(payments.studentId, studentId)).orderBy(desc(payments.dueDate));
      }
      async getStudentPerformanceHistory(studentId) {
        return [];
      }
      // Achievement history operations
      async createAchievementHistory(achievementData) {
        const [achievement] = await db.insert(achievementHistory).values(achievementData).returning();
        return achievement;
      }
      async getAchievementHistory(studentId) {
        return await db.select().from(achievementHistory).where(eq(achievementHistory.studentId, studentId)).orderBy(desc(achievementHistory.createdAt));
      }
    };
    storage = new DatabaseStorage();
  }
});

// server/report-generator.ts
var report_generator_exports = {};
__export(report_generator_exports, {
  ReportGenerator: () => ReportGenerator,
  reportGenerator: () => reportGenerator
});
import { eq as eq2, and as and2, gte as gte2, lte as lte2, like as like2, desc as desc2, asc as asc2, sql as sql2, inArray } from "drizzle-orm";
import * as XLSX from "xlsx";
var ReportGenerator, reportGenerator;
var init_report_generator = __esm({
  "server/report-generator.ts"() {
    "use strict";
    init_db();
    init_schema();
    ReportGenerator = class _ReportGenerator {
      static instance;
      tableMap = {
        students,
        payments,
        attendance,
        sports,
        batches,
        coaches
      };
      static getInstance() {
        if (!_ReportGenerator.instance) {
          _ReportGenerator.instance = new _ReportGenerator();
        }
        return _ReportGenerator.instance;
      }
      async executeQuery(config) {
        try {
          const baseTable = this.tableMap[config.tables[0]];
          let query = db.select().from(baseTable);
          if (config.joins) {
            for (const join of config.joins) {
              const joinTable = this.tableMap[join.table];
              if (join.type === "left") {
                query = query.leftJoin(joinTable, sql2.raw(join.on));
              } else if (join.type === "inner") {
                query = query.innerJoin(joinTable, sql2.raw(join.on));
              }
            }
          }
          if (config.filters && config.filters.length > 0) {
            const conditions = config.filters.map((filter) => {
              const [table, field] = filter.field.split(".");
              const tableRef = this.tableMap[table];
              const column = tableRef[field];
              switch (filter.operator) {
                case "eq":
                  return eq2(column, filter.value);
                case "ne":
                  return sql2`${column} != ${filter.value}`;
                case "gt":
                  return sql2`${column} > ${filter.value}`;
                case "gte":
                  return gte2(column, filter.value);
                case "lt":
                  return sql2`${column} < ${filter.value}`;
                case "lte":
                  return lte2(column, filter.value);
                case "like":
                  return like2(column, `%${filter.value}%`);
                case "in":
                  return inArray(column, filter.value);
                case "between":
                  return and2(gte2(column, filter.value[0]), lte2(column, filter.value[1]));
                default:
                  return eq2(column, filter.value);
              }
            });
            query = query.where(and2(...conditions));
          }
          if (config.groupBy && config.groupBy.length > 0) {
            const groupColumns = config.groupBy.map((field) => {
              const [table, column] = field.split(".");
              return this.tableMap[table][column];
            });
            query = query.groupBy(...groupColumns);
          }
          if (config.orderBy && config.orderBy.length > 0) {
            const orderColumns = config.orderBy.map((order) => {
              const [table, column] = order.field.split(".");
              const col = this.tableMap[table][column];
              return order.direction === "desc" ? desc2(col) : asc2(col);
            });
            query = query.orderBy(...orderColumns);
          }
          if (config.limit) {
            query = query.limit(config.limit);
          }
          return await query;
        } catch (error) {
          console.error("Error executing query:", error);
          throw error;
        }
      }
      async generateReport(reportId, executedBy) {
        try {
          const [report] = await db.select().from(customReports).where(eq2(customReports.id, reportId));
          if (!report) {
            throw new Error("Report not found");
          }
          const [execution] = await db.insert(reportExecutions).values({
            reportId,
            status: "running",
            executedBy,
            metadata: { startTime: (/* @__PURE__ */ new Date()).toISOString() }
          }).returning();
          try {
            const queryConfig = report.queryConfig;
            const results = await this.executeQuery(queryConfig);
            const reportData = {
              data: results,
              metadata: {
                generatedAt: (/* @__PURE__ */ new Date()).toISOString(),
                recordCount: results.length,
                queryConfig,
                chartConfig: report.chartConfig
              }
            };
            const [updatedExecution] = await db.update(reportExecutions).set({
              status: "completed",
              result: reportData,
              completedAt: /* @__PURE__ */ new Date(),
              metadata: {
                ...execution.metadata,
                endTime: (/* @__PURE__ */ new Date()).toISOString(),
                recordCount: results.length
              }
            }).where(eq2(reportExecutions.id, execution.id)).returning();
            return updatedExecution;
          } catch (error) {
            await db.update(reportExecutions).set({
              status: "failed",
              errorMessage: error.message,
              completedAt: /* @__PURE__ */ new Date()
            }).where(eq2(reportExecutions.id, execution.id));
            throw error;
          }
        } catch (error) {
          console.error("Error generating report:", error);
          throw error;
        }
      }
      async exportToExcel(data, filename) {
        try {
          const workbook = XLSX.utils.book_new();
          const worksheet = XLSX.utils.json_to_sheet(data);
          XLSX.utils.book_append_sheet(workbook, worksheet, "Report Data");
          const filepath = `reports/${filename}_${Date.now()}.xlsx`;
          XLSX.writeFile(workbook, filepath);
          return filepath;
        } catch (error) {
          console.error("Error exporting to Excel:", error);
          throw error;
        }
      }
      async scheduleReport(reportId) {
        try {
          const [report] = await db.select().from(customReports).where(eq2(customReports.id, reportId));
          if (!report || !report.scheduleConfig) {
            throw new Error("Report or schedule configuration not found");
          }
          const scheduleConfig = report.scheduleConfig;
          console.log(`Scheduling report ${reportId} with config:`, scheduleConfig);
          await db.update(customReports).set({ lastRunAt: /* @__PURE__ */ new Date() }).where(eq2(customReports.id, reportId));
        } catch (error) {
          console.error("Error scheduling report:", error);
          throw error;
        }
      }
      // Predefined report templates
      getPredefinedReports() {
        return {
          studentEnrollment: {
            name: "Student Enrollment Report",
            category: "students",
            queryConfig: {
              tables: ["students", "sports", "batches"],
              fields: [
                { table: "students", field: "name", alias: "Student Name" },
                { table: "students", field: "email", alias: "Email" },
                { table: "students", field: "phone", alias: "Phone" },
                { table: "sports", field: "name", alias: "Sport" },
                { table: "batches", field: "name", alias: "Batch" },
                { table: "students", field: "createdAt", alias: "Enrollment Date" }
              ],
              joins: [
                { table: "sports", on: "students.sport_id = sports.id", type: "left" },
                { table: "batches", on: "students.batch_id = batches.id", type: "left" }
              ],
              orderBy: [{ field: "students.createdAt", direction: "desc" }]
            },
            chartConfig: {
              type: "line",
              xAxis: "Enrollment Date",
              yAxis: "Student Count",
              title: "Student Enrollment Trend"
            }
          },
          paymentSummary: {
            name: "Payment Summary Report",
            category: "payments",
            queryConfig: {
              tables: ["payments", "students", "sports"],
              fields: [
                { table: "students", field: "name", alias: "Student Name" },
                { table: "sports", field: "name", alias: "Sport" },
                { table: "payments", field: "amount", alias: "Amount" },
                { table: "payments", field: "paymentMethod", alias: "Payment Method" },
                { table: "payments", field: "status", alias: "Status" },
                { table: "payments", field: "createdAt", alias: "Payment Date" }
              ],
              joins: [
                { table: "students", on: "payments.student_id = students.id", type: "left" },
                { table: "sports", on: "students.sport_id = sports.id", type: "left" }
              ],
              orderBy: [{ field: "payments.createdAt", direction: "desc" }]
            },
            chartConfig: {
              type: "bar",
              xAxis: "Payment Method",
              yAxis: "Total Amount",
              title: "Payment Methods Distribution"
            }
          },
          attendanceReport: {
            name: "Attendance Report",
            category: "attendance",
            queryConfig: {
              tables: ["attendance", "students", "batches", "sports"],
              fields: [
                { table: "students", field: "name", alias: "Student Name" },
                { table: "sports", field: "name", alias: "Sport" },
                { table: "batches", field: "name", alias: "Batch" },
                { table: "attendance", field: "status", alias: "Status" },
                { table: "attendance", field: "date", alias: "Date" }
              ],
              joins: [
                { table: "students", on: "attendance.student_id = students.id", type: "left" },
                { table: "batches", on: "attendance.batch_id = batches.id", type: "left" },
                { table: "sports", on: "students.sport_id = sports.id", type: "left" }
              ],
              orderBy: [{ field: "attendance.date", direction: "desc" }]
            },
            chartConfig: {
              type: "pie",
              title: "Attendance Distribution"
            }
          },
          revenueAnalysis: {
            name: "Revenue Analysis Report",
            category: "financial",
            queryConfig: {
              tables: ["payments", "sports"],
              fields: [
                { table: "sports", field: "name", alias: "Sport" },
                { table: "payments", field: "amount", aggregate: "sum", alias: "Total Revenue" },
                { table: "payments", field: "id", aggregate: "count", alias: "Payment Count" }
              ],
              joins: [
                { table: "students", on: "payments.student_id = students.id", type: "left" },
                { table: "sports", on: "students.sport_id = sports.id", type: "left" }
              ],
              filters: [
                { field: "payments.status", operator: "eq", value: "completed" }
              ],
              groupBy: ["sports.name"],
              orderBy: [{ field: "payments.amount", direction: "desc" }]
            },
            chartConfig: {
              type: "bar",
              xAxis: "Sport",
              yAxis: "Total Revenue",
              title: "Revenue by Sport"
            }
          }
        };
      }
    };
    reportGenerator = ReportGenerator.getInstance();
  }
});

// server/gamification.ts
var gamification_exports = {};
__export(gamification_exports, {
  GamificationService: () => GamificationService,
  gamificationService: () => gamificationService
});
var GamificationService, gamificationService;
var init_gamification = __esm({
  "server/gamification.ts"() {
    "use strict";
    init_storage();
    GamificationService = class _GamificationService {
      static instance;
      static getInstance() {
        if (!_GamificationService.instance) {
          _GamificationService.instance = new _GamificationService();
        }
        return _GamificationService.instance;
      }
      async initializeDefaultBadges() {
        const defaultBadges = [
          // Attendance Badges
          {
            name: "Perfect Attendance",
            description: "Attend all classes for 30 consecutive days",
            icon: "trophy",
            color: "gold",
            category: "attendance",
            requirements: {
              type: "attendance",
              operator: "streak",
              value: 30,
              timeframe: "daily"
            },
            points: 500,
            rarity: "legendary"
          },
          {
            name: "Early Bird",
            description: "Be punctual for 10 consecutive classes",
            icon: "clock",
            color: "blue",
            category: "attendance",
            requirements: {
              type: "attendance",
              operator: "streak",
              value: 10,
              timeframe: "daily"
            },
            points: 200,
            rarity: "epic"
          },
          {
            name: "Attendance Champion",
            description: "Achieve 95% attendance this month",
            icon: "star",
            color: "green",
            category: "attendance",
            requirements: {
              type: "attendance",
              operator: "greater",
              value: 95,
              timeframe: "monthly"
            },
            points: 300,
            rarity: "rare"
          },
          // Payment Badges
          {
            name: "Prompt Payer",
            description: "Pay fees on time for 6 consecutive months",
            icon: "credit-card",
            color: "emerald",
            category: "payment",
            requirements: {
              type: "payment",
              operator: "streak",
              value: 6,
              timeframe: "monthly"
            },
            points: 400,
            rarity: "epic"
          },
          {
            name: "Financial Responsibility",
            description: "Never miss a payment deadline",
            icon: "wallet",
            color: "purple",
            category: "payment",
            requirements: {
              type: "payment",
              operator: "equals",
              value: 0,
              timeframe: "all_time"
            },
            points: 600,
            rarity: "legendary"
          },
          // Performance Badges
          {
            name: "Skill Master",
            description: "Achieve advanced skill level in your sport",
            icon: "award",
            color: "orange",
            category: "performance",
            requirements: {
              type: "performance",
              operator: "equals",
              value: 5,
              timeframe: "all_time"
            },
            points: 750,
            rarity: "legendary"
          },
          {
            name: "Rising Star",
            description: "Show consistent improvement over 3 months",
            icon: "trending-up",
            color: "yellow",
            category: "performance",
            requirements: {
              type: "performance",
              operator: "greater",
              value: 3,
              timeframe: "monthly"
            },
            points: 250,
            rarity: "rare"
          },
          // Milestone Badges
          {
            name: "Loyal Student",
            description: "Complete 1 year of training",
            icon: "heart",
            color: "red",
            category: "milestone",
            requirements: {
              type: "milestone",
              operator: "greater",
              value: 365,
              timeframe: "all_time"
            },
            points: 1e3,
            rarity: "legendary"
          },
          {
            name: "Dedicated Learner",
            description: "Complete 100 training sessions",
            icon: "book",
            color: "indigo",
            category: "milestone",
            requirements: {
              type: "milestone",
              operator: "greater",
              value: 100,
              timeframe: "all_time"
            },
            points: 500,
            rarity: "epic"
          },
          {
            name: "Newcomer",
            description: "Complete your first week of training",
            icon: "user-plus",
            color: "cyan",
            category: "milestone",
            requirements: {
              type: "milestone",
              operator: "greater",
              value: 7,
              timeframe: "all_time"
            },
            points: 50,
            rarity: "common"
          }
        ];
        for (const badgeData of defaultBadges) {
          try {
            const existingBadge = await storage.getBadgeByName(badgeData.name);
            if (!existingBadge) {
              await storage.createBadge(badgeData);
            }
          } catch (error) {
            console.error(`Error creating badge ${badgeData.name}:`, error);
          }
        }
      }
      async processGamificationEvent(event) {
        const { studentId, eventType, data } = event;
        await this.checkBadgeEligibility(studentId, eventType, data);
        await this.awardPoints(studentId, eventType, data);
        await this.updateStudentLevel(studentId);
      }
      async checkBadgeEligibility(studentId, eventType, data) {
        const allBadges = await storage.getBadges();
        const earnedBadges = await storage.getStudentBadges(studentId);
        const earnedBadgeIds = earnedBadges.map((eb) => eb.badgeId);
        for (const badge of allBadges) {
          if (earnedBadgeIds.includes(badge.id) || !badge.isActive) continue;
          const isEligible = await this.evaluateBadgeCondition(studentId, badge, eventType, data);
          if (isEligible) {
            await this.awardBadge(studentId, badge);
          }
        }
      }
      async evaluateBadgeCondition(studentId, badge, eventType, data) {
        const criteria = badge.requirements;
        switch (criteria.type) {
          case "attendance":
            return await this.evaluateAttendanceCriteria(studentId, criteria);
          case "payment":
            return await this.evaluatePaymentCriteria(studentId, criteria);
          case "performance":
            return await this.evaluatePerformanceCriteria(studentId, criteria);
          case "milestone":
            return await this.evaluateMilestoneCriteria(studentId, criteria);
          default:
            return false;
        }
      }
      async evaluateAttendanceCriteria(studentId, requirements) {
        const attendanceData = await storage.getStudentAttendance(studentId);
        if (requirements.operator === "streak") {
          const streak = this.calculateAttendanceStreak(attendanceData);
          return streak >= requirements.value;
        } else if (requirements.operator === "greater") {
          const percentage = this.calculateAttendancePercentage(attendanceData, requirements.timeframe);
          return percentage >= requirements.value;
        }
        return false;
      }
      async evaluatePaymentCriteria(studentId, requirements) {
        const paymentData = await storage.getStudentPayments(studentId);
        if (requirements.operator === "streak") {
          const streak = this.calculatePaymentStreak(paymentData);
          return streak >= requirements.value;
        } else if (requirements.operator === "equals" && requirements.value === 0) {
          const missedPayments = paymentData.filter((p) => p.status === "overdue").length;
          return missedPayments === 0;
        }
        return false;
      }
      async evaluatePerformanceCriteria(studentId, requirements) {
        const student = await storage.getStudent(studentId);
        if (requirements.operator === "equals") {
          return student?.skillLevel >= requirements.value;
        } else if (requirements.operator === "greater") {
          const performanceHistory = await storage.getStudentPerformanceHistory(studentId);
          return this.calculatePerformanceImprovement(performanceHistory, requirements.timeframe) >= requirements.value;
        }
        return false;
      }
      async evaluateMilestoneCriteria(studentId, requirements) {
        const student = await storage.getStudent(studentId);
        if (requirements.operator === "greater") {
          if (requirements.value === 365) {
            const daysSinceJoining = Math.floor(((/* @__PURE__ */ new Date()).getTime() - new Date(student.joiningDate).getTime()) / (1e3 * 60 * 60 * 24));
            return daysSinceJoining >= requirements.value;
          } else if (requirements.value === 100) {
            const attendanceCount = await storage.getStudentAttendanceCount(studentId);
            return attendanceCount >= requirements.value;
          } else if (requirements.value === 7) {
            const daysSinceJoining = Math.floor(((/* @__PURE__ */ new Date()).getTime() - new Date(student.joiningDate).getTime()) / (1e3 * 60 * 60 * 24));
            return daysSinceJoining >= requirements.value;
          }
        }
        return false;
      }
      async awardBadge(studentId, badge) {
        await storage.createStudentBadge({
          studentId,
          badgeId: badge.id,
          earnedAt: /* @__PURE__ */ new Date(),
          progress: {},
          isDisplayed: true
        });
        await storage.addStudentPoints(studentId, badge.points);
        await storage.createAchievementHistory({
          studentId,
          action: "badge_earned",
          description: `Earned badge: ${badge.name}`,
          points: badge.points,
          metadata: { badgeId: badge.id, badgeName: badge.name }
        });
      }
      async awardPoints(studentId, eventType, data) {
        let points = 0;
        switch (eventType) {
          case "attendance_marked":
            points = 10;
            break;
          case "payment_made":
            points = 20;
            break;
          case "milestone_reached":
            points = data.points || 50;
            break;
          default:
            points = 5;
        }
        await storage.addStudentPoints(studentId, points);
        await storage.createAchievementHistory({
          studentId,
          action: "points_awarded",
          description: `Earned ${points} points for ${eventType}`,
          points,
          metadata: { eventType, data }
        });
      }
      async updateStudentLevel(studentId) {
        const studentPoints2 = await storage.getStudentPoints(studentId);
        if (studentPoints2) {
          const newLevel = Math.floor(studentPoints2.experiencePoints / 1e3) + 1;
          if (newLevel > studentPoints2.level) {
            await storage.updateStudentLevel(studentId, newLevel);
            await storage.createAchievementHistory({
              studentId,
              action: "level_up",
              description: `Reached level ${newLevel}`,
              points: newLevel * 100,
              metadata: { oldLevel: studentPoints2.level, newLevel }
            });
          }
        }
      }
      calculateAttendanceStreak(attendanceData) {
        let streak = 0;
        let currentStreak = 0;
        const sortedData = attendanceData.sort((a, b) => new Date(b.date).getTime() - new Date(a.date).getTime());
        for (const record of sortedData) {
          if (record.status === "present") {
            currentStreak++;
            streak = Math.max(streak, currentStreak);
          } else {
            currentStreak = 0;
          }
        }
        return streak;
      }
      calculateAttendancePercentage(attendanceData, timeframe) {
        const now = /* @__PURE__ */ new Date();
        let startDate = /* @__PURE__ */ new Date();
        if (timeframe === "monthly") {
          startDate = new Date(now.getFullYear(), now.getMonth(), 1);
        } else if (timeframe === "weekly") {
          startDate = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1e3);
        }
        const filteredData = attendanceData.filter((record) => new Date(record.date) >= startDate);
        const totalClasses = filteredData.length;
        const presentClasses = filteredData.filter((record) => record.status === "present").length;
        return totalClasses > 0 ? Math.round(presentClasses / totalClasses * 100) : 0;
      }
      calculatePaymentStreak(paymentData) {
        let streak = 0;
        const sortedData = paymentData.sort((a, b) => new Date(b.dueDate).getTime() - new Date(a.dueDate).getTime());
        for (const payment of sortedData) {
          if (payment.status === "completed" && new Date(payment.paidDate) <= new Date(payment.dueDate)) {
            streak++;
          } else {
            break;
          }
        }
        return streak;
      }
      calculatePerformanceImprovement(performanceHistory, timeframe) {
        return Math.floor(Math.random() * 5) + 1;
      }
      // Public methods for external use
      async triggerAttendanceEvent(studentId, attendanceData) {
        await this.processGamificationEvent({
          studentId,
          eventType: "attendance_marked",
          data: attendanceData,
          timestamp: /* @__PURE__ */ new Date()
        });
      }
      async triggerPaymentEvent(studentId, paymentData) {
        await this.processGamificationEvent({
          studentId,
          eventType: "payment_made",
          data: paymentData,
          timestamp: /* @__PURE__ */ new Date()
        });
      }
      async triggerMilestoneEvent(studentId, milestoneData) {
        await this.processGamificationEvent({
          studentId,
          eventType: "milestone_reached",
          data: milestoneData,
          timestamp: /* @__PURE__ */ new Date()
        });
      }
    };
    gamificationService = GamificationService.getInstance();
  }
});

// server/ai-insights.ts
var ai_insights_exports = {};
__export(ai_insights_exports, {
  generateAIResponse: () => generateAIResponse,
  generateAttendanceInsights: () => generateAttendanceInsights,
  generateRetentionForecast: () => generateRetentionForecast,
  generateRevenueAnalysis: () => generateRevenueAnalysis,
  generateStudentInsights: () => generateStudentInsights
});
import { GoogleGenAI } from "@google/genai";
async function generateStudentInsights() {
  try {
    const students2 = await storage.getStudents();
    const payments2 = await storage.getPayments();
    const attendance2 = await storage.getAttendanceStats();
    const dashboardStats = await storage.getDashboardStats();
    const prompt = `
    Analyze this sports academy data and provide actionable insights:

    Student Data:
    - Total Students: ${dashboardStats.totalStudents}
    - Active Students: ${dashboardStats.activeStudents}
    - Sports Distribution: ${JSON.stringify(dashboardStats.sportsDistribution)}

    Financial Data:
    - Total Revenue: ${dashboardStats.totalRevenue}
    - Pending Fees: ${dashboardStats.pendingFees}
    - Payment Stats: ${JSON.stringify(payments2)}

    Attendance Data:
    - Today's Attendance: ${dashboardStats.todayAttendance}
    - Overall Stats: ${JSON.stringify(attendance2)}

    Please provide:
    1. Key performance indicators
    2. Areas of concern
    3. Recommendations for improvement
    4. Growth opportunities
    5. Student engagement insights

    Format as JSON with sections: kpis, concerns, recommendations, opportunities, engagement
    `;
    const response = await ai.models.generateContent({
      model: "gemini-2.5-flash",
      contents: prompt
    });
    let cleanedResponse = response.text || "{}";
    cleanedResponse = cleanedResponse.replace(/```json\s*/, "").replace(/```\s*$/, "");
    return JSON.parse(cleanedResponse);
  } catch (error) {
    console.error("AI Insights Error:", error);
    throw new Error("Failed to generate AI insights");
  }
}
async function generateRevenueAnalysis() {
  try {
    const revenueStats = await storage.getRevenueStats();
    const monthlyRevenue = await storage.getMonthlyRevenueReport((/* @__PURE__ */ new Date()).getFullYear());
    const prompt = `
    Analyze this revenue data and provide insights:

    Revenue Stats:
    - Total Revenue: ${revenueStats.total}
    - This Month: ${revenueStats.thisMonth}
    - Last Month: ${revenueStats.lastMonth}
    - Growth: ${revenueStats.growth}%

    Monthly Data: ${JSON.stringify(monthlyRevenue)}

    Provide analysis on:
    1. Revenue trends
    2. Seasonal patterns
    3. Growth predictions
    4. Optimization strategies

    Format as JSON with sections: trends, patterns, predictions, strategies
    `;
    const response = await ai.models.generateContent({
      model: "gemini-2.5-flash",
      contents: prompt
    });
    let cleanedResponse = response.text || "{}";
    cleanedResponse = cleanedResponse.replace(/```json\s*/, "").replace(/```\s*$/, "");
    return JSON.parse(cleanedResponse);
  } catch (error) {
    console.error("Revenue Analysis Error:", error);
    throw new Error("Failed to generate revenue analysis");
  }
}
async function generateAttendanceInsights() {
  try {
    const attendance2 = await storage.getAttendanceStats();
    const recentAttendance = await storage.getAttendanceByDate((/* @__PURE__ */ new Date()).toISOString().split("T")[0]);
    const prompt = `
    Analyze attendance data:

    Overall Stats:
    - Total: ${attendance2.total}
    - Present: ${attendance2.present}
    - Absent: ${attendance2.absent}
    - Percentage: ${attendance2.percentage}%

    Recent Attendance: ${JSON.stringify(recentAttendance)}

    Provide insights on:
    1. Attendance patterns
    2. Concerning trends
    3. Improvement suggestions
    4. Student engagement levels

    Format as JSON with sections: patterns, concerns, suggestions, engagement
    `;
    const response = await ai.models.generateContent({
      model: "gemini-2.5-flash",
      contents: prompt
    });
    let cleanedResponse = response.text || "{}";
    cleanedResponse = cleanedResponse.replace(/```json\s*/, "").replace(/```\s*$/, "");
    return JSON.parse(cleanedResponse);
  } catch (error) {
    console.error("Attendance Analysis Error:", error);
    throw new Error("Failed to generate attendance insights");
  }
}
async function generateRetentionForecast() {
  try {
    const studentsData = await storage.getStudents();
    const paymentsData = await storage.getPayments();
    const attendance2 = await storage.getAttendanceStats();
    const dashboardStats = await storage.getDashboardStats();
    const students2 = Array.isArray(studentsData) ? studentsData : studentsData?.students || [];
    const payments2 = Array.isArray(paymentsData) ? paymentsData : paymentsData?.payments || [];
    const retentionMetrics = calculateRetentionMetrics(students2, payments2, attendance2);
    const prompt = `
    Analyze this sports academy data to predict student retention and provide forecasting insights:

    Student Data:
    - Total Students: ${dashboardStats.totalStudents}
    - Active Students: ${dashboardStats.activeStudents}
    - Student Cohorts: ${JSON.stringify(retentionMetrics.cohorts)}
    - Dropout Patterns: ${JSON.stringify(retentionMetrics.dropoutPatterns)}

    Payment Data:
    - Payment Regularity: ${JSON.stringify(retentionMetrics.paymentPatterns)}
    - Pending Fees: ${dashboardStats.pendingFees}
    - Payment Defaults: ${JSON.stringify(retentionMetrics.paymentDefaults)}

    Attendance Data:
    - Attendance Rates: ${JSON.stringify(retentionMetrics.attendanceRates)}
    - Attendance Trends: ${JSON.stringify(retentionMetrics.attendanceTrends)}

    Please provide a comprehensive retention forecast including:
    1. Overall retention rate prediction for next 3 months
    2. High-risk students identification (criteria and list)
    3. Retention factors (positive and negative)
    4. Early warning indicators
    5. Intervention strategies
    6. Seasonal trends impact
    7. Sport-specific retention patterns
    8. Action plan for improvement

    Format as JSON with sections: 
    {
      "overallForecast": {
        "currentRetentionRate": number,
        "predictedRetentionRate": number,
        "confidenceScore": number,
        "timeframe": "3 months"
      },
      "highRiskStudents": {
        "count": number,
        "criteria": ["criteria1", "criteria2"],
        "riskFactors": ["factor1", "factor2"]
      },
      "retentionFactors": {
        "positive": ["factor1", "factor2"],
        "negative": ["factor1", "factor2"]
      },
      "warningIndicators": ["indicator1", "indicator2"],
      "interventionStrategies": ["strategy1", "strategy2"],
      "seasonalTrends": ["trend1", "trend2"],
      "sportSpecificPatterns": {"sport1": "pattern", "sport2": "pattern"},
      "actionPlan": ["action1", "action2"]
    }
    `;
    const response = await ai.models.generateContent({
      model: "gemini-2.5-pro",
      config: {
        responseMimeType: "application/json",
        responseSchema: {
          type: "object",
          properties: {
            overallForecast: {
              type: "object",
              properties: {
                currentRetentionRate: { type: "number" },
                predictedRetentionRate: { type: "number" },
                confidenceScore: { type: "number" },
                timeframe: { type: "string" }
              }
            },
            highRiskStudents: {
              type: "object",
              properties: {
                count: { type: "number" },
                criteria: { type: "array", items: { type: "string" } },
                riskFactors: { type: "array", items: { type: "string" } }
              }
            },
            retentionFactors: {
              type: "object",
              properties: {
                positive: { type: "array", items: { type: "string" } },
                negative: { type: "array", items: { type: "string" } }
              }
            },
            warningIndicators: { type: "array", items: { type: "string" } },
            interventionStrategies: { type: "array", items: { type: "string" } },
            seasonalTrends: { type: "array", items: { type: "string" } },
            sportSpecificPatterns: { type: "object" },
            actionPlan: { type: "array", items: { type: "string" } }
          }
        }
      },
      contents: prompt
    });
    return JSON.parse(response.text || "{}");
  } catch (error) {
    console.error("Error generating retention forecast:", error);
    return {
      overallForecast: {
        currentRetentionRate: 0,
        predictedRetentionRate: 0,
        confidenceScore: 0,
        timeframe: "3 months"
      },
      highRiskStudents: {
        count: 0,
        criteria: ["Data analysis unavailable"],
        riskFactors: ["System connectivity issues"]
      },
      retentionFactors: {
        positive: ["Unable to analyze"],
        negative: ["Data processing error"]
      },
      warningIndicators: ["System monitoring required"],
      interventionStrategies: ["Contact support for assistance"],
      seasonalTrends: ["Analysis unavailable"],
      sportSpecificPatterns: {},
      actionPlan: ["Verify system connectivity"]
    };
  }
}
function calculateRetentionMetrics(students2, payments2, attendance2) {
  const now = /* @__PURE__ */ new Date();
  const sixMonthsAgo = new Date(now.getFullYear(), now.getMonth() - 6, now.getDate());
  const threeMonthsAgo = new Date(now.getFullYear(), now.getMonth() - 3, now.getDate());
  const cohorts = {
    recent: students2.filter((s) => new Date(s.joiningDate) >= threeMonthsAgo).length,
    midTerm: students2.filter((s) => {
      const joinDate = new Date(s.joiningDate);
      return joinDate >= sixMonthsAgo && joinDate < threeMonthsAgo;
    }).length,
    longTerm: students2.filter((s) => new Date(s.joiningDate) < sixMonthsAgo).length
  };
  const dropoutPatterns = {
    inactiveStudents: students2.filter((s) => !s.isActive).length,
    totalStudents: students2.length,
    dropoutRate: students2.length > 0 ? students2.filter((s) => !s.isActive).length / students2.length * 100 : 0
  };
  const paymentPatterns = {
    regularPayments: payments2.filter((p) => p.status === "completed").length,
    pendingPayments: payments2.filter((p) => p.status === "pending").length,
    failedPayments: payments2.filter((p) => p.status === "failed").length
  };
  const paymentDefaults = {
    overdueFees: payments2.filter((p) => p.status === "pending" && new Date(p.dueDate) < now).length,
    totalPayments: payments2.length
  };
  const attendanceRates = {
    overall: attendance2?.averageAttendance || 0,
    byMonth: attendance2?.monthlyStats || {},
    bySport: attendance2?.sportStats || {}
  };
  const attendanceTrends = {
    declining: attendance2?.decliningStudents || [],
    improving: attendance2?.improvingStudents || [],
    stable: attendance2?.stableStudents || []
  };
  return {
    cohorts,
    dropoutPatterns,
    paymentPatterns,
    paymentDefaults,
    attendanceRates,
    attendanceTrends
  };
}
async function generateAIResponse(query) {
  try {
    const [studentsData, paymentsData, attendanceData, revenueStats] = await Promise.allSettled([
      storage.getStudents(),
      storage.getPayments(),
      storage.getAttendanceStats().catch(() => ({ percentage: 0 })),
      storage.getRevenueStats().catch(() => ({ total: 0, thisMonth: 0, growth: 0 }))
    ]);
    const students2 = studentsData.status === "fulfilled" ? studentsData.value : null;
    const payments2 = paymentsData.status === "fulfilled" ? paymentsData.value : null;
    const attendance2 = attendanceData.status === "fulfilled" ? attendanceData.value : { percentage: 0 };
    const revenue = revenueStats.status === "fulfilled" ? revenueStats.value : { total: 0, thisMonth: 0, growth: 0 };
    const studentsCount = Array.isArray(students2) ? students2.length : students2?.students?.length || 0;
    const paymentsCount = Array.isArray(payments2) ? payments2.length : payments2?.payments?.length || 0;
    const prompt = `
    You are an AI assistant for Parmanand Sports Academy. Answer the following question based on the academy data:

    Query: ${query}

    Academy Data:
    - Students: ${studentsCount} total students
    - Revenue Stats: Total: \u20B9${revenue.total}, This Month: \u20B9${revenue.thisMonth}, Growth: ${revenue.growth}%
    - Attendance: ${attendance2.percentage}% average attendance
    - Recent Payments: ${paymentsCount} payment records

    Please provide a helpful, specific answer based on this data. Be conversational and actionable.
    Keep your response concise but informative.

    Format your response as JSON with:
    {
      "answer": "your detailed response here",
      "suggestions": ["actionable suggestion 1", "actionable suggestion 2"],
      "confidence": 85
    }
    `;
    const response = await ai.models.generateContent({
      model: "gemini-2.5-flash",
      contents: prompt
    });
    let cleanedResponse = response.text || '{"answer": "I apologize, but I encountered an issue processing your query. Please try again.", "suggestions": ["Check your question and try again", "Contact support if the issue persists"], "confidence": 50}';
    cleanedResponse = cleanedResponse.replace(/```json\s*/, "").replace(/```\s*$/, "");
    try {
      return JSON.parse(cleanedResponse);
    } catch (parseError) {
      return {
        answer: "I processed your query but had trouble formatting the response. Based on the academy data, we currently have " + studentsCount + " students with " + attendance2.percentage + "% average attendance and \u20B9" + revenue.total + " total revenue.",
        suggestions: ["Review student attendance trends", "Check payment collection status"],
        confidence: 70
      };
    }
  } catch (error) {
    console.error("AI Response Error:", error);
    return {
      answer: "I'm currently experiencing technical difficulties. Please check your API configuration and try again.",
      suggestions: ["Verify Google API key is properly set", "Contact administrator for assistance"],
      confidence: 0
    };
  }
}
var ai;
var init_ai_insights = __esm({
  "server/ai-insights.ts"() {
    "use strict";
    init_storage();
    if (!process.env.GEMINI_API_KEY) {
      throw new Error("GEMINI_API_KEY is required for AI Insights functionality");
    }
    ai = new GoogleGenAI({ apiKey: process.env.GEMINI_API_KEY });
  }
});

// server/notifications.ts
var notifications_exports = {};
__export(notifications_exports, {
  sendAttendanceAlert: () => sendAttendanceAlert,
  sendBulkNotification: () => sendBulkNotification,
  sendFeeReminder: () => sendFeeReminder,
  sendPaymentConfirmation: () => sendPaymentConfirmation,
  sendWhatsAppNotification: () => sendWhatsAppNotification
});
async function sendWhatsAppNotification(message) {
  try {
    const whatsappToken = await storage.getSetting("whatsapp_token");
    const phoneNumberId = await storage.getSetting("whatsapp_phone_number_id");
    if (!whatsappToken?.value || !phoneNumberId?.value) {
      throw new Error("WhatsApp API not configured. Please add your WhatsApp Business API credentials in Settings.");
    }
    const response = await fetch(`https://graph.facebook.com/v18.0/${phoneNumberId.value}/messages`, {
      method: "POST",
      headers: {
        "Authorization": `Bearer ${whatsappToken.value}`,
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        messaging_product: "whatsapp",
        to: message.to.replace(/[^0-9]/g, ""),
        // Remove non-numeric characters
        type: "text",
        text: {
          body: message.message
        }
      })
    });
    const result = await response.json();
    if (!response.ok) {
      throw new Error(`WhatsApp API error: ${result.error?.message || "Unknown error"}`);
    }
    await storage.createCommunication({
      type: "whatsapp",
      recipient: message.to,
      subject: getSubjectByType(message.type),
      content: message.message,
      status: "sent",
      sentAt: /* @__PURE__ */ new Date(),
      metadata: {
        messageType: message.type,
        messageId: result.messages?.[0]?.id || `wa_${Date.now()}`
      }
    });
    console.log(`WhatsApp message sent to ${message.to}: ${message.message}`);
    return { success: true, messageId: result.messages?.[0]?.id || `wa_${Date.now()}` };
  } catch (error) {
    console.error("WhatsApp notification error:", error);
    await storage.createCommunication({
      type: "whatsapp",
      recipient: message.to,
      subject: getSubjectByType(message.type),
      content: message.message,
      status: "failed",
      sentAt: /* @__PURE__ */ new Date(),
      metadata: {
        messageType: message.type,
        error: error.message
      }
    });
    throw new Error(`Failed to send WhatsApp notification: ${error.message}`);
  }
}
function getSubjectByType(type) {
  switch (type) {
    case "fee_reminder":
      return "Fee Payment Reminder";
    case "payment_received":
      return "Payment Confirmation";
    case "attendance_alert":
      return "Attendance Alert";
    default:
      return "Academy Notification";
  }
}
async function sendFeeReminder(studentId, amount, dueDate) {
  try {
    const student = await storage.getStudent(studentId);
    if (!student?.phone) {
      throw new Error("Student phone number not found");
    }
    const message = `
Hi ${student.name},

This is a friendly reminder that your monthly fee payment of \u20B9${amount} is due on ${dueDate}.

Please pay at your earliest convenience to avoid any service interruption.

Thank you!
Parmanand Sports Academy
    `.trim();
    return await sendWhatsAppNotification({
      to: student.phone,
      message,
      type: "fee_reminder"
    });
  } catch (error) {
    console.error("Fee reminder error:", error);
    throw new Error("Failed to send fee reminder");
  }
}
async function sendPaymentConfirmation(studentId, amount, paymentMethod) {
  try {
    const student = await storage.getStudent(studentId);
    if (!student?.phone) {
      throw new Error("Student phone number not found");
    }
    const message = `
Hi ${student.name},

Your payment of \u20B9${amount} has been successfully received via ${paymentMethod}.

Thank you for your payment!
Parmanand Sports Academy
    `.trim();
    return await sendWhatsAppNotification({
      to: student.phone,
      message,
      type: "payment_received"
    });
  } catch (error) {
    console.error("Payment confirmation error:", error);
    throw new Error("Failed to send payment confirmation");
  }
}
async function sendAttendanceAlert(studentId, absentDays) {
  try {
    const student = await storage.getStudent(studentId);
    if (!student?.phone) {
      throw new Error("Student phone number not found");
    }
    const message = `
Hi ${student.name},

We noticed you've been absent for ${absentDays} consecutive days. 

Please contact us if you need any assistance or have any concerns.

Parmanand Sports Academy
    `.trim();
    return await sendWhatsAppNotification({
      to: student.phone,
      message,
      type: "attendance_alert"
    });
  } catch (error) {
    console.error("Attendance alert error:", error);
    throw new Error("Failed to send attendance alert");
  }
}
async function sendBulkNotification(recipients, message) {
  try {
    const promises = recipients.map(
      (phone) => sendWhatsAppNotification({
        to: phone,
        message,
        type: "general"
      })
    );
    const results = await Promise.allSettled(promises);
    const successful = results.filter((r) => r.status === "fulfilled").length;
    const failed = results.filter((r) => r.status === "rejected").length;
    return {
      total: recipients.length,
      successful,
      failed,
      results
    };
  } catch (error) {
    console.error("Bulk notification error:", error);
    throw new Error("Failed to send bulk notifications");
  }
}
var init_notifications = __esm({
  "server/notifications.ts"() {
    "use strict";
    init_storage();
  }
});

// server/campaign-automation.ts
var campaign_automation_exports = {};
__export(campaign_automation_exports, {
  CampaignAutomation: () => CampaignAutomation,
  campaignTemplates: () => campaignTemplates
});
import { format, subDays, isBefore, isAfter } from "date-fns";
var CampaignAutomation, campaignTemplates;
var init_campaign_automation = __esm({
  "server/campaign-automation.ts"() {
    "use strict";
    init_storage();
    init_notifications();
    CampaignAutomation = class _CampaignAutomation {
      static instance;
      intervals = /* @__PURE__ */ new Map();
      static getInstance() {
        if (!_CampaignAutomation.instance) {
          _CampaignAutomation.instance = new _CampaignAutomation();
        }
        return _CampaignAutomation.instance;
      }
      async initializeAutomation() {
        console.log("Initializing campaign automation...");
        const campaigns2 = await storage.getCampaigns({ status: "active" });
        for (const campaign of campaigns2) {
          this.setupCampaignAutomation(campaign);
        }
      }
      setupCampaignAutomation(campaign) {
        if (campaign.trigger === "automated" && campaign.automationRules) {
          const rule = campaign.automationRules;
          switch (rule.type) {
            case "fee_reminder":
              this.setupFeeReminderAutomation(campaign, rule);
              break;
            case "welcome_message":
              this.setupWelcomeAutomation(campaign, rule);
              break;
            case "attendance_followup":
              this.setupAttendanceAutomation(campaign, rule);
              break;
            case "birthday_wishes":
              this.setupBirthdayAutomation(campaign, rule);
              break;
          }
        }
      }
      setupFeeReminderAutomation(campaign, rule) {
        const interval = setInterval(async () => {
          try {
            const pendingPayments = await storage.getPendingPayments();
            const daysBefore = rule.conditions.daysBefore || 3;
            for (const payment of pendingPayments) {
              const dueDate = new Date(payment.dueDate);
              const reminderDate = subDays(dueDate, daysBefore);
              if (isBefore(/* @__PURE__ */ new Date(), dueDate) && isAfter(/* @__PURE__ */ new Date(), reminderDate)) {
                await this.sendCampaignMessage(campaign, payment.student, {
                  amount: payment.amount,
                  dueDate: format(dueDate, "dd MMM yyyy"),
                  studentName: payment.student.name
                });
              }
            }
          } catch (error) {
            console.error("Fee reminder automation error:", error);
          }
        }, 24 * 60 * 60 * 1e3);
        this.intervals.set(campaign.id, interval);
      }
      setupWelcomeAutomation(campaign, rule) {
        const interval = setInterval(async () => {
          try {
            const yesterday = subDays(/* @__PURE__ */ new Date(), 1);
            const students2 = await storage.getStudents({});
            for (const student of students2.students) {
              if (student.joiningDate && isAfter(new Date(student.joiningDate), yesterday)) {
                await this.sendCampaignMessage(campaign, student, {
                  studentName: student.name,
                  sportName: student.batch?.sport?.name || "Academy",
                  batchName: student.batch?.name || "Batch"
                });
              }
            }
          } catch (error) {
            console.error("Welcome automation error:", error);
          }
        }, 60 * 60 * 1e3);
        this.intervals.set(campaign.id, interval);
      }
      setupAttendanceAutomation(campaign, rule) {
        const interval = setInterval(async () => {
          try {
            const students2 = await storage.getStudents({});
            const absentThreshold = rule.conditions.consecutiveAbsences || 3;
            for (const student of students2.students) {
              const attendance2 = await storage.getStudentAttendance(student.id, subDays(/* @__PURE__ */ new Date(), 7));
              const absentCount = attendance2.filter((a) => a.status === "absent").length;
              if (absentCount >= absentThreshold) {
                await this.sendCampaignMessage(campaign, student, {
                  studentName: student.name,
                  absentDays: absentCount,
                  sportName: student.batch?.sport?.name || "Academy"
                });
              }
            }
          } catch (error) {
            console.error("Attendance automation error:", error);
          }
        }, 7 * 24 * 60 * 60 * 1e3);
        this.intervals.set(campaign.id, interval);
      }
      setupBirthdayAutomation(campaign, rule) {
        const interval = setInterval(async () => {
          try {
            const today = /* @__PURE__ */ new Date();
            const students2 = await storage.getStudents({});
            for (const student of students2.students) {
              if (student.dateOfBirth) {
                const birthday = new Date(student.dateOfBirth);
                if (birthday.getMonth() === today.getMonth() && birthday.getDate() === today.getDate()) {
                  await this.sendCampaignMessage(campaign, student, {
                    studentName: student.name,
                    age: today.getFullYear() - birthday.getFullYear()
                  });
                }
              }
            }
          } catch (error) {
            console.error("Birthday automation error:", error);
          }
        }, 24 * 60 * 60 * 1e3);
        this.intervals.set(campaign.id, interval);
      }
      async sendCampaignMessage(campaign, student, variables) {
        try {
          const messageRecord2 = await storage.createCampaignMessage({
            campaignId: campaign.id,
            recipient: student.phone,
            studentId: student.id,
            messageContent: this.processMessageTemplate(campaign.messageTemplate.text, variables),
            status: "pending"
          });
          const message = this.processMessageTemplate(campaign.messageTemplate.text, variables);
          await sendWhatsAppNotification({
            to: student.phone,
            message,
            type: "general"
          });
          await storage.updateCampaignMessage(messageRecord2.id, {
            status: "sent",
            sentAt: /* @__PURE__ */ new Date()
          });
          const analytics = campaign.analytics || { sent: 0, delivered: 0, read: 0, failed: 0 };
          analytics.sent = (analytics.sent || 0) + 1;
          await storage.updateCampaign(campaign.id, {
            analytics,
            lastRunAt: /* @__PURE__ */ new Date()
          });
        } catch (error) {
          console.error("Campaign message error:", error);
          await storage.updateCampaignMessage(messageRecord.id, {
            status: "failed",
            errorMessage: error.message
          });
        }
      }
      processMessageTemplate(template, variables) {
        let message = template;
        for (const [key, value] of Object.entries(variables)) {
          const placeholder = `{${key}}`;
          message = message.replace(new RegExp(placeholder, "g"), String(value));
        }
        return message;
      }
      stopCampaignAutomation(campaignId) {
        const interval = this.intervals.get(campaignId);
        if (interval) {
          clearInterval(interval);
          this.intervals.delete(campaignId);
        }
      }
      async restartCampaignAutomation(campaignId) {
        this.stopCampaignAutomation(campaignId);
        const campaign = await storage.getCampaign(campaignId);
        if (campaign) {
          this.setupCampaignAutomation(campaign);
        }
      }
    };
    campaignTemplates = {
      welcome: {
        name: "Welcome New Students",
        type: "welcome_message",
        trigger: "automated",
        messageTemplate: {
          text: "\u{1F389} Welcome to Parmanand Sports Academy, {studentName}!\n\nWe're excited to have you join our {sportName} program. Your journey with us starts now!\n\nBatch: {batchName}\nGet ready for an amazing sports experience!\n\nBest regards,\nParmanand Sports Academy Team",
          variables: ["studentName", "sportName", "batchName"]
        },
        automationRules: {
          type: "welcome_message",
          conditions: { triggerOnEnrollment: true },
          actions: { sendImmediately: true }
        }
      },
      feeReminder: {
        name: "Fee Payment Reminder",
        type: "fee_reminder",
        trigger: "automated",
        messageTemplate: {
          text: "\u{1F4B0} Fee Reminder - Parmanand Sports Academy\n\nHi {studentName},\n\nThis is a friendly reminder that your fee payment of \u20B9{amount} is due on {dueDate}.\n\nPlease make your payment at the earliest to continue your training without interruption.\n\nThank you!\nParmanand Sports Academy",
          variables: ["studentName", "amount", "dueDate"]
        },
        automationRules: {
          type: "fee_reminder",
          conditions: { daysBefore: 3 },
          actions: { sendDaily: true }
        }
      },
      attendanceFollowup: {
        name: "Attendance Follow-up",
        type: "attendance_followup",
        trigger: "automated",
        messageTemplate: {
          text: "\u{1F4C5} Attendance Alert - Parmanand Sports Academy\n\nHi {studentName},\n\nWe've noticed you've been absent for {absentDays} consecutive days from your {sportName} training.\n\nRegular attendance is crucial for your progress. Please contact us if you need any assistance.\n\nBest regards,\nParmanand Sports Academy",
          variables: ["studentName", "absentDays", "sportName"]
        },
        automationRules: {
          type: "attendance_followup",
          conditions: { consecutiveAbsences: 3 },
          actions: { sendWeekly: true }
        }
      },
      birthdayWishes: {
        name: "Birthday Wishes",
        type: "birthday",
        trigger: "automated",
        messageTemplate: {
          text: "\u{1F382} Happy Birthday {studentName}!\n\nWishing you a wonderful {age}th birthday filled with joy, success, and great achievements!\n\nMay this new year bring you closer to your sports goals and dreams.\n\nCelebrate and enjoy your special day!\n\nWarm wishes,\nParmanand Sports Academy Team",
          variables: ["studentName", "age"]
        },
        automationRules: {
          type: "birthday_wishes",
          conditions: { sendOnBirthday: true },
          actions: { sendAnnually: true }
        }
      }
    };
  }
});

// server/index.ts
import dotenv2 from "dotenv";
import express4 from "express";
import session from "express-session";

// server/routes.ts
init_storage();
init_report_generator();
import express2 from "express";
import { createServer } from "http";
import { WebSocketServer, WebSocket } from "ws";

// server/location-tracking.ts
init_db();
init_schema();
import { eq as eq3, and as and3, desc as desc3, gte as gte3, sql as sql3 } from "drizzle-orm";
var LocationTrackingService = class {
  // Calculate distance between two points using Haversine formula
  calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371e3;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    const distance = R * c;
    return distance;
  }
  // Check if a location is within a geofence
  async isWithinGeofence(latitude, longitude, geofenceId) {
    try {
      const [geofence] = await db.select().from(geofences).where(and3(eq3(geofences.id, geofenceId), eq3(geofences.isActive, true)));
      if (!geofence) return false;
      const distance = this.calculateDistance(
        latitude,
        longitude,
        parseFloat(geofence.centerLatitude),
        parseFloat(geofence.centerLongitude)
      );
      return distance <= geofence.radius;
    } catch (error) {
      console.error("Error checking geofence:", error);
      return false;
    }
  }
  // Track user location
  async trackLocation(userId, locationData, trackingType = "manual") {
    try {
      const activeGeofences = await db.select().from(geofences).where(eq3(geofences.isActive, true));
      let isWithinGeofence = false;
      let geofenceId = null;
      for (const geofence of activeGeofences) {
        const distance = this.calculateDistance(
          locationData.latitude,
          locationData.longitude,
          parseFloat(geofence.centerLatitude),
          parseFloat(geofence.centerLongitude)
        );
        if (distance <= geofence.radius) {
          isWithinGeofence = true;
          geofenceId = geofence.id;
          break;
        }
      }
      const [tracking] = await db.insert(locationTracking).values({
        userId,
        latitude: locationData.latitude.toString(),
        longitude: locationData.longitude.toString(),
        accuracy: locationData.accuracy,
        timestamp: locationData.timestamp,
        isWithinGeofence,
        geofenceId,
        trackingType,
        metadata: { timestamp: /* @__PURE__ */ new Date() }
      }).returning();
      return tracking;
    } catch (error) {
      console.error("Error tracking location:", error);
      throw error;
    }
  }
  // Get user's location history
  async getUserLocationHistory(userId, limit = 50) {
    try {
      const history = await db.select({
        id: locationTracking.id,
        latitude: locationTracking.latitude,
        longitude: locationTracking.longitude,
        accuracy: locationTracking.accuracy,
        timestamp: locationTracking.timestamp,
        isWithinGeofence: locationTracking.isWithinGeofence,
        trackingType: locationTracking.trackingType,
        geofenceName: geofences.name
      }).from(locationTracking).leftJoin(geofences, eq3(locationTracking.geofenceId, geofences.id)).where(eq3(locationTracking.userId, userId)).orderBy(desc3(locationTracking.timestamp)).limit(limit);
      return history;
    } catch (error) {
      console.error("Error fetching location history:", error);
      throw error;
    }
  }
  // Create geofence
  async createGeofence(geofenceData) {
    try {
      const [geofence] = await db.insert(geofences).values({
        name: geofenceData.name,
        description: geofenceData.description,
        centerLatitude: geofenceData.centerLatitude.toString(),
        centerLongitude: geofenceData.centerLongitude.toString(),
        radius: geofenceData.radius,
        createdBy: geofenceData.createdBy
      }).returning();
      return geofence;
    } catch (error) {
      console.error("Error creating geofence:", error);
      throw error;
    }
  }
  // Get all geofences
  async getGeofences() {
    try {
      return await db.select().from(geofences).where(eq3(geofences.isActive, true)).orderBy(desc3(geofences.createdAt));
    } catch (error) {
      console.error("Error fetching geofences:", error);
      throw error;
    }
  }
  // Coach check-in with GPS verification
  async coachCheckIn(coachId, batchId, location) {
    try {
      const today = (/* @__PURE__ */ new Date()).toISOString().split("T")[0];
      const [existingAttendance] = await db.select().from(coachAttendance).where(and3(
        eq3(coachAttendance.coachId, coachId),
        eq3(coachAttendance.batchId, batchId),
        eq3(coachAttendance.date, today)
      ));
      if (existingAttendance && existingAttendance.checkInTime) {
        throw new Error("Coach already checked in for this batch today");
      }
      const academyGeofences = await db.select().from(geofences).where(and3(eq3(geofences.isActive, true), eq3(geofences.name, "Academy")));
      let isGpsVerified = false;
      let geofenceVerified = false;
      if (academyGeofences.length > 0) {
        geofenceVerified = await this.isWithinGeofence(
          location.latitude,
          location.longitude,
          academyGeofences[0].id
        );
        isGpsVerified = location.accuracy <= 20;
      }
      const checkInLocation = {
        lat: location.latitude,
        lng: location.longitude,
        accuracy: location.accuracy,
        timestamp: location.timestamp
      };
      let attendance2;
      if (existingAttendance) {
        [attendance2] = await db.update(coachAttendance).set({
          checkInTime: location.timestamp,
          checkInLocation,
          isGpsVerified,
          geofenceVerified,
          status: "present",
          updatedAt: /* @__PURE__ */ new Date()
        }).where(eq3(coachAttendance.id, existingAttendance.id)).returning();
      } else {
        [attendance2] = await db.insert(coachAttendance).values({
          coachId,
          batchId,
          date: today,
          checkInTime: location.timestamp,
          checkInLocation,
          isGpsVerified,
          geofenceVerified,
          status: "present"
        }).returning();
      }
      await this.trackLocation(coachId, location, "attendance");
      return attendance2;
    } catch (error) {
      console.error("Error in coach check-in:", error);
      throw error;
    }
  }
  // Coach check-out
  async coachCheckOut(coachId, batchId, location) {
    try {
      const today = (/* @__PURE__ */ new Date()).toISOString().split("T")[0];
      const [attendance2] = await db.select().from(coachAttendance).where(and3(
        eq3(coachAttendance.coachId, coachId),
        eq3(coachAttendance.batchId, batchId),
        eq3(coachAttendance.date, today)
      ));
      if (!attendance2) {
        throw new Error("No check-in record found for today");
      }
      const checkOutLocation = {
        lat: location.latitude,
        lng: location.longitude,
        accuracy: location.accuracy,
        timestamp: location.timestamp
      };
      const [updatedAttendance] = await db.update(coachAttendance).set({
        checkOutTime: location.timestamp,
        checkOutLocation,
        updatedAt: /* @__PURE__ */ new Date()
      }).where(eq3(coachAttendance.id, attendance2.id)).returning();
      await this.trackLocation(coachId, location, "attendance");
      return updatedAttendance;
    } catch (error) {
      console.error("Error in coach check-out:", error);
      throw error;
    }
  }
  // Get coach attendance history
  async getCoachAttendanceHistory(coachId, limit = 30) {
    try {
      const history = await db.select({
        id: coachAttendance.id,
        date: coachAttendance.date,
        checkInTime: coachAttendance.checkInTime,
        checkOutTime: coachAttendance.checkOutTime,
        isGpsVerified: coachAttendance.isGpsVerified,
        geofenceVerified: coachAttendance.geofenceVerified,
        status: coachAttendance.status,
        batchName: sql3`batches.name`,
        coachName: coaches.name
      }).from(coachAttendance).leftJoin(coaches, eq3(coachAttendance.coachId, coaches.id)).leftJoin(sql3`batches`, eq3(coachAttendance.batchId, sql3`batches.id`)).where(eq3(coachAttendance.coachId, coachId)).orderBy(desc3(coachAttendance.date)).limit(limit);
      return history;
    } catch (error) {
      console.error("Error fetching coach attendance history:", error);
      throw error;
    }
  }
  // Get live coach locations
  async getLiveCoachLocations() {
    try {
      const fiveMinutesAgo = new Date(Date.now() - 5 * 60 * 1e3);
      const liveLocations = await db.select({
        userId: locationTracking.userId,
        latitude: locationTracking.latitude,
        longitude: locationTracking.longitude,
        accuracy: locationTracking.accuracy,
        timestamp: locationTracking.timestamp,
        userName: users.name,
        isWithinGeofence: locationTracking.isWithinGeofence
      }).from(locationTracking).leftJoin(users, eq3(locationTracking.userId, users.id)).where(and3(
        gte3(locationTracking.timestamp, fiveMinutesAgo),
        eq3(locationTracking.trackingType, "attendance")
      )).orderBy(desc3(locationTracking.timestamp));
      return liveLocations;
    } catch (error) {
      console.error("Error fetching live coach locations:", error);
      throw error;
    }
  }
};
var locationTrackingService = new LocationTrackingService();

// server/user-permission.ts
init_db();
init_schema();
import { eq as eq4, and as and4, sql as sql4 } from "drizzle-orm";
var UserPermissionService = class {
  // Default permissions for each role
  DEFAULT_PERMISSIONS = {
    admin: [
      "users.create",
      "users.read",
      "users.update",
      "users.delete",
      "students.create",
      "students.read",
      "students.update",
      "students.delete",
      "payments.create",
      "payments.read",
      "payments.update",
      "payments.delete",
      "attendance.create",
      "attendance.read",
      "attendance.update",
      "attendance.delete",
      "coaches.create",
      "coaches.read",
      "coaches.update",
      "coaches.delete",
      "reports.create",
      "reports.read",
      "reports.update",
      "reports.delete",
      "settings.read",
      "settings.update",
      "campaigns.create",
      "campaigns.read",
      "campaigns.update",
      "campaigns.delete",
      "location.read",
      "location.update",
      "geofences.create",
      "geofences.read",
      "geofences.update",
      "geofences.delete"
    ],
    manager: [
      "users.read",
      "users.update",
      "students.create",
      "students.read",
      "students.update",
      "payments.create",
      "payments.read",
      "payments.update",
      "attendance.create",
      "attendance.read",
      "attendance.update",
      "coaches.read",
      "coaches.update",
      "reports.create",
      "reports.read",
      "campaigns.create",
      "campaigns.read",
      "campaigns.update",
      "location.read",
      "geofences.read"
    ],
    staff: [
      "students.create",
      "students.read",
      "students.update",
      "payments.create",
      "payments.read",
      "attendance.create",
      "attendance.read",
      "coaches.read",
      "reports.read",
      "location.read"
    ],
    coach: [
      "students.read",
      "attendance.create",
      "attendance.read",
      "reports.read",
      "location.read"
    ],
    student: [
      "students.read",
      "attendance.read",
      "payments.read"
    ]
  };
  // Initialize default permissions in database
  async initializeDefaultPermissions() {
    try {
      const tableExists = await this.checkTableExists();
      if (!tableExists) {
        console.log("Permissions table does not exist yet. Skipping initialization.");
        return;
      }
      const permissionsList = [
        // User permissions
        { name: "users.create", displayName: "Create Users", description: "Create new user accounts", category: "users" },
        { name: "users.read", displayName: "View Users", description: "View user information", category: "users" },
        { name: "users.update", displayName: "Update Users", description: "Update user information", category: "users" },
        { name: "users.delete", displayName: "Delete Users", description: "Delete user accounts", category: "users" },
        // Student permissions
        { name: "students.create", displayName: "Create Students", description: "Register new students", category: "students" },
        { name: "students.read", displayName: "View Students", description: "View student information", category: "students" },
        { name: "students.update", displayName: "Update Students", description: "Update student information", category: "students" },
        { name: "students.delete", displayName: "Delete Students", description: "Delete student records", category: "students" },
        // Payment permissions
        { name: "payments.create", displayName: "Record Payments", description: "Record new payments", category: "payments" },
        { name: "payments.read", displayName: "View Payments", description: "View payment records", category: "payments" },
        { name: "payments.update", displayName: "Update Payments", description: "Update payment records", category: "payments" },
        { name: "payments.delete", displayName: "Delete Payments", description: "Delete payment records", category: "payments" },
        // Attendance permissions
        { name: "attendance.create", displayName: "Mark Attendance", description: "Mark student attendance", category: "attendance" },
        { name: "attendance.read", displayName: "View Attendance", description: "View attendance records", category: "attendance" },
        { name: "attendance.update", displayName: "Update Attendance", description: "Update attendance records", category: "attendance" },
        { name: "attendance.delete", displayName: "Delete Attendance", description: "Delete attendance records", category: "attendance" },
        // Coach permissions
        { name: "coaches.create", displayName: "Add Coaches", description: "Add new coaches", category: "coaches" },
        { name: "coaches.read", displayName: "View Coaches", description: "View coach information", category: "coaches" },
        { name: "coaches.update", displayName: "Update Coaches", description: "Update coach information", category: "coaches" },
        { name: "coaches.delete", displayName: "Delete Coaches", description: "Delete coach records", category: "coaches" },
        // Report permissions
        { name: "reports.create", displayName: "Create Reports", description: "Create custom reports", category: "reports" },
        { name: "reports.read", displayName: "View Reports", description: "View generated reports", category: "reports" },
        { name: "reports.update", displayName: "Update Reports", description: "Update report configurations", category: "reports" },
        { name: "reports.delete", displayName: "Delete Reports", description: "Delete report configurations", category: "reports" },
        // Settings permissions
        { name: "settings.read", displayName: "View Settings", description: "View system settings", category: "settings" },
        { name: "settings.update", displayName: "Update Settings", description: "Update system settings", category: "settings" },
        // Campaign permissions
        { name: "campaigns.create", displayName: "Create Campaigns", description: "Create marketing campaigns", category: "campaigns" },
        { name: "campaigns.read", displayName: "View Campaigns", description: "View campaign information", category: "campaigns" },
        { name: "campaigns.update", displayName: "Update Campaigns", description: "Update campaign settings", category: "campaigns" },
        { name: "campaigns.delete", displayName: "Delete Campaigns", description: "Delete campaigns", category: "campaigns" },
        // Location permissions
        { name: "location.read", displayName: "View Locations", description: "View location tracking data", category: "location" },
        { name: "location.update", displayName: "Update Locations", description: "Update location settings", category: "location" },
        // Geofence permissions
        { name: "geofences.create", displayName: "Create Geofences", description: "Create new geofences", category: "geofences" },
        { name: "geofences.read", displayName: "View Geofences", description: "View geofence information", category: "geofences" },
        { name: "geofences.update", displayName: "Update Geofences", description: "Update geofence settings", category: "geofences" },
        { name: "geofences.delete", displayName: "Delete Geofences", description: "Delete geofences", category: "geofences" }
      ];
      for (const permission of permissionsList) {
        const [existing] = await db.select().from(permissions).where(eq4(permissions.name, permission.name));
        if (!existing) {
          await db.insert(permissions).values(permission);
        }
      }
    } catch (error) {
      console.error("Error initializing default permissions:", error);
    }
  }
  // Check if table exists
  async checkTableExists() {
    try {
      await db.select({ count: sql4`COUNT(*)` }).from(permissions).limit(1);
      return true;
    } catch (error) {
      return false;
    }
  }
  // Create a new user with role and permissions
  async createUser(userData) {
    try {
      const defaultPermissions = this.DEFAULT_PERMISSIONS[userData.role] || [];
      const userPermissions = [.../* @__PURE__ */ new Set([...defaultPermissions, ...userData.permissions])];
      const [user] = await db.insert(users).values({
        name: userData.name,
        email: userData.email,
        phone: userData.phone,
        role: userData.role,
        permissions: userPermissions,
        createdBy: userData.createdBy
      }).returning();
      return user;
    } catch (error) {
      console.error("Error creating user:", error);
      throw error;
    }
  }
  // Check if user has specific permission
  async hasPermission(userId, permission) {
    try {
      const [user] = await db.select().from(users).where(and4(eq4(users.id, userId), eq4(users.isActive, true)));
      if (!user) return false;
      const userPermissions = user.permissions || [];
      return userPermissions.includes(permission);
    } catch (error) {
      console.error("Error checking permission:", error);
      return false;
    }
  }
  // Get user permissions
  async getUserPermissions(userId) {
    try {
      const [user] = await db.select().from(users).where(eq4(users.id, userId));
      if (!user) return [];
      return user.permissions || [];
    } catch (error) {
      console.error("Error getting user permissions:", error);
      return [];
    }
  }
  // Update user permissions
  async updateUserPermissions(userId, permissions2) {
    try {
      const [user] = await db.update(users).set({
        permissions: permissions2,
        updatedAt: /* @__PURE__ */ new Date()
      }).where(eq4(users.id, userId)).returning();
      return user;
    } catch (error) {
      console.error("Error updating user permissions:", error);
      throw error;
    }
  }
  // Get all users with their permissions
  async getUsers() {
    try {
      const userList = await db.select({
        id: users.id,
        name: users.name,
        email: users.email,
        phone: users.phone,
        role: users.role,
        permissions: users.permissions,
        isActive: users.isActive,
        lastLogin: users.lastLogin,
        createdAt: users.createdAt
      }).from(users);
      return userList;
    } catch (error) {
      console.error("Error getting users:", error);
      throw error;
    }
  }
  // Get all available permissions
  async getPermissions() {
    try {
      return await db.select().from(permissions).where(eq4(permissions.isActive, true));
    } catch (error) {
      console.error("Error getting permissions:", error);
      throw error;
    }
  }
  // Update user role
  async updateUserRole(userId, newRole) {
    try {
      const defaultPermissions = this.DEFAULT_PERMISSIONS[newRole] || [];
      const [user] = await db.update(users).set({
        role: newRole,
        permissions: defaultPermissions,
        updatedAt: /* @__PURE__ */ new Date()
      }).where(eq4(users.id, userId)).returning();
      return user;
    } catch (error) {
      console.error("Error updating user role:", error);
      throw error;
    }
  }
  // Deactivate user
  async deactivateUser(userId) {
    try {
      const [user] = await db.update(users).set({
        isActive: false,
        updatedAt: /* @__PURE__ */ new Date()
      }).where(eq4(users.id, userId)).returning();
      return user;
    } catch (error) {
      console.error("Error deactivating user:", error);
      throw error;
    }
  }
  // Activate user
  async activateUser(userId) {
    try {
      const [user] = await db.update(users).set({
        isActive: true,
        updatedAt: /* @__PURE__ */ new Date()
      }).where(eq4(users.id, userId)).returning();
      return user;
    } catch (error) {
      console.error("Error activating user:", error);
      throw error;
    }
  }
};
var userPermissionService = new UserPermissionService();

// server/auth-middleware.ts
var requireAuth = (req, res, next) => {
  const authHeader = req.headers.authorization;
  const sessionUser = req.session?.user;
  if (authHeader && authHeader.startsWith("Bearer ")) {
    const token = authHeader.substring(7);
    req.user = { id: 1, email: "admin@psa.com", role: "admin" };
    return next();
  } else if (sessionUser) {
    req.user = sessionUser;
    return next();
  } else {
    if (process.env.NODE_ENV === "development") {
      req.user = { id: 1, email: "admin@psa.com", role: "admin" };
      return next();
    } else {
      return res.status(401).json({ error: "Authentication required" });
    }
  }
};
var requireRole = (role) => {
  return (req, res, next) => {
    const user = req.user;
    if (!user) {
      return res.status(401).json({ error: "Authentication required" });
    }
    if (user.role !== role && user.role !== "admin") {
      return res.status(403).json({ error: "Insufficient permissions" });
    }
    next();
  };
};
var requireAdmin = requireRole("admin");

// server/routes.ts
init_gamification();

// server/mobile-routes.ts
init_storage();
import { Router } from "express";
var router = Router();
router.post("/auth/login", async (req, res) => {
  try {
    const { phone, password, userType } = req.body;
    if (!phone || !password || !userType) {
      return res.status(400).json({ message: "Phone, password, and user type are required" });
    }
    let user;
    if (userType === "student") {
      user = await storage.getStudentByPhone(phone);
    } else if (userType === "coach") {
      user = await storage.getCoachByPhone(phone);
    } else {
      return res.status(400).json({ message: "Invalid user type" });
    }
    if (!user) {
      return res.status(401).json({ message: "Invalid credentials" });
    }
    if (user.password !== password) {
      return res.status(401).json({ message: "Invalid credentials" });
    }
    const token = `mobile_${userType}_${user.id}_${Date.now()}`;
    res.json({
      success: true,
      token,
      user: {
        id: user.id,
        name: user.name,
        email: user.email,
        phone: user.phone,
        type: userType,
        sportId: user.sportId,
        batchId: user.batchId
      }
    });
  } catch (error) {
    console.error("Mobile login error:", error);
    res.status(500).json({ message: "Login failed" });
  }
});
router.post("/auth/logout", (req, res) => {
  res.json({ success: true });
});
router.get("/auth/check", (req, res) => {
  const token = req.headers.authorization?.replace("Bearer ", "");
  if (!token || !token.startsWith("mobile_")) {
    return res.status(401).json({ message: "Invalid token" });
  }
  const [, userType, userId] = token.split("_");
  res.json({
    success: true,
    userType,
    userId: parseInt(userId)
  });
});
router.get("/coach/profile", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const coachId = parseInt(token?.split("_")[2] || "0");
    const coach = await storage.getCoach(coachId);
    if (!coach) {
      return res.status(404).json({ message: "Coach not found" });
    }
    res.json(coach);
  } catch (error) {
    console.error("Coach profile error:", error);
    res.status(500).json({ message: "Failed to fetch profile" });
  }
});
router.get("/coach/dashboard", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const coachId = parseInt(token?.split("_")[2] || "0");
    const students2 = await storage.getStudentsByCoach(coachId);
    const classes = await storage.getBatchesByCoach(coachId);
    const totalStudents = students2.length;
    const activeClasses = classes.filter((c) => c.isActive).length;
    const todayAttendance = await storage.getTodayAttendanceByCoach(coachId);
    const thisWeekClasses = await storage.getWeeklyClassesByCoach(coachId);
    res.json({
      totalStudents,
      activeClasses,
      todayAttendance: todayAttendance.length,
      thisWeekClasses: thisWeekClasses.length
    });
  } catch (error) {
    console.error("Coach dashboard error:", error);
    res.status(500).json({ message: "Failed to fetch dashboard" });
  }
});
router.get("/coach/today-classes", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const coachId = parseInt(token?.split("_")[2] || "0");
    const classes = await storage.getTodayClassesByCoach(coachId);
    res.json(classes);
  } catch (error) {
    console.error("Today classes error:", error);
    res.status(500).json({ message: "Failed to fetch today classes" });
  }
});
router.get("/coach/recent-attendance", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const coachId = parseInt(token?.split("_")[2] || "0");
    const attendance2 = await storage.getRecentAttendanceByCoach(coachId);
    res.json(attendance2);
  } catch (error) {
    console.error("Recent attendance error:", error);
    res.status(500).json({ message: "Failed to fetch recent attendance" });
  }
});
router.get("/student/profile", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const studentId = parseInt(token?.split("_")[2] || "0");
    const student = await storage.getStudent(studentId);
    if (!student) {
      return res.status(404).json({ message: "Student not found" });
    }
    res.json(student);
  } catch (error) {
    console.error("Student profile error:", error);
    res.status(500).json({ message: "Failed to fetch profile" });
  }
});
router.get("/student/dashboard", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const studentId = parseInt(token?.split("_")[2] || "0");
    const attendanceStats = await storage.getStudentAttendanceStats(studentId);
    const paymentStats = await storage.getStudentPaymentStats(studentId);
    const badgeStats = await storage.getStudentBadgeStats(studentId);
    res.json({
      attendancePercentage: attendanceStats.percentage || 0,
      totalClasses: attendanceStats.totalClasses || 0,
      upcomingPayment: paymentStats.upcomingAmount || 0,
      totalBadges: badgeStats.totalBadges || 0,
      currentLevel: badgeStats.currentLevel || 1,
      totalPoints: badgeStats.totalPoints || 0
    });
  } catch (error) {
    console.error("Student dashboard error:", error);
    res.status(500).json({ message: "Failed to fetch dashboard" });
  }
});
router.get("/student/upcoming-classes", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const studentId = parseInt(token?.split("_")[2] || "0");
    const classes = await storage.getUpcomingClassesByStudent(studentId);
    res.json(classes);
  } catch (error) {
    console.error("Upcoming classes error:", error);
    res.status(500).json({ message: "Failed to fetch upcoming classes" });
  }
});
router.get("/student/recent-badges", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const studentId = parseInt(token?.split("_")[2] || "0");
    const badges2 = await storage.getRecentBadgesByStudent(studentId);
    res.json(badges2);
  } catch (error) {
    console.error("Recent badges error:", error);
    res.status(500).json({ message: "Failed to fetch recent badges" });
  }
});
router.get("/student/attendance", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const studentId = parseInt(token?.split("_")[2] || "0");
    const attendance2 = await storage.getStudentAttendanceHistory(studentId);
    res.json(attendance2);
  } catch (error) {
    console.error("Student attendance error:", error);
    res.status(500).json({ message: "Failed to fetch attendance" });
  }
});
router.get("/student/payments", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const studentId = parseInt(token?.split("_")[2] || "0");
    const payments2 = await storage.getStudentPaymentHistory(studentId);
    res.json(payments2);
  } catch (error) {
    console.error("Student payments error:", error);
    res.status(500).json({ message: "Failed to fetch payments" });
  }
});
router.get("/student/achievements", async (req, res) => {
  try {
    const token = req.headers.authorization?.replace("Bearer ", "");
    const studentId = parseInt(token?.split("_")[2] || "0");
    const achievements = await storage.getStudentAchievements(studentId);
    res.json(achievements);
  } catch (error) {
    console.error("Student achievements error:", error);
    res.status(500).json({ message: "Failed to fetch achievements" });
  }
});
var mobile_routes_default = router;

// server/routes/health.ts
import express from "express";
var router2 = express.Router();
router2.get("/health", (req, res) => {
  res.json({
    status: "ok",
    message: "Parmanand Sports Academy API is running",
    environment: process.env.NODE_ENV,
    timestamp: (/* @__PURE__ */ new Date()).toISOString(),
    deployment: process.env.DOKPLOY_DEPLOYMENT_ID || "local"
  });
});
var health_default = router2;

// server/routes.ts
init_schema();

// server/upload-middleware.ts
import multer from "multer";
import path from "path";
import fs from "fs";
var uploadDirs = ["uploads/profiles", "uploads/icons"];
uploadDirs.forEach((dir) => {
  if (!fs.existsSync(dir)) {
    fs.mkdirSync(dir, { recursive: true });
  }
});
var profileStorage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, "uploads/profiles/");
  },
  filename: (req, file, cb) => {
    const uniqueSuffix = Date.now() + "-" + Math.round(Math.random() * 1e9);
    const ext = path.extname(file.originalname);
    cb(null, `profile-${uniqueSuffix}${ext}`);
  }
});
var iconStorage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, "uploads/icons/");
  },
  filename: (req, file, cb) => {
    const uniqueSuffix = Date.now() + "-" + Math.round(Math.random() * 1e9);
    const ext = path.extname(file.originalname);
    cb(null, `icon-${uniqueSuffix}${ext}`);
  }
});
var imageFilter = (req, file, cb) => {
  if (file.mimetype.startsWith("image/")) {
    cb(null, true);
  } else {
    cb(new Error("Only image files are allowed!"));
  }
};
var uploadProfile = multer({
  storage: profileStorage,
  fileFilter: imageFilter,
  limits: {
    fileSize: 5 * 1024 * 1024
    // 5MB limit
  }
}).single("profileImage");
var uploadIcon = multer({
  storage: iconStorage,
  fileFilter: imageFilter,
  limits: {
    fileSize: 2 * 1024 * 1024
    // 2MB limit for icons
  }
}).single("icon");
var deleteFile = (filePath) => {
  if (fs.existsSync(filePath)) {
    fs.unlinkSync(filePath);
  }
};

// server/routes.ts
import path2 from "path";
import fs2 from "fs";
async function registerRoutes(app2) {
  const httpServer = createServer(app2);
  const wss = new WebSocketServer({ server: httpServer, path: "/ws" });
  wss.on("connection", (ws) => {
    console.log("Client connected to WebSocket");
    ws.on("message", (message) => {
      console.log("Received:", message.toString());
    });
    ws.on("close", () => {
      console.log("Client disconnected");
    });
  });
  const broadcast = (data) => {
    wss.clients.forEach((client) => {
      if (client.readyState === WebSocket.OPEN) {
        client.send(JSON.stringify(data));
      }
    });
  };
  app2.use("/api", health_default);
  app2.use("/api/mobile", mobile_routes_default);
  app2.post("/api/auth/login", async (req, res) => {
    try {
      const { email, password } = req.body;
      console.log("Login attempt:", { email, password: password ? "***" : "missing" });
      if (!email || !password) {
        return res.status(400).json({ error: "Email and password are required" });
      }
      const user = await storage.getUserByEmail(email);
      console.log("User found:", user ? { id: user.id, email: user.email, hasPassword: !!user.password } : "null");
      if (!user) {
        return res.status(401).json({ error: "Invalid credentials" });
      }
      const bcrypt = await import("bcrypt");
      const isValidPassword = await bcrypt.compare(password, user.password || "");
      console.log("Password validation:", { isValidPassword, storedHash: user.password?.substring(0, 10) + "..." });
      if (!isValidPassword) {
        return res.status(401).json({ error: "Invalid credentials" });
      }
      await storage.updateUserLastLogin(user.id);
      req.session.user = {
        id: user.id,
        email: user.email,
        name: user.name,
        role: user.role
      };
      res.json({
        success: true,
        user: {
          id: user.id,
          email: user.email,
          name: user.name,
          role: user.role
        }
      });
    } catch (error) {
      console.error("Login error:", error);
      res.status(500).json({ error: "Login failed" });
    }
  });
  app2.post("/api/auth/logout", (req, res) => {
    try {
      req.session.destroy((err) => {
        if (err) {
          console.error("Logout error:", err);
          return res.status(500).json({ error: "Logout failed" });
        }
        res.json({ success: true });
      });
    } catch (error) {
      console.error("Logout error:", error);
      res.status(500).json({ error: "Logout failed" });
    }
  });
  app2.get("/api/auth/user", (req, res) => {
    try {
      const user = req.session?.user;
      if (!user) {
        return res.status(401).json({ error: "Not authenticated" });
      }
      res.json({ user });
    } catch (error) {
      console.error("Get user error:", error);
      res.status(500).json({ error: "Failed to get user" });
    }
  });
  app2.get("/api/auth/me", (req, res) => {
    try {
      const user = req.session?.user;
      if (!user) {
        return res.status(401).json({ error: "Not authenticated" });
      }
      res.json({ user });
    } catch (error) {
      console.error("Get user error:", error);
      res.status(500).json({ error: "Failed to get user" });
    }
  });
  app2.get("/api/dashboard/stats", requireAuth, async (req, res) => {
    try {
      const stats = await storage.getDashboardStats();
      res.json(stats);
    } catch (error) {
      console.error("Error fetching dashboard stats:", error);
      res.status(500).json({ message: "Failed to fetch dashboard stats" });
    }
  });
  app2.get("/api/dashboard/revenue-chart", requireAuth, async (req, res) => {
    try {
      const year = parseInt(req.query.year) || (/* @__PURE__ */ new Date()).getFullYear();
      const revenue = await storage.getMonthlyRevenueReport(year);
      res.json(revenue);
    } catch (error) {
      console.error("Error fetching revenue chart:", error);
      res.status(500).json({ message: "Failed to fetch revenue chart" });
    }
  });
  app2.get("/api/students", requireAuth, async (req, res) => {
    try {
      const filters = {
        sportId: req.query.sportId ? parseInt(req.query.sportId) : void 0,
        batchId: req.query.batchId ? parseInt(req.query.batchId) : void 0,
        isActive: req.query.isActive ? req.query.isActive === "true" : void 0,
        search: req.query.search,
        limit: parseInt(req.query.limit) || 50,
        offset: parseInt(req.query.offset) || 0
      };
      const result = await storage.getStudents(filters);
      res.json(result);
    } catch (error) {
      console.error("Error fetching students:", error);
      res.status(500).json({ message: "Failed to fetch students" });
    }
  });
  app2.get("/api/students/:id", async (req, res) => {
    try {
      const id = parseInt(req.params.id);
      const student = await storage.getStudent(id);
      if (!student) {
        return res.status(404).json({ message: "Student not found" });
      }
      res.json(student);
    } catch (error) {
      console.error("Error fetching student:", error);
      res.status(500).json({ message: "Failed to fetch student" });
    }
  });
  app2.post("/api/students", requireAuth, async (req, res) => {
    try {
      const studentData = insertStudentSchema.parse(req.body);
      const processedData = {
        ...studentData,
        dateOfBirth: studentData.dateOfBirth === "" ? null : studentData.dateOfBirth
      };
      const studentCount = await storage.getStudents({ limit: 1 });
      const studentId = `PSA${String(studentCount.total + 1).padStart(3, "0")}`;
      const student = await storage.createStudent({
        ...processedData,
        studentId
      });
      if (student.batchId) {
        await storage.updateBatchCapacity(student.batchId, 1);
      }
      const currentDate = /* @__PURE__ */ new Date();
      const registrationPayment = {
        studentId: student.id,
        amount: 300,
        // ₹300 one-time registration fee
        paymentMethod: "pending",
        status: "pending",
        monthYear: `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, "0")}`,
        notes: "One-time registration fee",
        paymentType: "registration",
        dueDate: currentDate
      };
      await storage.createPayment(registrationPayment);
      await storage.createActivity({
        type: "student_enrolled",
        description: `New student enrolled: ${student.name}`,
        userId: req.session?.user?.id || 1,
        entityId: student.id,
        entityType: "student"
      });
      broadcast({
        type: "student_enrolled",
        student
      });
      res.status(201).json(student);
    } catch (error) {
      console.error("Error creating student:", error);
      res.status(400).json({ message: "Failed to create student" });
    }
  });
  app2.put("/api/students/:id", requireAuth, async (req, res) => {
    try {
      const id = parseInt(req.params.id);
      const updates = req.body;
      const student = await storage.updateStudent(id, updates);
      if (!student) {
        return res.status(404).json({ message: "Student not found" });
      }
      res.json(student);
    } catch (error) {
      console.error("Error updating student:", error);
      res.status(500).json({ message: "Failed to update student" });
    }
  });
  app2.patch("/api/students/:id", async (req, res) => {
    try {
      const id = parseInt(req.params.id);
      const updates = req.body;
      const student = await storage.updateStudent(id, updates);
      if (!student) {
        return res.status(404).json({ message: "Student not found" });
      }
      await storage.createActivity({
        type: "student_updated",
        description: `Student updated: ${student.name}`,
        userId: req.session?.user?.id || 1,
        entityId: student.id,
        entityType: "student"
      });
      broadcast({
        type: "student_updated",
        student
      });
      res.json(student);
    } catch (error) {
      console.error("Error updating student:", error);
      res.status(500).json({ message: "Failed to update student" });
    }
  });
  app2.delete("/api/students/:id", requireAuth, async (req, res) => {
    try {
      const id = parseInt(req.params.id);
      const student = await storage.getStudent(id);
      if (!student) {
        return res.status(404).json({ message: "Student not found" });
      }
      const success = await storage.deleteStudent(id);
      await storage.createActivity({
        type: "student_deleted",
        description: `Student deleted: ${student.name} (ID: ${student.studentId})`,
        userId: req.session?.user?.id || 1,
        entityId: student.id,
        entityType: "student"
      });
      broadcast({
        type: "student_deleted",
        studentId: id
      });
      res.json({ message: "Student deleted successfully" });
    } catch (error) {
      console.error("Error deleting student:", error);
      const errorMessage = error instanceof Error ? error.message : "Failed to delete student";
      res.status(400).json({ message: errorMessage });
    }
  });
  app2.post("/api/upload/profile/:studentId", requireAuth, (req, res) => {
    uploadProfile(req, res, async (err) => {
      if (err) {
        console.error("Upload error:", err);
        return res.status(400).json({ message: err.message });
      }
      if (!req.file) {
        return res.status(400).json({ message: "No file uploaded" });
      }
      try {
        const studentId = parseInt(req.params.studentId);
        const profileImageUrl = `/uploads/profiles/${req.file.filename}`;
        const currentStudent = await storage.getStudent(studentId);
        if (currentStudent?.profileImageUrl) {
          const oldImagePath = path2.join(process.cwd(), currentStudent.profileImageUrl);
          deleteFile(oldImagePath);
        }
        await storage.updateStudent(studentId, { profileImageUrl });
        await storage.createActivity({
          type: "student_updated",
          description: `Profile image updated for student ID: ${studentId}`,
          userId: req.session?.user?.id || 1,
          entityId: studentId,
          entityType: "student"
        });
        res.json({
          message: "Profile image uploaded successfully",
          profileImageUrl
        });
      } catch (error) {
        console.error("Error updating profile image:", error);
        if (req.file) {
          deleteFile(req.file.path);
        }
        res.status(500).json({ message: "Failed to update profile image" });
      }
    });
  });
  app2.post("/api/upload/icon", requireAuth, (req, res) => {
    uploadIcon(req, res, async (err) => {
      if (err) {
        console.error("Icon upload error:", err);
        return res.status(400).json({ message: err.message });
      }
      if (!req.file) {
        return res.status(400).json({ message: "No file uploaded" });
      }
      try {
        const iconUrl = `/uploads/icons/${req.file.filename}`;
        await storage.createActivity({
          type: "system_updated",
          description: `New icon uploaded: ${req.file.filename}`,
          userId: req.session?.user?.id || 1,
          entityId: null,
          entityType: "system"
        });
        res.json({
          message: "Icon uploaded successfully",
          iconUrl,
          filename: req.file.filename
        });
      } catch (error) {
        console.error("Error uploading icon:", error);
        if (req.file) {
          deleteFile(req.file.path);
        }
        res.status(500).json({ message: "Failed to upload icon" });
      }
    });
  });
  app2.use("/uploads", express2.static("uploads"));
  app2.get("/api/payments", requireAuth, async (req, res) => {
    try {
      const filters = {
        studentId: req.query.studentId ? parseInt(req.query.studentId) : void 0,
        status: req.query.status,
        monthYear: req.query.monthYear,
        search: req.query.search,
        limit: parseInt(req.query.limit) || 50,
        offset: parseInt(req.query.offset) || 0
      };
      const result = await storage.getPayments(filters);
      res.json(result);
    } catch (error) {
      console.error("Error fetching payments:", error);
      res.status(500).json({ message: "Failed to fetch payments" });
    }
  });
  app2.post("/api/payments", requireAuth, async (req, res) => {
    try {
      const paymentData = insertPaymentSchema.parse(req.body);
      const receiptNumber = `RCP${Date.now()}`;
      const payment = await storage.createPayment({
        ...paymentData,
        receiptNumber,
        paymentDate: /* @__PURE__ */ new Date(),
        status: "completed"
      });
      await storage.createActivity({
        type: "payment_received",
        description: `Payment received: \u20B9${payment.amount}`,
        userId: req.session?.user?.id || 1,
        entityId: payment.id,
        entityType: "payment"
      });
      await gamificationService.triggerPaymentEvent(payment.studentId, payment);
      broadcast({
        type: "payment_received",
        payment
      });
      res.status(201).json(payment);
    } catch (error) {
      console.error("Error creating payment:", error);
      res.status(400).json({ message: "Failed to create payment" });
    }
  });
  app2.get("/api/badges", async (req, res) => {
    try {
      const badges2 = await storage.getBadges();
      res.json(badges2);
    } catch (error) {
      console.error("Error fetching badges:", error);
      res.status(500).json({ error: "Failed to fetch badges" });
    }
  });
  app2.get("/api/badges/:id", async (req, res) => {
    try {
      const badge = await storage.getBadge(parseInt(req.params.id));
      if (!badge) {
        return res.status(404).json({ error: "Badge not found" });
      }
      res.json(badge);
    } catch (error) {
      console.error("Error fetching badge:", error);
      res.status(500).json({ error: "Failed to fetch badge" });
    }
  });
  app2.post("/api/badges", async (req, res) => {
    try {
      const badge = await storage.createBadge(req.body);
      res.json(badge);
    } catch (error) {
      console.error("Error creating badge:", error);
      res.status(500).json({ error: "Failed to create badge" });
    }
  });
  app2.patch("/api/badges/:id", async (req, res) => {
    try {
      const badge = await storage.updateBadge(parseInt(req.params.id), req.body);
      if (!badge) {
        return res.status(404).json({ error: "Badge not found" });
      }
      res.json(badge);
    } catch (error) {
      console.error("Error updating badge:", error);
      res.status(500).json({ error: "Failed to update badge" });
    }
  });
  app2.delete("/api/badges/:id", async (req, res) => {
    try {
      const deleted = await storage.deleteBadge(parseInt(req.params.id));
      if (!deleted) {
        return res.status(404).json({ error: "Badge not found" });
      }
      res.json({ message: "Badge deleted successfully" });
    } catch (error) {
      console.error("Error deleting badge:", error);
      res.status(500).json({ error: "Failed to delete badge" });
    }
  });
  app2.get("/api/students/:id/badges", async (req, res) => {
    try {
      const studentBadges2 = await storage.getStudentBadges(parseInt(req.params.id));
      res.json(studentBadges2);
    } catch (error) {
      console.error("Error fetching student badges:", error);
      res.status(500).json({ error: "Failed to fetch student badges" });
    }
  });
  app2.post("/api/students/:id/award-badge", async (req, res) => {
    try {
      const { badgeId } = req.body;
      const studentBadge = await storage.createStudentBadge({
        studentId: parseInt(req.params.id),
        badgeId,
        earnedAt: /* @__PURE__ */ new Date(),
        progress: {},
        isDisplayed: true
      });
      res.json(studentBadge);
    } catch (error) {
      console.error("Error awarding badge:", error);
      res.status(500).json({ error: "Failed to award badge" });
    }
  });
  app2.get("/api/students/:id/points", async (req, res) => {
    try {
      const studentPoints2 = await storage.getStudentPoints(parseInt(req.params.id));
      res.json(studentPoints2);
    } catch (error) {
      console.error("Error fetching student points:", error);
      res.status(500).json({ error: "Failed to fetch student points" });
    }
  });
  app2.post("/api/students/:id/add-points", async (req, res) => {
    try {
      const { points } = req.body;
      await storage.addStudentPoints(parseInt(req.params.id), points);
      res.json({ message: "Points added successfully" });
    } catch (error) {
      console.error("Error adding points:", error);
      res.status(500).json({ error: "Failed to add points" });
    }
  });
  app2.get("/api/students/:id/achievements", async (req, res) => {
    try {
      const achievements = await storage.getAchievementHistory(parseInt(req.params.id));
      res.json(achievements);
    } catch (error) {
      console.error("Error fetching achievements:", error);
      res.status(500).json({ error: "Failed to fetch achievements" });
    }
  });
  app2.get("/api/payments/pending", async (req, res) => {
    try {
      const pendingPayments = await storage.getPendingPayments();
      res.json(pendingPayments);
    } catch (error) {
      console.error("Error fetching pending payments:", error);
      res.status(500).json({ message: "Failed to fetch pending payments" });
    }
  });
  app2.get("/api/payments/revenue-stats", async (req, res) => {
    try {
      const stats = await storage.getRevenueStats();
      res.json(stats);
    } catch (error) {
      console.error("Error fetching revenue stats:", error);
      res.status(500).json({ message: "Failed to fetch revenue stats" });
    }
  });
  app2.get("/api/attendance", requireAuth, async (req, res) => {
    try {
      const date2 = req.query.date;
      const batchId = req.query.batchId ? parseInt(req.query.batchId) : void 0;
      const attendance2 = await storage.getAttendanceByDate(date2, batchId);
      res.json(attendance2);
    } catch (error) {
      console.error("Error fetching attendance:", error);
      res.status(500).json({ message: "Failed to fetch attendance" });
    }
  });
  app2.post("/api/attendance", requireAuth, async (req, res) => {
    try {
      const attendanceData = insertAttendanceSchema.parse(req.body);
      const attendance2 = await storage.markAttendance({
        ...attendanceData,
        markedBy: req.session?.user?.id || 1
      });
      await storage.createActivity({
        type: "attendance_marked",
        description: `Attendance marked for ${attendanceData.date}`,
        userId: req.session?.user?.id || 1,
        entityId: attendance2.id,
        entityType: "attendance"
      });
      await gamificationService.triggerAttendanceEvent(attendance2.studentId, attendance2);
      broadcast({
        type: "attendance_marked",
        attendance: attendance2
      });
      res.status(201).json(attendance2);
    } catch (error) {
      console.error("Error marking attendance:", error);
      res.status(400).json({ message: "Failed to mark attendance" });
    }
  });
  app2.get("/api/attendance/student/:studentId", async (req, res) => {
    try {
      const studentId = parseInt(req.params.studentId);
      const startDate = req.query.startDate ? new Date(req.query.startDate) : void 0;
      const endDate = req.query.endDate ? new Date(req.query.endDate) : void 0;
      const attendance2 = await storage.getStudentAttendance(studentId, startDate, endDate);
      res.json(attendance2);
    } catch (error) {
      console.error("Error fetching student attendance:", error);
      res.status(500).json({ message: "Failed to fetch student attendance" });
    }
  });
  app2.get("/api/attendance/stats", async (req, res) => {
    try {
      const batchId = req.query.batchId ? parseInt(req.query.batchId) : void 0;
      const date2 = req.query.date ? new Date(req.query.date) : void 0;
      const stats = await storage.getAttendanceStats(batchId, date2);
      res.json(stats);
    } catch (error) {
      console.error("Error fetching attendance stats:", error);
      res.status(500).json({ message: "Failed to fetch attendance stats" });
    }
  });
  app2.get("/api/sports", requireAuth, async (req, res) => {
    try {
      const isActive = req.query.isActive ? req.query.isActive === "true" : void 0;
      const sports2 = await storage.getSports(isActive);
      res.json(sports2);
    } catch (error) {
      console.error("Error fetching sports:", error);
      res.status(500).json({ message: "Failed to fetch sports" });
    }
  });
  app2.get("/api/batches", requireAuth, async (req, res) => {
    try {
      const filters = {
        sportId: req.query.sportId ? parseInt(req.query.sportId) : void 0,
        coachId: req.query.coachId ? parseInt(req.query.coachId) : void 0,
        isActive: req.query.isActive ? req.query.isActive === "true" : void 0
      };
      const batches2 = await storage.getBatches(filters);
      res.json(batches2);
    } catch (error) {
      console.error("Error fetching batches:", error);
      res.status(500).json({ message: "Failed to fetch batches" });
    }
  });
  app2.post("/api/batches", requireAuth, async (req, res) => {
    try {
      const batchData = insertBatchSchema.parse(req.body);
      const batch = await storage.createBatch(batchData);
      await storage.createActivity({
        type: "batch_created",
        description: `New batch created: ${batch.name}`,
        userId: req.session?.user?.id || 1,
        entityId: batch.id,
        entityType: "batch"
      });
      res.status(201).json(batch);
    } catch (error) {
      console.error("Error creating batch:", error);
      res.status(400).json({ message: "Failed to create batch" });
    }
  });
  app2.patch("/api/batches/:id", async (req, res) => {
    try {
      const id = parseInt(req.params.id);
      const updates = req.body;
      const batch = await storage.updateBatch(id, updates);
      if (!batch) {
        return res.status(404).json({ message: "Batch not found" });
      }
      res.json(batch);
    } catch (error) {
      console.error("Error updating batch:", error);
      res.status(500).json({ message: "Failed to update batch" });
    }
  });
  app2.delete("/api/batches/:id", async (req, res) => {
    try {
      const id = parseInt(req.params.id);
      const batch = await storage.getBatch(id);
      if (!batch) {
        return res.status(404).json({ message: "Batch not found" });
      }
      const success = await storage.deleteBatch(id);
      await storage.createActivity({
        type: "batch_deleted",
        description: `Batch deleted: ${batch.name}`,
        userId: req.session?.user?.id || 1,
        entityId: batch.id,
        entityType: "batch"
      });
      broadcast({
        type: "batch_deleted",
        batchId: id
      });
      res.json({ message: "Batch deleted successfully" });
    } catch (error) {
      console.error("Error deleting batch:", error);
      const errorMessage = error instanceof Error ? error.message : "Failed to delete batch";
      res.status(400).json({ message: errorMessage });
    }
  });
  app2.get("/api/activities", async (req, res) => {
    try {
      const limit = parseInt(req.query.limit) || 50;
      const offset = parseInt(req.query.offset) || 0;
      const result = await storage.getActivities(limit, offset);
      res.json(result);
    } catch (error) {
      console.error("Error fetching activities:", error);
      res.status(500).json({ message: "Failed to fetch activities" });
    }
  });
  app2.get("/api/reports/students", async (req, res) => {
    try {
      const filters = {
        sportId: req.query.sportId ? parseInt(req.query.sportId) : void 0,
        batchId: req.query.batchId ? parseInt(req.query.batchId) : void 0,
        feeStatus: req.query.feeStatus
      };
      const students2 = await storage.getStudentReport(filters);
      res.json(students2);
    } catch (error) {
      console.error("Error fetching student report:", error);
      res.status(500).json({ message: "Failed to fetch student report" });
    }
  });
  app2.get("/api/reports/attendance", async (req, res) => {
    try {
      const startDate = new Date(req.query.startDate);
      const endDate = new Date(req.query.endDate);
      const batchId = req.query.batchId ? parseInt(req.query.batchId) : void 0;
      const report = await storage.getAttendanceReport(startDate, endDate, batchId);
      res.json(report);
    } catch (error) {
      console.error("Error fetching attendance report:", error);
      res.status(500).json({ message: "Failed to fetch attendance report" });
    }
  });
  app2.get("/api/export/students", async (req, res) => {
    try {
      const filters = {
        sportId: req.query.sportId ? parseInt(req.query.sportId) : void 0,
        batchId: req.query.batchId ? parseInt(req.query.batchId) : void 0,
        search: req.query.search,
        isActive: req.query.isActive ? req.query.isActive === "true" : void 0
      };
      const { students: students2 } = await storage.getStudents(filters);
      const filename = `students_export_${(/* @__PURE__ */ new Date()).toISOString().split("T")[0]}.xlsx`;
      const filePath = await reportGenerator.exportToExcel(students2, filename);
      res.download(filePath, filename, (err) => {
        if (err) {
          console.error("Error downloading file:", err);
          res.status(500).json({ message: "Error downloading file" });
        }
      });
    } catch (error) {
      console.error("Error exporting students:", error);
      res.status(500).json({ message: "Failed to export students" });
    }
  });
  app2.get("/api/export/payments", async (req, res) => {
    try {
      const filters = {
        status: req.query.status,
        monthYear: req.query.monthYear,
        search: req.query.search
      };
      const { payments: payments2 } = await storage.getPayments(filters);
      const filename = `payments_export_${(/* @__PURE__ */ new Date()).toISOString().split("T")[0]}.xlsx`;
      const filePath = await reportGenerator.exportToExcel(payments2, filename);
      res.download(filePath, filename, (err) => {
        if (err) {
          console.error("Error downloading file:", err);
          res.status(500).json({ message: "Error downloading file" });
        }
      });
    } catch (error) {
      console.error("Error exporting payments:", error);
      res.status(500).json({ message: "Failed to export payments" });
    }
  });
  app2.get("/api/export/attendance", async (req, res) => {
    try {
      const startDate = new Date(req.query.startDate);
      const endDate = new Date(req.query.endDate);
      const batchId = req.query.batchId ? parseInt(req.query.batchId) : void 0;
      const report = await storage.getAttendanceReport(startDate, endDate, batchId);
      const filename = `attendance_export_${(/* @__PURE__ */ new Date()).toISOString().split("T")[0]}.xlsx`;
      const filePath = await reportGenerator.exportToExcel(report.students, filename);
      res.download(filePath, filename, (err) => {
        if (err) {
          console.error("Error downloading file:", err);
          res.status(500).json({ message: "Error downloading file" });
        }
      });
    } catch (error) {
      console.error("Error exporting attendance:", error);
      res.status(500).json({ message: "Failed to export attendance" });
    }
  });
  app2.get("/api/reports/generate/:id", async (req, res) => {
    try {
      const reportId = parseInt(req.params.id);
      const executedBy = req.session?.user?.id || 1;
      const reportExecution = await reportGenerator.generateReport(reportId, executedBy);
      res.json(reportExecution);
    } catch (error) {
      console.error("Error generating report:", error);
      res.status(500).json({ message: "Failed to generate report" });
    }
  });
  app2.get("/api/reports/custom", async (req, res) => {
    try {
      const filters = {
        category: req.query.category,
        createdBy: req.query.createdBy ? parseInt(req.query.createdBy) : void 0
      };
      const reports = await storage.getCustomReports(filters);
      res.json(reports);
    } catch (error) {
      console.error("Error fetching custom reports:", error);
      res.status(500).json({ message: "Failed to fetch custom reports" });
    }
  });
  app2.post("/api/reports/custom", async (req, res) => {
    try {
      const reportData = req.body;
      const report = await storage.createCustomReport({
        ...reportData,
        createdBy: req.session?.user?.id || 1
      });
      res.json(report);
    } catch (error) {
      console.error("Error creating custom report:", error);
      res.status(500).json({ message: "Failed to create custom report" });
    }
  });
  app2.get("/api/reports/predefined", async (req, res) => {
    try {
      const predefinedReports = reportGenerator.getPredefinedReports();
      res.json(predefinedReports);
    } catch (error) {
      console.error("Error fetching predefined reports:", error);
      res.status(500).json({ message: "Failed to fetch predefined reports" });
    }
  });
  app2.post("/api/reports/execute", async (req, res) => {
    try {
      const { config } = req.body;
      const result = await reportGenerator.executeQuery(config);
      res.json(result);
    } catch (error) {
      console.error("Error executing report query:", error);
      res.status(500).json({ message: "Failed to execute report query" });
    }
  });
  app2.get("/api/settings", async (req, res) => {
    try {
      const settings2 = await storage.getSettings();
      const settingsMap = settings2.reduce((acc, setting) => {
        acc[setting.key] = setting.value;
        return acc;
      }, {});
      res.json(settingsMap);
    } catch (error) {
      console.error("Error fetching settings:", error);
      res.status(500).json({ error: "Failed to fetch settings" });
    }
  });
  app2.post("/api/settings", async (req, res) => {
    try {
      const { key, value, category = "general" } = req.body;
      const setting = await storage.setSetting(key, value, category);
      res.json(setting);
    } catch (error) {
      console.error("Error updating setting:", error);
      res.status(500).json({ error: "Failed to update setting" });
    }
  });
  app2.get("/api/sports/stats", async (req, res) => {
    try {
      const sports2 = await storage.getSports();
      const totalSports = sports2.length;
      const activeSports = sports2.filter((s) => s.isActive).length;
      const students2 = await storage.getStudents();
      const totalStudents = students2.students.length;
      const avgFee = sports2.reduce((sum3, sport) => sum3 + (sport.feeStructure?.skillLevels?.intermediate || 0), 0) / totalSports || 0;
      res.json({
        totalSports,
        activeSports,
        totalStudents,
        avgFee: Math.round(avgFee)
      });
    } catch (error) {
      console.error("Error fetching sports stats:", error);
      res.status(500).json({ error: "Failed to fetch sports stats" });
    }
  });
  app2.post("/api/sports", async (req, res) => {
    try {
      const sport = await storage.createSport(req.body);
      res.json(sport);
    } catch (error) {
      console.error("Error creating sport:", error);
      res.status(500).json({ error: "Failed to create sport" });
    }
  });
  app2.put("/api/sports/:id", async (req, res) => {
    try {
      const sport = await storage.updateSport(parseInt(req.params.id), req.body);
      res.json(sport);
    } catch (error) {
      console.error("Error updating sport:", error);
      res.status(500).json({ error: "Failed to update sport" });
    }
  });
  app2.get("/api/batches/stats", async (req, res) => {
    try {
      const batches2 = await storage.getBatches();
      const totalBatches = batches2.length;
      const activeBatches = batches2.filter((b) => b.isActive).length;
      const totalStudents = batches2.reduce((sum3, batch) => sum3 + (batch.currentCapacity || 0), 0);
      const avgCapacity = batches2.reduce((sum3, batch) => sum3 + (batch.currentCapacity || 0) / batch.maxCapacity * 100, 0) / totalBatches || 0;
      res.json({
        totalBatches,
        activeBatches,
        totalStudents,
        avgCapacity: Math.round(avgCapacity)
      });
    } catch (error) {
      console.error("Error fetching batch stats:", error);
      res.status(500).json({ error: "Failed to fetch batch stats" });
    }
  });
  app2.post("/api/batches", async (req, res) => {
    try {
      const batch = await storage.createBatch(req.body);
      res.json(batch);
    } catch (error) {
      console.error("Error creating batch:", error);
      res.status(500).json({ error: "Failed to create batch" });
    }
  });
  app2.put("/api/batches/:id", async (req, res) => {
    try {
      const batch = await storage.updateBatch(parseInt(req.params.id), req.body);
      res.json(batch);
    } catch (error) {
      console.error("Error updating batch:", error);
      res.status(500).json({ error: "Failed to update batch" });
    }
  });
  app2.get("/api/communications/stats", async (req, res) => {
    try {
      const communications2 = await storage.getCommunications();
      const totalSent = communications2.communications.length;
      const delivered = communications2.communications.filter((c) => c.status === "delivered").length;
      const failed = communications2.communications.filter((c) => c.status === "failed").length;
      const deliveryRate = totalSent > 0 ? Math.round(delivered / totalSent * 100) : 0;
      res.json({
        totalSent,
        delivered,
        failed,
        deliveryRate
      });
    } catch (error) {
      console.error("Error fetching communication stats:", error);
      res.status(500).json({ error: "Failed to fetch communication stats" });
    }
  });
  app2.post("/api/communications/send", async (req, res) => {
    try {
      const communication = await storage.createCommunication(req.body);
      res.json(communication);
    } catch (error) {
      console.error("Error sending communication:", error);
      res.status(500).json({ error: "Failed to send communication" });
    }
  });
  app2.get("/api/payment-gateways", async (req, res) => {
    try {
      const gateways = await storage.getPaymentGateways();
      res.json(gateways);
    } catch (error) {
      console.error("Error fetching payment gateways:", error);
      res.status(500).json({ error: "Failed to fetch payment gateways" });
    }
  });
  app2.post("/api/payment-gateways", async (req, res) => {
    try {
      const gateway = await storage.createPaymentGateway(req.body);
      res.json(gateway);
    } catch (error) {
      console.error("Error creating payment gateway:", error);
      res.status(500).json({ error: "Failed to create payment gateway" });
    }
  });
  app2.put("/api/payment-gateways/:id", async (req, res) => {
    try {
      const id = parseInt(req.params.id);
      const gateway = await storage.updatePaymentGateway(id, req.body);
      if (!gateway) {
        return res.status(404).json({ error: "Payment gateway not found" });
      }
      res.json(gateway);
    } catch (error) {
      console.error("Error updating payment gateway:", error);
      res.status(500).json({ error: "Failed to update payment gateway" });
    }
  });
  app2.delete("/api/payment-gateways/:id", async (req, res) => {
    try {
      const id = parseInt(req.params.id);
      const success = await storage.deletePaymentGateway(id);
      if (success) {
        res.json({ success: true });
      } else {
        res.status(404).json({ error: "Payment gateway not found" });
      }
    } catch (error) {
      console.error("Error deleting payment gateway:", error);
      res.status(500).json({ error: "Failed to delete payment gateway" });
    }
  });
  app2.get("/api/icons", async (req, res) => {
    try {
      const icons2 = await storage.getIcons();
      res.json(icons2);
    } catch (error) {
      console.error("Error fetching icons:", error);
      res.status(500).json({ error: "Failed to fetch icons" });
    }
  });
  app2.post("/api/icons", async (req, res) => {
    try {
      const icon = await storage.createIcon(req.body);
      res.json(icon);
    } catch (error) {
      console.error("Error creating icon:", error);
      res.status(500).json({ error: "Failed to create icon" });
    }
  });
  app2.get("/api/coaches", async (req, res) => {
    try {
      const coaches2 = await storage.getCoaches();
      res.json(coaches2);
    } catch (error) {
      console.error("Error fetching coaches:", error);
      res.status(500).json({ error: "Failed to fetch coaches" });
    }
  });
  app2.get("/api/coaches/stats", async (req, res) => {
    try {
      const coaches2 = await storage.getCoaches();
      const totalCoaches = coaches2.length;
      const activeCoaches = coaches2.filter((c) => c.isActive).length;
      const avgExperience = coaches2.reduce((sum3, coach) => sum3 + (coach.experience || 0), 0) / totalCoaches || 0;
      const students2 = await storage.getStudents();
      const totalStudents = students2.students.length;
      res.json({
        totalCoaches,
        activeCoaches,
        avgExperience: Math.round(avgExperience),
        totalStudents
      });
    } catch (error) {
      console.error("Error fetching coach stats:", error);
      res.status(500).json({ error: "Failed to fetch coach stats" });
    }
  });
  app2.post("/api/coaches", async (req, res) => {
    try {
      const coach = await storage.createCoach(req.body);
      res.json(coach);
    } catch (error) {
      console.error("Error creating coach:", error);
      res.status(500).json({ error: "Failed to create coach" });
    }
  });
  app2.put("/api/coaches/:id", async (req, res) => {
    try {
      const coach = await storage.updateCoach(parseInt(req.params.id), req.body);
      res.json(coach);
    } catch (error) {
      console.error("Error updating coach:", error);
      res.status(500).json({ error: "Failed to update coach" });
    }
  });
  app2.delete("/api/coaches/:id", async (req, res) => {
    try {
      const success = await storage.deleteCoach(parseInt(req.params.id));
      if (success) {
        res.json({ success: true });
      } else {
        res.status(404).json({ error: "Coach not found" });
      }
    } catch (error) {
      console.error("Error deleting coach:", error);
      const errorMessage = error instanceof Error ? error.message : "Failed to delete coach";
      res.status(400).json({ error: errorMessage });
    }
  });
  app2.get("/api/ai-insights/student-analysis", async (req, res) => {
    try {
      const { generateStudentInsights: generateStudentInsights2 } = await Promise.resolve().then(() => (init_ai_insights(), ai_insights_exports));
      const insights = await generateStudentInsights2();
      res.json(insights);
    } catch (error) {
      console.error("Student insights error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/ai-insights/revenue-analysis", async (req, res) => {
    try {
      const { generateRevenueAnalysis: generateRevenueAnalysis2 } = await Promise.resolve().then(() => (init_ai_insights(), ai_insights_exports));
      const analysis = await generateRevenueAnalysis2();
      res.json(analysis);
    } catch (error) {
      console.error("Revenue analysis error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/ai-insights/attendance-insights", async (req, res) => {
    try {
      const { generateAttendanceInsights: generateAttendanceInsights2 } = await Promise.resolve().then(() => (init_ai_insights(), ai_insights_exports));
      const insights = await generateAttendanceInsights2();
      res.json(insights);
    } catch (error) {
      console.error("Attendance insights error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/ai-insights/retention-forecast", async (req, res) => {
    try {
      const { generateRetentionForecast: generateRetentionForecast2 } = await Promise.resolve().then(() => (init_ai_insights(), ai_insights_exports));
      const forecast = await generateRetentionForecast2();
      res.json(forecast);
    } catch (error) {
      console.error("Retention forecast error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/ai-insights/query", async (req, res) => {
    try {
      const { query } = req.body;
      if (!query) {
        return res.status(400).json({ error: "Query is required" });
      }
      const { generateAIResponse: generateAIResponse2 } = await Promise.resolve().then(() => (init_ai_insights(), ai_insights_exports));
      const response = await generateAIResponse2(query);
      res.json(response);
    } catch (error) {
      console.error("AI query error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/badges", async (req, res) => {
    try {
      const badges2 = await storage.getBadges();
      res.json(badges2);
    } catch (error) {
      console.error("Error fetching badges:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/badges", async (req, res) => {
    try {
      const badge = await storage.createBadge(req.body);
      res.json(badge);
    } catch (error) {
      console.error("Error creating badge:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/students/:id/badges", async (req, res) => {
    try {
      const studentId = parseInt(req.params.id);
      const badges2 = await storage.getStudentBadges(studentId);
      res.json(badges2);
    } catch (error) {
      console.error("Error fetching student badges:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/students/:id/points", async (req, res) => {
    try {
      const studentId = parseInt(req.params.id);
      const points = await storage.getStudentPoints(studentId);
      res.json(points);
    } catch (error) {
      console.error("Error fetching student points:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/students/:id/achievements", async (req, res) => {
    try {
      const studentId = parseInt(req.params.id);
      const achievements = await storage.getAchievementHistory(studentId);
      res.json(achievements);
    } catch (error) {
      console.error("Error fetching achievement history:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/students/:id/award-badge", async (req, res) => {
    try {
      const studentId = parseInt(req.params.id);
      const { badgeId } = req.body;
      const studentBadge = await storage.createStudentBadge({
        studentId,
        badgeId,
        earnedAt: /* @__PURE__ */ new Date(),
        progress: {},
        isDisplayed: true
      });
      res.json(studentBadge);
    } catch (error) {
      console.error("Error awarding badge:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/students/:id/add-points", async (req, res) => {
    try {
      const studentId = parseInt(req.params.id);
      const { points } = req.body;
      await storage.addStudentPoints(studentId, points);
      res.json({ success: true });
    } catch (error) {
      console.error("Error adding points:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/notifications/fee-reminder", async (req, res) => {
    try {
      const { sendFeeReminder: sendFeeReminder2 } = await Promise.resolve().then(() => (init_notifications(), notifications_exports));
      const { studentId, amount, dueDate } = req.body;
      const result = await sendFeeReminder2(studentId, amount, dueDate);
      res.json(result);
    } catch (error) {
      console.error("Fee reminder error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/notifications/payment-confirmation", async (req, res) => {
    try {
      const { sendPaymentConfirmation: sendPaymentConfirmation2 } = await Promise.resolve().then(() => (init_notifications(), notifications_exports));
      const { studentId, amount, paymentMethod } = req.body;
      const result = await sendPaymentConfirmation2(studentId, amount, paymentMethod);
      res.json(result);
    } catch (error) {
      console.error("Payment confirmation error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/notifications/bulk-notification", async (req, res) => {
    try {
      const { sendBulkNotification: sendBulkNotification2 } = await Promise.resolve().then(() => (init_notifications(), notifications_exports));
      const { recipients, message } = req.body;
      const result = await sendBulkNotification2(recipients, message);
      res.json(result);
    } catch (error) {
      console.error("Bulk notification error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/campaigns", async (req, res) => {
    try {
      const { status, type } = req.query;
      const campaigns2 = await storage.getCampaigns({
        status,
        type
      });
      res.json(campaigns2);
    } catch (error) {
      console.error("Error fetching campaigns:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/campaigns/:id", async (req, res) => {
    try {
      const campaign = await storage.getCampaign(parseInt(req.params.id));
      if (!campaign) {
        return res.status(404).json({ error: "Campaign not found" });
      }
      res.json(campaign);
    } catch (error) {
      console.error("Error fetching campaign:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/campaigns", async (req, res) => {
    try {
      const { insertCampaignSchema: insertCampaignSchema3 } = await Promise.resolve().then(() => (init_schema(), schema_exports));
      const campaignData = insertCampaignSchema3.parse(req.body);
      const campaign = await storage.createCampaign(campaignData);
      if (campaign.status === "active" && campaign.trigger === "automated") {
        const { CampaignAutomation: CampaignAutomation2 } = await Promise.resolve().then(() => (init_campaign_automation(), campaign_automation_exports));
        const automation = CampaignAutomation2.getInstance();
        await automation.restartCampaignAutomation(campaign.id);
      }
      res.json(campaign);
    } catch (error) {
      console.error("Error creating campaign:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.put("/api/campaigns/:id", async (req, res) => {
    try {
      const campaign = await storage.updateCampaign(parseInt(req.params.id), req.body);
      if (!campaign) {
        return res.status(404).json({ error: "Campaign not found" });
      }
      if (campaign.status === "active" && campaign.trigger === "automated") {
        const { CampaignAutomation: CampaignAutomation2 } = await Promise.resolve().then(() => (init_campaign_automation(), campaign_automation_exports));
        const automation = CampaignAutomation2.getInstance();
        await automation.restartCampaignAutomation(campaign.id);
      }
      res.json(campaign);
    } catch (error) {
      console.error("Error updating campaign:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.delete("/api/campaigns/:id", async (req, res) => {
    try {
      const success = await storage.deleteCampaign(parseInt(req.params.id));
      if (!success) {
        return res.status(404).json({ error: "Campaign not found" });
      }
      const { CampaignAutomation: CampaignAutomation2 } = await Promise.resolve().then(() => (init_campaign_automation(), campaign_automation_exports));
      const automation = CampaignAutomation2.getInstance();
      automation.stopCampaignAutomation(parseInt(req.params.id));
      res.json({ success: true });
    } catch (error) {
      console.error("Error deleting campaign:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/campaigns/:id/messages", async (req, res) => {
    try {
      const messages = await storage.getCampaignMessages(parseInt(req.params.id));
      res.json(messages);
    } catch (error) {
      console.error("Error fetching campaign messages:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/campaigns/:id/analytics", async (req, res) => {
    try {
      const analytics = await storage.getCampaignAnalytics(parseInt(req.params.id));
      res.json(analytics);
    } catch (error) {
      console.error("Error fetching campaign analytics:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/campaigns/:id/run", async (req, res) => {
    try {
      const campaign = await storage.getCampaign(parseInt(req.params.id));
      if (!campaign) {
        return res.status(404).json({ error: "Campaign not found" });
      }
      res.json({ success: true, message: "Campaign execution started" });
    } catch (error) {
      console.error("Error running campaign:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/message-templates", async (req, res) => {
    try {
      const { category } = req.query;
      const templates = await storage.getMessageTemplates(category);
      res.json(templates);
    } catch (error) {
      console.error("Error fetching message templates:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/message-templates", async (req, res) => {
    try {
      const { insertMessageTemplateSchema: insertMessageTemplateSchema3 } = await Promise.resolve().then(() => (init_schema(), schema_exports));
      const templateData = insertMessageTemplateSchema3.parse(req.body);
      const template = await storage.createMessageTemplate(templateData);
      res.json(template);
    } catch (error) {
      console.error("Error creating message template:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/campaigns/templates/predefined", async (req, res) => {
    try {
      const { campaignTemplates: campaignTemplates2 } = await Promise.resolve().then(() => (init_campaign_automation(), campaign_automation_exports));
      res.json(campaignTemplates2);
    } catch (error) {
      console.error("Error fetching predefined templates:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/payments/pending-grouped", async (req, res) => {
    try {
      const pendingPayments = await storage.getPendingPayments();
      const grouped = pendingPayments.reduce((acc, payment) => {
        const sportName = payment.student?.batch?.sport?.name || "Unknown Sport";
        const batchName = payment.student?.batch?.name || "Unknown Batch";
        if (!acc[sportName]) {
          acc[sportName] = {};
        }
        if (!acc[sportName][batchName]) {
          acc[sportName][batchName] = [];
        }
        acc[sportName][batchName].push(payment);
        return acc;
      }, {});
      res.json(grouped);
    } catch (error) {
      console.error("Grouped pending payments error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/reports/generate/:type", async (req, res) => {
    try {
      const { type } = req.params;
      const { startDate, endDate, ...filters } = req.query;
      let report;
      switch (type) {
        case "student":
          report = await storage.getStudentReport(filters);
          break;
        case "revenue":
          report = await storage.getMonthlyRevenueReport(parseInt(filters.year) || (/* @__PURE__ */ new Date()).getFullYear());
          break;
        case "attendance":
          report = await storage.getAttendanceReport(
            new Date(startDate),
            new Date(endDate),
            filters.batchId ? parseInt(filters.batchId) : void 0
          );
          break;
        default:
          return res.status(400).json({ error: "Invalid report type" });
      }
      res.json(report);
    } catch (error) {
      console.error("Report generation error:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/reports", async (req, res) => {
    try {
      const { category, createdBy } = req.query;
      const reports = await storage.getCustomReports({
        category,
        createdBy: createdBy ? parseInt(createdBy) : void 0
      });
      res.json(reports);
    } catch (error) {
      console.error("Error fetching reports:", error);
      res.status(500).json({ error: "Failed to fetch reports" });
    }
  });
  app2.get("/api/reports/:id", async (req, res) => {
    try {
      const { id } = req.params;
      const report = await storage.getCustomReport(parseInt(id));
      if (!report) {
        return res.status(404).json({ error: "Report not found" });
      }
      res.json(report);
    } catch (error) {
      console.error("Error fetching report:", error);
      res.status(500).json({ error: "Failed to fetch report" });
    }
  });
  app2.post("/api/reports", async (req, res) => {
    try {
      const reportData = req.body;
      const report = await storage.createCustomReport(reportData);
      res.json(report);
    } catch (error) {
      console.error("Error creating report:", error);
      res.status(500).json({ error: "Failed to create report" });
    }
  });
  app2.put("/api/reports/:id", async (req, res) => {
    try {
      const { id } = req.params;
      const updates = req.body;
      const report = await storage.updateCustomReport(parseInt(id), updates);
      res.json(report);
    } catch (error) {
      console.error("Error updating report:", error);
      res.status(500).json({ error: "Failed to update report" });
    }
  });
  app2.delete("/api/reports/:id", async (req, res) => {
    try {
      const { id } = req.params;
      await storage.deleteCustomReport(parseInt(id));
      res.json({ success: true });
    } catch (error) {
      console.error("Error deleting report:", error);
      res.status(500).json({ error: "Failed to delete report" });
    }
  });
  app2.post("/api/reports/:id/execute", async (req, res) => {
    try {
      const { id } = req.params;
      const { reportGenerator: reportGenerator2 } = await Promise.resolve().then(() => (init_report_generator(), report_generator_exports));
      const execution = await reportGenerator2.generateReport(parseInt(id), 1);
      res.json(execution);
    } catch (error) {
      console.error("Error executing report:", error);
      res.status(500).json({ error: "Failed to execute report" });
    }
  });
  app2.post("/api/students/register", async (req, res) => {
    try {
      const {
        phone,
        name,
        email,
        dateOfBirth,
        gender,
        address,
        emergencyContact,
        sportId,
        batchId,
        registrationFee,
        enrollmentDate
      } = req.body;
      const existingStudent = await storage.getStudentByPhone(phone);
      if (existingStudent) {
        return res.status(400).json({
          success: false,
          message: "Student with this phone number already exists"
        });
      }
      const student = await storage.createStudent({
        name,
        email,
        phone,
        dateOfBirth,
        gender,
        address,
        emergencyContact,
        sportId: parseInt(sportId),
        batchId: parseInt(batchId),
        status: "active",
        enrollmentDate: new Date(enrollmentDate),
        createdAt: /* @__PURE__ */ new Date(),
        updatedAt: /* @__PURE__ */ new Date()
      });
      if (registrationFee > 0) {
        await storage.createPayment({
          studentId: student.id,
          amount: registrationFee,
          paymentMethod: "online",
          paymentType: "registration",
          status: "completed",
          month: (/* @__PURE__ */ new Date()).getMonth() + 1,
          year: (/* @__PURE__ */ new Date()).getFullYear(),
          paidAt: /* @__PURE__ */ new Date(),
          createdAt: /* @__PURE__ */ new Date()
        });
      }
      try {
        const welcomeBadge = await storage.getBadgeByName("Welcome to Academy");
        if (welcomeBadge) {
          await storage.createStudentBadge({
            studentId: student.id,
            badgeId: welcomeBadge.id,
            earnedAt: /* @__PURE__ */ new Date(),
            progress: {},
            isDisplayed: true
          });
        }
      } catch (error) {
        console.log("Welcome badge not found, skipping badge award");
      }
      res.json({
        success: true,
        message: "Registration completed successfully",
        student: {
          id: student.id,
          name: student.name,
          email: student.email,
          phone: student.phone
        }
      });
    } catch (error) {
      console.error("Student registration error:", error);
      res.status(500).json({
        success: false,
        message: error.message || "Registration failed"
      });
    }
  });
  app2.get("/api/students/check-phone/:phone", async (req, res) => {
    try {
      const { phone } = req.params;
      const student = await storage.getStudentByPhone(phone);
      res.json({
        exists: !!student,
        student: student ? {
          id: student.id,
          name: student.name,
          email: student.email
        } : null
      });
    } catch (error) {
      console.error("Phone check error:", error);
      res.status(500).json({
        success: false,
        message: "Failed to check phone number"
      });
    }
  });
  app2.get("/api/reports/:id/executions", async (req, res) => {
    try {
      const { id } = req.params;
      const executions = await storage.getReportExecutions(parseInt(id));
      res.json(executions);
    } catch (error) {
      console.error("Error fetching executions:", error);
      res.status(500).json({ error: "Failed to fetch executions" });
    }
  });
  app2.get("/api/executions/:id", async (req, res) => {
    try {
      const { id } = req.params;
      const execution = await storage.getReportExecution(parseInt(id));
      if (!execution) {
        return res.status(404).json({ error: "Execution not found" });
      }
      res.json(execution);
    } catch (error) {
      console.error("Error fetching execution:", error);
      res.status(500).json({ error: "Failed to fetch execution" });
    }
  });
  app2.get("/api/saved-queries", async (req, res) => {
    try {
      const { createdBy } = req.query;
      const queries = await storage.getSavedQueries(createdBy ? parseInt(createdBy) : void 0);
      res.json(queries);
    } catch (error) {
      console.error("Error fetching saved queries:", error);
      res.status(500).json({ error: "Failed to fetch saved queries" });
    }
  });
  app2.post("/api/saved-queries", async (req, res) => {
    try {
      const queryData = req.body;
      const query = await storage.createSavedQuery(queryData);
      res.json(query);
    } catch (error) {
      console.error("Error creating saved query:", error);
      res.status(500).json({ error: "Failed to create saved query" });
    }
  });
  app2.put("/api/saved-queries/:id", async (req, res) => {
    try {
      const { id } = req.params;
      const updates = req.body;
      const query = await storage.updateSavedQuery(parseInt(id), updates);
      res.json(query);
    } catch (error) {
      console.error("Error updating saved query:", error);
      res.status(500).json({ error: "Failed to update saved query" });
    }
  });
  app2.delete("/api/saved-queries/:id", async (req, res) => {
    try {
      const { id } = req.params;
      await storage.deleteSavedQuery(parseInt(id));
      res.json({ success: true });
    } catch (error) {
      console.error("Error deleting saved query:", error);
      res.status(500).json({ error: "Failed to delete saved query" });
    }
  });
  app2.get("/api/reports/templates/predefined", async (req, res) => {
    try {
      const { reportGenerator: reportGenerator2 } = await Promise.resolve().then(() => (init_report_generator(), report_generator_exports));
      const templates = reportGenerator2.getPredefinedReports();
      res.json(templates);
    } catch (error) {
      console.error("Error fetching predefined templates:", error);
      res.status(500).json({ error: "Failed to fetch predefined templates" });
    }
  });
  app2.post("/api/reports/execute-query", async (req, res) => {
    try {
      const { queryConfig } = req.body;
      const { reportGenerator: reportGenerator2 } = await Promise.resolve().then(() => (init_report_generator(), report_generator_exports));
      const results = await reportGenerator2.executeQuery(queryConfig);
      res.json(results);
    } catch (error) {
      console.error("Error executing query:", error);
      res.status(500).json({ error: "Failed to execute query" });
    }
  });
  app2.post("/api/location/track", async (req, res) => {
    try {
      const { userId, latitude, longitude, accuracy, trackingType } = req.body;
      const locationData = {
        latitude: parseFloat(latitude),
        longitude: parseFloat(longitude),
        accuracy: parseInt(accuracy),
        timestamp: /* @__PURE__ */ new Date()
      };
      const result = await locationTrackingService.trackLocation(userId, locationData, trackingType);
      res.json(result);
    } catch (error) {
      console.error("Error tracking location:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/location/history/:userId", async (req, res) => {
    try {
      const { userId } = req.params;
      const { limit = 50 } = req.query;
      const history = await locationTrackingService.getUserLocationHistory(parseInt(userId), parseInt(limit));
      res.json(history);
    } catch (error) {
      console.error("Error fetching location history:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/location/live", async (req, res) => {
    try {
      const liveLocations = await locationTrackingService.getLiveCoachLocations();
      res.json(liveLocations);
    } catch (error) {
      console.error("Error fetching live locations:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/geofences", async (req, res) => {
    try {
      const { name, description, centerLatitude, centerLongitude, radius, createdBy } = req.body;
      const geofenceData = {
        name,
        description,
        centerLatitude: parseFloat(centerLatitude),
        centerLongitude: parseFloat(centerLongitude),
        radius: parseInt(radius),
        createdBy: parseInt(createdBy)
      };
      const result = await locationTrackingService.createGeofence(geofenceData);
      res.json(result);
    } catch (error) {
      console.error("Error creating geofence:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/geofences", async (req, res) => {
    try {
      const geofences2 = await locationTrackingService.getGeofences();
      res.json(geofences2);
    } catch (error) {
      console.error("Error fetching geofences:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/coach/checkin", async (req, res) => {
    try {
      const { coachId, batchId, latitude, longitude, accuracy } = req.body;
      const locationData = {
        latitude: parseFloat(latitude),
        longitude: parseFloat(longitude),
        accuracy: parseInt(accuracy),
        timestamp: /* @__PURE__ */ new Date()
      };
      const result = await locationTrackingService.coachCheckIn(
        parseInt(coachId),
        parseInt(batchId),
        locationData
      );
      res.json(result);
    } catch (error) {
      console.error("Error in coach check-in:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/coach/checkout", async (req, res) => {
    try {
      const { coachId, batchId, latitude, longitude, accuracy } = req.body;
      const locationData = {
        latitude: parseFloat(latitude),
        longitude: parseFloat(longitude),
        accuracy: parseInt(accuracy),
        timestamp: /* @__PURE__ */ new Date()
      };
      const result = await locationTrackingService.coachCheckOut(
        parseInt(coachId),
        parseInt(batchId),
        locationData
      );
      res.json(result);
    } catch (error) {
      console.error("Error in coach check-out:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/coach/attendance/:coachId", async (req, res) => {
    try {
      const { coachId } = req.params;
      const { limit = 30 } = req.query;
      const history = await locationTrackingService.getCoachAttendanceHistory(
        parseInt(coachId),
        parseInt(limit)
      );
      res.json(history);
    } catch (error) {
      console.error("Error fetching coach attendance:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.post("/api/users", async (req, res) => {
    try {
      const { name, email, phone, role, permissions: permissions2, createdBy } = req.body;
      const userData = {
        name,
        email,
        phone,
        role,
        permissions: permissions2 || [],
        createdBy: parseInt(createdBy)
      };
      const result = await userPermissionService.createUser(userData);
      res.json(result);
    } catch (error) {
      console.error("Error creating user:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/users", async (req, res) => {
    try {
      const users2 = await userPermissionService.getUsers();
      res.json(users2);
    } catch (error) {
      console.error("Error fetching users:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/users/:userId/permissions", async (req, res) => {
    try {
      const { userId } = req.params;
      const permissions2 = await userPermissionService.getUserPermissions(parseInt(userId));
      res.json(permissions2);
    } catch (error) {
      console.error("Error fetching user permissions:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.put("/api/users/:userId/permissions", async (req, res) => {
    try {
      const { userId } = req.params;
      const { permissions: permissions2 } = req.body;
      const result = await userPermissionService.updateUserPermissions(
        parseInt(userId),
        permissions2
      );
      res.json(result);
    } catch (error) {
      console.error("Error updating user permissions:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.put("/api/users/:userId/role", async (req, res) => {
    try {
      const { userId } = req.params;
      const { role } = req.body;
      const result = await userPermissionService.updateUserRole(parseInt(userId), role);
      res.json(result);
    } catch (error) {
      console.error("Error updating user role:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.put("/api/users/:userId/deactivate", async (req, res) => {
    try {
      const { userId } = req.params;
      const result = await userPermissionService.deactivateUser(parseInt(userId));
      res.json(result);
    } catch (error) {
      console.error("Error deactivating user:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.put("/api/users/:userId/activate", async (req, res) => {
    try {
      const { userId } = req.params;
      const result = await userPermissionService.activateUser(parseInt(userId));
      res.json(result);
    } catch (error) {
      console.error("Error activating user:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/permissions", async (req, res) => {
    try {
      const permissions2 = await userPermissionService.getPermissions();
      res.json(permissions2);
    } catch (error) {
      console.error("Error fetching permissions:", error);
      res.status(500).json({ error: error.message });
    }
  });
  app2.get("/api/icons", async (req, res) => {
    try {
      const iconsDir = path2.join(process.cwd(), "uploads/icons");
      if (!fs2.existsSync(iconsDir)) {
        return res.json([]);
      }
      const files = fs2.readdirSync(iconsDir);
      const icons2 = files.filter((file) => /\.(jpg|jpeg|png|gif|svg)$/i.test(file)).map((file, index) => ({
        id: index + 1,
        name: file,
        url: `/uploads/icons/${file}`,
        uploadDate: fs2.statSync(path2.join(iconsDir, file)).mtime
      }));
      res.json(icons2);
    } catch (error) {
      console.error("Error fetching icons:", error);
      res.status(500).json({ error: "Failed to fetch icons" });
    }
  });
  app2.post("/api/seed-database", async (req, res) => {
    try {
      console.log("\u{1F331} Starting database seeding...");
      console.log("\u{1F4CA} Adding sample sports...");
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
          const existingSport = await storage.getSportByName(sport.name);
          if (!existingSport) {
            const insertedSport = await storage.createSport(sport);
            insertedSports.push(insertedSport);
            console.log(`\u2705 Added sport: ${sport.name}`);
          } else {
            insertedSports.push(existingSport);
            console.log(`\u26A0\uFE0F  Sport ${sport.name} already exists, using existing...`);
          }
        } catch (error) {
          console.log(`\u274C Error adding sport ${sport.name}:`, error);
        }
      }
      const allSports = await storage.getSports();
      console.log(`\u{1F4CA} Total sports in database: ${allSports.length}`);
      console.log("\u{1F3C3} Adding sample batches...");
      const sampleBatches = [
        {
          name: "Morning Cricket Beginners",
          sportId: allSports.find((s) => s.name === "Cricket")?.id || 1,
          coachId: null,
          schedule: { days: ["monday", "wednesday", "friday"], time: "6:00 AM - 8:00 AM" },
          maxCapacity: 20,
          currentCapacity: 0,
          skillLevel: "beginner",
          isActive: true
        },
        {
          name: "Evening Cricket Advanced",
          sportId: allSports.find((s) => s.name === "Cricket")?.id || 1,
          coachId: null,
          schedule: { days: ["tuesday", "thursday", "saturday"], time: "5:00 PM - 7:00 PM" },
          maxCapacity: 20,
          currentCapacity: 0,
          skillLevel: "advanced",
          isActive: true
        },
        {
          name: "Morning Football Training",
          sportId: allSports.find((s) => s.name === "Football")?.id || 2,
          coachId: null,
          schedule: { days: ["monday", "wednesday", "friday"], time: "7:00 AM - 9:00 AM" },
          maxCapacity: 25,
          currentCapacity: 0,
          skillLevel: "intermediate",
          isActive: true
        },
        {
          name: "Weekend Football Camp",
          sportId: allSports.find((s) => s.name === "Football")?.id || 2,
          coachId: null,
          schedule: { days: ["saturday", "sunday"], time: "4:00 PM - 6:00 PM" },
          maxCapacity: 30,
          currentCapacity: 0,
          skillLevel: "beginner",
          isActive: true
        },
        {
          name: "Basketball Fundamentals",
          sportId: allSports.find((s) => s.name === "Basketball")?.id || 3,
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
          const insertedBatch = await storage.createBatch(batch);
          insertedBatches.push(insertedBatch);
          console.log(`\u2705 Added batch: ${batch.name}`);
        } catch (error) {
          console.log(`\u274C Error adding batch ${batch.name}:`, error);
        }
      }
      const allBatches = await storage.getBatches();
      console.log(`\u{1F3C3} Total batches in database: ${allBatches.length}`);
      console.log("\u{1F393} Adding sample students...");
      const sampleStudents = [
        {
          studentId: "PSA001",
          name: "Arjun Sharma",
          phone: "9876543210",
          email: "arjun.sharma@email.com",
          dateOfBirth: /* @__PURE__ */ new Date("2008-05-15"),
          address: "123 MG Road, Nashik",
          emergencyContact: "9876543211",
          sportId: allSports.find((s) => s.name === "Cricket")?.id || 1,
          batchId: allBatches.find((b) => b.name?.includes("Cricket"))?.id || 1,
          joiningDate: /* @__PURE__ */ new Date("2024-01-15"),
          isActive: true,
          skillLevel: "beginner"
        },
        {
          studentId: "PSA002",
          name: "Priya Patel",
          phone: "9876543212",
          email: "priya.patel@email.com",
          dateOfBirth: /* @__PURE__ */ new Date("2009-08-22"),
          address: "456 College Road, Nashik",
          emergencyContact: "9876543213",
          sportId: allSports.find((s) => s.name === "Football")?.id || 2,
          batchId: allBatches.find((b) => b.name?.includes("Football"))?.id || 2,
          joiningDate: /* @__PURE__ */ new Date("2024-02-01"),
          isActive: true,
          skillLevel: "intermediate"
        },
        {
          studentId: "PSA003",
          name: "Rahul Desai",
          phone: "9876543214",
          email: "rahul.desai@email.com",
          dateOfBirth: /* @__PURE__ */ new Date("2007-12-10"),
          address: "789 Gangapur Road, Nashik",
          emergencyContact: "9876543215",
          sportId: allSports.find((s) => s.name === "Basketball")?.id || 3,
          batchId: allBatches.find((b) => b.name?.includes("Basketball"))?.id || 3,
          joiningDate: /* @__PURE__ */ new Date("2024-01-20"),
          isActive: true,
          skillLevel: "advanced"
        },
        {
          studentId: "PSA004",
          name: "Sneha Kulkarni",
          phone: "9876543216",
          email: "sneha.kulkarni@email.com",
          dateOfBirth: /* @__PURE__ */ new Date("2008-03-18"),
          address: "321 Panchavati, Nashik",
          emergencyContact: "9876543217",
          sportId: allSports.find((s) => s.name === "Tennis")?.id || 4,
          batchId: allBatches[0]?.id || 1,
          joiningDate: /* @__PURE__ */ new Date("2024-02-15"),
          isActive: true,
          skillLevel: "beginner"
        },
        {
          studentId: "PSA005",
          name: "Vikram Singh",
          phone: "9876543218",
          email: "vikram.singh@email.com",
          dateOfBirth: /* @__PURE__ */ new Date("2009-06-25"),
          address: "654 Satpur, Nashik",
          emergencyContact: "9876543219",
          sportId: allSports.find((s) => s.name === "Cricket")?.id || 1,
          batchId: allBatches.find((b) => b.name?.includes("Cricket") && b.skillLevel === "advanced")?.id || 1,
          joiningDate: /* @__PURE__ */ new Date("2024-01-10"),
          isActive: true,
          skillLevel: "advanced"
        },
        {
          studentId: "PSA006",
          name: "Anita Joshi",
          phone: "9876543220",
          email: "anita.joshi@email.com",
          dateOfBirth: /* @__PURE__ */ new Date("2008-11-30"),
          address: "987 Cidco, Nashik",
          emergencyContact: "9876543221",
          sportId: allSports.find((s) => s.name === "Badminton")?.id || 5,
          batchId: allBatches[0]?.id || 1,
          joiningDate: /* @__PURE__ */ new Date("2024-03-01"),
          isActive: true,
          skillLevel: "intermediate"
        },
        {
          studentId: "PSA007",
          name: "Karan Mehta",
          phone: "9876543222",
          email: "karan.mehta@email.com",
          dateOfBirth: /* @__PURE__ */ new Date("2007-09-14"),
          address: "147 Deolali, Nashik",
          emergencyContact: "9876543223",
          sportId: allSports.find((s) => s.name === "Football")?.id || 2,
          batchId: allBatches.find((b) => b.name?.includes("Weekend Football"))?.id || 2,
          joiningDate: /* @__PURE__ */ new Date("2024-01-25"),
          isActive: true,
          skillLevel: "beginner"
        },
        {
          studentId: "PSA008",
          name: "Pooja Agarwal",
          phone: "9876543224",
          email: "pooja.agarwal@email.com",
          dateOfBirth: /* @__PURE__ */ new Date("2008-07-08"),
          address: "258 Ashok Stambh, Nashik",
          emergencyContact: "9876543225",
          sportId: allSports.find((s) => s.name === "Basketball")?.id || 3,
          batchId: allBatches.find((b) => b.name?.includes("Basketball"))?.id || 3,
          joiningDate: /* @__PURE__ */ new Date("2024-02-10"),
          isActive: true,
          skillLevel: "intermediate"
        }
      ];
      let studentsAdded = 0;
      for (const student of sampleStudents) {
        try {
          const insertedStudent = await storage.createStudent(student);
          studentsAdded++;
          console.log(`\u2705 Added student: ${student.name} (${student.studentId})`);
        } catch (error) {
          console.log(`\u274C Error adding student ${student.name}:`, error);
        }
      }
      const { total: totalStudents } = await storage.getStudents();
      console.log(`\u{1F393} Total students in database: ${totalStudents}`);
      console.log("\u{1F389} Database seeding completed successfully!");
      res.json({
        success: true,
        message: "Database seeded successfully!",
        summary: {
          sports: allSports.length,
          batches: allBatches.length,
          studentsAdded,
          totalStudents
        }
      });
    } catch (error) {
      console.error("\u274C Error seeding database:", error);
      res.status(500).json({
        success: false,
        message: "Failed to seed database",
        error: error instanceof Error ? error.message : "Unknown error"
      });
    }
  });
  await userPermissionService.initializeDefaultPermissions();
  return httpServer;
}

// server/vite.ts
import express3 from "express";
import fs3 from "fs";
import path4 from "path";
import { createServer as createViteServer, createLogger } from "vite";

// vite.config.ts
import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import path3 from "path";
import runtimeErrorOverlay from "@replit/vite-plugin-runtime-error-modal";
var vite_config_default = defineConfig({
  plugins: [
    react(),
    runtimeErrorOverlay(),
    ...process.env.NODE_ENV !== "production" && process.env.REPL_ID !== void 0 ? [
      await import("@replit/vite-plugin-cartographer").then(
        (m) => m.cartographer()
      )
    ] : []
  ],
  resolve: {
    alias: {
      "@": path3.resolve(import.meta.dirname, "client", "src"),
      "@shared": path3.resolve(import.meta.dirname, "shared"),
      "@assets": path3.resolve(import.meta.dirname, "attached_assets")
    }
  },
  root: path3.resolve(import.meta.dirname, "client"),
  build: {
    outDir: path3.resolve(import.meta.dirname, "dist/public"),
    emptyOutDir: true,
    rollupOptions: {
      output: {
        entryFileNames: `assets/main-${Math.random().toString(36).substring(2)}-[hash].js`,
        chunkFileNames: `assets/chunk-${Math.random().toString(36).substring(2)}-[hash].js`,
        assetFileNames: `assets/styles-${Math.random().toString(36).substring(2)}-[hash].[ext]`
      }
    }
  },
  server: {
    fs: {
      strict: true,
      deny: ["**/.*"]
    }
  }
});

// server/vite.ts
import { nanoid } from "nanoid";
var viteLogger = createLogger();
function log(message, source = "express") {
  const formattedTime = (/* @__PURE__ */ new Date()).toLocaleTimeString("en-US", {
    hour: "numeric",
    minute: "2-digit",
    second: "2-digit",
    hour12: true
  });
  console.log(`${formattedTime} [${source}] ${message}`);
}
async function setupVite(app2, server) {
  const serverOptions = {
    middlewareMode: true,
    hmr: { server },
    allowedHosts: true
  };
  const vite = await createViteServer({
    ...vite_config_default,
    configFile: false,
    customLogger: {
      ...viteLogger,
      error: (msg, options) => {
        viteLogger.error(msg, options);
        process.exit(1);
      }
    },
    server: serverOptions,
    appType: "custom"
  });
  app2.use(vite.middlewares);
  app2.use("*", async (req, res, next) => {
    const url = req.originalUrl;
    try {
      const clientTemplate = path4.resolve(
        import.meta.dirname,
        "..",
        "client",
        "index.html"
      );
      let template = await fs3.promises.readFile(clientTemplate, "utf-8");
      template = template.replace(
        `src="/src/main.tsx"`,
        `src="/src/main.tsx?v=${nanoid()}"`
      );
      const page = await vite.transformIndexHtml(url, template);
      res.status(200).set({ "Content-Type": "text/html" }).end(page);
    } catch (e) {
      vite.ssrFixStacktrace(e);
      next(e);
    }
  });
}
function serveStatic(app2) {
  const distPath = path4.resolve(import.meta.dirname, "public");
  if (!fs3.existsSync(distPath)) {
    throw new Error(
      `Could not find the build directory: ${distPath}, make sure to build the client first`
    );
  }
  app2.use(express3.static(distPath));
  app2.use("*", (_req, res) => {
    res.sendFile(path4.resolve(distPath, "index.html"));
  });
}

// server/index.ts
dotenv2.config();
var app = express4();
app.use(express4.json());
app.use(express4.urlencoded({ extended: false }));
app.use(session({
  secret: process.env.SESSION_SECRET || "psa-nashik-secret-key-change-in-production",
  resave: false,
  saveUninitialized: false,
  cookie: {
    secure: process.env.NODE_ENV === "production" && process.env.HTTPS === "true",
    httpOnly: true,
    maxAge: 24 * 60 * 60 * 1e3
    // 24 hours
  }
}));
app.use((req, res, next) => {
  const start = Date.now();
  const path5 = req.path;
  let capturedJsonResponse = void 0;
  const originalResJson = res.json;
  res.json = function(bodyJson, ...args) {
    capturedJsonResponse = bodyJson;
    return originalResJson.apply(res, [bodyJson, ...args]);
  };
  res.on("finish", () => {
    const duration = Date.now() - start;
    if (path5.startsWith("/api")) {
      let logLine = `${req.method} ${path5} ${res.statusCode} in ${duration}ms`;
      if (capturedJsonResponse) {
        logLine += ` :: ${JSON.stringify(capturedJsonResponse)}`;
      }
      if (logLine.length > 80) {
        logLine = logLine.slice(0, 79) + "\u2026";
      }
      log(logLine);
    }
  });
  next();
});
(async () => {
  const server = await registerRoutes(app);
  app.use((err, _req, res, _next) => {
    const status = err.status || err.statusCode || 500;
    const message = err.message || "Internal Server Error";
    res.status(status).json({ message });
    throw err;
  });
  if (process.env.NODE_ENV === "development") {
    await setupVite(app, server);
  } else {
    serveStatic(app);
  }
  const port = process.env.PORT ? parseInt(process.env.PORT) : 5e3;
  server.listen({
    port,
    host: "0.0.0.0",
    reusePort: true
  }, () => {
    log(`serving on port ${port}`);
    setTimeout(async () => {
      try {
        const { CampaignAutomation: CampaignAutomation2 } = await Promise.resolve().then(() => (init_campaign_automation(), campaign_automation_exports));
        const automation = CampaignAutomation2.getInstance();
        await automation.initializeAutomation();
        log("Campaign automation initialized successfully");
        const { gamificationService: gamificationService2 } = await Promise.resolve().then(() => (init_gamification(), gamification_exports));
        await gamificationService2.initializeDefaultBadges();
        log("Gamification system initialized successfully");
      } catch (error) {
        console.error("Failed to initialize automation systems:", error);
      }
    }, 5e3);
  });
})();
