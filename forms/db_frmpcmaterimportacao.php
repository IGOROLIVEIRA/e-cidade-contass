<?
/*
* E-cidade Software Publico para Gestao Municipal
* Copyright (C) 2009 DBselller Servicos de Informatica
* www.dbseller.com.br
* e-cidade@dbseller.com.br
*
* Este programa e software livre; voce pode redistribui-lo e/ou
* modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
* publicada pela Free Software Foundation; tanto a versao 2 da
* Licenca como (a seu criterio) qualquer versao mais nova.
*
* Este programa e distribuido na expectativa de ser util, mas SEM
* QUALQUER GARANTIA; sem mesmo a garantia implicita de
* COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
* PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
* detalhes.
*
* Voce deve ter recebido uma copia da Licenca Publica Geral GNU
* junto com este programa; se nao, escreva para a Free Software
* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
* 02111-1307, USA.
*
* Copia da licenca no diretorio licenca/licenca_en.txt
* licenca/licenca_pt.txt
*/

$totalitens = 0;

if (isset($_POST["salvar"])) {
}

if (isset($_POST["processar"])) {
    $contTama = 1;

    $pc01_data = $_POST["pc01_data"];
    $pc01_data = explode("/", $pc01_data);
    $pc01_data = $pc01_data[2] . "-" . $pc01_data[1] . "-" . $pc01_data[0];

    $novo_nome = $_FILES["uploadfile"]["name"];

    // Nome do novo arquivo
    $nomearq = $_FILES["uploadfile"]["name"];

    $extensao = strtolower(substr($nomearq, -5));

    $diretorio = "libs/Pat_xls_import/";

    // Nome do arquivo temporário gerado no /tmp
    $nometmp = $_FILES["uploadfile"]["tmp_name"];

    // Seta o nome do arquivo destino do upload
    $arquivoDocument = "$diretorio" . "$novo_nome";


    if ($extensao != ".xlsx") {
        db_msgbox("Arquivo inválido! O arquivo selecionado deve ser do tipo .xlsx");
        unlink($nometmp);
        $lFail = true;
        db_redireciona('com1_pcmaterimportacao001.php');
    }

    $files = glob('libs/Pat_xls_import/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }

    // Faz um upload do arquivo para o local especificado
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $diretorio . $novo_nome)) {

        $href = $arquivoDocument;
    } else {

        db_msgbox("Erro ao enviar arquivo.");
        unlink($nometmp);
        $lFail = true;
        return false;
    }

    $dir = "libs/Pat_xls_import/";
    $files1 = scandir($dir, 1);
    $arquivo = "libs/Pat_xls_import/" . $files1[0];

    if (!file_exists($arquivo)) {
        echo "<script>alert('Arquivo não localizado')</script>";
    } else {

        $objPHPExcel = PHPExcel_IOFactory::load($arquivo);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();
        $highestRow = $highestRow;

        $i = 0;
        for ($row = 7; $row <= $highestRow; $row++) {

            if (
                $objWorksheet->getCellByColumnAndRow(0, $row)->getValue() == NULL &&
                $objWorksheet->getCellByColumnAndRow(1, $row)->getValue() == NULL &&
                $objWorksheet->getCellByColumnAndRow(2, $row)->getValue() == NULL &&
                $objWorksheet->getCellByColumnAndRow(3, $row)->getValue() == NULL &&
                $objWorksheet->getCellByColumnAndRow(4, $row)->getValue() == NULL &&
                $objWorksheet->getCellByColumnAndRow(5, $row)->getValue() == NULL &&
                $objWorksheet->getCellByColumnAndRow(6, $row)->getValue() == NULL &&
                $objWorksheet->getCellByColumnAndRow(7, $row)->getValue() == NULL
            ) {
                break;
            }

            $cell = $objWorksheet->getCellByColumnAndRow(0, $row);
            $pc01_descrmater = utf8_decode($cell->getValue());

            $cell = $objWorksheet->getCellByColumnAndRow(1, $row);
            $pc01_complmater = utf8_decode($cell->getValue());

            $cell = $objWorksheet->getCellByColumnAndRow(2, $row);
            $pc01_servico =  utf8_decode($cell->getValue());

            $cell = $objWorksheet->getCellByColumnAndRow(3, $row);
            $pc01_codsubgrupo = $cell->getValue();

            $cell = $objWorksheet->getCellByColumnAndRow(4, $row);
            $pc01_obras = utf8_decode($cell->getValue());

            $cell = $objWorksheet->getCellByColumnAndRow(5, $row);
            $pc01_tabela = utf8_decode($cell->getValue());

            $cell = $objWorksheet->getCellByColumnAndRow(6, $row);
            $pc01_taxa = utf8_decode($cell->getValue());

            $cell = $objWorksheet->getCellByColumnAndRow(7, $row);
            $pc07_codele = $cell->getValue();


            $dataArr[$i][0] = $pc01_descrmater;
            $dataArr[$i][1] = $pc01_complmater;
            $dataArr[$i][2] = $pc01_servico;
            $dataArr[$i][3] = $pc01_codsubgrupo;
            $dataArr[$i][4] = $pc01_obras;
            $dataArr[$i][5] = $pc01_tabela;
            $dataArr[$i][6] = $pc01_taxa;
            $dataArr[$i][7] = $pc07_codele;


            $i++;
        }
        $totalitens = $i;
        $arrayItensPlanilha = array();

        foreach ($dataArr as $keyRow => $Row) {


            $objItensPlanilha = new stdClass();
            foreach ($Row as $keyCel => $cell) {

                if ($keyCel == 0) {
                    $objItensPlanilha->pc01_descrmater = $cell;
                }

                if ($keyCel == 1) {
                    $objItensPlanilha->pc01_complmater = $cell;
                }
                if ($keyCel == 2) {
                    $objItensPlanilha->pc01_servico = $cell;
                }
                if ($keyCel == 3) {
                    $objItensPlanilha->pc01_codsubgrupo = $cell;
                }
                if ($keyCel == 4) {
                    $objItensPlanilha->pc01_obras = $cell;
                }
                if ($keyCel == 5) {
                    $objItensPlanilha->pc01_tabela = $cell;
                }
                if ($keyCel == 6) {
                    $objItensPlanilha->pc01_taxa = $cell;
                }
                if ($keyCel == 7) {
                    $objItensPlanilha->pc07_codele = $cell;
                }
            }
            $arrayItensPlanilha[] = $objItensPlanilha;
        }
    }
}
?>


