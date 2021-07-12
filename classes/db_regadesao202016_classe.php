<?
//MODULO: sicom
//CLASSE DA ENTIDADE regadesao202016
class cl_regadesao202016 { 
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
   var $si73_sequencial = 0; 
   var $si73_tiporegistro = 0; 
   var $si73_codorgao = null; 
   var $si73_codunidadesub = null; 
   var $si73_nroprocadesao = null; 
   var $si73_exercicioadesao = 0; 
   var $si73_nrolote = 0; 
   var $si73_coditem = 0; 
   var $si73_percdesconto = 0; 
   var $si73_tipodocumento = 0; 
   var $si73_nrodocumento = null; 
   var $si73_mes = 0; 
   var $si73_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si73_sequencial = int8 = sequencial 
                 si73_tiporegistro = int8 = Tipo do  registro 
                 si73_codorgao = varchar(2) = Código do órgão 
                 si73_codunidadesub = varchar(8) = Código da unidade 
                 si73_nroprocadesao = varchar(12) = Número do  processo de  adesão 
                 si73_exercicioadesao = int8 = Exercício do  processo de  adesão 
                 si73_nrolote = int8 = Número do Lote 
                 si73_coditem = int8 = Código do item 
                 si73_percdesconto = float8 = Percentual do  desconto 
                 si73_tipodocumento = int8 = Tipo do  documento 
                 si73_nrodocumento = varchar(14) = Número do  documento 
                 si73_mes = int8 = Mês 
                 si73_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_regadesao202016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("regadesao202016"); 
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
       $this->si73_sequencial = ($this->si73_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_sequencial"]:$this->si73_sequencial);
       $this->si73_tiporegistro = ($this->si73_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_tiporegistro"]:$this->si73_tiporegistro);
       $this->si73_codorgao = ($this->si73_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_codorgao"]:$this->si73_codorgao);
       $this->si73_codunidadesub = ($this->si73_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_codunidadesub"]:$this->si73_codunidadesub);
       $this->si73_nroprocadesao = ($this->si73_nroprocadesao == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_nroprocadesao"]:$this->si73_nroprocadesao);
       $this->si73_exercicioadesao = ($this->si73_exercicioadesao == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_exercicioadesao"]:$this->si73_exercicioadesao);
       $this->si73_nrolote = ($this->si73_nrolote == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_nrolote"]:$this->si73_nrolote);
       $this->si73_coditem = ($this->si73_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_coditem"]:$this->si73_coditem);
       $this->si73_percdesconto = ($this->si73_percdesconto == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_percdesconto"]:$this->si73_percdesconto);
       $this->si73_tipodocumento = ($this->si73_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_tipodocumento"]:$this->si73_tipodocumento);
       $this->si73_nrodocumento = ($this->si73_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_nrodocumento"]:$this->si73_nrodocumento);
       $this->si73_mes = ($this->si73_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_mes"]:$this->si73_mes);
       $this->si73_instit = ($this->si73_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_instit"]:$this->si73_instit);
     }else{
       $this->si73_sequencial = ($this->si73_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si73_sequencial"]:$this->si73_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si73_sequencial){ 
      $this->atualizacampos();
     if($this->si73_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si73_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si73_exercicioadesao == null ){ 
       $this->si73_exercicioadesao = "0";
     }
     if($this->si73_nrolote == null ){ 
       $this->si73_nrolote = "0";
     }
     if($this->si73_coditem == null ){ 
       $this->si73_coditem = "0";
     }
     if($this->si73_percdesconto == null ){ 
       $this->si73_percdesconto = "0";
     }
     if($this->si73_tipodocumento == null ){ 
       $this->si73_tipodocumento = "0";
     }
     if($this->si73_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si73_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si73_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si73_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si73_sequencial == "" || $si73_sequencial == null ){
       $result = db_query("select nextval('regadesao202016_si73_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: regadesao202016_si73_sequencial_seq do campo: si73_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si73_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from regadesao202016_si73_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si73_sequencial)){
         $this->erro_sql = " Campo si73_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si73_sequencial = $si73_sequencial; 
       }
     }
     if(($this->si73_sequencial == null) || ($this->si73_sequencial == "") ){ 
       $this->erro_sql = " Campo si73_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into regadesao202016(
                                       si73_sequencial 
                                      ,si73_tiporegistro 
                                      ,si73_codorgao 
                                      ,si73_codunidadesub 
                                      ,si73_nroprocadesao 
                                      ,si73_exercicioadesao 
                                      ,si73_nrolote 
                                      ,si73_coditem 
                                      ,si73_percdesconto 
                                      ,si73_tipodocumento 
                                      ,si73_nrodocumento 
                                      ,si73_mes 
                                      ,si73_instit 
                       )
                values (
                                $this->si73_sequencial 
                               ,$this->si73_tiporegistro 
                               ,'$this->si73_codorgao' 
                               ,'$this->si73_codunidadesub' 
                               ,'$this->si73_nroprocadesao' 
                               ,$this->si73_exercicioadesao 
                               ,$this->si73_nrolote 
                               ,$this->si73_coditem 
                               ,$this->si73_percdesconto 
                               ,$this->si73_tipodocumento 
                               ,'$this->si73_nrodocumento' 
                               ,$this->si73_mes 
                               ,$this->si73_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "regadesao202016 ($this->si73_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "regadesao202016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "regadesao202016 ($this->si73_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si73_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si73_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010243,'$this->si73_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010302,2010243,'','".AddSlashes(pg_result($resaco,0,'si73_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010244,'','".AddSlashes(pg_result($resaco,0,'si73_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010245,'','".AddSlashes(pg_result($resaco,0,'si73_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010246,'','".AddSlashes(pg_result($resaco,0,'si73_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010247,'','".AddSlashes(pg_result($resaco,0,'si73_nroprocadesao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2011316,'','".AddSlashes(pg_result($resaco,0,'si73_exercicioadesao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010249,'','".AddSlashes(pg_result($resaco,0,'si73_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010250,'','".AddSlashes(pg_result($resaco,0,'si73_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010251,'','".AddSlashes(pg_result($resaco,0,'si73_percdesconto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010252,'','".AddSlashes(pg_result($resaco,0,'si73_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010253,'','".AddSlashes(pg_result($resaco,0,'si73_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2010254,'','".AddSlashes(pg_result($resaco,0,'si73_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010302,2011585,'','".AddSlashes(pg_result($resaco,0,'si73_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si73_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update regadesao202016 set ";
     $virgula = "";
     if(trim($this->si73_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_sequencial"])){ 
        if(trim($this->si73_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si73_sequencial"])){ 
           $this->si73_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si73_sequencial = $this->si73_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si73_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_tiporegistro"])){ 
       $sql  .= $virgula." si73_tiporegistro = $this->si73_tiporegistro ";
       $virgula = ",";
       if(trim($this->si73_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si73_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si73_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_codorgao"])){ 
       $sql  .= $virgula." si73_codorgao = '$this->si73_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si73_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_codunidadesub"])){ 
       $sql  .= $virgula." si73_codunidadesub = '$this->si73_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si73_nroprocadesao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_nroprocadesao"])){ 
       $sql  .= $virgula." si73_nroprocadesao = '$this->si73_nroprocadesao' ";
       $virgula = ",";
     }
     if(trim($this->si73_exercicioadesao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_exercicioadesao"])){ 
        if(trim($this->si73_exercicioadesao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si73_exercicioadesao"])){ 
           $this->si73_exercicioadesao = "0" ; 
        } 
       $sql  .= $virgula." si73_exercicioadesao = $this->si73_exercicioadesao ";
       $virgula = ",";
     }
     if(trim($this->si73_nrolote)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_nrolote"])){ 
        if(trim($this->si73_nrolote)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si73_nrolote"])){ 
           $this->si73_nrolote = "0" ; 
        } 
       $sql  .= $virgula." si73_nrolote = $this->si73_nrolote ";
       $virgula = ",";
     }
     if(trim($this->si73_coditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_coditem"])){ 
        if(trim($this->si73_coditem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si73_coditem"])){ 
           $this->si73_coditem = "0" ; 
        } 
       $sql  .= $virgula." si73_coditem = $this->si73_coditem ";
       $virgula = ",";
     }
     if(trim($this->si73_percdesconto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_percdesconto"])){ 
        if(trim($this->si73_percdesconto)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si73_percdesconto"])){ 
           $this->si73_percdesconto = "0" ; 
        } 
       $sql  .= $virgula." si73_percdesconto = $this->si73_percdesconto ";
       $virgula = ",";
     }
     if(trim($this->si73_tipodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_tipodocumento"])){ 
        if(trim($this->si73_tipodocumento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si73_tipodocumento"])){ 
           $this->si73_tipodocumento = "0" ; 
        } 
       $sql  .= $virgula." si73_tipodocumento = $this->si73_tipodocumento ";
       $virgula = ",";
     }
     if(trim($this->si73_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_nrodocumento"])){ 
       $sql  .= $virgula." si73_nrodocumento = '$this->si73_nrodocumento' ";
       $virgula = ",";
     }
     if(trim($this->si73_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_mes"])){ 
       $sql  .= $virgula." si73_mes = $this->si73_mes ";
       $virgula = ",";
       if(trim($this->si73_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si73_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si73_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si73_instit"])){ 
       $sql  .= $virgula." si73_instit = $this->si73_instit ";
       $virgula = ",";
       if(trim($this->si73_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si73_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si73_sequencial!=null){
       $sql .= " si73_sequencial = $this->si73_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si73_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010243,'$this->si73_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_sequencial"]) || $this->si73_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010243,'".AddSlashes(pg_result($resaco,$conresaco,'si73_sequencial'))."','$this->si73_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_tiporegistro"]) || $this->si73_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010244,'".AddSlashes(pg_result($resaco,$conresaco,'si73_tiporegistro'))."','$this->si73_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_codorgao"]) || $this->si73_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010245,'".AddSlashes(pg_result($resaco,$conresaco,'si73_codorgao'))."','$this->si73_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_codunidadesub"]) || $this->si73_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010246,'".AddSlashes(pg_result($resaco,$conresaco,'si73_codunidadesub'))."','$this->si73_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_nroprocadesao"]) || $this->si73_nroprocadesao != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010247,'".AddSlashes(pg_result($resaco,$conresaco,'si73_nroprocadesao'))."','$this->si73_nroprocadesao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_exercicioadesao"]) || $this->si73_exercicioadesao != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2011316,'".AddSlashes(pg_result($resaco,$conresaco,'si73_exercicioadesao'))."','$this->si73_exercicioadesao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_nrolote"]) || $this->si73_nrolote != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010249,'".AddSlashes(pg_result($resaco,$conresaco,'si73_nrolote'))."','$this->si73_nrolote',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_coditem"]) || $this->si73_coditem != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010250,'".AddSlashes(pg_result($resaco,$conresaco,'si73_coditem'))."','$this->si73_coditem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_percdesconto"]) || $this->si73_percdesconto != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010251,'".AddSlashes(pg_result($resaco,$conresaco,'si73_percdesconto'))."','$this->si73_percdesconto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_tipodocumento"]) || $this->si73_tipodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010252,'".AddSlashes(pg_result($resaco,$conresaco,'si73_tipodocumento'))."','$this->si73_tipodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_nrodocumento"]) || $this->si73_nrodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010253,'".AddSlashes(pg_result($resaco,$conresaco,'si73_nrodocumento'))."','$this->si73_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_mes"]) || $this->si73_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2010254,'".AddSlashes(pg_result($resaco,$conresaco,'si73_mes'))."','$this->si73_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si73_instit"]) || $this->si73_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010302,2011585,'".AddSlashes(pg_result($resaco,$conresaco,'si73_instit'))."','$this->si73_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "regadesao202016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si73_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "regadesao202016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si73_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si73_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si73_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si73_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010243,'$si73_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010302,2010243,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010244,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010245,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010246,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010247,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_nroprocadesao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2011316,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_exercicioadesao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010249,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010250,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010251,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_percdesconto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010252,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010253,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2010254,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010302,2011585,'','".AddSlashes(pg_result($resaco,$iresaco,'si73_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from regadesao202016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si73_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si73_sequencial = $si73_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "regadesao202016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si73_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "regadesao202016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si73_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si73_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:regadesao202016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si73_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from regadesao202016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si73_sequencial!=null ){
         $sql2 .= " where regadesao202016.si73_sequencial = $si73_sequencial "; 
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
   function sql_query_file ( $si73_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from regadesao202016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si73_sequencial!=null ){
         $sql2 .= " where regadesao202016.si73_sequencial = $si73_sequencial "; 
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
