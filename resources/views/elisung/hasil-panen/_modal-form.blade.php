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
                        <label for="data-input-tgl-panen">Tanggal Panen</label>
                        <input
                        type="date"
                        class="form-control"
                        id="data-input-tgl-panen"
                        name="tgl_panen"
                        placeholder="0"
                        aria-label="0"
                        aria-describedby="basic-addon13"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="data-input-jumlah">Jumlah Panen</label>
                        <div class="input-group">
                          <input
                              type="number"
                              step="0.1"
                              min="0"
                              id="data-input-jumlah"
                              class="form-control"
                              name="jumlah"
                              required
                          />
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-gradient-info text-white">Kilo</span>
                          </div>
                        </div>
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
