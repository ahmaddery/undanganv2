<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naru-Register</title>
    <link rel="icon" href="<?= base_url('gambar/logonaru.png') ?>">
    <link rel="stylesheet" href="<?= base_url('bootstrap-5.3.2-dist/css/bootstrap.min.css') ?>">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.wrapper {
    background-color: #fff;
    border-radius: 10px;
    padding: 30px;
    width: 400px;
    text-align: center;
}

.logo img {
    width: 100px;
    height: 100px;
    margin-bottom: 20px;
}

.name {
    font-size: 24px;
    font-weight: bold;
}

.form-field {
    margin-bottom: 20px;
}

.form-field input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.btn {
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.btn:hover {
    background-color: #45a049;
}

.fs-6 {
    margin-top: 20px;
}

.fs-6 a {
    text-decoration: none;
    color: #4CAF50;
}

.fs-6 a:hover {
    color: #45a049;
}

</style>
<body>
    <div class="wrapper">
        <div class="logo">
            <img src="<?= base_url('gambar/logonaru.png') ?>" alt="">
        </div>
        <div class="text-center mt-4 name">
            Register
        </div>
        <form action="<?= base_url('auth/register') ?>" class="p-3 mt-3" method="post">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="email" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="pwd" placeholder="Password">
            </div>
            <button class="btn mt-3">Register</button>
        </form>
        <div class="text-center fs-6">
            <p href="#">Sudah punya akun ? or <a href="/login">Login</a></p> 

        </div>
    </div>
    <script src="<?= base_url('bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>
