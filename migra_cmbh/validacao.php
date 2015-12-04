<?php
/*
@autor: Moacir Selínger Fernandes
@email: hassed@hassed.com
*/

// Função que valida o CPF
function validaCPF($cpf)
{	// Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(preg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
	
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
	return false;
    }
	else
	{   // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}


//Função que valida o CNPJ
function validaCNPJ($str) {
	if (!preg_match('|^(\d{2,3})\.?(\d{3})\.?(\d{3})\/?(\d{4})\-?(\d{2})$|', $str, $matches))
		return false;

	array_shift($matches);

	$str = implode('', $matches);
	if (strlen($str) > 14)
		$str = substr($str, 1);

	$sum1 = 0;
	$sum2 = 0;
	$sum3 = 0;
	$calc1 = 5;
	$calc2 = 6;

	for ($i=0; $i <= 12; $i++) {
		$calc1 = $calc1 < 2 ? 9 : $calc1;
		$calc2 = $calc2 < 2 ? 9 : $calc2;

		if ($i <= 11)
			$sum1 += $str[$i] * $calc1;

		$sum2 += $str[$i] * $calc2;
		$sum3 += $str[$i];
		$calc1--;
		$calc2--;
	}

	$sum1 %= 11;
	$sum2 %= 11;

	return ($sum3 && $str[12] == ($sum1 < 2 ? 0 : 11 - $sum1) && $str[13] == ($sum2 < 2 ? 0 : 11 - $sum2)) ? true : false;
}

function valida_cpf_cnpj($num) {
	
	if (strlen($num) > 11){
		validaCNPJ($num);
  } else {
  	validaCPF($num);
  }
  
}
?>