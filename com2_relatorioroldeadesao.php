<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
db_postmemory($HTTP_POST_VARS);
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<script>

function js_emite(){
  var qry = "";

  qry  = 'ordem='+document.form1.ordem.value;
  qry += '&tipo_ordem='+document.form1.tipo_ordem.value;
  qry += '&listar_mat='+document.form1.listar_mat.value;
  qry += '&listar_serv='+document.form1.listar_serv.value;

  jan  = window.open('com2_relatorioroldeadesao002.php?'+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}

</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<center>
<form name="form1" method="post" action="">
<fieldset style="width: 480px;margin-top: 30px">
            <legend><strong>Relat�rio de Recursos Or�amentarios</strong></legend>

            <table>
                <tr>
                  <td align="left" nowrap title="<?= $Te60_numcgm ?>">
                    <? db_ancora("Ata de Registro de Pre�o: ","js_pesquisaadesao(true);",1); ?>
                  </td>
                  <td align="left" nowrap>
                    <? db_input("si06_sequencial", 6, $Isi06_sequencial, true, "text", 4, "onchange='js_pesquisaadesao(false);'");
                    db_input("si06_objetoadesao", 40, "$Isi06_objetoadesao", true, "text", 3);
                    ?></td>
                </tr>
                <tr>
                  <td align="left" nowrap title="<?= $Te60_numcgm ?>">
                    <? db_ancora("Modalidade: ","js_pesquisapc80_codproc(true);",1); ?>
                  </td>
                  <td align="left" nowrap>
                    <? db_input("m51_numcgm", 6, $Ie60_numcgm, true, "text", 4, "onchange='js_pesquisae60_numcgm(false);'");
                    db_input("z01_nome", 40, "$Iz01_nome", true, "text", 3);
                    ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bolder;" >
                        Exerc�cio:
                    </td>
                    <td>
                        <?
                        db_input("pc80_codproc", 6, $Ipc80_codproc,true,"text",4,"onchange='js_pesquisapc80_codproc(false);'");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Tipo de Relat�rio</strong>
                    </td>
                    <td>
                        <?$iFornecedor = array(
                            1=>"N�o",
                            2 =>"Sim");
                        db_select("fornecedor",$iFornecedor,true,1,"");
                        ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        </form>
                        </center>
  <table  align="center">
    <form name="form1" method="post" action="" >
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>

      <tr>
        <td nowrap align='right'>
         <b>Ordem :</b>
        </td>
        <td nowrap>
	      <?
          $x = array("n"=>"Num�rica","a"=>"Alfab�tica");
          db_select("ordem",$x,true,2); 
	      ?>
        </td>
      </tr>
      <tr>
        <td nowrap align='right'>
         <b>Tipo Ordem :</b>
        </td>
        <td nowrap>
	      <?
          $y = array("a"=>"Ascendente","d"=>"Descendente");
          db_select("tipo_ordem",$y,true,2); 
	      ?>
        </td>
      </tr>
      <tr>
        <td><b>Listar Materiais :</b></td>
        <td nowrap>
        <?
          $x = array("T"=>"Todos","A"=>"Ativos","I"=>"Inativos");
          db_select("listar_mat",$x,true,2);
        ?>
        </td>
      <tr>
        <td nowrap align='right'><b>Listar :</b></td>
        <td nowrap>
	       <? 
	       $somente_serv = array("M"=>"Materiais", "T"=>"Todos", "S"=>"Servi�os");
	       db_select("listar_serv",$somente_serv,true,2);
		   ?>
        </td>		
		
      </tr>
      <tr><td colspan="2">&nbsp;</td></tr>
      <tr>
        <td colspan="2" align = "center"> 
          <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" >
        </td>
      </tr>

      

  </form>
    </table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>

<script>

    function js_pesquisaadesao(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo', 'db_iframe_adesaoregprecos', 'func_adesaoregprecos.php?funcao_js=parent.js_preenchepesquisa|si06_sequencial|si06_objetoadesao', 'Pesquisa', true);
        }else{
            if(document.form1.pc80_codproc.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_pcproc','func_pcproc.php?pesquisa_chave='+document.form1.pc80_codproc.value+'&funcao_js=parent.js_mostrapcproc','Pesquisa',false);
            }else{
                document.form1.pc80_codproc.value = '';
            }
        }
    }
    function js_preenchepesquisa(chave, objetoadesao,) {
      document.getElementById('si06_sequencial').value=chave;
          document.getElementById('si06_objetoadesao').value=objetoadesao;
        
    db_iframe_adesaoregprecos.hide();
  }
    function js_mostrapcproc(chave,erro){
        if(erro==true){
            document.form1.pc80_codproc.focus();
            document.form1.pc80_codproc.value = '';
        }
    }
    function js_mostrapcproc1(chave1,x){
        document.form1.pc80_codproc.value = chave1;
        db_iframe_pcproc.hide();
    }
</script>