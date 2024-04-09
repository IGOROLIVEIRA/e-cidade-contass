<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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
?>
<form name="form1" enctype="multipart/form-data" onsubmit="return js_verificar()" method="post" action="">
    <fieldset style="margin: 40px auto 10px; width: 700px;">
        <legend>
            <strong>Importação de Receitas</strong>
        </legend>
        <table align="center">
            <tr>
                <td nowrap><b>Layout:</b></td>
                <td>
                    <?php
                    $aLayout = array(
                        0 => 'Selecione',
                        2 => 'BDA - Layout 2',
                    );
                    $layout = 2;
                    db_select("layout", $aLayout, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
            <td nowrap><strong>Data Importação:</strong></td>
              <td>
                <?php
                $dataSistema = date("d/m/Y", db_getsession("DB_datausu"));
                db_inputdata('k81_dataimportacao', @$k81_dataimportacao_dia, @$k81_dataimportacao_mes, @$k81_dataimportacao_ano, true, 'text', 1, "")
                ?>
              </td>
            </tr> 
            <tr>
                <td nowrap><b>Arquivo:</b></td>
                <td><?php db_input("arquivo", 29, $Iarqret, true, "file", 4) ?></td>
            </tr>
            
            <tr>
                <td nowrap colspan="2"><b>Antes de realizar a importação confira se a data do arquivo é a mesma data do sistema!</b></td>
            </tr>

        </table>
    </fieldset>
    <center>
        <input name="processar" type="submit" id="processar" value="Processar">
    </center>
</form>

<script type="text/javascript">
    js_removeObj('msgBox');
    // Função de verificação dos campos preenchidos
    function js_verificar() {
        if ($F("layout") == 0) {
            alert("Campo Layout é de preenchimento obrigatório.");
            $('layout').focus();
            return false;
        }

        if ($F('k81_dataimportacao') == '') {
            alert("Informe a data da importação.");
            $('k81_dataimportacao').focus();
            return false;
        }
        
        var valorCampoEstorno = $F('k81_dataimportacao');
        var dataAtual = "<?php print $dataSistema; ?>";
        var dataEstorno = converterParaData(valorCampoEstorno);
        var dataAtual = converterParaData(dataAtual);

        if (dataEstorno > dataAtual) {
            alert("A data de importação não pode ser maior que a data atual.");
            $('k81_dataimportacao').focus();
            return false;
        }

        anoDataAutenticacao = $F('k81_dataimportacao');
        anoDataAtual        = "<?php print $dataSistema; ?>";
        var partesDataAutenticacao = anoDataAutenticacao.split('/');
        var anoAtual = anoDataAtual.split('/');

        if (anoAtual[2] != partesDataAutenticacao[2]) {
            alert("O ano da importção, não pode ser diferente do ano da sessão.");
            $('k81_dataimportacao').focus();
            return false;
        } 

        if ($F("arquivo") == "") {
            alert("Campo Arquivo é de preenchimento obrigatório.");
            $('arquivo').focus();
            return false;
        }
        
        js_divCarregando('Aguarde, processando arquivos','msgBox');
        return true;
    }

    function converterParaData(dataString) {
        var partesData = dataString.split('/');
        return new Date(partesData[2], partesData[1] - 1, partesData[0]);
    }
</script>