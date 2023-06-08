<?php
require_once 'model/relatorios/Relatorio.php';
include("classes/db_db_docparag_classe.php");

// include("fpdf151/pdf.php");
require("libs/db_utils.php");
$oGet = db_utils::postMemory($_GET);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);


/**
 * BUSCO PROCESSO DE COMPRAS
 */

 $rscodproc = "select distinct pc81_codproc from pcprocitem where pc81_solicitem in (select pc11_codigo from solicitem where pc11_numero =  {$solicitacaocompras})";
 $resultCodproc = db_query($rscodproc);
 $codigo_preco    = db_utils::fieldsMemory($resultCodproc, 0)->pc81_codproc;

if(pg_num_rows($resultCodproc)!=0){
/**
 * BUSCO DADOS DA INSTITUICAO
 *
 */


 $sql = "select nomeinst,
 bairro,
 cgc,
 trim(ender)||','||trim(cast(numero as text)) as ender,
 upper(munic) as munic,
 uf,
 telef,
 email,
 url,
 logo, 
 db12_extenso
 from db_config 
 inner join db_uf on db12_uf = uf
 where codigo = ".db_getsession("DB_instit");
 $result = db_query($sql);
 db_fieldsmemory($result,0);
 
 /**
  * BUSCO TIPO DE PRECO DE REFERENCIA
  */
 
 $rsLotes = db_query("select distinct  pc68_sequencial,pc68_nome
 from
     pcproc
 join pcprocitem on
     pc80_codproc = pc81_codproc
 left join processocompraloteitem on
     pc69_pcprocitem = pcprocitem.pc81_codprocitem
 left join processocompralote on
     pc68_sequencial = pc69_processocompralote
 where
     pc80_codproc = {$codigo_preco}
     and pc68_sequencial is not null
     order by pc68_sequencial asc");
 
 
 
 
 $rsResultado = db_query("select pc80_criterioadjudicacao from pcproc where pc80_codproc = {$codigo_preco}");
 $criterio    = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
 $sCondCrit   = ($criterio == 3 || empty($criterio)) ? " AND pc23_valor <> 0 " : "";

 $rsTipopreco = db_query("select si01_tipoprecoreferencia from precoreferencia where si01_processocompra = {$codigo_preco}");
$resultTipopreco    = db_utils::fieldsMemory($rsTipopreco, 0)->si01_tipoprecoreferencia;

if($resultTipopreco==3){
    $tipoReferencia = " (min(pc23_vlrun)) ";
}else if($resultTipopreco==2){
    $tipoReferencia = " (max(pc23_vlrun)) ";
}else{
    $tipoReferencia = " (sum(pc23_vlrun)/count(pc23_orcamforne)) ";
}
 
 /**
  * GET ITENS
  */
 $sSql = "select * from (SELECT
                 pc01_codmater,
                 case when pc01_complmater is not null and pc01_complmater != pc01_descrmater then pc01_descrmater ||'. '|| pc01_complmater
              else pc01_descrmater end as pc01_descrmater,
                 m61_abrev,
                 sum(pc11_quant) as pc11_quant,
                 pc69_seq,
                 pc11_seq
 from (
 SELECT DISTINCT pc01_servico,
                 pc11_codigo,
                 pc11_seq,
                 pc11_quant,
                 pc11_prazo,
                 pc11_pgto,
                 pc11_resum,
                 pc11_just,
                 m61_abrev,
                 m61_descr,
                 pc17_quant,
                 pc01_codmater,
                 pc01_descrmater,pc01_complmater,
                 pc10_numero,
                 pc90_numeroprocesso AS processo_administrativo,
                 (pc11_quant * pc11_vlrun) AS pc11_valtot,
                 m61_usaquant,
                 pc69_seq
 FROM solicitem
 INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
 LEFT JOIN solicitaprotprocesso ON solicitaprotprocesso.pc90_solicita = solicita.pc10_numero
 LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
 LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
 LEFT JOIN pcprocitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
 LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
 LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
 LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
 LEFT JOIN orcelemento ON solicitemele.pc18_codele = orcelemento.o56_codele
 left join processocompraloteitem on
         pc69_pcprocitem = pcprocitem.pc81_codprocitem
 left join processocompralote on
             pc68_sequencial = pc69_processocompralote
 AND orcelemento.o56_anousu = " . db_getsession("DB_anousu") . "
 WHERE pc81_codproc = {$codigo_preco}
   AND pc10_instit = " . db_getsession("DB_instit") . "
 ORDER BY pc11_seq) as x GROUP BY
                 pc01_codmater,
                 pc11_seq,
                 pc01_descrmater,pc01_complmater,m61_abrev,pc69_seq ) as matquan join
 (SELECT DISTINCT
                 pc11_seq,
                 {$tipoReferencia} as si02_vltotalprecoreferencia,
                                      case when pc80_criterioadjudicacao = 1 then
                      round((sum(pc23_perctaxadesctabela)/count(pc23_orcamforne)),2)
                      when pc80_criterioadjudicacao = 2 then
                      round((sum(pc23_percentualdesconto)/count(pc23_orcamforne)),2)
                      end as mediapercentual,
                 pc01_codmater,
                 si01_datacotacao,
                 pc80_criterioadjudicacao,
                 pc01_tabela,
                 pc01_taxa,
                 si01_justificativa
 FROM pcproc
 JOIN pcprocitem ON pc80_codproc = pc81_codproc
 JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
 JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
 JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
 JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
 JOIN solicitem ON pc81_solicitem = pc11_codigo
 JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
 JOIN pcmater ON pc16_codmater = pc01_codmater
 JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
 JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
 WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0
 GROUP BY pc11_seq, pc01_codmater,si01_datacotacao,si01_justificativa,pc80_criterioadjudicacao,pc01_tabela,pc01_taxa
 ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by matquan.pc11_seq asc";
 $resultpreco = db_query($sSql) or die(pg_last_error());
 
 for ($iCont = 0; $iCont < pg_num_rows($resultpreco); $iCont++) {
 
        $oResult = db_utils::fieldsMemory($resultpreco, $iCont);
 
        //    if($quant_casas){
        $lTotal = round($oResult->si02_vltotalprecoreferencia * $oResult->pc11_quant, 2);
        $nTotalItens += $lTotal;
 }
 
 /**
  * BUSCO O VALOR TOTAL DO PRECO DE REFERENCIA
  *
  */
 $sqlObjeto = "select pc80_resumo as objeto from pcproc where pc80_codproc = $codigo_preco";
 $resultObjeto = db_query($sqlObjeto);
 db_fieldsmemory($resultObjeto,0);
}
 /**
* BUSCO O TEXTO NO CADASTRO DE PARAGRAFOS
*
*/
$sqlparag = "select db02_texto from db_paragrafo inner join db_docparag on db02_idparag = db04_idparag inner join db_documento on db04_docum = db03_docum where db03_descr='SOLICITACAO DE DISPO. FINANCEIRA1' and db03_instit = " . db_getsession("DB_instit")." order by db04_ordem ";
$resparag = db_query($sqlparag);

?>

<?php
header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=Solicitacao_Parecer_Financeiro_".$solicitacaocompras.".doc");
?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">

    <head>
        <title>Relatório</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <style>
        div {
            font-size: 14px;
            text-align: center;
            border: 1px solid black;
        }

        table {
            font-size: 12px;
            border: 1px solid black;
        }
        .headerpref {
            margin-top: 10px;
            font-size: 11px;
        }
        .headertitulo {
            border: 1px solid black;
            border-collapse: collapse;
            background-color: #DCDCDC;
            margin-top: 10px;
            font-size: 11px;
        }
        .headertr {
            margin-top: 10px;
            font-size: 11px;
            width:auto;
        }
    </style>

    <body>
            <table>
                <tr class="headertr">
                <td class="headerpref" width="500px">  
                <?php
                    echo $nomeinst."<br>".$ender."<br>".$munic." - ".$uf."<br>".$telef." - CNPJ : ".$cgc."<br>".$email."<br>".$url."</p>";       
                ?>
                </td>
                <td class="headertitulo" colspan="3"> SOLICITAÇÃO DE PARECER DE DISPONIBILIDADE FINANCEIRA </td>
                <tr>
            </table>
            <hr  style="border: 6px solid #000000;">
            <?php
                if(pg_num_rows($resparag) != 0){
                    db_fieldsmemory( $resparag, 0 );
                    eval($db02_texto);
                }  

            ?>

            <div>
                <?php
                if(pg_num_rows($resparag) != 0){
                    db_fieldsmemory( $resparag, 1 );
                    eval($db02_texto);
                }
                ?>
            </div>
            <br>
            <br>
            <div style="text-align: center;">
                <?php
                    $data = db_getsession('DB_datausu');
                    $sDataExtenso     = db_dataextenso($data);
                    echo "<p>".$munic.','.strtoupper($sDataExtenso)."</p>";       
                ?>
            </div>
            <br>
            <br>
            <br>
            <br>
            <?php
                if(pg_num_rows($resparag) != 0){
                    db_fieldsmemory( $resparag, 2 );
                    eval($db02_texto);
                }  

            ?>
            </table>
        
    </body>

    </html>
