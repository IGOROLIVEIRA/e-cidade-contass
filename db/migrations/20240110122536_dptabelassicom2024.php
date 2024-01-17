<?php

use Phinx\Migration\AbstractMigration;

class Dptabelassicom2024 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
BEGIN;
-- aberlic102024_si46_sequencial_seq definition

--DROP SEQUENCE aberlic102024_si46_sequencial_seq;

CREATE SEQUENCE aberlic102024_si46_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic112024_si47_sequencial_seq definition

--DROP SEQUENCE aberlic112024_si47_sequencial_seq;

CREATE SEQUENCE aberlic112024_si47_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic122024_si48_sequencial_seq definition

--DROP SEQUENCE aberlic122024_si48_sequencial_seq;

CREATE SEQUENCE aberlic122024_si48_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic132024_si49_sequencial_seq definition

--DROP SEQUENCE aberlic132024_si49_sequencial_seq;

CREATE SEQUENCE aberlic132024_si49_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic142024_si50_sequencial_seq definition

--DROP SEQUENCE aberlic142024_si50_sequencial_seq;

CREATE SEQUENCE aberlic142024_si50_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic152024_si51_sequencial_seq definition

--DROP SEQUENCE aberlic152024_si51_sequencial_seq;

CREATE SEQUENCE aberlic152024_si51_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aberlic162024_si52_sequencial_seq definition

--DROP SEQUENCE aberlic162024_si52_sequencial_seq;

CREATE SEQUENCE aberlic162024_si52_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aex102024_si130_sequencial_seq definition

--DROP SEQUENCE aex102024_si130_sequencial_seq;

CREATE SEQUENCE aex102024_si130_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- alq102024_si121_sequencial_seq definition

--DROP SEQUENCE alq102024_si121_sequencial_seq;

CREATE SEQUENCE alq102024_si121_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- alq112024_si122_sequencial_seq definition

--DROP SEQUENCE alq112024_si122_sequencial_seq;

CREATE SEQUENCE alq112024_si122_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- alq122024_si123_sequencial_seq definition

--DROP SEQUENCE alq122024_si123_sequencial_seq;

CREATE SEQUENCE alq122024_si123_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- anl102024_si110_sequencial_seq definition

--DROP SEQUENCE anl102024_si110_sequencial_seq;

CREATE SEQUENCE anl102024_si110_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- anl112024_si111_sequencial_seq definition

--DROP SEQUENCE anl112024_si111_sequencial_seq;

CREATE SEQUENCE anl112024_si111_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aob102024_si141_sequencial_seq definition

--DROP SEQUENCE aob102024_si141_sequencial_seq;

CREATE SEQUENCE aob102024_si141_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aob112024_si142_sequencial_seq definition

--DROP SEQUENCE aob112024_si142_sequencial_seq;

CREATE SEQUENCE aob112024_si142_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc102024_si38_sequencial_seq definition

--DROP SEQUENCE aoc102024_si38_sequencial_seq;

CREATE SEQUENCE aoc102024_si38_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc112024_si39_sequencial_seq definition

--DROP SEQUENCE aoc112024_si39_sequencial_seq;

CREATE SEQUENCE aoc112024_si39_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc122024_si40_sequencial_seq definition

--DROP SEQUENCE aoc122024_si40_sequencial_seq;

CREATE SEQUENCE aoc122024_si40_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc132024_si41_sequencial_seq definition

--DROP SEQUENCE aoc132024_si41_sequencial_seq;

CREATE SEQUENCE aoc132024_si41_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc142024_si42_sequencial_seq definition

--DROP SEQUENCE aoc142024_si42_sequencial_seq;

CREATE SEQUENCE aoc142024_si42_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aoc152024_si194_sequencial_seq definition

--DROP SEQUENCE aoc152024_si194_sequencial_seq;

CREATE SEQUENCE aoc152024_si194_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aop102024_si137_sequencial_seq definition

--DROP SEQUENCE aop102024_si137_sequencial_seq;

CREATE SEQUENCE aop102024_si137_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- aop112024_si138_sequencial_seq definition

--DROP SEQUENCE aop112024_si138_sequencial_seq;

CREATE SEQUENCE aop112024_si138_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- arc102024_si28_sequencial_seq definition

--DROP SEQUENCE arc102024_si28_sequencial_seq;

CREATE SEQUENCE arc102024_si28_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- arc112024_si29_sequencial_seq definition

--DROP SEQUENCE arc112024_si29_sequencial_seq;

CREATE SEQUENCE arc112024_si29_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- arc202024_si31_sequencial_seq definition

