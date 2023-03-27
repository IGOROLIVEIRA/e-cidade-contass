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
//CLASSE DA ENTIDADE dipr
class cl_diprcontribuicao
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
    var $nomeTabela = "diprbasecontribuicao";
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        c237_sequencial serial,
        c237_coddipr int8,
        c237_datasicom date,
        c237_tipoente int4,
        c237_basecalculocontribuinte int4,
        c237_mescompetencia int4,
        c237_exerciciocompetencia int4,
        c237_tipofundo int4,
        c237_remuneracao decimal,
        c237_basecalculoorgao int4,
        c237_basecalculosegurados int4,
        c237_valorbasecalculo decimal,
        c237_tipocontribuinte int4,
        c237_aliquota decimal,
        c237_valorcontribuicao decimal ";

    //funcao construtor da classe
    function cl_diprcontribuicao()
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
            $this->c237_coddipr = ($this->c237_coddipr == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_coddipr"] : $this->c237_coddipr);
            $this->c237_tipoente = ($this->c237_tipoente == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_tipoente"] : $this->c237_tipoente);
            $this->atualizaCampoData("c237_datasicom");
            $this->c237_basecalculocontribuinte = ($this->c237_basecalculocontribuinte == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_basecalculocontribuinte"] : $this->c237_basecalculocontribuinte);
            $this->c237_mescompetencia = ($this->c237_mescompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_mescompetencia"] : $this->c237_mescompetencia);
            $this->c237_exerciciocompetencia = ($this->c237_exerciciocompetencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_exerciciocompetencia"] : $this->c237_exerciciocompetencia);
            $this->c237_tipofundo = ($this->c237_tipofundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_tipofundo"] : $this->c237_tipofundo);
            $this->c237_remuneracao = ($this->c237_remuneracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_remuneracao"] : $this->c237_remuneracao);
            $this->verificarCondicaoBaseCalculoContribuintePatronal('c237_basecalculoorgao');
            $this->verificarCondicaoBaseCalculoContribuinteSegurado('c237_basecalculosegurados');
            $this->c237_valorbasecalculo = ($this->c237_valorbasecalculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_valorbasecalculo"] : $this->c237_valorbasecalculo);
            $this->c237_tipocontribuinte = ($this->c237_tipocontribuinte == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_tipocontribuinte"] : $this->c237_tipocontribuinte);
            $this->c237_aliquota = ($this->c237_aliquota == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_aliquota"] : $this->c237_aliquota);
            $this->c237_valorcontribuicao = ($this->c237_valorcontribuicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c237_valorcontribuicao"] : $this->c237_valorcontribuicao);
        }
    }

    public function verificarCondicaoBaseCalculoContribuintePatronal($nomeCampo)
    {
        if ($this->c237_basecalculocontribuinte === "2") {
            $this->$nomeCampo = 0;
            return;
        }
        $this->$nomeCampo = ($this->nomeCampo == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampo] : $this->$nomeCampo);
    }

    public function verificarCondicaoBaseCalculoContribuinteSegurado($nomeCampo)
    {
        if ($this->c237_basecalculocontribuinte === "1") {
            $this->$nomeCampo = 0;
            return;
        }
        $this->$nomeCampo = ($this->nomeCampo == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampo] : $this->$nomeCampo);
    }

    function atualizaCampoData($nomeCampo)
    {
        $nomeCampoDia = "{$nomeCampo}_dia";
        $nomeCampoMes = "{$nomeCampo}_mes";
        $nomeCampoAno = "{$nomeCampo}_ano";
        if ($this->$nomeCampo == "") {
            $this->$nomeCampoDia = ($this->$nomeCampoDia == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampoDia] : $this->$nomeCampoDia);
            $this->$nomeCampoMes = ($this->$nomeCampoMes == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampoMes] : $this->$nomeCampoMes);
            $this->$nomeCampoAno = ($this->$nomeCampoAno == "" ? @$GLOBALS["HTTP_POST_VARS"][$nomeCampoAno] : $this->$nomeCampoAno);
            if ($this->$nomeCampoDia != "") {
                $this->$nomeCampo = $this->$nomeCampoAno . "-" . $this->$nomeCampoMes . "-" . $this->$nomeCampoDia;
            }
        } 
    }

    // funcao para Inclusão
    function incluir()
    {
        $this->atualizacampos();
        if (!$this->verificaCodigoDIRP())
            return false;

        if (!$this->verificaTipoEnte())
            return false;
 
        if (!$this->verificaDataSICOM())
            return false;

        if (!$this->verificaTipoBaseCalculoContribuicao())
            return false;

        if (!$this->verificaMesCompetencia())
            return false;

        if (!$this->verificaExercicioCompetencia())
            return false;

        if (!$this->verificaTipoFundo())
            return false;

        if (!$this->verificaRemuneracao())
            return false;

        if (!$this->verificaTipoBaseCalculoOrgao())
            return false;

        if (!$this->verificaTipoBaseCalculoSegurados())
            return false;
        
        if (!$this->verificaValorBaseCalculo())
            return false;

        if (!$this->verificaTipoContribuicao())
            return false;

        if (!$this->verificaAliquota())
            return false;

        if (!$this->verificaValorContribuicao())
            return false;

        $sql  = "INSERT INTO {$this->nomeTabela} ( ";
        $sql .= " c237_coddipr, ";
        $sql .= " c237_datasicom, ";
        $sql .= " c237_tipoente, ";
        $sql .= " c237_basecalculocontribuinte, ";
        $sql .= " c237_mescompetencia, ";
        $sql .= " c237_exerciciocompetencia, ";
        $sql .= " c237_tipofundo, ";
        $sql .= " c237_remuneracao, ";
        $sql .= " c237_basecalculoorgao, ";
        $sql .= " c237_basecalculosegurados, ";
        $sql .= " c237_valorbasecalculo, ";
        $sql .= " c237_tipocontribuinte, ";
        $sql .= " c237_aliquota, ";
        $sql .= " c237_valorcontribuicao ";
        $sql .= ") VALUES ( ";
        $sql .= " {$this->c237_coddipr}, ";
        $sql .= " '{$this->c237_datasicom}', ";
        $sql .= " {$this->c237_tipoente}, ";
        $sql .= " {$this->c237_basecalculocontribuinte}, ";
        $sql .= " {$this->c237_mescompetencia}, ";
        $sql .= " {$this->c237_exerciciocompetencia}, ";
        $sql .= " {$this->c237_tipofundo}, ";
        $sql .= " {$this->c237_remuneracao}, ";
        $sql .= " {$this->c237_basecalculoorgao}, ";
        $sql .= " {$this->c237_basecalculosegurados}, ";
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

        if (!$this->verificaTipoBaseCalculoOrgao())
            return false;
    
        if (!$this->verificaTipoBaseCalculoSegurados())
            return false;

        $sql = " UPDATE {$this->nomeTabela} SET ";
        $virgula = "";

        if ($this->verificaSequencial()) {
            $sql .= $virgula . " c237_sequencial = {$this->c237_sequencial} ";
            $virgula = ",";            
        }

        if ($this->verificaCodigoDIRP()) {
            $sql  .= $virgula . " c237_coddipr = '$this->c237_coddipr' ";
            $virgula = ",";
        }

        if ($this->verificaTipoEnte()) {
            $sql .= $virgula . " c237_tipoente = {$this->c237_tipoente} ";
            $virgula = ",";            
        }

        if ($this->verificaDataSICOM()) {
            $sql  .= $virgula . " c237_datasicom = '{$this->c237_datasicom}' ";
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

        if ($this->verificaTipoBaseCalculoSegurados()) {
            $sql  .= $virgula . " c237_basecalculosegurados = '$this->c237_basecalculosegurados' ";
            $virgula = ",";
        }

        if ($this->verificaValorBaseCalculo()) {
            $sql  .= $virgula . " c237_valorbasecalculo = '$this->c237_valorbasecalculo' ";
            $virgula = ",";
        }

        if ($this->verificaAliquota()) {
            $sql  .= $virgula . " c237_aliquota = '$this->c237_aliquota' ";
            $virgula = ",";
        }

        if ($this->verificaValorContribuicao()) {
            $sql  .= $virgula . " c237_valorcontribuicao = '$this->c237_valorcontribuicao' ";
            $virgula = ",";
        }

        if ($this->verificaTipoContribuicao()) {
            $sql  .= $virgula . " c237_tipocontribuinte = '$this->c237_tipocontribuinte' ";
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
            $this->erro_sql   = "Record Vazio na Tabela:dipr";
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
        $nomeCampo = "c237_sequencial";
        $descricaoCampo = "Sequencial";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaCodigoDIRP()
    {
        $nomeCampo = "c237_coddipr";
        $descricaoCampo = "Código DIRP";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaTipoEnte()
    {
        $nomeCampo = "c237_tipoente";
        $descricaoCampo = "Tipo Ente";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    function verificaDataSICOM()
    {
        $nomeCampo = "c237_datasicom";
        $descricaoCampo = "Data Referência SICOM";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaTipoBaseCalculoContribuicao()
    {
        $nomeCampo = "c237_basecalculocontribuinte";
        $descricaoCampo = "Tipo Base de Calculo Contribuição";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    function verificaMesCompetencia()
    {
        $nomeCampo = "c237_mescompetencia";
        $descricaoCampo = "Mês Competencia";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    function verificaExercicioCompetencia()
    {
        $nomeCampo = "c237_exerciciocompetencia";
        $descricaoCampo = "Exercicio Competencia";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaRemuneracao()
    {
        $nomeCampo = "c237_remuneracao";
        $descricaoCampo = "Remuneração";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaTipoFundo()
    {
        $nomeCampo = "c237_tipofundo";
        $descricaoCampo = "Tipo Fundo Contribuição";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    function verificaValorBaseCalculo()
    {
        $nomeCampo = "c237_valorbasecalculo";
        $descricaoCampo = "Valor de Base de Calculo";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaAliquota()
    {
        $nomeCampo = "c237_aliquota";
        $descricaoCampo = "Valor Aliquota";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaValorContribuicao()
    {
        $nomeCampo = "c237_valorcontribuicao";
        $descricaoCampo = "Valor da Contribuição";
        return $this->validacaoCampoTexto($nomeCampo, $descricaoCampo);
    }

    function verificaTipoBaseCalculoOrgao()
    {
        $nomeCampo = "c237_basecalculoorgao";
        $descricaoCampo = "Tipo Base de Calculo Orgão";
        if ($this->$nomeCampo == 0 AND $this->c237_basecalculocontribuinte == 1) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;
    }

    function verificaTipoBaseCalculoSegurados()
    {
        $nomeCampo = "c237_basecalculosegurados";
        $descricaoCampo = "Tipo Base de Calculo Segurados";
        if ($this->$nomeCampo == 0 AND $this->c237_basecalculocontribuinte == 2) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;
    }
    

    function verificaTipoContribuicao()
    {
        $nomeCampo = "c237_tipocontribuinte";
        $descricaoCampo = "Tipo de Contribuição";
        return $this->validacaoCampoInteiro($nomeCampo, $descricaoCampo);
    }

    public function validacaoCampoTexto($nomeCampo, $descricaoCampo)
    {
        if (trim($this->$nomeCampo) == "" AND trim($GLOBALS["HTTP_POST_VARS"][$nomeCampo]) == "") {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
            return false;
        }
        return true;
    }

    public function validacaoCampoInteiro($nomeCampo, $descricaoCampo)
    {
        if ($this->$nomeCampo == 0) {
            $this->erroCampo("Campo {$descricaoCampo} não Informado.", $nomeCampo);
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
