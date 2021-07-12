<?
//MODULO: sicom
//CLASSE DA ENTIDADE flpgo112013
class cl_flpgo112013 {
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
  var $si196_nrodocumento = 0;
  var $si196_codreduzidopessoa = 0;
  var $si196_tiporemuneracao = 0;
  var $si196_desctiporemuneracao = null;
  var $si196_vlrremuneracaodetalhada = 0;
  var $si196_mes = 0;
  var $si196_inst = 0;
  var $si196_reg10 = 0;

  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 si196_sequencial = int8 = si196_sequencial 
                 si196_tiporegistro = int8 = Tipo registro 
                 si196_nrodocumento = int8 = Número do CPF ou CNPJ
                 si196_codreduzidopessoa = int8 = Código identificador da pessoa
                 si196_tiporemuneracao = int8 = Tipo da remuneração 
                 si196_desctiporemuneracao = varchar(150) = Descrição para o tipo outros
                 si196_vlrremuneracaodetalhada = float8 = Valor dos rendimentos por tipo 
                 si196_mes = int8 = si196_mes 
                 si196_inst = int8 = si196_inst 
                 si196_reg10 = int8 = si196_reg10 
                 ";
  //funcao construtor da classe 
  function cl_flpgo112013() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("flpgo112013");
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
      $this->si196_nrodocumento = ($this->si196_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_nrodocumento"]:$this->si196_nrodocumento);
      $this->si196_tiporemuneracao = ($this->si196_tiporemuneracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_tiporemuneracao"]:$this->si196_tiporemuneracao);
      $this->si196_desctiporemuneracao = ($this->si196_desctiporemuneracao == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_desctiporemuneracao"]:$this->si196_desctiporemuneracao);
      $this->si196_vlrremuneracaodetalhada = ($this->si196_vlrremuneracaodetalhada == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_vlrremuneracaodetalhada"]:$this->si196_vlrremuneracaodetalhada);
      $this->si196_mes = ($this->si196_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_mes"]:$this->si196_mes);
      $this->si196_inst = ($this->si196_inst == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_inst"]:$this->si196_inst);
      $this->si196_reg10 = ($this->si196_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_reg10"]:$this->si196_reg10);
    }else{
      $this->si196_sequencial = ($this->si196_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_sequencial"]:$this->si196_sequencial);
    }
  }
  // funcao para inclusao
  function incluir ($si196_sequencial){
    $this->atualizacampos();
    if($this->si196_tiporegistro == null ){
      $this->erro_sql = " Campo Tipo registro não informado.";
      $this->erro_campo = "si196_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_nrodocumento == null ){
      $this->erro_sql = " Campo Número do CPF não informado.";
      $this->erro_campo = "si196_nrodocumento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_codreduzidopessoa == null ){
      $this->erro_sql = " Campo codigo reduzido pessoa não informado.";
      $this->erro_campo = "si196_nrodocumento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_tiporemuneracao == null ){
      $this->erro_sql = " Campo Tipo da remuneração não informado.". $this->si196_codreduzidopessoa;
      $this->erro_campo = "si196_tiporemuneracao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_vlrremuneracaodetalhada == null ){
      $this->erro_sql = " Campo Valor dos rendimentos por tipo não informado.";
      $this->erro_campo = "si196_vlrremuneracaodetalhada";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_mes == null ){
      $this->erro_sql = " Campo si196_mes não informado.";
      $this->erro_campo = "si196_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_inst == null ){
      $this->erro_sql = " Campo si196_inst não informado.";
      $this->erro_campo = "si196_inst";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si196_reg10 == null ){
      $this->erro_sql = " Campo si196_reg10 não informado.";
      $this->erro_campo = "si196_reg10";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($si196_sequencial == "" || $si196_sequencial == null ){
      $result = db_query("select nextval('flpgo112013_si196_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: flpgo112013_si196_sequencial_seq do campo: si196_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si196_sequencial = pg_result($result,0,0);
    }else{
      $result = db_query("select last_value from flpgo112013_si196_sequencial_seq");
      if(($result != false) && (pg_result($result,0,0) < $si196_sequencial)){
        $this->erro_sql = " Campo si196_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }else{
        $this->si196_sequencial = $si196_sequencial;
      }
    }
    if(($this->si196_sequencial == null) || ($this->si196_sequencial == "") ){
      $this->erro_sql = " Campo si196_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into flpgo112013(
                                       si196_sequencial 
                                      ,si196_tiporegistro
                                      ,si196_nrodocumento
                                      ,si196_codreduzidopessoa
                                      ,si196_tiporemuneracao 
                                      ,si196_desctiporemuneracao
                                      ,si196_vlrremuneracaodetalhada 
                                      ,si196_mes 
                                      ,si196_inst 
                                      ,si196_reg10 
                       )
                values (
                                $this->si196_sequencial 
                               ,$this->si196_tiporegistro 
                               ,'$this->si196_nrodocumento'
                               ,$this->si196_codreduzidopessoa
                               ,$this->si196_tiporemuneracao 
                               ,'$this->si196_desctiporemuneracao'
                               ,$this->si196_vlrremuneracaodetalhada 
                               ,$this->si196_mes 
                               ,$this->si196_inst 
                               ,$this->si196_reg10 
                      )";
    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
        $this->erro_sql   = "flpgo112013 ($this->si196_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "flpgo112013 já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }else{
        $this->erro_sql   = "flpgo112013 ($this->si196_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir= 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : ".$this->si196_sequencial;
    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
        $resac = db_query("insert into db_acountkey values($acount,1009299,'$this->si196_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010196,1009299,'','".AddSlashes(pg_result($resaco,0,'si196_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010196,1009300,'','".AddSlashes(pg_result($resaco,0,'si196_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010196,1009301,'','".AddSlashes(pg_result($resaco,0,'si196_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010196,1009302,'','".AddSlashes(pg_result($resaco,0,'si196_tiporemuneracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010196,1009303,'','".AddSlashes(pg_result($resaco,0,'si196_desctiporemuneracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010196,1009305,'','".AddSlashes(pg_result($resaco,0,'si196_vlrremuneracaodetalhada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010196,1009306,'','".AddSlashes(pg_result($resaco,0,'si196_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010196,1009307,'','".AddSlashes(pg_result($resaco,0,'si196_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010196,1009317,'','".AddSlashes(pg_result($resaco,0,'si196_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    return true;
  }
  // funcao para alteracao
  function alterar ($si196_sequencial=null) {
    $this->atualizacampos();
    $sql = " update flpgo112013 set ";
    $virgula = "";
    if(trim($this->si196_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_sequencial"])){
      $sql  .= $virgula." si196_sequencial = $this->si196_sequencial ";
      $virgula = ",";
      if(trim($this->si196_sequencial) == null ){
        $this->erro_sql = " Campo si196_sequencial não informado.";
        $this->erro_campo = "si196_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si196_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_nrodocumento"])){
      $sql  .= $virgula." si196_nrodocumento = $this->si196_nrodocumento ";
      $virgula = ",";
      if(trim($this->si196_nrodocumento) == null ){
        $this->erro_sql = " Campo Número do CPF não informado.";
        $this->erro_campo = "si196_nrodocumento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si196_tiporemuneracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_tiporemuneracao"])){
      $sql  .= $virgula." si196_tiporemuneracao = $this->si196_tiporemuneracao ";
      $virgula = ",";
      if(trim($this->si196_tiporemuneracao) == null ){
        $this->erro_sql = " Campo Tipo da remuneração não informado.";
        $this->erro_campo = "si196_tiporemuneracao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si196_desctiporemuneracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_desctiporemuneracao"])){
      $sql  .= $virgula." si196_desctiporemuneracao = '$this->si196_desctiporemuneracao' ";
      $virgula = ",";
    }
    if(trim($this->si196_vlrremuneracaodetalhada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_vlrremuneracaodetalhada"])){
      $sql  .= $virgula." si196_vlrremuneracaodetalhada = $this->si196_vlrremuneracaodetalhada ";
      $virgula = ",";
      if(trim($this->si196_vlrremuneracaodetalhada) == null ){
        $this->erro_sql = " Campo Valor dos rendimentos por tipo não informado.";
        $this->erro_campo = "si196_vlrremuneracaodetalhada";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si196_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_mes"])){
      $sql  .= $virgula." si196_mes = $this->si196_mes ";
      $virgula = ",";
      if(trim($this->si196_mes) == null ){
        $this->erro_sql = " Campo si196_mes não informado.";
        $this->erro_campo = "si196_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si196_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_reg10"])){
      $sql  .= $virgula." si196_reg10 = $this->si196_reg10 ";
      $virgula = ",";
      if(trim($this->si196_reg10) == null ){
        $this->erro_sql = " Campo si196_reg10 não informado.";
        $this->erro_campo = "si196_reg10";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
          $resac = db_query("insert into db_acountkey values($acount,1009299,'$this->si196_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_sequencial"]) || $this->si196_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010196,1009299,'".AddSlashes(pg_result($resaco,$conresaco,'si196_sequencial'))."','$this->si196_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_tiporegistro"]) || $this->si196_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010196,1009300,'".AddSlashes(pg_result($resaco,$conresaco,'si196_tiporegistro'))."','$this->si196_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_nrodocumento"]) || $this->si196_nrodocumento != "")
            $resac = db_query("insert into db_acount values($acount,1010196,1009301,'".AddSlashes(pg_result($resaco,$conresaco,'si196_nrodocumento'))."','$this->si196_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_tiporemuneracao"]) || $this->si196_tiporemuneracao != "")
            $resac = db_query("insert into db_acount values($acount,1010196,1009302,'".AddSlashes(pg_result($resaco,$conresaco,'si196_tiporemuneracao'))."','$this->si196_tiporemuneracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_desctiporemuneracao"]) || $this->si196_desctiporemuneracao != "")
            $resac = db_query("insert into db_acount values($acount,1010196,1009303,'".AddSlashes(pg_result($resaco,$conresaco,'si196_desctiporemuneracao'))."','$this->si196_desctiporemuneracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_vlrremuneracaodetalhada"]) || $this->si196_vlrremuneracaodetalhada != "")
            $resac = db_query("insert into db_acount values($acount,1010196,1009305,'".AddSlashes(pg_result($resaco,$conresaco,'si196_vlrremuneracaodetalhada'))."','$this->si196_vlrremuneracaodetalhada',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_mes"]) || $this->si196_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010196,1009306,'".AddSlashes(pg_result($resaco,$conresaco,'si196_mes'))."','$this->si196_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_inst"]) || $this->si196_inst != "")
            $resac = db_query("insert into db_acount values($acount,1010196,1009307,'".AddSlashes(pg_result($resaco,$conresaco,'si196_inst'))."','$this->si196_inst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_reg10"]) || $this->si196_reg10 != "")
            $resac = db_query("insert into db_acount values($acount,1010196,1009317,'".AddSlashes(pg_result($resaco,$conresaco,'si196_reg10'))."','$this->si196_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "flpgo112013 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : ".$this->si196_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "flpgo112013 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : ".$this->si196_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->si196_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
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
          $resac  = db_query("insert into db_acountkey values($acount,1009299,'$si196_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010196,1009299,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010196,1009300,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010196,1009301,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010196,1009302,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_tiporemuneracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010196,1009303,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_desctiporemuneracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010196,1009305,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_vlrremuneracaodetalhada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010196,1009306,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010196,1009307,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010196,1009317,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from flpgo112013
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
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "flpgo112013 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : ".$si196_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "flpgo112013 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : ".$si196_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$si196_sequencial;
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
      $this->erro_sql   = "Record Vazio na Tabela:flpgo112013";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  // funcao do sql 
  function sql_query ( $si196_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from flpgo112013 ";
    $sql .= "      inner join flpgo102013  on  flpgo102013.si195_sequencial = flpgo112013.si196_reg10";
    $sql2 = "";
    if($dbwhere==""){
      if($si196_sequencial!=null ){
        $sql2 .= " where flpgo112013.si196_sequencial = $si196_sequencial ";
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
  function sql_query_file ( $si196_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from flpgo112013 ";
    $sql2 = "";
    if($dbwhere==""){
      if($si196_sequencial!=null ){
        $sql2 .= " where flpgo112013.si196_sequencial = $si196_sequencial ";
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
