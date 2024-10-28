<?php
include '../db.php';

// Capture search parameters
$contract_number = isset($_GET['contract_number']) ? $_GET['contract_number'] : '';
$next_change_date = isset($_GET['next_change_date']) ? $_GET['next_change_date'] : '';

// Build the SQL query based on search inputs
$sql = "SELECT * FROM customer_notes WHERE 1=1";
if ($contract_number) {
    $sql .= " AND contract_number LIKE '%$contract_number%'";
}
if ($next_change_date) {
    $sql .= " AND next_change_date = '$next_change_date'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .print-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .print-button:hover {
            background-color: #218838;
        }
        .notes-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .notes-table th, .notes-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        .notes-table th {
            background-color: #007bff;
            color: white;
        }
        .notes-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .action-buttons button:hover {
            background-color: #0056b3;
        }
        .delete-button {
            background-color: #dc3545;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<h1>Search Results</h1>

<button class="print-button" onclick="window.print()">Print</button>

<table class="notes-table">
    <thead>
        <tr>
            <th>Contract Number</th>
            <th>Client's Name</th>
            <th>Representative's Name</th>
            <th>Date of Next Change</th>
            <th>Notes</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['contract_number']; ?></td>
                    <td><?php echo $row['client_name']; ?></td>
                    <td><?php echo $row['representative_name']; ?></td>
                    <td><?php echo $row['next_change_date']; ?></td>
                    <td><?php echo $row['notes']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                    <td class="action-buttons">
                        <form action="edit_note.php" method="GET" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit">Edit</button>
                        </form>
                        <form action="delete_note.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete this note?');">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No records found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<?php $conn->close(); ?>
