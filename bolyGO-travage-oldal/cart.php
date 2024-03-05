<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bolyGO | Kosár</title>
    <link rel="shortcut icon favicon" href="styles/img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/cart.css">
    <script defer src="https://kit.fontawesome.com/af2e246792.js" crossorigin="anonymous"></script>
    <script defer src="./js/cartApp.js"></script>
</head>
</head>
<body>

    <nav class="main-nav" data-state="closed" data-scrolled="false">
        <div class="nav-first-row">
            <a class="logo" href="./index.php">
                <img class="logo" src="styles/img/logo_transparent.png" alt="bolyGO logo">
            </a>
            
            <a href="./cart.php" class="btn mobile-btn" ><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="#" class="btn btn-dark mobile-btn" onclick="toggleNav();"><i class="fa fa-bars"></i></a>
        </div>

        <a href="programok.html">Csomagok</a>
        <a href="galeria.html">Rólunk</a>
        <a href="">Kapcsolat</a>
        <a class="btn pc-btn icon-btn" href="./index.php">Vissza <i class="fa-solid fa-arrow-left"></i></a>
    </nav>

    <header class="header-cart">
        <div class="header-content">
            <h1>Kosár</h1>
        </div>
    </header>



    
    <main class="main-cart">
        <!--kiírja a $_SESSION-ből a kosár tartalmát (az emberek száma változtatható)-->
        <!-- <table>
        <?php $orderNum = 0;?>
        <?php foreach ($_SESSION["kosar"] as $item):?> 
            <?php $orderNum++;?>
            <tr class="lineOfCart" id="line_<?= $item["id"]?>">
                <td class="orderNum"><?= $orderNum?>.</td>
                <td>
                    <p class="name">Csomagnév: <b><?= $item["nev"]?></b></p>
                    <p>Utazók száma: <input type="number" name="<?= "numOfPeople_".$item["id"]?>" value="<?= $item["fo"]?>"><button class="delete" name="deleteElement" value="<?=$item["id"]?>">Töröl</button></p>
                    <input type="hidden" name="id" value="<?=$item["id"]?>">
                </td>
            </tr>
        <?php endforeach ?>
        </table> -->

<!-- 
        <table>
            <tr class="lineOfCart" id="line_id">
                <td class="orderNum">ordernum</td>
                <td>
                    <p class="name">Csomagnév: <b>nééééév</b></p>
                    <p>Utazók száma: 
                        <input type="number" name="num" value="2">
                        <button class="delete" name="deleteElement" value="2">Töröl</button>
                    </p>
                    <input type="hidden" name="id" value="id">
                </td>
            </tr>
        </table> -->



        <div class="cart">
        <?php
            // Sample data
            $items = array(
                array("image" => "item1.jpg", "name" => "Item 1", "description" => "Lorem ipsum dolor sit amet", "price" => 10),
                array("image" => "item2.jpg", "name" => "Item 2", "description" => "Consectetur adipiscing elit", "price" => 15),
                array("image" => "item3.jpg", "name" => "Item 3", "description" => "Sed do eiusmod tempor incididunt", "price" => 20)
            );
        ?>

        <?php foreach ($items as $item):?>
            
            <div class="item">
                <img src="images/<?php echo $item["image"]; ?>" alt="<?php echo $item["name"]; ?>">
                <div class="details">
                    <h2><?php echo $item["name"]; ?></h2>
                    <p><?php echo $item["description"]; ?></p>
                    <p>$<?php echo $item["price"]; ?></p>
                </div>
                <div class="actions">
                    <input type="number" class="quantity" value="1" min="1">
                    <button class="delete">Delete</button>
                </div>
            </div>

        <?php endforeach;?>
        <div id="total-price">Total: $0.00</div> <!-- Total price element -->

        
    </div>
    
</div>
    </div>



    </main>

</body>
    

</html>






