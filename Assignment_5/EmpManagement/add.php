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

// Checking if the form is submitted
if (isset($_POST["submit"])) {
    $empid = $_POST['empid'];
    $empname = $_POST['empname'];
    $empphone = $_POST['empphone'];
    $empdep = $_POST['empdep'];
    $empemail = $_POST['empemail'];
    $empsalary = $_POST['empsalary'];

    // Check if the ID already exists in the database
    $checkSql = "SELECT * FROM employee_info WHERE id = '$empid'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        echo "<div style='text-align:center; color:red;'>Error: An employee with ID $empid already exists. Please use a unique ID.</div>";
    } else {
        // Insert query
        $sql = "INSERT INTO employee_info (id, name, phone, dep, email, salary) 
                VALUES ('$empid', '$empname', '$empphone', '$empdep', '$empemail', '$empsalary')";

        if ($conn->query($sql) === TRUE) {
            echo "<div style='text-align:center; color:green;'>Record added successfully!</div>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
