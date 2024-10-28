<?php
// Include database connection file
include 'db.php';

// Initialize search variables
$contract_number = !empty($_POST['contract_number']) ? $_POST['contract_number'] : '';
$client_name = !empty($_POST['client_name']) ? $_POST['client_name'] : '';
$area = !empty($_POST['area']) ? $_POST['area'] : '';
$phone_number = !empty($_POST['phone_number']) ? $_POST['phone_number'] : '';
$start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : '';

// Construct SQL query
$sql = 'SELECT * FROM customers WHERE 1=1';
if ($contract_number) $sql .= ' AND contract_number LIKE "%' . mysqli_real_escape_string($conn, $contract_number) . '%"';
if ($client_name) $sql .= ' AND client_name LIKE "%' . mysqli_real_escape_string($conn, $client_name) . '%"';
if ($area) $sql .= ' AND area LIKE "%' . mysqli_real_escape_string($conn, $area) . '%"';
if ($phone_number) $sql .= ' AND phone_number LIKE "%' . mysqli_real_escape_string($conn, $phone_number) . '%"';
if ($start_date && $end_date) $sql .= ' AND activation_date BETWEEN "' . mysqli_real_escape_string($conn, $start_date) . '" AND "' . mysqli_real_escape_string($conn, $end_date) . '"';

// Execute SQL query
$result = $conn->query($sql);
if ($result) {
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $row_count = count($results); // Count the number of rows in the result set
} else {
    echo 'Error: ' . $conn->error;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .print-button {
            margin: 20px 0;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .details-row {
            display: none;
            background-color: #f9f9f9;
        }
    </style>
    <script>
        function toggleDetails(id) {
            const detailsRow = document.getElementById('details-' + id);
            if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                detailsRow.style.display = 'table-row';
            } else {
                detailsRow.style.display = 'none';
            }
        }

        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Search Results</h1>
        <button class="print-button" onclick="printPage()">Print</button>
        
        <?php if (!empty($results)): ?>
            <p><strong>Total Results Found: <?php echo $row_count; ?></strong></p> <!-- Display number of rows -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Contract Number</th>
                            <th>Client Name</th>
                            <th>Phone Number</th>
                            <th>Activation Date</th>
                            <th>Area</th>
                            <th>Change Every</th>
                            <th>Show Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['contract_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['activation_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['area']); ?></td>
                                <td><?php echo htmlspecialchars($row['change_every']); ?></td>
                                <td><button class="btn btn-primary" onclick="toggleDetails(<?php echo $row['id']; ?>)">Show</button></td>
                            </tr>
                            <!-- Details row, initially hidden -->
                            <tr id="details-<?php echo $row['id']; ?>" class="details-row">
                                <td colspan="6">
                                    <div><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></div>
                                    <div><strong>Contract Notes:</strong> <?php echo htmlspecialchars($row['contract_notes']); ?></div>
                                    <div><strong>MOP 18:</strong> <?php echo htmlspecialchars($row['mop_18']); ?></div>
                                    <div><strong>Price MOP 18:</strong> <?php echo htmlspecialchars($row['price_mop_18']); ?></div>
                                    <div><strong>MOP 36:</strong> <?php echo htmlspecialchars($row['mop_36']); ?></div>
                                    <div><strong>Price MOP 36:</strong> <?php echo htmlspecialchars($row['price_mop_36']); ?></div>
                                    <div><strong>MIT:</strong> <?php echo htmlspecialchars($row['mit']); ?></div>
                                    <div><strong>Price MIT:</strong> <?php echo htmlspecialchars($row['price_mit']); ?></div>
                                    <div><strong>HD 1:</strong> <?php echo htmlspecialchars($row['hd_1']); ?></div>
                                    <div><strong>Price HD 1:</strong> <?php echo htmlspecialchars($row['price_hd_1']); ?></div>
                                    <div><strong>HD 2:</strong> <?php echo htmlspecialchars($row['hd_2']); ?></div>
                                    <div><strong>Price HD 2:</strong> <?php echo htmlspecialchars($row['price_hd_2']); ?></div>
                                    <div><strong>Total Price:</strong> <?php echo htmlspecialchars($row['total_price']); ?></div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No results found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
