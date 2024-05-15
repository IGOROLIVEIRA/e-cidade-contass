<?
//MODULO: sicom
//CLASSE DA ENTIDADE ddc202015
class cl_ddc202015 { 
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
   var $si153_sequencial = 0; 
   var $si153_tiporegistro = 0; 
   var $si153_codorgao = null; 
   var $si153_nrocontratodivida = null; 
   var $si153_dtassinatura_dia = null; 
   var $si153_dtassinatura_mes = null; 
   var $si153_dtassinatura_ano = null; 
   var $si153_dtassinatura = null; 
   var $si153_contratodeclei = 0; 
   var $si153_nroleiautorizacao = null; 
   var $si153_dtleiautorizacao_dia = null; 
   var $si153_dtleiautorizacao_mes = null; 
   var $si153_dtleiautorizacao_ano = null; 
   var $si153_dtleiautorizacao = null; 
   var $si153_objetocontratodivida = null; 
   var $si153_especificacaocontratodivida = null; 
   var $si153_mes = 0; 
   var $si153_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si153_sequencial = int8 = sequencial 
                 si153_tiporegistro = int8 = Tipo do  registro 
                 si153_codorgao = varchar(2) = Código do órgão 
                 si153_nrocontratodivida = varchar(30) = Número do  Contrato de  Dívida 
                 si153_dtassinatura = date = Data da assinatura  do Contrato 
                 si153_contratodeclei = int8 = Contrato decorrente de Lei 
                 si153_nroleiautorizacao = varchar(6) = Número da Lei de  Autorização 
                 si153_dtleiautorizacao = date = Data da Lei de  Autorização 
                 si153_objetocontratodivida = varchar(1000) = Objeto do contrato 
                 si153_especificacaocontratodivida = varchar(500) = Descrição da  dívida  consolidada 
                 si153_mes = int8 = Mês 
                 si153_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ddc202015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ddc202015"); 
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
       $this->si153_sequencial = ($this->si153_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_sequencial"]:$this->si153_sequencial);
       $this->si153_tiporegistro = ($this->si153_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_tiporegistro"]:$this->si153_tiporegistro);
       $this->si153_codorgao = ($this->si153_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_codorgao"]:$this->si153_codorgao);
       $this->si153_nrocontratodivida = ($this->si153_nrocontratodivida == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_nrocontratodivida"]:$this->si153_nrocontratodivida);
       if($this->si153_dtassinatura == ""){
         $this->si153_dtassinatura_dia = ($this->si153_dtassinatura_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_dtassinatura_dia"]:$this->si153_dtassinatura_dia);
         $this->si153_dtassinatura_mes = ($this->si153_dtassinatura_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_dtassinatura_mes"]:$this->si153_dtassinatura_mes);
         $this->si153_dtassinatura_ano = ($this->si153_dtassinatura_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_dtassinatura_ano"]:$this->si153_dtassinatura_ano);
         if($this->si153_dtassinatura_dia != ""){
            $this->si153_dtassinatura = $this->si153_dtassinatura_ano."-".$this->si153_dtassinatura_mes."-".$this->si153_dtassinatura_dia;
         }
       }
       $this->si153_contratodeclei = ($this->si153_contratodeclei == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_contratodeclei"]:$this->si153_contratodeclei);
       $this->si153_nroleiautorizacao = ($this->si153_nroleiautorizacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_nroleiautorizacao"]:$this->si153_nroleiautorizacao);
       if($this->si153_dtleiautorizacao == ""){
         $this->si153_dtleiautorizacao_dia = ($this->si153_dtleiautorizacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_dtleiautorizacao_dia"]:$this->si153_dtleiautorizacao_dia);
         $this->si153_dtleiautorizacao_mes = ($this->si153_dtleiautorizacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_dtleiautorizacao_mes"]:$this->si153_dtleiautorizacao_mes);
         $this->si153_dtleiautorizacao_ano = ($this->si153_dtleiautorizacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_dtleiautorizacao_ano"]:$this->si153_dtleiautorizacao_ano);
         if($this->si153_dtleiautorizacao_dia != ""){
            $this->si153_dtleiautorizacao = $this->si153_dtleiautorizacao_ano."-".$this->si153_dtleiautorizacao_mes."-".$this->si153_dtleiautorizacao_dia;
         }
       }
       $this->si153_objetocontratodivida = ($this->si153_objetocontratodivida == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_objetocontratodivida"]:$this->si153_objetocontratodivida);
       $this->si153_especificacaocontratodivida = ($this->si153_especificacaocontratodivida == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_especificacaocontratodivida"]:$this->si153_especificacaocontratodivida);
       $this->si153_mes = ($this->si153_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_mes"]:$this->si153_mes);
       $this->si153_instit = ($this->si153_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_instit"]:$this->si153_instit);
     }else{
       $this->si153_sequencial = ($this->si153_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si153_sequencial"]:$this->si153_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si153_sequencial){ 
      $this->atualizacampos();
     if($this->si153_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si153_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si153_dtassinatura == null ){ 
       $this->si153_dtassinatura = "null";
     }
     if($this->si153_contratodeclei == null ){ 
       $this->si153_contratodeclei = "0";
     }
     if($this->si153_dtleiautorizacao == null ){ 
       $this->si153_dtleiautorizacao = "null";
     }
     if($this->si153_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si153_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si153_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si153_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si153_sequencial == "" || $si153_sequencial == null ){
       $result = db_query("select nextval('ddc202015_si153_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ddc202015_si153_sequencial_seq do campo: si153_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si153_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ddc202015_si153_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si153_sequencial)){
         $this->erro_sql = " Campo si153_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si153_sequencial = $si153_sequencial; 
       }
     }
     if(($this->si153_sequencial == null) || ($this->si153_sequencial == "") ){ 
       $this->erro_sql = " Campo si153_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ddc202015(
                                       si153_sequencial 
                                      ,si153_tiporegistro 
                                      ,si153_codorgao 
                                      ,si153_nrocontratodivida 
                                      ,si153_dtassinatura 
                                      ,si153_contratodeclei 
                                      ,si153_nroleiautorizacao 
                                      ,si153_dtleiautorizacao 
                                      ,si153_objetocontratodivida 
                                      ,si153_especificacaocontratodivida 
                                      ,si153_mes 
                                      ,si153_instit 
                       )
                values (
                                $this->si153_sequencial 
                               ,$this->si153_tiporegistro 
                               ,'$this->si153_codorgao' 
                               ,'$this->si153_nrocontratodivida' 
                               ,".($this->si153_dtassinatura == "null" || $this->si153_dtassinatura == ""?"null":"'".$this->si153_dtassinatura."'")." 
                               ,$this->si153_contratodeclei 
                               ,'$this->si153_nroleiautorizacao' 
                               ,".($this->si153_dtleiautorizacao == "null" || $this->si153_dtleiautorizacao == ""?"null":"'".$this->si153_dtleiautorizacao."'")." 
                               ,'$this->si153_objetocontratodivida' 
                               ,'$this->si153_especificacaocontratodivida' 
                               ,$this->si153_mes 
                               ,$this->si153_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ddc202015 ($this->si153_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ddc202015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ddc202015 ($this->si153_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si153_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si153_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011168,'$this->si153_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010382,2011168,'','".AddSlashes(pg_result($resaco,0,'si153_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011169,'','".AddSlashes(pg_result($resaco,0,'si153_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011369,'','".AddSlashes(pg_result($resaco,0,'si153_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011370,'','".AddSlashes(pg_result($resaco,0,'si153_nrocontratodivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011371,'','".AddSlashes(pg_result($resaco,0,'si153_dtassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011170,'','".AddSlashes(pg_result($resaco,0,'si153_contratodeclei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011171,'','".AddSlashes(pg_result($resaco,0,'si153_nroleiautorizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011172,'','".AddSlashes(pg_result($resaco,0,'si153_dtleiautorizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011372,'','".AddSlashes(pg_result($resaco,0,'si153_objetocontratodivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011373,'','".AddSlashes(pg_result($resaco,0,'si153_especificacaocontratodivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011173,'','".AddSlashes(pg_result($resaco,0,'si153_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010382,2011666,'','".AddSlashes(pg_result($resaco,0,'si153_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si153_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ddc202015 set ";
     $virgula = "";
     if(trim($this->si153_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_sequencial"])){ 
        if(trim($this->si153_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si153_sequencial"])){ 
           $this->si153_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si153_sequencial = $this->si153_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si153_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_tiporegistro"])){ 
       $sql  .= $virgula." si153_tiporegistro = $this->si153_tiporegistro ";
       $virgula = ",";
       if(trim($this->si153_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si153_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si153_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_codorgao"])){ 
       $sql  .= $virgula." si153_codorgao = '$this->si153_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si153_nrocontratodivida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_nrocontratodivida"])){ 
       $sql  .= $virgula." si153_nrocontratodivida = '$this->si153_nrocontratodivida' ";
       $virgula = ",";
     }
     if(trim($this->si153_dtassinatura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_dtassinatura_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si153_dtassinatura_dia"] !="") ){ 
       $sql  .= $virgula." si153_dtassinatura = '$this->si153_dtassinatura' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si153_dtassinatura_dia"])){ 
         $sql  .= $virgula." si153_dtassinatura = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si153_contratodeclei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_contratodeclei"])){ 
        if(trim($this->si153_contratodeclei)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si153_contratodeclei"])){ 
           $this->si153_contratodeclei = "0" ; 
        } 
       $sql  .= $virgula." si153_contratodeclei = $this->si153_contratodeclei ";
       $virgula = ",";
     }
     if(trim($this->si153_nroleiautorizacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_nroleiautorizacao"])){ 
       $sql  .= $virgula." si153_nroleiautorizacao = '$this->si153_nroleiautorizacao' ";
       $virgula = ",";
     }
     if(trim($this->si153_dtleiautorizacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_dtleiautorizacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si153_dtleiautorizacao_dia"] !="") ){ 
       $sql  .= $virgula." si153_dtleiautorizacao = '$this->si153_dtleiautorizacao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si153_dtleiautorizacao_dia"])){ 
         $sql  .= $virgula." si153_dtleiautorizacao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si153_objetocontratodivida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_objetocontratodivida"])){ 
       $sql  .= $virgula." si153_objetocontratodivida = '$this->si153_objetocontratodivida' ";
       $virgula = ",";
     }
     if(trim($this->si153_especificacaocontratodivida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_especificacaocontratodivida"])){ 
       $sql  .= $virgula." si153_especificacaocontratodivida = '$this->si153_especificacaocontratodivida' ";
       $virgula = ",";
     }
     if(trim($this->si153_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_mes"])){ 
       $sql  .= $virgula." si153_mes = $this->si153_mes ";
       $virgula = ",";
       if(trim($this->si153_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si153_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si153_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si153_instit"])){ 
       $sql  .= $virgula." si153_instit = $this->si153_instit ";
       $virgula = ",";
       if(trim($this->si153_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si153_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si153_sequencial!=null){
       $sql .= " si153_sequencial = $this->si153_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si153_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011168,'$this->si153_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_sequencial"]) || $this->si153_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011168,'".AddSlashes(pg_result($resaco,$conresaco,'si153_sequencial'))."','$this->si153_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_tiporegistro"]) || $this->si153_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011169,'".AddSlashes(pg_result($resaco,$conresaco,'si153_tiporegistro'))."','$this->si153_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_codorgao"]) || $this->si153_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011369,'".AddSlashes(pg_result($resaco,$conresaco,'si153_codorgao'))."','$this->si153_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_nrocontratodivida"]) || $this->si153_nrocontratodivida != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011370,'".AddSlashes(pg_result($resaco,$conresaco,'si153_nrocontratodivida'))."','$this->si153_nrocontratodivida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_dtassinatura"]) || $this->si153_dtassinatura != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011371,'".AddSlashes(pg_result($resaco,$conresaco,'si153_dtassinatura'))."','$this->si153_dtassinatura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_contratodeclei"]) || $this->si153_contratodeclei != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011170,'".AddSlashes(pg_result($resaco,$conresaco,'si153_contratodeclei'))."','$this->si153_contratodeclei',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_nroleiautorizacao"]) || $this->si153_nroleiautorizacao != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011171,'".AddSlashes(pg_result($resaco,$conresaco,'si153_nroleiautorizacao'))."','$this->si153_nroleiautorizacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_dtleiautorizacao"]) || $this->si153_dtleiautorizacao != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011172,'".AddSlashes(pg_result($resaco,$conresaco,'si153_dtleiautorizacao'))."','$this->si153_dtleiautorizacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_objetocontratodivida"]) || $this->si153_objetocontratodivida != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011372,'".AddSlashes(pg_result($resaco,$conresaco,'si153_objetocontratodivida'))."','$this->si153_objetocontratodivida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_especificacaocontratodivida"]) || $this->si153_especificacaocontratodivida != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011373,'".AddSlashes(pg_result($resaco,$conresaco,'si153_especificacaocontratodivida'))."','$this->si153_especificacaocontratodivida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_mes"]) || $this->si153_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011173,'".AddSlashes(pg_result($resaco,$conresaco,'si153_mes'))."','$this->si153_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si153_instit"]) || $this->si153_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010382,2011666,'".AddSlashes(pg_result($resaco,$conresaco,'si153_instit'))."','$this->si153_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ddc202015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si153_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ddc202015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si153_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si153_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si153_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si153_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011168,'$si153_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010382,2011168,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011169,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011369,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011370,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_nrocontratodivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011371,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_dtassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011170,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_contratodeclei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011171,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_nroleiautorizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011172,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_dtleiautorizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011372,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_objetocontratodivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011373,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_especificacaocontratodivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011173,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010382,2011666,'','".AddSlashes(pg_result($resaco,$iresaco,'si153_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ddc202015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si153_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si153_sequencial = $si153_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ddc202015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si153_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ddc202015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si153_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si153_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ddc202015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si153_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ddc202015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si153_sequencial!=null ){
         $sql2 .= " where ddc202015.si153_sequencial = $si153_sequencial "; 
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
   function sql_query_file ( $si153_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ddc202015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si153_sequencial!=null ){
         $sql2 .= " where ddc202015.si153_sequencial = $si153_sequencial "; 
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
