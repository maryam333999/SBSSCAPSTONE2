<!DOCTYPE html>
<html lang="en">
<head>

</head>
<body style="background-color: #2D9BAF;"> <!-- Set background color for the body -->
    <h1>Admin</h1>
    <div class="info-container">
        <div class="home-page"><a href="Admin.php">Home page</a></div>
        <div class="current-routes"><a href="currentroutes.php">Current Routes</a></div>
        <div class="parent-info"><a href="parentinfo.php">Parent Information</a></div>
        <div class="student-info"><a href="studentinfo.php">Student Information</a></div>
        <div class="supervisor-info"><a href="supervisorinfo.php">Supervisor Information</a></div>
    </div> 
    <style>
body{
    background-color: #2D9BAF;
    text-align: center; /* Center-align text within the body */
}

h1 {
    font-weight: bold; /* Make the text bold */
    font-size: 48px; /* Increase the font size to 48 pixels (adjust as needed) */
    font-family: cambria; 
    margin-bottom: 20px; /* Add some spacing below the h1 */
    text-align: center; /* Center-align the h1 element */
}

.info-container {
    display: flex;
    justify-content: space-between; /* Add space between boxes */
    padding: 10px; /* Add padding to the container */
}

.info-container a {
    text-decoration: none;
    background-color: #fff;
    font-weight: bold;
    font-size: 20px;
    color: black; /* Adjust text color */
    transition: color 0.3s ease;
    padding: 10px 20px; /* Add padding to each box */
    border: 1px solid #333; /* Add a border to each box */
    border-radius: 5px; /* Add rounded corners */
}

.info-container a:hover {
    color: #555;
    background-color: #2D9BAF; /* Change background color on hover */
    border-color: #555; /* Change border color on hover */
}


.parent-info a,
.student-info a,
.supervisor-info a ,
.current-routes a,
.home-page a {
    text-decoration: none;
    font-weight: bold;
    font-size: 20px; /* Adjust the font size as needed */
    color: #333; /* Initial text color */
    transition: color 0.3s ease; /* Smooth transition for text color */
    margin-right: 20px; /* Add margin to create spacing between elements */
}

.parent-info a:hover,
.student-info a:hover,
.supervisor-info a:hover,
.current-routes a:hover ,
.home-page a:hover {
    color: #555; /* Brighten the text color on hover */
    cursor: pointer; /* Change cursor to indicate clickability */
}
        table {
            border-collapse: collapse; /* Collapse borders for the table */
            width: 80%; /* Set the table width */
            margin: 20px auto; /* Center-align the table */
                text-align: center; /* Center-align text within the body */
        }

        th, td {
            border: 1px solid white; /* White border for table cells */
            padding: 8px; /* Add padding to cells */
            text-align: left; /* Left-align text in cells */
            color: white; /* Text color for table content */
        }

        th {
            background-color: #2D9BAF; /* Background color for table headers */
        }

        tr:nth-child(even) {
            background-color: #467C8B; /* Background color for even rows */
        }

        tr:nth-child(odd) {
            background-color: #356977; /* Background color for odd rows */
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>SupervisorID</th>
                <th>FirstName</th>
                <th>UserID</th>
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
        <?php
            
            include "db_connection.php";

            $conn = mysqli_connect($sname, $uname, $password, $db_name);

            if (!$conn) {
                echo "Connection failed: " . mysqli_connect_error();
            }

            $sql = "SELECT SupervisorID, FirstName, UserID, Username FROM Supervisor";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["SupervisorID"] . "</td>";
                    echo "<td>" . $row["FirstName"] . "</td>";
                    echo "<td>" . $row["UserID"] . "</td>";
                    echo "<td>" . $row["Username"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No parent records found</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
</body>
</html>

   

