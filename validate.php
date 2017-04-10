<?php
// $card = $_GET["cardnr"];
$card = 'notthetruth';
$time = time ();
$isValid = False;

$cache = unserialize ( file_get_contents ( 'Cache.txt' ) );
$permission = unserialize ( file_get_contents ( 'Permissions.txt' ) );
$permit = intval ( $permission [0] );

if (! is_null ( $card )) {
	if ($time < $permit || isset($permit)) 
	{
		echo '#1';
	} 
	else 
	{
		file_put_contents('Permissions.txt', '');
		foreach ( $cache as $id ) 
		{
			if ($id == $card) 
			{
				$isValid = True;
				echo '#1';
				break;
			}
		}
		if (! $isValid) 
		{
			echo '#0';
		}
	}
} 
else 
{
	echo '#0';
}
?>
