INSERT INTO roles (name, description) VALUES
('Admin', 'System administrator with full control'),
('Doctor', 'Doctor with scheduling and appointment management'),
('Patient', 'Patient who books and views appointments');
-- Admin
INSERT INTO users (name, email, password, role_id) VALUES
('Admin User', 'admin@doctorapp.com', 'hashed_password_here', 1);

-- Doctor
INSERT INTO users (name, email, password, role_id) VALUES
('Dr. John Doe', 'doctor@doctorapp.com', 'hashed_password_here', 2);

-- Patient
INSERT INTO users (name, email, password, role_id) VALUES
('Patient 1', 'patient1@doctorapp.com', 'hashed_password_here', 3);
