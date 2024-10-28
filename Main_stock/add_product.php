<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتج</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; margin-top: 20px; }
        .container { max-width: 600px; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>إضافة منتج جديد</h1>
        <form action="add_product.php" method="POST">
            
            <div class="mb-3">
                <label for="product_name" class="form-label">اسم المنتج</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="mb-3">
                <label for="product_description" class="form-label">وصف المنتج</label>
                <textarea class="form-control" id="product_description" name="product_description"></textarea>
            </div>
            <div class="mb-3">
                <label for="stock_quantity" class="form-label">الكمية المتوفرة</label>
                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="0" min="0">
            </div>
            <button type="submit" class="btn btn-primary">إضافة المنتج</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $conn = new mysqli("localhost", "root", "", "my_stock");
            if ($conn->connect_error) { die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error); }

            $product_name = $_POST['product_name'];
            $product_description = $_POST['product_description'];
            $stock_quantity = $_POST['stock_quantity'];

            $sql = "INSERT INTO New_products (product_name, product_description, stock_quantity) 
                    VALUES ('$product_name', '$product_description', $stock_quantity)";
            if ($conn->query($sql) === TRUE) {
                echo "<div class='alert alert-success mt-3'>تم إضافة المنتج بنجاح!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>خطأ: " . $conn->error . "</div>";
            }
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
