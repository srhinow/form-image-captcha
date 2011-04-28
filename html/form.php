<?php
/*Sicherheitscode

/* Zufallsgenerator starten */
$zufallszahl = mt_rand(10000, 99999);
setcookie("zufallszahl", $zufallszahl);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>secureimage &copy; 2006 by <sr-tag></title>
</head>
<body onLoad="this.document.secure.code.focus();">
<?php


if(empty($_REQUEST['action'])) {
?>
<form name="secure" action="form.php?action=check" method="post"><fieldset style="text-align:center; vertical-align:middle;"><legend>SicherheitsCode</legend>
<input type="text" value="" size="10" maxlength="5" name="code" onKeyPress="if(event.keyCode < 48 || event.keyCode > 57) { event.returnValue = false; } else {if(event.which < 48 || event.which > 57) return false;}">&nbsp;
<img src="sicherheitscode.php" alt="SecureImage" border="0">&nbsp;
<input type="submit" value="ab damit"></fieldset>
</form>
<?php
}
if($_REQUEST['action'] == "check") {
    if($_POST['code'] != $_COOKIE['zufallszahl']) {
        echo 'Sorry, aber du hast dich vertippt! 
';
        echo '<a href="index.php">versuch dein glück doch nochmal</a>';
    } else {
        echo 'gut gemacht, kein Tippfehler! Respekt :P
';
        echo '<a href="form.php">willste nochmal?</a>';
    }
}
?>
</body>
</html>