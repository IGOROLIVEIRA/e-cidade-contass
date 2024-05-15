<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete182015
class cl_balancete182015 { 
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
   var $si185_sequencial = 0; 
   var $si185_tiporegistro = 0; 
   var $si185_contacontabil = 0; 
   var $si185_codfontrecursos = 0; 
   var $si185_saldoinicialfr = 0; 
   var $si185_naturezasaldoinicialfr = null; 
   var $si185_totaldebitosfr = 0; 
   var $si185_totalcreditosfr = 0; 
   var $si185_saldofinalfr = 0; 
   var $si185_naturezasaldofinalfr = null; 
   var $si185_mes = 0; 
   var $si185_instit = 0; 
   var $si185_reg10 = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si185_sequencial = int8 = si185_sequencial 
                 si185_tiporegistro = int8 = si185_tiporegistro 
                 si185_contacontabil = int8 = si185_contacontabil 
                 si185_codfontrecursos = int8 = si185_codfontrecursos 
                 si185_saldoinicialfr = float8 = si185_saldoinicialfr 
                 si185_naturezasaldoinicialfr = varchar(1) = si185_naturezasaldoinicialfr 
                 si185_totaldebitosfr = float8 = si185_totaldebitosfr 
                 si185_totalcreditosfr = float8 = si185_totalcreditosfr 
                 si185_saldofinalfr = float8 = si185_saldofinalfr 
                 si185_naturezasaldofinalfr = varchar(1) = si185_naturezasaldofinalfr 
                 si185_mes = int8 = si185_mes 
                 si185_instit = int8 = si185_instit 
                 ";
   //funcao construtor da classe 
   function cl_balancete182015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("balancete182015"); 
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
       $this->si185_sequencial = ($this->si185_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_sequencial"]:$this->si185_sequencial);
       $this->si185_tiporegistro = ($this->si185_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_tiporegistro"]:$this->si185_tiporegistro);
       $this->si185_contacontabil = ($this->si185_contacontabil == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_contacontabil"]:$this->si185_contacontabil);
       $this->si185_codfontrecursos = ($this->si185_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_codfontrecursos"]:$this->si185_codfontrecursos);
       $this->si185_saldoinicialfr = ($this->si185_saldoinicialfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_saldoinicialfr"]:$this->si185_saldoinicialfr);
       $this->si185_naturezasaldoinicialfr = ($this->si185_naturezasaldoinicialfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_naturezasaldoinicialfr"]:$this->si185_naturezasaldoinicialfr);
       $this->si185_totaldebitosfr = ($this->si185_totaldebitosfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_totaldebitosfr"]:$this->si185_totaldebitosfr);
       $this->si185_totalcreditosfr = ($this->si185_totalcreditosfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_totalcreditosfr"]:$this->si185_totalcreditosfr);
       $this->si185_saldofinalfr = ($this->si185_saldofinalfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_saldofinalfr"]:$this->si185_saldofinalfr);
       $this->si185_naturezasaldofinalfr = ($this->si185_naturezasaldofinalfr == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_naturezasaldofinalfr"]:$this->si185_naturezasaldofinalfr);
       $this->si185_mes = ($this->si185_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_mes"]:$this->si185_mes);
       $this->si185_instit = ($this->si185_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_instit"]:$this->si185_instit);
     }else{
       $this->si185_sequencial = ($this->si185_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si185_sequencial"]:$this->si185_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si185_sequencial){ 
      $this->atualizacampos();
     if($this->si185_tiporegistro == null ){ 
       $this->erro_sql = " Campo si185_tiporegistro não informado.";
       $this->erro_campo = "si185_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_contacontabil == null ){ 
       $this->erro_sql = " Campo si185_contacontabil não informado.";
       $this->erro_campo = "si185_contacontabil";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_codfontrecursos == null ){ 
       $this->erro_sql = " Campo si185_codfontrecursos não informado.";
       $this->erro_campo = "si185_codfontrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_saldoinicialfr == null ){ 
       $this->erro_sql = " Campo si185_saldoinicialfr não informado.";
       $this->erro_campo = "si185_saldoinicialfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_naturezasaldoinicialfr == null ){ 
       $this->erro_sql = " Campo si185_naturezasaldoinicialfr não informado.";
       $this->erro_campo = "si185_naturezasaldoinicialfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_totaldebitosfr == null ){ 
       $this->erro_sql = " Campo si185_totaldebitosfr não informado.";
       $this->erro_campo = "si185_totaldebitosfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_totalcreditosfr == null ){ 
       $this->erro_sql = " Campo si185_totalcreditosfr não informado.";
       $this->erro_campo = "si185_totalcreditosfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_saldofinalfr == null ){ 
       $this->erro_sql = " Campo si185_saldofinalfr não informado.";
       $this->erro_campo = "si185_saldofinalfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_naturezasaldofinalfr == null ){ 
       $this->erro_sql = " Campo si185_naturezasaldofinalfr não informado.";
       $this->erro_campo = "si185_naturezasaldofinalfr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_mes == null ){ 
       $this->erro_sql = " Campo si185_mes não informado.";
       $this->erro_campo = "si185_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si185_instit == null ){ 
       $this->erro_sql = " Campo si185_instit não informado.";
       $this->erro_campo = "si185_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si185_sequencial == "" || $si185_sequencial == null ){
       $result = db_query("select nextval('balancete182015_si185_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: balancete182015_si185_sequencial_seq do campo: si185_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si185_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from balancete182015_si185_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si185_sequencial)){
         $this->erro_sql = " Campo si185_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si185_sequencial = $si185_sequencial;
       }
     } 
     if(($this->si185_sequencial == null) || ($this->si185_sequencial == "") ){ 
       $this->erro_sql = " Campo si185_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into balancete182015(
                                       si185_sequencial 
                                      ,si185_tiporegistro 
                                      ,si185_contacontabil 
                                      ,si185_codfontrecursos 
                                      ,si185_saldoinicialfr 
                                      ,si185_naturezasaldoinicialfr 
                                      ,si185_totaldebitosfr 
                                      ,si185_totalcreditosfr 
                                      ,si185_saldofinalfr 
                                      ,si185_naturezasaldofinalfr 
                                      ,si185_mes 
                                      ,si185_instit
                                      ,si185_reg10
                       )
                values (
                                $this->si185_sequencial 
                               ,$this->si185_tiporegistro 
                               ,$this->si185_contacontabil 
                               ,$this->si185_codfontrecursos 
                               ,$this->si185_saldoinicialfr 
                               ,'$this->si185_naturezasaldoinicialfr' 
                               ,$this->si185_totaldebitosfr 
                               ,$this->si185_totalcreditosfr 
                               ,$this->si185_saldofinalfr 
                               ,'$this->si185_naturezasaldofinalfr' 
                               ,$this->si185_mes 
                               ,$this->si185_instit
                               ,$this->si185_reg10
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "balancete182015 ($this->si185_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "balancete182015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "balancete182015 ($this->si185_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si185_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si185_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011823,'$this->si185_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010202,2011823,'','".AddSlashes(pg_result($resaco,0,'si185_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011824,'','".AddSlashes(pg_result($resaco,0,'si185_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011825,'','".AddSlashes(pg_result($resaco,0,'si185_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011826,'','".AddSlashes(pg_result($resaco,0,'si185_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011827,'','".AddSlashes(pg_result($resaco,0,'si185_saldoinicialfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011828,'','".AddSlashes(pg_result($resaco,0,'si185_naturezasaldoinicialfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011829,'','".AddSlashes(pg_result($resaco,0,'si185_totaldebitosfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011830,'','".AddSlashes(pg_result($resaco,0,'si185_totalcreditosfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011831,'','".AddSlashes(pg_result($resaco,0,'si185_saldofinalfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011832,'','".AddSlashes(pg_result($resaco,0,'si185_naturezasaldofinalfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011833,'','".AddSlashes(pg_result($resaco,0,'si185_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2011834,'','".AddSlashes(pg_result($resaco,0,'si185_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si185_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update balancete182015 set ";
     $virgula = "";
     if(trim($this->si185_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_sequencial"])){ 
       $sql  .= $virgula." si185_sequencial = $this->si185_sequencial ";
       $virgula = ",";
       if(trim($this->si185_sequencial) == null ){ 
         $this->erro_sql = " Campo si185_sequencial não informado.";
         $this->erro_campo = "si185_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_tiporegistro"])){ 
       $sql  .= $virgula." si185_tiporegistro = $this->si185_tiporegistro ";
       $virgula = ",";
       if(trim($this->si185_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si185_tiporegistro não informado.";
         $this->erro_campo = "si185_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_contacontabil)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_contacontabil"])){ 
       $sql  .= $virgula." si185_contacontabil = $this->si185_contacontabil ";
       $virgula = ",";
       if(trim($this->si185_contacontabil) == null ){ 
         $this->erro_sql = " Campo si185_contacontabil não informado.";
         $this->erro_campo = "si185_contacontabil";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_codfontrecursos"])){ 
       $sql  .= $virgula." si185_codfontrecursos = $this->si185_codfontrecursos ";
       $virgula = ",";
       if(trim($this->si185_codfontrecursos) == null ){ 
         $this->erro_sql = " Campo si185_codfontrecursos não informado.";
         $this->erro_campo = "si185_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_saldoinicialfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_saldoinicialfr"])){ 
       $sql  .= $virgula." si185_saldoinicialfr = $this->si185_saldoinicialfr ";
       $virgula = ",";
       if(trim($this->si185_saldoinicialfr) == null ){ 
         $this->erro_sql = " Campo si185_saldoinicialfr não informado.";
         $this->erro_campo = "si185_saldoinicialfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_naturezasaldoinicialfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_naturezasaldoinicialfr"])){ 
       $sql  .= $virgula." si185_naturezasaldoinicialfr = '$this->si185_naturezasaldoinicialfr' ";
       $virgula = ",";
       if(trim($this->si185_naturezasaldoinicialfr) == null ){ 
         $this->erro_sql = " Campo si185_naturezasaldoinicialfr não informado.";
         $this->erro_campo = "si185_naturezasaldoinicialfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_totaldebitosfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_totaldebitosfr"])){ 
       $sql  .= $virgula." si185_totaldebitosfr = $this->si185_totaldebitosfr ";
       $virgula = ",";
       if(trim($this->si185_totaldebitosfr) == null ){ 
         $this->erro_sql = " Campo si185_totaldebitosfr não informado.";
         $this->erro_campo = "si185_totaldebitosfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_totalcreditosfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_totalcreditosfr"])){ 
       $sql  .= $virgula." si185_totalcreditosfr = $this->si185_totalcreditosfr ";
       $virgula = ",";
       if(trim($this->si185_totalcreditosfr) == null ){ 
         $this->erro_sql = " Campo si185_totalcreditosfr não informado.";
         $this->erro_campo = "si185_totalcreditosfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_saldofinalfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_saldofinalfr"])){ 
       $sql  .= $virgula." si185_saldofinalfr = $this->si185_saldofinalfr ";
       $virgula = ",";
       if(trim($this->si185_saldofinalfr) == null ){ 
         $this->erro_sql = " Campo si185_saldofinalfr não informado.";
         $this->erro_campo = "si185_saldofinalfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_naturezasaldofinalfr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_naturezasaldofinalfr"])){ 
       $sql  .= $virgula." si185_naturezasaldofinalfr = '$this->si185_naturezasaldofinalfr' ";
       $virgula = ",";
       if(trim($this->si185_naturezasaldofinalfr) == null ){ 
         $this->erro_sql = " Campo si185_naturezasaldofinalfr não informado.";
         $this->erro_campo = "si185_naturezasaldofinalfr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_mes"])){ 
       $sql  .= $virgula." si185_mes = $this->si185_mes ";
       $virgula = ",";
       if(trim($this->si185_mes) == null ){ 
         $this->erro_sql = " Campo si185_mes não informado.";
         $this->erro_campo = "si185_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si185_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si185_instit"])){ 
       $sql  .= $virgula." si185_instit = $this->si185_instit ";
       $virgula = ",";
       if(trim($this->si185_instit) == null ){ 
         $this->erro_sql = " Campo si185_instit não informado.";
         $this->erro_campo = "si185_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si185_sequencial!=null){
       $sql .= " si185_sequencial = $this->si185_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si185_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011823,'$this->si185_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_sequencial"]) || $this->si185_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011823,'".AddSlashes(pg_result($resaco,$conresaco,'si185_sequencial'))."','$this->si185_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_tiporegistro"]) || $this->si185_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011824,'".AddSlashes(pg_result($resaco,$conresaco,'si185_tiporegistro'))."','$this->si185_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_contacontabil"]) || $this->si185_contacontabil != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011825,'".AddSlashes(pg_result($resaco,$conresaco,'si185_contacontabil'))."','$this->si185_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_codfontrecursos"]) || $this->si185_codfontrecursos != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011826,'".AddSlashes(pg_result($resaco,$conresaco,'si185_codfontrecursos'))."','$this->si185_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_saldoinicialfr"]) || $this->si185_saldoinicialfr != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011827,'".AddSlashes(pg_result($resaco,$conresaco,'si185_saldoinicialfr'))."','$this->si185_saldoinicialfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_naturezasaldoinicialfr"]) || $this->si185_naturezasaldoinicialfr != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011828,'".AddSlashes(pg_result($resaco,$conresaco,'si185_naturezasaldoinicialfr'))."','$this->si185_naturezasaldoinicialfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_totaldebitosfr"]) || $this->si185_totaldebitosfr != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011829,'".AddSlashes(pg_result($resaco,$conresaco,'si185_totaldebitosfr'))."','$this->si185_totaldebitosfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_totalcreditosfr"]) || $this->si185_totalcreditosfr != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011830,'".AddSlashes(pg_result($resaco,$conresaco,'si185_totalcreditosfr'))."','$this->si185_totalcreditosfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_saldofinalfr"]) || $this->si185_saldofinalfr != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011831,'".AddSlashes(pg_result($resaco,$conresaco,'si185_saldofinalfr'))."','$this->si185_saldofinalfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_naturezasaldofinalfr"]) || $this->si185_naturezasaldofinalfr != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011832,'".AddSlashes(pg_result($resaco,$conresaco,'si185_naturezasaldofinalfr'))."','$this->si185_naturezasaldofinalfr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_mes"]) || $this->si185_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011833,'".AddSlashes(pg_result($resaco,$conresaco,'si185_mes'))."','$this->si185_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si185_instit"]) || $this->si185_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2011834,'".AddSlashes(pg_result($resaco,$conresaco,'si185_instit'))."','$this->si185_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "balancete182015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si185_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "balancete182015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si185_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si185_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si185_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si185_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011823,'$si185_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011823,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011824,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011825,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011826,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011827,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_saldoinicialfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011828,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_naturezasaldoinicialfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011829,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_totaldebitosfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011830,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_totalcreditosfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011831,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_saldofinalfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011832,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_naturezasaldofinalfr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011833,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2011834,'','".AddSlashes(pg_result($resaco,$iresaco,'si185_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
         }
       }
     }
     $sql = " delete from balancete182015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si185_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si185_sequencial = $si185_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "balancete182015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si185_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "balancete182015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si185_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si185_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:balancete182015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si185_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from balancete182015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si185_sequencial!=null ){
         $sql2 .= " where balancete182015.si185_sequencial = $si185_sequencial "; 
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
   function sql_query_file ( $si185_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from balancete182015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si185_sequencial!=null ){
         $sql2 .= " where balancete182015.si185_sequencial = $si185_sequencial "; 
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
