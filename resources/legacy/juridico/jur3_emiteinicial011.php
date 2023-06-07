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
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/verticalTab.widget.php");

db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);

$veinclu       = false;

$oDaoCertidao = new cl_certid();

$sCampos  = "v13_certid,     ";
$sCampos .= "v50_inicial,    ";
$sCampos .= "v15_codigo,     ";
$sCampos .= "v15_observacao, ";
$sCampos .= "v13_dtemis,     ";
$sCampos .= "v15_parcial     ";

$iCodigoPesquisa = '';
$sTipoPesquisa   = '';

if(isset($cgm) && $cgm!=""){

  $sTipoPesquisa   = 'cgm';
  $iCodigoPesquisa = $cgm;

}else if(isset($inscricao) && $inscricao!="" && $veinclu==false){

  $sTipoPesquisa   = 'inscricao';
  $iCodigoPesquisa = $inscricao;

}else if(isset($matricula) && $matricula!="" && $veinclu==false){

  $sTipoPesquisa   = 'matricula';
  $iCodigoPesquisa = $matricula;
} else if (isset($certidao) && $certidao != ''){

  $sTipoPesquisa   = 'certidao';
  $iCodigoPesquisa = $certidao;
}

if ( !isset($lConsulta) ) {

  $sCampos = " distinct certidao.certidao    as v13_certid,
                        certidao.instituicao as instit,
                        inicial.v50_inicial  as v50_inicial,
                        certidao.tipo_cda    as tipocer,
                        v50_advog||' - '||cgm_advogado.z01_nome as v50_advog,
                        v53_descr,
                        v54_descr,
                        v70_codforo,
                        v52_descr";

  $sSqlCertidao = $oDaoCertidao->sql_queryCertidao($iCodigoPesquisa, $sTipoPesquisa, $sCampos);
  $rsCertidao   = $oDaoCertidao->sql_record($sSqlCertidao);
  if ($oDaoCertidao->numrows == 0) {
    db_msgbox(_M('tributario.juridico.jur3_emiteinicial011.certidao_nao_encontrada'));
  }
}
?>

<html>
<head>
  <?php
    db_app::load("estilos.css, grid.style.css, tab.style.css, scripts.js, strings.js, prototype.js, datagrid.widget.js, DBToogle.widget.js");
  ?>
</head>
<body class="abas">
<?php

if ( $oDaoCertidao->numrows == 1 || isset($lConsulta) ) {

  $sCampos = "certidao.certidao,
              certidao.data_emissao,
              certidao.instituicao,
              certidao.observacao,
              inicial.v50_inicial as inicial,
              certidao.anulado,
              certidao.tipo_cda";
  $sSqlCertidao = $oDaoCertidao->sql_queryCertidao($certidao, 'certidao', $sCampos);
  $rsCertidao   = $oDaoCertidao->sql_record($sSqlCertidao);

  $oDadosCertidao = db_utils::fieldsMemory($rsCertidao, 0, true);
?>
<fieldset>
  <legend>Dados da CDA</legend>

  <table class="linhaZebrada">
    <tr>
      <td><strong>Número da Certidão:</strong></td>
      <td><?php echo $oDadosCertidao->certidao; ?></td>
    </tr>

    <tr>
      <td><strong>Inicial:</strong></td>
      <td><?php echo $oDadosCertidao->inicial; ?></td>
    </tr>

    <tr>
      <td><strong>Data Emissão</strong></td>
      <td><?php echo $oDadosCertidao->data_emissao; ?></td>
    </tr>

    <tr>
      <td><strong>Situação:</strong></td>
      <td>
        <?php
          $sSituacao = 'Ativa';
          if ($oDadosCertidao->anulado == 't') {
            $sSituacao = 'Anulada';
          }
          echo $sSituacao;
        ?>
      </td>
    </tr>
  </table>
</fieldset>

<fieldset>
  <legend>Dados da Inicial</legend>
    <?php

      $oTabDetalhesCertidao = new verticalTab("consultaCda", 250);

      $oTabDetalhesCertidao->add("consultaDebitos",
                                 "Débitos Vinculados",
                                 "jur3_emiteinicialdebitos.php?sTipoConsulta=debitos&certidao=" . $oDadosCertidao->certidao);

      $oTabDetalhesCertidao->add("consultaDebitos",
                                 "Movimentações",
                                 "jur3_emiteinicialdebitos.php?sTipoConsulta=movimentacao&certidao=" . $oDadosCertidao->certidao);

      /**
       * Verifica se possui movimento extrajudicial
       */
      $oCertidao = new Certidao( $oDadosCertidao->certidao );
      if( $oCertidao->hasCobrancaExtrajudicial() ){

        $oTabDetalhesCertidao->add("consultaDebitos",
                                   "Movimentações Extrajudiciais",
                                   "jur3_emiteinicialdebitos.php?sTipoConsulta=movimentacaoextrajudicial&certidao=" . $oDadosCertidao->certidao);
      }

      $oTabDetalhesCertidao->show();
    ?>
</fieldset>
<?php

} else {

   $funcao_js='js_selecionaCertidao|0';
   db_lovrot($sSqlCertidao,15,"()","",$funcao_js,"","NoMe",array());
}
?>
<script type="text/javascript">

  function js_selecionaCertidao(iCodigoCertidao)  {
    window.location = 'jur3_emiteinicial011.php?lConsulta=true&certidao=' + iCodigoCertidao;
  }
</script>

<style type="text/css">

  table.linhaZebrada {
    width: 750px;
  }

  table.linhaZebrada tr td:nth-child(even) {
    background-color: #FFF;
  }

  table.linhaZebrada tr td:nth-child(odd) {
    font-weight: bold;
    width: 150px;
  }
</style>
</body>
</html>