# Srb2Srb-php

Srb2Срб klasa omogucava kompletno prevodenje sajta iz latinice u cirilicu i obrnuto. 

Postoji mogucnost da se neki delovi teksta izuzmu od prevodenja tako što se napiše {#} na pocetku i {/#} na kraju teksta , npr. 

<strong>neki tekst {#} ovaj deo teksta izuzeti od prevodenja {/#} neki tekst</strong>

To bi trebalo koristiti u situacija kad se radi o linkovima, email adresama i sl.

Postoje odredene reci koje se ne mogu bukvalno prevoditi. Ovo važi samo u situacijama kad se prevodi sa latinice na cirilicu, npr. injekcija ce biti prevedena kao ???????? sto je pogrešno.

Na netu sam pronasao raspravu gde je dosta toga objašnjeno ali opet ne sve. Iz tog razloga sam odlucio sa ostavim mogucnost da se mogu dodavati odredene reci koje treba da se izuzmu od bukvalnog prevoda.

Princip rada je sledeci. Prvo se pretražuje tekst prema datom regularnom izrazu npr. injek[a-z]* , kad se pronade rec uzima se sledeci parametar a to je broj 2 koji prestavlja drugo slovo u reci u konkretnom slucaju slovo n tj. to je mesto na kojem ce se data rec podeliti na dva dela. Izmedu ta dva dela bice ubacen niz znakova koji se ne može prevesti da bi se sve to opet spojilo u jednu rec npr. in#qq#jekcija. Kad se tekst prevede niz znakova #qq# bice obrisan i dobice se rec ?????????.

Sam regularni izraz ne bi trebao da prestavlja problem. Kao što se vidi iz izraza injek[a-z]* , injek je obavezan deo reci, [a-z] prestavlja sva slova a zvezdica minimalan broj slova. U konkretnom slucaju ne postoji minimalan broj slova, ako se nalazi znak plus onda je minimum jedno slovo dok u oba slucaja maksimum nije definisan.
