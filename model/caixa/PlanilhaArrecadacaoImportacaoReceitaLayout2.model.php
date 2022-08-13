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

class PlanilhaArrecadacaoImportacaoReceitaLayout2
{
    private $oLinha;

    public function __construct($sLinha)
    {
        $this->preencherLinha($sLinha);
    }

    public function preencherLinha($sLinha)
    {
        $oReceita = new stdClass();
        $oReceita->iCodBanco        = substr($sLinha, 0, 3);
        $oReceita->sDescricaoBanco  = ""; // Buscar de Agentes Arrecadadores
        $oReceita->iContaBancaria   = 0; // Buscar de Agentes Arrecadadores
        $oReceita->sCodAgencia      = substr($sLinha, 3, 4);
        $oReceita->dDataCredito     = $this->montarData(substr($sLinha, 7, 8));
        $oReceita->nValor           = $this->montarValor(substr($sLinha, 21, 13));
        $oReceita->sCodContabil     = $this->montarCodigoContabil(str_replace(".", "", substr($sLinha, 35, 17)));
        $oDadosReceita              = $this->buscarReceita($oReceita->sCodContabil);
        $oReceita->iRecurso         = $oDadosReceita->iRecurso;
        $oReceita->iReceita         = $oDadosReceita->iReceita;
        $this->oLinha = $oReceita;
    }

    public function recuperarLinha()
    {
        return $this->oLinha;
    }

    public function buscarReceita($sCodContabil)
    {
        $oDadosReceita = new stdClass();
        $oDadosReceita->iReceita = 0;
        $oDadosReceita->iRecurso = 0;

        $cltabrec = new cl_tabrec;
        $sqlTabrec = $cltabrec->sql_query_inst("", "*", "k02_estorc", " k02_estorc like '{$sCodContabil}%' ");
        $rsTabrec = $cltabrec->sql_record($sqlTabrec);

        if ($cltabrec->numrows == 0) {
            throw new Exception("Não encontrado receita para conta contábil {$sCodContabil} ");
        }

        while ($oTabRec = pg_fetch_object($rsTabrec)) {
            $oDadosReceita->iReceita = $oTabRec->k02_codigo;
            $oDadosReceita->iRecurso = $oTabRec->recurso;
            montarDebug("Código da Receita: {$oTabRec->k02_codigo} Fonte de Recurso: {$oTabRec->recurso}");
        }

        return $oDadosReceita;
    }

    public function montarDebug($oDebug)
    {
        if (DEBUG) {
            var_dump($oDebug);
            echo "<br><hr/>";
        }
        return;
    }

    public function montarCodigoContabil($sCodContabil)
    {
        if (in_array(substr($sCodContabil, 0, 1), array(1, 7, 9)))
            return "4{$sCodContabil}";
        return $sCodContabil;
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
