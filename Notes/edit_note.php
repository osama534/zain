<?php
include '../db.php';

// Get the note ID from the URL
$id = $_GET['id'];

// Fetch the note data from the database
$sql = "SELECT * FROM customer_notes WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $note = $result->fetch_assoc();
} else {
    echo "Note not found.";
    exit();
}

// Handle form submission for updating the note
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $contract_number = $_POST['contract_number'];
    $client_name = $_POST['client_name'];
    $representative_name = $_POST['representative_name'];
    $next_change_date = $_POST['next_change_date'];
    $notes = $_POST['notes'];

    $update_sql = "UPDATE customer_notes SET contract_number='$contract_number', client_name='$client_name', representative_name='$representative_name', next_change_date='$next_change_date', notes='$notes' WHERE id = $id";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Note updated successfully!'); window.location.href = 'view_notes.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
        }
        .submit-button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .submit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Edit Note</h1>
    <form action="edit_note.php?id=<?php echo $id; ?>" method="POST">
        <div class="form-group">
            <label for="contract_number">Contract Number</label>
            <input type="text" id="contract_number" name="contract_number" value="<?php echo $note['contract_number']; ?>" required>
        </div>
        <div class="form-group">
            <label for="client_name">Client's Name</label>
            <input type="text" id="client_name" name="client_name" value="<?php echo $note['client_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="representative_name">Representative's Name</label>
            <input type="text" id="representative_name" name="representative_name" value="<?php echo $note['representative_name']; ?>" required>
        </div>
        <div class="form-group">
            <label for="next_change_date">Date of Next Change</label>
            <input type="date" id="next_change_date" name="next_change_date" value="<?php echo $note['next_change_date']; ?>" required>
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea id="notes" name="notes" rows="4"><?php echo $note['notes']; ?></textarea>
        </div>
        <button type="submit" class="submit-button">Update Note</button>
    </form>
</div>

</body>
</html>
