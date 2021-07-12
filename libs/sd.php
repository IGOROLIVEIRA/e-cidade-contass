<?
//header("Connection: Keep-Alive");
//header("Keep-Alive: ");
/*


header("Expect: 100-continue");
*/
/*
//header("Keep-Alive: timeout=0, max=0");
// Data no passado
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
// Sempre modificado
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
// HTTP/1.0
header("Pragma: no-cache");
*/

function db_pf($recordset)
{
  $numfields = pg_numfields($recordset);
  $numrows = pg_numrows($recordset);
  echo "<br><br><br><table border=\"1\"><tr bgcolor=\"#9CDBFC\">\n";
  for ($j = 0; $j < $numfields; $j++)
    echo "<th>" . pg_fieldname($recordset, $j) . "</th>\n";
  echo "</tr>\n";
  for ($i = 0; $i < $numrows; $i++) {
    echo "<tr bgcolor=\"" . ($i % 2 == 0 ? "#9EFAD2" : "#1DF398") . "\">\n";
    for ($j = 0; $j < $numfields; $j++) {
      $str = pg_result($recordset, $i, $j);
      echo "<td>" . (trim($str) == "" ? "&nbsp;" : $str) . "</td>\n";
    }
    echo "</tr>\n";
  }
  echo "</table>\n";
}

class janela
{
  var $nome;
  var $arquivo;
  var $iniciarVisivel = true;
  var $largura = "400";
  var $altura = "400";
  var $posX = "10";
  var $posY = "10";
  var $scrollbar = "auto"; // pode ser tb, 0 ou 1
  var $corFundoTitulo = "#2C7AFE";
  var $corTitulo = "white";
  var $fonteTitulo = "Arial, Helvetica, sans-serif";
  var $tamTitulo = "11";
  var $titulo = "DBSeller Informática Ltda";
  var $janBotoes = "101";

  function __construct($nome, $arquivo)
  {
    $this->nome = $nome;
    $this->arquivo = $arquivo;
  }
  function mostrar()
  {
    if ($this->iniciarVisivel == true)
      $this->iniciarVisivel = "visible";
    else
      $this->iniciarVisivel = "hidden";
?>
    <div id="Jan<? echo $this->nome ?>" style=" background-color: #c0c0c0;border: 0px outset #666666;position:absolute; left:<? echo $this->posX ?>px; top:<? echo $this->posY ?>px; width:<? echo $this->largura ?>px; height:<? echo $this->altura ?>px; z-index:1; visibility: <? echo $this->iniciarVisivel ?>;">
      <table width="100%" height="100%" style="border-color: #f0f0f0 #606060 #404040 #d0d0d0;border-style: solid;  border-width: 2px;" border="0" cellspacing="0" cellpadding="2">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr id="CF<? echo $this->nome ?>" style="white-space: nowrap;background-color:<? echo $this->corFundoTitulo ?>">
                <td nowrap onmousedown="js_engage(document.getElementById('Jan<? echo $this->nome ?>'),event)" onmouseup="js_release(document.getElementById('Jan<? echo $this->nome ?>'),event)" onmousemove="js_dragIt(document.getElementById('Jan<? echo $this->nome ?>'),event)" onmouseout="js_release(document.getElementById('Jan<? echo $this->nome ?>'),event)" width="80%" style="cursor:hand;font-weight: bold;color: <? echo $this->corTitulo ?>;font-family: <? echo $this->fonteTitulo ?>;font-size: <? echo $this->tamTitulo ?>px">&nbsp;<? echo $this->titulo ?></td>
                <td width="20%" align="right" valign="middle" nowrap><? $kp = 0x4;
                                                                      $m = $kp & $this->janBotoes;
                                                                      $kp >>= 1; ?><img <? echo $m ? 'style="cursor:hand"' : "" ?> src=<? echo $m ? "imagens/jan_mini_on.gif" : "imagens/jan_mini_off.gif" ?> title="Minimizar" border="0" onClick="js_MinimizarJan(this,'<? echo $this->nome ?>')"><? $m = $kp & $this->janBotoes;
                                                                                                                                                                                                                                                                                                    $kp >>= 1; ?><img <? echo $m ? 'style="cursor:hand"' : "" ?> src=<? echo $m ? "imagens/jan_max_on.gif" : "imagens/jan_max_off.gif" ?> title="Maximizar" border="0" onClick="js_MaximizarJan(this,'<? echo $this->nome ?>')"><? $m = $kp & $this->janBotoes;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                $kp >>= 1; ?><img <? echo $m ? 'style="cursor:hand"' : "" ?> src=<? echo $m ? "imagens/jan_fechar_on.gif" : "imagens/jan_fechar_off.gif" ?> title="Fechar" border="0" onClick="js_FecharJan(this,'<? echo $this->nome ?>')"></td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td width="100%" height="100%"><iframe frameborder="1" style="border-color:#C0C0F0" height="100%" width="100%" id="IF<? echo $this->nome ?>" name="IF<? echo $this->nome ?>" scrolling="<? echo $this->scrollbar ?>" src="<? echo $this->arquivo ?>"></iframe></td>
        </tr>
      </table>
    </div>
    <script>
      <? echo $this->nome ?> = new janela(document.getElementById('Jan<? echo $this->nome ?>'), document.getElementById('CF<? echo $this->nome ?>'), IF<? echo $this->nome ?>);
    </script>
  <?
  }
}




