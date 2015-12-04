<?
//WebSeller


function db_inputdatasaude($intEspecmed, $nome, $dia = "", $mes = "", $ano = "", $dbcadastro = true, $dbtype = 'text', $db_opcao = 3, $js_script = "", $nomevar = "", $bgcolor = "",$shutdown_function="none",$onclickBT="", $onfocus="", $jsRetornoCal=""){

		//#00#//db_inputdata
		//#10#//Função para montar um objeto tipo data. Serão três objetos input na tela mais um objeto input tipo button para
		//#10#//acessar o calendário do sistema
		//#15#//db_inputdata($nome,$dia="",$mes="",$ano="",$dbcadastro=true,$dbtype='text',$db_opcao=3,$js_script="",$nomevar="",$bgcolor="",$shutdown_funcion="none",$onclickBT="",$onfocus"");
		//#20#//Nome            : Nome do campo da documentacao do sistema ou do arquivo
		//#20#//Dia             : Valor para o objeto |db_input| do dia
		//#20#//Mês             : Valor para o objeto |db_input| do mês
		//#20#//Ano             : Valor para o objeto |db_input| do ano
		//#20#//Cadastro        : True se cadastro ou false se nao cadastro Padrão: true
		//#20#//Type            : Tipo a ser incluido para a data Padrão: text
		//#20#//Opcao           : *db_opcao* do programa a ser executado neste objeto input, inclusão(1) alteração(2) exclusão(3)
		//#20#//Script          : JAVASCRIPT  a ser executado juntamento com o objeto, indicando os métodos
		//#20#//Nome Secundário : Nome do input que será gerado, assumindo somente as características do campo Nome
		//#20#//Cor Background  : Cor de fundo da tela, no caso de *db_opcao*=3 será "#DEB887"
		//#20#//shutdown_funcion : função que será executada apos o retorno do calendário
		//#20#//onclickBT       : Função que será executada ao clicar no botão que abre o calendário
		//#20#//onfocus         : Função que será executada ao focar os campos
		//#99#//Quando o parâmetro Opção for de alteração (Opcao = 22) ou exclusão (Opção = 33) o sistema
		//#99#//colocará a sem acesso ao calendário
		//#99#//Para *db_opcao* 3 e 5 o sistema colocará sem o calendário e com readonly
		//#99#//
		//#99#//Os três input gerados para a data terão o nome do campo acrescido do [Nome]_dia, [Nome]_mes e
		//#99#//[Nome]_ano os quais serão acessados pela classe com estes nome.
		//#99#//
		//#99#//O sistema gerá para a primeira data incluída um formulário, um objeto de JanelaIframe do nosso
		//#99#//sistema para que sejá mostrado o calendário.

	global $DataJavaScript;
	if ($db_opcao == 3 || $db_opcao == 22) {
		$bgcolor = "style='background-color:#DEB887'";
	}

	if(isset($dia) && $dia != "" && isset($mes) && $mes != '' && isset($ano) && $ano != ""){
		$diamesano = $dia."/".$mes."/".$ano;
		$anomesdia = $ano."/".$mes."/".$dia;
	}

	$sButtonType = "button";

	?>
		<input name="<?=($nomevar==""?$nome:$nomevar).""?>" <?=$bgcolor?>
		       type="<?=$dbtype?>"
		       id="<?=($nomevar==""?$nome:$nomevar).""?>"
		       <?=($db_opcao==3 || $db_opcao==22 ?'readonly':($db_opcao==5?'disabled':''))?>
		       value="<?=@$diamesano?>" size="10" maxlength="10" autocomplete="off"
		       onBlur='js_validaDbData(this);'
		       onKeyUp="return js_mascaraData(this,event)"
		       onSelect="return js_bloqueiaSelecionar(this);"
		       onFocus="js_validaEntrada(this);" <?=$js_script?> >

		<input name="<?=($nomevar==""?$nome:$nomevar)."_dia"?>"   type="hidden" title="" id="<?=($nomevar==""?$nome:$nomevar)."_dia"?>" value="<?=@$dia?>" size="2"  maxlength="2" >
		<input name="<?=($nomevar==""?$nome:$nomevar)."_mes"?>"   type="hidden" title="" id="<?=($nomevar==""?$nome:$nomevar)."_mes"?>" value="<?=@$mes?>" size="2"  maxlength="2" >
		<input name="<?=($nomevar==""?$nome:$nomevar)."_ano"?>"   type="hidden" title="" id="<?=($nomevar==""?$nome:$nomevar)."_ano"?>" value="<?=@$ano?>" size="4"  maxlength="4" >
	<?
	if (($db_opcao < 3) || ($db_opcao == 4)) {
		?>
		<script>
		var PosMouseY, PosMoudeX;

		function js_comparaDatas<?=($nomevar==""?$nome:$nomevar).""?>(dia,mes,ano){
			var objData        = document.getElementById('<?=($nomevar==""?$nome:$nomevar).""?>');
			objData.value      = dia+"/"+mes+'/'+ano;
			<?=$jsRetornoCal?>
		}
		</script>
		<?
		if (isset($dbtype) && strtolower($dbtype) == strtolower('hidden')) {
			$sButtonType = "hidden";
		}
		?>
			<input value="D"
			       type="<?=$sButtonType?>"
			       name="dtjs_<?=($nomevar==""?$nome:$nomevar)?>"
			       onclick="<?=$onclickBT?>pegaPosMouse(event);show_calendarsaude('<?=($nomevar==""?$nome:$nomevar)?>','<?=$shutdown_function?>',<?=$intEspecmed ?>)"  >
		<?
	}
} //fim function


