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
include("dbforms/db_classesgenericas.php");
$gform    = new cl_formulario_rel_pes;
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
db_postmemory($HTTP_POST_VARS);
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>

<script>


function js_emite(){
  let qry = '';
  qry += "&tipo="             + document.form1.tipo.value;
  qry += "&quebrar="          + document.form1.quebrar.value;
  qry += "&ordem="          + document.form1.ordem.value;
  if(document.form1.selcargo){
    if(document.form1.selcargo.length > 0){
      faixacargo = js_campo_recebe_valores();
      qry+= "&fca="+faixacargo;
    }
  }else if(document.form1.cargoi){
    carini = document.form1.cargoi.value;
    carfim = document.form1.cargof.value;
    qry+= "&cai="+carini;
    qry+= "&caf="+carfim;
  }

  if(document.form1.sellot){
    if(document.form1.sellot.length > 0){
      faixalot = js_campo_recebe_valores();
      qry+= "&flt="+faixalot;
    }
  }else if(document.form1.lotaci){
    lotini = document.form1.lotaci.value;
    lotfim = document.form1.lotacf.value;
    qry+= "&lti="+lotini;
    qry+= "&ltf="+lotfim;
  }
  if(document.form1.selorg){
    if(document.form1.selorg.length > 0){
      faixaorg = js_campo_recebe_valores();
      qry+= "&for="+faixaorg;
    }
  }else if(document.form1.orgaoi){
    orgini = document.form1.orgaoi.value;
    orgfim = document.form1.orgaof.value;
    qry+= "&ori="+orgini;
    qry+= "&orf="+orgfim;
  }
  jan = window.open('pes2_bagefetividade002.php?ano='+document.form1.DBtxt23.value+'&mes='+document.form1.DBtxt25.value+'&modelo='+document.form1.modelo.value+qry,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
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

  <table  align="center">
    <form name="form1" method="post" action="" onsubmit="return js_verifica();">
      <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
      </tr>
      <tr >
        <td align="left" nowrap title="Digite o Ano / Mes de competência" >
        <strong>Ano / Mês :&nbsp;&nbsp;</strong>
        </td>
        <td>
          <?
	  $sqlanomes = "select max(r11_anousu||lpad(r11_mesusu,2,0)) from cfpess";
	  $resultanomes = pg_exec($sqlanomes);
	  db_fieldsmemory($resultanomes,0);
	  $DBtxt23 = substr($max,0,4);
            db_input('DBtxt23',4,$IDBtxt23,true,'text',2,'')
          ?>
	  &nbsp;/&nbsp;
          <?
	  $DBtxt25 = substr($max,4,2);
            db_input('DBtxt25',2,$IDBtxt25,true,'text',2,'')
          ?>
        </td>
      </tr>
      <tr> 
        <td align="left" nowrap title="Modelo" ><b>Modelo :</b>&nbsp;&nbsp;
        </td>
        <td>
          <select name="modelo">
            <option value='efetividade'>Efetividade</option>
            <option value='ocorrencias'>Ocorrências</option>
          </select>
        </td>
      </tr>
      <?
        if(!isset($tipo)){
          $tipo = "l";
        }
        if(!isset($filtro)){
          $filtro = "i";
        }
        
        $gform->tipores = true;
        $gform->usalota = true;               // PERMITIR SELEÇÃO DE LOTAÇÕES
        $gform->usaLotaFieldsetClass = true;  // PERMITIR SELEÇÃO DE LOTAÇÕES
        $gform->usaorga = true;               // PERMITIR SELEÇÃO DE ÓRGÃO
        $gform->usacarg = true;               // PERMITIR SELEÇÃO DE Cargo
        $gform->mostaln = true;             // Removido campo tipo de ordem e carregado manualmente 
                                              
        $gform->masnome = "ordem";            
                                              
        $gform->ca1nome = "cargoi";           // NOME DO CAMPO DO CARGO INICIAL
        $gform->ca2nome = "cargof";           // NOME DO CAMPO DO CARGO FINAL
        $gform->ca3nome = "selcargo";         
        $gform->ca4nome = "Cargo";            
                                              
        $gform->lo1nome = "lotaci";           // NOME DO CAMPO DA LOTAÇÃO INICIAL
        $gform->lo2nome = "lotacf";           // NOME DO CAMPO DA LOTAÇÃO FINAL
        $gform->lo3nome = "sellot";           
                                              
        $gform->or1nome = "orgaoi";           // NOME DO CAMPO DO ÓRGÃO INICIAL
        $gform->or2nome = "orgaof";           // NOME DO CAMPO DO ÓRGÃO FINAL
        $gform->or3nome = "selorg";           // NOME DO CAMPO DE SELEÇÃO DE ÓRGÃOS
        $gform->or4nome = "Secretaria";       // NOME DO CAMPO DE SELEÇÃO DE ÓRGÃOS
                                              
        $gform->trenome = "tipo";             // NOME DO CAMPO TIPO DE RESUMO
        $gform->tfinome = "filtro";           // NOME DO CAMPO TIPO DE FILTRO
                                              
        $gform->resumopadrao = "l";           // TIPO DE RESUMO PADRÃO
        $gform->filtropadrao = "i";           
        $gform->strngtipores = "loc";         // OPÇÕES PARA MOSTRAR NO TIPO DE RESUMO g - geral,
                                              
        $gform->selecao = false;               
        $gform->onchpad = true;               // MUDAR AS OPÇÕES AO SELECIONAR OS TIPOS DE FILTRO OU RESUMO
    
        $gform->manomes = false;
        $gform->gera_form( db_anofolha(), db_mesfolha() );
      ?>
      <tr >
        <td nowrap><strong>Quebrar :</strong>&nbsp;
        </td>
        <td>
          <?
            $xxy = array(
                      "n"=>"NÃO", 
                      "s"=>"SIM"
                        );
            db_select('quebrar',$xxy,true,4,"");
          ?>
        </td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
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
function js_pesquisatabdesc(mostra){
     if(mostra==true){
       db_iframe.jan.location.href = 'func_tabdesc.php?funcao_js=parent.js_mostratabdesc1|0|2';
       db_iframe.mostraMsg();
       db_iframe.show();
       db_iframe.focus();
     }else{
       db_iframe.jan.location.href = 'func_tabdesc.php?pesquisa_chave='+document.form1.codsubrec.value+'&funcao_js=parent.js_mostratabdesc';
     }
}
function js_mostratabdesc(chave,erro){
  document.form1.k07_descr.value = chave;
  if(erro==true){
     document.form1.codsubrec.focus();
     document.form1.codsubrec.value = '';
  }
}
function js_mostratabdesc1(chave1,chave2){
     document.form1.codsubrec.value = chave1;
     document.form1.k07_descr.value = chave2;
     db_iframe.hide();
}
</script>


<?
$func_iframe = new janela('db_iframe','');
$func_iframe->posX=1;
$func_iframe->posY=20;
$func_iframe->largura=780;
$func_iframe->altura=430;
$func_iframe->titulo='Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();

?>