--DROP SEQUENCE arc202024_si31_sequencial_seq;

CREATE SEQUENCE arc202024_si31_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- arc212024_si32_sequencial_seq definition

--DROP SEQUENCE arc212024_si32_sequencial_seq;

CREATE SEQUENCE arc212024_si32_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa102024_si103_sequencial_seq definition

--DROP SEQUENCE caixa102024_si103_sequencial_seq;

CREATE SEQUENCE caixa102024_si103_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa112024_si166_sequencial_seq definition

--DROP SEQUENCE caixa112024_si166_sequencial_seq;

CREATE SEQUENCE caixa112024_si166_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa122024_si104_sequencial_seq definition

--DROP SEQUENCE caixa122024_si104_sequencial_seq;

CREATE SEQUENCE caixa122024_si104_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- caixa132024_si105_sequencial_seq definition

--DROP SEQUENCE caixa132024_si105_sequencial_seq;

CREATE SEQUENCE caixa132024_si105_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge102024_si182_sequencial_seq definition

--DROP SEQUENCE conge102024_si182_sequencial_seq;

CREATE SEQUENCE conge102024_si182_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- conge202024_si183_sequencial_seq definition

--DROP SEQUENCE conge202024_si183_sequencial_seq;

CREATE SEQUENCE conge202024_si183_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge302024_si184_sequencial_seq definition

--DROP SEQUENCE conge302024_si184_sequencial_seq;

CREATE SEQUENCE conge302024_si184_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge402024_si237_sequencial_seq definition

--DROP SEQUENCE conge402024_si237_sequencial_seq;

CREATE SEQUENCE conge402024_si237_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conge502024_si238_sequencial_seq definition

--DROP SEQUENCE conge502024_si238_sequencial_seq;

CREATE SEQUENCE conge502024_si238_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consid102024_si158_sequencial_seq definition

--DROP SEQUENCE consid102024_si158_sequencial_seq;

CREATE SEQUENCE consid102024_si158_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor102024_si16_sequencial_seq definition

--DROP SEQUENCE consor102024_si16_sequencial_seq;

CREATE SEQUENCE consor102024_si16_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- consor202024_si17_sequencial_seq definition

--DROP SEQUENCE consor202024_si17_sequencial_seq;

CREATE SEQUENCE consor202024_si17_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor302024_si18_sequencial_seq definition

--DROP SEQUENCE consor302024_si18_sequencial_seq;

CREATE SEQUENCE consor302024_si18_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor402024_si19_sequencial_seq definition

--DROP SEQUENCE consor402024_si19_sequencial_seq;

CREATE SEQUENCE consor402024_si19_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- consor502024_si20_sequencial_seq definition

--DROP SEQUENCE consor502024_si20_sequencial_seq;

CREATE SEQUENCE consor502024_si20_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos102024_si83_sequencial_seq definition

--DROP SEQUENCE contratos102024_si83_sequencial_seq;

CREATE SEQUENCE contratos102024_si83_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos112024_si84_sequencial_seq definition

--DROP SEQUENCE contratos112024_si84_sequencial_seq;

CREATE SEQUENCE contratos112024_si84_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos122024_si85_sequencial_seq definition

--DROP SEQUENCE contratos122024_si85_sequencial_seq;

CREATE SEQUENCE contratos122024_si85_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos132024_si86_sequencial_seq definition

--DROP SEQUENCE contratos132024_si86_sequencial_seq;

CREATE SEQUENCE contratos132024_si86_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- contratos202024_si87_sequencial_seq definition

--DROP SEQUENCE contratos202024_si87_sequencial_seq;

CREATE SEQUENCE contratos202024_si87_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos212024_si88_sequencial_seq definition

--DROP SEQUENCE contratos212024_si88_sequencial_seq;

CREATE SEQUENCE contratos212024_si88_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos302024_si89_sequencial_seq definition

--DROP SEQUENCE contratos302024_si89_sequencial_seq;

CREATE SEQUENCE contratos302024_si89_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- contratos402024_si91_sequencial_seq definition

--DROP SEQUENCE contratos402024_si91_sequencial_seq;

CREATE SEQUENCE contratos402024_si91_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- conv102024_si92_sequencial_seq definition

--DROP SEQUENCE conv102024_si92_sequencial_seq;

CREATE SEQUENCE conv102024_si92_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv112024_si93_sequencial_seq definition

--DROP SEQUENCE conv112024_si93_sequencial_seq;

CREATE SEQUENCE conv112024_si93_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv202024_si94_sequencial_seq definition

--DROP SEQUENCE conv202024_si94_sequencial_seq;

