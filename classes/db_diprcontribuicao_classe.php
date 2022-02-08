<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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
 *  junto com este programa; se não, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: contabilidade
//CLASSE DA ENTIDADE dirp
class cl_dirpcontribuicao
{
    // cria variaveis de erro
    var $rotulo     = null;
    var $query_sql  = null;
    var $numrows    = 0;
    var $numrows_incluir = 0;
    var $numrows_alterar = 0;
    var $numrows_excluir = 0;
    var $erro_status = null;
    var $erro_sql   = null;
    var $erro_banco = null;
    var $erro_msg   = null;
    var $erro_campo = null;
    var $pagina_retorno = null;
    // cria variaveis do arquivo
    var $c237_codhist = 0;
    var $c237_compl = 'f';
    var $c237_descr = null;
    var $nomeTabela = "dirpcontribuicao";
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        c237_sequencial serial,
        c237_coddirp int8,
        c237_datasicom date,
        c237_basecalculocontribuinte int4,
        c237_mescompetencia int4,
        c237_exerciciocompetencia int4,
        c237_tipofundo int4,
        c237_remuneracao decimal,
        c237_basecalculoorgao int4,
        c237_valorbasecalculo decimal,
        c237_tipocontribuinte int4,
        c237_aliquota decimal,
        c237_valorcontribuicao decimal ";

