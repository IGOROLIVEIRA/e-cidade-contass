<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta>
		<title>Abastecimento</title>
        
	<head>
	<body>
		<?php
		// Definimos o nome do arquivo que será exportado
		$arquivo = 'planilha.xls';
		
		// Criamos uma tabela HTML com o formato da planilha
		$html = '';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td colspan="15" rowspan="5">          Importação de Abastecimento</td>';
		$html .= '</tr>';
		$html .= '</table>';
		$html .= '<table border="1">';
		$html .= '<tr>';
		$html .= '<td style="background-color:red;"><b>Cód. Abast.</b></td>';
		$html .= '<td><b>Data</b></td>';
		$html .= '<td><b>Horário</b></td>';
		$html .= '<td><b>Placa</b></td>';
		$html .= '<td><b>Motorista</b></td>';
        $html .= '<td><b>CPF</b></td>';
		$html .= '<td><b>Unidade</b></td>';
		$html .= '<td><b>SubUnidade</b></td>';
		$html .= '<td><b>Combustivel</b></td>';
		$html .= '<td><b>KM Abast.</b></td>';
        $html .= '<td><b>Qtde. Litros</b></td>';
		$html .= '<td><b>Preço Unit.</b></td>';
		$html .= '<td><b>Valor</b></td>';
		$html .= '<td><b>Status</b></td>';
        $html .= '<td><b>Produto</b></td>';

		$html .= '</tr>';

		
		//Selecionar todos os itens da tabela 
		//$result_msg_contatos = "SELECT * FROM mensagens_contatos";
		//$resultado_msg_contatos = mysqli_query($conn , $result_msg_contatos);
		
		//while($row_msg_contatos = mysqli_fetch_assoc($resultado_msg_contatos)){

			;
		//}
		// Configurações header para forçar o download
		header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
		header ("Cache-Control: no-cache, must-revalidate");
		header ("Pragma: no-cache");
		header ("Content-type: application/x-msexcel");
		header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
		header ("Content-Description: PHP Generated Data" );
		// Envia o conteúdo do arquivo
		echo $html;
		exit; ?>
	</body>
</html>
