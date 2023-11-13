

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Supervisor Dashboard</title>
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

        li {
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
        }

        #map {
            width: 100%;
            height: 300px;
        }

        .submit-button {
            font-weight: bold;
            font-size: 18px;
            font-family: Arial, sans-serif;
            padding: 8px 16px;
            border: 2px solid #333;
            background-color: transparent;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #555;
            color: #fff;
            border-color: #555;
        }

        /* Center the submit button */
        .button-container {
            text-align: center;
        }

        .alert-button {
    border-radius: 50%; 
    background-color: red; 
    border: 2px solid red; 
    color: white; 
    font-size: 18px;
    padding: 20px 16px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    margin-top: 10px;
    margin-right: 500px;


}

.alert-button:hover {
    background-color: darkred; /* Change background color on hover */
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
        <h1>Bus Supervisor Dashboard</h1>
        <div id="map"></div>
        <script>
            // Google Maps integration
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

   
        
<p style="color: black; font-weight: bold; border: 1px solid #000; padding: 10px; border-radius: 5px;">Selected Supervisors: 
    <?php
    session_start();
    if (isset($_SESSION['selected_supervisors']) && is_array($_SESSION['selected_supervisors'])) {
        foreach ($_SESSION['selected_supervisors'] as $attempt => $selectedSupervisors) {
            echo "LIST " . ($attempt + 1) . ": " . implode(', ', $selectedSupervisors) . "<br>";
        }
    } else {
        echo "None selected";
    }
    ?>
</p>

<p style="color: black; font-weight: bold; border: 1px solid #000; padding: 10px; border-radius: 5px;">Selected Buses: 
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
<ul>
    <?php
    // Database connection
    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $database = "BUS SYSTEM"; 

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT StudentID, FirstName, LastName FROM Students"; 
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $StudentID = $row['StudentID'];
            $FirstName = $row['FirstName'];
            $LastName = $row['LastName'];
            echo "<li>
                    <input type='checkbox' id='$StudentID' name='students[]' value='$StudentID' onchange='handleCheckboxChange(\"$StudentID\", this.checked)'>
                    <label for='$StudentID' style='color: black;'>$FirstName $LastName ($StudentID)</label>
                </li>";
        }
    } else {
        echo "No students found in the database.";
    }

    $conn->close();
    ?>
</ul>

<script>
    var selectedStudents = [];

    function handleCheckboxChange(studentID, isChecked) {
        if (isChecked) {
            if (!selectedStudents.includes(studentID)) {
                selectedStudents.push(studentID);
            }
        } else {
            var index = selectedStudents.indexOf(studentID);
            if (index !== -1) {
                selectedStudents.splice(index, 1);
            }
        }
    }

    function submitAttendance() {
        window.location.href = 'process_attendance.php?students=' + selectedStudents.join(',');
    }
</script>

        <div id="navigation" style="width:auto;margin:auto;">
            <p style="
                padding:10px;
                text-align: right;
                color: blue;
                font-size: 16px;
                font-family: Arial;
                font-weight: bold;
            ">
            &nbsp;&nbsp;
            <a href="login.php">Logout</a>
            </p>
        </div>
    


        <div class="button-container">
            <button class="submit-button" onclick="redirectToParent()">Submit Attendance</button>
        </div>

           <div class="button-container">
    <button class="submit-button alert-button" onclick="showAlert()">Alert</button>
</div>
        <script>
            function redirectToParent() {
                window.location.href = 'Parent.php';
            }

        
        </script>
      
       
        <div class="chat-box" style="position: fixed; bottom: 20px; right: 20px; border: 1px solid #ccc; >
            <h3 style= "text-align: center; margin: 0;>Parent Chat</h3>
            <div id="supervisorMessages" style="padding: 10px;"></div>
            <input type="text" id="supervisorMessage" style="width: 70%; margin: 10px; padding: 5px;" placeholder="Type a message...">
            <button onclick="sendsupervisorMessage()" style="padding: 5px;">Send</button>
        </div>
    </div>

    <script>
        function sendsupervisorMessage() {
            var supervisorMessage = document.getElementById("supervisorMessage").value;
            var supervisortMessages = document.getElementById("parentMessages");

            // Simulating sending a message to the supervisor
            supervisorMessages.innerHTML += `<p style="color: green; margin: 5px 0;">supervisor: ${supervisorMessage}</p>`;
            document.getElementById("supervisorMessage").value = ""; // Clear input field after sending message
        }
    </script>


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

    function showAlert() {
        var message = "Alert to check message";

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "parent.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("alertMessage=" + message);

        alert("Alert sent to parent!");
    }
</script>
   </body>
</html>
