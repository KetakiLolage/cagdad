<?php
	session_start();
	require_once __DIR__ . "/vendor/autoload.php";
?>

<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body class="a">
		<link rel="stylesheet" type="text/css" href="style.css" media="screen">
		<link href='https://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet'>

		<div>
			<ul>
					<li><p ><a href="index.php">Home</a></p></li>
					<li><p><a href="about.html">About GSA</a></p></li>
					<li><p><a class="active" href="signup.php">New User Registration</a></p></li>
			</ul>
		</div>
		<div id="signup">

		<form action="" method="post">
			<p >FIRST NAME:<input type="text" name="fname" size="15" required="required" maxlength="30" pattern="[A-Za-z]{1,}" value="<?php if (isset($_POST['fname'])) echo $_POST['fname']; ?>" /><?php echo "<label class=error>$errors[0]</label>"?></p>
		
			<p >LAST NAME:  <input type="text" name="lname" size="15" required="required" maxlength="30" pattern="[A-Za-z]{1,}" value="<?php if (isset($_POST['lname'])) echo $_POST['lname']; ?>" /><?php echo "<label class=error>$errors[1]</label>"?></p>
		
			<p >DATE OF BIRTH:
			<select name="bday" id="Birthday_Day" value="<?php if (isset($_POST['bday'])) echo $_POST['bday']; ?>" >
				<option value="-1">Day</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
			</select>
	
			<select id="Birthday_Month" name="bmonth" value="<?php if (isset($_POST['bmonth'])) echo $_POST['bmonth']; ?>" >
				<option value="-1">Month</option>
				<option value="January">Jan</option>
				<option value="February">Feb</option>
				<option value="March">Mar</option>
				<option value="April">Apr</option>
				<option value="May">May</option>
				<option value="June">Jun</option>
				<option value="July">Jul</option>
				<option value="August">Aug</option>
				<option value="September">Sep</option>
				<option value="October">Oct</option>
				<option value="November">Nov</option>
				<option value="December">Dec</option>
			</select>
									 
			<select name="byear" id="Birthday_Year" value="<?php if (isset($_POST['byear'])) echo $_POST['byear']; ?>" >
				<option value="-1">Year</option>
				<option value="2000">2000</option>
				<option value="1999">1999</option>
				<option value="1998">1998</option>
				<option value="1997">1997</option>
				<option value="1996">1996</option>
				<option value="1995">1995</option>
				<option value="1994">1994</option>
				<option value="1993">1993</option>
				<option value="1992">1992</option>
				<option value="1991">1991</option>
				<option value="1990">1990</option>
				<option value="1989">1989</option>
				<option value="1988">1988</option>
				<option value="1987">1987</option>
				<option value="1986">1986</option>
				<option value="1985">1985</option>
				<option value="1984">1984</option>
				<option value="1983">1983</option>
				<option value="1982">1982</option>
				<option value="1981">1981</option>
				<option value="1980">1980</option>
				<option value="1979">1979</option>
				<option value="1978">1978</option>
				<option value="1977">1977</option>
				<option value="1976">1976</option>
				<option value="1975">1975</option>
				<option value="1974">1974</option>
				<option value="1973">1973</option>
				<option value="1972">1972</option>
				<option value="1971">1971</option>
				<option value="1970">1970</option>
				<option value="1969">1969</option>
				<option value="1968">1968</option>
				<option value="1967">1967</option>
				<option value="1966">1966</option>
				<option value="1965">1965</option>
				<option value="1964">1964</option>
				<option value="1963">1963</option>
				<option value="1962">1962</option>
				<option value="1961">1961</option>
				<option value="1960">1960</option>
				<option value="1959">1959</option>
				<option value="1958">1958</option>
				<option value="1957">1957</option>
				<option value="1956">1956</option>
				<option value="1955">1955</option>
				<option value="1954">1954</option>
				<option value="1953">1953</option>
				<option value="1952">1952</option>
				<option value="1951">1951</option>
				<option value="1950">1950</option>
				<option value="1959">1949</option>
				<option value="1958">1948</option>
				<option value="1957">1947</option>
				<option value="1956">1946</option>
				<option value="1955">1945</option>
				<option value="1954">1944</option>
				<option value="1953">1943</option>
				<option value="1952">1942</option>
				<option value="1951">1941</option>
				<option value="1950">1940</option>
			</select>

			<?php echo "<label class=error>$errors[2]</label>"?>

			<p >EMAIL ID:<input type="email" name="email" size="30" maxlength="100" placeholder="example@domain.com"value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" /><?php echo "<label class=error>$errors[3]</label>"?></p>	

			<p>PASSWORD: <input type="password" name="pass" size="10" maxlength="30" required="required" value="<?php if (isset($_POST['pass'])) echo $_POST['pass']; ?>" /><?php echo "<label class=error>$errors[4]</label>"?></p>

			<p >CONFIRM PASSWORD: <input type="password" name="pass1" size="10" maxlength="20" required="required"/><?php echo "<label class=error>$errors[25]</label>"?></p>

			<p >MOBILE NUMBER:  <input type="text" name="mob" maxlength="10" pattern="[7-9]{1}[0-9]{9}" value="<?php if (isset($_POST['mob'])) echo $_POST['mob']; ?>" /><?php echo "<label class=error>$errors[5]</label>"?></p>

			<p >GENDER:  Male <input type="radio" name="gender" value="Male" required="required" />
			   	    Female <input type="radio" name="gender" value="Female" />   <?php echo "<label class=error>$errors[6]</label>"?></p>
	
	
			<p >NATIONALITY: <select name="nationality" value="<?php if (isset($_POST['nationality'])) echo $_POST['nationality']; ?>" >
				<option value="-1">-Select-</option>	
				<option value="Indian">Indian</option>
				<option value="NRI">NRI</option>
				<option value="PIO">PIO</option>
				<option value="OCI">OCI</option>
				<option value="Other">Other</option>
			</select>
			<?php echo "<label class=error>$errors[7]</label>"?>
				</p>

			<p >BLOOD GROUP:  <select name="bgrp" value="<?php if (isset($_POST['bgrp'])) echo $_POST['bgrp']; ?>" >
				<option value="-1">-Select-</option>
				<option value="A+">A+</option>
				<option value="A-">A-</option>
				<option value="B+">B+</option>
				<option value="B-">B-</option>
				<option value="AB+">AB+</option>
				<option value="AB-">AB-</option>
				<option value="O+">O+</option>
				<option value="O-">O-</option>
			</select>
			<?php echo "<label class=error>$errors[8]</label>"?>
			</p>			 

			<br />
				<p>
					<input type="submit" name="submit1" value="Submit"/>
					<input type="reset" name="reset" value="Reset"/>
				</p>
			
		</form>

	</div>
	<span class="copyright">&copy 2018 Ketaki, Jyoti, Monika, and Anuja</span>

