SELECT
    ab.doctor_id,
    u.name AS doctor_name,
    u.email AS doctor_email,
    d.specialty,
    COUNT(*) AS total_appointments
FROM
    appointments_booking ab
JOIN doctors d ON ab.doctor_id = d.id
JOIN users u ON d.user_id = u.id
WHERE
    ab.user_id = 4
    AND ab.date >= DATE '2025-05-01'
    AND ab.date < DATE '2025-06-01'
GROUP BY
    ab.doctor_id, u.name, u.email, d.specialty
ORDER BY
    total_appointments DESC
LIMIT 100