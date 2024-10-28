<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المنتجات المصدرة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; margin-top: 20px; }
        .container { max-width: 800px; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>المنتجات المصدرة</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="product_id" class="form-label">اختيار المنتج</label>
                <select class="form-select" id="product_id" name="product_id" required>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "my_stock");
                    if ($conn->connect_error) { die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error); }
                    $result = $conn->query("SELECT product_id, product_name FROM New_products");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['product_id']}'>{$row['product_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="rep_id" class="form-label">اسم المندوب</label>
                <select class="form-select" id="rep_id" name="rep_id" required>
                    <?php
                    $result = $conn->query("SELECT rep_id, rep_name FROM representative");
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='{$row['rep_id']}'>{$row['rep_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity_exported" class="form-label">الكمية المصدرة</label>
                <input type="number" class="form-control" id="quantity_exported" name="quantity_exported" required>
            </div>
            <div class="mb-3">
                <label for="export_date" class="form-label">تاريخ التصدير</label>
                <input type="date" class="form-control" id="export_date" name="export_date" required>
            </div>
            <button type="submit" class="btn btn-primary">إضافة المنتج المصدّر</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = $_POST['product_id'];
            $rep_id = $_POST['rep_id'];
            $quantity_exported = $_POST['quantity_exported'];
            $export_date = $_POST['export_date'];

            $sql = "INSERT INTO exported_products (product_id, rep_id, quantity_exported, export_date) 
                    VALUES ('$product_id', '$rep_id', '$quantity_exported', '$export_date')";
            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success mt-3'>تم إضافة المنتج المصدّر بنجاح!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>خطأ: " . $conn->error . "</div>";
            }
        }
        $conn->close();
        ?>
        
        <h2 class="mt-5">قائمة المنتجات المصدرة</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>اسم المندوب</th>
                    <th>الكمية المصدرة</th>
                    <th>تاريخ التصدير</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $conn = new mysqli("localhost", "root", "", "my_stock");
                if ($conn->connect_error) { die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error); }
                $sql = "SELECT r.rep_name, e.quantity_exported, e.export_date
                        FROM exported_products e
                        JOIN New_products p ON e.product_id = p.product_id
                        JOIN representative r ON e.rep_id = r.rep_id";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['rep_name']}</td>
                                <td>{$row['quantity_exported']}</td>
                                <td>{$row['export_date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>لا توجد بيانات للمصدرة</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
