<?php

use Phinx\Migration\AbstractMigration;

class AddNaturezasRubricas extends AbstractMigration
{
    protected $arrNatureza = array(       
'1089' => 'Cesta básica ou refeição, não vinculada ao PAT ',
'1022' => 'Férias - Abono ou gratificação de férias não excedente a 20 dias',
'1216' => 'Adicional de localidade',
'1351' => 'Bolsa de estudo - Médico residente',
'1404' => 'Auxílio babá',
'1405' => 'Assistência médica',
'1207' => 'Comissões, porcentagens, produção',
'1208' => 'Gueltas ou gorjetas - Repassadas por fornecedores ou clientes',
'1209' => 'Gueltas ou gorjetas - Repassadas pelo empregador',
'1210' => 'Gratificação por acordo ou convenção coletiva',
'1217' => 'Gratificação de curso/concurso',
'1225' => 'Quebra de caixa',
'1230' => 'Remuneração do dirigente sindical',
'1300' => 'PLR - Participação em Lucros ou Resultados',
'1352' => 'Bolsa de estudo ou pesquisa',
'1401' => 'Abono',
'1406' => 'Auxílio-creche',
'1006' => 'Intervalos intra e inter jornadas não concedidos',
'1007' => 'Luvas e premiações',
'1009' => 'Salário-família - Complemento',
'1010' => 'Salário in natura - Pagos em bens ou serviços',
'1011' => 'Sobreaviso e prontidão',
'1021' => 'Férias - Abono ou gratificação de férias superior a 20 dias',
'1214' => 'Adicional de penosidade',
'1005' => 'Direito de arena',
'1080' => 'Stock option',
'1412' => 'Abono permanência',
'1601' => 'Ajuda de custo - Aeronauta',
'1603' => 'Ajuda de custo',
'1604' => 'Ajuda de custo - Acima de 50% da remuneração mensal',
'1619' => 'Ajuda compensatória - Lei 14.020/2020',
'1800' => 'Alimentação concedida em pecúnia',
'1802' => 'Etapas (marítimos)',
'1806' => 'Alimentação em ticket ou cartão, vinculada ao PAT',
'1807' => 'Alimentação em ticket ou cartão, não vinculada ao PAT',
'1809' => 'Cesta básica ou refeição, não vinculada ao PAT',
'1899' => 'Outros auxílios',
'2501' => 'Prêmios',
'2502' => 'Liberalidades concedidas em mais de duas parcelas anuais',
'2510' => 'Direitos autorais e intelectuais',
'2801' => 'Quarentena remunerada',
'2901' => 'Empréstimos',
'2902' => 'Vestuário e equipamentos',
'2999' => 'Arredondamentos',
'3505' => 'Retiradas (pró-labore) de diretores empregados',
'3508' => 'Retiradas (pró-labore) de proprietários ou sócios',
'3509' => 'Honorários a conselheiros',
'1411' => 'Auxílio-natalidade',
'1650' => 'Diárias de viagem',
'1808' => 'Cesta básica ou refeição, vinculada ao PAT',
'3510' => 'Gratificação (jeton)',
'3511' => 'Gratificação eleitoral',
'3520' => 'Remuneração de cooperado',
'3525' => 'Côngruas, prebendas e afins',
'4010' => 'Complementação salarial de auxílio-doença',
'4011' => 'Complemento de salário-mínimo - RPPS',
'5501' => 'Adiantamento de salário',
'5510' => 'Adiantamento de benefícios previdenciários',
'6105' => 'Indenização recebida a título de incentivo a demissão',
'6107' => 'Indenização por quebra de estabilidade',
'6119' => 'Indenização rescisória - Lei 14.020/2020',
'9243' => 'Cesta básica ou refeição, vinculada ao PAT - Desconto',
'6103' => 'Indenização do art. 14 da Lei 5.889/1973',
'7003' => 'Proventos - Reserva',
'7004' => 'Proventos - Reforma',
'7005' => 'Pensão Militar',
'7006' => 'Auxílio-reclusão',
'7007' => 'Pensões especiais',
'7008' => 'Complementação de aposentadoria/ pensão',
'9202' => 'Contribuição militar',
'9207' => 'Faltas',
'9208' => 'Atrasos',
'9211' => 'DSR sobre faltas',
'9212' => 'DSR sobre atrasos',
'9220' => 'Alimentação - Desconto',
'9224' => 'FAPI - Parte do empregado',
'9226' => 'Desconto de férias - Abono',
'9233' => 'Contribuição sindical - Confederativa',
'9240' => 'Alimentação concedida em pecúnia - Desconto',
'9241' => 'Alimentação em ticket ou cartão, vinculada ao PAT - Desconto',
'9242' => 'Alimentação em ticket ou cartão, não vinculada ao PAT - Desconto',
'9244' => 'Cesta básica ou refeição, não vinculada ao PAT - Desconto',
'9255' => 'Empréstimos do empregador - Desconto',
'9260' => 'FIES - Desconto',
'9291' => 'Abate-teto',
'9292' => 'Ressarcimento ao erário',
'9293' => 'Honorários advocatícios',
'9294' => 'Redutor EC 41/03',
'9909' => 'Base de cálculo da contribuição previdenciária - Aposentados e Pensionistas',
'9905' => 'Serviço militar',
'9906' => 'Remuneração no exterior',
'9907' => 'Total da contribuição da previdenciária patronal - RPPS',
'9910' => 'Seguros',
'9911' => 'Assistência Médica',
'9950' => 'Horas extraordinárias - Banco de horas',
'9951' => 'Horas compensadas - Banco de horas'
);

