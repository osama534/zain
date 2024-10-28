<?php
// Include database connection
include 'db.php';

// Define the number of results per page
$results_per_page = 10;

// Initialize search parameter
$search_query = '';
$whereClause = '';

// Check if a search query is provided
if (!empty($_GET['contract_number'])) {
    $contract_number = $conn->real_escape_string($_GET['contract_number']);
    $whereClause = "WHERE contract_number LIKE '%$contract_number%'";
    $search_query = $contract_number;
}

// Build the SQL query for counting total results
$sql = "SELECT COUNT(*) FROM customers $whereClause";

// Check for SQL errors
if (!$result = $conn->query($sql)) {
    die('SQL Error: ' . $conn->error);
}

$row = $result->fetch_row();
$total_results = $row[0];

// Calculate total pages and current page
$total_pages = ceil($total_results / $results_per_page);
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $results_per_page;

// Fetch the data for the current page
$sql = "SELECT * FROM customers $whereClause LIMIT $offset, $results_per_page";

// Check for SQL errors again
if (!$result = $conn->query($sql)) {
    die('SQL Error: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contracts</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .no-data-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
        .pagination .page-item.disabled .page-link {
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>All Contracts</h2>
        
        <!-- Search Form -->
        <form method="GET" action="view_contracts.php" class="form-inline mb-4">
            <input type="text" name="contract_number" class="form-control mr-2" placeholder="Search by Contract Number" value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit" class="btn btn-primary mr-2">Search</button>

            <?php if (!empty($_GET['contract_number'])): ?>
            <!-- Show 'Return' button if a search query is present -->
            <button type="button" class="btn btn-secondary" onclick="window.location.href='main.php'">back to main</button>
            <?php endif; ?>
        </form>


        
        
        <!-- Data Table -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Contract Number</th>
                        <th>Client Name</th>
                        <th>Phone Number</th>
                        <th>Change Every</th>
                        <th>Area</th>
                        <th>Notes</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <a href="view_contract_details.php?id=<?php echo urlencode($row['id']); ?>" target="_blank">
                                    <?php echo htmlspecialchars($row['contract_number']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($row['client_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($row['change_every']); ?></td>
                            <td><?php echo htmlspecialchars($row['area']); ?></td>
                            <td><?php echo htmlspecialchars($row['contract_notes']); ?></td>
                            <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                            <td>
                                <a href="view_contract_details.php?id=<?php echo urlencode($row['id']); ?>" class="btn btn-info btn-sm" target="_blank">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data-message">No data found</div>
        <?php endif; ?>

        <!-- Pagination Links -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <!-- First Page Link -->
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'view_contracts.php?page=1&contract_number=' . urlencode($search_query); ?>">First</a>
                    </li>
                <?php endif; ?>

                <!-- Previous Page Link -->
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'view_contracts.php?page=' . ($current_page - 1) . '&contract_number=' . urlencode($search_query); ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <!-- Page Number Links -->
                <?php
                $start_page = max(1, $current_page - 2);
                $end_page = min($total_pages, $current_page + 2);

                if ($start_page > 1): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>

                <?php for ($page = $start_page; $page <= $end_page; $page++): ?>
                    <li class="page-item <?php if ($page == $current_page) echo 'active'; ?>">
                        <a class="page-link" href="<?php echo 'view_contracts.php?page=' . $page . '&contract_number=' . urlencode($search_query); ?>">
                            <?php echo $page; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($end_page < $total_pages): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>

                <!-- Next Page Link -->
                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'view_contracts.php?page=' . ($current_page + 1) . '&contract_number=' . urlencode($search_query); ?>">Next</a>
                    </li>
                <?php endif; ?>

                <!-- Last Page Link -->
                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo 'view_contracts.php?page=' . $total_pages . '&contract_number=' . urlencode($search_query); ?>">Last</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>
</html>

<?php
$conn->close();
?>
