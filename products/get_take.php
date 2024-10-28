<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الاستلام - التسليم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .option-card {
            margin: 10px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .option-card:hover {
            transform: scale(1.05);
        }
        h1 {
            text-align: center;
            margin-bottom: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <h1>اختار العملية</h1>
        <div class="col-md-4">
            <div class="card option-card text-center">
                <div class="card-body">
                    <h3 class="card-title">التقارير</h3>
                    <p class="card-text">انقر هنا لإجراء عملية التقارير.</p>
                    <a href="reports_page.php" class="btn btn-success">التقارير</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card option-card text-center">
                <div class="card-body">
                    <h3 class="card-title">الاستلام</h3>
                    <p class="card-text">انقر هنا لإجراء عملية الاستلام.</p>
                    <a href="products/get_products.php" class="btn btn-primary" target="blank">الاستلام</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card option-card text-center">
                <div class="card-body">
                    <h3 class="card-title">التسليم</h3>
                    <p class="card-text">انقر هنا لإجراء عملية التسليم.</p>
                    <a href="products/take_products.php" class="btn btn-success" target=blank>التسليم</a>


                    
                </div>
            </div>
        </div>
        
    </div>
</div>

</body>
</html>
