<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="Admin.css"> 
    <style>
        body {
            background-color: #2D9BAF;
            text-align: left;
        }

        h1 {
            font-weight: bold;
            font-size: 48px;
            margin-bottom: 20px;
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

        .route-details {
            margin-left: 20px;
        }

        .route-details h2 {
            font-weight: bold;
            font-size: 24px;
        }

        .route-details p {
            font-size: 16px;
            margin: 10px 0;
        }
    </style>
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
    <p>Selected Supervisors: 
        <?php
        session_start();
        if (isset($_POST['supervisor']) && is_array($_POST['supervisor'])) {
            $_SESSION['selected_supervisors'][] = $_POST['supervisor'];
        }

        if (isset($_POST['bus'])) {
            $_SESSION['selected_buses'][] = $_POST['bus'];
        }

        if (isset($_SESSION['selected_supervisors']) && is_array($_SESSION['selected_supervisors'])) {
            foreach ($_SESSION['selected_supervisors'] as $attempt => $selectedSupervisors) {
                echo "LIST " . ($attempt + 1) . ": " . implode(', ', $selectedSupervisors) . "<br>";
            }
        } else {
            echo "None selected";
        }
        ?>
    </p>
    <p>Selected Buses: 
        <?php
        if (isset($_SESSION['selected_buses'])) {
            foreach ($_SESSION['selected_buses'] as $attempt => $selectedBus) {
                echo "LIST " . ($attempt + 1) . ": " . $selectedBus . "<br>";
            }
        } else {
            echo "None selected";
        }
        ?>
    </p>
    </div>
    <div class="button-container">
        <a href="reset.php" class="reset-button">Reset</a>
    </div>
</body>
</html>
