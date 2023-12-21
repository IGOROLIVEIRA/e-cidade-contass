<?php
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");
/**
 * Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Obras
 */

class gerarEXEOBRAS extends GerarAM
{
    /**
     *
     * Mes de refer�ncia
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "EXEOBRAS";
        $this->abreArquivo();

        $sSql = "select distinct * from exeobras102024 where si197_mes = " . $this->iMes . " and si197_instit=" . db_getsession("DB_instit") . " order by si197_nroprocessolicitatorio";
        $rsexeobras102024 = db_query($sSql);

        $sSql = "select * from exeobras202024 where si204_mes = " . $this->iMes . " and si204_instit=" . db_getsession("DB_instit");
        $rsexeobras202024 = db_query($sSql);

        $seqnumlotes = array();
        $linhas = array();
        $sequencial = 1;
        $nroprocesso = 0;

        if (pg_num_rows($rsexeobras102024) == 0 && pg_num_rows($rsexeobras202024) == 0) {

            $aCSV['tiporegistro'] = '99';
            $this->sLinha = $aCSV;
            $this->adicionaLinha();
        } else {

            /**
             *
             * Registros 10
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsexeobras102024); $iCont++) {

                $aEXEOBRAS10 = pg_fetch_array($rsexeobras102024, $iCont);

                $aCSVEXEOBRAS10['si197_tiporegistro'] = $aEXEOBRAS10['si197_tiporegistro'];
                $aCSVEXEOBRAS10['si197_codorgao'] = str_pad($aEXEOBRAS10['si197_codorgao'], 3, "0", STR_PAD_LEFT);
                $aCSVEXEOBRAS10['si197_codunidadesub'] = substr($aEXEOBRAS10['si197_codunidadesub'], 0, 8);
                $aCSVEXEOBRAS10['si197_nrocontrato'] = $aEXEOBRAS10['si197_nrocontrato'];
                $aCSVEXEOBRAS10['si197_exerciciocontrato'] = $aEXEOBRAS10['si197_exerciciocontrato'];
                $aCSVEXEOBRAS10['si197_contdeclicitacao'] = $aEXEOBRAS10['si197_contdeclicitacao'];
                $aCSVEXEOBRAS10['si197_exerciciolicitacao'] = $aEXEOBRAS10['si197_exerciciolicitacao'];
                $aCSVEXEOBRAS10['si197_nroprocessolicitatorio'] = $aEXEOBRAS10['si197_nroprocessolicitatorio'];
                $aCSVEXEOBRAS10['si197_codunidadesubresp'] = str_pad($aEXEOBRAS10['si197_codunidadesubresp'], 5, "0", STR_PAD_LEFT);

                /*
* Trecho do c�digo respons�vel por gerar sequenciais para o n�mero do lote
* de acordo a l04_descricao e n�mero do lote.
*/

                $nrolote = $aEXEOBRAS10['si197_nrolote'];
                $sql = "select liclicitemlote.* from liclicitem
join liclicita on l20_codigo=l21_codliclicita
join liclicitemlote on l04_liclicitem=l21_codigo
where l04_codigo=$nrolote order by l04_descricao;";
                $rslotedescricao = db_query($sql);
                $rslotedescricao = pg_fetch_array($rslotedescricao, 0);


                $l04_descricao = $rslotedescricao['l04_descricao'];

                if ($aCSVEXEOBRAS10['si197_nroprocessolicitatorio'] != $nroprocesso) {
                    $nroprocesso = $aCSVEXEOBRAS10['si197_nroprocessolicitatorio'];
                    $seqnumlotes = array();
                    $sequencial = 1;
                }


                if (in_array($l04_descricao, $seqnumlotes)) {
                    $seq = array_search($l04_descricao, $seqnumlotes);
                    $aCSVEXEOBRAS10['si197_nrolote'] = $seq;
                } else {
                    $seqnumlotes[$sequencial] = $l04_descricao;
                    $aCSVEXEOBRAS10['si197_nrolote'] = $sequencial;
                    $sequencial++;
                }

                $aCSVEXEOBRAS10['si197_codobra'] = $aEXEOBRAS10['si197_codobra'];
                $aCSVEXEOBRAS10['si197_objeto'] = $aEXEOBRAS10['si197_objeto'];
                $aCSVEXEOBRAS10['si197_linkobra'] = $aEXEOBRAS10['si197_linkobra'];
                $inserir = true;

                $processolicitatorio = $aCSVEXEOBRAS10['si197_nroprocessolicitatorio'];

                $l20_tipojulg = db_query("select l20_tipojulg from liclicita where l20_edital = $processolicitatorio and l20_anousu = 2024");
                $l20_tipojulg = pg_fetch_array($l20_tipojulg, 0);

