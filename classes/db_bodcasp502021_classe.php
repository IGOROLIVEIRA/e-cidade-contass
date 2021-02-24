<?
//MODULO: sicom
//CLASSE DA ENTIDADE bodcasp502021
class cl_bodcasp502021 {
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
   var $si205_ano      = 0;
   var $si205_periodo  = 0;
   var $si205_institu  = 0;
   var $si205_sequencial = 0;
   var $si205_tiporegistro = 0;
   var $si205_faserestospagarprocnaoliqui = 0;
   var $si205_vlrspprocliqpessoalencarsoc = 0;
   var $si205_vlrspprocliqjurosencardiv = 0;
   var $si205_vlrspprocliqoutrasdespcorrentes = 0;
   var $si205_vlrspprocesliqinv = 0;
   var $si205_vlrspprocliqinverfinan = 0;
   var $si205_vlrspprocliqamortizadivida = 0;
   var $si205_vltotalexecrspprocnaoproceli = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si205_ano = int4 = si205_ano
                 si205_periodo = int4 = si205_periodo
                 si205_institu = int4 = si205_institu
                 si205_sequencial = int4 = si205_sequencial
                 si205_tiporegistro = int4 = si205_tiporegistro
                 si205_faserestospagarprocnaoliqui = int4 = si205_faserestospagarprocnaoliqui
                 si205_vlrspprocliqpessoalencarsoc = float4 = si205_vlrspprocliqpessoalencarsoc
                 si205_vlrspprocliqjurosencardiv = float4 = si205_vlrspprocliqjurosencardiv
                 si205_vlrspprocliqoutrasdespcorrentes = float4 = si205_vlrspprocliqoutrasdespcorrentes
                 si205_vlrspprocesliqinv = float4 = si205_vlrspprocesliqinv
                 si205_vlrspprocliqinverfinan = float4 = si205_vlrspprocliqinverfinan
                 si205_vlrspprocliqamortizadivida = float4 = si205_vlrspprocliqamortizadivida
                 si205_vltotalexecrspprocnaoproceli = float4 = si205_vltotalexecrspprocnaoproceli
                 ";
   //funcao construtor da classe
   function cl_bodcasp502021() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bodcasp502021");
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
       $this->si205_ano = ($this->si205_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_ano"]:$this->si205_ano);
       $this->si205_periodo = ($this->si205_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_periodo"]:$this->si205_periodo);
       $this->si205_institu = ($this->si205_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_institu"]:$this->si205_institu);
       $this->si205_sequencial = ($this->si205_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_sequencial"]:$this->si205_sequencial);
       $this->si205_tiporegistro = ($this->si205_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_tiporegistro"]:$this->si205_tiporegistro);
       $this->si205_faserestospagarprocnaoliqui = ($this->si205_faserestospagarprocnaoliqui == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_faserestospagarprocnaoliqui"]:$this->si205_faserestospagarprocnaoliqui);
       $this->si205_vlrspprocliqpessoalencarsoc = ($this->si205_vlrspprocliqpessoalencarsoc == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqpessoalencarsoc"]:$this->si205_vlrspprocliqpessoalencarsoc);
       $this->si205_vlrspprocliqjurosencardiv = ($this->si205_vlrspprocliqjurosencardiv == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqjurosencardiv"]:$this->si205_vlrspprocliqjurosencardiv);
       $this->si205_vlrspprocliqoutrasdespcorrentes = ($this->si205_vlrspprocliqoutrasdespcorrentes == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqoutrasdespcorrentes"]:$this->si205_vlrspprocliqoutrasdespcorrentes);
       $this->si205_vlrspprocesliqinv = ($this->si205_vlrspprocesliqinv == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocesliqinv"]:$this->si205_vlrspprocesliqinv);
       $this->si205_vlrspprocliqinverfinan = ($this->si205_vlrspprocliqinverfinan == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqinverfinan"]:$this->si205_vlrspprocliqinverfinan);
       $this->si205_vlrspprocliqamortizadivida = ($this->si205_vlrspprocliqamortizadivida == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqamortizadivida"]:$this->si205_vlrspprocliqamortizadivida);
       $this->si205_vltotalexecrspprocnaoproceli = ($this->si205_vltotalexecrspprocnaoproceli == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_vltotalexecrspprocnaoproceli"]:$this->si205_vltotalexecrspprocnaoproceli);
     }else{
       $this->si205_sequencial = ($this->si205_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si205_sequencial"]:$this->si205_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si205_sequencial){
      $this->atualizacampos();
     if ($this->si205_ano == null ) {
       $this->si205_ano = intval(date('Y'));
     }
     if ($this->si205_periodo == null ) {
       $this->si205_periodo = intval(date('m') + 16);
     }
     if ($this->si205_institu == null ) {
       $this->si205_institu = db_getsession("DB_instit");
     }
     if($this->si205_tiporegistro == null ){
        $this->si205_tiporegistro = 50;
     }
     if( empty($this->si205_faserestospagarprocnaoliqui) ){
        $this->si205_faserestospagarprocnaoliqui = 0;
     }
     if( empty($this->si205_vlrspprocliqpessoalencarsoc) ){
        $this->si205_vlrspprocliqpessoalencarsoc = 0;
     }
     if( empty($this->si205_vlrspprocliqjurosencardiv) ){
        $this->si205_vlrspprocliqjurosencardiv = 0;
     }
     if( empty($this->si205_vlrspprocliqoutrasdespcorrentes) ){
        $this->si205_vlrspprocliqoutrasdespcorrentes = 0;
     }
     if( empty($this->si205_vlrspprocesliqinv) ){
        $this->si205_vlrspprocesliqinv = 0;
     }
     if( empty($this->si205_vlrspprocliqinverfinan) ){
        $this->si205_vlrspprocliqinverfinan = 0;
     }
     if( empty($this->si205_vlrspprocliqamortizadivida) ){
        $this->si205_vlrspprocliqamortizadivida = 0;
     }
     if( empty($this->si205_vltotalexecrspprocnaoproceli) ){
        $this->si205_vltotalexecrspprocnaoproceli = 0;
     }


     if($si205_sequencial == "" || $si205_sequencial == null ){
       $result = db_query("select nextval('bodcasp502021_si205_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: bodcasp502021_si205_sequencial_seq do campo: si205_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si205_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from bodcasp502021_si205_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si205_sequencial)){
         $this->erro_sql = " Campo si205_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si205_sequencial = $si205_sequencial;
       }
     }


     $sql = "insert into bodcasp502021(
                                       si205_ano
                                      ,si205_periodo
                                      ,si205_institu
                                      ,si205_sequencial
                                      ,si205_tiporegistro
                                      ,si205_faserestospagarprocnaoliqui
                                      ,si205_vlrspprocliqpessoalencarsoc
                                      ,si205_vlrspprocliqjurosencardiv
                                      ,si205_vlrspprocliqoutrasdespcorrentes
                                      ,si205_vlrspprocesliqinv
                                      ,si205_vlrspprocliqinverfinan
                                      ,si205_vlrspprocliqamortizadivida
                                      ,si205_vltotalexecrspprocnaoproceli
                       )
                values (
                                {$this->si205_ano}
                               ,{$this->si205_periodo}
                               ,{$this->si205_institu}
                               ,{$this->si205_sequencial}
                               ,{$this->si205_tiporegistro}
                               ,{$this->si205_faserestospagarprocnaoliqui}
                               ,{$this->si205_vlrspprocliqpessoalencarsoc}
                               ,{$this->si205_vlrspprocliqjurosencardiv}
                               ,{$this->si205_vlrspprocliqoutrasdespcorrentes}
                               ,{$this->si205_vlrspprocesliqinv}
                               ,{$this->si205_vlrspprocliqinverfinan}
                               ,{$this->si205_vlrspprocliqamortizadivida}
                               ,{$this->si205_vltotalexecrspprocnaoproceli}
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bodcasp502021 ($this->si205_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "bodcasp502021 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "bodcasp502021 ($this->si205_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si205_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si205_sequencial=null) {
      $this->atualizacampos();
     $sql = " update bodcasp502021 set ";
     $virgula = "";
     if(trim($this->si205_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_sequencial"])){
       $sql  .= $virgula." si205_sequencial = $this->si205_sequencial ";
       $virgula = ",";
       if(trim($this->si205_sequencial) == null ){
         $this->erro_sql = " Campo si205_sequencial não informado.";
         $this->erro_campo = "si205_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_tiporegistro"])){
       $sql  .= $virgula." si205_tiporegistro = $this->si205_tiporegistro ";
       $virgula = ",";
       if(trim($this->si205_tiporegistro) == null ){
         $this->erro_sql = " Campo si205_tiporegistro não informado.";
         $this->erro_campo = "si205_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_faserestospagarprocnaoliqui)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_faserestospagarprocnaoliqui"])){
       $sql  .= $virgula." si205_faserestospagarprocnaoliqui = $this->si205_faserestospagarprocnaoliqui ";
       $virgula = ",";
       if(trim($this->si205_faserestospagarprocnaoliqui) == null ){
         $this->erro_sql = " Campo si205_faserestospagarprocnaoliqui não informado.";
         $this->erro_campo = "si205_faserestospagarprocnaoliqui";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_vlrspprocliqpessoalencarsoc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqpessoalencarsoc"])){
       $sql  .= $virgula." si205_vlrspprocliqpessoalencarsoc = $this->si205_vlrspprocliqpessoalencarsoc ";
       $virgula = ",";
       if(trim($this->si205_vlrspprocliqpessoalencarsoc) == null ){
         $this->erro_sql = " Campo si205_vlrspprocliqpessoalencarsoc não informado.";
         $this->erro_campo = "si205_vlrspprocliqpessoalencarsoc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_vlrspprocliqjurosencardiv)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqjurosencardiv"])){
       $sql  .= $virgula." si205_vlrspprocliqjurosencardiv = $this->si205_vlrspprocliqjurosencardiv ";
       $virgula = ",";
       if(trim($this->si205_vlrspprocliqjurosencardiv) == null ){
         $this->erro_sql = " Campo si205_vlrspprocliqjurosencardiv não informado.";
         $this->erro_campo = "si205_vlrspprocliqjurosencardiv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_vlrspprocliqoutrasdespcorrentes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqoutrasdespcorrentes"])){
       $sql  .= $virgula." si205_vlrspprocliqoutrasdespcorrentes = $this->si205_vlrspprocliqoutrasdespcorrentes ";
       $virgula = ",";
       if(trim($this->si205_vlrspprocliqoutrasdespcorrentes) == null ){
         $this->erro_sql = " Campo si205_vlrspprocliqoutrasdespcorrentes não informado.";
         $this->erro_campo = "si205_vlrspprocliqoutrasdespcorrentes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_vlrspprocesliqinv)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocesliqinv"])){
       $sql  .= $virgula." si205_vlrspprocesliqinv = $this->si205_vlrspprocesliqinv ";
       $virgula = ",";
       if(trim($this->si205_vlrspprocesliqinv) == null ){
         $this->erro_sql = " Campo si205_vlrspprocesliqinv não informado.";
         $this->erro_campo = "si205_vlrspprocesliqinv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_vlrspprocliqinverfinan)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqinverfinan"])){
       $sql  .= $virgula." si205_vlrspprocliqinverfinan = $this->si205_vlrspprocliqinverfinan ";
       $virgula = ",";
       if(trim($this->si205_vlrspprocliqinverfinan) == null ){
         $this->erro_sql = " Campo si205_vlrspprocliqinverfinan não informado.";
         $this->erro_campo = "si205_vlrspprocliqinverfinan";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_vlrspprocliqamortizadivida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_vlrspprocliqamortizadivida"])){
       $sql  .= $virgula." si205_vlrspprocliqamortizadivida = $this->si205_vlrspprocliqamortizadivida ";
       $virgula = ",";
       if(trim($this->si205_vlrspprocliqamortizadivida) == null ){
         $this->erro_sql = " Campo si205_vlrspprocliqamortizadivida não informado.";
         $this->erro_campo = "si205_vlrspprocliqamortizadivida";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si205_vltotalexecrspprocnaoproceli)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si205_vltotalexecrspprocnaoproceli"])){
       $sql  .= $virgula." si205_vltotalexecrspprocnaoproceli = $this->si205_vltotalexecrspprocnaoproceli ";
       $virgula = ",";
       if(trim($this->si205_vltotalexecrspprocnaoproceli) == null ){
         $this->erro_sql = " Campo si205_vltotalexecrspprocnaoproceli não informado.";
         $this->erro_campo = "si205_vltotalexecrspprocnaoproceli";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si205_sequencial!=null){
       $sql .= " si205_sequencial = $this->si205_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bodcasp502021 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si205_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp502021 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si205_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si205_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si205_sequencial=null,$dbwhere=null) {

     $sql = " delete from bodcasp502021
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si205_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si205_sequencial = $si205_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "bodcasp502021 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si205_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bodcasp502021 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si205_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si205_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bodcasp502021";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si205_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bodcasp502021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si205_sequencial!=null ){
         $sql2 .= " where bodcasp502021.si205_sequencial = $si205_sequencial ";
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
   function sql_query_file ( $si205_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from bodcasp502021 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si205_sequencial!=null ){
         $sql2 .= " where bodcasp502021.si205_sequencial = $si205_sequencial ";
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
