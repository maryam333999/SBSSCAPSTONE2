<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Admin.css"> 
<script>
        function resetForm() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            
            var busDropdown = document.getElementById("bus");
            busDropdown.selectedIndex = 0; 
        }
    </script>
</head>
<body>
    <h1>Admin</h1>
    <div class="info-container">
        <div class="home-page"><a href="Admin.php">Home page</a></div>
        <div class="current-routes"><a href="currentroutes.php">Current Routes</a></div>
        <div class="parent-info"><a href="parentinfo.php">Parent Information</a></div>
        <div class="student-info"><a href="studentinfo.php">Student Information</a></div>
        <div class="supervisor-info"><a href="supervisorinfo.php">Supervisor Information</a></div>
    </div> 
     <form action="currentroutes.php" method="post">
        <div class="prepare-trip">
            <h2>Prepare trip</h2>
            <div class="supervisor-list">
                <label for="supervisor" style="font-size: 19px; font-weight: bold; color: black; font-family: sans-serif">Choose Supervisor:</label>
                <div class="supervisor-list-scroll">
                    <?php
                  
                    $mysqli = new mysqli("localhost", "root", "", "BUS SYSTEM");

                    if ($mysqli->connect_error) {
                        die("Connection failed: " . $mysqli->connect_error);
                    }

                    $sql = "SELECT `SupervisorID`, `FirstName` FROM `Supervisor`";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<label class="supervisor-checkbox">';
                            echo "<input type='checkbox' name='supervisor[]' value='" . $row["SupervisorID"] . "'>";
                            echo '<span class="checkmark-supervisor"></span>';
                            echo '<div class="supervisor-name">' . $row["FirstName"] . '</div>';
                            echo '</label>';
                        }
                    }

                    $mysqli->close();
                    ?>
               
            </div>

            <div class="dropdown">
                <label for="bus">Choose Bus:</label>
                <select id="bus" name="bus"> <!-- Add name attribute -->
                    <option value="bus1">Choose Bus</option>
                    <?php
                 
                    $mysqli = new mysqli("localhost", "root", "", "BUS SYSTEM");

                  
                    if ($mysqli->connect_error) {
                        die("Connection failed: " . $mysqli->connect_error);
                    }

                    $sql = "SELECT `BusID` FROM `Buses`";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["BusID"] . "'>" . $row["BusID"] . "</option>";
                        }
                    }

                    
                    $mysqli->close();
                    ?>
                </select>
            </div>
            
            <div class="button-container">
                <button class="submit-button" type="submit">Submit</button>
                <button class="reset-button" type="button" onclick="resetForm()">Reset</button>
            </div>
        </div>
         </div>
                        <div id="navigation" style="width:auto;margin:auto;">
            <P style="
                padding:10px;
                text-align: right;
                color: blue;
                font-size: 16px;
                font-family: Arial;
                font-weight: bold;

            ">
            &nbsp;&nbsp;
             <A HREF="login.php">Logout</A>
            </P>
        </div>
    </form> 

<?php
if( empty(session_id()) && !headers_sent()){
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if (isset($_POST['supervisor']) && is_array($_POST['supervisor'])) {
        if (!isset($_SESSION['selected_supervisors'])) {
            $_SESSION['selected_supervisors'] = array();
        }
        $_SESSION['selected_supervisors'][] = $_POST['supervisor'];
    }

    if (isset($_POST['bus'])) {
        if (!isset($_SESSION['selected_buses'])) {
            $_SESSION['selected_buses'] = array();
        }
        $_SESSION['selected_buses'][] = $_POST['bus'];
    }

    
    header("Location: currentroutes.php");
    exit();
}
?>


</body>
</html>


