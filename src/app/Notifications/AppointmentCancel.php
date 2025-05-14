<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentCancel extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
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
                ->subject('Appointment Cancelled')
                ->greeting("Hello Dr. {$notifiable->name},")
                ->line("Your appointment with {$patient->name} has been cancelled.")
                ->line("Patient: {$patient->name}")
                ->line("Date: {$date}")
                ->line("Time: {$time}")
                ->line("We make this time available for others.")
                ->line('Thank you for using our platform.');
        }

        if ($notifiable->role === 'patient') {
            return (new MailMessage)
                ->subject('Appointment Cancelled')
                ->greeting("Hi {$notifiable->name},")
                ->line("Your appointment with Dr. {$doctor->name} has been cancelled.")
                ->line("Doctor: Dr. {$doctor->name}")
                ->line("Date: {$date}")
                ->line("Time: {$time}")
                ->line('Thank you for using our platform.');
        }

        // Optional: default message for unknown roles
        return (new MailMessage)
            ->greeting("Hello {$notifiable->name},")
            ->line("You have an appointment scheduled.")
            ->line("Date: {$date}")
            ->line("Time: {$time}")
            ->line('Thank you!');
    }
}
