-- Corrected Seed Data for Brilliance Healthcare Academy

-- 1. Categories
INSERT INTO categories (name, slug) VALUES 
('Clinical Skills', 'clinical-skills'),
('Mandatory Training', 'mandatory-training'),
('Mental Health', 'mental-health'),
('Leadership', 'leadership');

-- 2. Sample Users
-- Admin (Password: admin123)
-- Student (Password: student123)
INSERT INTO users (name, email, password, role, referral_code) VALUES 
('System Admin', 'admin@bha.ac.uk', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'admin', 'BHA-ADMIN'),
('John Student', 'student@example.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', 'student', 'BHA-JOHN');

-- 3. Initial Courses
INSERT INTO courses (category_id, title, slug, description, price, certificate_price, image) VALUES 
(1, 'Care Certificate (Standards 1-15)', 'care-certificate-1-15', 'Comprehensive UK Care Certificate training covering all essential standards for healthcare workers.', 25.00, 25.00, 'https://images.unsplash.com/photo-1584515159911-66df9845ec64?auto=format&fit=crop&q=80&w=800'),
(2, 'Infection Prevention & Control', 'infection-prevention-control', 'Learn the latest protocols for maintaining a sterile and safe environment in clinical settings.', 19.99, 15.00, 'https://images.unsplash.com/photo-1583324113626-70df0f4deaab?auto=format&fit=crop&q=80&w=800'),
(3, 'Safeguarding Adults at Risk', 'safeguarding-adults-at-risk', 'Crucial training on identifying and preventing abuse or neglect in vulnerable adult populations.', 24.50, 20.00, 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=800');

-- 4. Sample Vouchers
INSERT INTO vouchers (code, discount_type, discount_value, usage_limit) VALUES 
('WINTER20', 'percent', 20.00, 100),
('NEWYEAR5', 'flat', 5.00, 50);

-- 5. Sample Lessons for Care Certificate
INSERT INTO lessons (course_id, title, content, sort_order) VALUES 
(1, 'Introduction to the Care Certificate', '<h1>Welcome</h1><p>The Care Certificate is an agreed set of standards that define the knowledge, skills and behaviours expected of specific job roles in the health and social care sectors.</p>', 1),
(1, 'Standard 1: Understand Your Role', '<h2>The Main Duties</h2><p>As a healthcare professional, your primary role is to provide safe, compassionate, and high-quality care...</p>', 2);
