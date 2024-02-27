<?php

header('Content-Type: application/json; charset=utf-8');

switch ($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        if (isset($_GET["csomagid"]))
            getCsomag($_GET["csomagid"]);
        else
            getCsomagok();
        break;
    case "POST":
        foglal();
        break;
    default:
        hibauzenet("API-hívás hiba", "Ismeretlen hívás típus.");
}

//csomagok leírásának, nevének, azonosítójának lekérése
function getCsomagok()
{
    $sql = "SELECT id, nev, leiras FROM csomag WHERE id > -1";
    $csomagok = array();
    $tabla = runQuery($sql);
    while ($sor = mysqli_fetch_array($tabla)) {
        $csomagok[] = array(
            "id" => intval($sor["id"]),
            "nev" => $sor["nev"],
            "leiras" => $sor["leiras"]
        );
    }

    echo json_encode($csomagok);
    //echo json_encode($csomagok, JSON_PRETTY_PRINT);
}

//egy csomag adatainak lekérése a csomagid alapján
function getCsomag($csomagid)
{
    $csomag = array();

    $sql = "SELECT csomag.nev AS csomagnev, csomag.leiras, bolygo.nev AS bolygonev, csomag.kezdes, csomag.vege, csomag.ar FROM csomag INNER JOIN bolygo ON csomag.bolygoid = bolygo.id WHERE csomag.id = " . $csomagid;
    $tabla = runQuery($sql);
    $sor = mysqli_fetch_array($tabla);

    $csomag["nev"] = $sor["csomagnev"];
    $csomag["leiras"] = $sor["leiras"];
    $csomag["bolygo"] = $sor["bolygonev"];
    $csomag["kezdido"] = $sor["kezdes"];
    $csomag["vegido"] = $sor["vege"];
    $csomag["csomagar"] = intval($sor["ar"]);

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

    echo json_encode($csomag);
    //echo json_encode($csomag, JSON_PRETTY_PRINT);
}

//foglalások feltöltése az adatbázisba
function foglal()
{
}

//SQL lekérdezés lefuttatása
function runQuery($sql)
{
    try {
        $adb = mysqli_connect("localhost", "root", "", "bolygo_db");
        $tabla = mysqli_query($adb, $sql);
        mysqli_close($adb);
        return $tabla;
    } catch (Exception $e) {
        SQL_Hibauzenet($e);
    }
}

//SQL hibaüzenet visszaküldése
function SQL_Hibauzenet($e)
{
    $uzenet = array("hiba" => "SQL-hiba", "uzenet" => "Nem sikerült csatlakozni az adatbázishoz. Hibaüzenet: " . $e->getMessage());
    $json = json_encode($uzenet);
    exit($json);
}

//saját hibaüzenet visszaküldése
function hibauzenet($hibatipus, $hibauzenet)
{
    $uzenet = array("hiba" => $hibatipus, "uzenet" => "Hiba: " . $hibauzenet);
    $json = json_encode($uzenet);
    exit($json);
}