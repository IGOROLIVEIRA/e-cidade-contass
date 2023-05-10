<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once("libs/db_stdlib.php");
require_once("libs/db_stdlibwebseller.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");

$clacervo           = new cl_acervo;
$clautoracervo      = new cl_autoracervo;
$cllocalexemplar    = new cl_localexemplar;
$cldb_depart        = new cl_db_depart;
$clemprestimoacervo = new cl_emprestimoacervo;
$clexemplar         = new cl_exemplar;

$sql    = "SELECT bi17_codigo, bi17_nome FROM biblioteca WHERE bi17_coddepto = " . db_getsession("DB_coddepto");
$result = db_query( $sql );
$linhas = pg_num_rows( $result );

if( $linhas != 0 ) {
  db_fieldsmemory( $result, 0 );
}

if( isset( $chavepesquisa ) ) {

  $result = $clacervo->sql_record( $clacervo->sql_query( "", "*", "", "bi06_seq = {$chavepesquisa}" ) );
  db_fieldsmemory( $result, 0 );
}
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?php
  db_app::load("scripts.js, prototype.js, strings.js");
  db_app::load("estilos.css");
  ?>
</head>
<body class="body-default">

  <?php
  MsgAviso(db_getsession("DB_coddepto"),"biblioteca",""," bi17_coddepto = ".db_getsession("DB_coddepto")."");
  ?>

  <center>
  <fieldset style="width:95%;margin-top:25px">
    <legend class="bold">Consulta de Acervo</legend>
    <table valign="top" marginwidth="0" width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" align="center" valign="top">
          <table bgcolor="#f3f3f3" valign="top" marginwidth="0" width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td colspan="2" align="center" bgcolor="#999999">
                <label class="bold">Dados do Acervo:</label>
              </td>
            </tr>
            <tr>
              <td width="35%">
                <label class="bold">Código do Acervo:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi06_seq ) ) {
                  echo $bi06_seq;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Biblioteca:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi17_codigo ) && isset( $bi17_nome ) ) {
                  echo "{$bi17_codigo} - {$bi17_nome}";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Data de Registro:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi06_dataregistro ) ) {
                  echo db_formatar( $bi06_dataregistro, 'd' );
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Ano de Edição:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi06_anoedicao ) ) {
                  echo $bi06_anoedicao;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Edição:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi06_edicao ) ) {
                  echo $bi06_edicao;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Título:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi06_titulo ) ) {
                  echo $bi06_titulo;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Clas. CDD:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi06_classcdd ) ) {
                  echo $bi06_classcdd;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">ISBN:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi06_isbn ) ) {
                  echo $bi06_isbn;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Volume:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi06_volume ) ) {
                  echo $bi06_volume;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Tipo Item:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi05_nome ) ) {
                  echo $bi05_nome;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Editora:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi02_nome ) ) {
                  echo $bi02_nome;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Clas. Literária:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi03_classificacao ) ) {
                  echo $bi03_classificacao;
                }
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <label class="bold">Coleção:</label>
              </td>
              <td>
                &nbsp;
                <?php
                if( isset( $bi29_nome ) ) {
                  echo $bi29_nome;
                }
                ?>
              </td>
            </tr>
          </table>
        </td>
        <td width="40%" align="center" valign="top">
          <table bgcolor="#f3f3f3" valign="top" marginwidth="0" width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" bgcolor="#999999">
                <label class="bold">Autores:</label>
              </td>
            </tr>
            <?php
            if( isset( $bi06_seq ) && !empty( $bi06_seq ) ) {

              //mostra autores do acervo
              $sSql   = $clautoracervo->sql_query( "", "*", "", "bi21_acervo = {$bi06_seq}");
              $result = $clautoracervo->sql_record( $sSql );

              for( $x = 0; $x < $clautoracervo->numrows; $x++ ) {

                db_fieldsmemory( $result, $x );
              ?>
                <tr>
                  <td>&nbsp;&nbsp;<?=$bi01_nome?></td>
                </tr>
              <?php
              }
            }
            ?>
          </table>
          <table bgcolor="#f3f3f3" valign="top" marginwidth="0" width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" bgcolor="#999999">
                <label class="bold">Exemplares:</label>
              </td>
            </tr>
            <?php

            if( isset( $bi06_seq ) && !empty( $bi06_seq ) ) {

              //mostra exemplares do acervo
              $sSql    = $clexemplar->sql_query( "", "*", "bi23_codigo", "bi23_acervo = {$bi06_seq}" );
              $result  = $clexemplar->sql_record( $sSql );
              $iLinhas = $clexemplar->numrows;

              for( $x = 0; $x < $iLinhas; $x++ ) {

                db_fieldsmemory( $result, $x );

                $sCamposLocalExemplar = "bi20_sequencia, bi27_letra, bi09_nome";
                $sWhereLocalExemplar  = " bi27_exemplar = {$bi23_codigo}";
                $sSqlLocalExemplar    = $cllocalexemplar->sql_query( "", $sCamposLocalExemplar, "", $sWhereLocalExemplar );
                $result0              = $cllocalexemplar->sql_record( $sSqlLocalExemplar );

                if( $cllocalexemplar->numrows > 0 ) {

                  db_fieldsmemory( $result0, 0 );

                  $sequencia  = $bi23_situacao == " N" ? "" : "&nbsp;&nbsp;Ordenação: ";
                  $sequencia .= $bi20_sequencia != "" ? $bi20_sequencia : "";
                  $sequencia .= ( $bi27_letra != "" ? "-" . $bi27_letra : "" );
                } else {
                  $sequencia = "";
                }
                ?>
                <tr>
                  <td>
                  &nbsp;&nbsp;<?=$bi23_codigo?> - <?=$bi23_codbarras?>
                  &nbsp;&nbsp;Adquirido em <?=db_formatar( $bi23_dataaquisicao, 'd' )?>
                  <br>
                  &nbsp;&nbsp;Situação: <?=$bi23_situacao == "S" ? "ATIVO" : "INATIVO" ?> &nbsp;&nbsp; Aquisição: <?=$bi04_forma?>
                  <br>
                  &nbsp;&nbsp;Empréstimo:
                  <?php
                  $sql1    = "SELECT bi23_codigo ";
                  $sql1   .= "  FROM exemplar ";
                  $sql1   .= " WHERE not exists(select * ";
                  $sql1   .= "                    from emprestimoacervo ";
                  $sql1   .= "                   where emprestimoacervo.bi19_exemplar = exemplar.bi23_codigo ";
                  $sql1   .= "                     and not exists(select * ";
                  $sql1   .= "                                      from devolucaoacervo ";
                  $sql1   .= "                                     where devolucaoacervo.bi21_codigo = emprestimoacervo.bi19_codigo ";
                  $sql1   .= "                                   ) ";
                  $sql1   .= "                 ) ";
                  $sql1   .= "  AND bi23_codigo = {$bi23_codigo}";
                  $result1 = db_query( $sql1 );
                  $linhas1 = pg_num_rows( $result1 );

                  if( $linhas1 == 0 || $bi23_situacao == 'N' ) {
                    echo "Indisponível";
                  } else {

                    ?>
                    <a href="#"
                       onclick="location.href='bib1_emprestimo001.php?bi23_codigo=<?=$bi23_codigo?>&bi06_titulo=<?=$bi06_titulo?>&assunto'"
                       title="Realizar Empréstimo">Disponível</a>
                    <?php
                  }
                  ?>
                  <br>
                  &nbsp;&nbsp;Localização:
                  <?=$bi09_nome?><br><?=$sequencia?>
                 </td>
               </tr>
              <?php
              }
            }
            ?>
          </table>
          <table bgcolor="#f3f3f3" valign="top" marginwidth="0" width="100%" border="1" cellspacing="0" cellpadding="0">
            <tr>
              <td align="center" bgcolor="#999999">
                <label class="bold">Empréstimos Abertos:</label>
              </td>
            </tr>
            <?php
            if( !isset( $chavepesquisa ) ) {
              $bi06_seq = 0;
            }

            $sql    = "SELECT bi23_codigo, ";
            $sql   .= "       bi06_titulo, ";
            $sql   .= "       bi18_retirada, ";
            $sql   .= "       bi18_devolucao ";
            $sql   .= "  FROM emprestimoacervo ";
            $sql   .= "       inner join emprestimo      on bi18_codigo = bi19_emprestimo ";
            $sql   .= "       inner join carteira        on bi16_codigo = bi18_carteira ";
            $sql   .= "       inner join leitor          on bi10_codigo = bi16_leitor ";
            $sql   .= "       inner join leitorcategoria on bi07_codigo = bi16_leitorcategoria ";
            $sql   .= "       inner join biblioteca      on bi17_codigo = bi07_biblioteca ";
            $sql   .= "       inner join exemplar        on bi23_codigo = bi19_exemplar ";
            $sql   .= "       inner join acervo          on bi06_seq    = bi23_acervo ";
            $sql   .= " WHERE bi06_seq        = {$bi06_seq} ";
            $sql   .= "   AND bi07_biblioteca = {$bi17_codigo} ";
            $sql   .= "   AND not exists(select * ";
            $sql   .= "                    from devolucaoacervo ";
            $sql   .= "                   where devolucaoacervo.bi21_codigo = emprestimoacervo.bi19_codigo ";
            $sql   .= "                 )";
            $result = db_query( $sql );
            $linhas = pg_num_rows( $result );

            if( $result && $linhas > 0 ) {

              for( $x = 0; $x < $linhas; $x++ ) {

                db_fieldsmemory( $result, $x );
                ?>
                <tr>
                  <td>
                    &nbsp;&nbsp;Retirada:<?=db_formatar( $bi18_retirada, 'd' )?> - Devolução:<?=db_formatar( $bi18_devolucao, 'd' )?>
                  </td>
                </tr>
                <?php
              }
            } else {
              echo "<tr><td align='center'>Nenhum empréstimo pendente.</td></tr>";
            }
            ?>
          </table>
        </td>
      </tr>
    </table>
  </fieldset>
  <input type="button" name="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
  </center>
  <?php
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
</body>
</html>
<script>
function js_pesquisa() {
  js_OpenJanelaIframe(
                       '',
                       'db_iframe_acervo',
                       'func_acervo.php?funcao_js=parent.js_preenchepesquisa|bi06_seq',
                       'Pesquisa',
                       true
                     );
}

function js_preenchepesquisa( chave ) {

  db_iframe_acervo.hide();
  <?php
  echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  ?>
}
</script>
<?php
if( !isset( $chavepesquisa ) ) {
  echo "<script>js_pesquisa();</script>";
}