<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot - Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        p {
            margin-bottom: 20px;
            line-height: 1.6;
            color: #666;
        }
        .buttons {
            text-align: center;
        }
        .buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-btn {
            background-color: #4CAF50;
            color: white;
        }
        .register-btn {
            background-color: #008CBA;
            color: white;
        }
        .buttons button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Our Chatbot</h1>
        <p>This is a chatbot, that allows users to regiter, login and send messages. The Messages are stored inside a log file with the sender's name and then displayed in the frontend based on the sender. There is a section that displays the list of online users too.</p>
        <p>Log in or register to start chatting!</p>
        <div class="buttons">
            <button class="login-btn" onclick="window.location.href='./public_html/login.php'">Login</button>
            <button class="register-btn" onclick="window.location.href='./public_html/register.php'">Register</button>
        </div>
    </div>
</body>
</html>
