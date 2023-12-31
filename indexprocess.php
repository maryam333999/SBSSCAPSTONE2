<?php
include "db_connection.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $user = validate($_POST['username']);
    $pass = validate($_POST['password']);

    if (empty($user) || empty($pass)) {
        header("Location: index.php?error=Invalid credentials");
        exit();
    } else {

        $hashed_pass= SHA1($pass);

        $sql = "SELECT * FROM Users WHERE Username='$user' AND Password='$hashed_pass'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {

                $row = mysqli_fetch_assoc($result);
                $role = $row["Role"]; 

                
                if ($role == "Admin") {
                    header("Location: admin.php");
                } elseif ($role == "Parent") {
                    header("Location: Parent.php");
                } elseif ($role == "Supervisor") {
                    header("Location: supervisor.php");
                } else {
                    // Unknown role
                    header("Location: index.php");
                }

                exit();
            } else {
                header("Location: index.php?error=Invalid credentials");
                exit();
            }
        } else {
            header("Location: index.php?error=Database error");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>