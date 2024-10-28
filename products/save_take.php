<?php
$servername = "localhost"; // اسم السيرفر
$username = "root"; // اسم المستخدم
$password = ""; // كلمة المرور
$dbname = "my_project"; // اسم قاعدة البيانات

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// تحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// استلام المدخلات من النموذج
$representative_name = $_POST['representative_name'];
$date_of_entry = $_POST['date_of_entry'];
$mob18 = $_POST['mob18'];
$mob36 = $_POST['mob36'];
$gloves = $_POST['gloves'];
$handster1 = $_POST['handster1'];
$handster2 = $_POST['handster2'];

// إدخال البيانات إلى قاعدة البيانات
$sql = "INSERT INTO take_products (representative_name, date_of_entry, mob18, mob36, gloves, handster1, handster2)
VALUES ('$representative_name', '$date_of_entry', '$mob18', '$mob36', '$gloves', '$handster1', '$handster2')";

if ($conn->query($sql) === TRUE) {
    echo "تم حفظ البيانات بنجاح!";
} else {
    echo "خطأ: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
