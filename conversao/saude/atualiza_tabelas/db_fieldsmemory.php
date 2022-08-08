<?
function db_fieldsmemory($recordset,$indice,$formatar="",$mostravar=false){
//#00#//db_fieldsmemory
//#10#//Esta funcao cria as variáveis de uma determinada linha de um record set, sendo o nome da variável
//#10#//o nome do campo no record set e seu conteúdo o conteúdo da variável
//#15#//db_fieldsmemory($recordset,$indice,$formatar="",$mostravar=false);
//#20#//Record Set        : Record set que será pesquisado
//#20#//Indice            : Número da linha (índice) que será caregada as funções
//#20#//Formatar          : Se formata as variáveis conforme o tipo no banco de dados
//#20#//                    true = Formatar      false = Não Formatar (Padrão = false)
//#20#//Mostrar Variáveis : Mostrar na tela as variáveis que estão sendo geradas
//#99#//Esta função é bastante utilizada quando se faz um for para percorrer um record set.
//#99#//Exemplo: 
//#99#//db_fieldsmemory($result,0);
//#99#//Cria todas as variáveis com o conteúdo de cada uma sendo o valor do campo
  $fm_numfields = pg_numfields($recordset);
  for ($i = 0;$i < $fm_numfields;$i++){
    $matriz[$i] = pg_fieldname($recordset,$i);
    global $$matriz[$i];
     $aux = trim(pg_result($recordset,$indice,$matriz[$i]));
     if(!empty($formatar)) {
         switch(pg_fieldtype($recordset,$i)) {
         case "float8":
         case "float4":
         case "float":
          $$matriz[$i] = number_format($aux,2,".","");
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
            break;
          case "date":
          if($aux!=""){
              $data = explode("-",$aux);
              $$matriz[$i] = $data[2]."/".$data[1]."/".$data[0];
            }else{
              $$matriz[$i] = "";
            }
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
            break;
          default:
          $$matriz[$i] = $aux;                      
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
            break;
       }
     } else
         switch(pg_fieldtype($recordset,$i)) {
          case "date":
            $datav = explode("-",$aux);
          $split_data = $matriz[$i]."_dia";
          global $$split_data;
          $$split_data =  @$datav[2];     
          if($mostravar==true) echo $split_data."->".$$split_data."<br";
          $split_data = $matriz[$i]."_mes";
          global $$split_data;
          $$split_data =  @$datav[1];     
          if($mostravar==true) echo $split_data."->".$$split_data."<br>";
          $split_data = $matriz[$i]."_ano";
          global $$split_data;
          $$split_data =  @$datav[0];      
          if($mostravar==true) echo $split_data."->".$$split_data."<br>";
          $$matriz[$i] = $aux;                      
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
            break;
          default:
          $$matriz[$i] = $aux;                      
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
            break;
       }
  }
}

function db_endereco($endtrocar) {
  $er = ',[ ][0-9]*[ ]';
  $texto = $endtrocar;
  global $numero;
  global $ender;
  global $compl;
  if(ereg($er,$texto,$matriz)) {
    $numero = trim(substr($matriz[0],2,9));
    $xender = explode($matriz[0],$texto);
    $ender  = $xender[0];
    $compl  = trim(substr($xender[1],1,20));
  } else {
    $ender  = substr($arquivo[$i],135,40);
    $numero = 0;
    $compl  = "";
  }

}

function db_testaduplo($nome,$endereco,$numero,$cidade,$uf,$cpf){

  // cgc cnpj

  $_achou = false;

  if (strlen(ltrim($nome)) == 0) return 0;

  if (strlen($cpf) > 0) {

    $sql6 = "select z01_numcgm from cgm where z01_cgccpf = '$cpf'";
    $result6 = pg_exec($sql6);
    if ($result6 == false) {
      echo "sql executado: $sql6\n";
      return 9999999999;
    }

    if ($result6 != false) {
      if (pg_numrows($result6) > 0) {
      $_achou = true;
      }
    }
  }

  if ($_achou == false) {
  
    // nome, endereco, numero, cidade, uf...
   
    $sql6 = "select z01_numcgm from cgm where z01_nome = '$nome' and z01_ender = '$endereco' and z01_numero = $numero and z01_munic = '$cidade' and z01_uf = '$uf'";
    $result6 = pg_exec($sql6);
    if ($result6 == false) {
      echo "sql executado: $sql6\n";
      return 9999999999;
    }
//echo "nome: $nome - " . pg_numrows($result6) . "\n";
    if (pg_numrows($result6) > 0) {
       $_achou = true;
    }

  }

  if ($_achou == false) {
    return 0;
  } else {
    return pg_result($result6,0);
  }

}
?>
