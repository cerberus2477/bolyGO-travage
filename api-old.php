<?php

// api működéséhez szükséges paraméterek
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json; charset=utf-8');

// DB SETUP
$isDB = false;
runNonQuery(file_get_contents("bolygo_db.sql"));
$isDB = true;
runNonQuery(file_get_contents("data.sql"));

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["csomagid"])) getCsomag($_GET["csomagid"], false);
        else getCsomagok();
        break;
    case "POST":
        foglal();
        break;
    default:
        hibauzenet(405, "API-hívás hiba", "Ismeretlen hívás típus.");
}

//csomagok adatainak lekérése
function getCsomagok()
{
    $sql = "SELECT id FROM csomag WHERE id > -1";
    $tabla = runQuery($sql);
    $csomagok = array();
    while ($sor = mysqli_fetch_array($tabla)) {
        $csomagok[] = getCsomag($sor["id"], true);
    }

    http_response_code(200);
    echo json_encode($csomagok);
    //echo json_encode($csomagok, JSON_PRETTY_PRINT);
}

//egy csomag adatainak lekérése a csomagid alapján
function getCsomag($csomagid, $return)
{
    $csomag = array();

    $sql = "SELECT csomag.id AS id, csomag.nev AS csomagnev, csomag.leiras, bolygo.nev AS bolygonev, csomag.kezdes, csomag.vege, csomag.ar FROM csomag INNER JOIN bolygo ON csomag.bolygoid = bolygo.id WHERE csomag.id = " . $csomagid;
    $tabla = runQuery($sql);
    $sor = mysqli_fetch_array($tabla);

    $csomag["id"] = $sor["id"];
    $csomag["nev"] = $sor["csomagnev"];
    $csomag["leiras"] = $sor["leiras"];
    $csomag["bolygo"] = $sor["bolygonev"];
    $csomag["kezdido"] = $sor["kezdes"];
    $csomag["vegido"] = $sor["vege"];
    $csomag["csomagar"] = intval($sor["ar"]);

    //csomaghoz választható járművek adatai
    $sql = "SELECT jarmu.nev, jarmu.osztaly, jarmu.fekvohely, csomagjarmu.ar FROM csomagjarmu INNER JOIN jarmu ON csomagjarmu.jarmuid = jarmu.id WHERE csomagjarmu.csomagid = " . $csomagid;
    $tabla = runQuery($sql);
    $csomag["jarmuvek"] = array();

    while ($sor = mysqli_fetch_array($tabla)) {
        $csomag["jarmuvek"][] = array(
            "nev" => $sor["nev"],
            "osztaly" => intval($sor["osztaly"]),
            "fekvohely" => boolval($sor["fekvohely"]),
            "ar" => intval($sor["ar"])
        );
    }

    if ($return) return $csomag;
    else {
        http_response_code(200);
        echo json_encode($csomag);
    }
}

//foglalások feltöltése az adatbázisba
function foglal()
{
    $data = json_decode(file_get_contents('php://input'), true);

    try {
        //foglalás számosságának tesztelése: 
        //ha csak 1 elem van, csak azt kell feltölteni, ha több, akkor mindet külön
        if (!isset($data[0])) {
            uploadtoDB($data);
        } else {
            foreach ($data as $elem) {
                uploadtoDB($elem);
            }
        }

        $d = array("eredmeny" => "Foglalás sikeresen rögzítve.");
        http_response_code(201);
        echo json_encode($d);
    } catch (Exception $e) {
        $d = array("eredmeny" => "Hiba az adatbázisba feltöltés során: " . $e->getMessage());
        http_response_code(500);
        echo json_encode($d, JSON_PRETTY_PRINT);
    }
}

//egy foglalás feltöltése az adatbázisba
function uploadtoDB($adatok)
{
    //1. foglalás hozzáadása
    $foglalasid = mysqli_fetch_array(runQuery("SELECT COUNT(*) AS db FROM `foglalas`"))["db"] + 1;
    $sql = "INSERT INTO foglalas (id, csomagid, kezdes, vege, ar) VALUES ($foglalasid," . $adatok["csomagid"] . ",' " . $adatok["kezdido"] . "',' " . $adatok["vegido"] . "', " . $adatok["ar"] . ")";
    runNonQuery($sql);

    //2. ügyfelek hozzáadása
    $ugyfelek = array();
    foreach ($adatok["ugyfelek"] as $ugyfel) {
        $ugyfelid = mysqli_fetch_array(runQuery("SELECT COUNT(*) AS db FROM `ugyfel`"))["db"] + 1;
        $ugyfelek[] = $ugyfelid;
        $sql = "INSERT INTO ugyfel (id, nev, lakcim, szul, nem, tel, email) VALUES ($ugyfelid, '" . $ugyfel["nev"] . "', '" . $ugyfel["lakcim"] . "', '" . $ugyfel["szul"] . "', '" . $ugyfel["nem"] . "', '" . $ugyfel["tel"] . "', '" . $ugyfel["email"] . "')";
        runNonQuery($sql);
    }

    //3. ügyfelek-foglalás összekapcsolása
    foreach ($ugyfelek as $ugyfelid) {
        $sql = "INSERT INTO csoport (foglalasid, ugyfelid) VALUES ($foglalasid, $ugyfelid);";
        runNonQuery($sql);
    }
}

//SQL lekérdezés lefuttatása
function runQuery($sql)
{
    try {
        global $isDB;
        //ha van már adatbázis oda csatlakozik, ha nincs akkor csak localhostra
        $adb =  mysqli_connect("localhost", "root", "", $isDB ? "bolygo_db" : "");
        $tabla = mysqli_query($adb, $sql);
        mysqli_close($adb);
        return $tabla;
    } catch (Exception $e) {
        SQL_Hibauzenet($e);
    }
}

//SQL módosító parancs lefuttatása
function runNonQuery($sql)
{
    try {
        global $isDB;
        //ha van már adatbázis oda csatlakozik, ha nincs akkor csak localhostra
        $adb =  mysqli_connect("localhost", "root", "", $isDB ? "bolygo_db" : "");
        mysqli_query($adb, $sql);
        mysqli_close($adb);
    } catch (Exception $e) {
        SQL_Hibauzenet($e);
    }
}

// SQL hibaüzenet visszaküldése
function SQL_Hibauzenet($e)
{
    $uzenet = array("hiba" => "SQL-hiba", "uzenet" => "Nem sikerült csatlakozni az adatbázishoz. Hibaüzenet: " . $e->getMessage());
    $json = json_encode($uzenet);
    http_response_code(500);
    exit($json);
}

//saját hibaüzenet visszaküldése
function hibauzenet($hibakod, $hibatipus, $hibauzenet)
{
    $uzenet = array("hiba" => $hibatipus, "uzenet" => "Hiba: " . $hibauzenet);
    http_response_code($hibakod);
    $json = json_encode($uzenet);
    exit($json);
}