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

$message = ""; // To store success or error messages

// Checking if the delete button is clicked
if (isset($_GET['submit'])) {
    $empid = $_GET['empid'];

    // Delete query
    $sql = "DELETE FROM employee_info WHERE id = '$empid'";

    if ($conn->query($sql) === TRUE) {
        $message = "<p style='color: green;'>Record deleted successfully!</p>";
    } else {
        $message = "<p style='color: red;'>Error deleting record: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
    <div class="emp-container">
        <h2>Delete Employee</h2>

        <!-- Display Message Separately from the Form -->
        <div style="text-align: center; margin-bottom: 20px;">
            <?php echo $message; ?>
        </div>

        <form action="delete.php" method="get" name="f1">
            <input type="number" name="empid" placeholder="Employee ID" required> 
            <input class="submit-btn" type="submit" name="submit" value="Delete">
        </form>

        <hr>
        <div class="btn-container">
            <a href="index.html"><button class="action-btn" name="add">ADD</button></a>
            <a href="display.html"><button class="action-btn" name="display">Display</button></a>
            <a href="update.html"><button class="action-btn" name="update">Update</button></a>
        </div>
    </div>
</body>
</html>
