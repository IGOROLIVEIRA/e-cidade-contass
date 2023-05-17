<?php
require_once 'model/relatorios/Relatorio.php';
include("classes/db_db_docparag_classe.php");

// include("fpdf151/pdf.php");
require("libs/db_utils.php");
$oGet = db_utils::postMemory($_GET);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

?>

<?php
header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=Preco_de_Referencia_PRC_teste.doc");
?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">

    <head>
        <title>Relat�rio</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <style>
        div {
            font-size: 14px;
            text-align: center;
            border: 1px solid black;
        }

        table {
            font-size: 12px;
            border: 1px solid black;
        }
        .headerpref {
            margin-top: 10px;
            font-size: 11px;
        }
        .headertitulo {
            border: 1px solid black;
            border-collapse: collapse;
            background-color: #DCDCDC;
            margin-top: 10px;
            font-size: 11px;
        }
        .headertr {
            margin-top: 10px;
            font-size: 11px;
            width:auto;
        }
    </style>

    <body>
            <table>
                <tr class="headertr">
                <td class="headerpref" width="500px">  <p>PREFEITURA BURITIZEIRO<br>
                PRACA CEL JOSE GERALDO, 1<br>
                BURITIZEIRO - MG<br>
                P3837421011 - CNPJ : 18.279.067/0001-72<br>
                arrecadacao@buritizeiro.mg.gov.br<br>
                arrecadacao@buritizeiro.mg.gov.br</p></td>
                <td class="headertitulo" colspan="3"> SOLICITA��O DE PARECER DE DISPONIBILIDADE FINANCEIRA </td>
                <tr>
            </table>
            <hr  style="border: 6px solid #000000;">
            <div style="text-align: center;">
                <strong>SOLICITA��O DE PARECER DE DISPONIBILIDADE FINANCEIRA</strong>
            </div>
        
            <div>
                <p>De: Pregoeira/ Comiss�o permanente de Licita��o<br>Para: Setor cont�bil</p>
            </div>

            <div>
                <p>Solicito ao departamento cont�bil se h� no or�amento vigente, disponibilidade financeira
que atenda , no valor total estimado de</p>
            </div>

            <div style="text-align: center;">
                <p>BURITIZEIRO,17 DE MAIO DE 2023.</p>
            </div>
            <br>
            <br>
            <br>
            <br>
            <div style="text-align: center;">
             <center>  ------------------------------------  </center> 
                <p>Presidente da CPL</p>
                <p>e/ou Presidente da Comiss�o de Licita��o</p>
            </div>
            <?php


           
                    
                   

            ?>
            </table>
        
    </body>

    </html>
