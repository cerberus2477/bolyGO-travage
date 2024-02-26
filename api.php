<?php

header('Content-Type: application/json; charset=utf-8');

switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["csomagid"])) getCsomag($_GET["csomagid"]);
        else getCsomagok();
        break;
    case "POST":
        foglal();
        break;
    default:
        hibauzenet("API-hívás hiba", "Ismeretlen hívás típus.");
}

//csomagok leírásának, nevének, azonosítójának lekérése
function getCsomagok() {
    $sql = "SELECT id, nev, leiras FROM csomag WHERE id > -1";
    $csomagok = array();
    $tabla = runQuery($sql);
    while ($sor = mysqli_fetch_array($tabla)) {
        $csomagok[] = array("id" => $sor["id"], "nev" => $sor["nev"], "leiras" => $sor["leiras"]);
    }

    echo json_encode($csomagok);
    //echo json_encode($csomagok, JSON_PRETTY_PRINT);
}

//egy csomag adatainak lekérése a csomagid alapján
function getCsomag($csomagid) {
    $sql = "SELECT csomag.nev AS csomagnev, csomag.leiras, bolygo.nev AS bolygonev, csomag.kezdes, csomag.vege, csomag.ar FROM csomag INNER JOIN bolygo ON csomag.bolygoid = bolygo.id WHERE csomag.id = ".$csomagid;
    $csomag = array();
    $tabla = runQuery($sql);
    $sor = mysqli_fetch_array($tabla);
    print_r($sor);
    $csomag["nev"] = $sor["csomagnev"];
    $csomag["leiras"] = $sor["leiras"];
    $csomag["bolygo"] = $sor["bolygonev"];
    $csomag["kezdido"] = $sor["kezdes"];
    $csomag["vegido"] = $sor["vege"];
    $csomag["csomagar"] = $sor["ar"];

    //lequerizni a jarmuveket és tömbbe rakni
    
    echo json_encode($csomag, JSON_PRETTY_PRINT);
    /*{
    "nev": "Csomagnév",
    "leiras": "Nagyon jó hely",
    "bolygo": "Mars",
    "kezdido": "2024-02-10",
    "vegido": "2024-09-30",
    "csomagar": 9700, 
    "jarmuvek": [
        {
            "nev":"Busz",
            "osztaly":3,
            "fekvohely":false,
            "ar": 990
        },
        {
            "nev":"Vonat1",
            "osztaly":2,
            "fekvohely":false,
            "ar": 1200
        },
        {
            "nev":"Vonat2",
            "osztaly":1,
            "fekvohely":true,
            "ar": 2190
        }
    ]
}*/
}

//foglalások feltöltése az adatbázisba
function foglal() {
}

//SQL lekérdezés lefuttatása
function runQuery($sql) {
    try {
        $adb = mysqli_connect( "localhost", "root", "", "bolygo_db" );
        $tabla = mysqli_query( $adb, $sql );
        mysqli_close( $adb );
        return $tabla;
    } catch (Exception $e) {
        SQL_Hibauzenet($e);
    }
}

//SQL hibaüzenet visszaküldése
function SQL_Hibauzenet($e) {
    $uzenet = array("hiba" => "SQL-hiba", "uzenet" => "Nem sikerült csatlakozni az adatbázishoz. Hibaüzenet: ".$e->getMessage());
    $json = json_encode($uzenet);
    exit($json);
}

//saját hibaüzenet visszaküldése
function hibauzenet($hibatipus, $hibauzenet) {
    $uzenet = array("hiba" => $hibatipus, "uzenet" => "Hiba: ".$hibauzenet);
    $json = json_encode($uzenet);
    exit($json);
}