//////////// CLASSE ROTULO  ///////////
/// ESTA CLASSE CRIA AS VARIAVEIS DE LABEL E TITLE DAS PÁGINAS ///
class rotulovelho
{
  var $tabela;
  function __construct($tabela)
  {
    $this->tabela = $tabela;
  }
  function label($nome = "")
  {
    $result = pg_exec("select c.descricao,c.rotulo,c.nomecam
	                   from db_syscampo c
					   inner join db_sysarqcamp s
					   on s.codcam = c.codcam
					   inner join db_sysarquivo a
					   on a.codarq = s.codarq
					   where a.nomearq = '" . $this->tabela . "'
					   " . ($nome != "" ? "and trim(c.nomecam) = trim('$nome')" : ""));
    $numrows = pg_numrows($result);
    for ($i = 0; $i < $numrows; $i++) {
      $variavel = trim("L" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = "<strong>" . pg_result($result, $i, "rotulo") . ":</strong>";
      $variavel = trim("T" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "descricao") . "\n\nCampo:" . trim("T" . pg_result($result, $i, "nomecam"));
    }
  }
}

class rotulo
{
  var $tabela;
  function __construct($tabela)
  {
    $this->tabela = $tabela;
  }
  function label($nome = "")
  {
    $result = pg_exec("select c.descricao,c.rotulo,c.nomecam,c.tamanho,c.nulo,c.maiusculo,c.autocompl,c.conteudo,c.aceitatipo
	                   from db_syscampo c
					   inner join db_sysarqcamp s
					   on s.codcam = c.codcam
					   inner join db_sysarquivo a
					   on a.codarq = s.codarq
					   where a.nomearq = '" . $this->tabela . "'
					   " . ($nome != "" ? "and trim(c.nomecam) = trim('$nome')" : ""));
    $numrows = pg_numrows($result);
    for ($i = 0; $i < $numrows; $i++) {
      /// variavel com o tipo de campo
      $variavel = trim("I" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "aceitatipo");
      /// variavel para determinar o autocomplete
      $variavel = trim("A" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      if (pg_result($result, $i, "autocompl") == 'f') {
        ${$variavel} = "off";
      } else {
        ${$variavel} = "on";
      }
      /// variavel para preenchimento obrigatorio
      $variavel = trim("U" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "nulo");
      /// variavel para colocar maiusculo
      $variavel = trim("G" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "maiusculo");
      /// variavel para colocar no erro do javascript de preenchimento de campo
      $variavel = trim("S" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "rotulo");
      /// variavel para colocar como label de campo
      $variavel = trim("L" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = "<strong>" . ucfirst(pg_result($result, $i, "rotulo")) . ":</strong>";
      /// vaariavel para colocat na tag title dos campos
      $variavel = trim("T" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = ucfirst(pg_result($result, $i, "descricao")) . "\n\nCampo:" . pg_result($result, $i, "nomecam");
      /// variavel para incluir o tamanhoda tag maxlength dos campos
      $variavel = trim("M" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "tamanho");
      /// variavel para controle de campos nulos
      $variavel = trim("N" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "nulo");
      if (${$variavel} == "t")
        ${$variavel} = "style=\"background-color:#E6E4F1\"";
      else
        ${$variavel} = "";
    }
  }
  function tlabel($nome = "")
  {
    $result = pg_exec("select c.nomearq,c.descricao,c.nomearq
	                   from db_sysarquivo c
					   where trim(c.nomearq) = '" . $this->tabela . "'");
    $numrows = pg_numrows($result);
    if ($numrows > 0) {
      $variavel = trim("L" . pg_result($result, $i, "nomearq"));
      global ${$variavel};
      ${$variavel} = "<strong>" . pg_result($result, $i, "nomearq") . ":</strong>";
      $variavel = trim("T" . pg_result($result, $i, "nomearq"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "descricao");
    }
  }
}

class rotulocampo
{
  function label($campo = "")
  {
    $result = pg_exec("select c.descricao,c.rotulo,c.nomecam,c.tamanho,c.nulo,c.maiusculo,c.autocompl,c.conteudo,c.aceitatipo
	                   from db_syscampo c
					   where trim(c.nomecam) = trim('$campo')");
    $numrows = pg_numrows($result);
    for ($i = 0; $i < $numrows; $i++) {

      /// variavel com o tipo de campo
      $variavel = trim("I" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "aceitatipo");
      /// variavel para determinar o autocomplete
      $variavel = trim("A" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      if (pg_result($result, $i, "autocompl") == 'f') {
        ${$variavel} = "off";
      } else {
        ${$variavel} = "on";
      }
      /// variavel para preenchimento obrigatorio
      $variavel = trim("U" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "nulo");
      /// variavel para colocar maiusculo
      $variavel = trim("G" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "maiusculo");
      /// variavel para colocar no erro do javascript de preenchimento de campo
      $variavel = trim("S" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "rotulo");
      /// variavel para colocar como label de campo
      $variavel = trim("L" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = "<strong>" . ucfirst(pg_result($result, $i, "rotulo")) . ":</strong>";
      /// vaariavel para colocat na tag title dos campos
      $variavel = trim("T" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = ucfirst(pg_result($result, $i, "descricao")) . "\n\nCampo:" . pg_result($result, $i, "nomecam");
      /// variavel para incluir o tamanhoda tag maxlength dos campos
      $variavel = trim("M" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "tamanho");
      /// variavel para controle de campos nulos
      $variavel = trim("N" . pg_result($result, $i, "nomecam"));
      global ${$variavel};
      ${$variavel} = pg_result($result, $i, "nulo");
      if (${$variavel} == "t")
        ${$variavel} = "style=\"background-color:#E6E4F1\"";
      else
        ${$variavel} = "";
    }
  }
}
class rotulolov
{
  var $titulo = null;
  var $title = null;
  var $tamanho = null;
  function label($nome = "")
  {
    if (substr($nome, 0, 3) == "dl_") {
      $this->titulo = substr($nome, 3);
      $this->title  = substr($nome, 3);
      $this->tamanho = 0;
    } else {
      $result = pg_exec("select c.descricao,c.rotulo,c.tamanho
	                    from db_syscampo c
		 			   where trim(c.nomecam) = trim('$nome')");
      $numrows = pg_numrows($result);
      if ($numrows != 0) {
        $this->titulo  = ucfirst(pg_result($result, 0, "rotulo"));
        $this->title   = ucfirst(pg_result($result, 0, "descricao"));
        $this->tamanho = pg_result($result, 0, "tamanho");
      } else {
        $this->titulo  = "";
        $this->title   = "";
        $this->tamanho = "";
      }
    }
  }
}


//header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');

//Variavel com a URL absoluta, menos o arquivo
$DB_URL_ABS = "http://" . $HTTP_SERVER_VARS['HTTP_HOST'] . substr($HTTP_SERVER_VARS['PHP_SELF'], 0, strrpos($HTTP_SERVER_VARS['PHP_SELF'], "/") + 1);
//Variavel com a URL absoluta da pagina que abriu a atual, menos o arquivo
if (isset($HTTP_SERVER_VARS["HTTP_REFERER"]))
  $DB_URL_REF = substr($HTTP_SERVER_VARS["HTTP_REFERER"], 0, strrpos($HTTP_SERVER_VARS["HTTP_REFERER"], "/") + 1);

//troca os caracteres especiais em tags html

//if(basename($HTTP_SERVER_VARS['PHP_SELF']) != "/~dbjoao/dbportal2/pre4_mensagens001.php") {
if (basename($HTTP_SERVER_VARS['PHP_SELF']) != "pre4_mensagens001.php") {
  $tam_vetor = sizeof($HTTP_POST_VARS);
  reset($HTTP_POST_VARS);
  for ($i = 0; $i < $tam_vetor; $i++) {
    if (gettype($HTTP_POST_VARS[key($HTTP_POST_VARS)]) != "array")
      $HTTP_POST_VARS[key($HTTP_POST_VARS)] = ($HTTP_POST_VARS[key($HTTP_POST_VARS)]);
    next($HTTP_POST_VARS);
  }
  $tam_vetor = sizeof($HTTP_GET_VARS);
  reset($HTTP_GET_VARS);
  for ($i = 0; $i < $tam_vetor; $i++) {
    if (gettype($HTTP_GET_VARS[key($HTTP_GET_VARS)]) != "array")
      $HTTP_GET_VARS[key($HTTP_GET_VARS)] = ($HTTP_GET_VARS[key($HTTP_GET_VARS)]);
    next($HTTP_GET_VARS);
  }
}

// Verifica se esta sendo passado algum comando SQL
function db_verfPostGet($post)
{
  $tam_vetor = sizeof($post);
  reset($post);
  for ($i = 0; $i < $tam_vetor; $i++) {
    if (key($post) != 'corpofuncao' && key($post) != 'eventotrigger')
      $dbarraypost = (gettype($post[key($post)]) != "array" ? $post[key($post)] : "");
    if (
      db_indexOf(strtoupper($dbarraypost), "INSERT") > 0 ||
      db_indexOf(strtoupper($dbarraypost), "UPDATE") > 0 ||
      db_indexOf(strtoupper($dbarraypost), "DELETE") > 0 ||
      db_indexOf(strtoupper($dbarraypost), "EXEC(")  > 0 ||
      db_indexOf(strtoupper($dbarraypost), "SYSTEM(")  > 0 ||
      db_indexOf(strtoupper($dbarraypost), "PASSTHRU(")  > 0
    ) {
      echo "<script>alert('Voce está passando parametros inválidos e sera redirecionado.');location.href='http://localhost/dbportal/modulos.php'</script>\n";
      exit;
    }
    //$post[key($post)] = htmlspecialchars(gettype($post[key($post)])!="array"?$post[key($post)]:"");
    next($post);
  }
}
db_verfPostGet($HTTP_POST_VARS);
db_verfPostGet($HTTP_GET_VARS);


function db_criatabela($result)
{
  $numrows = pg_numrows($result);
  $numcols = pg_numfields($result);
  ?> <br><br>
  <table border="1" cellpadding="0" cellspacing="0"> <?
                                                      echo "<tr bgcolor=\"#00CCFF\">\n";
                                                      for ($j = 0; $j < $numcols; $j++) {
                                                        echo "<td>" . pg_fieldname($result, $j) . "</td>\n";
                                                      }
                                                      $cor = "#07F89D";
                                                      echo "</tr>\n";
                                                      for ($i = 0; $i < $numrows; $i++) {
                                                        echo "<tr bgcolor=\"" . ($cor = ($cor == "#07F89D" ? "#51F50A" : "#07F89D")) . "\">\n";
                                                        for ($j = 0; $j < $numcols; $j++) {
                                                          echo "<td nowrap>" . pg_result($result, $i, $j) . "</td>\n";
                                                        }
                                                        echo "</tr>\n";
                                                      }
                                                      ?> </table><br><br> <?
                                                                        }



                                                                        //retorna o tamanho do maior registro
                                                                        function db_getMaxSizeField($recordset, $campo = 0)
                                                                        {
                                                                          $numrows = pg_numrows($recordset);
                                                                          $val = strlen(trim(pg_result($recordset, 0, $campo)));
                                                                          for ($i = 1; $i < $numrows; $i++) {
                                                                            $field = strlen(trim(pg_result($recordset, $i, $campo)));
                                                                            if ($val < $field)
                                                                              $val = $field;
                                                                          }
                                                                          return (int)$val;
                                                                        }
                                                                        //Pega um vetor e cria variaveis globais pelo indice do vetor
                                                                        //atualiza a classe dos arquivos
                                                                        function db_postmemory($vetor, $verNomeIndices = 0)
                                                                        {
                                                                          if (!is_array($vetor)) {
                                                                            echo "Erro na função postmemory: Parametro não é um array válido.<Br>\n";
                                                                            return false;
                                                                          }
                                                                          $tam_vetor = sizeof($vetor);
                                                                          reset($vetor);
                                                                          if ($verNomeIndices > 0)
                                                                            echo "<br><br>\n";
                                                                          for ($i = 0; $i < $tam_vetor; $i++) {
                                                                            $matriz[$i] = key($vetor);
                                                                            global ${$matriz[$i]};
                                                                            ${$matriz[$i]} = $vetor[$matriz[$i]];
                                                                            if ($verNomeIndices == 1)
                                                                              echo "$" . $matriz[$i] . "<br>\n";
                                                                            else if ($verNomeIndices == 2)
                                                                              echo "$" . $matriz[$i] . " = '" . ${$matriz[$i]} . "';<br>\n";
                                                                            next($vetor);
                                                                          }
                                                                          if ($verNomeIndices > 0)
                                                                            echo "<br><br>\n";
                                                                        }


                                                                        // retorna uma string formatada, retorna false se alguma opção estiver errada
                                                                        // $tipo pode ser:
                                                                        // "f" formata a string pra float
                                                                        // "d" formata a string pra data
                                                                        // "v" tira a formatação
                                                                        // "s"  Preenche uma string para um certo tamanho com outra string
                                                                        // se for "s":
                                                                        //   $caracter             caracter ou espaço pra acrecentar a esquerda, direita ou meio
                                                                        //   $quantidade           tamanho que ficará a string com os espaços ou caracteres
                                                                        //   $TipoDePreenchimento  informa se vai aplicar a string a:
                                                                        //                         esquerda       "e"
                                                                        //                         direita        "d"
                                                                        //                         ambos os lados "a"
                                                                        function db_formatar($str, $tipo, $caracter = " ", $quantidade = 0, $TipoDePreenchimento = "e")
                                                                        {
                                                                          switch ($tipo) {
                                                                            case "b":
                                                                              if ($str == false) {
                                                                                return 'N';
                                                                              } else {
                                                                                return 'S';
                                                                              }
                                                                            case "f":
                                                                              if ($quantidade == 0)
                                                                                return str_pad(number_format($str, 2, ",", "."), 15, $caracter, STR_PAD_LEFT);
                                                                              else
                                                                                return str_pad(number_format($str, 2, ",", "."), $quantidade, $caracter, STR_PAD_LEFT);
                                                                            case "d":
                                                                              $data = explode("-", $str);
                                                                              return $data[2] . "/" . $data[1] . "/" . $data[0];
                                                                            case "s":
                                                                              if ($TipoDePreenchimento == "e") {
                                                                                return str_pad($str, $quantidade, $caracter, STR_PAD_LEFT);
                                                                              } else if ($TipoDePreenchimento == "d") {
                                                                                return str_pad($str, $quantidade, $caracter, STR_PAD_RIGHT);
                                                                              } else if ($TipoDePreenchimento == "a") {
                                                                                return str_pad($str, $quantidade, $caracter, STR_PAD_BOTH);
                                                                              }
                                                                            case "v":
                                                                              if (strpos($str, ",") != "") {
                                                                                $str = str_replace(".", "", $str);
                                                                                $str = str_replace(",", ".", $str);
                                                                                return $str;
                                                                              } else if (strpos($str, "-") != "") {
                                                                                $str = explode("-", $str);
                                                                                return $str[2] . "-" . $str[1] . "-" . $str[0];
                                                                              } else if (strpos($str, "/") != "") {
                                                                                $str = explode("/", $str);
                                                                                return $str[2] . "-" . $str[1] . "-" . $str[0];
                                                                              }
                                                                              break;
                                                                          }
                                                                          return false;
                                                                        }

                                                                        //Cria veriaveis globais de todos os campos do recordset no indice $indice

                                                                        function db_fieldsmemory($recordset, $indice, $formatar = "")
                                                                        {
                                                                          $fm_numfields = pg_numfields($recordset);
                                                                          for ($i = 0; $i < $fm_numfields; $i++) {
                                                                            $matriz[$i] = pg_fieldname($recordset, $i);
                                                                            global ${$matriz[$i]};
                                                                            $aux = trim(pg_result($recordset, $indice, $matriz[$i]));
                                                                            if (!empty($formatar)) {
                                                                              switch (pg_fieldtype($recordset, $i)) {
                                                                                case "float8":
                                                                                case "float4":
                                                                                case "float":
                                                                                  ${$matriz[$i]} = number_format($aux, 2, ",", ".");
                                                                                  break;
                                                                                case "date":
                                                                                  if ($aux != "") {
                                                                                    $data = explode("-", $aux);
                                                                                    ${$matriz[$i]} = $data[2] . "/" . $data[1] . "/" . $data[0];
                                                                                  } else {
                                                                                    ${$matriz[$i]} = "";
                                                                                  }
                                                                                  break;
                                                                                default:
                                                                                  ${$matriz[$i]} = $aux;
                                                                                  break;
                                                                              }
                                                                            } else
                                                                              switch (pg_fieldtype($recordset, $i)) {
                                                                                case "date":
                                                                                  $datav = explode("-", $aux);
                                                                                  $split_data = $matriz[$i] . "_dia";
                                                                                  global ${$split_data};
                                                                                  ${$split_data} =  @$datav[2];
                                                                                  $split_data = $matriz[$i] . "_mes";
                                                                                  global ${$split_data};
                                                                                  ${$split_data} =  @$datav[1];
                                                                                  $split_data = $matriz[$i] . "_ano";
                                                                                  global ${$split_data};
                                                                                  ${$split_data} =  @$datav[0];
                                                                                  ${$matriz[$i]} = $aux;
                                                                                  break;
                                                                                default:
                                                                                  ${$matriz[$i]} = $aux;
                                                                                  break;
                                                                              }
                                                                          }
                                                                        }




                                                                        ///////  Calcula Digito Verificador
                                                                        ///////  sCampo - Valor  Ipeso - Qual peso 10 11

                                                                        function db_CalculaDV($sCampo, $iPeso = 11)
                                                                        {
                                                                          $mult = 2;
                                                                          $i = 0;
                                                                          $iDigito = 0;
                                                                          $iSoma1 = 0;
                                                                          $iDV1 = 0;
                                                                          $iTamCampo = strlen($sCampo);
                                                                          for ($i = $iTamCampo - 1; $i > -1; $i--) {
                                                                            $iDigito = $sCampo[$i];
                                                                            $iSoma1 = intval($iSoma1, 10) + intval(($iDigito * $mult), 10);
                                                                            $mult++;
                                                                            if ($mult > 9)
                                                                              $mult = 2;
                                                                          }
                                                                          $iDV1 = ($iSoma1 % 11);
                                                                          if ($iDV1 < 2)
                                                                            $iDV1 = 0;
                                                                          else
                                                                            $iDV1 = 11 - $iDV1;
                                                                          return $iDV1;
                                                                        }

                                                                        //funcao para a db_CalculaDV
                                                                        function db_Calcular_Peso($iPosicao, $iPeso)
                                                                        {
                                                                          return ($iPosicao % ($iPeso - 1)) + 2;
                                                                        }


                                                                        //formata uma string pra cgc ou cpf
                                                                        function db_cgccpf($str)
                                                                        {
                                                                          if (strlen($str) == 14)
                                                                            return substr($str, 0, 2) . "." . substr($str, 2, 3) . "." . substr($str, 5, 3) . "/" . substr($str, 8, 4) . "-" . substr($str, 12, 2);
                                                                          else if (strlen($str) == 11)
                                                                            return substr($str, 0, 3) . "." . substr($str, 3, 3) . "." . substr($str, 6, 3) . "-" . substr($str, 9, 2);
                                                                          else return $str;
                                                                        }

                                                                        function verifica_data($dia, $mes, $ano)
                                                                        {
                                                                          while ((checkdate($mes, $dia, $ano) == false) or  ((date("w", mktime(0, 0, 0, $mes, $dia, $ano)) == "0") or (date("w", mktime(0, 0, 0, $mes, $dia, $ano)) == "6"))) {
                                                                            if ($dia > 31) {
                                                                              $dia = 1;
                                                                              $mes++;
                                                                              if ($mes > 12) {
                                                                                $mes = 1;
                                                                                $ano++;
                                                                              }
                                                                            } else {
                                                                              $dia++;
                                                                            }
                                                                          }
                                                                          return $ano . "-" . $mes . "-" . $dia;
                                                                        }


                                                                        function db_vencimento($dt = "")
                                                                        {
                                                                          if (empty($dt))
                                                                            $dt = db_getsession("DB_datausu");
                                                                          $data = date("Y-m-d", $dt);
                                                                          if ((date("H", $dt) >= "16")) {
                                                                            $data = verifica_data(date("d", $dt) + 1, date("m", $dt), date("Y", $dt));
                                                                            //      echo $data;
                                                                          } else {
                                                                            if ((date("w", mktime(0, 0, 0, date("m", $dt), date("d", $dt), date("Y", $dt))) == "0") or (date("w", mktime(0, 0, 0, date("m", $dt), date("d", $dt), date("Y", $dt))) == "6")) {
                                                                              $data = verifica_data(date("d", $dt) + 1, date("m", $dt), date("Y", $dt));
                                                                            }
                                                                          }
                                                                          //  echo $data;
                                                                          return $data;
                                                                        }


                                                                        //mostra uma mensagem na tela
                                                                        function db_msgbox($msg)
                                                                        {
                                                                          echo "<script>alert('$msg')</script>\n";
                                                                        }

                                                                        //redireciona para uma url
                                                                        function db_redireciona($url = "0")
                                                                        {
                                                                          if ($url == "0")
                                                                            $url = $GLOBALS["PHP_SELF"];
                                                                          echo "<script>location.href='$url'</script>\n";
                                                                          exit;
                                                                        }

                                                                        //retorna uma variável de sessão
                                                                        /*
function db_getsession($var) {
  global $HTTP_SESSION_VARS;
  if(!class_exists("crypt_hcemd5"))
    include("db_calcula.php");
  $rand = 195728462;
  $key = "alapuchatche";
  $md = new Crypt_HCEMD5($key, $rand);
  return $md->decrypt($HTTP_SESSION_VARS[$var]);
}
*/

                                                                        //retorna uma variável de sessão
                                                                        function db_getsession($var = "0")
                                                                        {
                                                                          global $HTTP_SESSION_VARS;
                                                                          /*
  if(!class_exists("crypt_hcemd5"))
    include("db_calcula.php");
  $rand = 195728462;
  $key = "alapuchatche";
  $md = new Crypt_HCEMD5($key, $rand);
  if($var=="0"){
    reset($HTTP_SESSION_VARS);
    $str = "";
    $caract = "";
    for($x=0;$x<sizeof($HTTP_SESSION_VARS);$x++){
      $str .= $caract.key($HTTP_SESSION_VARS)."=".$md->decrypt($HTTP_SESSION_VARS[key($HTTP_SESSION_VARS)]);
      next($HTTP_SESSION_VARS);
      $caract = "&";
    }
    return $str;
  } else {
    return $md->decrypt($HTTP_SESSION_VARS[$var]);
  }
  */
                                                                          if ($var == "0") {
                                                                            reset($HTTP_SESSION_VARS);
                                                                            $str = "";
                                                                            $caract = "";
                                                                            for ($x = 0; $x < sizeof($HTTP_SESSION_VARS); $x++) {
                                                                              $str .= $caract . key($HTTP_SESSION_VARS) . "=" . $HTTP_SESSION_VARS[key($HTTP_SESSION_VARS)];
                                                                              next($HTTP_SESSION_VARS);
                                                                              $caract = "&";
                                                                            }
                                                                            return $str;
                                                                          } else {
                                                                            return $HTTP_SESSION_VARS[$var];
                                                                          }
                                                                        }

                                                                        //atualiza uma variável de sessao
                                                                        function db_putsession($var, $valor)
                                                                        {
                                                                          global $HTTP_SESSION_VARS;
                                                                          /*
  if(!class_exists("crypt_hcemd5"))
    include("db_calcula.php");
  $rand = 195728462;
  $key = "alapuchatche";
  $md = new Crypt_HCEMD5($key, $rand);
  $HTTP_SESSION_VARS[$var] = $md->encrypt($valor);
  */
                                                                          $HTTP_SESSION_VARS[$var] = $valor;
                                                                        }

                                                                        //coloca no tamanho e acrecenta caracteres '$qual' a esquerda
                                                                        function db_sqlformat($campo, $quant, $qual)
                                                                        {
                                                                          $aux = "";
                                                                          for ($i = strlen($campo); $i < $quant; $i++)
                                                                            $aux .= $qual;
                                                                          return  $aux . $campo;
                                                                        }

                                                                        //retorna uma string do inicio de $str, até primeiro caractere da ocorrencia em $pos
                                                                        function db_strpos($str, $pos)
                                                                        {
                                                                          return substr($str, 0, (strpos($str, $pos) == "" ? strlen($str) : strpos($str, $pos)));
                                                                        }

                                                                        //imprime uma mensagem de erro, com um link pra voltar pra página anterior
                                                                        function db_erro($msg, $voltar = 1)
                                                                        {
                                                                          $uri = $GLOBALS["PHP_SELF"];
                                                                          echo "$msg<br>\n";
                                                                          if ($voltar == 1)
                                                                            echo "<a href=\"$uri\">Voltar</a>\n";
                                                                          exit;
                                                                        }

                                                                        //Tipo a parseInt do javascript
                                                                        function db_parse_int($str)
                                                                        {
                                                                          $num = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
                                                                          $tam = strlen($str);
                                                                          $aux = "";
                                                                          for ($i = 0; $i < $tam; $i++) {
                                                                            if (in_array($str[$i], $num))
                                                                              $aux .= $str[$i];
                                                                          }
                                                                          return $aux;
                                                                        }

                                                                        // Tipo o indexOf do javascript
                                                                        function db_indexOf($str, $proc)
                                                                        {
                                                                          // 0 nao encontrou
                                                                          // > 0 encontrou
                                                                          return strlen(strstr($str, $proc));
                                                                        }




                                                                        //Executa um SELECT e pagina na tela com os labels do sistema
                                                                        function db_lovrot($query, $numlinhas, $arquivo = "", $filtro = "%", $aonde = "_self", $campos_layer = "", $NomeForm = "NoMe")
                                                                        {
                                                                          global $BrowSe;
                                                                          //cor do cabecalho
                                                                          global $db_corcabec;
                                                                          $db_corcabec = $db_corcabec == "" ? "#CDCDFF" : $db_corcabec;
                                                                          //cor de fundo de cada registro
                                                                          global $cor1;
                                                                          global $cor2;
                                                                          $mensagem = "Clique Aqui";
                                                                          $cor1 = $cor1 == "" ? "#97B5E6" : $cor1;
                                                                          $cor2 = $cor2 == "" ? "#E796A4" : $cor2;
                                                                          global $HTTP_POST_VARS;
                                                                          $tot_registros = "tot_registros" . $NomeForm;
                                                                          $offset = "offset" . $NomeForm;
                                                                          //recebe os valores do campo hidden
                                                                          if (isset($HTTP_POST_VARS["totreg" . $NomeForm])) {
                                                                            $$tot_registros = $HTTP_POST_VARS["totreg" . $NomeForm];
                                                                          } else {
                                                                            $$tot_registros = 0;
                                                                          }
                                                                          if (isset($HTTP_POST_VARS["offset" . $NomeForm])) {
                                                                            $$offset = $HTTP_POST_VARS["offset" . $NomeForm];
                                                                          } else {
                                                                            $$offset = 0;
                                                                          }
                                                                          // se for a primeira vez que é rodado, pega o total de registros e guarda no campo hidden
                                                                          if (empty($$tot_registros) && !empty($query)) {
                                                                            $Dd1 = "disabled";
                                                                            //$tot = pg_exec("select count(*) from ($query) as temp");
                                                                            $tot = 0;
                                                                            $$tot_registros = 0; //pg_result($tot,0,0);
                                                                          }
                                                                          // testa qual botao foi pressionado
                                                                          if (isset($HTTP_POST_VARS["pri" . $NomeForm])) {
                                                                            $$offset = 0;
                                                                            $Dd1 = "disabled";
                                                                            $query = str_replace("\\", "", $HTTP_POST_VARS["filtroquery"]);
                                                                          } else if (isset($HTTP_POST_VARS["ant" . $NomeForm])) {
                                                                            // if(isset("filtroquery"]);
                                                                            $query = str_replace("\\", "", @$HTTP_POST_VARS["filtroquery"]);
                                                                            if ($$offset <= $numlinhas) {
                                                                              $$offset = 0;
                                                                              $Dd1 = "disabled";
                                                                            } else
                                                                              $$offset = $$offset - $numlinhas;
                                                                          } else if (isset($HTTP_POST_VARS["prox" . $NomeForm])) {
                                                                            $query = str_replace("\\", "", $HTTP_POST_VARS["filtroquery"]);
                                                                            if ($numlinhas >= ($$tot_registros - $$offset - $numlinhas)) {
                                                                              $$offset = $$tot_registros - $numlinhas;
                                                                              $Dd2 = "disabled";
                                                                            } else
                                                                              $$offset = $$offset + $numlinhas;
                                                                          } else if (isset($HTTP_POST_VARS["ult" . $NomeForm])) {
                                                                            $query = str_replace("\\", "", $HTTP_POST_VARS["filtroquery"]);
                                                                            $$offset = $$tot_registros - $numlinhas;
                                                                            $Dd2 = "disabled";
                                                                          }
                                                                          $filtroquery = $query;
                                                                          // executa a query e cria a tabela
                                                                          if ($query == "") {
                                                                            exit;
                                                                          }
                                                                          $query .= " limit $numlinhas offset " . $$offset;
                                                                          $result = pg_exec($query);
                                                                          $NumRows = pg_numrows($result);
                                                                          $NumFields = pg_numfields($result);
                                                                          if ($NumRows < $numlinhas)
                                                                            $Dd1 = @$Dd2 = "disabled";
                                                                          echo "<table id=\"TabDbLov\" border=\"1\" cellspacing=\"1\" cellpadding=\"0\">\n";
                                                                          /**** botoes de navegacao ********/
                                                                          echo "<tr><td colspan=\"$NumFields\" nowrap> <form name=\"navega_lov" . $NomeForm . "\" method=\"post\">
    <input type=\"submit\" name=\"pri" . $NomeForm . "\" value=\"Início\" " . @$Dd1 . ">
    <input type=\"submit\" name=\"ant" . $NomeForm . "\" value=\"Anterior\" " . @$Dd1 . ">
    <input type=\"submit\" name=\"prox" . $NomeForm . "\" value=\"Próximo\" " . @$Dd2 . ">
    <input type=\"submit\" name=\"ult" . $NomeForm . "\" value=\"Último\" " . @$Dd2 . ">
	<input type=\"hidden\" name=\"offset" . $NomeForm . "\" value=\"" . @$$offset . "\">
	<input type=\"hidden\" name=\"totreg" . $NomeForm . "\" value=\"" . @$$tot_registros . "\">
	<input type=\"hidden\" name=\"filtro\" value=\"$filtro\">
	<input type=\"hidden\" name=\"filtroquery\" value=\"" . str_replace("\n", "", @$filtroquery) . "\">
  " . ($NumRows > 0 ? "
  Foram retornados <font color=\"red\"><strong>" . $$tot_registros . "</strong></font> registros.
  Mostrando de <font color=\"red\"><strong>" . (@$$offset + 1) . "</strong></font> até
  <font color=\"red\"><strong>" . ($$tot_registros < (@$$offset + $numlinhas) ? $NumRows : ($$offset + $numlinhas)) . "</strong></font>." : "Nenhum Registro
  Retornado") . "</form>
  </td></tr>\n";
                                                                          /*********************************/
                                                                          /***** Escreve o cabecalho *******/
                                                                          if ($NumRows > 0) {
                                                                            echo "<tr>\n";
                                                                            // implamentacao de informacoes complementares
                                                                            //    echo "<td title='Outras Informações'>OI</td>\n";
                                                                            $clrotulocab = new rotulolov();
                                                                            for ($i = 0; $i < $NumFields; $i++) {
                                                                              if (strlen(strstr(pg_fieldname($result, $i), "db_")) == 0) {
                                                                                $clrotulocab->label(pg_fieldname($result, $i));
                                                                                echo "<td nowrap bgcolor=\"$db_corcabec\" title=\"" . $clrotulocab->title . "\" align=\"center\"><b><u>" . $clrotulocab->titulo . "</u></b></td>\n";
                                                                              }
                                                                            }
                                                                            echo "</tr>\n";
                                                                          }
                                                                          //cria nome da funcao com parametros
                                                                          if ($arquivo == "()") {
                                                                            $arrayFuncao = explode("\|", $aonde);
                                                                            $quantidadeItemsArrayFuncao = sizeof($arrayFuncao);
                                                                          }


                                                                          /********************************/
                                                                          /****** escreve o corpo *******/
                                                                          for ($i = 0; $i < $NumRows; $i++) {
                                                                            echo '<tr>' . "\n";
                                                                            // implamentacao de informacoes complementares
                                                                            //  	echo '<td onMouseOver="document.getElementById(\'div'.$i.'\').style.visibility=\'visible\';" onMouseOut="document.getElementById(\'div'.$i.'\').style.visibility=\'hidden\';" >-></td>'."\n";
                                                                            if ($arquivo == "()") {
                                                                              $loop = "";
                                                                              $caracter = "";
                                                                              if ($quantidadeItemsArrayFuncao > 1) {
                                                                                for ($cont = 1; $cont < $quantidadeItemsArrayFuncao; $cont++) {
                                                                                  $loop .= $caracter . "'" . pg_result($result, $i, (int)$arrayFuncao[$cont]) . "'";
                                                                                  $caracter = ",";
                                                                                }
                                                                                $resultadoRetorno = $arrayFuncao[0] . "(" . $loop . ")";
                                                                              } else {
                                                                                $resultadoRetorno = $arrayFuncao[0] . "()";
                                                                              }
                                                                            }

                                                                            /*
    if($NumRows==1){
      if($arquivo!=""){
        echo "<td>$resultadoRetorno<td>";
        exit;
	  }else{
        echo "<script>JanBrowse = window.open('".$arquivo."?".base64_encode("retorno=".($BrowSe==1?0:trim(pg_result($result,0,0))))."','$aonde','width=800,height=600');</script>";
        exit;
 	  }
	}
*/

                                                                            if (isset($cor)) {
                                                                              $cor = $cor == $cor1 ? $cor2 : $cor1;
                                                                            } else {
                                                                              $cor = $cor1;
                                                                            }
                                                                            // implamentacao de informacoes complementares
                                                                            //    $mostradiv="";
                                                                            for ($j = 0; $j < $NumFields; $j++) {
                                                                              if (strlen(strstr(pg_fieldname($result, $j), "db_")) == 0) {
                                                                                if (pg_fieldtype($result, $j) == "date") {
                                                                                  if (pg_result($result, $i, $j) != "") {
                                                                                    $matriz_data = explode("-", pg_result($result, $i, $j));
                                                                                    $var_data = $matriz_data[2] . "/" . $matriz_data[1] . "/" . $matriz_data[0];
                                                                                  } else {
                                                                                    $var_data = "//";
                                                                                  }
                                                                                  // implamentacao de informacoes complementares
                                                                                  //          $mostradiv.=$var_data." <br>";
                                                                                  echo "<td id=\"I" . $i . $j . "\" style=\"text-decoration:none;color:#000000;\" bgcolor=\"$cor\" nowrap>
	       " . ($arquivo != "" ? "<a title=\"$mensagem\" style=\"text-decoration:none;color:#000000;\" href=\"\" " . ($arquivo == "()" ? "OnClick=\"" . $resultadoRetorno . ";return false\">" : "onclick=\"JanBrowse = window.open('" . $arquivo . "?" . base64_encode("retorno=" . ($BrowSe == 1 ? $i : trim(pg_result($result, $i, 0)))) . "','$aonde','width=800,height=600');return false\">")
                                                                                    . (trim($var_data)) == "" ? "&nbsp;" : trim($var_data) . "</a>" : (trim($var_data) == "" ? "&nbsp;" : trim($var_data))) . "&nbsp;</td>\n";
                                                                                  //		  echo "<td id=\"I".$i.$j."\" style=\"text-decoration:none;color:#000000;\" bgcolor=\"$cor\" nowrap>
                                                                                  //	        ".($arquivo!=""?"<a title=\"$mensagem\" style=\"text-decoration:none;color:#000000;\" href=\"\" ".($arquivo=="()"?"OnClick=\"".$resultadoRetorno.";return false\">":"onclick=\"JanBrowse = window.open('".$arquivo."?".base64_encode("retorno=".($BrowSe==1?$i:trim(pg_result($result,$i,0))))."','$aonde','width=800,height=600');return false\">")
                                                                                  //		    .(trim(pg_result($result,$i,$j))==""?"&nbsp;":trim(pg_result($result,$i,$j)))."</a>":(trim(pg_result($result,$i,$j))==""?"&nbsp;":trim(pg_result($result,$i,$j))))."&nbsp;</td>\n";

                                                                                } else if (pg_fieldtype($result, $j) == "float8") {
                                                                                  $var_data = db_formatar(pg_result($result, $i, $j), 'f', ' ');
                                                                                  // implamentacao de informacoes complementares
                                                                                  //          $mostradiv.=$var_data." <br>";
                                                                                  echo "<td id=\"I" . $i . $j . "\" style=\"text-decoration:none;color:#000000;aling:center\" bgcolor=\"$cor\" nowrap>
	       " . ($arquivo != "" ? "<a title=\"$mensagem\" style=\"text-decoration:none;color:#000000;\" href=\"\" " . ($arquivo == "()" ? "OnClick=\"" . $resultadoRetorno . ";return false\">" : "onclick=\"JanBrowse = window.open('" . $arquivo . "?" . base64_encode("retorno=" . ($BrowSe == 1 ? $i : trim(pg_result($result, $i, 0)))) . "','$aonde','width=800,height=600');return false\">")
                                                                                    . (trim($var_data)) == "" ? "&nbsp;" : trim($var_data) . "</a>" : (trim($var_data) == "" ? "&nbsp;" : trim($var_data))) . "&nbsp;</td>\n";
                                                                                  //		  echo "<td id=\"I".$i.$j."\" style=\"text-decoration:none;color:#000000;\" bgcolor=\"$cor\" nowrap>
                                                                                  //	        ".($arquivo!=""?"<a title=\"$mensagem\" style=\"text-decoration:none;color:#000000;\" href=\"\" ".($arquivo=="()"?"OnClick=\"".$resultadoRetorno.";return false\">":"onclick=\"JanBrowse = window.open('".$arquivo."?".base64_encode("retorno=".($BrowSe==1?$i:trim(pg_result($result,$i,0))))."','$aonde','width=800,height=600');return false\">")
                                                                                  //		    .(trim(pg_result($result,$i,$j))==""?"&nbsp;":trim(pg_result($result,$i,$j)))."</a>":(trim(pg_result($result,$i,$j))==""?"&nbsp;":trim(pg_result($result,$i,$j))))."&nbsp;</td>\n";

                                                                                } else if (pg_fieldtype($result, $j) == "bool") {
                                                                                  $var_data = (pg_result($result, $i, $j) == 'f' || pg_result($result, $i, $j) == '' ? 'Não' : 'Sim');
                                                                                  // implamentacao de informacoes complementares
                                                                                  //          $mostradiv.=$var_data." <br>";
                                                                                  echo "<td id=\"I" . $i . $j . "\" style=\"text-decoration:none;color:#000000;aling:right\" bgcolor=\"$cor\" nowrap>
	       " . ($arquivo != "" ? "<a title=\"$mensagem\" style=\"text-decoration:none;color:#000000;\" href=\"\" " . ($arquivo == "()" ? "OnClick=\"" . $resultadoRetorno . ";return false\">" : "onclick=\"JanBrowse = window.open('" . $arquivo . "?" . base64_encode("retorno=" . ($BrowSe == 1 ? $i : trim(pg_result($result, $i, 0)))) . "','$aonde','width=800,height=600');return false\">")
                                                                                    . (trim($var_data)) == "" ? "&nbsp;" : trim($var_data) . "</a>" : (trim($var_data) == "" ? "&nbsp;" : trim($var_data))) . "&nbsp;</td>\n";
                                                                                  //		  echo "<td id=\"I".$i.$j."\" style=\"text-decoration:none;color:#000000;\" bgcolor=\"$cor\" nowrap>
                                                                                  //	        ".($arquivo!=""?"<a title=\"$mensagem\" style=\"text-decoration:none;color:#000000;\" href=\"\" ".($arquivo=="()"?"OnClick=\"".$resultadoRetorno.";return false\">":"onclick=\"JanBrowse = window.open('".$arquivo."?".base64_encode("retorno=".($BrowSe==1?$i:trim(pg_result($result,$i,0))))."','$aonde','width=800,height=600');return false\">")
                                                                                  //		    .(trim(pg_result($result,$i,$j))==""?"&nbsp;":trim(pg_result($result,$i,$j)))."</a>":(trim(pg_result($result,$i,$j))==""?"&nbsp;":trim(pg_result($result,$i,$j))))."&nbsp;</td>\n";




                                                                                } else {
                                                                                  // implamentacao de informacoes complementares
                                                                                  //          $mostradiv .= pg_result($result,$i,$j)." <br>";
                                                                                  echo "<td id=\"I" . $i . $j . "\" style=\"text-decoration:none;color:#000000;\" bgcolor=\"$cor\" nowrap>
	        " . ($arquivo != "" ? "<a title=\"$mensagem\" style=\"text-decoration:none;color:#000000;\" href=\"\" " . ($arquivo == "()" ? "OnClick=\"" . $resultadoRetorno . ";return false\">" : "onclick=\"JanBrowse = window.open('" . $arquivo . "?" . base64_encode("retorno=" . ($BrowSe == 1 ? $i : trim(pg_result($result, $i, 0)))) . "','$aonde','width=800,height=600');return false\">")
                                                                                    . (trim(pg_result($result, $i, $j)) == "" ? "&nbsp;" : trim(pg_result($result, $i, $j))) . "</a>" : (trim(pg_result($result, $i, $j)) == "" ? "&nbsp;" : trim(pg_result($result, $i, $j)))) . "&nbsp;</td>\n";
                                                                                }
                                                                              }
                                                                            }
                                                                            // implamentacao de informacoes complementares
                                                                            //    $divmostra .= "</table>";
                                                                            //    $divmostra .= '<div id="div'.$i.'" name="div'.$i.'" style="position:absolute; left:30px; top:40px; z-index:1; visibility: hidden; border: 1px none #000000; background-color: #CCCCCC; layer-background-color: #CCCCCC;">';
                                                                            //    $divmostra .= '<table  border=\"1\"  align=\"center\" cellspacing=\"1\">';
                                                                            //    $divmostra .= '<tr>';
                                                                            //    $divmostra .= '<td> '.$mostradiv;
                                                                            //    $divmostra .= '</td> ';
                                                                            //    $divmostra .= '</tr> ';
                                                                            //    $divmostra .= '</table>';
                                                                            //    $divmostra .= '</div>';
                                                                            echo "</tr>\n";
                                                                          }
                                                                          //  echo $divmostra;
                                                                          /******************************/
                                                                          return $result;
                                                                        }

                                                                        //Executa um SELECT e pagina na tela
                                                                        function db_lov($query, $numlinhas, $arquivo = "", $filtro = "%", $aonde = "_self", $mensagem = "Clique Aqui", $NomeForm = "NoMe")
                                                                        {
                                                                          global $BrowSe;
                                                                          //cor do cabecalho
                                                                          global $db_corcabec;
                                                                          $db_corcabec = $db_corcabec == "" ? "#CDCDFF" : $db_corcabec;
                                                                          //cor de fundo de cada registro
                                                                          global $cor1;
                                                                          global $cor2;
                                                                          $cor1 = $cor1 == "" ? "#97B5E6" : $cor1;
                                                                          $cor2 = $cor2 == "" ? "#E796A4" : $cor2;
                                                                          global $HTTP_POST_VARS;
                                                                          $tot_registros = "tot_registros" . $NomeForm;
                                                                          $offset = "offset" . $NomeForm;
                                                                          //recebe os valores do campo hidden
                                                                          $$tot_registros = @$HTTP_POST_VARS["totreg" . $NomeForm];
                                                                          $$offset = @$HTTP_POST_VARS["offset" . $NomeForm];
                                                                          // se for a primeira vez que é rodado, pega o total de registros e guarda no campo hidden
                                                                          if (empty($$tot_registros)) {
                                                                            $Dd1 = "disabled";
                                                                            $tot = pg_exec("select count(*) from ($query) as temp");
                                                                            $$tot_registros = pg_result($tot, 0, 0);
                                                                          }
                                                                          // testa qual botao foi pressionado
                                                                          if (isset($HTTP_POST_VARS["pri" . $NomeForm])) {
                                                                            $$offset = 0;
                                                                            $Dd1 = "disabled";
                                                                          } else if (isset($HTTP_POST_VARS["ant" . $NomeForm])) {
                                                                            if ($$offset <= $numlinhas) {
                                                                              $$offset = 0;
                                                                              $Dd1 = "disabled";
                                                                            } else
                                                                              $$offset = $$offset - $numlinhas;
                                                                          } else if (isset($HTTP_POST_VARS["prox" . $NomeForm])) {
                                                                            if ($numlinhas >= ($$tot_registros - $$offset - $numlinhas)) {
                                                                              $$offset = $$tot_registros - $numlinhas;
                                                                              $Dd2 = "disabled";
                                                                            } else
                                                                              $$offset = $$offset + $numlinhas;
                                                                          } else if (isset($HTTP_POST_VARS["ult" . $NomeForm])) {
                                                                            $$offset = $$tot_registros - $numlinhas;
                                                                            $Dd2 = "disabled";
                                                                          } else {
                                                                            $$offset = @$HTTP_POST_VARS["offset" . $NomeForm] == "" ? 0 : @$HTTP_POST_VARS["offset" . $NomeForm];
                                                                          }
                                                                          // executa a query e cria a tabela
                                                                          $query .= " limit $numlinhas offset " . $$offset;
                                                                          $result = pg_exec($query);
                                                                          $NumRows = pg_numrows($result);
                                                                          $NumFields = pg_numfields($result);
                                                                          if ($NumRows < $numlinhas)
                                                                            $Dd1 = $Dd2 = "disabled";
                                                                          echo "<table id=\"TabDbLov\" border=\"1\" cellspacing=\"1\" cellpadding=\"0\">\n";
                                                                          /**** botoes de navegacao ********/
                                                                          echo "<tr><td colspan=\"$NumFields\" nowrap>
  <form name=\"navega_lov" . $NomeForm . "\" method=\"post\">
    <input type=\"submit\" name=\"pri" . $NomeForm . "\" value=\"<<\" " . @$Dd1 . ">
    <input type=\"submit\" name=\"ant" . $NomeForm . "\" value=\"<\" " . @$Dd1 . ">
    <input type=\"submit\" name=\"prox" . $NomeForm . "\" value=\">\" " . @$Dd2 . ">
    <input type=\"submit\" name=\"ult" . $NomeForm . "\" value=\">>\" " . @$Dd2 . ">
	<input type=\"hidden\" name=\"offset" . $NomeForm . "\" value=\"" . $$offset . "\">
	<input type=\"hidden\" name=\"totreg" . $NomeForm . "\" value=\"" . $$tot_registros . "\">
	<input type=\"hidden\" name=\"filtro\" value=\"$filtro\">
  </form>" . ($NumRows > 0 ? "
  Foram retornados <font color=\"red\"><strong>" . $$tot_registros . "</strong></font> registros.
  Mostrando de <font color=\"red\"><strong>" . ($$offset + 1) . "</strong></font> até
  <font color=\"red\"><strong>" . ($$tot_registros < ($$offset + $numlinhas) ? $NumRows : ($$offset + $numlinhas)) . "</strong></font>." : "Nenhum Registro
  Retornado") . "
  </td></tr>\n";
                                                                          /*********************************/
                                                                          /***** Escreve o cabecalho *******/
                                                                          if ($NumRows > 0) {
                                                                            echo "<tr>\n";
                                                                            for ($i = 0; $i < $NumFields; $i++) {
                                                                              if (strlen(strstr(pg_fieldname($result, $i), "db")) == 0)
                                                                                echo "<td nowrap bgcolor=\"$db_corcabec\"  style=\"font-size:13px\" align=\"center\"><b><u>" . ucfirst(pg_fieldname($result, $i)) . "</u></b></td>\n";
                                                                            }
                                                                            echo "</tr>\n";
                                                                          }
                                                                          /********************************/
                                                                          /****** escreve o corpo *******/
                                                                          for ($i = 0; $i < $NumRows; $i++) {
                                                                            echo "<tr>\n";
                                                                            $cor = @$cor == $cor1 ? $cor2 : $cor1;
                                                                            for ($j = 0; $j < $NumFields; $j++) {
                                                                              if (strlen(strstr(pg_fieldname($result, $j), "db")) == 0)
                                                                                echo "<td id=\"I" . $i . $j . "\" style=\"text-decoration:none;color:#000000;font-size:13px\" bgcolor=\"$cor\" nowrap>
	       " . ($arquivo != "" ? "<a title=\"$mensagem\" style=\"text-decoration:none;color:#000000;font-size:13px\" href=\"\" " . ($arquivo == "()" ? "OnClick=\"js_retornaValor('I" . $i . $j . "');return false\">" : "onclick=\"JanBrowse = window.open('" . $arquivo . "?" . base64_encode("retorno=" . ($BrowSe == 1 ? $i : trim(pg_result($result, $i, 0)))) . "','$aonde','width=800,height=600');return false\">")
                                                                                  . (trim(pg_result($result, $i, $j)) == "" ? "&nbsp;" : trim(pg_result($result, $i, $j))) . "</a>" : (trim(pg_result($result, $i, $j)) == "" ? "&nbsp;" : trim(pg_result($result, $i, $j)))) . "</td>\n";
                                                                            }
                                                                            echo "</tr>\n";
                                                                          }
                                                                          /******************************/
                                                                          echo "</table>";

                                                                          return $result;
                                                                        }





                                                                        //Insere um registro de log
                                                                        function db_logs($matricula, $incricao, $numcgm, $string)
                                                                        {
                                                                          pg_exec("BEGIN");
                                                                          $result = pg_exec("INSERT INTO db_logs VALUES ('" . $_SERVER["REMOTE_ADDR"] . "','" . date("Y-m-d") . "','" . date("G:i:s") . "','" . $_SERVER["REQUEST_URI"] . "','$matricula','$incricao',$numcgm,'$string')");
                                                                          if (pg_cmdtuples($result) > 0)
                                                                            pg_exec("COMMIT");
                                                                          else {
                                                                            pg_exec("ROLLBACK");
                                                                          }
                                                                        }

                                                                        /* Cria menus */

                                                                        function db_menu($usuario, $modulo, $anousu, $instit)
                                                                        {
                                                                          global $HTTP_SERVER_VARS;
                                                                          global $conn;
                                                                          $menu = pg_exec(
                                                                            $conn,
                                                                            "SELECT m.id_item,m.id_item_filho,m.menusequencia,i.descricao,i.help,i.funcao
    				 FROM db_menu m
  					 INNER JOIN db_permissao p
  				     ON p.id_item = m.id_item_filho
  					 INNER JOIN db_itensmenu i
  					 ON i.id_item = m.id_item_filho
  					 AND p.permissaoativa = 1
					 AND p.anousu = $anousu
					 AND p.id_instit = $instit
					 AND p.id_modulo = $modulo
    				 WHERE p.id_usuario = $usuario
                     AND m.modulo = $modulo
  					 AND i.itemativo = 1
    				 ORDER BY m.id_item,m.id_item_filho,m.menusequencia
					 "
                                                                          );
                                                                          //order by id_item,menusequencia
                                                                          //    				 ORDER BY m.id_item,m.id_item_filho,m.menusequencia
                                                                          $NumMenu = pg_numrows($menu);
                                                                          if ($NumMenu != 0) {
                                                                            echo "<div class=\"menuBar\" style=\"width:80%;position:absolute;left:0px;top:0px\">\n";
                                                                            for ($i = 0; $i < $NumMenu; $i++) {
                                                                              $URI = pg_result($menu, $i, 5) == "" ? "" : "http://" . $HTTP_SERVER_VARS["HTTP_HOST"] . substr($HTTP_SERVER_VARS["PHP_SELF"], 0, strrpos($HTTP_SERVER_VARS["PHP_SELF"], "/")) . "/" . pg_result($menu, $i, 5);
                                                                              if (pg_result($menu, $i, 0) == $modulo) {
                                                                                echo "<a class=\"menuButton\" href=\"\" onclick=\"return buttonClick(event, 'Ijoao" . pg_result($menu, $i, 1) . "');\" onmouseover=\"buttonMouseover(event, 'Ijoao" . pg_result($menu, $i, "id_item_filho") . "');\">" . pg_result($menu, $i, "descricao") . "</a>\n";
                                                                              }
                                                                            }
                                                                            echo "<a class=\"menuButton\" id=\"menuSomeTela\" href=\"\" onclick=\"someFrame(event,1); return false\">Tela</a>\n";
                                                                            echo "</div>\n";
                                                                            for ($i = 0; $i < $NumMenu; $i++) {
                                                                              for ($j = 0; $j < $NumMenu; $j++) {
                                                                                if (pg_result($menu, $j, "id_item") == pg_result($menu, $i, "id_item_filho")) {
                                                                                  echo "<div id=\"Ijoao" . pg_result($menu, $i, "id_item_filho") . "\" class=\"menu\" onmouseover=\"menuMouseover(event)\">\n";
                                                                                  for ($a = 0; $a < $NumMenu; $a++) {
                                                                                    if (pg_result($menu, $j, "id_item") == pg_result($menu, $a, "id_item")) {
                                                                                      $verifica = 1;
                                                                                      for ($b = 0; $b < $NumMenu; $b++) {
                                                                                        if (pg_result($menu, $a, "id_item_filho") == pg_result($menu, $b, "id_item")) {
                                                                                          echo "<a class=\"menuItem\" href=\"\"  onclick=\"return false;\"  onmouseover=\"menuItemMouseover(event, 'Ijoao" . pg_result($menu, $a, "id_item_filho") . "');\">\n";
                                                                                          echo "<span class=\"menuItemText\">" . pg_result($menu, $a, "descricao") . "</span>\n";
                                                                                          echo "<span class=\"menuItemArrow\">&#9654;</span></a>\n";
                                                                                          $verifica = 0;
                                                                                          break;
                                                                                        }
                                                                                      }
                                                                                      if ($verifica == 1)
                                                                                        echo "<a class=\"menuItem\" href=\"" . pg_result($menu, $a, "funcao") . "\">" . pg_result($menu, $a, "descricao") . "</a>\n";
                                                                                    }
                                                                                  }
                                                                                  echo "</div>\n";
                                                                                  break;
                                                                                }
                                                                              }
                                                                            }
                                                                            /*
	 echo "<div id=\"I".pg_result($menu,0,1)."\" class=\"menu\" onmouseover=\"menuMouseover(event)\">\n";
     for($i = 0;$i < $NumMenu;$i++) {
	   $URI = pg_result($menu,$i,5) == ""?"":"http://".$HTTP_SERVER_VARS["HTTP_HOST"].substr($HTTP_SERVER_VARS["PHP_SELF"],0,strrpos($HTTP_SERVER_VARS["PHP_SELF"],"/"))."/".pg_result($menu,$i,5);
       if(pg_result($menu,$i,0) != $modulo) {
         for($j = 0;$j < $NumMenu;$j++) {
           if(pg_result($menu,$i,0) == pg_result($menu,$j,1))
             echo "<a class=\"menuItem\" href=\"".$URI."\">".pg_result($menu,$i,3)."</a>\n";
         }
       }
     }
	 echo "</div>\n";
	 */
                                                                          } else {
                                                                            echo "Sem permissao de menu!";
                                                                          }
                                                                        }

                                                                        /*
function db_menu($usuario,$modulo,$anousu,$instit) {
  global $HTTP_SERVER_VARS;
  global $conn;
    $result = pg_exec($conn,"select * from db_cfmenus where id_usuario = $usuario");

  $vertvoriz = pg_result($result,0,0);
  $espmenuprinc = pg_result($result,0,1);
  $fonte = pg_result($result,0,2);
  $fontetam = pg_result($result,0,3);
  $negrito = pg_result($result,0,4);
  $italico = pg_result($result,0,5);
  $largborda = pg_result($result,0,6);
  $corborda = pg_result($result,0,7);
  $altmenuprinc = pg_result($result,0,8);
  $largmenuprinc = pg_result($result,0,9);
  $corfundomenuprinc = pg_result($result,0,10);
  $corfontemenuprinc = pg_result($result,0,11);
  $corfontemenuprincover = pg_result($result,0,12);
  $altmenu = pg_result($result,0,13);
  $largmenu = pg_result($result,0,14);
  $corfundomenu = pg_result($result,0,15);
  $corfundoover = pg_result($result,0,16);
  $corfontemenu = pg_result($result,0,17);
  $corfontemenuover = pg_result($result,0,18);
  $posx = pg_result($result,0,19);
  $posy = pg_result($result,0,20);
  if(pg_numrows($result) == 0) {
  	echo "ERRO: A tabela db_cfmenus não está configurada para este usuario\n";
  	exit;
  }
  $menu = pg_exec($conn,
  "SELECT m.id_item,m.id_item_filho,m.menusequencia,i.descricao,i.help,i.funcao
    				 FROM db_menu m
  					 INNER JOIN db_permissao p
  				     ON p.id_item = m.id_item_filho
  					 INNER JOIN db_itensmenu i
  					 ON i.id_item = m.id_item_filho
  					 AND p.permissaoativa = 1
					 AND p.anousu = $anousu
					 AND p.id_instit = $instit
					 AND p.id_modulo = $modulo
    				 WHERE p.id_usuario = $usuario
                     AND m.modulo = $modulo
  					 AND i.itemativo = 1
    				 ORDER BY m.id_item,m.id_item_filho,m.menusequencia
					 ");
					 //order by id_item,menusequencia
//    				 ORDER BY m.id_item,m.id_item_filho,m.menusequencia
  $NumMenu = pg_numrows($menu);
  if ( $NumMenu != 0 ){
     echo "<script type='text/javascript' src='scripts/awjsmenugold10trial.js'></script>\n";
     echo "<script type='text/javascript'>\n";
     echo "var awbMNBSpm=new awbmnbspm();\n";    //V/H                 //fonte,tamanho,negrito,italico,espessura da borda
     echo "menus=new TJSMenuType2(\"menus\",\"\",1,$vertvoriz,$posx,$posy,$espmenuprinc,0,0,1000,2,\"$fonte\",$fontetam,$negrito,$italico,$largborda,\"$corborda\",40,15,1,5,1,\"\");\n";

     for($i = 0;$i < $NumMenu;$i++) {
	   $URI = pg_result($menu,$i,5) == ""?"":"http://".$HTTP_SERVER_VARS["HTTP_HOST"].substr($HTTP_SERVER_VARS["PHP_SELF"],0,strrpos($HTTP_SERVER_VARS["PHP_SELF"],"/"))."/".pg_result($menu,$i,5);
  	   if(pg_result($menu,$i,0) == $modulo)
  	     echo "menus.awBmnbspM(\"I".pg_result($menu,$i,1)."\",\"\",\"".pg_result($menu,$i,3)."\",\"$URI\",\"corpo\",$largmenuprinc,$altmenuprinc,\"\",\"\",\"$corfundomenuprinc\",\"$corfundomenuprinc\",\"$corfontemenuprinc\",\"$corfontemenuprincover\",\"".pg_result($menu,$i,4)."\");\n";
     }
     for($i = 0;$i < $NumMenu;$i++) {
	   $URI = pg_result($menu,$i,5) == ""?"":"http://".$HTTP_SERVER_VARS["HTTP_HOST"].substr($HTTP_SERVER_VARS["PHP_SELF"],0,strrpos($HTTP_SERVER_VARS["PHP_SELF"],"/"))."/".pg_result($menu,$i,5);
  	   if(pg_result($menu,$i,0) != $modulo) {
         for($j = 0;$j < $NumMenu;$j++) {
           if(pg_result($menu,$i,0) == pg_result($menu,$j,1))
             echo "menus.awBmnbspM(\"I".pg_result($menu,$i,1)."\",\"I".pg_result($menu,$i,0)."\",\"".pg_result($menu,$i,3)."\",\"$URI\",\"corpo\",$largmenu,$altmenu,\"\",\"\",\"$corfundomenu\",\"$corfundoover\",\"$corfontemenu\",\"$corfontemenuover\",\"".pg_result($menu,$i,4)."\");\n";
         }
       }
     }
     echo "menus.awBmNBspm();\n";
  } else {
    echo "Sem permissao de menu!";
  }
  echo "</script>\n";
  echo "<noscript>Seu browser nao suporta javascript</noscript>\n";
}
*/

                                                                          ?>
