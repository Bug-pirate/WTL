<?php
// Database connection details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "tyb"; // Make sure your database name is correct

// Creating a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Checking the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$empid = "";
$empname = "";
$empphone = "";
$empdep = "";
$empemail = "";
$empsalary = "";
$message = ""; // To store success or error messages

// Check if empid is provided for fetching data
if (isset($_GET['empid'])) {
    $empid = $_GET['empid'];

    // Fetching data for the given empid
    $sql = "SELECT * FROM employee_info WHERE id = '$empid'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $empname = $row['name'];
        $empphone = $row['phone'];
        $empdep = $row['dep'];
        $empemail = $row['email'];
        $empsalary = $row['salary'];
    } else {
        $message = "<p style='color: red;'>Employee with ID $empid not found.</p>";
    }
}

// Updating record when the form is submitted
if (isset($_POST['update'])) {
    $empid = $_POST['empid'];
    $empname = $_POST['empname'];
    $empphone = $_POST['empphone'];
    $empdep = $_POST['empdep'];
    $empemail = $_POST['empemail'];
    $empsalary = $_POST['empsalary'];

    // Update query with correct column names
    $sql = "UPDATE employee_info 
            SET name='$empname', phone='$empphone', dep='$empdep', email='$empemail', salary='$empsalary' 
            WHERE id='$empid'";

    if ($conn->query($sql) === TRUE) {
        $message = "<p style='color: green;'>Record updated successfully!</p>";
    } else {
        $message = "<p style='color: red;'>Error updating record: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <div class="emp-container">
        <h2>Update Employee</h2>
        
        <!-- Display Message Separately from the Form -->
        <div style="text-align: center; margin-bottom: 20px;">
            <?php echo $message; ?>
        </div>

        <form action="update.php" method="post">
            <input type="hidden" name="empid" value="<?php echo $empid; ?>"> 
            <input type="text" name="empname" value="<?php echo $empname; ?>" placeholder="Employee Name">
            <input type="number" name="empphone" value="<?php echo $empphone; ?>" placeholder="Employee Phone No.">
            <input type="text" name="empdep" value="<?php echo $empdep; ?>" placeholder="Employee Department Name">
            <input type="text" name="empemail" value="<?php echo $empemail; ?>" placeholder="Employee Email">
            <input type="number" name="empsalary" value="<?php echo $empsalary; ?>" placeholder="Employee Salary">
            <input class="submit-btn" type="submit" name="update" value="Update">
        </form>

        <hr>
        <div class="btn-container">
            <a href="index.html"><button class="action-btn">ADD</button></a>
            <a href="display.html"><button class="action-btn">Display</button></a>
            <a href="delete.html"><button class="action-btn">Delete</button></a>
        </div>
    </div>
</body>
</html>
