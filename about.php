<?php
	session_start();
	$page_title = "About GSA";
	if(isset($_SESSION['admin_id']))
	{
		$data="<div>";
		$data.="<ul>";
		$data.="<li><p><a class='active' href='about.php'>About GSA</a></p></li>";
		$data.="<li><p><a href='admin_dashboard.php'>All Tasks</a></p></li>";
		$data.="<li><p><a href='viewall.php'>View All Patient Profiles</a></p></li>";
		$data.="<li><p><a href='signout.php'>Sign Out</a></p></li>";
		$data.="</ul>";
		$data.="</div>";
		echo $data;	
	}
	
	else if(isset($_SESSION['patient_id']) )
	{
		$data="<div>";
		$data.="<ul>";
		$data.="<li><p><a class='active' href='about.php'>About GSA</a></p></li>";
		$data.="<li><p><a href='user_dashboard.php'>My Tasks</a></p></li>";
		$data.="<li><p><a href='addquery.php'>Add A Query</a></p></li>";
		$data.="<li><p><a href='profile.php'>My Profile</a></p></li>";
		$data.="<li><p><a href='signout.php'>Sign Out</a></p></li>";
		$data.="</ul>";
		$data.="</div>";
		echo $data;
	}
	
	else
	{
		$data="<div>";
		$data.="<ul>";
		$data.="<li><p><a  href='index.php'>Home</a></p></li>";
		$data.="<li><p><a class='active' href='about.php'>About GSA</a></p></li>";
		$data.="<li><p><a href='signup.php'>New User Registration</a></p></li>";
		$data.="</ul>";
		$data.="</div>";
		echo $data;
	}
?>

<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body class="a">
		<link rel="stylesheet" type="text/css" href="style.css" media="screen">
		<link href='https://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet'>

		<div id="about1">
		<span>
		<h2>Genome - the All Powerful Key</h2>	
		<p align="justify" >
			The human genome is the complete set of nucleic acid sequences for humans, encoded as DNA within the 23 chromosome pairs in cell nuclei and in a small DNA molecule found within individual mitochondria. Human genomes include both protein-coding and noncoding DNA. Haploid human genomes consist of three billion DNA base pairs, while diploid genomes have twice the DNA content.
		</p>

		<p align="justify">
			Well, that's all swell and exciting. But what does that mean for us - the non-biology-speaking folk? It means that our DNA is the blueprint that can unlock the mysteries of how our bodies work.
		</p>
		</div>
		
		<br />
		<div id="about2">
		<h2>Reading the Human Genome</h2>
		<p align="justify">
			Genome sequencing technology has come a long way since it was invented in the 1970s. Today it costs only about &dollar;1000, and is expected to become even less expensive in the near future. Thus it is getting easier and easier to read the human DNA.
		</p>
		<p align="justify">
			Sequence alignment is the task of arranging two sequences such that their homologous regions can be determined. If we have one sequence that has been fully understood, then another sequence of the same kind can be decoded as well. This saves the cost of trying to understand the function of two sequences separately. 
		</p>
		<p align="justify">
			This approach has been used to predict the presence of genetic disorder-causing genes in humans - it is termed genetic screening. However because of the sheer size of the human genome, it is computationally and temporally expensive. We propose a novel hierarchical architecture to tackle this problem. 
		</p>
		</div>
		
		<br />
		<div id="about3">
		<h2>Our Sequence Alignment Tool</h2>
		<p align="justify">
			Our method involves use of a master-slave architecture to pool the resources of available computer systems to distribute the work load evenly. The original problem is subdivided into subproblems and the resulting alignments are consolidated. The Smith-Waterman algorithm for local alignment has been employed. Extensive testing has assured us that such distribution trades off only a minute level of accuracy for a large decrease in computing time.
		</p>
		<p align="justify">
			The overall aim is to make genome-based disease prediction feasible in terms of time taken and computing resources needed. It is our hope that our system could be deployed in professional medical environments and used as a reference diagnostic testing tool.
		</p>

		</div>
		<span class="copyright">&copy 2018 Ketaki, Jyoti, Monika, and Anuja</span>
	</body>
</html>
