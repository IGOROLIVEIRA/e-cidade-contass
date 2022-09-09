<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

db_postmemory($HTTP_SERVER_VARS);

$alterando   = isset($alterando);
$db_botao    = 1;
$db_opcao    = 1;
$pesq        = true;
$clissbase  = new cl_issbase;
$clissisen  = new cl_issisen;
$rotulocampo = new rotulocampo;

$clissbase->rotulo->label();
$clissisen->rotulo->label();

$rotulocampo->label("z01_nome");
$rotulocampo->label("q147_descr");
$rotulocampo->label("j34_area");
$rotulocampo->label("p58_codproc");
$rotulocampo->label("p58_requer");

$q147_tipoisen = 0;
$result    = $clissbase->sql_record($clissbase->sql_query("","cgm.z01_nome as z01_nomematri","","q02_inscr=$q148_inscr"));

/**
 * Buscamos o tipo de isençao na alteraçao para que sejam realizadas as validaçoes quando a isençao for imune ou nao incidente
 */

if ( $clissbase->numrows == 0 ) {
    db_redireciona("iss4_issisen001.php?invalido=true");
}else{
    @db_fieldsmemory($result,0);
}

if ($alterando == 1 && !empty($q148_codigo) ) {

    if( $q148_codigo != "nova" ){

        $resultTipis = $clissbase->sql_record($clissisen->sql_query("", "q147_tipoisen", "", "q148_codigo = $q148_codigo"));
        $q147_tipoisen = db_utils::fieldsMemory($resultTipis,0)->q147_tipoisen;
        $q147_taxas = db_utils::fieldsMemory($resultTipis,0)->q147_taxas;
    }
}

$data = date("Y-m-d",db_getsession("DB_datausu"));
$dat  = preg_split("-",$data);

if(isset($incluir) || isset($alterar)){

    $clissisen->q148_dtinc     = $data;
    $clissisen->q148_dtinc_dia = $dat[2];
    $clissisen->q148_dtinc_mes = $dat[1];
}

if (isset($q148_codigo) && $q148_codigo=="nova") {

    $result = $clissbase->sql_record($clissbase->sql_query($q148_inscr,"z01_nome",""));
    @db_fieldsmemory($result,0);
    $q148_codigo = "";
} else if(isset($incluir)) {

    $q148_dtinc_ano = $clissisen->q148_dtinc_ano=$dat[2];

    if (empty($q148_dtfim)) {

        $q148_dtfim_dia = $q148_dtini_dia;
        $q148_dtfim_mes = $q148_dtini_mes;
        $q148_dtfim_ano = $q148_dtini_ano + 50;

        $clissisen->q148_dtfim_dia = $q148_dtfim_dia;
        $clissisen->q148_dtfim_mes = $q148_dtfim_mes;
        $clissisen->q148_dtfim_ano = $q148_dtfim_ano;
    }

    db_inicio_transacao();
    $trans_erro = false;
    $clissisen->incluir($q148_codigo);
    $erro_msg=$clissisen->erro_msg;

    if($clissisen->erro_status=="0"){
        $trans_erro = true;
    }

    db_fim_transacao($trans_erro);
}else if(isset($excluir)){

    db_inicio_transacao();
    $clissisen->excluir($q148_codigo);
    db_fim_transacao();
}else if(isset($alterar)){

    if (empty($q148_dtfim)) {

        $q148_dtfim_dia = $q148_dtini_dia;
        $q148_dtfim_mes = $q148_dtini_mes;
        $q148_dtfim_ano = $q148_dtini_ano + 50;

        $clissisen->q148_dtfim_dia = $q148_dtfim_dia;
        $clissisen->q148_dtfim_mes = $q148_dtfim_mes;
        $clissisen->q148_dtfim_ano = $q148_dtfim_ano;
    }

    db_inicio_transacao();

    $clissisen->alterar($q148_codigo);

    db_fim_transacao();

}else if(isset($q148_inscr) && isset($q148_codigo)){

    $sql    = $clissisen->sql_query("$q148_codigo","issisen.*,q147_descr,j56_receit,j56_perc","","");
    $result = $clissisen->sql_record($sql);
    @db_fieldsmemory($result,0);
    $db_opcao    = "2";
    $recoloca    = "ok";
    $codigo      = $q148_codigo;
}
?>
<html lang="">
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/numbers.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">

        <?php if(isset($q148_inscr)){ ?>

        function js_trocaid(valor){

            if(valor!==""){
                location.href = "iss4_issisen002.php?<?=$alterando?'':'alterando=true&'?>q148_inscr=<?=$q148_inscr?>&q148_codigo="+valor;
            }
        }
        <?php } ?>

        function js_carreg(){

            document.form1.q148_tipo.focus();
            js_trocacordeselect();
        }
    </script>
