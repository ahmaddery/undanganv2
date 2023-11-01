<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>
    <link rel="icon" href="<?= base_url('gambar/logonaru.png') ?>">
 

    <style>
body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f4f4f4;
}

.forgot-container {
    background-color: #fff;
    border-radius: 10px;
    padding: 30px;
    width: 400px;
    text-align: center;
}

h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}

.message {
    margin-top: 20px;
}

.error-message {
    color: red;
}

.success-message {
    color: green;
}

form {
    margin-top: 20px;
}

form div {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="email"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

    </style>
</head>

<body>
    <div class="forgot-container">
        <h2>Forgot Password</h2>
        <?php if (session()->getFlashdata('error')) : ?>
            <div class="message">
                <p class="error-message"><?= session()->getFlashdata('error') ?></p>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')) : ?>
            <div class="message">
                <p class="success-message"><?= session()->getFlashdata('success') ?></p>
            </div>
        <?php endif; ?>
        <form action="/auth/forgotPassword" method="post">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Send Reset Code</button>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successAlert = document.querySelector('.success-message');
            if (successAlert) {
                successAlert.style.display = 'block';
                setTimeout(function() {
                    window.location.replace('/login');
                }, 5000); // Delay 5 detik sebelum pengalihan
            }
        });
    </script>
</body>

</html>
