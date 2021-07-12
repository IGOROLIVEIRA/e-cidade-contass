<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete212019
class cl_balancete212019 { 
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
   var $si188_sequencial = 0; 
   var $si188_tiporegistro = 0; 
   var $si188_contacontabil = 0; 
   var $si188_codfundo = null;
   var $si188_cnpjconsorcio = 0;
   var $si188_codfontrecursos = 0; 
   var $si188_saldoinicialconsorfr = 0; 
   var $si188_naturezasaldoinicialconsorfr = null; 
   var $si188_totaldebitosconsorfr = 0; 
   var $si188_totalcreditosconsorfr = 0; 
   var $si188_saldofinalconsorfr = 0; 
   var $si188_naturezasaldofinalconsorfr = null; 
   var $si188_mes = 0; 
   var $si188_instit = 0;
   var $si188_reg10;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si188_sequencial = int8 = si188_sequencial 
                 si188_tiporegistro = int8 = si188_tiporegistro 
                 si188_contacontabil = int8 = si188_contacontabil 
                 si188_codfundo = varchar(8) = si188_codfundo 
                 si188_cnpjconsorcio = int8 = si188_cnpjconsorcio 
                 si188_codfontrecursos = int8 = si188_codfontrecursos 
                 si188_saldoinicialconsorfr = float8 = si188_saldoinicialconsorfr 
                 si188_naturezasaldoinicialconsorfr = varchar(1) = si188_naturezasaldoinicialconsorfr 
                 si188_totaldebitosconsorfr = float8 = si188_totaldebitosconsorfr 
                 si188_totalcreditosconsorfr = float8 = si188_totalcreditosconsorfr 
                 si188_saldofinalconsorfr = float8 = si188_saldofinalconsorfr 
                 si188_naturezasaldofinalconsorfr = varchar(1) = si188_naturezasaldofinalconsorfr 
                 si188_mes = int8 = si188_mes 
                 si188_instit = int8 = si188_instit 
                 ";
   //funcao construtor da classe 
   function cl_balancete212019() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("balancete212019"); 
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
       $this->si188_sequencial = ($this->si188_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_sequencial"]:$this->si188_sequencial);
       $this->si188_tiporegistro = ($this->si188_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_tiporegistro"]:$this->si188_tiporegistro);
       $this->si188_contacontabil = ($this->si188_contacontabil == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_contacontabil"]:$this->si188_contacontabil);
       $this->si188_codfundo = ($this->si188_codfundo == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_codfundo"]:$this->si188_codfundo);
       $this->si188_cnpjconsorcio = ($this->si188_cnpjconsorcio == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_cnpjconsorcio"]:$this->si188_cnpjconsorcio);
       $this->si188_codfontrecursos = ($this->si188_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_codfontrecursos"]:$this->si188_codfontrecursos);
       $this->si188_saldoinicialconsorfr = ($this->si188_saldoinicialconsorfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_saldoinicialconsorfr"]:$this->si188_saldoinicialconsorfr);
       $this->si188_naturezasaldoinicialconsorfr = ($this->si188_naturezasaldoinicialconsorfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_naturezasaldoinicialconsorfr"]:$this->si188_naturezasaldoinicialconsorfr);
       $this->si188_totaldebitosconsorfr = ($this->si188_totaldebitosconsorfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_totaldebitosconsorfr"]:$this->si188_totaldebitosconsorfr);
       $this->si188_totalcreditosconsorfr = ($this->si188_totalcreditosconsorfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_totalcreditosconsorfr"]:$this->si188_totalcreditosconsorfr);
       $this->si188_saldofinalconsorfr = ($this->si188_saldofinalconsorfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_saldofinalconsorfr"]:$this->si188_saldofinalconsorfr);
       $this->si188_naturezasaldofinalconsorfr = ($this->si188_naturezasaldofinalconsorfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_naturezasaldofinalconsorfr"]:$this->si188_naturezasaldofinalconsorfr);
       $this->si188_mes = ($this->si188_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_mes"]:$this->si188_mes);
       $this->si188_instit = ($this->si188_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_instit"]:$this->si188_instit);
     }else{
       $this->si188_sequencial = ($this->si188_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_sequencial"]:$this->si188_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si188_sequencial){ 
      $this->atualizacampos();
     if($this->si188_tiporegistro == null ){ 
       $this->erro_sql = " Campo si188_tiporegistro não informado.";
       $this->erro_campo = "si188_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_contacontabil == null ){ 
       $this->erro_sql = " Campo si188_contacontabil não informado.";
       $this->erro_campo = "si188_contacontabil";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_cnpjconsorcio == null ){ 
       $this->erro_sql = " Campo si188_cnpjconsorcio não informado.";
       $this->erro_campo = "si188_cnpjconsorcio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_codfontrecursos == null ){ 
       $this->erro_sql = " Campo si188_codfontrecursos não informado.";
       $this->erro_campo = "si188_codfontrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_saldoinicialconsorfr == null ){ 
       $this->erro_sql = " Campo si188_saldoinicialconsorfr não informado.";
       $this->erro_campo = "si188_saldoinicialconsorfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_naturezasaldoinicialconsorfr == null ){ 
       $this->erro_sql = " Campo si188_naturezasaldoinicialconsorfr não informado.";
       $this->erro_campo = "si188_naturezasaldoinicialconsorfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_totaldebitosconsorfr == null ){ 
       $this->erro_sql = " Campo si188_totaldebitosconsorfr não informado.";
       $this->erro_campo = "si188_totaldebitosconsorfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_totalcreditosconsorfr == null ){ 
       $this->erro_sql = " Campo si188_totalcreditosconsorfr não informado.";
       $this->erro_campo = "si188_totalcreditosconsorfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_saldofinalconsorfr == null ){ 
       $this->erro_sql = " Campo si188_saldofinalconsorfr não informado.";
       $this->erro_campo = "si188_saldofinalconsorfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_naturezasaldofinalconsorfr == null ){ 
       $this->erro_sql = " Campo si188_naturezasaldofinalconsorfr não informado.";
       $this->erro_campo = "si188_naturezasaldofinalconsorfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_mes == null ){ 
       $this->erro_sql = " Campo si188_mes não informado.";
       $this->erro_campo = "si188_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si188_instit == null ){ 
       $this->erro_sql = " Campo si188_instit não informado.";
       $this->erro_campo = "si188_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si188_sequencial = $si188_sequencial; 
     if(($this->si188_sequencial == null) || ($this->si188_sequencial == "") ){ 
       $this->erro_sql = " Campo si188_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into balancete212019(
                                       si188_sequencial 
                                      ,si188_tiporegistro 
                                      ,si188_contacontabil 
                                      ,si188_codfundo 
                                      ,si188_cnpjconsorcio 
                                      ,si188_codfontrecursos 
                                      ,si188_saldoinicialconsorfr 
                                      ,si188_naturezasaldoinicialconsorfr 
                                      ,si188_totaldebitosconsorfr 
                                      ,si188_totalcreditosconsorfr 
                                      ,si188_saldofinalconsorfr 
                                      ,si188_naturezasaldofinalconsorfr 
                                      ,si188_mes 
                                      ,si188_instit
                                      ,si188_reg10
                       )
                values (
                                $this->si188_sequencial 
                               ,$this->si188_tiporegistro 
                               ,$this->si188_contacontabil 
                               ,'$this->si188_codfundo' 
                               ,$this->si188_cnpjconsorcio 
                               ,$this->si188_codfontrecursos 
                               ,$this->si188_saldoinicialconsorfr 
                               ,'$this->si188_naturezasaldoinicialconsorfr' 
                               ,$this->si188_totaldebitosconsorfr 
                               ,$this->si188_totalcreditosconsorfr 
                               ,$this->si188_saldofinalconsorfr 
                               ,'$this->si188_naturezasaldofinalconsorfr' 
                               ,$this->si188_mes 
                               ,$this->si188_instit
                               ,$this->si188_reg10
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "balancete212019 ($this->si188_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "balancete212019 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "balancete212019 ($this->si188_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si188_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si188_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011865,'$this->si188_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010205,2011865,'','".AddSlashes(pg_result($resaco,0,'si188_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011866,'','".AddSlashes(pg_result($resaco,0,'si188_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011867,'','".AddSlashes(pg_result($resaco,0,'si188_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011868,'','".AddSlashes(pg_result($resaco,0,'si188_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011869,'','".AddSlashes(pg_result($resaco,0,'si188_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011870,'','".AddSlashes(pg_result($resaco,0,'si188_saldoinicialconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011871,'','".AddSlashes(pg_result($resaco,0,'si188_naturezasaldoinicialconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011872,'','".AddSlashes(pg_result($resaco,0,'si188_totaldebitosconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011873,'','".AddSlashes(pg_result($resaco,0,'si188_totalcreditosconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011874,'','".AddSlashes(pg_result($resaco,0,'si188_saldofinalconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011875,'','".AddSlashes(pg_result($resaco,0,'si188_naturezasaldofinalconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011876,'','".AddSlashes(pg_result($resaco,0,'si188_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010205,2011877,'','".AddSlashes(pg_result($resaco,0,'si188_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si188_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update balancete212019 set ";
     $virgula = "";
     if(trim($this->si188_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_sequencial"])){ 
       $sql  .= $virgula." si188_sequencial = $this->si188_sequencial ";
       $virgula = ",";
       if(trim($this->si188_sequencial) == null ){ 
         $this->erro_sql = " Campo si188_sequencial não informado.";
         $this->erro_campo = "si188_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_tiporegistro"])){ 
       $sql  .= $virgula." si188_tiporegistro = $this->si188_tiporegistro ";
       $virgula = ",";
       if(trim($this->si188_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si188_tiporegistro não informado.";
         $this->erro_campo = "si188_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_contacontabil)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_contacontabil"])){ 
       $sql  .= $virgula." si188_contacontabil = $this->si188_contacontabil ";
       $virgula = ",";
       if(trim($this->si188_contacontabil) == null ){ 
         $this->erro_sql = " Campo si188_contacontabil não informado.";
         $this->erro_campo = "si188_contacontabil";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_codfundo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_codfundo"])){
       $sql  .= $virgula." si188_codfundo = '$this->si188_codfundo' ";
       $virgula = ",";
       if(trim($this->si188_codfundo) == null ){
         $this->erro_sql = " Campo si188_codfundo não informado.";
         $this->erro_campo = "si188_codfundo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_cnpjconsorcio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_cnpjconsorcio"])){
       $sql  .= $virgula." si188_cnpjconsorcio = $this->si188_cnpjconsorcio ";
       $virgula = ",";
       if(trim($this->si188_cnpjconsorcio) == null ){ 
         $this->erro_sql = " Campo si188_cnpjconsorcio não informado.";
         $this->erro_campo = "si188_cnpjconsorcio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_codfontrecursos"])){ 
       $sql  .= $virgula." si188_codfontrecursos = $this->si188_codfontrecursos ";
       $virgula = ",";
       if(trim($this->si188_codfontrecursos) == null ){ 
         $this->erro_sql = " Campo si188_codfontrecursos não informado.";
         $this->erro_campo = "si188_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_saldoinicialconsorfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_saldoinicialconsorfr"])){ 
       $sql  .= $virgula." si188_saldoinicialconsorfr = $this->si188_saldoinicialconsorfr ";
       $virgula = ",";
       if(trim($this->si188_saldoinicialconsorfr) == null ){ 
         $this->erro_sql = " Campo si188_saldoinicialconsorfr não informado.";
         $this->erro_campo = "si188_saldoinicialconsorfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_naturezasaldoinicialconsorfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_naturezasaldoinicialconsorfr"])){ 
       $sql  .= $virgula." si188_naturezasaldoinicialconsorfr = '$this->si188_naturezasaldoinicialconsorfr' ";
       $virgula = ",";
       if(trim($this->si188_naturezasaldoinicialconsorfr) == null ){ 
         $this->erro_sql = " Campo si188_naturezasaldoinicialconsorfr não informado.";
         $this->erro_campo = "si188_naturezasaldoinicialconsorfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_totaldebitosconsorfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_totaldebitosconsorfr"])){ 
       $sql  .= $virgula." si188_totaldebitosconsorfr = $this->si188_totaldebitosconsorfr ";
       $virgula = ",";
       if(trim($this->si188_totaldebitosconsorfr) == null ){ 
         $this->erro_sql = " Campo si188_totaldebitosconsorfr não informado.";
         $this->erro_campo = "si188_totaldebitosconsorfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_totalcreditosconsorfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_totalcreditosconsorfr"])){ 
       $sql  .= $virgula." si188_totalcreditosconsorfr = $this->si188_totalcreditosconsorfr ";
       $virgula = ",";
       if(trim($this->si188_totalcreditosconsorfr) == null ){ 
         $this->erro_sql = " Campo si188_totalcreditosconsorfr não informado.";
         $this->erro_campo = "si188_totalcreditosconsorfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_saldofinalconsorfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_saldofinalconsorfr"])){ 
       $sql  .= $virgula." si188_saldofinalconsorfr = $this->si188_saldofinalconsorfr ";
       $virgula = ",";
       if(trim($this->si188_saldofinalconsorfr) == null ){ 
         $this->erro_sql = " Campo si188_saldofinalconsorfr não informado.";
         $this->erro_campo = "si188_saldofinalconsorfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_naturezasaldofinalconsorfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_naturezasaldofinalconsorfr"])){ 
       $sql  .= $virgula." si188_naturezasaldofinalconsorfr = '$this->si188_naturezasaldofinalconsorfr' ";
       $virgula = ",";
       if(trim($this->si188_naturezasaldofinalconsorfr) == null ){ 
         $this->erro_sql = " Campo si188_naturezasaldofinalconsorfr não informado.";
         $this->erro_campo = "si188_naturezasaldofinalconsorfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_mes"])){ 
       $sql  .= $virgula." si188_mes = $this->si188_mes ";
       $virgula = ",";
       if(trim($this->si188_mes) == null ){ 
         $this->erro_sql = " Campo si188_mes não informado.";
         $this->erro_campo = "si188_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si188_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_instit"])){ 
       $sql  .= $virgula." si188_instit = $this->si188_instit ";
       $virgula = ",";
       if(trim($this->si188_instit) == null ){ 
         $this->erro_sql = " Campo si188_instit não informado.";
         $this->erro_campo = "si188_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si188_sequencial!=null){
       $sql .= " si188_sequencial = $this->si188_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si188_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011865,'$this->si188_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_sequencial"]) || $this->si188_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011865,'".AddSlashes(pg_result($resaco,$conresaco,'si188_sequencial'))."','$this->si188_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_tiporegistro"]) || $this->si188_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011866,'".AddSlashes(pg_result($resaco,$conresaco,'si188_tiporegistro'))."','$this->si188_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_contacontabil"]) || $this->si188_contacontabil != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011867,'".AddSlashes(pg_result($resaco,$conresaco,'si188_contacontabil'))."','$this->si188_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_cnpjconsorcio"]) || $this->si188_cnpjconsorcio != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011868,'".AddSlashes(pg_result($resaco,$conresaco,'si188_cnpjconsorcio'))."','$this->si188_cnpjconsorcio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_codfontrecursos"]) || $this->si188_codfontrecursos != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011869,'".AddSlashes(pg_result($resaco,$conresaco,'si188_codfontrecursos'))."','$this->si188_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_saldoinicialconsorfr"]) || $this->si188_saldoinicialconsorfr != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011870,'".AddSlashes(pg_result($resaco,$conresaco,'si188_saldoinicialconsorfr'))."','$this->si188_saldoinicialconsorfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_naturezasaldoinicialconsorfr"]) || $this->si188_naturezasaldoinicialconsorfr != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011871,'".AddSlashes(pg_result($resaco,$conresaco,'si188_naturezasaldoinicialconsorfr'))."','$this->si188_naturezasaldoinicialconsorfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_totaldebitosconsorfr"]) || $this->si188_totaldebitosconsorfr != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011872,'".AddSlashes(pg_result($resaco,$conresaco,'si188_totaldebitosconsorfr'))."','$this->si188_totaldebitosconsorfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_totalcreditosconsorfr"]) || $this->si188_totalcreditosconsorfr != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011873,'".AddSlashes(pg_result($resaco,$conresaco,'si188_totalcreditosconsorfr'))."','$this->si188_totalcreditosconsorfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_saldofinalconsorfr"]) || $this->si188_saldofinalconsorfr != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011874,'".AddSlashes(pg_result($resaco,$conresaco,'si188_saldofinalconsorfr'))."','$this->si188_saldofinalconsorfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_naturezasaldofinalconsorfr"]) || $this->si188_naturezasaldofinalconsorfr != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011875,'".AddSlashes(pg_result($resaco,$conresaco,'si188_naturezasaldofinalconsorfr'))."','$this->si188_naturezasaldofinalconsorfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_mes"]) || $this->si188_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011876,'".AddSlashes(pg_result($resaco,$conresaco,'si188_mes'))."','$this->si188_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si188_instit"]) || $this->si188_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010205,2011877,'".AddSlashes(pg_result($resaco,$conresaco,'si188_instit'))."','$this->si188_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "balancete212019 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si188_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "balancete212019 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si188_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si188_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si188_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si188_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011865,'$si188_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011865,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011866,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011867,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011868,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011869,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011870,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_saldoinicialconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011871,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_naturezasaldoinicialconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011872,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_totaldebitosconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011873,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_totalcreditosconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011874,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_saldofinalconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011875,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_naturezasaldofinalconsorfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011876,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010205,2011877,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
         }
       }
     }
     $sql = " delete from balancete212019
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si188_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si188_sequencial = $si188_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "balancete212019 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si188_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "balancete212019 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si188_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si188_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:balancete212019";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si188_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from balancete212019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si188_sequencial!=null ){
         $sql2 .= " where balancete212019.si188_sequencial = $si188_sequencial "; 
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
   function sql_query_file ( $si188_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from balancete212019 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si188_sequencial!=null ){
         $sql2 .= " where balancete212019.si188_sequencial = $si188_sequencial "; 
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
