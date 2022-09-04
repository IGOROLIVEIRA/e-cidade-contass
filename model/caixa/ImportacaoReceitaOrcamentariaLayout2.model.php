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

class ImportacaoReceitaOrcamentariaLayout2
{
    private $oReceita;

    public function __construct($sLinha)
    {
        $this->oReceita = new stdClass();
        $this->preencherLinha($sLinha);
    }

    public function preencherLinha($sLinha)
    {
        if (!$this->eReceita($sLinha))
            return;

        $this->oReceita->iCodBanco        = substr($sLinha, 0, 3);
        $this->oReceita->sDescricaoBanco  = ""; // Buscar de Agentes Arrecadadores
        $this->oReceita->iContaBancaria   = 0; // Buscar de Agentes Arrecadadores
        $this->oReceita->sCodAgencia      = substr($sLinha, 3, 4);
        $this->oReceita->dDataCredito     = $this->montarData(substr($sLinha, 7, 8));
        $this->oReceita->nValor           = $this->montarValor(substr($sLinha, 21, 13));
        $this->oReceita->sCodReceita      = substr(str_replace(".", "", substr(trim($sLinha), 35, -3)), 0, 14);
        $this->preencherReceita();
        $this->preencherAgenteArrecadador();
    }

    /**
     * Verifica se a linha é desse tipo de Receita
     *
     * @return bool
     */
    public function eReceita($sLinha)
    {
        if (in_array(substr($sLinha, 35, 1), array("1", "7", "9")))
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

    public function recuperarLinha()
    {
        return $this->oReceita;
    }

    public function preencherReceita()
    {
        $cltabrec = new cl_tabrec;
        $sqlTabrec = $cltabrec->sql_query_inst("", "*", "k02_estorc", " k02_estorc like '4{$this->oReceita->sCodReceita}%' ");
        $rsTabrec = $cltabrec->sql_record($sqlTabrec);

        if ($cltabrec->numrows == 0) {
            throw new BusinessException("Não encontrado receita para conta contábil {$this->oReceita->sCodReceita}");
        }

        while ($oTabRec = pg_fetch_object($rsTabrec)) {
            $this->oReceita->iReceita = $oTabRec->k02_codigo;
            $this->oReceita->iRecurso = $oTabRec->o70_codigo;
        }
    }

    /**
     * Função para formatar a data confida no txt
     *
     * @param [string] $sData
     * @return date
     */
    public function montarData($sData)
    {
        $sDia = substr($sData, 0, 2);
        $sMes = substr($sData, 2, 2);
        $sAno = substr($sData, 4, 4);
        return date("Y-m-d", strtotime("{$sDia}-{$sMes}-{$sAno}"));
    }

    /**
     * Função para formatar os valores contidos no txt
     *
     * @param [string] $sValor
     * @return float
     */
    public function montarValor($sValor)
    {
        return (float) ((int) substr($sValor, 0, 11)) . "." . substr($sValor, 11, 2);
    }
}
