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
                si09_codorgaotce orgao,
                c61_codtce as codtce,
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
                    WHEN contabancaria.db83_tipoconta = 2 THEN 'Poupanca'
                    WHEN contabancaria.db83_tipoconta = 3 THEN 'Aplicacao'
                    WHEN contabancaria.db83_tipoconta = 4 THEN 'Salario'
                END as tipo,
                k13_limite limite
            FROM saltes
            JOIN conplanoreduz ON k13_reduz = c61_reduz
                AND c61_anousu = {$this->ano}
            JOIN conplanoconta ON c63_codcon = c61_codcon
                AND c63_anousu = c61_anousu
            JOIN conplano ON c60_codcon = c61_codcon
                AND c60_anousu = c61_anousu
            JOIN orctiporec ON c61_codigo = o15_codigo
            LEFT JOIN conplanocontabancaria ON c56_codcon = c61_codcon
                AND c56_anousu = c61_anousu
            LEFT JOIN contabancaria ON c56_contabancaria = db83_sequencial
            LEFT JOIN convconvenios ON db83_numconvenio = c206_sequencial
            LEFT JOIN infocomplementaresinstit ON si09_instit = c61_instit
            INNER JOIN db_config ON codigo = conplanoreduz.c61_instit
            INNER JOIN cgm ON z01_numcgm = db_config.numcgm
        WHERE
            c61_instit = {$this->instituicao}
            AND c61_anousu = {$this->ano}
            AND (k13_limite IS NULL OR k13_limite BETWEEN '{$this->ano}-01-01'
                AND '{$this->ano}-12-31') 
        ORDER BY c63_banco, c63_agencia, c63_conta, tipo";

        $result = db_query($sql);

        while ($data = pg_fetch_object($result)) {
            $data = $this->tratarConta($data);
            $chave = $this->buscarChave($data);
            if (array_key_exists($chave, $this->contasHabilitadas)) {
                $this->contasHabilitadas[$chave]->contas[] = $data->reduzido;
            } else {
                $this->contasHabilitadas[$chave] = $data;
            }
        }
    }

    public function buscarChave($conta) {
        $chave  = $conta->orgao;
        $chave .= intval($conta->banco);
        $chave .= intval($conta->agencia);
        $chave .= intval($conta->digito_agencia);
        $chave .= intval($conta->conta);
        $chave .= intval($conta->digito_conta);
        $chave .= $conta->tipo;
        return $chave;
    }

    public function tratarConta($conta) {
        $conta->orgao = str_pad($conta->orgao, 2, "0", STR_PAD_LEFT);
        $conta->codtce = $conta->codtce ? $conta->codtce : $conta->reduzido;
        $conta->situacao = $this->setSituacao($conta);
        $conta->limite = $conta->limite ? date("d/m/Y", strtotime($conta->limite)) : "";
        return $conta;
    }

    public function getContasHabilitadas()
    {
        // sort($this->contasHabilitadas);
        return $this->contasHabilitadas;
    }

    public function setSituacao($conta)
    {
        $diretorio = "extratobancariosicom/{$conta->cnpj}/{$this->ano}/CTB_{$conta->orgao}_{$conta->codtce}.pdf";
    
        if (file_exists($diretorio)) {
            return 'enviado';
        }
    
        return 'pendente';
    }
}
?>