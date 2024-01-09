<?php
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
/**
 * Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Obras
 */

class gerarLICOBRAS extends GerarAM
{
    /**
     *
     * Mes de refer�ncia
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "LICOBRAS";
        $this->abreArquivo();

        $sSql = "select * from licobras102024 where si195_mes = " . $this->iMes . " and si195_instit=" . db_getsession("DB_instit");
        $rslicobras102024 = db_query($sSql);

        $sSql = "select * from licobras202024 where si196_mes = " . $this->iMes . " and si196_instit=" . db_getsession("DB_instit");
        $rslicobras202024 = db_query($sSql);

        $sSql = "select * from licobras302024 where si203_mes = " . $this->iMes . " and si203_instit=" . db_getsession("DB_instit");
        $rslicobras302024 = db_query($sSql);

        if (pg_num_rows($rslicobras102024) == 0) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();
        } else {

            /**
             *
             * Registros 10
             */
            for ($iCont = 0; $iCont < pg_num_rows($rslicobras102024); $iCont++) {

                $alICOBRAS10 = pg_fetch_array($rslicobras102024, $iCont);

                $aCSVLICOBRAS10['si195_tiporegistro'] = str_pad($alICOBRAS10['si195_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVLICOBRAS10['si195_codorgaoresp'] = str_pad($alICOBRAS10['si195_codorgaoresp'], 3, "0", STR_PAD_LEFT);
                $aCSVLICOBRAS10['si195_codunidadesubrespestadual'] = str_pad($alICOBRAS10['si195_codunidadesubrespestadual'], 4, "0", STR_PAD_LEFT);
                $aCSVLICOBRAS10['si195_exerciciolicitacao'] = $alICOBRAS10['si195_exerciciolicitacao'];
                $aCSVLICOBRAS10['si195_nroprocessolicitatorio'] = $alICOBRAS10['si195_nroprocessolicitatorio'];
                $aCSVLICOBRAS10['si195_nrolote'] = $alICOBRAS10['si195_nrolote'];
                $aCSVLICOBRAS10['si195_contdeclicitacao'] = $alICOBRAS10['si195_contdeclicitacao'];
                $aCSVLICOBRAS10['si195_codobra'] = $alICOBRAS10['si195_codobra'];
                $aCSVLICOBRAS10['si195_objeto'] = $alICOBRAS10['si195_objeto'];
                $aCSVLICOBRAS10['si195_linkobra'] = $alICOBRAS10['si195_linkobra'];
                $aCSVLICOBRAS10['si195_codorgaorespsicom'] = $alICOBRAS10['si195_codorgaorespsicom'];
                $aCSVLICOBRAS10['si195_codunidadesubsicom'] = $alICOBRAS10['si195_codunidadesubsicom'];
                $aCSVLICOBRAS10['si195_nrocontrato'] = $alICOBRAS10['si195_nrocontrato'];
                $aCSVLICOBRAS10['si195_exerciciocontrato'] = $alICOBRAS10['si195_exerciciocontrato'];
                $aCSVLICOBRAS10['si195_dataassinatura'] = $this->sicomDate($alICOBRAS10['si195_dataassinatura']);
                $aCSVLICOBRAS10['si195_vlcontrato'] = $alICOBRAS10['si195_vlcontrato'];
                $aCSVLICOBRAS10['si195_numdocumentocontratado'] = $alICOBRAS10['si195_numdocumentocontratado'];
                $aCSVLICOBRAS10['si195_undmedidaprazoexecucao'] = $alICOBRAS10['si195_undmedidaprazoexecucao'];
                $aCSVLICOBRAS10['si195_prazoexecucao'] = $alICOBRAS10['si195_prazoexecucao'];
                $this->sLinha = $aCSVLICOBRAS10;
                $this->adicionaLinha();
            }
        }

        if (pg_num_rows($rslicobras202024) == 0) {

            //      $aCSV['tiporegistro'] = '99';
            //      $this->sLinha = $aCSV;
            //      $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 20
             */
            for ($iCont = 0; $iCont < pg_num_rows($rslicobras202024); $iCont++) {

                $aLICOBRAS20 = pg_fetch_array($rslicobras202024, $iCont);

                $aCSVLICOBRAS20['si196_tiporegistro'] = str_pad($aLICOBRAS20['si196_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVLICOBRAS20['si196_codorgaoresp'] = str_pad($aLICOBRAS20['si196_codorgaoresp'], 3, "0", STR_PAD_LEFT);
                $aCSVLICOBRAS20['si196_codunidadesubrespestadual'] = str_pad($aLICOBRAS20['si196_codunidadesubrespestadual'], 4, "0", STR_PAD_LEFT);
                $aCSVLICOBRAS20['si196_exerciciolicitacao'] = $aLICOBRAS20['si196_exerciciolicitacao'];
                $aCSVLICOBRAS20['si196_nroprocessolicitatorio'] = $aLICOBRAS20['si196_nroprocessolicitatorio'];
                $aCSVLICOBRAS20['si196_tipoprocesso'] = $aLICOBRAS20['si196_tipoprocesso'];
                $aCSVLICOBRAS20['si196_contdeclicitacao'] = $aLICOBRAS20['si196_contdeclicitacao'];
                $aCSVLICOBRAS20['si196_codobra'] = $aLICOBRAS20['si196_codobra'];
                $aCSVLICOBRAS20['si196_objeto'] = $aLICOBRAS20['si196_objeto'];
                $aCSVLICOBRAS20['si196_linkobra'] = $aLICOBRAS20['si196_linkobra'];
                $aCSVLICOBRAS20['si196_codorgaorespsicom'] = $aLICOBRAS20['si196_codorgaorespsicom'];
                $aCSVLICOBRAS20['si196_codunidadesubsicom'] = $aLICOBRAS20['si196_codunidadesubsicom'];
                $aCSVLICOBRAS20['si196_nrocontrato'] = $aLICOBRAS20['si196_nrocontrato'];
                $aCSVLICOBRAS20['si196_exerciciocontrato'] = $aLICOBRAS20['si196_exerciciocontrato'];
                $aCSVLICOBRAS20['si196_dataassinatura'] = $aLICOBRAS20['si196_dataassinatura'];
                $aCSVLICOBRAS20['si196_vlcontrato'] = $aLICOBRAS20['si196_vlcontrato'];
                $aCSVLICOBRAS20['si196_undmedidaprazoexecucao'] = $aLICOBRAS20['si196_undmedidaprazoexecucao'];
                $aCSVLICOBRAS20['si196_prazoexecucao'] = $aLICOBRAS20['si196_prazoexecucao'];
                $this->sLinha = $aCSVLICOBRAS20;
                $this->adicionaLinha();
            }
        }

        if (pg_num_rows($rslicobras302024) == 0) {

            //      $aCSV['tiporegistro'] = '99';
            //      $this->sLinha = $aCSV;
            //      $this->adicionaLinha();

        } else {

            /**
             *
             * Registros 30
             */
            for ($iCont = 0; $iCont < pg_num_rows($rslicobras302024); $iCont++) {

                $aLICOBRAS30 = pg_fetch_array($rslicobras302024, $iCont);

                $aCSVLICOBRAS30['si203_tiporegistro'] = str_pad($aLICOBRAS30['si203_tiporegistro'], 2, "0", STR_PAD_LEFT);
                $aCSVLICOBRAS30['si203_codorgaoresp'] = str_pad($aLICOBRAS30['si203_codorgaoresp'], 3, "0", STR_PAD_LEFT);
                $aCSVLICOBRAS30['si203_codobra'] = $aLICOBRAS30['si203_codobra'];
                $aCSVLICOBRAS30['si203_codunidadesubrespestadual'] = str_pad($aLICOBRAS30['si203_codunidadesubrespestadual'], 4, "0", STR_PAD_LEFT);
                $aCSVLICOBRAS30['si203_nroseqtermoaditivo'] = $aLICOBRAS30['si203_nroseqtermoaditivo'];
                $aCSVLICOBRAS30['si203_dataassinaturatermoaditivo'] = $this->sicomDate($aLICOBRAS30['si203_dataassinaturatermoaditivo']);
                $aCSVLICOBRAS30['si203_tipoalteracaovalor'] = $aLICOBRAS30['si203_tipoalteracaovalor'];
                $aCSVLICOBRAS30['si203_tipotermoaditivo'] = $aLICOBRAS30['si203_tipotermoaditivo'];
                $aCSVLICOBRAS30['si203_dscalteracao'] = $aLICOBRAS30['si203_dscalteracao'];
                $aCSVLICOBRAS30['si203_novadatatermino'] = $this->sicomDate($aLICOBRAS30['si203_novadatatermino']);
                $aCSVLICOBRAS30['si203_tipodetalhamento'] = $aLICOBRAS30['si203_tipodetalhamento'];
                $aCSVLICOBRAS30['si203_valoraditivo'] = $aLICOBRAS30['si203_valoraditivo'];
                $this->sLinha = $aCSVLICOBRAS30;
                $this->adicionaLinha();
            }
        }

        $this->fechaArquivo();
    }
}