<style>
    #pc21_orcamfornedescr {
        width: 296;
    }

    #tdcontrol {
        width: 11%;
    }

    #dias_validade,
    #dias_prazo,
    #pc20_codorc,
    #Exportarxlsforne,
    #importar {
        width: 91px;
    }

    #uploadfile {
        height: 25px;
    }
</style>
<form name="form1" method="post" action="" enctype="multipart/form-data">
    <center>
        <table border="0" style="width: 30%; align:center;">
            <tr>
                <td>
                    <fieldset>
                        <legend>Importar Itens</legend>

                        <form name="form2" id="form2" method="post" action="db_frmabastimportacao.php" enctype="multipart/form-data">
                            <table>
                                <tr>
                                    <td style="width: 100px">
                                        <b>Importar xls:</b>
                                    </td>
                                    <td>
                                        <?php
                                        db_input("uploadfile", 30, 0, true, "file", 1);
                                        ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td id="myProgress">

                                        <input type="text" id="nomeArquivo" name="nomeArquivo" style="width:235px;" value="<? echo $nomearq; ?>" disabled>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td>
                                        <?php
                                        db_input("namefile", 31, 0, true, "hidden", 1);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b> Data: </b>
                                    </td>
                                    <td>
                                        <?
                                        db_inputdata("pc01_data", '', true, "text", 1, "", "dataI");
                                        ?>
                                    </td>
                                </tr>

                            </table>
                            <div style="margin-left: 120px; margin-top: 10px; width: 220px;">
                                <div style="width: 70px; float: left;">
                                    <input name='processar' type='submit' id="Processar" value="Processar" onClick="return validaData()" />
                                </div>
                                <div style="width: 100px; float: left;">
                                    <input name='exportar' type='button' id="exportar" value="Gerar Planilha" onclick="gerar()" />
                                </div>
                            </div>

                        </form>

                    </fieldset>

                </td>
            </tr>


        </table>
    </center>
</form>

