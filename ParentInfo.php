<!DOCTYPE html>
<html lang="en">
<head>
   
</head>
<body style="background-color: #2D9BAF;">
    <h1>Admin</h1>
    <div class="info-container">
        <div class="home-page"><a href="Admin.php">Home page</a></div>
        <div class="current-routes"><a href="currentroutes.php">Current Routes</a></div>
        <div class="parent-info"><a href="parentinfo.php">Parent Information</a></div>
        <div class="student-info"><a href="studentinfo.php">Student Information</a></div>
        <div class="supervisor-info"><a href="supervisorinfo.php">Supervisor Information</a></div>
    </div> 
    <style>
body {
    background-color: #2D9BAF;
    text-align: center;
}

h1 {
    font-weight: bold;
    font-size: 48px;
    font-family: cambria; 
    margin-bottom: 20px;
    text-align: center;
}

.info-container {
    display: flex;
    justify-content: space-between;
    padding: 10px;
}

.info-container a {
    text-decoration: none;
    background-color: #fff;
    font-weight: bold;
    font-size: 20px;
    color: black;
    transition: color 0.3s ease;
    padding: 10px 20px;
    border: 1px solid #333;
    border-radius: 5px;
}

.info-container a:hover {
    color: #555;
    background-color: #2D9BAF;
    border-color: #555;
}

.parent-info a,
.student-info a,
.supervisor-info a,
.current-routes a,
.home-page a {
    text-decoration: none;
    font-weight: bold;
    font-size: 20px;
    color: #333;
    transition: color 0.3s ease;
    margin-right: 20px;
}

.parent-info a:hover,
.student-info a:hover,
.supervisor-info a:hover,
.current-routes a:hover,
.home-page a:hover {
    color: #555;
    cursor: pointer;
}

table {
    border-collapse: collapse;
    width: 80%;
    margin: 20px auto;
    text-align: center;
}

th, td {
    border: 1px solid white;
    padding: 8px;
    text-align: left;
    color: white;
}

th {
    background-color: #2D9BAF;
}

tr:nth-child(even) {
    background-color: #467C8B;
}

tr:nth-child(odd) {
    background-color: #356977;
}
</style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ParentID</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Username</th>
                <th>StudentID</th>
                <th>Destination</th>
            </tr>
        </thead>
        <tbody>
        <?php
            include "db_connection.php";
            $conn = mysqli_connect($sname, $uname, $password, $db_name);
            if (!$conn) {
                echo "Connection failed: " . mysqli_connect_error();
            }
            $sql = "SELECT ParentID,FirstName, LastName, Email, Phone, Username, StudentID ,Destination FROM Parents";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ParentID"] . "</td>";
                    echo "<td>" . $row["FirstName"] . "</td>";
                    echo "<td>" . $row["LastName"] . "</td>";
                    echo "<td>" . $row["Email"] . "</td>";
                    echo "<td>" . $row["Phone"] . "</td>";
                    echo "<td>" . $row["Username"] . "</td>";
                    echo "<td>" . $row["StudentID"] . "</td>";
                    echo "<td>" . $row["Destination"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No parent records found</td></tr>";
            }
            $conn->close();
        ?>

        </tbody>
    </table>
  
    <div class="input-fields">
        <input type="text" placeholder="ParentID">
        <input type="text" placeholder="FirstName">
        <input type="text" placeholder="LastName">
        <input type="text" placeholder="Email">
        <input type="text" placeholder="Phone">
        <input type="text" placeholder="Username">
        <input type="text" placeholder="StudentID">
        <input type="text" placeholder="Destination">
    </div>
</body>
</html>