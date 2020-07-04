<!DOCTYPE html>
<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$db = "restaurant";

	$conn = mysqli_connect($servername, $username, $password, $db);
	$messages = array();

	function valid_file($filetoUpload, $target_dir){

		$countfiles = count($_FILES[$filetoUpload]['name']);

		$messages = array();

		for($i=0;$i<$countfiles;$i++){

	    $target_file = $target_dir . basename($_FILES[$filetoUpload]["name"][$i]);
	    $uploadOk = 1;
	    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	      $check = getimagesize($_FILES[$filetoUpload]["tmp_name"][$i]);

	      if (file_exists($target_file)) {
	          $message =  ' file already exists. Please Rename your file';
	          array_push($messages,$message);
	          $uploadOk = 0;
	      }
	      // Check file size
	      if ($_FILES[$filetoUpload]["size"][$i] > 500000) {
	          $message =  ' your file is too large.';
	          array_push($messages,$message);
	          $uploadOk = 0;
	      }
	      // Allow certain file formats
	      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	      && $imageFileType != "gif" ) {
	          $message =  ' only JPG, JPEG, PNG & GIF files are allowed.';
	          array_push($messages,$message);
	          $uploadOk = 0;
	      }
	      // Check if $uploadOk is set to 0 by an error

			}
			return $uploadOk;

	}

	function add_file($filetoUpload, $target_dir){
		// $target_dir = "";
		$countfiles = count($_FILES[$filetoUpload]['name']);

		$messages = array();

		for($i=0;$i<$countfiles;$i++){

	    $target_file = $target_dir . basename($_FILES[$filetoUpload]["name"][$i]);
	    $uploadOk = 1;
	    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	      $check = getimagesize($_FILES[$filetoUpload]["tmp_name"][$i]);

	      if (file_exists($target_file)) {
	          $message =  ' file already exists. Please Rename your file';
	          array_push($messages,$message);
	          $uploadOk = 0;
	      }
	      // Check file size
	      if ($_FILES[$filetoUpload]["size"][$i] > 500000) {
	          $message =  ' your file is too large.';
	          array_push($messages,$message);
	          $uploadOk = 0;
	      }
	      // Allow certain file formats
	      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	      && $imageFileType != "gif" ) {
	          $message =  ' only JPG, JPEG, PNG & GIF files are allowed.';
	          array_push($messages,$message);
	          $uploadOk = 0;
	      }
	      // Check if $uploadOk is set to 0 by an error
	      if ($uploadOk == 0) {
	          $message =  ' your file was not uploaded.';
	          array_push($messages,$message);
	      // if everything is ok, try to upload file
	      } else {
	          if (move_uploaded_file($_FILES[$filetoUpload]["tmp_name"][$i], $target_file)) {
	              // $message =  '<label class="text-uppercase" style="color:green" >'.'The file "'. basename( $_FILES[$filetoUpload]["name"][$i]). '" has been uploaded.'.'</label><br>';
	              // array_push($messages,$message);
	              $tar = explode("/",$target_file);
	              $x = array_slice($tar, -3);
	              $x2 = join("/",$x);
	              // $new_target = $_SERVER['DOCUMENT_ROOT']."/Shreejit/".$x2;
	              $new_target = "/Shreejit/".$x2;
	              // $qu = "INSERT INTO images (image_path) VALUES ('$new_target')";
	              // mysqli_query($db, $qu);
	          } else {
	              $message =  ' there was an error uploading your file.';
	              array_push($messages,$message);
	          }
	      }
	  }
	}

	if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
		$owner_name = mysqli_real_escape_string($conn, $_POST['owner_name']);
		$poc = mysqli_real_escape_string($conn, $_POST['poc']);
		$city = mysqli_real_escape_string($conn, $_POST['city']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);
		$landmark = mysqli_real_escape_string($conn, $_POST['landmark']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$website = mysqli_real_escape_string($conn, $_POST['website']);
		$pay1 = $_POST['pay'];
		$pay2 = "";
		foreach ($pay1 as $color){
				$pay2 = $pay2 . $color . ";";
		}
		$pay = substr($pay2, 0, -1);
		$alcohol = mysqli_real_escape_string($conn, $_POST['alcohol']);
		$cuisine = mysqli_real_escape_string($conn, $_POST['cuisine']);
		$service1 = $_POST['service'];
		$service2 = "";
		foreach ($service1 as $color){
				$service2 = $service2 . $color . ";";
		}
		$service = substr($service2, 0, -1);
		$offer1 = $_POST['offer'];
		$offer2 = "";
		foreach ($offer1 as $color){
				$offer2 = $offer2 . $color . ";";
		}
		$offer = substr($offer2, 0, -1);
		$liscence = mysqli_real_escape_string($conn, $_POST['liscence']);
		$regno = mysqli_real_escape_string($conn, $_POST['regno']);
		$addr = mysqli_real_escape_string($conn, $_POST['addr']);
		$exp = mysqli_real_escape_string($conn, $_POST['exp']);
		$outlets = mysqli_real_escape_string($conn, $_POST['outlets']);
		$avg_cost = mysqli_real_escape_string($conn, $_POST['avg_cost']);
		$primary_area = mysqli_real_escape_string($conn, $_POST['primary_area']);
		$path = "file/" . $name . '_' . $owner_name;
		$menu1 = $_FILES['menu']['name'];
		$menu2 = "";
		foreach ($menu1 as $key) {
			$menu2 = $menu2.$path."/".$key.";";
		}
		$menu = substr($menu2, 0, -1);


		$img1 = $_FILES['img']['name'];
		$img2 = "";
		foreach ($img1 as $key) {
			$img2 = $img2.$path."/".$key.";";
		}
		$img = substr($img2, 0, -1);


		$kyc1 = $_FILES['kyc']['name'];
		$kyc2 = "";
		foreach ($kyc1 as $key) {
			$kyc2 = $kyc2.$path."/".$key.";";
		}
		$kyc = substr($kyc2, 0, -1);


		$pan1 = $_FILES['pan']['name'];
		$pan2 = "";
		foreach ($pan1 as $key) {
			$pan2 = $pan2.$path."/".$key.";";
		}
		$pan = substr($pan2, 0, -1);


		$gstin1 = $_FILES['gstin']['name'];
		$gstin2 = "";
		foreach ($gstin1 as $key) {
			$gstin2 = $gstin2.$path."/".$key.";";
		}
		$gstin = substr($gstin2, 0, -1);


		$shop_liscence1 = $_FILES['shop_liscence']['name'];
		$shop_liscence2 = "";
		foreach ($shop_liscence1 as $key) {
			$shop_liscence2 = $shop_liscence2.$path."/".$key.";";
		}
		$shop_liscence = substr($shop_liscence2, 0, -1);

		$k = valid_file("menu", $path."/");
		$k = $k + valid_file("img", $path."/");
		$k = $k + valid_file("kyc", $path."/");
		$k = $k + valid_file("pan", $path."/");
		$k = $k + valid_file("gstin", $path."/");
		$k = $k + valid_file("shop_liscence", $path."/");

		if ($k == 6){
			mkdir($path, 0700);

			add_file("menu", $path."/");
			add_file("img", $path."/");
			add_file("kyc", $path."/");
			add_file("pan", $path."/");
			add_file("gstin", $path."/");
			add_file("shop_liscence", $path."/");

			$sql = "INSERT INTO data(name, owner_name, poc, city, address, landmark, email, website, payment, alcohol, cuisine, service, offer, menu, img, fssai_liscence, fssai_regno, fssai_addr, fssai_exp, kyc, pan_card, gstin, shop_liscence, outlets, avg_cost, primary_area) VALUES ";
			$sql = $sql."('$name', '$owner_name', '$poc', '$city', '$address', '$landmark', '$email', '$website', '$pay', '$alcohol', '$cuisine', '$service', '$offer', '$menu', '$img', '$liscence', '$regno', '$addr', '$exp', '$kyc', '$pan', '$gstin', '$shop_liscence', '$outlets', '$avg_cost', '$primary_area')";
			mysqli_query($conn, $sql);

		}


}

 ?>
