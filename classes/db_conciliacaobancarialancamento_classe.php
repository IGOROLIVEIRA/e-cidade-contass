<?
// MODULO: Caixa
// CLASSE DA ENTIDADE conciliacaobancarialancamento
class cl_conciliacaobancarialancamento
{
    // cria variaveis de erro
    var $rotulo = null;
    var $query_sql = null;
    var $numrows = 0;
    var $numrows_incluir = 0;
    var $numrows_alterar = 0;
    var $numrows_excluir = 0;
    var $erro_status = null;
    var $erro_sql = null;
    var $erro_banco = null;
    var $erro_msg = null;
    var $erro_campo = null;
    var $pagina_retorno = null;
    // cria variaveis do arquivo
    var $k172_conta = 0;
    var $k172_data = null;
    var $k172_numcgm = 0;
    var $k172_coddoc = 0;
    var $k172_codigo = null;
    var $k172_valor = 0;
    var $k172_dataconciliacao = null;
    var $k172_mov = 0;

    // cria propriedade com as variaveis do arquivo
    var $campos = "
        k172_conta = int8 = Numero da Conta
        k172_data = date = Data do Lançamento
        k172_numcmg = int8 = Numero do CGM
        k172_coddoc = int8 = Codigo do Documento
        k172_codigo = varchar(255) = Codigo do Lancamento
        k172_valor = float8 = Valor Conciliado
        k172_dataconciliacao = date = Data da Conciliado
        k172_mov = int8 = Entrada ou saida
        ";

