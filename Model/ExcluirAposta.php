<?php
/**
 * Created by PhpStorm.
 * User: nicol
 * Date: 29/12/2016
 * Time: 19:04
 */
$file="aposta.json";

$indice = $_POST['Aposta'];

//$lines = file($file);
$lines = file($file);
echo "<script>console.log(\"$indice\")</script>";
$last = sizeof($lines) - 1 ;
unset($lines[$indice+1]);


$fp = fopen($file, 'w');
$writeline=implode('', $lines);
if($indice==0){
    $writeline=preg_replace("/,{/","{", $writeline,1);
    fwrite($fp, $writeline);
}
else{
    fwrite($fp, implode('', $lines));
}
fclose($fp);