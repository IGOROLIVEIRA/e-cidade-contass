<?php

header('Content-Type:text/plain');

$hostname = gethostname();
$cmd = shell_exec("cat updatedb/conn | grep -e $hostname"); 
$rows        = preg_split('/\s+/', $cmd);
$rows = array_filter($rows);
$array_global = array();
$array_interno=array();

foreach($rows as $row)
{
   if(count($array_interno) <= 3  ){
       $array_interno[] = $row;
       if(count($array_interno) == 3){
	 array_push($array_global,$array_interno);
	 $array_interno=array();
       }
   }
}

echo 'INICIANDO DEPLOY'.PHP_EOL;
echo '======='.PHP_EOL;

// uso o passthru para rodar um
// git pull ou svn up no console do Linux
echo 'Atualizando o repositório'.PHP_EOL;

passthru('svn up --username marcelo --password 1301891w ');
echo 'OK'.PHP_EOL;
echo '======='.PHP_EOL;



foreach($array_global as $row){

passthru("php vendor/ruckusing/ruckusing-migrations/ruckus.php db:migrate ENV='$row[0]'");

}


exit;



