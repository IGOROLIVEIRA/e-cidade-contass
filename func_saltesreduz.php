<?php
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
 
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_saltes_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clsaltes = new cl_saltes;
$clsaltes->rotulo->label("k13_conta");
$clsaltes->rotulo->label("k13_descr");
$clsaltes->rotulo->label("k13_reduz");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload='document.form2.chave_k13_reduz.focus();'>
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
  <tr> 
    <td height="63" align="center" valign="top">
        <table width="35%" border="0" align="center" cellspacing="0">
	     <form name="form2" method="post" action="" >
          <tr> 
            <td width="4%" align="right" nowrap title="<?php echo $Tk13_conta?>">
              <?php echo $Lk13_reduz?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?php 
	              db_input("k13_reduz",5,$Ik13_reduz,true,"text",4,"","chave_k13_reduz");
	            ?>
            </td>
          </tr>
          <tr> 
            <td width="4%" align="right" nowrap title="<?php echo $Tk13_descr?>">
              <?php echo $Lk13_descr?>
            </td>
            <td width="96%" align="left" nowrap> 
              <?php 
	              db_input("k13_descr",40,$Ik13_descr,true,"text",4,"","chave_k13_descr");
	            ?>
            </td>
          </tr>
          <tr> 
            <td colspan="2" align="center"> 
              <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"> 
              <input name="limpar" type="reset" id="limpar" value="Limpar" >
              <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_saltes.hide();">
             </td>
          </tr>
        </form>
        </table>
      </td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <?php 
      $dbwhere="";
      if(isset($c61_codigo) && trim($c61_codigo) != "") {
          $dbwhere = " and c61_codigo = $c61_codigo ";
          if (isset($disp_rec) && trim($disp_rec) == "S"){
               $dbwhere .= "or c61_codigo = 1 ";
          }
      }

      if (isset($ver_datalimite) && trim(@$ver_datalimite)=="1"){
           $dbwhere .= " and (k13_limite is null or k13_limite >= '".date("Y-m-d",db_getsession("DB_datausu"))."')";  /* OC 2386 - A falta de parenteses na data limite interferia na busca da conta na confecção de slips. */
      }
      $iAnoSessao = db_getsession("DB_anousu");
      if ($tiposelecione == 01 || $tiposelecione == 02){
            if ($tipoconta == "Debito"){
              if ( $tipocontadebito == 1){
                  $dbwhere .= " and db83_tipoconta = ".$tipocontadebito ;
              }
              if ( $tipocontadebito == 2){
                 if ($tiposelecione == 01){
                    $dbwhere .= "  and ( db83_tipoconta = ".$tipocontadebito."  or db83_tipoconta = 3 )"  ;
                 } else{
                    $dbwhere .= " and db83_tipoconta = ".$tipocontadebito ;
                 }
              }
              if ( $tipocontadebito == 3){
                $dbwhere .= " and db83_tipoconta is null" ;
              }
            }
            if ($tipoconta == "Credito"){
                
                $dbwhere .= " and c63_conta = 
                            ( select 
                                  c63_conta
                              from
                                  saltes
                              inner join conplanoreduz on
                                  conplanoreduz.c61_reduz = saltes.k13_reduz
                                  and c61_anousu = $iAnoSessao
                              inner join conplanoexe on
                                  conplanoexe.c62_reduz = conplanoreduz.c61_reduz
                                  and c61_anousu = c62_anousu
                              inner join conplano on
                                  conplanoreduz.c61_codcon = conplano.c60_codcon
                                  and c61_anousu = c60_anousu
                              left join conplanoconta on
                                  conplanoconta.c63_codcon = conplanoreduz.c61_codcon
                                  and conplanoconta.c63_anousu = conplanoreduz.c61_anousu
                              where  k13_reduz = $codigoconta and c61_anousu = $iAnoSessao
                              )  " ;
                
                if ($tiposelecione == 02){
                    $dbwhere .= "  and ( db83_tipoconta = ".$tipocontacredito."  or db83_tipoconta = 3 )"  ;
                } else{
                    $dbwhere .= " and db83_tipoconta = $tipocontacredito ";
                }
                
            } 
      }
      if ($tiposelecione == 03){
            if ($tipoconta == "Debito"){
              if ( $tipocontadebito == 1){
                $dbwhere .= " and ( db83_tipoconta = ".$tipocontadebito."  or db83_tipoconta = 3 ) " ;
              }
            } 
            if ($tipoconta == "Credito"){
              
              if ($codigoconta){
                
                $dbwhere .= " and c61_codigo = 
                              ( select 
                                    c61_codigo
                                from
                                    saltes
                                inner join conplanoreduz on
                                    conplanoreduz.c61_reduz = saltes.k13_reduz
                                    and c61_anousu = $iAnoSessao
                                inner join conplanoexe on
                                    conplanoexe.c62_reduz = conplanoreduz.c61_reduz
                                    and c61_anousu = c62_anousu
                                inner join conplano on
                                    conplanoreduz.c61_codcon = conplano.c60_codcon
                                    and c61_anousu = c60_anousu
                                left join conplanoconta on
                                    conplanoconta.c63_codcon = conplanoreduz.c61_codcon
                                    and conplanoconta.c63_anousu = conplanoreduz.c61_anousu
                                where  k13_reduz = $codigoconta and c61_anousu = $iAnoSessao
                                )";
                                $dbwhere .= " and ( db83_tipoconta = ".$tipocontadebito."  or db83_tipoconta = 3 )" ;
              }
            }     
      }
      if ($tiposelecione == 04){
          if ($tipoconta == "Debito"){
            if ( $tipocontadebito == 1){
              $dbwhere .= " and db83_tipoconta = ".$tipocontadebito ;
            }
          }    
          if ($tipoconta == "Credito"){    
            if ( $tipocontacredito == 1){
              $dbwhere .= " and db83_tipoconta = ".$tipocontacredito ;
            }
          }  
      }
      if ($tiposelecione == 05){
            if ($tipoconta == "Debito"){
                if ( $tipocontadebito == 1){
                  $dbwhere .= "  and c61_codigo in ('15000001') and db83_tipoconta = ".$tipocontadebito ;
                }
            }    
            if ($tipoconta == "Credito"){
                if ( $tipocontacredito == 1){
                  $dbwhere .= "  and c61_codigo in ('15000000') and db83_tipoconta = ".$tipocontacredito ;
                }
            }    
      }
      if ($tiposelecione == 06){
        if ($tipoconta == "Debito"){
            if ( $tipocontadebito == 1){
              $dbwhere .= "  and c61_codigo in ('15000002') and db83_tipoconta = ".$tipocontadebito ;
            }
        }    
        if ($tipoconta == "Credito"){
            if ( $tipocontacredito == 1){
              $dbwhere .= "  and c61_codigo in ('15000000') and db83_tipoconta = ".$tipocontacredito ;
            }
        }    
      }
      if ($tiposelecione == 07){
          if ($tipoconta == "Debito"){
              if ( $tipocontadebito == 1){
                $dbwhere .= "  and c61_codigo in ('15700000','15710000','15720000','15750000','16310000','16320000','16330000','16360000','16650000','17000000','17010000','17020000','17030000') and db83_tipoconta = ".$tipocontadebito ;
              }
          }    
          if ($tipoconta == "Credito"){
              if ( $tipocontacredito == 1){
                $dbwhere .= "  and c61_codigo in ('15000000') and db83_tipoconta = ".$tipocontacredito ;
              }
          }    
      }
      if ($tiposelecione == "08"){
        if ($tipoconta == "Debito"){
          if ( $tipocontadebito == 1){
            $dbwhere .= " and db83_tipoconta = ".$tipocontadebito ;
          }
        }    
        if ($tipoconta == "Credito"){  
          if ( $tipocontacredito == 1){
            $dbwhere .= " and db83_tipoconta = ".$tipocontacredito ;
          }
        }  
      }
      if ($tiposelecione == "09"){
        if ($tipoconta == "Debito"){
          if ( $tipocontadebito == 1){
            $dbwhere .= " and db83_tipoconta = ".$tipocontadebito ;
          }
        }    
        if ($tipoconta == "Credito"){
          if ( $tipocontacredito == 3){
            $dbwhere .= " and db83_tipoconta is null " ;
          }
        }  
      }
      if ($tiposelecione == 10){
        if ($tipoconta == "Debito"){
          if ( $tipocontadebito == 3){
            $dbwhere .= " and db83_tipoconta is null " ;
          }
        }    
        if ($tipoconta == "Credito"){
          if ( $tipocontacredito == 1){
            $dbwhere .= " and db83_tipoconta = ".$tipocontacredito ;
          }
        } 
      }


      if(!isset($pesquisa_chave)){
        if(isset($campos)==false){
           if(file_exists("funcoes/db_func_saltes.php")==true){
             include("funcoes/db_func_saltes.php");
           }else{
           $campos = "saltes.*";
           }
        }
        if(isset($chave_k13_reduz) && (trim($chave_k13_reduz)!="") ){
          $sql = $clsaltes->sql_query_anousu($chave_k13_reduz,$campos,""," k13_reduz::text like '$chave_k13_reduz%' and c61_instit = ".db_getsession("DB_instit") . $dbwhere);
        }else if(isset($chave_k13_descr) && (trim($chave_k13_descr)!="") ){
	        $sql = $clsaltes->sql_query_anousu("",$campos,"k13_descr"," k13_descr like '$chave_k13_descr%' and c61_instit = ".db_getsession("DB_instit") . $dbwhere);
        }else{
          $sql = $clsaltes->sql_query_anousu(null,$campos,"k13_conta","c61_instit = ".db_getsession("DB_instit") . $dbwhere);
        }
        db_lovrot($sql,15,"()","",$funcao_js,"","NoMe",array(),false);
      }else{
        if($pesquisa_chave!=null && $pesquisa_chave!=""){
          $result = $clsaltes->sql_record($clsaltes->sql_query_anousu(null,"*","","k13_conta=$pesquisa_chave and c61_instit = ".db_getsession("DB_instit") . $dbwhere));
          if($clsaltes->numrows!=0){
            db_fieldsmemory($result,0);
            echo "<script>".$funcao_js."('$k13_descr','$c61_codigo','$k13_reduz',false);</script>";
          }else{
	         echo "<script>".$funcao_js."('Chave(".$pesquisa_chave.") não Encontrado',true);</script>";
          }
        }else{
	       echo "<script>".$funcao_js."('',false);</script>";
        }
      }
      ?>
     </td>
   </tr>
</table>
</body>
</html>
<?php 
if(!isset($pesquisa_chave)){
  ?>
  <script>
  </script>
  <?php 
}
?>