<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Landing Page</title>
    <style>


body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    text-align: center;
    margin: 20% auto;
    max-width: 400px;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #333;
}

p {
    color: #666;
}

.btn {
    display: inline-block;
    text-align: center;
    padding: 10px 20px;
    margin: 10px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
}

.login {
    background-color: #3498db;
    color: #fff;
}

.register {
    background-color: #27ae60;
    color: #fff;
}



    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Our Website</h1>
        <p>Explore our amazing platform. Join us today!</p>
        <div class="buttons">
            <a href="/login" class="btn login">Login</a>
            <a href="/register" class="btn register">Register</a>
        </div>
    </div>
</body>
</html>
