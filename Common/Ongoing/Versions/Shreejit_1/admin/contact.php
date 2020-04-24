<?php 
require($_SERVER['DOCUMENT_ROOT']."/Shreejit/dbconnect.php");
if(empty($_SESSION['admin'])){
  header('location:index.php');
}
$_SESSION['page'] = 'contact';


if(isset($_POST['phone'])){
  $phone = $_POST['phone_text'];
  $phone_sp = nl2br($phone);
  $phone_q = "UPDATE contact_us SET Phone='$phone_sp' WHERE 1";
  mysqli_query($db, $phone_q);
  // header('location: contact.php');
  echo "<script>alert('Updated');</script>"; 
}

if(isset($_POST['mail'])){
  $mail = $_POST['mail_text'];
  $mail_sp = nl2br($mail);
  $mail_q = "UPDATE contact_us SET Email='$mail_sp' WHERE 1";
  mysqli_query($db, $mail_q);
  // header('location: contact.php');
  echo "<script>alert('Updated');</script>"; 
}

if(isset($_POST['address'])){
  $address = $_POST['address_text'];
  $address_sp = nl2br($address);
  $address_q = "UPDATE contact_us SET Address='$address_sp' WHERE 1";
  mysqli_query($db, $address_q);
  // header('location: contact.php');
  echo "<script>alert('Updated');</script>"; 
}
?>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - YogaAyurveda</title>

  <!-- Custom fonts for this template-->
  <link href="/Shreejit/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/Shreejit/assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
  <?php include($_SERVER['DOCUMENT_ROOT']."/Shreejit/admin/include/sidebar.php")?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include($_SERVER['DOCUMENT_ROOT']."/Shreejit/admin/include/navbar.php")?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <?php       
            $qcon = "SELECT * FROM contact_us WHERE contact_id = '1';";
            $rescon = mysqli_query($db, $qcon);
            $rowcon = mysqli_fetch_assoc($rescon);
           ?>
          <div class="row">
              <div class="col-lg-6">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-uppercase">Contact Numbers</h6>
                  </div>
                  <div class="card-body">
                    <form action="contact.php" method="post">
                      <!-- &#13;&#10; -->
                      <div class="d-flex justify-content-around">
                          <textarea class="form-control bg-light border-0 small" name="phone_text" style="width:80%;height:10vh"><?php echo str_replace('<br />','&#13;',$rowcon['Phone'])?></textarea>
                          <button class="btn btn-primary" type="submit" name = 'phone'>
                            Update
                          </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-uppercase">Email ID</h6>
                  </div>
                  <div class="card-body">
                    <form action="contact.php" method="post">
                      <div class="d-flex justify-content-around">
                          <textarea class="form-control bg-light border-0 small" name="mail_text" style="width:80%;height:10vh"><?php echo str_replace('<br />','&#13;',$rowcon['Email'])?></textarea>
                          <button class="btn btn-primary" type="submit" name = 'mail'>
                            Update
                          </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary text-uppercase">Address</h6>
                  </div>
                  <div class="card-body">
                    <form action="contact.php" method="post">
                      <div class="d-flex justify-content-around">
                          <textarea class="form-control bg-light border-0 small" name="address_text" style="width:80%;height:10vh"><?php echo str_replace('<br />','&#13;',$rowcon['Address'])?></textarea>
                          <button class="btn btn-primary" type="submit" name = 'address'>
                            Update
                          </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
          </div>
          

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>YogaAyurvedaKarona</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="submit" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="submit" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="/Shreejit/assets/vendor/jquery/jquery.min.js"></script>
  <script src="/Shreejit/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/Shreejit/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/Shreejit/assets/js/sb-admin-2.min.js"></script>

</body>

</html>