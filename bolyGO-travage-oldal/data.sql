INSERT INTO bolygo (id, nev) 
VALUES 
(1, 'Aranyföld'), 
(2, 'Zafírvilág'), 
(3, 'Kristálybolygó'), 
(4, 'Tündérvilág'), 
(5, 'Csillagkert'), 
(6, 'Galaktikus Gyöngy'), 
(7, 'Varázshegy'), 
(8, 'Csillagporos'), 
(9, 'Mélyűr'), 
(10, 'Kozmikus Kert'), 
(11, 'Csillagfény'), 
(12, 'Káprázatbolygó');

INSERT INTO jarmu (id, nev, osztaly, fekvohely) 
VALUES 
(1, 'Csillagharcos', 7, true),
(2, 'Ködfutár', 8, true),
(3, 'Asztron Futár', 6, false),
(4, 'Végtelen Felfedező', 9, true),
(5, 'Galaktikus Utazó', 8, true),
(6, 'Kozmo Futur', 7, false),
(7, 'Egei Nomád', 6, true),
(8, 'Napvitorlás', 5, false),
(9, 'Űrjáró', 8, true),
(10, 'Csillagálmodó', 9, true);

INSERT INTO csomag (id, nev, leiras, bolygoid, kezdes, vege, ar) 
VALUES 
(1, 'Aranyföldi Kalandok', 'Fedezze fel az Aranyföld rejtett kincseit ezen a lenyűgöző utazáson, miközben felfedezzük a bolygó aranyhomokkal borított tájait és ragyogó naplementéjét. Hódítson új területeket és tapasztalja meg az Aranyföld különleges atmoszféráját a csillagok között. Ez az utazás emlékezetes élményeket kínál az aranyra vágyó utazóknak.', 1, '2024-07-01', '2024-07-10', 1800),
(2, 'Zafírvilági Ugrás', 'Merüljön el a Zafírvilág csodálatos kék tengerében ezen a lenyűgöző körúton, miközben felfedezzük a bolygó zafírhomokkal borított partjait és kristálytiszta vizét. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Zafírvilág különleges élővilágát és tengeri titkait. Tapasztalja meg a kék varázslatot, miközben átsiklik a Zafírvilág égszínkék égen.', 2, '2024-08-15', '2024-08-25', 2000),
(3, 'Kristálybolygói Expedíció', 'Utazzon a Kristálybolygó rejtett barlangjaiba ezen a kalandos utazáson, miközben felfedezzük a bolygó kristályos hegyeit és csillogó barlangjait. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Kristálybolygó különleges geológiai képződményeit és természeti szépségeit. Tapasztalja meg a kristályok csodáját, miközben felfedezzük a bolygó rejtett titkait.', 3, '2024-09-10', '2024-09-20', 2200),
(4, 'Tündérvilági Kalandok', 'Fedezze fel a Tündérvilág varázslatos erdeit és tündérlakait ezen a különleges expedíción, miközben tanulmányozzuk a bolygó zöldellő erdeit és mesés tájait. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Tündérvilág különleges élővilágát és varázslatos titkait. Tapasztalja meg a tündérek varázsát, miközben átsiklik a Tündérvilág álomszerű erdein.', 4, '2024-10-05', '2024-10-15', 2500),
(5, 'Csillagkerti Körút', 'Utazzon a Csillagkert csodálatos virágos rétjein ezen a különleges utazáson, miközben felfedezzük a bolygó színes virágait és buja növényzetét. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Csillagkert különleges növényvilágát és életét. Tapasztalja meg a virágok varázsát, miközben felfedezzük a Csillagkert rejtett szépségeit.', 5, '2024-11-01', '2024-11-10', 2300),
(6, 'Galaktikus Gyöngyök Túra', 'Tapasztalja meg a Galaktikus Gyöngyök csillogását és varázsát ezen a különleges utazáson, miközben felfedezzük a bolygó gyöngyhomokkal borított partjait és ragyogó kristályait. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Galaktikus Gyöngyök különleges élővilágát és természeti szépségeit. Tapasztalja meg a gyöngyök csodáját, miközben átsiklik a bolygó csillogó égboltja alatt.', 6, '2024-12-01', '2024-12-10', 2000),
(7, 'Varázshegyi Expedíció', 'Utazzon a Varázshegy mélyére ezen a lenyűgöző utazáson, miközben felfedezzük a bolygó mesés völgyeit és varázslatos várát. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Varázshegy különleges történetét és legendáit. Tapasztalja meg a varázslatot, miközben felfedezzük a Varázshegy rejtett szépségeit.', 7, '2025-01-01', '2025-01-10', 2100),
(8, 'Csillagporos Ugrás', 'Fedezze fel a Csillagporos rejtett csillagportengerét ezen a különleges utazáson, miközben felfedezzük a bolygó ragyogó porfelhőit és szikrázó csillagait. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Csillagporos különleges csillagportengerét és űrtájait. Tapasztalja meg a csillagok porának varázsát, miközben átsiklik a Csillagporos végtelen égén.', 8, '2025-02-01', '2025-02-10', 1900),
(9, 'Mélyűri Felfedezés', 'Utazzon a Mélyűr rejtett birodalmába ezen a kalandos expedíción, miközben felfedezzük a bolygó sötét mélységeit és titokzatos holdjait. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Mélyűr különleges atmoszféráját és űrképződményeit. Tapasztalja meg a mélyűr csodáit, miközben felfedezzük a Mélyűr rejtett birodalmának titkait.', 9, '2025-03-01', '2025-03-10', 2200),
(10, 'Kozmikus Kerti Kalandozás', 'Fedezze fel a Kozmikus Kert misztikus ösvényeit és titokzatos erdeit ezen a kalandos utazáson, miközben felfedezzük a bolygó különleges növényvilágát és élőlényeit. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Kozmikus Kert különleges élővilágát és természeti szépségeit. Tapasztalja meg a kertek varázsát, miközben átsiklik a Kozmikus Kert csillagos égen.', 10, '2025-04-01', '2025-04-10', 2100),
(11, 'Csillagfényi Utazás', 'Utazzon a Csillagfény rejtett birodalmába ezen a különleges expedíción, miközben felfedezzük a bolygó ragyogó égi jelenségeit és csillagfényes tájait. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Csillagfény különleges világát és csillogó csillagait. Tapasztalja meg a csillagfény varázsát, miközben felfedezzük a Csillagfény rejtett birodalmának titkait.', 11, '2025-05-01', '2025-05-10', 2000),
(12, 'Káprázatbolygói Körút', 'Fedezze fel a Káprázatbolygó csillogó tájait és káprázatos csodáit ezen a lenyűgöző utazáson, miközben felfedezzük a bolygó ragyogó égi jelenségeit és csillagfényes tájait. Ez az utazás lehetővé teszi, hogy közelebbről megismerje a Káprázatbolygó különleges világát és csillogó csillagait. Tapasztalja meg a káprázat varázsát, miközben átsiklik a Káprázatbolygó ragyogó égboltja alatt.', 12, '2025-06-01', '2025-06-10', 2200);

INSERT INTO csomagjarmu (csomagid, jarmuid, ar) 
VALUES 
(1, 3, 1000),
(2, 5, 1500),
(3, 2, 900),
(4, 7, 2000),
(5, 1, 500),
(6, 4, 1500),
(7, 9, 3000),
(8, 6, 2200),
(9, 8, 2900),
(10, 10, 3750),
(11, 3, 1100),
(12, 5, 1500),
(1, 7, 2290),
(2, 2, 890),
(3, 4, 1290),
(4, 8, 3020),
(5, 10, 3990),
(6, 1, 875),
(7, 6, 2290),
(8, 9, 3000),
(9, 3, 1000),
(10, 2, 970),
(11, 4, 1190),
(12, 8, 3190),
(1, 10, 4770),
(2, 6, 3500);
