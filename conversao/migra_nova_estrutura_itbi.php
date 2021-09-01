<?php

require(__DIR__ . "/../libs/db_utils.php");
require(__DIR__ . "/../libs/db_conn.php");

$DB_USUARIO         = "postgres";
$DB_SENHA           = "";
$DB_SERVIDOR        = "192.168.0.52";                // ip do servidor.
$DB_BASE            = "auto_sapiranga_20090330_v99"; // nome da base de dados
$DB_PORTA           = "5432";

$iUsuarioMigracao   = "1";// Padrão 1 - Usuário DBSELLER

// Departamento por Cliente
//
// Sapiranga   : 4
// Alegrete    : 234
// Charqueadas : 73

$iDeptoMigracao     = "4"; 


echo "inicio da migracao: ".date("d/m/Y")." - ".date("h:i:s");
echo "\nConectando...\n";

$aComandosSql[] = " CREATE SEQUENCE itbiavaliaformapagamentovalor_it24_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1";
$aComandosSql[] = " CREATE SEQUENCE itbialt_it30_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1 ";
$aComandosSql[] = " CREATE SEQUENCE itbidadosimovelsetorloc_it29_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1; ";
$aComandosSql[] = " CREATE SEQUENCE itbiformapagamento_it27_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807  START 1 CACHE 1;";
$aComandosSql[] = " CREATE SEQUENCE itbiformapagamentovalor_it26_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;";
$aComandosSql[] = " CREATE SEQUENCE itbitransacaoformapag_it25_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;";

$aComandosSql[] = " CREATE TABLE itbiavaliaformapagamentovalor(
                                 it24_sequencial			int4 default 0,
                                 it24_itbitransacaoformapag	int4 default 0,
                                 it24_itbiavalia			int4 default 0,
                                 it24_valor					float8 default 0,
                                 CONSTRAINT itbiavaliaformapagamentovalor_sequ_pk PRIMARY KEY (it24_sequencial)) ";
$aComandosSql[] = " CREATE TABLE itbidadosimovelsetorloc(
                                 it29_sequencial		int4 default 0,
                                 it29_setorloc		int4 default 0,
                                 it29_itbidadosimovel		int4 default 0,
                                 CONSTRAINT itbidadosimovelsetorloc_sequ_pk PRIMARY KEY (it29_sequencial)); ";

$aComandosSql[] = " CREATE TABLE itbiformapagamento(
                                 it27_sequencial		int4 default 0,
                                 it27_itbitipoformapag		int4 default 0,
                                 it27_descricao		varchar(40) ,
                                 it27_tipo		int4 default 0,
                                 it27_aliquota		float8 default 0,
                                 CONSTRAINT itbiformapagamento_sequ_pk PRIMARY KEY (it27_sequencial)) ";

$aComandosSql[] = " CREATE TABLE itbiformapagamentovalor(
                                 it26_sequencial		int4 default 0,
                                 it26_itbitransacaoformapag		int4 default 0,
                                 it26_guia		int4 default 0,
                                 it26_valor		float8 default 0,
                                 CONSTRAINT itbiformapagamentovalor_sequ_pk PRIMARY KEY (it26_sequencial)); ";

$aComandosSql[] = " CREATE TABLE itbitransacaoformapag(
                                 it25_sequencial		int4 default 0,
                                 it25_itbiformapagamento		int4 default 0,
                                 it25_itbitransacao		int4 default 0,
                                 CONSTRAINT itbitransacaoformapag_sequ_pk PRIMARY KEY (it25_sequencial)) ";

$aComandosSql[] = " CREATE TABLE paritbi(
                                 it24_anousu		int4 default 0,
                                 it24_grupoespbenfurbana		int4 default 0,
                                 it24_grupotipobenfurbana		int4 default 0,
                                 it24_grupoespbenfrural		int4 default 0,
                                 it24_grupotipobenfrural		int4 default 0,
                                 it24_grupoutilterrarural		int4 default 0,
                                 it24_grupodistrterrarural		int4 default 0,
                                 it24_diasvctoitbi		int4 default 0,
                                 CONSTRAINT paritbi_ae_pk PRIMARY KEY (it24_anousu)) ";