CREATE SEQUENCE conv202024_si94_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv212024_si232_sequencial_seq definition

--DROP SEQUENCE conv212024_si232_sequencial_seq;

CREATE SEQUENCE conv212024_si232_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv302024_si203_sequencial_seq definition

--DROP SEQUENCE conv302024_si203_sequencial_seq;

CREATE SEQUENCE conv302024_si203_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- conv312024_si204_sequencial_seq definition

--DROP SEQUENCE conv312024_si204_sequencial_seq;

CREATE SEQUENCE conv312024_si204_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cronem102024_si170_sequencial_seq definition

--DROP SEQUENCE cronem102024_si170_sequencial_seq;

CREATE SEQUENCE cronem102024_si170_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb102024_si95_sequencial_seq definition

--DROP SEQUENCE ctb102024_si95_sequencial_seq;

CREATE SEQUENCE ctb102024_si95_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- ctb202024_si96_sequencial_seq definition

--DROP SEQUENCE ctb202024_si96_sequencial_seq;

CREATE SEQUENCE ctb202024_si96_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb212024_si97_sequencial_seq definition

--DROP SEQUENCE ctb212024_si97_sequencial_seq;

CREATE SEQUENCE ctb212024_si97_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb222024_si98_sequencial_seq definition

--DROP SEQUENCE ctb222024_si98_sequencial_seq;

CREATE SEQUENCE ctb222024_si98_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb302024_si99_sequencial_seq definition

--DROP SEQUENCE ctb302024_si99_sequencial_seq;

CREATE SEQUENCE ctb302024_si99_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb312024_si100_sequencial_seq definition

--DROP SEQUENCE ctb312024_si100_sequencial_seq;

CREATE SEQUENCE ctb312024_si100_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb402024_si101_sequencial_seq definition

--DROP SEQUENCE ctb402024_si101_sequencial_seq;

CREATE SEQUENCE ctb402024_si101_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ctb502024_si102_sequencial_seq definition

--DROP SEQUENCE ctb502024_si102_sequencial_seq;

CREATE SEQUENCE ctb502024_si102_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cute102024_si199_sequencial_seq definition

--DROP SEQUENCE cute102024_si199_sequencial_seq;

CREATE SEQUENCE cute102024_si199_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- cute202024_si200_sequencial_seq definition

--DROP SEQUENCE cute202024_si200_sequencial_seq;

CREATE SEQUENCE cute202024_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cute212024_si201_sequencial_seq definition

--DROP SEQUENCE cute212024_si201_sequencial_seq;

CREATE SEQUENCE cute212024_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cute302024_si202_sequencial_seq definition

--DROP SEQUENCE cute302024_si202_sequencial_seq;

CREATE SEQUENCE cute302024_si202_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cvc102024_si146_sequencial_seq definition

--DROP SEQUENCE cvc102024_si146_sequencial_seq;

CREATE SEQUENCE cvc102024_si146_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- cvc202024_si147_sequencial_seq definition

--DROP SEQUENCE cvc202024_si147_sequencial_seq;

CREATE SEQUENCE cvc202024_si147_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cvc302024_si148_sequencial_seq definition

--DROP SEQUENCE cvc302024_si148_sequencial_seq;

CREATE SEQUENCE cvc302024_si148_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cvc402024_si149_sequencial_seq definition

--DROP SEQUENCE cvc402024_si149_sequencial_seq;

CREATE SEQUENCE cvc402024_si149_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf102024_si157_sequencial_seq definition

--DROP SEQUENCE dclrf102024_si157_sequencial_seq;

CREATE SEQUENCE dclrf102024_si157_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf112024_si205_sequencial_seq definition

--DROP SEQUENCE dclrf112024_si205_sequencial_seq;

CREATE SEQUENCE dclrf112024_si205_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- dclrf202024_si191_sequencial_seq definition

--DROP SEQUENCE dclrf202024_si191_sequencial_seq;

CREATE SEQUENCE dclrf202024_si191_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf302024_si192_sequencial_seq definition

--DROP SEQUENCE dclrf302024_si192_sequencial_seq;

CREATE SEQUENCE dclrf302024_si192_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dclrf402024_si193_sequencial_seq definition

--DROP SEQUENCE dclrf402024_si193_sequencial_seq;

CREATE SEQUENCE dclrf402024_si193_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ddc202024_si153_sequencial_seq definition

--DROP SEQUENCE ddc202024_si153_sequencial_seq;

CREATE SEQUENCE ddc202024_si153_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ddc302024_si154_sequencial_seq definition

--DROP SEQUENCE ddc302024_si154_sequencial_seq;

