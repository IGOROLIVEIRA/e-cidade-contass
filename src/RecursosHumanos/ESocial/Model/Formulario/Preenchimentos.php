<?php

namespace ECidade\RecursosHumanos\ESocial\Model\Formulario;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\DadosResposta;

/**
 * Classe respons�vel por buscar os dados de preenchimento dos formul�rios
 * @package ECidade\RecursosHumanos\ESocial\Model\Formulario
 */
class Preenchimentos
{
    /**
     * Respons�vel pelo preenchimento do formul�rio
     *
     * @var mixed
     */
    private $responsavelPreenchimento;

    /**
     * Informa o respons�vel pelo preenchimento. Se n�o indormado, busca de todos
     *
     * @param mixed $responsavel
     */
    public function setReponsavelPeloPreenchimento($responsavel)
    {
        $this->responsavelPreenchimento = $responsavel;
    }

    /**
     * Busca os preenchimentos dos empregadores
     *
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimentoEmpregador($codigoFormulario)
    {
        $where = array(" db101_sequencial = {$codigoFormulario} ");
        if (!empty($this->responsavelPreenchimento)) {
            $where[] = "eso03_cgm = {$this->responsavelPreenchimento}";
        }

        $where = implode(' and ', $where);

        $group = " group by eso03_cgm";
        $campos = 'eso03_cgm as cgm, max(db107_sequencial) as preenchimento, ';
        $campos .= '(select z01_cgccpf from cgm where z01_numcgm = eso03_cgm) as inscricao_empregador ';
        $dao = new \cl_avaliacaogruporespostacgm;
        $sql = $dao->sql_avaliacao_preenchida(null, $campos, null, $where . $group);
        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul�rios dos empregadores.");
        }

        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * Busca os preenchimentos dos servidores
     *
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimentoServidor($codigoFormulario)
    {
        $where = " db101_sequencial = {$codigoFormulario} ";
        $group = " group by eso02_rhpessoal";
        $campos = 'eso02_rhpessoal as matricula, max(db107_sequencial) as preenchimento';
        $dao = new \cl_avaliacaogruporespostarhpessoal;
        $sql = $dao->sql_avaliacao_preenchida(null, $campos, null, $where . $group);
        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul�rios dos servidores.");
        }

        /**
         * Para pegar o empregador, vai ter que ver a lota��o do servidor na compet�ncia.
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * Busca o preenchimento dos formul�rios gen�ricos.
     * Aqueles que possuem uma carga de dados e um campo pk (Uma chave �nica )
     *
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimento($codigoFormulario)
    {
        $where = " db101_sequencial = {$codigoFormulario} ";
        $campos = 'distinct db107_sequencial as preenchimento, ';
        $campos .= '(select db106_resposta';
        $campos .= '   from avaliacaoresposta as ar ';
        $campos .= '   join avaliacaogrupoperguntaresposta as preenchimento on preenchimento.db108_avaliacaoresposta = ar.db106_sequencial ';
        $campos .= '   join avaliacaoperguntaopcao as apo on apo.db104_sequencial = ar.db106_avaliacaoperguntaopcao ';
        $campos .= '   join avaliacaopergunta as ap on ap.db103_sequencial = apo.db104_avaliacaopergunta ';
        $campos .= '  where ap.db103_perguntaidentificadora is true ';
        $campos .= '    and preenchimento.db108_avaliacaogruporesposta = db107_sequencial ';
        $campos .= ') as pk ';
        $dao = new \cl_avaliacaogruporesposta;
        $sql = $dao->sql_avaliacao_preenchida(null, $campos, null, $where);

        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul�rios.");
        }

        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimentoInstituicao($codigoFormulario)
    {
        $where  = " db101_sequencial = {$codigoFormulario} ";
        $where .= " AND COALESCE((SELECT db106_resposta::integer
                FROM avaliacaogrupoperguntaresposta
                JOIN avaliacaoresposta ON avaliacaogrupoperguntaresposta.db108_avaliacaoresposta=avaliacaoresposta.db106_sequencial
                JOIN avaliacaoperguntaopcao ON avaliacaoperguntaopcao.db104_sequencial = avaliacaoresposta.db106_avaliacaoperguntaopcao
                WHERE db108_avaliacaogruporesposta=db107_sequencial and db104_identificadorcampo = 'instituicao'),0) IN (" . db_getsession("DB_instit") . ",0)";
        $campos = 'distinct db107_sequencial as preenchimento, ';
        $campos .= '(select db106_resposta';
        $campos .= '   from avaliacaoresposta as ar ';
        $campos .= '   join avaliacaogrupoperguntaresposta as preenchimento on preenchimento.db108_avaliacaoresposta = ar.db106_sequencial ';
        $campos .= '   join avaliacaoperguntaopcao as apo on apo.db104_sequencial = ar.db106_avaliacaoperguntaopcao ';
        $campos .= '   join avaliacaopergunta as ap on ap.db103_sequencial = apo.db104_avaliacaopergunta ';
        $campos .= '  where ap.db103_perguntaidentificadora is true ';
        $campos .= '    and preenchimento.db108_avaliacaogruporesposta = db107_sequencial ';
        $campos .= "    and db103_identificadorcampo != 'instituicao' ";
        $campos .= "    order by db106_resposta desc limit 1 ";
        $campos .= ') as pk ';
        $dao = new \cl_avaliacaogruporesposta;
        $sql = $dao->sql_avaliacao_preenchida(null, $campos, "preenchimento desc", $where);

        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul�rios das rubricas.");
        }

        $rubricas = \db_utils::getCollectionByRecord($rs);

        /**
         * @todo busca os empregadores da institui��o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * Busca os preenchimentos Lotacao
     *
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimentoLotacao($codigoFormulario)
    {
        $where = " db101_sequencial = {$codigoFormulario} ";
        $group = "";
        $campos = "(select z01_numcgm from cgm where z01_numcgm = $this->responsavelPreenchimento) as cgm, max(db107_sequencial) as preenchimento, ";
        $campos .= "(select z01_cgccpf from cgm where z01_numcgm = $this->responsavelPreenchimento) as inscricao_empregador ";
        $dao = new \cl_avaliacaogruporespostalotacao;
        $sql = $dao->buscaAvaliacaoPreenchida(null, $campos, null, $where . $group);
        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul�rios dos empregadores.");
        }

        return \db_utils::getCollectionByRecord($rs);
    }


    /**
     * Buscas as respostas de um preenchimento
     *
     * @param integer $preenchimentoId
     * @return DadosResposta[]
     */
    public static function buscaRespostas($preenchimentoId)
    {
        $dao = new \cl_avaliacaogruporesposta;
        $campos = array(
            "db102_identificadorcampo as grupo",
            "db103_identificadorcampo as pergunta",
            "db103_sequencial as idpergunta",
            "db104_valorresposta as valorresposta",
            "db106_resposta as resposta",
            "db103_avaliacaotiporesposta as tipopergunta",
            "db103_obrigatoria as obrigatoria"
        );

        $campos = implode(', ', $campos);
        $sql = $dao->busca_resposta_preenchimento($preenchimentoId, $campos);
        $rs = \db_query($sql);

        return \db_utils::makeCollectionFromRecord($rs, function ($dado) {

            $dadoResposta = new DadosResposta();
            $dadoResposta->grupo = $dado->grupo;
            $dadoResposta->pergunta = $dado->pergunta;
            $dadoResposta->idPergunta = $dado->idpergunta;
            $dadoResposta->valorResposta = $dado->valorresposta;
            $dadoResposta->resposta = $dado->resposta;
            $dadoResposta->tipoPergunta = $dado->tipopergunta;
            $dadoResposta->obrigatoria = $dado->obrigatoria == 't';

            return $dadoResposta;
        });
    }
}
