<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp1002018
class cl_dfcdcasp1002018 {
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
   var $si228_anousu  = 0;
   var $si228_periodo = 0;
   var $si228_instit  = 0;
   var $si228_sequencial = 0;
   var $si228_tiporegistro = 0;
   var $si228_vlgeracaoliquidaequivalentecaixa = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si228_anousu = int4 = si228_anousu
                 si228_periodo = int4 = si228_periodo
                 si228_instit = int4 = si228_instit
                 si228_sequencial = int4 = si228_sequencial
                 si228_tiporegistro = int4 = si228_tiporegistro
                 si228_vlgeracaoliquidaequivalentecaixa = float8 = si228_vlgeracaoliquidaequivalentecaixa
                 ";
   //funcao construtor da classe
   function cl_dfcdcasp1002018() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp1002018");
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
       $this->si228_anousu = ($this->si228_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si228_anousu"]:$this->si228_anousu);
       $this->si228_periodo = ($this->si228_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si228_periodo"]:$this->si228_periodo);
       $this->si228_instit = ($this->si228_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si228_instit"]:$this->si228_instit);
       $this->si228_sequencial = ($this->si228_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si228_sequencial"]:$this->si228_sequencial);
       $this->si228_tiporegistro = ($this->si228_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si228_tiporegistro"]:$this->si228_tiporegistro);
       $this->si228_vlgeracaoliquidaequivalentecaixa = ($this->si228_vlgeracaoliquidaequivalentecaixa == ""?@$GLOBALS["HTTP_POST_VARS"]["si228_vlgeracaoliquidaequivalentecaixa"]:$this->si228_vlgeracaoliquidaequivalentecaixa);
     }else{
       $this->si228_sequencial = ($this->si228_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si228_sequencial"]:$this->si228_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si228_sequencial){
      $this->atualizacampos();
     if (empty($this->si228_anousu)) {
       $this->si228_anousu = db_getsession("DB_anousu");
     }
     if (empty($this->si228_periodo)) {
       $this->si228_periodo = 28;
     }
     if (empty($this->si228_instit)) {
       $this->si228_instit = db_getsession("DB_instit");
     }
     if(empty($this->si228_tiporegistro)) {
        $this->si228_tiporegistro = 100;
     }
     if(empty($this->si228_vlgeracaoliquidaequivalentecaixa)) {
        $this->si228_vlgeracaoliquidaequivalentecaixa = 0;
     }


     if(empty($si228_sequencial)){
       $result = db_query("select nextval('dfcdcasp1002018_si228_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dfcdcasp1002018_si228_sequencial_seq do campo: si228_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si228_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from dfcdcasp1002018_si228_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si228_sequencial)){
         $this->erro_sql = " Campo si228_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si228_sequencial = $si228_sequencial;
       }
     }


     $sql = "insert into dfcdcasp1002018(
                                       si228_anousu
                                      ,si228_periodo
                                      ,si228_instit
                                      ,si228_sequencial
                                      ,si228_tiporegistro
                                      ,si228_vlgeracaoliquidaequivalentecaixa
                       )
                values (
                                {$this->si228_anousu}
                               ,{$this->si228_periodo}
                               ,{$this->si228_instit}
                               ,$this->si228_sequencial
                               ,$this->si228_tiporegistro
                               ,$this->si228_vlgeracaoliquidaequivalentecaixa
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp1002018 ($this->si228_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dfcdcasp1002018 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dfcdcasp1002018 ($this->si228_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si228_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si228_sequencial=null) {
      $this->atualizacampos();
     $sql = " update dfcdcasp1002018 set ";
     $virgula = "";
     if(trim($this->si228_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si228_sequencial"])){
       $sql  .= $virgula." si228_sequencial = $this->si228_sequencial ";
       $virgula = ",";
       if(trim($this->si228_sequencial) == null ){
         $this->erro_sql = " Campo si228_sequencial não informado.";
         $this->erro_campo = "si228_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si228_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si228_tiporegistro"])){
       $sql  .= $virgula." si228_tiporegistro = $this->si228_tiporegistro ";
       $virgula = ",";
       if(trim($this->si228_tiporegistro) == null ){
         $this->erro_sql = " Campo si228_tiporegistro não informado.";
         $this->erro_campo = "si228_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si228_vlgeracaoliquidaequivalentecaixa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si228_vlgeracaoliquidaequivalentecaixa"])){
       $sql  .= $virgula." si228_vlgeracaoliquidaequivalentecaixa = $this->si228_vlgeracaoliquidaequivalentecaixa ";
       $virgula = ",";
       if(trim($this->si228_vlgeracaoliquidaequivalentecaixa) == null ){
         $this->erro_sql = " Campo si228_vlgeracaoliquidaequivalentecaixa não informado.";
         $this->erro_campo = "si228_vlgeracaoliquidaequivalentecaixa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si228_sequencial!=null){
       $sql .= " si228_sequencial = $this->si228_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp1002018 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si228_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp1002018 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si228_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si228_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si228_sequencial=null,$dbwhere=null) {

     $sql = " delete from dfcdcasp1002018
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si228_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si228_sequencial = $si228_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp1002018 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si228_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp1002018 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si228_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si228_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp1002018";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si228_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp1002018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si228_sequencial!=null ){
         $sql2 .= " where dfcdcasp1002018.si228_sequencial = $si228_sequencial ";
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
   function sql_query_file ( $si228_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp1002018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si228_sequencial!=null ){
         $sql2 .= " where dfcdcasp1002018.si228_sequencial = $si228_sequencial ";
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
