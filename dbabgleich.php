<?php
require_once 'classes/http_request2/vendor/autoload.php';
require_once  'classes/ApiToDBC.php';
use API\ApiToDBC;

//echo  getenv('USERNAME');

$msg ="";
$ApiToDBobj = new ApiToDBC('phpappl','n4Ovxs&Mlhnl&Yms');
if (isset($_POST['toIBM'])){

  if(isset($_POST['BesuchtoIBM'])){
      if ($ApiToDBobj->updateBesuch('https://vog.ninoxdb.com/share/34a08hveypverqj7i06m5rrghd7k2idt8u4f') == true ){ $msg .="<h3 style='color: #00CC00; font-style: italic' >Besuch erfolgreich importiert</h3>";}
  }
  if (isset ($_POST['BAkpftoIMB'])){
     if( $ApiToDBobj->updateBAkpf('https://vog.ninoxdb.com/share/1pmwz2n89kj0i98tta12jmhlk3tqs3ztelyq')== true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >BAkpf erfolgreich importiert</h3>";}
  }
  if (isset($_POST['BlstpostoIBM'])) {
     if( $ApiToDBobj->updateBlspos('https://vog.ninoxdb.com/share/7t6ryzx2xmwxqsa1tquzi55x12l2ncoq2nb2') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >Blspos erfolgreich importiert</h3>";}
  }
  if (isset($_POST['ZeiterfassungtoIBM'])) {
        if( $ApiToDBobj->updateZeiterfassung('https://vog.ninoxdb.com/share/n8ir4vij306sbxqy831i03ocvwrxkdc6mpqf') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >Zeiterfassung erfolgreich importiert</h3>";}
  }
    if (isset($_POST['AufgabetoIBM'])) {
        if( $ApiToDBobj->updateAufgabe('https://vog.ninoxdb.com/share/69yavrxwmfzegf31vbykqd0yhas1txhr9tcu') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >Aufgabe erfolgreich importiert</h3>";}
  }
}else if (isset($_POST['toNinox'])){

    if(isset($_POST['BesuchtoNinox'])){
        if( $ApiToDBobj->DBabgleich('xsrw389wnhdb','VFBESUCHP','M') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >VFBESUCHP erfolgreich abgeglichen</h3>";}
    }
    if (isset ($_POST['BAkpftoNinox'])){
        if( $ApiToDBobj->DBabgleich('xsrw389wnhdb','VFBAKPFP','U') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >VFBAKPFP erfolgreich abgeglichen</h3>";}
    }
    if (isset($_POST['BlstpostoNinox'])) {
        if( $ApiToDBobj->DBabgleich('xsrw389wnhdb','VFBLSTPOSP','Z') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >VFBLSTPOSP erfolgreich abgeglichen</h3>";}
    }
    if (isset($_POST['ZeiterfassungtoNinox'])) {
        if( $ApiToDBobj->DBabgleich('xsrw389wnhdb','vfzeitp','GB',"and Kategorie like 'Verkaufsfoerderer' ") == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >vfzeitp erfolgreich abgeglichen</h3>";}
    }
    if (isset($_POST['AufgabetoNinox'])) {
        if( $ApiToDBobj->DBabgleich('xsrw389wnhdb','VFAUFGABEP','HB') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >VFAUFGABEP erfolgreich abgeglichen</h3>";}
    }
}else if (isset ($_POST['updateAktion'])){

    if (isset ($_POST['Aktionenkopftoninox']))
    {
        if ($ApiToDBobj->setAktion()){$msg .="<h3 style='color: #00CC00; font-style: italic' >Aktionen erfolgreich aktualisiert</h3>";}
    }
    if (isset ($_POST['AktionsArtikeltoninox']))
    {
        if ($ApiToDBobj->setAktionsArtikel()){$msg .="<h3 style='color: #00CC00; font-style: italic' >AktionensArtikel erfolgreich aktualisiert</h3>";}
    }
}else if (isset ($_POST['GastrotoIBM'])){

    // Begin Erweiterung ninox to IBM

    if (isset($_POST['GastroBesuch'])) {
   if( $ApiToDBobj->updateGastroBesuch('https://vog.ninoxdb.com/share/j6l0t2v5odjvdn7si4jquf8zbgx78ljw58gv') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >Besuch erfolgreich importiert</h3>";}
    }
    if (isset($_POST['GastroAuftrag'])) {
        if( $ApiToDBobj->updateAuftrag('https://vog.ninoxdb.com/share/58od9aq8ljhfpb96j4ba08ahfp7t7onhuu17') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >Auftrag erfolgreich importiert</h3>";}
    }
    if (isset($_POST['GastroAuftragpos'])) {
        if( $ApiToDBobj->updateAuftragpos('https://vog.ninoxdb.com/share/iyl9ykigh3bbgve6tverkk4u252i6okg8vw6') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >AuftragPos erfolgreich importiert</h3>";}
    }

    // End Erweiterung

    if (isset($_POST['Spesen'])) {
        if( $ApiToDBobj->updateSpesen('https://vog.ninoxdb.com/share/stxh0zymieau0oqeb9gajx1577m8mxuk81zq') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >Spesenabrechnung erfolgreich importiert</h3>";}
    }
    if (isset($_POST['GastroZeit'])) {
        if( $ApiToDBobj->updateZeiterfassung('https://vog.ninoxdb.com/share/3kxor3ar1aqhexcdzjyr28nsym8wy4n503iy') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >Spesenabrechnung erfolgreich importiert</h3>";}
    }

}else if (isset($_POST['GastrotoNinox'])){

if(isset($_POST['SpesentoNinox'])) {
    if ($ApiToDBobj->DBabgleich('i7p2dvwvzm4h', 'GROSPESEN', 'TB') == true) { $msg .= "<h3 style='color: #00CC00; font-style: italic' >Spesenabrechnung erfolgreich abgeglichen</h3>";}
    }
    if(isset($_POST['GastroZeittoNinox'])){
        if( $ApiToDBobj->DBabgleich('i7p2dvwvzm4h','VFZEITP','GB', "and Kategorie like 'Gastro' ") == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >VFZEIT erfolgreich abgeglichen</h3>";}
    }

 //TO NINOX
// Begin erweiterung ToNinox
    if(isset($_POST['GastroBesuchNinox'])){
        if( $ApiToDBobj->DBabgleich('i7p2dvwvzm4h','grobesuch','M') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >GROBesuch erfolgreich abgeglichen</h3>";}
    }
    if(isset($_POST['GastroAuftragNinox'])){
        if( $ApiToDBobj->DBabgleich('i7p2dvwvzm4h','groauftrag','OB') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >GROAuftrag erfolgreich abgeglichen</h3>";}
    }
    if(isset($_POST['GastroAuftragposNinox'])){
        if( $ApiToDBobj->DBabgleich('i7p2dvwvzm4h','GROAUFTGPO','SB') == true){ $msg .="<h3 style='color: #00CC00; font-style: italic' >GROAuftgpo erfolgreich abgeglichen</h3>";}
    }
// end erweiterung
}
?>

<!DOCTYPE html>
<html lang="en" class="container">
<head>
  <title>Datenbank abgleichen</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css\style.css">
    <?php if ('prod'=== getenv('host_name', true)) echo' <link rel="stylesheet" href="css\styleProd.css"> '  ?>
</head>
<body class="container">
   <div  class="container-fluid" >
     <h1>Datenbank Abgleich</h1>
     <p>VOG UI für Datenbank abgleichen</p>
   </div>
   <div>
       <nav class="navbar navbar-dark bg-dark" style="justify-content: left;">
           <a class="navbar-brand" href="javascript:showSection('dbabgleich');">Verkaufsförderer</a>
           <a class="navbar-brand" href="javascript:showSection('Aktionen');">Aktionen</a>
           <a class="navbar-brand" href="javascript:showSection('Gastro');">Gastro</a>
       </nav>
   </div>
   <section id="dbabgleich" style="display:none">
       <form id="form" action="dbabgleich.php?" method="post" class="contain">
           <div id="cont-but">
               <div class="div-contain">
                   <h3 class="text-warning"> NINOX---->IBM</h3>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckBesuch" name="BesuchtoIBM">
                       <label class="form-check-label" for="flexSwitchCheckBesuch">update Besuch</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckBAkpf" name="BAkpftoIMB">
                       <label class="form-check-label" for="flexSwitchCheckBAkpf">update BAkpf</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckBlstpos" name="BlstpostoIBM">
                       <label  class="form-check-label" for="flexSwitchCheckBlstpos">update Blstpos</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckzeiterfassung" name="ZeiterfassungtoIBM">
                       <label  class="form-check-label" for="flexSwitchCheckzeiterfassung">update Zeiterfassung</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckAufgabe" name="AufgabetoIBM">
                       <label  class="form-check-label" for="flexSwitchCheckAufgabe">update Aufgabe</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <input id="lostoIBM" name="toIBM" onclick="losRing(0,5);" type="submit" class="btn btn-warning" value="Los">
               </div>
               <br><br><br>
               <div class="div-contain">
                   <h3 class="text-warning"> IBM---->NINOX</h3>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="BesuchNinox" name="BesuchtoNinox">
                       <label class="form-check-label" for="BesuchNinox">update Besuch</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="BAkpfNinox" name="BAkpftoNinox">
                       <label class="form-check-label" for="BAkpfNinox">update BAkpf</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="BlstposNinox" name="BlstpostoNinox">
                       <label  class="form-check-label" for="BlstposNinox">update Blstpos</label>
                       <div  class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="ZeiterfassungNinox" name="ZeiterfassungtoNinox">
                       <label  class="form-check-label" for="ZeiterfassungNinox">update Zeiterfassung</label>
                       <div  class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="AufgabeNinox" name="AufgabetoNinox">
                       <label  class="form-check-label" for="AufgabeNinox">update Aufgabe</label>
                       <div  class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <input id="lostoNinox"  name="toNinox"  onclick= "losRing(5,10);" type="submit" class="btn btn-warning" value="Los"><br>
               </div>
           </div>
       </form>
   </section>
   <section id="Aktionen" style="display: none" >
       <form id="form2" action="dbabgleich.php?" method="post" class="contain">
           <div id="cont-but2">
               <div class="div-contain">
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckAktionenkopf" name="Aktionenkopftoninox">
                       <label class="form-check-label" for="flexSwitchCheckAktionenkopf">update Aktionenkopf</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckBAkpAktionsArtikel" name="AktionsArtikeltoninox">
                       <label class="form-check-label" for="flexSwitchCheckBAkpAktionsArtikel">update Aktionsartikel</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <input id="updateAktion" name="updateAktion" onclick="losRing(10,12);" type="submit" class="btn btn-warning" value="Los">
               </div>
           </div>
       </form>
   </section>

   <section id="Gastro" style="display:none">
       <form id="form" action="dbabgleich.php?" method="post" class="contain">
           <div id="cont-but">
               <div class="div-contain">
                   <h3 class="text-warning"> NINOX---->IBM</h3>
<!--Begin Erweiterung NINOX---IBM-->
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckGastroBesuch" name="GastroBesuch">
                       <label class="form-check-label" for="flexSwitchCheckGastroBesuch">update Besuch</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckGastroAuftrag" name="GastroAuftrag">
                       <label class="form-check-label" for="flexSwitchCheckGastroAuftrag">update Auftrag</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckGastroAuftragpos" name="GastroAuftragpos">
                       <label class="form-check-label" for="flexSwitchCheckGastroAuftragpos">update Auftragpos</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
<!--End Erweiterung -->
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckSpesen" name="Spesen">
                       <label class="form-check-label" for="flexSwitchCheckSpesen">update Spesenabrechnung</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="flexSwitchCheckGastroZeit" name="GastroZeit">
                       <label class="form-check-label" for="flexSwitchCheckGastroZeit">update Zeiterfassung</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <input id="GastrotoIBM" name="GastrotoIBM" onclick="losRing(12, 17);" type="submit" class="btn btn-warning" value="Los">
               </div>
               <br><br><br>
               <div class="div-contain">
                   <h3 class="text-warning"> IBM---->NINOX</h3>
<!--  Begin erweiterung Tbale-->
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="GastroBesuchNinox" name="GastroBesuchNinox">
                       <label class="form-check-label" for="GastroBesuchNinox">update Besuch</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="GastroAuftragNinox" name="GastroAuftragNinox">
                       <label class="form-check-label" for="GastroAuftragNinox">update Auftrag</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="GastroAuftragposNinox" name="GastroAuftragposNinox">
                       <label class="form-check-label" for="GastroAuftragposNinox">update Auftragpos</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
  <!--  End  erweiterung Tbale-->
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="SpesenNinox" name="SpesentoNinox">
                       <label class="form-check-label" for="SpesenNinox">update Spesen</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>
                   <div class="form-check form-switch">
                       <input class="form-check-input" type="checkbox" id="GastroZeitNinox" name="GastroZeittoNinox">
                       <label class="form-check-label" for="GastroZeitNinox">update Zeiterfassung</label>
                       <div class="spinner-border text-warning" role="status">
                           <span class="visually-hidden">Loading...</span>
                       </div>
                   </div>

                   <input id="GastrotoNinox"  name="GastrotoNinox"  onclick= "losRing(17,22);" type="submit" class="btn btn-warning" value="Los"><br>
               </div>
           </div>
       </form>
   </section>

   <div id ="msg" class="contain">
       <div> <?php  echo $msg;?></div>
   </div>
   <div  class="container-fluid footer">
       <p>@copy VOG </p>
       <p>Bäckermühlweg 44, 4030 Linz </p>
   </div>
</body>
</html>

<script  lang="js">

    // Gastro beginn
    function losRing (von, to){
        var checkbox = document.querySelectorAll("[type=checkbox]");
        var ring = document.getElementsByClassName("spinner-border");
        for (i=von; i< to; i++){
            if (checkbox.item(i).checked){
                ring.item(i).style.display= "inline-block";
            }
        }
    }// losRing

    function showSection (sectionId){
        var section = document.getElementById(sectionId);
        var msg =document.getElementById("msg");
        var collectionSection = document.getElementsByTagName("section");
        for (i= 0; i< collectionSection.length; i++ ){
            collectionSection.item(i).style.display="none";
        }
        msg.style.display="none";
        section.style.display="Block";
    }//showSection
// Gastro ende
//
</script>
