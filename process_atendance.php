<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "bus system";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['students']) && is_array($_POST['students'])) {
        $selectedStudents = $_POST['students'];
        foreach ($selectedStudents as $studentName) {
            $studentName = $conn->real_escape_string($studentName);
            $sql = "UPDATE attendance SET IsPresent = 1 WHERE StudentID IN (SELECT StudentID FROM students WHERE CONCAT(FirstName, ' ', LastName) = '$studentName')";
            $result = $conn->query($sql);
        }
    }

    $conn->close();
    
    header("Location: parent_dashboard.php?notification=success");
} else {
    echo "Invalid request.";
}

?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "bus system";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['students'])) {
        $selectedStudents = explode(',', $_GET['students']);
        foreach ($selectedStudents as $studentID) {
            $studentID = $conn->real_escape_string($studentID);
            $sql = "UPDATE attendance SET Status = 'Present' WHERE StudentID = '$studentID'";
            $result = $conn->query($sql);
        }
    }

    $conn->close();

    // Redirect back to supervisor_dashboard.php with success notification
    header("Location: supervisor_dashboard.php?notification=success");
} else {
    echo "Invalid request.";
}
?>