CREATE SEQUENCE ddc302024_si154_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ddc402024_si178_sequencial_seq definition

--DROP SEQUENCE ddc402024_si178_sequencial_seq;

CREATE SEQUENCE ddc402024_si178_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa102024_si74_sequencial_seq definition

--DROP SEQUENCE dispensa102024_si74_sequencial_seq;

CREATE SEQUENCE dispensa102024_si74_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa112024_si75_sequencial_seq definition

--DROP SEQUENCE dispensa112024_si75_sequencial_seq;

CREATE SEQUENCE dispensa112024_si75_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa122024_si76_sequencial_seq definition

--DROP SEQUENCE dispensa122024_si76_sequencial_seq;

CREATE SEQUENCE dispensa122024_si76_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa132024_si77_sequencial_seq definition

--DROP SEQUENCE dispensa132024_si77_sequencial_seq;

CREATE SEQUENCE dispensa132024_si77_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa142024_si78_sequencial_seq definition

--DROP SEQUENCE dispensa142024_si78_sequencial_seq;

CREATE SEQUENCE dispensa142024_si78_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa152024_si79_sequencial_seq definition

--DROP SEQUENCE dispensa152024_si79_sequencial_seq;

CREATE SEQUENCE dispensa152024_si79_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa162024_si80_sequencial_seq definition

--DROP SEQUENCE dispensa162024_si80_sequencial_seq;

CREATE SEQUENCE dispensa162024_si80_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa172024_si81_sequencial_seq definition

--DROP SEQUENCE dispensa172024_si81_sequencial_seq;

CREATE SEQUENCE dispensa172024_si81_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dispensa182024_si82_sequencial_seq definition

--DROP SEQUENCE dispensa182024_si82_sequencial_seq;

CREATE SEQUENCE dispensa182024_si82_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp102024_si106_sequencial_seq definition

--DROP SEQUENCE emp102024_si106_sequencial_seq;

CREATE SEQUENCE emp102024_si106_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp112024_si107_sequencial_seq definition

--DROP SEQUENCE emp112024_si107_sequencial_seq;

CREATE SEQUENCE emp112024_si107_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp122024_si108_sequencial_seq definition

--DROP SEQUENCE emp122024_si108_sequencial_seq;

CREATE SEQUENCE emp122024_si108_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- emp202024_si109_sequencial_seq definition

--DROP SEQUENCE emp202024_si109_sequencial_seq;

CREATE SEQUENCE emp202024_si109_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- emp302024_si206_sequencial_seq definition

--DROP SEQUENCE emp302024_si206_sequencial_seq;

CREATE SEQUENCE emp302024_si206_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext102024_si124_sequencial_seq definition

--DROP SEQUENCE ext102024_si124_sequencial_seq;

CREATE SEQUENCE ext102024_si124_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext202024_si165_sequencial_seq definition

--DROP SEQUENCE ext202024_si165_sequencial_seq;

CREATE SEQUENCE ext202024_si165_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext302024_si126_sequencial_seq definition

--DROP SEQUENCE ext302024_si126_sequencial_seq;

CREATE SEQUENCE ext302024_si126_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext312024_si127_sequencial_seq definition

--DROP SEQUENCE ext312024_si127_sequencial_seq;

CREATE SEQUENCE ext312024_si127_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ext322024_si128_sequencial_seq definition

--DROP SEQUENCE ext322024_si128_sequencial_seq;

CREATE SEQUENCE ext322024_si128_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- hablic102024_si57_sequencial_seq definition

--DROP SEQUENCE hablic102024_si57_sequencial_seq;

CREATE SEQUENCE hablic102024_si57_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- hablic112024_si58_sequencial_seq definition

--DROP SEQUENCE hablic112024_si58_sequencial_seq;

CREATE SEQUENCE hablic112024_si58_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- hablic202024_si59_sequencial_seq definition

--DROP SEQUENCE hablic202024_si59_sequencial_seq;

CREATE SEQUENCE hablic202024_si59_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic102024_si63_sequencial_seq definition

--DROP SEQUENCE homolic102024_si63_sequencial_seq;

CREATE SEQUENCE homolic102024_si63_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic202024_si64_sequencial_seq definition

--DROP SEQUENCE homolic202024_si64_sequencial_seq;

CREATE SEQUENCE homolic202024_si64_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic302024_si65_sequencial_seq definition

--DROP SEQUENCE homolic302024_si65_sequencial_seq;

CREATE SEQUENCE homolic302024_si65_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- homolic402024_si65_sequencial_seq definition

--DROP SEQUENCE homolic402024_si65_sequencial_seq;

