<?php
include "../Helper/Helper.php";
include "Aposta.php";
ignore_user_abort(true);
set_time_limit(0);
define("MEGASENA", 60);
define("QUINA", 80);
define("LOTOMANIA", 100);
define("LOTOFACIL", 25);

date_default_timezone_set('America/Sao_Paulo');
echo "<script>console.log(\"hfgf\")</script>";
$data = $_POST['Aposta'];
$aposta = new Aposta();
$aposta->set_Id(generate_uuid());
$today = date("D M j G:i:s Y");
$aposta->set_DataAposta($today);
$aposta->set_DezenasApostadas($data['DezenasApostadas']);
$aposta->set_NomeJogo($data['NomeJogo']);
$aposta->set_TotalAposta($data['TotalAposta']);
$aposta->set_ValorAposta($data['ValorAposta']);
$oi = $data['NomeJogo'];
$totalAposta = $data['TotalAposta'];
$dezenasApostadas = $data['DezenasApostadas'];
$apostas = [[]];
switch($oi){
    case "Mega-Sena":{
        for($x = 0; $x<$totalAposta;$x++){
                do{
                    for($y=0;$y<$dezenasApostadas;$y++){
                        do{
                            $dezena=mt_rand(1,MEGASENA);
                            if(in_array_r($dezena,$apostas)==false){
                                $apostas[$x][$y]=$dezena;
                                break;
                            }
                        }while (in_array_r($dezena,$apostas)==true);
                    }
                }while (!isset($apostas[$x][$dezenasApostadas-1]));
        }
        break;
    }

    case "Quina":{
        for($x = 0; $x<$totalAposta;$x++){
            do{
                for($y=0;$y<$dezenasApostadas;$y++){
                    do{
                        $dezena=mt_rand(1,QUINA);
                        if(in_array_r($dezena,$apostas)==false){
                            $apostas[$x][$y]=$dezena;
                            break;
                        }
                    }while (in_array_r($dezena,$apostas)==true);
                }
            }while (!isset($apostas[$x][$dezenasApostadas-1]));
        }
        break;
    }
    case "Lotomania":{
        for($x = 0; $x<$totalAposta;$x++){
            do{
                for($y=0;$y<$dezenasApostadas;$y++){
                    do{
                        $dezena=mt_rand(1,LOTOMANIA);
                        if(in_array_r($dezena,$apostas)==false){
                            $apostas[$x][$y]=$dezena;
                            break;
                        }
                    }while (in_array_r($dezena,$apostas)==true);
                }
            }while (!isset($apostas[$x][$dezenasApostadas-1]));
        }
        break;
    }
    case "Lotofacil":{
        for($x = 0; $x<$totalAposta;$x++){
            do{
                for($y=0;$y<$dezenasApostadas;$y++){
                    do{
                        $dezena=mt_rand(1,LOTOFACIL);
                        if(in_array_r($dezena,$apostas)==false){
                            $apostas[$x][$y]=$dezena;
                            break;
                        }
                    }while (in_array_r($dezena,$apostas)==true);
                }
            }while (!isset($apostas[$x][$dezenasApostadas-1]));
        }
        break;
    }
}


$sort = array();
foreach($apostas as $k=>$v) {
    sort($v);
    $sort[$k] = $v;
}
$file="aposta.json";
array_multisort($sort, SORT_ASC, $apostas);
echo "<script>console.log(\"hfgf\")</script>";
$aposta->set_NumerosSorteados($sort);

$json_aposta=json_encode($aposta);


$apostasRealizadas = file($file);
$last = sizeof($apostasRealizadas) - 1 ;
unset($apostasRealizadas[0]);
unset($apostasRealizadas[$last]);
$fp = fopen($file, 'w+');
fwrite($fp, "[  \n");
fwrite($fp, implode('', $apostasRealizadas));
if(!empty($apostasRealizadas))
fwrite($fp, ",".$json_aposta."\n ]");
else
    fwrite($fp, $json_aposta."\n ]");
fclose($fp);