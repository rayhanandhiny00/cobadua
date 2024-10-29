<?php

//fungsi menampilkan data (create, update, delete)
function select($query)
{
    //panggil koneksi database
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];

    while ($row = mysqli_fetch_assoc($result))
    {
        $rows[] = $row;
    }

    return $rows;
}

function execute($query) {
    
    global $db;
    if ($db->query($query) === TRUE) {
        return true;
    } else {
        error_log("Error: " . $db->error);
        return false;
    }
}

//fungsi menambahkan data barang
function create_barang($post)
{
    global $db;

    $nama_b = strip_tags($post["nama_b"]);
    $jumlah = strip_tags($post["jumlah"]);
    $harga = strip_tags($post["harga"]);

    //query tambah data
    $query = "INSERT INTO barang VALUES(null, '$nama_b', '$jumlah', '$harga', current_timestamp())";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//fungsi edit/update data datang
function update_barang($post)
{
    global $db;

    $id_barang = $post["id_barang"];
    $nama_b = strip_tags($post["nama_b"]);
    $jumlah = strip_tags($post["jumlah"]);
    $harga = strip_tags($post["harga"]);

    //query edit data
    $query = "UPDATE barang SET nama_b = '$nama_b', jumlah = '$jumlah', harga = '$harga' WHERE id_barang = $id_barang";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//fungsi mengahapus barang
function delete_barang($id_barang) {
    global $db;

    //query hapus data barang
    $query = "DELETE FROM barang WHERE id_barang = $id_barang";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);

}

//fungsi menambah akun
function create_akun($post)
{
    global $db;

    $no_a = strip_tags($post["no_a"]);
    $nama_a = strip_tags($post["nama_a"]);
    $jk = strip_tags($post["jk"]);
    $alamat = strip_tags($post["alamat"]);
    $tlp = strip_tags($post["tlp"]);
    $username = strip_tags($post["username"]);
    $password = strip_tags($post["password"]);
    $role = strip_tags($post["role"]);


    //enkripsi atau hashing password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //query tambah data
    $query = "INSERT INTO akun VALUES(null, '$no_a', '$nama_a', '$jk', '$alamat', '$tlp', '$username', '$password', '$role')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

// fungsi mengahapus akun
function delete_akun($id_akun)
{
    global $db;

    //query hapus data akun
    $query = "DELETE FROM akun WHERE id_akun = $id_akun";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function update_akun($post)
{
    global $db;

    $id_akun = $post["id_akun"];
    $no_a = strip_tags($post["no_a"]);
    $nama_a = strip_tags($post["nama_a"]);
    $jk = strip_tags($post["jk"]);
    $alamat = strip_tags($post["alamat"]);
    $tlp = strip_tags($post["tlp"]);
    $username = strip_tags($post["username"]);
    $password = strip_tags($post["password"]);
    $role = strip_tags($post["role"]);

    //enkripsi atau hashing password
    // $password = password_hash($password, PASSWORD_DEFAULT);

    // Fetch existing data for the user to compare passwords
    $existing_akun = select("SELECT password FROM akun WHERE id_akun = $id_akun");

    if (!empty($existing_akun)) {
        $existing_password = $existing_akun[0]['password'];

        // Check if the password in the form is the same as the existing one
        if ($existing_password !== $password) {
            // Password has been changed, hash it
            // $password = password_hash($password, PASSWORD_DEFAULT);
        // } else {
            // Password remains the same, use the existing hashed password
            $password = $existing_password;
        }
    } else {
        // If the user does not exist, handle the error
        return 0;
    }

    //query edit data
    $query = "UPDATE akun SET no_a = '$no_a', nama_a = '$nama_a', jk = '$jk', alamat = '$alamat', tlp = '$tlp', username = '$username', password = '$password', role = '$role' WHERE id_akun = $id_akun";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

//fungsi ganti password
function ganti_password($data) {
    global $db; // Assuming $db is your database dbection

    $id_akun = $_SESSION['id_akun']; // Get the user ID from the session
    $pwlama = mysqli_real_escape_string($db, $data['pwlama']);
    $pwbaru = mysqli_real_escape_string($db, $data['pwbaru']);
    $conpwbaru = mysqli_real_escape_string($db, $data['conpwbaru']);

    // Fetch current password from the database
    $result = mysqli_query($db, "SELECT password FROM akun WHERE id_akun = $id_akun");
    $akun = mysqli_fetch_assoc($result);

    // Verify old password
    if (!password_verify($pwlama, $akun['password'])) {
        echo "<script>
                alert('Password Lama salah');
             </script>";
        return 0;
    }

    // Check if new password and confirm password match
    if ($pwbaru !== $conpwbaru) {
        echo "<script>
                alert('Password Baru dan Konfirmasi Password Baru tidak cocok');
             </script>";
        return 0;
    }

    // Hash the new password
    $pwbaru_hashed = password_hash($pwbaru, PASSWORD_DEFAULT);

    // Update the password in the database
    $query = "UPDATE akun SET password = '$pwbaru_hashed' WHERE id_akun = $id_akun";
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function create_pesanan($post)
{
    global $db;

    $id_barang = strip_tags($post["id_barang"]);
    $namatoko = strip_tags($post["namatoko"]);
    $jml_brg = strip_tags($post["jml_brg"]);
    $nama_a = strip_tags($post["nama_a"]);

        // Check stock availability
        $query_check = "SELECT jumlah FROM barang WHERE id_barang = '$id_barang'";
        $result_check = mysqli_query($db, $query_check);
        $stock = mysqli_fetch_assoc($result_check)['jumlah'];

    if ($jml_brg >= $stock) {
        return -1; // Indicate insufficient stock
    }

        // Insert into pesanan
        $query = "INSERT INTO barang_keluar (id_barang, namatoko, jml_brg, nama_a, tanggal) VALUES ('$id_barang', '$namatoko', '$jml_brg', '$nama_a', current_timestamp())";
        mysqli_query($db, $query);

        // Update stok barang
        $query_barang = "UPDATE barang SET jumlah = jumlah - '$jml_brg' WHERE id_barang = '$id_barang'";
        mysqli_query($db, $query_barang);

        return mysqli_affected_rows($db);

}

// function edit_pesanan($post)
// {
//     global $db;

//     $id_keluar = strip_tags($post["id_keluar"]);
//     $id_barang = strip_tags($post["edit_id_barang"]);
//     $namatoko = strip_tags($post["edit_namatoko"]);
//     $jml_brg = strip_tags($post["edit_jml_brg"]);
//     $nama_a = strip_tags($post["edit_nama_a"]);

//     // Ambil jumlah barang sebelumnya
//     $query_before = "SELECT jml_brg FROM barang_keluar WHERE id_keluar = '$id_keluar'";
//     $result_before = mysqli_query($db, $query_before);
//     $row_before = mysqli_fetch_assoc($result_before);
//     $jml_brg_before = $row_before['jml_brg'];

//     // Update barang_keluar
//     $query = "UPDATE barang_keluar SET id_barang = '$id_barang', namatoko = '$namatoko', jml_brg = '$jml_brg', nama_a = '$nama_a' WHERE id_keluar = '$id_keluar'";
//     $result = mysqli_query($db, $query);

//     if (!$result) {
//         return mysqli_error($db);  // Mengembalikan pesan kesalahan jika query gagal
//     }

//     // Hitung selisih jumlah baru dengan jumlah sebelumnya
//     $selisih = $jml_brg - $jml_brg_before;

//     // Perbarui jumlah stok barang di tabel barang
//     $query_update_stok = "UPDATE barang SET jumlah = jumlah - '$selisih' WHERE id_barang = '$id_barang'";
//     mysqli_query($db, $query_update_stok);

//     // return mysqli_affected_rows($db) > 0 ? 1 : 0;
//     return mysqli_affected_rows($db);
// }

// function edit_pesanan($post)
// {
//     global $db;

//     $id_keluar = strip_tags($post["id_keluar"]);
//     $id_barang = strip_tags($post["edit_id_barang"]);
//     $namatoko = strip_tags($post["edit_namatoko"]);
//     $jml_brg = strip_tags($post["edit_jml_brg"]);
//     $nama_a = strip_tags($post["edit_nama_a"]);

//     // Ambil jumlah barang sebelumnya
//     $query_before = "SELECT jml_brg FROM barang_keluar WHERE id_keluar = '$id_keluar'";
//     $result_before = mysqli_query($db, $query_before);
//     $row_before = mysqli_fetch_assoc($result_before);
//     $jml_brg_before = $row_before['jml_brg'];

//     // Hitung selisih jumlah baru dengan jumlah sebelumnya
//     $selisih = $jml_brg - $jml_brg_before;

//     // Ambil jumlah stok saat ini
//     $query_stock = "SELECT jumlah FROM barang WHERE id_barang = '$id_barang'";
//     $result_stock = mysqli_query($db, $query_stock);
//     $stock = mysqli_fetch_assoc($result_stock)['jumlah'];

//     // Periksa apakah stok setelah pembaruan akan kurang dari 1
//     if ($stock - $selisih < 1) {
//         return -11; // Indicate insufficient stock after the update
//     }

//     // Update barang_keluar
//     $query = "UPDATE barang_keluar SET id_barang = '$id_barang', namatoko = '$namatoko', jml_brg = '$jml_brg', nama_a = '$nama_a' WHERE id_keluar = '$id_keluar'";
//     $result = mysqli_query($db, $query);

//     if (!$result) {
//         return mysqli_error($db);  // Mengembalikan pesan kesalahan jika query gagal
//     }

//     // Perbarui jumlah stok barang di tabel barang
//     $query_update_stok = "UPDATE barang SET jumlah = jumlah - '$selisih' WHERE id_barang = '$id_barang'";
//     mysqli_query($db, $query_update_stok);

//     return mysqli_affected_rows($db);
// }

function edit_pesanan($post)
{
    global $db;

    $id_keluar = strip_tags($post["id_keluar"]);
    $id_barang = strip_tags($post["edit_id_barang"]);
    $namatoko = strip_tags($post["edit_namatoko"]);
    $jml_brg = strip_tags($post["edit_jml_brg"]);
    $nama_a = strip_tags($post["edit_nama_a"]);

    // Ambil data sebelumnya
    $query_before = "SELECT id_barang, namatoko, jml_brg, nama_a FROM barang_keluar WHERE id_keluar = '$id_keluar'";
    $result_before = mysqli_query($db, $query_before);
    $row_before = mysqli_fetch_assoc($result_before);
    $id_barang_before = $row_before['id_barang'];
    $jml_brg_before = $row_before['jml_brg'];
    $namatoko_before = $row_before['namatoko'];
    $nama_a_before = $row_before['nama_a'];

    // Hitung selisih jumlah barang baru dan lama
    $selisih = $jml_brg - $jml_brg_before;

    // Ambil stok barang saat ini
    $query_stock = "SELECT jumlah FROM barang WHERE id_barang = '$id_barang'";
    $result_stock = mysqli_query($db, $query_stock);
    $stock = mysqli_fetch_assoc($result_stock)['jumlah'];

    // Jika barangnya diubah, ambil stok barang lama juga
    if ($id_barang != $id_barang_before) {
        $query_stock_before = "SELECT jumlah FROM barang WHERE id_barang = '$id_barang_before'";
        $result_stock_before = mysqli_query($db, $query_stock_before);
        $stock_before = mysqli_fetch_assoc($result_stock_before)['jumlah'];
    }

    // Periksa apakah stok setelah pembaruan akan kurang dari 1
    if (($id_barang != $id_barang_before && $stock < $jml_brg) || ($id_barang == $id_barang_before && $stock - $selisih <= 1)) {
        return -11; // Indicate insufficient stock after the update
    }

    // Update barang_keluar
    $query = "UPDATE barang_keluar SET id_barang = '$id_barang', namatoko = '$namatoko', jml_brg = '$jml_brg', nama_a = '$nama_a' WHERE id_keluar = '$id_keluar'";
    $result = mysqli_query($db, $query);

    if (!$result) {
        return mysqli_error($db);  // Mengembalikan pesan kesalahan jika query gagal
    }

    // Perbarui stok barang lama jika barangnya diubah
    if ($id_barang != $id_barang_before) {
        $query_update_stock_before = "UPDATE barang SET jumlah = jumlah + '$jml_brg_before' WHERE id_barang = '$id_barang_before'";
        mysqli_query($db, $query_update_stock_before);
    }

    // Perbarui stok barang baru
    $query_update_stock = "UPDATE barang SET jumlah = jumlah - '$jml_brg' WHERE id_barang = '$id_barang'";
    mysqli_query($db, $query_update_stock);

    return 1; // Indicate success
}

function delete_pesanan($id_keluar) {
    global $db;

    // Dapatkan id_barang dan jml_brg dari tabel barang_keluar
    $query_select = "SELECT id_barang, jml_brg FROM barang_keluar WHERE id_keluar = $id_keluar";
    $result_select = mysqli_query($db, $query_select);
    $row = mysqli_fetch_assoc($result_select);
    $id_barang = $row['id_barang'];
    $jml_brg = $row['jml_brg'];

    //query hapus data barang
    $query = "DELETE FROM barang_keluar WHERE id_barang = $id_barang";
    mysqli_query($db, $query);

    // Update stok barang
    $query_barang = "UPDATE barang SET jumlah = jumlah + '$jml_brg' WHERE id_barang = '$id_barang'";
    mysqli_query($db, $query_barang);

    return mysqli_affected_rows($db);

}

function tambah_stok($post)
{
    global $db;

    $id_barang = strip_tags($post["id_barang"]);
    $jumlah_masuk = strip_tags($post["jumlah"]);
    $nama_a = strip_tags($post["nama_a"]);
    
    // Insert data into tambah_stok
    $query = "INSERT INTO tambah_stok (id_barang, jumlah_tambah, nama_a, tanggal) VALUES ('$id_barang', '$jumlah_masuk', '$nama_a', current_timestamp())";
    mysqli_query($db, $query);

    // Update jumlah barang in barang table
    $query_update = "UPDATE barang SET jumlah = jumlah + '$jumlah_masuk' WHERE id_barang = '$id_barang'";
    mysqli_query($db, $query_update);

    return mysqli_affected_rows($db);
}

function pesanan_selesai($id_keluar)
{
    global $db;
    
    // Select the data to be moved
    $barang_keluar = select("SELECT * FROM barang_keluar WHERE id_keluar = $id_keluar")[0];

    // Prepare the data for insertion into riwayat
    $namatoko = $barang_keluar['namatoko'];
    $id_barang = $barang_keluar['id_barang'];
    $jml_brg = $barang_keluar['jml_brg'];
    $nama_a = $barang_keluar['nama_a'];
    
    // Get the actual name of the barang
    $barang = select("SELECT nama_b FROM barang WHERE id_barang = $id_barang")[0];
    $nama_barang = $barang['nama_b'];
    
    // Insert into riwayat
    $query_insert = "INSERT INTO riwayat (namatoko, nmbarang, jml_brg, nama_a, tanggal) VALUES ('$namatoko', '$nama_barang', '$jml_brg', '$nama_a', NOW())";
    mysqli_query($db, $query_insert);
    
    // Check if insert was successful
    if (mysqli_affected_rows($db) > 0) {
        // Delete from barang_keluar
        $query_delete = "DELETE FROM barang_keluar WHERE id_keluar = $id_keluar";
        mysqli_query($db, $query_delete);
        
        return mysqli_affected_rows($db);
    }
    
    return 0;
}

function absensls($post)
{
    global $db;

    $nama_a = $post["nama_a"];
    $namatoko = strip_tags($post["namatoko"]);
    $latitude = strip_tags($post["latitude"]);
    $longitude = strip_tags($post["longitude"]);

    //query tambah data
    $query = "INSERT INTO absensi VALUES(null, '$nama_a', '$namatoko', current_timestamp(), '$latitude', '$longitude')";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function totalpesanan($nama_a, $role)
{
    global $db;

    if ($role == 3)
    {
        $query = "SELECT COUNT(*) AS total FROM barang_keluar WHERE nama_a = '$nama_a'";
        $result = mysqli_query($db,$query);
    } else {
        $query = "SELECT COUNT(*) AS total FROM barang_keluar"; // Menghitung jumlah baris pada tabel barang_keluar
        $result = mysqli_query($db, $query);
    }

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0; // Mengembalikan 0 jika query gagal
    }
}

function totalriwayat($nama_a, $role)
{
    global $db;

    if ($role == 3)
    {
        $query = "SELECT COUNT(*) AS total FROM riwayat WHERE nama_a = '$nama_a'";
        $result = mysqli_query($db,$query);
    } else {
    $query = "SELECT COUNT(*) AS total FROM riwayat"; // Menghitung jumlah baris pada tabel barang_keluar
    $result = mysqli_query($db, $query);
    }

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0; // Mengembalikan 0 jika query gagal
    }
}

function absensisales($start_month)
{
    global $db;

    // Mengambil bulan saat ini
    $current_month = date('Y-m');

    // Jika bulan saat ini berbeda dengan bulan terakhir perhitungan, mulai perhitungan baru
    if ($current_month != $start_month) {
        $result = $db->query("SELECT nama_a, COUNT(nama_a) as absensi FROM absensi GROUP BY nama_a");
        $absensi_data = [];
        while ($row = $result->fetch_assoc()) {
            $absensi_data[$row['nama_a']] = $row['absensi'];
        }
        return $absensi_data;
    } else {
        // Jika masih dalam bulan yang sama, gunakan data absensi sebelumnya
        return getPreviousMonthAbsensi($start_month); // Panggil fungsi untuk mendapatkan data absensi dari bulan sebelumnya
    }
}

function getPreviousMonthAbsensi($start_month) {
    global $db;

    // Query untuk mendapatkan data absensi dari bulan sebelumnya
    $result = $db->query("SELECT nama_a, COUNT(nama_a) as absensi FROM absensi WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$start_month' GROUP BY nama_a");
    
    $absensi_data = [];
    while ($row = $result->fetch_assoc()) {
        $absensi_data[$row['nama_a']] = $row['absensi'];
    }
    return $absensi_data;
}

function pesanansales($start_month)
{
    global $db;

    // Mengambil bulan saat ini
    $current_month = date('Y-m');

    // Jika bulan saat ini berbeda dengan bulan terakhir perhitungan, kembalikan semua pesanan ke 0
    if ($current_month != $start_month) {
        $result = $db->query("SELECT nama_a, COUNT(nama_a) as jumlah_pesanan FROM akun GROUP BY nama_a");
        $pesanan_data = [];
        while ($row = $result->fetch_assoc()) {
            $pesanan_data[$row['nama_a']] = $row['jumlah_pesanan'];
        }
        return $pesanan_data;
    } else {
        // Jika masih dalam bulan yang sama, hitung pesanan seperti biasa
        $result = $db->query("SELECT nama_a, 
            (SELECT COUNT(*) FROM barang_keluar WHERE nama_a = akun.nama_a) + 
            (SELECT COUNT(*) FROM riwayat WHERE nama_a = akun.nama_a) as jumlah_pesanan 
            FROM akun 
            GROUP BY nama_a");
        $pesanan_data = [];
        while ($row = $result->fetch_assoc()) {
            $pesanan_data[$row['nama_a']] = $row['jumlah_pesanan'];
        }
        return $pesanan_data;
    }}

?>