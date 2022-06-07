<?php

require_once("classes/db_acordo_classe.php");
require_once("model/Acordo.model.php");
require_once("model/AcordoItem.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/MaterialCompras.model.php");

echo <<<HTML
    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">
    <head>
        <title>Extrato de Contrato (Novo)</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <style>
        #info{
            font-weight: bold;
        }
        .topo{
            background-color: #CDC9C9;
            font-weight: bold;
            text-align: center;
        }
        .infoitem{
            text-transform:uppercase;
        }
    </style>
    </head>
    <body>
    <center>
    <h1 style="text-align: center">Extrato de Contrato</h1>
    <br>
        <div>
            <table>
                <tr>
                    <td id="info">Nº Contrato: </td>
                    <td colspan="400">448</td>
                    <td id="info">Departamento: </td>
                    <td>Prefeitura Contass</td>
                </tr>
                <tr>
                    <td id="info">Data de Assinatura: </td>
                    <td colspan="400">01/01/2022</td>
                    <td id="info">Contratado: </td>
                    <td>Daniel Gustavo de Oliveira</td>
                </tr>
                <tr>
                    <td id="info">Vigência: </td>
                    <td colspan="5">01/01/2022</td>
                    <td colspan="5"> até </td>
                    <td>31/01/2023</td>
                </tr>
                <tr>
                    <td id="info">Valor do Contrato: </td>
                    <td>R$ 3.000,00</td>
                </tr>
                <tr>
                    <td id="info">Objeto: </td>
                    <td>TESTE</td>
                </tr>
            </table>
        </div>
    <br>
    <br>
    <br>
        <div>
            <table border="1">
                <tr class="topo">
                    <th>Ordem</th>
                    <th>Item</th>
                    <th>Descrição</th>
                    <th>Unidade</th>
                    <th>Quantidade</th>
                    <th>Valor Unitário</th>
                    <th>Valor Total</th>
                </tr>
                <tr class="infoitem">
                    <td>1</td>
                    <td>1021454</td>
                    <td>SERVICO PRESTADO PARA ATENDER AO MUNICIPIO DURANTE AS ATIVIDADES FESTIVAS</td>
                    <td>servico</td>
                    <td>100</td>
                    <td>R$ 200,00 </td>
                    <td>R$ 20.000,00</td>
                </tr>
            </table>
        </div>
        </center
    </body>
    </html>

HTML;
