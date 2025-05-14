<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentBooked extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via(object $notifiable): array
    {
        return ['mail',  'database'];
    }

    public function toMail($notifiable)
    {
        $doctor = $this->appointment->doctorUser;
        $patient = $this->appointment->patientUser;
        $date = $this->appointment->date;
        // convert date to MM/DD/YYYY
        $date = date('m/d/Y', strtotime($date));
        // convert time to HH:MM AM/PM
        $time = $this->appointment->booking_time;
        $time = date('h:i A', strtotime($time));

        if ($notifiable->role === 'Doctor') {
            return (new MailMessage)
                ->subject('New Appointment')
                ->greeting("Hello Dr. {$notifiable->name},")
                ->line("You have an new appointment scheduled.")
                ->line("Patient: {$patient->name}")
                ->line("Date: {$date}")
                ->line("Time: {$time}")
                ->line("Please make sure to be available on time.")
                ->line('Thank you for using our platform.');
        }

        if ($notifiable->role === 'Patient') {
            return (new MailMessage)
                ->subject('Appointment Booked')
                ->greeting("Hi {$notifiable->name},")
                ->line("Your appointment with Dr. {$doctor->name} has been scheduled.")
                ->line("Doctor: Dr. {$doctor->name}")
                ->line("Date: {$date}")
                ->line("Time: {$time}")
                ->line("Please arrive 10 minutes early.")
                ->line('We look forward to seeing you!');
        }

        // Optional: default message for unknown roles
        return (new MailMessage)
            ->greeting("Hello {$notifiable->name},")
            ->line("You have an appointment scheduled.")
            ->line("Date: {$date}")
            ->line("Time: {$time}")
            ->line('Thank you!');
    }


    public function toArray(object $notifiable): array
    {
        if ($notifiable->role === 'Patient') {
            return [
                'message' => 'You have an upcoming appointment with Dr. ' . $this->appointment->doctorUser->name,
                'appointment_id' => $this->appointment->id,
            ];
        }

        return [
            'message' => 'You have an upcoming appointment with ' . $this->appointment->patientUser->name,
            'appointment_id' => $this->appointment->id,
        ];
        
    }
}
