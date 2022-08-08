<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa102020
class cl_dispensa102020
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
  var $si74_sequencial = 0;
  var $si74_tiporegistro = 0;
  var $si74_codorgaoresp = null;
  var $si74_codunidadesubresp = null;
  var $si74_exercicioprocesso = 0;
  var $si74_nroprocesso = null;
  var $si74_tipoprocesso = 0;
  var $si74_dtabertura_dia = null;
  var $si74_dtabertura_mes = null;
  var $si74_dtabertura_ano = null;
  var $si74_dtabertura = null;
  var $si74_naturezaobjeto = 0;
  var $si74_objeto = null;
  var $si74_justificativa = null;
  var $si74_razao = null;
  var $si74_dtpublicacaotermoratificacao_dia = null;
  var $si74_dtpublicacaotermoratificacao_mes = null;
  var $si74_dtpublicacaotermoratificacao_ano = null;
  var $si74_dtpublicacaotermoratificacao = null;
  var $si74_veiculopublicacao = null;
  var $si74_processoporlote = 0;
  var $si74_tipocadastro = 0;
  var $si74_mes = 0;
  var $si74_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si74_sequencial = int8 = sequencial 
                 si74_tiporegistro = int8 = Tipo do  registro 
                 si74_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si74_codunidadesubresp = varchar(8) = Código da unidade 
                 si74_exercicioprocesso = int8 = Exercício em que foi instaurado 
                 si74_nroprocesso = varchar(12) = Número sequencial  do processo 
                 si74_tipoprocesso = int8 = Tipo de processo 
                 si74_dtabertura = date = Data de abertura 
                 si74_naturezaobjeto = int8 = Natureza do objeto 
                 si74_objeto = varchar(500) = Objeto da  contratação 
                 si74_justificativa = varchar(250) = Justificativa 
                 si74_razao = varchar(250) = Razão 
                 si74_dtpublicacaotermoratificacao = date = Data de Publicação  do Termo 
                 si74_veiculopublicacao = varchar(50) = Nome do veículo 
                 si74_processoporlote = int8 = Processo por Lote 
                 si74_processoporlote = int8 = Tipo de cadastro 
                 si74_mes = int8 = Mês 
                 si74_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_dispensa102020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("dispensa102020");
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
      $this->si74_sequencial = ($this->si74_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_sequencial"] : $this->si74_sequencial);
      $this->si74_tiporegistro = ($this->si74_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_tiporegistro"] : $this->si74_tiporegistro);
      $this->si74_codorgaoresp = ($this->si74_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_codorgaoresp"] : $this->si74_codorgaoresp);
      $this->si74_codunidadesubresp = ($this->si74_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_codunidadesubresp"] : $this->si74_codunidadesubresp);
      $this->si74_exercicioprocesso = ($this->si74_exercicioprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_exercicioprocesso"] : $this->si74_exercicioprocesso);
      $this->si74_nroprocesso = ($this->si74_nroprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_nroprocesso"] : $this->si74_nroprocesso);
      $this->si74_tipoprocesso = ($this->si74_tipoprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_tipoprocesso"] : $this->si74_tipoprocesso);
      if ($this->si74_dtabertura == "") {
        $this->si74_dtabertura_dia = ($this->si74_dtabertura_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_dtabertura_dia"] : $this->si74_dtabertura_dia);
        $this->si74_dtabertura_mes = ($this->si74_dtabertura_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_dtabertura_mes"] : $this->si74_dtabertura_mes);
        $this->si74_dtabertura_ano = ($this->si74_dtabertura_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_dtabertura_ano"] : $this->si74_dtabertura_ano);
        if ($this->si74_dtabertura_dia != "") {
          $this->si74_dtabertura = $this->si74_dtabertura_ano . "-" . $this->si74_dtabertura_mes . "-" . $this->si74_dtabertura_dia;
        }
      }
      $this->si74_naturezaobjeto = ($this->si74_naturezaobjeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_naturezaobjeto"] : $this->si74_naturezaobjeto);
      $this->si74_objeto = ($this->si74_objeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_objeto"] : $this->si74_objeto);
      $this->si74_justificativa = ($this->si74_justificativa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_justificativa"] : $this->si74_justificativa);
      $this->si74_razao = ($this->si74_razao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_razao"] : $this->si74_razao);
      if ($this->si74_dtpublicacaotermoratificacao == "") {
        $this->si74_dtpublicacaotermoratificacao_dia = ($this->si74_dtpublicacaotermoratificacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_dtpublicacaotermoratificacao_dia"] : $this->si74_dtpublicacaotermoratificacao_dia);
        $this->si74_dtpublicacaotermoratificacao_mes = ($this->si74_dtpublicacaotermoratificacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_dtpublicacaotermoratificacao_mes"] : $this->si74_dtpublicacaotermoratificacao_mes);
        $this->si74_dtpublicacaotermoratificacao_ano = ($this->si74_dtpublicacaotermoratificacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_dtpublicacaotermoratificacao_ano"] : $this->si74_dtpublicacaotermoratificacao_ano);
        if ($this->si74_dtpublicacaotermoratificacao_dia != "") {
          $this->si74_dtpublicacaotermoratificacao = $this->si74_dtpublicacaotermoratificacao_ano . "-" . $this->si74_dtpublicacaotermoratificacao_mes . "-" . $this->si74_dtpublicacaotermoratificacao_dia;
        }
      }
      $this->si74_veiculopublicacao = ($this->si74_veiculopublicacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_veiculopublicacao"] : $this->si74_veiculopublicacao);
      $this->si74_processoporlote = ($this->si74_processoporlote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_processoporlote"] : $this->si74_processoporlote);
      $this->si74_tipocadastro = ($this->si74_tipocadastro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_tipocadastro"] : $this->si74_tipocadastro);
      $this->si74_mes = ($this->si74_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_mes"] : $this->si74_mes);
      $this->si74_instit = ($this->si74_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_instit"] : $this->si74_instit);
    } else {
      $this->si74_sequencial = ($this->si74_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si74_sequencial"] : $this->si74_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si74_sequencial)
  {
    $this->atualizacampos();
    if ($this->si74_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si74_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si74_exercicioprocesso == null) {
      $this->si74_exercicioprocesso = "0";
    }
    if ($this->si74_tipoprocesso == null) {
      $this->si74_tipoprocesso = "0";
    }
    if ($this->si74_dtabertura == null) {
      $this->si74_dtabertura = "null";
    }
    if ($this->si74_naturezaobjeto == null) {
      $this->si74_naturezaobjeto = "0";
    }
    if ($this->si74_dtpublicacaotermoratificacao == null) {
      $this->si74_dtpublicacaotermoratificacao = "null";
    }
    if ($this->si74_processoporlote == null) {
      $this->si74_processoporlote = "0";
    }
    if ($this->si74_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si74_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si74_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si74_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si74_sequencial == "" || $si74_sequencial == null) {
      $result = db_query("select nextval('dispensa102020_si74_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: dispensa102020_si74_sequencial_seq do campo: si74_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si74_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from dispensa102020_si74_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si74_sequencial)) {
        $this->erro_sql = " Campo si74_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si74_sequencial = $si74_sequencial;
      }
    }
    if (($this->si74_sequencial == null) || ($this->si74_sequencial == "")) {
      $this->erro_sql = " Campo si74_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if(!$this->si74_tipocadastro){
      $this->si74_tipocadastro = 1;
    }
    $sql = "insert into dispensa102020(
                                       si74_sequencial 
                                      ,si74_tiporegistro 
                                      ,si74_codorgaoresp 
                                      ,si74_codunidadesubresp 
                                      ,si74_exercicioprocesso 
                                      ,si74_nroprocesso 
                                      ,si74_tipoprocesso 
                                      ,si74_dtabertura 
                                      ,si74_naturezaobjeto 
                                      ,si74_objeto 
                                      ,si74_justificativa 
                                      ,si74_razao 
                                      ,si74_dtpublicacaotermoratificacao 
                                      ,si74_veiculopublicacao 
                                      ,si74_processoporlote
                                      ,si74_tipocadastro
                                      ,si74_mes 
                                      ,si74_instit 
                       )
                values (
                                $this->si74_sequencial 
                               ,$this->si74_tiporegistro 
                               ,'$this->si74_codorgaoresp' 
                               ,'$this->si74_codunidadesubresp' 
                               ,$this->si74_exercicioprocesso 
                               ,'$this->si74_nroprocesso' 
                               ,$this->si74_tipoprocesso 
                               ," . ($this->si74_dtabertura == "null" || $this->si74_dtabertura == "" ? "" : "'" . $this->si74_dtabertura . "'") . " 
                               ,$this->si74_naturezaobjeto 
                               ,'$this->si74_objeto' 
                               ,'$this->si74_justificativa' 
                               ,'$this->si74_razao' 
                               ," . ($this->si74_dtpublicacaotermoratificacao == "null" || $this->si74_dtpublicacaotermoratificacao == "" ? "null" : "'" . $this->si74_dtpublicacaotermoratificacao . "'") . " 
                               ,'$this->si74_veiculopublicacao' 
                               ,$this->si74_processoporlote 
                               ,$this->si74_tipocadastro 
                               ,$this->si74_mes 
                               ,$this->si74_instit 
                      )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "dispensa102020 ($this->si74_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "dispensa102020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "dispensa102020 ($this->si74_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si74_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si74_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010255,'$this->si74_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010303,2010255,'','" . AddSlashes(pg_result($resaco, 0, 'si74_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010256,'','" . AddSlashes(pg_result($resaco, 0, 'si74_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010257,'','" . AddSlashes(pg_result($resaco, 0, 'si74_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010258,'','" . AddSlashes(pg_result($resaco, 0, 'si74_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010259,'','" . AddSlashes(pg_result($resaco, 0, 'si74_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010260,'','" . AddSlashes(pg_result($resaco, 0, 'si74_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010261,'','" . AddSlashes(pg_result($resaco, 0, 'si74_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010262,'','" . AddSlashes(pg_result($resaco, 0, 'si74_dtabertura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010263,'','" . AddSlashes(pg_result($resaco, 0, 'si74_naturezaobjeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010264,'','" . AddSlashes(pg_result($resaco, 0, 'si74_objeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010265,'','" . AddSlashes(pg_result($resaco, 0, 'si74_justificativa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010266,'','" . AddSlashes(pg_result($resaco, 0, 'si74_razao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010267,'','" . AddSlashes(pg_result($resaco, 0, 'si74_dtpublicacaotermoratificacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010268,'','" . AddSlashes(pg_result($resaco, 0, 'si74_veiculopublicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010269,'','" . AddSlashes(pg_result($resaco, 0, 'si74_processoporlote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2010270,'','" . AddSlashes(pg_result($resaco, 0, 'si74_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010303,2011586,'','" . AddSlashes(pg_result($resaco, 0, 'si74_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si74_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update dispensa102020 set ";
    $virgula = "";
    if (trim($this->si74_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_sequencial"])) {
      if (trim($this->si74_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_sequencial"])) {
        $this->si74_sequencial = "0";
      }
      $sql .= $virgula . " si74_sequencial = $this->si74_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si74_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_tiporegistro"])) {
      $sql .= $virgula . " si74_tiporegistro = $this->si74_tiporegistro ";
      $virgula = ",";
      if (trim($this->si74_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si74_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si74_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_codorgaoresp"])) {
      $sql .= $virgula . " si74_codorgaoresp = '$this->si74_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si74_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_codunidadesubresp"])) {
      $sql .= $virgula . " si74_codunidadesubresp = '$this->si74_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si74_exercicioprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_exercicioprocesso"])) {
      if (trim($this->si74_exercicioprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_exercicioprocesso"])) {
        $this->si74_exercicioprocesso = "0";
      }
      $sql .= $virgula . " si74_exercicioprocesso = $this->si74_exercicioprocesso ";
      $virgula = ",";
    }
    if (trim($this->si74_nroprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_nroprocesso"])) {
      $sql .= $virgula . " si74_nroprocesso = '$this->si74_nroprocesso' ";
      $virgula = ",";
    }
    if (trim($this->si74_tipoprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_tipoprocesso"])) {
      if (trim($this->si74_tipoprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_tipoprocesso"])) {
        $this->si74_tipoprocesso = "0";
      }
      $sql .= $virgula . " si74_tipoprocesso = $this->si74_tipoprocesso ";
      $virgula = ",";
    }
    if (trim($this->si74_dtabertura) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_dtabertura_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si74_dtabertura_dia"] != "")) {
      $sql .= $virgula . " si74_dtabertura = '$this->si74_dtabertura' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si74_dtabertura_dia"])) {
        $sql .= $virgula . " si74_dtabertura = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si74_naturezaobjeto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_naturezaobjeto"])) {
      if (trim($this->si74_naturezaobjeto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_naturezaobjeto"])) {
        $this->si74_naturezaobjeto = "0";
      }
      $sql .= $virgula . " si74_naturezaobjeto = $this->si74_naturezaobjeto ";
      $virgula = ",";
    }
    if (trim($this->si74_objeto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_objeto"])) {
      $sql .= $virgula . " si74_objeto = '$this->si74_objeto' ";
      $virgula = ",";
    }
    if (trim($this->si74_justificativa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_justificativa"])) {
      $sql .= $virgula . " si74_justificativa = '$this->si74_justificativa' ";
      $virgula = ",";
    }
    if (trim($this->si74_razao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_razao"])) {
      $sql .= $virgula . " si74_razao = '$this->si74_razao' ";
      $virgula = ",";
    }
    if (trim($this->si74_dtpublicacaotermoratificacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_dtpublicacaotermoratificacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si74_dtpublicacaotermoratificacao_dia"] != "")) {
      $sql .= $virgula . " si74_dtpublicacaotermoratificacao = '$this->si74_dtpublicacaotermoratificacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si74_dtpublicacaotermoratificacao_dia"])) {
        $sql .= $virgula . " si74_dtpublicacaotermoratificacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si74_veiculopublicacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_veiculopublicacao"])) {
      $sql .= $virgula . " si74_veiculopublicacao = '$this->si74_veiculopublicacao' ";
      $virgula = ",";
    }
    if (trim($this->si74_processoporlote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_processoporlote"])) {
      if (trim($this->si74_processoporlote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_processoporlote"])) {
        $this->si74_processoporlote = "0";
      }
      $sql .= $virgula . " si74_processoporlote = $this->si74_processoporlote ";
      $virgula = ",";
    }
    if (trim($this->si74_tipocadastro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_tipocadastro"])) {
      if (trim($this->si74_tipocadastro) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si74_tipocadastro"])) {
        $this->si74_tipocadastro = "1";
      }
      $sql .= $virgula . " si74_tipocadastro = $this->si74_tipocadastro ";
      $virgula = ",";
    }
    if (trim($this->si74_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_mes"])) {
      $sql .= $virgula . " si74_mes = $this->si74_mes ";
      $virgula = ",";
      if (trim($this->si74_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si74_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si74_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si74_instit"])) {
      $sql .= $virgula . " si74_instit = $this->si74_instit ";
      $virgula = ",";
      if (trim($this->si74_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si74_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si74_sequencial != null) {
      $sql .= " si74_sequencial = $this->si74_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si74_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010255,'$this->si74_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_sequencial"]) || $this->si74_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010255,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_sequencial')) . "','$this->si74_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_tiporegistro"]) || $this->si74_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010256,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_tiporegistro')) . "','$this->si74_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_codorgaoresp"]) || $this->si74_codorgaoresp != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010257,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_codorgaoresp')) . "','$this->si74_codorgaoresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_codunidadesubresp"]) || $this->si74_codunidadesubresp != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010258,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_codunidadesubresp')) . "','$this->si74_codunidadesubresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_exercicioprocesso"]) || $this->si74_exercicioprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010259,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_exercicioprocesso')) . "','$this->si74_exercicioprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_nroprocesso"]) || $this->si74_nroprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010260,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_nroprocesso')) . "','$this->si74_nroprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_tipoprocesso"]) || $this->si74_tipoprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010261,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_tipoprocesso')) . "','$this->si74_tipoprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_dtabertura"]) || $this->si74_dtabertura != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010262,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_dtabertura')) . "','$this->si74_dtabertura'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_naturezaobjeto"]) || $this->si74_naturezaobjeto != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010263,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_naturezaobjeto')) . "','$this->si74_naturezaobjeto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_objeto"]) || $this->si74_objeto != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010264,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_objeto')) . "','$this->si74_objeto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_justificativa"]) || $this->si74_justificativa != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010265,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_justificativa')) . "','$this->si74_justificativa'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_razao"]) || $this->si74_razao != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010266,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_razao')) . "','$this->si74_razao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_dtpublicacaotermoratificacao"]) || $this->si74_dtpublicacaotermoratificacao != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010267,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_dtpublicacaotermoratificacao')) . "','$this->si74_dtpublicacaotermoratificacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_veiculopublicacao"]) || $this->si74_veiculopublicacao != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010268,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_veiculopublicacao')) . "','$this->si74_veiculopublicacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_processoporlote"]) || $this->si74_processoporlote != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010269,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_processoporlote')) . "','$this->si74_processoporlote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_mes"]) || $this->si74_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2010270,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_mes')) . "','$this->si74_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si74_instit"]) || $this->si74_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010303,2011586,'" . AddSlashes(pg_result($resaco, $conresaco, 'si74_instit')) . "','$this->si74_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa102020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si74_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa102020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si74_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si74_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si74_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si74_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010255,'$si74_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010303,2010255,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010256,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010257,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010258,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010259,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010260,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010261,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010262,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_dtabertura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010263,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_naturezaobjeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010264,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_objeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010265,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_justificativa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010266,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_razao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010267,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_dtpublicacaotermoratificacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010268,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_veiculopublicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010269,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_processoporlote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2010270,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010303,2011586,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si74_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from dispensa102020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si74_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si74_sequencial = $si74_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa102020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si74_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa102020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si74_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si74_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:dispensa102020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si74_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si74_sequencial != null) {
        $sql2 .= " where dispensa102020.si74_sequencial = $si74_sequencial ";
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
  function sql_query_file($si74_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si74_sequencial != null) {
        $sql2 .= " where dispensa102020.si74_sequencial = $si74_sequencial ";
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
