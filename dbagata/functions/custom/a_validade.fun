<?
# function a_validade
# Coloca a validade
# By Rodrigo Carvalhaes
# $string_column � a coluna selecionada 
# $array_row � a linha atual do relat�rio

function a_validade($string_column, $array_row)
{
    $new_string = "";
    
    if ($string_column == 1)
    {
    $new_string = $string_column . ' DIA';
    }
    elseif ($string_column >1)
    {	
    $new_string = $string_column . ' DIAS';
    }
    elseif ($string_column == 0)
    {	
    $new_string = 'IMEDIATA';
    }

    
    return $new_string;

}

?>
