INSERT IGNORE INTO bolygo (id, nev)
VALUES
(1, 'Aranyföld'),
(2, 'Palnet 4546B'),
(3, 'Cadia'),
(4, 'Hoxxies'),
(5, 'MEOW');

INSERT IGNORE INTO jarmu (id, nev, osztaly, fekvohely)
VALUES
(1, 'Santa Maria', 1, true),
(2, 'Küklopsz-modell-LightSpeed', 4, false),
(3, 'Aurora', 2, true),
(4, 'Császári Csatabárka', 6, true),
(5, 'Drop Pod', 1, true),
(7, 'Scythe osztályú hajó', 8, true),
(8, 'THE MEOWer', 1, true);

INSERT IGNORE INTO csomag (id, nev, leiras, bolygoid, kezdes, vege, ar)
VALUES
(1, 'Aranyföldi Kalandok', 'Fedezze fel az Aranyföld rejtett kincseit ezen a lenyűgöző utazáson, miközben felfedezzük a bolygó aranyhomokkal borított tájait és ragyogó naplementéjét. Hódítson meg új területeket és tapasztalja meg az Aranyföld különleges atmoszférájában erzékelhető különös viharokat. Ez az utazás emlékezetes élményeket kínál az aranyra vágyó utazóknak. (opcionálisan pusztítsa ki az itt élő törzseket)', 1, '2492-08-03', '2493-01-01', 18800),
(2, 'Mélymerülés nautica alatt', 'Szereti a vizi világokat? Netán szeretne ismeretlen bioszférékat felfedezni? Akkor merüljön el ebben a lélegzetelállító bolygó szépségeiben! (Van információnk egy jelenleg folyó karanténról a bolygó egészén, de biztosak vagyunk benne, hogy a kovid közben ehhez már hozzászoktunk.)', 2, '2284-08-15', '2284-08-25', 2000),
(3, 'Nautica alatti jégparty', 'Szereti a vizi világokat? Netán szeretne ismeretlen bioszférékat felfedezni? Nem zavarja önt a hideg? Akkor merüljön el ebben a lélegzetelállító bolygó szépségeiben!', 2, '2286-08-15', '2286-08-25', 2000),
(4, 'Jeges kiruccanás Hoxxis-on', 'Elege van már az Ausztrál forróságból, esetleg a klímaváltozás mellékhatásaival nincs megelégedve, cserébe nem akar megválni Ausztrália többi jellemzőétől? Cégünk pont erre a problémára kínál megoldást a Hoxxies nevű bolygón, ahol némi jelentéktelen ízeltlábú problémán kívül felhőtlenül kapcsolódhat ki egy kis aranybányászat mellett akár egész családjával (történelmi rekordokból tudjuk hogy a gyermekek élvezik ezt a legjobban)', 4, '2024-09-10', '2024-09-20', 2200),
(5, 'Biológiai kutatás a Hoxxis-on', 'Fedezezze fel a gombás lápokat a Hoxxies nevű bolygón, ahol némi jelentéktelen ízeltlábú problémán kívül felhőtlenül kapcsolódhat ki egy kis aranybányászat mellett akár egész családjával.', 4, '2024-10-05', '2024-10-15', 2500),
(6, 'Cadia eleste', 'Fedezd fel az elpusztult Cadia tragédiájának lenyűgöző látványát egy különleges úton! légy tanúja annak, hogyan vált az egykor büszke bástyaváros a pusztulás színhelyévé. Ne hagyd ki ezt a lehetőséget, hogy részese lehess egy olyan kalandnak, amely feledhetetlen élményekkel gazdagít!', 3, '4998-12-01', '4999-12-30', 2300),
(7, 'MEOW', 'Szeretettel várunk a MEOW bolygón! Itt minden cica boldogan ugrándozik, és a "MEOWer" űrhajóval való utazás még soha nem volt ilyen kényelmes és izgalmas! Fedezd fel a végtelen kalandokat, a puhábbnál puhább kényelmet és a csillagok közötti legfinomabb cicafalatokat. Lépj be a MEOW világába, ahol minden cica egy csillag!', 5, '1500-01-01', '9999-12-31', 3000);

INSERT IGNORE INTO csomagjarmu (csomagid, jarmuid, ar)
VALUES
(1, 1, 10000),
(2, 2, 1500),
(2, 3, 5000),
(3, 2, 900),
(3, 3, 0),
(4, 5, 24000),
(5, 5, 25100),
(6, 4, 1500),
(6, 7, 2000),
(7, 8, 0);