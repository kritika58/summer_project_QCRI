<!DOCTYPE html>
<html lang="en">
	<head>
	<title>QCRI- Mega News Project</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" src="index_style.css">
	<link rel="icon" type="image/png" href="https://excellence.qa/wp-content/uploads/2016/12/qatar-foundation.png">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- jQuery library -->
	<script src="libs/js/jquery.js"></script>
	<!-- bootstrap JavaScript -->
	<script src="libs/js/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="libs/js/bootstrap/docs-assets/js/holder.js"></script>
	<style>
	    .desc {
        font-size: 20px;
        font-family: "Times New Roman", Times, serif;
    }
  </style>
	</head>
	<body>
		<?php
			include 'dbconnection.php';
		?>
		<form id="form3" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" >
			<h2>Please select a country</h2>
			<select class="form-control" name="country" required>
				<option value="qa">Qatar</option>
				<option value="sa">Saudi Arabia</option>
				<option value="ae">UAE</option>
				<option value="kw">Kuwait</option>
				<option value="uk">UK</option>
				<option value="us">USA</option>
			</select>
			<br>
			<select class="form-control" name="category" required>
				<h2>Please select a category</h2>
				<option value="General">General</option>
				<option value="Entertainment">Entertainment</option>
				<option value="Sports">Sports</option>
				<option value="Science">Science</option>
				<option value="Health">Health</option>
				<option value="Economy">Economy</option>
			</select>

			<input type="submit" name="apply" class="btn btn-success" value"Apply">

		</form>
		<?php 
			if(isset($_POST['apply'])){
				$selected_country = $_POST['country'];
				$selected_category = $_POST['category'];
				$sql = "SELECT * FROM news_arabic WHERE country_code='".$selected_country."' AND Category='".$selected_category."' ";
				$result1 = $conn->query($sql);
				echo ''.mysqli_num_rows($result1);
			}
		?>
            <form id="form4" action='try.php' method="POST">

			<div class="col-sm-6">		

			<ul  class="nav nav-pills nav-stacked">		
				<?php
					$i=0;
					while ($row = $result1->fetch_array(MYSQLI_ASSOC))
					{
						$uname[]=$row["user_name"];
						$id[]=$row["user_id"];
						$img[]=$row["user_profile_image_url"]
				?>
				<li>
					<span><input type="checkbox" name="check_list1[]" value="<?php echo $uname[$i]?>">
					<a href="display.php?id=<?php echo $id[$i]?>">
					<?php echo $uname[$i]?></span>
					<img align="right" style="width: 40px; height:40px;" src="<?php echo $img[$i]?>">
					</a>
				</li>
				<?php  
				$i++;
				}
				?>
				</ul><br>
			<input type="submit" name="submit1" class="btn btn-success" value"Submit">
		</form>
		</div>
	</body>
</html>