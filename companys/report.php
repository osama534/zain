<?php
// Include database connection file
include '../db.php';

// Initialize search variables
$contract_number = '';
$company_name = '';
$area = '';
$phone_number = '';
$start_date = '';
$end_date = '';

$results = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contract_number = !empty($_POST['contract_number']) ? $_POST['contract_number'] : '';
    $company_name = !empty($_POST['company_name']) ? $_POST['company_name'] : '';
    $area = !empty($_POST['area']) ? $_POST['area'] : '';
    $phone_number = !empty($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : '';

    $sql = 'SELECT * FROM company WHERE 1=1';
    if ($contract_number) $sql .= ' AND contract_number LIKE ?';
    if ($company_name) $sql .= ' AND company_name LIKE ?';
    if ($area) $sql .= ' AND area LIKE ?';
    if ($phone_number) $sql .= ' AND phone_number LIKE ?';
    if ($start_date && $end_date) $sql .= ' AND activation_date BETWEEN ? AND ?';

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $params = [];
    if ($contract_number) $params[] = "%$contract_number%";
    if ($company_name) $params[] = "%$company_name%";
    if ($area) $params[] = "%$area%";
    if ($phone_number) $params[] = "%$phone_number%";
    if ($start_date && $end_date) {
        $params[] = $start_date;
        $params[] = $end_date;
    }

    // Bind parameters dynamically
    if ($params) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Company</title>
    <link rel="stylesheet" href="companys/styles.css"> <!-- Optional CSS file for styling -->
</head>
<body>
    <h1>Search Company</h1>
    <form method="POST" action="companys/report_results.php" target="_blank">
        <label for="contract_number">Contract Number:</label>
        <input type="text" id="contract_number" name="contract_number" value="<?php echo htmlspecialchars($contract_number); ?>">

        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($company_name); ?>">

        <label for="area">Area:</label>
        <input type="text" id="area" name="area" value="<?php echo htmlspecialchars($area); ?>">

        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">

        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">

        <button type="submit">Search</button>
    </form>


    <?php if (!empty($results)): ?>
        <h2>Search Results</h2>
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
    <?php endif; ?>
</body>
</html>
