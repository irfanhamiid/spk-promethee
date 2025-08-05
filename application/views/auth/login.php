
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login SPK Promethee</title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block">
                <img width="100%" style="padding-left: 30px; padding-top: 50px;" src="<?= base_url('assets/img/undraw_Best_place_re_lne9.png') ?>">
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1>
                  </div>
                  <?php if ($this->session->flashdata('gagal')) { ?>
                    <div class="col-md-12" >
                      <div class="alert alert-danger alert-message" id="auto-close-alert" align="center"><?= $this->session->flashdata('gagal') ?>
                    </div>
                  </div>
                <?php } ?>
                <form class="user" method="post" action="<?= base_url('welcome/do_login') ?>">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="exampleInputEmail" name="username" aria-describedby="emailHelp" placeholder="Masukkan Username">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                  </div>
                  <button class="btn btn-primary btn-user btn-block">Login</button>

                </form>
                <hr>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>
<script>
  // Fungsi untuk menutup alert secara otomatis setelah waktu tertentu
  function autoCloseAlert() {
    const alertElement = document.getElementById('auto-close-alert');
    const timeoutDuration = 2000; // Waktu dalam milidetik (misalnya 5000ms = 5 detik)

    setTimeout(function() {
      alertElement.style.display = 'none'; // Menyembunyikan alert setelah timeout
    }, timeoutDuration);
  }

  // Panggil fungsi autoCloseAlert saat halaman selesai dimuat
  document.addEventListener('DOMContentLoaded', autoCloseAlert);
</script>
</body>

</html>
