
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

    //@ ignorálja az errorokat, így nem jelenik meg az oldalon. később kezeljük.
    $raw_data = file_get_contents($url, false, $context);
    $data = json_decode($raw_data, true);


    //KOSÁR
    session_start();
    if (!isset($_SESSION["kosar"])) { $_SESSION["kosar"] = array(); }

    if (isset($_POST["addcart"])) {
        $_SESSION["kosar"][] = array(
            "id" => $_POST["addcart"], 
            "nev" => $_POST["csomagnev"],
            "fo" => 1);
        unset($_POST["addcart"]);
        //odaugrik 
        echo '<script>document.getElementById("#bovebben").scrollIntoView({behavior: "smooth", block: "start", inline: "nearest"});</script>';
    }    
?>


<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bolyGO</title>
    <link rel="shortcut icon favicon" href="styles/img/logo_ikon.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/style.css">
    <script defer src="https://kit.fontawesome.com/af2e246792.js" crossorigin="anonymous"></script>
    <script defer src="./js/design.js"></script>
</head>

<body>
    <nav data-state="closed" data-scrolled="false">
        <div class="nav-first-row">
            <img class="logo" src="styles/img/logo_transparent.png" alt="bolyGO logo">
            <a href="./cart.php" class="btn mobile-btn" ><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="#" class="btn btn-dark mobile-btn" onclick="toggleNav();"><i class="fa fa-bars"></i></a>
        </div>
      
        <a class="navlink" href="#csomagok" data-active="true">Csomagok</a>
        <a class="navlink" href="#rolunk">Rólunk</a>
        <a class="navlink" href="#kapcsolat">Kapcsolat</a>
        <a class="btn pc-btn btn-auto-hover" href="./cart.php">Kosár <i class="fa-solid fa-cart-shopping"></i></a>
    </nav>


    <header id="index-header">
        <div class="header-content">
            <h1> <span>bolyGO</span> <br> utazási iroda</h1>
            <p>Utazz epikus bolygókra!!</p>
            <div><a class="btn btn-light" href="#csomagok">Csomagok </a></div>
        </div>
        <img class="scrolling-planet" src="./styles/img/planet.png" alt="Planet">
    </header>



    <main id="index-main">
        <section id=rolunk>
            <h2>Rólunk <i class="fa-solid fa-user-astronaut"></i></h2>
            <p>Utaztatunk and shit és nagyon szuperek vagyunk. Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Blanditiis, quos.</p>
            <div class="card-container rolunk-cards">
                <div class="card" data-color="green">
                    <img class="small-card-img" src="styles/img/sityu.jpg" alt="Sityu">
                    <div class="card-content">
                        <h3>Sityu</h3>
                        <p class="description">Hol vagyok?</p>
                    </div>
                </div>
                <div class="card" data-color="yellow">
                    <img class="small-card-img" src="styles/img/levi.png" alt="Levi">
                    <div class="card-content">
                        <h3>Levi</h3>
                        <p class="description">MIAUUUUU</div>
                </div>
                <div class="card" data-color="pink">
                    <img class="small-card-img" src="styles/img/tunde.jpg" alt="Tünde">
                    <div class="card-content">
                        <h3>Tünde</h3>
                        <p class="description"><--- that's my boyfren c:</p>
                    </div>
                </div>
            </div>

        </section>


        <section id="csomagok">
            <h2>Csomagjaink  <i class="fa-solid fa-shuttle-space"></i></h2>
            <div class="card-container csomag-cards">
                <!-- kártyák random színéhez kell -->
                <!-- pirosat kivettem -->
                <?php $colors = ['green', 'yellow', 'pink', 'purple'];?>

                <!-- csomagok kis kártyái -->
                    <?php if ($data !== null): ?>
                        <?php foreach ($data as $csomag): ?>
                            <div class="card" data-csomagid="<?= $csomag["id"] ?>" data-color="<?= $colors[array_rand($colors)] ?>">
                                <img class="small-card-img" src="<?= './styles/csomag_img/' . $csomag["id"] . '.png' ?>" alt="<?= $csomag["nev"] . ' képe' ?>">
                                <div class="card-content">
                                    <h3><?= $csomag["nev"] ?></h3>
                                    <p class="description"><?= $csomag["leiras"] ?></p>
                                    <button class="btn btn-light btn-auto-hover" onclick='jumpTo(<?= $csomag["id"] ?>)'>Részletek <i class="fa-solid fa-circle-chevron-down"></i></button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="error">
                            <h3><i class="fa-solid fa-triangle-exclamation"></i> HIBA! A csomagok megjelenítése sikertelen volt.</h3>
                            <p>Az adatbázis elérése közben hiba merült fel. A következő lépéseket teheti a hiba elhárítása érdekében:</p>
                            <ol>
                                <li>Telepítse a <a href="http://www.apachefriends.org/download.html" target="_blank" rel="noopener noreferrer">XAMPP alkalmazás</a>t majd indítsa el az APACHE és MySQL szolgáltatásokat a XAMPP segítségével.</li>
                                <li>Ellenőrizze a <a href="http://127.0.0.1/phpmyadmin/" target="_blank" rel="noopener noreferrer">phpMyAdmin</a> felületén, hogy a bolyGO_db létrehozása sikeres volt-e, és az adatok feltöltése megtörtént-e.</li>
                                <li>Ha a hiba továbbra is fennáll, forduljon hozzánk a megadott elérhetőségek egyikén.</li>
                            </ol>
                        </div>
                    <?php endif; ?>

            </div>
        </section>

        <section id="bovebben" class="full-width dark-blur">
            <h2>Tudj meg többet a csomagról</h2>
            <button class="btn btn-control" onclick="showPrevCard()"><i class="fa-solid fa-chevron-left"></i></button> 

            <div class="bovebben-cards"> 
                <?php if ($data !== null): ?>
                    <?php foreach ($data as $csomag):?>
                        <div class="card big-card card-hidden" data-csomagid="<?= $csomag["id"]?>" data-color="">
                            <img class="big-card-img" src="<?= './styles/csomag_img/'.$csomag["id"].'.png'?>" alt="<?= $csomag["nev"].' képe'?>">
                
                            <div class="card-content">
                                <h3><?= $csomag["nev"]?></h3>
                                <h4><?= $csomag["bolygo"]?> <i class="fa-solid fa-meteor"></i></h4>
                                <p><?= $csomag["leiras"]?></p>
                            </div>

                            <div class="card-content">
                                <p>Választható dátum: <?= $csomag["kezdido"]?> - <?= $csomag["vegido"]?></p>
                                <p>Választható járművek <i class="fa-solid fa-rocket"></i></p>
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
                                    <button class="btn btn-auto-hover" name="addcart" value="<?= $csomag["id"]?>">Kosárhoz adás <i class="fa-solid fa-cart-plus"></i></button>
                                    <input type="hidden" name="csomagnev" value="<?= $csomag["nev"]?>">
                                </form>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php else: ?>
                    <div class="error">
                        <h3><i class="fa-solid fa-triangle-exclamation"></i> HIBA! A csomagok részletes leírásának megjelenítése sikertelen volt.</h3>
                        <p>Az adatbázis elérése közben hiba merült fel. A következő lépéseket teheti a hiba elhárítása érdekében:</p>
                        <ol>
                            <li>Telepítse a <a href="http://www.apachefriends.org/download.html" target="_blank" rel="noopener noreferrer">XAMPP alkalmazás</a>t majd indítsa el az APACHE és MySQL szolgáltatásokat a XAMPP segítségével.</li>
                            <li>Ellenőrizze a <a href="http://127.0.0.1/phpmyadmin/" target="_blank" rel="noopener noreferrer">phpMyAdmin</a> felületén, hogy a bolyGO_db létrehozása sikeres volt-e, és az adatok feltöltése megtörtént-e.</li>
                            <li>Ha a hiba továbbra is fennáll, hozzánk a megadott elérhetőségek egyikén.</li>
                        </ol>
                    </div>
                <?php endif; ?>
            </div>

            <button class="btn btn-control" onclick="showNextCard()"><i class="fa-solid fa-chevron-right"></i></button> 
        </section>

        <section id="kapcsolat">
            <h2>Kapcsolat <i class="fa-solid fa-envelope"></i></h2>
            <div class="card dark-blur card-content">
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="name">Név:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Üzenet:</label>
                        <textarea id="message" name="message" rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-light">Küldés <i class="fa-solid fa-circle-check"></i></button>
                </form>
            </div>
        </section>
    </main>

    <footer class="dark-blur">
        <section>
            <h3>Nav</h3>
            <a href="#csomagok">Csomagok</a>
            <a href="#rolunk">Rólunk</a>
            <a href="#kapcsolat">Kapcsolat</a>
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
        <!-- src="https://maps.google.com/maps?width=100&amp;height=100&amp;hl=en&amp;q=dunasziget%20nefelejcs%20utca%2064+(Rudolf%20Vend%C3%A9gh%C3%A1z%2C%20Dunasziget)&amp;ie=UTF8&amp;t=p&amp;z=10&amp;iwloc=B&amp;output=embed" -->

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

</html>