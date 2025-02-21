<?php
include("session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reportType = $_POST['report_type'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];

    $query = "";
    $tableHeader = '';
    $periodDates = array();

    switch ($reportType) {
        case 'datewise':
            $query = "SELECT DATE(date) AS period, SUM(amount) AS totalIncome FROM income WHERE user_id = '$userid' AND date BETWEEN '$startDate' AND '$endDate' GROUP BY period";
            $tableHeader = 'Date';
            $periodDates = generateDateRange($startDate, $endDate);
            break;
        case 'monthwise':
            $query = "SELECT YEAR(date) AS year, MONTH(date) AS month, SUM(amount) AS totalIncome FROM income WHERE user_id = '$userid' AND date BETWEEN '$startDate' AND '$endDate' GROUP BY year, month";
            $tableHeader = 'Year-Month';
            $periodDates = generateMonthYearRange($startDate, $endDate);
            break;
        case 'yearwise':
            $query = "SELECT YEAR(date) AS year, SUM(amount) AS totalIncome FROM income WHERE user_id = '$userid' AND date BETWEEN '$startDate' AND '$endDate' GROUP BY year";
            $tableHeader = 'Year';
            $periodDates = generateYearRange($startDate, $endDate);
            break;
    }

    if ($query !== "") {
        $income_fetched = mysqli_query($con, $query);
    }
}

function generateDateRange($startDate, $endDate) {
    $dates = array();
    $currentDate = strtotime($startDate);
    while ($currentDate <= strtotime($endDate)) {
        $dates[] = date('Y-m-d', $currentDate);
        $currentDate = strtotime('+1 day', $currentDate);
    }
    return $dates;
}

function generateMonthYearRange($startDate, $endDate) {
    $periodDates = array();
    $currentDate = strtotime($startDate);
    while ($currentDate <= strtotime($endDate)) {
        $periodDates[] = date('Y-m', $currentDate);
        $currentDate = strtotime('+1 month', $currentDate);
    }
    return $periodDates;
}

function generateYearRange($startDate, $endDate) {
    $periodDates = array();
    $currentDate = strtotime($startDate);
    while ($currentDate <= strtotime($endDate)) {
        $periodDates[] = date('Y', $currentDate);
        $currentDate = strtotime('+1 year', $currentDate);
    }
    return $periodDates;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Income Report</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .try {
            font-size: 28px;
            color: #333;
            padding: 15px 0px 5px 0px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-right" id="sidebar-wrapper">
            <div class="user">
                <img class="img img-fluid rounded-circle" src="uploads/default_profile.png" width="120">
                <h5><?php echo $username ?></h5>
                <p><?php echo $useremail ?></p>
            </div>
            <div class="sidebar-heading">Management</div>
            <div class="list-group list-group-flush">
        
            <a href="dashboard.php" class="list-group-item list-group-item-action "><span data-feather="home"></span> Dashboard</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Expenses</a>
        <a href="expensereport.php" class="list-group-item list-group-item-action "><span data-feather="file-text"></span> Expense Report</a>
        <a href="add_income.php" class="list-group-item list-group-item-action "><span data-feather="plus-square"></span> Add Income</a>
        <a href="manage_income.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Income</a>
        <a href="incomereport.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="file-text"></span> Income Report</a>
     
        
        </div>
            <div class="sidebar-heading">Settings</div>
            <div class="list-group list-group-flush">
                <a href="profile.php" class="list-group-item list-group-item-action">Profile</a>
                <a href="logout.php" class="list-group-item list-group-item-action">Logout</a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light border-bottom">
                <button class="toggler" type="button" id="menu-toggle">
                    <span>&#9776;</span> <!-- Sidebar Toggle Icon -->
                </button>
                <div class="col-md-11 text-center">
                    <h2 class="try">Income Report</h2>
                </div>
            </nav>

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form method="POST" action="">
                            <div class="form-group row" style="padding-top: 25px;">
                                <label for="report_type" class="col-sm-6 col-form-label"><b>Select Report Type:</b></label>
                                <div class="col-md-6">
                                    <select class="form-control col-sm-12" id="report_type" name="report_type">
                                        <option value="datewise">Datewise Report</option>
                                        <option value="monthwise">Monthwise Report</option>
                                        <option value="yearwise">Yearwise Report</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="start_date" class="col-sm-6 col-form-label"><b>Start Date</b></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control col-sm-12" value="<?php echo date('Y-m-d'); ?>" name="start_date" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="end_date" class="col-sm-6 col-form-label"><b>End Date</b></label>
                                <div class="col-md-6">
                                    <input type="date" class="form-control col-sm-12" value="<?php echo date('Y-m-d'); ?>" name="end_date" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-lg btn-block btn-success">Generate Report</button>
                                </div>
                            </div>
                        </form>

                        <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($income_fetched)) { ?>
                            <h4 class="mt-4">Generated Report</h4>
                            <table class="table table-hover table-bordered">
                                <thead><tr class="text-center"><th>Sl No.</th><th><?php echo $tableHeader; ?></th><th>Total Amount</th></tr></thead>
                                <tbody>
                                    <?php
                                    $count = 1;
                                    while ($row = mysqli_fetch_array($income_fetched)) {
                                        echo "<tr><td class='text-center'>{$count}</td><td class='text-center'>{$row['period']}</td><td class='text-center'>{$row['totalIncome']}</td></tr>";
                                        $count++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/feather-icons"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize Feather Icons
        feather.replace();

        // Sidebar toggle functionality
        document.getElementById("menu-toggle").addEventListener("click", function(e) {
            e.preventDefault();
            document.getElementById("wrapper").classList.toggle("toggled");

            // Refresh Feather icons after toggling
            feather.replace();
        });
    });
</script>

</body>

</html>