</head>
<body class="body-default" onLoad="js_carreg();">
<div class="container">
    <form name="form1" method="post" action="">
        <input name="dadostaxa" type="hidden" value="">
        <input name="q147_tipoisen" type="hidden" value="<?php echo $q147_tipoisen ?>">

        <fieldset style="width:520px;">
            <legend>Dados de Isenção</legend>
            <table border="0" align="center">
                <tr>
                    <td nowrap title="<?= @$Tq148_inscr ?>">
                        <?php
                        if ($alterando) {
                            echo @$Lq148_inscr;
                        } else {
                            ?>
                            <a href='' onclick='js_mostrabic_matricula();return false;'><?= @$Lq148_inscr ?></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php
                        db_input('q148_inscr', 10, $Iq148_inscr, true, 'text', 3, " onchange='js_pesquisaq148_inscr(false);'");
                        db_input('z01_nome', 40, $Iz01_nome, true, 'text', 3, '', 'z01_nomematri');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tq148_codigo ?>">
                        <?= @$Lq148_codigo ?>
                    </td>
                    <td>
                        <?php
                        db_input('q148_codigo', 4, "", true, 'text', 3, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tq148_tipo ?>">
                        <?php
                        db_ancora(@$Lq148_tipo, "js_pesquisaq148_tipo(true);document.form1.q147_descr.value='';", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?php
                        db_input('q148_tipo', 4, $Iq148_tipo, true, 'text', $db_opcao, "onchange='js_pesquisaq148_tipo(false);js_limpanome();'");
                        db_input('q147_descr', 40, $Iq147_descr, true, 'text', 3, '');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tq148_dtini ?>">
                        <?= @$Lq148_dtini ?>
                    </td>
                    <td>
                        <?php
                        db_inputdata('q148_dtini', @$q148_dtini_dia, @$q148_dtini_mes, @$q148_dtini_ano, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tq148_dtfim ?>">
                        <?= @$Lq148_dtfim ?>
                    </td>
                    <td>
                        <?php
                        db_inputdata('q148_dtfim', @$q148_dtfim_dia, @$q148_dtfim_mes, @$q148_dtfim_ano, true, 'text', $db_opcao)
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tq148_perc ?>">
                        <?= @$Lq148_perc ?>
                    </td>
                    <td>
                        <?php
                        db_input('q148_perc', 10, $Iq148_perc, true, 'text', $db_opcao, "onChange='js_validapercentual(this);'")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Área total do lote">
                        <strong>Área do lote:</strong>
                    </td>
                    <td colspan="2">
                        <?php
                        $sql_areatot = "select j34_area from issbase inner join lote on j34_idbql = j01_idbql where q02_inscr = $q148_inscr;";
                        $result_areatot = $clissbase->sql_record($sql_areatot);

                        if ($clissbase->numrows > 0) {
                            db_fieldsmemory($result_areatot, 0);
                        }
                        db_input('j34_area', 10, $Ij34_area, true, 'text', 3, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Área a isentar">
                        <strong>Área isenta:</strong>
                    </td>
                    <td>
                        <?php
                        db_input('q148_arealo', 10, $Iq148_arealo, true, 'text', $db_opcao, "onchange = 'js_preenchedif(this.name,this.value,document.form1.j34_area.value);'");
                        ?>
                        <strong>Diferença:</strong>
                        <?php
                        db_input('q148_dif', 10, $Iq148_arealo, true, 'text', 3, "");

                        if (!empty($j34_area) && !empty($q148_arealo)) {

                            $q148_dif = $j34_area - $q148_arealo;
                            echo "<script>document.form1.q148_dif.value = $q148_dif;</script>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
                        $q148_idusu = db_getsession("DB_id_usuario");
                        db_input('q148_idusu', 4, $Iq148_idusu, true, 'hidden', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tp58_codproc ?>">
                        <?php
                        db_ancora(@$Lp58_codproc, "js_pesquisap58_codproc(true);", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?php
                        db_input('p58_codproc', 10, $Ip58_codproc, true, 'text', $db_opcao, " onchange='js_pesquisap58_codproc(false);'")
                        ?>
                        <?php
                        db_input('p58_requer', 40, $Ip58_requer, true, 'text', 3, '')
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Tq148_hist ?>">
                        <?= @$Lq148_hist ?>
                    </td>
                    <td>
                        <?php
                        db_textarea('q148_hist', 5, 52, $Iq148_hist, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td align="left" width="40%" valign="top">
                        <table border=0>
                            <?php
                            if (@$q148_tipo == "" || isset($incluir)) {
                                $q148_codigo = "";
                            }
                            ?>
                            <tr>
                                <?php
                                if (isset($q148_inscr)) {

                                    if (!isset($excluir)) {

                                        $result = $clissisen->sql_record($clissisen->sql_query_file("", "q148_codigo as codigo", "", "q148_inscr=$q148_inscr"));
                                        if ($clissisen->numrows > 0) {
                                            db_fieldsmemory($result, 0);
                                        }
                                    }

                                    $num = $clissisen->numrows;

                                    if ($num != 0) {
                                        ?>
                                        <td>
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr align="center">
                                                    <td><strong>Isenções já Cadastradas</strong></td>
                                                </tr>
                                                <tr>
                                                    <td align="center">
                                                        <?php
                                                        echo "<select name='selcod' onchange='js_trocaid(this.value)' style='width:520px;' size='" . ($num > 4 ? 5 : ($num + 1)) . "'>";
                                                        echo "<option value='nova' " . (!isset($q148_inscr) ? "selected" : "") . ">Nova</option>";
                                                        if (isset($recoloca) && $recoloca != "") {
                                                            $idcod = $q148_codigo;
                                                        } else {
                                                            $idcod = "";
                                                        }

                                                        for ($i = 0; $i < $num; $i++) {

                                                            db_fieldsmemory($result, $i);
                                                            if ($codigo != $idcod) {
                                                                echo "<option  value='" . $codigo . "' " . ($codigo == $idcod ? "selected" : "") . ">" . $codigo . "</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <?php
                                    }
                                }
                                ?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </fieldset>

        <input name="incluir" type="submit" id="incluir" value="Incluir"      onclick="return js_pegare()"  <?=($db_opcao!=1?"disabled":"")?> />
        <input name="alterar" type="submit" id="alterar" value="Alterar"      onclick="return js_pegare()"  <?=($db_opcao!=2?"disabled":"")?> />
        <input name="excluir" type="submit" id="excluir" value="Excluir"      onclick="return js_pegare()"  <?=($db_opcao!=2?"disabled":"")?> />
        <input name="nova"    type="button" id="nova"    value="Nova Isenção" onclick="js_trocaid('nova')">

        <?php if (!$alterando) { ?>
            <input name="voltar" type="button" id="volta" value="Voltar" onclick="js_volta()">
        <?php } ?>
    </form>
</div>
<?php
if (!$alterando) {
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
}
?>
</body>
</html>
<script type="text/javascript">

    const tipoIsencao = document.form1.q147_tipoisen.value;
    const isencaoTaxas = document.form1.q147_taxas.value;
    const alterando   = <?php echo $alterando ? 1 : 0;?>;

    if (alterando === 1 && tipoIsencao === 1) {
        document.form1.q148_perc.readOnly = 'true';
    }

    /**
     * Validamos as obrigatoriedades dos campos
     *
     * @return boolean
     */
    function js_validarCampo() {

        let tipoIsencao = document.form1.q147_tipoisen.value;

        if (document.getElementById('q148_tipo').value === "") {

            alert('Informe o tipo de isenção.');
            return false;
        }

        if (document.getElementById('q148_dtini').value === "") {

            alert('Informe a data de início.');
            return false;
        }

        if ( (tipoIsencao !== 1 && tipoIsencao !== 2) && alterando !== 1) {

            if (document.getElementById('q148_dtfim').value === "") {

                alert('Informe a data de término.');
                return false;
            }
        }

        if (document.getElementById('q148_dtfim').value !== "") {

            const dtfim = document.form1.q148_dtfim.value;
            const dtini = document.form1.q148_dtini.value;

            if (dtfim.substr(6,4) === dtini.substr(6,4)) {

                if (dtfim.substr(3,2) === dtini.substr(3,2)) {

                    if (dtfim.substr(0,2) < dtini.substr(0,2)) {

                        alert('A data final nao pode ser menor que a data inicial.');
                        return false;
                    }
                } else if (dtfim.substr(3,2) < dtini.substr(3,2)) {

                    alert('A data final nao pode ser menor que a data inicial.');
                    return false;
                }
            } else if (dtfim.substr(6,4) < dtini.substr(6,4)) {

                alert('A data final nao pode ser menor que a data inicial.');
                return false;
            }
        }

        if (document.getElementById('q148_perc').value === "") {

            alert('Informe o percentual de isencão.');
            return false;
        }

        if (document.getElementById('q148_hist').value === "") {

            alert('Informe o histório da isenção.');
            return false;
        }

        return true;
    }

    function js_pegare() {

        if (!js_validarCampo()) {
            return false;
        }

        const obj   = document.getElementsByTagName("INPUT");
        let val   = "";
        let valor = "";
        let x     = "";
        const expr  = new RegExp("[^0-9\.]+");

        if(document.form1.q147_descr.value === '' || document.form1.q148_tipo.value === ''){

            alert('Tipo de isenção não encontrado no cadastro de isenções');
            document.form1.q148_tipo.value = '';
            document.form1.q148_tipo.focus();
            return false;
        }

        for(let i=0; i<obj.length; i++){

            const matri = obj[i].name.split("xx");

            if(obj[i].id==="receit"){

                valor = obj[i].value;
                if(obj[i].value.match(expr)) {

                    alert(matri[0]+" deve ser preenchido somente com números decimais!");
                    obj[i].select();
                    return false;
                }

                if(obj[i].value==="") {

                    alert(matri[0]+" deve ser preenchido!");
                    obj[i].select();
                    return false;
                }

                /**
                 * valor percentual yy numero da receita
                 */
                val += x + obj[i].value + "yy" + matri[1];
                x    = "X";
            }
        }

        document.form1.dadostaxa.value=val;
        return true;
    }

    function js_validapercentual(obj){

        const valor = Number(obj.value);
        if(valor > 100 ){
            alert('Percentual nao pode ser maior que 100 !');
            obj.value = '0';
            obj.focus();
            obj.select();
        }
    }

    function js_limpanome(){
        document.form1.q147_descr.value='';
    }

    function js_mostrabic_matricula(){
        js_OpenJanelaIframe('','db_iframe_cadastro','cad3_conscadastro_002.php?cod_matricula=<?=@$q148_inscr?>','Pesquisa',true);
    }

    function js_pesquisap58_codproc(mostra){

        if(mostra===true){
            js_OpenJanelaIframe('','db_iframe_cgm','func_protprocesso.php?funcao_js=parent.js_mostraprotprocesso1|p58_codproc|p58_requer','Pesquisa',true);
        }else{
            js_OpenJanelaIframe('','db_iframe_cgm','func_protprocesso.php?pesquisa_chave='+document.form1.p58_codproc.value+'&funcao_js=parent.js_mostraprotprocesso','Pesquisa',false);
        }
    }

    function js_mostraprotprocesso(chave,chave1,erro){

        document.form1.p58_requer.value = chave1;
        if(erro===true){

            document.form1.p58_codproc.focus();
            document.form1.p58_codproc.value = '';
        }
    }

    function js_mostraprotprocesso1(chave1,chave2){

        document.form1.p58_codproc.value = chave1;
        document.form1.p58_requer.value  = chave2;
        db_iframe_cgm.hide();
    }

    function js_volta(){
        location.href = 'iss4_issisen001.php ';
    }

    function js_pesquisaq148_tipo(mostra){

        if(mostra===true){
            js_OpenJanelaIframe('','db_iframe','func_tipoisen.php?funcao_js=parent.js_mostratipoisen1|0|1|2|3','Pesquisa',true);
        }else{
            js_OpenJanelaIframe('','db_iframe','func_tipoisen.php?pesquisa_chave='+document.form1.q148_tipo.value+'&funcao_js=parent.js_mostratipoisen','Pesquisa',false);
        }

    }

    function js_alteraValidacaoDataFim(q147_tipoisen, q147_taxas) {

        var elementosTaxas = document.getElementsByClassName('receit');

        document.form1.q148_perc.value    = '';
        document.form1.q148_perc.readOnly = '';

        for (i in elementosTaxas) {

            if (isNumeric(i)){

                elementosTaxas[i].value    = '';
                elementosTaxas[i].readOnly = '';
            }
        }

        if (q147_tipoisen === 1) {

            document.form1.q148_perc.value    = '100';
            document.form1.q148_perc.readOnly = 'true';

            for (let i in elementosTaxas) {

                if (isNumeric(i) && q147_taxas !== 't'){

                    elementosTaxas[i].value    = '100';
                    elementosTaxas[i].readOnly = 'true';
                }
            }
        }

        if (q147_tipoisen === 1 || q147_tipoisen === 2) {
            document.form1.q148_dtfim.style = "background-color:#e6e4f1;";
        } else {
            document.form1.q148_dtfim.style = "background-color:#FFFFFF;";
        }
    }

    function js_mostratipoisen(chave,tipo,taxas,erro){

        document.form1.q147_descr.value = chave;
        document.form1.q147_tipoisen.value = tipo;
        document.form1.q147_taxas.value = taxas;
        if(erro===true){

            document.form1.q148_tipo.focus();
            document.form1.q148_tipo.value = '';
        }
        js_alteraValidacaoDataFim(document.form1.q147_tipoisen.value, document.form1.q147_taxas.value);
    }

    function js_mostratipoisen1(chave1,chave2,chave3,chave4){

        document.form1.q148_tipo.value  = chave1;
        document.form1.q147_descr.value = chave2;
        document.form1.q147_tipoisen.value = chave3;
        document.form1.q147_taxas.value = chave4;
        db_iframe.hide();
        js_alteraValidacaoDataFim(document.form1.q147_tipoisen.value, document.form1.q147_taxas.value);
    }

    function js_pesquisa(){
        js_OpenJanelaIframe('','','func_issisen.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
    }

    function js_preenchepesquisa(chave){
        location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave;
    }

    function js_pesquisaq148_inscr(mostra){

        if(mostra===true){
            js_OpenJanelaIframe('','','func_issbase.php?funcao_js=parent.js_mostraissbase1|0|1','Pesquisa',true);
        }else{
            js_OpenJanelaIframe('','','func_issbase.php?pesquisa_chave='+document.form1.q148_inscr.value+'&funcao_js=parent.js_mostraissbase','Pesquisa',false);
        }
    }

    function js_mostraissbase(chave,erro){

        document.form1.z01_nome.value = chave;
        if(erro===true){

            document.form1.q148_inscr.focus();
            document.form1.q148_inscr.value = '';
        }
    }
    function js_mostraissbase1(chave1,chave2){
        document.form1.q148_inscr.value = chave1;
        document.form1.z01_nome.value = chave2;
        db_iframe.hide();
    }

    function js_pesquisa(){
        js_OpenJanelaIframe('','','func_issisen.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
    }

    function js_preenchepesquisa(chave){

        db_iframe.hide();
        location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave;
    }

    function js_cgm(mostra){

        if(mostra===true){
            js_OpenJanelaIframe('','','func_nome.php?funcao_js=parent.js_mostra1|0|1','Pesquisa',true);
        }else{
            js_OpenJanelaIframe('','','func_nome.php?pesquisa_chave='+document.form1.q148_numcgm.value+'&funcao_js=parent.js_mostra','Pesquisa',false);
        }
    }

    function js_mostra1(chave1,chave2){

        document.form1.q148_numcgm.value = chave1;
        document.form1.z01_nome.value   = chave2;
        db_iframe.hide();
    }

    function js_mostra(erro,chave){

        document.form1.z01_nome.value = chave;

        if(erro===true){

            document.form1.q148_numcgm.focus();
            document.form1.q148_numcgm.value="";
        }
    }

    function js_preenchedif(nome,valor1,valor2){

        valor1 = parseInt(valor1);
        valor2 = parseInt(valor2);

        if(valor1>valor2){

            alert("A área a isentar deve ser menor que a área total do lote.");
            eval('document.form1.'+nome+'.value = "";');
            eval('document.form1.'+nome+'.focus();');
            document.form1.q148_dif.value = "";
        } else {

            if((valor1 !== "" || valor1===0) && !isNaN(valor1)){
                document.form1.q148_dif.value = valor2 - valor1;
            }else{
                document.form1.q148_dif.value = "";
            }
        }
    }
</script>
<?php
if(isset($incluir)||isset($excluir)||isset($alterar)){

    if($clissisen->erro_status=="0"){

        db_msgbox($erro_msg);
        if($clissisen->erro_campo!=""){

            echo "<script> document.form1.".$clissisen->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clissisen->erro_campo.".focus();</script>";
        }
    }else{

        $clissisen->erro(true,false);
        db_redireciona("iss4_issisen002.php?q148_inscr=$q148_inscr&q148_codigo=nova".($alterando?"&alterando=true":""));
    }
}
?>
