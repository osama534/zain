<?php
// Include database connection
include 'db.php';

// Get the contract ID from the URL
$contract_id = $_GET['id'];

// Fetch contract details from the database
$sql = "SELECT * FROM customers WHERE id = $contract_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $contract = $result->fetch_assoc();
} else {
    echo "Contract not found";
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $client_name = $conn->real_escape_string($_POST['client_name']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $address = $conn->real_escape_string($_POST['address']);
    $area = $conn->real_escape_string($_POST['area']);
    $delivery_date = $conn->real_escape_string($_POST['delivery_date']);
    
    // Update the contract with the new data
    $update_sql = "UPDATE customers SET client_name = '$client_name', phone_number = '$phone_number', address = '$address', area = '$area', delivery_date = '$delivery_date' WHERE id = $contract_id";
    
    if ($conn->query($update_sql) === TRUE) {
        $message = "Contract updated successfully!";
    } else {
        $message = "Error updating contract.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Contract</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #343a40;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Contract Review</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="contract_number">Contract Number</label>
                <input type="text" class="form-control" id="contract_number" value="<?php echo $contract['contract_number']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="client_name">Client Name</label>
                <input type="text" name="client_name" class="form-control" id="client_name" value="<?php echo $contract['client_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" id="phone_number" value="<?php echo $contract['phone_number']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control" id="address" value="<?php echo $contract['address']; ?>" required>
            </div>
            <div class="form-group">
                <label for="area">Area</label>
                <input type="text" name="area" class="form-control" id="area" value="<?php echo $contract['area']; ?>" required>
            </div>
            <div class="form-group">
                <label for="delivery_date">Delivery Date</label>
                <input type="date" name="delivery_date" class="form-control" id="delivery_date" value="<?php echo $contract['delivery_date']; ?>">
            </div>

            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>
