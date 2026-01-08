<?php
session_start();

$username = "admin";
$password = "123456";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['user']);
    $pass = trim($_POST['pass']);

    if ($user == "" || $pass == "") {
        $error = "Username dan Password wajib diisi!";
    } elseif ($user === $username && $pass === $password) {
        $_SESSION['username'] = $user;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-danger-subtle">

<div class="container mt-5">
<div class="col-md-4 mx-auto card p-4 rounded-4 shadow">

<h4 class="text-center">Login</h4>

<?php if ($error): ?>
<div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="post">
    <input class="form-control mb-3" name="user" placeholder="Username">
    <input class="form-control mb-3" type="password" name="pass" placeholder="Password">
    <button class="btn btn-danger w-100">Login</button>
</form>

</div>
</div>
</body>
</html>
