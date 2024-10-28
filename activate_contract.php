<?php
include 'db.php';

$contractId = $_GET['id'] ?? '';
$status = $_GET['status'] ?? '';

if ($status !== '' && $status === 'success') {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Activation Successful</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background-color: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                margin: 0;
            }
            .message-container {
                background-color: #fff;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
            .btn {
                margin-top: 20px;
            }
        </style>
    </head>
    <body>
        <div class="message-container">
            <h1>Activation Successful!</h1>
            <p>The contract has been successfully activated and moved to the customer list.</p>
            <a href="show_canceled.php" class="btn btn-primary">Back to Canceled Contracts</a>
        </div>
    </body>
    </html>';
    exit();
}

// If no status or status is not success, proceed with activation

if (!$contractId) {
    die('No contract ID provided.');
}

// Sanitize the input
$contractId = intval($contractId);

// Fetch the contract details
$sql = "SELECT * FROM canceled_contracts WHERE id = $contractId";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die('Contract not found.');
}

$contract = $result->fetch_assoc();

// Insert the contract into the customers table
$insertSql = "INSERT INTO customers (
    contract_number, client_name, phone_number, activation_date, address, change_every, area, contract_notes, 
    mop_18, price_mop_18, mop_36, price_mop_36, mit, price_mit, hd_1, price_hd_1, hd_2, price_hd_2, total_price
) VALUES (
    '{$conn->real_escape_string($contract['contract_number'])}',
    '{$conn->real_escape_string($contract['client_name'])}',
    '{$conn->real_escape_string($contract['phone_number'])}',
    '{$conn->real_escape_string($contract['activation_date'])}',
    '{$conn->real_escape_string($contract['address'])}',
    '{$conn->real_escape_string($contract['change_every'])}',
    '{$conn->real_escape_string($contract['area'])}',
    '{$conn->real_escape_string($contract['contract_notes'])}',
    {$contract['mop_18']},
    {$contract['price_mop_18']},
    {$contract['mop_36']},
    {$contract['price_mop_36']},
    {$contract['mit']},
    {$contract['price_mit']},
    {$contract['hd_1']},
    {$contract['price_hd_1']},
    {$contract['hd_2']},
    {$contract['price_hd_2']},
    {$contract['total_price']}
)";

$insertResult = $conn->query($insertSql);

if (!$insertResult) {
    die('Error inserting into customers table: ' . $conn->error);
}

// Delete the contract from canceled_contracts
$deleteSql = "DELETE FROM canceled_contracts WHERE id = $contractId";
$deleteResult = $conn->query($deleteSql);

if (!$deleteResult) {
    die('Error deleting from canceled_contracts table: ' . $conn->error);
}

// Redirect to the same page with a success message
header('Location: activate_contract.php?status=success');
exit();
?>
