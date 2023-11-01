<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
</head>
<body>
    <h1>User Profile</h1>
    <?php if(isset($user) && is_array($user) && count($user) > 0): ?>
        <table border="1">
            <tr>
                <th>Username</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            <tr>
                <td><?= $user['username']; ?></td>
                <td><?= $user['alamat']; ?></td>
                <td><?= $user['nohp']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><a href="/user/edit" class="btn btn-primary">Edit</a></td>
            </tr>
        </table>
    <?php else: ?>
        <p>User data not found.</p>
    <?php endif; ?>
</body>
</html>
