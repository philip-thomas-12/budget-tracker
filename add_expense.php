<?php
include("session.php");

$update = false;
$del = false;
$expenseamount = "";
$expensedate = date("Y-m-d");
$expensecategory = "";

if (isset($_POST['add'])) {
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];

    $expenses = "INSERT INTO expenses (user_id, expense,expensedate,expensecategory) VALUES ('$userid', '$expenseamount','$expensedate','$expensecategory')";
    $result = mysqli_query($con, $expenses) or die("Something Went Wrong!");
    header('location: add_expense.php');
}

if (isset($_POST['update'])) {
    $id = $_GET['edit'];
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];

    $sql = "UPDATE expenses SET expense='$expenseamount', expensedate='$expensedate', expensecategory='$expensecategory' WHERE user_id='$userid' AND expense_id='$id'";
    if (mysqli_query(mysql: $con, query: $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_expense.php');
}

if (isset($_POST['delete'])) {
    $id = $_GET['delete'];
    $expenseamount = $_POST['expenseamount'];
    $expensedate = $_POST['expensedate'];
    $expensecategory = $_POST['expensecategory'];

    $sql = "DELETE FROM expenses WHERE user_id='$userid' AND expense_id='$id'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: manage_expense.php');
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");
    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense'];
        $expensedate = $n['expensedate'];
        $expensecategory = $n['expensecategory'];
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $del = true;
    $record = mysqli_query($con, "SELECT * FROM expenses WHERE user_id='$userid' AND expense_id=$id");

    if (mysqli_num_rows($record) == 1) {
        $n = mysqli_fetch_array($record);
        $expenseamount = $n['expense'];
        $expensedate = $n['expensedate'];
        $expensecategory = $n['expensecategory'];
    } else {
        echo ("WARNING: AUTHORIZATION ERROR: Trying to Access Unauthorized data");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Expense Manager - Dashboard</title>
    

     <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">

    <!-- Feather JS for Icons -->
    <script src="js/feather.min.js"></script>
<style>
    .try {
  font-size: 28px; /* Adjust the font size as needed */
  color: #333;    /* Adjust the color as needed */
  padding: 15px 70px 5px 0px;   /* Adjust the padding as needed */
}


</style>
</head>

<body>

    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
    <div class="border-right" id="sidebar-wrapper">
      <div class="user">
        <img class="img img-fluid rounded-circle" src="uploads\default_profile.png" width="120">
        <h5><?php echo $username ?></h5>
        <p><?php echo $useremail ?></p>
      </div>
      <div class="sidebar-heading">Management</div>
      <div class="list-group list-group-flush">
      <a href="dashboard.php" class="list-group-item list-group-item-action "><span data-feather="home"></span> Dashboard</a>
        <a href="add_expense.php" class="list-group-item list-group-item-action sidebar-active"><span data-feather="plus-square"></span> Add Expenses</a>
        <a href="manage_expense.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Expenses</a>
        <a href="expensereport.php" class="list-group-item list-group-item-action"><span data-feather="file-text"></span> Expense Report</a>
        <a href="add_income.php" class="list-group-item list-group-item-action"><span data-feather="plus-square"></span> Add Income</a>
        <a href="manage_income.php" class="list-group-item list-group-item-action "><span data-feather="dollar-sign"></span> Manage Income</a>
        <a href="incomereport.php" class="list-group-item list-group-item-action "><span data-feather="file-text"></span> Income Report</a>
     
      </div>
      <div class="sidebar-heading">Settings </div>
      <div class="list-group list-group-flush">
        <a href="profile.php" class="list-group-item list-group-item-action "><span data-feather="user"></span> Profile</a>
        <a href="logout.php" class="list-group-item list-group-item-action "><span data-feather="power"></span> Logout</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light  border-bottom">


                <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
                    <span data-feather="menu"></span>
                </button>
                <div class="col-md-12 text-center">
    <h3 class="try">Add Your Daily Expenses</h3>
</div>

                <hr>                        
            </nav>

            <div class="container d-flex align-items-center justify-content-center vh-100 mt-n5">
    <div class="col-md-6">
        <form action="" method="POST" class="p-4 border rounded shadow">
            <h4 class="text-center mb-4">Add Your Daily Expenses</h4>

            <!-- Amount Field -->
            <div class="form-group row">
                <label for="expenseamount" class="col-sm-4 col-form-label text-right"><b>Enter Amount</b></label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" value="<?php echo $expenseamount; ?>" id="expenseamount" name="expenseamount" required>
                </div>
            </div>

            <!-- Date Field -->
            <div class="form-group row">
                <label for="expensedate" class="col-sm-4 col-form-label text-right"><b>Date</b></label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" value="<?php echo $expensedate; ?>" name="expensedate" id="expensedate" required>
                </div>
            </div>

            <!-- Category Dropdown -->
            <div class="form-group row">
                <label class="col-sm-4 col-form-label text-right"><b>Category</b></label>
                <div class="col-sm-8">
                    <select class="form-control" id="expensecategory" name="expensecategory" required>
                        <?php
                        $categories_query = "SELECT * FROM expense_categories";
                        $categories_result = mysqli_query($con, $categories_query);

                        while ($row = mysqli_fetch_assoc($categories_result)) {
                            $category_name = $row['category_name'];
                            $selected = ($category_name === $expensecategory) ? 'selected' : '';
                            echo "<option value=\"$category_name\" $selected>$category_name</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group text-center mt-4">
                <?php if ($update == true) : ?>
                    <button class="btn btn-warning btn-lg btn-block" type="submit" name="update">Update</button>
                <?php elseif ($del == true) : ?>
                    <button class="btn btn-danger btn-lg btn-block" type="submit" name="delete">Delete</button>
                <?php else : ?>
                    <button type="submit" name="add" class="btn btn-success btn-lg btn-block">Add Expense</button>
                <?php endif ?>
            </div>
        </form>
    </div>
</div>


        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
     <!-- Bootstrap core JavaScript -->
  <script src="js/jquery.slim.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/Chart.min.js"></script>    
  <script src="js/popper.min.js"></script>  
    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    <script>
        feather.replace();
    </script>
    <script>

    </script>
</body>
</html>
