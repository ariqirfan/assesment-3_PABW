<?php
header('Content-Type: application/json; charset=utf8');

// Cross Origin Request
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Content-Type: application/json; charset=utf8');

$koneksi = mysqli_connect("localhost", "root", "", "tubes_pabw");

if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Menampilkan Semua Data TO DO: Buat lebih spesifik (Untuk POSTMAN)
    $sql = "SELECT * FROM konsumen";
    $query = mysqli_query($koneksi, $sql);
    $array_data = array();
    while ($data = mysqli_fetch_assoc($query)) {
        $array_data[] = $data;
    }
    echo json_encode($array_data, JSON_PRETTY_PRINT);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') { // [POST] Menambahkan data + Use Body, x-www-form-urlencoded in Postman
    $id_konsumen = $_POST['id_konsumen']; // All Required since it's a new data
    $nm_konsumen = $_POST['nm_konsumen'];
    $nohp_konsumen = $_POST['nohp_konsumen'];
    $email_konsumen = $_POST['email_konsumen'];
    $gender_konsumen = $_POST['gender_konsumen'];
    $sql = "INSERT INTO konsumen (id_konsumen, nm_konsumen, nohp_konsumen, email_konsumen, gender_konsumen) VALUES ('$id_konsumen', '$nm_konsumen', '$nohp_konsumen', '$email_konsumen', '$gender_konsumen')";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Data berhasil ditambahkan"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "Gagal menambahkan data"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { // [DELETE] Id only + Use Param in Postman
    $id_konsumen = $_GET['id'];
    $sql = "DELETE FROM konsumen WHERE id_konsumen='$id_konsumen'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Data berhasil dihapus"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "Gagal menghapus data"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { // [PUT] Use All + Use Params in Postman
    parse_str(file_get_contents("php://input"), $_PUT);
    $id_konsumen = $_PUT['id_konsumen_update'];
    $new_id_konsumen = $_PUT['new_id_konsumen'];

    // Check if a new ID was provided and use it if available
    if (isset($_PUT['new_id_konsumen']) && !empty($_PUT['new_id_konsumen'])) {
        // Update the ID in the database
        $sql_update_id_konsumen = "UPDATE konsumen SET id_konsumen='$new_id_konsumen' WHERE id_konsumen='$id_konsumen'";
        $cek_update_id_konsumen = mysqli_query($koneksi, $sql_update_id_konsumen);

        // Update the ID variable if the update was successful
        if ($cek_update_id_konsumen) {
            $id_konsumen = $new_id_konsumen;
        }
    }

    $nm_konsumen = $_PUT['nm_konsumen_update'];
    $nohp_konsumen = $_PUT['nohp_konsumen_update'];
    $email_konsumen = $_PUT['email_konsumen_update'];
    $gender_konsumen = $_PUT['gender_konsumen_update'];

    $sql = "UPDATE konsumen SET nm_konsumen='$nm_konsumen', nohp_konsumen='$nohp_konsumen', email_konsumen='$email_konsumen', gender_konsumen='$gender_konsumen' WHERE id_konsumen='$id_konsumen'";
    $cek = mysqli_query($koneksi, $sql);

    if ($cek) {
        $data = [
            'status' => "Data berhasil diperbarui"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        $data = [
            'status' => "Gagal memperbarui data"
        ];
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
}
?>
