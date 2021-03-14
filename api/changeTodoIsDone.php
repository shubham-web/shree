<?php 
	require_once 'middleware.php';
	if (isset($_POST['id']) && isset($_POST['isDone'])) {
		$id = $_POST['id'];
		$isDone = $_POST['isDone'] === "true";
	}
	else{
		die("Invalid Request");
	}
	$todoArray = json_decode(file_get_contents('../tasksToDo.json'), true);
	$newList = [];
	for ($i=0; $i < count($todoArray); $i++) { 
		if ($id == $todoArray[$i]['id']) {
			$todoArray[$i]['isDone'] = $isDone;
		}
		array_push($newList, $todoArray[$i]);
	}
	file_put_contents('../tasksToDo.json', json_encode($newList));
	echo json_encode($newList);