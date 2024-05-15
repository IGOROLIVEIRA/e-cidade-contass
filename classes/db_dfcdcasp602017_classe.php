<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp602017
class cl_dfcdcasp602017 {
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
   var $si224_anousu  = 0;
   var $si224_periodo = 0;
   var $si224_instit  = 0;
   var $si224_sequencial = 0;
   var $si224_tiporegistro = 0;
   var $si224_exercicio = 0;
   var $si224_vlfluxocaixaliquidoinvestimento = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si224_anousu = int4 = si224_anousu
                 si224_periodo = int4 = si224_periodo
                 si224_instit = int4 = si224_instit
                 si224_sequencial = int4 = si224_sequencial
                 si224_tiporegistro = int4 = si224_tiporegistro
                 si224_exercicio = int4 = si224_exercicio
                 si224_vlfluxocaixaliquidoinvestimento = float8 = si224_vlfluxocaixaliquidoinvestimento
                 ";
   //funcao construtor da classe
   function cl_dfcdcasp602017() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp602017");
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
       $this->si224_anousu = ($this->si224_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si224_anousu"]:$this->si224_anousu);
       $this->si224_periodo = ($this->si224_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si224_periodo"]:$this->si224_periodo);
       $this->si224_instit = ($this->si224_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si224_instit"]:$this->si224_instit);
       $this->si224_sequencial = ($this->si224_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si224_sequencial"]:$this->si224_sequencial);
       $this->si224_tiporegistro = ($this->si224_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si224_tiporegistro"]:$this->si224_tiporegistro);
       $this->si224_exercicio = ($this->si224_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si224_exercicio"]:$this->si224_exercicio);
       $this->si224_vlfluxocaixaliquidoinvestimento = ($this->si224_vlfluxocaixaliquidoinvestimento == ""?@$GLOBALS["HTTP_POST_VARS"]["si224_vlfluxocaixaliquidoinvestimento"]:$this->si224_vlfluxocaixaliquidoinvestimento);
     }else{
       $this->si224_sequencial = ($this->si224_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si224_sequencial"]:$this->si224_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si224_sequencial){
      $this->atualizacampos();
     if (empty($this->si224_anousu)) {
       $this->si224_anousu = db_getsession("DB_anousu");
     }
     if (empty($this->si224_periodo)) {
       $this->si224_periodo = 28;
     }
     if (empty($this->si224_instit)) {
       $this->si224_instit = db_getsession("DB_instit");
     }
     if( empty($this->si224_tiporegistro) ){
        $this->si224_tiporegistro = 60;
     }
     if( empty($this->si224_exercicio) ){
       $this->erro_sql = " Campo si224_exercicio não informado.";
       $this->erro_campo = "si224_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if( empty($this->si224_vlfluxocaixaliquidoinvestimento) ){
        $this->si224_vlfluxocaixaliquidoinvestimento = 0;
     }

     if(empty($si224_sequencial)){
       $result = db_query("select nextval('dfcdcasp602017_si224_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dfcdcasp602017_si224_sequencial_seq do campo: si224_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si224_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from dfcdcasp602017_si224_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si224_sequencial)){
         $this->erro_sql = " Campo si224_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si224_sequencial = $si224_sequencial;
       }
     }

     $sql = "insert into dfcdcasp602017(
                                       si224_anousu
                                      ,si224_periodo
                                      ,si224_instit
                                      ,si224_sequencial
                                      ,si224_tiporegistro
                                      ,si224_exercicio
                                      ,si224_vlfluxocaixaliquidoinvestimento
                       )
                values (
                                {$this->si224_anousu}
                               ,{$this->si224_periodo}
                               ,{$this->si224_instit}
                               ,$this->si224_sequencial
                               ,$this->si224_tiporegistro
                               ,$this->si224_exercicio
                               ,$this->si224_vlfluxocaixaliquidoinvestimento
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp602017 ($this->si224_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dfcdcasp602017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dfcdcasp602017 ($this->si224_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si224_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si224_sequencial=null) {
      $this->atualizacampos();
     $sql = " update dfcdcasp602017 set ";
     $virgula = "";
     if(trim($this->si224_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si224_sequencial"])){
       $sql  .= $virgula." si224_sequencial = $this->si224_sequencial ";
       $virgula = ",";
       if(trim($this->si224_sequencial) == null ){
         $this->erro_sql = " Campo si224_sequencial não informado.";
         $this->erro_campo = "si224_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si224_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si224_tiporegistro"])){
       $sql  .= $virgula." si224_tiporegistro = $this->si224_tiporegistro ";
       $virgula = ",";
       if(trim($this->si224_tiporegistro) == null ){
         $this->erro_sql = " Campo si224_tiporegistro não informado.";
         $this->erro_campo = "si224_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si224_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si224_exercicio"])){
       $sql  .= $virgula." si224_exercicio = $this->si224_exercicio ";
       $virgula = ",";
       if(trim($this->si224_exercicio) == null ){
         $this->erro_sql = " Campo si224_exercicio não informado.";
         $this->erro_campo = "si224_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si224_vlfluxocaixaliquidoinvestimento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si224_vlfluxocaixaliquidoinvestimento"])){
       $sql  .= $virgula." si224_vlfluxocaixaliquidoinvestimento = $this->si224_vlfluxocaixaliquidoinvestimento ";
       $virgula = ",";
       if(trim($this->si224_vlfluxocaixaliquidoinvestimento) == null ){
         $this->erro_sql = " Campo si224_vlfluxocaixaliquidoinvestimento não informado.";
         $this->erro_campo = "si224_vlfluxocaixaliquidoinvestimento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si224_sequencial!=null){
       $sql .= " si224_sequencial = $this->si224_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp602017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si224_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp602017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si224_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si224_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si224_sequencial=null,$dbwhere=null) {

     $sql = " delete from dfcdcasp602017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si224_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si224_sequencial = $si224_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp602017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si224_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp602017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si224_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si224_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp602017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si224_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp602017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si224_sequencial!=null ){
         $sql2 .= " where dfcdcasp602017.si224_sequencial = $si224_sequencial ";
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
   function sql_query_file ( $si224_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp602017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si224_sequencial!=null ){
         $sql2 .= " where dfcdcasp602017.si224_sequencial = $si224_sequencial ";
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
