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
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: contabilidade
//CLASSE DA ENTIDADE receitaexercicioanterior
class cl_receitaexercicioanterior
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
    var $c233_codhist = 0;
    var $c233_compl = 'f';
    var $c233_descr = null;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
        c234_sequencial serial,
        c234_orgao int4 NOT NULL,
        c234_mes int4 NOT NULL,
        c234_ano int4 NOT NULL,
        c234_receita int8 NOT NULL,
        c234_tipoemenda int8 NOT NULL,
        c234_valorarrecadado float8 NOT NULL ";
    //funcao construtor da classe
    function cl_receitaexercicioanterior()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("receitaexercicioanterior");
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
        if ($exclusao == false) {
            $this->c234_sequencial = ($this->c234_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["c234_sequencial"] : $this->c234_sequencial);
            $this->c234_orgao = ($this->c234_orgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c234_orgao"] : $this->c234_orgao);
            $this->c234_mes = ($this->c234_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["c234_mes"] : $this->c234_mes);
            $this->c234_ano = ($this->c234_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["c234_ano"] : $this->c234_ano);
            $this->c234_receita = ($this->c234_receita == "" ? @$GLOBALS["HTTP_POST_VARS"]["c234_receita"] : $this->c234_receita);
            $this->c234_tipoemenda = ($this->c234_tipoemenda == "" ? @$GLOBALS["HTTP_POST_VARS"]["c234_tipoemenda"] : $this->c234_tipoemenda);
            $this->c234_valorarrecadado = ($this->c234_valorarrecadado == "" ? @$GLOBALS["HTTP_POST_VARS"]["c234_valorarrecadado"] : $this->c234_valorarrecadado);
        } else {
            $this->c234_sequencial = ($this->c234_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["c234_sequencial"] : $this->c234_sequencial);
        }
    }
    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();
        if ($this->c234_orgao == null) {
            $this->erro_sql = " Campo Orgao nao Informado.";
            $this->erro_campo = "c234_orgao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c234_mes == null) {
            $this->erro_sql = " Campo Mes nao Informado.";
            $this->erro_campo = "c234_mes";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c234_ano == null) {
            $this->erro_sql = " Campo Ano nao Informado.";
            $this->erro_campo = "c234_ano";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c234_receita == null) {
            $this->erro_sql = " Campo Receita nao Informado.";
            $this->erro_campo = "c234_receita";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c234_tipoemenda == null) {
            $this->erro_sql = " Campo Tipo Emenda nao Informado.";
            $this->erro_campo = "c234_tipoemenda";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c234_valorarrecadado == null) {
            $this->erro_sql = " Campo Valor Arrecadado nao Informado.";
            $this->erro_campo = "c234_valorarrecadado";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into receitaexercicioanterior(c234_orgao,c234_mes,c234_ano,c234_receita,c234_tipoemenda,c234_valorarrecadado)values($this->c234_orgao,$this->c234_mes,$this->c234_ano,$this->c234_receita,$this->c234_tipoemenda,$this->c234_valorarrecadado)";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "Despesa do Exercício Anterior ($this->c234_sequencial) nao IncluÃ­da. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "Despesa do ExercÃ­cio Anterior jÃ¡ Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "Despesa do ExercÃ­cio Anterior ($this->c234_sequencial) nao IncluÃ­do. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_msg .= $sql;
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->c234_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    function alterar($c234_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update receitaexercicioanterior set ";
        $virgula = "";
        if (trim($this->c234_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c234_sequencial"])) {
            $sql .= $virgula . " c234_sequencial = $this->c234_sequencial ";
            $virgula = ",";
            if (trim($this->c234_sequencial) == null) {
                $this->erro_sql = " Campo Sequencial nao Informado.";
                $this->erro_campo = "c234_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c234_orgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c234_orgao"])) {
            $sql  .= $virgula . " c234_orgao = '$this->c234_orgao' ";
            $virgula = ",";
            if (trim($this->c234_orgao) == null) {
                $this->erro_sql = " Campo Orgao nao Informado.";
                $this->erro_campo = "c234_orgao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c234_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c234_mes"])) {
            $sql  .= $virgula . " c234_mes = '$this->c234_mes' ";
            $virgula = ",";
            if (trim($this->c234_mes) == null) {
                $this->erro_sql = " Campo MÃªs nao Informado.";
                $this->erro_campo = "c234_mes";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c234_ano) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c234_ano"])) {
            $sql  .= $virgula . " c234_ano = '$this->c234_ano' ";
            $virgula = ",";
            if (trim($this->c234_ano) == null) {
                $this->erro_sql = " Campo Ano nao Informado.";
                $this->erro_campo = "c234_ano";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c234_receita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c234_receita"])) {
            $sql  .= $virgula . " c234_receita = '$this->c234_receita' ";
            $virgula = ",";
            if (trim($this->c234_receita) == null) {
                $this->erro_sql = " Campo Receita nao Informado.";
                $this->erro_campo = "c234_receita";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c234_tipoemenda) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c234_tipoemenda"])) {
            $sql  .= $virgula . " c234_tipoemenda = '$this->c234_tipoemenda' ";
            $virgula = ",";
            if (trim($this->c234_tipoemenda) == null) {
                $this->erro_sql = " Campo Tipo de Emenda nao Informado.";
                $this->erro_campo = "c234_tipoemenda";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c234_valorarrecadado) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c234_valorarrecadado"])) {
            $sql  .= $virgula . " c234_valorarrecadado = '$this->c234_valorarrecadado' ";
            $virgula = ",";
            if (trim($this->c234_valorarrecadado) == null) {
                $this->erro_sql = " Campo Valor da Arrecadado nao Informado.";
                $this->erro_campo = "c234_valorarrecadado";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        $sql .= " where ";
        if (trim($this->c234_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c234_sequencial"])) {
            $sql .= " c234_sequencial = $this->c234_sequencial";
        }

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Despesa do Exercicio Anterior nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->c234_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));

            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Exercicio Anterior nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->c234_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));

                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->c234_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir($c234_sequencial = null, $dbwhere = null)
    {
        $sql = " delete from receitaexercicioanterior where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($c234_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c234_sequencial = $c234_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Despesa do Exercicio Anterior nao ExcluÃ­do. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $c234_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Exercicio Anterior nao Encontrado. Exclusão nÃ£o Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $c234_sequencial;
                $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $c234_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao do recordset
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
            $this->erro_sql   = "Record Vazio na Tabela:receitaexercicioanterior";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    function sql_query($c234_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from receitaexercicioanterior ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c234_sequencial != null) {
                $sql2 .= " where receitaexercicioanterior.c234_sequencial = $c234_sequencial ";
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
    function sql_query_file($c234_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from receitaexercicioanterior ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c234_sequencial != null) {
                $sql2 .= " where receitaexercicioanterior.c234_sequencial = $c234_sequencial ";
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
}
