<?php

//membatasi halaman sebelum login
if (!isset($_SESSION["login"])){
    echo"<script>
        alert('Anda Harus Login');
        document.location.href = 'login.php';
    </script>";
    exit;
}

?>