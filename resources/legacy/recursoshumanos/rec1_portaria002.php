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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_portaria_classe.php");
include("classes/db_assenta_classe.php");
include("classes/db_rhpessoal_classe.php");
include("classes/db_portariaassenta_classe.php");
include("classes/db_portariatipo_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clportaria        = new cl_portaria;
$classenta         = new cl_assenta;
$clrhpessoal       = new cl_rhpessoal;
$clportariaassenta = new cl_portariaassenta;
$clportariatipo    = new cl_portariatipo;

$lExibirNumeracaoPortaria = true;
$db_opcao_numero = 3;

$db_opcao = 22;
$db_botao = false;
$sqlerro  = false;
$erro_msg = "";

if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clportaria->alterar($h31_sequencial);

  if ($clportaria->erro_status == "0"){
       $sqlerro  = true;
       $erro_msg = $clportaria->erro_msg;
  }

  if ($sqlerro == false) {

    $oDaoAssentaAttr = new cl_assentadb_cadattdinamicovalorgrupo();
    $oDaoAssentaAttr->excluir(null, null, "h80_assenta = $h16_codigo" );
    $oDaoAssentaAttr->h80_assenta                     = $h16_codigo;
    $oDaoAssentaAttr->h80_db_cadattdinamicovalorgrupo = $h80_db_cadattdinamicovalorgrupo;
    $oDaoAssentaAttr->incluir($h16_codigo, $h80_db_cadattdinamicovalorgrupo);
      
    $rsPortariaTipo = db_query($clportariatipo->sql_query_file($h31_portariatipo,"h30_tipoasse",null));
    $oPortariaTipo  = db_utils::fieldsMemory($rsPortariaTipo,0);

    $oAssentamento = new Assentamento();
    $oAssentamento->setCodigo($h16_codigo);
    $oAssentamento->setMatricula($h16_regist);
    $oAssentamento->setTipoAssentamento($oPortariaTipo->h30_tipoasse);
    $oAssentamento->setDataConcessao(new DBDate($h16_dtconc));
    $oAssentamento->setHistorico($h16_histor);
    $oAssentamento->setCodigoPortaria($h31_numero);
    $oAssentamento->setDescricaoAto($h16_atofic);
    $oAssentamento->setDias($h16_quant);
    $oAssentamento->setPercentual("0");
    $oAssentamento->setDataTermino(new DBDate($h16_dtterm));
    $oAssentamento->setSegundoHistorico('');
    $oAssentamento->setLoginUsuario(db_getsession("DB_id_usuario"));
    $oAssentamento->setDataLancamento(date("Y-m-d",db_getsession("DB_datausu")));
    $oAssentamento->setConvertido("false");
    $oAssentamento->setAnoPortaria($h31_anousu);

    AssentamentoRepository::persist($oAssentamento);



    if ($classenta->erro_status == "0"){
      $sqlerro  = true;
      $erro_msg = $classenta->erro_msg;
    }
  }

  if(!$sqlerro) {

    if(!empty($rh161_regist)) {

      $oAssentamentoSubstituicao = new AssentamentoSubstituicao($oAssentamento->getCodigo());
      $oAssentamentoSubstituicao->setSubstituido(ServidorRepository::getInstanciaByCodigo($rh161_regist, DBPessoal::getAnoFolha(), DBPessoal::getMesFolha()));
      
      $mResponse = $oAssentamentoSubstituicao->persist();

      if($mResponse !== true) {
        $sqlerro  = true;
        $erro_msg = $mResponse;
      }
    }
  }

  db_fim_transacao($sqlerro);

  if (!$sqlerro) {
    db_msgbox("Altera��o Realizada com Sucesso.");
    db_redireciona("");
  }

  
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clportaria->sql_record($clportaria->sql_query($chavepesquisa)); 
   db_fieldsmemory($result,0);
      $res_portariaassenta = $clportariaassenta->sql_record($clportariaassenta->sql_query_file(null,"h33_assenta",null,"h33_portaria = {$h31_sequencial}"));
      db_fieldsmemory($res_portariaassenta,0);
           
      $oDaoAssentaAttr = new cl_assentadb_cadattdinamicovalorgrupo();
      $rsComplemento   = db_query($oDaoAssentaAttr->sql_query(null,null, "h80_db_cadattdinamicovalorgrupo", null, "h80_assenta = {$h33_assenta}"));
      if (pg_numrows($rsComplemento) > 0) {
        db_fieldsmemory($rsComplemento,0);
      }
      
   $db_botao = true;
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/geradorrelatorios.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/dates.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >

  <?php include("forms/db_frmportaria.php"); ?>
  <?php db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>

</body>
</html>
<?
if(isset($alterar)){
  if($clportaria->erro_status=="0"){
    $clportaria->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clportaria->erro_campo!=""){
      echo "<script> document.form1.".$clportaria->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clportaria->erro_campo.".focus();</script>";
    }
  }else{
      if($classenta->erro_status=="0"){
          $classenta->erro(true,false);
          $db_botao=true;
          echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
          if($classenta->erro_campo!=""){
              echo "<script> document.form1.".$classenta->erro_campo.".style.backgroundColor='#99A9AE';</script>";
              echo "<script> document.form1.".$classenta->erro_campo.".focus();</script>";
          }
      } else {    
           $classenta->erro(true,true);
      }
  }
}
if ($db_opcao==22) {
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
renderizarFormulario();
js_tabulacaoforms("form1","h31_portariatipo",true,1,"h31_portariatipo",true);
js_criarCamposAdicionais("<?= (!empty($h12_codigo) ? $h16_codigo : null ) ?>");
</script>