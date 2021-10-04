<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_liclicita_classe.php");
include("classes/db_liclicitem_classe.php");

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clliclicitem = new cl_liclicitem;
$clliclicita  = new cl_liclicita;

$clliclicita->rotulo->label("l20_codigo");
$clliclicita->rotulo->label("l20_numero");
$clliclicita->rotulo->label("l20_edital");
$clrotulo = new rotulocampo;
$clrotulo->label("l03_descr");

$sWhereContratos = " and 1 = 1 ";
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
        <td height="63" align="center" valign="top">
            <table width="35%" border="0" align="center" cellspacing="0">
                <form name="form2" method="post" action="" >
                    <tr>
                        <td width="4%" align="right" nowrap title="<?=$Tl20_codigo?>">
                            <?=$Ll20_codigo?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?
                            db_input("l20_codigo",10,$Il20_codigo,true,"text",4,"","chave_l20_codigo");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="4%" align="right" nowrap title="<?=$Tl20_edital?>">
                            <?=$Ll20_edital?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?
                            db_input("l20_edital",10,$Il20_edital,true,"text",4,"","chave_l20_edital");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td width="4%" align="right" nowrap title="<?=$Tl20_numero?>">
                            <?=$Ll20_numero?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?
                            db_input("l20_numero",10,$Il20_numero,true,"text",4,"","chave_l20_numero");
                            ?>
                        </td>
                    </tr>
                    <tr>

                    <tr>
                        <td width="4%" align="right" nowrap title="<?=$Tl03_descr?>">
                            <?=$Ll03_descr?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?
                            db_input("l03_descr",60,$Il03_descr,true,"text",4,"","chave_l03_descr");
                            db_input("param",10,"",false,"hidden",3);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                            <input name="limpar" type="reset" id="limpar" value="Limpar" >
                            <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_liclicita.hide();">
                        </td>
                    </tr>
                </form>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top">
            <?
            $and            = "and ";
            $dbwhere        = "";
            if (isset($tipo) && trim($tipo)!=""){
                $dbwhere   = "l08_altera is true and";
            }

            /**
             * QUANDO FOR ADJUDICACAO NAO DEVE RETORNAR PROCESSO QUE SAO REGISTRO DE PRECO
             */
            if(isset($homologacao) &&trim($homologacao) == "1") {
                $dbwhere .= "((liclicita.l20_tipnaturezaproced = 2 and l20_licsituacao in (1,10)) or (l20_licsituacao in (13,10))) and l200_data <= '" . date('Y-m-d', db_getsession('DB_datausu')) . "'
             and l11_data <= '" . date('Y-m-d', db_getsession('DB_datausu')) . "' and ";

            }else{
                $dbwhere .= "l20_licsituacao = 10 and l200_data <= '" . date('Y-m-d', db_getsession('DB_datausu')) . "'
             and l11_data <= '" . date('Y-m-d', db_getsession('DB_datausu')) . "' and l202_datahomologacao is not null and ";
            }
            /**
             * QUANDO FOR ADJUDICACAO NAO DEVE RETORNAR PROCESSO QUE SAO REGISTRO DE PRECO
             */
            if(isset($adjudicacao) &&trim($adjudicacao) != ""){
                $dbwhere .= "l20_tipnaturezaproced != 2 AND ";
            }
            /**
             * INCLUSAO
             */
            if(isset($adjudicacao) && trim($adjudicacao) == "1"){
                $dbwhere .= "l202_dataadjudicacao IS NULL AND l202_datahomologacao IS NULL AND ";
            }
            /**
             * ALTERACAO
             */
            if(isset($adjudicacao) && trim($adjudicacao) == "2"){
                $dbwhere .= "l202_dataadjudicacao IS NOT NULL AND l202_datahomologacao IS NULL AND ";
            }

            $sWhereModalidade = "";

            if (isset($iModalidadeLicitacao) && !empty($iModalidadeLicitacao)) {
                $sWhereModalidade = "and l20_codtipocom = {$iModalidadeLicitacao}";
            }

            $dbwhere_instit = "l20_instit = ".db_getsession("DB_instit"). "{$sWhereModalidade}";


            if (isset($lContratos) && $lContratos == 1 ) {

                $sWhereContratos .= " and ac24_sequencial is null ";
            }

                $sWhereContratos .= " AND liclicita.l20_codigo IN (SELECT DISTINCT liclicitem.l21_codliclicita
                     FROM pcprocitem
                     INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                     INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                     INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
                     INNER JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
                     LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
                     LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
                     LEFT JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
                     LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                     LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                     LEFT JOIN licitemobra ON licitemobra.obr06_pcmater = pcmater.pc01_codmater
                     LEFT JOIN pcsubgrupo ON pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo
                     LEFT JOIN pctipo ON pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo
                     LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
                     LEFT JOIN orcelemento ON orcelemento.o56_codele = solicitemele.pc18_codele
                     AND orcelemento.o56_anousu = 2021
                     LEFT JOIN empautitempcprocitem ON empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem
                     LEFT JOIN empautitem ON empautitem.e55_autori = empautitempcprocitem.e73_autori
                     AND empautitem.e55_sequen = empautitempcprocitem.e73_sequen
                     LEFT JOIN empautoriza ON empautoriza.e54_autori = empautitem.e55_autori
                     LEFT JOIN cgm ON empautoriza.e54_numcgm = cgm.z01_numcgm
                     LEFT JOIN empempaut ON empempaut.e61_autori = empautitem.e55_autori
                     LEFT JOIN empempenho ON empempenho.e60_numemp = empempaut.e61_numemp
                     LEFT JOIN liclicitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
                     LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
                     LEFT JOIN pcorcamitemlic ON liclicitem.l21_codigo = pcorcamitemlic.pc26_liclicitem
                     LEFT JOIN pcorcamitem ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
                     LEFT JOIN pcorcamjulg ON pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem
                     LEFT JOIN pcorcamval ON (pc24_orcamitem,
                                              pc24_orcamforne) = (pc23_orcamitem,
                                                                  pc23_orcamforne)
                     LEFT JOIN pcorcamforne ON pc24_orcamforne = pc21_orcamforne
                     LEFT JOIN cgm cgmforncedor ON pcorcamforne.pc21_numcgm = cgmforncedor.z01_numcgm
                     LEFT JOIN homologacaoadjudica ON l202_licitacao = l21_codliclicita
                     LEFT JOIN itenshomologacao ON l203_homologaadjudicacao = l202_sequencial
                     AND l203_item = pc81_codprocitem
                     WHERE liclicitem.l21_codliclicita = liclicita.l20_codigo
                         AND pc24_pontuacao = 1
                         AND pc81_codprocitem NOT IN
                             (SELECT l203_item
                              FROM homologacaoadjudica
                              INNER JOIN itenshomologacao ON l203_homologaadjudicacao = l202_sequencial
                              WHERE l202_licitacao = liclicita.l20_codigo))";

