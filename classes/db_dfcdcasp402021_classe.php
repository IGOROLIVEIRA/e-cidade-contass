<?
//MODULO: sicom
//CLASSE DA ENTIDADE dfcdcasp402021
class cl_dfcdcasp402021 {
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
   var $si222_anousu  = 0;
   var $si222_periodo = 0;
   var $si222_instit  = 0;
   var $si222_sequencial = 0;
   var $si222_tiporegistro = 0;
   var $si222_vlalienacaobens = 0;
   var $si222_vlamortizacaoemprestimoconcedido = 0;
   var $si222_vloutrosingressos = 0;
   var $si222_vltotalingressosatividainvestiment = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si222_anousu = int4 = si222_anousu
                 si222_periodo = int4 = si222_periodo
                 si222_instit = int4 = si222_instit
                 si222_sequencial = int4 = si222_sequencial
                 si222_tiporegistro = int4 = si222_tiporegistro
                 si222_vlalienacaobens = float8 = si222_vlalienacaobens
                 si222_vlamortizacaoemprestimoconcedido = float8 = si222_vlamortizacaoemprestimoconcedido
                 si222_vloutrosingressos = float8 = si222_vloutrosingressos
                 si222_vltotalingressosatividainvestiment = float8 = si222_vltotalingressosatividainvestiment
                 ";
   //funcao construtor da classe
   function cl_dfcdcasp402021() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dfcdcasp402021");
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
       $this->si222_anousu = ($this->si222_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_anousu"]:$this->si222_anousu);
       $this->si222_periodo = ($this->si222_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_periodo"]:$this->si222_periodo);
       $this->si222_instit = ($this->si222_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_instit"]:$this->si222_instit);
       $this->si222_sequencial = ($this->si222_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_sequencial"]:$this->si222_sequencial);
       $this->si222_tiporegistro = ($this->si222_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_tiporegistro"]:$this->si222_tiporegistro);
       $this->si222_vlalienacaobens = ($this->si222_vlalienacaobens == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_vlalienacaobens"]:$this->si222_vlalienacaobens);
       $this->si222_vlamortizacaoemprestimoconcedido = ($this->si222_vlamortizacaoemprestimoconcedido == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_vlamortizacaoemprestimoconcedido"]:$this->si222_vlamortizacaoemprestimoconcedido);
       $this->si222_vloutrosingressos = ($this->si222_vloutrosingressos == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_vloutrosingressos"]:$this->si222_vloutrosingressos);
       $this->si222_vltotalingressosatividainvestiment = ($this->si222_vltotalingressosatividainvestiment == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_vltotalingressosatividainvestiment"]:$this->si222_vltotalingressosatividainvestiment);
     }else{
       $this->si222_sequencial = ($this->si222_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si222_sequencial"]:$this->si222_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si222_sequencial){
      $this->atualizacampos();
     if (empty($this->si222_anousu)) {
       $this->si222_anousu = db_getsession("DB_anousu");
     }
     if (empty($this->si222_periodo)) {
       $this->si222_periodo = 28;
     }
     if (empty($this->si222_instit)) {
       $this->si222_instit = db_getsession("DB_instit");
     }

     if ( empty($this->si222_tiporegistro) ){
        $this->si222_tiporegistro = 40;
     }
     if ( empty($this->si222_vlalienacaobens) ){
        $this->si222_vlalienacaobens = 0;
     }
     if ( empty($this->si222_vlamortizacaoemprestimoconcedido) ){
        $this->si222_vlamortizacaoemprestimoconcedido = 0;
     }
     if ( empty($this->si222_vloutrosingressos) ){
        $this->si222_vloutrosingressos = 0;
     }
     if ( empty($this->si222_vltotalingressosatividainvestiment) ){
        $this->si222_vltotalingressosatividainvestiment = 0;
     }

     if(empty($si222_sequencial)){
       $result = db_query("select nextval('dfcdcasp402021_si222_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dfcdcasp402021_si222_sequencial_seq do campo: si222_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si222_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from dfcdcasp402021_si222_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si222_sequencial)){
         $this->erro_sql = " Campo si222_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si222_sequencial = $si222_sequencial;
       }
     }

     $sql = "insert into dfcdcasp402021(
                                       si222_anousu
                                      ,si222_periodo
                                      ,si222_instit
                                      ,si222_sequencial
                                      ,si222_tiporegistro
                                      ,si222_vlalienacaobens
                                      ,si222_vlamortizacaoemprestimoconcedido
                                      ,si222_vloutrosingressos
                                      ,si222_vltotalingressosatividainvestiment
                       )
                values (
                                {$this->si222_anousu}
                               ,{$this->si222_periodo}
                               ,{$this->si222_instit}
                               ,$this->si222_sequencial
                               ,$this->si222_tiporegistro
                               ,$this->si222_vlalienacaobens
                               ,$this->si222_vlamortizacaoemprestimoconcedido
                               ,$this->si222_vloutrosingressos
                               ,$this->si222_vltotalingressosatividainvestiment
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dfcdcasp402021 ($this->si222_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dfcdcasp402021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dfcdcasp402021 ($this->si222_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si222_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si222_sequencial=null) {
      $this->atualizacampos();
     $sql = " update dfcdcasp402021 set ";
     $virgula = "";
     if(trim($this->si222_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si222_sequencial"])){
       $sql  .= $virgula." si222_sequencial = $this->si222_sequencial ";
       $virgula = ",";
       if(trim($this->si222_sequencial) == null ){
         $this->erro_sql = " Campo si222_sequencial não informado.";
         $this->erro_campo = "si222_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si222_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si222_tiporegistro"])){
       $sql  .= $virgula." si222_tiporegistro = $this->si222_tiporegistro ";
       $virgula = ",";
       if(trim($this->si222_tiporegistro) == null ){
         $this->erro_sql = " Campo si222_tiporegistro não informado.";
         $this->erro_campo = "si222_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si222_vlalienacaobens)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si222_vlalienacaobens"])){
       $sql  .= $virgula." si222_vlalienacaobens = $this->si222_vlalienacaobens ";
       $virgula = ",";
       if(trim($this->si222_vlalienacaobens) == null ){
         $this->erro_sql = " Campo si222_vlalienacaobens não informado.";
         $this->erro_campo = "si222_vlalienacaobens";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si222_vlamortizacaoemprestimoconcedido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si222_vlamortizacaoemprestimoconcedido"])){
       $sql  .= $virgula." si222_vlamortizacaoemprestimoconcedido = $this->si222_vlamortizacaoemprestimoconcedido ";
       $virgula = ",";
       if(trim($this->si222_vlamortizacaoemprestimoconcedido) == null ){
         $this->erro_sql = " Campo si222_vlamortizacaoemprestimoconcedido não informado.";
         $this->erro_campo = "si222_vlamortizacaoemprestimoconcedido";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si222_vloutrosingressos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si222_vloutrosingressos"])){
       $sql  .= $virgula." si222_vloutrosingressos = $this->si222_vloutrosingressos ";
       $virgula = ",";
       if(trim($this->si222_vloutrosingressos) == null ){
         $this->erro_sql = " Campo si222_vloutrosingressos não informado.";
         $this->erro_campo = "si222_vloutrosingressos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si222_vltotalingressosatividainvestiment)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si222_vltotalingressosatividainvestiment"])){
       $sql  .= $virgula." si222_vltotalingressosatividainvestiment = $this->si222_vltotalingressosatividainvestiment ";
       $virgula = ",";
       if(trim($this->si222_vltotalingressosatividainvestiment) == null ){
         $this->erro_sql = " Campo si222_vltotalingressosatividainvestiment não informado.";
         $this->erro_campo = "si222_vltotalingressosatividainvestiment";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si222_sequencial!=null){
       $sql .= " si222_sequencial = $this->si222_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp402021 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si222_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp402021 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si222_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si222_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si222_sequencial=null,$dbwhere=null) {

     $sql = " delete from dfcdcasp402021
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si222_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si222_sequencial = $si222_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dfcdcasp402021 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si222_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dfcdcasp402021 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si222_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si222_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dfcdcasp402021";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si222_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp402021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si222_sequencial!=null ){
         $sql2 .= " where dfcdcasp402021.si222_sequencial = $si222_sequencial ";
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
   function sql_query_file ( $si222_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dfcdcasp402021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si222_sequencial!=null ){
         $sql2 .= " where dfcdcasp402021.si222_sequencial = $si222_sequencial ";
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
