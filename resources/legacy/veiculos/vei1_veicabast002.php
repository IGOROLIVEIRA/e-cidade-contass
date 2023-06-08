<?
/*
 *     E-cidade Software Público para Gestão Municipal
 *  Copyright (C) 2014  DBseller Serviços de Informática
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa é software livre; você pode redistribuí-lo e/ou
 *  modificá-lo sob os termos da Licença Pública Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versão 2 da
 *  Licença como (a seu critério) qualquer versão mais nova.
 *
 *  Este programa e distribuído na expectativa de ser útil, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implícita de
 *  COMERCIALIZAÇÃO ou de ADEQUAÇÃO A QUALQUER PROPÓSITO EM
 *  PARTICULAR. Consulte a Licença Pública Geral GNU para obter mais
 *  detalhes.
 *
 *  Você deve ter recebido uma cópia da Licença Pública Geral GNU
 *  junto com este programa; se não, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Cópia da licença no diretório licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
require("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_veicabast_classe.php");
include("classes/db_veicabastposto_classe.php");
include("classes/db_veicabastpostoempnota_classe.php");
include("classes/db_veicabastretirada_classe.php");
include("classes/db_veicparam_classe.php");
include("classes/db_veiculos_classe.php");
include("classes/db_veictipoabast_classe.php");
include("classes/db_veicretirada_classe.php");
include("classes/db_empveiculos_classe.php");
include("classes/db_condataconf_classe.php");
require("libs/db_app.utils.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clveiculos              = new cl_veiculos;
$clveicabast             = new cl_veicabast;
$clveicabastposto        = new cl_veicabastposto;
$clveicabastpostoempnota = new cl_veicabastpostoempnota;
$clveicabastretirada     = new cl_veicabastretirada;
$clveicparam             = new cl_veicparam;
$clveictipoabast         = new cl_veictipoabast;
$clveicretirada          = new cl_veicretirada;
$clempveiculos           = new cl_empveiculos;

$clempveiculos->rotulo->label();

$db_opcao = 22;
$db_botao = false;
$erro_msg = "";
$sqlerro  =false;
$ve70_medida1=null;
$ve70_medida2=null;
$ve70_medida3=null;

if (isset($ve60_datasaida) && $ve60_datasaida != "") {

  $aData = explode("/", $ve60_datasaida);

  $ve60_datasaida_dia = $aData[0];
  $ve60_datasaida_mes = $aData[1];
  $ve60_datasaida_ano = $aData[2];

}

if(isset($alterar)){

    $medida     = $ve70_medida;
    $oDataAbast = new DBDate($ve70_dtabast);
    $passa=false;
    $horaabast = $ve70_hora;
    $retirada = $ve73_veicretirada;
    $datahoraAbastecimento = strtotime($oDataAbast->getDate()." ".$ve70_hora);
    $dataabast = $oDataAbast->getDate();

    if (isset($ve70_medida) and $ve70_medida==0) {
        $medidazero=true;
    } else {
        $medidazero=false;
    }
    /*
     * verifica retirada e devolução vinculados ao abastecimento
     */
    $result_retirada=$clveicabast->sql_record($clveicabast->sql_query_retirada(null,"ve60_codigo,ve60_medidasaida,ve61_medidadevol,to_timestamp(ve60_datasaida||' '||ve60_horasaida::varchar,'YYYY-MM-DD hh24:mi')::TIMESTAMP AS datahrretirada,to_timestamp(ve61_datadevol||' '||ve61_horadevol::varchar,'YYYY-MM-DD hh24:mi')::TIMESTAMP AS datahrdevolucao",null,"ve60_codigo=$retirada"));
    if (pg_num_rows($result_retirada)>0){
        $oRetirada = db_utils::fieldsMemory($result_retirada,0);
        $ve60_medidasaida = $oRetirada->ve60_medidasaida;
        $datahoraRetirada = $oRetirada->datahrretirada;
        $ve61_medidadevol = $oRetirada->ve61_medidadevol;
        $datahoraDevolucao = $oRetirada->datahrdevolucao;
    }

    /*
     * verifica abastecimentos anterior ao que o usuario deseja incluir
     */
    $result_abast1=$clveicabast->sql_record($clveicabast->sql_query_file_anula(null,"ve70_medida,ve74_codigo,ve70_codigo,ve60_medidasaida,ve60_datasaida,ve61_medidadevol,ve61_datadevol,ve61_horadevol,ve60_horasaida,to_timestamp(ve70_dtabast||' '||ve70_hora::varchar,'YYYY-MM-DD hh24:mi')::TIMESTAMP AS ve70_dtabast",null,"ve60_codigo = $retirada) as x WHERE ve70_dtabast < to_timestamp('{$oDataAbast->getDate()}'||' '||'$horaabast'::varchar,'YYYY-MM-DD hh24:mi')::TIMESTAMP LIMIT 1;"));
    if (pg_num_rows($result_abast1)>0 ) {
        $oAbast1       = db_utils::fieldsMemory($result_abast1,0);
        $ve70_medida1  = $oAbast1->ve70_medida;
        $ve70_datahora1 = $oAbast1->ve70_dtabast;
    }

    /*
     * verifica abastecimentos posterior ao que o usuario deseja incluir
     */
    $result_abast3=$clveicabast->sql_record($clveicabast->sql_query_file_anula(null,"ve70_medida,ve74_codigo,ve70_codigo,ve60_medidasaida,ve60_datasaida,ve61_medidadevol,ve61_datadevol,ve61_horadevol,ve60_horasaida,to_timestamp(ve70_dtabast||' '||ve70_hora::varchar,'YYYY-MM-DD hh24:mi')::TIMESTAMP AS ve70_dtabast","","ve70_veiculos=$ve70_veiculos and ve60_codigo = $retirada) as x WHERE ve70_dtabast > to_timestamp('{$oDataAbast->getDate()}'||' '||'$horaabast'::varchar,'YYYY-MM-DD hh24:mi')::TIMESTAMP ORDER BY ve70_medida asc LIMIT 1;"));
    if (pg_num_rows($result_abast3)>0 ) {
        $oAbast3       = db_utils::fieldsMemory($result_abast3,0);
        $ve70_medida3  = $oAbast3->ve70_medida;
        $ve70_datahora3 = $oAbast3->ve70_dtabast;
    }

    if (!empty($ve70_datahora1) && $datahoraAbastecimento < strtotime($ve70_datahora1)){
        db_msgbox("Data ou Hora menor que abastecimento anterior.");
        $sqlerro=true;
        $erro_msg="Não foi possível incluir.";
    }
    else if (!empty($ve70_datahora3) && $datahoraAbastecimento > strtotime($ve70_datahora3)){
        db_msgbox("Data ou Hora maior que abastecimento posterior.");
        $sqlerro=true;
        $erro_msg="Não foi possível incluir.";
    }
    else if (!empty($ve70_medida1) && $medida < $ve70_medida1){
        db_msgbox("Medida de Abastecimento menor que Medida de abastecimento anterior");
        $sqlerro=true;
        $erro_msg="Não foi possível incluir.";
    }
    else if (!empty($ve70_medida3) && $medida > $ve70_medida3){
        db_msgbox("Medida de Abastecimento maior que Medida de abastecimento posterior");
        $sqlerro=true;
        $erro_msg="Não foi possível incluir.";
    }
    else if (!empty($datahoraRetirada) && $datahoraAbastecimento < strtotime($datahoraRetirada)){
        db_msgbox("Data ou Hora do Abastecimento menor que da Retirada");
        $sqlerro=true;
        $erro_msg="Não foi possível incluir.";
    }
    else if (!empty($datahoraDevolucao) && $datahoraAbastecimento > strtotime($datahoraDevolucao)){
        db_msgbox("Data ou Hora do Abastecimento maior que da Devolucao");
        $sqlerro=true;
        $erro_msg="Não foi possível incluir.";
    }
    else if (!empty($ve60_medidasaida) && $medida < $ve60_medidasaida){
        db_msgbox("Medida de Abastecimento menor que Medida de Retirada");
        $sqlerro=true;
        $erro_msg="Não foi possível incluir.";
    }
    else if (!empty($ve61_medidadevol) && $medida > $ve61_medidadevol){
        db_msgbox("Medida de Abastecimento maior que Medida de Devolucao");
        $sqlerro=true;
        $erro_msg="Não foi possível incluir.";
    }

