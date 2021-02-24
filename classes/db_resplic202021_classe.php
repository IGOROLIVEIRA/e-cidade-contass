<?
//MODULO: sicom
//CLASSE DA ENTIDADE resplic202021
class cl_resplic202021
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
  var $si56_sequencial = 0;
  var $si56_tiporegistro = 0;
  var $si56_codorgao = null;
  var $si56_codunidadesub = null;
  var $si56_exerciciolicitacao = 0;
  var $si56_nroprocessolicitatorio = null;
  var $si56_codtipocomissao = 0;
  var $si56_descricaoatonomeacao = 0;
  var $si56_nroatonomeacao = 0;
  var $si56_dataatonomeacao_dia = null;
  var $si56_dataatonomeacao_mes = null;
  var $si56_dataatonomeacao_ano = null;
  var $si56_dataatonomeacao = null;
  var $si56_iniciovigencia_dia = null;
  var $si56_iniciovigencia_mes = null;
  var $si56_iniciovigencia_ano = null;
  var $si56_iniciovigencia = null;
  var $si56_finalvigencia_dia = null;
  var $si56_finalvigencia_mes = null;
  var $si56_finalvigencia_ano = null;
  var $si56_finalvigencia = null;
  var $si56_cpfmembrocomissao = null;
  var $si56_codatribuicao = 0;
  var $si56_cargo = null;
  var $si56_naturezacargo = 0;
  var $si56_mes = 0;
  var $si56_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si56_sequencial = int8 = sequencial 
                 si56_tiporegistro = int8 = Tipo do  registro 
                 si56_codorgao = varchar(2) = Código do órgão 
                 si56_codunidadesub = varchar(8) = Código da unidade 
                 si56_exerciciolicitacao = int8 = Exercício em que   foi instaurado 
                 si56_nroprocessolicitatorio = varchar(12) = Número sequencial do processo 
                 si56_codtipocomissao = int8 = Tipo da  comissão 
                 si56_descricaoatonomeacao = int8 = Descrição do ato  de nomeação 
                 si56_nroatonomeacao = int8 = Número do Ato de  Nomeação 
                 si56_dataatonomeacao = date = Data do Ato de  Nomeação 
                 si56_iniciovigencia = date = Data do início da  vigência 
                 si56_finalvigencia = date = Data do fim da  vigência 
                 si56_cpfmembrocomissao = varchar(11) = CPF Membro  Comissão 
                 si56_codatribuicao = int8 = Código da  atribuição do  responsável 
                 si56_cargo = varchar(50) = Descrição do  cargo do  componente 
                 si56_naturezacargo = int8 = Natureza do Cargo 
                 si56_mes = int8 = Mês 
                 si56_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_resplic202021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("resplic202021");
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
      $this->si56_sequencial = ($this->si56_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_sequencial"] : $this->si56_sequencial);
      $this->si56_tiporegistro = ($this->si56_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_tiporegistro"] : $this->si56_tiporegistro);
      $this->si56_codorgao = ($this->si56_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_codorgao"] : $this->si56_codorgao);
      $this->si56_codunidadesub = ($this->si56_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_codunidadesub"] : $this->si56_codunidadesub);
      $this->si56_exerciciolicitacao = ($this->si56_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_exerciciolicitacao"] : $this->si56_exerciciolicitacao);
      $this->si56_nroprocessolicitatorio = ($this->si56_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_nroprocessolicitatorio"] : $this->si56_nroprocessolicitatorio);
      $this->si56_codtipocomissao = ($this->si56_codtipocomissao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_codtipocomissao"] : $this->si56_codtipocomissao);
      $this->si56_descricaoatonomeacao = ($this->si56_descricaoatonomeacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_descricaoatonomeacao"] : $this->si56_descricaoatonomeacao);
      $this->si56_nroatonomeacao = ($this->si56_nroatonomeacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_nroatonomeacao"] : $this->si56_nroatonomeacao);
      if ($this->si56_dataatonomeacao == "") {
        $this->si56_dataatonomeacao_dia = ($this->si56_dataatonomeacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_dataatonomeacao_dia"] : $this->si56_dataatonomeacao_dia);
        $this->si56_dataatonomeacao_mes = ($this->si56_dataatonomeacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_dataatonomeacao_mes"] : $this->si56_dataatonomeacao_mes);
        $this->si56_dataatonomeacao_ano = ($this->si56_dataatonomeacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_dataatonomeacao_ano"] : $this->si56_dataatonomeacao_ano);
        if ($this->si56_dataatonomeacao_dia != "") {
          $this->si56_dataatonomeacao = $this->si56_dataatonomeacao_ano . "-" . $this->si56_dataatonomeacao_mes . "-" . $this->si56_dataatonomeacao_dia;
        }
      }
      if ($this->si56_iniciovigencia == "") {
        $this->si56_iniciovigencia_dia = ($this->si56_iniciovigencia_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_iniciovigencia_dia"] : $this->si56_iniciovigencia_dia);
        $this->si56_iniciovigencia_mes = ($this->si56_iniciovigencia_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_iniciovigencia_mes"] : $this->si56_iniciovigencia_mes);
        $this->si56_iniciovigencia_ano = ($this->si56_iniciovigencia_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_iniciovigencia_ano"] : $this->si56_iniciovigencia_ano);
        if ($this->si56_iniciovigencia_dia != "") {
          $this->si56_iniciovigencia = $this->si56_iniciovigencia_ano . "-" . $this->si56_iniciovigencia_mes . "-" . $this->si56_iniciovigencia_dia;
        }
      }
      if ($this->si56_finalvigencia == "") {
        $this->si56_finalvigencia_dia = ($this->si56_finalvigencia_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_finalvigencia_dia"] : $this->si56_finalvigencia_dia);
        $this->si56_finalvigencia_mes = ($this->si56_finalvigencia_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_finalvigencia_mes"] : $this->si56_finalvigencia_mes);
        $this->si56_finalvigencia_ano = ($this->si56_finalvigencia_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_finalvigencia_ano"] : $this->si56_finalvigencia_ano);
        if ($this->si56_finalvigencia_dia != "") {
          $this->si56_finalvigencia = $this->si56_finalvigencia_ano . "-" . $this->si56_finalvigencia_mes . "-" . $this->si56_finalvigencia_dia;
        }
      }
      $this->si56_cpfmembrocomissao = ($this->si56_cpfmembrocomissao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_cpfmembrocomissao"] : $this->si56_cpfmembrocomissao);
      $this->si56_codatribuicao = ($this->si56_codatribuicao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_codatribuicao"] : $this->si56_codatribuicao);
      $this->si56_cargo = ($this->si56_cargo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_cargo"] : $this->si56_cargo);
      $this->si56_naturezacargo = ($this->si56_naturezacargo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_naturezacargo"] : $this->si56_naturezacargo);
      $this->si56_mes = ($this->si56_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_mes"] : $this->si56_mes);
      $this->si56_instit = ($this->si56_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_instit"] : $this->si56_instit);
    } else {
      $this->si56_sequencial = ($this->si56_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si56_sequencial"] : $this->si56_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si56_sequencial)
  {
    $this->atualizacampos();
    if ($this->si56_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si56_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si56_exerciciolicitacao == null) {
      $this->si56_exerciciolicitacao = "0";
    }
    if ($this->si56_codtipocomissao == null) {
      $this->si56_codtipocomissao = "0";
    }
    if ($this->si56_descricaoatonomeacao == null) {
      $this->si56_descricaoatonomeacao = "0";
    }
    if ($this->si56_nroatonomeacao == null) {
      $this->si56_nroatonomeacao = "0";
    }
    if ($this->si56_dataatonomeacao == null) {
      $this->si56_dataatonomeacao = "null";
    }
    if ($this->si56_iniciovigencia == null) {
      $this->si56_iniciovigencia = "null";
    }
    if ($this->si56_finalvigencia == null) {
      $this->si56_finalvigencia = "null";
    }
    if ($this->si56_codatribuicao == null) {
      $this->si56_codatribuicao = "0";
    }
    if ($this->si56_naturezacargo == null) {
      $this->si56_naturezacargo = "0";
    }
    if ($this->si56_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si56_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si56_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si56_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si56_sequencial == "" || $si56_sequencial == null) {
      $result = db_query("select nextval('resplic202021_si56_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: resplic202021_si56_sequencial_seq do campo: si56_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si56_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from resplic202021_si56_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si56_sequencial)) {
        $this->erro_sql = " Campo si56_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si56_sequencial = $si56_sequencial;
      }
    }
    if (($this->si56_sequencial == null) || ($this->si56_sequencial == "")) {
      $this->erro_sql = " Campo si56_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into resplic202021(
                                       si56_sequencial 
                                      ,si56_tiporegistro 
                                      ,si56_codorgao 
                                      ,si56_codunidadesub 
                                      ,si56_exerciciolicitacao 
                                      ,si56_nroprocessolicitatorio 
                                      ,si56_codtipocomissao 
                                      ,si56_descricaoatonomeacao 
                                      ,si56_nroatonomeacao 
                                      ,si56_dataatonomeacao 
                                      ,si56_iniciovigencia 
                                      ,si56_finalvigencia 
                                      ,si56_cpfmembrocomissao 
                                      ,si56_codatribuicao 
                                      ,si56_cargo 
                                      ,si56_naturezacargo 
                                      ,si56_mes 
                                      ,si56_instit 
                       )
                values (
                                $this->si56_sequencial 
                               ,$this->si56_tiporegistro 
                               ,'$this->si56_codorgao' 
                               ,'$this->si56_codunidadesub' 
                               ,$this->si56_exerciciolicitacao 
                               ,'$this->si56_nroprocessolicitatorio' 
                               ,$this->si56_codtipocomissao 
                               ,$this->si56_descricaoatonomeacao 
                               ,$this->si56_nroatonomeacao 
                               ," . ($this->si56_dataatonomeacao == "null" || $this->si56_dataatonomeacao == "" ? "null" : "'" . $this->si56_dataatonomeacao . "'") . "
                               ," . ($this->si56_iniciovigencia == "null" || $this->si56_iniciovigencia == "" ? "null" : "'" . $this->si56_iniciovigencia . "'") . "
                               ," . ($this->si56_finalvigencia == "null" || $this->si56_finalvigencia == "" ? "null" : "'" . $this->si56_finalvigencia . "'") . "
                               ,'$this->si56_cpfmembrocomissao' 
                               ,$this->si56_codatribuicao 
                               ,'$this->si56_cargo' 
                               ,$this->si56_naturezacargo 
                               ,$this->si56_mes 
                               ,$this->si56_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "resplic202021 ($this->si56_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "resplic202021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "resplic202021 ($this->si56_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si56_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si56_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009994,'$this->si56_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010285,2009994,'','" . AddSlashes(pg_result($resaco, 0, 'si56_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2009995,'','" . AddSlashes(pg_result($resaco, 0, 'si56_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2009996,'','" . AddSlashes(pg_result($resaco, 0, 'si56_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2009997,'','" . AddSlashes(pg_result($resaco, 0, 'si56_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2009998,'','" . AddSlashes(pg_result($resaco, 0, 'si56_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2009999,'','" . AddSlashes(pg_result($resaco, 0, 'si56_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010000,'','" . AddSlashes(pg_result($resaco, 0, 'si56_codtipocomissao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010001,'','" . AddSlashes(pg_result($resaco, 0, 'si56_descricaoatonomeacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010002,'','" . AddSlashes(pg_result($resaco, 0, 'si56_nroatonomeacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010003,'','" . AddSlashes(pg_result($resaco, 0, 'si56_dataatonomeacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010004,'','" . AddSlashes(pg_result($resaco, 0, 'si56_iniciovigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010005,'','" . AddSlashes(pg_result($resaco, 0, 'si56_finalvigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010006,'','" . AddSlashes(pg_result($resaco, 0, 'si56_cpfmembrocomissao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010007,'','" . AddSlashes(pg_result($resaco, 0, 'si56_codatribuicao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010008,'','" . AddSlashes(pg_result($resaco, 0, 'si56_cargo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010009,'','" . AddSlashes(pg_result($resaco, 0, 'si56_naturezacargo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2010010,'','" . AddSlashes(pg_result($resaco, 0, 'si56_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010285,2011568,'','" . AddSlashes(pg_result($resaco, 0, 'si56_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si56_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update resplic202021 set ";
    $virgula = "";
    if (trim($this->si56_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_sequencial"])) {
      if (trim($this->si56_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si56_sequencial"])) {
        $this->si56_sequencial = "0";
      }
      $sql .= $virgula . " si56_sequencial = $this->si56_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si56_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_tiporegistro"])) {
      $sql .= $virgula . " si56_tiporegistro = $this->si56_tiporegistro ";
      $virgula = ",";
      if (trim($this->si56_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si56_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si56_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_codorgao"])) {
      $sql .= $virgula . " si56_codorgao = '$this->si56_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si56_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_codunidadesub"])) {
      $sql .= $virgula . " si56_codunidadesub = '$this->si56_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si56_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_exerciciolicitacao"])) {
      if (trim($this->si56_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si56_exerciciolicitacao"])) {
        $this->si56_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si56_exerciciolicitacao = $this->si56_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si56_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si56_nroprocessolicitatorio = '$this->si56_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si56_codtipocomissao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_codtipocomissao"])) {
      if (trim($this->si56_codtipocomissao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si56_codtipocomissao"])) {
        $this->si56_codtipocomissao = "0";
      }
      $sql .= $virgula . " si56_codtipocomissao = $this->si56_codtipocomissao ";
      $virgula = ",";
    }
    if (trim($this->si56_descricaoatonomeacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_descricaoatonomeacao"])) {
      if (trim($this->si56_descricaoatonomeacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si56_descricaoatonomeacao"])) {
        $this->si56_descricaoatonomeacao = "0";
      }
      $sql .= $virgula . " si56_descricaoatonomeacao = $this->si56_descricaoatonomeacao ";
      $virgula = ",";
    }
    if (trim($this->si56_nroatonomeacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_nroatonomeacao"])) {
      if (trim($this->si56_nroatonomeacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si56_nroatonomeacao"])) {
        $this->si56_nroatonomeacao = "0";
      }
      $sql .= $virgula . " si56_nroatonomeacao = $this->si56_nroatonomeacao ";
      $virgula = ",";
    }
    if (trim($this->si56_dataatonomeacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_dataatonomeacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si56_dataatonomeacao_dia"] != "")) {
      $sql .= $virgula . " si56_dataatonomeacao = '$this->si56_dataatonomeacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si56_dataatonomeacao_dia"])) {
        $sql .= $virgula . " si56_dataatonomeacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si56_iniciovigencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_iniciovigencia_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si56_iniciovigencia_dia"] != "")) {
      $sql .= $virgula . " si56_iniciovigencia = '$this->si56_iniciovigencia' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si56_iniciovigencia_dia"])) {
        $sql .= $virgula . " si56_iniciovigencia = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si56_finalvigencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_finalvigencia_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si56_finalvigencia_dia"] != "")) {
      $sql .= $virgula . " si56_finalvigencia = '$this->si56_finalvigencia' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si56_finalvigencia_dia"])) {
        $sql .= $virgula . " si56_finalvigencia = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si56_cpfmembrocomissao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_cpfmembrocomissao"])) {
      $sql .= $virgula . " si56_cpfmembrocomissao = '$this->si56_cpfmembrocomissao' ";
      $virgula = ",";
    }
    if (trim($this->si56_codatribuicao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_codatribuicao"])) {
      if (trim($this->si56_codatribuicao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si56_codatribuicao"])) {
        $this->si56_codatribuicao = "0";
      }
      $sql .= $virgula . " si56_codatribuicao = $this->si56_codatribuicao ";
      $virgula = ",";
    }
    if (trim($this->si56_cargo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_cargo"])) {
      $sql .= $virgula . " si56_cargo = '$this->si56_cargo' ";
      $virgula = ",";
    }
    if (trim($this->si56_naturezacargo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_naturezacargo"])) {
      if (trim($this->si56_naturezacargo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si56_naturezacargo"])) {
        $this->si56_naturezacargo = "0";
      }
      $sql .= $virgula . " si56_naturezacargo = $this->si56_naturezacargo ";
      $virgula = ",";
    }
    if (trim($this->si56_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_mes"])) {
      $sql .= $virgula . " si56_mes = $this->si56_mes ";
      $virgula = ",";
      if (trim($this->si56_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si56_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si56_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si56_instit"])) {
      $sql .= $virgula . " si56_instit = $this->si56_instit ";
      $virgula = ",";
      if (trim($this->si56_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si56_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si56_sequencial != null) {
      $sql .= " si56_sequencial = $this->si56_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si56_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009994,'$this->si56_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_sequencial"]) || $this->si56_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2009994,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_sequencial')) . "','$this->si56_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_tiporegistro"]) || $this->si56_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2009995,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_tiporegistro')) . "','$this->si56_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_codorgao"]) || $this->si56_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2009996,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_codorgao')) . "','$this->si56_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_codunidadesub"]) || $this->si56_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2009997,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_codunidadesub')) . "','$this->si56_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_exerciciolicitacao"]) || $this->si56_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2009998,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_exerciciolicitacao')) . "','$this->si56_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_nroprocessolicitatorio"]) || $this->si56_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2009999,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_nroprocessolicitatorio')) . "','$this->si56_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_codtipocomissao"]) || $this->si56_codtipocomissao != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010000,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_codtipocomissao')) . "','$this->si56_codtipocomissao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_descricaoatonomeacao"]) || $this->si56_descricaoatonomeacao != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010001,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_descricaoatonomeacao')) . "','$this->si56_descricaoatonomeacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_nroatonomeacao"]) || $this->si56_nroatonomeacao != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010002,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_nroatonomeacao')) . "','$this->si56_nroatonomeacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_dataatonomeacao"]) || $this->si56_dataatonomeacao != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010003,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_dataatonomeacao')) . "','$this->si56_dataatonomeacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_iniciovigencia"]) || $this->si56_iniciovigencia != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010004,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_iniciovigencia')) . "','$this->si56_iniciovigencia'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_finalvigencia"]) || $this->si56_finalvigencia != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010005,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_finalvigencia')) . "','$this->si56_finalvigencia'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_cpfmembrocomissao"]) || $this->si56_cpfmembrocomissao != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010006,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_cpfmembrocomissao')) . "','$this->si56_cpfmembrocomissao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_codatribuicao"]) || $this->si56_codatribuicao != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010007,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_codatribuicao')) . "','$this->si56_codatribuicao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_cargo"]) || $this->si56_cargo != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010008,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_cargo')) . "','$this->si56_cargo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_naturezacargo"]) || $this->si56_naturezacargo != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010009,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_naturezacargo')) . "','$this->si56_naturezacargo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_mes"]) || $this->si56_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2010010,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_mes')) . "','$this->si56_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si56_instit"]) || $this->si56_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010285,2011568,'" . AddSlashes(pg_result($resaco, $conresaco, 'si56_instit')) . "','$this->si56_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "resplic202021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si56_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "resplic202021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si56_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si56_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si56_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si56_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009994,'$si56_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010285,2009994,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2009995,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2009996,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2009997,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2009998,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2009999,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010000,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_codtipocomissao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010001,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_descricaoatonomeacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010002,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_nroatonomeacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010003,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_dataatonomeacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010004,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_iniciovigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010005,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_finalvigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010006,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_cpfmembrocomissao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010007,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_codatribuicao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010008,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_cargo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010009,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_naturezacargo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2010010,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010285,2011568,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si56_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from resplic202021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si56_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si56_sequencial = $si56_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "resplic202021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si56_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "resplic202021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si56_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si56_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:resplic202021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si56_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from resplic202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si56_sequencial != null) {
        $sql2 .= " where resplic202021.si56_sequencial = $si56_sequencial ";
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
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }

  // funcao do sql
  function sql_query_file($si56_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from resplic202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si56_sequencial != null) {
        $sql2 .= " where resplic202021.si56_sequencial = $si56_sequencial ";
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
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }
}

?>
