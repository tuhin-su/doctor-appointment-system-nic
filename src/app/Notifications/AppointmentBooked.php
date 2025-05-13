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
        $doctor = $this->appointment->doctor;
        $patient = $this->appointment->patient;
        $date = $this->appointment->date;
        // convert date to MM/DD/YYYY
        $date = date('m/d/Y', strtotime($date));
        // convert time to HH:MM AM/PM
        $time = $this->appointment->booking_time;
        $time = date('h:i A', strtotime($time));

        if ($notifiable->role === 'doctor') {
            return (new MailMessage)
                ->subject('Upcoming Appointment Reminder')
                ->greeting("Hello Dr. {$notifiable->name},")
                ->line("You have an upcoming appointment scheduled.")
                ->line("Patient: {$patient->name}")
                ->line("Date: {$date}")
                ->line("Time: {$time}")
                ->line("Please make sure to be available on time.")
                ->line('Thank you for using our platform.');
        }

        if ($notifiable->role === 'patient') {
            return (new MailMessage)
                ->subject('Appointment Reminder')
                ->greeting("Hi {$notifiable->name},")
                ->line("This is a reminder for your upcoming appointment.")
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
        return [
            'message' => 'You have an upcoming appointment with Dr. ' . $this->appointment->doctor->name,
            'appointment_id' => $this->appointment->id,
        ];
    }
}
