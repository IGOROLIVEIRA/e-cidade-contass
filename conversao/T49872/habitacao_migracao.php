<?php
/*
 * Flag para usar o arquivo de configuracao db_conn.php
 */
$lConn = true;

define("CAMINHO_PADRAO","../../");

if ($lConn) {
  require_once(CAMINHO_PADRAO."libs/db_conn.php");	
} else {
	
  $DB_USUARIO  = "postgres";
  $DB_SENHA    = "";
  $DB_SERVIDOR = ""; 
  $DB_BASE     = "";
  $DB_PORTA    = "5432";
}

require_once(CAMINHO_PADRAO."libs/db_utils.php");
require_once(CAMINHO_PADRAO."model/processoProtocolo.model.php");
require_once("db_libconsole.php");
require_once("db_protprocesso_classe.php");

echo "Inicio da migracao modulo habitacao: ".date("d/m/Y - h:i:s", time())."\n";
echo "Conectando...\n";

$sConexao = "host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA";

if (! $conn1 = pg_connect($sConexao) ) {
  
  echo "Erro ao Conectar...\n";
  exit;
}

echo "Processando...\n";

$sSqlInstit = "select codigo from configuracoes.db_config where prefeitura is true limit 1";
$rsInstit   = db_query($conn1, $sSqlInstit);
$oInstit    = db_utils::fieldsMemory($rsInstit,0);
$instit     = $oInstit->codigo;

$sArquivo   = "log/log_migracao_habitacao_".date("YmdHis").".txt";

