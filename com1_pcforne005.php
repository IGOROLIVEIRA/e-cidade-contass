<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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
include("classes/db_pcforne_classe.php");
include("classes/db_pcfornemov_classe.php");
include("classes/db_pcfornecert_classe.php");
include("classes/db_cgm_classe.php");
include("classes/db_licitaparam_classe.php");
include("classes/db_pcfornecon_classe.php");

$clpcforne = new cl_pcforne;
$cllicitaparam = new cl_licitaparam;
$clpcfornecon = new cl_pcfornecon;
$clcgm = new cl_cgm;

db_postmemory($HTTP_POST_VARS);
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  $sqlerro=false;

  $rsParamLic = $cllicitaparam->sql_record($cllicitaparam->sql_query(null,"*",null,"l12_instit = ".db_getsession('DB_instit')));
        db_fieldsmemory($rsParamLic, 0)->l12_validacadfornecedor;

        if($l12_validacadfornecedor == "t"){
          
          if($z01_telef == ""){
            db_msgbox("Usuário: Campo Email não informado !");
            $sqlerro = true;
          }
  
          if($z01_email == ""){
            db_msgbox("Usuário: Campo Telefone não informado !");
            $sqlerro = true;
          }

          /**
           * Verifica conta bancaria
           */
          $rsContaBancaria = $clpcfornecon->sql_record($clpcfornecon->sql_query(null,"*",null,"pc63_numcgm={$pc60_numcgm}"));
          //db_criatabela($rsContaBancaria);exit;
          if(pg_numrows($rsContaBancaria) == 0) {
            db_msgbox("Usuário: E necessario cadastrar ao menos uma conta bancaria !");
            $sqlerro = true;

            echo "
              <script>
                  function js_db_libera(){         
                    parent.document.formaba.pcfornecon.disabled=false;
                    top.corpo.iframe_pcfornecon.location.href='com1_pcfornecon001.php?pc63_numcgm=".@$pc60_numcgm."';
                ";
            echo"}\n
                js_db_libera();
              </script>\n
            ";
          }
        }
  /**
  * alterando email e telefone OC15701
  */
  if($sqlerro == false){
    $clcgm->z01_numcgm = $pc60_numcgm;
    $clcgm->z01_email = $z01_email;
    $clcgm->z01_telef = $z01_telef;
    $clcgm->alterar($pc60_numcgm);
  }
  db_inicio_transacao();
  if($sqlerro == false){
    $clpcforne->alterar($pc60_numcgm);
    if($clpcforne->erro_status==0){
      $sqlerro=true;
    }
  }

  $erro_msg = $clpcforne->erro_msg; 
  db_fim_transacao($sqlerro);
   $db_opcao = 2;
   $db_botao = true;
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $db_botao = true;
   $result = $clpcforne->sql_record($clpcforne->sql_query($chavepesquisa)); 
   db_fieldsmemory($result,0);
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<br />
    <center>
    	<?
    	 include("forms/db_frmpcforne.php");
    	?>
    </center>

</body>
</html>
<?
if(isset($alterar)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clpcforne->erro_campo!=""){
      echo "<script> document.form1.".$clpcforne->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clpcforne->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
  }
}
if(isset($chavepesquisa)){	
 echo "
  <script>
      function js_db_libera(){         
     
         parent.document.formaba.pcfornemov.disabled=false;
         top.corpo.iframe_pcfornemov.location.href='com1_pcfornemov001.php?pc62_numcgm=".@$pc60_numcgm."';
         parent.document.formaba.subgrupo.disabled=false;
         top.corpo.iframe_subgrupo.location.href='com1_pcfornesub001.php?pc76_pcforne=".@$pc60_numcgm."';
         parent.document.formaba.pcfornecon.disabled=false;
         top.corpo.iframe_pcfornecon.location.href='com1_pcfornecon001.php?pc63_numcgm=".@$pc60_numcgm."';
         top.corpo.iframe_pcforneidentificacaocredor.location.href='com1_pcfornetipoidentificacaocredorgenerica001.php?pc81_cgmforn=".@$pc60_numcgm."';
         parent.document.formaba.pcforneidentificacaocredor.disabled=false;
     ";
    //Alterado o modulo de 28 para 39 - cod modulo incorreto (Ocorrencia 2213)

    /** Mario Junior
     *  comentado parte do codigo que impedia usuario comum alterar e incluir contass banco;
     * $permissao=db_permissaomenu(db_getsession("DB_anousu"),39,5002);
     */

     $permissao=true;
     if ($permissao=='true'){
     	    echo" 
                parent.document.formaba.pcfornereprlegal.disabled=false;
         	      top.corpo.iframe_pcfornereprlegal.location.href='com1_pcfornereprlegal001.php?pc81_cgmforn=".@$pc60_numcgm."';
         	";
     	if(isset($liberaaba)){
          echo "  parent.mo_camada('pcfornereprlegal');";
     	}
     }else{
     	if(isset($liberaaba)){
        	echo "  parent.mo_camada('pcfornemov');";
     	}
     }
 echo"}\n
    js_db_libera();
  </script>\n
 ";
}
 if($db_opcao==22||$db_opcao==33){
    echo "<script>document.form1.pesquisar.click();</script>";
 }
?>
