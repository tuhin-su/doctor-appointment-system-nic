CREATE TABLE schedules (
    id SERIAL PRIMARY KEY,
    doctor_id INT REFERENCES users(id) ON DELETE CASCADE,
    available_from TIME NOT NULL,
    available_to TIME NOT NULL,
    day_of_week INT NOT NULL,  -- 0: Sunday, 1: Monday, etc.
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
