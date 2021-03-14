<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<style> *{ font-family: "Montserrat", sans-serif; } body{ background-color: #f1f1f1; } 
		section#graph{
			position: absolute;
			transform: translate(-50%,-50%);
			top: 50%;
			left: 50%;
		}
	</style>
	<link rel="stylesheet" href="css/graph.css" />
	<title>Cash Flow Graph</title>
</head>
<body>
	<aside id="pillerInfo">
		<h1 id="pillerType">Expenses</h1>
		<p id="pillerAmt">Rs. 20,1052</p>
	</aside>
	<section id="graph">
		<main>
			<?php
				for ($i=0; $i < 5; $i++) {
					echo "<div><div class=\"bar\"></div><div class=\"bar\"></div></div>";
				}
			?>
		</main>
		<footer><span></span><span></span><span></span><span></span><span></span></footer>
	</section>
	<script src="js/graph.js"></script>
</body>
</html>