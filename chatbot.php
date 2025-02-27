<?php

define("DB_FILE", "chatbot.json");

// Load chat history
function loadDatabase() {
    return file_exists(DB_FILE) ? json_decode(file_get_contents(DB_FILE), true) : [];
}

// Save chat history
function saveDatabase($data) {
    file_put_contents(DB_FILE, json_encode($data, JSON_PRETTY_PRINT));
}

// Generate a response
function chatbotResponse($userMessage) {
  $database = loadDatabase();
    
    // Check if response exists
    if (isset($database[$userMessage])) {
     return $database[$userMessage];
    }

    // Learn new response
    $defaultResponse = "I don't know that yet. Can you teach me? (reply with: learn [your response])";
    return $defaultResponse;
}

// Learning feature
function learnNewResponse($userMessage) {
    $parts = explode("learn ", $userMessage);
    if (count($parts) > 1) {
        $database = loadDatabase();
        $newResponse = trim($parts[1]);
        $database[$_POST["previousMessage"]] = $newResponse;
        saveDatabase($database);
        return "Got it! I learned a new response.";
    }
    return null;
}

// Handle user input
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userMessage = strtolower(trim($_POST["message"]));
    $previousMessage = $_POST["previousMessage"] ?? "";

    if (strpos($userMessage, "learn ") === 0) {
        echo learnNewResponse($userMessage);
    } else {
        echo chatbotResponse($userMessage);
    }
}
?>
