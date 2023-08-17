<?php

use Phinx\Migration\AbstractMigration;

class Oc20323 extends AbstractMigration
{
    public function up()
    {
        $nomeCampo = "c50_descrcompl";
        $descricaoCampo = "Descrição do Complemento";
        $nomeArquivo = "conhist";
        
            $sql = "    
            BEGIN;
                SELECT fc_startsession();
                
                    -- Insere novo campo
                    INSERT INTO db_syscampo
                    VALUES (
                        (SELECT max(codcam) + 1 FROM db_syscampo), '{$nomeCampo}', 'bool', '{$descricaoCampo}',
                        'f', '{$descricaoCampo}', 1, FALSE, FALSE, FALSE, 5, 'select', '{$descricaoCampo}');

                    INSERT INTO db_sysarqcamp
                    VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = '{$nomeArquivo}'),
                        (SELECT codcam FROM db_syscampo WHERE nomecam = '{$nomeCampo}'),
                        (SELECT max(seqarq) + 1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = '{$nomeArquivo}')), 0);
               
                        ALTER TABLE {$nomeArquivo} ADD COLUMN {$nomeCampo} varchar(500) NULL;

                        INSERT INTO conhist
                        (c50_codhist, c50_compl, c50_descr, c50_descrcompl)
                        VALUES
                        (9791, true, 'APLICACAO FINANCEIRA', 'APLICACAO FINANCEIRA'),
                        (9792, true, 'RESGATE DE APLICACAO FINANCEIRA', 'RESGATE DE APLICACAO FINANCEIRA'),
                        (9793, true, 'TRANSFERENCIA ENTRE CONTAS BANCARIAS', 'TRANSFERENCIA ENTRE CONTAS BANCARIAS'),
                        (9794, true, 'TRANSFERENCIAS DE VALORES RETIDOS', 'TRANSFERENCIAS DE VALORES RETIDOS'),
                        (9795, true, 'DEPOSITO DECENDIAL EDUCAÇÃO', 'DEPOSITO DECENDIAL EDUCAÇÃO'),
                        (9796, true, 'DEPOSITO DECENDIAL SAUDE', 'DEPOSITO DECENDIAL SAUDE'),
                        (9797, true, 'TRANSFERENCIA DA CONTRAPARTIDA DO CONVENIO', 'TRANSFERENCIA DA CONTRAPARTIDA DO CONVENIO'),
                        (9798, true, 'TRANSFERENCIA ENTRE CONTAS', 'TRANSFERENCIA ENTRE CONTAS'),
                        (9799, true, 'TRANSFERENCIA DA CONTA CAIXA PARA ESTA CONTA', 'TRANSFERENCIA DA CONTA CAIXA PARA ESTA CONTA'),
                        (9790, true, 'SAQUES', 'SAQUES');

                        UPDATE {$nomeArquivo} SET c50_descr='TRANSFERÊNCIA BANCÁRIA' , c50_descrcompl='TRANSFERÊNCIA BANCÁRIA' WHERE c50_codhist = 9700;

                        UPDATE {$nomeArquivo} SET c50_descrcompl='VALOR REFERENTE À RECEBIMENTO EXTRAORÇAMENTÁRIO' WHERE c50_codhist = 9500;

                        UPDATE {$nomeArquivo} SET c50_descrcompl='VALOR REFERENTE À PAGAMENTO EXTRAORÇAMENTÁRIO' WHERE c50_codhist = 9030;

                    
                        ALTER TABLE slip ADD k17_numdocumento varchar NULL;

                        ALTER TABLE slip ADD k17_tiposelect varchar NULL;
                    
                    
                    COMMIT";  
               
            $this->execute($sql);            
        
    }
}