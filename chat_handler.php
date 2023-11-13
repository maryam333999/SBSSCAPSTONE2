<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    // Handle incoming messages
    $message = $_POST['message'];

    // Store the message in a session variable, database, or other storage mechanism
    // For example, in the $_SESSION variable

    if (!isset($_SESSION['chat_messages'])) {
        $_SESSION['chat_messages'] = [];
    }

    $_SESSION['chat_messages'][] = [
        'message' => $message,
        'timestamp' => time()
    ];
}

// Retrieve and send back the messages
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['chat_messages'])) {
        echo json_encode($_SESSION['chat_messages']);
    } else {
        echo json_encode([]);
    }
}
?>