$aComandosSql[] = " CREATE TABLE itbialt(
                                 it30_sequencial   int4 default 0,
                                 it30_guia   int8 default 0,
                                 it30_usuario    int4 default 0,
                                 it30_dataalt    date default null,
                                 it30_hora   char(5) ,
                                 it30_dataliberacao    date default null,
                                 it30_datavenc   date default null,
                                 it30_dataitbi   date default null,
                                 CONSTRAINT itbialt_sequ_pk PRIMARY KEY (it30_sequencial));";

$aComandosSql[] = " ALTER TABLE itbialt ADD CONSTRAINT itbialt_guia_fk FOREIGN KEY (it30_guia) REFERENCES itbiavalia; ";
$aComandosSql[] = " ALTER TABLE itbialt ADD CONSTRAINT itbialt_usuario_fk FOREIGN KEY (it30_usuario) REFERENCES db_usuarios; ";
$aComandosSql[] = " ALTER TABLE itbiavaliaformapagamentovalor ADD CONSTRAINT itbiavaliaformapagamentovalor_itbiavalia_fk FOREIGN KEY (it24_itbiavalia) REFERENCES itbiavalia; "; 
$aComandosSql[] = " ALTER TABLE itbiavaliaformapagamentovalor ADD CONSTRAINT itbiavaliaformapagamentovalor_itbitransacaoformapag_fk FOREIGN KEY (it24_itbitransacaoformapag) REFERENCES itbitransacaoformapag; "; 
$aComandosSql[] = " ALTER TABLE itbidadosimovelsetorloc  ADD CONSTRAINT itbidadosimovelsetorloc_setorloc_fk FOREIGN KEY (it29_setorloc) REFERENCES setorregimovel; "; 
$aComandosSql[] = " ALTER TABLE itbidadosimovelsetorloc  ADD CONSTRAINT itbidadosimovelsetorloc_itbidadosimovel_fk FOREIGN KEY (it29_itbidadosimovel) REFERENCES itbidadosimovel; "; 
$aComandosSql[] = " ALTER TABLE itbiformapagamento      ADD CONSTRAINT itbiformapagamento_itbitipoformapag_fk FOREIGN KEY (it27_itbitipoformapag) REFERENCES itbitipoformapag; "; 
$aComandosSql[] = " ALTER TABLE itbiformapagamentovalor ADD CONSTRAINT itbiformapagamentovalor_guia_fk FOREIGN KEY (it26_guia) REFERENCES itbi; "; 
$aComandosSql[] = " ALTER TABLE itbiformapagamentovalor ADD CONSTRAINT itbiformapagamentovalor_itbitransacaoformapag_fk FOREIGN KEY (it26_itbitransacaoformapag) REFERENCES itbitransacaoformapag; "; 
$aComandosSql[] = " ALTER TABLE itbitransacaoformapag   ADD CONSTRAINT itbitransacaoformapag_transacao_fk FOREIGN KEY (it25_itbitransacao) REFERENCES itbitransacao; "; 
$aComandosSql[] = " ALTER TABLE itbitransacaoformapag   ADD CONSTRAINT itbitransacaoformapag_itbiformapagamento_fk FOREIGN KEY (it25_itbiformapagamento) REFERENCES itbiformapagamento; "; 

