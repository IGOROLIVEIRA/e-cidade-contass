<?php
//MODULO: veiculos
//CLASSE DA ENTIDADE transferenciaveiculos
class cl_transferenciaveiculos
{
  // cria variaveis de erro
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status = null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
  // cria variaveis do arquivo
  public $ve80_sequencial = 0;
  public $ve80_motivo = null;
  public $ve80_dt_transferencia_dia = null;
  public $ve80_dt_transferencia_mes = null;
  public $ve80_dt_transferencia_ano = null;
  public $ve80_dt_transferencia = null;
  public $ve80_id_usuario = 0;
  public $ve80_coddeptoatual = 0;
  public $ve80_coddeptodestino = 0;
  public $ve80_hora = null;

  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 ve80_sequencial = int4 = Codigo da Transferencia
                 ve80_motivo = varchar(150) = Motivo
                 ve80_dt_transferencia = date = Data Transferencia
                 ve80_id_usuario = int4 = ve80_id_usuario
                 ve80_coddeptoatual = int4 = Codigo do departamento atual
                 ve80_coddeptodestino = int4 = Codigo do departamento destino
                 ve80_hora = varchar(5) = Horas
                 ";

  //funcao construtor da classe
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("transferenciaveiculos");
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
      $this->ve80_sequencial = ($this->ve80_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve80_sequencial"] : $this->ve80_sequencial);
      $this->ve80_motivo = ($this->ve80_motivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve80_motivo"] : $this->ve80_motivo);
      if ($this->ve80_dt_transferencia == "") {
        $this->ve80_dt_transferencia_dia = ($this->ve80_dt_transferencia_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve80_dt_transferencia_dia"] : $this->ve80_dt_transferencia_dia);
        $this->ve80_dt_transferencia_mes = ($this->ve80_dt_transferencia_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve80_dt_transferencia_mes"] : $this->ve80_dt_transferencia_mes);
        $this->ve80_dt_transferencia_ano = ($this->ve80_dt_transferencia_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve80_dt_transferencia_ano"] : $this->ve80_dt_transferencia_ano);
        if ($this->ve80_dt_transferencia_dia != "") {
          $this->ve80_dt_transferencia = $this->ve80_dt_transferencia_ano . "-" . $this->ve80_dt_transferencia_mes . "-" . $this->ve80_dt_transferencia_dia;
        }
        $this->ve80_hora = date('H:i');
      }
      $this->ve80_id_usuario = ($this->ve80_id_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve80_id_usuario"] : $this->ve80_id_usuario);
      $this->ve80_coddeptoatual = ($this->ve80_coddeptoatual == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve80_coddeptoatual"] : $this->ve80_coddeptoatual);
      $this->ve80_coddeptodestino = ($this->ve80_coddeptodestino == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve80_coddeptodestino"] : $this->ve80_coddeptodestino);
    } else {
      $this->ve80_sequencial = ($this->ve80_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve80_sequencial"] : $this->ve80_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($ve80_sequencial)
  {
    $this->atualizacampos();
    if ($this->ve80_motivo == null) {
      $this->erro_sql = " Campo Motivo não informado.";
      $this->erro_campo = "ve80_motivo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ve80_dt_transferencia == null) {
      $this->erro_sql = " Campo Data Transferencia não informado.";
      $this->erro_campo = "ve80_dt_transferencia_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ve80_id_usuario == null) {
      $this->erro_sql = " Campo ve80_id_usuario não informado.";
      $this->erro_campo = "ve80_id_usuario";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ve80_coddeptoatual == null) {
      $this->erro_sql = " Campo Codigo do departamento atual não informado.";
      $this->erro_campo = "ve80_coddeptoatual";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ve80_coddeptodestino == null) {
      $this->erro_sql = " Campo Codigo do departamento destino não informado.";
      $this->erro_campo = "ve80_coddeptodestino";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($ve80_sequencial == "" || $ve80_sequencial == null) {
      $result = db_query("select nextval('transferenciaveiculos_ve80_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: transferenciaveiculos_ve80_sequencial_seq do campo: ve80_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->ve80_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from transferenciaveiculos_ve80_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $ve80_sequencial)) {
        $this->erro_sql = " Campo ve80_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->ve80_sequencial = $ve80_sequencial;
      }
    }
    if (($this->ve80_sequencial == null) || ($this->ve80_sequencial == "")) {
      $this->erro_sql = " Campo ve80_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    $this->ve80_hora = date('H:i');

    $sql = "insert into transferenciaveiculos(
                                       ve80_sequencial
                                      ,ve80_motivo
                                      ,ve80_dt_transferencia
                                      ,ve80_id_usuario
                                      ,ve80_coddeptoatual
                                      ,ve80_coddeptodestino
                                      ,ve80_hora
                       )
                values (
                                $this->ve80_sequencial
                               ,'$this->ve80_motivo'
                               ," . ($this->ve80_dt_transferencia == "null" || $this->ve80_dt_transferencia == "" ? "null" : "'" . $this->ve80_dt_transferencia . "'") . "
                               ,$this->ve80_id_usuario
                               ,$this->ve80_coddeptoatual
                               ,$this->ve80_coddeptodestino
                               ,'$this->ve80_hora'
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "Transferencia Veiculos ($this->ve80_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "Transferencia Veiculos já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "Transferencia Veiculos ($this->ve80_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->ve80_sequencial;
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
      && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->ve80_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {

        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011771,'$this->ve80_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,2010421,2011771,'','" . AddSlashes(pg_result($resaco, 0, 've80_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010421,2011772,'','" . AddSlashes(pg_result($resaco, 0, 've80_motivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010421,2011773,'','" . AddSlashes(pg_result($resaco, 0, 've80_dt_transferencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010421,2011774,'','" . AddSlashes(pg_result($resaco, 0, 've80_id_usuario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010421,2011775,'','" . AddSlashes(pg_result($resaco, 0, 've80_coddeptoatual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010421,2011776,'','" . AddSlashes(pg_result($resaco, 0, 've80_coddeptodestino')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    return true;
  }

  // funcao para alteracao
  function alterar($ve80_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update transferenciaveiculos set ";
    $virgula = "";
    if (trim($this->ve80_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ve80_sequencial"])) {
      $sql  .= $virgula . " ve80_sequencial = $this->ve80_sequencial ";
      $virgula = ",";
      if (trim($this->ve80_sequencial) == null) {
        $this->erro_sql = " Campo Codigo da Transferencia não informado.";
        $this->erro_campo = "ve80_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ve80_motivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ve80_motivo"])) {
      $sql  .= $virgula . " ve80_motivo = '$this->ve80_motivo' ";
      $virgula = ",";
      if (trim($this->ve80_motivo) == null) {
        $this->erro_sql = " Campo Motivo não informado.";
        $this->erro_campo = "ve80_motivo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ve80_dt_transferencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ve80_dt_transferencia_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ve80_dt_transferencia_dia"] != "")) {
      $sql  .= $virgula . " ve80_dt_transferencia = '$this->ve80_dt_transferencia' ";
      $sql  .= $virgula . " ve80_hora = '$this->ve80_hora' ";
      $virgula = ",";
      if (trim($this->ve80_dt_transferencia) == null) {
        $this->erro_sql = " Campo Data Transferencia não informado.";
        $this->erro_campo = "ve80_dt_transferencia_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["ve80_dt_transferencia_dia"])) {
        $sql  .= $virgula . " ve80_dt_transferencia = null ";
        $virgula = ",";
        if (trim($this->ve80_dt_transferencia) == null) {
          $this->erro_sql = " Campo Data Transferencia não informado.";
          $this->erro_campo = "ve80_dt_transferencia_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->ve80_id_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ve80_id_usuario"])) {
      $sql  .= $virgula . " ve80_id_usuario = $this->ve80_id_usuario ";
      $virgula = ",";
      if (trim($this->ve80_id_usuario) == null) {
        $this->erro_sql = " Campo ve80_id_usuario não informado.";
        $this->erro_campo = "ve80_id_usuario";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ve80_coddeptoatual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ve80_coddeptoatual"])) {
      $sql  .= $virgula . " ve80_coddeptoatual = $this->ve80_coddeptoatual ";
      $virgula = ",";
      if (trim($this->ve80_coddeptoatual) == null) {
        $this->erro_sql = " Campo Codigo do departamento atual não informado.";
        $this->erro_campo = "ve80_coddeptoatual";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ve80_coddeptodestino) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ve80_coddeptodestino"])) {
      $sql  .= $virgula . " ve80_coddeptodestino = $this->ve80_coddeptodestino ";
      $virgula = ",";
      if (trim($this->ve80_coddeptodestino) == null) {
        $this->erro_sql = " Campo Codigo do departamento destino não informado.";
        $this->erro_campo = "ve80_coddeptodestino";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($ve80_sequencial != null) {
      $sql .= " ve80_sequencial = $this->ve80_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
      && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->ve80_sequencial));
      if ($this->numrows > 0) {

        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

          $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac, 0, 0);
          $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
          $resac = db_query("insert into db_acountkey values($acount,2011771,'$this->ve80_sequencial','A')");
          if (isset($GLOBALS["HTTP_POST_VARS"]["ve80_sequencial"]) || $this->ve80_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,2010421,2011771,'" . AddSlashes(pg_result($resaco, $conresaco, 've80_sequencial')) . "','$this->ve80_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["ve80_motivo"]) || $this->ve80_motivo != "")
            $resac = db_query("insert into db_acount values($acount,2010421,2011772,'" . AddSlashes(pg_result($resaco, $conresaco, 've80_motivo')) . "','$this->ve80_motivo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["ve80_dt_transferencia"]) || $this->ve80_dt_transferencia != "")
            $resac = db_query("insert into db_acount values($acount,2010421,2011773,'" . AddSlashes(pg_result($resaco, $conresaco, 've80_dt_transferencia')) . "','$this->ve80_dt_transferencia'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["ve80_id_usuario"]) || $this->ve80_id_usuario != "")
            $resac = db_query("insert into db_acount values($acount,2010421,2011774,'" . AddSlashes(pg_result($resaco, $conresaco, 've80_id_usuario')) . "','$this->ve80_id_usuario'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["ve80_coddeptoatual"]) || $this->ve80_coddeptoatual != "")
            $resac = db_query("insert into db_acount values($acount,2010421,2011775,'" . AddSlashes(pg_result($resaco, $conresaco, 've80_coddeptoatual')) . "','$this->ve80_coddeptoatual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["ve80_coddeptodestino"]) || $this->ve80_coddeptodestino != "")
            $resac = db_query("insert into db_acount values($acount,2010421,2011776,'" . AddSlashes(pg_result($resaco, $conresaco, 've80_coddeptodestino')) . "','$this->ve80_coddeptodestino'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Transferencia Veiculos nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->ve80_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Transferencia Veiculos nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->ve80_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->ve80_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($ve80_sequencial = null, $dbwhere = null)
  {

    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
      && ($lSessaoDesativarAccount === false))) {

      if ($dbwhere == null || $dbwhere == "") {

        $resaco = $this->sql_record($this->sql_query_file($ve80_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {

        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

          $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac, 0, 0);
          $resac  = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
          $resac  = db_query("insert into db_acountkey values($acount,2011771,'$ve80_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,2010421,2011771,'','" . AddSlashes(pg_result($resaco, $iresaco, 've80_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac  = db_query("insert into db_acount values($acount,2010421,2011772,'','" . AddSlashes(pg_result($resaco, $iresaco, 've80_motivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac  = db_query("insert into db_acount values($acount,2010421,2011773,'','" . AddSlashes(pg_result($resaco, $iresaco, 've80_dt_transferencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac  = db_query("insert into db_acount values($acount,2010421,2011774,'','" . AddSlashes(pg_result($resaco, $iresaco, 've80_id_usuario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac  = db_query("insert into db_acount values($acount,2010421,2011775,'','" . AddSlashes(pg_result($resaco, $iresaco, 've80_coddeptoatual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac  = db_query("insert into db_acount values($acount,2010421,2011776,'','" . AddSlashes(pg_result($resaco, $iresaco, 've80_coddeptodestino')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
      }
    }
    $sql = " delete from transferenciaveiculos
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($ve80_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " ve80_sequencial = $ve80_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Transferencia Veiculos nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $ve80_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Transferencia Veiculos nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $ve80_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $ve80_sequencial;
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
      $this->erro_sql   = "Record Vazio na Tabela:transferenciaveiculos";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query($ve80_sequencial = null, $campos = "*", $dbwhere = "", $ordem = null)
  {
    /*$sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#", $campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     } else {
       $sql .= $campos;
     }*/

    /*Adaptações para OC 4072*/
    $sql = "";
    $sql .= "
        SELECT distinct(transferenciaveiculos.ve80_sequencial),
             transferenciaveiculos.ve80_motivo,
             TO_CHAR(transferenciaveiculos.ve80_dt_transferencia, 'DD/MM/YYYY') AS DATA,
             db_depart.descrdepto
        FROM transferenciaveiculos
        INNER JOIN db_depart ON db_depart.coddepto = transferenciaveiculos.ve80_coddeptodestino
        INNER JOIN db_config ON db_config.codigo = db_depart.instit

     ";


    /*$sql .= " from transferenciaveiculos ";
     $sql .= "      inner join db_usuarios on db_usuarios.id_usuario = transferenciaveiculos.ve80_id_usuario";
     $sql .= "      inner join db_depart   on db_depart.coddepto = transferenciaveiculos.ve80_coddeptoatual or  db_depart.coddepto = transferenciaveiculos.ve80_coddeptodestino";
     $sql .= "      inner join db_config   on db_config.codigo = db_depart.instit";*/

    $sql2 = "";
    if ($dbwhere == "") {
      if ($ve80_sequencial != null) {
        $sql2 .= " where transferenciaveiculos.ve80_sequencial = $ve80_sequencial ";
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
    //print_r($sql);die;
    return $sql;
  }

  // funcao do sql
  function sql_query_file($ve80_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from transferenciaveiculos ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($ve80_sequencial != null) {
        $sql2 .= " where transferenciaveiculos.ve80_sequencial = $ve80_sequencial ";
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

  function buscaTransfComprovanteTodos()
  {
    $rsBusca = db_query("
        select t.ve80_sequencial,
               t.ve80_motivo,
               TO_CHAR(t.ve80_dt_transferencia, 'DD/MM/YYYY') as data,
               v.ve81_placa,
               a.descrdepto atual,
               d.descrdepto destino,
               a.nomeresponsavel
          from transferenciaveiculos t
            inner join veiculostransferencia v on v.ve81_transferencia = t.ve80_sequencial
            inner join db_depart a             on a.coddepto           = t.ve80_coddeptoatual
            inner join db_depart d             on d.coddepto           = t.ve80_coddeptodestino
      ");

    return $rsBusca;
  }
}
