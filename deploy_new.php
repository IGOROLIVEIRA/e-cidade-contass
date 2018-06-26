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

passthru('composer update');

passthru('rm phinx.yml');
$name = 'phinx.yml';
$text = "paths:". PHP_EOL ;
$text .= "    migrations: %%PHINX_CONFIG_DIR%%/db/migrations".PHP_EOL;
$text .= PHP_EOL;
$text .= "environments:".PHP_EOL;
$text .= "    default_migration_table: phinxlog".PHP_EOL;
$text .= "    default_database: development".PHP_EOL;

foreach($array_global as $row){

    $text .= "    $row[0]:".PHP_EOL;
    $text .= "        adapter: pgsql".PHP_EOL;
    $text .= "        host: localhost".PHP_EOL;
    $text .= "        name: $row[0]".PHP_EOL;
    $text .= "        user: dbportal".PHP_EOL;
    $text .= "        pass: ''".PHP_EOL;
    $text .= "        port: $row[1]".PHP_EOL;
    $text .= "        charset: utf8".PHP_EOL;
    $text .= PHP_EOL;
}

$file = fopen($name, 'a');
fwrite($file, $text);
fclose($file);

// uso o passthru para rodar um
// git pull ou svn up no console do Linux
echo 'Atualizando o repositório'.PHP_EOL;

passthru('export LC_ALL=pt_BR.ISO-8859-1');
passthru('svn cleanup');
passthru('svn up --username marcelo --password 1301891w ',$status);

if($status == 0)
{
    //passthru("vim /tmp/deploy.txt").PHP_EOL;
    echo "SVN Succesfully".PHP_EOL;
}
else
{
    //passthru("vim /tmp/deploy.txt").PHP_EOL;
    echo "SVN failed".PHP_EOL;
}
echo '======='.PHP_EOL;

foreach($array_global as $row){

echo "php vendor/robmorgan/phinx/bin/phinx migrate ENV='$row[0]'";

passthru("php vendor/robmorgan/phinx/bin/phinx migrate -e $row[0] ",$status);

echo 'Status: '.$status;

}


exit;



