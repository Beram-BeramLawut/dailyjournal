<?php
include "koneksi.php";  

// 1. Ambil data user berdasarkan session
$username = $_SESSION['username'];

// Query data user
$sql = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    $id = $data['id']; 
} else {
    die("Error: User tidak ditemukan.");
}

// 2. Logika Update Data
if (isset($_POST['simpan'])) {
    $password_baru = $_POST['password'];
    $foto_baru = $_FILES['foto']['name'];
    
    // Update Password
    if (!empty($password_baru)) {
        $password_md5 = md5($password_baru); 
        $sql_pass = "UPDATE user SET password = '$password_md5' WHERE id = '$id'";
        $conn->query($sql_pass);
    }

    // Update Foto
    if (!empty($foto_baru)) {
        $folder_tujuan = "img/";
        $nama_file_unik = date('dmYHis') . "_" . $foto_baru; 
        $target_file = $folder_tujuan . $nama_file_unik;
        $tmp_file = $_FILES['foto']['tmp_name'];

        if (move_uploaded_file($tmp_file, $target_file)) {
            $sql_foto = "UPDATE user SET foto = '$nama_file_unik' WHERE id = '$id'";
            $conn->query($sql_foto);
        } else {
            echo "<script>alert('Gagal upload foto.');</script>";
        }
    }

    echo "<script>
            alert('Profil berhasil diperbarui!');
            document.location='admin.php?page=profile';
          </script>";
}
?>

<div class="card shadow-sm border-danger">
    <div class="card-header bg-danger-subtle fw-bold">
        Pengaturan Profil
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Username</label>
                <input type="text" class="form-control" id="username" name="username" 
                       value="<?= $data['username'] ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-bold">Ganti Password</label>
                <input type="password" class="form-control" id="password" name="password" 
                       placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label fw-bold">Ganti Foto Profil</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>

            <div class="mb-3"> <label class="form-label d-block fw-bold">Foto Profil Saat Ini</label>
                <?php 
                    if ($data['foto'] != "" && file_exists("img/" . $data['foto'])) {
                        // rounded-circle DIHAPUS agar kotak
                        echo "<img src='img/$data[foto]' width='150' class='img-thumbnail'>";
                    } else {
                        // rounded-circle DIHAPUS agar kotak
                        echo "<img src='https://via.placeholder.com/150' width='150' class='img-thumbnail' alt='No Photo'>";
                    }
                ?>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" name="simpan">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
