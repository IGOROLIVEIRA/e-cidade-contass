<?
//MODULO: sicom
//CLASSE DA ENTIDADE dclrf302017
class cl_dclrf302017 {
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
   var $si178_sequencial = 0;
   var $si178_tiporegistro = 0;
   var $si178_publiclrf = 0;
   var $si178_dtpublicacaorelatoriolrf_dia = null;
   var $si178_dtpublicacaorelatoriolrf_mes = null;
   var $si178_dtpublicacaorelatoriolrf_ano = null;
   var $si178_dtpublicacaorelatoriolrf = null;
   var $si178_localpublicacao = null;
   var $si178_tpbimestre = 0;
   var $si178_mes = 0;
   var $si178_instit = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si178_sequencial = int8 = Sequencial
                 si178_tiporegistro = int4 = Tipo Registro
                 si178_publiclrf = int4 = Publicar relatório LRF
                 si178_dtpublicacaorelatoriolrf = date = Data publicação de relatórios
                 si178_localpublicacao = varchar(1000) = Onde foi dada a publicidade do RGF/RREO
                 si178_tpbimestre = int4 = Periodo data de publicação da LRF
                 si178_mes = int8 = Mês
                 si178_instit = int8 = Instituição
                 ";
   //funcao construtor da classe
   function cl_dclrf302017() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dclrf302017");
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
       $this->si178_sequencial = ($this->si178_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_sequencial"]:$this->si178_sequencial);
       $this->si178_tiporegistro = ($this->si178_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_tiporegistro"]:$this->si178_tiporegistro);
       $this->si178_publiclrf = ($this->si178_publiclrf == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_publiclrf"]:$this->si178_publiclrf);
       if($this->si178_dtpublicacaorelatoriolrf == ""){
         $this->si178_dtpublicacaorelatoriolrf_dia = ($this->si178_dtpublicacaorelatoriolrf_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_dtpublicacaorelatoriolrf_dia"]:$this->si178_dtpublicacaorelatoriolrf_dia);
         $this->si178_dtpublicacaorelatoriolrf_mes = ($this->si178_dtpublicacaorelatoriolrf_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_dtpublicacaorelatoriolrf_mes"]:$this->si178_dtpublicacaorelatoriolrf_mes);
         $this->si178_dtpublicacaorelatoriolrf_ano = ($this->si178_dtpublicacaorelatoriolrf_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_dtpublicacaorelatoriolrf_ano"]:$this->si178_dtpublicacaorelatoriolrf_ano);
         if($this->si178_dtpublicacaorelatoriolrf_dia != ""){
            $this->si178_dtpublicacaorelatoriolrf = $this->si178_dtpublicacaorelatoriolrf_ano."-".$this->si178_dtpublicacaorelatoriolrf_mes."-".$this->si178_dtpublicacaorelatoriolrf_dia;
         }
       }
       $this->si178_localpublicacao = ($this->si178_localpublicacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_localpublicacao"]:$this->si178_localpublicacao);
       $this->si178_tpbimestre = ($this->si178_tpbimestre == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_tpbimestre"]:$this->si178_tpbimestre);
       $this->si178_mes = ($this->si178_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_mes"]:$this->si178_mes);
       $this->si178_instit = ($this->si178_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_instit"]:$this->si178_instit);
     }else{
       $this->si178_sequencial = ($this->si178_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si178_sequencial"]:$this->si178_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si178_sequencial){
      $this->atualizacampos();
     if($this->si178_tiporegistro == null ){
       $this->erro_sql = " Campo Tipo Registro não informado.";
       $this->erro_campo = "si178_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si178_publiclrf == null ){
       $this->erro_sql = " Campo Publicar relatório LRF não informado.";
       $this->erro_campo = "si178_publiclrf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si178_dtpublicacaorelatoriolrf == null ){
       $this->erro_sql = " Campo Data publicação de relatórios não informado.";
       $this->erro_campo = "si178_dtpublicacaorelatoriolrf_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si178_localpublicacao == null ){
       $this->erro_sql = " Campo Onde foi dada a publicidade do RGF/RREO não informado.";
       $this->erro_campo = "si178_localpublicacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si178_tpbimestre == null ){
       $this->erro_sql = " Campo Periodo data de publicação da LRF não informado.";
       $this->erro_campo = "si178_tpbimestre";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si178_mes == null ){
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si178_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si178_instit == null ){
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si178_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si178_sequencial = $si178_sequencial;
     if(($this->si178_sequencial == null) || ($this->si178_sequencial == "") ){
       $this->erro_sql = " Campo si178_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dclrf302017(
                                       si178_sequencial
                                      ,si178_tiporegistro
                                      ,si178_publiclrf
                                      ,si178_dtpublicacaorelatoriolrf
                                      ,si178_localpublicacao
                                      ,si178_tpbimestre
                                      ,si178_mes
                                      ,si178_instit
                       )
                values (
                                $this->si178_sequencial
                               ,$this->si178_tiporegistro
                               ,$this->si178_publiclrf
                               ,".($this->si178_dtpublicacaorelatoriolrf == "null" || $this->si178_dtpublicacaorelatoriolrf == ""?"null":"'".$this->si178_dtpublicacaorelatoriolrf."'")."
                               ,'$this->si178_localpublicacao'
                               ,$this->si178_tpbimestre
                               ,$this->si178_mes
                               ,$this->si178_instit
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Cadastro DCLFR30 ($this->si178_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro DCLFR30 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Cadastro DCLFR30 ($this->si178_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si178_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si178_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,3000064,'$this->si178_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,2010419,3000064,'','".AddSlashes(pg_result($resaco,0,'si178_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010419,3000065,'','".AddSlashes(pg_result($resaco,0,'si178_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010419,3000066,'','".AddSlashes(pg_result($resaco,0,'si178_publiclrf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010419,3000067,'','".AddSlashes(pg_result($resaco,0,'si178_dtpublicacaorelatoriolrf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010419,3000068,'','".AddSlashes(pg_result($resaco,0,'si178_localpublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010419,3000069,'','".AddSlashes(pg_result($resaco,0,'si178_tpbimestre'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010419,3000070,'','".AddSlashes(pg_result($resaco,0,'si178_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010419,3000071,'','".AddSlashes(pg_result($resaco,0,'si178_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($si178_sequencial=null) {
      $this->atualizacampos();
     $sql = " update dclrf302017 set ";
     $virgula = "";
     if(trim($this->si178_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si178_sequencial"])){
       $sql  .= $virgula." si178_sequencial = $this->si178_sequencial ";
       $virgula = ",";
       if(trim($this->si178_sequencial) == null ){
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si178_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si178_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si178_tiporegistro"])){
       $sql  .= $virgula." si178_tiporegistro = $this->si178_tiporegistro ";
       $virgula = ",";
       if(trim($this->si178_tiporegistro) == null ){
         $this->erro_sql = " Campo Tipo Registro não informado.";
         $this->erro_campo = "si178_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si178_publiclrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si178_publiclrf"])){
       $sql  .= $virgula." si178_publiclrf = $this->si178_publiclrf ";
       $virgula = ",";
       if(trim($this->si178_publiclrf) == null ){
         $this->erro_sql = " Campo Publicar relatório LRF não informado.";
         $this->erro_campo = "si178_publiclrf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si178_dtpublicacaorelatoriolrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si178_dtpublicacaorelatoriolrf_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si178_dtpublicacaorelatoriolrf_dia"] !="") ){
       $sql  .= $virgula." si178_dtpublicacaorelatoriolrf = '$this->si178_dtpublicacaorelatoriolrf' ";
       $virgula = ",";
       if(trim($this->si178_dtpublicacaorelatoriolrf) == null ){
         $this->erro_sql = " Campo Data publicação de relatórios não informado.";
         $this->erro_campo = "si178_dtpublicacaorelatoriolrf_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si178_dtpublicacaorelatoriolrf_dia"])){
         $sql  .= $virgula." si178_dtpublicacaorelatoriolrf = null ";
         $virgula = ",";
         if(trim($this->si178_dtpublicacaorelatoriolrf) == null ){
           $this->erro_sql = " Campo Data publicação de relatórios não informado.";
           $this->erro_campo = "si178_dtpublicacaorelatoriolrf_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si178_localpublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si178_localpublicacao"])){
       $sql  .= $virgula." si178_localpublicacao = '$this->si178_localpublicacao' ";
       $virgula = ",";
       if(trim($this->si178_localpublicacao) == null ){
         $this->erro_sql = " Campo Onde foi dada a publicidade do RGF/RREO não informado.";
         $this->erro_campo = "si178_localpublicacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si178_tpbimestre)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si178_tpbimestre"])){
       $sql  .= $virgula." si178_tpbimestre = $this->si178_tpbimestre ";
       $virgula = ",";
       if(trim($this->si178_tpbimestre) == null ){
         $this->erro_sql = " Campo Periodo data de publicação da LRF não informado.";
         $this->erro_campo = "si178_tpbimestre";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si178_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si178_mes"])){
       $sql  .= $virgula." si178_mes = $this->si178_mes ";
       $virgula = ",";
       if(trim($this->si178_mes) == null ){
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si178_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si178_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si178_instit"])){
       $sql  .= $virgula." si178_instit = $this->si178_instit ";
       $virgula = ",";
       if(trim($this->si178_instit) == null ){
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si178_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si178_sequencial!=null){
       $sql .= " si178_sequencial = $this->si178_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si178_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,3000064,'$this->si178_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si178_sequencial"]) || $this->si178_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,2010419,3000064,'".AddSlashes(pg_result($resaco,$conresaco,'si178_sequencial'))."','$this->si178_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si178_tiporegistro"]) || $this->si178_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,2010419,3000065,'".AddSlashes(pg_result($resaco,$conresaco,'si178_tiporegistro'))."','$this->si178_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si178_publiclrf"]) || $this->si178_publiclrf != "")
             $resac = db_query("insert into db_acount values($acount,2010419,3000066,'".AddSlashes(pg_result($resaco,$conresaco,'si178_publiclrf'))."','$this->si178_publiclrf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si178_dtpublicacaorelatoriolrf"]) || $this->si178_dtpublicacaorelatoriolrf != "")
             $resac = db_query("insert into db_acount values($acount,2010419,3000067,'".AddSlashes(pg_result($resaco,$conresaco,'si178_dtpublicacaorelatoriolrf'))."','$this->si178_dtpublicacaorelatoriolrf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si178_localpublicacao"]) || $this->si178_localpublicacao != "")
             $resac = db_query("insert into db_acount values($acount,2010419,3000068,'".AddSlashes(pg_result($resaco,$conresaco,'si178_localpublicacao'))."','$this->si178_localpublicacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si178_tpbimestre"]) || $this->si178_tpbimestre != "")
             $resac = db_query("insert into db_acount values($acount,2010419,3000069,'".AddSlashes(pg_result($resaco,$conresaco,'si178_tpbimestre'))."','$this->si178_tpbimestre',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si178_mes"]) || $this->si178_mes != "")
             $resac = db_query("insert into db_acount values($acount,2010419,3000070,'".AddSlashes(pg_result($resaco,$conresaco,'si178_mes'))."','$this->si178_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si178_instit"]) || $this->si178_instit != "")
             $resac = db_query("insert into db_acount values($acount,2010419,3000071,'".AddSlashes(pg_result($resaco,$conresaco,'si178_instit'))."','$this->si178_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro DCLFR30 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si178_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro DCLFR30 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si178_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si178_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si178_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si178_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,3000064,'$si178_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,2010419,3000064,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2010419,3000065,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2010419,3000066,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_publiclrf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2010419,3000067,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_dtpublicacaorelatoriolrf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2010419,3000068,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_localpublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2010419,3000069,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_tpbimestre'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2010419,3000070,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2010419,3000071,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from dclrf302017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si178_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si178_sequencial = $si178_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro DCLFR30 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si178_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro DCLFR30 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si178_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si178_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dclrf302017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si178_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf302017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si178_sequencial!=null ){
         $sql2 .= " where dclrf302017.si178_sequencial = $si178_sequencial ";
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
   function sql_query_file ( $si178_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dclrf302017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si178_sequencial!=null ){
         $sql2 .= " where dclrf302017.si178_sequencial = $si178_sequencial ";
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
