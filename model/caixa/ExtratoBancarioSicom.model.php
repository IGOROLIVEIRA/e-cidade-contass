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

/**
 * Model controle do Extrato Bancário do SICOM
 * @author widouglas
 * @package caixa
 */
class ExtratoBancarioSicom {
    private $ano;
    private $instituicao;
    private $contasHabilitadas = array();

    public function __construct($ano, $instituicao) 
    {
        $this->ano = $ano;
        $this->instituicao = $instituicao;
        $this->setContasHabilitadas();
    }

    public function setContasHabilitadas()
    {
        $sql = "
            SELECT DISTINCT
                z01_cgccpf cnpj,
                saltes.k13_reduz reduzido,
                saltes.k13_descr descricao,
                c63_banco banco,
                c63_agencia agencia,
                c63_dvagencia digito_agencia,
                c63_conta conta,
                c63_dvconta digito_conta,
                CASE
                    WHEN contabancaria.db83_tipoconta = 1 THEN 'Corrente'
                    WHEN contabancaria.db83_tipoconta = 2 THEN 'Poupança'
                    WHEN contabancaria.db83_tipoconta = 3 THEN 'Aplicação'
                    WHEN contabancaria.db83_tipoconta = 4 THEN 'Salário'
                END as tipo,
                CASE
                    WHEN k13_limite IS NULL THEN 'SIM'
                    ELSE 'NAO'
                END ativa
            FROM saltes
            INNER JOIN conplanoreduz ON conplanoreduz.c61_reduz = saltes.k13_reduz
                AND c61_anousu = {$this->ano}
            INNER JOIN db_config ON codigo = conplanoreduz.c61_instit
            INNER JOIN cgm ON z01_numcgm = db_config.numcgm
            INNER JOIN conplanoexe ON conplanoexe.c62_reduz = conplanoreduz.c61_reduz
                AND c61_anousu = c62_anousu
            INNER JOIN conplano ON conplanoreduz.c61_codcon = conplano.c60_codcon
                AND c61_anousu = c60_anousu
            LEFT JOIN conplanoconta ON conplanoconta.c63_codcon = conplanoreduz.c61_codcon
                AND conplanoconta.c63_anousu = conplanoreduz.c61_anousu
            LEFT JOIN conplanocontabancaria ON c60_codcon = c56_codcon
                AND c60_anousu = {$this->ano}
            LEFT JOIN contabancaria ON c56_contabancaria = db83_sequencial
        WHERE
            c61_instit = {$this->instituicao}
            AND c62_anousu = {$this->ano}
            AND (k13_limite IS NULL OR k13_limite BETWEEN '{$this->ano}-01-01'
                AND '{$this->ano}-12-31') ";
        $result = db_query($sql);

        while ($data = pg_fetch_object($result)) {
            $data->situacao = $this->setSituacao($data);
            $this->contasHabilitadas[$data->reduzido] = $data;
        }
    }

    public function getContasHabilitadas()
    {
        sort($this->contasHabilitadas);
        return $this->contasHabilitadas;
    }

    public function setSituacao($conta)
    {
        $diretorio = "extratobancariosicom/{$conta->cnpj}/{$this->ano}/{$conta->reduzido}.pdf";
    
        if (file_exists($diretorio)) {
            return 'enviado';
        }
    
        return 'pendente';
    }
}
?>