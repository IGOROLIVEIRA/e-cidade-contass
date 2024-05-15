<?
//MODULO: sicom
//CLASSE DA ENTIDADE respinf102014
class cl_respinf102014 {
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
  var $si197_sequencial = 0;
  var $si197_nomeresponsavel = null;
  var $si197_cartident = null;
  var $si197_orgemissorci = null;
  var $si197_cpf = null;
  var $si197_dtinicio_dia = null;
  var $si197_dtinicio_mes = null;
  var $si197_dtinicio_ano = null;
  var $si197_dtinicio = null;
  var $si197_dtfinal_dia = null;
  var $si197_dtfinal_mes = null;
  var $si197_dtfinal_ano = null;
  var $si197_dtfinal = null;
  var $si197_mes = 0;
  var $si197_inst = 0;
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 si197_sequencial = int8 = si197_sequencial 
                 si197_nomeresponsavel = varchar(120) = Nome do Responsavel 
                 si197_cartident = varchar(10) = Identidade do responsável 
                 si197_orgemissorci = varchar(10) = Órgão emissor da carteira de identidade 
                 si197_cpf = varchar(11) = Número do CPF do responsável 
                 si197_dtinicio = date = Data inicial 
                 si197_dtfinal = date = Data final 
                 si197_mes = int8 = si197_mes 
                 si197_inst = int8 = si197_inst 
                 ";
  //funcao construtor da classe 
  function cl_respinf102014() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("respinf102014");
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
      $this->si197_sequencial = ($this->si197_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_sequencial"]:$this->si197_sequencial);
      $this->si197_nomeresponsavel = ($this->si197_nomeresponsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_nomeresponsavel"]:$this->si197_nomeresponsavel);
      $this->si197_cartident = ($this->si197_cartident == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_cartident"]:$this->si197_cartident);
      $this->si197_orgemissorci = ($this->si197_orgemissorci == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_orgemissorci"]:$this->si197_orgemissorci);
      $this->si197_cpf = ($this->si197_cpf == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_cpf"]:$this->si197_cpf);
      if($this->si197_dtinicio == ""){
        $this->si197_dtinicio_dia = ($this->si197_dtinicio_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_dtinicio_dia"]:$this->si197_dtinicio_dia);
        $this->si197_dtinicio_mes = ($this->si197_dtinicio_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_dtinicio_mes"]:$this->si197_dtinicio_mes);
        $this->si197_dtinicio_ano = ($this->si197_dtinicio_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_dtinicio_ano"]:$this->si197_dtinicio_ano);
        if($this->si197_dtinicio_dia != ""){
          $this->si197_dtinicio = $this->si197_dtinicio_ano."-".$this->si197_dtinicio_mes."-".$this->si197_dtinicio_dia;
        }
      }
      if($this->si197_dtfinal == ""){
        $this->si197_dtfinal_dia = ($this->si197_dtfinal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_dtfinal_dia"]:$this->si197_dtfinal_dia);
        $this->si197_dtfinal_mes = ($this->si197_dtfinal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_dtfinal_mes"]:$this->si197_dtfinal_mes);
        $this->si197_dtfinal_ano = ($this->si197_dtfinal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_dtfinal_ano"]:$this->si197_dtfinal_ano);
        if($this->si197_dtfinal_dia != ""){
          $this->si197_dtfinal = $this->si197_dtfinal_ano."-".$this->si197_dtfinal_mes."-".$this->si197_dtfinal_dia;
        }
      }
      $this->si197_mes = ($this->si197_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_mes"]:$this->si197_mes);
      $this->si197_inst = ($this->si197_inst == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_inst"]:$this->si197_inst);
    }else{
      $this->si197_sequencial = ($this->si197_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_sequencial"]:$this->si197_sequencial);
    }
  }
  // funcao para inclusao
  function incluir ($si197_sequencial){
    $this->atualizacampos();
    if($this->si197_nomeresponsavel == null ){
      $this->erro_sql = " Campo Nome do Responsavel não informado.";
      $this->erro_campo = "si197_nomeresponsavel";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si197_cartident == null ){
      $this->erro_sql = " Campo Identidade do responsável não informado.";
      $this->erro_campo = "si197_cartident";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si197_orgemissorci == null ){
      $this->erro_sql = " Campo Órgão emissor da carteira de identidade não informado.";
      $this->erro_campo = "si197_orgemissorci";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si197_cpf == null ){
      $this->erro_sql = " Campo Número do CPF do responsável não informado.";
      $this->erro_campo = "si197_cpf";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si197_dtinicio == null ){
      $this->erro_sql = " Campo Data inicial não informado.";
      $this->erro_campo = "si197_dtinicio_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si197_dtfinal == null ){
      $this->erro_sql = " Campo Data final não informado.";
      $this->erro_campo = "si197_dtfinal_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si197_mes == null ){
      $this->erro_sql = " Campo si197_mes não informado.";
      $this->erro_campo = "si197_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si197_inst == null ){
      $this->erro_sql = " Campo si197_inst não informado.";
      $this->erro_campo = "si197_inst";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($si197_sequencial == "" || $si197_sequencial == null ){
      $result = db_query("select nextval('respinf102014_si197_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: respinf102014_si197_sequencial_seq do campo: si197_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si197_sequencial = pg_result($result,0,0);
    }else{
      $result = db_query("select last_value from respinf102014_si197_sequencial_seq");
      if(($result != false) && (pg_result($result,0,0) < $si197_sequencial)){
        $this->erro_sql = " Campo si197_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }else{
        $this->si197_sequencial = $si197_sequencial;
      }
    }
    if(($this->si197_sequencial == null) || ($this->si197_sequencial == "") ){
      $this->erro_sql = " Campo si197_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into respinf102014(
                                       si197_sequencial 
                                      ,si197_nomeresponsavel 
                                      ,si197_cartident 
                                      ,si197_orgemissorci 
                                      ,si197_cpf 
                                      ,si197_dtinicio 
                                      ,si197_dtfinal 
                                      ,si197_mes 
                                      ,si197_inst 
                       )
                values (
                                $this->si197_sequencial 
                               ,'$this->si197_nomeresponsavel' 
                               ,'$this->si197_cartident' 
                               ,'$this->si197_orgemissorci' 
                               ,'$this->si197_cpf' 
                               ,".($this->si197_dtinicio == "null" || $this->si197_dtinicio == ""?"null":"'".$this->si197_dtinicio."'")." 
                               ,".($this->si197_dtfinal == "null" || $this->si197_dtfinal == ""?"null":"'".$this->si197_dtfinal."'")." 
                               ,$this->si197_mes 
                               ,$this->si197_inst 
                      )";
    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
        $this->erro_sql   = "respinf102014 ($this->si197_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "respinf102014 já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }else{
        $this->erro_sql   = "respinf102014 ($this->si197_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir= 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : ".$this->si197_sequencial;
    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir= pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si197_sequencial  ));
      if(($resaco!=false)||($this->numrows!=0)){

        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,1009308,'$this->si197_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010197,1009308,'','".AddSlashes(pg_result($resaco,0,'si197_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,1009309,'','".AddSlashes(pg_result($resaco,0,'si197_nomeresponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,1009310,'','".AddSlashes(pg_result($resaco,0,'si197_cartident'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,1009311,'','".AddSlashes(pg_result($resaco,0,'si197_orgemissorci'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,1009312,'','".AddSlashes(pg_result($resaco,0,'si197_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,1009313,'','".AddSlashes(pg_result($resaco,0,'si197_dtinicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,1009314,'','".AddSlashes(pg_result($resaco,0,'si197_dtfinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,1009315,'','".AddSlashes(pg_result($resaco,0,'si197_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,1009316,'','".AddSlashes(pg_result($resaco,0,'si197_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    return true;
  }
  // funcao para alteracao
  function alterar ($si197_sequencial=null) {
    $this->atualizacampos();
    $sql = " update respinf102014 set ";
    $virgula = "";
    if(trim($this->si197_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_sequencial"])){
      $sql  .= $virgula." si197_sequencial = $this->si197_sequencial ";
      $virgula = ",";
      if(trim($this->si197_sequencial) == null ){
        $this->erro_sql = " Campo si197_sequencial não informado.";
        $this->erro_campo = "si197_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si197_nomeresponsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_nomeresponsavel"])){
      $sql  .= $virgula." si197_nomeresponsavel = '$this->si197_nomeresponsavel' ";
      $virgula = ",";
      if(trim($this->si197_nomeresponsavel) == null ){
        $this->erro_sql = " Campo Nome do Responsavel não informado.";
        $this->erro_campo = "si197_nomeresponsavel";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si197_cartident)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_cartident"])){
      $sql  .= $virgula." si197_cartident = '$this->si197_cartident' ";
      $virgula = ",";
      if(trim($this->si197_cartident) == null ){
        $this->erro_sql = " Campo Identidade do responsável não informado.";
        $this->erro_campo = "si197_cartident";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si197_orgemissorci)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_orgemissorci"])){
      $sql  .= $virgula." si197_orgemissorci = '$this->si197_orgemissorci' ";
      $virgula = ",";
      if(trim($this->si197_orgemissorci) == null ){
        $this->erro_sql = " Campo Órgão emissor da carteira de identidade não informado.";
        $this->erro_campo = "si197_orgemissorci";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si197_cpf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_cpf"])){
      $sql  .= $virgula." si197_cpf = '$this->si197_cpf' ";
      $virgula = ",";
      if(trim($this->si197_cpf) == null ){
        $this->erro_sql = " Campo Número do CPF do responsável não informado.";
        $this->erro_campo = "si197_cpf";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si197_dtinicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_dtinicio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si197_dtinicio_dia"] !="") ){
      $sql  .= $virgula." si197_dtinicio = '$this->si197_dtinicio' ";
      $virgula = ",";
      if(trim($this->si197_dtinicio) == null ){
        $this->erro_sql = " Campo Data inicial não informado.";
        $this->erro_campo = "si197_dtinicio_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if(isset($GLOBALS["HTTP_POST_VARS"]["si197_dtinicio_dia"])){
        $sql  .= $virgula." si197_dtinicio = null ";
        $virgula = ",";
        if(trim($this->si197_dtinicio) == null ){
          $this->erro_sql = " Campo Data inicial não informado.";
          $this->erro_campo = "si197_dtinicio_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if(trim($this->si197_dtfinal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_dtfinal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si197_dtfinal_dia"] !="") ){
      $sql  .= $virgula." si197_dtfinal = '$this->si197_dtfinal' ";
      $virgula = ",";
      if(trim($this->si197_dtfinal) == null ){
        $this->erro_sql = " Campo Data final não informado.";
        $this->erro_campo = "si197_dtfinal_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if(isset($GLOBALS["HTTP_POST_VARS"]["si197_dtfinal_dia"])){
        $sql  .= $virgula." si197_dtfinal = null ";
        $virgula = ",";
        if(trim($this->si197_dtfinal) == null ){
          $this->erro_sql = " Campo Data final não informado.";
          $this->erro_campo = "si197_dtfinal_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if(trim($this->si197_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_mes"])){
      $sql  .= $virgula." si197_mes = $this->si197_mes ";
      $virgula = ",";
      if(trim($this->si197_mes) == null ){
        $this->erro_sql = " Campo si197_mes não informado.";
        $this->erro_campo = "si197_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if(trim($this->si197_inst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_inst"])){
      $sql  .= $virgula." si197_inst = $this->si197_inst ";
      $virgula = ",";
      if(trim($this->si197_inst) == null ){
        $this->erro_sql = " Campo si197_inst não informado.";
        $this->erro_campo = "si197_inst";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if($si197_sequencial!=null){
      $sql .= " si197_sequencial = $this->si197_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si197_sequencial));
      if($this->numrows>0){

        for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,1009308,'$this->si197_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si197_sequencial"]) || $this->si197_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010197,1009308,'".AddSlashes(pg_result($resaco,$conresaco,'si197_sequencial'))."','$this->si197_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si197_nomeresponsavel"]) || $this->si197_nomeresponsavel != "")
            $resac = db_query("insert into db_acount values($acount,1010197,1009309,'".AddSlashes(pg_result($resaco,$conresaco,'si197_nomeresponsavel'))."','$this->si197_nomeresponsavel',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si197_cartident"]) || $this->si197_cartident != "")
            $resac = db_query("insert into db_acount values($acount,1010197,1009310,'".AddSlashes(pg_result($resaco,$conresaco,'si197_cartident'))."','$this->si197_cartident',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si197_orgemissorci"]) || $this->si197_orgemissorci != "")
            $resac = db_query("insert into db_acount values($acount,1010197,1009311,'".AddSlashes(pg_result($resaco,$conresaco,'si197_orgemissorci'))."','$this->si197_orgemissorci',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si197_cpf"]) || $this->si197_cpf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,1009312,'".AddSlashes(pg_result($resaco,$conresaco,'si197_cpf'))."','$this->si197_cpf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si197_dtinicio"]) || $this->si197_dtinicio != "")
            $resac = db_query("insert into db_acount values($acount,1010197,1009313,'".AddSlashes(pg_result($resaco,$conresaco,'si197_dtinicio'))."','$this->si197_dtinicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si197_dtfinal"]) || $this->si197_dtfinal != "")
            $resac = db_query("insert into db_acount values($acount,1010197,1009314,'".AddSlashes(pg_result($resaco,$conresaco,'si197_dtfinal'))."','$this->si197_dtfinal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si197_mes"]) || $this->si197_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010197,1009315,'".AddSlashes(pg_result($resaco,$conresaco,'si197_mes'))."','$this->si197_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si197_inst"]) || $this->si197_inst != "")
            $resac = db_query("insert into db_acount values($acount,1010197,1009316,'".AddSlashes(pg_result($resaco,$conresaco,'si197_inst'))."','$this->si197_inst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "respinf102014 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : ".$this->si197_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "respinf102014 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : ".$this->si197_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$this->si197_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  // funcao para exclusao 
  function excluir ($si197_sequencial=null,$dbwhere=null) {

    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
            && ($lSessaoDesativarAccount === false))) {

      if ($dbwhere==null || $dbwhere=="") {

        $resaco = $this->sql_record($this->sql_query_file($si197_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
      }
      if (($resaco != false) || ($this->numrows!=0)) {

        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,1009308,'$si197_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010197,1009308,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,1009309,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_nomeresponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,1009310,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_cartident'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,1009311,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_orgemissorci'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,1009312,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,1009313,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_dtinicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,1009314,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_dtfinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,1009315,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,1009316,'','".AddSlashes(pg_result($resaco,$iresaco,'si197_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from respinf102014
                    where ";
    $sql2 = "";
    if($dbwhere==null || $dbwhere ==""){
      if($si197_sequencial != ""){
        if($sql2!=""){
          $sql2 .= " and ";
        }
        $sql2 .= " si197_sequencial = $si197_sequencial ";
      }
    }else{
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if($result==false){
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "respinf102014 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : ".$si197_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    }else{
      if(pg_affected_rows($result)==0){
        $this->erro_banco = "";
        $this->erro_sql = "respinf102014 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : ".$si197_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      }else{
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$si197_sequencial;
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
      $this->erro_sql   = "Record Vazio na Tabela:respinf102014";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  // funcao do sql 
  function sql_query ( $si197_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from respinf102014 ";
    $sql2 = "";
    if($dbwhere==""){
      if($si197_sequencial!=null ){
        $sql2 .= " where respinf102014.si197_sequencial = $si197_sequencial ";
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
  function sql_query_file ( $si197_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from respinf102014 ";
    $sql2 = "";
    if($dbwhere==""){
      if($si197_sequencial!=null ){
        $sql2 .= " where respinf102014.si197_sequencial = $si197_sequencial ";
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
