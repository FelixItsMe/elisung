<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> User
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
                        <table class="table mt-3">
                          <tbody>

                                <tr>
                                    <td colspan="2" class="py-1 text-center">
                                        <img src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : asset('images/faces-clipart/pic-1.png') }}" alt="img-thumbnail" style="width: 100px !important;height: 100px !important;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg-info"> Name </td>
                                    <td class="text-center"> {{ Auth::user()->name }} </td>
                                </tr>
                                <tr>
                                    <td class="bg-info"> NIK </td>
                                    <td class="text-center"> {{ Auth::user()->nik }} </td>
                                </tr>
                                @php
                                    $jenis_kelamin = null;

                                    switch (Auth::user()->jenis_kelamin) {
                                        case 'l':
                                            $jenis_kelamin = "Laki - laki";
                                            break;

                                        case 'p':
                                            $jenis_kelamin = "Perempuan";
                                            break;

                                        default:
                                            $jenis_kelamin = "-";
                                            break;
                                    }
                                @endphp
                                <tr>
                                    <td class="bg-info"> Jenis Kelamin </td>
                                    <td class="text-center"> {{ $jenis_kelamin }} </td>
                                </tr>
                                <tr>
                                    <td class="bg-info"> Tanggal Lahir </td>
                                    <td class="text-center"> {{ Auth::user()->tgl_lahir }} </td>
                                </tr>
                                <tr>
                                    <td class="bg-info"> Alamat </td>
                                    <td class="text-center text-wrap"> {{ Auth::user()->alamat }} </td>
                                </tr>

                          </tbody>
                        </table>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>

    @include('elisung.telemetri._modal-detail')

    @push('scripts')
        <script>

            $(document).ready(function () {
                $('.btn-detail').click( async e => {
                    try {
                        loadField()
                        let dataId = $(e.target).data('id');
                        let url = "{{ route('elisung.telemetri.show', ['telemetri' => 'ID']) }}"


                        let response = await axios.get(url.replace('ID', dataId));
                        let data = response.data.data

                        $('#text-waktu-mulai').html(data.t_awal);
                        $('#text-waktu-selesai').html(data.t_akhir);
                        $('#text-waktu-penggilingan').html(data.waktu_penggilingan);
                        $('#text-latitude').html(data.latitude);
                        $('#text-longitude').html(data.longitude);
                        $('#text-hasil-beras').html(data.beras);
                        $('#text-hasil-dedak').html(data.dedak);
                        $('#text-bensin').html(data.bensin_pakai);
                    } catch (error) {
                        console.error(error.response.data.message);
                    }
                });
            });

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
