<?php

use Phinx\Migration\AbstractMigration;

class Oc18553Hotfix extends AbstractMigration
{

    public function up()
    {
        $sql =  "

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

        create table amparocflicita(
            l213_amparo int not null,
            l213_modalidade int not null,
            PRIMARY KEY (l213_amparo,l213_modalidade),
            FOREIGN KEY (l213_amparo) REFERENCES amparolegal(l212_codigo),
            FOREIGN KEY (l213_modalidade) REFERENCES cflicita(l03_codigo));";

        $aRowsModalidade =   $this->fetchAll("SELECT l03_codigo FROM cflicita WHERE l03_pctipocompratribunal = 110");

        foreach ($aRowsModalidade as $modalidade) {
            $sql .= " INSERT INTO amparocflicita VALUES (5,{$modalidade['l03_codigo']});";
        }

        $aRowsModalidade =   $this->fetchAll("SELECT l03_codigo FROM cflicita WHERE l03_pctipocompratribunal = 51");

        foreach ($aRowsModalidade as $modalidade) {
            $sql .= " INSERT INTO amparocflicita VALUES (3,{$modalidade['l03_codigo']});";
        }

        $aRowsModalidade =   $this->fetchAll("SELECT l03_codigo FROM cflicita WHERE l03_pctipocompratribunal = 50");

        foreach ($aRowsModalidade as $modalidade) {
            $sql .= " INSERT INTO amparocflicita VALUES (2,{$modalidade['l03_codigo']});";
        }

        $aRowsModalidade =   $this->fetchAll("SELECT l03_codigo FROM cflicita WHERE l03_pctipocompratribunal = 53");

        foreach ($aRowsModalidade as $modalidade) {
            $sql .= " INSERT INTO amparocflicita VALUES (1,{$modalidade['l03_codigo']});";
        }

        $aRowsModalidade =   $this->fetchAll("SELECT l03_codigo FROM cflicita WHERE l03_pctipocompratribunal = 52");

        foreach ($aRowsModalidade as $modalidade) {
            $sql .= " INSERT INTO amparocflicita VALUES (1,{$modalidade['l03_codigo']});";
        }

        $aRowsModalidade =   $this->fetchAll("SELECT l03_codigo FROM cflicita WHERE l03_pctipocompratribunal = 101");

        foreach ($aRowsModalidade as $modalidade) {
            $sql .= " INSERT INTO amparocflicita VALUES (18,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (19,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (20,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (21,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (22,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (23,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (24,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (25,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (26,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (27,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (28,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (29,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (30,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (31,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (32,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (33,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (34,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (35,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (36,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (37,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (38,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (39,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (40,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (41,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (42,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (43,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (44,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (45,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (46,{$modalidade['l03_codigo']});";
        }

        $aRowsModalidade =   $this->fetchAll("SELECT l03_codigo FROM cflicita WHERE l03_pctipocompratribunal = 100");

        foreach ($aRowsModalidade as $modalidade) {
            $sql .= " INSERT INTO amparocflicita VALUES (6,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (7,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (8,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (9,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (10,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (11,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (12,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (13,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (14,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (15,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (16,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (17,{$modalidade['l03_codigo']});";
            $sql .= " INSERT INTO amparocflicita VALUES (50,{$modalidade['l03_codigo']});";
        }

        $aRowsModalidade =   $this->fetchAll("SELECT l03_codigo FROM cflicita WHERE l03_pctipocompratribunal = 102");

        foreach ($aRowsModalidade as $modalidade) {
            $sql .= " INSERT INTO amparocflicita VALUES (47,{$modalidade['l03_codigo']});";
        }

        $aRowsModalidade =   $this->fetchAll("SELECT l03_codigo FROM cflicita WHERE l03_pctipocompratribunal = 103");

        foreach ($aRowsModalidade as $modalidade) {
            $sql .= " INSERT INTO amparocflicita VALUES (47,{$modalidade['l03_codigo']});";
        }

        $sql .= " COMMIT;";

        $this->execute($sql);
    }
}
