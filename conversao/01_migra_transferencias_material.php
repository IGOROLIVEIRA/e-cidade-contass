
<?
require_once(__DIR__ . "/../libs/db_conn.php");
require_once(__DIR__ . "/../libs/db_utils.php");
require_once(__DIR__ . "/../libs/db_stdlib.php");

/*
$DB_SERVIDOR = 'localhost';
$DB_BASE     = 'macedo_bage';
$DB_PORTA    = '5432';
$DB_USUARIO  = 'postgres';
$DB_SENHA    = '';
*/

if (!($conn = @pg_connect("host = '$DB_SERVIDOR' dbname = '$DB_BASE' port = '$DB_PORTA' user = '$DB_USUARIO' password = $DB_SENHA"))) {
  echo "Erro ao conectar com a base de dados";
  exit;
}

pg_query("select fc_startsession()");

$sSqlInstit = "select codigo from db_config where prefeitura is true limit 1";
$rsInstit   = pg_query($sSqlInstit);
$aInstit    = db_utils::getColectionByRecord($rsInstit);
// codigo da instituição prefeitura. 
foreach ($aInstit as $indiceInstit => $valorInstit) {
	
	$iCodigoInstit = $valorInstit->codigo;
}


$sSqlSetaInstit = "select fc_putsession('DB_instit', {$iCodigoInstit} );";
pg_query($sSqlSetaInstit);
/*
 *Migra todas as transferencias que foram realizadas com o tipo 8, para o novo tipo  21, 
 * onde a saida do estoque é realizado junto com a saida
 */
