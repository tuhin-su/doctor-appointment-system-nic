<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentReminder extends Notification
{
    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
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
                ->subject('Upcoming Appointment Reminder')
                ->greeting("Hey Dr. {$notifiable->name},")
                ->line("Just a quick reminder: you have an appointment coming up.")
                ->line("Patient: {$patient->name}")
                ->line("Date: {$date}")
                ->line("Time: {$time}")
                ->line("Make sure you're ready before the session.")
                ->salutation('Thanks, Your Healthcare App Team');
        }

        if ($notifiable->role === 'patient') {
            return (new MailMessage)
                ->subject('Your Appointment is Coming Up')
                ->greeting("Hi {$notifiable->name},")
                ->line("Here's a friendly reminder about your upcoming appointment.")
                ->line("Doctor: Dr. {$doctor->name}")
                ->line("Date: {$date}")
                ->line("Time: {$time}")
                ->line("Please arrive at least 10 minutes early and bring any necessary documents.")
                ->salutation('See you soon, Your Healthcare App Team');
        }

        // Optional fallback
        return (new MailMessage)
            ->subject('Appointment Reminder')
            ->greeting("Hello {$notifiable->name},")
            ->line("This is a reminder about your upcoming appointment.")
            ->line("Date: {$date}")
            ->line("Time: {$time}")
            ->salutation('Thanks, Your Healthcare App Team');
    }
}
