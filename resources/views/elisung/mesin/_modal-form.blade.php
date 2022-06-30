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
                <label for="data-input-nama" class="form-label">Nama Perangkat</label>
                <input
                    type="text"
                    id="data-input-nama"
                    class="form-control"
                    name="nama_perangkat"
                    required
                />
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                <label for="data-input-seri" class="form-label">Seri Perangkat</label>
                <input
                    type="text"
                    id="data-input-seri"
                    class="form-control"
                    name="seri_perangkat"
                    required
                />
                </div>
            </div>
            <div class="row g-2 mb-3">
              <div class="col mb-0">
                <label for="data-input-tgl-produksi" class="form-label">Tanggal Produksi</label>
                  <input
                    type="date"
                    class="form-control"
                    id="data-input-tgl-produksi"
                    name="tgl_produksi"
                    placeholder="0"
                    aria-label="0"
                    aria-describedby="basic-addon13"
                  />
              </div>
              <div class="col mb-0">
                  <label for="data-input-tgl-pembelian" class="form-label">Tanggal Pembelian</label>
                    <input
                      type="date"
                      class="form-control"
                      id="data-input-tgl-pembelian"
                      name="tgl_pembelian"
                      placeholder="0"
                      aria-label="0"
                      aria-describedby="basic-addon13"
                    />
              </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                      <label>Foto Mesin</label>
                      <input type="file" name="foto" class="file-upload-default" id="data-input-foto">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-gradient-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <button class="btn btn-info" id="btn-new-spesifik">New Spesifikasi</button>
                </div>
                <div class="col-md-12" id="form-spesifik">
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
