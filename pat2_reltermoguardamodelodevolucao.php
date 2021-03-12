<?php

include("vendor/mpdf/mpdf/mpdf.php");
require("libs/db_utils.php");
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("dbforms/db_funcoes.php");
require_once("classes/db_bensguardaitemdev_classe.php");

$oGet = db_utils::postMemory($_GET);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

$cl_bensguardaitemdev = new cl_bensguardaitemdev;

$sCampos = "t22_bem, t52_ident, t52_descr, t70_descr as situacao, t22_obs, t21_representante, t21_cpf, ";
$sCampos .= "t21_data, z01_nome as responsavel, z01_numcgm as numcgm, t20_descr as tipoguarda, t23_obs";
$sSqlBens = $cl_bensguardaitemdev->sql_query_relatorio('', $sCampos, '', 't22_bensguarda = '. $oGet->iTermo);

$rsBens = $cl_bensguardaitemdev->sql_record($sSqlBens);

$mPDF = new mpdf('', 'A4', 0, '', 10, 10, 30, 10, 5, 5);

$header = <<<HEADER
<header>
  <div style="width: 100%; font-family:sans-serif; padding-top: 18px;">
    <div style="text-align: center; width: 100%; font-size: 16pt; border-top: 1px solid #000; border-bottom: 1px solid #000;">
      <span style="font-weight: bold;">Termo Devolução de Guarda - Nº $oGet->iTermo </span><br>
    </div>
  </div>
</header>
HEADER;

$sSqlInstit = "SELECT munic from db_config where codigo = " . db_getsession('DB_instit');
$rsInstit = db_query($sSqlInstit);
$nomeMunicipio = ucwords(strtolower(db_utils::fieldsMemory($rsInstit, 0)->munic));

/**
 * Busca os dados da guarda
 *  */

$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);

ob_start();

?>
<html>

<head>
    <style type="text/css">
        .grid-container .table__dados a {
            color: inherit;
        }

        .grid-container .table__dados .th__cabecalho {
            background-color: #d8d8d8;
            border: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 10pt;
            font-weight: bold;
            padding: 0px 3px 0px 3px;
            text-align: center;
        }

        .grid-container .table__dados .td__conteudo {
            background-color: #fff;
            border: 1px SOLID #000;
            color: #000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 8pt;
        }

        .div__assinaturas{
            text-align: center;
            margin: 50px auto;
        }

        .div__detentor-guarda{
            margin-top: 10px;
            border-top: 1px solid #000;
            margin: 0 auto;
            width: 50%;
            z-index: 2;
        }

        .div__responsavel-departamento{
            border-top: 1px solid #000;
            margin: 50px auto 0px auto;
            width: 50%;
        }

        ol {
            counter-reset: list;
            margin: 0;
        }

        ul {
            list-style: none;
            padding-left: 0px;
        }

        .table__dados{
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="grid-container" dir="ltr">
        <div class="div__atestado">
            <p style="text-align: center;">Atestamos que os bens relacionados abaixo foram desenvolvidos em <?=date('d/m/Y', db_getsession('DB_datausu'));?>,
            nas seguintes condições:
            </p>
            <ul>
                <li>(__) Em perfeito estado</li>
                <li>(__) Apresentando defeito</li>
                <li>(__) Faltando peças/acessórios</li>
                <li>(__) Outros:
                    <hr>
                </li>
            </ul>
            <p><b>Observações: </b></p>
            <?php
                $aBens = db_utils::fieldsMemory($rsBens, 0);

                for($count=0;$count< pg_numrows($rsBens);$count++){
                    $oItemPosicao = db_utils::fieldsMemory($rsBens, $count);
            ?>
                    <p style="font-size: 10px"><?= $oItemPosicao->t23_obs ? $count+1 .' - '.$oItemPosicao->t23_obs : ' - ';?></p>
            <?php
                }
            ?>
        </div>
        <br>
        <table class="table__dados" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="th__cabecalho" style="width: 15px">Código</th>
                    <th class="th__cabecalho" style="width: 20px">Placa</th>
                    <th class="th__cabecalho" style="width: 280px">Descrição</th>
                    <th class="th__cabecalho" style="width: 15px">Situação</th>
                    <th class="th__cabecalho" style="width: 280px">Observações</th>
                </tr>
            </thead>

            <tbody>
                <h3>Listagem dos Bens</h3>
                <?php  
                for($count = 0; $count < $cl_bensguardaitemdev->numrows; $count++) {
                    $oItem = db_utils::fieldsMemory($rsBens, $count);
                ?> 
                    <tr>
                        <td class='td__conteudo' style='width: 15px'><?=$oItem->t22_bem?></td>
                        <td class='td__conteudo' style='width: 20px'><?=$oItem->t52_ident?></td>
                        <td class='td__conteudo' style='width: 280px'><?=$oItem->t52_descr?></td>
                        <td class='td__conteudo' style='width: 15px'><?=$oItem->situacao?></td>
                        <td class='td__conteudo' style='width: 280px'><?=$oItem->t22_obs ? $oItem->t22_obs : ' - '?></td>
                    </tr>
                <?php
                }
                ?>
                <tr>
                    <td class="td__conteudo" style="text-align: left; padding: 5px;" colspan="5">
                        Total de Registros: <?=pg_numrows($rsBens);?>
                    </td>
                </tr>
            </tbody>

            <?php
                $sSqlInstit = "
                    SELECT nomeinst, cgc, nomeresponsavel, fonedepto, emaildepto 
                        FROM db_config 
                        INNER JOIN db_depart ON instit = codigo
                    where coddepto = " . db_getsession('DB_coddepto');
                $rsInstit = db_query($sSqlInstit);
                $oInstituicao = db_utils::fieldsMemory($rsInstit, 0);
                $nomeInstit = ucwords(strtolower($oInstituicao->nomeinst));
            ?>
            <br/>
        </table>
        <br/>
        
        <div class="div__assinaturas">
            <div class="div__detentor-guarda">
                <p>Assinatura do responsável pelo recebimento</p>
            </div>
        </div>

        <div style="text-align: right;">
                <?php
                    $dataUsu = date('d-m-Y', db_getsession('DB_datausu'));
                    $aData = explode('-', $dataUsu);
                    $aMeses = array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
                    "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
                ?>
            <p><?=$nomeMunicipio;?>, <?=$aData[0]?> de <?=$aMeses[intval($aData[1]) - 1]?> de <?=$aData[2]?>.</p>
        </div>

    </div>
</body>

</html>
<?php

$html = ob_get_contents();
echo $html;
$mPDF->WriteHTML(utf8_encode($html));
ob_end_clean();
$mPDF->Output();

?>

