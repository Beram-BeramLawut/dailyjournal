<?php
// Memulai session
session_start();

// Menyertakan code dari file koneksi
include "koneksi.php";

if (isset($_SESSION['username'])) {
    header("location:admin.php");
    exit;
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userInput = $_POST['user'];
    $passInput = $_POST['pass'];

    if (empty($userInput) || empty($passInput)) {
        $error_message = "Username dan Password tidak boleh kosong!";
    } else {
        $username = $userInput;
        $password = md5($passInput); 

        $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND password=?");
        
        $stmt->bind_param("ss", $username, $password);
      
        $stmt->execute();
        
        $hasil = $stmt->get_result();
        $row = $hasil->fetch_array(MYSQLI_ASSOC);

        if (!empty($row)) {

            $_SESSION['username'] = $row['username']; 
            header("location:admin.php");
            exit; 
        } else {
            $error_message = "Username atau password salah!";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | My Daily Journal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
    <link rel="icon" href="img/logo.png" />
</head>
<body class="bg-danger-subtle">

    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 m-auto">
                <div class="card border-0 shadow rounded-5">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="bi bi-person-circle h1 display-4"></i>
                            <p>My Daily Journal</p>
                            <hr />
                        </div>
                        
                        <?php if (!empty($error_message)): ?>
                            <div class="alert alert-danger text-center">
                                <?= $error_message; ?>
                            </div>
                        <?php endif; ?>

                        <form action="" method="post" id="loginform">
                            <input type="text" name="user" id="user" class="form-control my-4 py-2 rounded-4" placeholder="Username" value="<?= isset($_POST['user']) ? htmlspecialchars($_POST['user']) : '' ?>" />
                            <input type="password" name="pass" id="pass" class="form-control my-4 py-2 rounded-4" placeholder="Password" />
                            <div class="text-center my-3 d-grid">
                                <button class="btn btn-danger rounded-4">Login</button>
                            </div>
                            <p id="jsErrorMsg" class="text-danger"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("loginform").addEventListener("submit", function(event) {
            const user = document.getElementById("user").value.trim();
            const pass = document.getElementById("pass").value.trim();
            const errorMsg = document.getElementById("jsErrorMsg");

            errorMsg.textContent = "";

            if (user === "") {
                errorMsg.textContent = "Username tidak boleh kosong!";
                event.preventDefault();
                return;
            }

            if (pass === "") {
                errorMsg.textContent = "Password tidak boleh kosong!";
                event.preventDefault();
                return;
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
