<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Screen</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".section-title").click(function(){
                $(this).next(".section-content").slideToggle();
                $(this).toggleClass("active");
            });

            $(".section-content a").click(function(e){
                e.preventDefault();
                var page = $(this).attr("href");
                $("#content").html('<div class="loading">Loading...</div>');
                $("#content").load(page, function(response, status, xhr) {
                    if (status == "error") {
                        $("#content").html("<p>Error loading page. Please try again later.</p>");
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <div class="sidebar">
        <!-- Customers Section -->
        <div class="section">
            <div class="section-title">Customers</div>
            <div class="section-content">
                <a href="add_customer.html">Add a New Client</a>
                <a href="view_contracts.php">Search for Contracts</a>
                <a href="show_canceled.php">Canceled Contracts</a>
                <a href="cus_report.php">Reports</a>
            </div>
        </div>
        <!-- Companies Section -->
        <div class="section">
            <div class="section-title">Companies</div>
            <div class="section-content">
                <a href="companys/company.html">Add a New Company</a>
                <a href="companys/all_companys.php">Search for Companies</a>
                <a href="companys/show_canceled.php">Vacuumed Branches</a>
                <a href="companys/report.php">Reports</a>
            </div>
        </div>

        <!-- Notes Section -->
        <div class="section">
            <div class="section-title">Operation Notes</div>
                <div class="section-content">
                    <a href="Notes/add_notes.html">Add a New Notes</a>
                    <a href="Notes/view_notes.php">Search for Notes</a>
                </div>
            </div>

        <!-- Products Section -->
        <div class="section">
            <div class="section-title">Products & Stock</div>
            <div class="section-content">
                <a href="products/add_representative.php">اضافه مندوب</a>
                <a href="products/get_take.php">الاستلام والتسليم</a>
                <a href="main_stock/stock.html">المخزن الرئيسى</a>
            </div>
        </div>
        <!--Operation Section -->
        <div class="section">
            <div class="section-title">Contracts Operation</div>
            <div class="section-content">
                <a href="operations/new_contracts.php">Validation</a>
                <a href="operations/view_operations.php">Operation List</a>
            </div>
        </div>
    </div>
    <div id="content" class="content">
        <!-- Main content will be loaded here -->
    </div>
</body>
</html>

