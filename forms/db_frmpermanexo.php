<?
//MODULO: protocolo
$clpermanexo->rotulo->label();
?>


<!-- Novo Fieldset -->

<form name="form1" method="post" action="">
  <center>

    <table align=center style="margin-top: 15px">
      <tr>
        <td>

          <fieldset>
            <legend><b>Permissões dos anexos</b></legend>

            <table border="0">
              <tr>
                <td nowrap title="<?= @$Tp202_sequencial ?>">
                  <b> Sequencial: </b>

                  <input name="oid" type="hidden" value="<?= @$oid ?>">
                </td>
                <td>
                  <?
                  db_input('p202_sequencial', 11, $Ip202_sequencial, true, 'text', 3, "")
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?= @$Tp202_tipo ?>">
                  <b> Tipo: </b>
                </td>
                <td>
                  <?
                  db_input('p202_tipo', 40, $Ip202_tipo, true, 'text', $db_opcao, "")
                  ?>
                </td>
              </tr>

            </table>

            <fieldset>
              <legend><b>Perfis de Acesso</b></legend>

              <table id="tablePerfis" class="DBGrid" style="width: 70%; border: 1px solid #a4a4a4;">
                <tr>
                  <th class="table_header" style="background:#e6e6e6; cursor: pointer; border: 1px solid #a4a4a4;" onclick="marcarTodos();">M</th>
                  <th style="border: 0px solid red;  background:#e6e6e6; border: 1px solid #a4a4a4;">Perfis</th>
                </tr>



                <?php
                if (db_getsession("DB_id_usuario") == "1"  || db_getsession("DB_administrador") == "1") {
                  $instit = db_getsession("DB_instit");
                  $result = db_query("select * from (select distinct u.id_usuario,u.nome,u.login 
                                                   from db_usuarios u
                                                        inner join db_permissao p on p.id_usuario = u.id_usuario 
                                                   where u.usuarioativo = 1 and u.usuext = 2
                                                    and p.id_instit = $instit ) as x
                                                   order by lower(login) ");
                } else {

                  $result = db_query("select * from ( select distinct u.id_usuario,u.nome,u.login,u.usuext 
                         from db_usuarios u
                                                        inner join db_permissao p on p.id_usuario = u.id_usuario
              
                             inner join db_userinst i
                             on i.id_usuario = u.id_usuario								   
                             where u.usuarioativo = 1 
                             and i.id_instit = " . db_getsession("DB_instit") . "
                              and p.id_instit = $instit
                                                                        and u.usuext = 2 ) as x
                             order by lower(login)");
                }


                $numrows = pg_numrows($result);
                for ($i = 0; $i < $numrows; $i++) {
                  echo  "<tr>
                          <td  style='text-align:center; background:#e6e6e6; border: 1px solid #a4a4a4;'>
                              <input id=" . pg_result($result, $i, "id_usuario") . " type='checkbox' class='marca_itens' name='aItonsMarcados[]' value='" . pg_result($result, $i, "id_usuario") . "'>
                        </td>

                        <td style='text-align:center; background:#ffffff; border: 1px solid #a4a4a4;'>" .
                    pg_result($result, $i, "nome") . "
                        </td>

                        
                      </tr>";
                }


                ?>

              </table>

            </fieldset>

            <div align="center">
              <input style="margin-top: 10px;" align="center" name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
              <input align="center" name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
            </div>
          </fieldset>



        </td>
      </tr>
    </table>

  </center>

</form>
<script>
  marcarTodosPerfis = false;

  function marcarTodos() {
    qntdperfis = document.getElementsByClassName("marca_itens").length;
    perfis = document.getElementsByClassName("marca_itens");

    if (marcarTodosPerfis == false) {
      for (let i = 0; i < qntdperfis; i++) {
        perfis[i].checked = true;
      }

      marcarTodosPerfis = true;
    } else {
      for (let i = 0; i < qntdperfis; i++) {
        perfis[i].checked = false;
      }

      marcarTodosPerfis = false;
    }




  }

  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo', 'db_iframe_permanexo', 'func_permanexo.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_permanexo.hide();
    <?
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
    }
    ?>
  }
</script>