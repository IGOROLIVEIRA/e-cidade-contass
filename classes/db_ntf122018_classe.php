<?
//MODULO: sicom
//CLASSE DA ENTIDADE ntf122018
class cl_ntf122018 { 
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
   var $si145_sequencial = 0; 
   var $si145_tiporegistro = 0; 
   var $si145_codnotafiscal = 0; 
   var $si145_codunidadesub = null; 
   var $si145_dtempenho_dia = null; 
   var $si145_dtempenho_mes = null; 
   var $si145_dtempenho_ano = null; 
   var $si145_dtempenho = null; 
   var $si145_nroempenho = 0; 
   var $si145_dtliquidacao_dia = null; 
   var $si145_dtliquidacao_mes = null; 
   var $si145_dtliquidacao_ano = null; 
   var $si145_dtliquidacao = null; 
   var $si145_nroliquidacao = 0; 
   var $si145_mes = 0; 
   var $si145_reg10 = 0; 
   var $si145_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si145_sequencial = int8 = sequencial 
                 si145_tiporegistro = int8 = Tipo do  registro 
                 si145_codnotafiscal = int8 = Código Identificador da Nota Fiscal 
                 si145_codunidadesub = varchar(8) = Código da unidade 
                 si145_dtempenho = date = Data do empenho 
                 si145_nroempenho = int8 = Número do  empenho 
                 si145_dtliquidacao = date = Data da Liquidação do empenho 
                 si145_nroliquidacao = int8 = Número da  liquidação 
                 si145_mes = int8 = Mês 
                 si145_reg10 = int8 = reg10 
                 si145_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ntf122018() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ntf122018"); 
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
       $this->si145_sequencial = ($this->si145_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_sequencial"]:$this->si145_sequencial);
       $this->si145_tiporegistro = ($this->si145_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_tiporegistro"]:$this->si145_tiporegistro);
       $this->si145_codnotafiscal = ($this->si145_codnotafiscal == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_codnotafiscal"]:$this->si145_codnotafiscal);
       $this->si145_codunidadesub = ($this->si145_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_codunidadesub"]:$this->si145_codunidadesub);
       if($this->si145_dtempenho == ""){
         $this->si145_dtempenho_dia = ($this->si145_dtempenho_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_dtempenho_dia"]:$this->si145_dtempenho_dia);
         $this->si145_dtempenho_mes = ($this->si145_dtempenho_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_dtempenho_mes"]:$this->si145_dtempenho_mes);
         $this->si145_dtempenho_ano = ($this->si145_dtempenho_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_dtempenho_ano"]:$this->si145_dtempenho_ano);
         if($this->si145_dtempenho_dia != ""){
            $this->si145_dtempenho = $this->si145_dtempenho_ano."-".$this->si145_dtempenho_mes."-".$this->si145_dtempenho_dia;
         }
       }
       $this->si145_nroempenho = ($this->si145_nroempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_nroempenho"]:$this->si145_nroempenho);
       if($this->si145_dtliquidacao == ""){
         $this->si145_dtliquidacao_dia = ($this->si145_dtliquidacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_dtliquidacao_dia"]:$this->si145_dtliquidacao_dia);
         $this->si145_dtliquidacao_mes = ($this->si145_dtliquidacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_dtliquidacao_mes"]:$this->si145_dtliquidacao_mes);
         $this->si145_dtliquidacao_ano = ($this->si145_dtliquidacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_dtliquidacao_ano"]:$this->si145_dtliquidacao_ano);
         if($this->si145_dtliquidacao_dia != ""){
            $this->si145_dtliquidacao = $this->si145_dtliquidacao_ano."-".$this->si145_dtliquidacao_mes."-".$this->si145_dtliquidacao_dia;
         }
       }
       $this->si145_nroliquidacao = ($this->si145_nroliquidacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_nroliquidacao"]:$this->si145_nroliquidacao);
       $this->si145_mes = ($this->si145_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_mes"]:$this->si145_mes);
       $this->si145_reg10 = ($this->si145_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_reg10"]:$this->si145_reg10);
       $this->si145_instit = ($this->si145_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_instit"]:$this->si145_instit);
     }else{
       $this->si145_sequencial = ($this->si145_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si145_sequencial"]:$this->si145_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si145_sequencial){ 
      $this->atualizacampos();
     if($this->si145_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si145_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si145_codnotafiscal == null ){ 
       $this->si145_codnotafiscal = "0";
     }
     if($this->si145_dtempenho == null ){ 
       $this->si145_dtempenho = "null";
     }
     if($this->si145_nroempenho == null ){ 
       $this->si145_nroempenho = "0";
     }
     if($this->si145_dtliquidacao == null ){ 
       $this->si145_dtliquidacao = "null";
     }
     if($this->si145_nroliquidacao == null ){ 
       $this->si145_nroliquidacao = "0";
     }
     if($this->si145_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si145_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si145_reg10 == null ){ 
       $this->si145_reg10 = "0";
     }
     if($this->si145_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si145_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si145_sequencial == "" || $si145_sequencial == null ){
       $result = db_query("select nextval('ntf122018_si145_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ntf122018_si145_sequencial_seq do campo: si145_sequencial"; 
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si145_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ntf122018_si145_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si145_sequencial)){
         $this->erro_sql = " Campo si145_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si145_sequencial = $si145_sequencial; 
       }
     }
     if(($this->si145_sequencial == null) || ($this->si145_sequencial == "") ){ 
       $this->erro_sql = " Campo si145_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ntf122018(
                                       si145_sequencial 
                                      ,si145_tiporegistro 
                                      ,si145_codnotafiscal 
                                      ,si145_codunidadesub 
                                      ,si145_dtempenho 
                                      ,si145_nroempenho 
                                      ,si145_dtliquidacao 
                                      ,si145_nroliquidacao 
                                      ,si145_mes 
                                      ,si145_reg10 
                                      ,si145_instit 
                       )
                values (
                                $this->si145_sequencial 
                               ,$this->si145_tiporegistro 
                               ,$this->si145_codnotafiscal 
                               ,'$this->si145_codunidadesub' 
                               ,".($this->si145_dtempenho == "null" || $this->si145_dtempenho == ""?"null":"'".$this->si145_dtempenho."'")." 
                               ,$this->si145_nroempenho 
                               ,".($this->si145_dtliquidacao == "null" || $this->si145_dtliquidacao == ""?"null":"'".$this->si145_dtliquidacao."'")." 
                               ,$this->si145_nroliquidacao 
                               ,$this->si145_mes 
                               ,$this->si145_reg10 
                               ,$this->si145_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ntf122018 ($this->si145_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "ntf122018 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "ntf122018 ($this->si145_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si145_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si145_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011079,'$this->si145_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010374,2011079,'','".AddSlashes(pg_result($resaco,0,'si145_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011080,'','".AddSlashes(pg_result($resaco,0,'si145_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011081,'','".AddSlashes(pg_result($resaco,0,'si145_codnotafiscal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011082,'','".AddSlashes(pg_result($resaco,0,'si145_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011083,'','".AddSlashes(pg_result($resaco,0,'si145_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011084,'','".AddSlashes(pg_result($resaco,0,'si145_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011085,'','".AddSlashes(pg_result($resaco,0,'si145_dtliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011086,'','".AddSlashes(pg_result($resaco,0,'si145_nroliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011087,'','".AddSlashes(pg_result($resaco,0,'si145_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011088,'','".AddSlashes(pg_result($resaco,0,'si145_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010374,2011658,'','".AddSlashes(pg_result($resaco,0,'si145_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si145_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ntf122018 set ";
     $virgula = "";
     if(trim($this->si145_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_sequencial"])){ 
        if(trim($this->si145_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si145_sequencial"])){ 
           $this->si145_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si145_sequencial = $this->si145_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si145_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_tiporegistro"])){ 
       $sql  .= $virgula." si145_tiporegistro = $this->si145_tiporegistro ";
       $virgula = ",";
       if(trim($this->si145_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si145_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si145_codnotafiscal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_codnotafiscal"])){ 
        if(trim($this->si145_codnotafiscal)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si145_codnotafiscal"])){ 
           $this->si145_codnotafiscal = "0" ; 
        } 
       $sql  .= $virgula." si145_codnotafiscal = $this->si145_codnotafiscal ";
       $virgula = ",";
     }
     if(trim($this->si145_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_codunidadesub"])){ 
       $sql  .= $virgula." si145_codunidadesub = '$this->si145_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si145_dtempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_dtempenho_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si145_dtempenho_dia"] !="") ){ 
       $sql  .= $virgula." si145_dtempenho = '$this->si145_dtempenho' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si145_dtempenho_dia"])){ 
         $sql  .= $virgula." si145_dtempenho = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si145_nroempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_nroempenho"])){ 
        if(trim($this->si145_nroempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si145_nroempenho"])){ 
           $this->si145_nroempenho = "0" ; 
        } 
       $sql  .= $virgula." si145_nroempenho = $this->si145_nroempenho ";
       $virgula = ",";
     }
     if(trim($this->si145_dtliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_dtliquidacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si145_dtliquidacao_dia"] !="") ){ 
       $sql  .= $virgula." si145_dtliquidacao = '$this->si145_dtliquidacao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si145_dtliquidacao_dia"])){ 
         $sql  .= $virgula." si145_dtliquidacao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si145_nroliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_nroliquidacao"])){ 
        if(trim($this->si145_nroliquidacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si145_nroliquidacao"])){ 
           $this->si145_nroliquidacao = "0" ; 
        } 
       $sql  .= $virgula." si145_nroliquidacao = $this->si145_nroliquidacao ";
       $virgula = ",";
     }
     if(trim($this->si145_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_mes"])){ 
       $sql  .= $virgula." si145_mes = $this->si145_mes ";
       $virgula = ",";
       if(trim($this->si145_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si145_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si145_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_reg10"])){ 
        if(trim($this->si145_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si145_reg10"])){ 
           $this->si145_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si145_reg10 = $this->si145_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si145_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si145_instit"])){ 
       $sql  .= $virgula." si145_instit = $this->si145_instit ";
       $virgula = ",";
       if(trim($this->si145_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si145_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si145_sequencial!=null){
       $sql .= " si145_sequencial = $this->si145_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si145_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011079,'$this->si145_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_sequencial"]) || $this->si145_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011079,'".AddSlashes(pg_result($resaco,$conresaco,'si145_sequencial'))."','$this->si145_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_tiporegistro"]) || $this->si145_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011080,'".AddSlashes(pg_result($resaco,$conresaco,'si145_tiporegistro'))."','$this->si145_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_codnotafiscal"]) || $this->si145_codnotafiscal != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011081,'".AddSlashes(pg_result($resaco,$conresaco,'si145_codnotafiscal'))."','$this->si145_codnotafiscal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_codunidadesub"]) || $this->si145_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011082,'".AddSlashes(pg_result($resaco,$conresaco,'si145_codunidadesub'))."','$this->si145_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_dtempenho"]) || $this->si145_dtempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011083,'".AddSlashes(pg_result($resaco,$conresaco,'si145_dtempenho'))."','$this->si145_dtempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_nroempenho"]) || $this->si145_nroempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011084,'".AddSlashes(pg_result($resaco,$conresaco,'si145_nroempenho'))."','$this->si145_nroempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_dtliquidacao"]) || $this->si145_dtliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011085,'".AddSlashes(pg_result($resaco,$conresaco,'si145_dtliquidacao'))."','$this->si145_dtliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_nroliquidacao"]) || $this->si145_nroliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011086,'".AddSlashes(pg_result($resaco,$conresaco,'si145_nroliquidacao'))."','$this->si145_nroliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_mes"]) || $this->si145_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011087,'".AddSlashes(pg_result($resaco,$conresaco,'si145_mes'))."','$this->si145_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_reg10"]) || $this->si145_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011088,'".AddSlashes(pg_result($resaco,$conresaco,'si145_reg10'))."','$this->si145_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si145_instit"]) || $this->si145_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010374,2011658,'".AddSlashes(pg_result($resaco,$conresaco,'si145_instit'))."','$this->si145_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "ntf122018 nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si145_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ntf122018 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si145_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si145_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si145_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si145_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011079,'$si145_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010374,2011079,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011080,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011081,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_codnotafiscal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011082,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011083,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011084,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011085,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_dtliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011086,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_nroliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011087,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011088,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010374,2011658,'','".AddSlashes(pg_result($resaco,$iresaco,'si145_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ntf122018
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si145_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si145_sequencial = $si145_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "ntf122018 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si145_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ntf122018 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si145_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si145_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ntf122018";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si145_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ntf122018 ";
     $sql .= "      left  join ntf102018  on  ntf102018.si143_sequencial = ntf122018.si145_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si145_sequencial!=null ){
         $sql2 .= " where ntf122018.si145_sequencial = $si145_sequencial "; 
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
   function sql_query_file ( $si145_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ntf122018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si145_sequencial!=null ){
         $sql2 .= " where ntf122018.si145_sequencial = $si145_sequencial "; 
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
