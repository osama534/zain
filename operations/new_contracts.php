<?php
// Include database connection
include '../db.php';

// Fetch newly saved contracts
$sql = "SELECT * FROM customers WHERE is_activated = 0 ORDER BY activation_date DESC";
 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض العملاء</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
        }
        .container {
            margin-top: 50px;
        }
        table {
            width: 100%;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">العقود الجديده</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>رقم العقد</th>
                    <th>اسم العميل</th>
                    <th>رقم الهاتف</th>
                    <th>تاريخ التفعيل</th>
                    <th>المنطقة</th>
                    <th>مدة التغيير</th>
                    <th>إجمالي السعر</th>
                    <th>العمليات</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['contract_number'] . "</td>";
                        echo "<td>" . $row['client_name'] . "</td>";
                        echo "<td>" . $row['phone_number'] . "</td>";
                        echo "<td>" . $row['activation_date'] . "</td>";
                        echo "<td>" . $row['area'] . "</td>";
                        echo "<td>" . $row['change_every'] . " يوم</td>";
                        echo "<td>" . $row['total_price'] . "</td>";
                        echo "<td><a href='operations/customer_operations.php?customer_id=" . $row['id'] . "' class='btn btn-primary'>مراجعه العقد</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>لا توجد بيانات عملاء مسجلة</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
