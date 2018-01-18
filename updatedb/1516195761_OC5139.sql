
-- Ocorrência 5139
BEGIN;                   
SELECT fc_startsession();

-- Início do script

update db_itensmenu set funcao='lic4_situacaolicitacao001.php?iCodigoTipoSituacao=3&iOpcao=1' where id_item=7319;
update db_itensmenu set funcao='lic4_situacaolicitacao001.php?iCodigoTipoSituacao=5&iOpcao=1' where funcao like 'lic4_situacaolicitacao001.php?iCodigoTipoSituacao=12&iOpcao=1';
update db_itensmenu set funcao='lic4_situacaolicitacao001.php?iCodigoTipoSituacao=5&iOpcao=2' where funcao like 'lic4_situacaolicitacao001.php?iCodigoTipoSituacao=12&iOpcao=2';
update db_itensmenu set funcao='lic4_situacaolicitacao001.php?iCodigoTipoSituacao=5&iOpcao=3' where funcao like 'lic4_situacaolicitacao001.php?iCodigoTipoSituacao=12&iOpcao=3';

-- Fim do script

COMMIT;