if ($ve70_vlrun == '' || $ve70_vlrun == 0){
  db_msgbox("Informar o valor do litro.");
  $sqlerro=true;
  $erro_msg="Não foi possível alterar.";
}

if (isset($sel_proprio) && ($sel_proprio==2)){
 if ($ve70_valor == ""){
 db_msgbox("Informar o valor abastecido.");
 $sqlerro=true;
 $erro_msg="Não foi possível alterar.";
 }
if ($ve70_vlrun == ''){
 db_msgbox("Informar o valor do litro.");
 $sqlerro=true;
 $erro_msg="Não foi possível alterar.";
}
if ($ve71_nota =="" && $empnota == ""){
 db_msgbox("Informar a nota.");
 $sqlerro=true;
 $erro_msg="Não foi possível alterar.";
}


if ($ve71_nota !="" && $empnota != ""){
   db_msgbox("Informar apenas uma nota.");
    $sqlerro=true;
     $erro_msg="Não foi possível alterar.";
}

}

if( (isset($proximamedida) && $proximamedida > 0) && $proximamedida < $medida){
 $sqlerro  = true;
 $erro_msg = "Medida informada maior que a proxima medida {$proximamedida}! Verique!";
 $clveicabast->erro_campo = "ve70_medida";
}

/**
 * Verificar Encerramento Periodo Patrimonial
 */
