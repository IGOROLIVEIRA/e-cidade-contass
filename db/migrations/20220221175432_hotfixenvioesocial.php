<?php

use Phinx\Migration\AbstractMigration;

class Hotfixenvioesocial extends AbstractMigration
{
    public function up()
    {
        $sql = "
        BEGIN;
        update avaliacaopergunta set db103_perguntaidentificadora = true, db103_ordem = 1 where db103_identificador = 'matricula-atribuida-ao-trabalhador-pela--4000599';
        update avaliacaopergunta set db103_perguntaidentificadora = true, db103_ordem = 2 where db103_identificador = 'nome-do-trabalhador-4000553';
        update avaliacaopergunta set db103_perguntaidentificadora = true, db103_ordem = 3 where db103_identificador = 'preencher-com-a-data-de-admissao-do-trab-4000603';
        update avaliacaopergunta set db103_perguntaidentificadora = true, db103_ordem = 4 where db103_identificador = 'data-da-entrada-em-exercicio-pelo-servid-4000620';

        update avaliacaopergunta set db103_perguntaidentificadora = false where db103_identificador = 'preencher-com-o-numero-do-cpf-do-trabalh-4000552';
        update avaliacaopergunta set db103_perguntaidentificadora = false where db103_identificador = 'informar-o-nome-do-cargo-4000625';

        ALTER TABLE public.esocialenvio ADD rh213_protocolo varchar(100) NULL;
        COMMIT;
        ";
        $this->execute($sql);
    }
}
