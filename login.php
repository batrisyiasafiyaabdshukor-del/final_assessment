

<?php
session_start();
include "db.php";

$error = "";

// If already logged in, go to records
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// When Login button is clicked
if (isset($_POST['login'])) {

    $username = trim($_POST['username'] ?? "");
    $password = $_POST['password'] ?? "";

    // Check username in database
    $sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $sql->bind_param("s", $username);
    $sql->execute();

    $row = $sql->get_result()->fetch_assoc();

    // Verify password
    if ($row && password_verify($password, $row['password_hash'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];

        header("Location: index.php");
        exit();

    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Student Grading System</title>
</head>
<body>

<h1>Student Grading System</h1>
<h2>Admin Login</h2>

<?php
if ($error != "") {
    echo "<p style='color:red;'>" . htmlspecialchars($error) . "</p>";
}
?>

<form method="post">

    <label>Username</label>
    <input type="text" name="username" required>
    <br><br>

    <label>Password</label>
    <input type="password" name="password" required>
    <br><br>

    <input type="submit" name="login" value="Login">

</form>

</body>
</html>