    public function up()
    {
        $sql = "";
        foreach ($this->arrNatureza as $codNatureza => $descNatureza) {
            if($this->checkNatureza($codNatureza)) {
                $sql .= "INSERT INTO rubricasesocial values ('{$codNatureza}','{$descNatureza}');";
            }
        }
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        DELETE FROM rubricasesocial WHERE e990_sequencial = '1089';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1022';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1216';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1351';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1404';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1405';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1207';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1208';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1209';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1210';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1217';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1225';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1230';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1300';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1352';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1401';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1406';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1006';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1007';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1009';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1010';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1011';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1021';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1214';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1005';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1080';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1412';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1601';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1603';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1604';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1619';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1800';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1802';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1806';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1807';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1809';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1899';
DELETE FROM rubricasesocial WHERE e990_sequencial = '2501';
DELETE FROM rubricasesocial WHERE e990_sequencial = '2502';
DELETE FROM rubricasesocial WHERE e990_sequencial = '2510';
DELETE FROM rubricasesocial WHERE e990_sequencial = '2801';
DELETE FROM rubricasesocial WHERE e990_sequencial = '2901';
DELETE FROM rubricasesocial WHERE e990_sequencial = '2902';
DELETE FROM rubricasesocial WHERE e990_sequencial = '2999';
DELETE FROM rubricasesocial WHERE e990_sequencial = '3505';
DELETE FROM rubricasesocial WHERE e990_sequencial = '3508';
DELETE FROM rubricasesocial WHERE e990_sequencial = '3509';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1411';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1650';
DELETE FROM rubricasesocial WHERE e990_sequencial = '1808';
DELETE FROM rubricasesocial WHERE e990_sequencial = '3510';
DELETE FROM rubricasesocial WHERE e990_sequencial = '3511';
DELETE FROM rubricasesocial WHERE e990_sequencial = '3520';
DELETE FROM rubricasesocial WHERE e990_sequencial = '3525';
DELETE FROM rubricasesocial WHERE e990_sequencial = '4010';
DELETE FROM rubricasesocial WHERE e990_sequencial = '4011';
DELETE FROM rubricasesocial WHERE e990_sequencial = '5501';
DELETE FROM rubricasesocial WHERE e990_sequencial = '5510';
DELETE FROM rubricasesocial WHERE e990_sequencial = '6105';
DELETE FROM rubricasesocial WHERE e990_sequencial = '6107';
DELETE FROM rubricasesocial WHERE e990_sequencial = '6119';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9243';
DELETE FROM rubricasesocial WHERE e990_sequencial = '6103';
DELETE FROM rubricasesocial WHERE e990_sequencial = '7003';
DELETE FROM rubricasesocial WHERE e990_sequencial = '7004';
DELETE FROM rubricasesocial WHERE e990_sequencial = '7005';
DELETE FROM rubricasesocial WHERE e990_sequencial = '7006';
DELETE FROM rubricasesocial WHERE e990_sequencial = '7007';
DELETE FROM rubricasesocial WHERE e990_sequencial = '7008';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9202';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9207';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9208';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9211';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9212';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9220';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9224';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9226';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9233';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9240';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9241';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9242';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9244';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9255';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9260';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9291';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9292';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9293';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9294';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9909';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9905';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9906';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9907';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9910';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9911';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9950';
DELETE FROM rubricasesocial WHERE e990_sequencial = '9951';
        ";
        $this->execute($sql);
    }

    private function checkNatureza($cod)
    {
        $result = $this->fetchRow("SELECT * FROM rubricasesocial WHERE e990_sequencial = '{$cod}'");
        if (empty($result)) {
            return true;
        }
        return false; 
    }
}
