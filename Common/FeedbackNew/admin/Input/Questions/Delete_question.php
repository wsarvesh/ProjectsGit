<?php require('../../../dbconnect.php');

if(empty($_SESSION['admin'])){
  header('location: index.php');
}

$q = "SELECT * from feedback_ques;";
$results= mysqli_query($db, $q);


	if(isset($_POST['delete'])){
		$question = mysqli_real_escape_string($db, $_POST['question']);

    for($i=0;$i<mysqli_num_rows($results);$i++){
      if(isset($_POST[$i])){

        $qu = "DELETE FROM feedback_ques WHERE fbq_id='$_POST[$i]';";
        mysqli_query($db, $qu);

      }
    }

		header('location: index.php');
	}

?>
<html lang="en">
<head>
	<title>Subjects</title>
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
			<form class="contact100-form validate-form" action="Delete_question.php" method="POST" enctype="multipart/form-data">
				<span class="contact100-form-title">
					Delete question
				</span>

        <?php


        $x = 0;
        while($row = mysqli_fetch_assoc($results)){
          echo '<div class="wrap-input100 bg1">';
  					echo '<span class="label-input100">Question</span><br>';
  				      echo '&nbsp&nbsp<label class="label-inputx" style="font-size:18px;">&nbsp&nbsp<input class="options" type="checkbox" name="'.$x.'" value="'.$row['fbq_id'].'">&nbsp&nbsp'.$row['question'].'</label><br>';
  				echo '</div>';

          $x++;

        }

         ?>


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
