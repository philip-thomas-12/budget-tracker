<?php
include("session.php");
$update = false;
$del = false;
$incomeamount = "";
$incomedate = date("Y-m-d");
$incomecategory = "";


if (isset($_POST['add'])) {
    $incomeamount = 
    $_POST['incomeamount'];
    $incomedate = $_POST['incomedate'];
    $incomecategory = $_POST['incomecategory'];

    $income_query = "INSERT INTO income (user_id, amount, date, category) VALUES ('$userid', '$incomeamount','$incomedate','$incomecategory')";
    mysqli_query($con, $income_query) or die("Something Went Wrong!");
    header('location: add_income.php');
}



if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $incomeamount = $_POST['incomeamount'];
    $incomedate = $_POST['incomedate'];
    $incomecategory = $_POST['incomecategory'];

    $sql = "UPDATE income SET amount='$incomeamount', date='$incomedate', category='$incomecategory' WHERE user_id='$userid' AND income_id='$id'";
    mysqli_query($con, $sql) or die("Error updating record");
    header('location: manage_income.php');
}


if (isset($_POST['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM income WHERE user_id='$userid' AND income_id='$id'";
    mysqli_query($con, $sql) or die("Error deleting record");
    header('location: manage_income.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($con, "SELECT * FROM income WHERE user_id='$userid' AND income_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $incomeamount = $n['amount'];
        $incomedate = $n['date'];
        $incomecategory = $n['category'];
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $del = true;
    $record = mysqli_query($con, "SELECT * FROM income WHERE user_id='$userid' AND income_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $incomeamount = $n['amount'];
        $incomedate = $n['date'];
        $incomecategory = $n['category'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Income Manager - Dashboard</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/feather.min.js"></script>
</head>
<body>
    <div class="d-flex" id="wrapper">
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
        <a href="expensereport.php" class="list-group-item list-group-item-action"><span data-feather="file-text"></span> Expense Report</a>
        <a href="add_income.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="plus-square"></span> Add Income</a>
        <a href="manage_income.php" class="list-group-item list-group-item-action"><span data-feather="dollar-sign"></span> Manage Income</a>
        <a href="incomereport.php" class="list-group-item list-group-item-action "><span data-feather="file-text"></span> Income Report</a>
     
    
            </div>
            <div class="sidebar-heading">Settings</div>
            <div class="list-group list-group-flush">
                <a href="profile.php" class="list-group-item list-group-item-action"><span data-feather="user"></span> Profile</a>
                <a href="logout.php" class="list-group-item list-group-item-action"><span data-feather="power"></span> Logout</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light border-bottom">
                <button class="toggler" type="button" id="menu-toggle"><span data-feather="menu"></span></button>
                <div class="col-md-12 text-center"><h3>Add Your Income</h3></div>
            </nav>
            <div class="container d-flex align-items-center justify-content-center vh-100 mt-n5">
    <div class="row w-100">
        <div class="col-md"></div>
        <div class="col-md-6">
            <form action="" method="POST" class="p-4 border rounded shadow">
                <h4 class="text-center mb-4">Add Your Income</h4>

                <!-- Amount Field -->
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label text-right"><b>Enter Amount</b></label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" value="<?php echo $incomeamount; ?>" name="incomeamount" required>
                    </div>
                </div>

                <!-- Date Field -->
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label text-right"><b>Date</b></label>
                    <div class="col-md-6">
                        <input type="date" class="form-control" value="<?php echo $incomedate; ?>" name="incomedate" required>
                    </div>
                </div>

                <!-- Category Dropdown -->
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label text-right"><b>Category</b></label>
                    <div class="col-md-6">
                        <select class="form-control" name="incomecategory" required>
                            <?php
                            $categories_query = "SELECT * FROM income_categories";
                            $categories_result = mysqli_query($con, $categories_query);
                            while ($row = mysqli_fetch_assoc($categories_result)) {
                                $category_name = $row['category_name'];
                                $selected = ($category_name === $incomecategory) ? 'selected' : '';
                                echo "<option value='$category_name' $selected>$category_name</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group text-center mt-4">
                    <?php if ($update) : ?>
                        <button class="btn btn-warning btn-lg btn-block" type="submit" name="update">Update</button>
                    <?php elseif ($del) : ?>
                        <button class="btn btn-danger btn-lg btn-block" type="submit" name="delete">Delete</button>
                    <?php else : ?>
                        <button type="submit" name="add" class="btn btn-success btn-lg btn-block">Add Income</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        <div class="col-md"></div>
    </div>
</div>

            </div>
        </div>
    </div>
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        feather.replace();
    </script>
</body>
</html>
