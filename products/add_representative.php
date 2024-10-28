<?php
// الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_project";

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// التحقق إذا تم إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // التأكد من تعبئة كافة الحقول
    if (!empty($_POST['representative_name']) && !empty($_POST['address']) && !empty($_POST['phone_number']) && !empty($_POST['appointment_date'])) {

        // استخدام mysqli_real_escape_string لتجنب SQL Injection
        $representative_name = $conn->real_escape_string($_POST['representative_name']);
        $address = $conn->real_escape_string($_POST['address']);
        $phone_number = $conn->real_escape_string($_POST['phone_number']);
        $appointment_date = $conn->real_escape_string($_POST['appointment_date']);

        // التحقق من وجود اسم المندوب مسبقاً
        $check_sql = "SELECT * FROM representatives WHERE representative_name = '$representative_name'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            echo "اسم المندوب موجود مسبقاً، الرجاء إدخال اسم مختلف.";
        } else {
            // استعلام الإدخال
            $sql = "INSERT INTO representatives (representative_name, address, phone_number, appointment_date) 
                    VALUES ('$representative_name', '$address', '$phone_number', '$appointment_date')";

            // تنفيذ الاستعلام والتحقق من نجاح الإدخال
            if ($conn->query($sql) === TRUE) {
                // إعادة التوجيه إلى صفحة النجاح
                header("Location: success.php");
                exit();

                
            } else {
                echo "خطأ في الإدخال: " . $conn->error;
            }
        }
    } else {
        echo "الرجاء تعبئة كافة الحقول المطلوبة!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدخال بيانات المندوب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .container {
            margin-top: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .card {
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            margin-bottom: 30px;
            width: 100%;
            max-width: 600px;
        }
        h2 {
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            font-weight: 500;
            color: #666;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-custom {
            background-color: #3498db;
            color: white;
            border-radius: 20px;
            padding: 10px;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2>إدخال بيانات المندوب</h2>

        <form action="products/add_representative.php" method="POST">
            <div class="mb-3">
                <label for="representative_name" class="form-label">اسم المندوب</label>
                <input type="text" class="form-control" id="representative_name" name="representative_name" placeholder="أدخل اسم المندوب" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">العنوان</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="أدخل عنوان المندوب" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">رقم التليفون</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="أدخل رقم التليفون" required>
            </div>
            <div class="mb-3">
                <label for="appointment_date" class="form-label">تاريخ التعيين</label>
                <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-custom">حفظ البيانات</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
