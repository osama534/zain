<?php
include 'db.php';

// Search filters
$contractNumber = $_GET['contract_number'] ?? '';
$clientName = $_GET['client_name'] ?? '';
$phoneNumber = $_GET['phone_number'] ?? '';
$area = $_GET['area'] ?? '';

// Build the query with search filters
$sql = "SELECT * FROM canceled_contracts WHERE 1=1";
if ($contractNumber) {
    $sql .= " AND contract_number LIKE '%" . $conn->real_escape_string($contractNumber) . "%'";
}
if ($clientName) {
    $sql .= " AND client_name LIKE '%" . $conn->real_escape_string($clientName) . "%'";
}
if ($phoneNumber) {
    $sql .= " AND phone_number LIKE '%" . $conn->real_escape_string($phoneNumber) . "%'";
}
if ($area) {
    $sql .= " AND area LIKE '%" . $conn->real_escape_string($area) . "%'";
}

// Fetch the data
$result = $conn->query($sql);

if (!$result) {
    die('Error fetching canceled contracts: ' . $conn->error);
}
$canceledContracts = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #007bff;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search Results</h2>

        <?php if ($canceledContracts): ?>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Contract Number</th>
                    <th>Client Name</th>
                    <th>Phone Number</th>
                    <th>Activation Date</th>
                    <th>Area</th>
                    <th>Total Price</th>
                    <th>Cancellation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($canceledContracts as $contract): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contract['id']); ?></td>
                    <td>
                        <a href="cancel_details.php?id=<?php echo $contract['id']; ?>" target="_blank">
                            <?php echo htmlspecialchars($contract['contract_number']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($contract['client_name']); ?></td>
                    <td><?php echo htmlspecialchars($contract['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($contract['activation_date']); ?></td>
                    <td><?php echo htmlspecialchars($contract['area']); ?></td>
                    <td><?php echo number_format($contract['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($contract['cancellation_date']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="text-center">No results found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
