<?
//MODULO: sicom
//CLASSE DA ENTIDADE cvc302019
class cl_cvc302019
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
  var $si148_sequencial = 0;
  var $si148_tiporegistro = 0;
  var $si148_codorgao = null;
  var $si148_codunidadesub = null;
  var $si148_codveiculo = null;
  var $si148_nomeestabelecimento = null;
  var $si148_localidade = null;
  var $si148_qtdediasrodados = 0;
  var $si148_distanciaestabelecimento = 0;
  var $si148_numeropassageiros = 0;
  var $si148_turnos = null;
  var $si148_mes = 0;
  var $si148_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si148_sequencial = int8 = sequencial 
                 si148_tiporegistro = int8 = Tipo do  registro 
                 si148_codorgao = varchar(2) = Código do órgão 
                 si148_codunidadesub = varchar(8) = Código da  unidade 
                 si148_codveiculo = varchar(10) = Código do Veiculo 
                 si148_nomeestabelecimento = varchar(250) = Nome do estabelecimento de ensino 
                 si148_localidade = varchar(250) = Localidade 
                 si148_qtdediasrodados = int8 = Quantidade de  dias rodados 
                 si148_distanciaestabelecimento = float8 = Distância total  percorrida no mês 
                 si148_numeropassageiros = int8 = Números de  passageiros 
                 si148_turnos = varchar(2) = Turnos do estabelecimento de ensino 
                 si148_mes = int8 = Mês 
                 si148_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_cvc302019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("cvc302019");
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
      $this->si148_sequencial = ($this->si148_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_sequencial"] : $this->si148_sequencial);
      $this->si148_tiporegistro = ($this->si148_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_tiporegistro"] : $this->si148_tiporegistro);
      $this->si148_codorgao = ($this->si148_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_codorgao"] : $this->si148_codorgao);
      $this->si148_codunidadesub = ($this->si148_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_codunidadesub"] : $this->si148_codunidadesub);
      $this->si148_codveiculo = ($this->si148_codveiculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_codveiculo"] : $this->si148_codveiculo);
      $this->si148_nomeestabelecimento = ($this->si148_nomeestabelecimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_nomeestabelecimento"] : $this->si148_nomeestabelecimento);
      $this->si148_localidade = ($this->si148_localidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_localidade"] : $this->si148_localidade);
      $this->si148_qtdediasrodados = ($this->si148_qtdediasrodados == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_qtdediasrodados"] : $this->si148_qtdediasrodados);
      $this->si148_distanciaestabelecimento = ($this->si148_distanciaestabelecimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_distanciaestabelecimento"] : $this->si148_distanciaestabelecimento);
      $this->si148_numeropassageiros = ($this->si148_numeropassageiros == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_numeropassageiros"] : $this->si148_numeropassageiros);
      $this->si148_turnos = ($this->si148_turnos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_turnos"] : $this->si148_turnos);
      $this->si148_mes = ($this->si148_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_mes"] : $this->si148_mes);
      $this->si148_instit = ($this->si148_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_instit"] : $this->si148_instit);
    } else {
      $this->si148_sequencial = ($this->si148_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si148_sequencial"] : $this->si148_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si148_sequencial)
  {
    $this->atualizacampos();
    if ($this->si148_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si148_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si148_qtdediasrodados == null) {
      $this->si148_qtdediasrodados = "0";
    }
    if ($this->si148_distanciaestabelecimento == null) {
      $this->si148_distanciaestabelecimento = "0";
    }
    if ($this->si148_numeropassageiros == null) {
      $this->si148_numeropassageiros = "0";
    }
    if ($this->si148_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si148_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si148_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si148_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si148_sequencial == "" || $si148_sequencial == null) {
      $result = db_query("select nextval('cvc302019_si148_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: cvc302019_si148_sequencial_seq do campo: si148_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si148_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from cvc302019_si148_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si148_sequencial)) {
        $this->erro_sql = " Campo si148_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si148_sequencial = $si148_sequencial;
      }
    }
    if (($this->si148_sequencial == null) || ($this->si148_sequencial == "")) {
      $this->erro_sql = " Campo si148_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into cvc302019(
                                       si148_sequencial 
                                      ,si148_tiporegistro 
                                      ,si148_codorgao 
                                      ,si148_codunidadesub 
                                      ,si148_codveiculo 
                                      ,si148_nomeestabelecimento 
                                      ,si148_localidade 
                                      ,si148_qtdediasrodados 
                                      ,si148_distanciaestabelecimento 
                                      ,si148_numeropassageiros 
                                      ,si148_turnos 
                                      ,si148_mes 
                                      ,si148_instit 
                       )
                values (
                                $this->si148_sequencial 
                               ,$this->si148_tiporegistro 
                               ,'$this->si148_codorgao' 
                               ,'$this->si148_codunidadesub' 
                               ,'$this->si148_codveiculo' 
                               ,'$this->si148_nomeestabelecimento' 
                               ,'$this->si148_localidade' 
                               ,$this->si148_qtdediasrodados 
                               ,$this->si148_distanciaestabelecimento 
                               ,$this->si148_numeropassageiros 
                               ,'$this->si148_turnos' 
                               ,$this->si148_mes 
                               ,$this->si148_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "cvc302019 ($this->si148_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "cvc302019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "cvc302019 ($this->si148_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si148_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si148_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2011124,'$this->si148_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010377,2011124,'','" . AddSlashes(pg_result($resaco, 0, 'si148_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011125,'','" . AddSlashes(pg_result($resaco, 0, 'si148_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011126,'','" . AddSlashes(pg_result($resaco, 0, 'si148_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011127,'','" . AddSlashes(pg_result($resaco, 0, 'si148_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011128,'','" . AddSlashes(pg_result($resaco, 0, 'si148_codveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011129,'','" . AddSlashes(pg_result($resaco, 0, 'si148_nomeestabelecimento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011130,'','" . AddSlashes(pg_result($resaco, 0, 'si148_localidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011131,'','" . AddSlashes(pg_result($resaco, 0, 'si148_qtdediasrodados')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011132,'','" . AddSlashes(pg_result($resaco, 0, 'si148_distanciaestabelecimento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011133,'','" . AddSlashes(pg_result($resaco, 0, 'si148_numeropassageiros')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011134,'','" . AddSlashes(pg_result($resaco, 0, 'si148_turnos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011135,'','" . AddSlashes(pg_result($resaco, 0, 'si148_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010377,2011661,'','" . AddSlashes(pg_result($resaco, 0, 'si148_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si148_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update cvc302019 set ";
    $virgula = "";
    if (trim($this->si148_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_sequencial"])) {
      if (trim($this->si148_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si148_sequencial"])) {
        $this->si148_sequencial = "0";
      }
      $sql .= $virgula . " si148_sequencial = $this->si148_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si148_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_tiporegistro"])) {
      $sql .= $virgula . " si148_tiporegistro = $this->si148_tiporegistro ";
      $virgula = ",";
      if (trim($this->si148_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si148_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si148_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_codorgao"])) {
      $sql .= $virgula . " si148_codorgao = '$this->si148_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si148_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_codunidadesub"])) {
      $sql .= $virgula . " si148_codunidadesub = '$this->si148_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si148_codveiculo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_codveiculo"])) {
      $sql .= $virgula . " si148_codveiculo = '$this->si148_codveiculo' ";
      $virgula = ",";
    }
    if (trim($this->si148_nomeestabelecimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_nomeestabelecimento"])) {
      $sql .= $virgula . " si148_nomeestabelecimento = '$this->si148_nomeestabelecimento' ";
      $virgula = ",";
    }
    if (trim($this->si148_localidade) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_localidade"])) {
      $sql .= $virgula . " si148_localidade = '$this->si148_localidade' ";
      $virgula = ",";
    }
    if (trim($this->si148_qtdediasrodados) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_qtdediasrodados"])) {
      if (trim($this->si148_qtdediasrodados) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si148_qtdediasrodados"])) {
        $this->si148_qtdediasrodados = "0";
      }
      $sql .= $virgula . " si148_qtdediasrodados = $this->si148_qtdediasrodados ";
      $virgula = ",";
    }
    if (trim($this->si148_distanciaestabelecimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_distanciaestabelecimento"])) {
      if (trim($this->si148_distanciaestabelecimento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si148_distanciaestabelecimento"])) {
        $this->si148_distanciaestabelecimento = "0";
      }
      $sql .= $virgula . " si148_distanciaestabelecimento = $this->si148_distanciaestabelecimento ";
      $virgula = ",";
    }
    if (trim($this->si148_numeropassageiros) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_numeropassageiros"])) {
      if (trim($this->si148_numeropassageiros) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si148_numeropassageiros"])) {
        $this->si148_numeropassageiros = "0";
      }
      $sql .= $virgula . " si148_numeropassageiros = $this->si148_numeropassageiros ";
      $virgula = ",";
    }
    if (trim($this->si148_turnos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_turnos"])) {
      $sql .= $virgula . " si148_turnos = '$this->si148_turnos' ";
      $virgula = ",";
    }
    if (trim($this->si148_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_mes"])) {
      $sql .= $virgula . " si148_mes = $this->si148_mes ";
      $virgula = ",";
      if (trim($this->si148_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si148_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si148_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si148_instit"])) {
      $sql .= $virgula . " si148_instit = $this->si148_instit ";
      $virgula = ",";
      if (trim($this->si148_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si148_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si148_sequencial != null) {
      $sql .= " si148_sequencial = $this->si148_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si148_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011124,'$this->si148_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_sequencial"]) || $this->si148_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011124,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_sequencial')) . "','$this->si148_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_tiporegistro"]) || $this->si148_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011125,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_tiporegistro')) . "','$this->si148_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_codorgao"]) || $this->si148_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011126,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_codorgao')) . "','$this->si148_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_codunidadesub"]) || $this->si148_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011127,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_codunidadesub')) . "','$this->si148_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_codveiculo"]) || $this->si148_codveiculo != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011128,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_codveiculo')) . "','$this->si148_codveiculo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_nomeestabelecimento"]) || $this->si148_nomeestabelecimento != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011129,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_nomeestabelecimento')) . "','$this->si148_nomeestabelecimento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_localidade"]) || $this->si148_localidade != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011130,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_localidade')) . "','$this->si148_localidade'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_qtdediasrodados"]) || $this->si148_qtdediasrodados != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011131,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_qtdediasrodados')) . "','$this->si148_qtdediasrodados'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_distanciaestabelecimento"]) || $this->si148_distanciaestabelecimento != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011132,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_distanciaestabelecimento')) . "','$this->si148_distanciaestabelecimento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_numeropassageiros"]) || $this->si148_numeropassageiros != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011133,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_numeropassageiros')) . "','$this->si148_numeropassageiros'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_turnos"]) || $this->si148_turnos != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011134,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_turnos')) . "','$this->si148_turnos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_mes"]) || $this->si148_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011135,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_mes')) . "','$this->si148_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si148_instit"]) || $this->si148_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010377,2011661,'" . AddSlashes(pg_result($resaco, $conresaco, 'si148_instit')) . "','$this->si148_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "cvc302019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si148_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "cvc302019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si148_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si148_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si148_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si148_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011124,'$si148_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010377,2011124,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011125,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011126,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011127,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011128,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_codveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011129,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_nomeestabelecimento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011130,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_localidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011131,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_qtdediasrodados')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011132,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_distanciaestabelecimento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011133,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_numeropassageiros')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011134,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_turnos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011135,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010377,2011661,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si148_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from cvc302019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si148_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si148_sequencial = $si148_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "cvc302019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si148_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "cvc302019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si148_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si148_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:cvc302019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si148_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from cvc302019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si148_sequencial != null) {
        $sql2 .= " where cvc302019.si148_sequencial = $si148_sequencial ";
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
  function sql_query_file($si148_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from cvc302019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si148_sequencial != null) {
        $sql2 .= " where cvc302019.si148_sequencial = $si148_sequencial ";
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