try {

	db_query($conn1, "BEGIN");
	
	$sSqlStartSession = " select fc_startsession(); ";
	$rsStartSession   = db_query($conn1, $sSqlStartSession);
	
  $iQtdInteressePrograma = 0;
	
	db_log('Verificando Consistência dos Dados.', $sArquivo ,2);
  $sSqlConsistenciaDados = " select habitprograma.ht01_sequencial,
                                    habitprograma.ht01_descricao,
                                    workflow.db112_sequencial,
                                    workflow.db112_descricao,
                                    workflowativ.db114_sequencial
                               from habitprograma
                                    left join workflow     on workflow.db112_sequencial   = habitprograma.ht01_workflow
                                    left join workflowativ on workflowativ.db114_workflow = workflow.db112_sequencial ";

  $rsConsistenciaDados   = db_query($conn1, $sSqlConsistenciaDados);
  
  if (!$rsConsistenciaDados) {
    
    throw new Exception("Erro ao consultar workflow dos programas!");
  } else {
    
    $iRowsConistencias = pg_num_rows($rsConsistenciaDados);
    
    $aWorkFlowNaoCadastrados = array();
    $aWorkFlowSemAtividade   = array();
    
    for ($iInd=0; $iInd < $iRowsConistencias; $iInd++) {
      
      $oPrograma = db_utils::fieldsMemory($rsConsistenciaDados,$iInd); 
      
      $sDescricaoPrograma = $oPrograma->ht01_sequencial." - ".$oPrograma->ht01_descricao;
      $sDescricaoWorkflow = $oPrograma->db112_sequencial." - ".$oPrograma->db112_descricao;
      
      if (trim($oPrograma->db112_sequencial) == '') {
        $aWorkFlowNaoCadastrados[$oPrograma->ht01_sequencial] = " - Workflow não cadastrado para o programa : {$sDescricaoPrograma}."; 
      } else if (trim($oPrograma->db114_sequencial) == '') {
        $aWorkFlowSemAtividade[$oPrograma->db112_sequencial]  = " - Atividade não cadastrada para o workflow : {$sDescricaoWorkflow}.";
      }  
    }
    
    $aMsgErro = array();
    
    if (count($aWorkFlowNaoCadastrados) > 0) {
      $aMsgErro[] = implode("\n",$aWorkFlowNaoCadastrados);
    }  
      
    if (count($aWorkFlowSemAtividade) > 0) {
      $aMsgErro[] = implode("\n",$aWorkFlowSemAtividade);
    }      
    
    if (count($aMsgErro) > 0) {
      throw new Exception("ERRO - Verificar Inconsistências : \n\n".implode("\n",$aMsgErro)."\n\n");
    }
  }
	
	
	db_log('Migrando registros tabela habitcandidato.', $sArquivo ,2);	
	
  $sSqlWHabitCandidato        = "   select ht10_numcgm,                            ";
  $sSqlWHabitCandidato       .= "          max(ht10_sequencial) as ht10_sequencial "; 
  $sSqlWHabitCandidato       .= "     from public.w_migra_habitcandidato           ";
  $sSqlWHabitCandidato       .= " group by ht10_numcgm;                            ";
  $rsSqlWHabitCandidato       = db_query($conn1, $sSqlWHabitCandidato);
  $iNumRowsSqlWHabitCandidato = pg_num_rows($rsSqlWHabitCandidato);
  
  if ($iNumRowsSqlWHabitCandidato > 0) {
  	
  	for ($iInd = 0; $iInd < $iNumRowsSqlWHabitCandidato; $iInd++) {
  		
  		$oWHabitCandidato    = db_utils::fieldsMemory($rsSqlWHabitCandidato, $iInd);
  		
  		$sSqlHabitCandidato  = " INSERT INTO habitcandidato(                                        ";
      $sSqlHabitCandidato .= "                             ht10_sequencial,                       "; 
      $sSqlHabitCandidato .= "                             ht10_numcgm )                          "; 
      $sSqlHabitCandidato .= "                     VALUES(                                        ";
      $sSqlHabitCandidato .= "                             {$oWHabitCandidato->ht10_sequencial},  ";
      $sSqlHabitCandidato .= "                             {$oWHabitCandidato->ht10_numcgm} );    ";
      
      $rsSqlHabitCandidato = db_query($conn1, $sSqlHabitCandidato);
      
  	  if (!$rsSqlHabitCandidato) {
        throw new Exception("Erro ao incluir registros na tabela(habitcandidato)!");
      }
      
      db_log('Migrando registros tabela habitfichasocioeconomica.', $sArquivo ,2);
      
      $sSqlWHabitFichaSocioEconomica        = " select *                                                          ";
      $sSqlWHabitFichaSocioEconomica       .= "   from public.w_migra_habitfichasocioeconomica                    ";
      $sSqlWHabitFichaSocioEconomica       .= "  where ht12_habitcandidato = {$oWHabitCandidato->ht10_sequencial} ";
      $rsSqlWHabitFichaSocioEconomica       = db_query($conn1, $sSqlWHabitFichaSocioEconomica);
      $iNumRowsSqlWHabitFichaSocioEconomica = pg_num_rows($rsSqlWHabitFichaSocioEconomica);
      if ($iNumRowsSqlWHabitFichaSocioEconomica > 0) {
      	
      	$oWHabitFichaSocioEconomica    = db_utils::fieldsMemory($rsSqlWHabitFichaSocioEconomica, 0);
      	
      	$sSqlHabitFichaSocioEconomica  = " INSERT INTO habitfichasocioeconomica(                                                             ";
        $sSqlHabitFichaSocioEconomica .= "                                       ht12_sequencial,                                            "; 
        $sSqlHabitFichaSocioEconomica .= "                                       ht12_avaliacaogruporesposta,                                "; 
        $sSqlHabitFichaSocioEconomica .= "                                       ht12_habitcandidato )                                       ";
        $sSqlHabitFichaSocioEconomica .= "                               VALUES(                                                             ";
        $sSqlHabitFichaSocioEconomica .= "                                       {$oWHabitFichaSocioEconomica->ht12_sequencial},             ";
        $sSqlHabitFichaSocioEconomica .= "                                       {$oWHabitFichaSocioEconomica->ht12_avaliacaogruporesposta}, "; 
        $sSqlHabitFichaSocioEconomica .= "                                       {$oWHabitFichaSocioEconomica->ht12_habitcandidato} );       ";
        $rsSqlHabitFichaSocioEconomica = db_query($conn1, $sSqlHabitFichaSocioEconomica);
        if (!$rsSqlHabitFichaSocioEconomica) {
          throw new Exception("Erro ao incluir registros na tabela(habitfichasocioeconomica)!");
        }
      }
      
		  $sSqlWMigraHabitinscricao     = " select *                                                      ";
      $sSqlWMigraHabitinscricao    .= "   from public.w_migra_habitinscricao                          ";
      $sSqlWMigraHabitinscricao    .= "  where ht15_candidato = {$oWHabitCandidato->ht10_sequencial}; ";	                                     
		  $rsSqlWMigraHabitinscricao    = db_query($conn1, $sSqlWMigraHabitinscricao);
		  $iNumRowsWMigraHabitinscricao = pg_num_rows($rsSqlWMigraHabitinscricao);
		  if ($iNumRowsWMigraHabitinscricao > 0) {
		  	
		    $oWMigraHabitinscricao = db_utils::fieldsMemory($rsSqlWMigraHabitinscricao, 0);
		  	
		    $sSqlWHabitPrograma     = " select ht01_habitgrupoprograma                                        ";
        $sSqlWHabitPrograma    .= "   from public.w_migra_habitprograma                                   ";
        $sSqlWHabitPrograma    .= "  where ht01_sequencial = {$oWMigraHabitinscricao->ht15_habitprograma} ";
		    $rsSqlWHabitPrograma    = db_query($conn1, $sSqlWHabitPrograma);
		    $iNumRowsWHabitPrograma = pg_num_rows($rsSqlWHabitPrograma);
        if ($iNumRowsWHabitPrograma > 0) {
        	
        	$oWHabitPrograma = db_utils::fieldsMemory($rsSqlWHabitPrograma, 0);
        	
          $sSqlNextValHabitcandidatointeresse  = " select nextval('habitcandidatointeresse_ht20_sequencial_seq') as ht20_sequencial; ";
          $rsSqlNextValHabitcandidatointeresse = db_query($conn1, $sSqlNextValHabitcandidatointeresse);
          
          $oNextValHabitcandidatointeresse     = db_utils::fieldsMemory($rsSqlNextValHabitcandidatointeresse, 0);        	
        	
          db_log('Migrando registros tabela habitcandidatointeresse.', $sArquivo ,2);
          
        	$sSqlHabitCandidatoInteresse  = " INSERT INTO habitcandidatointeresse(                                                      ";
          $sSqlHabitCandidatoInteresse .= "                                      ht20_sequencial,                                     ";
          $sSqlHabitCandidatoInteresse .= "                                      ht20_habitcandidato,                                 "; 
          $sSqlHabitCandidatoInteresse .= "                                      ht20_habitgrupoprograma,                             "; 
          $sSqlHabitCandidatoInteresse .= "                                      ht20_ativo )                                         ";
          $sSqlHabitCandidatoInteresse .= "                              VALUES(                                                      ";
          $sSqlHabitCandidatoInteresse .= "                                      {$oNextValHabitcandidatointeresse->ht20_sequencial}, "; 
          $sSqlHabitCandidatoInteresse .= "                                      {$oWHabitCandidato->ht10_sequencial},                ";
          $sSqlHabitCandidatoInteresse .= "                                      {$oWHabitPrograma->ht01_habitgrupoprograma},         "; 
          $sSqlHabitCandidatoInteresse .= "                                      't' );                                               ";
          $rsSqlHabitCandidatoInteresse = db_query($conn1, $sSqlHabitCandidatoInteresse);
          if (!$rsSqlHabitCandidatoInteresse) {
            throw new Exception("Erro ao incluir registros na tabela(habitcandidatointeresse)!");
          }
          
          $sSqlCgm     = " select z01_numcgm,                                   ";
          $sSqlCgm    .= "        z01_nome                                      ";
          $sSqlCgm    .= "   from protocolo.cgm                                 ";
          $sSqlCgm    .= "  where z01_numcgm = {$oWHabitCandidato->ht10_numcgm} ";
          $rsSqlCgm    = db_query($conn1, $sSqlCgm);
          $iNumRowsCgm = pg_num_rows($rsSqlCgm);
          if ($iNumRowsCgm > 0) {
          	
          	$oCgm               = db_utils::fieldsMemory($rsSqlCgm, 0);   
          	
            $sSqlHabitPrograma     = " select db116_tipoproc                                                 ";
            $sSqlHabitPrograma    .= "   from habitprograma                                                  ";
            $sSqlHabitPrograma    .= "        inner join workflowtipoproc on db116_workflow = ht01_workflow  "; 
            $sSqlHabitPrograma    .= "  where ht01_sequencial = {$oWMigraHabitinscricao->ht15_habitprograma} ";
            $rsSqlHabitPrograma    = db_query($conn1, $sSqlHabitPrograma);
            $iNumRowsHabitPrograma = pg_num_rows($rsSqlHabitPrograma);
            
            if ($iNumRowsHabitPrograma > 0) {
            
            	$oHabitPrograma     = db_utils::fieldsMemory($rsSqlHabitPrograma, 0);
            	
		          $oProcessoProtocolo = new processoProtocolo();
		          
		          $oProcessoProtocolo->setTipoProcesso($oHabitPrograma->db116_tipoproc);
		          $oProcessoProtocolo->setCgm($oCgm->z01_numcgm);
		          $oProcessoProtocolo->setRequerente(addslashes($oCgm->z01_nome)); 
		          $oProcessoProtocolo->setObservacao(''); 
		          $oProcessoProtocolo->setDespacho(''); 
		          $oProcessoProtocolo->setInterno('f');
		          $oProcessoProtocolo->setPublico('f');      
		          $oProcessoProtocolo->salvar();
		          
		          $ht13_codproc = $oProcessoProtocolo->getCodProcesso();
              $iQtdInteressePrograma++;
		          
		          $sSqlHabitCandidatoInteressePrograma  = " INSERT INTO habitcandidatointeresseprograma(                                                                 ";
		          $sSqlHabitCandidatoInteressePrograma .= "                                              ht13_sequencial,                                                "; 
		          $sSqlHabitCandidatoInteressePrograma .= "                                              ht13_habitprograma,                                             "; 
		          $sSqlHabitCandidatoInteressePrograma .= "                                              ht13_habitcandidatointeresse,                                   "; 
		          $sSqlHabitCandidatoInteressePrograma .= "                                              ht13_codproc )                                                  ";
		          $sSqlHabitCandidatoInteressePrograma .= "                                      VALUES(                                                                 ";
		          $sSqlHabitCandidatoInteressePrograma .= "                                              nextval('habitcandidatointeresseprograma_ht13_sequencial_seq'), "; 
		          $sSqlHabitCandidatoInteressePrograma .= "                                              {$oWMigraHabitinscricao->ht15_habitprograma},                   ";
		          $sSqlHabitCandidatoInteressePrograma .= "                                              {$oNextValHabitcandidatointeresse->ht20_sequencial},            "; 
		          $sSqlHabitCandidatoInteressePrograma .= "                                              {$ht13_codproc} );                                              ";
		          $rsSqlHabitCandidatoInteressePrograma = db_query($conn1, $sSqlHabitCandidatoInteressePrograma);
		          if (!$rsSqlHabitCandidatoInteressePrograma) {
		            throw new Exception("Erro ao incluir registros na tabela(habitcandidatointeresseprograma)!");
		          }
            }
          }
        }
		  }
		  
		  logProcessamento($iInd, $iNumRowsSqlWHabitCandidato, 0);
  	}
  }
  
  db_log('Ajustando sequences das tabelas.', $sArquivo ,2);
  
  $sSqlResetSequence     = " select c.relname                                                       ";
  $sSqlResetSequence    .= "   from pg_catalog.pg_class c                                           ";
  $sSqlResetSequence    .= "        inner join pg_catalog.pg_roles     r on r.oid = c.relowner      ";
  $sSqlResetSequence    .= "        left  join pg_catalog.pg_namespace n on n.oid = c.relnamespace  ";
  $sSqlResetSequence    .= "  where c.relkind in ('S')                                              ";
  $sSqlResetSequence    .= "    and n.nspname = 'habitacao'                                         ";  
  $rsSqlResetSequence    = db_query($conn1, $sSqlResetSequence);
  $iNumRowsResetSequence = pg_num_rows($rsSqlResetSequence);
  if ($iNumRowsResetSequence > 0) {
    
    $aRecordSet = array();  
    for ($iIndX = 0; $iIndX < $iNumRowsResetSequence; $iIndX++) {
      
      $oResetSequence = db_utils::fieldsMemory($rsSqlResetSequence, $iIndX);
      
      $aRecordSet  = explode("_", $oResetSequence->relname);
      $sSqlSetVal  = " select setval('{$oResetSequence->relname}',(select max({$aRecordSet[1]}_{$aRecordSet[2]}) from {$aRecordSet[0]})); ";
      $rsSqlSetVal = db_query($conn1, $sSqlSetVal);
      if (!$rsSqlSetVal) {
        throw new Exception("Erro ao ajustar valor sequencial da tabela({$aRecordSet[0]})!");
      }
      
      logProcessamento($iIndX, $iNumRowsResetSequence, 0);
    }
  }
  
  db_log('Migracao registros concluida com sucesso.', $sArquivo ,0);
  db_log('',                                          $sArquivo ,0);
  
  db_query($conn1, "COMMIT");  
} catch ( Exception $eException ) {
  
  db_query($conn1, "ROLLBACK");
  db_log($eException->getMessage(), $sArquivo ,0);
}

