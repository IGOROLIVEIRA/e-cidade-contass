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
    <?php if(!$oGet->pendentes && !$oGet->module_licitacao):?>
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
    <?php endif;?>
    <tr>
        <td align="center" valign="top">
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
                        l10_descr as status
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
                       END) >= 2020 $sWhere AND liclicita.l20_naturezaobjeto in (1, 7)
                       AND (select count(l21_codigo) from liclicitem where l21_codliclicita = liclicita.l20_codigo) >= 1
                    ORDER BY l20_codigo";

                $aRepassa = array();
                db_lovrot($sql.' desc ',15,"()","",$funcao_js, null,'NoMe', $aRepassa, false);
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
<script>
    let aTr = document.querySelectorAll('td.DBLovrotRegistrosRetornados');
    let pendentes = "<?=$oGet->pendentes?>";
    let dataenvio = "<?=$oGet->dataenviosicom?>";
    let module_licitacao = ("<?=$oGet->module_licitacao?>" == 'true');

    for(let count=0;count<aTr.length;count++){

        let idCampo = parseInt(aTr[count].id.replace('I', ''));
        let format = idCampo.toString().includes('01') ? idCampo.toString().replace('01', '1') : idCampo;
        let idCampoInicial = format == 10 ? '00' : idCampo == 1010 ? 100 : parseInt(format.toString().substr(0, format.toString().length - 1)) - 1;

        if(aTr[count].cellIndex == 10){

            let status = aTr[count].innerText.replace(/\./g, '').trim();

            if( status == 'AGUARDANDO ENVIO'){

                if(idCampoInicial == '00'){
                    for(let count = 0; count<=10; count++){
                        let campo = document.getElementById(`I0${count}`);
                        campo.bgColor = 'red';

                        /*Verifica se não está na tela inicial do módulo Licitação. Caso esteja, cancela o evento de click*/
                        if(!module_licitacao){
                                /*
                                * Adiciona o evento de click a todas as células anteriores à célula que contenha o status da licitação como 'AGUARDANDO ENVIO'
                                * */

                            campo.onclick = (e) => {

                                // 1209 -> posição onde começa a última célula do registro contendo o status da licitação.
                                if(e.clientX < 1209){
                                    parent.js_buscaDadosLicitacao(codigoLicitacao);
                                    parent.db_iframe_liclicita.hide();
                                }
                            }
                        }else{
                            campo.style.pointerEvents = 'none';
                        }
                    }
                }else{
                    for(let count = 0; count<10; count++){
                        let campo = document.getElementById(`I${idCampoInicial+count}`);

                        if(idCampo == 1110 && count == 0){
                            document.querySelector('tr:nth-child(14)').firstChild.bgColor = 'red';
                        }

                        campo.bgColor = 'red';

                        /*Verifica se não está na tela inicial do módulo Licitação. Caso esteja, cancela o evento de click*/
                        if(!module_licitacao){
                                /*
                                * Adiciona o evento para retornar os dados a todas as células anteriores à célula que contenha o status da licitação como 'AGUARDANDO ENVIO'
                                * */
                            campo.onclick = (e) => {
                                // 1209 -> posição onde começa a última célula do registro contendo o status da licitação.
                                if(e.clientX < 1209){
                                    parent.js_buscaDadosLicitacao(codigoLicitacao);
                                    parent.db_iframe_liclicita.hide();
                                }
                            }
                        }else{
                            campo.style.pointerEvents = 'none';
                        }
                    }
                }

                let codigoLicitacao = document.getElementById(`I${idCampoInicial}`).innerText.trim();
                document.getElementById(`${aTr[count].id}`).bgColor = 'red';

                if(!module_licitacao){
                    document.getElementById(`${aTr[count].id}`).onclick = (e) => {
                        if(status == 'AGUARDANDO ENVIO'){
                            js_OpenJanelaIframe('','db_iframe_dataenvio',`lic4_dataenvio.php?codigo=${codigoLicitacao}`,'Data de Envio - SICOM',true, null, 550, 250, 180);
                        }
                    }
                }else{
                    document.getElementById(`${aTr[count].id}`).style.pointerEvents = 'none';
                }
            }else{

                /* Trecho que exibe as licitações pendentes no módulo Licitação */
                if(pendentes || module_licitacao){

                    if(idCampoInicial == '00'){

                        for(let count = 0; count<=10; count++){
                            let campo = document.getElementById(`I0${count}`);
                            campo.style.pointerEvents = 'none';
                        }

                    }else {

                        for (let count = 0; count <= 10; count++) {

                            let campo = '';
                            if(count < 10){
                                campo = `I${idCampoInicial + count}`;
                            }else{
                                campo = `I${idCampoInicial.toString().substr(0,1)}${count}`;
                            }
                            document.getElementById(`${campo}`).style.pointerEvents = 'none';
                        }
                    }
                }
            }
        }
    }

    function retornoEnvio(){
        db_iframe_dataenvio.hide();
        parent.retornoEnvio();
    }

</script>
