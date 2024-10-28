<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة مدخلات</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        background-color: blue;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        
    }
    h2 {
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }
    .form-control {
        border-radius: 5px;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .btn-primary {
        background-color: #007bff;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }
    @media (max-width: 768px) {
        .card {
            padding: 2rem;
        }
    }
</style>

</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h2 class="text-center">تسليم المنتجات للمناديب</h2>
                <form action="save_take.php" method="POST">
                    <div class="form section">
                        <div class="form-row row">
                            <div class="col-md-6">
                                <label for="representative_name">اسم المندوب:</label>
                                <select class="form-control" id="representative_name" name="representative_name" required>
                                <option value="">اختر المندوب</option>
                                <?php
                                // اتصال بقاعدة البيانات
                                $servername = "localhost"; // اسم السيرفر
                                $username = "root"; // اسم المستخدم
                                $password = ""; // كلمة المرور
                                $dbname = "my_project"; // اسم قاعدة البيانات

                                // إنشاء الاتصال
                                $conn = new mysqli($servername, $username, $password, $dbname);

                                // تحقق من الاتصال
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // استعلام لجلب أسماء المناديب
                                $sql = "SELECT representative_name FROM representatives";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['representative_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">لا توجد مناديب متاحة</option>';
                                }

                                $conn->close();
                                ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="date_of_entry">تاريخ الإدخال:</label>
                                <input type="date" class="form-control" id="date_of_entry" name="date_of_entry" required>
                            </div>                       
                        </div><br><br>
                        <div class="form-row row">
                            <div class="col-md-4">
                                <label for="mob18">موب(18):</label>
                                <input type="number" class="form-control" id="mob18" name="mob18" required>
                            </div>
                            <div class="col-md-4">
                                <label for="mob36">موب(36):</label>
                                <input type="number" class="form-control" id="mob36" name="mob36" required>
                            </div>
                            <div class="col-md-4">
                                <label for="gloves">الجوانتى:</label>
                                <input type="number" class="form-control" id="gloves" name="gloves" required>
                            </div>

                        </div><br><br>
                        
                    </div>                    
                    <div class="form-row row">
                        <div class="col-md-4">
                            <label for="handster1">هاندستر 1:</label>
                            <input type="number" class="form-control" id="handster1" name="handster1" required>
                        </div>
                        <div class="col-md-4">
                            <label for="handster2">هاندستر 2:</label>
                            <input type="number" class="form-control" id="handster2" name="handster2" required>
                        </div>            
                    </div><br><br><br>
                    
                    <button type="submit" class="btn btn-primary btn-block">حفظ منتجات التسليم</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
