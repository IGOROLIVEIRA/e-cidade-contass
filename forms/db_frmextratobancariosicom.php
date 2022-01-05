<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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
$extratoBancario = new ExtratoBancarioSicom(db_getsession("DB_anousu"), db_getsession("DB_instit"));

// Carrega os scripts
db_app::load("scripts.js");
db_app::load("prototype.js");
db_app::load("datagrid.widget.js");
db_app::load("strings.js");
db_app::load("grid.style.css");
db_app::load("estilos.css");
db_app::load("AjaxRequest.js");
db_app::load("widgets/windowAux.widget.js");
?>
<style type="text/css">
    #tabela-lancamentos {
        border-collapse: collapse;
        width: 98%;
        margin: 10px;
        border: 1px solid black;
    }
    #tabela-lancamentos tr {
        background-color: #fff;
    }
    #tabela-lancamentos td, #tabela-lancamentos th {
        padding: 5px;
        border: 1px solid #ddd;
}

#tabela-lancamentos tr:hover {background-color: #6a6a6a;}

#tabela-lancamentos th {

  text-align: left;
  background-color: #D3D3D3;
  font-weight: bold;
    color: #000;
}
    .pesquisaConta {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: none;
        overflow-y:auto;
        overflow-x: hidden;
        position: absolute;
        max-height: 200px;
    }

    .pesquisaConta li {
        border: 1px solid #ddd;
        margin-top: -1px;  /*Prevent double borders */
        background-color: #f6f6f6;
        padding: 10px;
        text-decoration: none;
        color: black;
        display: block
    }

    .pesquisaConta li:hover:not(.header) {
        background-color: #eee;
    }

    .codtipo {
        display: none;
    }

    .ctapag {
        width: 100%;
    }
</style>

<br/><br/>
<form name="form1" method="post" action="">
    <center>
        <table  border =0 style='width:90%'>
            <tr>
                <td>
                    <fieldset>
                        <legend><b>Extratos Bancários Sicom</b></legend>

                        <table width="100%">
                            <tr>
                            <div class='grid_planilha' id='grid_planilha' style='margin: 0 auto; width: 100%; text-align: center'>
                                <table id='tabela-lancamentos'>
                                    <thead>
                                        <tr>
                                            <th>Código CTB</th>
                                            <th>Descrição</th>
                                            <th>Banco</th>
                                            <th>Agência</th>
                                            <th>Conta</th>
                                            <th>Tipo</th>
                                            <th>Ativa</th>
                                            <th>Anexo</th>
                                            <th>Situação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($extratoBancario->getContasHabilitadas() as $conta) {
                                                echo "<tr>";
                                                echo "<td>{$conta->reduzido}</td>";
                                                echo "<td>{$conta->descricao}</td>";
                                                echo "<td>{$conta->banco}</td>";
                                                echo "<td>{$conta->agencia}-{$conta->digito_agencia}</td>";
                                                echo "<td>{$conta->conta}-{$conta->digito_conta}</td>";
                                                echo "<td>{$conta->tipo}</td>";
                                                echo "<td>{$conta->ativa}</td>";
                                                echo "<td>";
                                                echo "<input type='file' name='arquivo-{$conta->reduzido}'/>&nbsp&nbsp"; 
                                                echo "<input type='button' value='Enviar' onclick=\"micoxUpload(this.form,'upload_extrato_bancario_sicom.php?cnpj={$conta->cnpj}&orgao={$conta->orgao}&reduzido={$conta->reduzido}&ano=" . db_getsession("DB_anousu") . "','retorno-{$conta->reduzido}','Carregando...','Erro ao carregar')\" />";  
                                                echo "</td>";
                                                echo "<td id='retorno-{$conta->reduzido}'><span class='{$conta->situacao}'>{$conta->situacao}</span></td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>
    </form>
</center>
<div style='position:absolute;top: 200px; left:15px;
            border:1px solid black;
            width:300px;
            text-align: left;
            padding:3px;
            background-color: #FFFFCC;
            display:none;' id='ajudaItem'>
</div>