<?php

use Phinx\Migration\AbstractMigration;

class Hotfixfieldinstituicaos2200 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        INSERT INTO habitacao.avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES((select max(db103_sequencial)+1 from avaliacaopergunta), 1, 4000188, 'Instituição no e-Cidade:', true, true, 1, 'instituicao-no-ecidade-4000102', 6, '', 0, true, 'instituicao', 'instituicao');

        INSERT INTO avaliacaoperguntaopcao VALUES (
            (SELECT max(db104_sequencial)+1 FROM avaliacaoperguntaopcao),
            (SELECT db103_sequencial FROM avaliacaopergunta WHERE db103_identificador = 'instituicao-no-ecidade-4000102'),
            NULL,
            't',
            (SELECT db103_identificadorcampo FROM avaliacaopergunta WHERE db103_identificador = 'instituicao-no-ecidade-4000102')||'-'||(SELECT max(db104_sequencial)+1 FROM avaliacaoperguntaopcao)::varchar,
            0,
            NULL,
            (SELECT db103_identificadorcampo FROM avaliacaopergunta WHERE db103_identificador = 'instituicao-no-ecidade-4000102'));
        ";
        $this->execute($sql);
    }
}
