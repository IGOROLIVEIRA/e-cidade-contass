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
db_postmemory($HTTP_POST_VARS);
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('r44_selec');
$clrotulo->label('r44_descr');

$bancos['arquivo'] = 'pes4_geraraspprev001.php';

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

    </script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
        </head>
        <body bgcolor=#CCCCCC leftmargin="0"  topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
        <br />
        <br />
        <center>
        <form name="form1" method="post" action="<?=$bancos["arquivo"];?>">
        <fieldset style="width: 550px;">
        <legend><strong>Cálculo Atuarial - ASPPREV </strong></legend>

    <table width="100%">
        <tr>
        <td><strong>Ano / Mês:</strong></td>
    <td>
    <?
      $ano = db_anofolha();
      db_input('ano',4,$IDBtxt23,true,'text',2,'');
      echo "&nbsp;/&nbsp;";
      $mes = db_mesfolha();
      db_input('mes',2,$IDBtxt25,true,'text',2,'')
    ?>
    </td>
    </tr>
    <tr >
    <td align="left" nowrap title="Tabela de Previdência" >
        <strong>Tabela de Previdência :&nbsp;&nbsp;</strong>
    </td>
    <td>
    <?
$sql = "select distinct (cast(r33_codtab as integer) - 2) as r33_codtab,
                                                r33_nome
      from inssirf
      where r33_anousu = ".db_anofolha()."
        and r33_mesusu = ".db_mesfolha()."
        and r33_codtab > 2
        and r33_instit = ".db_getsession('DB_instit');
$res = pg_query($sql);
    db_selectrecord('prev', $res, true, 4);
    ?>
    </td>
    </tr>
    <tr>
    <td nowrap title="Seleção:">
        <?
          db_ancora("<b>Seleção:</b>","js_pesquisasel(true)",1);
        ?>
        </td>
        <td>
        <?
          db_input('r44_selec',4,$Ir44_selec,true,'text',2,'onchange="js_pesquisasel(false)"');
          db_input('r44_descr',40,$Ir44_selec,true,'text',3,'');
        ?>
        </td>
        </tr>
        <tr>
        <td><strong>Tipo de arquivo:</strong></td>
    <td>
    <?
      $aVinculos = array (
                          ''  => 'Selecione',
                          'S' => 'Segurado',
                          'C' => 'Cargo',
                          'FP' => 'FP',
                          'HS' => 'HS',
                          'VO' => 'VO',
                          'DP' => 'DP'
                          );
      db_select("vinculo",$aVinculos,true,1);
    ?>
    </td>
    </tr>

    <input id="separador" name="separador"  type="hidden" value="N" >

    <?
      // Banco 104 = Caixa Econômica Federal
      if ($banco == 104) {

        echo '<tr>';
        echo '  <td><strong>Versão:</strong></td>';
        echo '  <td>';
        $aAno = array (1 => 'Até 2010', 2 => '2011');
        db_select('versao', $aAno, true, 1);
        echo '  </td>';
        echo '</tr>';
      }
    ?>
    </table>
    </fieldset>
    <br />
    <input  name="gera" id="gera" type="submit" value="Processar" onclick="return js_validapars()" >
        </center>
        <?
          db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
        ?>
        </body>
        </html>
        <script>
        <?
       // if(isset($gera)){
       // 	echo "js_montarlista('".$arq."#Arquivo gerado em: ".$arq."','form1');";
       // }
        ?>

        function js_pesquisasel(mostra){
            if(mostra==true){
                js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_selecao','func_selecao.php?funcao_js=parent.js_mostrasel1|r44_selec|r44_descr','Pesquisa',true);
            }else{
                if(document.form1.r44_selec.value != ''){
                    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_selecao','func_selecao.php?pesquisa_chave='+document.form1.r44_selec.value+'&funcao_js=parent.js_mostrasel','Pesquisa',false);
                }else{
                    document.form1.r44_descr.value = '';
                }
            }
        }
    function js_mostrasel(chave,erro){
        document.form1.r44_descr.value = chave;
        if(erro==true){
            document.form1.r44_selec.focus();
            document.form1.r44_selec.value = '';
        }
    }
    function js_mostrasel1(chave1,chave2){
        document.form1.r44_selec.value = chave1;
        document.form1.r44_descr.value   = chave2;
        db_iframe_selecao.hide();
    }
    function js_validapars (){

        ano     = document.getElementById('ano').value;
        mes     = document.getElementById('mes').value;
        vinculo = document.getElementById('vinculo').value;

        if (ano == '' ||  mes == '' || vinculo == ''){

            alert('Verifique os Parametros!\n parametros obrigatórios nulos.');
            return false;
        }else{

            return true;
        }
        //return false;
    }




    </script>
