<?php

include("vendor/mpdf/mpdf/mpdf.php");
require("libs/db_utils.php");
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("dbforms/db_funcoes.php");
require_once("classes/db_bensguardaitem_classe.php");

$oGet = db_utils::postMemory($_GET);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

$cl_bensguardaitem = new cl_bensguardaitem;

$sCampos = "t22_bem, t52_ident, t52_descr, t70_descr as situacao, t22_obs, t21_representante, t21_cpf, ";
$sCampos .= "t21_data, db_depart.nomeresponsavel as responsavel, a.z01_numcgm as numcgm, a.z01_nome AS nomecgm, t20_descr as tipoguarda, t21_obs";
$sSqlBens = $cl_bensguardaitem->sql_query_relatorio('', $sCampos, '', 't22_bensguarda = '. $oGet->iTermo);
$rsBens = $cl_bensguardaitem->sql_record($sSqlBens);

$mPDF = new mpdf('', 'A4', 0, '', 10, 10, 30, 10, 5, 5);

$header = <<<HEADER
<header>
  <div style="width: 100%; font-family:sans-serif; padding-top: 18px;">
    <div style="text-align: center; width: 100%; font-size: 16pt;border-top: 1px solid #000; border-bottom: 1px solid #000;">
      <span style="font-weight: bold;">Termo de Guarda - Nº $oGet->iTermo </span><br>
    </div>
  </div>
</header>
HEADER;

$sSqlInstit = "SELECT munic from db_config where codigo = " . db_getsession('DB_instit');
$rsInstit = db_query($sSqlInstit);
$nomeInstit = ucwords(strtolower(db_utils::fieldsMemory($rsInstit, 0)->munic));

/**
 * Busca os dados da guarda
 *  */

$sSqlGuarda = "SELECT min(t22_dtini) as dtini, max(t22_dtfim) as dtfim
        FROM bensguardaitem
        INNER JOIN bens ON t52_bem = t22_bem
        INNER JOIN histbem ON t56_histbem =
            (SELECT max(t56_histbem)
            FROM histbem
            WHERE t56_codbem = t52_bem)
        WHERE t22_bensguarda = " . $oGet->iTermo;
$rsGuarda = db_query($sSqlGuarda);

$footer = <<<FOOTER
<div>
    <div style="text-align: center; font-size: 13px; width:100%; height: 10px;">
        $nomeInstit, 02 de Março de 2021.
    </div>
</div>

FOOTER;


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();

$oItemPosicao1 = db_utils::fieldsMemory($rsBens, 0);

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
            padding: 0px 3px 0px 3px;
            text-align: center;
        }

        h3{
            text-align: center;
            background-color: rgb(210, 210, 210);
        }

        p{
            margin: 0px;
        }

        .div__recebimento{
            text-align: justify;
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
        
    </style>
</head>

<body>
    <div>
        <div class="div__dadosorgao">
            <h3>Dados do Órgão</h3>
            <p><b>Data de Emissão:</b> <span><?=db_formatar($oItemPosicao1->t21_data, 'd');?></span></p>
            <p><b>Responsável pelo Empréstimo:</b> <span><?=$oItemPosicao1->responsavel;?></span></p>
            <p><b>Tipo de Guarda:</b> <span><?=$oItemPosicao1->tipoguarda;?></span></p>
        </div>
        
        <div class="div__guarda-detentor">
            <h3>Dados do Detentor da Guarda</h3>
            <p><b>CGM:</b> <span><?=$oItemPosicao1->numcgm;?> - <?=$oItemPosicao1->nomecgm?></span></p>
            <p><b>Representante:</b> <span><?=$oItemPosicao1->t21_representante ? $oItemPosicao1->t21_representante : ' - ';?></span></p>
            <p><b>CPF Representante:</b> <span><?=$oItemPosicao1->t21_cpf ? db_formatar($oItemPosicao1->t21_cpf, 'cpf') : ' - ';?></span></p>
        </div>

        <div class="div__guarda">
            <h3>Dados da Guarda</h3>
            <p><b>Data de Retirada:</b> <span><?=db_formatar(db_utils::fieldsMemory($rsGuarda, 0)->dtini, 'd');?></span></p>
            <p><b>Previsão de Devolução:</b> <span><?=db_formatar(db_utils::fieldsMemory($rsGuarda, 0)->dtfim, 'd');?></span></p>
            <p><b>Observações:</b> <span><?=$oItemPosicao1->t21_obs;?></span></p>
        </div>
        <br/>

    </div>
    <div class="grid-container" dir="ltr">
        <table class="table__dados" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="th__cabecalho" style="width: 15px">Código</th>
                    <th class="th__cabecalho" style="width: 20px">Placa</th>
                    <th class="th__cabecalho" style="width: 280px">Descrição</th>
                    <th class="th__cabecalho" style="width: 15px">Situação</th>
                    <th class="th__cabecalho" style="width: 280px">Observação</th>
                </tr>
            </thead>

            <tbody>
                <h3>Listagem dos Bens</h3>
                <?php  
                for($count = 0; $count < $cl_bensguardaitem->numrows; $count++) {
                    $oItem = db_utils::fieldsMemory($rsBens, $count);
                ?> 
                    <tr>
                        <td class='td__conteudo' style='width: 15px'><?=$oItem->t22_bem?></td>
                        <td class='td__conteudo' style='width: 20px'><?=$oItem->t52_ident?></td>
                        <td class='td__conteudo' style='width: 280px'><?=$oItem->t52_descr?></td>
                        <td class='td__conteudo' style='width: 15px'><?=$oItem->situacao?></td>
                        <td class='td__conteudo' style='width: 280px'><?=$oItem->t22_obs ? $oItem->t22_obs : ' - ' ?></td>
                    </tr>
                <?php
                }
                ?>
                
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
        <div class="div__recebimento">
            <p>Recebi da <?=$nomeInstit?>, CNPJ nº <?= db_formatar($oInstituicao->cgc, 'cnpj');?> a título de empréstimo, para 
            meu uso exclusivo, conforme determinado na lei, os equipamentos especificados neste termo de responsabilidade,
            comprometendo-me a mantê-los em perfeito estado de conservação, ficando ciente de que:
            </p>
            <p>
            <b>1.</b> Se o equipamento for danificado ou inutilizado por emprego inadequado, mau uso, negligência ou extravio,
            a empresa me fornecerá novo equipamento e cobrará o valor de um equipamento da mesma marca ou equivalente ao da praça,
            no prazo de 30 dias a contar da data de evolução.
            </p>
            <p>
            <b>2.</b> Em caso de dano, inutilização ou extravio do equipamento deverei comunicar imediatamente ao setor competente. 
            </p>
        </div>

        <div class="div__assinaturas">
            <div class="div__detentor-guarda">
                <p>Detentor da Guarda</p>
            </div>
            <div class="div__responsavel-departamento">
                <?php if($oInstituicao->nomeresponsavel):?>
                    <span><?=$oInstituicao->nomeresponsavel?></span>
                    <span><?=$oInstituicao->fonedepto?></span>
                    <span><?=$oInstituicao->emaildepto?></span>
                <?else:?>
                    <span>Responsável</span>
                <?php endif;?>
            </div>
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

