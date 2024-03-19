<?php
$o203_exercicio = db_getsession('DB_anousu');
?>
<form name="form1" method="post" action="">
<fieldset style="width: 1000px;">
    <legend><b>Metas de Arrecadação de Receita</b></legend>
    <center>
        <table border="0">
            <tr>
                <td nowrap title="o203_exercicio">
                    <strong>Exercício:</strong>
                </td>
                <td>
                    <?
                    db_input('o203_exercicio',14,$Io203_exercicio,true,'text',3,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="o203_bimestre01">
                    <strong>1º Bimestre:</strong>
                </td>
                <td>
                    <?
                    db_input('o203_bimestre01',14,4,true,'text',$db_opcao,"onchange='js_somar(this.value)'")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="o203_bimestre02">
                    <strong>2º Bimestre:</strong>
                </td>
                <td>
                    <?
                    db_input('o203_bimestre02',14,4,true,'text',$db_opcao,"onchange='js_somar(this.value)'")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="o203_bimestre03">
                    <strong>3º Bimestre:</strong>
                </td>
                <td>
                    <?
                    db_input('o203_bimestre03',14,4,true,'text',$db_opcao,"onchange='js_somar(this.value)'")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="o203_bimestre04">
                    <strong>4º Bimestre:</strong>
                </td>
                <td>
                    <?
                    db_input('o203_bimestre04',14,4,true,'text',$db_opcao,"onchange='js_somar(this.value)'")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="o203_bimestre05">
                    <strong>5º Bimestre:</strong>
                </td>
                <td>
                    <?
                    db_input('o203_bimestre05',14,4,true,'text',$db_opcao,"onchange='js_somar(this.value)'")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="o203_bimestre06">
                    <strong>6º Bimestre:</strong>
                </td>
                <td>
                    <?
                    db_input('o203_bimestre06',14,4,true,'text',$db_opcao,"onchange='js_somar(this.value)'")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="o203_bimestre06">
                    <strong>Total :</strong>
                </td>
                <td>
                    <?
                    db_input('o203_totalbimestres',14,4,true,'text',3,"")
                    ?>
                </td>
            </tr>
        </table>
    </center>
    <input name="salvar" type="submit" id="salvar" value="Salvar" >
</form>
<script>

function js_somar() {
    var soma = 0;
    for (var i = 1; i <= 6; i++) {
        var valor = js_formatar(document.getElementById("o203_bimestre0"+ i).value, 'f');
        document.getElementById("o203_bimestre" + ("0" + i)).value =  valor;
        valor = valor.split('.').join('');
        soma += parseFloat(valor.replace(',', '.'));
        
    }
    document.getElementById("o203_totalbimestres").value = js_formatar(soma,'f');
}
js_somar();

</script>
