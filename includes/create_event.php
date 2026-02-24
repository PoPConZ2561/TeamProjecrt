<?php

session_start();

//	event_id	user_id	title	description	location	max_participants	start_date	end_date	created_at

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require("database.php");
    $conn = getConnection();

    $user_id = $_SESSION['user_id'] ?? '';
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $max_participants = $_POST['max_participants'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    

    $sql = "INSERT INTO events (event_id, user_id, title, description, location, max_participants, start_date, end_date, created_at) 
    VALUES ('', '$user_id', '$title', '$description', '$location', '$max_participants', '$start_date', '$end_date', NOW())";
    mysqli_query($conn, $sql);

    $sql1 = "INSERT INTO event_images (image_id, event_id, image_path) VALUES ('', LAST_INSERT_ID(), '$img')";
    // INSERT INTO `event_images` (`image_id`, `event_id`, `image_path`) VALUES (NULL, '6', '1234.png');
    mysqli_query($conn, $sql1);
}