CREATE SEQUENCE homolic402024_si65_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ide2024_si11_sequencial_seq definition

--DROP SEQUENCE ide2024_si11_sequencial_seq;

CREATE SEQUENCE ide2024_si11_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- idedcasp2024_si200_sequencial_seq definition

--DROP SEQUENCE idedcasp2024_si200_sequencial_seq;

CREATE SEQUENCE idedcasp2024_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ideedital2024_si186_sequencial_seq definition

--DROP SEQUENCE ideedital2024_si186_sequencial_seq;

CREATE SEQUENCE ideedital2024_si186_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- iderp102024_si179_sequencial_seq definition

--DROP SEQUENCE iderp102024_si179_sequencial_seq;

CREATE SEQUENCE iderp102024_si179_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- iderp112024_si180_sequencial_seq definition

--DROP SEQUENCE iderp112024_si180_sequencial_seq;

CREATE SEQUENCE iderp112024_si180_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- iderp202024_si181_sequencial_seq definition

--DROP SEQUENCE iderp202024_si181_sequencial_seq;

CREATE SEQUENCE iderp202024_si181_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- item102024_si43_sequencial_seq definition

--DROP SEQUENCE item102024_si43_sequencial_seq;

CREATE SEQUENCE item102024_si43_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic102024_si60_sequencial_seq definition

--DROP SEQUENCE julglic102024_si60_sequencial_seq;

CREATE SEQUENCE julglic102024_si60_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic202024_si61_sequencial_seq definition

--DROP SEQUENCE julglic202024_si61_sequencial_seq;

CREATE SEQUENCE julglic202024_si61_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic302024_si62_sequencial_seq definition

--DROP SEQUENCE julglic302024_si62_sequencial_seq;

CREATE SEQUENCE julglic302024_si62_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- julglic402024_si62_sequencial_seq definition

--DROP SEQUENCE julglic402024_si62_sequencial_seq;

CREATE SEQUENCE julglic402024_si62_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao102024_si34_sequencial_seq definition

--DROP SEQUENCE lao102024_si34_sequencial_seq;

CREATE SEQUENCE lao102024_si34_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao112024_si35_sequencial_seq definition

--DROP SEQUENCE lao112024_si35_sequencial_seq;

CREATE SEQUENCE lao112024_si35_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao202024_si36_sequencial_seq definition

--DROP SEQUENCE lao202024_si36_sequencial_seq;

CREATE SEQUENCE lao202024_si36_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lao212024_si37_sequencial_seq definition

--DROP SEQUENCE lao212024_si37_sequencial_seq;

CREATE SEQUENCE lao212024_si37_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lqd102024_si118_sequencial_seq definition

--DROP SEQUENCE lqd102024_si118_sequencial_seq;

CREATE SEQUENCE lqd102024_si118_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lqd112024_si119_sequencial_seq definition

--DROP SEQUENCE lqd112024_si119_sequencial_seq;

CREATE SEQUENCE lqd112024_si119_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- lqd122024_si120_sequencial_seq definition

--DROP SEQUENCE lqd122024_si120_sequencial_seq;

CREATE SEQUENCE lqd122024_si120_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ntf102024_si143_sequencial_seq definition

--DROP SEQUENCE ntf102024_si143_sequencial_seq;

CREATE SEQUENCE ntf102024_si143_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ntf112024_si144_sequencial_seq definition

--DROP SEQUENCE ntf112024_si144_sequencial_seq;

CREATE SEQUENCE ntf112024_si144_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ntf202024_si145_sequencial_seq definition

--DROP SEQUENCE ntf202024_si145_sequencial_seq;

CREATE SEQUENCE ntf202024_si145_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- obelac102024_si139_sequencial_seq definition

--DROP SEQUENCE obelac102024_si139_sequencial_seq;

CREATE SEQUENCE obelac102024_si139_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- obelac112024_si140_sequencial_seq definition

--DROP SEQUENCE obelac112024_si140_sequencial_seq;

CREATE SEQUENCE obelac112024_si140_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops102024_si132_sequencial_seq definition

--DROP SEQUENCE ops102024_si132_sequencial_seq;

CREATE SEQUENCE ops102024_si132_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops112024_si133_sequencial_seq definition

--DROP SEQUENCE ops112024_si133_sequencial_seq;

CREATE SEQUENCE ops112024_si133_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops122024_si134_sequencial_seq definition

--DROP SEQUENCE ops122024_si134_sequencial_seq;

CREATE SEQUENCE ops122024_si134_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ops132024_si135_sequencial_seq definition

--DROP SEQUENCE ops132024_si135_sequencial_seq;

