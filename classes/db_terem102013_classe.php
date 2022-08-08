<?
//MODULO: sicom
//CLASSE DA ENTIDADE terem102013
class cl_terem102013 {
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
  var $si194_sequencial = 0;
  var $si194_tiporegistro = 0;
  var $si194_cnpj = null;
  var $si194_vlrparateto = 0;
  var $si194_tipocadastro = 0;
  var $si194_dtinicial_dia = null;
  var $si194_dtinicial_mes = null;
  var $si194_dtinicial_ano = null;
  var $si194_dtinicial = null;
  var $si194_dtfinal_dia = null;
  var $si194_dtfinal_mes = null;
  var $si194_dtfinal_ano = null;
  var $si194_dtfinal = null;
  var $si194_justalteracao = null;
  var $si194_mes = 0;
  var $si194_inst = 0;
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 si194_sequencial = int8 = si194_sequencial 
                 si194_tiporegistro = int8 = Tipo registro
                 si194_cnpj = varchar(14) = CNPJ
                 si194_vlrparateto = float8 = Valor para o teto 
                 si194_tipocadastro = int8 = Tipo de cadastro
                 si194_dtinicial = date = Data Inicial
                 si194_dtfinal = date = Data Final
                 si194_justalteracao = varchar(100) = Justificativa para a alteração 
                 si194_mes = int8 = si194_mes 
                 si194_inst = int8 = si194_inst 
                 ";
  //funcao construtor da classe 
  function cl_terem102013() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("terem102013");
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
      $this->si194_sequencial = ($this->si194_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_sequencial"]:$this->si194_sequencial);
      $this->si194_tiporegistro = ($this->si194_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"]:$this->si194_tiporegistro);
      $this->si194_cnpj = ($this->si194_cnpj == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_cnpj"]:$this->si194_cnpj);
      $this->si194_vlrparateto = ($this->si194_vlrparateto == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_vlrparateto"]:$this->si194_vlrparateto);
      $this->si194_tipocadastro = ($this->si194_tipocadastro == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_tipocadastro"]:$this->si194_tipocadastro);
      if($this->te01_dtinicial == ""){
        $this->te01_dtinicial_dia = ($this->te01_dtinicial_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_dia"]:$this->te01_dtinicial_dia);
        $this->te01_dtinicial_mes = ($this->te01_dtinicial_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_mes"]:$this->te01_dtinicial_mes);
        $this->te01_dtinicial_ano = ($this->te01_dtinicial_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_ano"]:$this->te01_dtinicial_ano);
        if($this->te01_dtinicial_dia != ""){
          $this->te01_dtinicial = $this->te01_dtinicial_ano."-".$this->te01_dtinicial_mes."-".$this->te01_dtinicial_dia;
        }
      }
      if($this->te01_dtfinal == ""){
        $this->te01_dtfinal_dia = ($this->te01_dtfinal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtfinal_dia"]:$this->te01_dtfinal_dia);
        $this->te01_dtfinal_mes = ($this->te01_dtfinal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtfinal_mes"]:$this->te01_dtfinal_mes);
        $this->te01_dtfinal_ano = ($this->te01_dtfinal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtfinal_ano"]:$this->te01_dtfinal_ano);
        if($this->te01_dtfinal_dia != ""){
          $this->te01_dtfinal = $this->te01_dtfinal_ano."-".$this->te01_dtfinal_mes."-".$this->te01_dtfinal_dia;
        }
      }
      $this->si194_justalteracao = ($this->si194_justalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_justalteracao"]:$this->si194_justalteracao);
      $this->si194_mes = ($this->si194_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_mes"]:$this->si194_mes);
      $this->si194_inst = ($this->si194_inst == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_inst"]:$this->si194_inst);
    }else{
      $this->si194_sequencial = ($this->si194_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si194_sequencial"]:$this->si194_sequencial);
    }
  }
  // funcao para inclusao
  function incluir ($si194_sequencial){
    $this->atualizacampos();
    if($this->si194_tiporegistro == null ){
      $this->erro_sql = " Campo Tipo registro não informado.";
      $this->erro_campo = "si194_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si194_cnpj == null ){
      $this->erro_sql = " Campo CNPJ não informado.";
      $this->erro_campo = "si194_cnpj";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si194_vlrparateto == null ){
      $this->erro_sql = " Campo Valor para o teto não informado.";
      $this->erro_campo = "si194_vlrparateto";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si194_dtinicial == null ){
      $this->erro_sql = " Campo Data Inicial não informado.";
      $this->erro_campo = "te01_dtinicial_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
//    if($this->si194_dtfinal == null ){
//      $this->erro_sql = " Campo Data Final não informado.";
//      $this->erro_campo = "si194_dtfinal_dia";
//      $this->erro_banco = "";
//      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//      $this->erro_status = "0";
//      return false;
//    }
    if($this->si194_tipocadastro == null ){
      $this->erro_sql = " Campo Tipo de cadastro não informado.";
      $this->erro_campo = "si194_tipocadastro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si194_mes == null ){
      $this->erro_sql = " Campo si194_mes não informado.";
      $this->erro_campo = "si194_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si194_inst == null ){
      $this->erro_sql = " Campo si194_inst não informado.";
      $this->erro_campo = "si194_inst";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($si194_sequencial == "" || $si194_sequencial == null ){
      $result = db_query("select nextval('terem102013_si194_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: terem102013_si194_sequencial_seq do campo: si194_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si194_sequencial = pg_result($result,0,0);
    }else{
      $result = db_query("select last_value from terem102013_si194_sequencial_seq");
      if(($result != false) && (pg_result($result,0,0) < $si194_sequencial)){
        $this->erro_sql = " Campo si194_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }else{
        $this->si194_sequencial = $si194_sequencial;
      }
    }
    if(($this->si194_sequencial == null) || ($this->si194_sequencial == "") ){
      $this->erro_sql = " Campo si194_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into terem102013(
                                       si194_sequencial 
                                      ,si194_tiporegistro
                                      ,si194_cnpj
                                      ,si194_vlrparateto 
                                      ,si194_tipocadastro
                                      ,si194_dtinicial
                                      ,si194_dtfinal
                                      ,si194_justalteracao 
                                      ,si194_mes 
                                      ,si194_inst 
                       )
                values (
                                $this->si194_sequencial 
                               ,$this->si194_tiporegistro
                               ,'$this->si194_cnpj'
                               ,$this->si194_vlrparateto 
                               ,$this->si194_tipocadastro
                               ,'$this->si194_dtinicial'
                               ,".($this->si194_dtfinal == "null" || $this->si194_dtfinal == ""?"null":"'".$this->si194_dtfinal."'")."
                               ,'$this->si194_justalteracao' 
                               ,$this->si194_mes 
                               ,$this->si194_inst 
                      )";

    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
        $this->erro_sql   = "terem102013 ($this->si194_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "terem102013 já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }else{
        $this->erro_sql   = "terem102013 ($this->si194_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir= 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : ".$this->si194_sequencial;
    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir= pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si194_sequencial  ));
      if(($resaco!=false)||($this->numrows!=0)){

        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,1009269,'$this->si194_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010194,1009269,'','".AddSlashes(pg_result($resaco,0,'si194_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009270,'','".AddSlashes(pg_result($resaco,0,'si194_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009271,'','".AddSlashes(pg_result($resaco,0,'si194_vlrparateto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009272,'','".AddSlashes(pg_result($resaco,0,'si194_tipocadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009273,'','".AddSlashes(pg_result($resaco,0,'si194_justalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009274,'','".AddSlashes(pg_result($resaco,0,'si194_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010194,1009275,'','".AddSlashes(pg_result($resaco,0,'si194_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    return true;
  }
  // funcao para alteracao
  function alterar ($si194_sequencial=null) {
    $this->atualizacampos();
    $sql = " update terem102013 set ";
    $virgula = "";
    if(trim($this->si194_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_sequencial"])){
      $sql  .= $virgula." si194_sequencial = $this->si194_sequencial ";
      $virgula = ",";
      if(trim($this->si194_sequencial) == null ){
        $this->erro_sql = " Campo si194_sequencial não informado.";
        $this->erro_campo = "si194_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si194_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"])){
      $sql  .= $virgula." si194_tiporegistro = $this->si194_tiporegistro ";
      $virgula = ",";
      if(trim($this->si194_tiporegistro) == null ){
        $this->erro_sql = " Campo Tipo registro não informado.";
        $this->erro_campo = "si194_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si194_vlrparateto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_vlrparateto"])){
      $sql  .= $virgula." si194_vlrparateto = $this->si194_vlrparateto ";
      $virgula = ",";
      if(trim($this->si194_vlrparateto) == null ){
        $this->erro_sql = " Campo Valor para o teto não informado.";
        $this->erro_campo = "si194_vlrparateto";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si194_tipocadastro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_tipocadastro"])){
      $sql  .= $virgula." si194_tipocadastro = $this->si194_tipocadastro ";
      $virgula = ",";
      if(trim($this->si194_tipocadastro) == null ){
        $this->erro_sql = " Campo Tipo de cadastro não informado.";
        $this->erro_campo = "si194_tipocadastro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si194_justalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_justalteracao"])){
      $sql  .= $virgula." si194_justalteracao = '$this->si194_justalteracao' ";
      $virgula = ",";
    }
    if(trim($this->si194_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_mes"])){
      $sql  .= $virgula." si194_mes = $this->si194_mes ";
      $virgula = ",";
      if(trim($this->si194_mes) == null ){
        $this->erro_sql = " Campo si194_mes não informado.";
        $this->erro_campo = "si194_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si194_inst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si194_inst"])){
      $sql  .= $virgula." si194_inst = $this->si194_inst ";
      $virgula = ",";
      if(trim($this->si194_inst) == null ){
        $this->erro_sql = " Campo si194_inst não informado.";
        $this->erro_campo = "si194_inst";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if($si194_sequencial!=null){
      $sql .= " si194_sequencial = $this->si194_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si194_sequencial));
      if($this->numrows>0){

        for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,1009269,'$this->si194_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si194_sequencial"]) || $this->si194_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009269,'".AddSlashes(pg_result($resaco,$conresaco,'si194_sequencial'))."','$this->si194_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"]) || $this->si194_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009270,'".AddSlashes(pg_result($resaco,$conresaco,'si194_tiporegistro'))."','$this->si194_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si194_vlrparateto"]) || $this->si194_vlrparateto != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009271,'".AddSlashes(pg_result($resaco,$conresaco,'si194_vlrparateto'))."','$this->si194_vlrparateto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si194_tipocadastro"]) || $this->si194_tipocadastro != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009272,'".AddSlashes(pg_result($resaco,$conresaco,'si194_tipocadastro'))."','$this->si194_tipocadastro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si194_justalteracao"]) || $this->si194_justalteracao != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009273,'".AddSlashes(pg_result($resaco,$conresaco,'si194_justalteracao'))."','$this->si194_justalteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si194_mes"]) || $this->si194_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009274,'".AddSlashes(pg_result($resaco,$conresaco,'si194_mes'))."','$this->si194_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si194_inst"]) || $this->si194_inst != "")
            $resac = db_query("insert into db_acount values($acount,1010194,1009275,'".AddSlashes(pg_result($resaco,$conresaco,'si194_inst'))."','$this->si194_inst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "terem102013 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : ".$this->si194_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "terem102013 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : ".$this->si194_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->si194_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  // funcao para exclusao 
  function excluir ($si194_sequencial=null,$dbwhere=null) {

    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      if ($dbwhere==null || $dbwhere=="") {

        $resaco = $this->sql_record($this->sql_query_file($si194_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
      }
      if (($resaco != false) || ($this->numrows!=0)) {

        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,1009269,'$si194_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009269,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009270,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009271,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_vlrparateto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009272,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_tipocadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009273,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_justalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009274,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010194,1009275,'','".AddSlashes(pg_result($resaco,$iresaco,'si194_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from terem102013
                    where ";
    $sql2 = "";
    if($dbwhere==null || $dbwhere ==""){
      if($si194_sequencial != ""){
        if($sql2!=""){
          $sql2 .= " and ";
        }
        $sql2 .= " si194_sequencial = $si194_sequencial ";
      }
    }else{
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "terem102013 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : ".$si194_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "terem102013 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : ".$si194_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$si194_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "Erro ao selecionar os registros.";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->numrows = pg_numrows($result);
    if($this->numrows==0){
      $this->erro_banco = "";
      $this->erro_sql   = "Record Vazio na Tabela:terem102013";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  // funcao do sql 
  function sql_query ( $si194_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
    $sql = "select ";
    if($campos != "*" ){
      $campos_sql = explode("#",$campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }else{
      $sql .= $campos;
    }
    $sql .= " from terem102013 ";
    $sql2 = "";
    if($dbwhere==""){
      if($si194_sequencial!=null ){
        $sql2 .= " where terem102013.si194_sequencial = $si194_sequencial ";
      }
    }else if($dbwhere != ""){
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if($ordem != null ){
      $sql .= " order by ";
      $campos_sql = explode("#",$ordem);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }
  // funcao do sql 
  function sql_query_file ( $si194_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
    $sql = "select ";
    if($campos != "*" ){
      $campos_sql = explode("#",$campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }else{
      $sql .= $campos;
    }
    $sql .= " from terem102013 ";
    $sql2 = "";
    if($dbwhere==""){
      if($si194_sequencial!=null ){
        $sql2 .= " where terem102013.si194_sequencial = $si194_sequencial ";
      }
    }else if($dbwhere != ""){
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if($ordem != null ){
      $sql .= " order by ";
      $campos_sql = explode("#",$ordem);
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
