<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نجاح عملية الحفظ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74ebd5, #ACB6E5);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .container {
            margin-top: 100px;
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
            text-align: center;
            max-width: 500px;
            width: 100%;
        }
        h2 {
            font-weight: 600;
            color: #333;
        }
        .btn-custom {
            background-color: #3498db;
            color: white;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 18px;
            transition: all 0.3s ease;
            margin-top: 20px;
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
        <h2>تم حفظ البيانات بنجاح!</h2>
        <a href="../main.php" class="btn btn-custom">الرجوع إلى الصفحة الرئيسية</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
