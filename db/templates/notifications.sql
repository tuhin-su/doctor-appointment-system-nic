CREATE TABLE notifications (
    id SERIAL PRIMARY KEY,
    appointment_id INT REFERENCES appointments(id) ON DELETE CASCADE,
    message TEXT,
    send_time TIMESTAMP NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',  -- pending, sent, failed
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
