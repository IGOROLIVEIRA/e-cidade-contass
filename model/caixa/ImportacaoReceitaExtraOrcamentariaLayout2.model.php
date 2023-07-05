<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("model/caixa/ImportacaoReceitaLayout2.php");

class ImportacaoReceitaExtraOrcamentariaLayout2 extends ImportacaoReceitaLayout2
{       
    public function preencherLinha($sLinha)
    {
        if (!$this->eReceitaExtraOrcamentaria($sLinha))
            return;

        $this->oReceita->iCodBanco        = substr($sLinha, 0, 3);
        $this->oReceita->sDescricaoBanco  = ""; // Buscar de Agentes Arrecadadores
        $this->oReceita->iContaBancaria   = 0; // Buscar de Agentes Arrecadadores
        $this->oReceita->sCodAgencia      = substr($sLinha, 3, 4);
        $this->oReceita->dDataCredito     = $this->montarData(substr($sLinha, 7, 8));
        $this->oReceita->nValor           = $this->montarValor(substr($sLinha, 21, 13));
        // Mudança necessária para utilização das fontes de recursos em 2023
        $iDigitosRecursos                 = (strlen($sLinha) < 69) ? -3 : -8;
        $this->oReceita->sPcasp           = $this->montarPcasp(str_replace(".", "", substr(trim($sLinha), 35, $iDigitosRecursos)));
        $this->oReceita->iRecurso         = substr(trim($sLinha), $iDigitosRecursos);
        $this->preencherContaCredito();
        $this->preencherAgenteArrecadador();
        $this->preencherIdentificadorReceita();
    }

    /**
     * Função responsável por montar o pcasp da extra-orçamentária
     *
     * @param string $pcasp
     * @return string
     */
    public function montarPcasp($pcasp)
    {
        if (substr($pcasp, 0, 3) === "922")
            return substr($pcasp, 2);
        return $pcasp;
    }

    /**
     * Gera identificador para agrupamento de slip e correção de saldo negativo
     *
     * @return void
     */
    public function preencherIdentificadorReceita()
    {
        $this->oReceita->iIdentificadorReceita = $this->oReceita->iCodBanco . 
            $this->oReceita->iNumeroCgm .
            $this->oReceita->iContaCredito . 
            $this->oReceita->iRecurso;
    }

    public function preencherContaCredito()
    {
        $clconplanoreduz = new cl_conplanoreduz;
        $sqlConPlanoReduz = $clconplanoreduz->sql_query_analitica("", "", "c61_reduz", " c61_reduz LIMIT 1 ",
            " c60_estrut like '{$this->oReceita->sPcasp}%' AND c61_anousu = " . db_getsession("DB_anousu") . " AND c61_instit = " . db_getsession("DB_instit"));

        $rsConPlanoReduz = $clconplanoreduz->sql_record($sqlConPlanoReduz);

        if ($clconplanoreduz->numrows == 0) {
            throw new BusinessException("Não encontrado reduzido para conta contábil {$this->oReceita->sPcasp}");
        }

        while ($oConPlanoReduz = pg_fetch_object($rsConPlanoReduz)) {
            $this->oReceita->iContaCredito = $oConPlanoReduz->c61_reduz;
        }
    }

    /**
     * Verifica se a linha é receita
     *
     * @return bool
     */
    public function eReceitaExtraOrcamentaria($sLinha)
    {
        if (in_array(substr($sLinha, 35, 1), array("2")) || in_array(substr($sLinha, 35, 3), array("922")))
            return true;
        return false;
    }

    /**
     * Verifica os cadastros de agente arrecadadores vinculados para busca da conta bancária
     *
     * @return void
     */
    public function preencherAgenteArrecadador()
    {
        $clagentearrecadador = new cl_agentearrecadador();
        $sqlAgenteArrecadador = $clagentearrecadador->sql_query("", 
            "agentearrecadador.k174_idcontabancaria, agentearrecadador.k174_numcgm", 
            "agentearrecadador.k174_idcontabancaria", 
            "agentearrecadador.k174_codigobanco = {$this->oReceita->iCodBanco} AND agentearrecadador.k174_instit = " . db_getsession('DB_instit'));
        $rsAgenteArrecadador = $clagentearrecadador->sql_record($sqlAgenteArrecadador);

        if ($clagentearrecadador->numrows == 0) {
            throw new Exception("Não encontrado agente arrecadador para o código do banco {$this->oReceita->iCodBanco} ");
        }

        while ($oAgenteArrecadador = pg_fetch_object($rsAgenteArrecadador)) {
            $oContaTesouraria = new contaTesouraria($oAgenteArrecadador->k174_idcontabancaria);
            $oContaTesouraria->validaContaPorDataMovimento(date('Y-m-d', db_getsession('DB_datausu')));
            $this->oReceita->oContaTesouraria = $oContaTesouraria;
            $this->oReceita->iNumeroCgm = $oAgenteArrecadador->k174_numcgm;
        }
    }
}
