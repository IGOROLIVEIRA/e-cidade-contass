<?php

include 'conexao_oracle.php';
include 'conexao_postgre.php';
include 'validacao.php';

$sql = "SELECT cta.BC_CLIENTE as codigo,
pes.cod_pessoa as codigo_fornecedor,
	nvl(nvl(
		decode(
			length(REGEXP_REPLACE(pes.num_cnpj_cpf,'[A-Z a-z]|\-|\s','')),
			12,
			concat('00',REGEXP_REPLACE(pes.num_cnpj_cpf,'[A-Z a-z]|\-|\s','')),
			REGEXP_REPLACE(pes.num_cnpj_cpf,'[A-Z a-z]|\-|\s','')
		), REGEXP_REPLACE(orc.cr_cgc_cpf,'[A-Z a-z]|\-|\s','')
	), '00000000000000') cnpj_cpf,
  case when cta.bc_banco = '048' then '000' else cta.bc_banco end as banco,
  REGEXP_REPLACE(cta.bc_agencia,'\-[A-Z0-9a-z]','') as agencia,
  nvl(replace(REGEXP_SUBSTR(cta.bc_agencia,'\-[A-Z0-9a-z]'),'-',''),0) as digito_agencia, --0 como Default, pois é campo obrigatório
  replace(REGEXP_REPLACE(cta.bc_conta_corrente,'\-[A-Z0-9a-z]',''),'.','') as conta,
  nvl(replace(REGEXP_SUBSTR(replace(cta.bc_conta_corrente,'.',''),'\-[A-Z0-9a-z]'),'-',''),0) as digito_conta, --0 como Default, pois em alguns casos não está no campo separado
  decode(cta.bc_conta_poupanca, 'N',1,'S',2) as eh_poupanca
FROM sot_cr1 orc
JOIN sot_bc cta on orc.cr_cliente = cta.bc_cliente
JOIN safcit_pessoa pes on orc.id_pessoa = pes.id_pessoa
ORDER BY cta.BC_CLIENTE";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
while (OCIFetch($sql_parse)) {
  
  $dados_oracle = array();
	
	if (validaCNPJ(OCIResult($sql_parse,"CNPJ_CPF")) == true) {
		$dados_oracle['CNPJ_CPF'] = OCIResult($sql_parse,"CNPJ_CPF");
	} else {
		
	  if (validaCPF(OCIResult($sql_parse,"CNPJ_CPF")) == true) {
		  $dados_oracle['CNPJ_CPF'] = OCIResult($sql_parse,"CNPJ_CPF");
	  } else {
	  	
	  	
	  	if(strlen(OCIResult($sql_parse,"CNPJ_CPF") > 11)) {
	  	  $dados_oracle['CNPJ_CPF'] = "00000000000000";
	  	} else {
	  		$dados_oracle['CNPJ_CPF'] = "00000000000";
	  	}
	  	
	  }
		  
	}
  
	$dados_oracle['CODIGO_FORNECEDOR']  = OCIResult($sql_parse,"CODIGO_FORNECEDOR");
	$dados_oracle['BANCO']              = OCIResult($sql_parse,"BANCO");
	$dados_oracle['AGENCIA']            = OCIResult($sql_parse,"AGENCIA");
	$dados_oracle['DIGITO_AGENCIA']     = OCIResult($sql_parse,"DIGITO_AGENCIA");
	$dados_oracle['CONTA']              = OCIResult($sql_parse,"CONTA");
	$dados_oracle['DIGITO_CONTA']       = OCIResult($sql_parse,"DIGITO_CONTA");
	$dados_oracle['EH_POUPANCA']        = OCIResult($sql_parse,"EH_POUPANCA");
	$dados_oracle['DIGITO_AGENCIA']     = OCIResult($sql_parse,"DIGITO_AGENCIA");
	$dados_oracle['DIGITO_CONTA']       = OCIResult($sql_parse,"DIGITO_CONTA");
	$aDadosAgrupadosOracle[]            = $dados_oracle;

}
/*$i = 0;
foreach ($aDadosAgrupadosOracle as $dados) {
	echo $dados['DESC_CLAMAT']."<br>";
	$i++;
	//echo "<pre>";
	//print_r($dados);exit;
}
echo $i;*/

$rsResult = pg_query($conexao_postgre, "SELECT fc_startsession();");

/**
 * inserir bancos que faltam
 * não foi encontrado banco 048
 * os fornecedores 206, 231, 313, 100 que estão ligados a esse banco foram direcionados para 'não informado'
 */
/*pg_query($conexao_postgre, "INSERT INTO db_bancos (db90_codban,db90_descr) VALUES ('230','UNICARD BANCO MULTIPLO S.A.')");
pg_query($conexao_postgre, "INSERT INTO db_bancos (db90_codban,db90_descr) VALUES ('655','BANCO VOTORANTIM S.A.')");
pg_query($conexao_postgre, "INSERT INTO db_bancos (db90_codban,db90_descr) VALUES ('077','BANCO INTERMEDIUM S.A.')");*/

$rsResult = pg_query($conexao_postgre, "SELECT CASE WHEN MAX(pc63_contabanco) IS NULL THEN 1 ELSE MAX(pc63_contabanco) END AS pc63_contabanco FROM pcfornecon;");
$dados = pg_fetch_array($rsResult);
$iCont = $dados['pc63_contabanco'];
foreach ($aDadosAgrupadosOracle as $aDados) {
	
	$rsResult = pg_query($conexao_postgre, "SELECT * FROM pcfornecon WHERE pc63_conta = '{$aDados['CONTA']}'");
	
	if (pg_num_rows($rsResult) > 0) {
		
		pg_query($conexao_postgre, "UPDATE pcfornecon SET pc63_numcgm = {$aDados['CODIGO_FORNECEDOR']}, 
		pc63_banco = '{$aDados['BANCO']}', pc63_agencia = '{$aDados['AGENCIA']}', pc63_agencia_dig = '{$aDados['DIGITO_AGENCIA']}',
		pc63_cnpjcpf = '{$aDados['CNPJ_CPF']}', pc63_tipoconta = {$aDados['EH_POUPANCA']}, pc63_conta_dig = '{$aDados['DIGITO_CONTA']}',
		pc63_dataconf = '".date('Y-m-d')."'
		WHERE pc63_conta = '{$aDados['CONTA']}'");
		
	} else {
	echo "{$aDados['CONTA']}<br>";
	  $sSql_insert = "INSERT INTO pcfornecon (pc63_contabanco,pc63_numcgm,pc63_banco,pc63_agencia,pc63_conta,pc63_id_usuario,pc63_cnpjcpf,
	  pc63_agencia_dig,pc63_conta_dig,pc63_dataconf,pc63_tipoconta) VALUES ($iCont,{$aDados['CODIGO_FORNECEDOR']},
	  '{$aDados['BANCO']}','{$aDados['AGENCIA']}','{$aDados['CONTA']}',1,'{$aDados['CNPJ_CPF']}','{$aDados['DIGITO_AGENCIA']}',
	  '{$aDados['DIGITO_CONTA']}','".date('Y-m-d')."',{$aDados['EH_POUPANCA']})";
	  pg_query($conexao_postgre, $sSql_insert);
	  $iCont++;
	  
	}
	
}
$rsResult = pg_query($conexao_postgre, "SELECT * FROM pcfornecon");
while ($dados = pg_fetch_array($rsResult)) {
	echo $dados['pc63_conta']."<br>";
}
echo pg_num_rows($rsResult);

?>
