<?php
include 'config.php';

$id = $_POST['id'];

$sql = "UPDATE tasks SET progress = 100 WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Task marked as complete";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
