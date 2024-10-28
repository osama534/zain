<?php
include '../db.php';

// Get the note ID from the POST request
$id = $_POST['id'];

// Delete the note from the database
$sql = "DELETE FROM customer_notes WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Note deleted successfully!'); window.location.href = 'view_notes.php';</script>";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
