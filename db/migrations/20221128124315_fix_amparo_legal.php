<?php

use Phinx\Migration\AbstractMigration;

class FixAmparoLegal extends AbstractMigration
{

    public function up()
    {
        $sql = "
        BEGIN;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 28, I' WHERE l212_codigo = 1;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 28, II' WHERE l212_codigo = 2;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 28, III' WHERE l212_codigo = 3;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 28, IV' WHERE l212_codigo = 4;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 28, V' WHERE l212_codigo = 5;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, I' WHERE l212_codigo = 6;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, II' WHERE l212_codigo = 7;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, III, a' WHERE l212_codigo = 8;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, III, b' WHERE l212_codigo = 9;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, III, c' WHERE l212_codigo = 10;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, III, d' WHERE l212_codigo = 11;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, III, e' WHERE l212_codigo = 12;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, III, f' WHERE l212_codigo = 13;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, III, g' WHERE l212_codigo = 14;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, III, h' WHERE l212_codigo = 15;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, IV' WHERE l212_codigo = 16;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, V' WHERE l212_codigo = 17;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, I' WHERE l212_codigo = 18;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, II' WHERE l212_codigo = 19;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, III, a' WHERE l212_codigo = 20;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, III, b' WHERE l212_codigo = 21;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, a' WHERE l212_codigo = 22;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, b' WHERE l212_codigo = 23;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, c' WHERE l212_codigo = 24;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV' WHERE l212_codigo = 25;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, e' WHERE l212_codigo = 26;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, f' WHERE l212_codigo = 27;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, g' WHERE l212_codigo = 28;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, h' WHERE l212_codigo = 29;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, i' WHERE l212_codigo = 30;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, j' WHERE l212_codigo = 31;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, k' WHERE l212_codigo = 32;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, l' WHERE l212_codigo = 33;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IV, m' WHERE l212_codigo = 34;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, V' WHERE l212_codigo = 35;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, VI' WHERE l212_codigo = 36;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, VII' WHERE l212_codigo = 37;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, VIII' WHERE l212_codigo = 38;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, IX' WHERE l212_codigo = 39;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, X' WHERE l212_codigo = 40;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, XI' WHERE l212_codigo = 41;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, XII' WHERE l212_codigo = 42;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, XIII' WHERE l212_codigo = 43;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, XIV' WHERE l212_codigo = 44;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, XV' WHERE l212_codigo = 45;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 75, XVI' WHERE l212_codigo = 46;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 78, I' WHERE l212_codigo = 47;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 78, II' WHERE l212_codigo = 48;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 78, III' WHERE l212_codigo = 49;
        UPDATE amparolegal SET l212_lei = 'Lei 14.133/2021, Art. 74, Caput' WHERE l212_codigo = 50;
        COMMIT;
        ";
        $this->execute($sql);
    }
}
