<?php
include 'db.php';

// Get the contract ID from the query string
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch contract details
$sql = "SELECT * FROM customers WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die('Contract not found');
}

$contract = $result->fetch_assoc();

// Handle modify or cancel actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cancel'])) {
        // Begin transaction
        $conn->begin_transaction();

        try {
            // Move to canceled_contracts table
            $sql_cancel = "INSERT INTO canceled_contracts (
                contract_number, client_name, phone_number, activation_date, address,
                change_every, area, contract_notes, mop_18, price_mop_18, mop_36, price_mop_36,
                mit, price_mit, hd_1, price_hd_1, hd_2, price_hd_2, total_price
            ) SELECT
                contract_number, client_name, phone_number, activation_date, address,
                change_every, area, contract_notes, mop_18, price_mop_18, mop_36, price_mop_36,
                mit, price_mit, hd_1, price_hd_1, hd_2, price_hd_2, total_price
            FROM customers WHERE id = $id";
            $conn->query($sql_cancel);

            // Delete from customers
            $sql_delete = "DELETE FROM customers WHERE id = $id";
            $conn->query($sql_delete);

            // Commit transaction
            $conn->commit();

            header('Location: view_contracts.php?message=Contract cancelled');
            exit;
        } catch (Exception $e) {
            // Rollback transaction if something goes wrong
            $conn->rollback();
            die('Error cancelling contract: ' . $e->getMessage());
        }
    } elseif (isset($_POST['modify'])) {
        // Update the contract in the customers table
        $contract_number = $conn->real_escape_string($_POST['contract_number']);
        $client_name = $conn->real_escape_string($_POST['client_name']);
        $phone_number = $conn->real_escape_string($_POST['phone_number']);
        $activation_date = $conn->real_escape_string($_POST['activation_date']);
        $address = $conn->real_escape_string($_POST['address']);
        $change_every = $conn->real_escape_string($_POST['change_every']);
        $area = $conn->real_escape_string($_POST['area']);
        $contract_notes = $conn->real_escape_string($_POST['contract_notes']);
        $mop_18 = (int)$_POST['mop_18'];
        $price_mop_18 = (float)$_POST['price_mop_18'];
        $mop_36 = (int)$_POST['mop_36'];
        $price_mop_36 = (float)$_POST['price_mop_36'];
        $mit = (int)$_POST['mit'];
        $price_mit = (float)$_POST['price_mit'];
        $hd_1 = (int)$_POST['hd_1'];
        $price_hd_1 = (float)$_POST['price_hd_1'];
        $hd_2 = (int)$_POST['hd_2'];
        $price_hd_2 = (float)$_POST['price_hd_2'];
        $total_price = ($mop_18 * $price_mop_18) + ($mop_36 * $price_mop_36) + ($mit * $price_mit) + ($hd_1 * $price_hd_1) + ($hd_2 * $price_hd_2);

        $sql_update = "UPDATE customers SET
                       client_name = '$client_name',
                       phone_number = '$phone_number',
                       activation_date = '$activation_date',
                       address = '$address',
                       change_every = '$change_every',
                       area = '$area',
                       contract_notes = '$contract_notes',
                       mop_18 = $mop_18,
                       price_mop_18 = $price_mop_18,
                       mop_36 = $mop_36,
                       price_mop_36 = $price_mop_36,
                       mit = $mit,
                       price_mit = $price_mit,
                       hd_1 = $hd_1,
                       price_hd_1 = $price_hd_1,
                       hd_2 = $hd_2,
                       price_hd_2 = $price_hd_2,
                       total_price = $total_price
                       WHERE id = $id";
        $conn->query($sql_update);

        header('Location: view_contracts.php?message=Contract updated');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contract Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
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
        .form-group label {
            font-weight: bold;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #bd2130;
            border-color: #a71d2a;
        }
        .btn-secondary {
            margin-top: 20px;
        }
        .form-row {
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .readonly {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Contract Details</h2>
        
        <form method="POST" action="view_contract_details.php?id=<?php echo $id; ?>">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="contract_number">Contract Number</label>
                    <input type="text" class="form-control readonly" id="contract_number" name="contract_number" value="<?php echo htmlspecialchars($contract['contract_number']); ?>" readonly>
                </div>
                <div class="form-group col-md-4">
                    <label for="client_name">Client Name</label>
                    <input type="text" class="form-control" id="client_name" name="client_name" value="<?php echo htmlspecialchars($contract['client_name']); ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($contract['phone_number']); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="change_every">Change Every</label>
                    <input type="text" class="form-control" id="change_every" name="change_every" value="<?php echo htmlspecialchars($contract['change_every']); ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="activation_date">Activation Date</label>
                    <input type="date" class="form-control" id="activation_date" name="activation_date" value="<?php echo htmlspecialchars($contract['activation_date']); ?>" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="area">Area</label>
                    <input type="text" class="form-control" id="area" name="area" value="<?php echo htmlspecialchars($contract['area']); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($contract['address']); ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="contract_notes">Contract Notes</label>
                    <textarea class="form-control" id="contract_notes" name="contract_notes" rows="3"><?php echo htmlspecialchars($contract['contract_notes']); ?></textarea>
                </div>
            </div>
            <!-- Products Section -->
            <h4 class="mb-3">Products</h4>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="mop_18">Mob18 Quantity</label>
                    <input type="number" class="form-control" id="mop_18" name="mop_18" value="<?php echo htmlspecialchars($contract['mop_18']); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="price_mop_18">Mob18 Price</label>
                    <input type="number" step="0.01" class="form-control" id="price_mop_18" name="price_mop_18" value="<?php echo htmlspecialchars($contract['price_mop_18']); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="mop_36">Mob36 Quantity</label>
                    <input type="number" class="form-control" id="mop_36" name="mop_36" value="<?php echo htmlspecialchars($contract['mop_36']); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="price_mop_36">Mob36 Price</label>
                    <input type="number" step="0.01" class="form-control" id="price_mop_36" name="price_mop_36" value="<?php echo htmlspecialchars($contract['price_mop_36']); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="mit">Mit Quantity</label>
                    <input type="number" class="form-control" id="mit" name="mit" value="<?php echo htmlspecialchars($contract['mit']); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="price_mit">Mit Price</label>
                    <input type="number" step="0.01" class="form-control" id="price_mit" name="price_mit" value="<?php echo htmlspecialchars($contract['price_mit']); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="hd_1">Handster1 Quantity</label>
                    <input type="number" class="form-control" id="hd_1" name="hd_1" value="<?php echo htmlspecialchars($contract['hd_1']); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="price_hd_1">Handster1 Price</label>
                    <input type="number" step="0.01" class="form-control" id="price_hd_1" name="price_hd_1" value="<?php echo htmlspecialchars($contract['price_hd_1']); ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="hd_2">Handster2 Quantity</label>
                    <input type="number" class="form-control" id="hd_2" name="hd_2" value="<?php echo htmlspecialchars($contract['hd_2']); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="price_hd_2">Handster2 Price</label>
                    <input type="number" step="0.01" class="form-control" id="price_hd_2" name="price_hd_2" value="<?php echo htmlspecialchars($contract['price_hd_2']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="total_price">Total Price</label>
                <input type="number" step="0.01" class="form-control readonly" id="total_price" name="total_price" value="<?php echo htmlspecialchars($contract['total_price']); ?>" readonly>
            </div>
            
            <button type="submit" name="modify" class="btn btn-primary">Modify</button>
            <button type="submit" id="cancelButton" name="cancel" class="btn btn-danger">Cancel</button>
        </form>
    </div>

    <script>
        document.getElementById('cancelButton').addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to cancel this contract?')) {
                event.preventDefault(); // Prevent form submission
            }
        });

        function calculateTotalPrice() {
            const mop18Qty = parseFloat(document.getElementById('mop_18').value) || 0;
            const mop18Price = parseFloat(document.getElementById('price_mop_18').value) || 0;
            const mop36Qty = parseFloat(document.getElementById('mop_36').value) || 0;
            const mop36Price = parseFloat(document.getElementById('price_mop_36').value) || 0;
            const mitQty = parseFloat(document.getElementById('mit').value) || 0;
            const mitPrice = parseFloat(document.getElementById('price_mit').value) || 0;
            const hd1Qty = parseFloat(document.getElementById('hd_1').value) || 0;
            const hd1Price = parseFloat(document.getElementById('price_hd_1').value) || 0;
            const hd2Qty = parseFloat(document.getElementById('hd_2').value) || 0;
            const hd2Price = parseFloat(document.getElementById('price_hd_2').value) || 0;

            const totalPrice = (mop18Qty * mop18Price) +
                               (mop36Qty * mop36Price) +
                               (mitQty * mitPrice) +
                               (hd1Qty * hd1Price) +
                               (hd2Qty * hd2Price);

            document.getElementById('total_price').value = totalPrice.toFixed(2);
        }

        // Add event listeners
        document.querySelectorAll('input[name^="mop_18"], input[name^="price_mop_18"], input[name^="mop_36"], input[name^="price_mop_36"], input[name^="mit"], input[name^="price_mit"], input[name^="hd_1"], input[name^="price_hd_1"], input[name^="hd_2"], input[name^="price_hd_2"]').forEach(input => {
            input.addEventListener('input', calculateTotalPrice);
        });

        // Initial calculation
        calculateTotalPrice();
    </script>
</body>
</html>

<?php
$conn->close();
?>
