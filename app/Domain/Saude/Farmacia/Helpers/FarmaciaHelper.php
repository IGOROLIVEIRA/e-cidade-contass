<?php

namespace App\Domain\Saude\Farmacia\Helpers;

use Exception;

class FarmaciaHelper
{
    /**
     * Valida se o p�rametro "Utilizar integra��o BNAFAR" do m�dulo f�rmacia est� habilitado
     * @return boolean
     */
    public static function utilizaIntegracaoBnafar()
    {
        $dao = new \cl_far_parametros;
        $sql = $dao->sql_query_file('', 'fa02_utiliza_bnafar');
        $rs = $dao->sql_record($sql);
        if ($rs) {
            return \db_utils::fieldsMemory($rs, 0)->fa02_utiliza_bnafar == 't';
        }

        return false;
    }

    /**
     * Valida se
     * @param $idMaterial
     * @return bool
     */
    public static function isMaterialFarmacia($idMaterial)
    {
        $dao = new \cl_far_matersaude();
        $sql = $dao->sql_query_file(null, '1', null, "fa01_i_codmater = {$idMaterial}");
        $rs = $dao->sql_record($sql);

        return !!$rs;
    }

    /**
     * @param integer $idDepartamento
     * @return bool
     */
    public static function isUnidadeSaude($idDepartamento)
    {
        $dao = new \cl_unidades();
        $sql = $dao->sql_query_file($idDepartamento);
        $rs = $dao->sql_record($sql);

        return !!$rs;
    }

    /**
     * Valida se o material possui os campos necess�rio para a integra��o com o BNAFAR
     * @param mixed $item
     * @param mixed $nota
     * @throws Exception
     * @return void
     */
    public static function validaItemEntradaOrdemCompra($item, $nota, $dataNota)
    {
        if ($item->checked != " checked ") {
            return;
        }

        /**
         * Valida as informa��es da nota antes de chamar a fun��o de uso comun, devido forma que a rotina funciona
         * A fun��o validaMaterial � executada tamb�m no momento que � feita altera��es no material, a qual n�o �
         * enviado informa��es da nota.
         */
        if (empty($nota)) {
            throw new Exception("Por favor, ajuste o N. da Nota Fiscal do produto{$item->m60_descr}.");
        }
        if (empty($dataNota)) {
            throw new Exception("Por favor, ajuste a data da Nota do produto{$item->m60_descr}.");
        }

        static::validaMaterial($item, true);
    }

    /**
     * Valida se o material possui os campos necess�rio para a integra��o com o BNAFAR
     * @param object $material
     * @param bool $ordemCompra
     * @param bool $verificaIntegracao
     * @return bool
     * @throws Exception
     */
    public static function validaMaterial($material, $ordemCompra = false, $verificaIntegracao = true)
    {
        if ($verificaIntegracao && !static::utilizaIntegracaoBnafar()) {
            return false;
        }
        if ($verificaIntegracao && !static::isMaterialFarmacia($material->m63_codmatmater)) {
            return false;
        }

        $descricao = property_exists($material, 'm60_descr') ? ": {$material->m60_descr}" : '';

        if (empty($material->m78_matfabricante)) {
            throw new Exception("Por favor, ajuste o fabricante do produto{$descricao}.");
        }
        if (empty($material->m77_lote)) {
            throw new Exception("Por favor, ajuste o Lote do produto{$descricao}.");
        }
        if (empty($material->m77_dtvalidade)) {
            throw new Exception("Por favor, ajuste a Validade do produto{$descricao}.");
        }
        if (!$ordemCompra && empty($material->m79_notafiscal)) {
            throw new Exception("Por favor, ajuste o N. da Nota Fiscal do produto{$descricao}.");
        }
        if (!$ordemCompra && empty($material->m79_data)) {
            throw new Exception("Por favor, ajuste a data da Nota do produto{$descricao}.");
        }

        return true;
    }

    /**
     * Valida se foram informados os campos necess�rios para envio das informa��es para o BNAFAR
     * @param $dados
     * @param $idMaterial
     * @param false $saida
     * @return bool
     * @throws Exception
     */
    public static function validaMovimentacaoMaterial($dados, $idMaterial, $saida = false)
    {
        if (!static::utilizaIntegracaoBnafar()) {
            return false;
        }
        if (!static::isMaterialFarmacia($idMaterial)) {
            return false;
        }

        if (empty($dados->tipoMovimentacao)) {
            throw new Exception("Informe o Tipo de movimenta��o.");
        }
        if (!$saida) {
            static::validaMaterial($dados, false, false);
        }
        if (empty($dados->cgm) && empty($dados->unidade)) {
            $tipo = [];
            if (in_array($dados->tipoMovimentacao, ['3', '4', '5', '6', '7', '8', '10', '11', '12', '14'])) {
                $tipo[] = 'Unidade';
            }
            if (in_array($dados->tipoMovimentacao, ['1', '2', '4', '5', '6', '9', '13', '14', '15'])) {
                $tipo[] = 'CGM';
            }

            $tipo = implode(' e/ou ', $tipo);
            $tipo .= $saida ? ' destino' : ' origem';
            throw new Exception("Informe {$tipo} do produto.");
        }
        if (!empty($dados->cgm) && !empty($dados->unidade)) {
            $tipo = $saida ? ' destino' : ' origem';
            throw new Exception("Informe somente unidade {$tipo} OU cgm {$tipo}.");
        }

        return true;
    }
}
