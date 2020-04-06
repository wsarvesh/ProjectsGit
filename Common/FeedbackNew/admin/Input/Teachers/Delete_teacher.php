<?php require('../../../dbconnect.php');

if(empty($_SESSION['admin'])){
  header('location: index.php');
}


$sem = $_SESSION['sem'];
$dept = $_SESSION['dept'];

	if(isset($_POST['delete'])){

    $del_teacher = mysqli_real_escape_string($db, $_POST['del_teacher']);
    echo $del_teacher;

    $qu = "DELETE FROM teacher WHERE teacher_id='$del_teacher';";
		mysqli_query($db, $qu);



		header('location: teachers.php');
	}

?>
<html lang="en">
<head>
	<title>teachers</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="../../../style/forms/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/vendor/noui/nouislider.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="../../../style/forms/css/util.css">
	<link rel="stylesheet" type="text/css" href="../../../style/forms/css/main.css">
<!--===============================================================================================-->
</head>
<body>


	<div class="container-contact100">
		<div class="wrap-contact100">
			<form class="contact100-form validate-form" action="Delete_teacher.php" method="POST" enctype="multipart/form-data">
				<span class="contact100-form-title">
					Delete teacher for
				</span>

        <div class="wrap-input100">
					<center><label class="label-inputx"><?php echo "SEM: ".$_SESSION['sem']." ".$_SESSION['dept'];  ?></label></center>
				</div>



        <?php
					$que = "SELECT * from teacher WHERE teacher_dept='$dept';";
					$result = mysqli_query($db, $que);
				?>


						<hr width=100%>
						<div class='wrap-input100 input100-select bg2 validate-input' data-validate='Please Fill Field'>
							<span class='label-input100'>Teachers</span>
							<div>
								<select class='js-select2' name="del_teacher" required>
									<option selected disabled value=''>Choose Teacher</option>
                  <?php while($rowq = mysqli_fetch_assoc($result)){
                            $s = $rowq['teacher_id'];
									          echo "<option value='$s'>".$rowq['teacher_name']."</option>";
                  }
                  ?>
								</select>
								<div class='dropDownSelect2'></div>
						</div>
					</div>




        <div class="container-contact100-form-btn">
					<button type="submit" class="contact100-form-btn" name="delete">
						<span>
							Delete
							<i class="fa fa-long-arrow-right m-l-7" aria-hidden="true"></i>
						</span>
					</button>
				</div>

			</form>
		</div>
	</div>

<?php require "../../../include/footer.php"?>

<!--===============================================================================================-->
	<script src="../../../style/forms/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="../../../style/forms/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="../../../style/forms/vendor/bootstrap/js/popper.js"></script>
	<script src="../../../style/forms/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="../../../style/forms/vendor/select2/select2.min.js"></script>
	<script>
		$(".js-select2").each(function(){
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
<!--===============================================================================================-->
	<script src="../../../style/forms/vendor/daterangepicker/moment.min.js"></script>
	<script src="../../../style/forms/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="../../../style/forms/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="../../../style/forms/js/main.js"></script>

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