//            $sWhereContratos .= " and (case when l20_naturezaobjeto in (1, 7) and l20_cadinicial in (1, 2) then false
//                                      else true end) ";

            /**
             * ValidaFornecedor:
             * Quando for passado por URL o parametro validafornecedor, só irá retornar licitações que possuem fornecedores habilitados.
             * @see ocorrência 2278
             */

            if ($validafornecedor == "1"){
                $whereHab = " and exists (select 1 from habilitacaoforn where l206_licitacao = liclicita.l20_codigo) ";
                $whereHab .= "AND l03_pctipocompratribunal NOT IN (100,101,102,103)";
            }

            if(!isset($pesquisa_chave)){

                if(isset($campos)==false){
                    if(file_exists("funcoes/db_func_liclicita.php")==true){
                        include("funcoes/db_func_liclicita.php");
                    }else{
                        $campos = "liclicita.*, liclicitasituacao.l11_sequencial";
                    }
                }

                $campos .= ', l08_descr as dl_Situação,l202_dataadjudicacao,l202_datahomologacao,l202_sequencial';
                if(isset($chave_l20_codigo) && (trim($chave_l20_codigo)!="") ){
                    $sql = $clliclicita->sql_queryContratosContass(null," " . $campos,"l20_codigo","l20_codigo = $chave_l20_codigo $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
                }else if(isset($chave_l20_numero) && (trim($chave_l20_numero)!="") ){
                    $sql = $clliclicita->sql_queryContratosContass(null," " .$campos,"l20_codigo","l20_numero=$chave_l20_numero $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
                }else if(isset($chave_l03_descr) && (trim($chave_l03_descr)!="") ){
                    $sql = $clliclicita->sql_queryContratosContass(null," " .$campos,"l20_codigo","l03_descr like '$chave_l03_descr%' $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
                }else if(isset($chave_l03_codigo) && (trim($chave_l03_codigo)!="") ){
                    $sql = $clliclicita->sql_queryContratosContass(null," " .$campos,"l20_codigo","l03_codigo=$chave_l03_codigo $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
                }else if(isset($chave_l20_edital) && (trim($chave_l20_edital)!="")){
                    $sql = $clliclicita->sql_queryContratosContass(null," " .$campos,"l20_codigo","l20_edital=$chave_l20_edital $and $dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
                }else{
                    $sql = $clliclicita->sql_queryContratosContass(""," " .$campos,"l20_codigo","$dbwhere $dbwhere_instit $sWhereContratos $whereHab",$situacao);
                }

                if (isset($param) && trim($param) != ""){
                    $dbwhere = " and (e55_sequen is null or (e55_sequen is not null and e54_anulad is not null))";
                    if(isset($chave_l20_codigo) && (trim($chave_l20_codigo)!="") ){
                        $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","l20_codigo = $chave_l20_codigo$dbwhere $whereHab");
                    }else if(isset($chave_l20_numero) && (trim($chave_l20_numero)!="") ){
                        $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","l20_numero=$chave_l20_numero$dbwhere $whereHab");
                    }else if(isset($chave_l03_descr) && (trim($chave_l03_descr)!="") ){
                        $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","l03_descr like '$chave_l03_descr%'$dbwhere $whereHab");
                    }else if(isset($chave_l03_codigo) && (trim($chave_l03_codigo)!="") ){
                        $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","l03_codigo=$chave_l03_codigo$dbwhere $whereHab");
                    } else {
                        $sql = $clliclicitem->sql_query_inf("",$campos,"l20_codigo","1=1$dbwhere $whereHab");
                    }
                }

                db_lovrot($sql.' desc ',15,"()","",$funcao_js);

            } else {

                if ($pesquisa_chave != null && $pesquisa_chave != "") {
                    if (isset($param) && trim($param) != ""){

                        $result = $clliclicitem->sql_record($clliclicitem->sql_query_inf($pesquisa_chave));

                        if ($clliclicitem->numrows!=0) {

                            db_fieldsmemory($result,0);
                            /**
                             *
                             * Adicionado o campo pc50_descr, removido o campo $l20_codigo e, coforme solicitado por Deborah@contass,
                             * inserido a numeração da modalidade. linhas: 187 e 197.
                             *
                             */

                            echo "<script>".$funcao_js."('$pc50_descr $l20_numero',false);</script>";
                        }else{
                            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
                        }
                    } else {
                        $dbwhere .= " pctipocompra.pc50_pctipocompratribunal not in (100, 101, 102, 103) AND ";
                        $result = $clliclicita->sql_record($clliclicita->sql_queryContratosContass(null,"*",null,"l20_codigo = $pesquisa_chave $and $dbwhere $dbwhere_instit"));
                        if($clliclicita->numrows != 0){

                            db_fieldsmemory($result,0);
                            echo "<script>".$funcao_js."('$pc50_descr $l20_numero',false);</script>";

                        } else {

                            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
                        }
                    }

                } else {
                    echo "<script>".$funcao_js."('',false);</script>";
                }
            }
            ?>
        </td>
    </tr>
</table>
</body>
</html>
<?
if(!isset($pesquisa_chave)){
    ?>
    <script>
    </script>
    <?
}
?>
