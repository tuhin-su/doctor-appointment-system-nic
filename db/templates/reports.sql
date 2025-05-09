CREATE TABLE reports (
    id SERIAL PRIMARY KEY,
    report_type VARCHAR(50) NOT NULL,  -- "daily", "monthly", etc.
    data JSONB,  -- Store report data in JSON format
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
