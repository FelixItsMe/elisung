<!-- Modal -->
<div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalPasswordTitle">Modal title</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
            @csrf
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="data-input-tgl-panen">Old Password</label>
                        <input
                        type="password"
                        class="form-control"
                        id="data-input-old-password"
                        name="old_password"
                        aria-label="0"
                        aria-describedby="basic-addon13"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="data-input-tgl-panen">New Password</label>
                        <input
                        type="password"
                        class="form-control"
                        id="data-input-new-password"
                        name="new_password"
                        aria-label="0"
                        aria-describedby="basic-addon13"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <div class="form-group">
                        <label for="data-input-tgl-panen">Comfirm Password</label>
                        <input
                        type="password"
                        class="form-control"
                        id="data-input-comfirm-password"
                        name="comfirm_password"
                        aria-label="0"
                        aria-describedby="basic-addon13"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Close
            </button>
            <button type="button" class="btn btn-primary" id="submit-password">Save</button>
        </div>
      </div>
    </div>
</div>
