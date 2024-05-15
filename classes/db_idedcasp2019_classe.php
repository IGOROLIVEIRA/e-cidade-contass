<?
//MODULO: sicom
//CLASSE DA ENTIDADE idedcasp2019
class cl_idedcasp2019 {
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
   var $si200_anousu  = 0;
   var $si200_instit  = 0;
   var $si200_sequencial = 0;
   var $si200_codmunicipio = null;
   var $si200_cnpjorgao = null;
   var $si200_codorgao = null;
   var $si200_tipoorgao = null;
   var $si200_tipodemcontabil = 0;
   var $si200_exercicioreferencia = 0;
   var $si200_datageracao_dia = null;
   var $si200_datageracao_mes = null;
   var $si200_datageracao_ano = null;
   var $si200_datageracao = null;
   var $si200_codcontroleremessa = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si200_sequencial = int4 = si200_sequencial
                 si200_codmunicipio = varchar(5) = si200_codmunicipio
                 si200_cnpjorgao = varchar(14) = si200_cnpjorgao
                 si200_codorgao = varchar(2) = si200_codorgao
                 si200_tipoorgao = varchar(2) = si200_tipoorgao
                 si200_tipodemcontabil = int4 = si200_tipodemcontabil
                 si200_exercicioreferencia = int4 = si200_exercicioreferencia
                 si200_datageracao = date = si200_datageracao
                 si200_codcontroleremessa = varchar(20) = si200_codcontroleremessa
                 si200_anousu = int4 = si200_anousu
                 si200_instit = int4 = si200_instit
                 ";
   //funcao construtor da classe
   function cl_idedcasp2019() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("idedcasp2019");
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
       $this->si200_anousu = ($this->si200_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_anousu"]:$this->si200_anousu);
       $this->si200_instit = ($this->si200_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_instit"]:$this->si200_instit);
       $this->si200_sequencial = ($this->si200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_sequencial"]:$this->si200_sequencial);
       $this->si200_codmunicipio = ($this->si200_codmunicipio == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_codmunicipio"]:$this->si200_codmunicipio);
       $this->si200_cnpjorgao = ($this->si200_cnpjorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_cnpjorgao"]:$this->si200_cnpjorgao);
       $this->si200_codorgao = ($this->si200_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_codorgao"]:$this->si200_codorgao);
       $this->si200_tipoorgao = ($this->si200_tipoorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_tipoorgao"]:$this->si200_tipoorgao);
       $this->si200_tipodemcontabil = ($this->si200_tipodemcontabil == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_tipodemcontabil"]:$this->si200_tipodemcontabil);
       $this->si200_exercicioreferencia = ($this->si200_exercicioreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_exercicioreferencia"]:$this->si200_exercicioreferencia);
       if($this->si200_datageracao == ""){
         $this->si200_datageracao_dia = ($this->si200_datageracao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_datageracao_dia"]:$this->si200_datageracao_dia);
         $this->si200_datageracao_mes = ($this->si200_datageracao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_datageracao_mes"]:$this->si200_datageracao_mes);
         $this->si200_datageracao_ano = ($this->si200_datageracao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_datageracao_ano"]:$this->si200_datageracao_ano);
         if($this->si200_datageracao_dia != ""){
            $this->si200_datageracao = $this->si200_datageracao_ano."-".$this->si200_datageracao_mes."-".$this->si200_datageracao_dia;
         }
       }
       $this->si200_codcontroleremessa = ($this->si200_codcontroleremessa == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_codcontroleremessa"]:$this->si200_codcontroleremessa);
     }else{
       $this->si200_sequencial = ($this->si200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_sequencial"]:$this->si200_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si200_sequencial){
      $this->atualizacampos();
     if ($this->si200_anousu == null ) {
       $this->si200_anousu = db_getsession("DB_anousu");
     }
     if ($this->si200_instit == null ) {
       $this->si200_instit = db_getsession("DB_instit");
     }
     if($this->si200_codmunicipio == null ){
       $this->erro_sql = " Campo si200_codmunicipio não informado.";
       $this->erro_campo = "si200_codmunicipio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si200_cnpjorgao == null ){
       $this->erro_sql = " Campo si200_cnpjorgao não informado.";
       $this->erro_campo = "si200_cnpjorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si200_codorgao == null ){
       $this->erro_sql = " Campo si200_codorgao não informado.";
       $this->erro_campo = "si200_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si200_tipoorgao == null ){
       $this->erro_sql = " Campo si200_tipoorgao não informado.";
       $this->erro_campo = "si200_tipoorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si200_tipodemcontabil == null ){
       $this->erro_sql = " Campo si200_tipodemcontabil não informado.";
       $this->erro_campo = "si200_tipodemcontabil";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si200_exercicioreferencia == null ){
       $this->erro_sql = " Campo si200_exercicioreferencia não informado.";
       $this->erro_campo = "si200_exercicioreferencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si200_datageracao == null ){
       $this->erro_sql = " Campo si200_datageracao não informado.";
       $this->erro_campo = "si200_datageracao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si200_codcontroleremessa == null ){
       $this->erro_sql = " Campo si200_codcontroleremessa não informado.";
       $this->erro_campo = "si200_codcontroleremessa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }

     if(empty($si200_sequencial)){
       $result = db_query("select nextval('idedcasp2019_si200_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: idedcasp2019_si200_sequencial_seq do campo: si200_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si200_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from idedcasp2019_si200_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si200_sequencial)){
         $this->erro_sql = " Campo si200_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si200_sequencial = $si200_sequencial;
       }
     }

     $sql = "insert into idedcasp2019(
                                       si200_sequencial
                                      ,si200_codmunicipio
                                      ,si200_cnpjorgao
                                      ,si200_codorgao
                                      ,si200_tipoorgao
                                      ,si200_tipodemcontabil
                                      ,si200_exercicioreferencia
                                      ,si200_datageracao
                                      ,si200_codcontroleremessa
                                      ,si200_anousu
                                      ,si200_instit
                       )
                values (
                                $this->si200_sequencial
                               ,'$this->si200_codmunicipio'
                               ,'$this->si200_cnpjorgao'
                               ,'$this->si200_codorgao'
                               ,'$this->si200_tipoorgao'
                               ,$this->si200_tipodemcontabil
                               ,$this->si200_exercicioreferencia
                               ,".($this->si200_datageracao == "null" || $this->si200_datageracao == ""?"null":"'".$this->si200_datageracao."'")."
                               ,'$this->si200_codcontroleremessa'
                               ,{$this->si200_anousu}
                               ,{$this->si200_instit}
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "idedcasp2019 ($this->si200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "idedcasp2019 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "idedcasp2019 ($this->si200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si200_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }
   // funcao para alteracao
   function alterar ($si200_sequencial=null) {
      $this->atualizacampos();
     $sql = " update idedcasp2019 set ";
     $virgula = "";
     if(trim($this->si200_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_sequencial"])){
       $sql  .= $virgula." si200_sequencial = $this->si200_sequencial ";
       $virgula = ",";
       if(trim($this->si200_sequencial) == null ){
         $this->erro_sql = " Campo si200_sequencial não informado.";
         $this->erro_campo = "si200_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si200_codmunicipio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_codmunicipio"])){
       $sql  .= $virgula." si200_codmunicipio = '$this->si200_codmunicipio' ";
       $virgula = ",";
       if(trim($this->si200_codmunicipio) == null ){
         $this->erro_sql = " Campo si200_codmunicipio não informado.";
         $this->erro_campo = "si200_codmunicipio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si200_cnpjorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_cnpjorgao"])){
       $sql  .= $virgula." si200_cnpjorgao = '$this->si200_cnpjorgao' ";
       $virgula = ",";
       if(trim($this->si200_cnpjorgao) == null ){
         $this->erro_sql = " Campo si200_cnpjorgao não informado.";
         $this->erro_campo = "si200_cnpjorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si200_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_codorgao"])){
       $sql  .= $virgula." si200_codorgao = '$this->si200_codorgao' ";
       $virgula = ",";
       if(trim($this->si200_codorgao) == null ){
         $this->erro_sql = " Campo si200_codorgao não informado.";
         $this->erro_campo = "si200_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si200_tipoorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_tipoorgao"])){
       $sql  .= $virgula." si200_tipoorgao = '$this->si200_tipoorgao' ";
       $virgula = ",";
       if(trim($this->si200_tipoorgao) == null ){
         $this->erro_sql = " Campo si200_tipoorgao não informado.";
         $this->erro_campo = "si200_tipoorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si200_tipodemcontabil)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_tipodemcontabil"])){
       $sql  .= $virgula." si200_tipodemcontabil = $this->si200_tipodemcontabil ";
       $virgula = ",";
       if(trim($this->si200_tipodemcontabil) == null ){
         $this->erro_sql = " Campo si200_tipodemcontabil não informado.";
         $this->erro_campo = "si200_tipodemcontabil";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si200_exercicioreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_exercicioreferencia"])){
       $sql  .= $virgula." si200_exercicioreferencia = $this->si200_exercicioreferencia ";
       $virgula = ",";
       if(trim($this->si200_exercicioreferencia) == null ){
         $this->erro_sql = " Campo si200_exercicioreferencia não informado.";
         $this->erro_campo = "si200_exercicioreferencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si200_datageracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_datageracao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si200_datageracao_dia"] !="") ){
       $sql  .= $virgula." si200_datageracao = '$this->si200_datageracao' ";
       $virgula = ",";
       if(trim($this->si200_datageracao) == null ){
         $this->erro_sql = " Campo si200_datageracao não informado.";
         $this->erro_campo = "si200_datageracao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si200_datageracao_dia"])){
         $sql  .= $virgula." si200_datageracao = null ";
         $virgula = ",";
         if(trim($this->si200_datageracao) == null ){
           $this->erro_sql = " Campo si200_datageracao não informado.";
           $this->erro_campo = "si200_datageracao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si200_codcontroleremessa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_codcontroleremessa"])){
       $sql  .= $virgula." si200_codcontroleremessa = '$this->si200_codcontroleremessa' ";
       $virgula = ",";
       if(trim($this->si200_codcontroleremessa) == null ){
         $this->erro_sql = " Campo si200_codcontroleremessa não informado.";
         $this->erro_campo = "si200_codcontroleremessa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si200_sequencial!=null){
       $sql .= " si200_sequencial = $this->si200_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "idedcasp2019 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si200_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "idedcasp2019 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si200_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si200_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si200_sequencial=null,$dbwhere=null) {

     $sql = " delete from idedcasp2019
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si200_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si200_sequencial = $si200_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "idedcasp2019 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si200_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "idedcasp2019 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si200_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si200_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:idedcasp2019";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from idedcasp2019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si200_sequencial!=null ){
         $sql2 .= " where idedcasp2019.si200_sequencial = $si200_sequencial ";
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
   function sql_query_file ( $si200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from idedcasp2019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si200_sequencial!=null ){
         $sql2 .= " where idedcasp2019.si200_sequencial = $si200_sequencial ";
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
