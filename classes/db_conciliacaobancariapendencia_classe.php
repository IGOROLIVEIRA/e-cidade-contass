<?
// MODULO: Caixa
// CLASSE DA ENTIDADE conciliacaobancariapendencia
class cl_conciliacaobancariapendencia
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
    var $k173_conta = 0;
    var $k173_tipolancamento = 0;
    var $k173_mov = 0;
    var $k173_tipomovimento = 0;
    var $k173_numcgm = 0;
    var $k173_codigo = null;
    var $k173_documento = null;
    var $k173_data = null;
    var $k173_valor = 0;
    var $k173_dataconciliacao = null;

    // cria propriedade com as variaveis do arquivo
    var $campos = "
        k173_conta = int8 = Numero da Conta
        k173_data = date = Data do Lançamento
        k173_numcmg = int8 = Numero do CGM
        k173_codigo = varchar(255) = Codigo do Lancamento
        k173_documento = varchar(255) = Codigo do Documento
        k173_valor = float8 = Valor Conciliado
        k173_dataconciliacao = date = Data da Conciliado
        k173_mov = int8 = Entrada ou saida
        k173_tipolancamento = int8 = Entrada ou saida
        k173_tipomovimento = int8 = Entrada ou saida
        k173_historico = text = Historico
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
            $this->k173_conta = ($this->k173_conta == "" ? @$GLOBALS["HTTP_POST_VARS"]["k173_conta"]:$this->k173_conta);
            if ($this->k173_data == "") {
                $this->k173_data_dia = ($this->k173_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k173_data_dia"]:$this->k173_data_dia);
                $this->k173_data_mes = ($this->k173_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k173_data_mes"]:$this->k173_data_mes);
                $this->k173_data_ano = ($this->k173_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k173_data_ano"]:$this->k173_data_ano);
                if ($this->k173_data_dia != "") {
                    $this->k173_data = $this->k173_data_ano."-".$this->k173_data_mes."-".$this->k173_data_dia;
                }
            }
            $this->k173_numcmg = ($this->k173_numcmg == "" ? @$GLOBALS["HTTP_POST_VARS"]["k173_conta"]:$this->k173_numcmg);
            $this->k173_codigo = ($this->k173_codigo == "" ? @$GLOBALS["HTTP_POST_VARS"]["k173_conta"]:$this->k173_codigo);
            $this->k173_documento = ($this->k173_documento == "" ? @$GLOBALS["HTTP_POST_VARS"]["k173_conta"]:$this->k173_documento);
            $this->k173_valor = ($this->k173_valor == "" ? @$GLOBALS["HTTP_POST_VARS"]["k173_valor"]:$this->k173_valor);
            $this->k173_mov = ($this->k173_mov == "" ? @$GLOBALS["HTTP_POST_VARS"]["k173_mov"]:$this->k173_mov);
            $this->k173_tipolancamento = ($this->k173_tipolancamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["k173_tipolancamento"]:$this->k173_tipolancamento);
            $this->k173_tipomovimento = ($this->k173_tipomovimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["k173_tipomovimento"]:$this->k173_tipomovimento);
            $this->k173_historico = ($this->k173_historico == "" ? @$GLOBALS["HTTP_POST_VARS"]["k173_historico"]:$this->k173_historico);
            if ($this->k173_dataconciliacao == "") {
                $this->k173_data_conciliacao_dia = ($this->k173_data_conciliacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k173_data_conciliacao_dia"]:$this->k173_data_conciliacao_dia);
                $this->k173_data_conciliacao_mes = ($this->k173_data_conciliacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k173_data_conciliacao_mes"]:$this->k173_data_conciliacao_mes);
                $this->k173_data_conciliacao_ano = ($this->k173_data_conciliacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k173_data_conciliacao_ano"]:$this->k173_data_conciliacao_ano);
                if ($this->k173_data_conciliacao_dia != "") {
                    $this->k173_dataconciliacao = $this->k173_data_conciliacao_ano."-".$this->k173_data_conciliacao_mes."-".$this->k173_data_conciliacao_dia;
                }
            }
        } else {
            $this->k173_conta = ($this->k173_conta == ""?@$GLOBALS["HTTP_POST_VARS"]["k173_conta"]:$this->k173_conta);
        }
    }

    // funcao para inclusao
    function incluir() {
        $this->atualizacampos();
        if (($this->k173_conta == null) || ($this->k173_conta == "")) {
            $this->erro_sql = " Campo k173_conta não declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k173_data == null) {
            $this->erro_sql = " Campo Data não Informado.";
            $this->erro_campo = "k173_data_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k173_mov == null) {
            $this->erro_sql = " Campo Movimentação não Informado.";
            $this->erro_campo = "k173_mov";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k173_tipolancamento == null) {
            $this->erro_sql = " Campo Tipo de Lançamento não Informado.";
            $this->erro_campo = "k173_tipolancamento";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k173_historico == null) {
            $this->erro_sql = " Campo Historico nao Informado.";
            $this->erro_campo = "k173_historico";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->k173_valor == null) {
            $this->erro_sql = " Campo Valor não Informado.";
            $this->erro_campo = "k173_valor";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into conciliacaobancariapendencia (k173_conta, k173_data, k173_numcgm, k173_codigo, k173_documento,k173_valor, k173_dataconciliacao, k173_mov, k173_tipolancamento, k173_tipomovimento, k173_historico) values ($this->k173_conta, " . ($this->k173_data == "null" || $this->k173_data == "" ? "null" : "'" . $this->k173_data . "'") . ", " . ($this->k173_numcgm != "" ? $this->k173_numcgm : 'null') . "," .  ($this->k173_codigo == "" ? 'null' : "'{$this->k173_codigo}'") . ", " . ($this->k173_documento == "" ? "null" : "'{$this->k173_documento}'") . ", $this->k173_valor, " . ($this->k173_dataconciliacao == "null" || $this->k173_dataconciliacao == "" ? "null" : "'" . $this->k173_dataconciliacao . "'") . ", {$this->k173_mov}, {$this->k173_tipolancamento}, '{$this->k173_tipomovimento}', '{$this->k173_historico}')";
        $result = db_query($sql);

        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql   = "Conciliacao Bancaria para o Lancamento da conta ({$this->k173_conta}) nao Incluido. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "Documento Automático Lançamento já Cadastrado";
                $this->erro_msg  .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql   = "Conciliacao Bancaria para o Lancamento da conta ({$this->k173_conta}) nao Incluido. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg  .=  str_replace('"', "",str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_msg  =  $sql;
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql  = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->k173_conta;
        $this->erro_msg  = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (isset($lSessaoDesativarAccount) && $lSessaoDesativarAccount === false) {
            $resaco = $this->sql_record($this->sql_query_file($this->k173_conta));
            if (($resaco != false) || ($this->numrows != 0)) {
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount, " . db_getsession("DB_acessado"). ")");
                $resac = db_query("insert into db_acountkey values($acount, 5213, '$this->k173_conta', 'I')");
                $resac = db_query("insert into db_acount values($acount, 764, 5213, '', '" . AddSlashes(pg_result($resaco, 0, 'k173_conta')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5214, '', '" . AddSlashes(pg_result($resaco, 0, 'k173_data')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k173_numcgm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k173_codigo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k173_documento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k173_valor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, 0, 'k173_dataconciliacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }
        return true;
    }

    // funcao para alteracao
    function alterar() {
        $this->atualizacampos();
        $sql = " update conciliacaobancariapendencia set ";
        $virgula = "";
        if (trim($this->k173_conta) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_conta"])) {
            $sql .= $virgula . " k173_conta = $this->k173_conta ";
            $virgula = ",";
            if (trim($this->k173_conta) == null) {
                $this->erro_sql = " Campo Código Lançamento não Informado.";
                $this->erro_campo = "k173_conta";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k173_valor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_valor"])) {
            $sql .= $virgula." k173_valor = $this->k173_valor ";
            $virgula = ",";
            if (trim($this->k173_valor) == null) {
                $this->erro_sql = " Campo Código não Informado.";
                $this->erro_campo = "k173_valor";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k173_numcgm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_numcgm"])) {
            $sql .= $virgula." k173_numcgm = $this->k173_numcgm ";
            $virgula = ",";
            if (trim($this->k173_numcgm) == null) {
                $this->erro_sql = " Campo Código não Informado.";
                $this->erro_campo = "k173_numcgm";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k173_codigo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_codigo"])) {
            $sql .= $virgula." k173_codigo = '{$this->k173_codigo}' ";
            $virgula = ",";
            if (trim($this->k173_codigo) == null) {
                $this->erro_sql = " Campo Código não Informado.";
                $this->erro_campo = "k173_codigo";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k173_documento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_documento"])) {
            $sql .= $virgula." k173_documento = '{$this->k173_documento}' ";
            $virgula = ",";
            if (trim($this->k173_documento) == null) {
                $this->erro_sql = " Campo Documento não Informado.";
                $this->erro_campo = "k173_documento";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k173_mov) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_mov"])) {
            $sql .= $virgula." k173_mov = $this->k173_mov ";
            $virgula = ",";
            if (trim($this->k173_mov) == null) {
                $this->erro_sql = " Campo Mov. não Informado.";
                $this->erro_campo = "k173_mov";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k173_tipolancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_tipolancamento"])) {
            $sql .= $virgula." k173_tipolancamento = $this->k173_tipolancamento ";
            $virgula = ",";
            if (trim($this->k173_tipolancamento) == null) {
                $this->erro_sql = " Campo Mov. não Informado.";
                $this->erro_campo = "k173_tipolancamento";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k173_tipomovimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_tipomovimento"])) {
            $sql .= $virgula." k173_tipomovimento = '$this->k173_tipomovimento' ";
            $virgula = ",";
            if (trim($this->k173_tipomovimento) == null) {
                $this->erro_sql = " Campo Mov. não Informado.";
                $this->erro_campo = "k173_tipomovimento";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k173_historico) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_historico"])) {
            $sql .= $virgula." k173_historico = '$this->k173_historico' ";
            $virgula = ",";
            if (trim($this->k173_historico) == null) {
                $this->erro_sql = " Campo Historico não Informado.";
                $this->erro_campo = "k173_historico";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->k173_data) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k173_data_dia"] != "")) {
            $sql .= $virgula." k173_data = '$this->k173_data' ";
            $virgula = ",";
            if (trim($this->k173_data) == null) {
                $this->erro_sql = " Campo Data não Informado.";
                $this->erro_campo = "k173_data_dia";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["k173_data_dia"])) {
                $sql .= $virgula . " k173_data = null ";
                $virgula = ",";
                if (trim($this->k173_data) == null) {
                    $this->erro_sql = " Campo Data não Informado.";
                    $this->erro_campo = "k173_data_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }

        if (trim($this->k173_dataconciliacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["k173_data_conciliacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k173_data_conciliacao_dia"] != "")) {
            $sql .= $virgula." k173_dataconciliacao = '$this->k173_dataconciliacao' ";
            $virgula = ",";
            if (trim($this->k173_dataconciliacao) == null) {
                $this->erro_sql = " Campo Data não Informado.";
                $this->erro_campo = "k173_data_conciliacao_dia";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        } else {
            if (isset($GLOBALS["HTTP_POST_VARS"]["k173_data_conciliacao_dia"])) {
                $sql .= $virgula . " k173_dataconciliacao = null ";
                $virgula = ",";
                if (trim($this->k173_dataconciliacao) == null) {
                    $this->erro_sql = " Campo Data da Conciliação não Informado.";
                    $this->erro_campo = "k173_data_conciliacao_dia";
                    $this->erro_banco = "";
                    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                    $this->erro_status = "0";
                    return false;
                }
            }
        }

        $sql .= " where ";
        if ($this->k173_sequencial != null) {
            $sql .= " k173_sequencial = $this->k173_sequencial ";
        }

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (isset($lSessaoDesativarAccount) && $lSessaoDesativarAccount === false) {
            $resaco = $this->sql_record($this->sql_query_file($this->k173_conta));
            if ($this->numrows > 0) {
                for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac, 0, 0);
                    $resac = db_query("insert into db_acountacesso values($acount, " . db_getsession("DB_acessado") . ")");
                    $resac = db_query("insert into db_acountkey values($acount, 5213, '$this->k173_conta', 'A')");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["k173_conta"]))
                        $resac = db_query("insert into db_acount values($acount, 764, 5213, '" . AddSlashes(pg_result($resaco, $conresaco, 'k173_conta')) . "', '$this->k173_conta', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["k173_valor"]))
                        $resac = db_query("insert into db_acount values($acount, 764, 5214, '" . AddSlashes(pg_result($resaco, $conresaco, 'k173_valor')) . "', '$this->k173_valor', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    if (isset($GLOBALS["HTTP_POST_VARS"]["k173_data"]))
                        $resac = db_query("insert into db_acount values($acount, 764, 5898, '" . AddSlashes(pg_result($resaco, $conresaco, 'k173_data')) . "', '$this->k173_data', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                }
            }
        }
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "Documento Automático Lançamento nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->k173_conta;
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
                $this->erro_sql .= "Valores : " . $this->k173_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_msg = $sql;
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->k173_conta;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql." \\n\\n";
                $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($k173_sequencial = null, $dbwhere = null) {
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (isset($lSessaoDesativarAccount) && $lSessaoDesativarAccount === false) {
            if ($dbwhere == null || $dbwhere == "") {
                $resaco = $this->sql_record($this->sql_query_file($k173_sequencial));
            } else {
                $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
            }

            if (($resaco != false) || ($this->numrows != 0)) {
                for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
                    $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac, 0, 0);
                    $resac = db_query("insert into db_acountacesso values($acount, ". db_getsession("DB_acessado") . ")");
                    $resac = db_query("insert into db_acountkey values($acount, 5213, '$k173_sequencial', 'E')");
                    $resac = db_query("insert into db_acount values($acount, 764, 5213, '', '" . AddSlashes(pg_result($resaco, $iresaco, 'k173_conta')) . "', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount, 764, 5214, '', '" . AddSlashes(pg_result($resaco, $iresaco, 'k173_valor')) . "', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                    $resac = db_query("insert into db_acount values($acount, 764, 5898, '', '" . AddSlashes(pg_result($resaco, $iresaco, 'k173_data')) . "', " . db_getsession('DB_datausu') . ", " . db_getsession('DB_id_usuario') . ")");
                }
            }
        }
        $sql = " delete from conciliacaobancariapendencia where ";
        $sql2 = "";
        if  ($dbwhere == null || $dbwhere == "") {
            if ($k173_sequencial != null) {
                $sql2 .= " conciliacaobancariapendencia.k173_sequencial = $k173_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql = "Documento Automático Lançamento nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $k173_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_msg = $sql;
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "Documento Automático Lançamento nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $k173_sequencial;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $k173_sequencial;
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
            $this->erro_sql = "Record Vazio na Tabela:conciliacaobancariapendencia";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .=  str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    function sql_query($k173_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "") {
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
        $sql .= " from conciliacaobancariapendencia ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($k173_sequencial != null) {
                $sql2 .= " where conciliacaobancariapendencia.k173_sequencial = $k173_sequencial ";
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

    function sql_query_file($k173_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "") {
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
        $sql .= " from conciliacaobancariapendencia ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($k173_sequencial != null) {
                $sql2 .= " where conciliacaobancariapendencia.k173_sequencial = $k173_sequencial ";
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
