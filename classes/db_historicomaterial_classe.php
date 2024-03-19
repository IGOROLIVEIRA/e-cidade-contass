<?
//MODULO: sicom
//CLASSE DA ENTIDADE historico material
class cl_historicomaterial
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
    var $db150_sequencial = 0;
    var $db150_tiporegistro = 0;
    var $db150_coditem = 0;
    var $db150_pcmater  = 0;
    var $db150_dscitem = null;
    var $db150_unidademedida = null;
    var $db150_tipocadastro = 0;
    var $db150_justificativaalteracao = null;
    var $db150_mes = 0;
    var $db150_data = null;
    var $db150_instit = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 db150_sequencial = int8 = sequencial
                 db150_tiporegistro = int8 = Tipo do registro
                 db150_coditem = int8 = Código do Item
                 db150_pcmater = int8 = codigo pcmater
                 db150_dscitem = varchar(250) = Descrição do Item
                 db150_unidademedida = varchar(50) = Descrição da unidade de medida
                 db150_tipocadastro = int8 = Tipo de  Cadastro
                 db150_justificativaalteracao = varchar(100) = Justificativa  para a  alteração
                 db150_mes = int8 = Mês
                 db150_data = date = data de cadastro
                 db150_instit = int8 = Instituição
                 ";

    //funcao construtor da classe
    function cl_historicomaterial()
    {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("historicomaterial");
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
            $this->db150_sequencial = ($this->db150_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_sequencial"] : $this->db150_sequencial);
            $this->db150_tiporegistro = ($this->db150_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_tiporegistro"] : $this->db150_tiporegistro);
            $this->db150_coditem = ($this->db150_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_coditem"] : $this->db150_coditem);
            $this->db150_pcmater = ($this->db150_pcmater == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_pcmater"] : $this->db150_pcmater);
            $this->db150_dscitem = ($this->db150_dscitem == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_dscitem"] : $this->db150_dscitem);
            $this->db150_unidademedida = ($this->db150_unidademedida == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_unidademedida"] : $this->db150_unidademedida);
            $this->db150_tipocadastro = ($this->db150_tipocadastro == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_tipocadastro"] : $this->db150_tipocadastro);
            $this->db150_justificativaalteracao = ($this->db150_justificativaalteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_justificativaalteracao"] : $this->db150_justificativaalteracao);
            $this->db150_mes = ($this->db150_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_mes"] : $this->db150_mes);
            $this->db150_data = ($this->db150_data == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_data"] : $this->db150_data);
            $this->db150_instit = ($this->db150_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_instit"] : $this->db150_instit);
        } else {
            $this->db150_sequencial = ($this->db150_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["db150_sequencial"] : $this->db150_sequencial);
        }
    }

    // funcao para inclusao
    function incluir($db150_sequencial)
    {
        $this->atualizacampos();
        if ($this->db150_tiporegistro == null) {
            $this->erro_sql = " Campo Tipo do registro nao Informado.";
            $this->erro_campo = "db150_tiporegistro";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        if ($this->db150_coditem == null) {
            $this->db150_coditem = "0";
        }
        if ($this->db150_tipocadastro == null) {
            $this->db150_tipocadastro = "0";
        }
        if ($this->db150_mes == null) {
            $this->erro_sql = " Campo Mês nao Informado.";
            $this->erro_campo = "db150_mes";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        if ($this->db150_instit == null) {
            $this->erro_sql = " Campo Instituição nao Informado.";
            $this->erro_campo = "db150_instit";
            $this->erro_banco = "";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        if ($db150_sequencial == "" || $db150_sequencial == null) {
            $result = db_query("select nextval('historicomaterial_db150_sequencial_seq')");
            if ($result == false) {
                $this->erro_banco = str_replace("", "", @pg_last_error());
                $this->erro_sql = "Verifique o cadastro da sequencia: historicomaterial_db150_sequencial_seq do campo: db150_sequencial";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
            $this->db150_sequencial = pg_result($result, 0, 0);
        } else {
            $result = db_query("select last_value from historicomaterial_db150_sequencial_seq");
            if (($result != false) && (pg_result($result, 0, 0) < $db150_sequencial)) {
                $this->erro_sql = " Campo db150_sequencial maior que último número da sequencia.";
                $this->erro_banco = "Sequencia menor que este número.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            } else {
                $this->db150_sequencial = $db150_sequencial;
            }
        }
        if (($this->db150_sequencial == null) || ($this->db150_sequencial == "")) {
            $this->erro_sql = " Campo db150_sequencial nao declarado.";
            $this->erro_banco = "Chave Primaria zerada.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $sql = "insert into historicomaterial(
                                       db150_sequencial
                                      ,db150_tiporegistro
                                      ,db150_coditem
                                      ,db150_pcmater
                                      ,db150_dscitem
                                      ,db150_unidademedida
                                      ,db150_tipocadastro
                                      ,db150_justificativaalteracao
                                      ,db150_mes
                                      ,db150_data
                                      ,db150_instit
                       )
                values (
                                $this->db150_sequencial
                               ,$this->db150_tiporegistro
                               ,$this->db150_coditem
                               ,$this->db150_pcmater
                               ,'$this->db150_dscitem'
                               ,'$this->db150_unidademedida'
                               ,$this->db150_tipocadastro
                               ,'$this->db150_justificativaalteracao'
                               ,$this->db150_mes
                               ,'$this->db150_data'
                               ,$this->db150_instit
                      )";
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
                $this->erro_sql = "historicomaterial ($this->db150_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_banco = "historicomaterial já Cadastrado";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            } else {
                $this->erro_sql = "historicomaterial ($this->db150_sequencial) nao Incluído. Inclusao Abortada.";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir = 0;

            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->db150_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_incluir = pg_affected_rows($result);
        $resaco = $this->sql_record($this->sql_query_file($this->db150_sequencial));
        if (($resaco != false) || ($this->numrows != 0)) {
            $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
            $acount = pg_result($resac, 0, 0);
            $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
            $resac = db_query("insert into db_acountkey values($acount,2009822,'$this->db150_sequencial','I')");
            $resac = db_query("insert into db_acount values($acount,2010272,2009822,'','" . AddSlashes(pg_result($resaco, 0, 'db150_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010272,2009823,'','" . AddSlashes(pg_result($resaco, 0, 'db150_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010272,2009825,'','" . AddSlashes(pg_result($resaco, 0, 'db150_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010272,2009826,'','" . AddSlashes(pg_result($resaco, 0, 'db150_dscitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010272,2009827,'','" . AddSlashes(pg_result($resaco, 0, 'db150_unidademedida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010272,2011308,'','" . AddSlashes(pg_result($resaco, 0, 'db150_tipocadastro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010272,2011309,'','" . AddSlashes(pg_result($resaco, 0, 'db150_justificativaalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010272,2009828,'','" . AddSlashes(pg_result($resaco, 0, 'db150_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            $resac = db_query("insert into db_acount values($acount,2010272,2011557,'','" . AddSlashes(pg_result($resaco, 0, 'db150_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }

        return true;
    }

    // funcao para alteracao
    function alterar($db150_sequencial = null)
    {
        $this->atualizacampos();
        $sql = " update historicomaterial set ";
        $virgula = "";
        if (trim($this->db150_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_sequencial"])) {
            if (trim($this->db150_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["db150_sequencial"])) {
                $this->db150_sequencial = "0";
            }
            $sql .= $virgula . " db150_sequencial = $this->db150_sequencial ";
            $virgula = ",";
        }
        if (trim($this->db150_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_tiporegistro"])) {
            $sql .= $virgula . " db150_tiporegistro = $this->db150_tiporegistro ";
            $virgula = ",";
            if (trim($this->db150_tiporegistro) == null) {
                $this->erro_sql = " Campo Tipo do registro nao Informado.";
                $this->erro_campo = "db150_tiporegistro";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
        }
        if (trim($this->db150_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_coditem"])) {
            if (trim($this->db150_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["db150_coditem"])) {
                $this->db150_coditem = "0";
            }
            $sql .= $virgula . " db150_coditem = $this->db150_coditem ";
            $virgula = ",";
        }
        if (trim($this->db150_dscitem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_dscitem"])) {
            $sql .= $virgula . " db150_dscitem = '$this->db150_dscitem' ";
            $virgula = ",";
        }
        if (trim($this->db150_unidademedida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_unidademedida"])) {
            $sql .= $virgula . " db150_unidademedida = '$this->db150_unidademedida' ";
            $virgula = ",";
        }
        if (trim($this->db150_tipocadastro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_tipocadastro"])) {
            if (trim($this->db150_tipocadastro) == "" && isset($GLOBALS["HTTP_POST_VARS"]["db150_tipocadastro"])) {
                $this->db150_tipocadastro = "0";
            }
            $sql .= $virgula . " db150_tipocadastro = $this->db150_tipocadastro ";
            $virgula = ",";
        }
        if (trim($this->db150_justificativaalteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_justificativaalteracao"])) {
            $sql .= $virgula . " db150_justificativaalteracao = '$this->db150_justificativaalteracao' ";
            $virgula = ",";
        }
        if (trim($this->db150_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_mes"])) {
            $sql .= $virgula . " db150_mes = $this->db150_mes ";
            $virgula = ",";
            if (trim($this->db150_mes) == null) {
                $this->erro_sql = " Campo Mês nao Informado.";
                $this->erro_campo = "db150_mes";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
        }

        if (trim($this->db150_data) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_data"])) {
            $sql .= $virgula . " db150_data = '$this->db150_data' ";
            $virgula = ",";
        }else{
            $sql .= $virgula . " db150_data = 'null' ";
        }

        if (trim($this->db150_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["db150_instit"])) {
            $sql .= $virgula . " db150_instit = $this->db150_instit ";
            $virgula = ",";
            if (trim($this->db150_instit) == null) {
                $this->erro_sql = " Campo Instituição nao Informado.";
                $this->erro_campo = "db150_instit";
                $this->erro_banco = "";
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "0";

                return false;
            }
        }
        $sql .= " where ";
        if ($db150_sequencial != null) {
            $sql .= " db150_sequencial = $this->db150_sequencial";
        }
        $resaco = $this->sql_record($this->sql_query_file($this->db150_sequencial));
        if ($this->numrows > 0) {
            for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac, 0, 0);
                $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
                $resac = db_query("insert into db_acountkey values($acount,2009822,'$this->db150_sequencial','A')");
                if (isset($GLOBALS["HTTP_POST_VARS"]["db150_sequencial"]) || $this->db150_sequencial != "")
                    $resac = db_query("insert into db_acount values($acount,2010272,2009822,'" . AddSlashes(pg_result($resaco, $conresaco, 'db150_sequencial')) . "','$this->db150_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["db150_tiporegistro"]) || $this->db150_tiporegistro != "")
                    $resac = db_query("insert into db_acount values($acount,2010272,2009823,'" . AddSlashes(pg_result($resaco, $conresaco, 'db150_tiporegistro')) . "','$this->db150_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["db150_coditem"]) || $this->db150_coditem != "")
                    $resac = db_query("insert into db_acount values($acount,2010272,2009825,'" . AddSlashes(pg_result($resaco, $conresaco, 'db150_coditem')) . "','$this->db150_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["db150_dscitem"]) || $this->db150_dscitem != "")
                    $resac = db_query("insert into db_acount values($acount,2010272,2009826,'" . AddSlashes(pg_result($resaco, $conresaco, 'db150_dscitem')) . "','$this->db150_dscitem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["db150_unidademedida"]) || $this->db150_unidademedida != "")
                    $resac = db_query("insert into db_acount values($acount,2010272,2009827,'" . AddSlashes(pg_result($resaco, $conresaco, 'db150_unidademedida')) . "','$this->db150_unidademedida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["db150_tipocadastro"]) || $this->db150_tipocadastro != "")
                    $resac = db_query("insert into db_acount values($acount,2010272,2011308,'" . AddSlashes(pg_result($resaco, $conresaco, 'db150_tipocadastro')) . "','$this->db150_tipocadastro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["db150_justificativaalteracao"]) || $this->db150_justificativaalteracao != "")
                    $resac = db_query("insert into db_acount values($acount,2010272,2011309,'" . AddSlashes(pg_result($resaco, $conresaco, 'db150_justificativaalteracao')) . "','$this->db150_justificativaalteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["db150_mes"]) || $this->db150_mes != "")
                    $resac = db_query("insert into db_acount values($acount,2010272,2009828,'" . AddSlashes(pg_result($resaco, $conresaco, 'db150_mes')) . "','$this->db150_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                if (isset($GLOBALS["HTTP_POST_VARS"]["db150_instit"]) || $this->db150_instit != "")
                    $resac = db_query("insert into db_acount values($acount,2010272,2011557,'" . AddSlashes(pg_result($resaco, $conresaco, 'db150_instit')) . "','$this->db150_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }
        $result = db_query($sql);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "historicomaterial nao Alterado. Alteracao Abortada.\n";
            $this->erro_sql .= "Valores : " . $this->db150_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "historicomaterial nao foi Alterado. Alteracao Executada.\n";
                $this->erro_sql .= "Valores : " . $this->db150_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $this->db150_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);

                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir($db150_sequencial = null, $dbwhere = null)
    {
        if ($dbwhere == null || $dbwhere == "") {
            $resaco = $this->sql_record($this->sql_query_file($db150_sequencial));
        } else {
            $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
        }
        if (($resaco != false) || ($this->numrows != 0)) {
            for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
                $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                $acount = pg_result($resac, 0, 0);
                $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
                $resac = db_query("insert into db_acountkey values($acount,2009822,'$db150_sequencial','E')");
                $resac = db_query("insert into db_acount values($acount,2010272,2009822,'','" . AddSlashes(pg_result($resaco, $iresaco, 'db150_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,2010272,2009823,'','" . AddSlashes(pg_result($resaco, $iresaco, 'db150_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,2010272,2009825,'','" . AddSlashes(pg_result($resaco, $iresaco, 'db150_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,2010272,2009826,'','" . AddSlashes(pg_result($resaco, $iresaco, 'db150_dscitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,2010272,2009827,'','" . AddSlashes(pg_result($resaco, $iresaco, 'db150_unidademedida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,2010272,2011308,'','" . AddSlashes(pg_result($resaco, $iresaco, 'db150_tipocadastro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,2010272,2011309,'','" . AddSlashes(pg_result($resaco, $iresaco, 'db150_justificativaalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,2010272,2009828,'','" . AddSlashes(pg_result($resaco, $iresaco, 'db150_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
                $resac = db_query("insert into db_acount values($acount,2010272,2011557,'','" . AddSlashes(pg_result($resaco, $iresaco, 'db150_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
            }
        }
        $sql = " delete from historicomaterial
                    where ";
        $sql2 = "";
        if ($dbwhere == null || $dbwhere == "") {
            if ($db150_sequencial != "") {
                if ($sql2 != "") {
                    $sql2 .= " and ";
                }
                $sql2 .= " db150_sequencial = $db150_sequencial ";
            }
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql . $sql2);
        if ($result == false) {
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "historicomaterial nao Excluído. Exclusão Abortada.\n";
            $this->erro_sql .= "Valores : " . $db150_sequencial;
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;

            return false;
        } else {
            if (pg_affected_rows($result) == 0) {
                $this->erro_banco = "";
                $this->erro_sql = "historicomaterial nao Encontrado. Exclusão não Efetuada.\n";
                $this->erro_sql .= "Valores : " . $db150_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;

                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\n";
                $this->erro_sql .= "Valores : " . $db150_sequencial;
                $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
                $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
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
            $this->erro_banco = str_replace("", "", @pg_last_error());
            $this->erro_sql = "Erro ao selecionar os registros.";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }
        $this->numrows = pg_numrows($result);
        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql = "Record Vazio na Tabela:historicomaterial";
            $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
            $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
            $this->erro_status = "0";

            return false;
        }

        return $result;
    }

    // funcao do sql
    function sql_query($db150_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from historicomaterial ";
        $sql .= " inner join pcmater on pc01_codmater = db150_pcmater ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($db150_sequencial != null) {
                $sql2 .= " where historicomaterial.db150_sequencial = $db150_sequencial ";
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
    function sql_query_file($db150_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
        $sql .= " from historicomaterial ";
        $sql2 = "";
        if ($dbwhere == "") {
            if ($db150_sequencial != null) {
                $sql2 .= " where historicomaterial.db150_sequencial = $db150_sequencial ";
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