</body>

<?php
	function test_input($data) 
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

if (isset($_POST['submit1'])) 
{
	$errors = array();
	if (empty($_POST['fname'])) 
		{ $errors[0] = 'You forgot to enter your First Name.'; } 
	else 
		{ $fname = test_input($_POST["fname"]); }

	if (empty($_POST['lname'])) 
		{ $errors[1] = 'You forgot to enter your Last Name.'; } 
	else
		{ $lname = test_input($_POST["lname"]); }

	if (strcmp($_POST['bday'],"-1")==0) 
		{ $errors[2] = 'You forgot to enter your Date of Birth.'; }
	else
		{ $bday = $_POST['bday']; }

	if (strcmp($_POST['bmonth'],"-1")==0) 
		{ $errors[2] = 'You forgot to enter your Date of Birth.'; }
	else 
		{ $bmonth = $_POST['bmonth']; }

	if (strcmp($_POST['byear'],"-1")==0) 
		{ $errors[2] = 'You forgot to enter your Date of Birth.'; }
	else 
		{ $byear = $_POST['byear']; }

	if (empty($_POST['email'])) 
		{ $errors[3] = 'You forgot to enter your email id.'; }
	else
	{ 
		$em = test_input($_POST["email"]); 
		if(!filter_var($em,FILTER_VALIDATE_EMAIL))
			$errors[3]='Incorrect email ID format.';
	}

	if (!empty($_POST['pass'])) 
	{ 
		if ($_POST['pass'] != $_POST['pass1']) 
			{ $errors[4] = 'The passwords you have entered do not match.'; } 
		else 
			{ $pass = test_input($_POST["pass"]); }
	}
	else 
		{ $errors[4] = 'You forgot to enter a password.'; }

	if (empty($_POST['mob'])) 
		{ $errors[5] = 'You forgot to enter your mobile number.'; }
	else 
		{ $mob = test_input($_POST["mob"]); }

	if(isset($_POST['gender']))
		$gender=$_POST['gender'];
	else 
		$errors[6]='You forgot to select gender';

	if (strcmp($_POST['nationality'],"-1")==0) 
		{ $errors[7] = 'You forgot to enter your nationality.'; }
	else
		{ $nationality = $_POST['nationality']; }

	if (strcmp($_POST['bgrp'],"-1")==0) 
		{ $errors[8] = 'You forgot to enter your blood group.'; }
	else
		{ $bgrp = $_POST['bgrp']; }


	if (empty($errors)) 
	{
		print_r($doc);
		$client = new MongoDB\Client("mongodb://localhost:27017");
		$collection = $client->gsa->patients;
		$cnt = $collection->count();
		$insertOneResult = $collection->insertOne(["_id" => $cnt, "name" => $_POST["fname"]." ".$_POST["lname"],
					   "dob" => $_POST["bday"]."/".$_POST["bmonth"]."/".$_POST["byear"],
					   "email" => $_POST["email"],
					   "password" => $_POST["pass"],
					   "mobno" => $_POST["mob"],
					   "gender" => $_POST["gender"],
					   "nationality" => $_POST["nationality"],
					   "bloodGroup" => $_POST["bgrp"]]);
		?>
		<script type="text/javascript">window.alert("Registration successful. Your patient ID is <?php echo $cnt ?>.");</script>
		<?php ;
		header("Location:index.php");
	} 
	else
	{
		echo "Some fields empty.";
	}		
} 
?>


