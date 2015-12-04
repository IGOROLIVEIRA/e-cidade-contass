<?php
include 'conexao_postgre.php';
include 'dados_oracle.php';

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");

/*$rsResult = pg_query($conexao_postgre, "CREATE TEMP TABLE importacao_cgm as select z01_numcgm,z01_nomecomple,z01_nome,
z01_contato,z01_incest,z01_nomefanta,z01_cgccpf,z01_cep,z01_ender,z01_numero,z01_munic,z01_uf,z01_bairro,z01_telef,
z01_fax,z01_telcel,z01_email,z01_cxpostal from cgm limit 1;");*/

//$rsResult = pg_query($conexao_postgre, "TRUNCATE importacao_cgm;");

foreach ($aDadosAgrupadosOracle as $aDados) {
	
	$rsResult = pg_query($conexao_postgre, "SELECT * FROM cgm WHERE z01_numcgm = {$aDados['CODIGO']}");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE cgm SET z01_nomecomple = '{$aDados['NOME_COMPLETO']}',z01_nome = '{$aDados['NOME_RAZAO_SOCIAL']}',
	z01_contato = '{$aDados['CONTATO']}',z01_incest = '{$aDados['INSCRICAO_ESTADUAL']}',z01_nomefanta = '{$aDados['NOME_FANTASIA']}',
	z01_cgccpf = '{$aDados['CNPJ_CPF']}',z01_cep = '{$aDados['CEP']}',z01_ender = '{$aDados['ENDERECO']}',z01_munic = '{$aDados['MUNICIPIO']}',
	z01_uf = '{$aDados['UF']}',z01_bairro = '{$aDados['BAIRRO']}',z01_telef = '{$aDados['TELEFONE']}',z01_fax = '{$aDados['FAX']}',
	z01_telcel = '{$aDados['CELULAR']}',z01_email = '{$aDados['EMAIL']}',z01_cxpostal = '{$aDados['CAIXA_POSTAL']}'
	WHERE z01_numcgm = {$aDados['CODIGO']}");
		
	} else {
	
		$sSql_insert = "INSERT INTO cgm (z01_numcgm,z01_nomecomple,z01_nome,
	z01_contato,z01_incest,z01_nomefanta,z01_cgccpf,z01_cep,z01_ender,z01_munic,z01_uf,z01_bairro,z01_telef,
	z01_fax,z01_telcel,z01_email,z01_cxpostal) VALUES ({$aDados['CODIGO']},'{$aDados['NOME_COMPLETO']}',
	'{$aDados['NOME_RAZAO_SOCIAL']}','{$aDados['CONTATO']}','{$aDados['INSCRICAO_ESTADUAL']}','{$aDados['NOME_FANTASIA']}',
	'{$aDados['CNPJ_CPF']}','{$aDados['CEP']}','{$aDados['ENDERECO']}','{$aDados['MUNICIPIO']}',
	'{$aDados['UF']}','{$aDados['BAIRRO']}','{$aDados['TELEFONE']}','{$aDados['FAX']}','{$aDados['CELULAR']}',
	'{$aDados['EMAIL']}','{$aDados['CAIXA_POSTAL']}')";
		//echo $sSql_insert;exit;
		//if (!pg_query($conexao_postgre, $sSql_insert)) {
			//echo "erronovo: ".$aDados['CODIGO'];
		//}
		pg_query($conexao_postgre, $sSql_insert);
		//$rsResult = pg_query($conexao_postgre, $sSql_insert);
	}
	
}
//$rsResult = pg_query($conexao_postgre, "UPDATE importacao_cgm SET z01_numero = 521;");
//$rsResult = pg_query($conexao_postgre, "INSERT INTO cgm (select * from importacao_cgm);");
$rsResult = pg_query($conexao_postgre, "select * from cgm order by z01_numcgm;");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['z01_numcgm']."<br>";
}
echo pg_num_rows($rsResult);

?>