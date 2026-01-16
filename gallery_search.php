<?php
include "koneksi.php";

$keyword = $_POST['keyword'];

if ($keyword != '') {
    $sql = "SELECT * FROM gallery 
            WHERE deskripsi LIKE ? OR tanggal LIKE ? OR username LIKE ?
            ORDER BY tanggal DESC";

    $stmt = $conn->prepare($sql);
    $search = "%" . $keyword . "%";
    $stmt->bind_param("sss", $search, $search, $search);
    $stmt->execute();
    $hasil = $stmt->get_result();
} else {
    $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
    $hasil = $conn->query($sql);
}

$no = 1;
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
}

?>
