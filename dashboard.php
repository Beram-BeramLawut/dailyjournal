<?php
// 1. PENTING: Panggil koneksi agar variabel $conn dikenali
include "koneksi.php";

// 2. Query untuk mengambil data Artikel
$sql_article = "SELECT * FROM article";
$result_article = $conn->query($sql_article);
$jumlah_article = $result_article->num_rows; // Hitung jumlah baris

// 3. Query untuk mengambil data Gallery
$sql_gallery = "SELECT * FROM gallery";
$result_gallery = $conn->query($sql_gallery);
$jumlah_gallery = $result_gallery->num_rows; // Hitung jumlah baris

// 4. Cek Session untuk Profile
// Session biasanya sudah start di admin.php, tapi untuk keamanan kita cek lagi
if (isset($_SESSION['username'])) {
    $username_login = $_SESSION['username'];
    
    // Ambil data user dari database (sesuaikan nama tabel user Anda, misal 'user' atau 'webdailyjournal')
    $sql_user = "SELECT * FROM user WHERE username = '$username_login'";
    $result_user = $conn->query($sql_user);
    $user_data = $result_user->fetch_assoc();
} else {
    // Default jika session hilang (jarang terjadi jika akses dari admin)
    $username_login = "User";
    $user_data = ['foto' => ''];
}
?>

<div class="row">
    <div class="col-12 text-center mb-5 mt-3">
        <h4 class="display-6">Selamat Datang,</h4>
        <h1 class="text-danger fw-bold display-4"><?= $username_login ?></h1>
        
        <div class="mt-4">
            <?php
            // Logika Foto: Cek apakah ada foto di database DAN filenya ada di folder
            $foto_profil = "img/default.jpg"; // Set default awal
            
            if (!empty($user_data['foto']) && file_exists("img/" . $user_data['foto'])) {
                $foto_profil = "img/" . $user_data['foto'];
            }
            ?>
            <img src="<?= $foto_profil ?>" alt="Foto Profil" 
                 class="rounded-circle img-thumbnail shadow-sm border-danger" 
                 style="width: 200px; height: 200px; object-fit: cover;">
        </div>
    </div>

    <div class="row justify-content-center pt-4">
        
        <div class="col-md-4 mb-3">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h3 class="card-title"><i class="bi bi-journal-text text-danger"></i> Article</h3>
                        <p class="card-text text-muted">Jumlah artikel saat ini</p>
                    </div>
                    <div>
                        <span class="badge rounded-circle bg-danger p-4 fs-2"><?= $jumlah_article ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-danger shadow-sm h-100">
                <div class="card-body d-flex justify-content-between align-items-center p-4">
                    <div>
                        <h3 class="card-title"><i class="bi bi-camera text-danger"></i> Gallery</h3>
                        <p class="card-text text-muted">Jumlah foto saat ini</p>
                    </div>
                    <div>
                        <span class="badge rounded-circle bg-danger p-4 fs-2"><?= $jumlah_gallery ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
