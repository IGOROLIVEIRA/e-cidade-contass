<?
//MODULO: sicom
//CLASSE DA ENTIDADE ddc112014
class cl_ddc112014 { 
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
   var $si151_sequencial = 0; 
   var $si151_tiporegistro = 0; 
   var $si151_codcontrato = 0; 
   var $si151_codorgao = null; 
   var $si151_nrocontratodivida = 0; 
   var $si151_dataassinatura_dia = null; 
   var $si151_dataassinatura_mes = null; 
   var $si151_dataassinatura_ano = null; 
   var $si151_dataassinatura = null; 
   var $si151_tipolancamento = null; 
   var $si151_objetocontrato = null; 
   var $si151_mes = 0; 
   var $si151_reg10 = 0; 
   var $si151_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si151_sequencial = int8 = sequencial 
                 si151_tiporegistro = int8 = Tipo do  registro 
                 si151_codcontrato = int8 = Código do contrato 
                 si151_codorgao = varchar(2) = Código do órgão 
                 si151_nrocontratodivida = int8 = Número do  Contrato 
                 si151_dataassinatura = date = Data da assinatura  do Contrato 
                 si151_tipolancamento = varchar(2) = Tipo de  Lançamento 
                 si151_objetocontrato = varchar(500) = Objeto do contrato 
                 si151_mes = int8 = Mês 
                 si151_reg10 = int8 = reg10 
                 si151_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ddc112014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ddc112014"); 
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
       $this->si151_sequencial = ($this->si151_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_sequencial"]:$this->si151_sequencial);
       $this->si151_tiporegistro = ($this->si151_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_tiporegistro"]:$this->si151_tiporegistro);
       $this->si151_codcontrato = ($this->si151_codcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_codcontrato"]:$this->si151_codcontrato);
       $this->si151_codorgao = ($this->si151_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_codorgao"]:$this->si151_codorgao);
       $this->si151_nrocontratodivida = ($this->si151_nrocontratodivida == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_nrocontratodivida"]:$this->si151_nrocontratodivida);
       if($this->si151_dataassinatura == ""){
         $this->si151_dataassinatura_dia = ($this->si151_dataassinatura_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_dataassinatura_dia"]:$this->si151_dataassinatura_dia);
         $this->si151_dataassinatura_mes = ($this->si151_dataassinatura_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_dataassinatura_mes"]:$this->si151_dataassinatura_mes);
         $this->si151_dataassinatura_ano = ($this->si151_dataassinatura_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_dataassinatura_ano"]:$this->si151_dataassinatura_ano);
         if($this->si151_dataassinatura_dia != ""){
            $this->si151_dataassinatura = $this->si151_dataassinatura_ano."-".$this->si151_dataassinatura_mes."-".$this->si151_dataassinatura_dia;
         }
       }
       $this->si151_tipolancamento = ($this->si151_tipolancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_tipolancamento"]:$this->si151_tipolancamento);
       $this->si151_objetocontrato = ($this->si151_objetocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_objetocontrato"]:$this->si151_objetocontrato);
       $this->si151_mes = ($this->si151_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_mes"]:$this->si151_mes);
       $this->si151_reg10 = ($this->si151_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_reg10"]:$this->si151_reg10);
       $this->si151_instit = ($this->si151_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_instit"]:$this->si151_instit);
     }else{
       $this->si151_sequencial = ($this->si151_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si151_sequencial"]:$this->si151_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si151_sequencial){ 
      $this->atualizacampos();
     if($this->si151_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si151_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si151_codcontrato == null ){ 
       $this->si151_codcontrato = "0";
     }
     if($this->si151_nrocontratodivida == null ){ 
       $this->si151_nrocontratodivida = "0";
     }
     if($this->si151_dataassinatura == null ){ 
       $this->si151_dataassinatura = "null";
     }
     if($this->si151_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si151_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si151_reg10 == null ){ 
       $this->si151_reg10 = "0";
     }
     if($this->si151_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si151_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si151_sequencial == "" || $si151_sequencial == null ){
       $result = db_query("select nextval('ddc112014_si151_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ddc112014_si151_sequencial_seq do campo: si151_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si151_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ddc112014_si151_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si151_sequencial)){
         $this->erro_sql = " Campo si151_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si151_sequencial = $si151_sequencial; 
       }
     }
     if(($this->si151_sequencial == null) || ($this->si151_sequencial == "") ){ 
       $this->erro_sql = " Campo si151_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ddc112014(
                                       si151_sequencial 
                                      ,si151_tiporegistro 
                                      ,si151_codcontrato 
                                      ,si151_codorgao 
                                      ,si151_nrocontratodivida 
                                      ,si151_dataassinatura 
                                      ,si151_tipolancamento 
                                      ,si151_objetocontrato 
                                      ,si151_mes 
                                      ,si151_reg10 
                                      ,si151_instit 
                       )
                values (
                                $this->si151_sequencial 
                               ,$this->si151_tiporegistro 
                               ,$this->si151_codcontrato 
                               ,'$this->si151_codorgao' 
                               ,$this->si151_nrocontratodivida 
                               ,".($this->si151_dataassinatura == "null" || $this->si151_dataassinatura == ""?"null":"'".$this->si151_dataassinatura."'")." 
                               ,'$this->si151_tipolancamento' 
                               ,'$this->si151_objetocontrato' 
                               ,$this->si151_mes 
                               ,$this->si151_reg10 
                               ,$this->si151_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ddc112014 ($this->si151_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ddc112014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ddc112014 ($this->si151_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si151_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si151_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011151,'$this->si151_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010380,2011151,'','".AddSlashes(pg_result($resaco,0,'si151_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011152,'','".AddSlashes(pg_result($resaco,0,'si151_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011153,'','".AddSlashes(pg_result($resaco,0,'si151_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011154,'','".AddSlashes(pg_result($resaco,0,'si151_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011155,'','".AddSlashes(pg_result($resaco,0,'si151_nrocontratodivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011156,'','".AddSlashes(pg_result($resaco,0,'si151_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011157,'','".AddSlashes(pg_result($resaco,0,'si151_tipolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011158,'','".AddSlashes(pg_result($resaco,0,'si151_objetocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011159,'','".AddSlashes(pg_result($resaco,0,'si151_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011160,'','".AddSlashes(pg_result($resaco,0,'si151_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010380,2011664,'','".AddSlashes(pg_result($resaco,0,'si151_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si151_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ddc112014 set ";
     $virgula = "";
     if(trim($this->si151_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_sequencial"])){ 
        if(trim($this->si151_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si151_sequencial"])){ 
           $this->si151_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si151_sequencial = $this->si151_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si151_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_tiporegistro"])){ 
       $sql  .= $virgula." si151_tiporegistro = $this->si151_tiporegistro ";
       $virgula = ",";
       if(trim($this->si151_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si151_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si151_codcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_codcontrato"])){ 
        if(trim($this->si151_codcontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si151_codcontrato"])){ 
           $this->si151_codcontrato = "0" ; 
        } 
       $sql  .= $virgula." si151_codcontrato = $this->si151_codcontrato ";
       $virgula = ",";
     }
     if(trim($this->si151_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_codorgao"])){ 
       $sql  .= $virgula." si151_codorgao = '$this->si151_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si151_nrocontratodivida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_nrocontratodivida"])){ 
        if(trim($this->si151_nrocontratodivida)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si151_nrocontratodivida"])){ 
           $this->si151_nrocontratodivida = "0" ; 
        } 
       $sql  .= $virgula." si151_nrocontratodivida = $this->si151_nrocontratodivida ";
       $virgula = ",";
     }
     if(trim($this->si151_dataassinatura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_dataassinatura_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si151_dataassinatura_dia"] !="") ){ 
       $sql  .= $virgula." si151_dataassinatura = '$this->si151_dataassinatura' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si151_dataassinatura_dia"])){ 
         $sql  .= $virgula." si151_dataassinatura = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si151_tipolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_tipolancamento"])){ 
       $sql  .= $virgula." si151_tipolancamento = '$this->si151_tipolancamento' ";
       $virgula = ",";
     }
     if(trim($this->si151_objetocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_objetocontrato"])){ 
       $sql  .= $virgula." si151_objetocontrato = '$this->si151_objetocontrato' ";
       $virgula = ",";
     }
     if(trim($this->si151_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_mes"])){ 
       $sql  .= $virgula." si151_mes = $this->si151_mes ";
       $virgula = ",";
       if(trim($this->si151_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si151_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si151_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_reg10"])){ 
        if(trim($this->si151_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si151_reg10"])){ 
           $this->si151_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si151_reg10 = $this->si151_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si151_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si151_instit"])){ 
       $sql  .= $virgula." si151_instit = $this->si151_instit ";
       $virgula = ",";
       if(trim($this->si151_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si151_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si151_sequencial!=null){
       $sql .= " si151_sequencial = $this->si151_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si151_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011151,'$this->si151_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_sequencial"]) || $this->si151_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011151,'".AddSlashes(pg_result($resaco,$conresaco,'si151_sequencial'))."','$this->si151_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_tiporegistro"]) || $this->si151_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011152,'".AddSlashes(pg_result($resaco,$conresaco,'si151_tiporegistro'))."','$this->si151_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_codcontrato"]) || $this->si151_codcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011153,'".AddSlashes(pg_result($resaco,$conresaco,'si151_codcontrato'))."','$this->si151_codcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_codorgao"]) || $this->si151_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011154,'".AddSlashes(pg_result($resaco,$conresaco,'si151_codorgao'))."','$this->si151_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_nrocontratodivida"]) || $this->si151_nrocontratodivida != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011155,'".AddSlashes(pg_result($resaco,$conresaco,'si151_nrocontratodivida'))."','$this->si151_nrocontratodivida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_dataassinatura"]) || $this->si151_dataassinatura != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011156,'".AddSlashes(pg_result($resaco,$conresaco,'si151_dataassinatura'))."','$this->si151_dataassinatura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_tipolancamento"]) || $this->si151_tipolancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011157,'".AddSlashes(pg_result($resaco,$conresaco,'si151_tipolancamento'))."','$this->si151_tipolancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_objetocontrato"]) || $this->si151_objetocontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011158,'".AddSlashes(pg_result($resaco,$conresaco,'si151_objetocontrato'))."','$this->si151_objetocontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_mes"]) || $this->si151_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011159,'".AddSlashes(pg_result($resaco,$conresaco,'si151_mes'))."','$this->si151_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_reg10"]) || $this->si151_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011160,'".AddSlashes(pg_result($resaco,$conresaco,'si151_reg10'))."','$this->si151_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si151_instit"]) || $this->si151_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010380,2011664,'".AddSlashes(pg_result($resaco,$conresaco,'si151_instit'))."','$this->si151_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ddc112014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si151_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ddc112014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si151_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si151_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si151_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si151_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011151,'$si151_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010380,2011151,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011152,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011153,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011154,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011155,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_nrocontratodivida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011156,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011157,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_tipolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011158,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_objetocontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011159,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011160,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010380,2011664,'','".AddSlashes(pg_result($resaco,$iresaco,'si151_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ddc112014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si151_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si151_sequencial = $si151_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ddc112014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si151_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ddc112014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si151_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si151_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ddc112014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si151_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ddc112014 ";
     $sql .= "      left  join ddc102014  on  ddc102014.si150_sequencial = ddc112014.si151_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si151_sequencial!=null ){
         $sql2 .= " where ddc112014.si151_sequencial = $si151_sequencial "; 
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
   function sql_query_file ( $si151_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ddc112014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si151_sequencial!=null ){
         $sql2 .= " where ddc112014.si151_sequencial = $si151_sequencial "; 
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
