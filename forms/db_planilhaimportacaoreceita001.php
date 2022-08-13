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
    <fieldset style="margin: 40px auto 10px; width: 400px;">
        <legend>
            <strong>Importa��o de Receitas</strong>
        </legend>
        <table align="center">
            <tr>
                <td nowrap><b>Layout:</b></td>
                <td>
                    <?php
                    $aLayout = array(
                        0 => 'Selecione',
                        2 => 'SAAE',
                    );

                    db_select("layout", $aLayout, true, $db_opcao, "");
                    ?>
                </td>
            </tr>

            <tr>
                <td nowrap><b>Arquivo:</b></td>
                <td><?php db_input("arquivo", 29, $Iarqret, true, "file", 4) ?></td>
            </tr>
        </table>
    </fieldset>
    <center>
        <input name="processar" type="submit" id="processar" value="Processar">
    </center>
</form>

<script type="text/javascript">
    // Fun��o de verifica��o dos campos preenchidos
    function js_verificar() {
        if ($F("layout") == 0) {
            alert("Campo Layout � de preenchimento obrigat�rio.");
            $('layout').focus();
            return false;
        }

        if ($F("arquivo") == "") {
            alert("Campo Arquivo � de preenchimento obrigat�rio.");
            $('arquivo').focus();
            return false;
        }

        return true;
    }
</script>