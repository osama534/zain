<?php
include '../db.php';

// Capture form data
$contract_number = $_POST['contract_number'];
$client_name = $_POST['client_name'];
$representative_name = $_POST['representative_name'];
$next_change_date = $_POST['next_change_date'];
$notes = $_POST['notes'];

// Insert data into customer_notes table
$sql = "INSERT INTO customer_notes (contract_number, client_name, representative_name, next_change_date, notes) 
        VALUES ('$contract_number', '$client_name', '$representative_name', '$next_change_date', '$notes')";

if ($conn->query($sql) === TRUE) {
    // Display success message with an OK button
    echo "
    <html>
    <head>
        <title>Success</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
                text-align: center;
            }
            .message-box {
                background-color: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                display: inline-block;
                margin-top: 50px;
            }
            .ok-button {
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
            }
            .ok-button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class='message-box'>
            <h2>Data saved successfully!</h2>
            <form action='add_notes.html' method='GET'>
                <button type='submit' class='ok-button'>OK</button>
            </form>
        </div>
    </body>
    </html>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
