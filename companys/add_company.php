<?php
// Include the database connection file
include '../db.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $contract_number = $conn->real_escape_string($_POST['contract_number']);
    $company_name = $conn->real_escape_string($_POST['company_name']);
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

    // Calculate total price
    $total_price = ($mop_18 * $price_mop_18) + ($mop_36 * $price_mop_36) + ($mit * $price_mit) + ($hd_1 * $price_hd_1) + ($hd_2 * $price_hd_2);

    // Check for duplicate contract number
    $check_duplicate_sql = "SELECT COUNT(*) FROM company WHERE contract_number = '$contract_number'";
    $result = $conn->query($check_duplicate_sql);

    if ($result->fetch_row()[0] > 0) {
        $message = "Error: Duplicate contract number. Please enter a unique contract number.";
    } else {
        // Prepare the SQL statement
        $sql = "INSERT INTO company (contract_number, company_name, phone_number, activation_date, address, change_every, area, contract_notes, mop_18, price_mop_18, mop_36, price_mop_36, mit, price_mit, hd_1, price_hd_1, hd_2, price_hd_2, total_price) 
                VALUES ('$contract_number', '$company_name', '$phone_number', '$activation_date', '$address', '$change_every', '$area', '$contract_notes', $mop_18, $price_mop_18, $mop_36, $price_mop_36, $mit, $price_mit, $hd_1, $price_hd_1, $hd_2, $price_hd_2, $total_price)";

        // Execute the SQL statement
        if ($conn->query($sql) === TRUE) {
            $message = "contract saved successfully!";
        } else {
            $message = "Error: Something went wrong. Please try again later.";
            // Log the error message
            error_log("Database error: " . $conn->error);
        }
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Save Confirmation</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <style>
       body {
           background-color: #f8f9fa;
       }
       .container {
           max-width: 900px;
           margin: 20px auto;
           padding: 20px;
           background: #fff;
           box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
           border-radius: 8px;
       }
       .alert {
           margin-top: 20px;
       }
   </style>
</head>
<body>
   <div class="container">
       <?php if (isset($message)): ?>
           <div class="alert alert-info">
               <?php echo $message; ?>
           </div>
       <?php endif; ?>
       
       <a href="../main.php" class="btn btn-primary">Back to Form</a>
   </div>
</body>
</html>
