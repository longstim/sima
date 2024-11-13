<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIMA HKBP Padang Bulan</title>

  <link rel="icon" type="image/x-icon" href="{{asset('image/logo-hkbp.png')}}">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <style>
  body {
      height: 100%;
      margin: 0;

      /* The image used */
      background-color: #f6f6f6;

      /* Full height */
      height: 100%; 

      /* Center and scale the image nicely */
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;

      font-family:Segoe UI,  Roboto,  Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;
    }
</style>
</head>
<body>

<section>
  <div class="container py-4 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="{{asset('image/login-banner.jpg')}}"
                alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; height: 100%;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">
                <form method="POST" action="{{ route('login') }}" class="form">
                  <div class="pb-1">
                    <center><img src="{{asset('image/logo_text_hkbp.png')}}" width="150px"></center>
                  </div>

                  <h5 class="fw-normal mb-3 pb-2" style="letter-spacing: 1px;text-align:center;"><b>Sistem Informasi Manajemen Aset</b><br>Gereja HKBP Padang Bulan</h5>

                  <div class="form-outline mb-4">
                    <label class="form-label" for="Username">Username</label>
                    <input type="username" name="username" id="txtUsername" class="form-control form-control-lg{{ $errors->has('username') ? ' is-invalid' : '' }} rounded-5" value="{{ old('username') }}" placeholder="Username" required autofocus />
                   @if($errors->has('username'))
                    <span>
                      <i style="color: red">{{ $errors->first('username') }}</i>
                    </span>
                    @endif
                  </div>

                  <div class="form-outline mb-4">
                     <label class="form-label" for="Password">Password</label>
                    <input type="password" name="password" id="txtPassword" class="form-control form-control-lg{{ $errors->has('password') ? ' is-invalid' : '' }} rounded-5" placeholder="Password" required autofocus/>       
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
                  </div>

                  <center><i class="small text-muted">Copyright © 2024 - <a href="#" target="_blank" class="text-muted"> HKBP Padang Bulan</a></i></center>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
</body>
</html>