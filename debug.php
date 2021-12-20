<?
// exibe o estado de uma classe

function debug($classe,$func=false)
{
  print_vars($classe);
  if ($func==true)
     print_methods($classe);

}
function print_vars($obj)
{

  $arr = get_object_vars($obj);
  echo "<table border=0 bgcolor=#AAAAFF style='border:1px solid'>";
  echo "<tr><td colspan=3>Debug da classe ".get_class($obj)." </td></tr>";
  while (list($prop, $val) = each($arr))
     echo "<tr><td>&nbsp; </td><td align=left>var $prop </td><td> $val </td>";
}

function print_methods($obj)
{
   echo "<tr><td colspan=3>Metodos encontrados </td></tr>";
   $arr = get_class_methods(get_class($obj));
   foreach ($arr as $method)
     echo "<tr><td>&nbsp; </td><td colspan=2>function $method() </td>";

   echo "<table>";
}

function print_obj($obj)
{
    echo "<pre>";print_r($obj);
}

?>
