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
//CLASSE DA ENTIDADE despesaexercicioanterior
class cl_despesaexercicioanterior
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
        c233_sequencial serial,
        c233_orgao int4 NOT NULL,
        c233_mes int4 NOT NULL,
        c233_ano int4 NOT NULL,
        c233_elemento int8 NOT NULL,
        c233_fonte int8 NOT NULL,
        c233_valorempenhado float8 NOT NULL,
        c233_tipodespesarpps int4,
        c233_competencia date,
        c233_valorliquidado float8,
        c233_valorpago float8 ";
    //funcao construtor da classe
    function cl_despesaexercicioanterior()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("despesaexercicioanterior");
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
            $this->c233_sequencial = ($this->c233_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_sequencial"] : $this->c233_sequencial);
            $this->c233_orgao = ($this->c233_orgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_orgao"] : $this->c233_orgao);
            $this->c233_mes = ($this->c233_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_mes"] : $this->c233_mes);
            $this->c233_ano = ($this->c233_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_ano"] : $this->c233_ano);
            $this->c233_elemento = ($this->c233_elemento == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_elemento"] : $this->c233_elemento);
            $this->c233_fonte = ($this->c233_fonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_fonte"] : $this->c233_fonte);
            $this->c233_valorempenhado = ($this->c233_valorempenhado == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_valorempenhado"] : $this->c233_valorempenhado);
            $this->c233_tipodespesarpps = ($this->c233_tipodespesarpps == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_tipodespesarpps"] : $this->c233_tipodespesarpps);
            $this->c233_competencia = ($this->c233_competencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_competencia"] : $this->c233_competencia);
            $this->c233_valorliquidado = ($this->c233_valorliquidado == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_valorliquidado"] : $this->c233_valorliquidado);
            $this->c233_valorpago = ($this->c233_valorpago == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_valorpago"] : $this->c233_valorpago);
        } else {
            $this->c233_sequencial = ($this->c233_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["c233_sequencial"] : $this->c233_sequencial);
        }
    }
    // funcao para inclusao
    function incluir()
    {
        $this->atualizacampos();
        if ($this->c233_orgao == null) {
            $this->erro_sql = " Campo Orgao nao Informado.";
            $this->erro_campo = "c233_orgao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c233_mes == null) {
            $this->erro_sql = " Campo Mes nao Informado.";
            $this->erro_campo = "c233_mes";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c233_ano == null) {
            $this->erro_sql = " Campo Ano nao Informado.";
            $this->erro_campo = "c233_ano";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->c233_elemento == null) {
            $this->erro_sql = " Campo Elemento nao Informado.";
            $this->erro_campo = "c233_elemento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->c233_valorempenhado == null) {
            $this->erro_sql = " Campo Valor Empenhado nao Informado.";
            $this->erro_campo = "c233_valorempenhado";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $this->c233_tipodespesarpps = $this->c233_tipodespesarpps == '' ? 0 : $this->c233_tipodespesarpps;
        $this->c233_valorliquidado = $this->c233_valorliquidado == '' ? 0 : $this->c233_valorliquidado;
        $this->c233_valorpago = $this->c233_valorpago == '' ? 0 : $this->c233_valorpago;
        $this->c233_fonte = $this->c233_fonte == '' ? 'null' : $this->c233_fonte;
        $this->c233_competencia = $this->c233_competencia == '' ? 'null' : "'$this->c233_competencia'";

        $sql = "insert into despesaexercicioanterior(c233_orgao,c233_mes,c233_ano,c233_elemento,c233_fonte,c233_valorempenhado,c233_tipodespesarpps,c233_competencia,c233_valorliquidado,c233_valorpago)values($this->c233_orgao,$this->c233_mes,$this->c233_ano,$this->c233_elemento,$this->c233_fonte,$this->c233_valorempenhado,$this->c233_tipodespesarpps,$this->c233_competencia,$this->c233_valorliquidado,$this->c233_valorpago)";

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "Despesa do Exercício Anterior nao Incluída. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "Despesa do Exercício Anterior já Cadastrado";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "Despesa do Exercício Anterior nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->c233_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        return true;
    }

    function alterar($c233_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update despesaexercicioanterior set ";
        $virgula = "";
        if (trim($this->c233_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c233_sequencial"])) {
            $sql .= $virgula . " c233_sequencial = $this->c233_sequencial ";
            $virgula = ",";
            if (trim($this->c233_sequencial) == null) {
                $this->erro_sql = " Campo Sequencial nao Informado.";
                $this->erro_campo = "c233_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c233_orgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c233_orgao"])) {
            $sql  .= $virgula . " c233_orgao = '$this->c233_orgao' ";
            $virgula = ",";
            if (trim($this->c233_orgao) == null) {
                $this->erro_sql = " Campo Orgao nao Informado.";
                $this->erro_campo = "c233_orgao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c233_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c233_mes"])) {
            $sql  .= $virgula . " c233_mes = '$this->c233_mes' ";
            $virgula = ",";
            if (trim($this->c233_mes) == null) {
                $this->erro_sql = " Campo Mês nao Informado.";
                $this->erro_campo = "c233_mes";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c233_ano) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c233_ano"])) {
            $sql  .= $virgula . " c233_ano = '$this->c233_ano' ";
            $virgula = ",";
            if (trim($this->c233_ano) == null) {
                $this->erro_sql = " Campo Ano nao Informado.";
                $this->erro_campo = "c233_ano";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c233_elemento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c233_elemento"])) {
            $sql  .= $virgula . " c233_elemento = '$this->c233_elemento' ";
            $virgula = ",";
            if (trim($this->c233_elemento) == null) {
                $this->erro_sql = " Campo Elemento nao Informado.";
                $this->erro_campo = "c233_elemento";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->c233_valorempenhado) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c233_valorempenhado"])) {
            $sql  .= $virgula . " c233_valorempenhado = '$this->c233_valorempenhado' ";
            $virgula = ",";
            if (trim($this->c233_valorempenhado) == null) {
                $this->erro_sql = " Campo Valor da Empenhado nao Informado.";
                $this->erro_campo = "c233_valorempenhado";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        $sql .= " where ";
        if ($c233_sequencial != null) {
            $sql .= " c233_sequencial = $this->c233_sequencial";
        }

        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Despesa do Exercicio Anterior nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->c233_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Exercicio Anterior nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->c233_sequencial;
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
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
    function excluir($c233_sequencial = null, $dbwhere = null)
    {
        $sql = " delete from despesaexercicioanterior
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($c233_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " c233_sequencial = $c233_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Despesa do Exercicio Anterior nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $c233_sequencial;
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Despesa do Exercicio Anterior nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $c233_sequencial;
                $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $c233_sequencial;
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
            $this->erro_sql   = "Record Vazio na Tabela:despesaexercicioanterior";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    function sql_query($c233_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from despesaexercicioanterior ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c233_sequencial != null) {
                $sql2 .= " where despesaexercicioanterior.c233_sequencial = $c233_sequencial ";
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
    function sql_query_file($c233_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from despesaexercicioanterior ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($c233_sequencial != null) {
                $sql2 .= " where despesaexercicioanterior.c233_sequencial = $c233_sequencial ";
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
