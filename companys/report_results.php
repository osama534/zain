<?php
// Include database connection file
include '../db.php';

// Initialize search variables
$contract_number = !empty($_POST['contract_number']) ? $_POST['contract_number'] : '';
$company_name = !empty($_POST['company_name']) ? $_POST['company_name'] : '';
$area = !empty($_POST['area']) ? $_POST['area'] : '';
$phone_number = !empty($_POST['phone_number']) ? $_POST['phone_number'] : '';
$start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : '';
$end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : '';

// Initialize results
$results = [];

// Construct SQL query
$sql = 'SELECT * FROM company WHERE 1=1';
if ($contract_number) $sql .= ' AND contract_number LIKE "%' . mysqli_real_escape_string($conn, $contract_number) . '%"';
if ($company_name) $sql .= ' AND company_name LIKE "%' . mysqli_real_escape_string($conn, $company_name) . '%"';
if ($area) $sql .= ' AND area LIKE "%' . mysqli_real_escape_string($conn, $area) . '%"';
if ($phone_number) $sql .= ' AND phone_number LIKE "%' . mysqli_real_escape_string($conn, $phone_number) . '%"';
if ($start_date && $end_date) $sql .= ' AND activation_date BETWEEN "' . mysqli_real_escape_string($conn, $start_date) . '" AND "' . mysqli_real_escape_string($conn, $end_date) . '"';

// Execute SQL query
$result = $conn->query($sql);
if ($result) {
    $results = $result->fetch_all(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="companys/styles.css"> <!-- Optional CSS file for styling -->
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
    </style>
    <script>
        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
    <h1>Search Results</h1>
    <button class="print-button" onclick="printPage()">Print</button>
    
    <?php if (!empty($results)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Contract Number</th>
                    <th>Company Name</th>
                    <th>Phone Number</th>
                    <th>Activation Date</th>
                    <th>Address</th>
                    <th>Change Every</th>
                    <th>Area</th>
                    <th>Contract Notes</th>
                    <th>MOP 18</th>
                    <th>Price MOP 18</th>
                    <th>MOP 36</th>
                    <th>Price MOP 36</th>
                    <th>MIT</th>
                    <th>Price MIT</th>
                    <th>HD 1</th>
                    <th>Price HD 1</th>
                    <th>HD 2</th>
                    <th>Price HD 2</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['contract_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['activation_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['address']); ?></td>
                        <td><?php echo htmlspecialchars($row['change_every']); ?></td>
                        <td><?php echo htmlspecialchars($row['area']); ?></td>
                        <td><?php echo htmlspecialchars($row['contract_notes']); ?></td>
                        <td><?php echo htmlspecialchars($row['mop_18']); ?></td>
                        <td><?php echo htmlspecialchars($row['price_mop_18']); ?></td>
                        <td><?php echo htmlspecialchars($row['mop_36']); ?></td>
                        <td><?php echo htmlspecialchars($row['price_mop_36']); ?></td>
                        <td><?php echo htmlspecialchars($row['mit']); ?></td>
                        <td><?php echo htmlspecialchars($row['price_mit']); ?></td>
                        <td><?php echo htmlspecialchars($row['hd_1']); ?></td>
                        <td><?php echo htmlspecialchars($row['price_hd_1']); ?></td>
                        <td><?php echo htmlspecialchars($row['hd_2']); ?></td>
                        <td><?php echo htmlspecialchars($row['price_hd_2']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>
</body>
</html>
