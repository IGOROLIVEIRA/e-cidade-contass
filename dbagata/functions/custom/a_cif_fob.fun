<?
# function a_cif_fob
# Troca o F por FOB e o C por CIF
# By Rodrigo Carvalhaes
# $string_column � a coluna selecionada 
# $array_row � a linha atual do relat�rio

function a_cif_fob($string_column, $array_row)
{
    $new_string = "";
    
    if ($string_column == 'F')
    {
    $new_string = 'FOB';
    }
    elseif ($string_column == 'C')
    {
    $new_string = 'CIF';
    }

    
    return $new_string;

}

?>
