<?php
$data = file_get_contents('Path to exe');
$hxstr = "";
for($i = 0; $i < strlen($data); ++$i){
	$hxstr.= bin2hex($data[$i]);
}
echo $hxstr;
?>