<html lang="en">
<head>
	<title>MOOD</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<!--===============================================================================================-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script src="js/query.js"></script>

</head>
<body>

	<div class="bg-contact2" >
		<div class="container-contact2">
			<div class="big-cont">
				<center>
					<div class="wrap-contact2-b mb-4 mt-3" id="startdiv">
					<span class="contact2-form-title text-white">
						M O O D I S H
					</span>
					
					<div class="mt-3">
						<span class="text-uppercase text-white font-weight-bold" style="letter-spacing:2px;">The one stop place for your restaurant growth</span>
					</div>
					
					<center><hr style="background:white;width:70%;height:3px;"></center>
					<div class="mt-3 mb-3 text-white" style="font-size:3vh;">
						<center>
							<i class="fa fa-space-shuttle text-white " aria-hidden="true"></i> &nbsp;&nbsp;
							<span class="text-uppercase text-white font-weight-bold " style="letter-spacing:2px;">Simple and fast onboarding process </span>
						</center>
					</div>
					<div class="mb-2 text-white">
						<center>
							<i class="fa fa-check-circle-o text-white small-font" aria-hidden="true"></i> &nbsp;&nbsp;
							<span class="text-uppercase text-white font-weight-bold small-font" style="letter-spacing:2px;">Fill the Registration form below </span>
						</center>
					</div>
					<div class="mb-2 text-white">
						<center>
							<i class="fa fa-check-circle-o text-white small-font" aria-hidden="true"></i> &nbsp;&nbsp;
							<span class="text-uppercase text-white font-weight-bold small-font" style="letter-spacing:2px;">Sign the service agreement </span>
						</center>
					</div>
					<div class="mb-2 text-white">
						<center>
							<i class="fa fa-check-circle-o text-white small-font" aria-hidden="true"></i> &nbsp;&nbsp;
							<span class="text-uppercase text-white font-weight-bold small-font" style="letter-spacing:2px;">Choose from the set of services (optional)</span>
						</center>
					</div>
					<div class="mb-2 text-white">
						<center>
							<i class="fa fa-check-circle-o text-white small-font" aria-hidden="true"></i> &nbsp;&nbsp;
							<span class="text-uppercase text-white font-weight-bold small-font" style="letter-spacing:2px;">Restaurant is now live within 24-48 hrs </span>
						</center>
					</div>
					
					<center><hr style="background:white;width:50%;height:3px;"></center>
					<div class="mt-3 mb-3 text-white" style="font-size:3vh;">
						<center>
							<i class="fa fa-wrench text-white" aria-hidden="true"></i></i> &nbsp;&nbsp;
							<span class="text-uppercase text-white font-weight-bold " style="letter-spacing:2px;">OUR SERVICES for you</span>
						</center>
					</div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-sm-12 col-lg-4">
								<div class="mb-2 text-white">
									<center>
										<i class="fa fa-shopping-cart text-white small-font" aria-hidden="true"></i> &nbsp;&nbsp;
										<span class="text-uppercase text-white font-weight-bold small-font" style="letter-spacing:2px;">Marketing</span>
									</center>
								</div>
							</div>
							<div class="col-sm-12 col-lg-4">
								<div class="mb-2 text-white">
									<center>
										<i class="fa fa-superpowers text-white small-font" aria-hidden="true"></i>&nbsp;&nbsp;
										<span class="text-uppercase text-white font-weight-bold small-font" style="letter-spacing:2px;">Website Development</span>
									</center>
								</div>
							</div>
							<div class="col-sm-12 col-lg-4">
								<div class="mb-2 text-white">
									<center>
										<i class="fa fa-camera text-white small-font" aria-hidden="true"></i> &nbsp;&nbsp;
										<span class="text-uppercase text-white font-weight-bold small-font" style="letter-spacing:2px;">Photography</span>
									</center>
								</div>
							</div>
						</div>		
					</div>
					
					<center>
					<div class="mt-4 open-btn" id="open">
						REGISTER NOW
					</div>
					 
				</center>

			</div>

			<div class="wrap-contact2-b2" id="form-open" style="display:none;">
				<form name="form" class="contact2-form validate-form" action="index.php" method="post" enctype= "multipart/form-data">
					<div class="mb-5">
						<span class="contact2-form-title gr-text text-uppercase">
							Registration Form
						</span>
						<center><hr style="background:white;width:60%;height:3px;"></center>
					</div>

					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="wrap-input2 mb-4 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900"> NAME OF RESTAURANT</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="name" required >
									<span class="focus-input2"></span>
								</div>
							</div>
							<div class="col-12">
								<div class="wrap-input2 mb-4 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900"> NAME OF THE OWNER</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="owner_name" required >
									<span class="focus-input2"></span>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2 mb-4 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900"> POC designation</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="poc" required >
									<span class="focus-input2"></span>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2 mb-4 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900"> CITY</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="city" required >
									<span class="focus-input2"></span>
								</div>
							</div>
							<div class="col-12">
								<div class="wrap-input2 mb-4 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900"> ADDRESS</span>
									<textarea class="input2 text-white" style="background:transparent" type="text" name="address" required ></textarea>
									<span class="focus-input2"></span>
								</div>
							</div>
							<div class="col-12">
								<div class="wrap-input2 mb-4 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">LANDMARK</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="landmark" required >
									<span class="focus-input2"></span>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2 mb-1 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">RESTAURANT EMAIL</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="email" required >
									<span class="focus-input2"></span>
								</div>
								<div class="text-white text-uppercase" style="font-size:15px">
									Owner MAil ID
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2 mb-1 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">RESTAURANT WEBSITE</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="website" required >
									<span class="focus-input2"></span>
								</div>
								<div class="text-white text-uppercase" style="font-size:15px">
									Dont have One? We Can help YOU. <span style="font-weight:bold">CLICK HERE</span>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2-cb mb-4 mt-4 validate-input" id="paydiv">
									<center><span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">PAYMENT METHOD</span></center>
									<div class="mt-3 d-flex justify-content-around">
										<div class="d-flex justify-content-center">
											<div class="ch-wrap">
		                    <input type="checkbox" class="mk pay" name="pay[]" value="card" id="pay1" hidden/>
		                    <label for="pay1" class="mark"></label>
		                  </div>
											&nbsp;&nbsp;
											<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="height:30px;font-size:3vh">
												CARD
											</div>
										</div>
										<div class="d-flex justify-content-center">
											<div class="ch-wrap">
		                    <input type="checkbox" class="mk pay" name="pay[]" value="cash" id="pay2" hidden/>
		                    <label for="pay2" class="mark"></label>
		                  </div>
											&nbsp;&nbsp;
											<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="height:30px;font-size:3vh">
												CASH
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2-cb mb-4 mt-4 validate-input" id="alcoholdiv">
									<center><span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">SERVES ALCOHOL</span></center>
									<div class="mt-3 d-flex justify-content-around">
										<div class="d-flex justify-content-center">
											<div class="ch-wrap">
		                    <input type="radio" class="mk" name="alcohol" value="yes" id="alcohol1" hidden/>
		                    <label for="alcohol1" class="mark"></label>
		                  </div>
											&nbsp;&nbsp;
											<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="height:30px;font-size:3vh">
												YES
											</div>
										</div>
										<div class="d-flex justify-content-center">
											<div class="ch-wrap">
		                    <input type="radio" class="mk" name="alcohol" value="no" id="alcohol2" hidden/>
		                    <label for="alcohol2" class="mark"></label>
		                  </div>
											&nbsp;&nbsp;
											<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="height:30px;font-size:3vh">
												No
											</div>
										</div>

									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="wrap-input2 mb-4 mt-4 validate-input">
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">CUISINE</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="cuisine" required >
									<span class="focus-input2"></span>
								</div>
							</div>
							<div class="col-12 d-flex justify-content-center">
								<div class="wrap-input2-cb mb-4 validate-input" id="servicediv" style="padding:0px;margin:0px;width:80%">
									<center><span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">SERVICES Offered</span></center>
									<div class="container-fluid">
									<div class="row">
										<div class=" col-sm-12 col-lg-4 mt-2 d-flex justify-content-center">
											<div class="ch-wrap">
		                    <input type="checkbox" class="mk" name="service[]" value="Breakfast" id="services1"  hidden/>
		                    <label for="services1" class="mark"></label>
		                  </div>
											&nbsp;&nbsp;
											<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="height:30px;font-size:3vh">
												Breakfast
											</div>
										</div>
										<div class="col-sm-12 col-lg-4 mt-2 d-flex justify-content-center">
											<div class="ch-wrap">
		                    <input type="checkbox" class="mk" name="service[]" value="Lunch" id="services2" hidden/>
		                    <label for="services2" class="mark"></label>
		                  </div>
											&nbsp;&nbsp;
											<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="height:30px;font-size:3vh">
												Lunch
											</div>
										</div>
										<div class="col-sm-12 col-lg-4 mt-2 d-flex justify-content-center">
											<div class="ch-wrap">
		                    <input type="checkbox" class="mk" name="service[]" value="Dinner" id="services3" hidden/>
		                    <label for="services3" class="mark"></label>
		                  </div>
											&nbsp;&nbsp;
											<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="height:30px;font-size:3vh">
												Dinner
											</div>
										</div>
										<div class="col-sm-12 col-lg-6 mt-2 d-flex justify-content-center">
											<div class="ch-wrap">
		                    <input type="checkbox" class="mk" name="service[]" value="Night Life" id="services4" hidden/>
		                    <label for="services4" class="mark"></label>
		                  </div>
											&nbsp;&nbsp;
											<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="height:30px;font-size:3vh">
												Night Life
											</div>
										</div>
										<div class="col-sm-12 col-lg-6 mt-2 d-flex justify-content-center">
											<div class="ch-wrap">
		                    <input type="checkbox" class="mk" name="service[]" value="Cafe" id="services5" hidden/>
		                    <label for="services5" class="mark"></label>
		                  </div>
											&nbsp;&nbsp;
											<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="height:30px;font-size:3vh">
												Cafe
											</div>
										</div>
									</div>
								</div>
								</div>
							</div>
							<div class="col-12 d-flex justify-content-center">
								<center><hr style="background:white;width:40%;height:2px;"></center>
								<div class="wrap-input2-cb mb-4 mt-4 validate-input" id="offerdiv" style="width:100%">
									<center><span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">AVAILABLE ATTRIBUTES</span></center>
									<div class="container-fluid mt-4">
										<div class="row">
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Live Music" id="offer11" hidden/>
				                    <label for="offer11" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Live Music
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Couple Entry" id="offer21" hidden/>
				                    <label for="offer21" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Couple Entry
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Free parking" id="offer31" hidden/>
				                    <label for="offer31" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Free parking
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Above 18 only" id="offer12" hidden/>
				                    <label for="offer12" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Above 18 only
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Outdoor seating" id="offer22" hidden/>
				                    <label for="offer22" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Outdoor seating
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Table Reservation" id="offer32" hidden/>
				                    <label for="offer32" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Table Reservation
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Poolside" id="offer13" hidden/>
				                    <label for="offer13" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Poolside
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Catering" id="offer23" hidden/>
				                    <label for="offer23" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Catering
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Pet friendly" id="offer33" hidden/>
				                    <label for="offer33" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Pet friendly
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Private Dining" id="offer14" hidden/>
				                    <label for="offer14" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Private Dining
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Smoking Area" id="offer24" hidden/>
				                    <label for="offer24" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Smoking Area
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Buffet" id="offer34" hidden/>
				                    <label for="offer34" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Buffet
													</div>
												</div>
											</div>
											<div class="col-sm-12 col-lg-4 mb-3">
												<div class="d-flex justify-content-start">
													<div class="ch-wrap">
				                    <input type="checkbox" class="mk" name="offer[]" value="Board Games" id="offer15" hidden/>
				                    <label for="offer15" class="mark"></label>
				                  </div>
													&nbsp;&nbsp;
													<div class="text-white font-weight-bold text-uppercase d-flex align-items-center" style="font-size:3vh">
														Board Games
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2-cb mb-4 validate-input" >
									<div class="mb-3">
										<center>
											<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">MENU IMAGES</span>
										</center>
									</div>
									<center>
										<label for="menu-upload" id="menu-upload-label" class="upload"> Upload Images
										</label>
									</center>
									<input type="file" class="uploading" id="menu-upload" name="menu[]" multiple style="display:none;"  >
									<div class="">
										<center>
											<span class="text-danger text-uppercase" id="menu-upload-error" style="letter-spacing:2px;font-weight:400"></span>
										</center>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2-cb mb-4 validate-input" >
									<div class="mb-3">
										<center>
											<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">RESTAURANT IMAGES</span>
										</center>
									</div>
									<center>
										<label for="pictures-upload" id="pictures-upload-label" class="upload"> Upload Images
										</label>
									</center>
									<input class="uploading" id="pictures-upload" name='img[]' type="file" multiple="multiple" style="display:none;"  >
									<div class="">
										<center>
											<span class="text-danger text-uppercase" id="pictures-upload-error" style="letter-spacing:2px;font-weight:400"></span>
										</center>
									</div>
								</div>
							</div>
							<div class="col-12">
								<center><span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900;font-size:4vh">FSSAI Certificate</span></center>
								<div class="container-fluid">
									<div class="row">
										<div class="col-sm-12 col-lg-6 mt-3">
											<div class="wrap-input2 mb-4 validate-input" >
												<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">LISCENCE NUMBER</span>
												<input class="input2 text-white" style="background:transparent" type="text" name="liscence" required >
												<span class="focus-input2"></span>
											</div>
										</div>
										<div class="col-sm-12 col-lg-6 mt-3">
											<div class="wrap-input2 mb-4 validate-input" >
												<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">REGISTRATION NUMBER</span>
												<input class="input2 text-white" style="background:transparent" type="text" name="regno" required >
												<span class="focus-input2"></span>
											</div>
										</div>
										<div class="col-sm-12 col-lg-6 mt-3">
											<div class="wrap-input2 mb-4 validate-input" >
												<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">ADDRESS</span>
												<textarea class="input2 text-white" style="background:transparent" type="text" name="addr" required ></textarea>
												<span class="focus-input2"></span>
											</div>
										</div>
										<div class="col-sm-12 col-lg-6 mt-3 d-flex align-items-end">
											<div class="wrap-input2 mb-4 validate-input" >
												<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">EXPIRY</span>
												<input class="input2 text-white" style="background:transparent" type="date" name="exp" required >
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12">
								<center><span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900;font-size:4vh">DOCUMENTS</span></center>
								<div class="container-fluid mt-3">
									<div class="row">
										<div class="col-sm-12 col-lg-6">
											<div class="wrap-input2-cb mb-4 validate-input" >
												<div class="mb-3">
													<center>
														<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">KYC VERIFICATION</span>
													</center>
												</div>
												<center>
													<label for="kyc-upload" id="kyc-upload-label" class="upload"> Upload Document
													</label>
												</center>
												<input class="uploading" id="kyc-upload" name='kyc[]' type="file" multiple="multiple" style="display:none;" >
												<div class="">
													<center>
														<span class="text-danger text-uppercase" id="kyc-upload-error" style="letter-spacing:2px;font-weight:400"></span>
													</center>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-lg-6">
											<div class="wrap-input2-cb mb-4 validate-input" >
												<div class="mb-3">
													<center>
														<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">PAN CARD</span>
													</center>
												</div>
												<center>
													<label for="pan-upload" id="pan-upload-label" class="upload"> Upload Document
													</label>
												</center>
												<input class="uploading" id="pan-upload" name='pan[]' type="file" multiple="multiple" style="display:none;"  >
												<div class="">
													<center>
														<span class="text-danger text-uppercase" id="pan-upload-error" style="letter-spacing:2px;font-weight:400"></span>
													</center>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-lg-6">
											<div class="wrap-input2-cb mb-4 validate-input" >
												<div class="mb-3">
													<center>
														<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">GSTIN Certificate</span>
													</center>
												</div>
												<center>
													<label for="gstin-upload" id="gstin-upload-label" class="upload"> Upload Document
													</label>
												</center>
												<input class="uploading" id="gstin-upload" name='gstin[]' type="file" multiple="multiple" style="display:none;"  >
												<div class="">
													<center>
														<span class="text-danger text-uppercase" id="gstin-upload-error" style="letter-spacing:2px;font-weight:400"></span>
													</center>
												</div>
											</div>
										</div>
										<div class="col-sm-12 col-lg-6">
											<div class="wrap-input2-cb mb-4 validate-input" >
												<div class="mb-3">
													<center>
														<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">SHOP LISCENCE</span>
													</center>
												</div>
												<center>
													<label for="liscence-upload" id="liscence-upload-label" class="upload"> Upload Document
													</label>
												</center>
												<input class="uploading" id="liscence-upload" name='shop_liscence[]' type="file" multiple="multiple" style="display:none;"  >
												<div class="">
													<center>
														<span class="text-danger text-uppercase" id="liscence-upload-error" style="letter-spacing:2px;font-weight:400"></span>
													</center>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2 mb-4 mt-4 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">Number of Outlets</span>
									<input class="input2 text-white" style="background:transparent" type="number" name="outlets" required >
									<span class="focus-input2"></span>
								</div>
							</div>
							<div class="col-sm-12 col-lg-6">
								<div class="wrap-input2 mb-4 mt-4 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">Average cost for 2</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="avg_cost" required >
									<span class="focus-input2"></span>
								</div>
							</div>
							<div class="col-12">
								<div class="wrap-input2 mb-4 mt-4 validate-input" >
									<span class="gr-text text-uppercase" style="letter-spacing:2px;font-weight:900">Primary Area of the Restaurant</span>
									<input class="input2 text-white" style="background:transparent" type="text" name="primary_area" required >
									<span class="focus-input2"></span>
								</div>
							</div>
						</div>
					</div>

					<div class="mt-2" >
						<center>
							<span class="font-weight-bold text-uppercase text-danger" id="error" style="letter-spacing:2px;">

							</span>
						</center>
					</div>





					<div class="container-contact2-form-btn">
						<div class="wrap-contact2-form-btn" style="border-radius:30px">
							<div class="contact2-form-bgbtn" style="border-radius:30px"></div>
							<div id="form-submit" class="contact2-form-btn text-uppercase" style="border-radius:30px;letter-spacing:2px;">
								Submit
							</div>
						</div>
					</div>
					<button type="submit" name="submit" id="final-submit" hidden></button>
				</form>
			</div>
		</center>
			</div>
		</div>
	</div>

<!--===============================================================================================-->
	<script src="js/main.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>

</body>
</html>