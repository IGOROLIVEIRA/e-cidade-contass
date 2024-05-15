<?
//MODULO: sicom
//CLASSE DA ENTIDADE julglic102014
class cl_julglic102014 { 
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
   var $si60_sequencial = 0; 
   var $si60_tiporegistro = 0; 
   var $si60_codorgao = null; 
   var $si60_codunidadesub = null; 
   var $si60_exerciciolicitacao = 0; 
   var $si60_nroprocessolicitatorio = null; 
   var $si60_tipodocumento = 0; 
   var $si60_nrodocumento = null; 
   var $si60_nrolote = 0; 
   var $si60_coditem = 0; 
   var $si60_vlunitario = 0; 
   var $si60_quantidade = 0; 
   var $si60_mes = 0; 
   var $si60_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si60_sequencial = int8 = sequencial 
                 si60_tiporegistro = int8 = Tipo do  registro 
                 si60_codorgao = varchar(2) = Código do órgão 
                 si60_codunidadesub = varchar(8) = Código da unidade 
                 si60_exerciciolicitacao = int8 = Exercício em que   foi instaurado 
                 si60_nroprocessolicitatorio = varchar(12) = Número sequencial do processo 
                 si60_tipodocumento = int8 = Tipo de documento 
                 si60_nrodocumento = varchar(14) = Número do  documento 
                 si60_nrolote = int8 = Número do lote  licitado 
                 si60_coditem = int8 = Código do item  licitado 
                 si60_vlunitario = float8 = Valor unitário do  item 
                 si60_quantidade = float8 = Quantidade do item 
                 si60_mes = int8 = Mês 
                 si60_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_julglic102014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("julglic102014"); 
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
       $this->si60_sequencial = ($this->si60_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_sequencial"]:$this->si60_sequencial);
       $this->si60_tiporegistro = ($this->si60_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_tiporegistro"]:$this->si60_tiporegistro);
       $this->si60_codorgao = ($this->si60_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_codorgao"]:$this->si60_codorgao);
       $this->si60_codunidadesub = ($this->si60_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_codunidadesub"]:$this->si60_codunidadesub);
       $this->si60_exerciciolicitacao = ($this->si60_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_exerciciolicitacao"]:$this->si60_exerciciolicitacao);
       $this->si60_nroprocessolicitatorio = ($this->si60_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_nroprocessolicitatorio"]:$this->si60_nroprocessolicitatorio);
       $this->si60_tipodocumento = ($this->si60_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_tipodocumento"]:$this->si60_tipodocumento);
       $this->si60_nrodocumento = ($this->si60_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_nrodocumento"]:$this->si60_nrodocumento);
       $this->si60_nrolote = ($this->si60_nrolote == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_nrolote"]:$this->si60_nrolote);
       $this->si60_coditem = ($this->si60_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_coditem"]:$this->si60_coditem);
       $this->si60_vlunitario = ($this->si60_vlunitario == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_vlunitario"]:$this->si60_vlunitario);
       $this->si60_quantidade = ($this->si60_quantidade == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_quantidade"]:$this->si60_quantidade);
       $this->si60_mes = ($this->si60_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_mes"]:$this->si60_mes);
       $this->si60_instit = ($this->si60_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_instit"]:$this->si60_instit);
     }else{
       $this->si60_sequencial = ($this->si60_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si60_sequencial"]:$this->si60_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si60_sequencial){ 
      $this->atualizacampos();
     if($this->si60_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si60_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si60_exerciciolicitacao == null ){ 
       $this->si60_exerciciolicitacao = "0";
     }
     if($this->si60_tipodocumento == null ){ 
       $this->si60_tipodocumento = "0";
     }
     if($this->si60_nrolote == null ){ 
       $this->si60_nrolote = "0";
     }
     if($this->si60_coditem == null ){ 
       $this->si60_coditem = "0";
     }
     if($this->si60_vlunitario == null ){ 
       $this->si60_vlunitario = "0";
     }
     if($this->si60_quantidade == null ){ 
       $this->si60_quantidade = "0";
     }
     if($this->si60_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si60_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si60_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si60_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si60_sequencial == "" || $si60_sequencial == null ){
       $result = db_query("select nextval('julglic102014_si60_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: julglic102014_si60_sequencial_seq do campo: si60_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si60_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from julglic102014_si60_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si60_sequencial)){
         $this->erro_sql = " Campo si60_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si60_sequencial = $si60_sequencial; 
       }
     }
     if(($this->si60_sequencial == null) || ($this->si60_sequencial == "") ){ 
       $this->erro_sql = " Campo si60_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into julglic102014(
                                       si60_sequencial 
                                      ,si60_tiporegistro 
                                      ,si60_codorgao 
                                      ,si60_codunidadesub 
                                      ,si60_exerciciolicitacao 
                                      ,si60_nroprocessolicitatorio 
                                      ,si60_tipodocumento 
                                      ,si60_nrodocumento 
                                      ,si60_nrolote 
                                      ,si60_coditem 
                                      ,si60_vlunitario 
                                      ,si60_quantidade 
                                      ,si60_mes 
                                      ,si60_instit 
                       )
                values (
                                $this->si60_sequencial 
                               ,$this->si60_tiporegistro 
                               ,'$this->si60_codorgao' 
                               ,'$this->si60_codunidadesub' 
                               ,$this->si60_exerciciolicitacao 
                               ,'$this->si60_nroprocessolicitatorio' 
                               ,$this->si60_tipodocumento 
                               ,'$this->si60_nrodocumento' 
                               ,$this->si60_nrolote 
                               ,$this->si60_coditem 
                               ,$this->si60_vlunitario 
                               ,$this->si60_quantidade 
                               ,$this->si60_mes 
                               ,$this->si60_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "julglic102014 ($this->si60_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "julglic102014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "julglic102014 ($this->si60_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si60_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si60_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010084,'$this->si60_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010289,2010084,'','".AddSlashes(pg_result($resaco,0,'si60_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010085,'','".AddSlashes(pg_result($resaco,0,'si60_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010086,'','".AddSlashes(pg_result($resaco,0,'si60_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010087,'','".AddSlashes(pg_result($resaco,0,'si60_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010088,'','".AddSlashes(pg_result($resaco,0,'si60_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010089,'','".AddSlashes(pg_result($resaco,0,'si60_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010090,'','".AddSlashes(pg_result($resaco,0,'si60_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010091,'','".AddSlashes(pg_result($resaco,0,'si60_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010092,'','".AddSlashes(pg_result($resaco,0,'si60_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010093,'','".AddSlashes(pg_result($resaco,0,'si60_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010094,'','".AddSlashes(pg_result($resaco,0,'si60_vlunitario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010095,'','".AddSlashes(pg_result($resaco,0,'si60_quantidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2010096,'','".AddSlashes(pg_result($resaco,0,'si60_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010289,2011572,'','".AddSlashes(pg_result($resaco,0,'si60_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si60_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update julglic102014 set ";
     $virgula = "";
     if(trim($this->si60_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_sequencial"])){ 
        if(trim($this->si60_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si60_sequencial"])){ 
           $this->si60_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si60_sequencial = $this->si60_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si60_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_tiporegistro"])){ 
       $sql  .= $virgula." si60_tiporegistro = $this->si60_tiporegistro ";
       $virgula = ",";
       if(trim($this->si60_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si60_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si60_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_codorgao"])){ 
       $sql  .= $virgula." si60_codorgao = '$this->si60_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si60_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_codunidadesub"])){ 
       $sql  .= $virgula." si60_codunidadesub = '$this->si60_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si60_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_exerciciolicitacao"])){ 
        if(trim($this->si60_exerciciolicitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si60_exerciciolicitacao"])){ 
           $this->si60_exerciciolicitacao = "0" ; 
        } 
       $sql  .= $virgula." si60_exerciciolicitacao = $this->si60_exerciciolicitacao ";
       $virgula = ",";
     }
     if(trim($this->si60_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_nroprocessolicitatorio"])){ 
       $sql  .= $virgula." si60_nroprocessolicitatorio = '$this->si60_nroprocessolicitatorio' ";
       $virgula = ",";
     }
     if(trim($this->si60_tipodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_tipodocumento"])){ 
        if(trim($this->si60_tipodocumento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si60_tipodocumento"])){ 
           $this->si60_tipodocumento = "0" ; 
        } 
       $sql  .= $virgula." si60_tipodocumento = $this->si60_tipodocumento ";
       $virgula = ",";
     }
     if(trim($this->si60_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_nrodocumento"])){ 
       $sql  .= $virgula." si60_nrodocumento = '$this->si60_nrodocumento' ";
       $virgula = ",";
     }
     if(trim($this->si60_nrolote)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_nrolote"])){ 
        if(trim($this->si60_nrolote)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si60_nrolote"])){ 
           $this->si60_nrolote = "0" ; 
        } 
       $sql  .= $virgula." si60_nrolote = $this->si60_nrolote ";
       $virgula = ",";
     }
     if(trim($this->si60_coditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_coditem"])){ 
        if(trim($this->si60_coditem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si60_coditem"])){ 
           $this->si60_coditem = "0" ; 
        } 
       $sql  .= $virgula." si60_coditem = $this->si60_coditem ";
       $virgula = ",";
     }
     if(trim($this->si60_vlunitario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_vlunitario"])){ 
        if(trim($this->si60_vlunitario)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si60_vlunitario"])){ 
           $this->si60_vlunitario = "0" ; 
        } 
       $sql  .= $virgula." si60_vlunitario = $this->si60_vlunitario ";
       $virgula = ",";
     }
     if(trim($this->si60_quantidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_quantidade"])){ 
        if(trim($this->si60_quantidade)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si60_quantidade"])){ 
           $this->si60_quantidade = "0" ; 
        } 
       $sql  .= $virgula." si60_quantidade = $this->si60_quantidade ";
       $virgula = ",";
     }
     if(trim($this->si60_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_mes"])){ 
       $sql  .= $virgula." si60_mes = $this->si60_mes ";
       $virgula = ",";
       if(trim($this->si60_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si60_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si60_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si60_instit"])){ 
       $sql  .= $virgula." si60_instit = $this->si60_instit ";
       $virgula = ",";
       if(trim($this->si60_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si60_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si60_sequencial!=null){
       $sql .= " si60_sequencial = $this->si60_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si60_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010084,'$this->si60_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_sequencial"]) || $this->si60_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010084,'".AddSlashes(pg_result($resaco,$conresaco,'si60_sequencial'))."','$this->si60_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_tiporegistro"]) || $this->si60_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010085,'".AddSlashes(pg_result($resaco,$conresaco,'si60_tiporegistro'))."','$this->si60_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_codorgao"]) || $this->si60_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010086,'".AddSlashes(pg_result($resaco,$conresaco,'si60_codorgao'))."','$this->si60_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_codunidadesub"]) || $this->si60_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010087,'".AddSlashes(pg_result($resaco,$conresaco,'si60_codunidadesub'))."','$this->si60_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_exerciciolicitacao"]) || $this->si60_exerciciolicitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010088,'".AddSlashes(pg_result($resaco,$conresaco,'si60_exerciciolicitacao'))."','$this->si60_exerciciolicitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_nroprocessolicitatorio"]) || $this->si60_nroprocessolicitatorio != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010089,'".AddSlashes(pg_result($resaco,$conresaco,'si60_nroprocessolicitatorio'))."','$this->si60_nroprocessolicitatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_tipodocumento"]) || $this->si60_tipodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010090,'".AddSlashes(pg_result($resaco,$conresaco,'si60_tipodocumento'))."','$this->si60_tipodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_nrodocumento"]) || $this->si60_nrodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010091,'".AddSlashes(pg_result($resaco,$conresaco,'si60_nrodocumento'))."','$this->si60_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_nrolote"]) || $this->si60_nrolote != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010092,'".AddSlashes(pg_result($resaco,$conresaco,'si60_nrolote'))."','$this->si60_nrolote',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_coditem"]) || $this->si60_coditem != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010093,'".AddSlashes(pg_result($resaco,$conresaco,'si60_coditem'))."','$this->si60_coditem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_vlunitario"]) || $this->si60_vlunitario != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010094,'".AddSlashes(pg_result($resaco,$conresaco,'si60_vlunitario'))."','$this->si60_vlunitario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_quantidade"]) || $this->si60_quantidade != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010095,'".AddSlashes(pg_result($resaco,$conresaco,'si60_quantidade'))."','$this->si60_quantidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_mes"]) || $this->si60_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2010096,'".AddSlashes(pg_result($resaco,$conresaco,'si60_mes'))."','$this->si60_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si60_instit"]) || $this->si60_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010289,2011572,'".AddSlashes(pg_result($resaco,$conresaco,'si60_instit'))."','$this->si60_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "julglic102014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si60_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "julglic102014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si60_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si60_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si60_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si60_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010084,'$si60_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010289,2010084,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010085,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010086,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010087,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010088,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010089,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010090,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_tipodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010091,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010092,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_nrolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010093,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010094,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_vlunitario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010095,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_quantidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2010096,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010289,2011572,'','".AddSlashes(pg_result($resaco,$iresaco,'si60_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from julglic102014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si60_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si60_sequencial = $si60_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "julglic102014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si60_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "julglic102014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si60_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si60_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:julglic102014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si60_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from julglic102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si60_sequencial!=null ){
         $sql2 .= " where julglic102014.si60_sequencial = $si60_sequencial "; 
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
   function sql_query_file ( $si60_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from julglic102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si60_sequencial!=null ){
         $sql2 .= " where julglic102014.si60_sequencial = $si60_sequencial "; 
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
