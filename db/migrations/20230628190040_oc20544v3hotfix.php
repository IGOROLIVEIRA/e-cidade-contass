<?php

use Phinx\Migration\AbstractMigration;

class Oc20544v3hotfix extends AbstractMigration
{
    public function up()
    {
        $nomeCampo = "e30_liquidacaodataanterior";
        $descricaoCampo = "Liquidação c/ data anterior a última";
        $nomeArquivo = "empparametro";
        $sqlConsulta = $this->query("SELECT 1 FROM db_syscampo WHERE nomecam = '{$nomeCampo}' AND descricao = '{$descricaoCampo}'");
        $resultado = $sqlConsulta->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($resultado)){
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
               
                    ALTER TABLE {$nomeArquivo} ADD COLUMN {$nomeCampo} bool DEFAULT NULL;
                    COMMIT";  
               
            $this->execute($sql);            
        }
    }
}
