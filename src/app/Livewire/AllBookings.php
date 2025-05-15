<?php

namespace App\Livewire;

use App\Models\AppointmentsBooking;
use Livewire\Component;
use Livewire\WithPagination;

class AllBookings extends Component
{
    use WithPagination;

    public string $search = '';
    public $searchQuery = ''; // Used only on submit
    public $rescheduleBookingView = false;
    public $rescheduleBookingId = null;

    protected $queryString = ['searchQuery'];

    public function updatingSearch()
    {
        // Prevent pagination reset until button clicked
    }

    public function searchBookings()
    {
        $this->searchQuery = $this->search;
        $this->resetPage();
    }

    public function cancelBooking($id)
    {
        $booking = AppointmentsBooking::findOrFail($id);
        $booking->reschedule_status = 'cancelled';
        $booking->save();

        $this->dispatch(
            "alert",
            type: "success",
            title: "Success",
            text: "Appointment cancelled successfully!",
        );
    }

    public function rescheduleBooking($id)
    {
        $this->rescheduleBookingView = true;
        $this->rescheduleBookingId = $id;
    }

    public function rescheduleBookingClose()
    {
        $this->rescheduleBookingView = false;
        $this->rescheduleBookingId = null;
    }

    public function render()
    {
        $bookings = AppointmentsBooking::with(['patientUser', 'doctorUser'])
            ->when($this->searchQuery, function ($query) {
                $query->whereHas('patientUser', function ($q) {
                    $q->where('name', 'like', '%' . $this->searchQuery . '%');
                })
                ->orWhereHas('doctorUser', function ($q) {
                    $q->where('name', 'like', '%' . $this->searchQuery . '%');
                })
                ->orWhere('date', 'like', '%' . $this->searchQuery . '%');
            })
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('livewire.all-bookings', [
            'bookings' => $bookings
        ]);
    }
}