//função para mostrar mensagens de aviso ao usuário

function MsgAviso($codescola,$tabela,$arquivo=null,$where=null){
 include("classes/db_".trim($tabela)."_classe.php");
 $instancia = "cl_".$tabela;
 $cltabela = new $instancia;
 if(trim($tabela)=="escola"){
  $result = $cltabela->sql_record($cltabela->sql_query("","*",""," ed18_i_codigo = $codescola"));
 }else{
  $result = $cltabela->sql_record($cltabela->sql_query("","*","","$where"));
 }
 if($cltabela->numrows==0){
  $where = $arquivo!=null?"AND ed90_c_arquivo = '$arquivo'":"";
  $sql = "SELECT * FROM msgaviso
          WHERE trim(ed90_c_tabela) = '$tabela'
          $where";
  $result1 = pg_query($sql);
  $dados = pg_fetch_array($result1);
  $arquivo = trim($dados['ed90_c_arqdestino']);
  ?>
  <br>
  <center>
  <fieldset style="width:90%"><legend><b>Aviso Importante:</b></legend>
   <?=$dados["ed90_t_msg"]?><br><br>
   <a href="javascript:location.href='<?=$arquivo?>'" title="<?=$dados['ed90_c_titulolink']?>"><?=$dados["ed90_c_descrlink"]?></a>
  </fieldset>
  </center>
  <?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  exit;
 }
}
function DiasLetivos($data_inicio,$data_fim,$sabado,$calendario,$retorno){
 $data_in = mktime(0,0,0,substr($data_inicio,5,2),substr($data_inicio,8,2),substr($data_inicio,0,4));
 $data_out = mktime(0,0,0,substr($data_fim,5,2),substr($data_fim,8,2),substr($data_fim,0,4));
 #pega a data de saida em UNIX_TIMESTAMP e diminui da data de entrada UNIX_TIMESTAMP
 $data_entre = $data_out - $data_in;
 #divide a diferenca das datas pelo numero de segundos de um dia e arredonda, para saber o numero de dias inteiro que tem
 $dias = ceil($data_entre/86400);
 $dias2 = $dias;
 $day = 0;
 $nao_util = 0;
 #pega dia, mes e ano da data de entrada
 $mes_inicial = date('m', $data_in);
 $d = date('d', $data_in);
 $m = date('m', $data_in);
 $y = date('Y', $data_in);
 #pega mes e ano da data de saida
 $m2 = date('m', $data_out);
 $y2 = date('Y', $data_out);
 #conta o numero de dias do mes de entrada
 $days_month = date("t", $data_in);
 $mi = date('m', $data_in);
 $semanas = 1;
 #se o dia da entrada + total de dias for menor que total de dias do mes, ou seja, se não passar do mesmo mês.
 if($dias+$d <= $days_month){
  for ($i = 0; $i < $dias+1; $i++){
   $letivo = true;
   $day++;
   #checa o dia da semana para cada dia do mês, se for igual a 0 (domingo) ou 6 (sabado) ele adiciona 1 no dia não útil
   if($sabado=="N"){
    if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 || date("w", mktime (0,0,0,$m,$d+$i,$y)) == 6){
     #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
     $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
     if(pg_num_rows($res)==0){
      $nao_util++;
      $letivo = false;
     }else{
      if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
       $nao_util++;
       $letivo = false;
      }
     }
    }else{
     #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
     $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
     if($row = pg_fetch_assoc($res)){
      $nao_util++;
      $letivo = false;
     }
    }
   }else{
    if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 ){
     #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
     $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
     if(pg_num_rows($res)==0){
      $nao_util++;
      $letivo = false;
     }else{
      if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
       $nao_util++;
       $letivo = false;
      }
     }
    }else{
     #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
     $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
     if($row = pg_fetch_assoc($res)){
      $nao_util++;
      $letivo = false;
     }
    }
   }
   if($letivo==true){
    $dia_mes_letivo[] = (strlen($d+$i)==1?"0".($d+$i):($d+$i))."-".(strlen($m)==1?"0".$m:$m);
   }
  }
 #se o dia da entrada + total de dias for maior que total de dias do mes, ou seja, se passar do mesmo mês.
 }else{
  #enquanto o mês de entrada for diferente do mês de saida ou ano de entrada for diferente do ano de saida.
  while($m != $m2 || $y != $y2){
   #pega total de dias do mes de entrada
   if($m==$mi){
    $days_month = date("t", mktime (0,0,0,$m,$d,$y))-$d+1;
   }else{
    $days_month = date("t", mktime (0,0,0,$m,$d,$y));
   }
   for ($i = 0; $i < $days_month; $i++){
    $letivo = true;
    $day++;
    #checa o dia da semana para cada dia do mês, se for igual a 0 (domingo) ou 6 (sabado) ele adiciona 1 no dia não útil
    if($sabado=="N"){
     if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 || date("w", mktime (0,0,0,$m,$d+$i,$y)) == 6){
      #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
      $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
      if(pg_num_rows($res)==0){
       $nao_util++;
       $letivo = false;
      }else{
       if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
        $nao_util++;
        $letivo = false;
       }
      }
     }else{
      #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
      $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
      if($row = pg_fetch_assoc($res)){
       $nao_util++;
       $letivo = false;
      }
     }
    }else{
     if (date("w", mktime (0,0,0,$m,$d+$i,$y)) == 0 ){
      #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
      $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
      if(pg_num_rows($res)==0){
       $nao_util++;
       $letivo = false;
      }else{
       if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
        $nao_util++;
        $letivo = false;
       }
      }
     }else{
      #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
      $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
      if($row = pg_fetch_assoc($res)){
       $nao_util++;
       $letivo = false;
      }
     }
    }
    if($letivo==true){
     $dia_mes_letivo[] = (strlen($d+$i)==1?"0".($d+$i):($d+$i))."-".(strlen($m)==1?"0".$m:$m);
    }
   }
   #se o mes for igual a 12 (dezembro), mes recebe 1 (janeiro) e ano recebe +1 (próximo ano)
   if($m == 12){
    $m = 1;
    $y++;
   #mês recebe mais 1 para fazer o mesmo processo do próximo mês
   }else{
    $m++;
   }
   $d = 1;
   //$dias2 = $dias2 - $day;
   if($m==$m2){
    $d3 = date('d', $data_out);
    $m3 = date('m', $data_out);
    $y3 = date('Y', $data_out);
    for ($i = 0; $i < $d3; $i++){
     $letivo = true;
     $day++;
     #checa o dia da semana para cada dia do mês, se for igual a 0 (domingo) ou 6 (sabado) ele adiciona 1 no dia não útil
     if($sabado=="N"){
      if(date("w", mktime (0,0,0,$m3,$d+$i,$y3)) == 0 || date("w", mktime (0,0,0,$m3,$d+$i,$y3)) == 6){
       #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
       $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m3 AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
       if(pg_num_rows($res)==0){
        $nao_util++;
        $letivo = false;
       }else{
        if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
         $nao_util++;
         $letivo = false;
        }
       }
      }else{
       #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
       $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m3 AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
       if($row = pg_fetch_assoc($res)){
        $nao_util++;
        $letivo = false;
       }
      }
     }else{
      if (date("w", mktime (0,0,0,$m3,$d+$i,$y3)) == 0 ){
       #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
       $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m3 AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario");
       if(pg_num_rows($res)==0){
        $nao_util++;
        $letivo = false;
       }else{
        if(pg_result($res,0,'ed54_c_dialetivo')=="N"){
         $nao_util++;
         $letivo = false;
        }
       }
      }else{
       #pesquisa no banco os feriados cadastrados se retornar aquele dia ele adiciona 1 no dia não útil
       $res = pg_query("SELECT * FROM feriado WHERE extract(month from ed54_d_data)=$m3 AND extract(day from ed54_d_data)=$d+$i AND ed54_i_calendario=$calendario AND ed54_c_dialetivo = 'N' ");
       if($row = pg_fetch_assoc($res)){
        $nao_util++;
        $letivo = false;
       }
      }
     }
     if($letivo==true){
      $dia_mes_letivo[] = (strlen($d+$i)==1?"0".($d+$i):($d+$i))."-".(strlen($m3)==1?"0".$m3:$m3);
     }
    }
   }
  }
 }
 $diasletivos = $day-$nao_util;
 $cont = 0;
 for($r=0;$r<count($dia_mes_letivo);$r++){
  $array_data = explode("-",$dia_mes_letivo[$r]);
  if(trim($array_data[1])!=$mes_inicial || $r==(count($dia_mes_letivo)-1)){
   $mes_qtdias[] = $mes_inicial.",".($r==(count($dia_mes_letivo)-1)?$cont+1:$cont);
   $mes_inicial = $array_data[1];
   $cont = 0;
  }
  $cont++;
 }
 if($retorno==1){
  return $diasletivos;
 }elseif($retorno==2){
  return $dia_mes_letivo;
 }elseif($retorno==3){
  return $mes_qtdias;
 }
}
function Situacao($situacao,$matricula){
 if(trim($situacao)=="MATRICULADO"){
  $sql = "SELECT ed60_c_tipo
          FROM matricula
          WHERE ed60_i_codigo = $matricula
         ";
  $result = pg_query($sql);
  $tipo = pg_result($result,0,0);
  if($tipo=="N"){
   $retorno = "MATRICULADO";
  }else{
   $retorno = "REMATRICULADO";
  }
 }else{
  $retorno = $situacao;
 }
 return $retorno;
}

