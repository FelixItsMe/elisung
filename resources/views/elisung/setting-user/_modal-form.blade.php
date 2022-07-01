<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalFormTitle">Modal title</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
            @csrf
            <input type="hidden" name="id" id="data-input-id">
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="data-input-tgl-panen">Nama</label>
                        <input
                        type="text"
                        class="form-control"
                        id="data-input-name"
                        name="name"
                        aria-label="0"
                        aria-describedby="basic-addon13"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="data-input-nik">NIK</label>
                        <input
                        type="number"
                        min="0"
                        class="form-control"
                        id="data-input-nik"
                        name="nik"
                        aria-label="0"
                        aria-describedby="basic-addon13"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="data-input-jenis-kelamin">Jenis Kelamin</label>
                        <select
                        class="form-control"
                        id="data-input-jenis-kelamin"
                        name="nik"
                        aria-label="0"
                        aria-describedby="basic-addon13"
                        >
                          <option value="l">Laki - laki</option>
                          <option value="p">Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="data-input-tgl-lahir">Tanggal Lahir</label>
                        <input
                        type="date"
                        class="form-control"
                        id="data-input-tgl-lahir"
                        name="tgl_lahir"
                        aria-label="0"
                        aria-describedby="basic-addon13"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="data-input-alamat">Alamat</label>
                        <textarea
                        class="form-control"
                        id="data-input-alamat"
                        name="alamat"
                        aria-label="0"
                        aria-describedby="basic-addon13"
                        rows="2"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
            </button>
            <button type="button" class="btn btn-primary" id="submit-btn">Save</button>
        </div>
      </div>
    </div>
</div>
