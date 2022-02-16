<?php

use Phinx\Migration\AbstractMigration;

class Oc16737Titulo extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            begin;
                update conplano	set c60_descr = 'BANCOS CONTA MOVIMENTO ? FUNDO EM REPARTIÇÃO' where c60_estrut = '111110602000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'BANCOS CONTA MOVIMENTO ? FUNDO EM CAPITALIZAÇÃO' where c60_estrut = '111110603000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'EMPRÉSTIMOS A RECEBER - RPPS - FUNDO EM CAPITALIZAÇÃO' where c60_estrut = '112410701000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FINANCIAMENTOS A RECEBER - RPPS - FUNDO EM CAPITALIZAÇÃO' where c60_estrut = '112410702000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'JUROS E ENCARGOS SOBRE EMPRÉSTIMOS A RECEBER ? RPPS - FUNDO EM CAPITALIZAÇÃO' where c60_estrut = '112410703000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'JUROS E ENCARGOS SOBRE FINANCIAMENTOS A RECEBER ? RPPS - FUNDO EM CAPITALIZAÇÃO' where c60_estrut = '112410704000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'DEPÓSITOS RESTITUÍVEIS E VALORES VINCULADOS - A RECEBER' where c60_estrut = '113500000000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'EMPRÉSTIMOS A RECEBER - RPPS - PLANO EM CAPITALIZAÇÃO' where c60_estrut = '121140305000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'JUROS E ENCARGOS SOBRE EMPRÉSTIMOS A RECEBER ? RPPS - PLANO EM CAPITALIZAÇÃO' where c60_estrut = '121140306000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FINANCIAMENTOS A RECEBER - RPPS - PLANO EM CAPITALIZAÇÃO' where c60_estrut = '121140307000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'JUROS E ENCARGOS SOBRE FINANCIAMENTOS A RECEBER ? RPPS - PLANO EM CAPITALIZAÇÃO' where c60_estrut = '121140308000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'TITULOS E VALORES MOBILIÁRIOS - RPPS - PLANO EM CAPITALIZAÇÃO' where c60_estrut = '122310100000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'APLICAÇÕES EM SEGMENTO DE IMÓVEIS - RPPS - PLANO EM CAPITALIZAÇÃO' where c60_estrut = '122310200000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) REDUÇÃO AO VALOR RECUPERÁVEL DE INVESTIMENTOS DO RPPS - FUNDO EM CAPITALIZAÇÃO' where c60_estrut = '122910300000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'RESSARCIMENTOS E RESTITUIÇÕES' where c60_estrut = '218810105000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FUNDO EM REPARTIÇÃO - PROVISÕES DE BENEFÍCIOS CONCEDIDOS   ' where c60_estrut = '227210100000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'APOSENTADORIAS/PENSÕES/OUTROS BENEFÍCIOS CONCEDIDOS FUNDO EM REPARTIÇÃO DO RPPS' where c60_estrut = '227210101000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO ENTE PARA O FUNDO EM REPARTIÇÃO DO RPPS' where c60_estrut = '227210102000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO APOSENTADO PARA O FUNDO EM REPARTIÇÃO DO RPPS' where c60_estrut = '227210103000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO PENSIONISTA PARA O FUNDO EM REPARTIÇÃO DO RPPS' where c60_estrut = '227210104000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) COMPENSAÇÃO PREVIDENCIÁRIA DO FUNDO EM REPARTIÇÃO DO RPPS' where c60_estrut = '227210105000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FUNDO EM REPARTIÇÃO - PROVISOES DE BENEFICIOS A CONCEDER' where c60_estrut = '227210200000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'APOSENTADORIAS/PENSÕES/OUTROS BENEFÍCIOS A CONCEDER FUNDO EM REPARTIÇÃO DO RPPS' where c60_estrut = '227210201000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO ENTE PARA O FUNDO EM REPARTIÇÃO DO RPPS' where c60_estrut = '227210202000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO ATIVO PARA O FUNDO EM REPARTIÇÃO DO RPPS' where c60_estrut = '227210203000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) COMPENSAÇÃO PREVIDENCIÁRIA DO FUNDO EM REPARTIÇÃO DO RPPS' where c60_estrut = '227210204000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FUNDO DE CAPITALIZAÇÃO - PROVISOES DE BENEFICIOS CONCEDIDOS' where c60_estrut = '227210300000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'APOSENTADORIAS/PENSÕES/OUTROS BENEFÍCIOS CONCEDIDOS DO FUNDO DE CAPITALIZAÇÃO DO RPPS' where c60_estrut = '227210301000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO ENTE PARA O FUNDO DE CAPITALIZAÇÃO DO RPPS' where c60_estrut = '227210302000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO APOSENTADO PARA O FUNDO DE CAPITALIZAÇÃO DO RPPS' where c60_estrut = '227210303000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO PENSIONISTA PARA O FUNDO DE CAPITALIZAÇÃO DO RPPS' where c60_estrut = '227210304000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) COMPENSAÇÃO PREVIDENCIÁRIA DO FUNDO DE CAPITALIZAÇÃO DO RPPS' where c60_estrut = '227210305000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FUNDO EM CAPITALIZAÇÃO - PROVISOES DE BENEFICIOS A CONCEDER' where c60_estrut = '227210400000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'APOSENTADORIAS/PENSÕES/OUTROS BENEFÍCIOS A CONCEDER DO FUNDO EM CAPITALIZAÇÃO DO RPPS' where c60_estrut = '227210401000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO ENTE PARA O FUNDO EM CAPITALIZAÇÃO DO RPPS' where c60_estrut = '227210402000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) CONTRIBUIÇÕES DO ATIVO PARA O FUNDO EM CAPITALIZAÇÃO DO RPPS' where c60_estrut = '227210403000000' and c60_anousu > 2021;
                update conplano	set c60_descr = '(-) COMPENSAÇÃO PREVIDENCIÁRIA DO FUNDO EM CAPITALIZAÇÃO DO RPPS' where c60_estrut = '227210404000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FUNDO EM CAPITALIZAÇÃO - PLANO DE AMORTIZACAO' where c60_estrut = '227210500000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'PROVISÕES ATUARIAIS PARA AJUSTES DO FUNDO EM REPARTIÇÃO' where c60_estrut = '227210600000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'PROVISÕES ATUARIAIS PARA AJUSTES DO FUNDO EM CAPITALIZAÇÃO' where c60_estrut = '227210700000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'OBRIGAÇÕES DECORRENTES DE CONTRATOS DE PPP- CONSOLIDAÇÃO - LONGO PRAZO' where c60_estrut = '228610000000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'OBRIGAÇÕES DECORRENTES DE   ATIVOS CONSTRUÍDOS PELA SPE - LONGO PRAZO' where c60_estrut = '228610100000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'RESSARCIMENTOS E RESTITUIÇÕES' where c60_estrut = '228810105000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'TRANSFERÊNCIAS CONCEDIDAS DE BENS IMÓVEIS' where c60_estrut = '351220202000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'TRANSFERÊNCIAS CONCEDIDAS DE BENS MÓVEIS ' where c60_estrut = '351220204000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FUNDO EM REPARTIÇÃO ' where c60_estrut = '351320100000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FUNDO EM CAPITALIZAÇÃO' where c60_estrut = '351320200000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'TRANSFERÊNCIAS RECEBIDAS DE BENS IMÓVEIS' where c60_estrut = '451220202000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'TRANSFERÊNCIAS RECEBIDAS DE BENS MÓVEIS ' where c60_estrut = '451220204000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FUNDO EM REPARTIÇÃO' where c60_estrut = '451320100000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'FUNDO EM CAPITALIZAÇÃO' where c60_estrut = '451320200000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'OUTRAS GARANTIAS CONCEDIDAS NO EXTERIOR EXECUTADAS' where c60_estrut = '812120221000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'EXECUÇÃO DE GARANTIAS CONCEDIDAS NO EXTERIOR' where c60_estrut = '812130200000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'OUTRAS GARANTIAS CONCEDIDAS NO EXTERIOR EXECUTADAS' where c60_estrut = '812130221000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'EXECUÇÃO DE GARANTIAS CONCEDIDAS NO EXTERIOR' where c60_estrut = '812140200000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'OUTRAS GARANTIAS CONCEDIDAS NO EXTERIOR EXECUTADAS' where c60_estrut = '812140221000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'EXECUÇÃO DE GARANTIAS CONCEDIDAS NO EXTERIOR' where c60_estrut = '812150200000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'OUTRAS GARANTIAS CONCEDIDAS NO EXTERIOR EXECUTADAS' where c60_estrut = '812150221000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'UTILIZADA COM EXECUÇÃO ORÇAMENTÁRIA' where c60_estrut = '821140100000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'OUTROS TRIBUTOS FEDERAIS' where c60_estrut = '228830106000000' and c60_anousu > 2021;
                update conplano	set c60_descr = 'OUTROS TRIBUTOS FEDERAIS' where c60_estrut = '218830106000000' and c60_anousu > 2021;
            commit;
SQL;
        $this->execute($sql);
    }
}
