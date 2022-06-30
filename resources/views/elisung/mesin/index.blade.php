<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-home"></i>
                </span> Mesin
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
              <div class="card-body table-responsive">
                <div>
                    <div class="float-start">
                        {{-- <h4 class="card-title">Striped Table</h4> --}}
                    </div>
                    <div class="float-end">
                        <button
                        type="button"
                        class="btn btn-primary btn-sm btn-fw"
                        data-bs-toggle="modal"
                        data-bs-target="#modalForm"
                        data-input-nama=""
                        data-input-seri=""
                        data-input-tgl-produksi=""
                        data-input-tgl-pembelian=""
                        data-input-id="add"
                        >Registrasi Mesin</button>
                    </div>
                </div>
                <table class="table table-striped mt-3">
                  <thead class="bg-gradient-dark text-center text-white fw-bold">
                    <tr>
                        <th> Seri </th>
                        <th> Nama </th>
                        <th> Tanggal Pembelian </th>
                        <th> Tanggal Produksi </th>
                        <th> Foto Mesin </th>
                        <th> Motor </th>
                        <th> Action </th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($data as $mesin)

                        <tr>
                            <td> {{ $mesin->seri }} </td>
                            <td> {{ $mesin->nama }} </td>
                            <td> {{ $mesin->tgl_pembelian }} </td>
                            <td> {{ $mesin->tgl_produksi }} </td>
                            <td class="py-1 text-center">
                                <a
                                href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#modalFoto"
                                data-foto="{{ asset($mesin->foto) }}"
                                data-input-id="{{ $mesin->id }}"
                                >
                                    <img src="{{ asset($mesin->foto) }}" alt="image" />
                                </a>
                            </td>
                            <td class="py-1 text-center">
                                <button type="button"
                                class="btn btn-gradient-danger btn-sm my-1 btn-motor-status"
                                data-status="{{ $mesin->status_motor }}"
                                >OFF</button>
                            </td>
                            <td class="d-flex flex-wrap">
                                <button
                                type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#modalSpesifikasi"
                                onclick="viewSpesifikasi({{ $mesin->spesifikasi }})"
                                class="btn btn-light btn-sm my-1 mx-1"
                                >Spesifikasi</button>

                                <button
                                    type="button"
                                    class="btn btn-warning btn-sm my-1 mx-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalForm"
                                    data-input-nama="{{ $mesin->nama }}"
                                    data-input-seri="{{ $mesin->seri }}"
                                    data-input-tgl-produksi="{{ $mesin->tgl_produksi }}"
                                    data-input-tgl-pembelian="{{ $mesin->tgl_pembelian }}"
                                    data-input-id="{{ $mesin->id }}"
                                    onclick="editSpesifikasi({{ $mesin }})"
                                >Edit</button>

                                <button
                                    class="btn btn-danger btn-sm my-1 mx-1"
                                    onclick="handleDeleteRows({{ $mesin }})"
                                >
                                    Delete
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
            </div>
        </div>
    </div>

    @include('elisung.mesin._modal-form')
    @include('elisung.mesin._modal-foto')
    @include('elisung.mesin._modal-spesifikasi')

    @push('scripts')
    <script src="{{ asset('js/file-upload.js') }}"></script>
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

            $('.btn-motor-status').click((e) =>{
                const status = $(e.target).data('status')
                $(e.target).attr('disabled', 'disabled')
                $(e.target).html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...`)

                if (status == 1) {
                    $(e.target).removeClass('bg-gradient-success');
                    $(e.target).addClass('bg-gradient-danger');

                    $(e.target).removeAttr('disabled');
                    $(e.target).html(`OFF`)
                }

                if (status == 0) {
                    $(e.target).removeClass('bg-gradient-danger');
                    $(e.target).addClass('bg-gradient-success');

                    $(e.target).removeAttr('disabled');
                    $(e.target).html(`ON`)
                }

                $(e.target).data('status', (status == 1) ? 0 : 1);
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
                let myFoto = document.getElementById('data-input-foto').files[0];

                if (typeof myFoto !== 'undefined'){
                    formData.append("foto", document.getElementById(
                        'data-input-foto').files[0])
                }

                formData.append("nama", document.getElementById('data-input-nama').value)
                formData.append("seri", document.getElementById('data-input-seri').value)
                formData.append("tgl_produksi", document.getElementById('data-input-tgl-produksi').value)
                formData.append("tgl_pembelian", document.getElementById('data-input-tgl-pembelian').value)

                let dataSpesifikasi = []

                document.querySelectorAll('.custom-spesifikasi').forEach(a => {
                    let namaSpesifikasi = a.childNodes[1].children['nama_spesifikasi'].value
                    let valueSpesifikasi = a.childNodes[3].children['value_spesifikasi'].value
                    let idSpesifikasi = a.childNodes[3].children['value_spesifikasi'].dataset.id

                    dataSpesifikasi.push({'name' : namaSpesifikasi, 'value' : valueSpesifikasi, 'id' : idSpesifikasi})
                });

                formData.append('spesifikasi', JSON.stringify(dataSpesifikasi))

                if (editOrAdd.value != 'add') {
                    url = "{{ route('elisung.mesin.update', 'ID') }}"
                    formSubmited = axios.post(url.replace('ID', document.getElementById(
                        'data-input-id').value), formData)
                } else {
                    url = "{{ route('elisung.mesin.store') }}"
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

            const myModalPrev = new bootstrap.Modal(document.getElementById("modalFoto"), {});
            const modalFoto = document.getElementById('modalFoto')
            modalFoto.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                // const recipient = button.getAttribute('data-bs-whatever')
                const modalTitle = modalFoto.querySelector('.modal-title')
                modalTitle.textContent = 'Foto Perangkat'

                for (let index = 0; index < button.attributes.length; index++) {
                    if (button.attributes[index].nodeName.includes('data-foto')) {
                        document.getElementById('iframe').src = button.attributes[index].nodeValue
                    }
                }

            })

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
                        const url = "{{ route('elisung.mesin.destroy', 'ID') }}"
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

            const btnNewSpesifik = document.getElementById('btn-new-spesifik')

            btnNewSpesifik.addEventListener("click", e => {
                e.preventDefault();
                let formSpesifik = document.getElementById('form-spesifik')

                formSpesifik.insertAdjacentHTML("beforeend", `<div class="row g-2 mb-3 custom-spesifikasi">
                    <div class="col-5 mb-0">
                        <label class="form-label">Nama Spesifikasi</label>
                        <input
                            type="text"
                            class="form-control data-input-nama-spesifik"
                            name="nama_spesifikasi"
                            data-id=""
                        />
                    </div>
                    <div class="col-5 mb-0">
                        <label class="form-label">Isi Spesifikasi</label>
                        <input
                            type="text"
                            class="form-control data-input-value-spesifik"
                            name="value_spesifikasi"
                            data-id=""
                        />
                    </div>
                    <div class="col-2 mb-0 d-grid gap-2">
                        <button class="btn btn-danger btn-sm btn-block mt-3 btn-delete-spesifik">X</button>
                    </div>
                </div>`)

                deleteSpesifik()
            })

            const deleteSpesifik = () => {

                document.querySelectorAll('.btn-delete-spesifik').forEach(element => {
                    element.addEventListener("click", e=>{

                        e.target.parentNode.parentNode.remove()
                    })
                });
            }

            const editSpesifikasi = (data) => {
                let formSpesifik = document.getElementById('form-spesifik')
                let element = ``

                for (let i = 0; i < data.spesifikasi.length; i++) {
                    const spesifikasi = data.spesifikasi[i];

                    element += `<div class="row g-2 mb-3 custom-spesifikasi">
                        <div class="col-5 mb-0">
                            <label class="form-label">Nama Spesifikasi</label>
                            <input
                                type="text"
                                class="form-control data-input-nama-spesifik"
                                name="nama_spesifikasi"
                                value="${spesifikasi.name}"
                                data-id="${spesifikasi.id}"
                            />
                        </div>
                        <div class="col-5 mb-0">
                            <label class="form-label">Isi Spesifikasi</label>
                            <input
                                type="text"
                                class="form-control data-input-value-spesifik"
                                name="value_spesifikasi"
                                value="${spesifikasi.value}"
                                data-id="${spesifikasi.id}"
                            />
                        </div>
                        <div class="col-2 mb-0 d-grid gap-2">
                            <button class="btn btn-danger btn-sm btn-block mt-3 btn-delete-spesifik">X</button>
                        </div>
                    </div>`
                }

                formSpesifik.innerHTML = element
            }

            const viewSpesifikasi = (spesifikasi) => {
                let element = spesifikasi.length > 0 ? `` : `<tr>
                                <td colspan="2" class="text-center">Tidak ada data</td>
                            </tr>`
                for (let i = 0; i < spesifikasi.length; i++) {
                    const data = spesifikasi[i];

                    element += `<tr>
                                <td class="text-center">${data.name}</td>
                                <td class="text-center">${data.value}</td>
                            </tr>`
                }

                document.getElementById('view-spesifik').innerHTML = element
            }

        </script>

    @endpush
</x-app-layout>
