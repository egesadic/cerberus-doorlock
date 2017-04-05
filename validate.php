<?php
//$card = $_GET["cardnr"];
$card= 'zsexdr';

$isValid = False;

$cache = unserialize(file_get_contents('Cache.txt'));

if(!is_null($card)){
	foreach ($cache as $id){
		if ($id == $card)
		{
			$isValid = True;
			echo '#1';
			break;
		}		
	}
	if(!$isValid)
	{
		echo '#0';
	}
}
else 
{
	echo'#0';
}
?>
