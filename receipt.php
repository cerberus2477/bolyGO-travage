<?php 
    session_start();
    // echo $_SESSION["apiresponse"];
    $file = fopen("receipt.txt", "w");
    
    fwrite($file,"SZÁMLA\n------\n");

    $vegosszeg = 0;
    foreach($_SESSION["foglalasiAdatok"] as $a) {
        $vegosszeg += $a["ar"];
    }
    fwrite($file,"VÉGÖSSZEG: ".$vegosszeg." KOBALT\n");
    fwrite($file,"Foglalások száma: ".count($_SESSION["foglalasiAdatok"])."\n");
    fwrite($file,"Részletek:\n");

    $i = 0;
    foreach($_SESSION["foglalasiAdatok"] as $f) {
        $i++;
        
        $url = "http://".$_SERVER['HTTP_HOST'].implode("/",array_map('rawurlencode',explode("/",dirname($_SERVER['SCRIPT_NAME'])."/api.php")))."?csomagid=".$f["csomagid"];
        $raw_data = @file_get_contents($url);
        $data = json_decode($raw_data, true);

        fwrite($file,$i.". csomag:\n");
        fwrite($file,"- Csomag neve: ".$data["nev"]."\n");
        fwrite($file,"- Lefoglalt napok: ".$f["kezdido"]." - ".$f["vegido"]."\n");
        fwrite($file,"- Utazók száma: ".count($f["ugyfelek"])."\n");
        fwrite($file,"- Úticél: ".$data["bolygo"]."\n");
        fwrite($file,"- Csomagért fizetendő: ".$f["ar"]." kobalt.\n");
    }

    fclose($file);
?>


<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Számla ✦ bolyGO</title>
    <link rel="shortcut icon favicon" href="styles/img/logo_ikon.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/style.css">
    <script defer src="https://kit.fontawesome.com/af2e246792.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav data-state="closed" data-scrolled="false">
        <div class="nav-first-row">
            <img class="logo" src="styles/img/logo_transparent.png" alt="bolyGO logo">
            <a href="./cart.php" class="btn mobile-btn" ><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="#" class="btn btn-dark mobile-btn" onclick="toggleNav();"><i class="fa fa-bars"></i></a>
        </div>
      
        <a class="navlink" href="index.php#csomagok" data-active="true">Csomagok</a>
        <a class="navlink" href="index.php#rolunk">Rólunk</a>
        <a class="navlink" href="index.php#kapcsolat">Kapcsolat</a>
        <a class="btn pc-btn btn-auto-hover" href="./cart.php">Vissza a főoldalra <i class="fa-solid fa-home"></i></a>
    </nav>


    <header>
        <div class="header-content">
            <h1>Számla</h1>
        </div>
    </header>

    <main>
        <section>
            <p><a href="receipt.txt" download>A számla ide kattintva tölthető le</a></p>
            <div class="receipt-txt">
                <?php
                    //ez megtartja az entereket
                    echo nl2br(file_get_contents('receipt.txt'))
                ?>
            </div>
        </section>
    </main>

    <footer class="dark-blur">
        <section>
            <h3>Nav</h3>
            <a href="index.php#csomagok">Csomagok</a>
            <a href="index.php#rolunk">Rólunk</a>
            <a href="index.php#kapcsolat">Kapcsolat</a>
            <a class="btn pc-btn btn-auto-hover" href="./cart.php">Kosár <i class="fa-solid fa-cart-shopping"></i></a>
        </section>
        <section>
            <h3>Forduljon hozzánk bizalommal!</h3>
            <ul>
                <li>Tel: +369696969 <i class="fa fa-mobile"></i></li>
                <li>meoww <i class="fa fa-cat"></i></li>
                <li>cicákat akarok most ide most gimme <i class="fa fa-cat"></i></li>
            </ul>
        </section>
        <section>
            <h3>Telephelyünk <i class="fa-solid fa-map-location-dot"></i></h3>
            <div class="maps-container">
                <iframe width="100%" height="100%"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2706.7356574234536!2d19.23691240392388!3d47.28042171934365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741930014fc0d9b%3A0x195b02a0b1e91634!2sMacskalapos!5e0!3m2!1sen!2sus!4v1709628639614!5m2!1sen!2sus"
                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                </iframe>
            </div>
        </section>
    </footer>
</body>


    <script defer src="./scripts/design.js"></script>
</html>