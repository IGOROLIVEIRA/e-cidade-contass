<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp302017
class cl_dfcdcasp302017 {
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
   var $si221_anousu  = 0;
   var $si221_periodo = 0;
   var $si221_instit  = 0;
   var $si221_sequencial = 0;
   var $si221_tiporegistro = 0;
   var $si221_exercicio = 0;
   var $si221_vlfluxocaixaliquidooperacional = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si221_anousu = int4 = si221_anousu
                 si221_periodo = int4 = si221_periodo
                 si221_instit = int4 = si221_instit
                 si221_sequencial = int4 = si221_sequencial
                 si221_tiporegistro = int4 = si221_tiporegistro
                 si221_exercicio = int4 = si221_exercicio
                 si221_vlfluxocaixaliquidooperacional = float8 = si221_vlfluxocaixaliquidooperacional
                 ";
   //funcao construtor da classe
   function cl_dfcdcasp302017() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp302017");
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
       $this->si221_anousu = ($this->si221_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si221_anousu"]:$this->si221_anousu);
       $this->si221_periodo = ($this->si221_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si221_periodo"]:$this->si221_periodo);
       $this->si221_instit = ($this->si221_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si221_instit"]:$this->si221_instit);
       $this->si221_sequencial = ($this->si221_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si221_sequencial"]:$this->si221_sequencial);
       $this->si221_tiporegistro = ($this->si221_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si221_tiporegistro"]:$this->si221_tiporegistro);
       $this->si221_exercicio = ($this->si221_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si221_exercicio"]:$this->si221_exercicio);
       $this->si221_vlfluxocaixaliquidooperacional = ($this->si221_vlfluxocaixaliquidooperacional == ""?@$GLOBALS["HTTP_POST_VARS"]["si221_vlfluxocaixaliquidooperacional"]:$this->si221_vlfluxocaixaliquidooperacional);
     }else{
       $this->si221_sequencial = ($this->si221_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si221_sequencial"]:$this->si221_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si221_sequencial){
      $this->atualizacampos();

     if (empty($this->si221_anousu)) {
       $this->si221_anousu = db_getsession("DB_anousu");
     }
     if (empty($this->si221_periodo)) {
       $this->si221_periodo = 28;
     }
     if (empty($this->si221_instit)) {
       $this->si221_instit = db_getsession("DB_instit");
     }

     if( empty($this->si221_tiporegistro) ){
        $this->si221_tiporegistro = 30;
     }
     if( empty($this->si221_exercicio) ){
       $this->erro_sql = " Campo si221_exercicio não informado.";
       $this->erro_campo = "si221_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if( empty($this->si221_vlfluxocaixaliquidooperacional) ){
        $this->si221_vlfluxocaixaliquidooperacional = 0;
     }

     if(empty($si221_sequencial)){
       $result = db_query("select nextval('dfcdcasp302017_si221_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dfcdcasp302017_si221_sequencial_seq do campo: si221_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si221_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from dfcdcasp302017_si221_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si221_sequencial)){
         $this->erro_sql = " Campo si221_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si221_sequencial = $si221_sequencial;
       }
     }

     $sql = "insert into dfcdcasp302017(
                                       si221_anousu
                                      ,si221_periodo
                                      ,si221_instit
                                      ,si221_sequencial
                                      ,si221_tiporegistro
                                      ,si221_exercicio
                                      ,si221_vlfluxocaixaliquidooperacional
                       )
                values (
                                {$this->si221_anousu}
                               ,{$this->si221_periodo}
                               ,{$this->si221_instit}
                               ,$this->si221_sequencial
                               ,$this->si221_tiporegistro
                               ,$this->si221_exercicio
                               ,$this->si221_vlfluxocaixaliquidooperacional
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp302017 ($this->si221_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dfcdcasp302017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dfcdcasp302017 ($this->si221_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si221_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si221_sequencial=null) {
      $this->atualizacampos();
     $sql = " update dfcdcasp302017 set ";
     $virgula = "";
     if(trim($this->si221_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si221_sequencial"])){
       $sql  .= $virgula." si221_sequencial = $this->si221_sequencial ";
       $virgula = ",";
       if(trim($this->si221_sequencial) == null ){
         $this->erro_sql = " Campo si221_sequencial não informado.";
         $this->erro_campo = "si221_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si221_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si221_tiporegistro"])){
       $sql  .= $virgula." si221_tiporegistro = $this->si221_tiporegistro ";
       $virgula = ",";
       if(trim($this->si221_tiporegistro) == null ){
         $this->erro_sql = " Campo si221_tiporegistro não informado.";
         $this->erro_campo = "si221_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si221_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si221_exercicio"])){
       $sql  .= $virgula." si221_exercicio = $this->si221_exercicio ";
       $virgula = ",";
       if(trim($this->si221_exercicio) == null ){
         $this->erro_sql = " Campo si221_exercicio não informado.";
         $this->erro_campo = "si221_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si221_vlfluxocaixaliquidooperacional)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si221_vlfluxocaixaliquidooperacional"])){
       $sql  .= $virgula." si221_vlfluxocaixaliquidooperacional = $this->si221_vlfluxocaixaliquidooperacional ";
       $virgula = ",";
       if(trim($this->si221_vlfluxocaixaliquidooperacional) == null ){
         $this->erro_sql = " Campo si221_vlfluxocaixaliquidooperacional não informado.";
         $this->erro_campo = "si221_vlfluxocaixaliquidooperacional";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si221_sequencial!=null){
       $sql .= " si221_sequencial = $this->si221_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp302017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si221_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp302017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si221_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si221_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si221_sequencial=null,$dbwhere=null) {

     $sql = " delete from dfcdcasp302017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si221_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si221_sequencial = $si221_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp302017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si221_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp302017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si221_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si221_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp302017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si221_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp302017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si221_sequencial!=null ){
         $sql2 .= " where dfcdcasp302017.si221_sequencial = $si221_sequencial ";
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
   function sql_query_file ( $si221_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp302017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si221_sequencial!=null ){
         $sql2 .= " where dfcdcasp302017.si221_sequencial = $si221_sequencial ";
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
