<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentRescheduled extends Notification
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  object  $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // Mail and database channels
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  object  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $doctor = $this->appointment->doctorUser;
        $patient = $this->appointment->patientUser;
        $date = $this->appointment->date;
        // Convert date to MM/DD/YYYY
        $date = date('m/d/Y', strtotime($date));
        // Convert time to HH:MM AM/PM
        $time = $this->appointment->booking_time;
        $time = date('h:i A', strtotime($time));

        if ($notifiable->role === 'Doctor') {
            return (new MailMessage)
                ->subject('Appointment Rescheduled')
                ->greeting("Hello Dr. {$doctor->name},")
                ->line("The appointment for patient {$patient->name} has been rescheduled.")
                ->line("Original Date and Time: {$date} at {$time}")
                ->line("New Date: {$date}")
                ->line("New Time: {$time}")
                ->line("Please review the details and take necessary actions.")
                ->line('Thank you for using our platform.');
        }

        // Optional: Default message for other roles if needed
        return (new MailMessage)
            ->greeting("Hello {$notifiable->name},")
            ->line("The appointment with Dr. {$doctor->name} has been rescheduled.")
            ->line("New Date: {$date}")
            ->line("New Time: {$time}")
            ->line('Thank you!');
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  object  $notifiable
     * @return array
     */
    public function toArray(object $notifiable): array
    {
        if ($notifiable->role === 'Patient') {
            return [
                'message' => 'The appointment for Dr. ' . $this->appointment->doctorUser->name . ' has been rescheduled to ' . $this->appointment->booking_time,
                'appointment_id' => $this->appointment->id,
            ];
        }

        return [
            'message' => 'The appointment for ' . $this->appointment->patientUser->name . ' has been rescheduled to ' . $this->appointment->booking_time,
            'appointment_id' => $this->appointment->id,
        ];
    }
}