<form name="form3" id="form3" method="post" action="" enctype="multipart/form-data">
    <div class="itens">
        <table style="width:100%; border: 0px solid black;">
            <tr>

                <th style="border: 0px solid red; width:20%; background:#eeeff2;">
                    Item
                </th>

                <th style="border: 0px solid red; background:#eeeff2;">
                    Data
                </th>

                <th style="border: 0px solid red; background:#eeeff2;">
                    Tipo
                </th>

                <th style="background:#eeeff2; width:20%;">
                    Subgrupo
                </th>
                <th style="background:#eeeff2;">
                    Obra
                </th>
                <th style="background:#eeeff2;">
                    Tabela
                </th>
                <th style="background:#eeeff2;">
                    Taxa
                </th>
                <th style="background:#eeeff2; width:25%; ">
                    Desdobramento
                </th>
            </tr>


            <?php

            $i = 1;
            $tamanho = count($arrayItensPlanilha);
            if ($contTama == 1 && $tamanho == 0) {
                echo "<script>alert('Nenhum registro encontrato!')</script>";
                echo "<script>location.href = 'com1_pcmaterimportacao001.php'</script>;";
            }
            $pc01_data = $_POST["pc01_data"];


            foreach ($arrayItensPlanilha as $rown) {

                echo "<tr style='background-color:#ffffff;'>";

                if (mb_strlen($rown->pc01_descrmater, 'UTF-8') > 80) {
                    echo "<td name='descricao[]' style='text-align:center; background-color:#f09999;'>";
                    echo  $rown->pc01_descrmater;
                    echo "</td>";
                } else {
                    echo "<td name='descricao[]' style='text-align:center;'>";
                    echo $rown->pc01_descrmater;
                    echo "</td>";
                }

                echo "<td name='data[]' style='text-align:center;' >";

                echo $pc01_data;
                echo "</td>";

                if (mb_strtolower($rown->pc01_servico) != "sim" && mb_strtolower($rown->pc01_servico) != "não") {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo $rown->pc01_servico;
                    echo "</td>";
                } else {
                    echo "<td style='text-align:center;'>";
                    echo $rown->pc01_servico;
                    echo "</td>";
                }

                if (is_numeric($rown->pc01_codsubgrupo)) {
                    $instituicao = db_getsession('DB_instit');
                    $sSQL = "select pc04_descrsubgrupo from pcsubgrupo where pc04_codsubgrupo = $rown->pc01_codsubgrupo and pc04_instit in ($instituicao,0);";
                    $rsResult       = db_query($sSQL);
                    $pc04_descrsubgrupo = db_utils::fieldsMemory($rsResult, 0)->pc04_descrsubgrupo;
                    if ($pc04_descrsubgrupo == "") {
                        echo "<td style='text-align:center; background-color:#f09999;'>";
                        echo $rown->pc01_codsubgrupo;
                        echo "</td>";
                    } else {
                        echo "<td style='text-align:center;'>";
                        echo $pc04_descrsubgrupo;
                        echo "</td>";
                    }
                } else {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo $rown->pc01_codsubgrupo;
                    echo "</td>";
                }


                if (mb_strtolower($rown->pc01_obras) != "sim" && mb_strtolower($rown->pc01_obras) != "não" && mb_strtolower($rown->pc01_obras) != "nao") {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo $rown->pc01_obras;
                    echo "</td>";
                } else {
                    echo "<td style='text-align:center;'>";
                    echo $rown->pc01_obras;
                    echo "</td>";
                }

                if (mb_strtolower($rown->pc01_tabela) != "sim" && mb_strtolower($rown->pc01_tabela) != "não" && mb_strtolower($rown->pc01_tabela) != "nao") {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo $rown->pc01_tabela;
                    echo "</td>";
                } else {
                    echo "<td style='text-align:center;'>";
                    echo $rown->pc01_tabela;
                    echo "</td>";
                }

                if (mb_strtolower($rown->pc01_taxa) != "sim" && mb_strtolower($rown->pc01_taxa) != "não" && mb_strtolower($rown->pc01_taxa) != "nao") {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo $rown->pc01_taxa;
                    echo "</td>";
                } else {
                    echo "<td style='text-align:center;'>";
                    echo $rown->pc01_taxa;
                    echo "</td>";
                }

                if (is_numeric($rown->pc07_codele)) {
                    $anousu = db_getsession("DB_anousu");
                    $sSQL = "select o56_elemento,o56_descr from orcelemento where o56_codele = $rown->pc07_codele and o56_anousu = $anousu;";
                    $rsResult       = db_query($sSQL);
                    $orcelemento = db_utils::fieldsMemory($rsResult, 0);
                    if ($orcelemento->o56_descr == "") {
                        echo "<td style='text-align:center; background-color:#f09999;'>";
                        echo $rown->pc07_codele;
                        echo "</td>";
                    } else {
                        echo "<td style='text-align:center;'>";
                        echo $orcelemento->o56_elemento . " - " . $orcelemento->o56_descr;
                        echo "</td>";
                    }
                } else {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo $rown->pc07_codele;
                    echo "</td>";
                }

                echo "</tr>";
                $i++;
            }

            ?>
            </tr>

            <tr style='background-color:#eeeff2;'>

                <td colspan="9" align="center"> <strong>Total de itens:</strong>
                    <span class="nowrap" id="totalitens"> <?php echo $totalitens ?> </span>
                </td>

            </tr>


            <?

            ?>
        </table>


    </div>
    <?php

    if (isset($_POST["processar"])) {
        echo  "<input style='margin-top: 10px;' type='submit' id='db_opcao' name='salvar' id='salvar' value='Salvar'>";
    } else {
        echo  "<input style='margin-top: -200px;' type='submit' id='db_opcao' value='Salvar'>";
    }

    ?>

</form>
<script>
    function validaData() {
        if (document.getElementById('pc01_data').value == '') {
            alert('Usuário: obrigatório preencher a data de cadastro dos itens.');
            return false;
        }

    }

    function gerar() {
        window.location.href = " com1_xlsimportacaoitensPlanilha.php";
    }

    function js_liberarButton() {
        document.getElementById("Processar").style.display = "block";
    }
    $('uploadfile').observe("change", js_liberarButton);
</script>