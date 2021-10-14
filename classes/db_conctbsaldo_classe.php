<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE conctbsaldo
class cl_conctbsaldo {
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
   var $ces02_sequencial = 0;
   var $ces02_codcon = 0;
   var $ces02_reduz = 0;
   var $ces02_fonte = 0;
   var $ces02_valor = 0;
   var $ces02_anousu = 0;
   var $ces02_inst = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 ces02_sequencial = int8 = ces02_sequencial
                 ces02_codcon = int8 = Plano de contas
                 ces02_reduz = int8 = Reduzido
                 ces02_fonte = int8 = Fonte
                 ces02_valor = float8 = Valor
                 ces02_anousu = int8 = ces02_anousu
                 ces02_inst = int8 = ces02_inst
                 ";
   //funcao construtor da classe
   function __construct() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("conctbsaldo");
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
       $this->ces02_sequencial = ($this->ces02_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ces02_sequencial"]:$this->ces02_sequencial);
       $this->ces02_codcon = ($this->ces02_codcon == ""?@$GLOBALS["HTTP_POST_VARS"]["ces02_codcon"]:$this->ces02_codcon);
       $this->ces02_reduz = ($this->ces02_reduz == ""?@$GLOBALS["HTTP_POST_VARS"]["ces02_reduz"]:$this->ces02_reduz);
       $this->ces02_fonte = ($this->ces02_fonte == ""?@$GLOBALS["HTTP_POST_VARS"]["ces02_fonte"]:$this->ces02_fonte);
       $this->ces02_valor = ($this->ces02_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["ces02_valor"]:$this->ces02_valor);
       $this->ces02_anousu = ($this->ces02_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["ces02_anousu"]:$this->ces02_anousu);
       $this->ces02_inst = ($this->ces02_inst == ""?@$GLOBALS["HTTP_POST_VARS"]["ces02_inst"]:$this->ces02_inst);
     }else{
       $this->ces02_sequencial = ($this->ces02_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ces02_sequencial"]:$this->ces02_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($ces02_sequencial){

      $this->atualizacampos();

     if($this->ces02_codcon == null ){
       $this->erro_sql = " Campo Plano de contas não informado.";
       $this->erro_campo = "ces02_codcon";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ces02_reduz == null ){
       $this->erro_sql = " Campo Reduzido não informado.";
       $this->erro_campo = "ces02_reduz";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ces02_fonte == null ){
       $this->erro_sql = " Campo Fonte não informado.";
       $this->erro_campo = "ces02_fonte";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ces02_valor == null ){
       $this->erro_sql = " Campo Valor não informado.";
       $this->erro_campo = "ces02_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->ces02_anousu == null ){
       $this->erro_sql = " Campo ces02_anousu não informado.";
       $this->erro_campo = "ces02_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ces02_inst == null ){
       $this->erro_sql = " Campo ces02_inst não informado.";
       $this->erro_campo = "ces02_inst";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($ces02_sequencial == "" || $ces02_sequencial == null ){
       $result = db_query("select nextval('conctbsaldo_ces02_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: conctbsaldo_ces02_sequencial_seq do campo: ces02_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->ces02_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from conctbsaldo_ces02_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $ces02_sequencial)){
         $this->erro_sql = " Campo ces02_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ces02_sequencial = $ces02_sequencial;
       }
     }
     if(($this->ces02_sequencial == null) || ($this->ces02_sequencial == "") ){
       $this->erro_sql = " Campo ces02_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into conctbsaldo(
                                       ces02_sequencial
                                      ,ces02_codcon
                                      ,ces02_reduz
                                      ,ces02_fonte
                                      ,ces02_valor
                                      ,ces02_anousu
                                      ,ces02_inst
                       )
                values (
                                $this->ces02_sequencial
                               ,$this->ces02_codcon
                               ,$this->ces02_reduz
                               ,$this->ces02_fonte
                               ,$this->ces02_valor
                               ,$this->ces02_anousu
                               ,$this->ces02_inst
                      )";

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "conCtbSaldo ($this->ces02_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "conCtbSaldo já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "conCtbSaldo ($this->ces02_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ces02_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->ces02_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009331,'$this->ces02_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010200,1009331,'','".AddSlashes(pg_result($resaco,0,'ces02_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009337,'','".AddSlashes(pg_result($resaco,0,'ces02_codcon'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009332,'','".AddSlashes(pg_result($resaco,0,'ces02_reduz'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009333,'','".AddSlashes(pg_result($resaco,0,'ces02_fonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009334,'','".AddSlashes(pg_result($resaco,0,'ces02_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009335,'','".AddSlashes(pg_result($resaco,0,'ces02_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010200,1009336,'','".AddSlashes(pg_result($resaco,0,'ces02_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }*/
     return true;
   }
   // funcao para alteracao
   function alterar ($ces02_sequencial=null) {
      $this->atualizacampos();
     $sql = " update conctbsaldo set ";
     $virgula = "";
     if(trim($this->ces02_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ces02_sequencial"])){
       $sql  .= $virgula." ces02_sequencial = $this->ces02_sequencial ";
       $virgula = ",";
       if(trim($this->ces02_sequencial) == null ){
         $this->erro_sql = " Campo ces02_sequencial não informado.";
         $this->erro_campo = "ces02_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ces02_codcon)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ces02_codcon"])){
       $sql  .= $virgula." ces02_codcon = $this->ces02_codcon ";
       $virgula = ",";
       if(trim($this->ces02_codcon) == null ){
         $this->erro_sql = " Campo Plano de contas não informado.";
         $this->erro_campo = "ces02_codcon";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ces02_reduz)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ces02_reduz"])){
       $sql  .= $virgula." ces02_reduz = $this->ces02_reduz ";
       $virgula = ",";
       if(trim($this->ces02_reduz) == null ){
         $this->erro_sql = " Campo Reduzido não informado.";
         $this->erro_campo = "ces02_reduz";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ces02_fonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ces02_fonte"])){
       $sql  .= $virgula." ces02_fonte = $this->ces02_fonte ";
       $virgula = ",";
       if(trim($this->ces02_fonte) == null ){
         $this->erro_sql = " Campo Fonte não informado.";
         $this->erro_campo = "ces02_fonte";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ces02_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ces02_valor"])){
       $sql  .= $virgula." ces02_valor = $this->ces02_valor ";
       $virgula = ",";
       if(trim($this->ces02_valor) == null ){
         $this->erro_sql = " Campo Valor não informado.";
         $this->erro_campo = "ces02_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ces02_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ces02_anousu"])){
       $sql  .= $virgula." ces02_anousu = $this->ces02_anousu ";
       $virgula = ",";
       if(trim($this->ces02_anousu) == null ){
         $this->erro_sql = " Campo ces02_anousu não informado.";
         $this->erro_campo = "ces02_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ces02_inst)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ces02_inst"])){
       $sql  .= $virgula." ces02_inst = $this->ces02_inst ";
       $virgula = ",";
       if(trim($this->ces02_inst) == null ){
         $this->erro_sql = " Campo ces02_inst não informado.";
         $this->erro_campo = "ces02_inst";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($ces02_sequencial!=null){
       $sql .= " ces02_sequencial = $this->ces02_sequencial";
     }
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->ces02_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009331,'$this->ces02_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ces02_sequencial"]) || $this->ces02_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009331,'".AddSlashes(pg_result($resaco,$conresaco,'ces02_sequencial'))."','$this->ces02_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ces02_codcon"]) || $this->ces02_codcon != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009337,'".AddSlashes(pg_result($resaco,$conresaco,'ces02_codcon'))."','$this->ces02_codcon',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ces02_reduz"]) || $this->ces02_reduz != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009332,'".AddSlashes(pg_result($resaco,$conresaco,'ces02_reduz'))."','$this->ces02_reduz',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ces02_fonte"]) || $this->ces02_fonte != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009333,'".AddSlashes(pg_result($resaco,$conresaco,'ces02_fonte'))."','$this->ces02_fonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ces02_valor"]) || $this->ces02_valor != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009334,'".AddSlashes(pg_result($resaco,$conresaco,'ces02_valor'))."','$this->ces02_valor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ces02_anousu"]) || $this->ces02_anousu != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009335,'".AddSlashes(pg_result($resaco,$conresaco,'ces02_anousu'))."','$this->ces02_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ces02_inst"]) || $this->ces02_inst != "")
             $resac = db_query("insert into db_acount values($acount,1010200,1009336,'".AddSlashes(pg_result($resaco,$conresaco,'ces02_inst'))."','$this->ces02_inst',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "conCtbSaldo nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->ces02_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "conCtbSaldo nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->ces02_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ces02_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($ces02_sequencial=null,$dbwhere=null) {

     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($ces02_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009331,'$ces02_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009331,'','".AddSlashes(pg_result($resaco,$iresaco,'ces02_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009337,'','".AddSlashes(pg_result($resaco,$iresaco,'ces02_codcon'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009332,'','".AddSlashes(pg_result($resaco,$iresaco,'ces02_reduz'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009333,'','".AddSlashes(pg_result($resaco,$iresaco,'ces02_fonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009334,'','".AddSlashes(pg_result($resaco,$iresaco,'ces02_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009335,'','".AddSlashes(pg_result($resaco,$iresaco,'ces02_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010200,1009336,'','".AddSlashes(pg_result($resaco,$iresaco,'ces02_inst'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from conctbsaldo
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($ces02_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " ces02_sequencial = $ces02_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "conCtbSaldo nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$ces02_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "conCtbSaldo nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$ces02_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$ces02_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:conctbsaldo";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $ces02_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from conctbsaldo ";
     $sql .= "      inner join conplano  on  conplano.c60_codcon = conctbsaldo.ces02_codcon";
     $sql .= "      inner join conclass  on  conclass.c51_codcla = conplano.c60_codcla";
     $sql .= "      inner join consistema  on  consistema.c52_codsis = conplano.c60_codsis";
     $sql .= "      inner join consistemaconta  on  consistemaconta.c65_sequencial = conplano.c60_consistemaconta";
     $sql2 = "";
     if($dbwhere==""){
       if($ces02_sequencial!=null ){
         $sql2 .= " where conctbsaldo.ces02_sequencial = $ces02_sequencial ";
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
   function sql_query_file ( $ces02_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from conctbsaldo ";
     $sql2 = "";
     if($dbwhere==""){
       if($ces02_sequencial!=null ){
         $sql2 .= " where conctbsaldo.ces02_sequencial = $ces02_sequencial ";
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
