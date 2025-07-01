<?php
session_start();
if (!isset($_SESSION['username'])) {
    // User is already logged in, redirect to welcome page  
    header("Location: login.php");

}

if(!isset($_SESSION["counter"])){
    $_SESSION["counter"] = 1;
} else {
    $_SESSION["counter"]++;
}

if(!isset($_SESSION["daftar"])){
    $_SESSION["daftar"] = [];
}

if(isset($_POST["nama"]) && isset($_POST["umur"])){
    $daftar = [
        'nama' => $_POST["nama"],
        'umur' => $_POST["umur"],
    ];
    $_SESSION["daftar"][] = $daftar;
}

$edit_daftar = [
    "nama" => "",
    "umur" => "",
];

$target = "dashboard.php";
if(isset($_GET["kunci"])){
    $target = "ubah.php?kunci=" . $_GET["kunci"];
    if($_GET["kunci"] != null){
        $index = $_GET["kunci"];
        $edit_daftar = $_SESSION["daftar"][$index];
    }
}

?>
<html>
    <head>
        <title>::Login Page::</title>
        <style type="text/css">
            body{
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-size: cover;
                background-image: url("https://cdn.arstechnica.net/wp-content/uploads/2023/06/bliss-update-1440x960.jpg");
            }
            table{
                background-color: white;
                border: 3px solid grey;
                padding: 20px;
                border-radius: 10px;
                font-family:Arial, Helvetica, sans-serif;
            }
            td{
                padding: 5px;
            }
            button{
                background-color: greenyellow;
                padding: 10px;
                border-radius: 5px;
            }
            #logout{
                background-color: red;
            }

        </style>
            <title>Dashboard</title>

    </head>
    <body>
        <h1><?php echo "Selamat datang " . $_SESSION['username'] . " ke-" . $_SESSION["counter"]  ?></h1>
        <br>
        <form action="<?php echo $target; ?>" method="post">
         <table>
            <tr>
                <td colspan="2" style="text-align: center;" >DAFTAR</td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama" value="<?php echo $edit_daftar["nama"] ?>" /></td>
            </tr>
            <tr>
                <td>Umur</td>
                <td><input type="number" name="umur" value="<?php echo $edit_daftar["umur"] ?>" /></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit" >PROSES</button>
                    <a href="logout.php">
                        <button id="logout" type="button" >LOGOUT</button>
                    </a>
                </td>
            </tr>
        </table>
        <table border="1">
            <tr>
                <td>Nama</td>
                <td>Umur</td>
                <td>keterangan</td>
                <td>Aksi</td>
            </tr>
            <?php foreach($_SESSION["daftar"] as $index => $daftar): ?>
            <tr>
                <td><?php echo $daftar ["nama"]; ?></td>
                <td><?php echo $daftar ["umur"]; ?></td>
                <td>
                    <?php

                    if($daftar['umur'] <= 10){
                        echo "Anak-anak";
                    }elseif($daftar['umur'] > 10 && $daftar['umur'] <= 20){
                        echo "Remaja";
                    }elseif($daftar['umur'] > 20 && $daftar['umur'] <= 40){
                        echo "Dewasa";
                    }else{
                        echo "Tua";
                    }
                    ?>
                </td>
                <td>
                    <a href="hapus.php?kunci=<?php echo $index; ?>">hapus</a> <a href="dashboard.php?kunci=<?php echo $index; ?>">ubah</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </form>
    </body>
</html>