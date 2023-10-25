<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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



$clpcorcam->rotulo->label();
$clpcorcamforne->rotulo->label();
$clpcorcamval->rotulo->label();
$clrotulo = new rotulocampo;

$totalitens = 0;
$visibilidadeEmpenhos = "hidden";
$dataAbastecimento = null;



if (isset($_POST["processar"])) {
    $contTama = 1;
    $lFail = false;
    $dataI = $_POST["dataI"];
    $dataI = explode("/", $dataI);
    $dataI = $dataI[2] . "-" . $dataI[1] . "-" . $dataI[0];

    $dataF = $_POST["dataF"];
    $dataF = explode("/", $dataF);
    $dataF = $dataF[2] . "-" . $dataF[1] . "-" . $dataF[0];






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
        db_redireciona('vei1_abastimportacao001.php');
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
    } else if ($lFail == false) {

        db_msgbox("Erro ao enviar arquivo.");
        unlink($nometmp);
        $lFail = true;
    }

    $dir = "libs/Pat_xls_import/";
    $files1 = scandir($dir, 1);
    $arquivo = "libs/Pat_xls_import/" . $files1[0];

    if (!file_exists($arquivo)) {
        echo "<script>alert('Arquivo não localizado')</script>";
    } else if ($lFail == false) {

        $objPHPExcel = PHPExcel_IOFactory::load($arquivo);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $highestRow = $objWorksheet->getHighestRow();

        $highestRow = $highestRow;
        $visibilidadeEmpenhos = "";

        $i = 0;
        for ($row = 7; $row <= $highestRow; $row++) {

            $cell = $objWorksheet->getCellByColumnAndRow(0, $row);
            $nota = $cell->getValue();

            $cell = $objWorksheet->getCellByColumnAndRow(1, $row);
            $data = $cell->getValue();

            if ($data == "") {
                break;
            }
        		
            $data = DateTime::createFromFormat("d/m/Y" , $data);
            $data = $data->format('Y-m-d');

            $cell = $objWorksheet->getCellByColumnAndRow(2, $row);
            $val = $cell->getValue();
            $tamVal = strlen($val);

            if ($tamVal == 8) {
                $hora = explode(":", $val);
                $hora = $hora[0] . ":" . $hora[1];
            } else {
                $hours = round($val * 24);
                $mins = round($val * 1440) - round($hours * 60);
                $secs = round($val * 86400) - round($hours * 3600) - round($mins * 60);
                $returnValue = (int) gmmktime($hours, $mins, $secs);

                $hora = date('H:i', $returnValue);
            }
            $cell = $objWorksheet->getCellByColumnAndRow(3, $row);
            $placa = $cell->getValue();
            $placa = explode("-", $placa);
            $placa = strtoupper($placa[0]) . "" . $placa[1];

            $cell = $objWorksheet->getCellByColumnAndRow(12, $row);
            $valor = $cell->getValue();

            $cell = $objWorksheet->getCellByColumnAndRow(6, $row);
            $secretaria = $cell->getValue();

            $cell = $objWorksheet->getCellByColumnAndRow(5, $row);
            $motorista = (string)$cell->getValue();

            if (strlen($motorista) == 14) {
                $valorcpf = explode('.', $motorista);
                $valorcpf1 = explode('-', $valorcpf[2]);
                $motorista = $valorcpf[0] . "" . $valorcpf[1] . "" . $valorcpf1[0] . "" . $valorcpf1[1];
            }


            $cell = $objWorksheet->getCellByColumnAndRow(4, $row);
            $motoristaNome = $cell->getValue();

            $cell = $objWorksheet->getCellByColumnAndRow(9, $row);
            $medidasaida = $cell->getValue();

            $cell = $objWorksheet->getCellByColumnAndRow(10, $row);
            $litros = $cell->getValue();

            $cell = $objWorksheet->getCellByColumnAndRow(11, $row);
            $vUnitario = $cell->getValue();

            $cell = $objWorksheet->getCellByColumnAndRow(8, $row);
            $combust = $cell->getValue();


            if (strtotime($dataI) <= strtotime($data) && strtotime($data) <= strtotime($dataF)) {

                $dataArr[$i][0] = $data;
                $dataArr[$i][1] = $hora;
                $dataArr[$i][2] = $placa;
                $dataArr[$i][3] = $valor;
                $dataArr[$i][4] = $secretaria;
                $dataArr[$i][5] = $motorista;
                $dataArr[$i][6] = $medidasaida;
                $dataArr[$i][7] = $litros;
                $dataArr[$i][8] = $vUnitario;
                $dataArr[$i][9] = $combust;
                $dataArr[$i][10] = $motoristaNome;
                $dataArr[$i][11] = $nota;


                $i++;
            }
        }
        $totalitens = $i;
        $arrayItensPlanilha = array();

        foreach ($dataArr as $keyRow => $Row) {


            $objItensPlanilha = new stdClass();
            foreach ($Row as $keyCel => $cell) {

                if ($keyCel == 0) {
                    $objItensPlanilha->data              =  $cell;
                }

                if ($keyCel == 2) {
                    $objItensPlanilha->placa    =  $cell;
                }
                if ($keyCel == 3) {
                    $objItensPlanilha->valor             =  $cell;
                }
                if ($keyCel == 4) {
                    $objItensPlanilha->secretaria        =  $cell;
                }
                if ($keyCel == 5) {
                    $objItensPlanilha->motorista         =  $cell;
                }
                if ($keyCel == 1) {
                    $objItensPlanilha->hora              =  $cell;
                }
                if ($keyCel == 6) {
                    $objItensPlanilha->medidasaida       =  $cell;
                }
                if ($keyCel == 7) {
                    $objItensPlanilha->litros            =  $cell;
                }
                if ($keyCel == 8) {
                    $objItensPlanilha->vUnitario         =  $cell;
                }
                if ($keyCel == 9) {
                    $objItensPlanilha->combust           =  $cell;
                }
                if ($keyCel == 10) {
                    $objItensPlanilha->motoristaNome     =  $cell;
                }
                if ($keyCel == 11) {
                    $objItensPlanilha->nota              =  $cell;
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
                        <legend>Imp. Movimentações</legend>


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
                                        <b> Periodo: </b>
                                    </td>
                                    <td>
                                        <?
                                        db_inputdata("dataI", '', true, "text", 1, "", "dataI");
                                        db_inputdata("dataF", '', true, "text", 1, "", "dataf");
                                        ?>
                                    </td>
                                </tr>

                            </table>
                            <div style="margin-left: 120px; margin-top: 10px; width: 220px;">
                                <div style="width: 70px; float: left;">
                                    <input name='processar' type='submit' id="Processar" value="Processar" />
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

<table style="width: 70%; border: 0px solid black; visibility: <?php echo $visibilidadeEmpenhos; ?>">

    <tr id="edicaoBloco">
        <td colspan='2'>
            <fieldset>
                <legend>Empenho para abastecimentos</legend>
                <table>
                    <td>
                        <?php db_ancora("Empenho:", "js_pesquisae60_codemp(true,0);", 1); ?>

                    </td>
                    <td>
                        <?php db_input('e60_codemp', 10, $Ie60_codemp, true, 'text', 1, "placeholder='num/ano' onchange='js_pesquisae60_codemp(false,0);'") ?>
                    </td>
                    <td>
                        <?
                        db_input('z01_nome', 35, $Iz01_nome, true, 'text', 3, "", "", "", "");
                        ?>
                        <input type='button' id='btnAp?icar' value='Aplicar' onclick="aplicarEmpenho();">
                    </td>
                </table>

        </td>

    </tr>

</table>

<form name="form1" id="form1" method="post" action="" enctype="multipart/form-data">
    <table class="DBGrid" style="width: 70%; border: 0px solid black;" id="tableResult">


        <tr>
            <th class="table_header" style="width: 30px; cursor: pointer;" onclick="marcarTodos();">M</th>

            <th style="border: 0px solid red; width:120px; background:#eeeff2; display:none">
                Cód Abastecimento
            </th>

            <th style="border: 0px solid red; width:120px; background:#eeeff2;">
                Placa
            </th>

            <th style="border: 0px solid red; width:120px; background:#eeeff2;">
                Data
            </th>

            <th style="border: 0px solid red; width:100px; background:#eeeff2;">
                Valor
            </th>

            <th style="border: 0px solid red; width:200px; background:#eeeff2;">
                Departamento
            </th>
            <th style="background:#eeeff2;">
                Empenho
            </th>
        </tr>


        <?php
        $i = 1;
        $tamanho = count($arrayItensPlanilha);
        if ($contTama == 1 && $tamanho == 0) {
            echo "<script>alert('Nenhum registro encontrato!')</script>";
        }
        //var_dump($arrayItensPlanilha);
        foreach ($arrayItensPlanilha as $rown) {

            $dataAbastecimento = $rown->data;

            if ($dataAbastecimento == null) {
                $dataAbastecimento = $rown->data;
            }

            if ($dataAbastecimento < $rown->data && $dataAbastecimento != null) {
                $dataAbastecimento = $rown->data;
            }


            echo "<tr style='background-color:#ffffff;'>";

            echo "<td id='abastecimento$i' style='text-align:center; display:none' >";
            echo $rown->nota;
            echo "</td>";

            echo "<td style='text-align:center;'>";
            echo "<input type='checkbox' class='marca_itens' name='aItonsMarcados[]' value='$i'> ";

            echo "</td>";


            echo "<td id='placa$i' style='text-align:center;' >";
            echo $rown->placa;
            echo "</td>";

            echo "<td id='data$i' style='text-align:center;'>";
            $dataV = $rown->data;
            $dataV = explode("-", $dataV);
            echo $dataV[2] . "-" . $dataV[1] . "-" . $dataV[0];
            echo "</td>";

            echo "<td style='text-align:center;'>";
            echo $rown->valor;
            echo "</td>";

            echo "<td style='text-align:center;'>";
            echo $rown->secretaria;
            echo "</td>";

            echo "<td style='text-align:center; width:100px;'>";
            echo "<input type='text' style='text-align:center;' id='empenho$i' name='empenho$i' placeholder='num/ano' onchange='return verificacaoEmpenho(this.value);' onkeypress='return onlynumber();'>";
            echo "</td>";
            echo "</tr>";
            $i++;
        }

        ?>
        </tr>

        <tr style='background-color:#eeeff2;'>

            <td colspan="6" align="center"> <strong>Total de itens:</strong>
                <span class="nowrap" id="totalitens"> <?php echo $totalitens ?> </span>
            </td>

        </tr>



        <?

        echo
        "<tr>
                            <td colspan='6' align='center'>
                
                                    
                                <input style='margin-top:10px;' type='button' id='db_opcao' value='Salvar'  " . ($db_botao == false ? "disabled" : "") . " onclick='js_verificarEmpenho();'>
                                
                                
                                
                            </td>
                        </tr>";

        $valor = array("valor" => 1, "teste" => 2);

        ?>
    </table>
    <br><br><br>
    <table style="width: 20%; border: 0px solid black; display: none;" id="tbl">

        <tr>
            <th colspan="2" style="text-align: center;">
                Veículos possuem retirada sem devolução
            </th>
        <tr>

        <tr style='background-color:#ffffff;'>
            <th style="width: 150px;">
                Código
            </th>
            <th style="width: 150px;">
                Placa
            </th>
        </tr>
    </table>
    <table style="width: 20%; border: 0px solid black; display: none;" id="veiculosLancados">

        <tr>
            <th colspan="4" style="text-align: center;">
                Veículos possuem abastecimentos já lançados
            </th>
        <tr>

        <tr style='background-color:#ffffff;'>
            <th style="width: 150px;">
                Cod. Abastecimento
            </th>
            <th style="width: 150px;">
                Data
            </th>
            <th style="width: 150px;">
                Litros
            </th>
            <th style="width: 150px;">
                Valor
            </th>
        </tr>
    </table>
    <table style="width: 40%; border: 0px solid black; display: none;" id="tblMotorista">

        <tr>
            <th colspan="2" style="text-align: center;">
                Motoristas não encontrados
            </th>
        <tr>

        <tr style='background-color:#ffffff;'>
            <th style="width: 150px;">
                CPF
            </th>
            <th style="width: 850px;">
                Nome
            </th>
        </tr>
    </table>
    <div id="divtblDataEmpenho">
        <table style="width: 20%; border: 0px solid black; display: none;" id="tblDataEmpenho">

            <tr>
                <th colspan="1" style="text-align: center;">
                    Veículos em que a data do empenho aplicado é maior que a data do abastecimento
                </th>
            <tr>

            <tr style='background-color:#ffffff;'>
                <th style="width: 150px;">
                    Código
                </th>
                <th style="width: 150px;">
                    Placa
                </th>
            </tr>


        </table>
    </div>
    <table style="width: 20%; border: 0px solid black; display: none;" id="tblBaixa">

        <tr>
            <th colspan="2" style="text-align: center;">
                Veículos foram baixados
            </th>
        <tr>

        <tr style='background-color:#ffffff;'>
            <th style="width: 150px;">
                Codigo
            </th>
            <th style="width: 150px;">
                Placa
            </th>
        </tr>
    </table>
    <table style="width: 20%; border: 0px solid black; display: none;" id="tblKm">

        <tr>
            <th colspan="4" style="text-align: center;">
                Erro de quilometragem
            </th>
        <tr>

        <tr style='background-color:#ffffff;'>
            <th style="width: 150px;">
                Codigo
            </th>
            <th style="width: 150px;">
                Placa
            </th>
            <th style="width: 150px;">
                km Final
            </th>
            <th style="width: 150px;">
                km Lançamento
            </th>
        </tr>
    </table>
    <table style="width: 20%; border: 0px solid black; display: none;" id="tblVeic">

        <tr>
            <th colspan="1" style="text-align: center;">
                Veiculos não encontrados
            </th>
        <tr>

        <tr style='background-color:#ffffff;'>

            <th style="width: 150px;">
                Placa
            </th>
        </tr>
    </table>
    <table style="width: 20%; border: 0px solid black; display: none;" id="tblComb">

        <tr>
            <th colspan="2" style="text-align: center;">
                Combustível não encontrado na base
            </th>
        <tr>

        <tr style='background-color:#ffffff;'>

            <th style="width: 150px;">
                Placa
            </th>
            <th style="width: 150px;">
                Combustível
            </th>
        </tr>
    </table>
</form>

<script>
    var empenhoselecionado = "";
    var dataempenho = "";
    document.getElementById("z01_nome").value = "";
    document.getElementById("e60_codemp").value = "";

    function js_removelinha(linha) {
        var tab = (document.all) ? document.all.tab : document.getElementById('tblDataEmpenho');
        for (i = 0; i < tab.rows.length; i++) {
            if (linha == tab.rows[i].id) {
                tab.deleteRow(i);
                break;
            }
        }
    }

    function aplicarEmpenho() {



        var itens = getItensMarcados();
        var gerartabela = 0;

        if (itens.length < 1) {

            alert('Selecione pelo menos um item da lista. ');
            return;

        }


        var i = 0;

        document.getElementById('tblDataEmpenho').remove();

        var element = document.getElementById('divtblDataEmpenho');
        element.innerHTML = ' <table style="width: 20%; border: 0px solid black; display: none;" id="tblDataEmpenho"><tr><th colspan="2" style="text-align: center;">Veículos em que a data do empenho aplicado é maior que a data do abastecimento</th><tr><tr style="background-color: #ffffff;"><th style="width: 150px;">Código</th><th style="width: 150px;">Placa</th></tr></table>'

        itens.forEach(function(item) {



            var id_empenho = 'empenho' + item.value;
            var id_dataabastecimento = 'data' + item.value;
            var data_abastecimento = document.getElementById(id_dataabastecimento).innerText;

            var id_abastecimento = 'abastecimento' + item.value;
            var abastecimento = document.getElementById(id_abastecimento).innerText;

            var id_placa = 'placa' + item.value;
            var placa = document.getElementById(id_placa).innerText;


            var dataFormatada1 = new Date(data_abastecimento.substring(6, 10), data_abastecimento.substring(3, 5), data_abastecimento.substring(0, 2));
            var dataFormatada2 = new Date(dataempenho);


            if (dataFormatada2 > dataFormatada1) {
                gerartabela = 1;
                var tabela = document.getElementById("tblDataEmpenho");

                var numeroLinhas = tabela.rows.length;

                var tabela = document.getElementById("tblDataEmpenho");
                var linha = tabela.insertRow(numeroLinhas);
                var celula1 = linha.insertCell(0);
                var celula2 = linha.insertCell(1);
                celula1.innerHTML = " <div style='text-align:center'>" + abastecimento + "<div>";
                celula2.innerHTML = " <div style='text-align:center'>" + placa + "<div>";
            } else {
                document.getElementById(id_empenho).value = empenhoselecionado;

            }

            i++;

        });

        if (gerartabela == 1) {
            document.getElementById("tblDataEmpenho").style.display = "block";
            return;
        } else {

            document.getElementById("tblDataEmpenho").style.display = "none";

        }

    }

    function getItensMarcados() {
        return aItens().filter(function(item) {
            return item.checked;
        });
    }

    function aItens() {
        var itensNum = document.querySelectorAll('.marca_itens');

        return Array.prototype.map.call(itensNum, function(item) {
            return item;
        });
    }

    function marcarTodos() {

        aItens().forEach(function(item) {

            var check = item.classList.contains('marcado');

            if (check) {
                item.classList.remove('marcado');
            } else {
                item.classList.add('marcado');
            }
            item.checked = !check;

        });

    }

    function verificacaoEmpenho(empenho){
        empenho = empenho.split("/");
        anoempenho = empenho[1];
        
        if(anoempenho == "" || anoempenho == undefined){
            document.getElementById(event.target.id).value = '';
            return alert('Usuário: informar o número do empenho com exercício');
        }
    }

    function js_pesquisae60_codemp(mostra, controlador) {
       
        if (mostra == true) {
            var ve70_abast = "";
            var e60_codemp = "";
            var e60_numemp = "";
            var datainicial = "<?php print $dataI; ?>";
            var datafinal = "<?php print $dataF; ?>";
            var dataAbastecimento = "<?php print $dataAbastecimento; ?>";



            if (controlador == 0) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_empempenho', 'func_empempenho.php?filtroabast=0&ve70_abast=' + ve70_abast + '&importacaoveiculo=1&dataAbastecimento=' + dataAbastecimento + '&funcao_js=parent.js_mostraempempenho2|e60_numemp|e60_codemp|e60_anousu|DB_e60_emiss|e60_numcgm|z01_nome', 'Pesquisa', true);
            } else {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_empempenho', 'func_empempenho.php?filtroabast=1&ve70_abast=' + ve70_abast + '&importacaoveiculo=1&dataAbastecimento=' + dataAbastecimento + '&funcao_js=parent.js_mostraempempenho2|e60_numemp|e60_codemp|e60_anousu|DB_e60_emiss|e60_numcgm', 'Pesquisa', true);
            }

        } else {
            let empenho = document.getElementById('e60_codemp').value;
            verificacaoEmpenho(empenho);
            var datainicial = "<?php print $dataI; ?>";
            var datafinal = "<?php print $dataF; ?>";
            var dataAbastecimento = "<?php print $dataAbastecimento; ?>";


            e60_numemp = document.getElementById("e60_codemp").value;
            js_OpenJanelaIframe('top.corpo', 'db_iframe_empempenho', 'func_empempenho.php?filtroabast=0&importacaoveiculo=1&dataAbastecimento=' + dataAbastecimento + '&pesquisa_chave=' + e60_numemp + '&funcao_js=parent.js_mostraempempenho&lPesquisaPorCodigoEmpenho=1', 'Pesquisa', false);
        }
    }

    function js_mostraempempenho(chave1, chave2, chave3, chave4, chave5, chave6) {
        if (chave2 == true) {
            document.getElementById("z01_nome").value = "";
            document.getElementById("e60_codemp").value = "";


        } else if (chave2 == false) {
            document.getElementById("z01_nome").value = "";

        } else {
            empenhoselecionado = chave1;
            dataempenho = chave6;
            document.getElementById("z01_nome").value = chave2;

        }
    }

    function js_mostraempempenho2(chave1, chave2, chave3, chave4, chave5, chave6) {
        empenhoselecionado = chave2 + "/" + chave3;
        dataempenho = chave4;
        document.getElementById("e60_codemp").value = empenhoselecionado;
        document.getElementById("z01_nome").value = chave6;

        db_iframe_empempenho.hide();

    }

    function gerar() {
        window.location.href = "vei1_xlsabastecimentoPlanilha.php";
        js_removeObj("msgbox");
    }

    function js_verificarEmpenho() {
        var nControle = 0;
        var itens = getItensMarcados();
        let aEmpenhos = [];

        for (i = 0; i < itens.length; i++) {
            var id_registro = itens[i].value;
            var numempenho = document.getElementById('empenho' + id_registro).value;
            aEmpenhos[i] = numempenho;
            if (!numempenho) {
                nControle = 1;
                alert("Preencher número de empenho");
                break;
            }
        }

        let oParametros = new Object();
        let oRetorno;
        oParametros.exec = "validacaoAbastecimentoPorEmpenho";
        oParametros.itensEmpenho = aEmpenhos;
        let oAjax = new Ajax.Request('vei1_xlsabastecimento.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            asynchronous: false,
            onComplete: function(oAjax) {
                oRetorno = eval("(" + oAjax.responseText.urlDecode() + ")");
            }
        });

        let aEmpenhosInvalidos = [...new Set(oRetorno.aEmpenhosInvalidos)];
        console.log(aEmpenhosInvalidos);
        let sEmpenhosInvalidos = JSON.stringify(aEmpenhosInvalidos);
        var permissaoParaControlarSaldo = true;

        if(aEmpenhosInvalidos.length > 0){
            if (!confirm(`Usuário: A data de emissão do(s) empenho(os) ${sEmpenhosInvalidos} é anterior à data de ativação do parametro controle de saldo do empenho, portanto, o saldo não será controlado.`)) {
                return false;
            }
            permissaoParaControlarSaldo = false;
        }

        if (nControle == 0) {
            js_importxlsfornecedor(permissaoParaControlarSaldo,aEmpenhosInvalidos);
        }
    }

    function js_liberarButton() {
        document.getElementById("Processar").style.display = "block";
    }

    $('uploadfile').observe("change", js_liberarButton);

    /***
     * ROTINA PARA CARREGAR VALORES DA PLANILHA ANEXADA
     */
    function js_importxlsfornecedor(permissaoParaControlarSaldo,aEmpenhosInvalidos) {

        var oParam = new Object();
        var empenho = [];
        oParam.exec = 'importar';

        oParam.valor = <?php echo json_encode($arrayItensPlanilha) ?>;
        oParam.nEmpenho = <?php echo json_encode($i - 1) ?>;

        oParam.dataI = <?php echo json_encode($dataI) ?>;
        oParam.dataF = <?php echo json_encode($dataF) ?>;

        for (i = 0; i < oParam.nEmpenho; i++) {
            nInput = i + 1;
            empenho[i] = $F('empenho' + nInput);
        }
        oParam.itensEmpenho = empenho;
        oParam.permissaoParaControlarSaldo = permissaoParaControlarSaldo;
        oParam.aEmpenhosInvalidos = aEmpenhosInvalidos;

        js_divCarregando('Aguarde... Carregando Arquivo', 'msgbox');

        var oAjax = new Ajax.Request(
            'vei1_xlsabastecimento.RPC.php', {
                parameters: 'json=' + Object.toJSON(oParam),
                asynchronous: false,
                method: 'post',
                onComplete: js_retornoimportarxls
            });
    }

    function onlynumber(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /^[0-9.\\/]+$/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }

    function js_retornoimportarxls(oAjax) {
        js_removeObj("msgbox");
        var valorC = [];
        var valorEmp = [];
        var id = 0;
        var opE = 0;
        var oRetorno = eval('(' + oAjax.responseText + ")");
        if (oRetorno.status == 2) {
            alert(oRetorno.message.urlDecode() + "" + valorEmp);

            oRetorno.itens.forEach(function(oItem) {
                if (opE == 0) {
                    valorEmp[opE] = oItem;
                    opE++;
                } else {
                    oper = 0;
                    for (j = 0; j < opE; j++) {
                        if (valorEmp[j] == oItem) {
                            oper = 1;
                        }
                    }
                    if (oper == 0) {
                        valorEmp[opE] = oItem;
                        opE++;
                    }
                }
            });


        } else if (oRetorno.status == 3) {
            alert(oRetorno.message.urlDecode());
            var url_atual = window.location.href;
            window.location.href = url_atual;

        } else if (oRetorno.status == 4) {
            alert(oRetorno.message.urlDecode());
            //var url_atual = window.location.href;
            //window.location.href = url_atual;

        } else if (oRetorno.status == 5) {
            $op = 0;
            alert(oRetorno.message.urlDecode());
            oRetorno.itens.forEach(function(oItem) {
                var vemp = oItem.emp;
                document.getElementById("tblEmpAn").style.display = "block";
                op = 0;
                if (id > 0) {
                    for (i = 0; i < id; i++) {
                        if (valorC[i] == vemp) {
                            op = 1;
                        }
                    }
                    if (op == 0) {

                        valorC[id] = vemp;
                        id++;
                    }
                } else {
                    valorC[id] = vemp;
                    id++;
                }
                if (op == 0) {

                    var tabela = document.getElementById("tblEmpAn");

                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);

                    celula1.innerHTML = "<div style='text-align:center'>" + vemp + "</div>";
                }

            });

        } else if (oRetorno.status == 6) {
            alert(oRetorno.message.urlDecode());
            //var url_atual = window.location.href;
            //window.location.href = url_atual;

        } else {
            var cont = 1;
            oRetorno.itens.forEach(function(oItem) {

                var identificador = oItem.identificador;
                if (identificador == 1) {
                    if (cont == 1) {
                        alert("Veículos com Abastecimentos já lançados");
                        cont++;
                    }
                    var vplaca = oItem.placa;
                    var data = oItem.data;
                    const myArr = data.split("-");
                    data = myArr[2] + "-" + myArr[1] + "-" + myArr[0]
                    var valor = oItem.valor;
                    var litros = oItem.litros;
                    document.getElementById("veiculosLancados").style.display = "block";
                    document.getElementById("db_opcao").style.display = "none";


                    var tabela = document.getElementById("veiculosLancados");

                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    var celula2 = linha.insertCell(1);
                    var celula3 = linha.insertCell(2);
                    var celula4 = linha.insertCell(3);
                    celula1.innerHTML = "<div style='text-align:center'>" + vplaca + "</div>";
                    celula2.innerHTML = "<div style='text-align:center'>" + data + "</div>";
                    celula3.innerHTML = "<div style='text-align:center'>" + litros + "</div>";
                    celula4.innerHTML = "<div style='text-align:center'>" + valor + "</div>";
                } else if (identificador == 2) {
                    op = 0;
                    if (cont == 1) {
                        alert("Veículos com retiradas sem devolução");
                        cont++;
                    }

                    var vplaca = oItem.placa;
                    var vcodigo = oItem.codigo;
                    document.getElementById("tbl").style.display = "block";
                    document.getElementById("db_opcao").style.display = "none";

                    if (id > 0) {
                        for (i = 0; i < id; i++) {
                            if (valorC[i] == vcodigo) {
                                op = 1;
                            }
                        }
                        if (op == 0) {

                            valorC[id] = vcodigo;
                            id++;
                        }
                    } else {
                        valorC[id] = vcodigo;
                        id++;
                    }

                    if (op == 0) {

                        var tabela = document.getElementById("tbl");
                        var numeroLinhas = tabela.rows.length;
                        var linha = tabela.insertRow(numeroLinhas);
                        var celula1 = linha.insertCell(0);
                        var celula2 = linha.insertCell(1);
                        celula1.innerHTML = "<div style='text-align:center'>" + vcodigo + "<div>";
                        celula2.innerHTML = "<div style='text-align:center'>" + vplaca + "<div>";
                    }


                } else if (identificador == 3) {
                    op = 0;
                    if (cont == 1) {
                        alert("Motoristas não encontrados");
                        cont++;
                    }

                    var vcpf = oItem.cpf;
                    var vmotorista = oItem.motorista;
                    document.getElementById("tblMotorista").style.display = "block";

                    if (id > 0) {
                        for (i = 0; i < id; i++) {
                            if (valorC[i] == vcpf) {
                                op = 1;
                            }
                        }
                        if (op == 0) {

                            valorC[id] = vcpf;
                            id++;
                        }
                    } else {
                        valorC[id] = vcpf;
                        id++;
                    }
                    if (op == 0) {

                        var tabela = document.getElementById("tblMotorista");
                        var numeroLinhas = tabela.rows.length;
                        var linha = tabela.insertRow(numeroLinhas);
                        var celula1 = linha.insertCell(0);
                        var celula2 = linha.insertCell(1);
                        celula1.innerHTML = "<div style='text-align:center'>" + vcpf + "<div>";
                        celula2.innerHTML = "<div style='text-align:center;'>" + vmotorista + "<div>";
                    }
                } else if (identificador == 4) {
                    if (cont == 1) {
                        alert("Veiculos com Baixa");
                        cont++;
                    }

                    var vcodigo = oItem.codigo;
                    var vplaca = oItem.placa;
                    document.getElementById("tblBaixa").style.display = "block";

                    var tabela = document.getElementById("tblBaixa");
                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    var celula2 = linha.insertCell(1);
                    celula1.innerHTML = "<div style='text-align:center'>" + vcodigo + "<div>";
                    celula2.innerHTML = "<div style='text-align:center;'>" + vplaca + "<div>";

                } else if (identificador == 5) {
                    if (cont == 1) {
                        alert("Quilometragem menor do que a última lançada!");
                        cont++;
                    }

                    var vcodigo = oItem.codigo;
                    var vplaca = oItem.placa;
                    var vkm = oItem.km;
                    var vkmfinal = oItem.kmfinal;
                    document.getElementById("tblKm").style.display = "block";

                    var tabela = document.getElementById("tblKm");
                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    var celula2 = linha.insertCell(1);
                    var celula3 = linha.insertCell(2);
                    var celula4 = linha.insertCell(3);
                    celula1.innerHTML = "<div style='text-align:center'>" + vcodigo + "<div>";
                    celula2.innerHTML = "<div style='text-align:center;'>" + vplaca + "<div>";
                    celula3.innerHTML = "<div style='text-align:center;'>" + vkmfinal + "<div>";
                    celula4.innerHTML = "<div style='text-align:center;'>" + vkm + "<div>";

                } else if (identificador == 6) {
                    if (cont == 1) {
                        alert("Veiculos não encontrados");
                        cont++;
                    }


                    var vplaca = oItem.placa;
                    document.getElementById("tblVeic").style.display = "block";

                    var tabela = document.getElementById("tblVeic");
                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    celula1.innerHTML = "<div style='text-align:center;'>" + vplaca + "<div>";


                } else if (identificador == 7) {
                    if (cont == 1) {
                        alert("Combustivel não localizado na base!");
                        cont++;
                    }


                    var vplaca = oItem.placa;
                    var vcom = oItem.comb;
                    document.getElementById("tblComb").style.display = "block";

                    var tabela = document.getElementById("tblComb");
                    var numeroLinhas = tabela.rows.length;
                    var linha = tabela.insertRow(numeroLinhas);
                    var celula1 = linha.insertCell(0);
                    var celula2 = linha.insertCell(1);
                    celula1.innerHTML = "<div style='text-align:center;'>" + vplaca + "<div>";
                    celula2.innerHTML = "<div style='text-align:center;'>" + vcom + "<div>";


                }


            });
        }
    }
</script>