    //funcao construtor da classe
    function cl_dirpcontribuicao()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo($this->nomeTabela);
        $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
    }

    //funcao erro
    function erro($mostra, $retorna)
    {
        if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
            echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
            if ($retorna == true) {
                echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
            }
        }
    }

    // funcao para atualizar campos
    function atualizacampos($exclusao = false)
    {
        $this->c237_sequencial = ($this->c237_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_sequencial"] : $this->c237_sequencial);
        if ($exclusao == false) {
            $this->c237_coddirp = ($this->c237_coddirp == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_coddirp"] : $this->c237_coddirp);
            $this->c237_datasicom = ($this->c237_datasicom == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_datasicom"] : $this->c237_datasicom);
            $this->c237_basecalculocontribuinte = ($this->c237_basecalculocontribuinte == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_basecalculocontribuinte"] : $this->c237_basecalculocontribuinte);
            $this->c237_mescompetencia = ($this->c237_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_mescompetencia"] : $this->c237_mescompetencia);
            $this->c237_exerciciocompetencia = ($this->c237_exerciciocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_exerciciocompetencia"] : $this->c237_exerciciocompetencia);
            $this->c237_tipofundo = ($this->c237_tipofundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_tipofundo"] : $this->c237_tipofundo);
            $this->c237_remuneracao = ($this->c237_remuneracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_remuneracao"] : $this->c237_remuneracao);
            $this->c237_basecalculoorgao = ($this->c237_basecalculoorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_basecalculoorgao"] : $this->c237_basecalculoorgao);
            $this->c237_valorbasecalculo = ($this->c237_valorbasecalculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_valorbasecalculo"] : $this->c237_valorbasecalculo);
            $this->c237_tipocontribuinte = ($this->c237_tipocontribuinte == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_tipocontribuinte"] : $this->c237_tipocontribuinte);
            $this->c237_aliquota = ($this->c237_aliquota == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_aliquota"] : $this->c237_aliquota);
            $this->c237_valorcontribuicao = ($this->c237_valorcontribuicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_valorcontribuicao"] : $this->c237_valorcontribuicao);
        }
    }

    // funcao para Inclusão
    function incluir()
    {
        $this->atualizacampos();
        if (!$this->verificaCodigoDIRP())
            return false;

        if (!$this->verificaDataSICOM())
            return false;

        if (!$this->verificaTipoBaseCalculoContribuicao())
            return false;

        if (!$this->verificaMesCompetencia())
            return false;

        if (!$this->verificaExercicioCompetencia())
            return false;

        if (!$this->verificaRemuneracao())
            return false;

        if (!$this->verificaTipoFundo())
            return false;

        if (!$this->verificaTipoBaseCalculoOrgao())
            return false;
        
        if (!$this->verificaValorBaseCalculo())
            return false;

        if (!$this->verificaAliquota())
            return false;

        $sql  = "INSERT INTO {$this->nomeTabela} ( ";
        $sql .= " c237_sequencial, ";
        $sql .= " c237_coddirp, ";
        $sql .= " c237_datasicom, ";
        $sql .= " c237_basecalculocontribuinte, ";
        $sql .= " c237_mescompetencia, ";
        $sql .= " c237_exerciciocompetencia, ";
        $sql .= " c237_tipofundo, ";
        $sql .= " c237_remuneracao, ";
        $sql .= " c237_basecalculoorgao, ";
        $sql .= " c237_valorbasecalculo, ";
        $sql .= " c237_tipocontribuinte, ";
        $sql .= " c237_aliquota, ";
        $sql .= " c237_valorcontribuicao ";
        $sql .= ") VALUES ( ";
        $sql .= " {$this->c237_sequencial}, ";
        $sql .= " {$this->c237_coddirp}, ";
        $sql .= " {$this->c237_datasicom}, ";
        $sql .= " {$this->c237_basecalculocontribuinte}, ";
        $sql .= " {$this->c237_mescompetencia}, ";
        $sql .= " {$this->c237_exerciciocompetencia}, ";
        $sql .= " {$this->c237_tipofundo}, ";
        $sql .= " {$this->c237_remuneracao}, ";
        $sql .= " {$this->c237_basecalculoorgao}, ";
        $sql .= " {$this->c237_valorbasecalculo}, ";
        $sql .= " {$this->c237_tipocontribuinte}, ";
        $sql .= " {$this->c237_aliquota}, ";
        $sql .= " {$this->c237_valorcontribuicao} ) ";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "DIRP não Incluída. Inclusão Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "DIRP já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "DIRP não Incluído. Inclusão Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->c237_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    function alterar($c237_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " UPDATE {$this->nomeTabela} SET ";
        $virgula = "";

        if ($this->verificaSequencial()) {
            $sql .= $virgula . " c237_sequencial = {$this->c237_sequencial} ";
            $virgula = ",";            
        }

        if ($this->verificaCodigoDIRP()) {
            $sql  .= $virgula . " c237_coddirp = '$this->c237_coddirp' ";
            $virgula = ",";
        }

        if ($this->verificaDataSICOM()) {
            $sql  .= $virgula . " c237_datasicom = '$this->c237_datasicom' ";
            $virgula = ",";
        }

        if ($this->verificaTipoBaseCalculoContribuicao()) {
            $sql  .= $virgula . " c237_basecalculocontribuinte = '$this->c237_basecalculocontribuinte' ";
            $virgula = ",";
        }

        if ($this->verificaMesCompetencia()) {
            $sql  .= $virgula . " c237_mescompetencia = '$this->c237_mescompetencia' ";
            $virgula = ",";
        }

        if ($this->verificaExercicioCompetencia()) {
            $sql  .= $virgula . " c237_exerciciocompetencia = '$this->c237_exerciciocompetencia' ";
            $virgula = ",";
        }

        if ($this->verificaRemuneracao()) {
            $sql  .= $virgula . " c237_remuneracao = '$this->c237_remuneracao' ";
            $virgula = ",";
        }
        
        if ($this->verificaTipoFundo()) {
            $sql  .= $virgula . " c237_tipofundo = '$this->c237_tipofundo' ";
            $virgula = ",";
        }

        if ($this->verificaTipoBaseCalculoOrgao()) {
            $sql  .= $virgula . " c237_basecalculoorgao = '$this->c237_basecalculoorgao' ";
            $virgula = ",";
        }

        $sql .= " WHERE ";

        if ($c237_sequencial != null) {
            $sql .= " c237_sequencial = $c237_sequencial ";
        }

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->c237_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->c233_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteracao efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->c233_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($c237_sequencial = null, $dbwhere = null)
    {
        $sql = " DELETE FROM {$this->nomeTabela} WHERE ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($c237_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c237_sequencial = $c237_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }

        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Despesa do Codigo DIRP não Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $c237_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Codigo DIRP não Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $c237_sequencial;
                $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $c237_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    function sql_record($sql)
    {
        $result = db_query($sql);
        if ($result == false) {
            $this->numrows    = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Erro ao selecionar os registros.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql   = "Record Vazio na Tabela:dirp";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    function sql_query($c237_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
    {
        $sql = "SELECT ";
        if ($campos != "*") {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " FROM {$this->nomeTabela} ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c237_sequencial != null) {
                $sql2 .= " WHERE c237_sequencial = $c237_sequencial ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    function sql_query_file($c237_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
    {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = explode("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from {$this->nomeTabela} ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c237_sequencial != null) {
                $sql2 .= " where c237_sequencial = $c237_sequencial ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = explode("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula . $campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    function verificaSequencial()
    {
        if (trim($this->c237_sequencial) == "" AND !isset($GLOBALS["HTTP_POST_VARS"]["c237_sequencial"])) {
            $this->erroCampo("Campo Sequencial não Informado.", "c237_sequencial");
            return false;
        }
        return true;
    }

    function verificaCodigoDIRP()
    {
        if (trim($this->c237_coddirp) == "" AND !isset($GLOBALS["HTTP_POST_VARS"]["c237_coddirp"])) {
            $this->erroCampo("Campo Código DIRP não Informado.", "c237_coddirp");
            return false;
        }
        return true;
    }

    function verificaDataSICOM()
    {
        if (trim($this->c237_datasicom) == "" AND !isset($GLOBALS["HTTP_POST_VARS"]["c237_datasicom"])) {
            $this->erroCampo("Campo Data Referência SICOM não Informada.", "c237_datasicom");
            return false;
        }
        return true;
    }

    function verificaTipoBaseCalculoContribuicao()
    {
        if (trim($this->c237_basecalculocontribuinte) == "0") {
            $this->erroCampo("Campo Tipo Base de Calculo Contribuição não Informado.", "c237_basecalculocontribuinte");
            return false;
        }
        return true;
    }

    function verificaMesCompetencia()
    {
        if (trim($this->c237_mescompetencia) == "0") {
            $this->erroCampo("Campo Mês Competencia não Informado.", "c237_mescompetencia");
            return false;
        }
        return true;
    }

    function verificaExercicioCompetencia()
    {
        if (trim($this->c237_exerciciocompetencia) == "" AND !isset($GLOBALS["HTTP_POST_VARS"]["c237_exerciciocompetencia"])) {
            $this->erroCampo("Campo Exercicio Competencia não Informado.", "c237_exerciciocompetencia");
            return false;
        }
        return true;
    }

    function verificaRemuneracao()
    {
        if (trim($this->c237_remuneracao) == "" AND !isset($GLOBALS["HTTP_POST_VARS"]["c237_remuneracao"])) {
            $this->erroCampo("Campo Remuneração não Informado.", "c237_remuneracao");
            return false;
        }
        return true;
    }

    function verificaTipoFundo()
    {
        if (trim($this->c237_tipofundo) == "0") {
            $this->erroCampo("Campo Tipo Fundo Contribuição não Informado.", "c237_tipofundo");
            return false;
        }
        return true;
    }

    function verificaValorBaseCalculo()
    {
        if (trim($this->c237_valorbasecalculo) == "" AND !isset($GLOBALS["HTTP_POST_VARS"]["c237_valorbasecalculo"])) {
            $this->erroCampo("Campo Valor de Base de Calculo não Informado.", "c237_valorbasecalculo");
            return false;
        }
        return true;
    }

    function verificaAliquota()
    {
        if (trim($this->c237_aliquota) == "" AND !isset($GLOBALS["HTTP_POST_VARS"]["c237_aliquota"])) {
            $this->erroCampo("Campo Valor Aliquota não Informado.", "c237_aliquota");
            return false;
        }
        return true;
    }

    function verificaValorContribuição()
    {
        if (trim($this->c237_valorcontribuicao) == "" AND !isset($GLOBALS["HTTP_POST_VARS"]["c237_valorcontribuicao"])) {
            $this->erroCampo("Campo Valor da Contribuição não Informado.", "c237_valorcontribuicao");
            return false;
        }
        return true;
    }

    function verificaTipoBaseCalculoOrgao()
    {
        if (trim($this->c237_basecalculoorgao) == "0") {
            $this->erroCampo("Campo Tipo Base de Calculo Orgão não Informado.", "c237_basecalculoorgao");
            return false;
        }
        return true;
    }

    function erroCampo($descricao, $campo)
    {
        $this->erro_sql = $descricao;
        $this->erro_campo = $campo;
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
    }
}
