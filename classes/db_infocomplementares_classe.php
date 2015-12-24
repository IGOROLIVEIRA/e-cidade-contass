<?
//MODULO: sicom
//CLASSE DA ENTIDADE infocomplementares
class cl_infocomplementares {
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
  var $si08_sequencial = 0;
  var $si08_anousu = 0;
  var $si08_instit = 0;
  var $si08_tipoliquidante = 0;
  var $si08_tratacodunidade = 0;
  var $si08_orcmodalidadeaplic = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si08_sequencial = int8 = Código Sequencial 
                 si08_anousu = int8 = Ano sessão 
                 si08_instit = int8 = Instituição 
                 si08_tipoliquidante = int8 = Tipo do Liquidante 
                 si08_tratacodunidade = int8 = Tratar Cod. Unidade 
                 si08_orcmodalidadeaplic = int8 = Orçamento por modalidade de aplicação
                 si08_codunidadesub = varchar(8) = Código da unidade orçamentária padrão para o exercicio atual
                 ";
  //funcao construtor da classe
  function cl_infocomplementares() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("infocomplementares");
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
      $this->si08_sequencial = ($this->si08_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si08_sequencial"]:$this->si08_sequencial);
      $this->si08_anousu = ($this->si08_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si08_anousu"]:$this->si08_anousu);
      $this->si08_instit = ($this->si08_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si08_instit"]:$this->si08_instit);
      $this->si08_tipoliquidante = ($this->si08_tipoliquidante == ""?@$GLOBALS["HTTP_POST_VARS"]["si08_tipoliquidante"]:$this->si08_tipoliquidante);
      $this->si08_tratacodunidade = ($this->si08_tratacodunidade == ""?@$GLOBALS["HTTP_POST_VARS"]["si08_tratacodunidade"]:$this->si08_tratacodunidade);
      $this->si08_orcmodalidadeaplic = ($this->si08_orcmodalidadeaplic == ""?@$GLOBALS["HTTP_POST_VARS"]["si08_orcmodalidadeaplic"]:$this->si08_orcmodalidadeaplic);
      $this->si08_codunidadesub = ($this->si08_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si08_codunidadesub"]:$this->si08_codunidadesub);
    }else{
      $this->si08_sequencial = ($this->si08_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si08_sequencial"]:$this->si08_sequencial);
    }
  }
  // funcao para inclusao
  function incluir ($si08_sequencial){
    $this->atualizacampos();
    if($this->si08_anousu == null ){
      $this->erro_sql = " Campo Ano sessão nao Informado.";
      $this->erro_campo = "si08_anousu";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si08_instit == null ){
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si08_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si08_tipoliquidante == null ){
      $this->erro_sql = " Campo Tipo do Liquidante nao Informado.";
      $this->erro_campo = "si08_tipoliquidante";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si08_tratacodunidade == null ){
      $this->erro_sql = " Campo Tratar Cod. Unidade nao Informado.";
      $this->erro_campo = "si08_tratacodunidade";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }

    /*
     * Campo adicionado por causa do sicom balancete em 2015
     */
    if($this->si08_orcmodalidadeaplic == null ){
      $this->si08_orcmodalidadeaplic = "null";
    }

    /*
     * Campo adicionado por causa do sicom balancete em 2015
     */
    if($this->si08_codunidadesub == null ){
      $this->si08_codunidadesub = "null";
    }

    if($si08_sequencial == "" || $si08_sequencial == null ){
      $result = db_query("select nextval('infocomplementares_si08_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: infocomplementares_si08_sequencial_seq do campo: si08_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si08_sequencial = pg_result($result,0,0);
    }else{
      $result = db_query("select last_value from infocomplementares_si08_sequencial_seq");
      if(($result != false) && (pg_result($result,0,0) < $si08_sequencial)){
        $this->erro_sql = " Campo si08_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }else{
        $this->si08_sequencial = $si08_sequencial;
      }
    }
    if(($this->si08_sequencial == null) || ($this->si08_sequencial == "") ){
      $this->erro_sql = " Campo si08_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into infocomplementares(
                                       si08_sequencial 
                                      ,si08_anousu 
                                      ,si08_instit 
                                      ,si08_tipoliquidante 
                                      ,si08_tratacodunidade
                                      ,si08_orcmodalidadeaplic 
                                      ,si08_codunidadesub 
                       )
                values (
                                $this->si08_sequencial 
                               ,$this->si08_anousu 
                               ,$this->si08_instit 
                               ,$this->si08_tipoliquidante 
                               ,$this->si08_tratacodunidade
                               ,$this->si08_orcmodalidadeaplic 
                               ,'$this->si08_codunidadesub'
                      )";
    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
        $this->erro_sql   = "Informações complementares ($this->si08_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "Informações complementares já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }else{
        $this->erro_sql   = "Informações complementares ($this->si08_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir= 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : ".$this->si08_sequencial;
    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir= pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si08_sequencial));
    if(($resaco!=false)||($this->numrows!=0)){
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac,0,0);
      $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
      $resac = db_query("insert into db_acountkey values($acount,2009465,'$this->si08_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010227,2009465,'','".AddSlashes(pg_result($resaco,0,'si08_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      $resac = db_query("insert into db_acount values($acount,2010227,2009464,'','".AddSlashes(pg_result($resaco,0,'si08_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      $resac = db_query("insert into db_acount values($acount,2010227,2009463,'','".AddSlashes(pg_result($resaco,0,'si08_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      $resac = db_query("insert into db_acount values($acount,2010227,2009462,'','".AddSlashes(pg_result($resaco,0,'si08_tipoliquidante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      $resac = db_query("insert into db_acount values($acount,2010227,2009461,'','".AddSlashes(pg_result($resaco,0,'si08_tratacodunidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    }
    return true;
  }
  // funcao para alteracao
  function alterar ($si08_sequencial=null) {
    $this->atualizacampos();
    $sql = " update infocomplementares set ";
    $virgula = "";
    if(trim($this->si08_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si08_sequencial"])){
      $sql  .= $virgula." si08_sequencial = $this->si08_sequencial ";
      $virgula = ",";
      if(trim($this->si08_sequencial) == null ){
        $this->erro_sql = " Campo Código Sequencial nao Informado.";
        $this->erro_campo = "si08_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si08_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si08_anousu"])){
      $sql  .= $virgula." si08_anousu = $this->si08_anousu ";
      $virgula = ",";
      if(trim($this->si08_anousu) == null ){
        $this->erro_sql = " Campo Ano sessão nao Informado.";
        $this->erro_campo = "si08_anousu";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si08_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si08_instit"])){
      $sql  .= $virgula." si08_instit = $this->si08_instit ";
      $virgula = ",";
      if(trim($this->si08_instit) == null ){
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si08_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si08_tipoliquidante)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si08_tipoliquidante"])){
      $sql  .= $virgula." si08_tipoliquidante = $this->si08_tipoliquidante ";
      $virgula = ",";
      if(trim($this->si08_tipoliquidante) == null ){
        $this->erro_sql = " Campo Tipo do Liquidante nao Informado.";
        $this->erro_campo = "si08_tipoliquidante";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si08_tratacodunidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si08_tratacodunidade"])){
      $sql  .= $virgula." si08_tratacodunidade = $this->si08_tratacodunidade ";
      $virgula = ",";
      if(trim($this->si08_tratacodunidade) == null ){
        $this->erro_sql = " Campo Tratar Cod. Unidade nao Informado.";
        $this->erro_campo = "si08_tratacodunidade";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    /**
     * Campo adicionado por causa do sicom balancete em 2015
     */
    if(trim($this->si08_orcmodalidadeaplic)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si08_orcmodalidadeaplic"])){
      $sql  .= $virgula." si08_orcmodalidadeaplic = ". ($this->si08_orcmodalidadeaplic == "" || $this->si08_orcmodalidadeaplic == null ? "null" : $this->si08_orcmodalidadeaplic);
      $virgula = ",";

    }

    /**
     * Campo adicionado por causa do sicom balancete em 2015
     */
    if(trim($this->si08_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si08_codunidadesub"])){
      $sql  .= $virgula." si08_codunidadesub = '$this->si08_codunidadesub' ";
      $virgula = ",";
      if(trim($this->si08_codunidadesub) == null ){
        $sql  .= $virgula." si08_codunidadesub = null ";
        $virgula = ",";

      }
    }

    $sql .= " where ";
    if($si08_sequencial!=null){
      $sql .= " si08_sequencial = $this->si08_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si08_sequencial));
    if($this->numrows>0){
      for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,2009465,'$this->si08_sequencial','A')");
        if(isset($GLOBALS["HTTP_POST_VARS"]["si08_sequencial"]) || $this->si08_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010227,2009465,'".AddSlashes(pg_result($resaco,$conresaco,'si08_sequencial'))."','$this->si08_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        if(isset($GLOBALS["HTTP_POST_VARS"]["si08_anousu"]) || $this->si08_anousu != "")
          $resac = db_query("insert into db_acount values($acount,2010227,2009464,'".AddSlashes(pg_result($resaco,$conresaco,'si08_anousu'))."','$this->si08_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        if(isset($GLOBALS["HTTP_POST_VARS"]["si08_instit"]) || $this->si08_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010227,2009463,'".AddSlashes(pg_result($resaco,$conresaco,'si08_instit'))."','$this->si08_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        if(isset($GLOBALS["HTTP_POST_VARS"]["si08_tipoliquidante"]) || $this->si08_tipoliquidante != "")
          $resac = db_query("insert into db_acount values($acount,2010227,2009462,'".AddSlashes(pg_result($resaco,$conresaco,'si08_tipoliquidante'))."','$this->si08_tipoliquidante',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        if(isset($GLOBALS["HTTP_POST_VARS"]["si08_tratacodunidade"]) || $this->si08_tratacodunidade != "")
          $resac = db_query("insert into db_acount values($acount,2010227,2009461,'".AddSlashes(pg_result($resaco,$conresaco,'si08_tratacodunidade'))."','$this->si08_tratacodunidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      }
    }
    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "Informações complementares nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : ".$this->si08_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "Informações complementares nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : ".$this->si08_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->si08_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  // funcao para exclusao
  function excluir ($si08_sequencial=null,$dbwhere=null) {
    if($dbwhere==null || $dbwhere==""){
      $resaco = $this->sql_record($this->sql_query_file($si08_sequencial));
    }else{
      $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
    }
    if(($resaco!=false)||($this->numrows!=0)){
      for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,2009465,'$si08_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010227,2009465,'','".AddSlashes(pg_result($resaco,$iresaco,'si08_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,2010227,2009464,'','".AddSlashes(pg_result($resaco,$iresaco,'si08_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,2010227,2009463,'','".AddSlashes(pg_result($resaco,$iresaco,'si08_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,2010227,2009462,'','".AddSlashes(pg_result($resaco,$iresaco,'si08_tipoliquidante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,2010227,2009461,'','".AddSlashes(pg_result($resaco,$iresaco,'si08_tratacodunidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      }
    }
    $sql = " delete from infocomplementares
                    where ";
    $sql2 = "";
    if($dbwhere==null || $dbwhere ==""){
      if($si08_sequencial != ""){
        if($sql2!=""){
          $sql2 .= " and ";
        }
        $sql2 .= " si08_sequencial = $si08_sequencial ";
      }
    }else{
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "Informações complementares nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : ".$si08_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "Informações complementares nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : ".$si08_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$si08_sequencial;
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
      $this->erro_sql   = "Record Vazio na Tabela:infocomplementares";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  // funcao do sql
  function sql_query ( $si08_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from infocomplementares ";
    $sql2 = "";
    if($dbwhere==""){
      if($si08_sequencial!=null ){
        $sql2 .= " where infocomplementares.si08_sequencial = $si08_sequencial ";
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
  function sql_query_file ( $si08_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from infocomplementares ";
    $sql2 = "";
    if($dbwhere==""){
      if($si08_sequencial!=null ){
        $sql2 .= " where infocomplementares.si08_sequencial = $si08_sequencial ";
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
