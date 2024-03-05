<?php
    session_start();
    if (!isset($_SESSION["kosar"])) $_SESSION["kosar"] = array();
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bolyGO</title>
    <link rel="shortcut icon favicon" href="styles/img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles/style.css">
    <script defer src="https://kit.fontawesome.com/af2e246792.js" crossorigin="anonymous"></script>
    <script defer src="./js/app.js"></script>
</head>

<body>
    <nav class="main-nav" data-state="closed" data-scrolled="false">
        <div class="nav-first-row">
            <img class="logo" src="styles/img/logo_transparent.png" alt="bolyGO logo">
            <a href="./cart.php" class="btn mobile-btn" ><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="#" class="btn btn-dark mobile-btn" onclick="toggleNav();"><i class="fa fa-bars"></i></a>
        </div>

        <a href="programok.html">Csomagok</a>
        <a href="galeria.html">Rólunk</a>
        <a href="">Kapcsolat</a>
        <a class="btn pc-btn icon-btn" href="./cart.php">Kosár <i class="fa-solid fa-cart-shopping"></i></a>
    </nav>



    <header class="header-main">
        <div class="header-content">
            <h1> <span>bolyGO</span> <br> utazási iroda</h1>
            <p>Utazz epikus bolygókra!!</p>
            <div><a class="btn btn-light icon-btn" href="#csomagok">Csomagok </a></div>
        </div>

    </header>



    <main id="index-content">
        <section id=rolunk>
            <h2>Rólunk</h2>
            <p>Utaztatunk and shit és nagyon szuperek vagyunk. Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Blanditiis, quos.</p>
            <div class="rolunk-container">
                <div class="card" data-color="yellow">
                    <div >
                        <img class="small-card-img" src="styles/img/levi.png" alt="Levi">
                    </div>
                    <div class="card-content">
                        <h2>Levi</h2>
                        <p class="description">MIAUUUUU
                    </div>
                </div>
                <div class="card" data-color="pink">
                    <img class="small-card-img" src="styles/img/tunde.jpg" alt="Tünde">
                    <div class="card-content">
                        <h2>Tünde</h2>
                        <p class="description">
                            <--- that's my boyfren c:</p>
                    </div>
                </div>
                <div class="card" data-color="green">
                    <img class="small-card-img" src="styles/img/sityu.jpg" alt="Sityu">
                    <div class="card-content">
                        <h2>Sityu</h2>
                        <p class="description">Hol vagyok?</p>
                    </div>
                </div>

            </div>
        </section>


        <section id="csomagok">
            <h2>Csomagok</h2>
            <div class="csomag-container">
                <?php
                    //API meghívása
                    $url = "http://".$_SERVER['HTTP_HOST'].implode("/",array_map('rawurlencode',explode("/",dirname($_SERVER['SCRIPT_NAME'])."/api.php")));
                    $options = array(
                        'http' => array(
                            'method' => 'GET',
                            'header' => 'Content-Type: application/json'
                        )
                    );
                    $context = stream_context_create($options);
                    $data = json_decode(file_get_contents($url, false, $context), true);

                    // kártyák random színéhez kell
                    $colors = ['green', 'red', 'yellow', 'pink', 'purple'];
                ?>

                <!-- csomgok kis kártyái -->
                <?php foreach ($data as $csomag):?>
                    <div class="card" data-color="<?= $colors[array_rand($colors)] ?>">
                        <img class="small-card-img" src="<?= './styles/csomag_img/'.$csomag["id"].'.png'?>" alt="<?= $csomag["nev"].' képe'?>">
                        <div class="card-content">
                            <h2><?= $csomag["nev"]?></h2>
                            <p class="description"><?= $csomag["leiras"]?></p>
                            <button class="btn btn-light icon-btn" onclick='jumpTo(<?= $csomag["id"]?>)'>Részletek <i class="fa-solid fa-circle-chevron-down"></i></button>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </section>

        <section class="bovebben-container">

            <button class="btn btn-controll" onclick="showPrevCard()"><i class="fa-solid fa-chevron-left"></i></button> 

            <div id="hosszuleiras" class="meow">  <!-- ha megcsinálom hogy szépen csússzanak a kártyák kelleni fog egy div -->
                <?php foreach ($data as $csomag):?>
                    <div class="card big-card card-hidden" data-csomagid="<?= $csomag["id"]?>">
                        <img class="big-card-img" src="<?= './styles/csomag_img/'.$csomag["id"].'.png'?>" alt="<?= $csomag["nev"].' képe'?>">
            
                        <div class="card-content">
                            <h2><?= $csomag["nev"]?></h2>
                            <h3><?= $csomag["bolygo"]?></h3>
                            <p><?= $csomag["leiras"]?></p>
                        </div>
                        <div class="card-content">
                            <p>Választható dátum: <?= $csomag["kezdido"]?> - <?= $csomag["vegido"]?></p>
                            <p>Választható járművek</p>
                            <table border="1">
                                <thead>
                                    <tr>
                                        <th>név</th>
                                        <th>osztály</th>
                                        <th>fekvőhely</th>
                                        <th>ár</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($csomag["jarmuvek"] as $jarmu):?>
                                        <tr>
                                            <td><?= $jarmu["nev"]?></td>
                                            <td><?= $jarmu["osztaly"]?></td>
                                            <td><?= $jarmu["fekvohely"]?></td>
                                            <td><?= $jarmu["ar"]?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <p><i>Már <span><?= $csomag["csomagar"]?></span> kobalt/fő/éjtől</i></p>
                            <form action="<?php print $_SERVER["PHP_SELF"];?>" method="post">
                                <button class="btn icon-btn" name="addcart" value="<?= $csomag["id"]?>">Kosárhoz adás <i class="fa-solid fa-cart-plus"></i></button>
                                <input type="hidden" name="csomagnev" value="<?= $csomag["nev"]?>">
                            </form>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <button class="btn btn-controll" onclick="showNextCard()"><i class="fa-solid fa-chevron-right"></i></button> 

        </section>

        <section id="kapcsolat">

        </section>
    </main>

    <?php
        if (isset($_POST["addcart"])) {
            $_SESSION["kosar"][] = array(
                "id" => $_POST["addcart"], 
                "nev" => $_POST["csomagnev"],
                "fo" => 1);
            unset($_POST["addcart"]);
            echo '<script>document.getElementById("hosszuleiras").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});</script>';
        }
    ?>

    <footer>
        <section>
            <h3>Ide lehetnek ilyen dolgok</h3>
        </section>
        <section>
            <h3>Hogy KAPCSOLAT pl</h3>
            <ul>
                <li>random telefonszám +369696969</li>
                <li>meoww</li>
                <li>cicákat akarok most ide most gimme</li>
            </ul>
        </section>
        <section>
            <h3>Térkép?</h3>
            <div class="maps-container">
                <iframe width="100%" height="100%"
                    src="https://maps.google.com/maps?width=100&amp;height=100&amp;hl=en&amp;q=dunasziget%20nefelejcs%20utca%2064+(Rudolf%20Vend%C3%A9gh%C3%A1z%2C%20Dunasziget)&amp;ie=UTF8&amp;t=p&amp;z=10&amp;iwloc=B&amp;output=embed"
                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                </iframe>
            </div>
        </section>
    </footer>
</body>

</html>