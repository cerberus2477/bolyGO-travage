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
        <section>
            <h2>Rólunk</h2>
            <p>Utaztatunk and shit és nagyon szuperek vagyunk. Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Blanditiis, quos.</p>
            <div class="rolunk-container">
                <div class="card" data-color="yellow">
                    <div class="card-image">
                        <img src="styles/img/levi.png" alt="Levi">
                    </div>
                    <div class="card-content">
                        <h2>Levi</h2>
                        <p class="description">MIAUUUUU
                    </div>
                </div>
                <div class="card" data-color="pink">
                    <div class="card-image">
                        <img src="styles/img/tunde.jpg" alt="Tünde">
                    </div>
                    <div class="card-content">
                        <h2>Tünde</h2>
                        <p class="description">
                            <--- that's my boyfren c:</p>
                    </div>
                </div>
                <div class="card" data-color="green">
                    <div class="card-image">
                        <img src="styles/img/sityu.jpg" alt="Sityu">
                    </div>
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
                    $url = "http://".implode("/",array_map('rawurlencode',explode("/",$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/api.php")));
                    $options = array(
                        'http' => array(
                            'method' => 'GET',
                            'header' => 'Content-Type: application/json'
                        )
                    );
                    $context = stream_context_create($options);
                    $data = json_decode(file_get_contents($url, false, $context), true);
                     // $colors = ['green', 'red', 'yellow', 'pink', 'purple'];
                    // <?$colors[array_rand($colors)]
                ?>

                <!-- jó lenne random szín or smth -->
                <?php foreach ($data as $item):?>
                    <div class="card" data-color="" data-csomagid="<?= $item["id"]?>">
                        <div class="card-image">
                            <!-- kepek forrasa?? -->
                            <img src="<?= './resources/'.$item["nev"].'img'?>" alt="<?= $item["nev"].' képe'?>">
                        </div>
                        <div class="card-content">
                            <h2><?= $item["nev"]?></h2>
                            <p class="description"><?= $item["leiras"]?></p>
                            <button class="btn btn-light icon-btn">Részletek <i class="fa-solid fa-circle-chevron-down"></i></button>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <!-- grid? -->
            <div id="csomag-bovebben" class="card big-card" data-csomagid="szam">

                <img src="./resources/logo.ico" alt="dolog">

                <div>
                    <h2>Cyperpunknesss bolygóshit</h2>
                    <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
                </div>
                <div>
                    <!-- generálni -->
                    <p>Választható dátum: 9999.99.99 - 6666.66.66</p>
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
                            <!-- ezt generálni kéne -->
                            <tr>
                                <td>János</td>
                                <td>9. osztály</td>
                                <td>8</td>
                                <td>5000 Ft</td>
                            </tr>
                            <!-- eddig -->
                        </tbody>
                    </table>
                    <button class="btn icon-btn">Kosárhoz adás <i class="fa-solid fa-cart-plus"></i></button>
                </div>


            </div>

        </section>
    </main>

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