CREATE SEQUENCE ops132024_si135_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- orgao102024_si14_sequencial_seq definition

--DROP SEQUENCE orgao102024_si14_sequencial_seq;

CREATE SEQUENCE orgao102024_si14_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- orgao112024_si15_sequencial_seq definition

--DROP SEQUENCE orgao112024_si15_sequencial_seq;

CREATE SEQUENCE orgao112024_si15_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parec102024_si22_sequencial_seq definition

--DROP SEQUENCE parec102024_si22_sequencial_seq;

CREATE SEQUENCE parec102024_si22_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parec102024_si66_sequencial_seq definition

--DROP SEQUENCE parec102024_si66_sequencial_seq;

CREATE SEQUENCE parec102024_si66_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parec112024_si23_sequencial_seq definition

--DROP SEQUENCE parec112024_si23_sequencial_seq;

CREATE SEQUENCE parec112024_si23_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- parpps102024_si156_sequencial_seq definition

--DROP SEQUENCE parpps102024_si156_sequencial_seq;

CREATE SEQUENCE parpps102024_si156_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- parpps202024_si155_sequencial_seq definition

--DROP SEQUENCE parpps202024_si155_sequencial_seq;

CREATE SEQUENCE parpps202024_si155_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- pessoa102024_si12_sequencial_seq definition

--DROP SEQUENCE pessoa102024_si12_sequencial_seq;

CREATE SEQUENCE pessoa102024_si12_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- pessoaflpgo102024_si193_sequencial_seq definition

--DROP SEQUENCE pessoaflpgo102024_si193_sequencial_seq;

CREATE SEQUENCE pessoaflpgo102024_si193_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- pessoasobra102024_si194_sequencial_seq definition

--DROP SEQUENCE pessoasobra102024_si194_sequencial_seq;

CREATE SEQUENCE pessoasobra102024_si194_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rec102024_si25_sequencial_seq definition

--DROP SEQUENCE rec102024_si25_sequencial_seq;

CREATE SEQUENCE rec102024_si25_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rec112024_si26_sequencial_seq definition

--DROP SEQUENCE rec112024_si26_sequencial_seq;

CREATE SEQUENCE rec112024_si26_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao102024_si67_sequencial_seq definition

--DROP SEQUENCE regadesao102024_si67_sequencial_seq;

CREATE SEQUENCE regadesao102024_si67_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao112024_si68_sequencial_seq definition

--DROP SEQUENCE regadesao112024_si68_sequencial_seq;

CREATE SEQUENCE regadesao112024_si68_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao122024_si69_sequencial_seq definition

--DROP SEQUENCE regadesao122024_si69_sequencial_seq;

CREATE SEQUENCE regadesao122024_si69_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao132024_si70_sequencial_seq definition

--DROP SEQUENCE regadesao132024_si70_sequencial_seq;

CREATE SEQUENCE regadesao132024_si70_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao142024_si71_sequencial_seq definition

--DROP SEQUENCE regadesao142024_si71_sequencial_seq;

CREATE SEQUENCE regadesao142024_si71_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- regadesao152024_si72_sequencial_seq definition

--DROP SEQUENCE regadesao152024_si72_sequencial_seq;

CREATE SEQUENCE regadesao152024_si72_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- regadesao202024_si73_sequencial_seq definition

--DROP SEQUENCE regadesao202024_si73_sequencial_seq;

CREATE SEQUENCE regadesao202024_si73_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- reglic102024_si44_sequencial_seq definition

--DROP SEQUENCE reglic102024_si44_sequencial_seq;

CREATE SEQUENCE reglic102024_si44_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- reglic202024_si45_sequencial_seq definition

--DROP SEQUENCE reglic202024_si45_sequencial_seq;

CREATE SEQUENCE reglic202024_si45_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- resplic102024_si55_sequencial_seq definition

--DROP SEQUENCE resplic102024_si55_sequencial_seq;

CREATE SEQUENCE resplic102024_si55_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- resplic202024_si56_sequencial_seq definition

--DROP SEQUENCE resplic202024_si56_sequencial_seq;

CREATE SEQUENCE resplic202024_si56_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp102024_si112_sequencial_seq definition

--DROP SEQUENCE rsp102024_si112_sequencial_seq;

CREATE SEQUENCE rsp102024_si112_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp112024_si113_sequencial_seq definition

--DROP SEQUENCE rsp112024_si113_sequencial_seq;

CREATE SEQUENCE rsp112024_si113_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp122024_si114_sequencial_seq definition

--DROP SEQUENCE rsp122024_si114_sequencial_seq;