function eduparametros($escola){
 $sql2 = "SELECT *
          FROM edu_parametros
          WHERE ed233_i_escola = $escola
         ";
 $result2 = pg_query($sql2);
 if(pg_num_rows($result2)>0){
  $retorno = pg_result($result2,0,"ed233_c_decimais");
 }else{
  $retorno = null;
 }
 return $retorno;
}

function TiraAcento($string){
 set_time_limit(240);
 $acentos = 'áéíóúÁÉÍÓÚàÀÂâÊêôÔüÜïÏöÖñÑãÃõÕçÇªºäÄ\'';
 $letras  = 'AEIOUAEIOUAAAAEEOOUUIIOONNAAOOCCAOAA ';
 $new_string = '';
 for($x=0; $x<strlen($string); $x++){
  $let = substr($string, $x, 1);
  for($y=0; $y<strlen($acentos); $y++){
   if($let==substr($acentos, $y, 1)){
    $let=substr($letras, $y, 1);
    break;
   }
  }
  $new_string = $new_string . $let;
 }
 return $new_string;
}

function VerParametroNota($escola){
 $sql2 = "SELECT *
          FROM edu_parametros
          WHERE ed233_i_escola = $escola
         ";
 $result2 = pg_query($sql2);
 if(pg_num_rows($result2)>0){
  $retorno = pg_result($result2,0,"ed233_c_notabranca");
 }else{
  $retorno = "N";
 }
 return $retorno;
}
function calcage($dd,$mm,$yy,$dd2,$mm2,$yy2){
    $yy  = $yy * 1;
    $yy2 = $yy2 * 1;

    if ($yy < 100 && $yy < 20){$yy = $yy + 2000;}
    if ($yy2 < 100 && $yy2 > 20){$yy2 = $yy2 + 1900;}
    if ($yy2 < 100 && $yy2 < 20){$yy2 = $yy2 + 2000;}

    //firstdate = new Date(mm+'/'+ dd +'/'+ yy)
    $mm = $mm + 1;

    //seconddate = new Date(mm2+'/'+ dd2 +'/'+ yy2)
    $mm2 = $mm2 + 1;

    $ageyears = $yy2 - $yy;

    if($mm2 == $mm){
          if($dd2 < $dd){
               $mm2 = $mm2 + 12;
               $ageyears = $ageyears - 1;
          }
    }

    if($mm2 < $mm){
          $mm2 = $mm2 + 12;
          $ageyears = $ageyears - 1;
          $agemonths = $mm2 - $mm;
     }

     $agemonths = $mm2 - $mm;

    if ($dd2 < $dd) {
          $agemonths = $agemonths - 1;
          $dd2 = $dd2 + 30;
          if ($mm2 == $mm) {
               $agemonths = 0;
               $ageyears = $ageyears - 1;
          }
     }
     $agedays = $dd2 - $dd;

     return $totalage =  $ageyears . ' anos, '. $agemonths .' meses e '. $agedays .' dias';
}