                if ($l20_tipojulg['l20_tipojulg'] != 3) {
                    $aCSVEXEOBRAS10['si197_nrolote'] = "";
                } else if ($l20_tipojulg['l20_tipojulg'] == 3) {
                    $l20_codigo = db_query("select l20_codigo from liclicita where l20_edital = $processolicitatorio and l20_anousu = " . db_getsession("DB_anousu"));
                    $l20_codigo = pg_fetch_array($l20_codigo, 0);
                    $l20_codigo = $l20_codigo['l20_codigo'];
                    $lotes = db_query("select distinct l04_descricao from liclicitemlote where l04_liclicitem in (select l21_codigo from liclicitem where l21_codliclicita = $l20_codigo)");

                    if (pg_num_rows($lotes) == 1) {
                        $aCSVEXEOBRAS10['si197_nrolote'] = "";
                    }
                }

                /*
                * Trecho do c�digo respons�vel por verificar se o registro
                * ap�s atribui��o do sequencial ao n�mero do lote j� existe na planilha.
                */

                if (count($linhas) > 0) {

                    for ($i = 0; $i < count($linhas); $i++) {
                        if (
                            $linhas[$i]['si197_tiporegistro'] == $aCSVEXEOBRAS10['si197_tiporegistro'] &&
                            $linhas[$i]['si197_codorgao'] == $aCSVEXEOBRAS10['si197_codorgao'] &&
                            $linhas[$i]['si197_codunidadesub'] == $aCSVEXEOBRAS10['si197_codunidadesub'] &&
                            $linhas[$i]['si197_nrocontrato'] == $aCSVEXEOBRAS10['si197_nrocontrato'] &&
                            $linhas[$i]['si197_exerciciocontrato'] == $aCSVEXEOBRAS10['si197_exerciciocontrato'] &&
                            $linhas[$i]['si197_contdeclicitacao'] == $aCSVEXEOBRAS10['si197_contdeclicitacao'] &&
                            $linhas[$i]['si197_exerciciolicitacao'] == $aCSVEXEOBRAS10['si197_exerciciolicitacao'] &&
                            $linhas[$i]['si197_nroprocessolicitatorio'] == $aCSVEXEOBRAS10['si197_nroprocessolicitatorio'] &&
                            $linhas[$i]['si197_codunidadesubresp'] == $aCSVEXEOBRAS10['si197_codunidadesubresp'] &&
                            $linhas[$i]['si197_nrolote'] == $aCSVEXEOBRAS10['si197_nrolote'] &&
                            $linhas[$i]['si197_codobra'] == $aCSVEXEOBRAS10['si197_codobra'] &&
                            $linhas[$i]['si197_objeto'] == $aCSVEXEOBRAS10['si197_objeto'] &&
                            $linhas[$i]['si197_linkobra'] == $aCSVEXEOBRAS10['si197_linkobra']

                        ) {
                            $inserir = false;
                            break;
                        }
                    }

                    if ($inserir == true) {
                        $linhas[count($linhas)] = $aCSVEXEOBRAS10;
                        $this->sLinha = $aCSVEXEOBRAS10;
                        $this->adicionaLinha();
                    }
                } else {
                    $linhas[$iCont] = $aCSVEXEOBRAS10;

                    $this->sLinha = $aCSVEXEOBRAS10;
                    $this->adicionaLinha();
                }
            }

            /**
             *
             * Registros 20
             */
            for ($iCont = 0; $iCont < pg_num_rows($rsexeobras202024); $iCont++) {

                $aEXEOBRAS20 = pg_fetch_array($rsexeobras202024, $iCont);

                $aCSVEXEOBRAS20['si204_tiporegistro'] = $aEXEOBRAS20['si204_tiporegistro'];
                $aCSVEXEOBRAS20['si204_codorgao'] = str_pad($aEXEOBRAS20['si204_codorgao'], 3, "0", STR_PAD_LEFT);
                $aCSVEXEOBRAS20['si204_codunidadesub'] = substr($aEXEOBRAS20['si204_codunidadesub'], 0, 8);
                $aCSVEXEOBRAS20['si204_nrocontrato'] = $aEXEOBRAS20['si204_nrocontrato'];
                $aCSVEXEOBRAS20['si204_exerciciocontrato'] = $aEXEOBRAS20['si204_exerciciocontrato'];
                $aCSVEXEOBRAS20['si204_contdeclicitacao'] = $aEXEOBRAS20['si204_contdeclicitacao'];
                $aCSVEXEOBRAS20['si204_exercicioprocesso'] = $aEXEOBRAS20['si204_exercicioprocesso'];
                $aCSVEXEOBRAS20['si204_nroprocesso'] = $aEXEOBRAS20['si204_nroprocesso'];
                $aCSVEXEOBRAS20['si204_codunidadesubresp'] = str_pad($aEXEOBRAS20['si204_codunidadesubresp'], 5, "0", STR_PAD_LEFT);
                $aCSVEXEOBRAS20['si204_tipoprocesso'] = $aEXEOBRAS20['si204_tipoprocesso'];
                $aCSVEXEOBRAS20['si204_codobra'] = $aEXEOBRAS20['si204_codobra'];
                $aCSVEXEOBRAS20['si204_objeto'] = $aEXEOBRAS20['si204_objeto'];
                $aCSVEXEOBRAS20['si204_linkobra'] = $aEXEOBRAS20['si204_linkobra'];
                $this->sLinha = $aCSVEXEOBRAS20;
                $this->adicionaLinha();
            }
        }

        $this->fechaArquivo();
    }
}
