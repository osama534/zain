<?php
include '../db.php';

// Initialize search variables
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
    <title>View Notes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input {
            padding: 10px;
            width: 200px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
    </style>
</head>
<body>

<h1>View Saved Notes</h1>

<div class="search-container">
    <form action="Notes/view_notes_result.php" method="GET" target="_blank">
        <input type="text" name="contract_number" placeholder="Search by Contract Number" value="<?php echo $contract_number; ?>">
        <input type="date" name="next_change_date" value="<?php echo $next_change_date; ?>">
        <button type="submit">Search</button>
    </form>

</div>

<table class="notes-table">
    <thead>
        <tr>
            <th>Contract Number</th>
            <th>Client's Name</th>
            <th>Representative's Name</th>
            <th>Date of Next Change</th>
            <th>Notes</th>
            <th>Created At</th>
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
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No records found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

<?php $conn->close(); ?>
