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
                            <div class="float-end">
                                <button
                                type="button"
                                class="btn btn-primary btn-sm btn-fw btn-icon-text"
                                data-bs-toggle="modal"
                                data-bs-target="#modalForm"
                                data-input-name="{{ Auth::user()->name }}"
                                data-input-nik="{{ Auth::user()->nik }}"
                                data-input-jenis-kelamin="{{ Auth::user()->jenis_kelamin }}"
                                data-input-tgl-lahir="{{ Auth::user()->tgl_lahir }}"
                                data-input-alamat="{{ Auth::user()->alamat }}"
                                data-input-id="{{ Auth::user()->id }}"
                                ><i class="mdi mdi-plus-circle-outline btn-icon-prepend"></i> Edit</button>
                            </div>
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

    @include('elisung.setting-user._modal-form')

    @push('scripts')
        <script>

            $(document).ready(function () {
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

                    formData.append("name", document.getElementById('data-input-name').value)
                    formData.append("nik", document.getElementById('data-input-nik').value)
                    formData.append("jenis_kelamin", document.getElementById('data-input-jenis-kelamin').value)
                    formData.append("tgl_lahir", document.getElementById('data-input-tgl-lahir').value)
                    formData.append("alamat", document.getElementById('data-input-alamat').value)

                    url = "{{ route('elisung.user-setting.update') }}"
                    formSubmited = axios.post(url, formData)


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
            });

        </script>
    @endpush
</x-app-layout>
