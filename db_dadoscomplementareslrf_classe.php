<?
//MODULO: sicom
//CLASSE DA ENTIDADE dadoscomplementareslrf
class cl_dadoscomplementareslrf { 
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
   var $si170_sequencial = 0; 
   var $si170_vlsaldoatualconcgarantia = 0; 
   var $si170_recprivatizacao = 0; 
   var $si170_vlliqincentcontrib = 0; 
   var $si170_vlliqincentInstfinanc = 0; 
   var $si170_vlIrpnpincentcontrib = 0; 
   var $si170_vllrpnpincentinstfinanc = 0; 
   var $si170_vlcompromissado = 0; 
   var $si170_vlrecursosnaoaplicados = 0; 
   var $si170_mesreferencia = 0; 
   var $si170_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si170_sequencial = int8 = sequencial 
                 si170_vlsaldoatualconcgarantia = float8 = Saldo atual das concessões 
                 si170_recprivatizacao = float8 = Receita de  Privatização 
                 si170_vlliqincentcontrib = float8 = Valor Liquidado de Incentivo 
                 si170_vlliqincentInstfinanc = float8 = Valor concedido por Instituição 
                 si170_vlIrpnpincentcontrib = float8 = Valor Inscrito em RP Não Processados 
                 si170_vllrpnpincentinstfinanc = float8 = Valor Inscrito em RP Não Processados IF 
                 si170_vlcompromissado = float8 = Total dos valores compromissados 
                 si170_vlrecursosnaoaplicados = float8 = Recursos do FUNDEB não aplicados 
                 si170_mesreferencia = int8 = Mês de referência 
                 si170_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_dadoscomplementareslrf() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dadoscomplementareslrf"); 
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
       $this->si170_sequencial = ($this->si170_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_sequencial"]:$this->si170_sequencial);
       $this->si170_vlsaldoatualconcgarantia = ($this->si170_vlsaldoatualconcgarantia == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualconcgarantia"]:$this->si170_vlsaldoatualconcgarantia);
       $this->si170_recprivatizacao = ($this->si170_recprivatizacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_recprivatizacao"]:$this->si170_recprivatizacao);
       $this->si170_vlliqincentcontrib = ($this->si170_vlliqincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentcontrib"]:$this->si170_vlliqincentcontrib);
       $this->si170_vlliqincentInstfinanc = ($this->si170_vlliqincentInstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentInstfinanc"]:$this->si170_vlliqincentInstfinanc);
       $this->si170_vlIrpnpincentcontrib = ($this->si170_vlIrpnpincentcontrib == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlIrpnpincentcontrib"]:$this->si170_vlIrpnpincentcontrib);
       $this->si170_vllrpnpincentinstfinanc = ($this->si170_vllrpnpincentinstfinanc == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vllrpnpincentinstfinanc"]:$this->si170_vllrpnpincentinstfinanc);
       $this->si170_vlcompromissado = ($this->si170_vlcompromissado == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlcompromissado"]:$this->si170_vlcompromissado);
       $this->si170_vlrecursosnaoaplicados = ($this->si170_vlrecursosnaoaplicados == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_vlrecursosnaoaplicados"]:$this->si170_vlrecursosnaoaplicados);
       $this->si170_mesreferencia = ($this->si170_mesreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_mesreferencia"]:$this->si170_mesreferencia);
       $this->si170_instit = ($this->si170_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_instit"]:$this->si170_instit);
     }else{
       $this->si170_sequencial = ($this->si170_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si170_sequencial"]:$this->si170_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si170_sequencial){ 
      $this->atualizacampos();
     if($this->si170_vlsaldoatualconcgarantia == null ){ 
       $this->erro_sql = " Campo Saldo atual das concessões nao Informado.";
       $this->erro_campo = "si170_vlsaldoatualconcgarantia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_recprivatizacao == null ){ 
       $this->erro_sql = " Campo Receita de  Privatização nao Informado.";
       $this->erro_campo = "si170_recprivatizacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlliqincentcontrib == null ){ 
       $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
       $this->erro_campo = "si170_vlliqincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlliqincentInstfinanc == null ){ 
       $this->erro_sql = " Campo Valor concedido por Instituição nao Informado.";
       $this->erro_campo = "si170_vlliqincentInstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlIrpnpincentcontrib == null ){ 
       $this->erro_sql = " Campo Valor Inscrito em RP Não Processados nao Informado.";
       $this->erro_campo = "si170_vlIrpnpincentcontrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vllrpnpincentinstfinanc == null ){ 
       $this->erro_sql = " Campo Valor Inscrito em RP Não Processados IF nao Informado.";
       $this->erro_campo = "si170_vllrpnpincentinstfinanc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlcompromissado == null ){ 
       $this->erro_sql = " Campo Total dos valores compromissados nao Informado.";
       $this->erro_campo = "si170_vlcompromissado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_vlrecursosnaoaplicados == null ){ 
       $this->erro_sql = " Campo Recursos do FUNDEB não aplicados nao Informado.";
       $this->erro_campo = "si170_vlrecursosnaoaplicados";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_mesreferencia == null ){ 
       $this->erro_sql = " Campo Mês de referência nao Informado.";
       $this->erro_campo = "si170_mesreferencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si170_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si170_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si170_sequencial == "" || $si170_sequencial == null ){
       $result = db_query("select nextval('dadoscomplementareslrf_si170_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dadoscomplementareslrf_si170_sequencial_seq do campo: si170_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si170_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from dadoscomplementareslrf_si170_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si170_sequencial)){
         $this->erro_sql = " Campo si170_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si170_sequencial = $si170_sequencial; 
       }
     }
     if(($this->si170_sequencial == null) || ($this->si170_sequencial == "") ){ 
       $this->erro_sql = " Campo si170_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dadoscomplementareslrf(
                                       si170_sequencial 
                                      ,si170_vlsaldoatualconcgarantia 
                                      ,si170_recprivatizacao 
                                      ,si170_vlliqincentcontrib 
                                      ,si170_vlliqincentInstfinanc 
                                      ,si170_vlIrpnpincentcontrib 
                                      ,si170_vllrpnpincentinstfinanc 
                                      ,si170_vlcompromissado 
                                      ,si170_vlrecursosnaoaplicados 
                                      ,si170_mesreferencia 
                                      ,si170_instit 
                       )
                values (
                                $this->si170_sequencial 
                               ,$this->si170_vlsaldoatualconcgarantia 
                               ,$this->si170_recprivatizacao 
                               ,$this->si170_vlliqincentcontrib 
                               ,$this->si170_vlliqincentInstfinanc 
                               ,$this->si170_vlIrpnpincentcontrib 
                               ,$this->si170_vllrpnpincentinstfinanc 
                               ,$this->si170_vlcompromissado 
                               ,$this->si170_vlrecursosnaoaplicados 
                               ,$this->si170_mesreferencia 
                               ,$this->si170_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dadoscomplementareslrf ($this->si170_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "dadoscomplementareslrf já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "dadoscomplementareslrf ($this->si170_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si170_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si170_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011446,'$this->si170_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010404,2011446,'','".AddSlashes(pg_result($resaco,0,'si170_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011447,'','".AddSlashes(pg_result($resaco,0,'si170_vlsaldoatualconcgarantia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011448,'','".AddSlashes(pg_result($resaco,0,'si170_recprivatizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011450,'','".AddSlashes(pg_result($resaco,0,'si170_vlliqincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011451,'','".AddSlashes(pg_result($resaco,0,'si170_vlliqincentInstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011452,'','".AddSlashes(pg_result($resaco,0,'si170_vlIrpnpincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011453,'','".AddSlashes(pg_result($resaco,0,'si170_vllrpnpincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011454,'','".AddSlashes(pg_result($resaco,0,'si170_vlcompromissado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011455,'','".AddSlashes(pg_result($resaco,0,'si170_vlrecursosnaoaplicados'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011456,'','".AddSlashes(pg_result($resaco,0,'si170_mesreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010404,2011687,'','".AddSlashes(pg_result($resaco,0,'si170_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si170_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dadoscomplementareslrf set ";
     $virgula = "";
     if(trim($this->si170_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_sequencial"])){ 
       $sql  .= $virgula." si170_sequencial = $this->si170_sequencial ";
       $virgula = ",";
       if(trim($this->si170_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si170_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlsaldoatualconcgarantia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualconcgarantia"])){ 
       $sql  .= $virgula." si170_vlsaldoatualconcgarantia = $this->si170_vlsaldoatualconcgarantia ";
       $virgula = ",";
       if(trim($this->si170_vlsaldoatualconcgarantia) == null ){ 
         $this->erro_sql = " Campo Saldo atual das concessões nao Informado.";
         $this->erro_campo = "si170_vlsaldoatualconcgarantia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_recprivatizacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_recprivatizacao"])){ 
       $sql  .= $virgula." si170_recprivatizacao = $this->si170_recprivatizacao ";
       $virgula = ",";
       if(trim($this->si170_recprivatizacao) == null ){ 
         $this->erro_sql = " Campo Receita de  Privatização nao Informado.";
         $this->erro_campo = "si170_recprivatizacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlliqincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentcontrib"])){ 
       $sql  .= $virgula." si170_vlliqincentcontrib = $this->si170_vlliqincentcontrib ";
       $virgula = ",";
       if(trim($this->si170_vlliqincentcontrib) == null ){ 
         $this->erro_sql = " Campo Valor Liquidado de Incentivo nao Informado.";
         $this->erro_campo = "si170_vlliqincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlliqincentInstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentInstfinanc"])){ 
       $sql  .= $virgula." si170_vlliqincentInstfinanc = $this->si170_vlliqincentInstfinanc ";
       $virgula = ",";
       if(trim($this->si170_vlliqincentInstfinanc) == null ){ 
         $this->erro_sql = " Campo Valor concedido por Instituição nao Informado.";
         $this->erro_campo = "si170_vlliqincentInstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlIrpnpincentcontrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlIrpnpincentcontrib"])){ 
       $sql  .= $virgula." si170_vlIrpnpincentcontrib = $this->si170_vlIrpnpincentcontrib ";
       $virgula = ",";
       if(trim($this->si170_vlIrpnpincentcontrib) == null ){ 
         $this->erro_sql = " Campo Valor Inscrito em RP Não Processados nao Informado.";
         $this->erro_campo = "si170_vlIrpnpincentcontrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vllrpnpincentinstfinanc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vllrpnpincentinstfinanc"])){ 
       $sql  .= $virgula." si170_vllrpnpincentinstfinanc = $this->si170_vllrpnpincentinstfinanc ";
       $virgula = ",";
       if(trim($this->si170_vllrpnpincentinstfinanc) == null ){ 
         $this->erro_sql = " Campo Valor Inscrito em RP Não Processados IF nao Informado.";
         $this->erro_campo = "si170_vllrpnpincentinstfinanc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlcompromissado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlcompromissado"])){ 
       $sql  .= $virgula." si170_vlcompromissado = $this->si170_vlcompromissado ";
       $virgula = ",";
       if(trim($this->si170_vlcompromissado) == null ){ 
         $this->erro_sql = " Campo Total dos valores compromissados nao Informado.";
         $this->erro_campo = "si170_vlcompromissado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_vlrecursosnaoaplicados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_vlrecursosnaoaplicados"])){ 
       $sql  .= $virgula." si170_vlrecursosnaoaplicados = $this->si170_vlrecursosnaoaplicados ";
       $virgula = ",";
       if(trim($this->si170_vlrecursosnaoaplicados) == null ){ 
         $this->erro_sql = " Campo Recursos do FUNDEB não aplicados nao Informado.";
         $this->erro_campo = "si170_vlrecursosnaoaplicados";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_mesreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_mesreferencia"])){ 
       $sql  .= $virgula." si170_mesreferencia = $this->si170_mesreferencia ";
       $virgula = ",";
       if(trim($this->si170_mesreferencia) == null ){ 
         $this->erro_sql = " Campo Mês de referência nao Informado.";
         $this->erro_campo = "si170_mesreferencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si170_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si170_instit"])){ 
       $sql  .= $virgula." si170_instit = $this->si170_instit ";
       $virgula = ",";
       if(trim($this->si170_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si170_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si170_sequencial!=null){
       $sql .= " si170_sequencial = $this->si170_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si170_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011446,'$this->si170_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_sequencial"]) || $this->si170_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011446,'".AddSlashes(pg_result($resaco,$conresaco,'si170_sequencial'))."','$this->si170_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlsaldoatualconcgarantia"]) || $this->si170_vlsaldoatualconcgarantia != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011447,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlsaldoatualconcgarantia'))."','$this->si170_vlsaldoatualconcgarantia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_recprivatizacao"]) || $this->si170_recprivatizacao != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011448,'".AddSlashes(pg_result($resaco,$conresaco,'si170_recprivatizacao'))."','$this->si170_recprivatizacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentcontrib"]) || $this->si170_vlliqincentcontrib != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011450,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlliqincentcontrib'))."','$this->si170_vlliqincentcontrib',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlliqincentInstfinanc"]) || $this->si170_vlliqincentInstfinanc != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011451,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlliqincentInstfinanc'))."','$this->si170_vlliqincentInstfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlIrpnpincentcontrib"]) || $this->si170_vlIrpnpincentcontrib != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011452,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlIrpnpincentcontrib'))."','$this->si170_vlIrpnpincentcontrib',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vllrpnpincentinstfinanc"]) || $this->si170_vllrpnpincentinstfinanc != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011453,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vllrpnpincentinstfinanc'))."','$this->si170_vllrpnpincentinstfinanc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlcompromissado"]) || $this->si170_vlcompromissado != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011454,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlcompromissado'))."','$this->si170_vlcompromissado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_vlrecursosnaoaplicados"]) || $this->si170_vlrecursosnaoaplicados != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011455,'".AddSlashes(pg_result($resaco,$conresaco,'si170_vlrecursosnaoaplicados'))."','$this->si170_vlrecursosnaoaplicados',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_mesreferencia"]) || $this->si170_mesreferencia != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011456,'".AddSlashes(pg_result($resaco,$conresaco,'si170_mesreferencia'))."','$this->si170_mesreferencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si170_instit"]) || $this->si170_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010404,2011687,'".AddSlashes(pg_result($resaco,$conresaco,'si170_instit'))."','$this->si170_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dadoscomplementareslrf nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si170_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dadoscomplementareslrf nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si170_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si170_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si170_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si170_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011446,'$si170_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010404,2011446,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011447,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlsaldoatualconcgarantia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011448,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_recprivatizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011450,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlliqincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011451,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlliqincentInstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011452,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlIrpnpincentcontrib'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011453,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vllrpnpincentinstfinanc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011454,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlcompromissado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011455,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_vlrecursosnaoaplicados'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011456,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_mesreferencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010404,2011687,'','".AddSlashes(pg_result($resaco,$iresaco,'si170_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from dadoscomplementareslrf
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si170_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si170_sequencial = $si170_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "dadoscomplementareslrf nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si170_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dadoscomplementareslrf nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si170_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si170_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dadoscomplementareslrf";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si170_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dadoscomplementareslrf ";
     $sql2 = "";
     if($dbwhere==""){
       if($si170_sequencial!=null ){
         $sql2 .= " where dadoscomplementareslrf.si170_sequencial = $si170_sequencial "; 
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
   function sql_query_file ( $si170_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dadoscomplementareslrf ";
     $sql2 = "";
     if($dbwhere==""){
       if($si170_sequencial!=null ){
         $sql2 .= " where dadoscomplementareslrf.si170_sequencial = $si170_sequencial "; 
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
