<div class="container">
    <div class="row mb-2">
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Article
            </button>
        </div>
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" id="search" class="form-control" placeholder="Cari Artikel...">
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
                        <th class="w-25">Judul</th>
                        <th class="w-50">Isi</th>
                        <th class="w-50">Gambar</th>
                        <th class="w-25">Aksi</th>
                    </tr>
                </thead>
                <tbody id="result">
                    <?php
                    $sql = "SELECT * FROM article ORDER BY tanggal DESC";
                    $hasil = $conn->query($sql);
                    $no = 1;

                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= $row["judul"] ?></strong>
                                <br>pada : <?= $row["tanggal"] ?>
                                <br>oleh : <?= $row["username"] ?>
                            </td>
                            <td><?= $row["isi"] ?></td>
                            <td>
                                <?php
                                if ($row["gambar"] != '') {
                                    if (file_exists('img/' . $row["gambar"] . '')) {
                                        echo '<img src="img/' . $row["gambar"] . '" class="img-fluid" width="150" alt="Gambar Artikel">';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                                <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Article</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="judul" class="form-label">Judul</label>
                                                <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" value="<?= $row["judul"] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="isi">Isi</label>
                                                <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" required><?= $row["isi"] ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="gambar" class="form-label">Ganti Gambar</label>
                                                <input type="file" class="form-control" name="gambar">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                                <?php
                                                if ($row["gambar"] != '') {
                                                    if (file_exists('img/' . $row["gambar"] . '')) {
                                                        echo '<br><img src="img/' . $row["gambar"] . '" class="img-fluid" width="100" alt="Gambar Artikel">';
                                                    }
                                                }
                                                ?>
                                                <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
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
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Article</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus artikel "<strong><?= $row["judul"] ?></strong>"?</label>
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
                    } 
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
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Article</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" required>
                    </div>
                    <div class="mb-3">
                        <label for="isi">Isi</label>
                        <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Pilih Gambar</label>
                        <input type="file" class="form-control" name="gambar">
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
                url: "article_search.php",
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


if (isset($_POST['simpan'])) {
    $judul = $_POST['judul'];
    $isi = $_POST['isi'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

  
    if ($nama_gambar != '') {
        $cek_upload = upload_foto($_FILES["gambar"]);
        if ($cek_upload['status']) {
            $gambar = $cek_upload['message'];
        } else {
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=article';
            </script>";
            die;
        }
    }


    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            $gambar = $_POST['gambar_lama']; 
        } else {
          
            if (file_exists("img/" . $_POST['gambar_lama'])) {
                unlink("img/" . $_POST['gambar_lama']);
            }
        }

        $stmt = $conn->prepare("UPDATE article SET judul=?, isi=?, gambar=?, tanggal=?, username=? WHERE id=?");
        $stmt->bind_param("sssssi", $judul, $isi, $gambar, $tanggal, $username, $id);
        $simpan = $stmt->execute();
    } else {
        $stmt = $conn->prepare("INSERT INTO article (judul,isi,gambar,tanggal,username) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $judul, $isi, $gambar, $tanggal, $username);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=article';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=article';
        </script>";
    }

    $stmt->close();
    $conn->close();
}


if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        if (file_exists("img/" . $gambar)) {
            unlink("img/" . $gambar);
        }
    }

    $stmt = $conn->prepare("DELETE FROM article WHERE id =?");
    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='admin.php?page=article';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='admin.php?page=article';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
