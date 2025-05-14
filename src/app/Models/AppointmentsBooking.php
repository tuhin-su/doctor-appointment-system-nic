<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentsBooking extends Model
{
    protected $table = 'appointments_booking';

    protected $fillable = [
        'user_id',
        'doctor_id',
        'doctor_user_id',
        'date',
        'booking_time',
        'reschedule_status',
        'reschedule_by',
        'reschedule_date',
        'reschedule_time',
    ];

    protected $casts = [
        'date' => 'date',
        'booking_time' => 'datetime:H:i:s',
        'reschedule_date' => 'date',
        'reschedule_time' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function doctorUser()
    {
        return $this->belongsTo(User::class, 'doctor_user_id');
    }

    public function patientUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