db_log("Quantidade de inscritos em programas : {$iQtdInteressePrograma}",$sArquivo ,0);
db_log('OBS: Favor verificar os logs gerados no diretorio ./log_*',                         $sArquivo ,0);
db_log('OBS: Cuidado script deve ser executado apenas 1x, para nao duplicar os registros.', $sArquivo ,0);
db_log('',                                                                                  $sArquivo ,0);


function db_getsession($var){
  
  global $instit;

  $aSessao['DB_id_usuario'] = 1;
  $aSessao['DB_instit']     = $instit;
  $aSessao['DB_coddepto']   = 15;
  $aSessao['DB_datausu']    = mktime(0, 0, 0, date('m'),date('d'), date('Y'));// date();
  return $aSessao[$var];
  
}

function db_hora(){
  return date('H').":".date('i'); 
}


/**
 * Função que exibe na tela a quantidade de registros processados 
 * e a quandidade de memória utilizada
 *
 * @param integer $iInd      Indice da linha que está sendo processada
 * @param integer $iTotalLinhas  Total de linhas a processar
 * @param integer $iParamLog     Caso seja passado true é exibido na tela 
 */
function logProcessamento($iInd,$iTotalLinhas,$iParamLog) {
  
  $nPercentual = round((($iInd + 1) / $iTotalLinhas) * 100, 2);
  $nMemScript  = (float)round( (memory_get_usage()/1024 ) / 1024,2);
  $sMemScript  = $nMemScript ." Mb";
  $sMsg        = " ".($iInd+1)." de {$iTotalLinhas} Processando {$nPercentual} %"." Total de memoria utilizada : {$sMemScript} ";
  $sMsg        = str_pad($sMsg,100," ",STR_PAD_RIGHT);
  
  db_log($sMsg."\r",null,$iParamLog,true,false);
}