    // funcao erro
    function erro($mostra, $retorna) {
        if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
            echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
            if ($retorna == true) {
                echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
            }
        }
    }

    // funcao para atualizar campos
    function atualizacampos($exclusao = false) {
        if ($exclusao == false) {
            $this->k172_conta = ($this->k172_conta == "" ? @$GLOBALS["HTTP_POST_VARS"]["k172_conta"]:$this->k172_conta);
            if ($this->k172_data == "") {
                $this->k172_data_dia = ($this->k172_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k172_data_dia"]:$this->k172_data_dia);
                $this->k172_data_mes = ($this->k172_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k172_data_mes"]:$this->k172_data_mes);
                $this->k172_data_ano = ($this->k172_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k172_data_ano"]:$this->k172_data_ano);
                if ($this->k172_data_dia != "") {
                    $this->k172_data = $this->k172_data_ano."-".$this->k172_data_mes."-".$this->k172_data_dia;
                }
            }
            $this->k172_numcmg = ($this->k172_numcmg == "" ? @$GLOBALS["HTTP_POST_VARS"]["k172_conta"]:$this->k172_numcmg);
            $this->k172_coddoc = ($this->k172_coddoc == "" ? @$GLOBALS["HTTP_POST_VARS"]["k172_conta"]:$this->k172_coddoc);
            $this->k172_codigo = ($this->k172_codigo == "" ? @$GLOBALS["HTTP_POST_VARS"]["k172_conta"]:$this->k172_codigo);
            $this->k172_valor = ($this->k172_valor == "" ? @$GLOBALS["HTTP_POST_VARS"]["k172_valor"]:$this->k172_valor);
            $this->k172_mov = ($this->k172_mov == "" ? @$GLOBALS["HTTP_POST_VARS"]["k172_mov"]:$this->k172_mov);
            if ($this->k172_dataconciliacao == "") {
                $this->k172_data_conciliacao_dia = ($this->k172_data_conciliacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k172_data_conciliacao_dia"]:$this->k172_data_conciliacao_dia);
                $this->k172_data_conciliacao_mes = ($this->k172_data_conciliacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k172_data_conciliacao_mes"]:$this->k172_data_conciliacao_mes);
                $this->k172_data_conciliacao_ano = ($this->k172_data_conciliacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k172_data_conciliacao_ano"]:$this->k172_data_conciliacao_ano);
                if ($this->k172_data_conciliacao_dia != "") {
                    $this->k172_dataconciliacao = $this->k172_data_conciliacao_ano."-".$this->k172_data_conciliacao_mes."-".$this->k172_data_conciliacao_dia;
                }
            }
        } else {
            $this->k172_conta = ($this->k172_conta == ""?@$GLOBALS["HTTP_POST_VARS"]["k172_conta"]:$this->k172_conta);
        }
    }

    // funcao para inclusao
    function incluir() {
        $this->atualizacampos();
        if (($this->k172_conta == null) || ($this->k172_conta == "")) {
            $this->erro_sql = " Campo k172_conta não declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k172_data == null) {
            $this->erro_sql = " Campo Data não Informado.";
            $this->erro_campo = "k172_data_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k172_coddoc == null) {
            $this->erro_sql = " Campo CodDoc não Informado.";
            $this->erro_campo = "k172_valor";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k172_codigo == null) {
            $this->erro_sql = " Campo Código do Documento não Informado.";
            $this->erro_campo = "k172_codigo";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k172_mov == null) {
            $this->erro_sql = " Campo Movimentação não Informado.";
            $this->erro_campo = "k172_mov";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k172_valor == null) {
            $this->erro_sql = " Campo Valor não Informado.";
            $this->erro_campo = "k172_valor";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k172_dataconciliacao == null) {
            $this->erro_sql = " Campo Data da Conciliação não Informado.";
            $this->erro_campo = "k172_data_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into conciliacaobancarialancamento (k172_conta, k172_data, k172_numcgm, k172_coddoc, k172_codigo, k172_valor, k172_dataconciliacao, k172_mov) values ($this->k172_conta, " . ($this->k172_data == "null" || $this->k172_data == "" ? "null" : "'" . $this->k172_data . "'") . ", " . ($this->k172_numcgm != "" ? $this->k172_numcgm : 'null') . " , $this->k172_coddoc, " . ($this->k172_codigo == "Â " ? 'null' : "'{$this->k172_codigo}'") . ", $this->k172_valor, " . ($this->k172_dataconciliacao == "null" || $this->k172_dataconciliacao == "" ? "null" : "'" . $this->k172_dataconciliacao) . "', {$this->k172_mov})";
        $result = db_query($sql);

        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "Conciliacao Bancaria para o Lancamento da conta ({$this->k172_conta}) nao Incluido. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "Documento Automático Lançamento já Cadastrado";
                $this->erro_msg  .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "Conciliacao Bancaria para o Lancamento da conta ({$this->k172_conta}) nao Incluido. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg  .=  str_replace('"', "",str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                // $this->erro_msg  =  $sql;
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql  = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->k172_conta;
        $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (isset($lSessaoDesativarAccount) && $lSessaoDesativarAccount === false) {
            $resaco = $this->sql_record($this->sql_query_file($this->k172_conta));
            if (($resaco != false) || ($this->numrows != 0)) {
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount, " . db_getsession("DB_acessado"). ")");
                $resac = db_query("insert into db_acountkey values($acount, 5213, '$this->k172_conta', 'I')");
                $resac = db_query("insert into db_acount values($acount, 764, 5213, '', '" . AddSlashes(pg_result($resaco, 0, 'k172_conta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5214, '', '" . AddSlashes(pg_result($resaco, 0, 'k172_data')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k172_numcgm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k172_coddoc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k172_codigo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k172_valor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k172_dataconciliacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }
        return true;
    }

    // funcao para alteracao
    function alterar() {
        $this->atualizacampos();
        $sql = " update conciliacaobancarialancamento set ";
        $virgula = "";
        if (trim($this->k172_conta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k172_conta"])) {
            $sql .= $virgula . " k172_conta = $this->k172_conta ";
            $virgula = ",";
            if (trim($this->k172_conta) == null) {
                $this->erro_sql = " Campo Código Lançamento não Informado.";
                $this->erro_campo = "k172_conta";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k172_valor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k172_valor"])) {
            $sql .= $virgula." k172_valor = $this->k172_valor ";
            $virgula = ",";
            if (trim($this->k172_valor) == null) {
                $this->erro_sql = " Campo Código não Informado.";
                $this->erro_campo = "k172_valor";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k172_numcgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k172_numcgm"])) {
            $sql .= $virgula." k172_numcgm = $this->k172_numcgm ";
            $virgula = ",";
            if (trim($this->k172_numcgm) == null) {
                $this->erro_sql = " Campo Código não Informado.";
                $this->erro_campo = "k172_numcgm";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k172_coddoc) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k172_coddoc"])) {
            $sql .= $virgula." k172_coddoc = $this->k172_coddoc ";
            $virgula = ",";
            if (trim($this->k172_coddoc) == null) {
                $this->erro_sql = " Campo Código não Informado.";
                $this->erro_campo = "k172_coddoc";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k172_codigo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k172_codigo"])) {
            $sql .= $virgula." k172_codigo = '{$this->k172_codigo}' ";
            $virgula = ",";
            if (trim($this->k172_codigo) == null) {
                $this->erro_sql = " Campo Código não Informado.";
                $this->erro_campo = "k172_codigo";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k172_mov) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k172_mov"])) {
            $sql .= $virgula." k172_mov = $this->k172_mov ";
            $virgula = ",";
            if (trim($this->k172_mov) == null) {
                $this->erro_sql = " Campo Mov. não Informado.";
                $this->erro_campo = "k172_mov";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k172_data) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k172_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k172_data_dia"] != "")) {
            $sql .= $virgula." k172_data = '$this->k172_data' ";
            $virgula = ",";
            if (trim($this->k172_data) == null) {
                $this->erro_sql = " Campo Data não Informado.";
                $this->erro_campo = "k172_data_dia";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["k172_data_dia"])) {
                $sql .= $virgula . " k172_data = null ";
                $virgula = ",";
                if (trim($this->k172_data) == null) {
                    $this->erro_sql = " Campo Data não Informado.";
                    $this->erro_campo = "k172_data_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }

        if (trim($this->k172_dataconciliacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k172_data_conciliacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k172_data_conciliacao_dia"] != "")) {
            $sql .= $virgula." k172_dataconciliacao = '$this->k172_dataconciliacao' ";
            $virgula = ",";
            if (trim($this->k172_dataconciliacao) == null) {
                $this->erro_sql = " Campo Data não Informado.";
                $this->erro_campo = "k172_data_conciliacao_dia";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["k172_data_conciliacao_dia"])) {
                $sql .= $virgula . " k172_dataconciliacao = null ";
                $virgula = ",";
                if (trim($this->k172_dataconciliacao) == null) {
                    $this->erro_sql = " Campo Data da Conciliação não Informado.";
                    $this->erro_campo = "k172_data_conciliacao_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }

        $sql .= " where ";
        if ($this->k172_conta != null) {
            $sql .= " k172_conta = $this->k172_conta ";
        }
        if ($this->k172_data != null) {
            $sql .= " AND k172_data = '$this->k172_data' ";
        }
        if ($this->k172_numcgm != null) {
            $sql .= " AND k172_numcgm = $this->k172_numcgm ";
        }
        if ($this->k172_coddoc != null) {
            $sql .= " AND k172_coddoc = $this->k172_coddoc ";
        }
        if ($this->k172_mov != null) {
            $sql .= " AND k172_mov = $this->k172_mov ";
        }
        if ($this->k172_codigo != null) {
            $sql .= " AND k172_codigo = '{$this->k172_codigo}' ";
        }
        if ($this->k172_valor != null) {
            $sql .= " AND k172_valor = $this->k172_valor ";
        }
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (isset($lSessaoDesativarAccount) && $lSessaoDesativarAccount === false) {
            $resaco = $this->sql_record($this->sql_query_file($this->k172_conta));
            if ($this->numrows > 0) {
                for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac, 0, 0);
                    $resac = db_query("insert into db_acountacesso values($acount, " . db_getsession("DB_acessado") . ")");
                    $resac = db_query("insert into db_acountkey values($acount, 5213, '$this->k172_conta', 'A')");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["k172_conta"]))
                        $resac = db_query("insert into db_acount values($acount, 764, 5213, '" . AddSlashes(pg_result($resaco, $conresaco, 'k172_conta')) . "', '$this->k172_conta', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["k172_valor"]))
                        $resac = db_query("insert into db_acount values($acount, 764, 5214, '" . AddSlashes(pg_result($resaco, $conresaco, 'k172_valor')) . "', '$this->k172_valor', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["k172_data"]))
                        $resac = db_query("insert into db_acount values($acount, 764, 5898, '" . AddSlashes(pg_result($resaco, $conresaco, 'k172_data')) . "', '$this->k172_data', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                }
            }
        }
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Documento Automático Lançamento nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->k172_conta;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_msg = "$sql\\n";
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Documento Automático Lançamento nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->k172_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->k172_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($k172_conta = null, $dbwhere = null) {
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (isset($lSessaoDesativarAccount) && $lSessaoDesativarAccount === false) {
            if ($dbwhere == null || $dbwhere == "") {
                $resaco = $this->sql_record($this->sql_query_file($k172_conta));
            } else {
                $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
            }

            if (($resaco != false) || ($this->numrows != 0)) {
                for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac, 0, 0);
                    $resac = db_query("insert into db_acountacesso values($acount, ". db_getsession("DB_acessado") . ")");
                    $resac = db_query("insert into db_acountkey values($acount, 5213, '$k172_conta', 'E')");
                    $resac = db_query("insert into db_acount values($acount, 764, 5213, '', '" . AddSlashes(pg_result($resaco, $iresaco, 'k172_conta')) . "', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount, 764, 5214, '', '" . AddSlashes(pg_result($resaco, $iresaco, 'k172_valor')) . "', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, $iresaco, 'k172_data')) . "', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                }
            }
        }
        $sql = " delete from conciliacaobancarialancamento where ";
        $sql2 = "";
        if  ($dbwhere == null || $dbwhere == "") {
            if ($this->k172_conta != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " k172_conta = $this->k172_conta ";
            }
            if ($k172_data != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " k172_data = '$this->k172_data' ";
            }
            if ($k172_numcmg != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " k172_numcmg = $this->k172_numcmg ";
            }
            if ($k172_mov != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " k172_mov = $this->k172_mov ";
            }
            if ($k172_coddoc != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " k172_coddoc = $this->k172_coddoc ";
            }
            if ($k172_codigo != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " k172_codigo = $this->k172_codigo ";
            }
            if ($k172_valor != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " k172_valor = $this->k172_valor ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql = "Documento Automático Lançamento nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $k172_conta;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Documento Automático Lançamento nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $k172_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $k172_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao do recordset
    function sql_record($sql) {
        $result = db_query($sql);
        if  ($result == false) {
            $this->numrows = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Erro ao selecionar os registros.";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql = "Record Vazio na Tabela:conciliacaobancarialancamento";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    function sql_query($k172_conta = null, $campos = "*", $ordem = null, $dbwhere = "") {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = split("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        } else {
            $sql .= $campos;
        }
        $sql .= " from conciliacaobancarialancamento ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($k172_conta != null) {
                $sql2 .= " where conciliacaobancarialancamento.k172_conta = $k172_conta ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere ";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = split("#",$ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }

    function sql_query_file($k172_conta = null, $campos = "*", $ordem = null, $dbwhere = "") {
        $sql = "select ";
        if ($campos != "*") {
            $campos_sql = split("#", $campos);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
          }
        } else {
            $sql .= $campos;
        }
        $sql .= " from conciliacaobancarialancamento ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($k172_conta != null) {
                $sql2 .= " where conciliacaobancarialancamento.k172_conta = $k172_conta ";
            }
        } else if ($dbwhere != "") {
            $sql2 = " where $dbwhere";
        }
        $sql .= $sql2;
        if ($ordem != null) {
            $sql .= " order by ";
            $campos_sql = split("#", $ordem);
            $virgula = "";
            for ($i = 0; $i < sizeof($campos_sql); $i++) {
                $sql .= $virgula.$campos_sql[$i];
                $virgula = ",";
            }
        }
        return $sql;
    }
}
