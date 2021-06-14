<?php
/**
 * Created by PhpStorm.
 * User: contass
 * Date: 03/06/21
 * Time: 08:28
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);

$clrhpesrescisao = new cl_rhpesrescisao;
$rotulocampo = new rotulocampo;

$rotulocampo->label("rh01_regist");
$rotulocampo->label("rh02_seqpes");
$rotulocampo->label("z01_nome");

if(empty($rh01_regist)){

    $datai_dia = '';
    $datai_mes = '';
    $datai_ano = '';
}

if (isset($rh01_regist) && !empty($rh01_regist)) {

    $ano             = db_anofolha();
    $mes             = db_mesfolha();
    $rsRhpesrescisao = $clrhpesrescisao->sql_record( $clrhpesrescisao->sql_query_ngeraferias( null,
        'rh05_recis',
        null,
        "rh02_regist = $rh01_regist and rh02_anousu = $ano and rh02_mesusu = $mes" ));

    if ($rsRhpesrescisao && $clrhpesrescisao->numrows > 0) {

        $oRecisao = db_utils::fieldsMemory($rsRhpesrescisao, 0);

        $datai_dia = date('d', strtotime($oRecisao->rh05_recis));
        $datai_mes = date('m', strtotime($oRecisao->rh05_recis));
        $datai_ano = date('Y', strtotime($oRecisao->rh05_recis));
    } else {

        $datai_dia = date('d', db_getsession('DB_datausu'));
        $datai_mes = date('m', db_getsession('DB_datausu'));
        $datai_ano = date('Y', db_getsession('DB_datausu'));
    }

}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        #datai{
            width: 78px;
        }
    </style>
</head>
<body class="body-default">
<div class="container">
    <form name="form1" method="post" action="" >
        <fieldset>
            <legend>Certidão de Tempo de Serviço</legend>

            <table>
                <tr>
                    <td nowrap title="<?php echo $Trh01_regist; ?>">
                        <label class="bold" for="rh01_regist" id="lbl_rh01_regist">
                            <?php db_ancora($Srh01_regist . ':', "js_pesquisarh01_regist(true);", 1); ?>
                        </label>
                    </td>
                    <td>
                        <?php
                        db_input('rh01_regist', 8, $Irh01_regist, true, 'text', 1, " onchange='js_pesquisarh01_regist(false);'");
                        db_input('z01_nome', 30, $Iz01_nome, true, 'text', 3, '');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?
                        db_ancora("NumCgm","js_pesquisarh01_numcgm(true);",$db_opcao);
                        ?>
                    </td>
                    <td nowrap>
                        <?
                        db_input('rh01_numcgm',8,"",true,'text',$db_opcao,"onchange='js_pesquisarh01_numcgm(false);' tabIndex='1'")
                        ?>
                        <?
                        db_input('z01_nomecgm',30,"",true,'text',3,'')
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="Data Certidão">
                        <label class="bold" for="datai" id="lbl_datai">Data de Certidão:</label>
                    </td>
                    <td>
                        <?php
                        db_inputdata("datai", @$datai_dia, @$datai_mes, @$datai_ano, true, 'text', 1);
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="Número Certidão">
                        <label class="bold" for="numcert" id="lbl_numcert">Número de Certidão:</label>
                    </td>
                    <td>
                        <?php
                        db_input('numcert', 8, 1, true, 'text', 1, "");
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="Dias de Falta">
                        <label class="bold" for="numcert" id="lbl_numcert">Dias de Falta:</label>
                    </td>
                    <td>
                        <?php
                        db_input('diasfalta', 8, 1, true, 'text', 1, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Emissor">
                        <label class="bold" for="emissor" id="lbl_emissor">
                            <?php
                            db_ancora('Emissor:', "js_pesquisaemissor(true);", 1);
                            ?>
                        </label>
                    </td>
                    <td>
                        <?php
                        db_input('emissor', 8,'' , true, 'text', 1, " onchange='js_pesquisaemissor(false);'");
                        db_input('z01_nomeemissor', 30,'' , true, 'text', 3, '');
                        ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" >
                        <fieldset>
                            <Legend>
                                <b>Selecione os Vinculos</b>
                            </Legend>
                            <?
                            db_input("valor", 3, 0, true, 'hidden', 3);
                            db_input("colunas_sselecionados", 3, 0, true, 'hidden', 3);
                            db_input("colunas_nselecionados", 3, 0, true, 'hidden', 3);
                            $arr_colunas_inicial = Array(
                                "2" => "2 - Afastado sem remuneração",
                                "3" => "3 - Afastado acidente de trabalho +15 dias",
                                "4" => "4 - Afastado serviço militar",
                                "5" => "5 - Afastado licença gestante",
                                "6" => "6 - Afastado doença +15 dias",
                                "7" => "7 - Licença sem vencimento, cessão sem ônus",
                                "8" => "8 - Afastado doença +30 dias",
                                "22" => "9 - Licença por Motivo de Afastamento do Cônjuge"
                            );
                            db_multiploselect("rh30_codreg","rh30_descr", "nselecionados", "sselecionados", $arr_colunas_inicial, $arr_colunas_final, 6, 250, "", "", true, "js_complementar('c');");
                            ?>
                        </fieldset>
                    </td>
                </tr>
            </table>
        </fieldset>

        <input name="relatorio" id="relatorio" type="button" value="Processar" onclick="js_emite();" >

    </form>
</div>

<?php
db_menu( db_getsession("DB_id_usuario"),
    db_getsession("DB_modulo"),
    db_getsession("DB_anousu"),
    db_getsession("DB_instit") );
?>
</body>
<script>
    var sMensagens = "recursoshumanos.rh.rec2_certcomprobatorio.";

    function js_emite() {

        selecionados = "";
        virgula_ssel = "";
        for(var i=0; i<document.form1.sselecionados.length; i++){
            selecionados+= virgula_ssel + document.form1.sselecionados.options[i].value;
            virgula_ssel = ",";
        }

        qry  = "?regist="+ document.form1.rh01_regist.value;
        qry += "&datacert=" + document.form1.datai_ano.value+'-'+document.form1.datai_mes.value+'-'+document.form1.datai_dia.value;
        qry += "&numcert=" + document.form1.numcert.value;
        qry += "&emissor=" + document.form1.emissor.value;
        qry += "&diasfalta=" + document.form1.diasfalta.value;
        qry += "&numcgm=" + document.form1.rh01_numcgm.value;
        qry += "&vinculoselecionados=" + selecionados;
        jan = window.open( 'pes2_gerarcertidaotempo002.php' + qry,
            '',
            'width=' + (screen.availWidth-5) + ',height='+(screen.availHeight-40) + ',scrollbars=1,location=0 ' );
        jan.moveTo(0,0);

    }

    function js_pesquisaemissor(mostra){

        if (mostra == true) {
            js_OpenJanelaIframe( 'top.corpo',
                'db_iframe_rhpessoal',
                'func_rhpessoal.php?funcao_js=parent.js_mostraemissor1|rh01_numcgm|z01_nome&instit=<?=(db_getsession("DB_instit"))?>',
                'Pesquisa',
                true );
        } else {

            js_OpenJanelaIframe( 'top.corpo',
                'db_iframe_rhpessoal',
                'func_rhpessoal.php?pesquisa_chave=' + document.form1.emissor.value
                + '&funcao_js=parent.js_mostraemissor&instit=<?=(db_getsession("DB_instit"))?>',
                'Pesquisa',
                false );
        }
    }

    function js_mostraemissor(chave, erro) {

        document.form1.z01_nomeemissor.value = chave;

        if (erro == true) {
            document.form1.emissor.focus();
            document.form1.emissor.value = '';
        }
    }

    function js_mostraemissor1(chave1, chave2) {
        document.form1.emissor.value         = chave1;
        document.form1.z01_nomeemissor.value = chave2;
        db_iframe_rhpessoal.hide();
    }

    function js_pesquisarh01_regist(mostra) {

        if (mostra == true) {
            js_OpenJanelaIframe( 'top.corpo',
                'db_iframe_rhpessoal',
                'func_rhpessoal.php?funcao_js=parent.js_mostrapessoal1|rh01_regist|z01_nome&instit=<?=(db_getsession("DB_instit"))?>',
                'Pesquisa',
                true );
        } else {

            if (document.form1.rh01_regist.value != '') {
                js_OpenJanelaIframe( 'top.corpo',
                    'db_iframe_rhpessoal',
                    'func_rhpessoal.php?testarescisao=true&pesquisa_chave=' + document.form1.rh01_regist.value
                    + '&funcao_js=parent.js_mostrapessoal&instit=<?=(db_getsession("DB_instit"))?>',
                    'Pesquisa',
                    false );
            } else {
                document.form1.z01_nome.value = '';
                document.form1.submit();
            }
        }
    }

    function js_mostrapessoal(chave, erro) {

        document.form1.z01_nome.value = chave;
        document.form1.rh01_numcgm.value = '';
        document.form1.z01_nomecgm.value = '';
        if (erro == true) {

            document.form1.rh01_regist.focus();
            document.form1.rh01_regist.value = '';
        } else {
            document.form1.submit();
        }
    }

    function js_mostrapessoal1(chave1, chave3) {

        document.form1.rh01_regist.value = chave1;
        document.form1.z01_nome.value    = chave3;
        document.form1.rh01_numcgm.value = '';
        document.form1.z01_nomecgm.value = '';

        db_iframe_rhpessoal.hide();
        document.form1.submit();
    }

    function js_pesquisarh01_numcgm(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo',
                'iframe_rhpessoal',
                'func_nome.php?campos=z01_numcgm,z01_nome&funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0');
        }else{
            if(document.form1.rh01_numcgm.value != ''){
                js_OpenJanelaIframe('top.corpo',
                    'iframe_rhpessoal',
                    'func_nome.php?pesquisa_chave='+document.form1.rh01_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'0');
            }else{
                document.form1.z01_nome.value = '';
            }
        }
    }

    function js_mostracgm(error,chave1,chave2,chave3){
        document.form1.z01_nomecgm.value = chave1;

        document.form1.rh01_regist.value = '';
        document.form1.z01_nome.value    = '';
        document.form1.datai.value    = '';
    }

    function js_mostracgm1(chave1,chave2,error){

        document.form1.rh01_numcgm.value = chave1;
        document.form1.z01_nomecgm.value = chave2;

        document.form1.rh01_regist.value = '';
        document.form1.z01_nome.value    = '';
        document.form1.datai.value    = '';
        iframe_rhpessoal.hide();
    }

    function js_complementar(opcao){
        selecionados = "";
        virgula_ssel = "";

        for(var i=0; i<document.form1.sselecionados.length; i++){
            selecionados+= virgula_ssel + document.form1.sselecionados.options[i].value;
            virgula_ssel = ",";
        }
        document.form1.colunas_sselecionados.value = selecionados;

        selecionados = "";
        virgula_ssel = "";
        for(var i=0; i<document.form1.nselecionados.length; i++){
            selecionados+= virgula_ssel + document.form1.nselecionados.options[i].value;
            virgula_ssel = ",";
        }
        document.form1.colunas_nselecionados.value = selecionados;

    }
</script>
</html>