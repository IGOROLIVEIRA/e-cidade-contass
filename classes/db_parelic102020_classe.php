<?
//MODULO: sicom
//CLASSE DA ENTIDADE parelic102020
class cl_parelic102020
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
  var $si66_sequencial = 0;
  var $si66_tiporegistro = 0;
  var $si66_codorgao = null;
  var $si66_codunidadesub = null;
  var $si66_exerciciolicitacao = 0;
  var $si66_nroprocessolicitatorio = null;
  var $si66_dataparecer_dia = null;
  var $si66_dataparecer_mes = null;
  var $si66_dataparecer_ano = null;
  var $si66_dataparecer = null;
  var $si66_tipoparecer = 0;
  var $si66_nrocpf = null;
  var $si66_mes = 0;
  var $si66_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si66_sequencial = int8 = sequencial 
                 si66_tiporegistro = int8 = Tipo do  registro 
                 si66_codorgao = varchar(2) = Código do órgão 
                 si66_codunidadesub = varchar(8) = Código da unidade 
                 si66_exerciciolicitacao = int8 = Exercício em que  foi instaurado 
                 si66_nroprocessolicitatorio = varchar(12) = Número sequencial   do processo 
                 si66_dataparecer = date = Data do parecer 
                 si66_tipoparecer = int8 = Tipo do parecer 
                 si66_nrocpf = varchar(11) = Número do CPF 
                 si66_mes = int8 = Mês 
                 si66_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_parelic102020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("parelic102020");
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
      $this->si66_sequencial = ($this->si66_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_sequencial"] : $this->si66_sequencial);
      $this->si66_tiporegistro = ($this->si66_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_tiporegistro"] : $this->si66_tiporegistro);
      $this->si66_codorgao = ($this->si66_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_codorgao"] : $this->si66_codorgao);
      $this->si66_codunidadesub = ($this->si66_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_codunidadesub"] : $this->si66_codunidadesub);
      $this->si66_exerciciolicitacao = ($this->si66_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_exerciciolicitacao"] : $this->si66_exerciciolicitacao);
      $this->si66_nroprocessolicitatorio = ($this->si66_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_nroprocessolicitatorio"] : $this->si66_nroprocessolicitatorio);
      if ($this->si66_dataparecer == "") {
        $this->si66_dataparecer_dia = ($this->si66_dataparecer_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_dataparecer_dia"] : $this->si66_dataparecer_dia);
        $this->si66_dataparecer_mes = ($this->si66_dataparecer_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_dataparecer_mes"] : $this->si66_dataparecer_mes);
        $this->si66_dataparecer_ano = ($this->si66_dataparecer_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_dataparecer_ano"] : $this->si66_dataparecer_ano);
        if ($this->si66_dataparecer_dia != "") {
          $this->si66_dataparecer = $this->si66_dataparecer_ano . "-" . $this->si66_dataparecer_mes . "-" . $this->si66_dataparecer_dia;
        }
      }
      $this->si66_tipoparecer = ($this->si66_tipoparecer == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_tipoparecer"] : $this->si66_tipoparecer);
      $this->si66_nrocpf = ($this->si66_nrocpf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_nrocpf"] : $this->si66_nrocpf);
      $this->si66_mes = ($this->si66_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_mes"] : $this->si66_mes);
      $this->si66_instit = ($this->si66_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_instit"] : $this->si66_instit);
    } else {
      $this->si66_sequencial = ($this->si66_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si66_sequencial"] : $this->si66_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si66_sequencial)
  {
    $this->atualizacampos();
    if (strlen($this->si66_nrocpf) > 11) {
      $this->erro_sql = " Campo Cpf do responsável não pode ser um cnpj. Favor corrigir no cadastro do parecer. Processo Licitatório $this->si66_nroprocessolicitatorio / $this->si66_exerciciolicitacao";
      $this->erro_campo = "si66_nrocpf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si66_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si66_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si66_exerciciolicitacao == null) {
      $this->si66_exerciciolicitacao = "0";
    }
    if ($this->si66_dataparecer == null) {
      $this->si66_dataparecer = "null";
    }
    if ($this->si66_tipoparecer == null) {
      $this->si66_tipoparecer = "0";
    }
    if ($this->si66_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si66_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si66_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si66_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si66_sequencial == "" || $si66_sequencial == null) {
      $result = db_query("select nextval('parec102020_si66_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: parec102020_si66_sequencial_seq do campo: si66_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si66_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from parec102020_si66_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si66_sequencial)) {
        $this->erro_sql = " Campo si66_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si66_sequencial = $si66_sequencial;
      }
    }
    if (($this->si66_sequencial == null) || ($this->si66_sequencial == "")) {
      $this->erro_sql = " Campo si66_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into parelic102020(
                                       si66_sequencial 
                                      ,si66_tiporegistro 
                                      ,si66_codorgao 
                                      ,si66_codunidadesub 
                                      ,si66_exerciciolicitacao 
                                      ,si66_nroprocessolicitatorio 
                                      ,si66_dataparecer 
                                      ,si66_tipoparecer 
                                      ,si66_nrocpf 
                                      ,si66_mes 
                                      ,si66_instit 
                       )
                values (
                                $this->si66_sequencial 
                               ,$this->si66_tiporegistro 
                               ,'$this->si66_codorgao' 
                               ,'$this->si66_codunidadesub' 
                               ,$this->si66_exerciciolicitacao 
                               ,'$this->si66_nroprocessolicitatorio' 
                               ," . ($this->si66_dataparecer == "null" || $this->si66_dataparecer == "" ? "null" : "'" . $this->si66_dataparecer . "'") . "
                               ,$this->si66_tipoparecer 
                               ,'$this->si66_nrocpf' 
                               ,$this->si66_mes 
                               ,$this->si66_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "parelic102020 ($this->si66_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "parelic102020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "parelic102020 ($this->si66_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si66_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si66_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010153,'$this->si66_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010295,2010153,'','" . AddSlashes(pg_result($resaco, 0, 'si66_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2010154,'','" . AddSlashes(pg_result($resaco, 0, 'si66_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2010155,'','" . AddSlashes(pg_result($resaco, 0, 'si66_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2010156,'','" . AddSlashes(pg_result($resaco, 0, 'si66_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2010158,'','" . AddSlashes(pg_result($resaco, 0, 'si66_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2010159,'','" . AddSlashes(pg_result($resaco, 0, 'si66_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2010160,'','" . AddSlashes(pg_result($resaco, 0, 'si66_dataparecer')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2010161,'','" . AddSlashes(pg_result($resaco, 0, 'si66_tipoparecer')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2010162,'','" . AddSlashes(pg_result($resaco, 0, 'si66_nrocpf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2010163,'','" . AddSlashes(pg_result($resaco, 0, 'si66_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010295,2011578,'','" . AddSlashes(pg_result($resaco, 0, 'si66_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si66_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update parelic102020 set ";
    $virgula = "";
    if (trim($this->si66_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_sequencial"])) {
      if (trim($this->si66_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si66_sequencial"])) {
        $this->si66_sequencial = "0";
      }
      $sql .= $virgula . " si66_sequencial = $this->si66_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si66_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_tiporegistro"])) {
      $sql .= $virgula . " si66_tiporegistro = $this->si66_tiporegistro ";
      $virgula = ",";
      if (trim($this->si66_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si66_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si66_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_codorgao"])) {
      $sql .= $virgula . " si66_codorgao = '$this->si66_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si66_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_codunidadesub"])) {
      $sql .= $virgula . " si66_codunidadesub = '$this->si66_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si66_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_exerciciolicitacao"])) {
      if (trim($this->si66_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si66_exerciciolicitacao"])) {
        $this->si66_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si66_exerciciolicitacao = $this->si66_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si66_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si66_nroprocessolicitatorio = '$this->si66_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si66_dataparecer) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_dataparecer_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si66_dataparecer_dia"] != "")) {
      $sql .= $virgula . " si66_dataparecer = '$this->si66_dataparecer' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si66_dataparecer_dia"])) {
        $sql .= $virgula . " si66_dataparecer = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si66_tipoparecer) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_tipoparecer"])) {
      if (trim($this->si66_tipoparecer) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si66_tipoparecer"])) {
        $this->si66_tipoparecer = "0";
      }
      $sql .= $virgula . " si66_tipoparecer = $this->si66_tipoparecer ";
      $virgula = ",";
    }
    if (trim($this->si66_nrocpf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_nrocpf"])) {
      $sql .= $virgula . " si66_nrocpf = '$this->si66_nrocpf' ";
      $virgula = ",";
    }
    if (trim($this->si66_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_mes"])) {
      $sql .= $virgula . " si66_mes = $this->si66_mes ";
      $virgula = ",";
      if (trim($this->si66_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si66_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si66_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si66_instit"])) {
      $sql .= $virgula . " si66_instit = $this->si66_instit ";
      $virgula = ",";
      if (trim($this->si66_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si66_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si66_sequencial != null) {
      $sql .= " si66_sequencial = $this->si66_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si66_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010153,'$this->si66_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_sequencial"]) || $this->si66_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010153,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_sequencial')) . "','$this->si66_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_tiporegistro"]) || $this->si66_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010154,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_tiporegistro')) . "','$this->si66_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_codorgao"]) || $this->si66_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010155,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_codorgao')) . "','$this->si66_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_codunidadesub"]) || $this->si66_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010156,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_codunidadesub')) . "','$this->si66_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_exerciciolicitacao"]) || $this->si66_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010158,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_exerciciolicitacao')) . "','$this->si66_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_nroprocessolicitatorio"]) || $this->si66_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010159,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_nroprocessolicitatorio')) . "','$this->si66_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_dataparecer"]) || $this->si66_dataparecer != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010160,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_dataparecer')) . "','$this->si66_dataparecer'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_tipoparecer"]) || $this->si66_tipoparecer != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010161,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_tipoparecer')) . "','$this->si66_tipoparecer'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_nrocpf"]) || $this->si66_nrocpf != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010162,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_nrocpf')) . "','$this->si66_nrocpf'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_mes"]) || $this->si66_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2010163,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_mes')) . "','$this->si66_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si66_instit"]) || $this->si66_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010295,2011578,'" . AddSlashes(pg_result($resaco, $conresaco, 'si66_instit')) . "','$this->si66_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "parelic102020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si66_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "parelic102020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si66_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si66_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si66_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si66_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010153,'$si66_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010295,2010153,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2010154,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2010155,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2010156,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2010158,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2010159,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2010160,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_dataparecer')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2010161,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_tipoparecer')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2010162,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_nrocpf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2010163,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010295,2011578,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si66_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from parelic102020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si66_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si66_sequencial = $si66_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "parelic102020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si66_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "parelic102020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si66_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si66_sequencial;
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
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:parelic102020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si66_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from parelic102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si66_sequencial != null) {
        $sql2 .= " where parelic102020.si66_sequencial = $si66_sequencial ";
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
  function sql_query_file($si66_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from parelic102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si66_sequencial != null) {
        $sql2 .= " where parelic102020.si66_sequencial = $si66_sequencial ";
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
