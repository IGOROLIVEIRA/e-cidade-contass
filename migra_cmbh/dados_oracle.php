<?php 

include 'conexao_oracle.php';
include 'validacao.php';
$sql = "select 
  pes.cod_pessoa as codigo,
	TRANSLATE(upper(trim(nvl(pes.nome_razao_social,orc.cr_nome))),'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') as nome_completo,
	TRANSLATE(upper(trim(nvl(pes.nome_razao_social,orc.cr_nome))),'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') as nome_razao_social,
	TRANSLATE(upper(trim(nvl(nvl(mat.desc_contato,pat.desc_contato),orc.cr_pescont))),'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS contato,
	upper(trim(nvl(nvl(mat.num_insc_estadual,pat.num_insc_estadual),orc.cr_ins_est))) inscricao_estadual,
	TRANSLATE(upper(trim(nvl(nvl(mat.nome_fantasia,pat.nome_fantasia),orc.cr_nome_fan))),'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS nome_fantasia,
	nvl(nvl(
		decode(
			length(REGEXP_REPLACE(pes.num_cnpj_cpf,'[A-Z a-z]|\-|\s','')),
			12,
			concat('00',REGEXP_REPLACE(pes.num_cnpj_cpf,'[A-Z a-z]|\-|\s','')),
			REGEXP_REPLACE(pes.num_cnpj_cpf,'[A-Z a-z]|\-|\s','')
		), REGEXP_REPLACE(orc.cr_cgc_cpf,'[A-Z a-z]|\-|\s','')
	), '00000000000000') cnpj_cpf,
  nvl(
    nvl(nvl(
      REGEXP_REPLACE(mat.num_cep,'[A-Z a-z]|\-|\s|\.',''),
      REGEXP_REPLACE(pat.num_cep,'[A-Z a-z]|\-|\s|\.','')
      ),REGEXP_REPLACE(orc.cr_cep,'[A-Z a-z]|\-|\s|\.',''))
  ,'00000000') as cep, --Default: 00000000, pois tem muitos cadastros sem CEP no RPS (+ ou - 730)
	TRANSLATE(upper(trim(nvl(nvl(mat.desc_endereco,pat.desc_endereco),orc.cr_endereco))),'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') as endereco,
	null numero, --Deixei como nulo. No cadastro do CGM nÃ£o estÃ¡ como obrigatÃ³rio. No banco RPS, Ã© junto do endereÃ§o.
	TRANSLATE(
	upper(trim(
    nvl(
      nvl(
        (select distinct mun.desc_municipio from safcit_municipio mun where mun.cod_municipio = mat.cod_municipio),
        (select distinct mun.desc_municipio from safcit_municipio mun where mun.cod_municipio = pat.cod_municipio)
      ), orc.cr_cidade)
  ))
  ,'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') as municipio,
  upper(trim(
    nvl(
      nvl(
        (select distinct tuf.sgl_uf from safcit_municipio mun join safcit_uf tuf on mun.cod_uf = tuf.cod_uf
            where mun.cod_municipio = mat.cod_municipio),
        (select distinct tuf.sgl_uf from safcit_municipio mun join safcit_uf tuf on mun.cod_uf = tuf.cod_uf
            where mun.cod_municipio = pat.cod_municipio)
      ), orc.cr_uf)
  )) as uf,
	TRANSLATE(upper(trim(nvl(nvl(mat.desc_bairro,pat.desc_bairro),orc.cr_bairro))),'âàãáÁÂÀÃéêÉÊíÍóôõÓÔÕüúÜÚÇç','AAAAAAAAEEEEIIOOOOOOUUUUCC') as bairro,
	nvl(
    nvl(
      REGEXP_REPLACE(orc.cr_telefone,'\-|\(|\)|\s|\/|\.',''),REGEXP_REPLACE(mat.num_tel,'\-|\(|\)|\s|\/|\.','')
    ),REGEXP_REPLACE(pat.num_tel,'\-|\(|\)|\s|\/|\.','')) as telefone,
	nvl(
    nvl(
      REGEXP_REPLACE(orc.cr_fax,'\-|\(|\)|\s|\/|\.',''),REGEXP_REPLACE(mat.num_fax,'\-|\(|\)|\s|\/|\.','')
    ),REGEXP_REPLACE(pat.num_fax,'\-|\(|\)|\s|\/|\.','')) as fax,
	null celular, --Não tem campo para celular
	upper(trim(nvl(nvl(mat.desc_email,pat.desc_email),orc.cr_email))) as email,
	null caixa_postal --Não tem campo para caixa postal
	from safcit_pessoa pes
	left join sigmat_fornecedor mat on mat.id_pessoa = pes.id_pessoa
	left join sicopt_fornecedor pat on pat.id_pessoa = pes.id_pessoa
	FULL outer join sot_cr1 orc on orc.id_pessoa = pes.id_pessoa
  order by pes.cod_pessoa";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
while (OCIFetch($sql_parse)) {
  
	if ($dados_oracle['CODIGO'] != OCIResult($sql_parse,"CODIGO")) {
		
		$dados_oracle = array();
		$aCaracteresNome                    = array("'","\"");
		$dados_oracle['CODIGO']             = OCIResult($sql_parse,"CODIGO");
		$dados_oracle['NOME_COMPLETO']      = str_replace($aCaracteresNome, "", OCIResult($sql_parse,"NOME_COMPLETO"));
		$dados_oracle['NOME_RAZAO_SOCIAL']  = substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"NOME_RAZAO_SOCIAL")), 0, 40);
		$dados_oracle['CONTATO']            = str_replace($aCaracteresNome, "", substr(OCIResult($sql_parse,"CONTATO"), 0, 40));
		$dados_oracle['INSCRICAO_ESTADUAL'] = substr(OCIResult($sql_parse,"INSCRICAO_ESTADUAL"), 0, 15);
		$dados_oracle['NOME_FANTASIA']      = str_replace($aCaracteresNome, "", OCIResult($sql_parse,"NOME_FANTASIA"));
		
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
		
		$dados_oracle['CEP']                = OCIResult($sql_parse,"CEP");	
		$dados_oracle['ENDERECO']           = str_replace($aCaracteresNome, "", OCIResult($sql_parse,"ENDERECO"));
		$dados_oracle['NUMERO']             = 0;
		$dados_oracle['MUNICIPIO']          = str_replace($aCaracteresNome, "", OCIResult($sql_parse,"MUNICIPIO"));
		$dados_oracle['UF']                 = OCIResult($sql_parse,"UF");
		$aCaracteresTelefone                = array("(",")","-","'");
		$dados_oracle['BAIRRO']             = str_replace($aCaracteresNome, "", OCIResult($sql_parse,"BAIRRO"));
		$dados_oracle['TELEFONE']           = substr(str_replace($aCaracteresTelefone, "", OCIResult($sql_parse,"TELEFONE")), 0, 12);
		$dados_oracle['FAX']                = substr(str_replace($aCaracteresTelefone, "", OCIResult($sql_parse,"FAX")), 0, 12);
		$dados_oracle['CELULAR']            = substr(str_replace($aCaracteresTelefone, "", OCIResult($sql_parse,"CELULAR")), 0, 12);
		$dados_oracle['EMAIL']              = OCIResult($sql_parse,"EMAIL");
		$dados_oracle['CAIXA_POSTAL']       = OCIResult($sql_parse,"CAIXA_POSTAL");
		
		$aDadosAgrupadosOracle[] = $dados_oracle;
	
  }
	
}
/*$i = 0;
foreach ($aDadosAgrupadosOracle as $dados) {
	echo html_entity_decode($dados['NOME_COMPLETO'])."<br>";
	$i++;
	echo "<pre>";
	print_r($dados);exit;
}
echo $i;*/
?>
