<?php

include 'connect.php';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM users WHERE username = ?";
try {
    $query = $conn->prepare($sql);
    $query->execute([$username]);
}
catch (PDOException $e) {
    $conn = null;
    $query = null;
    die("Virhe: " . $e->getMessage());
}
$user = $query->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $sql = "SELECT * FROM users;";
    try {
        $query = $conn->prepare($sql);
        $query->execute();
    }
    catch (PDOException $e) {
        $conn = null;
        $query = null;
        die("Virhe: " . $e->getMessage());
    }
    $users = $query->fetchAll();
    $conn = null;
    $query = null;
    session_start();
    $_SESSION['user'] = $user;
    $_SESSION['users'] = $users;
    session_regenerate_id(True);
    header('Location: home.php');
    // exit;
} else {
    header('Location: index.php');
}
?>