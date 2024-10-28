<?php
// تضمين الاتصال بقاعدة البيانات
include '../db.php';

if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    // استرجاع تفاصيل العقد من جدول customers
    $sql = "SELECT * FROM customers WHERE id = $customer_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $contract = $result->fetch_assoc();
    } else {
        echo "لا يوجد عقد بالمعرف المحدد.";
        exit;
    }
} else {
    echo "لم يتم تحديد معرف العميل.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $delivery_date = $_POST['delivery_date'];
    $notes = $_POST['notes'];

    // نقل العقد إلى جدول operation_list
    $insert_sql = "INSERT INTO operation_list 
        (contract_number, client_name, phone_number, activation_date, delivery_date, address, change_every, area, contract_notes, mop_18, price_mop_18, mop_36, price_mop_36, mit, price_mit, hd_1, price_hd_1, hd_2, price_hd_2, total_price, notes) 
        VALUES 
        ('{$contract['contract_number']}', '{$contract['client_name']}', '{$contract['phone_number']}', '{$contract['activation_date']}', '$delivery_date', '{$contract['address']}', '{$contract['change_every']}', '{$contract['area']}', '{$contract['contract_notes']}', '{$contract['mop_18']}', '{$contract['price_mop_18']}', '{$contract['mop_36']}', '{$contract['price_mop_36']}', '{$contract['mit']}', '{$contract['price_mit']}', '{$contract['hd_1']}', '{$contract['price_hd_1']}', '{$contract['hd_2']}', '{$contract['price_hd_2']}', '{$contract['total_price']}', '$notes')";

    if ($conn->query($insert_sql) === TRUE) {
        // تحديث حالة التفعيل في جدول customers
        $update_sql = "UPDATE customers SET is_activated = 1 WHERE id = $customer_id";
        $conn->query($update_sql);

        echo "<script>
                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم تفعيل العقد بنجاح!',
                        confirmButtonText: 'حسنًا'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'new_contracts.php';
                        }
                    });
                }, 500);
              </script>";
    } else {
        echo "خطأ في نقل البيانات إلى جدول العمليات: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل العقد</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        body { background-color: #f4f4f4; }
        .container { margin-top: 50px; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">تفاصيل العقد</h2>
        <table class="table table-bordered">
            <tr><th>رقم العقد</th><td><?php echo $contract['contract_number']; ?></td></tr>
            <tr><th>اسم العميل</th><td><?php echo $contract['client_name']; ?></td></tr>
            <tr><th>رقم الهاتف</th><td><?php echo $contract['phone_number']; ?></td></tr>
            <tr><th>تاريخ التفعيل</th><td><?php echo $contract['activation_date']; ?></td></tr>
            <tr><th>المنطقة</th><td><?php echo $contract['area']; ?></td></tr>
            <tr><th>مدة التغيير</th><td><?php echo $contract['change_every']; ?> يوم</td></tr>
            <tr><th>إجمالي السعر</th><td><?php echo $contract['total_price']; ?></td></tr>
        </table>

        <form method="post">
            <div class="form-group">
                <label for="delivery_date">تاريخ التسليم</label>
                <input type="date" class="form-control" id="delivery_date" name="delivery_date" required>
            </div>
            <div class="form-group">
                <label for="notes">الملاحظات</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-3">تأكيد التفعيل</button>
        </form>
    </div>
</body>
</html>
