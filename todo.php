<?php require_once 'api/middleware.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Todo | Shree Engineering Works</title>
	<style>
		*{
			font-family: "Montserrat", sans-serif;
			box-sizing: border-box;
			user-select: none;
		}
		::-webkit-scrollbar {
		    width: 10px;
		}	
		::-webkit-scrollbar-track {
		    background: #f1f1f1; 
		}
		::-webkit-scrollbar-thumb {
		    background: #888; 
		}
		::-webkit-scrollbar-thumb:hover {
		    background: #555; 
		}
		body{
			background-image: url('img/background.jpg');
			background-size: cover;
			background-attachment: fixed;		
		}
		.todoWrapper{
			position: relative;
			border-radius: 5px;
			width: 90%;
			padding: 10px 30px;
			align-items: stretch;
			height: 100%;
			box-sizing: border-box;
			margin: 0 auto;
		}
	</style>
	<link rel="stylesheet" href="css/todo.css" />
</head>
<body>
	<section class="todoWrapper">
	<div class="todoApp">
		<header id="todoHeader">
			<span id="day"></span>
			<span id="undoneTasks" title="Incompleted Tasks">0 Tasks</span>
			<span id="month"></span>
			<section id="middleAction">
				<input type="text" id="newTaskInput" placeholder="Brief Your Task" maxlength="500" />
				<button id="addTodo" title="Add Task">+</button>
			</section>
		</header>
		<main id="todos"></main>
	</div>
</section>
<script src="js/todo.js"></script>
</body>
</html>