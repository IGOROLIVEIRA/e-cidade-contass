<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp802018
class cl_dfcdcasp802018 {
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
   var $si226_anousu  = 0;
   var $si226_periodo = 0;
   var $si226_instit  = 0;
   var $si226_sequencial = 0;
   var $si226_tiporegistro = 0;
   var $si226_vlamortizacaorefinanciamento = 0;
   var $si226_vloutrosdesembolsosfinanciamento = 0;
   var $si226_vltotaldesembolsoatividafinanciame = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si226_anousu = int4 = si226_anousu
                 si226_periodo = int4 = si226_periodo
                 si226_instit = int4 = si226_instit
                 si226_sequencial = int4 = si226_sequencial
                 si226_tiporegistro = int4 = si226_tiporegistro
                 si226_vlamortizacaorefinanciamento = float8 = si226_vlamortizacaorefinanciamento
                 si226_vloutrosdesembolsosfinanciamento = float8 = si226_vloutrosdesembolsosfinanciamento
                 si226_vltotaldesembolsoatividafinanciame = float8 = si226_vltotaldesembolsoatividafinanciame
                 ";
   //funcao construtor da classe
   function cl_dfcdcasp802018() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp802018");
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
       $this->si226_anousu = ($this->si226_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_anousu"]:$this->si226_anousu);
       $this->si226_periodo = ($this->si226_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_periodo"]:$this->si226_periodo);
       $this->si226_instit = ($this->si226_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_instit"]:$this->si226_instit);
       $this->si226_sequencial = ($this->si226_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_sequencial"]:$this->si226_sequencial);
       $this->si226_tiporegistro = ($this->si226_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_tiporegistro"]:$this->si226_tiporegistro);
       $this->si226_vlamortizacaorefinanciamento = ($this->si226_vlamortizacaorefinanciamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_vlamortizacaorefinanciamento"]:$this->si226_vlamortizacaorefinanciamento);
       $this->si226_vloutrosdesembolsosfinanciamento = ($this->si226_vloutrosdesembolsosfinanciamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_vloutrosdesembolsosfinanciamento"]:$this->si226_vloutrosdesembolsosfinanciamento);
       $this->si226_vltotaldesembolsoatividafinanciame = ($this->si226_vltotaldesembolsoatividafinanciame == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_vltotaldesembolsoatividafinanciame"]:$this->si226_vltotaldesembolsoatividafinanciame);
     }else{
       $this->si226_sequencial = ($this->si226_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si226_sequencial"]:$this->si226_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si226_sequencial){
      $this->atualizacampos();
     if (empty($this->si226_anousu)) {
       $this->si226_anousu = db_getsession("DB_anousu");
     }
     if (empty($this->si226_periodo)) {
       $this->si226_periodo = 28;
     }
     if (empty($this->si226_instit)) {
       $this->si226_instit = db_getsession("DB_instit");
     }
     if (empty($this->si226_tiporegistro)) {
        $this->si226_tiporegistro = 80;
     }
     if (empty($this->si226_vlamortizacaorefinanciamento)) {
        $this->si226_vlamortizacaorefinanciamento = 0;
     }
     if (empty($this->si226_vloutrosdesembolsosfinanciamento)) {
        $this->si226_vloutrosdesembolsosfinanciamento = 0;
     }
     if (empty($this->si226_vltotaldesembolsoatividafinanciame)) {
        $this->si226_vltotaldesembolsoatividafinanciame = 0;
     }


     if(empty($si226_sequencial)){
       $result = db_query("select nextval('dfcdcasp802018_si226_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dfcdcasp802018_si226_sequencial_seq do campo: si226_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si226_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from dfcdcasp802018_si226_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si226_sequencial)){
         $this->erro_sql = " Campo si226_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si226_sequencial = $si226_sequencial;
       }
     }


     $sql = "insert into dfcdcasp802018(
                                       si226_anousu
                                      ,si226_periodo
                                      ,si226_instit
                                      ,si226_sequencial
                                      ,si226_tiporegistro
                                      ,si226_vlamortizacaorefinanciamento
                                      ,si226_vloutrosdesembolsosfinanciamento
                                      ,si226_vltotaldesembolsoatividafinanciame
                       )
                values (
                                {$this->si226_anousu}
                               ,{$this->si226_periodo}
                               ,{$this->si226_instit}
                               ,$this->si226_sequencial
                               ,$this->si226_tiporegistro
                               ,$this->si226_vlamortizacaorefinanciamento
                               ,$this->si226_vloutrosdesembolsosfinanciamento
                               ,$this->si226_vltotaldesembolsoatividafinanciame
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp802018 ($this->si226_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dfcdcasp802018 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dfcdcasp802018 ($this->si226_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si226_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si226_sequencial=null) {
      $this->atualizacampos();
     $sql = " update dfcdcasp802018 set ";
     $virgula = "";
     if(trim($this->si226_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_sequencial"])){
       $sql  .= $virgula." si226_sequencial = $this->si226_sequencial ";
       $virgula = ",";
       if(trim($this->si226_sequencial) == null ){
         $this->erro_sql = " Campo si226_sequencial não informado.";
         $this->erro_campo = "si226_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si226_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_tiporegistro"])){
       $sql  .= $virgula." si226_tiporegistro = $this->si226_tiporegistro ";
       $virgula = ",";
       if(trim($this->si226_tiporegistro) == null ){
         $this->erro_sql = " Campo si226_tiporegistro não informado.";
         $this->erro_campo = "si226_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si226_vlamortizacaorefinanciamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_vlamortizacaorefinanciamento"])){
       $sql  .= $virgula." si226_vlamortizacaorefinanciamento = $this->si226_vlamortizacaorefinanciamento ";
       $virgula = ",";
       if(trim($this->si226_vlamortizacaorefinanciamento) == null ){
         $this->erro_sql = " Campo si226_vlamortizacaorefinanciamento não informado.";
         $this->erro_campo = "si226_vlamortizacaorefinanciamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si226_vloutrosdesembolsosfinanciamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_vloutrosdesembolsosfinanciamento"])){
       $sql  .= $virgula." si226_vloutrosdesembolsosfinanciamento = $this->si226_vloutrosdesembolsosfinanciamento ";
       $virgula = ",";
       if(trim($this->si226_vloutrosdesembolsosfinanciamento) == null ){
         $this->erro_sql = " Campo si226_vloutrosdesembolsosfinanciamento não informado.";
         $this->erro_campo = "si226_vloutrosdesembolsosfinanciamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si226_vltotaldesembolsoatividafinanciame)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si226_vltotaldesembolsoatividafinanciame"])){
       $sql  .= $virgula." si226_vltotaldesembolsoatividafinanciame = $this->si226_vltotaldesembolsoatividafinanciame ";
       $virgula = ",";
       if(trim($this->si226_vltotaldesembolsoatividafinanciame) == null ){
         $this->erro_sql = " Campo si226_vltotaldesembolsoatividafinanciame não informado.";
         $this->erro_campo = "si226_vltotaldesembolsoatividafinanciame";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si226_sequencial!=null){
       $sql .= " si226_sequencial = $this->si226_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp802018 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si226_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp802018 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si226_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si226_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si226_sequencial=null,$dbwhere=null) {

     $sql = " delete from dfcdcasp802018
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si226_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si226_sequencial = $si226_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp802018 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si226_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp802018 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si226_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si226_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp802018";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si226_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp802018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si226_sequencial!=null ){
         $sql2 .= " where dfcdcasp802018.si226_sequencial = $si226_sequencial ";
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
   function sql_query_file ( $si226_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp802018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si226_sequencial!=null ){
         $sql2 .= " where dfcdcasp802018.si226_sequencial = $si226_sequencial ";
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
