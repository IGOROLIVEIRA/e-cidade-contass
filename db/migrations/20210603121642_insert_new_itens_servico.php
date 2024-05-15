<?php

use Phinx\Migration\AbstractMigration;

class InsertNewItensServico extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        INSERT INTO db_estruturavalor
        VALUES ((SELECT nextval('db_estruturavalor_db121_sequencial_seq')), 150000, '01.09'::varchar, 'Disponibilização, sem cessão definitiva, de conteúdos de áudio, vídeo, imagem e texto por meio da internet, respeitada a imunidade de livros, jornais e periódicos (exceto a distribuição de conteúdos pelas prestadoras de Serviço de Acesso Condicionado)'::varchar, 17, 2, 2);


        INSERT INTO db_estruturavalor
        VALUES ((SELECT nextval('db_estruturavalor_db121_sequencial_seq')), 150000, '14.14'::varchar, 'Guincho intramunicipal, guindaste e içamento.'::varchar, 144, 2, 2);


        INSERT INTO db_estruturavalor
        VALUES ((SELECT nextval('db_estruturavalor_db121_sequencial_seq')), 150000, '17.25'::varchar, 'Inserção de textos, desenhos e outros materiais de propaganda e publicidade, em qualquer meio (exceto em livros, jornais, periódicos e nas modalidades de serviços de radiodifusão sonora e de sons e imagens de recepção livre e gratuita)'::varchar, 179, 2, 2);


        INSERT INTO db_estruturavalor
        VALUES ((SELECT nextval('db_estruturavalor_db121_sequencial_seq')), 150000, '25.05'::varchar, 'Cessão de uso de espaços em cemitérios para sepultamento'::varchar, 220, 2, 2);


        INSERT INTO db_estruturavalor
        VALUES ((SELECT nextval('db_estruturavalor_db121_sequencial_seq')), 150000, '06.06'::varchar, 'Aplicação de tatuagens, piercings e congêneres'::varchar, 68, 2, 2);


        INSERT INTO issgruposervico
        SELECT nextval('issgruposervico_q126_sequencial_seq'),
               db121_sequencial
        FROM db_estruturavalor
        WHERE db121_estrutural in ('01.09',
                                   '14.14',
                                   '17.25',
                                   '25.05',
                                   '06.06');
               
        COMMIT;

SQL;

        $this->execute($sql);
    }

}