$aComandosSql[] = " ALTER TABLE paritbi ADD CONSTRAINT paritbi_grupoespbenfurbana_fk   FOREIGN KEY (it24_grupoespbenfurbana)   REFERENCES cargrup; "; 
$aComandosSql[] = " ALTER TABLE paritbi ADD CONSTRAINT paritbi_grupotipobenfurbana_fk  FOREIGN KEY (it24_grupotipobenfurbana)  REFERENCES cargrup; "; 
$aComandosSql[] = " ALTER TABLE paritbi ADD CONSTRAINT paritbi_grupoespbenfrural_fk    FOREIGN KEY (it24_grupoespbenfrural)    REFERENCES cargrup; "; 
$aComandosSql[] = " ALTER TABLE paritbi ADD CONSTRAINT paritbi_grupotipobenfrural_fk   FOREIGN KEY (it24_grupotipobenfrural)   REFERENCES cargrup; "; 
$aComandosSql[] = " ALTER TABLE paritbi ADD CONSTRAINT paritbi_grupoutilterrarural_fk  FOREIGN KEY (it24_grupoutilterrarural)  REFERENCES cargrup; "; 
$aComandosSql[] = " ALTER TABLE paritbi ADD CONSTRAINT paritbi_grupodistrterrarural_fk FOREIGN KEY (it24_grupodistrterrarural) REFERENCES cargrup; "; 
$aComandosSql[] = " CREATE INDEX itbiavaliaformapagamentovalor_pag_in    ON itbiavaliaformapagamentovalor(it24_itbitransacaoformapag); "; 
$aComandosSql[] = " CREATE INDEX itbiavaliaformapagamentovalor_avalia_in ON itbiavaliaformapagamentovalor(it24_itbiavalia); "; 
$aComandosSql[] = " CREATE INDEX itbidadosimovelsetorloc_setorloc_in      ON itbidadosimovelsetorloc(it29_setorloc); "; 
$aComandosSql[] = " CREATE INDEX itbidadosimovelsetorloc_dadosimovel_in   ON itbidadosimovelsetorloc(it29_itbidadosimovel); "; 
$aComandosSql[] = " CREATE INDEX itbiformapagamento_tipoformapag_in      ON itbiformapagamento(it27_itbitipoformapag); "; 
$aComandosSql[] = " CREATE INDEX itbiformapagamentovalor_transformpag_in ON itbiformapagamentovalor(it26_itbitransacaoformapag); "; 
$aComandosSql[] = " CREATE INDEX itbiformapagamentovalor_guia_in         ON itbiformapagamentovalor(it26_guia); "; 
$aComandosSql[] = " CREATE INDEX itbitransacaoformapag_iformapgto_in     ON itbitransacaoformapag(it25_itbiformapagamento); "; 
$aComandosSql[] = " CREATE INDEX itbitransacaoformapag_transacao_in      ON itbitransacaoformapag(it25_itbitransacao); "; 
$aComandosSql[] = " CREATE INDEX paritbi_grupotipobenfurbana_in          ON paritbi(it24_grupotipobenfurbana); "; 
$aComandosSql[] = " CREATE INDEX paritbi_grupoespbenfurbana_in           ON paritbi(it24_grupoespbenfurbana); "; 
$aComandosSql[] = " CREATE INDEX paritbi_grupoespbenfrural_in            ON paritbi(it24_grupoespbenfrural); "; 
$aComandosSql[] = " CREATE INDEX paritbi_grupotipobenfrural_in           ON paritbi(it24_grupotipobenfrural); "; 
$aComandosSql[] = " CREATE INDEX paritbi_grupoutilterrarural_in          ON paritbi(it24_grupoutilterrarural); "; 
$aComandosSql[] = " CREATE INDEX paritbi_grupodistrterrarura_in          ON paritbi(it24_grupodistrterrarural); "; 
$aComandosSql[] = " CREATE INDEX itbialt_guia_in                         ON itbialt(it30_guia); ";
$aComandosSql[] = " CREATE INDEX itbialt_usuario_in                      ON itbialt(it30_usuario);";

$aComandosSql[] = " ALTER TABLE itbi ADD it01_origem int4; ";
$aComandosSql[] = " ALTER TABLE itbi ADD it01_id_usuario int4; ";
$aComandosSql[] = " ALTER TABLE itbi ADD it01_coddepto int4; ";
$aComandosSql[] = " ALTER TABLE itbi ADD it01_valorterreno float8; ";
$aComandosSql[] = " ALTER TABLE itbi ADD it01_valorconstr float8; ";

$aComandosSql[] = " ALTER TABLE itbi ADD CONSTRAINT itbi_id_usuario_fk FOREIGN KEY (it01_id_usuario) REFERENCES db_usuarios; "; 
$aComandosSql[] = " ALTER TABLE itbi ADD CONSTRAINT itbi_coddepto_fk FOREIGN KEY (it01_coddepto) REFERENCES db_depart; "; 
$aComandosSql[] = " ALTER TABLE itbirural ADD it18_localimovel varchar(100); ";
$aComandosSql[] = " ALTER TABLE itbirural ADD it18_distcidade  float8; ";
$aComandosSql[] = " ALTER TABLE itbirural ADD it18_nomelograd  varchar(50); ";
$aComandosSql[] = " ALTER TABLE itbirural ADD it18_area        float8; ";
$aComandosSql[] = " ALTER TABLE itbidadosimovel ADD it22_matricri int8; ";
$aComandosSql[] = " ALTER TABLE itbidadosimovel ADD it22_setorri  varchar(40); ";
$aComandosSql[] = " ALTER TABLE itbidadosimovel ADD it22_quadrari varchar(40); ";
$aComandosSql[] = " ALTER TABLE itbidadosimovel ADD it22_loteri   varchar(40); ";

