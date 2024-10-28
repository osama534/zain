<?php
// Include the database connection file
include '../db.php';

$searchResults = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchQuery = isset($_POST['search_query']) ? $_POST['search_query'] : '';

    if (!empty($searchQuery)) {
        // Sanitize the input to prevent SQL injection
        $searchQuery = $conn->real_escape_string($searchQuery);

        // Construct the SQL query
        $sql = "SELECT * FROM company WHERE contract_number LIKE '%$searchQuery%' OR company_name LIKE '%$searchQuery%'";

        // Execute the query
        $result = $conn->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $searchResults[] = $row;
            }
        } else {
            echo "Error in query execution: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Search Results</h2>

        <?php if (count($searchResults) > 0): ?>
            <ul class="list-group">
                <?php foreach ($searchResults as $result): ?>
                    <li class="list-group-item">
                        <strong><?php echo htmlspecialchars($result['contract_number']); ?></strong> - <?php echo htmlspecialchars($result['company_name']); ?>
                        <a href="contract_details.php?id=<?php echo $result['id']; ?>" target="_blank" class="btn btn-primary btn-sm float-right">View Details</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No results found for your search query.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
