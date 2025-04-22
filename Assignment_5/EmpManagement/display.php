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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Records</title>
    <link rel="stylesheet" href="./css/index.css">
    <style>
        .table-container {
            width: 90%;
            margin: 20px auto;
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: white;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }
        .action-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .action-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Employee Records</h2>
        
        <?php
        // Fetching data from the database
        $sql = "SELECT * FROM employee_info";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Phone</th><th>Department</th><th>Email</th><th>Salary</th></tr>";

            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["phone"] . "</td>
                        <td>" . $row["dep"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["salary"] . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='text-align: center;'>No records found.</p>";
        }

        $conn->close();
        ?>

        <div class="btn-container">
            <a href="index.html"><button class="action-btn">ADD</button></a>
            <a href="update.html"><button class="action-btn">Update</button></a>
            <a href="delete.html"><button class="action-btn">Delete</button></a>
        </div>
    </div>
</body>
</html>
