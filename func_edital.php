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

db_postmemory($_GET);
db_postmemory($_POST);
$oGet = db_utils::postMemory($_GET);
parse_str($_SERVER["QUERY_STRING"]);

$clliclicitem = new cl_liclicitem;
$clliclicita  = new cl_liclicita;

$clliclicita->rotulo->label("l20_codigo");
$clliclicita->rotulo->label("l20_numero");
$clliclicita->rotulo->label("l20_edital");
$clrotulo = new rotulocampo;
$clrotulo->label("l03_descr");
$iAnoSessao = db_getsession("DB_anousu");

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

        <td align="center" valign="top">
        <h2 style="margin-bottom: 10px;margin-top: 10px;color:red;">Editais pendentes de envio</h2>
            <?

            if(!isset($pesquisa_chave)){

                $sWhere = '';
                if($pendentes){
                  $sWhere = ' AND liclicita.l20_cadinicial = 1';
                }
                if($aguardando_envio){
					$sWhere = ' AND '.$sWhere;
					$sWhere .= " liclicita.l20_cadinicial in (1, 2) ";
				}

                if($dataenviosicom){
					$sWhere = $sWhere ? ' AND '.$sWhere : '';
                    $sWhere .= " AND liclicita.l20_cadinicial in (3, 4) ";
                }

                $sql = "
                    SELECT DISTINCT liclicita.l20_codigo,
                        liclicita.l20_edital,
                        liclicita.l20_nroedital,
                        liclicita.l20_anousu,
                        pctipocompra.pc50_descr,
                        liclicita.l20_numero,
                        pctipocompra.pc50_pctipocompratribunal,
                        liclicita.l20_objeto,
                        liclicita.l20_naturezaobjeto dl_Natureza_objeto,
                        (CASE 
                        WHEN l03_pctipocompratribunal in (48, 49, 50, 52, 53, 54) and liclicita.l20_dtpublic is not null 
                          THEN liclicita.l20_dtpublic
                        WHEN l03_pctipocompratribunal in (100, 101, 102, 103, 106) and liclicita.l20_datacria is not null 
                          THEN liclicita.l20_datacria
                        WHEN liclancedital.l47_dataenvio is not null
                          THEN liclancedital.l47_dataenvio
                        END) as dl_Data_Referencia,
                        l10_descr as status,
                        liclancedital.l47_dataenvio
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
                    INNER JOIN editalsituacao on editalsituacao.l10_sequencial = liclicita.l20_cadinicial 
                    WHERE l20_instit = ".db_getsession('DB_instit')."
                       AND (CASE WHEN l03_pctipocompratribunal IN (48, 49, 50, 52, 53, 54) 
                       AND liclicita.l20_dtpublic IS NOT NULL THEN EXTRACT(YEAR FROM liclicita.l20_dtpublic)
                       WHEN l03_pctipocompratribunal IN (100, 101, 102, 103, 106) 
                       AND liclicita.l20_datacria IS NOT NULL THEN EXTRACT(YEAR FROM liclicita.l20_datacria)
                       END) >= 2020 $sWhere AND (liclicita.l20_naturezaobjeto in (1, 7) OR (EXTRACT(YEAR FROM liclicita.l20_datacria) > 2023))
                       AND (select count(l21_codigo) from liclicitem where l21_codliclicita = liclicita.l20_codigo) >= 1
                    ORDER BY l20_codigo";

                $aRepassa = array();
                if(isset($notifica)){
                    db_lovrot($sql.' desc ',15,"","","", null,'NoMe', "", false);
                }else{
                    db_lovrot($sql.' desc ',15,"()","",$funcao_js, "",'NoMe', "", false);
                }
            }
            ?>
        </td>
    </tr>
</table>
</body>
<script>

    function verificacoesStatusLicitacoes(){

        let table = document.getElementById('TabDbLov');
        const indiceStatus = 10;
        const indiceLicitacao = 0;

        for(i = 2; i < table.rows.length; i++){
            if(table.rows[i].cells[indiceStatus].innerText.trim() == "AGUARDANDO ENVIO"){
                codigoLicitacao = table.rows[i].cells[indiceLicitacao].innerText;
                table.rows[i].cells[indiceStatus].firstChild.removeAttribute("href");
                table.rows[i].cells[indiceStatus].firstChild.setAttribute("onclick",`popUpDataEnvio(${codigoLicitacao})`);
                for(j = 0; j<=11; j++){
                    table.rows[i].cells[j].bgColor = "red";
                }
            }
        }

    }

    function popUpDataEnvio(codigoLicitacao){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_editais','db_iframe_dataenvio',`lic4_dataenvio.php?codigo=${codigoLicitacao}`,'Data de Envio - SICOM',true,10,10,300,200);
        CurrentWindow.corpo.iframe_editais.document.getElementById('Jandb_iframe_dataenvio').style.marginLeft = "500px"; 
        CurrentWindow.corpo.iframe_editais.document.getElementById('Jandb_iframe_dataenvio').style.marginTop = "20px"; 
    }

    verificacoesStatusLicitacoes();

</script>
</html>
<?
if(!isset($pesquisa_chave)){
    ?>
    <script>
    </script>
    <?
}
?>

