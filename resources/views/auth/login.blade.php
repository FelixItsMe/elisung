<x-guest-layout>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
          <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
              <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left p-5">
                  {{-- <div class="brand-logo">
                    <img src="{{ asset('images/logo.svg') }}">
                  </div> --}}
                <h1 class="text-primary fw-bold">E-Lisung</h1>

                  <h6 class="font-weight-light">Sign in to continue.</h6>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form class="pt-3" method="POST" action="{{ route('login') }}">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="nik" placeholder="NIK" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" name="password" placeholder="Password" required autocomplete="current-password">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                        </div>
                        <div class="my-2 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input" name="remember_me"> Remember me </label>
                            </div>
                        </div>
                    </form>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
</x-guest-layout>