$aComandosSql[] = " ALTER TABLE itbiruralcaract ADD it19_tipocaract int4; ";
$aComandosSql[] = " ALTER TABLE itbiruralcaract ADD CONSTRAINT itbirutalcaract_tipocaract_fk FOREIGN KEY(it19_tipocaract) REFERENCES itbitipocaract;";


//
// Conectando na base de dados
//
$sConexao = "host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA";
if(!($pConexao = pg_connect($sConexao))){
  db_log("Erro ao conectar na base de dados. String de conexao : {$sConexao}");
  exit;
}

db_log("Abrindo transacao ...");
db_log("Criando estrutura na base de dados ...");

db_query($pConexao,"BEGIN;");
foreach ($aComandosSql as $sSql) {
  db_query($pConexao,$sSql);
}

db_log("Estrutura criada com sucesso...");

db_log("Ajustando valores padrao na tabela itbi...");
$sSqlValoresPadrao = "update itbi 
                         set it01_id_usuario = {$iUsuarioMigracao},  
                             it01_coddepto = {$iDeptoMigracao}, 
                             it01_origem = 1,
                             it01_valorterreno = it01_valortransacao, 
                             it01_valorconstr = 0 ;";
db_query($pConexao,$sSqlValoresPadrao);

db_log("Cadastrando formas de pagamento iniciais...");

$sSqlPkFormaPag  = "select nextval('itbiformapagamento_it27_sequencial_seq') as ipkavista;";
$rsPkFormaAvista = db_query($pConexao,$sSqlPkFormaPag);
$oPkkFormaAvista = db_utils::fieldsMemory($rsPkFormaAvista,0);

$sSqlFormaPagItbi = "insert into itbiformapagamento ( it27_sequencial,it27_itbitipoformapag,it27_descricao,it27_tipo,it27_aliquota ) 
                                             values ( {$oPkkFormaAvista->ipkavista},1,'À VISTA',3,0 );";
db_query($pConexao,$sSqlFormaPagItbi);

$sSqlPkFormaPag  = "select nextval('itbiformapagamento_it27_sequencial_seq') as ipkfinanc;";
$rsPkFormaFinanc = db_query($pConexao,$sSqlPkFormaPag);
$oPkkFormaFinanc = db_utils::fieldsMemory($rsPkFormaFinanc,0);

$sSqlFormaPagItbi = "insert into itbiformapagamento ( it27_sequencial,it27_itbitipoformapag,it27_descricao,it27_tipo,it27_aliquota ) 
                                             values ( {$oPkkFormaFinanc->ipkfinanc},2,'FINANCIADO',3,0 );";
db_query($pConexao,$sSqlFormaPagItbi);

db_log("Gerando ligacao dos tipos de transacao com formas de pagamento ...");

//
// Gerando itbitransacaoformapag
//
$sSqlItbiTranFormaPag  = "select * from itbitransacao;";
$rsItbiTranFormaPag    = db_query($pConexao,$sSqlItbiTranFormaPag);
$iNumrowsFormaPag      = pg_num_rows($rsItbiTranFormaPag);
for ($i = 0;$i < $iNumrowsFormaPag; $i ++) {

  $oItbiTranFormaPag = db_utils::fieldsMemory($rsItbiTranFormaPag,$i);
  
  $sSqlInsertTFormaPag = "insert into itbitransacaoformapag (it25_sequencial,it25_itbiformapagamento,it25_itbitransacao) 
                                                     values (nextval('itbitransacaoformapag_it25_sequencial_seq'),{$oPkkFormaAvista->ipkavista},{$oItbiTranFormaPag->it04_codigo}) ;";
  db_query($pConexao,$sSqlInsertTFormaPag); 

  $sSqlInsertTFormaPag = "insert into itbitransacaoformapag (it25_sequencial,it25_itbiformapagamento,it25_itbitransacao) 
                                                     values (nextval('itbitransacaoformapag_it25_sequencial_seq'),{$oPkkFormaFinanc->ipkfinanc},{$oItbiTranFormaPag->it04_codigo}) ;";
  db_query($pConexao,$sSqlInsertTFormaPag); 
  
}

