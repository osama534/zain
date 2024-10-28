<?php
// Include database connection file
include 'db.php';

// Initialize search variables
$contract_number = '';
$client_name = '';
$area = '';
$phone_number = '';
$start_date = '';
$end_date = '';

$results = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contract_number = !empty($_POST['contract_number']) ? $_POST['contract_number'] : '';
    $client_name = !empty($_POST['client_name']) ? $_POST['client_name'] : '';
    $area = !empty($_POST['area']) ? $_POST['area'] : '';
    $phone_number = !empty($_POST['phone_number']) ? $_POST['phone_number'] : '';
    $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : '';
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : '';

    $sql = 'SELECT * FROM customers WHERE 1=1';
    if ($contract_number) $sql .= ' AND contract_number LIKE ?';
    if ($client_name) $sql .= ' AND client_name LIKE ?';
    if ($area) $sql .= ' AND area LIKE ?';
    if ($phone_number) $sql .= ' AND phone_number LIKE ?';
    if ($start_date && $end_date) $sql .= ' AND activation_date BETWEEN ? AND ?';

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $params = [];
    if ($contract_number) $params[] = "%$contract_number%";
    if ($client_name) $params[] = "%$client_name%";
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
    <link rel="stylesheet" href="styly.css"> <!-- Optional CSS file for styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0; /* Light gray background for the page */
        }

        .form-container {
            background-color: #ffffff; /* White background for the form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Searching For Client's</h1>
        <form method="POST" action="cus_report_result.php" target="_blank">
            <label for="contract_number">Contract Number:</label>
            <input type="text" id="contract_number" name="contract_number" value="<?php echo htmlspecialchars($contract_number); ?>">

            <label for="client_name">Client Name:</label>
            <input type="text" id="client_name" name="client_name" value="<?php echo htmlspecialchars($client_name); ?>">

            <label for="area">Area:</label>
            <input type="text" id="area" name="area" value="<?php echo htmlspecialchars($area); ?>">

            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">

            <div class="form-buttons">
                <button type="submit">Search</button>
                <button type="reset">Clear Fields</button>
            </div>
        </form>
    </div>



    <?php if (!empty($results)): ?>
        <h2>Search Results</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Contract Number</th>
                    <th>Client Name</th>
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
                        <td><?php echo htmlspecialchars($row['client_name']); ?></td>
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
