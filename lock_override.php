<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/HTML; charset=utf-8" />
<style>
.error {color: #FF0000;}
</style>    
</head>
<body>
<?php 
require 'database.class.php';
?>
<h2>Kart Kontrolünü Devre Dışı Bırak</h2>
<p>
Süre: <select name="formDisableTime">
<option value="">Seçiniz...</option>
<option value="15m">15 Dakika</option>
<option value="30m">30 Dakika</option>
<option value="60m">1 Saat</option>
<option value="2h">2 Saat</option>
<option value="4h">4 Saat</option>
<option value="8h">8 Saat</option>
<option value="12h">12 Saat</option>
<option value="24h">24 Saat</option>
</select>
<br>
<h2>Girişi Engelle</h2>
<p>
Kişi:<select name="formBanPerson">
<option value="">Seçiniz...</option>
<option value="15m">15 Dakika</option>
<option value="30m">30 Dakika</option>
</select>
Süre: <select name="formBanTime">
<option value="">Seçiniz...</option>
<option value="15m">15 Dakika</option>
<option value="30m">30 Dakika</option>
</select>
</p>
</body>
</html>
