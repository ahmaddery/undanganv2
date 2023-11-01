<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form action="/profile/update" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?= $user['username']; ?>"><br><br>

        <label for="alamat">Alamat:</label><br>
        <input type="text" id="alamat" name="alamat" value="<?= $user['alamat']; ?>"><br><br>

        <label for="nohp">No HP:</label><br>
        <input type="text" id="nohp" name="nohp" value="<?= $user['nohp']; ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" value="<?= $user['email']; ?>"><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" placeholder="Password"><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>
