<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المخزن الرئيسي</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; margin-top: 20px; }
        .container { max-width: 800px; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>المخزن الرئيسي</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>اسم المنتج</th>
                    <th>الكمية الإجمالية</th>
                    <th>الكمية المصدرة</th>
                    <th>الكمية المتاحة</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli("localhost", "root", "", "my_stock");
                if ($conn->connect_error) { die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error); }
                $sql = "SELECT p.product_name, w.total_stock, w.exported_quantity, w.available_quantity
                        FROM New_products p
                        JOIN main_warehouse w ON p.product_id = w.product_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['product_name']}</td>
                                <td>{$row['total_stock']}</td>
                                <td>{$row['exported_quantity']}</td>
                                <td>{$row['available_quantity']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>لا توجد بيانات في المخزن</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
