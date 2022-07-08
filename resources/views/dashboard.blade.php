<x-app-layout>

    <x-slot name="header">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Telemetri
            </h3>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <input type="month" class="form-control" id="select-bulan" value="{{ now('Asia/Jakarta')->format('Y-m') }}">
                    </div>
                    <div class="col-md-12">
                        <canvas id="areachart-multi" style="height:250px"></canvas>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!-- Plugin js for this page -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script> --}}
        <!-- End plugin js for this page -->
        <!-- Custom js for this page -->
        {{-- <script src="{{ asset('js/chart.js') }}"></script> --}}
        <!-- End custom js for this page -->
        <script>

            let setDate = []
            let setBensin = []
            let setBeras = []

            var multiAreaData = {
                labels: setDate,
                datasets: [{
                        label: 'Beras (Kilo)',
                        data: setBeras,
                        borderColor: ['rgba(195, 26, 26, 0.5)'],
                        backgroundColor: ['rgba(255, 99, 132, 0.5)'],
                        borderWidth: 1,
                        fill: false
                    },
                    {
                        label: 'Bensin (Liter)',
                        data: setBensin,
                        borderColor: ['rgba(54, 162, 235, 0.5)'],
                        backgroundColor: ['rgba(54, 162, 235, 0.5)'],
                        borderWidth: 1,
                        fill: false
                    },
                ]
            };

            var multiAreaOptions = {
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    filler: {
                        propagate: true
                    }
                },
                hover: {
                    mode: 'index',
                    intersec: false
                },
                scales: {
                    x: {
                        title: {
                        display: true,
                        text: 'Tanggal'
                        }
                    },
                    y: {
                        ticks: {
                            // Include a dollar sign in the ticks
                            callback: function(value, index, ticks) {
                                return value.toFixed(3);
                            }
                        }
                    }
                }
            }

            var multiAreaCanvas = $("#areachart-multi").get(0).getContext("2d");

            $(document).ready(function () {

                var multiAreaChart = new Chart(multiAreaCanvas, {
                    type: 'line',
                    data: multiAreaData,
                    options: multiAreaOptions
                });

                getData(multiAreaChart, "{{ now()->format('Y-m') }}")

                $('#select-bulan').change(function (e) {
                    e.preventDefault();

                    getData(multiAreaChart, this.value)
                });
            });

            const getData = async (chart, month) => {
                try {
                    let url = "{{ route('elisung.dashboard-data.index', ['month' => 'ID']) }}"

                    let response = await axios.get(url.replace('ID', month));
                    const data = response.data.data

                    chart.data.labels = []
                    chart.data.datasets.forEach((dataset) => {
                        dataset.data = [];
                    });

                    let date = await data.map(({bensin, beras, date}) => {
                        chart.data.labels.push(date);
                        chart.data.datasets[0].data.push(beras);
                        chart.data.datasets[1].data.push(bensin);
                        return date;
                    })

                    chart.update();

                } catch (error) {
                    console.error(error);
                }
            }
        </script>
    @endpush
</x-app-layout>
