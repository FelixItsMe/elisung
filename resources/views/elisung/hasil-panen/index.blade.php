<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Hasil Panen
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
                            <button
                            type="button"
                            class="btn btn-primary btn-sm btn-fw btn-icon-text"
                            data-bs-toggle="modal"
                            data-bs-target="#modalForm"
                            data-input-tgl-panen=""
                            data-input-jumlah=""
                            data-input-id="add"
                            ><i class="mdi mdi-plus-circle-outline btn-icon-prepend"></i> Masukan Hasil Panen</button>
                        </div>
                    </div>
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped table-bordered mt-3">
                          <thead class="text-center text-white bg-gradient-dark">
                            <tr>
                                <th> Tanggal Panen </th>
                                <th> Jumlah (Kilo) </th>
                                <th style="width: 10%;"> Action </th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($data as $hasil_panen)

                                <tr>
                                    <td> {{ $hasil_panen->tgl_panen }} </td>
                                    <td> {{ $hasil_panen->jumlah }} </td>
                                    <td>
                                        <div class="float-end">
                                            <button
                                            type="button"
                                            class="btn btn-gradient-warning btn-rounded btn-icon"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalForm"
                                            data-input-tgl-panen="{{ $hasil_panen->tgl_panen }}"
                                            data-input-jumlah="{{ $hasil_panen->jumlah }}"
                                            data-input-id="{{ $hasil_panen->id }}"
                                            >
                                                <i class="mdi mdi-border-color"></i>
                                            </button>
                                            <button
                                            class="btn btn-gradient-danger btn-rounded btn-icon my-1"
                                            onclick="handleDeleteRows({{ $hasil_panen }})"
                                            >
                                                <i class="mdi mdi-delete-forever"></i>
                                            </button>
                                        </div>
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

    @include('elisung.hasil-panen._modal-form')

    @push('scripts')
        <script>
            const myModal = new bootstrap.Modal(document.getElementById("modalForm"), {});
            const modal = document.getElementById('modalForm')
            modal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                // const recipient = button.getAttribute('data-bs-whatever')
                const modalTitle = modal.querySelector('.modal-title')

                for (let index = 0; index < button.attributes.length; index++) {
                    if (button.attributes[index].nodeName.includes('data-input')) {
                        document.getElementById(button.attributes[index].nodeName).value = button.attributes[index].nodeValue

                        if (button.attributes[index].nodeName == 'data-input-id') {
                            if (document.getElementById(button.attributes[index].nodeName).value != 'add') {
                                modalTitle.textContent = 'Edit'
                                // validator.validate()
                            } else {
                                modalTitle.textContent = 'Tambah'
                            }
                        }
                    }
                }

            })

            // Submit button handler
            const submitButton = document.getElementById('submit-btn');
            submitButton.addEventListener('click', function(e) {
                // Prevent default button action
                e.preventDefault();

                // Show loading indication
                submitButton.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click
                submitButton.disabled = true;

                // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                let url, formSubmited;
                const editOrAdd = document.getElementById('data-input-id');
                const formData = new FormData();

                formData.append("tgl_panen", document.getElementById('data-input-tgl-panen').value)
                formData.append("jumlah", document.getElementById('data-input-jumlah').value)

                if (editOrAdd.value != 'add') {
                    url = "{{ route('elisung.hasil-panen.update', 'ID') }}"
                    formSubmited = axios.post(url.replace('ID', document.getElementById(
                        'data-input-id').value), formData)
                } else {
                    url = "{{ route('elisung.hasil-panen.store') }}"
                    formSubmited = axios.post(url, formData)
                }


                formSubmited.then((response) => {

                        window.location.reload();

                        // Remove loading indication
                        submitButton.removeAttribute('data-kt-indicator');

                        // Enable button
                        submitButton.disabled = false;
                    })
                    .catch((error) => {
                            // console.log(error);
                        let errorMessage = ''

                        if (error.hasOwnProperty('response')) {

                            for (const message in error.response.data.message) {
                                if (Object.hasOwnProperty.call(error.response.data.message, message)) {
                                    const element = error.response.data.message[message];

                                    errorMessage += element + "; "
                                }
                            }

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
                        submitButton.removeAttribute('data-kt-indicator');

                        // Enable button
                        submitButton.disabled = false;
                    });
            });

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
                        const url = "{{ route('elisung.hasil-panen.destroy', 'ID') }}"
                        let newUrl = url.replace('ID', data.id)

                        axios.delete(newUrl)
                        .then((response) => {
                            this.loading = false;
                            Swal.fire({
                                text: "Kamu berhasil menghapus mesin " + data.seri + "!.",
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
