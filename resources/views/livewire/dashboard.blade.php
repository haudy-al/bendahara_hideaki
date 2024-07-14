<div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <canvas id="myDonutChart" width="400" height="400"></canvas>
                            </div>
                        </div>


                        <div>
                            <canvas id="myChart"></canvas>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        var pengeluaran = {{ $pengeluaran }};
        var pemasukan = {{ $pemasukan }};
        myDonutChart(pemasukan, pengeluaran)

        function myDonutChart(pemsukan, pengeluaran) {

            const ctx = document.getElementById('myDonutChart').getContext('2d');
            const myDonutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran'],
                    datasets: [{
                        label: 'Total',
                        data: [pemasukan, pengeluaran],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    </script>

    <!-- resources/views/livewire/dashboard.blade.php -->



    <script>
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
            'November', 'December'
        ];

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(
                    $monthlyData->pluck('month')->map(function ($month) use ($months) {
                        return $months[$month - 1];
                    }),
                ) !!},
                datasets: [{
                    label: 'Pemasukan',
                    data: {!! json_encode($monthlyData->pluck('total_income')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Pengeluaran',
                    data: {!! json_encode($monthlyData->pluck('total_expense')) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>
