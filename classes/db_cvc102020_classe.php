<?
//MODULO: sicom
//CLASSE DA ENTIDADE cvc102020
class cl_cvc102020
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
  var $si146_sequencial = 0;
  var $si146_tiporegistro = 0;
  var $si146_codorgao = null;
  var $si146_codunidadesub = null;
  var $si146_codveiculo = null;
  var $si146_tpveiculo = null;
  var $si146_subtipoveiculo = null;
  var $si146_descveiculo = null;
  var $si146_marca = null;
  var $si146_modelo = null;
  var $si146_ano = 0;
  var $si146_placa = null;
  var $si146_chassi = null;
  var $si146_numerorenavam = null;
  var $si146_nroserie = null;
  var $si146_situacao = null;
  var $si146_tipodocumento = 0;
  var $si146_nrodocumento = null;
  var $si146_tpdeslocamento = null;
  var $si146_mes = 0;
  var $si146_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si146_sequencial = int8 = sequencial 
                 si146_tiporegistro = int8 = Tipo do  registro 
                 si146_codorgao = varchar(2) = Código do órgão 
                 si146_codunidadesub = varchar(8) = Código da  unidade 
                 si146_codveiculo = varchar(10) = Código do veículo 
                 si146_tpveiculo = varchar(2) = Tipo do veículo 
                 si146_subtipoveiculo = varchar(2) = Subdivisão dos  Veículos 
                 si146_descveiculo = varchar(100) = Descrição do  veículo 
                 si146_marca = varchar(50) = Marca do Veículo 
                 si146_modelo = varchar(50) = Modelo do  Veículo 
                 si146_ano = int8 = Ano do Veículo 
                 si146_placa = varchar(8) = Placa do Veículo 
                 si146_chassi = varchar(30) = Número do  Chassis 
                 si146_numerorenavam = varchar(14) = Número do  RENAVAM
                 si146_nroserie = varchar(20) = Número de Série 
                 si146_situacao = varchar(2) = Situação do  veículo 
                 si146_tipodocumento = int8 = Tipo de documento
                 si146_nrodocumento = varchar(14) = numero documento
                 si146_tpdeslocamento = varchar(2) = Tipo do  deslocamento 
                 si146_mes = int8 = Mês 
                 si146_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_cvc102020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("cvc102020");
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
      $this->si146_sequencial = ($this->si146_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_sequencial"] : $this->si146_sequencial);
      $this->si146_tiporegistro = ($this->si146_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_tiporegistro"] : $this->si146_tiporegistro);
      $this->si146_codorgao = ($this->si146_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_codorgao"] : $this->si146_codorgao);
      $this->si146_codunidadesub = ($this->si146_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_codunidadesub"] : $this->si146_codunidadesub);
      $this->si146_codveiculo = ($this->si146_codveiculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_codveiculo"] : $this->si146_codveiculo);
      $this->si146_tpveiculo = ($this->si146_tpveiculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_tpveiculo"] : $this->si146_tpveiculo);
      $this->si146_subtipoveiculo = ($this->si146_subtipoveiculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_subtipoveiculo"] : $this->si146_subtipoveiculo);
      $this->si146_descveiculo = ($this->si146_descveiculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_descveiculo"] : $this->si146_descveiculo);
      $this->si146_marca = ($this->si146_marca == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_marca"] : $this->si146_marca);
      $this->si146_modelo = ($this->si146_modelo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_modelo"] : $this->si146_modelo);
      $this->si146_ano = ($this->si146_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_ano"] : $this->si146_ano);
      $this->si146_placa = ($this->si146_placa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_placa"] : $this->si146_placa);
      $this->si146_chassi = ($this->si146_chassi == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_chassi"] : $this->si146_chassi);
      $this->si146_numerorenavam = ($this->si146_numerorenavam == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_numerorenavam"] : $this->si146_numerorenavam);
      $this->si146_nroserie = ($this->si146_nroserie == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_nroserie"] : $this->si146_nroserie);
      $this->si146_situacao = ($this->si146_situacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_situacao"] : $this->si146_situacao);
      $this->si146_tipodocumento = ($this->si146_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_tipodocumento"] : $this->si146_tipodocumento);
      $this->si146_nrodocumento = ($this->si146_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_nrodocumento"] : $this->si146_nrodocumento);
      $this->si146_tpdeslocamento = ($this->si146_tpdeslocamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_tpdeslocamento"] : $this->si146_tpdeslocamento);
      $this->si146_mes = ($this->si146_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_mes"] : $this->si146_mes);
      $this->si146_instit = ($this->si146_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_instit"] : $this->si146_instit);
    } else {
      $this->si146_sequencial = ($this->si146_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si146_sequencial"] : $this->si146_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si146_sequencial)
  {
    $this->atualizacampos();
    if ($this->si146_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si146_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si146_ano == null) {
      $this->si146_ano = "0";
    }
    if ($this->si146_numerorenavam == null) {
      $this->si146_numerorenavam = 'null';
    }
    if ($this->si146_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si146_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si146_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si146_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si146_sequencial == "" || $si146_sequencial == null) {
      $result = db_query("select nextval('cvc102020_si146_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: cvc102020_si146_sequencial_seq do campo: si146_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si146_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from cvc102020_si146_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si146_sequencial)) {
        $this->erro_sql = " Campo si146_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si146_sequencial = $si146_sequencial;
      }
    }
    if (($this->si146_sequencial == null) || ($this->si146_sequencial == "")) {
      $this->erro_sql = " Campo si146_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into cvc102020(
                                       si146_sequencial 
                                      ,si146_tiporegistro 
                                      ,si146_codorgao 
                                      ,si146_codunidadesub 
                                      ,si146_codveiculo 
                                      ,si146_tpveiculo 
                                      ,si146_subtipoveiculo 
                                      ,si146_descveiculo 
                                      ,si146_marca 
                                      ,si146_modelo 
                                      ,si146_ano 
                                      ,si146_placa 
                                      ,si146_chassi 
                                      ,si146_numerorenavam 
                                      ,si146_nroserie 
                                      ,si146_situacao 
                                      ,si146_tipodocumento
                                      ,si146_nrodocumento
                                      ,si146_tpdeslocamento 
                                      ,si146_mes 
                                      ,si146_instit 
                       )
                values (
                                $this->si146_sequencial 
                               ,$this->si146_tiporegistro 
                               ,'$this->si146_codorgao' 
                               ,'$this->si146_codunidadesub' 
                               ,'$this->si146_codveiculo' 
                               ,'$this->si146_tpveiculo' 
                               ,'$this->si146_subtipoveiculo' 
                               ,'$this->si146_descveiculo' 
                               ,'$this->si146_marca' 
                               ,'$this->si146_modelo' 
                               ,$this->si146_ano 
                               ,'$this->si146_placa' 
                               ,'$this->si146_chassi' 
                               ,$this->si146_numerorenavam
                               ,'$this->si146_nroserie' 
                               ,'$this->si146_situacao' 
                               ,".($this->si146_tipodocumento == NULL ? 'NULL' : $this->si146_tipodocumento)."
                               ,'$this->si146_nrodocumento'
                               ,'$this->si146_tpdeslocamento' 
                               ,$this->si146_mes 
                               ,$this->si146_instit 
                      )";
    $result = db_query($sql) or die($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "cvc102020 ($this->si146_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "cvc102020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "cvc102020 ($this->si146_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si146_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si146_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2011089,'$this->si146_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010375,2011089,'','" . AddSlashes(pg_result($resaco, 0, 'si146_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011090,'','" . AddSlashes(pg_result($resaco, 0, 'si146_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011091,'','" . AddSlashes(pg_result($resaco, 0, 'si146_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011092,'','" . AddSlashes(pg_result($resaco, 0, 'si146_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011093,'','" . AddSlashes(pg_result($resaco, 0, 'si146_codveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011094,'','" . AddSlashes(pg_result($resaco, 0, 'si146_tpveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011095,'','" . AddSlashes(pg_result($resaco, 0, 'si146_subtipoveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011096,'','" . AddSlashes(pg_result($resaco, 0, 'si146_descveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011097,'','" . AddSlashes(pg_result($resaco, 0, 'si146_marca')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011098,'','" . AddSlashes(pg_result($resaco, 0, 'si146_modelo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011099,'','" . AddSlashes(pg_result($resaco, 0, 'si146_ano')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011100,'','" . AddSlashes(pg_result($resaco, 0, 'si146_placa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011101,'','" . AddSlashes(pg_result($resaco, 0, 'si146_chassi')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011102,'','" . AddSlashes(pg_result($resaco, 0, 'si146_numerorenavam')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011103,'','" . AddSlashes(pg_result($resaco, 0, 'si146_nroserie')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011104,'','" . AddSlashes(pg_result($resaco, 0, 'si146_situacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011105,'','" . AddSlashes(pg_result($resaco, 0, 'si146_tpdeslocamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011106,'','" . AddSlashes(pg_result($resaco, 0, 'si146_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010375,2011659,'','" . AddSlashes(pg_result($resaco, 0, 'si146_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si146_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update cvc102020 set ";
    $virgula = "";
    if (trim($this->si146_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_sequencial"])) {
      if (trim($this->si146_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si146_sequencial"])) {
        $this->si146_sequencial = "0";
      }
      $sql .= $virgula . " si146_sequencial = $this->si146_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si146_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_tiporegistro"])) {
      $sql .= $virgula . " si146_tiporegistro = $this->si146_tiporegistro ";
      $virgula = ",";
      if (trim($this->si146_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si146_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si146_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_codorgao"])) {
      $sql .= $virgula . " si146_codorgao = '$this->si146_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si146_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_codunidadesub"])) {
      $sql .= $virgula . " si146_codunidadesub = '$this->si146_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si146_codveiculo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_codveiculo"])) {
      $sql .= $virgula . " si146_codveiculo = '$this->si146_codveiculo' ";
      $virgula = ",";
    }
    if (trim($this->si146_tpveiculo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_tpveiculo"])) {
      $sql .= $virgula . " si146_tpveiculo = '$this->si146_tpveiculo' ";
      $virgula = ",";
    }
    if (trim($this->si146_subtipoveiculo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_subtipoveiculo"])) {
      $sql .= $virgula . " si146_subtipoveiculo = '$this->si146_subtipoveiculo' ";
      $virgula = ",";
    }
    if (trim($this->si146_descveiculo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_descveiculo"])) {
      $sql .= $virgula . " si146_descveiculo = '$this->si146_descveiculo' ";
      $virgula = ",";
    }
    if (trim($this->si146_marca) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_marca"])) {
      $sql .= $virgula . " si146_marca = '$this->si146_marca' ";
      $virgula = ",";
    }
    if (trim($this->si146_modelo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_modelo"])) {
      $sql .= $virgula . " si146_modelo = '$this->si146_modelo' ";
      $virgula = ",";
    }
    if (trim($this->si146_ano) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_ano"])) {
      if (trim($this->si146_ano) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si146_ano"])) {
        $this->si146_ano = "0";
      }
      $sql .= $virgula . " si146_ano = $this->si146_ano ";
      $virgula = ",";
    }
    if (trim($this->si146_placa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_placa"])) {
      $sql .= $virgula . " si146_placa = '$this->si146_placa' ";
      $virgula = ",";
    }
    if (trim($this->si146_chassi) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_chassi"])) {
      $sql .= $virgula . " si146_chassi = '$this->si146_chassi' ";
      $virgula = ",";
    }
    if (trim($this->si146_numerorenavam) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_numerorenavam"])) {
      if (trim($this->si146_numerorenavam) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si146_numerorenavam"])) {
        $this->si146_numerorenavam = " ";
      }
      $sql .= $virgula . " si146_numerorenavam = $this->si146_numerorenavam ";
      $virgula = ",";
    }
    if (trim($this->si146_nroserie) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_nroserie"])) {
      $sql .= $virgula . " si146_nroserie = '$this->si146_nroserie' ";
      $virgula = ",";
    }
    if (trim($this->si146_situacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_situacao"])) {
      $sql .= $virgula . " si146_situacao = '$this->si146_situacao' ";
      $virgula = ",";
    }
    if (trim($this->si146_tpdeslocamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_tpdeslocamento"])) {
      $sql .= $virgula . " si146_tpdeslocamento = '$this->si146_tpdeslocamento' ";
      $virgula = ",";
    }
    if (trim($this->si146_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_mes"])) {
      $sql .= $virgula . " si146_mes = $this->si146_mes ";
      $virgula = ",";
      if (trim($this->si146_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si146_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si146_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si146_instit"])) {
      $sql .= $virgula . " si146_instit = $this->si146_instit ";
      $virgula = ",";
      if (trim($this->si146_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si146_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si146_sequencial != null) {
      $sql .= " si146_sequencial = $this->si146_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si146_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011089,'$this->si146_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_sequencial"]) || $this->si146_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011089,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_sequencial')) . "','$this->si146_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_tiporegistro"]) || $this->si146_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011090,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_tiporegistro')) . "','$this->si146_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_codorgao"]) || $this->si146_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011091,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_codorgao')) . "','$this->si146_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_codunidadesub"]) || $this->si146_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011092,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_codunidadesub')) . "','$this->si146_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_codveiculo"]) || $this->si146_codveiculo != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011093,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_codveiculo')) . "','$this->si146_codveiculo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_tpveiculo"]) || $this->si146_tpveiculo != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011094,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_tpveiculo')) . "','$this->si146_tpveiculo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_subtipoveiculo"]) || $this->si146_subtipoveiculo != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011095,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_subtipoveiculo')) . "','$this->si146_subtipoveiculo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_descveiculo"]) || $this->si146_descveiculo != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011096,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_descveiculo')) . "','$this->si146_descveiculo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_marca"]) || $this->si146_marca != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011097,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_marca')) . "','$this->si146_marca'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_modelo"]) || $this->si146_modelo != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011098,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_modelo')) . "','$this->si146_modelo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_ano"]) || $this->si146_ano != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011099,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_ano')) . "','$this->si146_ano'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_placa"]) || $this->si146_placa != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011100,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_placa')) . "','$this->si146_placa'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_chassi"]) || $this->si146_chassi != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011101,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_chassi')) . "','$this->si146_chassi'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_numerorenavam"]) || $this->si146_numerorenavam != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011102,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_numerorenavam')) . "','$this->si146_numerorenavam'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_nroserie"]) || $this->si146_nroserie != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011103,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_nroserie')) . "','$this->si146_nroserie'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_situacao"]) || $this->si146_situacao != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011104,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_situacao')) . "','$this->si146_situacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_tpdeslocamento"]) || $this->si146_tpdeslocamento != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011105,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_tpdeslocamento')) . "','$this->si146_tpdeslocamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_mes"]) || $this->si146_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011106,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_mes')) . "','$this->si146_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si146_instit"]) || $this->si146_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010375,2011659,'" . AddSlashes(pg_result($resaco, $conresaco, 'si146_instit')) . "','$this->si146_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "cvc102020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si146_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "cvc102020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si146_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si146_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si146_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si146_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011089,'$si146_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010375,2011089,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011090,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011091,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011092,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011093,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_codveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011094,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_tpveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011095,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_subtipoveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011096,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_descveiculo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011097,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_marca')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011098,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_modelo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011099,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_ano')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011100,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_placa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011101,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_chassi')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011102,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_numerorenavam')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011103,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_nroserie')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011104,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_situacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011105,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_tpdeslocamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011106,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010375,2011659,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si146_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from cvc102020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si146_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si146_sequencial = $si146_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "cvc102020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si146_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "cvc102020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si146_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si146_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:cvc102020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si146_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from cvc102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si146_sequencial != null) {
        $sql2 .= " where cvc102020.si146_sequencial = $si146_sequencial ";
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
  function sql_query_file($si146_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from cvc102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si146_sequencial != null) {
        $sql2 .= " where cvc102020.si146_sequencial = $si146_sequencial ";
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
