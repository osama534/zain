<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض العقود حسب تاريخ التسليم</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .table-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">البحث عن العقود حسب تاريخ التسليم</h2>
        
        <!-- Form to select delivery date -->
        <form action="" method="POST" class="form-inline justify-content-center">
            <div class="form-group mx-sm-3 mb-2">
                <label for="delivery_date" class="sr-only">تاريخ التسليم</label>
                <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
            </div>
            <button type="submit" name="search" class="btn btn-primary mb-2">بحث</button>
        </form>
        
        <!-- Display the results in a table -->
        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>رقم العقد</th>
                        <th>اسم العميل</th>
                        <th>رقم الهاتف</th>
                        <th>تاريخ التفعيل</th>
                        <th>تاريخ التسليم</th>
                        <th>العنوان</th>
                        <th>المنطقة</th>
                        <th>ملاحظات العقد</th>
                        <th>السعر الإجمالي</th>
                        <th>ملاحظات إضافية</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connect to the database
                    $conn = new mysqli('localhost', 'root', '', 'my_project');
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Handle the form submission
                    if (isset($_POST['search'])) {
                        $delivery_date = $_POST['delivery_date'];

                        // Query to fetch contracts based on delivery date
                        $query = "SELECT * FROM operation_list WHERE delivery_date = '$delivery_date'";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['contract_number'] . "</td>";
                                echo "<td>" . $row['client_name'] . "</td>";
                                echo "<td>" . $row['phone_number'] . "</td>";
                                echo "<td>" . $row['activation_date'] . "</td>";
                                echo "<td>" . $row['delivery_date'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                echo "<td>" . $row['area'] . "</td>";
                                echo "<td>" . $row['contract_notes'] . "</td>";
                                echo "<td>" . $row['total_price'] . "</td>";
                                echo "<td>" . $row['notes'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10' class='text-center'>لا توجد عقود لهذا التاريخ</td></tr>";
                        }
                    }
                    // Close the database connection
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