db_sel_instit($iCodigoInstit);
$iInicio = time(); 
$sSqlTransferencias  = "SELECT a.m80_codigo as codigo7, ";
$sSqlTransferencias .= "       a.m80_coddepto as departamento, ";
$sSqlTransferencias .= "       a.m80_login as usuario, ";
$sSqlTransferencias .= "       b.m80_codigo as codigo8, ";
$sSqlTransferencias .= "       b.m80_data as datatrans, ";
$sSqlTransferencias .= "       b.m80_hora as horatrans, ";
$sSqlTransferencias .= "       to_char(to_timestamp(b.m80_data || ' ' || b.m80_hora, 'YYYY-MM-DD HH24:MI:SS') -'1 second'::interval, 'YYYY-mm-dd') as datasaida,";
$sSqlTransferencias .= "       to_char(to_timestamp(b.m80_data || ' ' || b.m80_hora, 'YYYY-MM-DD HH24:MI:SS') -'1 second'::interval, 'HH24:MI:SS') as horasaida,";
$sSqlTransferencias .= "       m86_codigo, ";
$sSqlTransferencias .= "       m87_matestoqueinil ";
$sSqlTransferencias .= "  from matestoqueini a left join matestoqueinil on m86_matestoqueini = a.m80_codigo ";
$sSqlTransferencias .= "       left join matestoqueinill on m87_matestoqueinil = m86_codigo ";
$sSqlTransferencias .= "       left join matestoqueini b on b.m80_codigo = m87_matestoqueini ";
$sSqlTransferencias .= " where b.m80_codtipo = 8 and a.m80_codtipo <> 21";
$rsTransferencias    = pg_query($sSqlTransferencias); 
$iTotalLinhas        = pg_num_rows($rsTransferencias);
pg_query("BEGIN");
pg_query('alter table matestoqueinimei disable trigger all');
$lErro = false;
for ($i = 0; $i < $iTotalLinhas; $i++) {
  
  $oLinha = db_utils::fieldsMemory($rsTransferencias, $i);
  /**
   *Incluimos o movimento de transferencia, e ligamos a transferencia ao novo movimento.
   */
   $rsCodigoTransferencia = pg_query("select nextval('matestoqueini_m80_codigo_seq') as codigo");
   if ($rsCodigoTransferencia) {

      $iCodigoTransferencia = db_utils::fieldsMemory($rsCodigoTransferencia, 0)->codigo;

      $sInsert   = "insert into matestoqueini ";
      $sInsert  .= "       (m80_codigo, ";
      $sInsert  .= "       m80_login, ";
      $sInsert  .= "       m80_data, ";
      $sInsert  .= "       m80_obs, ";
      $sInsert  .= "       m80_codtipo, ";
      $sInsert  .= "       m80_coddepto, ";
      $sInsert  .= "       m80_hora) ";
      $sInsert  .= "      values ";
      $sInsert  .= "     ({$iCodigoTransferencia},";
      $sInsert  .= "     {$oLinha->usuario},";
      $sInsert  .= "     '{$oLinha->datasaida}',";
      $sInsert  .= "     'Transferencia migrada',";
      $sInsert  .= "     21,";
      $sInsert  .= "     {$oLinha->departamento},";
      $sInsert  .= "     '{$oLinha->horasaida}')";
      $rsInsert  = pg_query($sInsert); 
      if (!$rsInsert) {

         $lErro = true;
         echo pg_last_error()."\n";
      }
      /**
       *Vinculamos os dados da transferencia ao movimento de codtipo 7
       */
      if (!$lErro) {
       
        $rsCodigiInil  = pg_query("select nextval('matestoqueinil_m86_codigo_seq') as codigo");
        $iCodigoInil   = db_utils::fieldsMemory($rsCodigiInil, 0)->codigo;
        $sInsertIniNil = "insert into matestoqueinil values ({$iCodigoInil}, {$oLinha->codigo7})"; 
        $rsInsertInil  = pg_query($sInsertIniNil);
         
        $sSqlInsertInill = "insert into matestoqueinill values ({$iCodigoInil}, {$iCodigoTransferencia})";
        $rsInsertInill   = pg_query($sSqlInsertInill);

        /**
         * Atualizamos a ligaçao do movimento tipo 8 para a saida do tipo 21 
         * 
         */
         $sSqlUpdateNil = "update matestoqueinil set m86_matestoqueini = {$iCodigoTransferencia} where m86_codigo = {$oLinha->m86_codigo}";
         $rsUpdateNil   = pg_query($sSqlUpdateNil);
        if (!$lErro) {
          
          /**
           * vinculamos os itens da transferencia ao novo movimento
           */
          $sSqlItensTrans = "SELECT m82_matestoqueitem,coalesce(m82_quant,0) as m82_quant from matestoqueinimei where m82_matestoqueini = {$oLinha->codigo7}";
          $rsItensTransf  = pg_query($sSqlItensTrans);
          $iTotalItens    = pg_num_rows($rsItensTransf);
          for ($iItem = 0; $iItem < $iTotalItens; $iItem++) {

             echo "iProcessando Item:{$iItem}de {$iTotalItens}\n";
             $oItem = db_utils::fieldsMemory($rsItensTransf, $iItem);
             $sSqlCodigoIniMei  = "select nextval('matestoqueinimei_m82_codigo_seq') as codigo";
             $iCodigoIniMei     = db_utils::fieldsMemory(pg_query($sSqlCodigoIniMei), 0)->codigo;

             $sInsertIniMei  = "insert into matestoqueinimei (";
             $sInsertIniMei .= "       m82_codigo,";
             $sInsertIniMei .= "       m82_matestoqueini,";
             $sInsertIniMei .= "       m82_matestoqueitem,";
             $sInsertIniMei .= "       m82_quant )";
             $sInsertIniMei .= " values ({$iCodigoIniMei},"; 
             $sInsertIniMei .= "        {$iCodigoTransferencia},";
             $sInsertIniMei .= "        {$oItem->m82_matestoqueitem},";
             $sInsertIniMei .= "        {$oItem->m82_quant})";
             $rsInsertInill  = pg_query($sInsertIniMei);
             if (!$rsInsertInill) {

               $lErro = true;
               echo pg_last_error()."\n";
               break;
            } else {
              /**
               * Acerto o preco medio do item
               */
              $sSqlPrecoMedio = "select fc_calculaprecomedio({$iCodigoIniMei}::integer, {$iCodigoTransferencia}::integer,{$oItem->m82_quant},false)";
            
              $rsPrecoMedio   = pg_query($sSqlPrecoMedio);
            }
          }
        }

      }
   } else {
    
     $lErro = true;
     break;
   }
}
pg_query('alter table matestoqueinimei enable trigger all');
if ($lErro) {
  
  echo "Erro no Processamento";
  pg_query('ROLLBACK');
} else {
  pg_query('commit');
}
$iFim = time();
$tempoTotal = ($iFim - $iInicio);
echo "Tempo total: {$tempoTotal} Segundos\n";
?>
 