if (!empty($ve70_dtabast)) {
  $clcondataconf = new cl_condataconf;
  if (!$clcondataconf->verificaPeriodoPatrimonial($ve70_dtabast)) {
    db_msgbox($clcondataconf->erro_msg);
    $sqlerro  = true;
    $erro_msg="Não foi possível alterar.";
  }
}


if ($sqlerro==false){
  db_inicio_transacao();
  $db_opcao = 2;

  if (isset($sel_proprio) && trim($sel_proprio) != ""){
      if ($sel_proprio == 1){
        $clveicabast->ve70_valor = "0";
        $clveicabast->ve70_vlrun = "0";
      }
  }
  $clveicabast->ve70_hora = $ve70_hora;
  $clveicabast->alterar($ve70_codigo);
  $erro_msg=$clveicabast->erro_msg;
  if ($clveicabast->erro_status=="0"){
  	$sqlerro=true;
  }

  if ($sqlerro==false){
  	$clveicabastposto->ve71_veicabast=$ve70_codigo;

    if (isset($sel_proprio) && trim($sel_proprio) != ""){
       $result_veicabastpostoempnota = $clveicabastpostoempnota->sql_record($clveicabastpostoempnota->sql_query_abastposto(null,"ve71_codigo,ve72_codigo",null,"ve71_veicabast=$ve70_codigo"));
          if ($clveicabastpostoempnota->numrows>0){
              $oVe72_codigo=db_utils::fieldsMemory($result_veicabastpostoempnota,0);
              $clveicabastpostoempnota->ve72_codigo=$oVe72_codigo->ve72_codigo;
              $clveicabastpostoempnota->ve72_empnota=$e69_codnota;
              $clveicabastpostoempnota->ve72_veicabastposto=$oVe72_codigo->ve71_codigo;
              $clveicabastpostoempnota->excluir(null,"ve72_veicabastposto=$clveicabastpostoempnota->ve72_veicabastposto");
          }
      $clveicabastposto->excluir(null,"ve71_veicabast=$ve70_codigo");
      if ($sel_proprio == 1){
        $clveicabastposto->ve71_nota = "";
      }

      $clveicabastposto->incluir(null);
       if ($clveicabastposto->erro_status=="0"){
           $sqlerro=true;
           $erro_msg=$clveicabastposto->erro_msg;
          }

      if ($sel_proprio == 2){
        if ($e69_codnota==null and $ve71_nota!=null){
           $result_veicabastpostoempnota = $clveicabastpostoempnota->sql_record($clveicabastpostoempnota->sql_query_abastposto(null,"ve71_codigo,ve72_codigo",null,"ve71_veicabast=$ve70_codigo"));
          if ($clveicabastpostoempnota->numrows>0){
              $oVe72_codigo=db_utils::fieldsMemory($result_veicabastpostoempnota,0);
              $clveicabastpostoempnota->ve72_codigo=$oVe72_codigo->ve72_codigo;
              $clveicabastpostoempnota->ve72_empnota=$e69_codnota;
              $clveicabastpostoempnota->ve72_veicabastposto=$oVe72_codigo->ve71_codigo;
              $clveicabastpostoempnota->excluir(null,"ve72_veicabastposto=$clveicabastpostoempnota->ve72_veicabastposto");
              if ($clveicabastpostoempnota->erro_status=="0"){
                 $sqlerro=true;
                 $erro_msg=$clveicabastpostoempnota->erro_msg;
              }

               $clveicabastposto->alterar(null,"ve71_veicabast=$ve70_codigo");
            }
          }
         if ($e69_codnota!=null and $ve71_nota==null ){
              $clveicabastpostoempnota->ve72_veicabastposto= $clveicabastposto->ve71_codigo;
              $clveicabastpostoempnota->ve72_empnota=$e69_codnota;
              $clveicabastpostoempnota->incluir(null);
  	         if ($clveicabastpostoempnota->erro_status=="0"){
  		           $sqlerro=true;
  		           $erro_msg=$clveicabastpostoempnota->erro_msg;
  	          }
        }
}
    } else{
  	  $clveicabastposto->alterar(null,"ve71_veicabast=$ve70_codigo");
    }
  	if ($clveicabastposto->erro_status=="0"){
  		$sqlerro=true;
  		$erro_msg=$clveicabastposto->erro_msg;
  	}
  }

  if ($sqlerro==false){
  	$result_retirada=$clveicabastretirada->sql_record($clveicabastretirada->sql_query(null,"ve73_codigo",null,"ve73_veicabast=$ve70_codigo"));
  	if (isset($ve73_veicretirada)&&$ve73_veicretirada!=""){
  		if ($clveicabastretirada->numrows>0){
  			db_fieldsmemory($result_retirada,0);
  			$clveicabastretirada->ve73_codigo=$ve73_codigo;
  			$clveicabastretirada->alterar($ve73_codigo);
  			if ($clveicabastretirada->erro_status=="0"){
  				$sqlerro=true;
  				$erro_msg=$clveicabastretirada->erro_msg;
  			}
      }else{
  			$clveicabastretirada->ve73_veicabast=$ve70_codigo;
  			$clveicabastretirada->incluir(null);
  			if ($clveicabastretirada->erro_status=="0"){
  				$sqlerro=true;
  				$erro_msg=$clveicabastretirada->erro_msg;
  			}
      }
  	}else{
  		if ($clveicabastretirada->numrows>0){
  			$clveicabastretirada->excluir(null,"ve73_veicabast=$ve70_codigo");
  			if ($clveicabastretirada->erro_status=="0"){
  				$sqlerro=true;
  				$erro_msg=$clveicabastretirada->erro_msg;
  			}
      }
  	}
  }

  $clempveiculos->alterar(null,$ve70_codigo);
  $erro_msg=$clempveiculos->erro_msg;
  if ($clempveiculos->erro_status=="0"){
  	$sqlerro=true;
  }

  db_fim_transacao($sqlerro);
}

}else

 if(isset($chavepesquisa)){
   $db_botao = true;
   $db_opcao = 2;
   $result = $clveicabast->sql_record($clveicabast->sql_query($chavepesquisa));
   if ($clveicabast->numrows>0){
   db_fieldsmemory($result,0);
  }
  $ve70_codigo=$chavepesquisa;

   if (!isset($alterado)){
     $result_posto=$clveicabastposto->sql_record($clveicabastposto->sql_query_tip(null,"*",null,"ve71_veicabast=$ve70_codigo"));
     if ($clveicabastposto->numrows>0){
       db_fieldsmemory($result_posto,0);
  	   if ($descrdepto!=""){
         $sel_proprio = 1;
       	 $posto=$descrdepto;
       }
       if ($z01_nome!=""){
         $sel_proprio = 2;
       	 $posto=$z01_nome;
       }
     }

     $res_veicparam = $clveicparam->sql_record($clveicparam->sql_query_file(null,"ve50_postoproprio",null,"ve50_instit = ".db_getsession("DB_instit")));
     if ($clveicparam->numrows > 0){
       db_fieldsmemory($res_veicparam,0);
     }

     if (isset($ve50_postoproprio) && $ve50_postoproprio == 1) {  // Interno
       if (isset($z01_nome) && trim($z01_nome) != ""){
         $erro_msg     = "Abastecimento não pode ser alterado, tipo de posto EXTERNO e parâmetro somente tipo de posto INTERNO";
         $db_botao = false;
         $db_opcao = 22;
       }
     }

     if (isset($ve50_postoproprio) && $ve50_postoproprio == 0) {  // Externo
       if (isset($descrdepto) && trim($descrdepto) != ""){
         $erro_msg     = "Abastecimento não pode ser alterado, tipo de posto INTERNO e parâmetro somente tipo de posto EXTERNO";
         $db_botao = false;
         $db_opcao = 22;
       }
     }
   }

   $result = $clveiculos->sql_record($clveiculos->sql_query($ve70_veiculos,"ve01_veictipoabast"));
   db_fieldsmemory($result,0);

   $result_veictipoabast = $clveictipoabast->sql_record($clveictipoabast->sql_query($ve01_veictipoabast,"ve07_sigla"));
   if ($clveictipoabast->numrows > 0){
     db_fieldsmemory($result_veictipoabast,0);
   }

   $result_retirada=$clveicabastretirada->sql_record($clveicabastretirada->sql_query(null,"*",null,"ve73_veicabast=$ve70_codigo"));
   if ($clveicabastretirada->numrows>0){
     db_fieldsmemory($result_retirada,0);
   }

   $result_empnota=$clveicabastpostoempnota->sql_record($clveicabastpostoempnota->sql_query(null,"ve72_codigo",null,"ve71_veicabast=$ve70_codigo"));
   if ($clveicabastpostoempnota->numrows>0){
   	 db_fieldsmemory($result_empnota,0);
   }

   $result_empnota=$clveicabastpostoempnota->sql_record($clveicabastpostoempnota->sql_query_verificanota(null,"e69_numero as empnota,e69_codnota,ve71_nota",null,"ve71_veicabast=$ve70_codigo"));
   if ($clveicabastpostoempnota->numrows>0){
          db_fieldsmemory($result_empnota,0);
       }


   $result_comb=$clveicabast->sql_record($clveicabast->sql_query($ve70_codigo,"ve26_descr"));
   if ($clveicabast->numrows>0){
   db_fieldsmemory($result_comb,0);
   }

   /*
    * Alteração da tabela empveiculos para sicom
    */
   $result_comb=$clempveiculos->sql_record($clempveiculos->sql_query(null,"*",null,"si05_codabast=$ve70_codigo"));
   if ($clempveiculos->numrows>0){
   db_fieldsmemory($result_comb,0);
   }

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
<body bgcolor=#CCCCCC style='margin-top: 25px' topmargin="0" marginwidth="0" marginheight="0" onLoad="js_pesquisa_ultimamedida(); a=1;">
	<?
	include("forms/db_frmveicabast.php");
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
</body>
</html>
<?

if(isset($alterar)&& $self =! ""){
  if($clveicabast->erro_status=="0"||$sqlerro==true){
    db_msgbox($erro_msg);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clveicabast->erro_campo!=""){
      echo "<script> document.form1.".$clveicabast->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clveicabast->erro_campo.".focus();</script>";
    }
  }else{
    $clveicabast->erro(true,true);
  }
}


if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","ve70_veiculos",true,1,"ve70_veiculos",true);
</script>