CREATE SEQUENCE rsp122024_si114_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp202024_si115_sequencial_seq definition

--DROP SEQUENCE rsp202024_si115_sequencial_seq;

CREATE SEQUENCE rsp202024_si115_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp212024_si116_sequencial_seq definition

--DROP SEQUENCE rsp212024_si116_sequencial_seq;

CREATE SEQUENCE rsp212024_si116_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rsp222024_si117_sequencial_seq definition

--DROP SEQUENCE rsp222024_si117_sequencial_seq;

CREATE SEQUENCE rsp222024_si117_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- tce102024_si187_sequencial_seq definition

--DROP SEQUENCE tce102024_si187_sequencial_seq;

CREATE SEQUENCE tce102024_si187_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- tce112024_si188_sequencial_seq definition

--DROP SEQUENCE tce112024_si188_sequencial_seq;

CREATE SEQUENCE tce112024_si188_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- bfdcasp102024_si206_sequencial_seq definition

--DROP SEQUENCE bfdcasp102024_si206_sequencial_seq;

CREATE SEQUENCE bfdcasp102024_si206_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bfdcasp202024_si207_sequencial_seq definition

--DROP SEQUENCE bfdcasp202024_si207_sequencial_seq;

CREATE SEQUENCE bfdcasp202024_si207_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp102024_si201_sequencial_seq definition

--DROP SEQUENCE bodcasp102024_si201_sequencial_seq;

CREATE SEQUENCE bodcasp102024_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp202024_si202_sequencial_seq definition

--DROP SEQUENCE bodcasp202024_si202_sequencial_seq;

CREATE SEQUENCE bodcasp202024_si202_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp302024_si203_sequencial_seq definition

--DROP SEQUENCE bodcasp302024_si203_sequencial_seq;

CREATE SEQUENCE bodcasp302024_si203_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp402024_si204_sequencial_seq definition

--DROP SEQUENCE bodcasp402024_si204_sequencial_seq;

CREATE SEQUENCE bodcasp402024_si204_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bodcasp502024_si205_sequencial_seq definition

--DROP SEQUENCE bodcasp502024_si205_sequencial_seq;

CREATE SEQUENCE bodcasp502024_si205_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp102024_si208_sequencial_seq definition

--DROP SEQUENCE bpdcasp102024_si208_sequencial_seq;

CREATE SEQUENCE bpdcasp102024_si208_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp202024_si209_sequencial_seq definition

--DROP SEQUENCE bpdcasp202024_si209_sequencial_seq;

CREATE SEQUENCE bpdcasp202024_si209_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp302024_si210_sequencial_seq definition

--DROP SEQUENCE bpdcasp302024_si210_sequencial_seq;

CREATE SEQUENCE bpdcasp302024_si210_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp402024_si211_sequencial_seq definition

--DROP SEQUENCE bpdcasp402024_si211_sequencial_seq;

CREATE SEQUENCE bpdcasp402024_si211_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp502024_si212_sequencial_seq definition

--DROP SEQUENCE bpdcasp502024_si212_sequencial_seq;

CREATE SEQUENCE bpdcasp502024_si212_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp602024_si213_sequencial_seq definition

--DROP SEQUENCE bpdcasp602024_si213_sequencial_seq;

CREATE SEQUENCE bpdcasp602024_si213_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp702024_si214_sequencial_seq definition

--DROP SEQUENCE bpdcasp702024_si214_sequencial_seq;

CREATE SEQUENCE bpdcasp702024_si214_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- bpdcasp712024_si215_sequencial_seq definition

--DROP SEQUENCE bpdcasp712024_si215_sequencial_seq;

CREATE SEQUENCE bpdcasp712024_si215_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp1002024_si228_sequencial_seq definition

--DROP SEQUENCE dfcdcasp1002024_si228_sequencial_seq;

CREATE SEQUENCE dfcdcasp1002024_si228_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp102024_si219_sequencial_seq definition

--DROP SEQUENCE dfcdcasp102024_si219_sequencial_seq;

CREATE SEQUENCE dfcdcasp102024_si219_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp1102024_si229_sequencial_seq definition

--DROP SEQUENCE dfcdcasp1102024_si229_sequencial_seq;

CREATE SEQUENCE dfcdcasp1102024_si229_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp202024_si220_sequencial_seq definition

--DROP SEQUENCE dfcdcasp202024_si220_sequencial_seq;

CREATE SEQUENCE dfcdcasp202024_si220_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp302024_si221_sequencial_seq definition

--DROP SEQUENCE dfcdcasp302024_si221_sequencial_seq;

CREATE SEQUENCE dfcdcasp302024_si221_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp402024_si222_sequencial_seq definition

