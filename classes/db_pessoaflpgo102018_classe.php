<?
//MODULO: sicom
//CLASSE DA ENTIDADE pessoaflpgo102018
class cl_pessoaflpgo102018 {
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
  var $si193_sequencial = 0;
  var $si193_tiporegistro = 0;
  var $si193_tipodocumento = 0;
  var $si193_nrodocumento = null;
  var $si193_nome = null;
  var $si193_indsexo = null;
  var $si193_datanascimento_dia = null;
  var $si193_datanascimento_mes = null;
  var $si193_datanascimento_ano = null;
  var $si193_datanascimento = null;
  var $si193_tipocadastro = 0;
  var $si193_justalteracao = null;
  var $si193_mes = 0;
  var $si193_inst = 0;
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 si193_sequencial = int8 = si193_sequencial 
                 si193_tiporegistro = int8 = Tipo registro 
                 si193_tipodocumento = int8 = Tipo do documento 
                 si193_nrodocumento = varchar(14) = Número do documento 
                 si193_nome = varchar(120) = Nome da pessoa física 
                 si193_indsexo = varchar(1) = Indica o sexo 
                 si193_datanascimento = date = Data de nascimento 
                 si193_tipocadastro = int8 = Tipo de cadastro 
                 si193_justalteracao = varchar(100) = Justificativa para a alteração 
                 si193_mes = int8 = si193_mes 
                 si193_inst = int8 = si193_inst 
                 ";
  //funcao construtor da classe 
  function cl_pessoaflpgo102018() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("pessoaflpgo102018");
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
      $this->si193_sequencial = ($this->si193_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_sequencial"]:$this->si193_sequencial);
      $this->si193_tiporegistro = ($this->si193_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_tiporegistro"]:$this->si193_tiporegistro);
      $this->si193_tipodocumento = ($this->si193_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_tipodocumento"]:$this->si193_tipodocumento);
      $this->si193_nrodocumento = ($this->si193_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_nrodocumento"]:$this->si193_nrodocumento);
      $this->si193_nome = ($this->si193_nome == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_nome"]:$this->si193_nome);
      $this->si193_indsexo = ($this->si193_indsexo == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_indsexo"]:$this->si193_indsexo);
      if($this->si193_datanascimento == ""){
        $this->si193_datanascimento_dia = ($this->si193_datanascimento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_datanascimento_dia"]:$this->si193_datanascimento_dia);
        $this->si193_datanascimento_mes = ($this->si193_datanascimento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_datanascimento_mes"]:$this->si193_datanascimento_mes);
        $this->si193_datanascimento_ano = ($this->si193_datanascimento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_datanascimento_ano"]:$this->si193_datanascimento_ano);
        if($this->si193_datanascimento_dia != ""){
          $this->si193_datanascimento = $this->si193_datanascimento_ano."-".$this->si193_datanascimento_mes."-".$this->si193_datanascimento_dia;
        }
      }
      $this->si193_tipocadastro = ($this->si193_tipocadastro == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_tipocadastro"]:$this->si193_tipocadastro);
      $this->si193_justalteracao = ($this->si193_justalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_justalteracao"]:$this->si193_justalteracao);
      $this->si193_mes = ($this->si193_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_mes"]:$this->si193_mes);
      $this->si193_inst = ($this->si193_inst == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_inst"]:$this->si193_inst);
    }else{
      $this->si193_sequencial = ($this->si193_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si193_sequencial"]:$this->si193_sequencial);
    }
  }
  // funcao para inclusao
  function incluir ($si193_sequencial){
    $this->atualizacampos();
    if($this->si193_tiporegistro == null ){
      $this->erro_sql = " Campo Tipo registro não informado.";
      $this->erro_campo = "si193_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si193_tipodocumento == null ){
      $this->erro_sql = " Campo Tipo do documento não informado.";
      $this->erro_campo = "si193_tipodocumento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si193_nrodocumento == null ){
      $this->erro_sql = " Campo Número do documento não informado.";
      $this->erro_campo = "si193_nrodocumento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si193_nome == null ){
      $this->erro_sql = " Campo Nome da pessoa física não informado.";
      $this->erro_campo = "si193_nome";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if(trim($this->si193_indsexo) == null && strlen($this->si193_nrodocumento) == 11){
      $this->erro_sql = " Campo Indica o sexo não informado.". $this->si193_nrodocumento;
      $this->erro_campo = "si193_indsexo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si193_datanascimento == null && strlen($this->si193_nrodocumento) == 11){
      $this->erro_sql = " Campo Data de nascimento não informado.";
      $this->erro_campo = "si193_datanascimento_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si193_tipocadastro == null ){
      $this->erro_sql = " Campo Tipo de cadastro não informado.";
      $this->erro_campo = "si193_tipocadastro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si193_mes == null ){
      $this->erro_sql = " Campo si193_mes não informado.";
      $this->erro_campo = "si193_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si193_inst == null ){
      $this->erro_sql = " Campo si193_inst não informado.";
      $this->erro_campo = "si193_inst";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    if($si193_sequencial == "" || $si193_sequencial == null ){
      $result = db_query("select nextval('pessoaflpgo102018_si193_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("
","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: pessoaflpgo102018_si193_sequencial_seq do campo: si193_sequencial";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si193_sequencial = pg_result($result,0,0);
    }else{
      $result = db_query("select last_value from pessoaflpgo102018_si193_sequencial_seq");
      if(($result != false) && (pg_result($result,0,0) < $si193_sequencial)){
        $this->erro_sql = " Campo si193_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }else{
        $this->si193_sequencial = $si193_sequencial;
      }
    }
    if(($this->si193_sequencial == null) || ($this->si193_sequencial == "") ){
      $this->erro_sql = " Campo si193_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into pessoaflpgo102018(
                                       si193_sequencial 
                                      ,si193_tiporegistro 
                                      ,si193_tipodocumento 
                                      ,si193_nrodocumento 
                                      ,si193_nome 
                                      ,si193_indsexo 
                                      ,si193_datanascimento 
                                      ,si193_tipocadastro 
                                      ,si193_justalteracao 
                                      ,si193_mes 
                                      ,si193_inst 
                       )
                values (
                                $this->si193_sequencial 
                               ,$this->si193_tiporegistro 
                               ,$this->si193_tipodocumento 
                               ,'$this->si193_nrodocumento' 
                               ,'$this->si193_nome'
                               ,".($this->si193_indsexo == "null" || $this->si193_indsexo == ""?"null":"'".$this->si193_indsexo."'")."
                               ,".($this->si193_datanascimento == "null" || $this->si193_datanascimento == ""?"null":"'".$this->si193_datanascimento."'")." 
                               ,$this->si193_tipocadastro 
                               ,'$this->si193_justalteracao' 
                               ,$this->si193_mes 
                               ,$this->si193_inst 
                      )";

    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("
","",@pg_last_error());
      if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
        $this->erro_sql   = "pessoaflpgo102018 ($this->si193_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_banco = "pessoaflpgo102018 já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      }else{
        $this->erro_sql   = "pessoaflpgo102018 ($this->si193_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir= 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : ".$this->si193_sequencial;
    $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
    $this->erro_status = "1";
    $this->numrows_incluir= pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si193_sequencial  ));
      if(($resaco!=false)||($this->numrows!=0)){

        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,1009268,'$this->si193_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010193,1009268,'','".AddSlashes(pg_result($resaco,0,'si193_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,0,'si193_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,0,'si193_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009260,'','".AddSlashes(pg_result($resaco,0,'si193_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009261,'','".AddSlashes(pg_result($resaco,0,'si193_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009262,'','".AddSlashes(pg_result($resaco,0,'si193_indsexo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009263,'','".AddSlashes(pg_result($resaco,0,'si193_datanascimento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009264,'','".AddSlashes(pg_result($resaco,0,'si193_tipocadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009265,'','".AddSlashes(pg_result($resaco,0,'si193_justalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009266,'','".AddSlashes(pg_result($resaco,0,'si193_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010193,1009267,'','".AddSlashes(pg_result($resaco,0,'si193_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    return true;
  }
  // funcao para alteracao
  function alterar ($si193_sequencial=null) {
    $this->atualizacampos();
    $sql = " update pessoaflpgo102018 set ";
    $virgula = "";
    if(trim($this->si193_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_sequencial"])){
      $sql  .= $virgula." si193_sequencial = $this->si193_sequencial ";
      $virgula = ",";
      if(trim($this->si193_sequencial) == null ){
        $this->erro_sql = " Campo si193_sequencial não informado.";
        $this->erro_campo = "si193_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si193_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_tiporegistro"])){
      $sql  .= $virgula." si193_tiporegistro = $this->si193_tiporegistro ";
      $virgula = ",";
      if(trim($this->si193_tiporegistro) == null ){
        $this->erro_sql = " Campo Tipo registro não informado.";
        $this->erro_campo = "si193_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si193_tipodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_tipodocumento"])){
      $sql  .= $virgula." si193_tipodocumento = $this->si193_tipodocumento ";
      $virgula = ",";
      if(trim($this->si193_tipodocumento) == null ){
        $this->erro_sql = " Campo Tipo do documento não informado.";
        $this->erro_campo = "si193_tipodocumento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si193_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_nrodocumento"])){
      $sql  .= $virgula." si193_nrodocumento = '$this->si193_nrodocumento' ";
      $virgula = ",";
      if(trim($this->si193_nrodocumento) == null ){
        $this->erro_sql = " Campo Número do documento não informado.";
        $this->erro_campo = "si193_nrodocumento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si193_nome)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_nome"])){
      $sql  .= $virgula." si193_nome = '$this->si193_nome' ";
      $virgula = ",";
      if(trim($this->si193_nome) == null ){
        $this->erro_sql = " Campo Nome da pessoa física não informado.";
        $this->erro_campo = "si193_nome";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si193_indsexo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_indsexo"])){
      $sql  .= $virgula." si193_indsexo = '$this->si193_indsexo' ";
      $virgula = ",";
      if(trim($this->si193_indsexo) == null && strlen($this->si193_nrodocumento) == 11){
        $this->erro_sql = " Campo Indica o sexo não informado.";
        $this->erro_campo = "si193_indsexo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si193_datanascimento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_datanascimento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si193_datanascimento_dia"] !="") ){
      $sql  .= $virgula." si193_datanascimento = '$this->si193_datanascimento' ";
      $virgula = ",";
      if(trim($this->si193_datanascimento) == null ){
        $this->erro_sql = " Campo Data de nascimento não informado.";
        $this->erro_campo = "si193_datanascimento_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if(isset($GLOBALS["HTTP_POST_VARS"]["si193_datanascimento_dia"])){
        $sql  .= $virgula." si193_datanascimento = null ";
        $virgula = ",";
        if(trim($this->si193_datanascimento) == null ){
          $this->erro_sql = " Campo Data de nascimento não informado.";
          $this->erro_campo = "si193_datanascimento_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if(trim($this->si193_tipocadastro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_tipocadastro"])){
      $sql  .= $virgula." si193_tipocadastro = $this->si193_tipocadastro ";
      $virgula = ",";
      if(trim($this->si193_tipocadastro) == null ){
        $this->erro_sql = " Campo Tipo de cadastro não informado.";
        $this->erro_campo = "si193_tipocadastro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si193_justalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_justalteracao"])){
      $sql  .= $virgula." si193_justalteracao = '$this->si193_justalteracao' ";
      $virgula = ",";
    }
    if(trim($this->si193_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_mes"])){
      $sql  .= $virgula." si193_mes = $this->si193_mes ";
      $virgula = ",";
      if(trim($this->si193_mes) == null ){
        $this->erro_sql = " Campo si193_mes não informado.";
        $this->erro_campo = "si193_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si193_inst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si193_inst"])){
      $sql  .= $virgula." si193_inst = $this->si193_inst ";
      $virgula = ",";
      if(trim($this->si193_inst) == null ){
        $this->erro_sql = " Campo si193_inst não informado.";
        $this->erro_campo = "si193_inst";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if($si193_sequencial!=null){
      $sql .= " si193_sequencial = $this->si193_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si193_sequencial));
      if($this->numrows>0){

        for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,1009268,'$this->si193_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_sequencial"]) || $this->si193_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009268,'".AddSlashes(pg_result($resaco,$conresaco,'si193_sequencial'))."','$this->si193_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_tiporegistro"]) || $this->si193_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'si193_tiporegistro'))."','$this->si193_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_tipodocumento"]) || $this->si193_tipodocumento != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009259,'".AddSlashes(pg_result($resaco,$conresaco,'si193_tipodocumento'))."','$this->si193_tipodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_nrodocumento"]) || $this->si193_nrodocumento != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009260,'".AddSlashes(pg_result($resaco,$conresaco,'si193_nrodocumento'))."','$this->si193_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_nome"]) || $this->si193_nome != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009261,'".AddSlashes(pg_result($resaco,$conresaco,'si193_nome'))."','$this->si193_nome',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_indsexo"]) || $this->si193_indsexo != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009262,'".AddSlashes(pg_result($resaco,$conresaco,'si193_indsexo'))."','$this->si193_indsexo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_datanascimento"]) || $this->si193_datanascimento != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009263,'".AddSlashes(pg_result($resaco,$conresaco,'si193_datanascimento'))."','$this->si193_datanascimento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_tipocadastro"]) || $this->si193_tipocadastro != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009264,'".AddSlashes(pg_result($resaco,$conresaco,'si193_tipocadastro'))."','$this->si193_tipocadastro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_justalteracao"]) || $this->si193_justalteracao != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009265,'".AddSlashes(pg_result($resaco,$conresaco,'si193_justalteracao'))."','$this->si193_justalteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_mes"]) || $this->si193_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009266,'".AddSlashes(pg_result($resaco,$conresaco,'si193_mes'))."','$this->si193_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si193_inst"]) || $this->si193_inst != "")
            $resac = db_query("insert into db_acount values($acount,1010193,1009267,'".AddSlashes(pg_result($resaco,$conresaco,'si193_inst'))."','$this->si193_inst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("
","",@pg_last_error());
      $this->erro_sql   = "pessoaflpgo102018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : ".$this->si193_sequencial;
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "pessoaflpgo102018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : ".$this->si193_sequencial;
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : ".$this->si193_sequencial;
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  // funcao para exclusao 
  function excluir ($si193_sequencial=null,$dbwhere=null) {

    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      if ($dbwhere==null || $dbwhere=="") {

        $resaco = $this->sql_record($this->sql_query_file($si193_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
      }
      if (($resaco != false) || ($this->numrows!=0)) {

        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,1009268,'$si193_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009268,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009260,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009261,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009262,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_indsexo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009263,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_datanascimento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009264,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_tipocadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009265,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_justalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009266,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010193,1009267,'','".AddSlashes(pg_result($resaco,$iresaco,'si193_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from pessoaflpgo102018
                    where ";
    $sql2 = "";
    if($dbwhere==null || $dbwhere ==""){
      if($si193_sequencial != ""){
        if($sql2!=""){
          $sql2 .= " and ";
        }
        $sql2 .= " si193_sequencial = $si193_sequencial ";
      }
    }else{
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if($result==false){
      $this->erro_banco = str_replace("
","",@pg_last_error());
      $this->erro_sql   = "pessoaflpgo102018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : ".$si193_sequencial;
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "pessoaflpgo102018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : ".$si193_sequencial;
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : ".$si193_sequencial;
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
      $this->erro_sql   = "Record Vazio na Tabela:pessoaflpgo102018";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  // funcao do sql 
  function sql_query ( $si193_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from pessoaflpgo102018 ";
    $sql2 = "";
    if($dbwhere==""){
      if($si193_sequencial!=null ){
        $sql2 .= " where pessoaflpgo102018.si193_sequencial = $si193_sequencial ";
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
  function sql_query_file ( $si193_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from pessoaflpgo102018 ";
    $sql2 = "";
    if($dbwhere==""){
      if($si193_sequencial!=null ){
        $sql2 .= " where pessoaflpgo102018.si193_sequencial = $si193_sequencial ";
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
