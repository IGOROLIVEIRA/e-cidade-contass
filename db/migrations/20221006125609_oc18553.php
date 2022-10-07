<?php

use Phinx\Migration\AbstractMigration;

class Oc18553 extends AbstractMigration
{

    public function up()
    {
        $sql = "

        BEGIN;

        CREATE SEQUENCE amparolegal_l212_codigo_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;

        create table amparolegal(

        l212_codigo int not null default 0,
        l212_lei varchar (100) not null ,
        CONSTRAINT amparolegal_sequ_pk PRIMARY KEY (l212_codigo));
        
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 28, I');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 28, II');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 28, III');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), ' Lei14.133/2021, Art. 28, IV');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), ' Lei14.133/2021, Art. 28, V');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, I');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, II');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, III, a');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, III, b');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, III, c');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, III, d');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, III, e');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, III, f');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, III, g');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, III, h');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), ' Lei14.133/2021, Art. 74, IV');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), ' Lei14.133/2021, Art. 74, V');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), ' Lei14.133/2021, Art. 75, I');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, II');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), ' Lei14.133/2021, Art. 75, III, a');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, III, b');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, a');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, b');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, c');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, d');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, e');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, f');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, g');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, h');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, i');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, j');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, k');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, l');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IV, m');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, V');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, VI');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, VII');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, VIII');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, IX');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, X');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, XI');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, XII');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, XIII');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, XIV');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, XV');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 75, XVI');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 78, I');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 78, II');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 78, III');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei14.133/2021, Art. 74, Caput');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei 14.284/2021, Art. 29, caput');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei 14.284/2021, Art. 24 § 1º ');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei 14.284/2021, Art. 25 § 1º');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei 14.284/2021, Art. 34');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei 9.636/1998, Art. 11-C, I');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei 9.636/1998, Art. 11-C, II');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei 9.636/1998, Art. 24-C, I');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei 9.636/1998, Art. 24-C, II');
        INSERT INTO amparolegal VALUES (nextval('amparolegal_l212_codigo_seq'), 'Lei 9.636/1998, Art. 24-C, III'); 

        create table cflicita_amparo(
            l213_amparo int not null,
            l213_modalidade int not null,
            PRIMARY KEY (l213_amparo,l213_modalidade),
            FOREIGN KEY (l213_amparo) REFERENCES amparolegal(l212_codigo),
            FOREIGN KEY (l213_modalidade) REFERENCES cflicita(l03_codigo));

        INSERT INTO cflicita_amparo VALUES (5,(select l03_codigo from cflicita where l03_pctipocompratribunal = 110 limit 1));
        INSERT INTO cflicita_amparo VALUES (3,(select l03_codigo from cflicita where l03_pctipocompratribunal = 51 limit 1));
        INSERT INTO cflicita_amparo VALUES (2,(select l03_codigo from cflicita where l03_pctipocompratribunal = 50 limit 1));
        INSERT INTO cflicita_amparo VALUES (1,(select l03_codigo from cflicita where l03_pctipocompratribunal = 53 limit 1));
        INSERT INTO cflicita_amparo VALUES (1,(select l03_codigo from cflicita where l03_pctipocompratribunal = 52 limit 1));
        INSERT INTO cflicita_amparo VALUES (18,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (19,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (20,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (21,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (22,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (23,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (24,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (25,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (26,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (27,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (28,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (29,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (30,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (31,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (32,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (33,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (34,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (35,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (36,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (37,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (38,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (39,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (40,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (41,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (42,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (43,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (44,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (45,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (46,(select l03_codigo from cflicita where l03_pctipocompratribunal = 101 limit 1));
        INSERT INTO cflicita_amparo VALUES (6,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (7,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (8,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (9,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (10,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (11,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (12,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (13,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (14,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (15,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (16,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (17,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (50,(select l03_codigo from cflicita where l03_pctipocompratribunal = 100 limit 1));
        INSERT INTO cflicita_amparo VALUES (47,(select l03_codigo from cflicita where l03_pctipocompratribunal = 102 limit 1));
        INSERT INTO cflicita_amparo VALUES (47,(select l03_codigo from cflicita where l03_pctipocompratribunal = 103 limit 1));
          
            

        COMMIT;

        ";
    }
}
