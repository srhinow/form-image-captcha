<?php

/*Sicherheitscode - vielseitig einsetzbar
Copyright 2006 by sr-tag.de */
header("Content-Type: image/png");
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");          // Datum in der Vergangenheit
header ("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); // immer modifiziert
header ("Cache-Control: no-cache, must-revalidate");        // HTTP/1.1
header ("Pragma: no-cache");

session_start();
$sk=$_GET['sk'];
$SessionVar = $_SESSION['FE_DATA']["captcha_".$sk];

#### Groesse des Bildes ########################
$img_width   = $SessionVar['image_w'];        # Breite des Bildes in Pixel
$img_height  = $SessionVar['image_h'];         # Hoehe des Bildes in Pixel

#$font = "./RenStimpy.ttf";
$font   =  "./bradlay.ttf";
$zahl   = strval($SessionVar['sum']);    #Sessionwert muss als String übergeben werden PFLICHT=>""
$c =  5;

#### Hintergrundfarben 255->voll 0->keine ######
$bg_rot      = $SessionVar['bg_r'];        # Rotanteile des Hintergrundes
$bg_gelb     = $SessionVar['bg_g'];        # Gelbanteile des Hintergrundes
$bg_blau     = $SessionVar['bg_b'];        # Blauanteile des Hintergrundes

#### Linienfarben 255->voll 0->keine ######
$line_rot    = $SessionVar['line_r'];        # Rotanteile der Gitterlinien
$line_gelb   = $SessionVar['line_g'];        # Gelbanteile der Gitterlinien
$line_blau   = $SessionVar['line_b'];        # Blauanteile der Gitterlinien

#### Schriftfarben 255->voll 0->keine ######
$font_rot    = $SessionVar['font_r'];       # Rotanteile der Schrift
$font_gelb   = $SessionVar['font_g'];         # Gelbanteile der Schrift
$font_blau   = $SessionVar['font_b'];         # Blauanteile der Schrift



/* das Bild und seine Eigenschaften */
$im        = imagecreate($img_width, $img_height); # das bild erstellen
$bgcolor   = imagecolorallocate($im, $bg_rot, $bg_gelb, $bg_blau); # Backgroundcolor setzen
$linecolor = imagecolorallocate($im, $line_rot, $line_gelb, $line_blau); # Schriftfarbe setzen 
$fontcolor = imagecolorallocate($im, $font_rot, $font_gelb, $font_blau); //Schriftfarbe setzen
imagefilledrectangle($im, 0, 0, 49, 19, $bgcolor);

/* die Linien auf das Bild "zeichnen" */
for($x=0; $x <= 102; $x+=5)
    imageline($im, $x, 0, $x, 40, $linecolor);
for($y=0; $y <=52; $y+=5)
    imageline($im, 0, $y, 102, $y, $linecolor);

/* den Zahlencode auf das Bild "schreiben" */
$w=0;
for($i=0;$i<=$c;$i++){
    imagettftext($im, 20, 0, 2+$w, mt_rand(15,25), $fontcolor, $font, $zahl[$i]);
    $w=$w+18;
}

imagepng($im);
imagedestroy($im);
?> 
