<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete132015
class cl_balancete132015
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
    var $si180_sequencial = 0;
    var $si180_tiporegistro = 0;
    var $si180_contacontabil = 0;
    var $si180_codprograma = null;
    var $si180_idacao = null;
    var $si180_idsubacao = null;
    var $si180_saldoIniciaipa = 0;
    var $si180_naturezasaldoIniciaipa = null;
    var $si180_totaldebitospa = 0;
    var $si180_totalcreditospa = 0;
    var $si180_saldofinaipa = 0;
    var $si180_naturezasaldofinaipa = null;
    var $si180_mes = 0;
    var $si180_instit = 0;
    var $si180_reg10;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 si180_sequencial = int8 = si180_sequencial 
                 si180_tiporegistro = int8 = si180_tiporegistro 
                 si180_contacontabil = int8 = si180_contacontabil 
                 si180_codprograma = varchar(4) = si180_codprograma 
                 si180_idacao = text = si180_idacao 
                 si180_idsubacao = varchar(4) = si180_idsubacao 
                 si180_saldoIniciaipa = float8 = si180_saldoIniciaipa 
                 si180_naturezasaldoIniciaipa = varchar(1) = si180_naturezasaldoIniciaipa 
                 si180_totaldebitospa = float8 = si180_totaldebitospa 
                 si180_totalcreditospa = float8 = si180_totalcreditospa 
                 si180_saldofinaipa = float8 = si180_saldofinaipa 
                 si180_naturezasaldofinaipa = varchar(1) = si180_naturezasaldofinaipa 
                 si180_mes = int8 = si180_mes 
                 si180_instit = int8 = si180_instit 
                 ";

    //funcao construtor da classe
    function cl_balancete132015()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("balancete132015");
        $this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
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
            $this->si180_sequencial = ($this->si180_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_sequencial"] : $this->si180_sequencial);
            $this->si180_tiporegistro = ($this->si180_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_tiporegistro"] : $this->si180_tiporegistro);
            $this->si180_contacontabil = ($this->si180_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_contacontabil"] : $this->si180_contacontabil);
            $this->si180_codprograma = ($this->si180_codprograma == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_codprograma"] : $this->si180_codprograma);
            $this->si180_idacao = ($this->si180_idacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_idacao"] : $this->si180_idacao);
            $this->si180_idsubacao = ($this->si180_idsubacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_idsubacao"] : $this->si180_idsubacao);
            $this->si180_saldoIniciaipa = ($this->si180_saldoIniciaipa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_saldoIniciaipa"] : $this->si180_saldoIniciaipa);
            $this->si180_naturezasaldoIniciaipa = ($this->si180_naturezasaldoIniciaipa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_naturezasaldoIniciaipa"] : $this->si180_naturezasaldoIniciaipa);
            $this->si180_totaldebitospa = ($this->si180_totaldebitospa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_totaldebitospa"] : $this->si180_totaldebitospa);
            $this->si180_totalcreditospa = ($this->si180_totalcreditospa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_totalcreditospa"] : $this->si180_totalcreditospa);
            $this->si180_saldofinaipa = ($this->si180_saldofinaipa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_saldofinaipa"] : $this->si180_saldofinaipa);
            $this->si180_naturezasaldofinaipa = ($this->si180_naturezasaldofinaipa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_naturezasaldofinaipa"] : $this->si180_naturezasaldofinaipa);
            $this->si180_mes = ($this->si180_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_mes"] : $this->si180_mes);
            $this->si180_instit = ($this->si180_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_instit"] : $this->si180_instit);
        } else {
            $this->si180_sequencial = ($this->si180_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si180_sequencial"] : $this->si180_sequencial);
        }
    }

    // funcao para inclusao
    function incluir($si180_sequencial)
    {
        $this->atualizacampos();
        if ($this->si180_tiporegistro == null) {
            $this->erro_sql = " Campo si180_tiporegistro não informado.";
            $this->erro_campo = "si180_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_contacontabil == null) {
            $this->erro_sql = " Campo si180_contacontabil não informado.";
            $this->erro_campo = "si180_contacontabil";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_codprograma == null) {
            $this->erro_sql = " Campo si180_codprograma não informado.";
            $this->erro_campo = "si180_codprograma";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_idacao == null) {
            $this->erro_sql = " Campo si180_idacao não informado.";
            $this->erro_campo = "si180_idacao";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_saldoIniciaipa == null) {
            $this->erro_sql = " Campo si180_saldoIniciaipa não informado.";
            $this->erro_campo = "si180_saldoIniciaipa";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_naturezasaldoIniciaipa == null) {
            $this->erro_sql = " Campo si180_naturezasaldoIniciaipa não informado.";
            $this->erro_campo = "si180_naturezasaldoIniciaipa";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_totaldebitospa == null) {
            $this->erro_sql = " Campo si180_totaldebitospa não informado.";
            $this->erro_campo = "si180_totaldebitospa";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_totalcreditospa == null) {
            $this->erro_sql = " Campo si180_totalcreditospa não informado.";
            $this->erro_campo = "si180_totalcreditospa";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_saldofinaipa == null) {
            $this->erro_sql = " Campo si180_saldofinaipa não informado.";
            $this->erro_campo = "si180_saldofinaipa";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_naturezasaldofinaipa == null) {
            $this->erro_sql = " Campo si180_naturezasaldofinaipa não informado.";
            $this->erro_campo = "si180_naturezasaldofinaipa";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_mes == null) {
            $this->erro_sql = " Campo si180_mes não informado.";
            $this->erro_campo = "si180_mes";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->si180_instit == null) {
            $this->erro_sql = " Campo si180_instit não informado.";
            $this->erro_campo = "si180_instit";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->si180_idsubacao == null) {
            $this->si180_idsubacao = " ";
        }

        if ($si180_sequencial == "" || $si180_sequencial == null) {
            $result = db_query("select nextval('balancete132015_si180_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("\n", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: balancete132015_si180_sequencial_seq do campo: si180_sequencial";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->si180_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from balancete132015_si180_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $si180_sequencial)) {
                $this->erro_sql = " Campo si180_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            } else {
                $this->si180_sequencial = $si180_sequencial;
            }
        }

        if (($this->si180_sequencial == null) || ($this->si180_sequencial == "")) {
            $this->erro_sql = " Campo si180_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        $sql = "insert into balancete132015(
                                       si180_sequencial 
                                      ,si180_tiporegistro 
                                      ,si180_contacontabil 
                                      ,si180_codprograma 
                                      ,si180_idacao 
                                      ,si180_idsubacao 
                                      ,si180_saldoIniciaipa 
                                      ,si180_naturezasaldoIniciaipa 
                                      ,si180_totaldebitospa 
                                      ,si180_totalcreditospa 
                                      ,si180_saldofinaipa 
                                      ,si180_naturezasaldofinaipa 
                                      ,si180_mes 
                                      ,si180_instit
                                      ,si180_reg10
                       )
                values (
                                $this->si180_sequencial 
                               ,$this->si180_tiporegistro 
                               ,$this->si180_contacontabil 
                               ,'$this->si180_codprograma' 
                               ,'$this->si180_idacao' 
                               ,'$this->si180_idsubacao' 
                               ,$this->si180_saldoIniciaipa 
                               ,'$this->si180_naturezasaldoIniciaipa' 
                               ,$this->si180_totaldebitospa 
                               ,$this->si180_totalcreditospa 
                               ,$this->si180_saldofinaipa 
                               ,'$this->si180_naturezasaldofinaipa' 
                               ,$this->si180_mes 
                               ,$this->si180_instit
                               ,$this->si180_reg10
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "balancete132015 ($this->si180_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_banco = "balancete132015 já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            } else {
                $this->erro_sql = "balancete132015 ($this->si180_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si180_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))
        ) {

            $resaco = $this->sql_record($this->sql_query_file($this->si180_sequencial));
            if (($resaco != false) || ($this->numrows != 0)) {

                /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac,0,0);
                $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                $resac = db_query("insert into db_acountkey values($acount,2011746,'$this->si180_sequencial','I')");
                $resac = db_query("insert into db_acount values($acount,1010195,2011746,'','".AddSlashes(pg_result($resaco,0,'si180_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011747,'','".AddSlashes(pg_result($resaco,0,'si180_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011748,'','".AddSlashes(pg_result($resaco,0,'si180_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011749,'','".AddSlashes(pg_result($resaco,0,'si180_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011750,'','".AddSlashes(pg_result($resaco,0,'si180_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011751,'','".AddSlashes(pg_result($resaco,0,'si180_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011752,'','".AddSlashes(pg_result($resaco,0,'si180_saldoIniciaipa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011753,'','".AddSlashes(pg_result($resaco,0,'si180_naturezasaldoIniciaipa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011754,'','".AddSlashes(pg_result($resaco,0,'si180_totaldebitospa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011755,'','".AddSlashes(pg_result($resaco,0,'si180_totalcreditospa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011756,'','".AddSlashes(pg_result($resaco,0,'si180_saldofinaipa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011757,'','".AddSlashes(pg_result($resaco,0,'si180_naturezasaldofinaipa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011758,'','".AddSlashes(pg_result($resaco,0,'si180_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                $resac = db_query("insert into db_acount values($acount,1010195,2011759,'','".AddSlashes(pg_result($resaco,0,'si180_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
            }
        }
        return true;
    }

    // funcao para alteracao
    function alterar($si180_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update balancete132015 set ";
        $virgula = "";
        if (trim($this->si180_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_sequencial"])) {
            $sql .= $virgula . " si180_sequencial = $this->si180_sequencial ";
            $virgula = ",";
            if (trim($this->si180_sequencial) == null) {
                $this->erro_sql = " Campo si180_sequencial não informado.";
                $this->erro_campo = "si180_sequencial";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_tiporegistro"])) {
            $sql .= $virgula . " si180_tiporegistro = $this->si180_tiporegistro ";
            $virgula = ",";
            if (trim($this->si180_tiporegistro) == null) {
                $this->erro_sql = " Campo si180_tiporegistro não informado.";
                $this->erro_campo = "si180_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_contacontabil"])) {
            $sql .= $virgula . " si180_contacontabil = $this->si180_contacontabil ";
            $virgula = ",";
            if (trim($this->si180_contacontabil) == null) {
                $this->erro_sql = " Campo si180_contacontabil não informado.";
                $this->erro_campo = "si180_contacontabil";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_codprograma) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_codprograma"])) {
            $sql .= $virgula . " si180_codprograma = '$this->si180_codprograma' ";
            $virgula = ",";
            if (trim($this->si180_codprograma) == null) {
                $this->erro_sql = " Campo si180_codprograma não informado.";
                $this->erro_campo = "si180_codprograma";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_idacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_idacao"])) {
            $sql .= $virgula . " si180_idacao = '$this->si180_idacao' ";
            $virgula = ",";
            if (trim($this->si180_idacao) == null) {
                $this->erro_sql = " Campo si180_idacao não informado.";
                $this->erro_campo = "si180_idacao";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_idsubacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_idsubacao"])) {
            $sql .= $virgula . " si180_idsubacao = '$this->si180_idsubacao' ";
            $virgula = ",";
        }
        if (trim($this->si180_saldoIniciaipa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_saldoIniciaipa"])) {
            $sql .= $virgula . " si180_saldoIniciaipa = $this->si180_saldoIniciaipa ";
            $virgula = ",";
            if (trim($this->si180_saldoIniciaipa) == null) {
                $this->erro_sql = " Campo si180_saldoIniciaipa não informado.";
                $this->erro_campo = "si180_saldoIniciaipa";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_naturezasaldoIniciaipa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_naturezasaldoIniciaipa"])) {
            $sql .= $virgula . " si180_naturezasaldoIniciaipa = '$this->si180_naturezasaldoIniciaipa' ";
            $virgula = ",";
            if (trim($this->si180_naturezasaldoIniciaipa) == null) {
                $this->erro_sql = " Campo si180_naturezasaldoIniciaipa não informado.";
                $this->erro_campo = "si180_naturezasaldoIniciaipa";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_totaldebitospa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_totaldebitospa"])) {
            $sql .= $virgula . " si180_totaldebitospa = $this->si180_totaldebitospa ";
            $virgula = ",";
            if (trim($this->si180_totaldebitospa) == null) {
                $this->erro_sql = " Campo si180_totaldebitospa não informado.";
                $this->erro_campo = "si180_totaldebitospa";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_totalcreditospa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_totalcreditospa"])) {
            $sql .= $virgula . " si180_totalcreditospa = $this->si180_totalcreditospa ";
            $virgula = ",";
            if (trim($this->si180_totalcreditospa) == null) {
                $this->erro_sql = " Campo si180_totalcreditospa não informado.";
                $this->erro_campo = "si180_totalcreditospa";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_saldofinaipa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_saldofinaipa"])) {
            $sql .= $virgula . " si180_saldofinaipa = $this->si180_saldofinaipa ";
            $virgula = ",";
            if (trim($this->si180_saldofinaipa) == null) {
                $this->erro_sql = " Campo si180_saldofinaipa não informado.";
                $this->erro_campo = "si180_saldofinaipa";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_naturezasaldofinaipa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_naturezasaldofinaipa"])) {
            $sql .= $virgula . " si180_naturezasaldofinaipa = '$this->si180_naturezasaldofinaipa' ";
            $virgula = ",";
            if (trim($this->si180_naturezasaldofinaipa) == null) {
                $this->erro_sql = " Campo si180_naturezasaldofinaipa não informado.";
                $this->erro_campo = "si180_naturezasaldofinaipa";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_mes"])) {
            $sql .= $virgula . " si180_mes = $this->si180_mes ";
            $virgula = ",";
            if (trim($this->si180_mes) == null) {
                $this->erro_sql = " Campo si180_mes não informado.";
                $this->erro_campo = "si180_mes";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->si180_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si180_instit"])) {
            $sql .= $virgula . " si180_instit = $this->si180_instit ";
            $virgula = ",";
            if (trim($this->si180_instit) == null) {
                $this->erro_sql = " Campo si180_instit não informado.";
                $this->erro_campo = "si180_instit";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        $sql .= " where ";
        if ($si180_sequencial != null) {
            $sql .= " si180_sequencial = $this->si180_sequencial";
        }
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))
        ) {

            $resaco = $this->sql_record($this->sql_query_file($this->si180_sequencial));
            if ($this->numrows > 0) {

                for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

                    /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac,0,0);
                    $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                    $resac = db_query("insert into db_acountkey values($acount,2011746,'$this->si180_sequencial','A')");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_sequencial"]) || $this->si180_sequencial != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011746,'".AddSlashes(pg_result($resaco,$conresaco,'si180_sequencial'))."','$this->si180_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_tiporegistro"]) || $this->si180_tiporegistro != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011747,'".AddSlashes(pg_result($resaco,$conresaco,'si180_tiporegistro'))."','$this->si180_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_contacontabil"]) || $this->si180_contacontabil != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011748,'".AddSlashes(pg_result($resaco,$conresaco,'si180_contacontabil'))."','$this->si180_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_codprograma"]) || $this->si180_codprograma != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011749,'".AddSlashes(pg_result($resaco,$conresaco,'si180_codprograma'))."','$this->si180_codprograma',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_idacao"]) || $this->si180_idacao != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011750,'".AddSlashes(pg_result($resaco,$conresaco,'si180_idacao'))."','$this->si180_idacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_idsubacao"]) || $this->si180_idsubacao != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011751,'".AddSlashes(pg_result($resaco,$conresaco,'si180_idsubacao'))."','$this->si180_idsubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_saldoIniciaipa"]) || $this->si180_saldoIniciaipa != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011752,'".AddSlashes(pg_result($resaco,$conresaco,'si180_saldoIniciaipa'))."','$this->si180_saldoIniciaipa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_naturezasaldoIniciaipa"]) || $this->si180_naturezasaldoIniciaipa != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011753,'".AddSlashes(pg_result($resaco,$conresaco,'si180_naturezasaldoIniciaipa'))."','$this->si180_naturezasaldoIniciaipa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_totaldebitospa"]) || $this->si180_totaldebitospa != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011754,'".AddSlashes(pg_result($resaco,$conresaco,'si180_totaldebitospa'))."','$this->si180_totaldebitospa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_totalcreditospa"]) || $this->si180_totalcreditospa != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011755,'".AddSlashes(pg_result($resaco,$conresaco,'si180_totalcreditospa'))."','$this->si180_totalcreditospa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_saldofinaipa"]) || $this->si180_saldofinaipa != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011756,'".AddSlashes(pg_result($resaco,$conresaco,'si180_saldofinaipa'))."','$this->si180_saldofinaipa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_naturezasaldofinaipa"]) || $this->si180_naturezasaldofinaipa != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011757,'".AddSlashes(pg_result($resaco,$conresaco,'si180_naturezasaldofinaipa'))."','$this->si180_naturezasaldofinaipa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_mes"]) || $this->si180_mes != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011758,'".AddSlashes(pg_result($resaco,$conresaco,'si180_mes'))."','$this->si180_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    if(isset($GLOBALS["HTTP_POST_VARS"]["si180_instit"]) || $this->si180_instit != "")
                      $resac = db_query("insert into db_acount values($acount,1010195,2011759,'".AddSlashes(pg_result($resaco,$conresaco,'si180_instit'))."','$this->si180_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
                }
            }
        }
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "balancete132015 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : " . $this->si180_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "balancete132015 nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : " . $this->si180_sequencial;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $this->si180_sequencial;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($si180_sequencial = null, $dbwhere = null)
    {

        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))
        ) {

            if ($dbwhere == null || $dbwhere == "") {

                $resaco = $this->sql_record($this->sql_query_file($si180_sequencial));
            } else {
                $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
            }
            if (($resaco != false) || ($this->numrows != 0)) {

                for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

                    /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
                    $acount = pg_result($resac,0,0);
                    $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                    $resac  = db_query("insert into db_acountkey values($acount,2011746,'$si180_sequencial','E')");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011746,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011747,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011748,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011749,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011750,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011751,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011752,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_saldoIniciaipa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011753,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_naturezasaldoIniciaipa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011754,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_totaldebitospa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011755,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_totalcreditospa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011756,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_saldofinaipa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011757,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_naturezasaldofinaipa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011758,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                    $resac  = db_query("insert into db_acount values($acount,1010195,2011759,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
                }
            }
        }
        $sql = " delete from balancete132015
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($si180_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " si180_sequencial = $si180_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql = "balancete132015 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : " . $si180_sequencial;
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "balancete132015 nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : " . $si180_sequencial;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : " . $si180_sequencial;
                $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
            $this->erro_sql = "Record Vazio na Tabela:balancete132015";
            $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query($si180_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from balancete132015 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si180_sequencial != null) {
                $sql2 .= " where balancete132015.si180_sequencial = $si180_sequencial ";
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

    // funcao do sql
    function sql_query_file($si180_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from balancete132015 ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($si180_sequencial != null) {
                $sql2 .= " where balancete132015.si180_sequencial = $si180_sequencial ";
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

?>