function ResultadoFinal($ed60_i_codigo,$ed60_i_aluno,$ed60_i_turma,$ed60_c_situacao,$ed60_c_concluida){
 if(trim($ed60_c_situacao)=="CLASSIFICADO" || trim($ed60_c_situacao)=="AVANÇADO"){
  $resultado = "APROVADO";
 }elseif(trim($ed60_c_situacao)=="TRANSFERIDO FORA" || trim($ed60_c_situacao)=="TRANSFERIDO REDE"){
  if($ed60_c_concluida=="S"){
   $resultado = Situacao($ed60_c_situacao,$ed60_i_codigo);
  }else{
   $resultado = "EM ANDAMENTO";
  }
 }else{
  $sql4 = "SELECT ed95_c_encerrado
           FROM diario
            inner join aluno on ed47_i_codigo = ed95_i_aluno
            inner join diariofinal on ed74_i_diario = ed95_i_codigo
            inner join regencia on ed59_i_codigo = ed95_i_regencia
           WHERE ed95_i_aluno = $ed60_i_aluno
           AND ed95_i_regencia in (select ed59_i_codigo
                                   from regencia
                                   where ed59_i_turma = $ed60_i_turma
                                   and ed59_c_condicao = 'OB')
          ";
  $result4 = pg_query($sql4);
  $linhas4 = pg_num_rows($result4);
  if($linhas4==0){
   $resultado = "EM ANDAMENTO";
  }else{
   $sql41 = "SELECT ed74_c_resultadofinal
             FROM diario
              inner join aluno on ed47_i_codigo = ed95_i_aluno
              inner join diariofinal on ed74_i_diario = ed95_i_codigo
             WHERE ed95_i_aluno = $ed60_i_aluno
             AND ed95_i_regencia in (select ed59_i_codigo
                                     from regencia
                                     where ed59_i_turma = $ed60_i_turma
                                     and ed59_c_condicao = 'OB')
            ";
   $result41 = pg_query($sql41);
   $linhas41 = pg_num_rows($result41);
   $res_final = "";
   $sep = "";
   for($f=0;$f<$linhas4;$f++){
    $ed74_c_resultadofinal = pg_result($result41,$f,'ed74_c_resultadofinal')==""?" ":pg_result($result41,$f,'ed74_c_resultadofinal');
    $res_final .= $sep.$ed74_c_resultadofinal;
    $sep = ",";
   }
   if(strstr($res_final," ")){
    $resultado = "EM ANDAMENTO";
   }elseif(strstr($res_final,"R")){
    $resultado = "REPROVADO";
   }else{
    $resultado = "APROVADO";
   }
  }
 }
 return $resultado;
}

