<?
//MODULO: sicom
//CLASSE DA ENTIDADE terem202021
class cl_terem202021 {
  // cria variaveis de erro 
  var $rotulo     = null;
  var $query_sql  = null;
  var $numrows    = 0;
  var $numrows_incluir = 0;
  var $numrows_alterar = 0;
  var $numrows_excluir = 0;
  var $erro_status= null;
  var $erro_sql   = null;
  var $erro_banco = null;
  var $erro_msg   = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo 
  var $si196_sequencial = 0;
  var $si196_tiporegistro = 0;
  var $si196_codteto = 0;
  var $si196_vlrparateto = 0;
  var $si196_nrleiteto = null;
  var $si196_tipocadastro = 0;
  var $si196_dtpublicacaolei_dia = null;
  var $si196_dtpublicacaolei_mes = null;
  var $si196_dtpublicacaolei_ano = null;
  var $si196_dtpublicacaolei = null;
  var $si196_justalteracaoteto = null;
  var $si196_mes = 0;
  var $si196_inst = 0;
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 si196_sequencial = int8 = si196_sequencial 
                 si196_tiporegistro = int8 = Tipo registro
                 si196_codteto = int8 = Código do Teto remuneratório
                 si196_vlrparateto = float8 = Valor para o teto remuneratório 
                 si196_nrleiteto = int8 = Número da lei do teto
                 si196_dtpublicacaolei = date = Data da publicação
                 si196_justalteracaoteto = varchar(250) = Justificativa para a alteração 
                 si196_mes = int8 = si196_mes 
                 si196_inst = int8 = si196_inst 
                 ";
  //funcao construtor da classe 
  function cl_terem202021() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("terem202021");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }
  //funcao erro 
  function erro($mostra,$retorna) {
    if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
      echo "<script>alert(\"".$this->erro_msg."\");</script>";
      if($retorna==true){
        echo "<script>location.href='".$this->pagina_retorno."'</script>";
      }
    }
  }
  // funcao para atualizar campos
  function atualizacampos($exclusao=false) {
    if($exclusao==false){
      $this->si196_sequencial = ($this->si196_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_sequencial"]:$this->si196_sequencial);
      $this->si196_tiporegistro = ($this->si196_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_tiporegistro"]:$this->si196_tiporegistro);
      $this->si196_codteto = ($this->si196_codteto == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_codteto"]:$this->si196_codteto);
      $this->si196_vlrparateto = ($this->si196_vlrparateto == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_vlrparateto"]:$this->si196_vlrparateto);
      $this->si196_nrleiteto = ($this->si196_nrleiteto == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_nrleiteto"]:$this->si196_nrleiteto);
      if($this->te01_dtinicial == ""){
        $this->te01_dtinicial_dia = ($this->te01_dtinicial_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_dia"]:$this->te01_dtinicial_dia);
        $this->te01_dtinicial_mes = ($this->te01_dtinicial_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_mes"]:$this->te01_dtinicial_mes);
        $this->te01_dtinicial_ano = ($this->te01_dtinicial_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_ano"]:$this->te01_dtinicial_ano);
        if($this->te01_dtinicial_dia != ""){
          $this->te01_dtinicial = $this->te01_dtinicial_ano."-".$this->te01_dtinicial_mes."-".$this->te01_dtinicial_dia;
        }
      }
      $this->si196_justalteracaotetoteto = ($this->si196_justalteracaotetoteto == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_justalteracaotetoteto"]:$this->si196_justalteracaoteto);
    }else{
      $this->si196_sequencial = ($this->si196_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_sequencial"]:$this->si196_sequencial);
    }
  }
  // funcao para inclusao
  function  incluir ($si196_sequencial){
    $this->atualizacampos();
    if($this->si196_tiporegistro == null ){
      $this->erro_sql = " Campo Tipo registro não informado.";
      $this->erro_campo = "si196_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_codteto == null ){
      $this->erro_sql = " Campo Código do Teto não informado.";
      $this->erro_campo = "si196_codteto";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_vlrparateto == null ){
      $this->erro_sql = " Campo Valor para o teto não informado.";
      $this->erro_campo = "si196_vlrparateto";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_nrleiteto == null ){
      $this->erro_sql = " Campo Número da lei do teto não informado.";
      $this->erro_campo = "si196_nrleiteto";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }


    if($this->si196_dtpublicacaolei == null ){
      $this->erro_sql = " Campo Data prevista de retorno do afastamento não informado.";
      $this->erro_campo = "te01_dtpublicacaolei_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }

//    if($this->si196_dtfinal == null ){
//      $this->erro_sql = " Campo Data Final não informado.";
//      $this->erro_campo = "si196_dtfinal_dia";
//      $this->erro_banco = "";
//      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
//      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
//      $this->erro_status = "0";
//      return false;
//    }
    if($this->si196_tipocadastro == null ){
      $this->erro_sql = " Campo Tipo de cadastro não informado.";
      $this->erro_campo = "si196_tipocadastro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_mes == null ){
      $this->erro_sql = " Campo si196_mes não informado.";
      $this->erro_campo = "si196_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_inst == null ){
      $this->erro_sql = " Campo si196_inst não informado.";
      $this->erro_campo = "si196_inst";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }

    if($si196_sequencial == "" || $si196_sequencial == null ){
      $result = db_query("select nextval('terem202021_si196_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("
","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: terem202021_si196_sequencial_seq do campo: si196_sequencial";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si196_sequencial = pg_result($result,0,0);
    }else{
      $result = db_query("select last_value from terem202021_si196_sequencial_seq");
      if(($result != false) && (pg_result($result,0,0) < $si196_sequencial)){
        $this->erro_sql = " Campo si196_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }else{
        $this->si196_sequencial = $si196_sequencial;
      }
    }
    if(($this->si196_sequencial == null) || ($this->si196_sequencial == "") ){
      $this->erro_sql = " Campo si196_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into terem202021(
                                       si196_sequencial 
                                      ,si196_tiporegistro
                                      ,si196_codteto
                                      ,si196_vlrparateto 
                                      ,si196_nrleiteto
                                      ,si196_dtpublicacaolei
                                      ,si196_justalteracaoteto 
                                      ,si196_mes 
                                      ,si196_inst 
                       )
                values (
                                $this->si196_sequencial 
                               ,$this->si196_tiporegistro
                               ,'$this->si196_codteto'
                               ,$this->si196_vlrparateto 
                               ,$this->si196_nrleiteto
                               ,".($this->si196_dtpublicacaolei == "null" || $this->si196_dtpublicacaolei == ""?"null":"'".$this->si196_dtpublicacaolei."'")."
                               ,'$this->si196_justalteracaoteto' 
                               ,$this->si196_mes 
                               ,$this->si196_inst 
                      )";

    $result = db_query($sql);

    if($result==false){
      $this->erro_banco = str_replace("","",@pg_last_error());
      if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
        $this->erro_sql   = "terem202021 ($this->si196_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_banco = "terem202021 já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      }else{
        $this->erro_sql   = "terem202021 ($this->si196_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir= 0;
      return false;
    }

    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : ".$this->si196_sequencial;
    $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
    $this->erro_status = "1";
    $this->numrows_incluir= pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si196_sequencial  ));
      if(($resaco!=false)||($this->numrows!=0)){

        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,1009269,'$this->si196_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010194,1009269,'','".AddSlashes(pg_result($resaco,0,'si196_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009270,'','".AddSlashes(pg_result($resaco,0,'si196_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009271,'','".AddSlashes(pg_result($resaco,0,'si196_vlrparateto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009272,'','".AddSlashes(pg_result($resaco,0,'si196_tipocadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009273,'','".AddSlashes(pg_result($resaco,0,'si196_justalteracaoteto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009274,'','".AddSlashes(pg_result($resaco,0,'si196_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009275,'','".AddSlashes(pg_result($resaco,0,'si196_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    return true;
  }
  // funcao para alteracao
  function alterar ($si196_sequencial=null) {
    $this->atualizacampos();
    $sql = " update terem202021 set ";
    $virgula = "";
    if(trim($this->si196_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_sequencial"])){
      $sql  .= $virgula." si196_sequencial = $this->si196_sequencial ";
      $virgula = ",";
      if(trim($this->si196_sequencial) == null ){
        $this->erro_sql = " Campo si196_sequencial não informado.";
        $this->erro_campo = "si196_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si196_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_tiporegistro"])){
      $sql  .= $virgula." si196_tiporegistro = $this->si196_tiporegistro ";
      $virgula = ",";
      if(trim($this->si196_tiporegistro) == null ){
        $this->erro_sql = " Campo Tipo registro não informado.";
        $this->erro_campo = "si196_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si196_vlrparateto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_vlrparateto"])){
      $sql  .= $virgula." si196_vlrparateto = $this->si196_vlrparateto ";
      $virgula = ",";
      if(trim($this->si196_vlrparateto) == null ){
        $this->erro_sql = " Campo Valor para o teto não informado.";
        $this->erro_campo = "si196_vlrparateto";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si196_justalteracaoteto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_justalteracaoteto"])){
      $sql  .= $virgula." si196_justalteracaoteto = '$this->si196_justalteracaoteto' ";
      $virgula = ",";
    }
    if(trim($this->si196_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_mes"])){
      $sql  .= $virgula." si196_mes = $this->si196_mes ";
      $virgula = ",";
      if(trim($this->si196_mes) == null ){
        $this->erro_sql = " Campo si196_mes não informado.";
        $this->erro_campo = "si196_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si196_inst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_inst"])){
      $sql  .= $virgula." si196_inst = $this->si196_inst ";
      $virgula = ",";
      if(trim($this->si196_inst) == null ){
        $this->erro_sql = " Campo si196_inst não informado.";
        $this->erro_campo = "si196_inst";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if($si196_sequencial!=null){
      $sql .= " si196_sequencial = $this->si196_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si196_sequencial));
      if($this->numrows>0){

        for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,1009269,'$this->si196_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_sequencial"]) || $this->si196_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009269,'".AddSlashes(pg_result($resaco,$conresaco,'si196_sequencial'))."','$this->si196_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_tiporegistro"]) || $this->si196_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009270,'".AddSlashes(pg_result($resaco,$conresaco,'si196_tiporegistro'))."','$this->si196_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_vlrparateto"]) || $this->si196_vlrparateto != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009271,'".AddSlashes(pg_result($resaco,$conresaco,'si196_vlrparateto'))."','$this->si196_vlrparateto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_tipocadastro"]) || $this->si196_tipocadastro != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009272,'".AddSlashes(pg_result($resaco,$conresaco,'si196_tipocadastro'))."','$this->si196_tipocadastro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_justalteracaoteto"]) || $this->si196_justalteracaoteto != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009273,'".AddSlashes(pg_result($resaco,$conresaco,'si196_justalteracaoteto'))."','$this->si196_justalteracaoteto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_mes"]) || $this->si196_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009274,'".AddSlashes(pg_result($resaco,$conresaco,'si196_mes'))."','$this->si196_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_inst"]) || $this->si196_inst != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009275,'".AddSlashes(pg_result($resaco,$conresaco,'si196_inst'))."','$this->si196_inst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("
","",@pg_last_error());
      $this->erro_sql   = "terem202021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : ".$this->si196_sequencial;
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "terem202021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : ".$this->si196_sequencial;
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : ".$this->si196_sequencial;
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  // funcao para exclusao 
  function excluir ($si196_sequencial=null,$dbwhere=null) {

    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      if ($dbwhere==null || $dbwhere=="") {

        $resaco = $this->sql_record($this->sql_query_file($si196_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
      }
      if (($resaco != false) || ($this->numrows!=0)) {

        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,1009269,'$si196_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009269,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009270,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009271,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_vlrparateto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009272,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_tipocadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009273,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_justalteracaoteto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009274,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009275,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from terem202021
                    where ";
    $sql2 = "";
    if($dbwhere==null || $dbwhere ==""){
      if($si196_sequencial != ""){
        if($sql2!=""){
          $sql2 .= " and ";
        }
        $sql2 .= " si196_sequencial = $si196_sequencial ";
      }
    }else{
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if($result==false){
      $this->erro_banco = str_replace("
","",@pg_last_error());
      $this->erro_sql   = "terem202021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : ".$si196_sequencial;
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "terem202021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : ".$si196_sequencial;
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : ".$si196_sequencial;
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);
        return true;
      }
    }
  }
  // funcao do recordset 
  function sql_record($sql) {
    $result = db_query($sql);
    if($result==false){
      $this->numrows    = 0;
      $this->erro_banco = str_replace("
","",@pg_last_error());
      $this->erro_sql   = "Erro ao selecionar os registros.";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    $this->numrows = pg_numrows($result);
    if($this->numrows==0){
      $this->erro_banco = "";
      $this->erro_sql   = "Record Vazio na Tabela:terem202021";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  // funcao do sql 
  function sql_query ( $si196_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
    $sql = "select ";
    if($campos != "*" ){
      $campos_sql = split("#",$campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }else{
      $sql .= $campos;
    }
    $sql .= " from terem202021 ";
    $sql2 = "";
    if($dbwhere==""){
      if($si196_sequencial!=null ){
        $sql2 .= " where terem202021.si196_sequencial = $si196_sequencial ";
      }
    }else if($dbwhere != ""){
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if($ordem != null ){
      $sql .= " order by ";
      $campos_sql = split("#",$ordem);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }
  // funcao do sql 
  function sql_query_file ( $si196_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
    $sql = "select ";
    if($campos != "*" ){
      $campos_sql = split("#",$campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }else{
      $sql .= $campos;
    }
    $sql .= " from terem202021 ";
    $sql2 = "";
    if($dbwhere==""){
      if($si196_sequencial!=null ){
        $sql2 .= " where terem202021.si196_sequencial = $si196_sequencial ";
      }
    }else if($dbwhere != ""){
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if($ordem != null ){
      $sql .= " order by ";
      $campos_sql = split("#",$ordem);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }
}
?>
