<?php

use Phinx\Migration\AbstractMigration;

class Oc21389 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            begin;

                alter table pcproc add column pc80_criteriojulgamento int4;

                insert into amparolegal values (60,'Lei 14.133/2021, Art. 75, XVII');
                insert into amparolegal values (61,'Lei 14.133/2021, Art. 76, I, a');
                insert into amparolegal values (62,'Lei 14.133/2021, Art. 76, I, b');
                insert into amparolegal values (63,'Lei 14.133/2021, Art. 76, I, c');
                insert into amparolegal values (64,'Lei 14.133/2021, Art. 76, I, d');
                insert into amparolegal values (65,'Lei 14.133/2021, Art. 76, I, e');
                insert into amparolegal values (66,'Lei 14.133/2021, Art. 76, I, f');
                insert into amparolegal values (67,'Lei 14.133/2021, Art. 76, I, g');
                insert into amparolegal values (68,'Lei 14.133/2021, Art. 76, I, h');
                insert into amparolegal values (69,'Lei 14.133/2021, Art. 76, I, i');
                insert into amparolegal values (70,'Lei 14.133/2021, Art. 76, I, j');
                insert into amparolegal values (71,'Lei 14.133/2021, Art. 76, II, a');
                insert into amparolegal values (72,'Lei 14.133/2021, Art. 76, II, b');
                insert into amparolegal values (73,'Lei 14.133/2021, Art. 76, II, c');
                insert into amparolegal values (74,'Lei 14.133/2021, Art. 76, II, d');
                insert into amparolegal values (75,'Lei 14.133/2021, Art. 76, II, e');
                insert into amparolegal values (76,'Lei 14.133/2021, Art. 76, II, f');
                insert into amparolegal values (77,'Lei 14.133/2021, Art. 75, XVIII');
                insert into amparolegal values (78,'Lei 14.628/2023, Art. 4º');
                insert into amparolegal values (79,'Lei 14.628/2023, Art. 12');
                insert into amparolegal values (80,'Lei 14.133/2021, Art. 1º, § 2º');
                insert into amparolegal values (81,'Lei 13.303/2016, Art. 27, § 3º');
                insert into amparolegal values (82,'Lei 13.303/2016, Art. 28, § 3º, I');
                insert into amparolegal values (83,'Lei 13.303/2016, Art. 28, § 3º, II');
                insert into amparolegal values (84,'Lei 13.303/2016, Art. 29, I');
                insert into amparolegal values (85,'Lei 13.303/2016, Art. 29, II');
                insert into amparolegal values (86,'Lei 13.303/2016, Art. 29, III');
                insert into amparolegal values (87,'Lei 13.303/2016, Art. 29, IV');
                insert into amparolegal values (88,'Lei 13.303/2016, Art. 29, V');
                insert into amparolegal values (89,'Lei 13.303/2016, Art. 29, VI');
                insert into amparolegal values (90,'Lei 13.303/2016, Art. 29, VII');
                insert into amparolegal values (91,'Lei 13.303/2016, Art. 29, VIII');
                insert into amparolegal values (92,'Lei 13.303/2016, Art. 29, IX');
                insert into amparolegal values (93,'Lei 13.303/2016, Art. 29, X');
                insert into amparolegal values (94,'Lei 13.303/2016, Art. 29, XI');
                insert into amparolegal values (95,'Lei 13.303/2016, Art. 29, XII');
                insert into amparolegal values (96,'Lei 13.303/2016, Art. 29, XIII');
                insert into amparolegal values (97,'Lei 13.303/2016, Art. 29, XIV');
                insert into amparolegal values (98,'Lei 13.303/2016, Art. 29, XV');
                insert into amparolegal values (99,'Lei 13.303/2016, Art. 29, XVI');
                insert into amparolegal values (100 ,' Lei 13.303/2016, Art. 29, XVII');
                insert into amparolegal values (101 ,' Lei 13.303/2016, Art. 29, XVIII');
                insert into amparolegal values (102 ,' Lei 13.303/2016, Art. 30, caput - inexigibilidade');
                insert into amparolegal values (103 ,' Lei 13.303/2016, Art. 30, caput - credenciamento');
                insert into amparolegal values (104 ,' Lei 13.303/2016, Art. 30, I');
                insert into amparolegal values (105 ,' Lei 13.303/2016, Art. 30, II, a');
                insert into amparolegal values (106 ,' Lei 13.303/2016, Art. 30, II, b');
                insert into amparolegal values (107 ,' Lei 13.303/2016, Art. 30, II, c');
                insert into amparolegal values (108 ,' Lei 13.303/2016, Art. 30, II, d');
                insert into amparolegal values (109 ,' Lei 13.303/2016, Art. 30, II, e');
                insert into amparolegal values (110 ,' Lei 13.303/2016, Art. 30, II, f');
                insert into amparolegal values (111 ,' Lei 13.303/2016, Art. 30, II, g');
                insert into amparolegal values (112 ,' Lei 13.303/2016, Art. 31, § 4º');
                insert into amparolegal values (113 ,' Lei 13.303/2016, Art. 32, IV');
                insert into amparolegal values (114 ,' Lei 13.303/2016, Art. 54, I');
                insert into amparolegal values (115 ,' Lei 13.303/2016, Art. 54, II');
                insert into amparolegal values (116 ,' Lei 13.303/2016, Art. 54, III');
                insert into amparolegal values (117 ,' Lei 13.303/2016, Art. 54, IV');
                insert into amparolegal values (118 ,' Lei 13.303/2016, Art. 54, V');
                insert into amparolegal values (119 ,' Lei 13.303/2016, Art. 54, VI');
                insert into amparolegal values (120 ,' Lei 13.303/2016, Art. 54, VII');
                insert into amparolegal values (121 ,' Lei 13.303/2016, Art. 54, VIII');
                insert into amparolegal values (122 ,' Lei 13.303/2016, Art. 63, I');
                insert into amparolegal values (123 ,' Lei 13.303/2016, Art. 63, III');
                insert into amparolegal values (124 ,' Regulamento Interno de Licitações e Contratos Estatais - diálogo competitivo');
                insert into amparolegal values (125 ,' Regulamento Interno de Licitações e Contratos Estatais - credenciamento');
                insert into amparolegal values (126 ,' Lei 12.850/2013, Art. 3º, §1º, II');
                insert into amparolegal values (127 ,' Lei 12.850/2013, Art. 3º, §1º, V');
                insert into amparolegal values (128 ,' Lei 13.529/2017, Art. 5º');
                insert into amparolegal values (129 ,' Lei 8.629/1993, Art. 17, § 3º, V');
                insert into amparolegal values (130 ,' Lei 10.847/2004, Art. 6º');
                insert into amparolegal values (131 ,' Lei 11.516/2007, Art. 14-A');
                insert into amparolegal values (132 ,' Lei 11.652/2008, Art. 8º, § 2º, I');
                insert into amparolegal values (133 ,' Lei 11.652/2008, Art. 8º, § 2º, II');
                insert into amparolegal values (134 ,' Lei 11.759/2008, Art. 18-A');
                insert into amparolegal values (135 ,' Lei 12.865/2013, Art. 18, § 1º');
                insert into amparolegal values (136 ,' Lei 12.873/2013, Art. 42');
                insert into amparolegal values (137 ,' Lei 13.979/2020, Art. 4º, § 1º');
            commit;
        ";
        $this->execute($sql);
    }
}
