
-- Ocorrência 7710
BEGIN;                   
SELECT fc_startsession();

-- Início do script

UPDATE orcparamseqfiltropadrao
   SET o132_filtro = '<?xml version="1.0" encoding="ISO-8859-1"?>
<filter>
 <contas>
  <conta estrutural="413210000000000" nivel="" exclusao="false" indicador=""/>
  <conta estrutural="413210011100000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011180000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011190000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011120000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011220000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011230000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011480000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011490000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011500000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011510000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011520000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011530000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011540000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011550000" nivel="" exclusao="true" indicador=""/>
  <conta estrutural="413210011020000" nivel="" exclusao="true" indicador=""/>
 </contas>
 <orgao operador="in" valor="" id="orgao"/>
 <unidade operador="in" valor="" id="unidade"/>
 <funcao operador="in" valor="" id="funcao"/>
 <subfuncao operador="in" valor="" id="subfuncao"/>
 <programa operador="in" valor="" id="programa"/>
 <projativ operador="in" valor="" id="projativ"/>
 <recurso operador="in" valor="" id="recurso"/>
 <recursocontalinha numerolinha="" id="recursocontalinha"/>
 <observacao valor=""/>
 <desdobrarlinha valor="false"/>
</filter>'
 WHERE o132_orcparamrel = 173
   AND o132_orcparamseq = 63;


-- Fim do script

COMMIT;

