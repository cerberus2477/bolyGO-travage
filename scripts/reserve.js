function kiszamolAr(csomagar, fo, csomagid) {
    let kezdes = new Date(document.getElementById(csomagid + "_kezd").value);
    let vege = new Date(document.getElementById(csomagid + "_vege").value);
    let kulonbseg = vege.getTime() - kezdes.getTime();
    let napok = kulonbseg / (1000*3600*24);
    let osszeg = napok*fo*csomagar + parseInt(document.getElementById(csomagid+"_jarmu").value)*fo*2;
    if (isFinite(osszeg)) {
        document.getElementById(csomagid).innerText = "Ezen foglalásért fizetendő: " + osszeg + " kobalt.";
        document.getElementById(csomagid+"_ar").value = osszeg;
    }
    else {
        document.getElementById(csomagid).innerText = "Nincs elegendő adat az foglalás árának kiszámításához.";
        document.getElementById(csomagid+"_ar").value = 0;
    }
}

function closedetails(sorszam) {
    document.getElementById('details_'+sorszam).open = false;
}

function opendetails(sorszam) {
    document.getElementById('details_'+sorszam).open = true;
}

// alapból megnyitjuk az első formot
opendetails(1);

function changeDetails(from, to) {
    closedetails(from);
    opendetails(to);
    document.getElementById('details'+to).scrollIntoView();
}

function setDateBoundaries(csomagid) {
    let kezd = document.getElementById(csomagid+"_kezd");
    let vege = document.getElementById(csomagid+"_vege");
    if (kezd.value != "") vege.min = kezd.value;
    if (vege.value != "") kezd.max = vege.value;
}