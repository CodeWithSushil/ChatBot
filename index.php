<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP Chatbot</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        #chat { width: 300px; margin: auto; border: 1px solid #ddd; padding: 10px; }
        .message { padding: 5px; border-bottom: 1px solid #ddd;}
    </style>
</head>
<body>
    <h2>PHP AI Chatbot</h2>
    <div id="chat">
        <div id="chatbox"></div>
        <input type="hidden" id="previousMessage">
        <input type="text" id="message" placeholder="Type a message">
        <button onclick="sendMessage()">Send</button>
    </div>

    <script>
      function sendMessage() {
    let message = document.getElementById("message").value;
    let previousMessage = document.getElementById("previousMessage").value;

    if (!message) return;

    let chatbox = document.getElementById("chatbox");
    chatbox.innerHTML += `<div class="message"><strong>You:</strong> ${message}</div>`;

    fetch('chatbot.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `message=${encodeURIComponent(message)}&previousMessage=${encodeURIComponent(previousMessage)}`
    })
    .then(response => response.text())
    .then(data => {
        chatbox.innerHTML += `<div class="message"><strong>Bot:</strong> ${data}</div>`;
        document.getElementById("previousMessage").value = message;
    });

    document.getElementById("message").value = "";
}
    </script>
</body>
</html>
