<x-app-layout>

    @push('links')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin=""/>
        <link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
    @endpush
    @push('styles')
        <style>
            #map { height: 280px; }
        </style>
    @endpush

    <x-slot name="header">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Telemetri
            </h3>
            <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
            </nav>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-start">
                            {{-- <h4 class="card-title">Striped Table</h4> --}}
                        </div>
                        <div class="float-end">
                        </div>
                    </div>
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped table-bordered mt-3">
                          <thead class="text-center text-white bg-gradient-dark">
                            <tr>
                                <th> Waktu Mulai </th>
                                <th> Waktu Selesai </th>
                                <th> Waktu Penggilingan (Detik)</th>
                                <th> Hasil Beras (Kilo)</th>
                                <th style="width: 10%;"> Action </th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($data as $telemetri)

                                <tr>
                                    <td> {{ $telemetri->t_awal }} </td>
                                    <td> {{ $telemetri->t_akhir }} </td>
                                    <td> {{ $telemetri->waktu_penggilingan }} </td>
                                    <td> {{ $telemetri->beras }} </td>
                                    <td class="d-flex flex-wrap">

                                        <button
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalDetail"
                                        class="btn btn-info btn-sm my-1 mx-1 btn-detail"
                                        data-id="{{ $telemetri->id }}"
                                        >Detail</button>

                                        <button
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalMap"
                                        class="btn btn-success btn-sm my-1 mx-1 btn-map"
                                        data-id="{{ $telemetri->id }}"
                                        >Map</button>

                                        <button
                                        class="btn btn-gradient-danger btn-sm my-1 mx-1 btn-icon-text"
                                        onclick="handleDeleteRows({{ $telemetri }})"
                                        >
                                            <i class="mdi mdi-delete-forever btn-icon-prepend"></i> Delete
                                        </button>

                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center"> Kosong </td>
                                </tr>

                            @endforelse
                          </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 mt-3">
                        {{ $data->links() }}
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>

    @include('elisung.telemetri._modal-detail')
    @include('elisung.telemetri._modal-map')

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
        <script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
        <script>
            $(document).ready(function () {
                $('.btn-detail').click( async e => {
                    try {
                        loadField()
                        let dataId = $(e.target).data('id');
                        let url = "{{ route('elisung.telemetri.show', ['telemetri' => 'ID']) }}"


                        let response = await axios.get(url.replace('ID', dataId));
                        const data = response.data.data

                        $('#text-waktu-mulai').html(data.t_awal);
                        $('#text-waktu-selesai').html(data.t_akhir);
                        $('#text-waktu-penggilingan').html(data.waktu_penggilingan);
                        $('#text-latitude').html(data.latitude);
                        $('#text-longitude').html(data.longitude);
                        $('#text-hasil-beras').html(data.beras);
                        $('#text-hasil-dedak').html(data.dedak);
                        $('#text-bensin').html(data.bensin_pakai);
                        $('#text-total-berat-padi').html(data.gabah);
                        $('#text-rasio').html((data.beras / parseInt(data.gabah) * 100).toFixed(1));
                    } catch (error) {
                        console.error(error.response.data.message);
                    }
                });

                $('.btn-map').click(async function (e) {
                    e.preventDefault();

                    let dataId = $(this).data('id');
                    let url = "{{ route('elisung.telemetri.show', ['telemetri' => 'ID']) }}"


                    let response = await axios.get(url.replace('ID', dataId));
                    const data = response.data.data

                    let promise = new Promise((resolve, reject) => {
                        setTimeout(() => {
                            settingMap(parseFloat(data.latitude), parseFloat(data.longitude))
                            resolve("done!")
                        }, 500);
                    });

                    let result = await promise;

                    $('#map-spinner').remove();
                });
            });

            const settingMap = (lat, lng) => {
                let map = L.map('map', {
                    fullscreenControl: {
                        pseudoFullscreen: true // if true, fullscreen to page width and height
                    }
                }).setView([lat, lng], 12)

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap',
                }).addTo(map);

                let marker = L.marker([lat, lng]).addTo(map);

                marker.bindPopup("Lat: "+lat+"<br>Long: "+lng).openPopup();
            }

            function loadField() {
                let loadingElement = `<div class="d-flex align-items-center">
                    <strong>Loading...</strong>
                    <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                </div>`

                $('#text-waktu-mulai').html(loadingElement);
                $('#text-waktu-selesai').html(loadingElement);
                $('#text-waktu-penggilingan').html(loadingElement);
                $('#text-latitude').html(loadingElement);
                $('#text-longitude').html(loadingElement);
                $('#text-hasil-beras').html(loadingElement);
                $('#text-hasil-dedak').html(loadingElement);
                $('#text-bensin').html(loadingElement);
                $('#text-total-berat-padi').html(loadingElement);
                $('#text-rasio').html(loadingElement);
            }

            function handleDeleteRows(data) {
                Swal.fire({
                    text: "Menghapus data tidak dapat dibatalkan, dan semua data yang berhubungan akan hilang",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        Swal.fire({
                            html: '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class=""> Loading...</span>',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                        });
                        // Simulate delete request -- for demo purpose only
                        const url = "{{ route('elisung.telemetri.destroy', 'ID') }}"
                        let newUrl = url.replace('ID', data.id)

                        axios.delete(newUrl)
                        .then((response) => {
                            this.loading = false;
                            Swal.fire({
                                text: "Kamu berhasil menghapus telemetri!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function () {
                                // delete row data from server and re-draw datatable
                                window.location.reload();
                            });
                        })
                        .catch((error) => {
                            let errorMessage = error

                            if (error.hasOwnProperty('response')) {
                                if (error.response.status == 422) {
                                    errorMessage = 'Data yang dikirim tidak sesuai'
                                }
                            }

                            Swal.fire({
                                text: errorMessage,
                                icon: "error",
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });

                            // Remove loading indication
                            // submitButton.removeAttribute('data-kt-indicator');

                            // Enable button
                            // submitButton.disabled = false;
                        });
                    }
                });
            }

        </script>
    @endpush
</x-app-layout>
