<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_licobraslicitacao_classe.php");
require_once("classes/db_db_usuarios_classe.php");

db_postmemory($_GET);
db_postmemory($_POST);
$oGet = db_utils::postMemory($_GET);

parse_str($_SERVER["QUERY_STRING"]);

$clliclicitem = new cl_liclicitem;
$clliclicita  = new cl_liclicita;
$cllicobraslicitacao = new cl_licobraslicitacao;
$cldbusuarios = new cl_db_usuarios();

$clliclicita->rotulo->label("l20_codigo");
$clliclicita->rotulo->label("l20_numero");
$clliclicita->rotulo->label("l20_edital");
$clrotulo = new rotulocampo;
$clrotulo->label("l03_descr");
$iAnoSessao = db_getsession("DB_anousu");

$sWhere          = "exists (select pc11_quant, pc23_valor
                              from solicitem
                                   inner join pcprocitem      on pc11_codigo = pc81_solicitem
                                   inner join liclicitem      on l21_codpcprocitem = pc81_codprocitem
                                   inner join pcorcamitemlic  on pc26_liclicitem   = l21_codigo
                                   inner join pcorcamitem     on pc26_orcamitem    = pc22_orcamitem
                                   inner join pcorcamjulg     on pc22_orcamitem    = pc24_orcamitem
                                                             and pc24_pontuacao    = 1
                                   inner join pcorcamval     on  pc23_orcamitem    = pc24_orcamitem
                                                            and  pc23_orcamforne   = pc24_orcamforne
                                   inner join liclicita licsaldo on l21_codliclicita = licsaldo.l20_codigo
                                   left join (select coalesce(sum(e55_quant),0) as quantidade,
                                                     coalesce(sum(e55_vltot),0) as valor,
                                                     e73_pcprocitem as item
                                                from empautitempcprocitem
                                                       inner join empautitem on e55_autori = e73_autori
                                                                            and e55_sequen = e73_sequen
                                                       inner join empautoriza on e55_autori = e54_autori
                                                 where e73_pcprocitem = liclicitem.l21_codpcprocitem
                                                   and e54_anulad is null
                                                   group by e73_pcprocitem ) as saldo_autorizacao on item = pc81_codprocitem
                            where (pc11_quant > coalesce(quantidade,0) or coalesce(pc23_valor,0) > valor)
                          and licsaldo.l20_codigo = liclicita.l20_codigo)
                          AND l20_codigo NOT IN
        (SELECT DISTINCT l20_codigo
         FROM liclicita
         INNER JOIN liclicitem ON l21_codliclicita = l20_codigo
         INNER JOIN acordoliclicitem ON ac24_liclicitem = l21_codigo
         INNER JOIN acordoitem ON ac20_sequencial = ac24_acordoitem
         INNER JOIN acordoposicao ON ac26_sequencial = ac20_acordoposicao
         ORDER BY l20_codigo)";

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
                        <td align="right">
                            <b>Ano:</b>
                        </td>
                        <td>
                            <?php
                            db_input("l20_anousu", 10, "int", true, "text", 1, null, null, null, null, 4);
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
            /* if (isset($tipo) && trim($tipo)!=""){
               $dbwhere   = "l08_altera is true and";
             }*/


            if (isset($situacao) && trim($situacao) != '' && $cldbusuarios->vefica_adm_user(db_getsession('DB_id_usuario')) != "1"){

                $dbwhere .= "l20_licsituacao in ($situacao) and ";
            }else{
				if($situacao == '10'){
					$dbwhere .= " l20_licsituacao = 10 AND ";
				}elseif($situacao){
					$dbwhere .= " l20_licsituacao = 1 AND ";
				}
            }

            if (!empty($oGet->validasaldo)){
                $dbwhere .= " $sWhere and ";
            }

            $sWhereModalidade = "";
            if (!empty($iModalidadeLicitacao)) {
                $sWhereModalidade = "and l20_codtipocom = {$iModalidadeLicitacao}";
            }

            $dbwhere_instit = "l20_instit = ".db_getsession("DB_instit"). "{$sWhereModalidade}";
            if (isset($lContratos) && $lContratos == 1 ) {
                $sWhereContratos .= " and ac24_sequencial is null ";
            }

            if ($validafornecedor == "1"){
                if($dbwhere != ""){
                    $dbwhere .= " and exists (select 1 from habilitacaoforn where l206_licitacao = liclicita.l20_codigo) and ";
                }else{
                    $dbwhere .= " exists (select 1 from habilitacaoforn where l206_licitacao = liclicita.l20_codigo) and ";
                }

            }

            if($obras == "true"){
              $dbwhere .= " l20_naturezaobjeto in (1,7) and";
            }

			if($credenciamento == 'true'){
//			    $dbwhere .= $dbwhere ? ' AND ' : ' ';
				$dbwhere .= " l03_pctipocompratribunal IN (100,101,102,103) AND ";
			}

            if($listacred == 'false'){
                $dbwhere .= " l03_pctipocompratribunal IN (100, 101) AND ";
            }

			if($ratificacao == 'true'){
				$dbwhere .= " l20_dtpubratificacao IS NOT NULL AND ";
            }elseif($ratificacao == 'false'){
				$dbwhere .= " l20_dtpubratificacao IS NULL AND ";
            }

			if($enviada == 'true'){
				$dbwhere .= " (case when l20_naturezaobjeto in (1, 7) and l20_cadinicial in (1, 2) then false
                                      else true end) AND ";
            }

			if(!isset($pesquisa_chave)){

                if(isset($campos)==false){

                    $campos = "distinct liclicita.l20_codigo,
					liclicita.l20_edital,
					l20_anousu,
					pctipocompra.pc50_pctipocompratribunal,
					pctipocompra.pc50_descr,
					liclicita.l20_numero,
					(CASE WHEN l20_nroedital IS NULL THEN '-'
						ELSE l20_nroedital::varchar
					END) as l20_nroedital,
					liclicita.l20_datacria as dl_Data_Abertura_Proc_Adm,
					liclicita.l20_dataaber as dl_Data_Emis_Alt_Edital_Convite,
					liclicita.l20_dtpublic as dl_Data_Publicação_DO,
					liclicita.l20_objeto";

                }

                if($dispensas){
					$campos = "distinct liclicita.l20_codigo,
					                    liclicita.l20_edital,
                                        l20_anousu,
                                        pctipocompra.pc50_descr,
                                        liclicita.l20_numero, ";

					if(db_getsession('DB_anousu') >= 2021){
					    $campos .= " case when l20_nroedital is not null then l20_nroedital::varchar
                                        else '-' END as l20_nroedital, ";
                    }

					if(!$ocultacampos) {

						$campos .= "    liclicita.l20_datacria as dl_Data_Abertura_Proc_Adm,
                                        liclicita.l20_dataaber as dl_Data_Emis_Alt_Edital_Convite,
                                        liclicita.l20_dtpublic as dl_Data_Publicação_DO,
                                        liclicita.l20_objeto";
					}else{
						$campos .= "    liclicita.l20_datacria as dl_Data_Abertura_Proc_Adm,
                                        liclicita.l20_objeto";
                    }
                }

//                $campos .= ", (select max(l11_sequencial) as l11_sequencial from liclicitasituacao where l11_liclicita = l20_codigo) as l11_sequencial ";
//                $campos .= ", l03_codcom as tipcom";
//                $campos .= ", l03_pctipocompratribunal as tipocomtribunal";
                $campos .= ', l08_descr as dl_Situação';
                if(isset($chave_l20_codigo) && (trim($chave_l20_codigo)!="") ){
                    $sql = $clliclicita->sql_queryContratos(null,$campos,"l20_codigo","$dbwhere  l20_codigo = $chave_l20_codigo and $dbwhere_instit");
                }else if(isset($chave_l20_numero) && (trim($chave_l20_numero)!="") ){
                    $sql = $clliclicita->sql_queryContratos(null,$campos,"l20_codigo","$dbwhere l20_numero=$chave_l20_numero  and $dbwhere_instit");
                }else if(isset($chave_l03_descr) && (trim($chave_l03_descr)!="") ){
                    $sql = $clliclicita->sql_queryContratos(null,$campos,"l20_codigo","$dbwhere l03_descr like '$chave_l03_descr%'  and $dbwhere_instit");
                }else if(isset($chave_l03_codigo) && (trim($chave_l03_codigo)!="") ){
                    $sql = $clliclicita->sql_queryContratos(null,$campos,"l20_codigo","$dbwhere l03_codigo=$chave_l03_codigo  and $dbwhere_instit");
                }else if(isset($chave_l20_edital) && (trim($chave_l20_edital)!="")){
                    $sql = $clliclicita->sql_queryContratos(null,$campos,"l20_codigo","$dbwhere l20_edital=$chave_l20_edital  and $dbwhere_instit");
                }else if(isset($l20_anousu) && (trim($l20_anousu)!="")){
                    $sql = $clliclicita->sql_queryContratos(null,$campos,"l20_codigo","$dbwhere $dbwhere_instit and l20_anousu = {$l20_anousu}");
                }else{
                    $sql = $clliclicita->sql_queryContratos("",$campos,"l20_codigo","$dbwhere $dbwhere_instit");
//          $sql = $clliclicita->sql_queryContratos("",$campos,"l20_codigo","$dbwhere $dbwhere_instit  and l20_anousu = {$iAnoSessao}");
                }

                if (isset($param) && trim($param) != ""){

                    $dbwhere = " and (e55_sequen is null or (e55_sequen is not null and e54_anulad is not null))";
                    if(isset($chave_l20_codigo) && (trim($chave_l20_codigo)!="") ){
                        $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","$dbwhere l20_codigo = $chave_l20_codigo");
                    }else if(isset($chave_l20_numero) && (trim($chave_l20_numero)!="") ){
                        $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","$dbwhere l20_numero=$chave_l20_numero");
                    }else if(isset($chave_l03_descr) && (trim($chave_l03_descr)!="") ){
                        $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","$dbwhere l03_descr like '$chave_l03_descr%'");
                    }else if(isset($chave_l03_codigo) && (trim($chave_l03_codigo)!="") ){
                        $sql = $clliclicitem->sql_query_inf(null,$campos,"l20_codigo","$dbwhere l03_codigo=$chave_l03_codigo");
                    } else {
                        $sql = $clliclicitem->sql_query_inf("",$campos,"l20_codigo","$dbwhere 1=1");
                    }
                }

                if (isset($criterioadjudicacao) && $criterioadjudicacao == true) {
                    $sql = "
          SELECT DISTINCT liclicita.l20_codigo,
          liclicita.l20_edital,
          l20_anousu,
          pctipocompra.pc50_descr,
          liclicita.l20_numero,
          liclicita.l20_datacria AS dl_Data_Abertura_Proc_Adm,
          liclicita.l20_dataaber AS dl_Data_Emis_Alt_Edital_Convite,
          liclicita.l20_dtpublic AS dl_Data_Publicação_DO,
          liclicita.l20_horaaber,
          liclicita.l20_local,
          liclicita.l20_objeto,
          (SELECT max(l11_sequencial) AS l11_sequencial
           FROM liclicitasituacao
           WHERE l11_liclicita = l20_codigo
          ) AS l11_sequencial,
          pctipocompra.pc50_codcom,
          cflicita.l03_tipo
            FROM liclicita
              INNER JOIN db_config             ON db_config.codigo            = liclicita.l20_instit
              INNER JOIN db_usuarios           ON db_usuarios.id_usuario      = liclicita.l20_id_usucria
              INNER JOIN cflicita              ON cflicita.l03_codigo         = liclicita.l20_codtipocom
              INNER JOIN liclocal              ON liclocal.l26_codigo         = liclicita.l20_liclocal
              INNER JOIN liccomissao           ON liccomissao.l30_codigo      = liclicita.l20_liccomissao
              INNER JOIN licsituacao           ON licsituacao.l08_sequencial  = liclicita.l20_licsituacao
              INNER JOIN cgm                   ON cgm.z01_numcgm              = db_config.numcgm
              INNER JOIN db_config AS dbconfig ON dbconfig.codigo             = cflicita.l03_instit
              INNER JOIN pctipocompra          ON pctipocompra.pc50_codcom    = cflicita.l03_codcom
              INNER JOIN bairro                ON bairro.j13_codi             = liclocal.l26_bairro
              INNER JOIN ruas                  ON ruas.j14_codigo             = liclocal.l26_lograd
              LEFT JOIN liclicitaproc          ON liclicitaproc.l34_liclicita = liclicita.l20_codigo
              LEFT JOIN protprocesso           ON protprocesso.p58_codproc    = liclicitaproc.l34_protprocesso
              LEFT JOIN liclicitem             ON liclicita.l20_codigo        = l21_codliclicita
              LEFT JOIN acordoliclicitem       ON liclicitem.l21_codigo       = acordoliclicitem.ac24_liclicitem
              LEFT JOIN pcprocitem             ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
              LEFT JOIN pcproc                 ON pcproc.pc80_codproc         = pcprocitem.pc81_codproc
                WHERE l20_instit = ".db_getsession("DB_instit")."
                  AND (pc80_criterioadjudicacao = 1 OR pc80_criterioadjudicacao = 2)
                    ORDER BY l20_codigo
          ";
                }

                if (isset($edital) && $edital == true) {
                    $sWhere = '';
                    if($aguardando_envio){
                      $sWhere = ' AND liclicita.l20_cadinicial = 1';
                    }

                    $sql = "
                      SELECT DISTINCT liclicita.l20_codigo,
                            liclicita.l20_edital,
                            (CASE WHEN l20_nroedital IS NULL THEN '-'
                                ELSE l20_nroedital::varchar
                            END) as l20_nroedital,
                            liclicita.l20_anousu,
                            pctipocompra.pc50_descr,
                            liclicita.l20_numero,
                            pctipocompra.pc50_pctipocompratribunal,
                            liclicita.l20_objeto,
                            liclicita.l20_naturezaobjeto dl_Natureza_objeto,
                            (CASE
                            WHEN pc50_pctipocompratribunal in (48, 49, 50, 52, 53, 54) and liclicita.l20_dtpublic is not null
                              THEN liclicita.l20_dtpublic
                            WHEN pc50_pctipocompratribunal in (100, 101, 102, 103, 106) and liclicita.l20_datacria is not null
                              THEN liclicita.l20_datacria
                            WHEN liclancedital.l47_dataenvio is not null
                              THEN liclancedital.l47_dataenvio
                            END) as dl_Data_Referencia,
                            (CASE WHEN liclicita.l20_cadinicial = 1 or liclicita.l20_cadinicial is null THEN 'PENDENTE'
                                WHEN liclicita.l20_cadinicial = 2 THEN 'AGUARDANDO ENVIO'
                            END) as status
                        FROM liclicita
                        INNER JOIN db_config ON db_config.codigo = liclicita.l20_instit
                        INNER JOIN db_usuarios ON db_usuarios.id_usuario = liclicita.l20_id_usucria
                        INNER JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
                        INNER JOIN liclocal ON liclocal.l26_codigo = liclicita.l20_liclocal
                        INNER JOIN liccomissao ON liccomissao.l30_codigo = liclicita.l20_liccomissao
                        INNER JOIN licsituacao ON licsituacao.l08_sequencial = liclicita.l20_licsituacao
                        INNER JOIN cgm ON cgm.z01_numcgm = db_config.numcgm
                        INNER JOIN db_config AS dbconfig ON dbconfig.codigo = cflicita.l03_instit
                        INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
                        INNER JOIN bairro ON bairro.j13_codi = liclocal.l26_bairro
                        INNER JOIN ruas ON ruas.j14_codigo = liclocal.l26_lograd
                        LEFT JOIN liclicitaproc ON liclicitaproc.l34_liclicita = liclicita.l20_codigo
                        LEFT JOIN protprocesso ON protprocesso.p58_codproc = liclicitaproc.l34_protprocesso
                        LEFT JOIN liclicitem ON liclicita.l20_codigo = l21_codliclicita
                        LEFT JOIN acordoliclicitem ON liclicitem.l21_codigo = acordoliclicitem.ac24_liclicitem
                        LEFT JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
                        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                        LEFT JOIN liclancedital on liclancedital.l47_liclicita = liclicita.l20_codigo
                        WHERE l20_instit = ".db_getsession('DB_instit')."
                           AND (CASE WHEN pc50_pctipocompratribunal IN (48, 49, 50, 52, 53, 54) 
                                     AND liclicita.l20_dtpublic IS NOT NULL THEN EXTRACT(YEAR FROM liclicita.l20_dtpublic)
                                     WHEN pc50_pctipocompratribunal IN (100, 101, 102, 103, 106) 
                                     AND liclicita.l20_datacria IS NOT NULL THEN EXTRACT(YEAR FROM liclicita.l20_datacria)
                                END) >= 2020 $sWhere AND liclicita.l20_naturezaobjeto = 1
                            AND (select count(l21_codigo) from liclicitem where l21_codliclicita = liclicita.l20_codigo) >= 1
                        ORDER BY l20_codigo
          ";
                }
                $aRepassa = array();
                db_lovrot($sql.' desc ',15,"()","",$funcao_js, null,'NoMe', $aRepassa, false);

            } else {


                if ($pesquisa_chave != null && $pesquisa_chave != "") {

                    if (isset($param) && trim($param) != ""){

                        $result = $clliclicitem->sql_record($clliclicitem->sql_query_inf($pesquisa_chave));

                        if ($clliclicitem->numrows!=0) {

                            db_fieldsmemory($result,0);
                            echo "<script>".$funcao_js."('$l20_objeto',false);</script>";
                        }else{
                            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
                        }
                    }

                    else if (isset($criterioadjudicacao) && $criterioadjudicacao == true) {
                        $sql = "
              SELECT DISTINCT liclicita.l20_codigo,
              liclicita.l20_edital,
              l20_anousu,
              pctipocompra.pc50_codcom,
              cflicita.l03_tipo
                FROM liclicita
                  INNER JOIN db_config             ON db_config.codigo            = liclicita.l20_instit
                  INNER JOIN db_usuarios           ON db_usuarios.id_usuario      = liclicita.l20_id_usucria
                  INNER JOIN cflicita              ON cflicita.l03_codigo         = liclicita.l20_codtipocom
                  INNER JOIN liclocal              ON liclocal.l26_codigo         = liclicita.l20_liclocal
                  INNER JOIN liccomissao           ON liccomissao.l30_codigo      = liclicita.l20_liccomissao
                  INNER JOIN licsituacao           ON licsituacao.l08_sequencial  = liclicita.l20_licsituacao
                  INNER JOIN cgm                   ON cgm.z01_numcgm              = db_config.numcgm
                  INNER JOIN db_config AS dbconfig ON dbconfig.codigo             = cflicita.l03_instit
                  INNER JOIN pctipocompra          ON pctipocompra.pc50_codcom    = cflicita.l03_codcom
                  INNER JOIN bairro                ON bairro.j13_codi             = liclocal.l26_bairro
                  INNER JOIN ruas                  ON ruas.j14_codigo             = liclocal.l26_lograd
                  LEFT JOIN liclicitaproc          ON liclicitaproc.l34_liclicita = liclicita.l20_codigo
                  LEFT JOIN protprocesso           ON protprocesso.p58_codproc    = liclicitaproc.l34_protprocesso
                  LEFT JOIN liclicitem             ON liclicita.l20_codigo        = l21_codliclicita
                  LEFT JOIN acordoliclicitem       ON liclicitem.l21_codigo       = acordoliclicitem.ac24_liclicitem
                  LEFT JOIN pcprocitem             ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
                  LEFT JOIN pcproc                 ON pcproc.pc80_codproc         = pcprocitem.pc81_codproc
                    WHERE l20_instit = ".db_getsession("DB_instit")."
                      AND pc80_criterioadjudicacao = 1
                      AND liclicita.l20_codigo = {$pesquisa_chave}
                        ORDER BY l20_codigo
              ";
                        $result = $clliclicita->sql_record($sql);
                        if($clliclicita->numrows != 0){

                            db_fieldsmemory($result,0);
                            echo "<script>".$funcao_js."('$l20_edital','$l20_anousu','$l03_codcom',false);</script>";
                        }
                    } else if($autoriza == true){
                        $sql = "
              SELECT DISTINCT liclicita.l20_numero,
              liclicita.l20_edital,
              liclicita.l20_objeto,
              liclicita.l20_anousu,
              cflicita.l03_codcom,
              cflicita.l03_tipo,
              cflicita.l03_pctipocompratribunal
                FROM liclicita
                  INNER JOIN db_config             ON db_config.codigo            = liclicita.l20_instit
                  INNER JOIN db_usuarios           ON db_usuarios.id_usuario      = liclicita.l20_id_usucria
                  INNER JOIN cflicita              ON cflicita.l03_codigo         = liclicita.l20_codtipocom
                  INNER JOIN liclocal              ON liclocal.l26_codigo         = liclicita.l20_liclocal
                  INNER JOIN liccomissao           ON liccomissao.l30_codigo      = liclicita.l20_liccomissao
                  INNER JOIN licsituacao           ON licsituacao.l08_sequencial  = liclicita.l20_licsituacao
                  INNER JOIN cgm                   ON cgm.z01_numcgm              = db_config.numcgm
                  INNER JOIN db_config AS dbconfig ON dbconfig.codigo             = cflicita.l03_instit
                  INNER JOIN pctipocompra          ON pctipocompra.pc50_codcom    = cflicita.l03_codcom
                  INNER JOIN bairro                ON bairro.j13_codi             = liclocal.l26_bairro
                  INNER JOIN ruas                  ON ruas.j14_codigo             = liclocal.l26_lograd
                  LEFT JOIN liclicitaproc          ON liclicitaproc.l34_liclicita = liclicita.l20_codigo
                  LEFT JOIN protprocesso           ON protprocesso.p58_codproc    = liclicitaproc.l34_protprocesso
                  LEFT JOIN liclicitem             ON liclicita.l20_codigo        = l21_codliclicita
                  LEFT JOIN acordoliclicitem       ON liclicitem.l21_codigo       = acordoliclicitem.ac24_liclicitem
                  LEFT JOIN pcprocitem             ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
                  LEFT JOIN pcproc                 ON pcproc.pc80_codproc         = pcprocitem.pc81_codproc
                    WHERE l20_instit = ".db_getsession("DB_instit")."
                      AND liclicita.l20_codigo = {$pesquisa_chave}
              ";
                        $result = $clliclicita->sql_record($sql);

                        if($clliclicita->numrows != 0){
                            db_fieldsmemory($result,0);
                            echo "<script>".$funcao_js."('$l20_objeto','$l20_numero','$l20_edital','$l20_anousu','$l03_codcom','$l03_pctipocompratribunal',false);</script>";
                        }
                    }
                    else {
                        if($obras == "true"){
                          if($licitacaosistema == "1"){
                              $result = $clliclicita->sql_record($clliclicita->sql_query(null,"*",null,"$dbwhere l20_codigo = $pesquisa_chave $and $dbwhere_instit "));

                              if($clliclicita->numrows != 0){
                                  db_fieldsmemory($result,0);
                                  echo "<script>".$funcao_js."($l20_numero','$l20_numero','$l03_descr',false);</script>";
                              } else {
                                  echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado','Chave(".$pesquisa_chave.") não Encontrado','Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
                              }
                          }else{
                              $result = $cllicobraslicitacao->sql_record($cllicobraslicitacao->sql_query($pesquisa_chave));
                              if($cllicobraslicitacao->numrows!=0){
                                  db_fieldsmemory($result,0);
                                  echo "<script>".$funcao_js."('$l44_descricao','$obr07_objeto','$l20_numero',$false);</script>";
                              }else{
                                  echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
                              }
                          }
                        }else{
                          $result = $clliclicita->sql_record($clliclicita->sql_queryContratos(null,"*",null,"$dbwhere l20_codigo = $pesquisa_chave $and $dbwhere_instit "));

                          if($clliclicita->numrows != 0){
                            db_fieldsmemory($result,0);
                            if($tipoproc == "true"){
                              echo "<script>".$funcao_js."('$l20_objeto','$l03_pctipocompratribunal',false);</script>";
                            }else{
                              echo "<script>".$funcao_js."('$l20_objeto',false);</script>";
                            }
                          } else {
                            echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
                          }
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
