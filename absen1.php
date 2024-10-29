<?php 

session_start();

include("security/bataslogin.php");

$title = 'Data Barang';

include("layout/header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data latitude dan longitude dari POST request
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : null;
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : null;

    // Periksa apakah data yang diperlukan ada
    if ($latitude && $longitude) {
        // Lakukan sesuatu dengan data ini, misalnya menyimpan ke database
        // Contoh: menyimpan ke dalam file log (Anda bisa mengganti ini dengan penyimpanan ke database)

        $logEntry = "Latitude: $latitude, Longitude: $longitude\n";
        file_put_contents('locations.log', $logEntry, FILE_APPEND);

        // Berikan respons sukses
        echo "Data lokasi berhasil diterima: Latitude: $latitude, Longitude: $longitude";
    } else {
        // Berikan respons gagal jika data tidak lengkap
        echo "Data lokasi tidak lengkap.";
    }
} else {
    // Berikan respons gagal jika bukan POST request
    echo "Metode request tidak valid.";
}


?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Absensi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Absensi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h1 class="card-title">Absensi</h1>
                        </div>
                        <div class="card-body">
                            <!-- <h2>Ambil Lokasi Anda</h2> -->
                            <button id="get-location" class="btn btn-primary">Dapatkan Lokasi</button>
                            <div id="output" class="mt-3">
                                <p>Latitude: <span id="latitude"></span></p>
                                <p>Longitude: <span id="longitude"></span></p>
                            </div>
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
 
<script>
document.getElementById('get-location').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
});

function showPosition(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    document.getElementById('latitude').innerText = latitude;
    document.getElementById('longitude').innerText = longitude;

    // Inisialisasi HERE Map
    var platform = new H.service.Platform({
        'apikey': 'FBR3MOkHSo_PTVZAgHmrg6iloJOsskbfEtLXa3foU6o'
    });

    var defaultLayers = platform.createDefaultLayers();

    var map = new H.Map(document.getElementById('map'),
        defaultLayers.vector.normal.map, {
        center: {lat: latitude, lng: longitude},
        zoom: 15,
    });

    var icon = new H.map.Icon('https://img.icons8.com/office/40/000000/marker.png');
    var marker = new H.map.Marker({lat: latitude, lng: longitude}, {icon: icon});
    map.addObject(marker);

    // Mengirim data ke PHP
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "absen.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState == XMLHttpRequest.DONE && this.status == 200) {
            console.log(this.responseText);
        }
    }
    xhr.send("latitude=" + latitude + "&longitude=" + longitude);
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            alert("User denied the request for Geolocation.");
            break;
        case error.POSITION_UNAVAILABLE:
            alert("Location information is unavailable.");
            break;
        case error.TIMEOUT:
            alert("The request to get user location timed out.");
            break;
        case error.UNKNOWN_ERROR:
            alert("An unknown error occurred.");
            break;
    }
}
</script>

<?php 

include("layout/footer.php");

?>