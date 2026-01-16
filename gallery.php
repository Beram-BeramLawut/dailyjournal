<div class="container">
    <div class="row mb-2">
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Gallery
            </button>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Cari Gallery (Deskripsi)...">
                <span class="input-group-text">
                    <i class="bi bi-search"></i>
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="w-25">Tanggal</th>
                        <th class="w-25">Gambar</th>
                        <th class="w-25">Deskripsi</th>
                        <th class="w-25">Aksi</th>
                    </tr>
                </thead>
                <tbody id="result">
                    <?php
                    // PERBAIKAN 1: Masukkan koneksi database di sini
                    include "koneksi.php"; 

                    // 1. QUERY DATA
                    $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
                    $hasil = $conn->query($sql);
                    $no = 1;

                    // 2. LOOPING DATA
                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <span>pada : <?= $row["tanggal"] ?></span>
                                <br>oleh : <?= $row["username"] ?>
                            </td>
                            <td>
                                <?php
                                if ($row["gambar"] != '') {
                                    if (file_exists('img/' . $row["gambar"] . '')) {
                                        echo '<img src="img/' . $row["gambar"] . '" class="img-fluid" width="150" alt="Gambar Gallery">';
                                    }
                                }
                                ?>
                            </td>
                            <td><?= $row["deskripsi"] ?></td>
                            <td>
                                <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                                <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Gallery</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="gambar" class="form-label">Ganti Gambar</label>
                                                <input type="file" class="form-control" name="gambar">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                                <?php
                                                if ($row["gambar"] != '') {
                                                    if (file_exists('img/' . $row["gambar"] . '')) {
                                                        echo '<br><img src="img/' . $row["gambar"] . '" class="img-fluid" width="100" alt="Gambar">';
                                                    }
                                                }
                                                ?>
                                                <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="deskripsi">Deskripsi</label>
                                                <textarea class="form-control" placeholder="Tuliskan Deskripsi Gambar" name="deskripsi" required><?= $row["deskripsi"] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Gallery</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus gambar ini?</label>
                                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                                            <input type="submit" value="hapus" name="hapus" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php
                    } // AKHIR LOOPING
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Gallery</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Pilih Gambar</label>
                        <input type="file" class="form-control" name="gambar" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea class="form-control" placeholder="Tuliskan Deskripsi Gambar" name="deskripsi" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#search").on("keyup", function() {
            var keyword = $(this).val();
            $.ajax({
                url: "gallery_search.php", // PERBAIKAN 2: Ubah URL ke gallery_search.php
                type: "POST",
                data: {
                    keyword: keyword
                },
                success: function(data) {
                    $("#result").html(data);
                }
            });
        });
    });
</script>

<?php
include "upload_foto.php";

// LOGIKA SIMPAN (INSERT & UPDATE)
if (isset($_POST['simpan'])) {
    $deskripsi = $_POST['deskripsi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    // Cek jika ada file gambar baru
    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES["gambar"]);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=gallery';
            </script>";
            die;
        }
    }

    // CEK APAKAH INI EDIT ATAU TAMBAH
    if (isset($_POST['id'])) {
        // --- UPDATE ---
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama'];
        } else {
            if (file_exists("img/" . $_POST['gambar_lama'])) {
                unlink("img/" . $_POST['gambar_lama']);
            }
        }

        $stmt = $conn->prepare("UPDATE gallery SET gambar=?, deskripsi=?, tanggal=?, username=? WHERE id=?");
        $stmt->bind_param("ssssi", $gambar, $deskripsi, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
        // --- INSERT ---
        if ($gambar != '') {
            $stmt = $conn->prepare("INSERT INTO gallery (gambar, deskripsi, tanggal, username) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $gambar, $deskripsi, $tanggal, $username);
            $simpan = $stmt->execute();
        } else {
            $simpan = false;
        }
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}

// LOGIKA HAPUS
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        if (file_exists("img/" . $gambar)) {
            unlink("img/" . $gambar);
        }
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id =?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>