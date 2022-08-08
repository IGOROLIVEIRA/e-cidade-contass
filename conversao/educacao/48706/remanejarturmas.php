<?
set_time_limit(0);
include(__DIR__ . "/../../../libs/db_conn.php");
//$DB_SERVIDOR = "10.1.1.11";
//$DB_BASE     = "bage";
//$DB_USUARIO  = "postgres";
//$DB_SENHA    = "";
//$DB_PORTA    = "5432";
if (!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
	
  echo "Erro ao conectar origem...\n\n";
  exit;
  
} else {
  echo "conectado...\n\n";
} 

pg_query($conn,"select fc_startsession()");

require_once(__DIR__ . "/../../../libs/db_stdlib.php");
require_once(__DIR__ . "/../../../classes/db_turmalog_classe.php");
require_once(__DIR__ . "/../../../classes/db_regencia_classe.php");
require_once(__DIR__ . "/../../../classes/db_parecerturma_classe.php");
require_once(__DIR__ . "/../../../dbforms/db_funcoes.php");
$clturmalog     = new cl_turmalog;
$clregencia     = new cl_regencia;
$clparecerturma = new cl_parecerturma;

$objRetorno          = new stdClass();
$objRetorno->status  = 1;
$objRetorno->message = 'FIM....';

db_putsession('DB_id_usuario',1) ;
db_putsession('DB_acessado',1) ;
db_putsession('DB_datausu',1) ;


echo " ->Iniciando processo...\n\n";
sleep(1);
system("clear");
pg_exec("begin");

$result    = $clturmalog->sql_record($clturmalog->sql_query("",
                                                        "turma.ed57_i_codigo as novo,a.ed57_i_codigo as codigoant",
                                                        "",
                                                        ""
                                                       )
                                   );
$linhas    = $clturmalog->numrows;  
$turmanova = "";
$sepnovo   = "";
  
for ($e = 0; $e < $linhas; $e++) {
    
  db_fieldsmemory($result,$e);    			
  $result2           = $clregencia->sql_record($clregencia->sql_query("",
                                                                      "regencia.*,
                                                                       ed59_i_serie as serie, ed59_i_disciplina as disciplina",
                                                                       "",
                                                                       "ed59_i_turma = $codigoant"
                                                                     )
                                              );
  $linhasregencia    = $clregencia->numrows;
  for ($i = 0; $i < $linhasregencia; $i++) {    	
    
	db_fieldsmemory($result2,$i);	  
	  
	$sWhere    = "ed59_i_turma = $novo and ed59_i_serie = $serie and ed59_i_disciplina= $disciplina";
    $result3   = $clregencia->sql_record($clregencia->sql_query("",
                                                                 "*",
                                                                 "",
                                                                 $sWhere
                                                                )
                                          );
    $linhasreg = $clregencia->numrows; 
    if ($linhasreg == 0) {

      $clregencia->ed59_i_turma       = $novo;
      $clregencia->ed59_i_disciplina  = $disciplina;
      $clregencia->ed59_i_qtdperiodo  = $ed59_i_qtdperiodo;
      $clregencia->ed59_c_condicao    = $ed59_c_condicao;
      $clregencia->ed59_c_freqglob    = $ed59_c_freqglob;
      $clregencia->ed59_c_ultatualiz  = $ed59_c_ultatualiz;
      $clregencia->ed59_d_dataatualiz = $ed59_d_dataatualiz;
      $clregencia->ed59_c_encerrada   = $ed59_c_encerrada;
      $clregencia->ed59_i_ordenacao   = $ed59_i_ordenacao;
      $clregencia->ed59_i_serie       = $serie;           
      $clregencia->incluir(null);
        
      if ($clregencia->numrows_incluir == 0 ) {
		$objRetorno->status  = 2;
		$objRetorno->message = urlencode("regencia: " . $clregencia->erro_msg."ppp" );
		break;
	  }
            
    } 
  } 

  $result4            = $clparecerturma->sql_record($clparecerturma->sql_query("","*","","ed105_i_turma = $codigoant" ));
  $linhasparecerturma = $clparecerturma->numrows; 

  for ($w = 0; $w < $linhasparecerturma; $w++) {
    	
	db_fieldsmemory($result4,$w);  	   
	$result5       = $clparecerturma->sql_record($clparecerturma->sql_query("",
	                                                                        "*",
	                                                                        "",
	                                                                        "ed105_i_turma = $novo 
	                                                                         and ed105_i_parecer = $ed105_i_parecer"
	                                                                       )
	                                            );
    $linhasparecer = $clparecerturma->numrows;
    if ($linhasparecer == 0) {
        $clparecerturma->ed105_i_turma   = $novo;
        $clparecerturma->ed105_i_parecer = $ed105_i_parecer;   
        $clparecerturma->incluir(null);
      if ($clparecerturma->numrows_incluir == 0 ) {
		$objRetorno->status  = 2;
		$objRetorno->message = urlencode("Parecer: " . $clparecerturma->erro_msg."kkkk" );
		break;
	  }

    }
  }      
}
if ($objRetorno->status == 2 ) {
  pg_query("rollback;");
} else {
  pg_query("commit;");
}
echo "\n\n  {$objRetorno->message} \n\n ";  
db_fim_transacao();   
?>