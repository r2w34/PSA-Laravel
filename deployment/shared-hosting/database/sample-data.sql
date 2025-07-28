-- Sample data for PSA Sports Academy
-- Insert sample sports
INSERT INTO sports (name, description, is_active, created_at, updated_at) VALUES
('Cricket', 'Cricket training and coaching', 1, NOW(), NOW()),
('Football', 'Football training and coaching', 1, NOW(), NOW()),
('Basketball', 'Basketball training and coaching', 1, NOW(), NOW());

-- Insert sample coaches
INSERT INTO coaches (name, email, phone, specialization, experience_years, qualification, salary, status, created_at, updated_at) VALUES
('John Smith', 'john@psa.com', '9876543210', 'Cricket', 5, 'B.P.Ed', 25000.00, 'active', NOW(), NOW()),
('Mike Johnson', 'mike@psa.com', '9876543211', 'Football', 7, 'M.P.Ed', 30000.00, 'active', NOW(), NOW()),
('Sarah Wilson', 'sarah@psa.com', '9876543212', 'Basketball', 4, 'B.P.Ed', 22000.00, 'active', NOW(), NOW());

-- Insert sample batches
INSERT INTO batches (name, sport_id, coach_id, start_time, end_time, days_of_week, max_students, skill_level, fee_amount, is_active, created_at, updated_at) VALUES
('Cricket Beginners', 1, 1, '06:00:00', '07:30:00', 'Monday,Wednesday,Friday', 20, 'beginner', 2000.00, 1, NOW(), NOW()),
('Football Intermediate', 2, 2, '07:30:00', '09:00:00', 'Tuesday,Thursday,Saturday', 15, 'intermediate', 2500.00, 1, NOW(), NOW()),
('Basketball Advanced', 3, 3, '09:00:00', '10:30:00', 'Monday,Wednesday,Friday', 12, 'advanced', 3000.00, 1, NOW(), NOW());

-- Insert admin user (password: password)
INSERT INTO users (name, email, email_verified_at, password, role, created_at, updated_at) VALUES
('Admin User', 'admin@psa.com', NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW());