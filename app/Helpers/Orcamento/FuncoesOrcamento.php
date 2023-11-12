<?php

use ECidade\Financeiro\Contabilidade\PlanoDeContas\Estrutural;
use ECidade\Financeiro\Contabilidade\PlanoDeContas\EstruturalReceita;
use ECidade\Financeiro\Orcamento\Repository\ElementoRepository;
use ECidade\Financeiro\Orcamento\Repository\FonteReceitaRepository;
use ECidade\V3\Extension\Registry;
use Illuminate\Support\Facades\DB;

/**
 * Retorna um split do estrutural at� o n�vel dele
 * A fun��o identifica e o estrutural � de despesa, receita ou do balancete de verifica��o
 *
 * @exemple
 * Estrutural: 411130310000000 retorno 41113031
 * Estrutural: 411130311050300 retorno 4111303110503
 *
 */
if (!function_exists('estruturalAteNivel')) {
    function estruturalAteNivel($natureza)
    {
        $estrutural = new EstruturalReceita($natureza);
        if ((strpos($natureza, '3') === 0) || (strpos($natureza, '1') === 0)) {
            $estrutural = new Estrutural($natureza);
        }

        return $estrutural->getEstruturalAteNivel();
    }
}

/**
 * retorna todos os estruturais anal�ticos da receita.
 */
if (!function_exists('receitasAnaliticas')) {
    function receitasAnaliticas($exercicio, $operador = '=')
    {
        if (Registry::has('estruturaisReceita')) {
            return Registry::get('estruturaisReceita');
        }

        $estruturaisReceita = [];
        $repository = new FonteReceitaRepository();
        $fontes = $repository->scopeAno($exercicio, $operador)
            ->scopeApenasFonteAnalitica()
            ->get();

        foreach ($fontes as $fonte) {
            $estruturaisReceita[] = $fonte->getFonte();
        }

        Registry::set('estruturaisReceita', $estruturaisReceita);

        return Registry::get('estruturaisReceita');
    }
}

if (!function_exists('elementosDespesa')) {
    function elementosDespesa($exercicio)
    {
        if (Registry::has('elementosDespesa')) {
            return Registry::get('elementosDespesa');
        }

        $elementos = [];
        $repository = new ElementoRepository();
        $fontes = $repository->scopeAno($exercicio)->get();

        foreach ($fontes as $fonte) {
            $elementos[] = $fonte->getElemento();
        }

        Registry::set('elementosDespesa', $elementos);
        return Registry::get('elementosDespesa');
    }
}


if (!function_exists('todosElementosDespesa')) {
    function todosElementosDespesa()
    {
        if (Registry::has('todosElementosDespesa')) {
            return Registry::get('todosElementosDespesa');
        }

        $elementos = [];
        $repository = new ElementoRepository();
        $fontes = $repository->scopeHasVinculoContabilidade()->get(['distinct o56_elemento']);

        foreach ($fontes as $fonte) {
            $elementos[] = $fonte->getElemento();
        }


        Registry::set('todosElementosDespesa', $elementos);
        return Registry::get('todosElementosDespesa');
    }
}


if (!function_exists('contasBalanceteVerificacao')) {
    function contasBalanceteVerificacao($exercicio, $operador = ' = ')
    {
        if (Registry::has('contasBalanceteVerificacao')) {
            return Registry::get('contasBalanceteVerificacao');
        }

        $sql = "
        SELECT distinct p.c60_estrut AS estrutural
          FROM conplanoexe e
          INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
                AND r.c61_reduz = c62_reduz
          INNER JOIN conplano p ON r.c61_codcon = c60_codcon
                AND r.c61_anousu = c60_anousu
          LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
        WHERE c62_anousu {$operador} {$exercicio}
        order by 1
        ";

        $rs = db_query($sql);
        $contas = db_utils::makeCollectionFromRecord($rs, function ($dado) {
            return $dado->estrutural;
        });

        Registry::set('contasBalanceteVerificacao', $contas);

        return Registry::get('contasBalanceteVerificacao');
    }
}

if (!function_exists('getDesdobramentosReceita')) {
    /**
     * retorna os desdobramentos das fontes de recurso
     * @param $fonte
     * @param $exercicio
     * @return array
     */
    function getDesdobramentosReceita($fonte, $exercicio)
    {
        return DB::select("
            select o60_codfon as codigo_fonte,
                   o57_fonte as fonte,
                   o60_perc as percentual,
                   exists(
                   select 1
                    from contabilidade.conplanoorcamentoanalitica
                    join orcamento.orctiporec on o15_codigo = c61_codigo
                   where c61_codcon = o60_codfon
                     and c61_anousu = o60_anousu
                     and o15_tipo = 1
                  ) as livre,
                   o70_concarpeculiar as cp
              from orcfontes
              join orcfontesdes on o60_anousu = o57_anousu and o60_codfon = o57_codfon
              join orcamento.orcreceita on (o70_codfon, o70_anousu) = (o57_codfon, o57_anousu)
            where o57_anousu = {$exercicio} and o57_fonte like '{$fonte}%'
            order by o57_fonte;
        ");
    }
}

/**
 * Em v�rios relat�rios realizava o mesmo procedimento, ai criei essa fun��o que retorna a string com o nome
 * completo do recurso....
 *
 */
if (!function_exists('descricaoCompletaRecurso')) {
    /**
     * O Retorno vai depender do tipo informavado:
     * tipo = 1: gest�o - descr recurso - cod complemento - descr complemento
     * tipo = 2: gest�o - cod complemento - descr recurso
     * tipo = 3: gest�o - cod complemento
     *
     * @param int $codigoRecurso
     * @param int $exercicio
     * @param int $tipo
     * @return string
     */
    function descricaoCompletaRecurso($codigoRecurso, $exercicio, $tipo = 1)
    {
        $fonteRecurso = \App\Domain\Financeiro\Orcamento\Models\FonteRecurso::with('recurso')
            ->where('exercicio', $exercicio)
            ->where('orctiporec_id', $codigoRecurso)
            ->first();

        switch ($tipo) {
            case 1:
            default:
                return sprintf(
                    '%s - %s | %s - %s',
                    $fonteRecurso->gestao,
                    $fonteRecurso->descricao,
                    str_pad($fonteRecurso->recurso->o15_complemento, 4, '0', STR_PAD_LEFT),
                    $fonteRecurso->recurso->complemento->o200_descricao
                );
            case 2:
                return sprintf(
                    '%s - %s - %s',
                    $fonteRecurso->gestao,
                    str_pad($fonteRecurso->recurso->o15_complemento, 4, '0', STR_PAD_LEFT),
                    $fonteRecurso->descricao
                );
            case 3:
                return sprintf(
                    '%s - %s',
                    $fonteRecurso->gestao,
                    str_pad($fonteRecurso->recurso->o15_complemento, 4, '0', STR_PAD_LEFT)
                );
        }
    }
}
