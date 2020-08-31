    <?
    /*
     *     E-cidade Software Publico para Gestao Municipal
     *  Copyright (C) 2013  DBselller Servicos de Informatica
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

    require_once ("libs/db_stdlib.php");
    require_once ("libs/db_conecta.php");
    require_once ("libs/db_sessoes.php");
    require_once ("libs/db_usuariosonline.php");
    require_once ("libs/db_utils.php");
    require_once ("dbforms/db_funcoes.php");
    require_once ("dbforms/db_classesgenericas.php");
    require_once ("classes/db_bens_classe.php");
    require_once ("classes/db_bemfoto_classe.php");
    require_once ("classes/db_bensimoveis_classe.php");
    require_once ("classes/db_bensmater_classe.php");
    require_once ("classes/db_situabens_classe.php");
    require_once ("classes/db_clabens_classe.php");
    require_once ("classes/db_histbem_classe.php");
    require_once ("classes/db_bensplaca_classe.php");
    require_once ("classes/db_benscadlote_classe.php");
    require_once ("classes/db_benslote_classe.php");
    require_once ("classes/db_departdiv_classe.php");
    require_once ("classes/db_histbemdiv_classe.php");
    require_once ("classes/db_bensdiv_classe.php");
    require_once ("classes/db_cfpatriplaca_classe.php");
    require_once ("classes/db_cfpatri_classe.php");
    require_once ("classes/db_bensmarca_classe.php");
    require_once ("classes/db_bensmedida_classe.php");
    require_once ("classes/db_bensmodelo_classe.php");
    require_once ("classes/db_benscedente_classe.php") ;
    require_once ("classes/db_bensdepreciacao_classe.php");
    require_once ("classes/db_conlancambem_classe.php");
    require_once ("classes/db_bensmaterialempempenho_classe.php");
    require_once ("classes/db_bensempnotaitem_classe.php");

    $clbenscedente            = new cl_benscedente();
    $cldepartdiv              = new cl_departdiv;
    $clbens                   = new cl_bens;
    $clbemfoto                = new cl_bemfoto;
    $clhistbem                = new cl_histbem;
    $clclabens                = new cl_clabens;
    $clbensimoveis            = new cl_bensimoveis;
    $clbensmater              = new cl_bensmater;
    $cldb_estrut              = new cl_db_estrut;
    $clsituabens              = new cl_situabens;
    $clbensplaca              = new cl_bensplaca;
    $clbenscadlote            = new cl_benscadlote;
    $clbenslote               = new cl_benslote;
    $clhistbemdiv             = new cl_histbemdiv;
    $clbensdiv                = new cl_bensdiv;
    $clcfpatri                = new cl_cfpatri;
    $clcfpatriplaca           = new cl_cfpatriplaca;
    $clbensmarca              = new cl_bensmarca;
    $clbensmedida             = new cl_bensmedida;
    $clbensmodelo             = new cl_bensmodelo;
    $clbensdepreciacao        = new cl_bensdepreciacao;
    $clconlancambem           = new cl_conlancambem;
    $clbensmaterialempempenho = new cl_bensmaterialempempenho;
    $clbensempnotaitem        = new cl_bensempnotaitem;

    db_postmemory($HTTP_POST_VARS);
    db_postmemory($HTTP_GET_VARS);

    $db_opcao = 3;
    $db_botao = true;
    $sqlerro = false;

    if (isset($excluir)) {

      $erro_msg = "";

      $iPlacaInicial = $t52_placaini;
      $iPlacaFinal   = $t52_placafim;

      if(empty($t52_placaini) || empty($t52_placafim)){
        db_msgbox('Campos Placa inicial e Final devem ser preenchidos');
        db_redireciona("pat1_bensglobal003.php");
      }

      $sWhere  = "where t52_ident BETWEEN '{$iPlacaInicial}' and '$iPlacaFinal'";
      $sWhere .= " and t52_instit = " . db_getsession("DB_instit");

      $sSqlVerificaIntervaloPlaca = "select t52_bem from bens $sWhere";
      $rsVerificaIntervaloPlaca   = $clbensplaca->sql_record($sSqlVerificaIntervaloPlaca);

      if($clbensplaca->numrows > 0 ) {

        db_inicio_transacao();

        for ($Cont=0; $Cont < $iQuant; $Cont++) {

            db_fieldsmemory($rsVerificaIntervaloPlaca,$Cont);

            $clbensplaca->excluir('',"t41_bem = $t52_bem");
            if($clbensplaca->erro_status==0){
              $sqlerro=true;
            }
            $erro_msg = $clbensplaca->erro_msg;

        }

        echo 'Quantidade: '. $iQuant;

        for ($Cont=0; $Cont < $iQuant; $Cont++) {
          echo 'Penultimo for';

            db_fieldsmemory($rsVerificaIntervaloPlaca,$Cont);

            $clbensdepreciacao->excluir('',"t44_bens = $t52_bem");
            if($clbensdepreciacao->erro_status==0){
              $sqlerro=true;
            }


            $clbensempnotaitem->excluir('',"e136_bens = $t52_bem");
            if($clbensempnotaitem->erro_status==0){
              $sqlerro=true;
            }

            $clbenslote->excluir('',"t43_bem = $t52_bem");
            if($clbenslote->erro_status==0){
              $sqlerro=true;
            }


            $clbensmater->excluir('',"t53_codbem = $t52_bem");
            if($clbensmater->erro_status==0){
              $sqlerro=true;
            }

            $clhistbem->excluir('',"t56_codbem = $t52_bem");
            if($clhistbem->erro_status==0){
              $sqlerro=true;
            }

            $clbenscedente->excluir('',"t09_bem = $t52_bem");
            if($clbenscedente->erro_status==0){
              $sqlerro=true;
            }

        }

        for ($Cont=0; $Cont < $iQuant; $Cont++) {
            db_fieldsmemory($rsVerificaIntervaloPlaca,$Cont);

            $clbens->excluir('',"t52_bem = $t52_bem");
            if($clbens->erro_status==0){
              $sqlerro=true;
            }

            $clconlancambem->excluir('',"c110_bem = $t52_bem");
            if($clconlancambem->erro_status==0){
              $sqlerro=true;
            }
        }

          $quantidade = pg_affected_rows($rsVerificaIntervaloPlaca);
        for($cont = 0; $cont < $quantidade; $cont++){
            db_fieldsmemory($rsVerificaIntervaloPlaca,$cont);
            $clbemfoto->excluir('',"t54_numbem = $t52_bem");
            if($clbemfoto->erro_status==0){
              $sqlerro=true;
            }
        }




        db_fim_transacao($sqlerro);

      }else{
        db_msgbox('Intervalo de Placa(s) não existente' );
        db_redireciona("pat1_bensglobal003.php?".$PARTICULARmetros."liberaaba=true&chavepesquisa=$t52_bem");
      }

    }
    ?>
    <html>
    <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    </head>
    <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="js_escondeFieldsetImovel();js_escondeFieldsetMaterial();" >
    <br><br>
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
        <center>
          <?
            include ("forms/db_frm_bensglobalexclusao.php");
          ?>
        </center>
      </td>
      </tr>
    </table>
      <?
        db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
      ?>
    </body>
    </html>

    <?
    if(isset($excluir)){

      if (trim(@$erro_msg)!=""){
           db_msgbox($erro_msg);
      }else{
        db_msgbox('Bens excluidos com sucesso');
      }
      if($sqlerro==true){
        if($clbens->erro_campo!=""){
          echo "<script> document.form1.".$clbens->erro_campo.".style.backgroundColor='#99A9AE';</script>";
          echo "<script> document.form1.".$clbens->erro_campo.".focus();</script>";
        }
      } else {
        db_redireciona("pat1_bensglobal003.php?".$parametros."liberaaba=true&chavepesquisa=$t52_bem");
      }
    }
    ?>
