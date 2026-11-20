<?php

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $realname = trim($_POST['realname'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $realname !== '' && $password !== '') {
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = $conn->prepare(
            'INSERT INTO users (username, realname, password) VALUES (?, ?, ?)'
        );
        $query->execute([$username, $realname, $password]);

        echo 'Uusi käyttäjä lisätty!';
    }
}
?>

<form method="post">
    <label>Käyttäjänimi:</label>
    <input name="username" required><br>

    <label>Oikea nimi:</label>
    <input name="realname" required><br>

    <label>Salasana:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Lisää käyttäjä</button>
</form>