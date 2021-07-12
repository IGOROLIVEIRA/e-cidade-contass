<?
//MODULO: sicom
//CLASSE DA ENTIDADE lqd102016
class cl_lqd102016 { 
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
   var $si118_sequencial = 0; 
   var $si118_tiporegistro = 0; 
   var $si118_codreduzido = 0; 
   var $si118_codorgao = null; 
   var $si118_codunidadesub = null; 
   var $si118_tpliquidacao = 0; 
   var $si118_nroempenho = 0; 
   var $si118_dtempenho_dia = null; 
   var $si118_dtempenho_mes = null; 
   var $si118_dtempenho_ano = null; 
   var $si118_dtempenho = null; 
   var $si118_dtliquidacao_dia = null; 
   var $si118_dtliquidacao_mes = null; 
   var $si118_dtliquidacao_ano = null; 
   var $si118_dtliquidacao = null; 
   var $si118_nroliquidacao = 0; 
   var $si118_vlliquidado = 0; 
   var $si118_cpfliquidante = null; 
   var $si118_mes = 0; 
   var $si118_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si118_sequencial = int8 = sequencial 
                 si118_tiporegistro = int8 = Tipo do  registro 
                 si118_codreduzido = int8 = Código Identificador do registro 
                 si118_codorgao = varchar(2) = Código do órgão 
                 si118_codunidadesub = varchar(8) = Código da unidade 
                 si118_tpliquidacao = int8 = Tipo de  liquidação 
                 si118_nroempenho = int8 = Número do  empenho 
                 si118_dtempenho = date = Data do  empenho 
                 si118_dtliquidacao = date = Data da  Liquidação do  empenho 
                 si118_nroliquidacao = int8 = Número da  Liquidação 
                 si118_vlliquidado = float8 = Valor Liquidado  do empenho 
                 si118_cpfliquidante = varchar(11) = Número do CPF 
                 si118_mes = int8 = Mês 
                 si118_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_lqd102016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("lqd102016"); 
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
       $this->si118_sequencial = ($this->si118_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_sequencial"]:$this->si118_sequencial);
       $this->si118_tiporegistro = ($this->si118_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_tiporegistro"]:$this->si118_tiporegistro);
       $this->si118_codreduzido = ($this->si118_codreduzido == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_codreduzido"]:$this->si118_codreduzido);
       $this->si118_codorgao = ($this->si118_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_codorgao"]:$this->si118_codorgao);
       $this->si118_codunidadesub = ($this->si118_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_codunidadesub"]:$this->si118_codunidadesub);
       $this->si118_tpliquidacao = ($this->si118_tpliquidacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_tpliquidacao"]:$this->si118_tpliquidacao);
       $this->si118_nroempenho = ($this->si118_nroempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_nroempenho"]:$this->si118_nroempenho);
       if($this->si118_dtempenho == ""){
         $this->si118_dtempenho_dia = ($this->si118_dtempenho_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_dtempenho_dia"]:$this->si118_dtempenho_dia);
         $this->si118_dtempenho_mes = ($this->si118_dtempenho_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_dtempenho_mes"]:$this->si118_dtempenho_mes);
         $this->si118_dtempenho_ano = ($this->si118_dtempenho_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_dtempenho_ano"]:$this->si118_dtempenho_ano);
         if($this->si118_dtempenho_dia != ""){
            $this->si118_dtempenho = $this->si118_dtempenho_ano."-".$this->si118_dtempenho_mes."-".$this->si118_dtempenho_dia;
         }
       }
       if($this->si118_dtliquidacao == ""){
         $this->si118_dtliquidacao_dia = ($this->si118_dtliquidacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_dtliquidacao_dia"]:$this->si118_dtliquidacao_dia);
         $this->si118_dtliquidacao_mes = ($this->si118_dtliquidacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_dtliquidacao_mes"]:$this->si118_dtliquidacao_mes);
         $this->si118_dtliquidacao_ano = ($this->si118_dtliquidacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_dtliquidacao_ano"]:$this->si118_dtliquidacao_ano);
         if($this->si118_dtliquidacao_dia != ""){
            $this->si118_dtliquidacao = $this->si118_dtliquidacao_ano."-".$this->si118_dtliquidacao_mes."-".$this->si118_dtliquidacao_dia;
         }
       }
       $this->si118_nroliquidacao = ($this->si118_nroliquidacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_nroliquidacao"]:$this->si118_nroliquidacao);
       $this->si118_vlliquidado = ($this->si118_vlliquidado == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_vlliquidado"]:$this->si118_vlliquidado);
       $this->si118_cpfliquidante = ($this->si118_cpfliquidante == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_cpfliquidante"]:$this->si118_cpfliquidante);
       $this->si118_mes = ($this->si118_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_mes"]:$this->si118_mes);
       $this->si118_instit = ($this->si118_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_instit"]:$this->si118_instit);
     }else{
       $this->si118_sequencial = ($this->si118_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si118_sequencial"]:$this->si118_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si118_sequencial){ 
      $this->atualizacampos();
     if($this->si118_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si118_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si118_codreduzido == null ){ 
       $this->si118_codreduzido = "0";
     }
     if($this->si118_tpliquidacao == null ){ 
       $this->si118_tpliquidacao = "0";
     }
     if($this->si118_nroempenho == null ){ 
       $this->si118_nroempenho = "0";
     }
     if($this->si118_dtempenho == null ){ 
       $this->si118_dtempenho = "null";
     }
     if($this->si118_dtliquidacao == null ){ 
       $this->si118_dtliquidacao = "null";
     }
     if($this->si118_nroliquidacao == null ){ 
       $this->si118_nroliquidacao = "0";
     }
     if($this->si118_vlliquidado == null ){ 
       $this->si118_vlliquidado = "0";
     }
     if($this->si118_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si118_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si118_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si118_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si118_sequencial == "" || $si118_sequencial == null ){
       $result = db_query("select nextval('lqd102016_si118_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: lqd102016_si118_sequencial_seq do campo: si118_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si118_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from lqd102016_si118_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si118_sequencial)){
         $this->erro_sql = " Campo si118_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si118_sequencial = $si118_sequencial; 
       }
     }
     if(($this->si118_sequencial == null) || ($this->si118_sequencial == "") ){ 
       $this->erro_sql = " Campo si118_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into lqd102016(
                                       si118_sequencial 
                                      ,si118_tiporegistro 
                                      ,si118_codreduzido 
                                      ,si118_codorgao 
                                      ,si118_codunidadesub 
                                      ,si118_tpliquidacao 
                                      ,si118_nroempenho 
                                      ,si118_dtempenho 
                                      ,si118_dtliquidacao 
                                      ,si118_nroliquidacao 
                                      ,si118_vlliquidado 
                                      ,si118_cpfliquidante 
                                      ,si118_mes 
                                      ,si118_instit 
                       )
                values (
                                $this->si118_sequencial 
                               ,$this->si118_tiporegistro 
                               ,$this->si118_codreduzido 
                               ,'$this->si118_codorgao' 
                               ,'$this->si118_codunidadesub' 
                               ,$this->si118_tpliquidacao 
                               ,$this->si118_nroempenho 
                               ,".($this->si118_dtempenho == "null" || $this->si118_dtempenho == ""?"null":"'".$this->si118_dtempenho."'")." 
                               ,".($this->si118_dtliquidacao == "null" || $this->si118_dtliquidacao == ""?"null":"'".$this->si118_dtliquidacao."'")." 
                               ,$this->si118_nroliquidacao 
                               ,$this->si118_vlliquidado 
                               ,'$this->si118_cpfliquidante' 
                               ,$this->si118_mes 
                               ,$this->si118_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "lqd102016 ($this->si118_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "lqd102016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "lqd102016 ($this->si118_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si118_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si118_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010786,'$this->si118_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010347,2010786,'','".AddSlashes(pg_result($resaco,0,'si118_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010787,'','".AddSlashes(pg_result($resaco,0,'si118_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010788,'','".AddSlashes(pg_result($resaco,0,'si118_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010789,'','".AddSlashes(pg_result($resaco,0,'si118_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010790,'','".AddSlashes(pg_result($resaco,0,'si118_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010791,'','".AddSlashes(pg_result($resaco,0,'si118_tpliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010792,'','".AddSlashes(pg_result($resaco,0,'si118_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010793,'','".AddSlashes(pg_result($resaco,0,'si118_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010794,'','".AddSlashes(pg_result($resaco,0,'si118_dtliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010795,'','".AddSlashes(pg_result($resaco,0,'si118_nroliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010796,'','".AddSlashes(pg_result($resaco,0,'si118_vlliquidado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010797,'','".AddSlashes(pg_result($resaco,0,'si118_cpfliquidante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2010798,'','".AddSlashes(pg_result($resaco,0,'si118_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010347,2011631,'','".AddSlashes(pg_result($resaco,0,'si118_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si118_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update lqd102016 set ";
     $virgula = "";
     if(trim($this->si118_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_sequencial"])){ 
        if(trim($this->si118_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si118_sequencial"])){ 
           $this->si118_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si118_sequencial = $this->si118_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si118_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_tiporegistro"])){ 
       $sql  .= $virgula." si118_tiporegistro = $this->si118_tiporegistro ";
       $virgula = ",";
       if(trim($this->si118_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si118_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si118_codreduzido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_codreduzido"])){ 
        if(trim($this->si118_codreduzido)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si118_codreduzido"])){ 
           $this->si118_codreduzido = "0" ; 
        } 
       $sql  .= $virgula." si118_codreduzido = $this->si118_codreduzido ";
       $virgula = ",";
     }
     if(trim($this->si118_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_codorgao"])){ 
       $sql  .= $virgula." si118_codorgao = '$this->si118_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si118_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_codunidadesub"])){ 
       $sql  .= $virgula." si118_codunidadesub = '$this->si118_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si118_tpliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_tpliquidacao"])){ 
        if(trim($this->si118_tpliquidacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si118_tpliquidacao"])){ 
           $this->si118_tpliquidacao = "0" ; 
        } 
       $sql  .= $virgula." si118_tpliquidacao = $this->si118_tpliquidacao ";
       $virgula = ",";
     }
     if(trim($this->si118_nroempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_nroempenho"])){ 
        if(trim($this->si118_nroempenho)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si118_nroempenho"])){ 
           $this->si118_nroempenho = "0" ; 
        } 
       $sql  .= $virgula." si118_nroempenho = $this->si118_nroempenho ";
       $virgula = ",";
     }
     if(trim($this->si118_dtempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_dtempenho_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si118_dtempenho_dia"] !="") ){ 
       $sql  .= $virgula." si118_dtempenho = '$this->si118_dtempenho' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si118_dtempenho_dia"])){ 
         $sql  .= $virgula." si118_dtempenho = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si118_dtliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_dtliquidacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si118_dtliquidacao_dia"] !="") ){ 
       $sql  .= $virgula." si118_dtliquidacao = '$this->si118_dtliquidacao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si118_dtliquidacao_dia"])){ 
         $sql  .= $virgula." si118_dtliquidacao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si118_nroliquidacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_nroliquidacao"])){ 
        if(trim($this->si118_nroliquidacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si118_nroliquidacao"])){ 
           $this->si118_nroliquidacao = "0" ; 
        } 
       $sql  .= $virgula." si118_nroliquidacao = $this->si118_nroliquidacao ";
       $virgula = ",";
     }
     if(trim($this->si118_vlliquidado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_vlliquidado"])){ 
        if(trim($this->si118_vlliquidado)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si118_vlliquidado"])){ 
           $this->si118_vlliquidado = "0" ; 
        } 
       $sql  .= $virgula." si118_vlliquidado = $this->si118_vlliquidado ";
       $virgula = ",";
     }
     if(trim($this->si118_cpfliquidante)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_cpfliquidante"])){ 
       $sql  .= $virgula." si118_cpfliquidante = '$this->si118_cpfliquidante' ";
       $virgula = ",";
     }
     if(trim($this->si118_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_mes"])){ 
       $sql  .= $virgula." si118_mes = $this->si118_mes ";
       $virgula = ",";
       if(trim($this->si118_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si118_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si118_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si118_instit"])){ 
       $sql  .= $virgula." si118_instit = $this->si118_instit ";
       $virgula = ",";
       if(trim($this->si118_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si118_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si118_sequencial!=null){
       $sql .= " si118_sequencial = $this->si118_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si118_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010786,'$this->si118_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_sequencial"]) || $this->si118_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010786,'".AddSlashes(pg_result($resaco,$conresaco,'si118_sequencial'))."','$this->si118_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_tiporegistro"]) || $this->si118_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010787,'".AddSlashes(pg_result($resaco,$conresaco,'si118_tiporegistro'))."','$this->si118_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_codreduzido"]) || $this->si118_codreduzido != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010788,'".AddSlashes(pg_result($resaco,$conresaco,'si118_codreduzido'))."','$this->si118_codreduzido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_codorgao"]) || $this->si118_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010789,'".AddSlashes(pg_result($resaco,$conresaco,'si118_codorgao'))."','$this->si118_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_codunidadesub"]) || $this->si118_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010790,'".AddSlashes(pg_result($resaco,$conresaco,'si118_codunidadesub'))."','$this->si118_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_tpliquidacao"]) || $this->si118_tpliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010791,'".AddSlashes(pg_result($resaco,$conresaco,'si118_tpliquidacao'))."','$this->si118_tpliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_nroempenho"]) || $this->si118_nroempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010792,'".AddSlashes(pg_result($resaco,$conresaco,'si118_nroempenho'))."','$this->si118_nroempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_dtempenho"]) || $this->si118_dtempenho != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010793,'".AddSlashes(pg_result($resaco,$conresaco,'si118_dtempenho'))."','$this->si118_dtempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_dtliquidacao"]) || $this->si118_dtliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010794,'".AddSlashes(pg_result($resaco,$conresaco,'si118_dtliquidacao'))."','$this->si118_dtliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_nroliquidacao"]) || $this->si118_nroliquidacao != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010795,'".AddSlashes(pg_result($resaco,$conresaco,'si118_nroliquidacao'))."','$this->si118_nroliquidacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_vlliquidado"]) || $this->si118_vlliquidado != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010796,'".AddSlashes(pg_result($resaco,$conresaco,'si118_vlliquidado'))."','$this->si118_vlliquidado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_cpfliquidante"]) || $this->si118_cpfliquidante != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010797,'".AddSlashes(pg_result($resaco,$conresaco,'si118_cpfliquidante'))."','$this->si118_cpfliquidante',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_mes"]) || $this->si118_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2010798,'".AddSlashes(pg_result($resaco,$conresaco,'si118_mes'))."','$this->si118_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si118_instit"]) || $this->si118_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010347,2011631,'".AddSlashes(pg_result($resaco,$conresaco,'si118_instit'))."','$this->si118_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "lqd102016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si118_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "lqd102016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si118_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si118_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si118_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si118_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010786,'$si118_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010347,2010786,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010787,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010788,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_codreduzido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010789,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010790,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010791,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_tpliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010792,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010793,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010794,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_dtliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010795,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_nroliquidacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010796,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_vlliquidado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010797,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_cpfliquidante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2010798,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010347,2011631,'','".AddSlashes(pg_result($resaco,$iresaco,'si118_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from lqd102016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si118_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si118_sequencial = $si118_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "lqd102016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si118_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "lqd102016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si118_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si118_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:lqd102016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si118_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from lqd102016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si118_sequencial!=null ){
         $sql2 .= " where lqd102016.si118_sequencial = $si118_sequencial "; 
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
   function sql_query_file ( $si118_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from lqd102016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si118_sequencial!=null ){
         $sql2 .= " where lqd102016.si118_sequencial = $si118_sequencial "; 
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