function LimpaResultadoFinal($matricula){
 $result = pg_query("SELECT ed60_i_turma,ed60_i_aluno FROM matricula WHERE ed60_i_codigo = $matricula");
 $ed60_i_turma = pg_result($result,0,0);
 $ed60_i_aluno = pg_result($result,0,1);
 $result1 = pg_query("UPDATE diariofinal SET
                       ed74_i_procresultadoaprov = null,
                       ed74_c_valoraprov = '',
                       ed74_c_resultadoaprov = '',
                       ed74_i_procresultadofreq = null,
                       ed74_i_percfreq = null,
                       ed74_c_resultadofreq = '',
                       ed74_c_resultadofinal = ''
                      WHERE ed74_i_diario in (select ed95_i_codigo
                                              from diario
                                              where ed95_i_aluno = $ed60_i_aluno
                                              and ed95_i_regencia in (select ed59_i_codigo
                                                                      from regencia
                                                                      where ed59_i_turma = $ed60_i_turma
                                                                      )
                                              )
                     ");
}

function MatriculaPosterior($turma,$aluno){
 $sql1 = "SELECT ed52_i_ano,ed52_d_inicio,ed52_i_codigo
          FROM turma
           inner join calendario on ed52_i_codigo = ed57_i_calendario
          WHERE ed57_i_codigo = $turma
        ";
 $result1 = pg_query($sql1);
 $ed52_i_ano = pg_result($result1,0,'ed52_i_ano');
 $ed52_d_inicio = pg_result($result1,0,'ed52_d_inicio');
 $ed52_i_codigo = pg_result($result1,0,'ed52_i_codigo');
 $sql2 = "SELECT ed60_i_codigo
          FROM matricula
           inner join turma on ed57_i_codigo = ed60_i_turma
           inner join calendario on ed52_i_codigo = ed57_i_calendario
          WHERE ed60_i_aluno = $aluno
          AND ed52_i_ano >= $ed52_i_ano
          AND ed52_d_inicio > '$ed52_d_inicio'
          AND ed52_i_codigo != $ed52_i_codigo
         ";
 $result2 = pg_query($sql2);
 $linhas2 = pg_num_rows($result2);
 if($linhas2>0){
  $retorno = "SIM";
 }else{
  $retorno = "NAO";
 }
 return $retorno;
}
?>