db_log("Migrando os valores para a forma de pagamento...");
$sSqlItbiAvalia  = " select * from itbiavalia ";
$sSqlItbiAvalia .= "          inner join itbi on itbi.it01_guia = itbiavalia.it14_guia ;";
$rsItbiAvalia    = db_query($pConexao,$sSqlItbiAvalia);
$iNumRows        = pg_num_rows($rsItbiAvalia);

for ($i = 0; $i < $iNumRows; $i++) {

  $oItbiAvalia = db_utils::fieldsMemory($rsItbiAvalia,$i);

  //
  // Valores da AVALIACAO
  //
  $sSqlTFormaPag  = " select it25_sequencial ";
  $sSqlTFormaPag .= "   from itbitransacaoformapag ";
  $sSqlTFormaPag .= "  where it25_itbiformapagamento = {$oPkkFormaAvista->ipkavista} ";
  $sSqlTFormaPag .= "    and it25_itbitransacao = {$oItbiAvalia->it01_tipotransacao} ;";
  $rsTFormaPag    = db_query($pConexao,$sSqlTFormaPag);
  $oTFormaPag     = db_utils::fieldsMemory($rsTFormaPag,0);

  if ($oItbiAvalia->it14_valoraval > 0){
    $sSqlInsertValor = "insert into itbiavaliaformapagamentovalor (it24_sequencial,it24_itbitransacaoformapag,it24_itbiavalia,it24_valor)
                                                           values (nextval('itbiavaliaformapagamentovalor_it24_sequencial_seq'),
                                                                   {$oTFormaPag->it25_sequencial},
                                                                   {$oItbiAvalia->it14_guia},
                                                                   {$oItbiAvalia->it14_valoraval}) ;";
    db_query($pConexao,$sSqlInsertValor);
  }
  if ($oItbiAvalia->it01_valortransacao > 0){
    $sSqlInsertValor = "insert into itbiformapagamentovalor (it26_sequencial,it26_itbitransacaoformapag,it26_guia,it26_valor)
                                                           values (nextval('itbiformapagamentovalor_it26_sequencial_seq'),
                                                                   {$oTFormaPag->it25_sequencial},
                                                                   {$oItbiAvalia->it14_guia},
                                                                   {$oItbiAvalia->it01_valortransacao}) ;";
    db_query($pConexao,$sSqlInsertValor);
  }

  $sSqlTFormaPag  = " select it25_sequencial ";
  $sSqlTFormaPag .= "   from itbitransacaoformapag ";
  $sSqlTFormaPag .= "  where it25_itbiformapagamento = {$oPkkFormaFinanc->ipkfinanc} ";
  $sSqlTFormaPag .= "    and it25_itbitransacao = {$oItbiAvalia->it01_tipotransacao} ;";
  $rsTFormaPag    = db_query($pConexao,$sSqlTFormaPag);
  $oTFormaPag     = db_utils::fieldsMemory($rsTFormaPag,0);
  
  if ($oItbiAvalia->it14_valoravalfinanc > 0){
    $sSqlInsertValor = "insert into itbiavaliaformapagamentovalor (it24_sequencial,it24_itbitransacaoformapag,it24_itbiavalia,it24_valor)
                                                           values (nextval('itbiavaliaformapagamentovalor_it24_sequencial_seq'),
                                                                   {$oTFormaPag->it25_sequencial},
                                                                   {$oItbiAvalia->it14_guia},
                                                                   {$oItbiAvalia->it14_valoravalfinanc}) ;";
    db_query($pConexao,$sSqlInsertValor);
  }
  
  if ($oItbiAvalia->it01_valortransacaofinanc > 0){
    $sSqlInsertValor = "insert into itbiformapagamentovalor (it26_sequencial,it26_itbitransacaoformapag,it26_guia,it26_valor)
                                                     values (nextval('itbiformapagamentovalor_it26_sequencial_seq'),
                                                             {$oTFormaPag->it25_sequencial},
                                                             {$oItbiAvalia->it14_guia},
                                                             {$oItbiAvalia->it01_valortransacaofinanc});";
    db_query($pConexao,$sSqlInsertValor);
  }
  
}

