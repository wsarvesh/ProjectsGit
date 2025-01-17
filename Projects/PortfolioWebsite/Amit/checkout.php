<?php

  require($_SERVER['DOCUMENT_ROOT']."/Amit/dbconnect.php");


  // $checkout = $_COOKIE['checkout_var'];
  $checkout = explode (",", $_COOKIE['checkout_var']);
  array_pop($checkout);

  if(count($checkout) > 0){
    $cost_sql = "SELECT * FROM images WHERE image_id IN (".implode(',', $checkout).")";
    $cost_img = mysqli_query($conn, $cost_sql);
    $total_cost = 0;
    while($cost_row = mysqli_fetch_assoc($cost_img)){
      $total_cost = $total_cost + $cost_row['image_cost'];
    }
  }
  else{
    $total_cost = 0;
  }

  if(!isset($_COOKIE['amount_var'])){
    $_COOKIE['amount_var'] = $total_cost;
  }

  if(!isset($_COOKIE['pay_var'])){
    $_COOKIE['pay_var'] = "0";
  }


  $r_auth_key = "rzp_live_dLJl0vyuYIyVNI";

  $sql = "SELECT * FROM images WHERE image_id IN (".implode(',', $checkout).")";
  $img = mysqli_query($conn, $sql);

 ?>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Checkout - Amit Kumar Meena</title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <style media="screen">
    .razorpay-payment-button{
      border-style: solid;
      border: #262626;
      background: #262626;
      color:#efefef;
      border-radius: 25px;
      padding: 20px;
      text-transform: uppercase;
      letter-spacing: 2px;
      font-weight: bold;
      transition: 1s all;
    }
    .razorpay-payment-button:hover{
      opacity:0.7;
    }

    .razorpay-payment-button:focus{
      outline:none;
    }
  </style>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <script type="text/javascript">

    $(document).ready(function() {
      var pay_set = document.cookie.match(new RegExp('(^| )' + "pay_var" + '=([^;]+)'));
      if (pay_set){
        if(pay_set[2] == "1"){
          $(".razorpay-payment-button").click();
        }
      }
      document.cookie = "pay_var = " + "0";
      var total = 0;
      $('.sub').each(function(){
        var val_id = "#costvalue_"+$(this).attr('id');
         total = total + parseInt($(val_id).val());
        $(this).click(function(){
          // document.cookie = "pay_var = " + "0";
          var id = $(this).attr("id");
          var img = "#img_" + id;
          var cost = "#cost_" + id;
          var id_cost = $(this).val().split("_");
          var old_cookie = "";
          var match = document.cookie.match(new RegExp('(^| )' + "checkout_var" + '=([^;]+)'));
          if (match){
            old_cookie = match[2].split(",");
          }

          old_cookie = jQuery.grep(old_cookie, function(value) {
              return value != id_cost[0];
            });
          var new_cookie = old_cookie.join(",")
          var new_total = total - id_cost[1];
          $("#total_cost").html(new_total);
          document.cookie = "amount_var = " + new_total;
          document.cookie = "checkout_var = " + new_cookie;
          $(img).fadeOut("slow");
          $(cost).fadeOut("slow");
          $(img).css("display", "none");
          $(cost).css("display", "none");
          $(img).attr('class', '');
          $(cost).attr('class', '');
        });
        $("#total_cost").html(total);
        console.log(total);
        document.cookie = "amount_var = " + total;
        console.log(document.cookie);
      });

      $("#pay-btn").click(function(){
        document.cookie = "pay_var = " + "1";
        location.reload();
      });
    });

  </script>

</head>

<body class="off-white">

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">

      <h1 class="logo"><a href="index.php">Amit</a></h1>

      <nav class="nav-menu d-none d-lg-block">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="shop.php">Shop</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="blog.php">Blog</a></li>
          <li class="active"><a href="checkout.php">Checkout</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </nav><!-- .nav-menu -->

      <div class="header-social-links">
        <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
        <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
        <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
        <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
      </div>

    </div>

  </header><!-- End Header -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <?php
    if(count($checkout) > 0){

     ?>
    <section id="about" class="about" style="min-height:calc(100vh - 120px)">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Checkout</h2>

        </div>
          <div class="row mb-4">
        <?php
        $total = 0;
        $i = 0;
          while($row = mysqli_fetch_assoc($img)){

         ?>

           <div class="col-lg-3 d-flex align-items-center" id="img_<?= $i ?>">
             <img src="<?= $row['image_path'] ?>" class="img-fluid" alt="">
           </div>
           <div class="col-lg-3 pt-4 pt-lg-0 content d-flex align-items-center mb-4" id="cost_<?= $i ?>">
             <div class="mt-2">
               <div class="mt-1">
                 <h3><?= $row['image_title']?></h3>
                 <p class="font-italic">
                   COST : <b>₹ <?= $row['image_cost'] ?></b>
                 </p>

               </div>
               <div class="mt-4">
                 <p>
                   <input type="number" id="costvalue_<?= $i ?>" value="<?= $row['image_cost'] ?>" hidden>
                   <button type="submit" name="sub" id="<?= $i ?>" class="delete-btn py-1 px-3 sub" value="<?= $row['image_id'] ?>_<?= $row['image_cost'] ?>"><i class="fa fa-minus text-white" aria-hidden="true"></i> &nbsp;&nbsp; REMOVE</button>
                   </p>
               </div>
             </div>
           </div>


        <?php
          $total = $total + intval($row['image_cost']);
          $i++;
          }
         ?>
         </div>

         <div class="row mt-5">
           <div class="col-12">
             <center>
               <h1  style="color:#4d4d4d" class="text-uppercase">Total Cost</h1>
               <hr style="background:#262626;width:30%;height:3px">
               <h2 style="color:#4d4d4d"><b>₹
                 <span id="total_cost">
                   0
                 </span>
                 </b></h2>
             </center>
           </div>
         </div>

         <div class="row mt-5" style="display:none">

           <div class="col-12">
             <center>
               <form action="pay.php" method="POST">
           <script
               src="https://checkout.razorpay.com/v1/checkout.js"
               data-key="<?= $r_auth_key ?>" // Enter the Key ID generated from the Dashboard
               data-amount="<?= ((int)$_COOKIE['amount_var']*100); ?>" // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
               data-currency="INR"
               data-buttontext="Pay with RazorPay"
               data-name="Amit Kumar Mena"
               data-description=""
               data-theme.color="#262626"
               data-text.color="#EFEFEF"
           ></script>
           <input type="hidden" custom="Hidden Element" name="hidden">

           </form>
         </center>
           </div>
         </div>

         <div class="row">
           <div class="col-12">
             <center>
               <button id="pay-btn" class="read-btn">Pay with RazorPay</button>
             </center>
           </div>
         </div>

      </div>
    </section>

    <?php
      }
    else{
     ?>

    <section id="about" class="about" style="min-height:calc(100vh - 120px)">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Checkout</h2>

        </div>

        <div class="d-flex justify-content-center align-items-center" style="height:50%">
          <span>NO ITEMS ARE SELECTED</span>
        </div>

      </div>
    </section>
    <!-- End About Section -->
    <?php
        }
     ?>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container d-flex align-items-end justify-content-center">
      <div class="copyright" style="font-size:3px; opacity:0.3;">
        &copy; Copyright <strong><span>Kelly</span></strong>. All Rights Reserved
      </div>
      <div class="credits" style="font-size:3px; opacity:0.3;">
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="bx bx-up-arrow-alt"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/venobox/venobox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
