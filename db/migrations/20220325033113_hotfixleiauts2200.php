<?php

use Phinx\Migration\AbstractMigration;

class Hotfixleiauts2200 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='desccomp_localtrabgeral' WHERE db103_sequencial=4000644;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='nrinsc_localtrabgeral ' WHERE db103_sequencial=4000643;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='tpinsc_localtrabgeral' WHERE db103_sequencial=4000642;

        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto1' WHERE db103_sequencial=4000590;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto2' WHERE db103_sequencial=4001514;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto3' WHERE db103_sequencial=4001522;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto4' WHERE db103_sequencial=4001530;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto5' WHERE db103_sequencial=4001538;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto6' WHERE db103_sequencial=4001546;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto7' WHERE db103_sequencial=4001554;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto8' WHERE db103_sequencial=4001562;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto9' WHERE db103_sequencial=4001570;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dtnascto10' WHERE db103_sequencial=4001578;

        UPDATE habitacao.avaliacaopergunta SET db103_camposql='paisresid_exterior' WHERE db103_sequencial=4000570;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='dsclograd_exterior' WHERE db103_sequencial=4000571;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='nrlograd_exterior' WHERE db103_sequencial=4000572;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='complemento_exterior' WHERE db103_sequencial=4000573;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='bairro_exterior' WHERE db103_sequencial=4000574;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='nmcid_exterior' WHERE db103_sequencial=4000575;
        UPDATE habitacao.avaliacaopergunta SET db103_camposql='codpostal_exterior' WHERE db103_sequencial=4000576;

        INSERT INTO habitacao.avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo) VALUES((select max(db103_sequencial)+1 from avaliacaopergunta), 1, 4000188, 'Instituição no e-Cidade:', true, true, 1, 'instituicao-no-ecidade', 6, '', 0, true, 'instituicao', 'instituicao');

        UPDATE avaliacaopergunta SET db103_avaliacaotiporesposta = 2 WHERE db103_identificador = 'instituicao-no-ecidade-4000102';
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
