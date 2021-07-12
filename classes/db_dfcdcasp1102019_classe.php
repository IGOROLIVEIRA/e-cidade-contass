<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp1102019
class cl_dfcdcasp1102019 {
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
   var $si229_anousu  = 0;
   var $si229_periodo = 0;
   var $si229_instit  = 0;
   var $si229_sequencial = 0;
   var $si229_tiporegistro = 0;
   var $si229_vlcaixaequivalentecaixainicial = 0;
   var $si229_vlcaixaequivalentecaixafinal = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si229_anousu = int4 = si229_anousu
                 si229_periodo = int4 = si229_periodo
                 si229_instit = int4 = si229_instit
                 si229_sequencial = int4 = si229_sequencial
                 si229_tiporegistro = int4 = si229_tiporegistro
                 si229_vlcaixaequivalentecaixainicial = float8 = si229_vlcaixaequivalentecaixainicial
                 si229_vlcaixaequivalentecaixafinal = float8 = si229_vlcaixaequivalentecaixafinal
                 ";
   //funcao construtor da classe
   function cl_dfcdcasp1102019() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp1102019");
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
       $this->si229_anousu = ($this->si229_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_anousu"]:$this->si229_anousu);
       $this->si229_periodo = ($this->si229_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_periodo"]:$this->si229_periodo);
       $this->si229_instit = ($this->si229_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_instit"]:$this->si229_instit);
       $this->si229_sequencial = ($this->si229_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_sequencial"]:$this->si229_sequencial);
       $this->si229_tiporegistro = ($this->si229_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_tiporegistro"]:$this->si229_tiporegistro);
       $this->si229_vlcaixaequivalentecaixainicial = ($this->si229_vlcaixaequivalentecaixainicial == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixainicial"]:$this->si229_vlcaixaequivalentecaixainicial);
       $this->si229_vlcaixaequivalentecaixafinal = ($this->si229_vlcaixaequivalentecaixafinal == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixafinal"]:$this->si229_vlcaixaequivalentecaixafinal);
     }else{
       $this->si229_sequencial = ($this->si229_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si229_sequencial"]:$this->si229_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si229_sequencial){
      $this->atualizacampos();
     if (empty($this->si229_anousu)) {
       $this->si229_anousu = db_getsession("DB_anousu");
     }
     if (empty($this->si229_periodo)) {
       $this->si229_periodo = 28;
     }
     if (empty($this->si229_instit)) {
       $this->si229_instit = db_getsession("DB_instit");
     }
     if (empty($this->si229_tiporegistro)) {
        $this->si229_tiporegistro = 110;
     }
     if (empty($this->si229_vlcaixaequivalentecaixainicial)) {
        $this->si229_vlcaixaequivalentecaixainicial = 0;
     }
     if (empty($this->si229_vlcaixaequivalentecaixafinal)) {
        $this->si229_vlcaixaequivalentecaixafinal = 0;
     }

     if(empty($si229_sequencial)){
       $result = db_query("select nextval('dfcdcasp1102019_si229_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dfcdcasp1102019_si229_sequencial_seq do campo: si229_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si229_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from dfcdcasp1102019_si229_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si229_sequencial)){
         $this->erro_sql = " Campo si229_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si229_sequencial = $si229_sequencial;
       }
     }

     $sql = "insert into dfcdcasp1102019(
                                       si229_anousu
                                      ,si229_periodo
                                      ,si229_instit
                                      ,si229_sequencial
                                      ,si229_tiporegistro
                                      ,si229_vlcaixaequivalentecaixainicial
                                      ,si229_vlcaixaequivalentecaixafinal
                       )
                values (
                                {$this->si229_anousu}
                               ,{$this->si229_periodo}
                               ,{$this->si229_instit}
                               ,$this->si229_sequencial
                               ,$this->si229_tiporegistro
                               ,$this->si229_vlcaixaequivalentecaixainicial
                               ,$this->si229_vlcaixaequivalentecaixafinal
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp1102019 ($this->si229_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dfcdcasp1102019 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dfcdcasp1102019 ($this->si229_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si229_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si229_sequencial=null) {
      $this->atualizacampos();
     $sql = " update dfcdcasp1102019 set ";
     $virgula = "";
     if(trim($this->si229_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si229_sequencial"])){
       $sql  .= $virgula." si229_sequencial = $this->si229_sequencial ";
       $virgula = ",";
       if(trim($this->si229_sequencial) == null ){
         $this->erro_sql = " Campo si229_sequencial não informado.";
         $this->erro_campo = "si229_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si229_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si229_tiporegistro"])){
       $sql  .= $virgula." si229_tiporegistro = $this->si229_tiporegistro ";
       $virgula = ",";
       if(trim($this->si229_tiporegistro) == null ){
         $this->erro_sql = " Campo si229_tiporegistro não informado.";
         $this->erro_campo = "si229_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si229_vlcaixaequivalentecaixainicial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixainicial"])){
       $sql  .= $virgula." si229_vlcaixaequivalentecaixainicial = $this->si229_vlcaixaequivalentecaixainicial ";
       $virgula = ",";
       if(trim($this->si229_vlcaixaequivalentecaixainicial) == null ){
         $this->erro_sql = " Campo si229_vlcaixaequivalentecaixainicial não informado.";
         $this->erro_campo = "si229_vlcaixaequivalentecaixainicial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si229_vlcaixaequivalentecaixafinal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si229_vlcaixaequivalentecaixafinal"])){
       $sql  .= $virgula." si229_vlcaixaequivalentecaixafinal = $this->si229_vlcaixaequivalentecaixafinal ";
       $virgula = ",";
       if(trim($this->si229_vlcaixaequivalentecaixafinal) == null ){
         $this->erro_sql = " Campo si229_vlcaixaequivalentecaixafinal não informado.";
         $this->erro_campo = "si229_vlcaixaequivalentecaixafinal";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si229_sequencial!=null){
       $sql .= " si229_sequencial = $this->si229_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp1102019 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si229_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp1102019 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si229_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si229_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si229_sequencial=null,$dbwhere=null) {

     $sql = " delete from dfcdcasp1102019
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si229_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si229_sequencial = $si229_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp1102019 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si229_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp1102019 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si229_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si229_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp1102019";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si229_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp1102019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si229_sequencial!=null ){
         $sql2 .= " where dfcdcasp1102019.si229_sequencial = $si229_sequencial ";
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
   function sql_query_file ( $si229_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp1102019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si229_sequencial!=null ){
         $sql2 .= " where dfcdcasp1102019.si229_sequencial = $si229_sequencial ";
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
