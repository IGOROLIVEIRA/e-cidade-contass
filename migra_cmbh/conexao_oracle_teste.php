<?php

// Conexγo com Oracle usando OCI
/*$user='system'; // seta o usuαrio
$pass='123'; // seta a senha
$db='rps_dump'; // Instβncia do banco de dados

ci_connect
$conexao=ocilogon($user,$pass,$db);

if ($conexao) {
 echo "deu certo";
}*/

$conexao_oracle = oci_connect('rps_dump', 'rps_dump', '172.16.255.250/orateste','WE8ISO8859P1');

/*$sql = "SELECT spea.PE_COD_MATERIAL,sm.ID_MATERIAL AS COD_MATERIAL,sm.NOME_MATERIAL,spea.PE_ANO_ALMOX AS ANO_REFERENCIA, spea.PE_FISICO AS QUANT_ESTOQUE, 
spea.PE_FINANCEIRO AS VL_TOTAL, spea.PE_ALMOX AS ALMOX_CENTRAL
FROM SIGMAT_POSICAO_ESTOQUE_ALMOX spea JOIN SIGMAT_MATERIAL sm ON spea.PE_COD_MATERIAL =  sm.COD_MATERIAL WHERE spea.PE_ANO_ALMOX = 2012 AND spea.PE_ALMOX > -1
AND PE_FISICO > 0 AND PE_FINANCEIRO > 0 ORDER BY sm.NOME_MATERIAL";*/

$sql = "SELECT sbm.ID_PAT AS COD_BEM,
sbm.COD_PAT AS PLACA,
TRANSLATE(sbm.DESC_BMO,'βΰγαΑΒΐΓικΙΚνΝστυΣΤΥόϊάΪΗη','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS DESC_BEM,
CASE WHEN sbm.COD_CLPAT = 'C' THEN '311010000000000' ELSE sbm.COD_CLPAT END AS COD_CLASSIF,
CASE WHEN sp.cod_pessoa IS NULL THEN 1529 ELSE sp.cod_pessoa END AS COD_FORNEC,
TRANSLATE(sbm.DESC_MODELO,'βΰγαΑΒΐΓικΙΚνΝστυΣΤΥόϊάΪΗη','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS MODELO,
TRANSLATE(sbm.DESC_MARCA,'βΰγαΑΒΐΓικΙΚνΝστυΣΤΥόϊάΪΗη','AAAAAAAAEEEEIIOOOOOOUUUUCC') AS MARCA,
sbm.VR_INICIAL AS VALOR_AQUISICAO,
sbm.DATA_AQUISICAO,
((CASE WHEN sbm.DESC_ADICIONAL IS NOT NULL THEN 
TRANSLATE(sbm.DESC_ADICIONAL,'βΰγαΑΒΐΓικΙΚνΝστυΣΤΥόϊάΪΗη','AAAAAAAAEEEEIIOOOOOOUUUUCC') || ', ' END ) || 
(CASE WHEN sbm.DESC_COR IS NOT NULL THEN 
'cor ' || TRANSLATE(sbm.DESC_COR,'βΰγαΑΒΐΓικΙΚνΝστυΣΤΥόϊάΪΗη','AAAAAAAAEEEEIIOOOOOOUUUUCC') || ', ' END ) || 
(CASE WHEN sbm.DESC_SERIE IS NOT NULL THEN 
'serie ' || TRANSLATE(sbm.DESC_SERIE,'βΰγαΑΒΐΓικΙΚνΝστυΣΤΥόϊάΪΗη','AAAAAAAAEEEEIIOOOOOOUUUUCC') END)) AS OBSERVACAO,
COD_CC_ATUAL AS COD_DEPARTAMENTO,
COD_CBM_ATUAL AS COD_SITUACAO,
CASE WHEN COD_SALA_ATUAL IS NOT NULL THEN COD_SALA_ATUAL || COD_CC_ATUAL ELSE NULL END AS COD_DIVISAO
FROM SICOPT_BEM_MOVEL sbm
LEFT JOIN sicopt_fornecedor sf ON sbm.COD_FORNEC = sf.COD_FORNEC
LEFT JOIN safcit_pessoa sp ON sp.id_pessoa = sf.id_pessoa order by sbm.DESC_BMO";

$sql_parse = OCIParse($conexao_oracle,$sql); 
OCIExecute($sql_parse); 
$aDadosAgrupadosOracle = array();
$i = 0;
while (OCIFetch($sql_parse)) {
  
echo OCIResult($sql_parse,"COD_BEM");
echo " | ";
echo substr(str_replace($aCaracteresNome, "", OCIResult($sql_parse,"DESC_BEM")), 0, 80);
echo " | ".OCIResult($sql_parse,"PLACA");
//echo " | ".OCIResult($sql_parse,"QUANT_ESTOQUE");
echo "<br>";
$i++;
}
 echo $i;
/*if (!$conexao_oracle){
	echo "nγo deu certo";
} else {
	echo "deu certo";
}
exit;*/
			   
?>
