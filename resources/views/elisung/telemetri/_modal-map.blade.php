<!-- Modal -->
<div class="modal fade" id="modalMap" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalMapTitle">Map</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body position-relative" id="map-body">
            <div class="position-absolute bg-white text-center" id="map-spinner">
                <div class="spinner-grow text-info" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div id="map"></div>
        </div>
      </div>
    </div>
</div>
