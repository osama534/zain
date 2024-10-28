<?php
include '../db.php';

$contractId = $_GET['id'] ?? '';

if (!$contractId) {
    die('No contract ID provided.');
}

// Fetch contract details
$sql = "SELECT * FROM canceled_companys WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $contractId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die('Contract not found.');
}

$contract = $result->fetch_assoc();
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
        .table th, .table td {
            text-align: left;
        }
        .btn-container {
            text-align: center;
            margin-top: 30px;
        }
        .btn-container .btn {
            width: 150px;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Contract Details</h2>
        <table class="table table-bordered">
            <tbody>
                <?php foreach ($contract as $key => $value): ?>
                <tr>
                    <th><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $key))); ?></th>
                    <td><?php echo htmlspecialchars($value); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="btn-container">
            <a href="activate_canceled.php?id=<?php echo $contract['id']; ?>" class="btn btn-success">Activate</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
