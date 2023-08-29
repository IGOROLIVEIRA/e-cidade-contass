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


if (isset($_POST["descricao"])) {
    $descricao = $_POST['descricao'];
    $data =  $_POST['data'];
    $servico =  $_POST['servico'];
    $codsubgrupo = $_POST['codsubgrupo'];
    $obra = $_POST['obra'];
    $taxa = $_POST['taxa'];
    $tabela = $_POST['tabela'];
    $codele = $_POST['codele'];

    $dataimportacao = $data[0];
    $pc01_data = $data[0];
    $pc01_data = explode("/", $pc01_data);
    $pc01_data = $pc01_data[2] . "-" . $pc01_data[1] . "-" . $pc01_data[0];

    $pc96_descricao = $_POST['descricaoimportacao'];
    $rs_pc96_sequencial = db_query("select nextval('importacaoitens_pc96_sequencial_seq')");
    $pc96_sequencial = pg_result($rs_pc96_sequencial, 0, 0);


    for ($i = 0; $i < count($descricao); $i++) {
        db_inicio_transacao();

        $clpcmater = new cl_pcmater;
        $clpcmaterele = new cl_pcmaterele;

        $GLOBALS["HTTP_POST_VARS"]["pc01_conversao"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_id_usuario"] = '0';
        $GLOBALS["HTTP_POST_VARS"]["pc01_libaut"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_veiculo"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_veiculo"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_fraciona"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_validademinima"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_obrigatorio"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_liberaresumo"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_obras"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_taxa"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_tabela"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_ativo"] = 'f';

        $sqlerro = false;

        $clpcmater->pc01_descrmater = $descricao[$i];
        $clpcmater->pc01_complmater = $complemento[$i];
        $clpcmater->pc01_data = $pc01_data;
        $clpcmater->pc01_servico   = $servico[$i] == "Sim" ? "true" : "false";
        $clpcmater->pc01_codsubgrupo = $codsubgrupo[$i];
        $clpcmater->pc01_obras = $obra[$i] == "Sim" ? "true" : "false";
        $clpcmater->pc01_taxa   = $taxa[$i] == "Sim" ? "true" : "false";
        $clpcmater->pc01_tabela = $tabela[$i] == "Sim" ? "true" : "false";
        $clpcmater->pc01_ativo =  'f';
        $clpcmater->pc01_conversao = 'f';
        $clpcmater->pc01_id_usuario =  db_getsession("DB_id_usuario");
        $clpcmater->pc01_libaut = "true";
        $clpcmater->pc01_veiculo = 'f';
        $clpcmater->pc01_fraciona = 'f';
        $clpcmater->pc01_validademinima = 'f';
        $clpcmater->pc01_obrigatorio = 'f';
        $clpcmater->pc01_liberaresumo = 'f';

        $clpcmater->incluir(null);
        if ($clpcmater->erro_status = "0") {
            db_msgbox($clpcmater->erro_msg);
            break;
        }

        $clpcmaterele->pc07_codmater = $clpcmater->pc01_codmater;
        $clpcmaterele->pc07_codele = $codele[$i];
        $clpcmaterele->incluir($clpcmater->pc01_codmater, $codele[$i]);
        $codigoitens .= $clpcmater->pc01_codmater . ",";

        db_query("INSERT INTO importacaoitens values ($pc96_sequencial,'$pc96_descricao',$clpcmater->pc01_codmater)");

        db_fim_transacao(false);
    }

    $codigoitens = substr($codigoitens, 0, -1);

    db_msgbox($clpcmater->erro_msg);


    echo "<script> 

    Filtros = '';
            Filtros += 'codigoitens='+'$codigoitens';
            Filtros += '&codigoimportacao='+'$pc96_sequencial';
            Filtros += '&descricao='+'$pc96_descricao';
            Filtros += '&data='+'$dataimportacao';


    var jan = window.open('com2_relatorioimportacaoitens.php?'+Filtros, '', 'location=0, width='+(screen.availWidth - 5)+
                'width='+(screen.availWidth - 5)+', scrollbars=1');
            jan.moveTo(0, 0);

    </script>
    
    ";
}

$totalitens = 0;


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


            $dataArr[$i][0] = preg_replace('/[^\p{L}\p{N}\s]/', '', $pc01_descrmater );
            $dataArr[$i][1] = preg_replace('/[^\p{L}\p{N}\s]/', '', $pc01_complmater );
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

        $descricao = $_POST["pc96_descricao"];


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
                                    <td style="width: 100px;display:none;">
                                        <?php
                                        $rs_encpatrimonial = $clcondataconf->sql_record($clcondataconf->sql_query_file(db_getsession('DB_anousu'), db_getsession('DB_instit'), "c99_datapat", null, null));
                                        $c99_datapat = db_utils::fieldsMemory($rs_encpatrimonial, 0)->c99_datapat;
                                        $c99_datapat = implode('/', array_reverse(explode('-', $c99_datapat)));
                                        $c99_datapat = explode("/", $c99_datapat);
                                        $c99_datapat_dia = $c99_datapat[0];
                                        $c99_datapat_mes = $c99_datapat[1];
                                        $c99_datapat_ano = $c99_datapat[2];
                                        db_inputdata("c99_datapat", $c99_datapat_dia, $c99_datapat_mes, $c99_datapat_ano, true, "text", 1, "", "c99_datapat");
                                        ?>
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
                                        <?php
                                        db_inputdata("pc01_data", '', true, "text", 1, "", "dataI");
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b> Descrição da importação: </b>
                                    </td>
                                    <td>
                                        <?php
                                        db_input('pc96_descricao', 32, '', true, 'text', 1);
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
        <table style="width:100%; border: 0px solid black; margin-top:30px;">
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

            $erro = false;

            foreach ($arrayItensPlanilha as $rown) {

                echo "<tr style='background-color:#ffffff;'>";

                if (mb_strlen($rown->pc01_descrmater, 'UTF-8') > 80) {
                    echo "<td style='text-align:center;'>";
                    echo "<input title='Campo de texto limitado a 80 caracteres' style='text-align:center; background-color:#f09999; width:90%; border:none;' readonly='' type='text' name='descricao[]' value='" . $rown->pc01_descrmater . "'>";
                    echo "</td>";
                    $erro = true;
                } else if ($rown->pc01_descrmater == "") {
                    echo "<td style='text-align:center;'>";
                    echo "<input title='Campo Descrição do material não informado' style='text-align:center; background-color:#f09999; width:90%; border:none;' readonly='' type='text' name='descricao[]' value='" . $rown->pc01_descrmater . "'>";
                    echo "</td>";
                    $erro = true;
                } else {
                    echo "<td  style='text-align:center;'>";
                    echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='descricao[]' value='" . $rown->pc01_descrmater . "'>";
                    echo "</td>";
                }

                $pc01_data = $_POST["pc01_data"];
                echo "<td name='data[]' style='text-align:center;' >";
                echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='data[]' value='" . $pc01_data . "'>";

                echo "</td>";

                if (mb_strtolower($rown->pc01_servico) != "sim" && mb_strtolower($rown->pc01_servico) != "não") {
                    echo "<td style='text-align:center;'>";
                    echo "<input title='O campo serviço permite somente ?Sim? ou ?Não?' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='servico[]' value='" . mb_convert_case($rown->pc01_servico, MB_CASE_TITLE, "ISO-8859-1")  . "'>";
                    echo "</td>";
                    $erro = true;
                } else if ($rown->pc01_servico == "") {
                    echo "<td style='text-align:center;'>";
                    echo "<input title='Campo Serviço não informado' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='servico[]' value='" . mb_convert_case($rown->pc01_servico, MB_CASE_TITLE, "ISO-8859-1")  . "'>";
                    echo "</td>";
                    $erro = true;
                } else {
                    echo "<td style='text-align:center;'>";
                    echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='servico[]' value='" . mb_convert_case($rown->pc01_servico, MB_CASE_TITLE, "ISO-8859-1") . "'>";
                    echo "</td>";
                }

                if (is_numeric($rown->pc01_codsubgrupo)) {
                    $instituicao = db_getsession('DB_instit');
                    $sSQL = "select pc04_descrsubgrupo from pcsubgrupo where pc04_codsubgrupo = $rown->pc01_codsubgrupo and pc04_instit in ($instituicao,0);";
                    $rsResult       = db_query($sSQL);
                    $pc04_descrsubgrupo = db_utils::fieldsMemory($rsResult, 0)->pc04_descrsubgrupo;
                    if ($pc04_descrsubgrupo == "") {
                        echo "<td style='text-align:center; '>";
                        echo "<input title='Campo subgrupo não encontrado' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='subgrupo[]' value='" . $rown->pc01_codsubgrupo . "'>";
                        echo "</td>";
                        $erro = true;
                    } else {
                        echo "<td style='text-align:center;'>";
                        echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='subgrupo[]' value='" . $pc04_descrsubgrupo . "'>";
                        echo "</td>";
                    }
                } else {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo "<input title='Campo Cód Subgrupo permite somente números' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='subgrupo[]' value='" . $rown->pc01_codsubgrupo . "'>";
                    echo "</td>";
                    $erro = true;
                }


                if (mb_strtolower($rown->pc01_obras) != "sim" && mb_strtolower($rown->pc01_obras) != "não" && mb_strtolower($rown->pc01_obras) != "nao") {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo "<input title='Campo serviço permite somente ?Sim? ou ?Não?'  style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='obra[]' value='" . mb_convert_case($rown->pc01_obras, MB_CASE_TITLE, "ISO-8859-1") . "'>";
                    echo "</td>";
                    $erro = true;
                } else if ($rown->pc01_obras == "") {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo "<input title='Campo obras não informado'  style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='obra[]' value='" . mb_convert_case($rown->pc01_obras, MB_CASE_TITLE, "ISO-8859-1") . "'>";
                    echo "</td>";
                    $erro = true;
                } else {
                    echo "<td style='text-align:center;'>";
                    echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='obra[]' value='" . mb_convert_case($rown->pc01_obras, MB_CASE_TITLE, "ISO-8859-1") . "'>";
                    echo "</td>";
                }

                if (mb_strtolower($rown->pc01_tabela) != "sim" && mb_strtolower($rown->pc01_tabela) != "não" && mb_strtolower($rown->pc01_tabela) != "nao") {
                    echo "<td style='text-align:center;'>";
                    echo "<input title='Campo serviço permite somente ?Sim? ou ?Não?' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='tabela[]' value='" . mb_convert_case($rown->pc01_tabela, MB_CASE_TITLE, "ISO-8859-1")  . "'>";
                    echo "</td>";
                    $erro = true;
                } else if ($rown->pc01_tabela == "") {
                    echo "<td style='text-align:center;'>";
                    echo "<input title='Campo Tabela não informado' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='tabela[]' value='" . mb_convert_case($rown->pc01_tabela, MB_CASE_TITLE, "ISO-8859-1")  . "'>";
                    echo "</td>";
                    $erro = true;
                } else {
                    echo "<td style='text-align:center;'>";
                    echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='tabela[]' value='" . mb_convert_case($rown->pc01_tabela, MB_CASE_TITLE, "ISO-8859-1") . "'>";
                    echo "</td>";
                }

                if (mb_strtolower($rown->pc01_taxa) != "sim" && mb_strtolower($rown->pc01_taxa) != "não" && mb_strtolower($rown->pc01_taxa) != "nao") {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo "<input title='Campo Taxa permite somente ?Sim? ou ?Não?' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='taxa[]' value='" . mb_convert_case($rown->pc01_taxa, MB_CASE_TITLE, "ISO-8859-1") . "'>";
                    echo "</td>";
                    $erro = true;
                } else if ($rown->pc01_taxa == "") {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo "<input title='Campo Taxa não informado' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='taxa[]' value='" . mb_convert_case($rown->pc01_taxa, MB_CASE_TITLE, "ISO-8859-1") . "'>";
                    echo "</td>";
                    $erro = true;
                } else {
                    echo "<td style='text-align:center;'>";
                    echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='taxa[]' value='" . mb_convert_case($rown->pc01_taxa, MB_CASE_TITLE, "ISO-8859-1") . "'>";
                    echo "</td>";
                }

                if (is_numeric($rown->pc07_codele)) {
                    $anousu = db_getsession("DB_anousu");
                    $sSQL = "select o56_elemento,o56_descr from orcelemento where o56_codele = $rown->pc07_codele and o56_anousu = $anousu;";
                    $rsResult       = db_query($sSQL);
                    $orcelemento = db_utils::fieldsMemory($rsResult, 0);
                    if ($orcelemento->o56_descr == "") {
                        echo "<td style='text-align:center; background-color:#f09999;'>";
                        echo "<input title='Desdobramento não encontrado' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='desdobramento[]' value='" . $rown->pc07_codele . "'>";
                        echo "</td>";
                        $erro = true;
                    } else {
                        echo "<td style='text-align:center;'>";
                        echo "<input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='desdobramento[]' value='" . $orcelemento->o56_elemento . " - " . $orcelemento->o56_descr . "'>";
                        echo "</td>";
                    }
                } else {
                    echo "<td style='text-align:center; background-color:#f09999;'>";
                    echo "<input title='Campo reduzido permite somente números' style='text-align:center; width:90%; border:none; background-color:#f09999;' readonly='' type='text' name='desdobramento[]' value='" . $rown->pc07_codele . "'>";
                    echo "</td>";
                    $erro = true;
                }

                echo "<td style='text-align:center; display:none;'>";
                echo "<input style='text-align:center; width:90%; border:none; display:none;' readonly='' type='text' name='codele[]' value='" . $rown->pc07_codele . "'>";
                echo "</td>";

                echo "<td style='text-align:center; display:none;'>";
                echo "<input style='text-align:center; width:90%; border:none; display:none;' readonly='' type='text' name='codsubgrupo[]' value='" . $rown->pc01_codsubgrupo . "'>";
                echo "</td>";

                echo "<td style='text-align:center; display:none;'>";
                echo "<input style='text-align:center; width:90%; border:none; display:none;' readonly='' type='text' name='complemento[]' value='" . $rown->pc01_complmater . "'>";
                echo "</td>";



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

    db_input('descricaoimportacao', 80, '', true, 'text', 1, 'style="display: none;"');


    if (isset($_POST["processar"])) {
        echo "<script>document.getElementById('pc01_data').value = '$pc01_data'; </script>";
        echo "<script>document.getElementById('descricaoimportacao').value = '" . $_POST['pc96_descricao'] . "'</script>";
        echo  "<input style='margin-top: 10px;' type='button' id='salvar' name='salvar'  value='Salvar' onclick='salvarItens()'> ";
    } else {
        echo  "<input style='margin-top: -200px;' type='button' id='salvar' value='Salvar' name='salvar' onclick='salvarItens()'>";
    }
    if ($erro) {
        echo "<script> document.getElementById('save').disabled = true; </script>";
        echo "<script>  alert('Corrija os itens grifados em vermelho e reprocesse a planilha.'); </script>";
    }

    ?>

</form>
<script>
    var codigoimportacao;
    var urlrelatorio;

    function js_gerarRelatorio() {

        var iHeight = 200;
        var iWidth = 300;
        windowDotacaoItem = new windowAux('wndDotacoesItem',
            'Gerar Relagório ',
            iWidth,
            iHeight
        );

        var sContent = "<div style='margin-top:30px;'>";
        sContent += "<fieldset>";
        sContent += "<legend>Gerar Relatório de Importação de itens em:</legend>";
        sContent += "  <div id=''>";
        sContent += "  <input type='checkbox' id='pdf' name='PDF'>";
        sContent += "  <label>PDF</label>";
        sContent += "  </div>";
        sContent += "  <div id=''>";
        sContent += "  <input type='checkbox' id='excel' name='EXCEL'>";
        sContent += "  <label>EXCEL</label>";
        sContent += "  </div>";
        sContent += "</fieldset>";
        sContent += "<center>";
        sContent += "<input type='button' id='btnGerar' value='Confirmar' onclick='gerarRelatorio()'>";
        sContent += "</center>";
        sContent += "</div>";
        windowDotacaoItem.setContent(sContent);
        windowDotacaoItem.show();

    }

    function gerarRelatorio() {
        var pdf = document.getElementById("pdf");
        var excel = document.getElementById("excel");


        if (pdf.checked) {
            //document.location.href = document.location.href;

            var jan = window.open('com2_relatorioimportacaoitens.php?' + urlrelatorio, '', 'location=0, width=' + (screen.availWidth - 5) +
                'width=' + (screen.availWidth - 5) + ', scrollbars=1');
            jan.moveTo(0, 0);
        } else if (excel.checked) {
            window.location.href = "com2_relatorioimportacaoitensexcel.php?codigoimportacao=" + codigoimportacao;
        }
        windowDotacaoItem.destroy();
    }

    function salvarItens() {

        js_divCarregando('Aguarde, salvando os itens...', 'msgbox');
        var oParam = new Object();
        oParam.exec = "salvarItens";
        oParam.data = document.getElementById('pc01_data').value;
        oParam.descricaoImportacao = document.getElementById('pc96_descricao').value;
        oParam.aItens = new Array();

        for (i = 0; i < document.getElementsByName('descricao[]').length; i++) {
            var oItem = new Object();
            oItem.descricao = document.getElementsByName('descricao[]')[i].value;
            oItem.codsubgrupo = document.getElementsByName('codsubgrupo[]')[i].value;
            oItem.obra = document.getElementsByName('obra[]')[i].value;
            oItem.taxa = document.getElementsByName('taxa[]')[i].value;
            oItem.tabela = document.getElementsByName('tabela[]')[i].value;
            oItem.codele = document.getElementsByName('codele[]')[i].value;
            oItem.complemento = document.getElementsByName('complemento[]')[i].value;
            oItem.servico = document.getElementsByName('servico[]')[i].value;

            oParam.aItens.push(oItem);
        }


        var oAjax = new Ajax.Request('com1_pcmaterimportacao.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParam),
            onComplete: js_retornoSalvar
        });

    }

    function js_retornoSalvar(oResponse) {

        js_removeObj('msgbox');
        var oRetorno = eval("(" + oResponse.responseText + ")");
        if (oRetorno.iStatus == 1) {
            Filtros = '';
            Filtros += 'codigoitens=' + oRetorno.codigoitens;
            Filtros += '&codigoimportacao=' + oRetorno.pc96_sequencial;
            Filtros += '&descricao=' + document.getElementById('pc96_descricao').value;
            Filtros += '&data=' + document.getElementById('pc01_data').value;
            urlrelatorio = Filtros;
            codigoimportacao = oRetorno.pc96_sequencial;
            js_gerarRelatorio();


        }

        if (oRetorno.iStatus == 2) {
            alert(oRetorno.sMensagem.urlDecode())
        }

    }

    function validaData() {

        var data_patrimonial = document.getElementById('c99_datapat').value;
        data_patrimonial = data_patrimonial.substr(6, 4) + '-' + data_patrimonial.substr(3, 2) + '-' + data_patrimonial.substr(0, 2);
        var data_pcmater = document.getElementById('pc01_data').value;
        data_pcmater = data_pcmater.substr(6, 4) + '-' + data_pcmater.substr(3, 2) + '-' + data_pcmater.substr(0, 2);

        if (data_pcmater <= data_patrimonial) {
            alert('O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.');
            return false;
        }

        if (document.getElementById('pc01_data').value == '') {
            alert('Usuário: obrigatório preencher a data de cadastro dos itens.');
            return false;
        }

        if (document.getElementById('pc96_descricao').value == '') {
            alert('Usuário: é necessário inserir uma descrição para a identificação dessa importação.');
            return false;
        }

    }

    function gerar() {
        window.location.href = " com1_xlsimportacaoitensPlanilha.php";
        js_removeObj("msgbox");
    }

    function js_liberarButton() {
        document.getElementById("Processar").style.display = "block";
    }
    $('uploadfile').observe("change", js_liberarButton);
</script>