--DROP SEQUENCE dfcdcasp402024_si222_sequencial_seq;

CREATE SEQUENCE dfcdcasp402024_si222_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp502024_si223_sequencial_seq definition

--DROP SEQUENCE dfcdcasp502024_si223_sequencial_seq;

CREATE SEQUENCE dfcdcasp502024_si223_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp602024_si224_sequencial_seq definition

--DROP SEQUENCE dfcdcasp602024_si224_sequencial_seq;

CREATE SEQUENCE dfcdcasp602024_si224_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp702024_si225_sequencial_seq definition

--DROP SEQUENCE dfcdcasp702024_si225_sequencial_seq;

CREATE SEQUENCE dfcdcasp702024_si225_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp802024_si226_sequencial_seq definition

--DROP SEQUENCE dfcdcasp802024_si226_sequencial_seq;

CREATE SEQUENCE dfcdcasp802024_si226_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dfcdcasp902024_si227_sequencial_seq definition

--DROP SEQUENCE dfcdcasp902024_si227_sequencial_seq;

CREATE SEQUENCE dfcdcasp902024_si227_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dvpdcasp102024_si216_sequencial_seq definition

--DROP SEQUENCE dvpdcasp102024_si216_sequencial_seq;

CREATE SEQUENCE dvpdcasp102024_si216_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dvpdcasp202024_si217_sequencial_seq definition

--DROP SEQUENCE dvpdcasp202024_si217_sequencial_seq;

CREATE SEQUENCE dvpdcasp202024_si217_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- dvpdcasp302024_si218_sequencial_seq definition

--DROP SEQUENCE dvpdcasp302024_si218_sequencial_seq;

CREATE SEQUENCE dvpdcasp302024_si218_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rpsd102024_si189_sequencial_seq definition

--DROP SEQUENCE rpsd102024_si189_sequencial_seq;

CREATE SEQUENCE rpsd102024_si189_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- rpsd112024_si190_sequencial_seq definition

--DROP SEQUENCE rpsd112024_si190_sequencial_seq;

CREATE SEQUENCE rpsd112024_si190_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

-- ralic102024_si180_sequencial_seq definition

--DROP SEQUENCE ralic102024_si180_sequencial_seq;

CREATE SEQUENCE ralic102024_si180_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ralic112024_si181_sequencial_seq definition

--DROP SEQUENCE ralic112024_si181_sequencial_seq;

CREATE SEQUENCE ralic112024_si181_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- ralic122024_si182_sequencial_seq definition

--DROP SEQUENCE ralic122024_si182_sequencial_seq;

CREATE SEQUENCE ralic122024_si182_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- redispi102024_si183_sequencial_seq definition

--DROP SEQUENCE redispi102024_si183_sequencial_seq;

CREATE SEQUENCE redispi102024_si183_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- redispi112024_si184_sequencial_seq definition

--DROP SEQUENCE redispi112024_si184_sequencial_seq;

CREATE SEQUENCE redispi112024_si184_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- redispi122024_si185_sequencial_seq definition

--DROP SEQUENCE redispi122024_si185_sequencial_seq;

CREATE SEQUENCE redispi122024_si185_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- afast102024 definition

--DROP SEQUENCE cadobras102024_si198_sequencial_seq;

CREATE SEQUENCE cadobras102024_si198_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cadobras202024_si199_sequencial_seq definition

--DROP SEQUENCE cadobras202024_si199_sequencial_seq;

CREATE SEQUENCE cadobras202024_si199_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cadobras212024_si200_sequencial_seq definition

--DROP SEQUENCE cadobras212024_si200_sequencial_seq;

CREATE SEQUENCE cadobras212024_si200_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- cadobras302024_si201_sequencial_seq definition

--DROP SEQUENCE cadobras302024_si201_sequencial_seq;

CREATE SEQUENCE cadobras302024_si201_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- exeobras102024_si197_sequencial_seq definition

--DROP SEQUENCE exeobras102024_si197_sequencial_seq;

CREATE SEQUENCE exeobras102024_si197_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- licobras102024_si195_sequencial_seq definition

--DROP SEQUENCE licobras102024_si195_sequencial_seq;

CREATE SEQUENCE licobras102024_si195_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;


-- licobras202024_si196_sequencial_seq definition

--DROP SEQUENCE licobras202024_si196_sequencial_seq;

CREATE SEQUENCE licobras202024_si196_sequencial_seq
    INCREMENT BY 1
    MINVALUE 1
    MAXVALUE 9223372036854775807;

COMMIT;
SQL;
        $this->execute($sql);
    }
}
