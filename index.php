<?php
	session_start();
	require_once __DIR__ . "/vendor/autoload.php";
//	$command = escapeshellcmd('python /home/ketaki/server.py');
//    $output = shell_exec($command);

	if(isset($_POST["submit1"]))
	{
		$client = new MongoDB\Client("mongodb://localhost:27017");
		$collection = $client->gsa->admins;
		$e=test_input($_POST["id1"]);
		$p=test_input($_POST["passwd1"]);
		$document = $collection->findOne(['password' => $p]);
		if($document['_id'] == $e)
		{
			$_SESSION["admin_id"]=$e;
			$_SESSION["admin_pass"]=$p;
			header("Location:admin_dashboard.php");
		}
		else
		{
			?>
			<script type="text/javascript">window.alert("Invalid credentials.");</script>
			<?php ;
		}
	}
	
	if(isset($_POST["submit2"]))
	{
		$client = new MongoDB\Client("mongodb://localhost:27017");
		$collection = $client->gsa->patients;
		$e=test_input($_POST["id2"]);
		$p=test_input($_POST["passwd2"]);
		$document = $collection->findOne(['password' => $p]);
		if($document['_id'] == $e)
		{
			$_SESSION["patient_id"]=$e;
			$_SESSION["patient_pass"]=$p;
			echo "User logged in";
			header("Location:user_dashboard.php");
		}
		else
		{
			?>
			<script type="text/javascript">window.alert("Invalid credentials.");</script>
			<?php ;
		}
	}
	
	function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
	}
?>

<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body class="s">
		<title>GENETIC SEQUENCE ALIGNMENT</title>
		<link rel="stylesheet" type="text/css" href="style.css" media="screen">
		<link href='https://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet'>

		<div>
			<ul>
				<li><p><a class="active" href="index.php">Home</font></a></p></li>
				<li><p><a href="about.html">About GSA</font></a></p></li>
				<li><p><a href="signup.php">New User Registration<font></a></p></li>
			</ul>
		</div>

		<div id="wrap">
			<div id="left">
				<span style="position: relative; top: 30pt; left:30pt;">
					<h2>ADMIN SIGN IN</h2>
					<form action="" method="post">
						<p>ID: <input type="number" min="0" max="99999" name="id1" required="required"> </p>
						<br />
						<p>Password: <input type="password" name="passwd1" required="required"> </p>
						<br />
						<input type="submit" name="submit1" value="Submit">
					</form>
				</span>
			</div>

			<div id="right">
				<span style="position: relative; top: 30pt; left:30pt;">
					<h2>PATIENT SIGN IN</h2>
					<form action="" method="post">
						<p>ID: <input type="number" min="0" max="99999" name="id2" required="required"> </p>
						<br />
						<p>Password: <input type="password" name="passwd2" required="required"> </p>
						<br />
						<input type="submit" name="submit2" value="Submit">
					</form>
				</span>
			</div>
		</div>
	
		<span class="copyright">&copy 2018 Ketaki, Jyoti, Anuja, and Monika</span>
	</body>
</html>
