<?php
include 'db.php';

// Initialize pagination variables
$limit = 10; // Number of entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

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

// Get the total number of records for pagination
$totalResults = $conn->query($sql);
$totalRows = $totalResults->num_rows;
$totalPages = ceil($totalRows / $limit);

// Fetch the data with pagination
$sql .= " LIMIT $limit OFFSET $offset";
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
    <title>All Canceled Contracts</title>
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
        .pagination {
            justify-content: center;
        }
        .form-container {
            background-color: #007bff; /* Blue background */
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            color: #fff;
        }
        .form-inline {
            flex-direction: column; /* Stack inputs vertically */
            align-items: center; /* Center align inputs */
        }
        .form-inline .form-control {
            width: 300px; /* Increase the width of the inputs */
            margin-bottom: 15px; /* Add space between inputs */
        }
        .form-inline .btn {
            background-color: #28a745; /* Green button */
            border-color: #28a745;
            width: 200px; /* Larger button */
            font-size: 18px; /* Larger text size */
            padding: 10px; /* Increase padding */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Canceled Contracts</h2>

        <!-- Search Form -->
        <div class="form-container">
            <form class="form-inline" method="GET" action="cancel_results.php">
                <input type="text" name="contract_number" class="form-control" placeholder="Contract Number" value="<?php echo htmlspecialchars($contractNumber); ?>">
                <input type="text" name="client_name" class="form-control" placeholder="Client Name" value="<?php echo htmlspecialchars($clientName); ?>">
                <input type="text" name="phone_number" class="form-control" placeholder="Phone Number" value="<?php echo htmlspecialchars($phoneNumber); ?>">
                <input type="text" name="area" class="form-control" placeholder="Area" value="<?php echo htmlspecialchars($area); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>

        <?php if ($canceledContracts): ?>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Contract Number</th>
                    <th>Client Name</th>
                    <th>Phone Number</th>
                    <th>Activation Date</th>
                    <th>Change Every</th>
                    <th>Area</th>
                    <th>Total Price</th>
                    <th>Cancellation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($canceledContracts as $contract): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contract['contract_number']); ?></td>
                    <td><?php echo htmlspecialchars($contract['client_name']); ?></td>
                    <td><?php echo htmlspecialchars($contract['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($contract['activation_date']); ?></td>
                    <td><?php echo htmlspecialchars($contract['change_every']); ?></td>
                    <td><?php echo htmlspecialchars($contract['area']); ?></td>
                    <td><?php echo number_format($contract['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($contract['cancellation_date']); ?></td>
                    
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination Links -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&<?php echo http_build_query($_GET); ?>"><?php echo $i; ?></a>
                </li>
                <?php endfor; ?>
            </ul>
        </nav>

        <?php else: ?>
        <p class="text-center">No canceled contracts found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
