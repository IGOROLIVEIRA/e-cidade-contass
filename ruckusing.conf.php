<?php
date_default_timezone_set('UTC');

//----------------------------
// DATABASE CONFIGURATION
//----------------------------

/*

Valid types (adapters) are Postgres & MySQL:

'type' must be one of: 'pgsql' or 'mysql' or 'sqlite'

*/

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

foreach($array_global as $row){

        $array1[$row[0]]['type'] = 'pgsql';
        $array1[$row[0]]['host'] = 'localhost';
        $array1[$row[0]]['port'] = $row[1];
        $array1[$row[0]]['database'] = $row[0];
        $array1[$row[0]]['user'] = 'dbportal';
        $array1[$row[0]]['password'] = 'dbportal';

}

$array['db'] = $array1;
$array['migrations_dir'] = array('default' => RUCKUSING_WORKING_BASE . '/migrations');
$array['db_dir'] = RUCKUSING_WORKING_BASE . DIRECTORY_SEPARATOR . 'db';
$array['log_dir'] = RUCKUSING_WORKING_BASE . DIRECTORY_SEPARATOR . 'logs';
$array['ruckusing_base'] = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor/ruckusing/ruckusing-migrations';

//print_r($array);exit;

return 	$array; 
