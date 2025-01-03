<?php

header("Access-Control-Allow-Origin:* ");

header("Access-Control-Allow-Headers:* ");

header("Access-Control-Allow-Methods:* ");

$connect = new PDO("mysql:host=127.0.0.1;dbname=phpapi", "root", "");

$method = $_SERVER['REQUEST_METHOD']; //return GET, POST, PUT, DELETE


if ($method === 'GET') {
	if (isset($_GET['id'])) {
		//fetch single user
		$query = "SELECT * FROM students WHERE id = '" . $_GET["id"] . "'";

		$result = $connect->query($query, PDO::FETCH_ASSOC);

		$data = array();

		foreach ($result as $row) {
			$data['firstName'] = $row['firstName'];

			$data['lastName'] = $row['lastName'];

			$data['studentNumber'] = $row['studentNumber'];

			$data['email'] = $row['email'];

			$data['id'] = $row['id'];
		}

		echo json_encode($data);
	} else {
		//fetch all user

		$query = "SELECT * FROM students ORDER BY id DESC";

		$result = $connect->query($query, PDO::FETCH_ASSOC);

		$data = array();

		foreach ($result as $row) {
			$data[] = $row;
		}

		echo json_encode($data);
	}


}

if ($method === 'POST') {
	//Insert User Data

	$form_data = json_decode(file_get_contents('php://input'));

	$data = array(
		':firstName' => $form_data->firstName,
		':lastName' => $form_data->lastName,
		':studentNumber' => $form_data->studentNumber,
		':email' => $form_data->email
	);

	$query = "
	INSERT INTO students (firstName, lastName, studentNumber, email) VALUES (:firstName, :lastName, :studentNumber, :email);
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	echo json_encode(["success" => "done"]);
}

if ($method === 'PUT') {
	//Update User Data

	$form_data = json_decode(file_get_contents('php://input'));

	$data = array(
		':firstName' => $form_data->firstName,
		':lastName' => $form_data->lastName,
		':studentNumber' => $form_data->studentNumber,
		':email' => $form_data->email,
		':id' => $form_data->id
	);

	$query = "
	UPDATE students 
	SET firstName = :firstName, 
	lastName = :lastName, 
	studentNumber = :studentNumber,
	email = :email
	WHERE id = :id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	echo json_encode(["success" => "done"]);
}

if ($method === 'DELETE') {
	//Delete User Data

	$data = array(
		':id' => $_GET['id']
	);

	$query = "DELETE FROM students WHERE id = :id";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	echo json_encode(["success" => "done"]);
}
?>