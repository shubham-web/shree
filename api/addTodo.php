<?php 
	require_once 'middleware.php';
	if (isset($_POST['title']) && isset($_POST['date'])) {
		$title = strip_tags(ucwords($_POST['title']));
		$date = $_POST['date'];
	}
	else{
		die("Invalid Request : Title and Date Not Provided");
	}
	$todoArray = json_decode(file_get_contents('../tasksToDo.json'), true);
	$newList = $todoArray;
	if (count($todoArray) == 0) {
		$task = array('id' => 1, 'title' => $title, 'isDone' => false, 'date' => $date);
		array_push($newList, $task);
	}
	else{
		$newId = $todoArray[count($todoArray) - 1]['id'] + 1;
		$task = array('id' => $newId, 'title' => $title, 'isDone' => false, 'date' => $date);
		array_push($newList, $task);
	}
	file_put_contents('../tasksToDo.json', json_encode($newList));
	echo json_encode($newList);