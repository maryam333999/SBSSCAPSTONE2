<?php
session_start();


if (isset($_POST['alertMessage'])) {
    $alertMessage = $_POST['alertMessage'];

    if (!isset($_SESSION['alerts'])) {
        $_SESSION['alerts'] = [];
    }

    $_SESSION['alerts'][] = [
        'message' => $alertMessage,
        'timestamp' => time() 
    ];
}


function calculateTimeAgo($timeDifference) {
    if ($timeDifference < 60) {
        return "$timeDifference seconds";
    } elseif ($timeDifference >= 60 && $timeDifference < 3600) {
        return round($timeDifference / 60) . " minutes";
    } else {
        return round($timeDifference / 3600) . " hours";
    }
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2D9BAF;
            color: white;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            color: black;
        }

        h2 {
            color: black;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        #map {
            width: 100%;
            height: 300px;
        }

        li {
            color: black;
            padding: 5px;
            font-weight: bold;
        }

            .chat-box {
            position: fixed;
            bottom: 20px;
            right: 20px;
            border: 1px solid #ccc;
            background-color: #f4f4f4;
            width: 250px;
            max-height: 300px;
            overflow-y: auto;
            border-radius: 10px; /* Make the border round */
        }
        .chat-input {
            width: 70%;
            margin: 10px;
            padding: 5px;
            border-radius: 5px;
        }
        .send-button {
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Parent Dashboard</h1>

        <h2>Alerts</h2>
        <div id="alerts">
            <?php
            if (isset($_SESSION['alerts'])) {
                $currentTimestamp = time();

                foreach ($_SESSION['alerts'] as $alert) {
                    $alertMessage = $alert['message'];
                    $alertTimestamp = $alert['timestamp'];

                    // Calculate time difference from the current time
                    $timeDifference = $currentTimestamp - $alertTimestamp;
                    $timeAgo = calculateTimeAgo($timeDifference);

                    echo "<div style='color: black;'>
                            <p>$alertMessage - $timeAgo ago</p>
                          </div>";
                }
            }
            ?>
        </div>

           <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <button type="submit" name="clearAlerts" style="font-size: small;">Clear</button>
    </form>
        
        <div id="map"></div>
        <script>
            function initMap() {
                var busLocation = { lat: 24.3459, lng: 54.5312 };
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 14,
                    center: busLocation
                });
                var marker = new google.maps.Marker({
                    position: busLocation,
                    map: map
                });
            }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDN4JRRwb1VwDAeE1RtKqmoLglo_7elzo4&callback=initMap"></script>

        <h2>Attendance Status</h2>
        <ul id="attendanceStatus">
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "bus system";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT CONCAT(FirstName, ' ', LastName) AS StudentName, Status FROM students LEFT JOIN attendance ON students.StudentID = attendance.StudentID";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $studentName = $row['StudentName'];
                    $status = $row['Status'];
                    echo "<li>$studentName is $status</li>";
                }
            } else {
                echo "No attendance records found.";
            }

            $conn->close();
            ?>
        </ul>

        <form action="process_attendance.php" method="post">
         
        </form>
    </div>
 
    <div id="navigation" style="width:auto;margin:auto;">
        <p style="padding:10px; text-align: right; color: blue; font-size: 16px; font-family: Arial; font-weight: bold;">
            &nbsp;&nbsp;
            <a href="login.php">Logout</a>
        </p>
    </div>
       <div class="chat-box" style="position: fixed; bottom: 20px; right: 20px; border: 1px solid #ccc;">
        <h3 style="text-align: center; margin: 0;">Parent Chat</h3>
        <div id="parentMessages" style="padding: 10px;"></div>
        <input type="text" id="parentMessage" class="chat-input" placeholder="Type a message...">
        <button onclick="sendParentMessage()" class="send-button">Send</button>
    </div>
    </div>

   <script>
    function sendChatMessage(message) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "chat_handler.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("message=" + message);
}

function getChatMessages() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var messages = xhr.responseText;
                // Process received messages and display in the chat box
                // Update the chat box with the received messages
            }
        }
    };
    xhr.open("GET", "chat_handler.php", true);
    xhr.send();
}

        function sendParentMessage() {
            var parentMessage = document.getElementById("parentMessage").value;
            var parentMessages = document.getElementById("parentMessages");

            // Simulating sending a message to the supervisor
            parentMessages.innerHTML += `<p style="color: green; margin: 5px 0;">Parent: ${parentMessage}</p>`;
            document.getElementById("parentMessage").value = ""; // Clear input field after sending message
        }
    </script>
</body>
</html>