class rotulo {
  //|00|//rotulo
  //|10|//Esta classe gera as variáveis de controle do sistema de uma determinada tabela
  //|15|//[variavel] = new rotulo($tabela);
  //|20|//tabela  : Nome da tabela a ser pesquisada
  //|40|//Gera todas as variáveis de controle dos campos
  //|99|//
  var $tabela;
  function rotulo($tabela) {
    $this->tabela = $tabela;
  }
  function rlabel($nome = "") {
    //#00#//rlabel
    //#10#//Este método gera o label do campo ou campos para relatório
    //#15#//rlabel($nome);
    //#20#//nome  : Nome do campo a ser gerado o label para relatório
    //#20#//        Se não for informado campo, será gerado de todos os campos
    //#40#//Gera a variável label do relatorio do campo rotulorel
    //#99#//A variável será o "RL" mais o nome do campo
    //#99#//Exemplo : campo z01_nome ficará RLz01_nome
    $sCampoTrim = trim($nome);
    $result = pg_exec("select c.rotulorel
                         from db_syscampo c
                              inner join db_sysarqcamp s on s.codcam = c.codcam
                              inner join db_sysarquivo a on a.codarq = s.codarq
                        where a.nomearq = '".$this->tabela."'
                        ". ($sCampoTrim != "" ? "and c.nomecam = '${sCampoTrim}'" : ""));
    $numrows = pg_numrows($result);
    for ($i = 0; $i < $numrows; $i ++) {
      /// variavel para colocar como label de campo
      $variavel = "RL".trim(pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = ucfirst(trim(pg_result($result, $i, "rotulorel")));
    }
  }
  
  function label($nome = "") {
    //#00#//label
    //#10#//Este método gera o label do arquivo ou de um campo para os formulários
    //#15#//label($nome);
    //#20#//nome  : Nome do campo a ser gerado as variáveis de controle
    //#20#//        Se não informado o campo, será gerado de todos os campos
    //#99#//Nome das variáveis geradas:
    //#99#//"I" + nome do campo -> Tipo de consistencia javascript a ser gerada no formulário (|aceitatipo|)
    //#99#//"A" + nome do campo -> Variavel para determinar o autocomplete no objeto (!autocompl|)
    //#99#//"U" + nome do campo -> Variavel para preenchimento obrigatorio do campo (|nulo|)
    //#99#//"G" + nome do campo -> Variavel para colocar se letras do objeto devem ser maiusculo ou não (|maiusculo|)
    //#99#//"S" + nome do campo -> Variavel para colocar mensagem de erro do javascript de preenchimento de campo (|rotulo|)
    //#99#//"L" + nome do campo -> Variavel para colocar como label de campo (|rotulo|)
    //#99#//                       Coloca o campo com a primeira letra maiuscula e entre tags strong (negrito) (|rotulo|)
    //#99#//"T" + nome do campo -> Variavel para colocat na tag title dos campos (|descricao|)
    //#99#//"M" + nome do campo -> Variavel para incluir o tamanho da propriedade maxlength dos campos (|tamanho|)
    //#99#//"N" + nome do campo -> Variavel para controle da cor de fundo quando o  campo aceitar nulo (|nulo|)
    //#99#//                       style="background-color:#E6E4F1";
    //#99#//"RL"+ nome do campo -> Variavel para colocar como label de campo nos relatorios
    //#99#//"TC"+ nome do campo -> Variavel com o tipo de campo do banco de dados

    //        $result = pg_exec("select c.descricao,c.rotulo,c.nomecam,c.tamanho,c.nulo,c.maiusculo,c.autocompl,c.conteudo,c.aceitatipo,c.rotulorel
    //                                   from db_syscampo c
    //                                                   inner join db_sysarqcamp s
    //                                                   on s.codcam = c.codcam
    //                                                   inner join db_sysarquivo a
    //                                                   on a.codarq = s.codarq
    //                                                   where a.nomearq = '".$this->tabela."'
    //                                                   ". ($nome != "" ? "and trim(c.nomecam) = trim('$nome')" : ""));
    $sCampoTrim = trim($nome);
    $result = pg_exec("select c.descricao,c.rotulo,c.nomecam,c.tamanho,c.nulo,c.maiusculo,c.autocompl,c.conteudo,c.aceitatipo,c.rotulorel
                         from db_sysarquivo a
                              inner join db_sysarqcamp s on s.codarq = a.codarq
                              inner join db_syscampo c on c.codcam = s.codcam
                        where a.nomearq = '".$this->tabela."'
                        ". ($sCampoTrim != "" ? "and c.nomecam = '${sCampoTrim}'" : ""));
    $numrows = pg_numrows($result);
    for ($i = 0; $i < $numrows; $i ++) {
      /// variavel com o tipo de campo
      $variavel = trim("I".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "aceitatipo");
      /// variavel para determinar o autocomplete
      $variavel = trim("A".pg_result($result, $i, "nomecam"));
      global $$variavel;
      if (pg_result($result, $i, "autocompl") == 'f') {
        $$variavel = "off";
      } else {
        $$variavel = "on";
      }
      /// variavel para preenchimento obrigatorio
      $variavel = trim("U".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "nulo");
      /// variavel para colocar maiusculo
      $variavel = trim("G".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "maiusculo");
      /// variavel para colocar no erro do javascript de preenchimento de campo
      $variavel = trim("S".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "rotulo");
      /// variavel para colocar como label de campo
      $variavel = trim("L".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = "<strong>".ucfirst(pg_result($result, $i, "rotulo")).":</strong>";

      /// variavel para colocar como label de campo
      $variavel = trim("LS".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = ucfirst(pg_result($result, $i, "rotulo"));

      /// vaariavel para colocat na tag title dos campos
      $variavel = trim("T".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = ucfirst(pg_result($result, $i, "descricao"))."\n\nCampo:".pg_result($result, $i, "nomecam");
      /// variavel para incluir o tamanhoda tag maxlength dos campos
      $variavel = trim("M".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "tamanho");
      /// variavel para controle de campos nulos
      $variavel = trim("N".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "nulo");
      if ($$variavel == "t")
      $$variavel = "style=\"background-color:#E6E4F1\"";
      else
      $$variavel = "";
      /// variavel para colocar como label de campo nos relatorios
      $variavel = trim("RL".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = ucfirst(pg_result($result, $i, "rotulorel"));
      /// variavel para colocar o tipo de campo
      $variavel = "TC".trim(pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "conteudo");

    }
  }
  
  function tlabel($nome = "") {
    //#00#//tlabel
    //#10#//Este método gera o label do arquivo
    //#15#//tlabel($nome);
    //#20#//nome  : Nome do arquivo para ser gerado o label
    //#40#//Gera a variável label do arquivo "L" + nome do arquivo
    //#99#//Variáveis geradas:
    //#99#//"L" + nome do arquivo -> Label do arquivo
    //#99#//"T" + nome do arquivo -> Texto para a tag title

    $result = pg_exec("select c.nomearq,c.descricao,c.nomearq,c.rotulo
                         from db_sysarquivo c
                        where c.nomearq = '".$this->tabela."'");
    $numrows = pg_numrows($result);
    if ($numrows > 0) {
      $variavel = trim("L".pg_result($result, 0, "nomearq"));
      global $$variavel;
      $$variavel = "<strong>".pg_result($result, 0, "rotulo").":</strong>";
      $variavel = trim("T".pg_result($result, 0, "nomearq"));
      global $$variavel;
      $$variavel = pg_result($result, 0, "descricao");
    }
  }
}

class rotulocampo {
  //|00|//rotulocampo
  //|10|//Esta classe gera as variáveis de controle do sistema de uma determinada tabela
  //|15|//[variavel] = new rotulocampo($campo);
  //|20|//campo  : Nome do campo a ser pesquisada
  //|40|//Gera todas as variáveis de controle do campo
  //|99|//Exemplo:
  //|99|//[variavel] = new rotulocampo("z01_nome");
  //|99|//ou
  //|99|//[variavel] = new rotulocampo();
  //|99|//[variavel]->label("z01_nome");
  function label($campo = "") {
    //#00#//label
    //#10#//Este método gera o label do campo
    //#15#//label($campo);
    //#20#//nome  : Nome do campo a ser gerado as variáveis de controle
    //#99#//Nome das variáveis geradas:
    //#99#//"I" + nome do campo -> Tipo de consistencia javascript a ser gerada no formulário (|aceitatipo|)
    //#99#//"A" + nome do campo -> Variavel para determinar o autocomplete no objeto (!autocompl|)
    //#99#//"U" + nome do campo -> Variavel para preenchimento obrigatorio do campo (|nulo|)
    //#99#//"G" + nome do campo -> Variavel para colocar se letras do objeto devem ser maiusculo ou não (|maiusculo|)
    //#99#//"S" + nome do campo -> Variavel para colocar mensagem de erro do javascript de preenchimento de campo (|rotulo|)
    //#99#//"L" + nome do campo -> Variavel para colocar como label de campo (|rotulo|)
    //#99#//                       Coloca o campo com a primeira letra maiuscula e entre tags strong (negrito) (|rotulo|)
    //#99#//"T" + nome do campo -> Variavel para colocat na tag title dos campos (|descricao|)
    //#99#//"M" + nome do campo -> Variavel para incluir o tamanho da propriedade maxlength dos campos (|tamanho|)
    //#99#//"N" + nome do campo -> Variavel para controle da cor de fundo quando o  campo aceitar nulo (|nulo|)
    //#99#//                       style="background-color:#E6E4F1";
    //#99#//"RL"+ nome do campo -> Variavel para colocar como label de campo nos relatorios
    //#99#//"TC"+ nome do campo -> Variavel com o tipo de campo do banco de dados
    //#99#//"LS"+ nome do campo -> Variavel para colocar como label de campo sem as tags STRONG

    $sCampoTrim = trim($campo);
    $result = pg_exec("select c.descricao,c.rotulo,c.nomecam,c.tamanho,c.nulo,c.maiusculo,c.autocompl,c.conteudo,c.aceitatipo,c.valorinicial,c.rotulorel
                         from db_syscampo c
                        where c.nomecam = '${sCampoTrim}'");
    $numrows = pg_numrows($result);
    for ($i = 0; $i < $numrows; $i ++) {

      /// variavel com o tipo de campo
      $variavel = trim("I".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "aceitatipo");
      /// variavel para determinar o autocomplete
      $variavel = trim("A".pg_result($result, $i, "nomecam"));
      global $$variavel;
      if (pg_result($result, $i, "autocompl") == 'f') {
        $$variavel = "off";
      } else {
        $$variavel = "on";
      }
      /// variavel para preenchimento obrigatorio
      $variavel = trim("U".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "nulo");
      /// variavel para colocar maiusculo
      $variavel = trim("G".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "maiusculo");
      /// variavel para colocar no erro do javascript de preenchimento de campo
      $variavel = trim("S".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "rotulo");
      /// variavel para colocar como label de campo
      $variavel = trim("L".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = "<strong>".ucfirst(pg_result($result, $i, "rotulo")).":</strong>";

      /// variavel para colocar como label de campo
      $variavel = trim("LS".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = ucfirst(pg_result($result, $i, "rotulo"));

      /// vaariavel para colocat na tag title dos campos
      $variavel = trim("T".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = ucfirst(pg_result($result, $i, "descricao"))."\n\nCampo:".pg_result($result, $i, "nomecam");
      /// variavel para incluir o tamanhoda tag maxlength dos campos
      $variavel = trim("M".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "tamanho");
      /// variavel para controle de campos nulos
      $variavel = trim("N".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "nulo");
      if ($$variavel == "t")
      $$variavel = "style=\"background-color:#E6E4F1\"";
      else
      $$variavel = "";
      if ('DBtxt' == substr(trim(pg_result($result, $i, "nomecam")), 0, 5)) {
        $variavel = trim(pg_result($result, $i, "nomecam"));
        global $$variavel;
        $$variavel = pg_result($result, $i, "valorinicial");
      }
      /// variavel para colocar como label de campo nos relatorios
      $variavel = trim("RL".pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = ucfirst(pg_result($result, $i, "rotulorel"));
      /// variavel para colocar o tipo de campo
      $variavel = "TC".trim(pg_result($result, $i, "nomecam"));
      global $$variavel;
      $$variavel = pg_result($result, $i, "conteudo");

    }
  }
}
?>