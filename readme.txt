=== Plugin Name ===
Contributors: Andrej Kona, Ing. Igor Kona, Podujatie.eu
Donate link: http://www.podujatie.eu
Tags: xml, woocommerce, feed, podujatie.eu
Requires at least: 3.0.1
Tested up to: 3.6
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.podujatie.eu/

Plugin generuje xml feed pre obchod pod správou woocommerce na platforme wordpress. Plugin generuje xml feed pre portál Heureka.sk a Heureka.cz. Free verzia pluginu.

== Description ==

Plugin vytvorený pre platformu Wordpress a naň stavaný e-shop Woocommerce ponúka jeho majiteľom veľmi jednoduché, no pritom dostatočné vygenerovanie produktov do XML feed-u s vlastnou url linkou potrebnou pre načítanie portálom Heureka.sk.

Free verzia (zadarmo) dokáže vygenerovať na jeden xml feed spolu až 50 produktov!!! Viete si nastaviť dodatočne voliteľné údaje, vďaka ktorým zákazníci produkt skôr nájdu, získajú viac informácii a rýchlejšie vykonajú preklik na vašu stránku.

== Installation ==

Inštalácia tohto pluginu

1. Uploadnite priečinok `heureka-feed` do priečinku na serveri s Wordpress do `/wp-content/plugins/`
2. Aktivujte plugin prostredníctvom tlačítka na ľavej strane v admin menu paneli 'Plugins' (Moduly) vo Wordpress
3. Plugin je aktivovaný, teraz v admin menu paneli v časti Nastavenia kliknite na Heureka XML Feed a nastavte si plugin

== Frequently Asked Questions ==

= Ako uploadnem plugin do adresára? =

Odporučujeme použiť ftp manager program (napr. Filezilla, alebo online program na prenos dát na server z PC).

= Nevidím xml feed na linku =

Máte zapnutú možnosť vytvárania feed-ov programom Wordpress? Nastavili ste správne parametre? Zadávate správny url link? Opera ani iExplorer neukáže feed, len oznam o jeho existencii. Mozilla ukáže feed v "nedokonalom" stave.

= Ako zadám url link feed-u do portálu Heureka.sk? =

Je potrebné prihlásiť sa ako "Obchod" na tomto portáli, následne zvoliť nastavenia obchodu a zadať do kolonky XML Feed túto url linku.

= Mám prázndu stránku pluginu/wordpress-u/chybovú hlášku =

Nastal konflikt pluginov. Prosím vypnite všetky pluginy a podľa dôležitosti ich zapnite znova. Niektoré pluginy zapríčiňujú konflikt tým, že majú rovnaké kódovacie parametre. Ak nájdete takýto konflikt, dajte nám vedieť, chybu sa pokúsime odstrániť.

= &#187; Page not found - vypisuje na RSS feed-e =

Je potrebné, aby ste mali aspoň jednu vytvorenú stránku a jeden koment na stránke. Toto je problém Wordrpess-u.

= Feed nenačítava dodatočné údaje pri variabilných produktoch =

Verzia 3.00 nedokáže do feed-u preniesť dodatočné údaje (ako je EAN a Výrobca). Tieto údaje sa načítavajú len pri jednoduchých produktoch.

= Neukazuje kategóriu v nastaveniach =

Nastavili ste si kategóriu, no pri spätnom pohľade Vám neukazuje uloženú možnosť v kolónke nastavenia? Nemajte strach. Feed si uloženú možnosť načítava z MySQL databázy, no toto nastavenie niekedy (pri update, alebo zmene pluginu) môže ukazovať prázdne pole, prípadne "Vybrať možnosť", aj keď je uložená.

= Pätka sa po nainštalovaní pluginu pohybuje =

Nainštalovali ste si plugin a zistili ste, že pätka Wordpress sa v administrátorkom rozhraný pohybuje na spodu stránky podľa toho, ako skrolujete okno? Nič si z toho nerobte. Toto neohrozuje Wordpress a ani žiadne nastavenie, či plugin alebo databázu. Na odstránení chyby pracujeme.

= Iná pomoc? =

Navštívte stránku http://www.podujatie.eu a napíšte nám do podpory užívateľov.

