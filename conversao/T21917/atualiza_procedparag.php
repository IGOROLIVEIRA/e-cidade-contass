<?
/*
$DB_COR_FUNDO="#00CCFF";
$DB_FILES = "/dbportal2/imagens/files";
$DB_DIRPCB = "/home/sistema";
$DB_EXEC="/usr/bin/dbs";
$DB_NETSTAT="netstat";
*/
/*
$DB_USUARIO = "postgres";
$DB_SENHA = "";
$DB_SERVIDOR = " 192.168.0.2 ";
$DB_BASE     = " auto_alegrete_20090820_v3 ";
$DB_PORTA    = " 5433 ";
*/
//para eldorado e osorio = 2, para daeb = 4, demais = 1;
$db03_instit = 1;

include '../../libs/db_conn.php';

if(!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "Contate com Administrador do Sistema! (Conexуo Invсlida.) \n";
  exit;
}

pg_query($conn,"select fc_startsession()");
pg_query($conn,'begin');



//Identificando documento 1008 e paragrafo METODOLOGIA DE CALCULO.

$sQueryMetodologia = "SELECT distinct db03_docum,db03_tipodoc,db03_instit,db02_idparag, db04_docum,db04_idparag,db04_ordem
					from db_documento 
 					inner join db_docparag on db03_docum = db04_docum 
 					inner join db_paragrafo on db04_idparag = db02_idparag  
 					where db03_tipodoc = 1008 and db02_texto ilike '%METODOLOGIA DE CALCULO%' and db03_instit = $db03_instit";

$resQueryMetodologia = pg_query($conn,$sQueryMetodologia);

if(pg_num_rows($resQueryMetodologia) > 0){
	$rowQueryMetodologia = pg_fetch_object($resQueryMetodologia);
	echo "\nMetodologia de calculo encontrada ..... ok\n";
	$db03_docum   	=	$rowQueryMetodologia->db03_docum;
	$db03_tipodoc 	=	$rowQueryMetodologia->db03_tipodoc;
	$db03_instit		=	$rowQueryMetodologia->db03_instit;
	$db02_idparag		=	$rowQueryMetodologia->db02_idparag;
	$db04_docum			=	$rowQueryMetodologia->db04_docum;
	$db04_idparag		=	$rowQueryMetodologia->db04_idparag;
	$db04_ordem			= $rowQueryMetodologia->db04_ordem;
	
	//Cria um novo documento chamado METODOLOGIA DE CALCULO (1050)
	$sInsertDbDocumento = "insert into db_documento (db03_docum,db03_descr,db03_tipodoc,db03_instit) 
					values (nextval('db_documento_db03_docum_seq'),'METODOLOGIA DE CALCULO',1050,$db03_instit);";
	if(!pg_query($conn,$sInsertDbDocumento)){
		echo pg_last_error()."\n";
		pg_query('rollback',$conn);
		echo "\n Falha ao criar novo documento ! \nROLLBACK";
		exit();
	}
	echo "Novo Doc Metodologia de Calculo criado .....ok\n";
	//Recupera o id do documento criado.
	$sQueryCodDbDocumento = "select currval('db_documento_db03_docum_seq') as db03_docum_new;";
	$resQueryCodDbDocumento = pg_query($conn,$sQueryCodDbDocumento);
	if(pg_num_rows($resQueryCodDbDocumento) > 0 ){
		$row = pg_fetch_object($resQueryCodDbDocumento);
		$db03_docum_new = $row->db03_docum_new; 
	}else{
		echo pg_last_error()."\n";
		pg_query('rollback',$conn);
		echo '\n Falha ao recuparar last id do novo documento ! \nROLLBACK;';
		exit();
	}
	//Vincula o paragrafo existente ao novo documetno criado.
	$sInsertDocParag = "insert into db_docparag (db04_docum,db04_idparag,db04_ordem) 
													values ($db03_docum_new,$db04_idparag,$db04_ordem)";
	if(!pg_query($conn,$sInsertDocParag)){
		echo pg_last_error()."\n";
		pg_query('rollback',$conn);
		echo '\n Falha ao criar vinculo do novo documento ! \nROLLBACK;';
		exit();
	}
	echo "Vinculado paragrafo Met Calculo ao Novo Doc .....ok\n";
	
	//Realiza update no campo descriчуo do db_paragrafo referente a metodologia de calculo
	$sUpdateDbParagrafo = "update db_paragrafo set db02_descr = 'METODOLOGIA DE CALCULO' where db02_idparag = $db04_idparag";
	if(!pg_query($conn,$sUpdateDbParagrafo)){
		echo pg_last_error()."\n";
		pg_query('rollback',$conn);
		echo '\n Falha ao atualizar descriчуo db_paragrafo ! \nROLLBACK;';
		exit();
	}
	
	//Remove o vinculo do paragrafo anterior
	$sDeleteDocParag = "delete from db_docparag where db04_docum   = $db04_docum 
																								and db04_idparag = $db04_idparag 
																								and db04_ordem   = $db04_ordem ";
	if(!pg_query($conn,$sDeleteDocParag)){
		echo pg_last_error()."\n";
		pg_query('rollback',$conn);
		echo '\n Falha ao remover vinculo do paragrafo antigo ! \nROLLBACK;';
		exit();
	}
	echo "Removeчуo do vinculo do paragrafo anterior .....ok\n";
	
	$sUpdateProcedParag = "update procedparag set v80_docmetcalculo = $db03_docum_new ";
	if(!pg_query($conn,$sUpdateProcedParag)){
		echo pg_last_error()."\n";
		pg_query('rollback',$conn);
		echo '\n Falha ao atualizar ProceParag ! \nROLLBACK;';
		exit();
	}
	echo "Atualizando ProcedParag .....ok\n";
	pg_query($conn,'commit');
	echo "\nFim da atualizaчуo ..... ok\n\n";
													
}else{
	pg_query($conn,'rollback');
	echo "\nNenhum documento encontrado\nROLLBACK\n";
	exit();
}
?>