<?php
// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "my_stock");

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// التحقق من إرسال البيانات ومعالجتها
$message = "";
$alert_class = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $representative_name = $_POST['representative_name'];
    $date = $_POST['date'];
    $mob18 = $_POST['mob18'];
    $mob36 = $_POST['mob36'];
    $gloves = $_POST['gloves'];
    $handster1 = $_POST['handster1'];
    $handster2 = $_POST['handster2'];

    // إدخال البيانات في قاعدة البيانات
    $sql = "INSERT INTO representative_products (representative_name, date_of_entry, mob18, mob36, gloves, handster1, handster2)
            VALUES ('$representative_name', '$date', '$mob18', '$mob36', '$gloves', '$handster1', '$handster2')";

    if ($conn->query($sql) === TRUE) {
        $message = "تم حفظ البيانات بنجاح!";
        $alert_class = "alert-success";
    } else {
        $message = "حدث خطأ أثناء حفظ البيانات: " . $conn->error;
        $alert_class = "alert-danger";
    }
}

// جلب أسماء المناديب من قاعدة البيانات
$representatives_query = "SELECT representative_name FROM representatives"; // افترض أن الجدول اسمه 'representatives'
$representatives_result = $conn->query($representatives_query);

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة بيانات المندوب</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f8ff;
        }
        .container {
            margin-top: 50px;
        }
        .form-control {
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            width: 100%;
            border-radius: 10px;
            font-size: 18px;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .form-box {
            background-color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: right;
        }
        h3 {
            color: #333;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .alert {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-box">
                <h3 class="text-center">إضافة بيانات المنتجات للمندوب</h3>
                
                <!-- رسالة الحفظ -->
                <?php if ($message != ""): ?>
                    <div class="alert <?php echo $alert_class; ?> text-center">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                
                <!-- النموذج -->
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="representative_name">اسم المندوب</label>
                        <select class="form-control" id="representative_name" name="representative_name" required>
                            <option value="">اختر المندوب</option>
                            <?php 
                            if ($representatives_result->num_rows > 0) {
                                // عرض أسماء المناديب في القائمة المنسدلة
                                while ($row = $representatives_result->fetch_assoc()) {
                                    echo "<option value='" . $row['representative_name'] . "'>" . $row['representative_name'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>لا يوجد مناديب مسجلة</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">التاريخ</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="mob18">موب18</label>
                        <input type="number" class="form-control" id="mob18" name="mob18">
                    </div>
                    <div class="form-group">
                        <label for="mob36">موب36</label>
                        <input type="number" class="form-control" id="mob36" name="mob36">
                    </div>
                    <div class="form-group">
                        <label for="gloves">جوانتي</label>
                        <input type="number" class="form-control" id="gloves" name="gloves">
                    </div>
                    <div class="form-group">
                        <label for="handster1">هاندستر 1</label>
                        <input type="number" class="form-control" id="handster1" name="handster1">
                    </div>
                    <div class="form-group">
                        <label for="handster2">هاندستر 2</label>
                        <input type="number" class="form-control" id="handster2" name="handster2">
                    </div>
                    <button type="submit" class="btn btn-custom">حفظ البيانات</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