== Screenshots ==

== Changelog ==

= 3.00 =
Heureka taxanómia
Mapovanie kategórií*
Grafické rozhranie administrátora
Úprava xml feed-u
Úprava zdrojového kódu
Ean kód pole produktu *
Výrobca pole produktu *
Typ dopravy podľa Heureka
Meranie konverzií *
* pre Premium verziu

= 2.25 =
Úprava linku kontroly verzií

= 2.20 =
Kontrola nových verzií

= 2.10 =
Zmena načítavania chybových hlásení
Cesta k RSS template zmenená
Upravený RSS Template - obmädzenie chybových hlásení

= 2.0 =
Jazykový súbor odstránený.
Vylepšená prehľadnosť pluginu.
Zrýchlenie pluginu.
Rozdelenie na Pro a Free verziu.
Grafická úprava administrátorského rozhrania.
Úprava zdrojového kódu, eliminovanie chybového hlásenia, zmena administrátorského načítavania.

= 1.11 =
Úprava jazykového súboru

= 1.10 =
Upresnenie jazykového načítavania.

= 1.0 =
Vytvorenie pluginy s voliteľnými možnosťami.

= 0.01 =
Základné vytovrenie pluginu

== Upgrade Notice ==

= 2.20 =
Kontrola nových verzií

= 2.10 =
Zmena načítavania chybových hlásení
Cesta k RSS template zmenená
Upravený RSS Template - obmädzenie chybových hlásení

= 2.0 =
Jazykový súbor odstránený.
Vylepšená prehľadnosť pluginu.
Zrýchlenie pluginu.
Rozdelenie na Pro a Free verziu.
Grafická úprava administrátorského rozhrania.
Úprava zdrojového kódu, eliminovanie chybového hlásenia, zmena administrátorského načítavania.

= 1.11 =
Úprava jazykového súboru

= 1.10 =
Upresnenie jazykového načítavania.

= 1.0 =
Vytvorenie pluginy s voliteľnými možnosťami.

= 0.01 =
Základné vytovrenie pluginu

== Arbitrary section ==

SW sa nesmie ďalej predávať, ani akokoľvek šíriť bez vedomia a dohody s autorom. SW licencia je platná na všetky weby v rámci jednej domény jedného kupujúceho. Autor nenesie zodpovednosť pokiaľ SW akokoľvek poškodí dáta, alebo spôsobí škodu. Kúpou a platbou súhlasíte s týmto licenčným dojednaním. Autor si ďalej vyhradzuje právo úpravy tohto licenčného dojednania. Platba je jednorazová a sú v nej zahrnuté prípadné aktualizácie a pomoc pri štandardnej inštalácii. Zasahovanie do kódu pluginu, jeho časti či akákoľvek úprava je zakázaná. V opačnom prípade autor nenesie žiadnu zodpovednosť a taktiež povinnosť na akejkoľvek náprave. Najprv pred zakúpením pluginu vyskúšajte aspoň na 3 dni jeho Free verziu, či plugin pracuje korektne. Nakoľko nie je jasné, aké pluginy, systém a prepojenia používa objednávateľ tohto pluginu, nemôžeme zaručiť jeho korektné správanie sa na 100%. Plugin je otestovaný a na 99% negeneruje žiadne fatálne chyby. Zakúpením nevzniká automatický nárok na všetky ďalšie verzie, ani na úpravu pluginu, ani zásahy do pluginu. Plugin kupujte až po vyskúšaní Free verzie. V prípade nekompatibility pluginu s Vaším Wordpressom, nevzniká Vám nárok na vrátenie ceny pluginu! Do pluginu nijako nezasahujte ani ho neupravujte. Plugin kupujete na vlastné riziko!

Ďalšie šírenie tohto pluginu je ZAKÁZANÉ! Zákon č. 618/2003 Z.z. o autorskom práve a právach súvisiacich s autorským právom (autorský zákon) a Zákon č. 300/2005 Z.z. Trestný zákon, §283 Porušovanie autorského práva.

Ing. Igor Kona; IČO: 43729444; DIČ: 1078646503IČ; DPH: SK1078646503; platobné údaje na stránke Podujatie.eu.

== A brief Markdown Example ==

