<div>
    <div class="p-4 md:p-8 space-y-8 bg-white min-h-screen text-gray-700">

        <!-- Header -->
        <div class="text-center">
            <h1 class="text-2xl font-bold text-blue-700">Appointment Reports Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Track appointment performance and trends</p>
        </div>
    
        <!-- Report Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Appointments -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl shadow-sm p-6 text-center">
                <p class="text-sm text-blue-700 font-medium">Total Appointments</p>
                <h2 class="text-3xl font-bold text-blue-800 mt-2">{{ $totalAppointments }}</h2>
            </div>
    
            <!-- Rescheduled Appointments -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl shadow-sm p-6 text-center">
                <p class="text-sm text-blue-700 font-medium">Rescheduled Appointments</p>
                <h2 class="text-3xl font-bold text-yellow-500 mt-2">{{ $rescheduledAppointments }}</h2>
            </div>
    
            <!-- Users with No Appointments -->
            <div class="bg-blue-50 border border-blue-100 rounded-xl shadow-sm p-6 text-center">
                <p class="text-sm text-blue-700 font-medium">Users w/o Appointments</p>
                <h2 class="text-3xl font-bold text-red-500 mt-2">{{ $usersWithNoAppointments }}</h2>
            </div>
        </div>
    
        <!-- Chart Section -->
        <div class="bg-white border border-blue-100 rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-blue-700 mb-4">Appointments Overview</h3>
            <canvas id="appointmentsChart" class="w-full h-72"></canvas>
        </div>
    
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('appointmentsChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Total', 'Rescheduled', 'No Appointments'],
                    datasets: [{
                        data: [
                            @js($totalAppointments),
                            @js($rescheduledAppointments),
                            @js($usersWithNoAppointments)
                        ],
                        backgroundColor: ['#3B82F6', '#FACC15', '#EF4444'],
                        borderColor: '#ffffff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#1E3A8A', // dark blue
                                font: { size: 14 }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
    
</div>