db_log("Alterando tipo de característica na tabela  itbiruralcaract ...");
$sSqlAlteraItbiRuralCaract = " update itbiruralcaract set it19_tipocaract = 1; ";   
db_query($pConexao,$sSqlAlteraItbiRuralCaract);


db_query($pConexao,"ALTER TABLE itbi          DROP it01_valortransacaofinanc; ");
db_query($pConexao,"ALTER TABLE itbiavalia    DROP it14_valoravalfinanc; ");
db_query($pConexao,"ALTER TABLE itbiavalia    DROP it14_valoravalterfinanc; ");
db_query($pConexao,"ALTER TABLE itbiavalia    DROP it14_valoravalconstrfinanc; ");
db_query($pConexao,"ALTER TABLE itbiavalia    DROP it14_aliquota; ");
db_query($pConexao,"ALTER TABLE itbitransacao DROP it04_aliquota; ");
db_query($pConexao,"ALTER TABLE itbitransacao DROP it04_aliquotafinanc; ");
db_query($pConexao,"ALTER TABLE itbitransacao ADD  it04_datalimite date; ");

db_query($pConexao,"COMMIT;");

db_log("Fim da migracao: ".date("d/m/Y")." - ".date("h:i:s"));

echo "\n";

/* Funcoes */

function db_log($sLog="", $sArquivo="", $iTipo=0, $lLogDataHora=true, $lQuebraAntes=true) {
  //
  $aDataHora = getdate();
  $sQuebraAntes = $lQuebraAntes?"\n":"";
  if($lLogDataHora) {
    $sOutputLog = sprintf("%s[%02d/%02d/%04d %02d:%02d:%02d] %s", $sQuebraAntes,
                          $aDataHora["mday"], $aDataHora["mon"], $aDataHora["year"],
                          $aDataHora["hours"], $aDataHora["minutes"], $aDataHora["seconds"],
                          $sLog);
  } else {
    $sOutputLog = sprintf("%s%s", $sQuebraAntes, $sLog);
  }
  // Se habilitado saida na tela...
  if($iTipo==0 or $iTipo==1) {
    echo $sOutputLog;
  }
  // Se habilitado saida para arquivo...
  if($iTipo==0 or $iTipo==2) {
    if(!empty($sArquivo)) {
      $fd=fopen($sArquivo, "a+");
      if($fd) { 
        fwrite($fd, $sOutputLog);
        fclose($fd);
      }
    }
  }
  return $aDataHora;
}

//
// Funcao para executar uma query no PostgreSQL (com tratamento de erros e geracao de Log)
// 
function db_query($pConexao, $sSql, $sArquivoLog="", $lErroDie=true,$lIgnoreAll=false) {

  if(!is_resource($pConexao)) {
    db_log("ERRO: db_query - Conexao Invalida", $sArquivoLog);
    if($lErroDie) {
      die();
    }
    return false;
  }
  if(empty($sSql) or is_null($sSql)) {
    db_log("ERRO: db_query - Sql vazio", $sArquivoLog);
    if($lErroDie) {
      die();
    }
    return false;
  }

  $fd=fopen("/tmp/saida_itbi.sql", "a+");
  if($fd) { 
    fwrite($fd, $sSql);
    fclose($fd);
  }

  $rsRetorno = @pg_query($pConexao, $sSql);
  if(!$rsRetorno && !$lIgnoreAll) {
    $sBackTrace = var_export(debug_backtrace(), true);
    db_log("ERRO: db_query - DEBUG BACKTRACE:\n$sBackTrace", $sArquivoLog);
    db_log("ERRO: PostgreSQL (last)   - ".pg_last_error($pConexao)."\n", $sArquivoLog);
    if($lErroDie) {
      die();
    }
  }
  return $rsRetorno;
}

?>
