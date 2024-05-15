<?php
/**
 * a_date_to_br
 * @param $string_column ï¿½ o valor atual da coluna 
 * @param $array_row ï¿½ um vetor contendo a linha atual
 * @param $array_last_row ï¿½ um vetor contendo a linha anterior
 * @param $row_num ï¿½ o número da linha atual 
 * @param $col_num ï¿½ o número da coluna atual
 * @param $alias ï¿½ o alias da coluna
 * @param $format formato do relatï¿½rio (html, pdf, rtf)
 * @param $parameters parï¿½metros do relatï¿½rio
 * @param $report_object relatï¿½rio na forma de objeto PHP
 * @param $field_array propriedades do campo na forma de um vetor
 **/
function a_date_to_br($string_column, $array_row, $array_last_row, $row_num, $col_num, $alias=null, $format=null, $parameters=null, $report_object=null, $field_array=null)
{
    return substr($string_column, 8,2) . '/' .
           substr($string_column, 5,2) . '/' .
           substr($string_column, 0,4);
}
?>
