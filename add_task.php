<?php
include 'config.php';

$title = $_POST['title'];
$date = $_POST['date'];
$progress = $_POST['progress'];

$sql = "INSERT INTO tasks (title, date, progress) VALUES ('$title', '$date', '$progress')";

if ($conn->query($sql) === TRUE) {
    echo "New task added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
