<?
//MODULO: sicom
//CLASSE DA ENTIDADE homolic202014
class cl_homolic202014 { 
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
   var $si64_sequencial = 0; 
   var $si64_tiporegistro = 0; 
   var $si64_codorgao = null; 
   var $si64_codunidadesub = null; 
   var $si64_exerciciolicitacao = 0; 
   var $si64_nroprocessolicitatorio = null; 
   var $si64_tipodocumento = 0; 
   var $si64_nrodocumento = null; 
   var $si64_nrolote = 0; 
   var $si64_coditem = null; 
   var $si64_percdesconto = 0; 
   var $si64_mes = 0; 
   var $si64_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si64_sequencial = int8 = sequencial 
                 si64_tiporegistro = int8 = Tipo do  registro 
                 si64_codorgao = varchar(2) = Código do órgão 
                 si64_codunidadesub = varchar(8) = Código da unidade 
                 si64_exerciciolicitacao = int8 = Exercício em que foi instaurado 
                 si64_nroprocessolicitatorio = varchar(12) = Número sequencial  do processo 
                 si64_tipodocumento = int8 = Tipo de documento 
                 si64_nrodocumento = varchar(14) = Número do  documento 
                 si64_nrolote = int8 = Número do Lote 
                 si64_coditem = varchar(15) = Código do item 
                 si64_percdesconto = float8 = Percentual do  desconto 
                 si64_mes = int8 = Mês 
                 si64_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_homolic202014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("homolic202014"); 
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
       $this->si64_sequencial = ($this->si64_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_sequencial"]:$this->si64_sequencial);
       $this->si64_tiporegistro = ($this->si64_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_tiporegistro"]:$this->si64_tiporegistro);
       $this->si64_codorgao = ($this->si64_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_codorgao"]:$this->si64_codorgao);
       $this->si64_codunidadesub = ($this->si64_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_codunidadesub"]:$this->si64_codunidadesub);
       $this->si64_exerciciolicitacao = ($this->si64_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_exerciciolicitacao"]:$this->si64_exerciciolicitacao);
       $this->si64_nroprocessolicitatorio = ($this->si64_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_nroprocessolicitatorio"]:$this->si64_nroprocessolicitatorio);
       $this->si64_tipodocumento = ($this->si64_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_tipodocumento"]:$this->si64_tipodocumento);
       $this->si64_nrodocumento = ($this->si64_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_nrodocumento"]:$this->si64_nrodocumento);
       $this->si64_nrolote = ($this->si64_nrolote == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_nrolote"]:$this->si64_nrolote);
       $this->si64_coditem = ($this->si64_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_coditem"]:$this->si64_coditem);
       $this->si64_percdesconto = ($this->si64_percdesconto == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_percdesconto"]:$this->si64_percdesconto);
       $this->si64_mes = ($this->si64_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_mes"]:$this->si64_mes);
       $this->si64_instit = ($this->si64_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_instit"]:$this->si64_instit);
     }else{
       $this->si64_sequencial = ($this->si64_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si64_sequencial"]:$this->si64_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si64_sequencial){ 
      $this->atualizacampos();
     if($this->si64_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si64_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si64_exerciciolicitacao == null ){ 
       $this->si64_exerciciolicitacao = "0";
     }
     if($this->si64_tipodocumento == null ){ 
       $this->si64_tipodocumento = "0";
     }
     if($this->si64_nrolote == null ){ 
       $this->si64_nrolote = "0";
     }
     if($this->si64_percdesconto == null ){ 
       $this->si64_percdesconto = "0";
     }
     if($this->si64_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si64_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si64_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si64_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si64_sequencial == "" || $si64_sequencial == null ){
       $result = db_query("select nextval('homolic202014_si64_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: homolic202014_si64_sequencial_seq do campo: si64_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si64_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from homolic202014_si64_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si64_sequencial)){
         $this->erro_sql = " Campo si64_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si64_sequencial = $si64_sequencial; 
       }
     }
     if(($this->si64_sequencial == null) || ($this->si64_sequencial == "") ){ 
       $this->erro_sql = " Campo si64_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into homolic202014(
                                       si64_sequencial 
                                      ,si64_tiporegistro 
                                      ,si64_codorgao 
                                      ,si64_codunidadesub 
                                      ,si64_exerciciolicitacao 
                                      ,si64_nroprocessolicitatorio 
                                      ,si64_tipodocumento 
                                      ,si64_nrodocumento 
                                      ,si64_nrolote 
                                      ,si64_coditem 
                                      ,si64_percdesconto 
                                      ,si64_mes 
                                      ,si64_instit 
                       )
                values (
                                $this->si64_sequencial 
                               ,$this->si64_tiporegistro 
                               ,'$this->si64_codorgao' 
                               ,'$this->si64_codunidadesub' 
                               ,$this->si64_exerciciolicitacao 
                               ,'$this->si64_nroprocessolicitatorio' 
                               ,$this->si64_tipodocumento 
                               ,'$this->si64_nrodocumento' 
                               ,$this->si64_nrolote 
                               ,'$this->si64_coditem' 
                               ,$this->si64_percdesconto 
                               ,$this->si64_mes 
                               ,$this->si64_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "homolic202014 ($this->si64_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "homolic202014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "homolic202014 ($this->si64_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si64_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si64_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010132,'$this->si64_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010293,2010132,'','".AddSlashes(pg_result($resaco,0,'si64_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010133,'','".AddSlashes(pg_result($resaco,0,'si64_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010134,'','".AddSlashes(pg_result($resaco,0,'si64_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010135,'','".AddSlashes(pg_result($resaco,0,'si64_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010136,'','".AddSlashes(pg_result($resaco,0,'si64_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010137,'','".AddSlashes(pg_result($resaco,0,'si64_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010138,'','".AddSlashes(pg_result($resaco,0,'si64_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010139,'','".AddSlashes(pg_result($resaco,0,'si64_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010140,'','".AddSlashes(pg_result($resaco,0,'si64_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010141,'','".AddSlashes(pg_result($resaco,0,'si64_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010142,'','".AddSlashes(pg_result($resaco,0,'si64_percdesconto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2010143,'','".AddSlashes(pg_result($resaco,0,'si64_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010293,2011576,'','".AddSlashes(pg_result($resaco,0,'si64_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si64_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update homolic202014 set ";
     $virgula = "";
     if(trim($this->si64_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_sequencial"])){ 
        if(trim($this->si64_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si64_sequencial"])){ 
           $this->si64_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si64_sequencial = $this->si64_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si64_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_tiporegistro"])){ 
       $sql  .= $virgula." si64_tiporegistro = $this->si64_tiporegistro ";
       $virgula = ",";
       if(trim($this->si64_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si64_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si64_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_codorgao"])){ 
       $sql  .= $virgula." si64_codorgao = '$this->si64_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si64_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_codunidadesub"])){ 
       $sql  .= $virgula." si64_codunidadesub = '$this->si64_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si64_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_exerciciolicitacao"])){ 
        if(trim($this->si64_exerciciolicitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si64_exerciciolicitacao"])){ 
           $this->si64_exerciciolicitacao = "0" ; 
        } 
       $sql  .= $virgula." si64_exerciciolicitacao = $this->si64_exerciciolicitacao ";
       $virgula = ",";
     }
     if(trim($this->si64_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_nroprocessolicitatorio"])){ 
       $sql  .= $virgula." si64_nroprocessolicitatorio = '$this->si64_nroprocessolicitatorio' ";
       $virgula = ",";
     }
     if(trim($this->si64_tipodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_tipodocumento"])){ 
        if(trim($this->si64_tipodocumento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si64_tipodocumento"])){ 
           $this->si64_tipodocumento = "0" ; 
        } 
       $sql  .= $virgula." si64_tipodocumento = $this->si64_tipodocumento ";
       $virgula = ",";
     }
     if(trim($this->si64_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_nrodocumento"])){ 
       $sql  .= $virgula." si64_nrodocumento = '$this->si64_nrodocumento' ";
       $virgula = ",";
     }
     if(trim($this->si64_nrolote)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_nrolote"])){ 
        if(trim($this->si64_nrolote)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si64_nrolote"])){ 
           $this->si64_nrolote = "0" ; 
        } 
       $sql  .= $virgula." si64_nrolote = $this->si64_nrolote ";
       $virgula = ",";
     }
     if(trim($this->si64_coditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_coditem"])){ 
       $sql  .= $virgula." si64_coditem = '$this->si64_coditem' ";
       $virgula = ",";
     }
     if(trim($this->si64_percdesconto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_percdesconto"])){ 
        if(trim($this->si64_percdesconto)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si64_percdesconto"])){ 
           $this->si64_percdesconto = "0" ; 
        } 
       $sql  .= $virgula." si64_percdesconto = $this->si64_percdesconto ";
       $virgula = ",";
     }
     if(trim($this->si64_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_mes"])){ 
       $sql  .= $virgula." si64_mes = $this->si64_mes ";
       $virgula = ",";
       if(trim($this->si64_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si64_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si64_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si64_instit"])){ 
       $sql  .= $virgula." si64_instit = $this->si64_instit ";
       $virgula = ",";
       if(trim($this->si64_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si64_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si64_sequencial!=null){
       $sql .= " si64_sequencial = $this->si64_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si64_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010132,'$this->si64_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_sequencial"]) || $this->si64_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010132,'".AddSlashes(pg_result($resaco,$conresaco,'si64_sequencial'))."','$this->si64_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_tiporegistro"]) || $this->si64_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010133,'".AddSlashes(pg_result($resaco,$conresaco,'si64_tiporegistro'))."','$this->si64_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_codorgao"]) || $this->si64_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010134,'".AddSlashes(pg_result($resaco,$conresaco,'si64_codorgao'))."','$this->si64_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_codunidadesub"]) || $this->si64_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010135,'".AddSlashes(pg_result($resaco,$conresaco,'si64_codunidadesub'))."','$this->si64_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_exerciciolicitacao"]) || $this->si64_exerciciolicitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010136,'".AddSlashes(pg_result($resaco,$conresaco,'si64_exerciciolicitacao'))."','$this->si64_exerciciolicitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_nroprocessolicitatorio"]) || $this->si64_nroprocessolicitatorio != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010137,'".AddSlashes(pg_result($resaco,$conresaco,'si64_nroprocessolicitatorio'))."','$this->si64_nroprocessolicitatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_tipodocumento"]) || $this->si64_tipodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010138,'".AddSlashes(pg_result($resaco,$conresaco,'si64_tipodocumento'))."','$this->si64_tipodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_nrodocumento"]) || $this->si64_nrodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010139,'".AddSlashes(pg_result($resaco,$conresaco,'si64_nrodocumento'))."','$this->si64_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_nrolote"]) || $this->si64_nrolote != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010140,'".AddSlashes(pg_result($resaco,$conresaco,'si64_nrolote'))."','$this->si64_nrolote',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_coditem"]) || $this->si64_coditem != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010141,'".AddSlashes(pg_result($resaco,$conresaco,'si64_coditem'))."','$this->si64_coditem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_percdesconto"]) || $this->si64_percdesconto != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010142,'".AddSlashes(pg_result($resaco,$conresaco,'si64_percdesconto'))."','$this->si64_percdesconto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_mes"]) || $this->si64_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2010143,'".AddSlashes(pg_result($resaco,$conresaco,'si64_mes'))."','$this->si64_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si64_instit"]) || $this->si64_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010293,2011576,'".AddSlashes(pg_result($resaco,$conresaco,'si64_instit'))."','$this->si64_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "homolic202014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si64_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "homolic202014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si64_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si64_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si64_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si64_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010132,'$si64_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010293,2010132,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010133,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010134,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010135,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010136,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010137,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010138,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010139,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010140,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010141,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010142,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_percdesconto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2010143,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010293,2011576,'','".AddSlashes(pg_result($resaco,$iresaco,'si64_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from homolic202014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si64_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si64_sequencial = $si64_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "homolic202014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si64_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "homolic202014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si64_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si64_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:homolic202014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si64_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from homolic202014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si64_sequencial!=null ){
         $sql2 .= " where homolic202014.si64_sequencial = $si64_sequencial "; 
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
   function sql_query_file ( $si64_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from homolic202014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si64_sequencial!=null ){
         $sql2 .= " where homolic202014.si64_sequencial = $si64_sequencial "; 
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
