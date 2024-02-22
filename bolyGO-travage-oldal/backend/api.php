<?php

//header('Content-Type: application/json; charset=utf-8');

echo "uuhu";

switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["csomagid"])) getCsomag($_GET["csomagid"]);
        else getCsomagok();
        break;
    case "POST":
        foglal();
        break;
    default:
        echo "uwu";
        break;
}

//csomagok leírásának, nevének, azonosítójának lekérése
function getCsomagok() {
    $sql = "SELECT";
    connectDB();
    //*lekérés*
    closeDB();
}

//egy csomag adatainak lekérése a csomagid alapján
function getCsomag($csomagid) {
    $sql = "SELECT";
    connectDB();
    //*lekérés*
    closeDB();
}

//foglalások feltöltése az adatbázisba
function foglal() {
    connectDB();
    //*lekérés*
    closeDB();
}

//kapcsolódás az adatbázishoz
function connectDB() {
    try {
        $adb = mysqli_connect( "localhost", "root", "", "bolygodb" );
    } catch (Exception $e) {
        hibauzenet($e);
    }
}

//adatbáziskapcsolat bezárása
function closeDB() {
    try {
        mysqli_close( $adb ) ;
    } catch (Exception $e) {
        hibauzenet($e);
    }
}

//hibaüzenet visszaküldése
function hibauzenet($e) {
    $uzenet = array("hiba" => "SQL-hiba", "uzenet" => "Nem sikerült csatlakozni az adatbázishoz. Hibaüzenet: ".$e->getMessage());
    $json = json_encode($uzenet);
    exit($json);
}

echo "cukiság";