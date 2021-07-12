<?
//MODULO: sicom
//CLASSE DA ENTIDADE hablic112020
class cl_hablic112020
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
  var $si58_sequencial = 0;
  var $si58_tiporegistro = 0;
  var $si58_codorgao = null;
  var $si58_codunidadesub = null;
  var $si58_exerciciolicitacao = 0;
  var $si58_nroprocessolicitatorio = null;
  var $si58_tipodocumentocnpjempresahablic = 0;
  var $si58_cnpjempresahablic = null;
  var $si58_tipodocumentosocio = 0;
  var $si58_nrodocumentosocio = null;
  var $si58_tipoparticipacao = 0;
  var $si58_mes = 0;
  var $si58_reg10 = 0;
  var $si58_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si58_sequencial = int8 = sequencial
                 si58_tiporegistro = int8 = Tipo do  registro
                 si58_codorgao = varchar(2) = Código do órgão
                 si58_codunidadesub = varchar(8) = Código da unidade
                 si58_exerciciolicitacao = int8 = Exercício em que foi instaurado
                 si58_nroprocessolicitatorio = varchar(12) = Número sequencial  por ano Processo
                 si58_tipodocumentocnpjempresahablic = int8 = Tipo do documento da empresa
                 si58_cnpjempresahablic = varchar(14) = Número do CNPJ  da empresa
                 si58_tipodocumentosocio = int8 = Tipo de documento  do sócio
                 si58_nrodocumentosocio = varchar(14) = Número do  documento do  sócio
                 si58_tipoparticipacao = int8 = Tipo de  Participação
                 si58_mes = int8 = Mês
                 si58_reg10 = int8 = reg10
                 si58_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_hablic112020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("hablic112020");
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
      $this->si58_sequencial = ($this->si58_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_sequencial"] : $this->si58_sequencial);
      $this->si58_tiporegistro = ($this->si58_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_tiporegistro"] : $this->si58_tiporegistro);
      $this->si58_codorgao = ($this->si58_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_codorgao"] : $this->si58_codorgao);
      $this->si58_codunidadesub = ($this->si58_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_codunidadesub"] : $this->si58_codunidadesub);
      $this->si58_exerciciolicitacao = ($this->si58_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_exerciciolicitacao"] : $this->si58_exerciciolicitacao);
      $this->si58_nroprocessolicitatorio = ($this->si58_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_nroprocessolicitatorio"] : $this->si58_nroprocessolicitatorio);
      $this->si58_tipodocumentocnpjempresahablic = ($this->si58_tipodocumentocnpjempresahablic == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_tipodocumentocnpjempresahablic"] : $this->si58_tipodocumentocnpjempresahablic);
      $this->si58_cnpjempresahablic = ($this->si58_cnpjempresahablic == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_cnpjempresahablic"] : $this->si58_cnpjempresahablic);
      $this->si58_tipodocumentosocio = ($this->si58_tipodocumentosocio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_tipodocumentosocio"] : $this->si58_tipodocumentosocio);
      $this->si58_nrodocumentosocio = ($this->si58_nrodocumentosocio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_nrodocumentosocio"] : $this->si58_nrodocumentosocio);
      $this->si58_tipoparticipacao = ($this->si58_tipoparticipacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_tipoparticipacao"] : $this->si58_tipoparticipacao);
      $this->si58_mes = ($this->si58_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_mes"] : $this->si58_mes);
      $this->si58_reg10 = ($this->si58_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_reg10"] : $this->si58_reg10);
      $this->si58_instit = ($this->si58_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_instit"] : $this->si58_instit);
    } else {
      $this->si58_sequencial = ($this->si58_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si58_sequencial"] : $this->si58_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si58_sequencial)
  {
    $this->atualizacampos();
    if ($this->si58_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si58_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si58_exerciciolicitacao == null) {
      $this->si58_exerciciolicitacao = "0";
    }
    if ($this->si58_tipodocumentocnpjempresahablic == null) {
      $this->si58_tipodocumentocnpjempresahablic = "0";
    }
    if ($this->si58_tipodocumentosocio == null) {
      $this->si58_tipodocumentosocio = "0";
    }
    if ($this->si58_tipoparticipacao == null) {
      $this->si58_tipoparticipacao = "0";
    }
    if ($this->si58_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si58_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si58_reg10 == null) {
      $this->si58_reg10 = "0";
    }
    if ($this->si58_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si58_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si58_sequencial == "" || $si58_sequencial == null) {
      $result = db_query("select nextval('hablic112020_si58_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: hablic112020_si58_sequencial_seq do campo: si58_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si58_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from hablic112020_si58_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si58_sequencial)) {
        $this->erro_sql = " Campo si58_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si58_sequencial = $si58_sequencial;
      }
    }
    if (($this->si58_sequencial == null) || ($this->si58_sequencial == "")) {
      $this->erro_sql = " Campo si58_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into hablic112020(
                                       si58_sequencial
                                      ,si58_tiporegistro
                                      ,si58_codorgao
                                      ,si58_codunidadesub
                                      ,si58_exerciciolicitacao
                                      ,si58_nroprocessolicitatorio
                                      ,si58_tipodocumentocnpjempresahablic
                                      ,si58_cnpjempresahablic
                                      ,si58_tipodocumentosocio
                                      ,si58_nrodocumentosocio
                                      ,si58_tipoparticipacao
                                      ,si58_mes
                                      ,si58_reg10
                                      ,si58_instit
                       )
                values (
                                $this->si58_sequencial
                               ,$this->si58_tiporegistro
                               ,'$this->si58_codorgao'
                               ,'$this->si58_codunidadesub'
                               ,$this->si58_exerciciolicitacao
                               ,'$this->si58_nroprocessolicitatorio'
                               ,$this->si58_tipodocumentocnpjempresahablic
                               ,'$this->si58_cnpjempresahablic'
                               ,$this->si58_tipodocumentosocio
                               ,'$this->si58_nrodocumentosocio'
                               ,$this->si58_tipoparticipacao
                               ,$this->si58_mes
                               ,$this->si58_reg10
                               ,$this->si58_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "hablic112020 ($this->si58_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "hablic112020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "hablic112020 ($this->si58_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si58_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si58_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010055,'$this->si58_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010287,2010055,'','" . AddSlashes(pg_result($resaco, 0, 'si58_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010043,'','" . AddSlashes(pg_result($resaco, 0, 'si58_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010044,'','" . AddSlashes(pg_result($resaco, 0, 'si58_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010045,'','" . AddSlashes(pg_result($resaco, 0, 'si58_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010046,'','" . AddSlashes(pg_result($resaco, 0, 'si58_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010047,'','" . AddSlashes(pg_result($resaco, 0, 'si58_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010048,'','" . AddSlashes(pg_result($resaco, 0, 'si58_tipodocumentocnpjempresahablic')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010049,'','" . AddSlashes(pg_result($resaco, 0, 'si58_cnpjempresahablic')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010050,'','" . AddSlashes(pg_result($resaco, 0, 'si58_tipodocumentosocio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010051,'','" . AddSlashes(pg_result($resaco, 0, 'si58_nrodocumentosocio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010052,'','" . AddSlashes(pg_result($resaco, 0, 'si58_tipoparticipacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010053,'','" . AddSlashes(pg_result($resaco, 0, 'si58_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2010054,'','" . AddSlashes(pg_result($resaco, 0, 'si58_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010287,2011570,'','" . AddSlashes(pg_result($resaco, 0, 'si58_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si58_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update hablic112020 set ";
    $virgula = "";
    if (trim($this->si58_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_sequencial"])) {
      if (trim($this->si58_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si58_sequencial"])) {
        $this->si58_sequencial = "0";
      }
      $sql .= $virgula . " si58_sequencial = $this->si58_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si58_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_tiporegistro"])) {
      $sql .= $virgula . " si58_tiporegistro = $this->si58_tiporegistro ";
      $virgula = ",";
      if (trim($this->si58_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si58_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si58_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_codorgao"])) {
      $sql .= $virgula . " si58_codorgao = '$this->si58_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si58_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_codunidadesub"])) {
      $sql .= $virgula . " si58_codunidadesub = '$this->si58_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si58_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_exerciciolicitacao"])) {
      if (trim($this->si58_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si58_exerciciolicitacao"])) {
        $this->si58_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si58_exerciciolicitacao = $this->si58_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si58_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si58_nroprocessolicitatorio = '$this->si58_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si58_tipodocumentocnpjempresahablic) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_tipodocumentocnpjempresahablic"])) {
      if (trim($this->si58_tipodocumentocnpjempresahablic) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si58_tipodocumentocnpjempresahablic"])) {
        $this->si58_tipodocumentocnpjempresahablic = "0";
      }
      $sql .= $virgula . " si58_tipodocumentocnpjempresahablic = $this->si58_tipodocumentocnpjempresahablic ";
      $virgula = ",";
    }
    if (trim($this->si58_cnpjempresahablic) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_cnpjempresahablic"])) {
      $sql .= $virgula . " si58_cnpjempresahablic = '$this->si58_cnpjempresahablic' ";
      $virgula = ",";
    }
    if (trim($this->si58_tipodocumentosocio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_tipodocumentosocio"])) {
      if (trim($this->si58_tipodocumentosocio) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si58_tipodocumentosocio"])) {
        $this->si58_tipodocumentosocio = "0";
      }
      $sql .= $virgula . " si58_tipodocumentosocio = $this->si58_tipodocumentosocio ";
      $virgula = ",";
    }
    if (trim($this->si58_nrodocumentosocio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_nrodocumentosocio"])) {
      $sql .= $virgula . " si58_nrodocumentosocio = '$this->si58_nrodocumentosocio' ";
      $virgula = ",";
    }
    if (trim($this->si58_tipoparticipacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_tipoparticipacao"])) {
      if (trim($this->si58_tipoparticipacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si58_tipoparticipacao"])) {
        $this->si58_tipoparticipacao = "0";
      }
      $sql .= $virgula . " si58_tipoparticipacao = $this->si58_tipoparticipacao ";
      $virgula = ",";
    }
    if (trim($this->si58_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_mes"])) {
      $sql .= $virgula . " si58_mes = $this->si58_mes ";
      $virgula = ",";
      if (trim($this->si58_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si58_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si58_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_reg10"])) {
      if (trim($this->si58_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si58_reg10"])) {
        $this->si58_reg10 = "0";
      }
      $sql .= $virgula . " si58_reg10 = $this->si58_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si58_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si58_instit"])) {
      $sql .= $virgula . " si58_instit = $this->si58_instit ";
      $virgula = ",";
      if (trim($this->si58_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si58_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si58_sequencial != null) {
      $sql .= " si58_sequencial = $this->si58_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si58_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010055,'$this->si58_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_sequencial"]) || $this->si58_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010055,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_sequencial')) . "','$this->si58_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_tiporegistro"]) || $this->si58_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010043,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_tiporegistro')) . "','$this->si58_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_codorgao"]) || $this->si58_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010044,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_codorgao')) . "','$this->si58_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_codunidadesub"]) || $this->si58_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010045,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_codunidadesub')) . "','$this->si58_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_exerciciolicitacao"]) || $this->si58_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010046,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_exerciciolicitacao')) . "','$this->si58_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_nroprocessolicitatorio"]) || $this->si58_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010047,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_nroprocessolicitatorio')) . "','$this->si58_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_tipodocumentocnpjempresahablic"]) || $this->si58_tipodocumentocnpjempresahablic != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010048,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_tipodocumentocnpjempresahablic')) . "','$this->si58_tipodocumentocnpjempresahablic'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_cnpjempresahablic"]) || $this->si58_cnpjempresahablic != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010049,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_cnpjempresahablic')) . "','$this->si58_cnpjempresahablic'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_tipodocumentosocio"]) || $this->si58_tipodocumentosocio != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010050,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_tipodocumentosocio')) . "','$this->si58_tipodocumentosocio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_nrodocumentosocio"]) || $this->si58_nrodocumentosocio != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010051,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_nrodocumentosocio')) . "','$this->si58_nrodocumentosocio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_tipoparticipacao"]) || $this->si58_tipoparticipacao != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010052,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_tipoparticipacao')) . "','$this->si58_tipoparticipacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_mes"]) || $this->si58_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010053,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_mes')) . "','$this->si58_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_reg10"]) || $this->si58_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2010054,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_reg10')) . "','$this->si58_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si58_instit"]) || $this->si58_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010287,2011570,'" . AddSlashes(pg_result($resaco, $conresaco, 'si58_instit')) . "','$this->si58_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "hablic112020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si58_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "hablic112020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si58_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si58_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si58_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si58_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010055,'$si58_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010287,2010055,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010043,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010044,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010045,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010046,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010047,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010048,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_tipodocumentocnpjempresahablic')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010049,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_cnpjempresahablic')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010050,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_tipodocumentosocio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010051,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_nrodocumentosocio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010052,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_tipoparticipacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010053,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2010054,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010287,2011570,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si58_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from hablic112020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si58_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si58_sequencial = $si58_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "hablic112020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si58_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "hablic112020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si58_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si58_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:hablic112020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si58_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from hablic112020 ";
    $sql .= "      left  join hablic102020  on  hablic102020.si57_sequencial = hablic112020.si58_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si58_sequencial != null) {
        $sql2 .= " where hablic112020.si58_sequencial = $si58_sequencial ";
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
  function sql_query_file($si58_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from hablic112020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si58_sequencial != null) {
        $sql2 .= " where hablic112020.si58_sequencial = $si58_sequencial ";
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
