<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>YuCare</title>

  <!-- Bootstrap core CSS -->
  <link href="<?php echo base_url('assets/assets_pasien/')?>vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="<?php echo base_url('assets/assets_stisla/') ?>/assets/img/icon.png">
  <!-- Custom styles for this template -->
  <link href="<?php echo base_url('assets/assets_pasien/')?>css/shop-homepage.css" rel="stylesheet">

</head>
  <body class="pt-0">
  <div id="app">
    <section class="section">
      <div class="container mt-4">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand text-center">
              <img src="<?php echo base_url('assets/assets_stisla/') ?>/assets/img/icon.png" alt="logo" width="50" class="shadow-light mb-3">
            </div>

            <div class="card card-primary">
              <div class="card-header text-center"><h4>Lupa Password</h4></div>

              <span class="m-2"><?php echo $this->session->flashdata('pesan') ?></span>

              <div class="card-body">
                <form method="POST" action="<?php echo base_url('auth/forgotpassword') ?>">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" autofocus>
                    <?php echo form_error('email', '<div class="text-danger text-small">', '</div>') ?>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Reset Password 
                    </button>
                  </div>
                </form>

              </div>
            </div>
            <div class="mt-3 text-center">
              <a href="<?= base_url('auth/login')?>">Kembali ke Login</a>
            </div>
            <div class="simple-footer text-muted text-center mt-5">
              Copyright &copy; Stisla 2018
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Bootstrap core JavaScript -->
  <script src="<?php echo base_url('assets/assets_pasien/')?>vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url('assets/assets_pasien/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
