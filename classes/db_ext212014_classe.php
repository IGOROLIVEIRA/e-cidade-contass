<?
//MODULO: sicom
//CLASSE DA ENTIDADE ext212014
class cl_ext212014 { 
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
   var $si125_sequencial = 0; 
   var $si125_tiporegistro = 0; 
   var $si125_codreduzidomov = 0; 
   var $si125_codext = 0; 
   var $si125_codfontrecursos = 0; 
   var $si125_categoria = 0; 
   var $si125_dtlancamento_dia = null; 
   var $si125_dtlancamento_mes = null; 
   var $si125_dtlancamento_ano = null; 
   var $si125_dtlancamento = null; 
   var $si125_vllancamento = 0; 
   var $si125_mes = 0; 
   var $si125_reg20 = 0; 
   var $si125_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si125_sequencial = int8 = sequencial 
                 si125_tiporegistro = int8 = Tipo do  registro 
                 si125_codreduzidomov = int8 = Código ident desp extraorçamentária 
                 si125_codext = int8 = Código  identificador 
                 si125_codfontrecursos = int8 = Código da fonte de recursos 
                 si125_categoria = int8 = Categoria que está sendo informada 
                 si125_dtlancamento = date = Data do  Lançamento 
                 si125_vllancamento = float8 = Valor do  Lançamento 
                 si125_mes = int8 = Mês 
                 si125_reg20 = int8 = reg20 
                 si125_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ext212014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ext212014"); 
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
       $this->si125_sequencial = ($this->si125_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_sequencial"]:$this->si125_sequencial);
       $this->si125_tiporegistro = ($this->si125_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_tiporegistro"]:$this->si125_tiporegistro);
       $this->si125_codreduzidomov = ($this->si125_codreduzidomov == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_codreduzidomov"]:$this->si125_codreduzidomov);
       $this->si125_codext = ($this->si125_codext == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_codext"]:$this->si125_codext);
       $this->si125_codfontrecursos = ($this->si125_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_codfontrecursos"]:$this->si125_codfontrecursos);
       $this->si125_categoria = ($this->si125_categoria == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_categoria"]:$this->si125_categoria);
       if($this->si125_dtlancamento == ""){
         $this->si125_dtlancamento_dia = ($this->si125_dtlancamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_dtlancamento_dia"]:$this->si125_dtlancamento_dia);
         $this->si125_dtlancamento_mes = ($this->si125_dtlancamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_dtlancamento_mes"]:$this->si125_dtlancamento_mes);
         $this->si125_dtlancamento_ano = ($this->si125_dtlancamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_dtlancamento_ano"]:$this->si125_dtlancamento_ano);
         if($this->si125_dtlancamento_dia != ""){
            $this->si125_dtlancamento = $this->si125_dtlancamento_ano."-".$this->si125_dtlancamento_mes."-".$this->si125_dtlancamento_dia;
         }
       }
       $this->si125_vllancamento = ($this->si125_vllancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_vllancamento"]:$this->si125_vllancamento);
       $this->si125_mes = ($this->si125_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_mes"]:$this->si125_mes);
       $this->si125_reg20 = ($this->si125_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_reg20"]:$this->si125_reg20);
       $this->si125_instit = ($this->si125_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_instit"]:$this->si125_instit);
     }else{
       $this->si125_sequencial = ($this->si125_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si125_sequencial"]:$this->si125_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si125_sequencial){ 
      $this->atualizacampos();
     if($this->si125_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si125_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si125_codreduzidomov == null ){ 
       $this->si125_codreduzidomov = "0";
     }
     if($this->si125_codext == null ){ 
       $this->si125_codext = "0";
     }
     if($this->si125_codfontrecursos == null ){ 
       $this->si125_codfontrecursos = "0";
     }
     if($this->si125_categoria == null ){ 
       $this->si125_categoria = "0";
     }
     if($this->si125_dtlancamento == null ){ 
       $this->si125_dtlancamento = "null";
     }
     if($this->si125_vllancamento == null ){ 
       $this->si125_vllancamento = "0";
     }
     if($this->si125_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si125_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si125_reg20 == null ){ 
       $this->si125_reg20 = "0";
     }
     if($this->si125_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si125_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si125_sequencial == "" || $si125_sequencial == null ){
       $result = db_query("select nextval('ext212014_si125_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ext212014_si125_sequencial_seq do campo: si125_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si125_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ext212014_si125_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si125_sequencial)){
         $this->erro_sql = " Campo si125_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si125_sequencial = $si125_sequencial; 
       }
     }
     if(($this->si125_sequencial == null) || ($this->si125_sequencial == "") ){ 
       $this->erro_sql = " Campo si125_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ext212014(
                                       si125_sequencial 
                                      ,si125_tiporegistro 
                                      ,si125_codreduzidomov 
                                      ,si125_codext 
                                      ,si125_codfontrecursos 
                                      ,si125_categoria 
                                      ,si125_dtlancamento 
                                      ,si125_vllancamento 
                                      ,si125_mes 
                                      ,si125_reg20 
                                      ,si125_instit 
                       )
                values (
                                $this->si125_sequencial 
                               ,$this->si125_tiporegistro 
                               ,$this->si125_codreduzidomov 
                               ,$this->si125_codext 
                               ,$this->si125_codfontrecursos 
                               ,$this->si125_categoria 
                               ,".($this->si125_dtlancamento == "null" || $this->si125_dtlancamento == ""?"null":"'".$this->si125_dtlancamento."'")." 
                               ,$this->si125_vllancamento 
                               ,$this->si125_mes 
                               ,$this->si125_reg20 
                               ,$this->si125_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ext212014 ($this->si125_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ext212014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ext212014 ($this->si125_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si125_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si125_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010858,'$this->si125_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010354,2010858,'','".AddSlashes(pg_result($resaco,0,'si125_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2010859,'','".AddSlashes(pg_result($resaco,0,'si125_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2010860,'','".AddSlashes(pg_result($resaco,0,'si125_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2011337,'','".AddSlashes(pg_result($resaco,0,'si125_codext'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2010861,'','".AddSlashes(pg_result($resaco,0,'si125_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2011335,'','".AddSlashes(pg_result($resaco,0,'si125_categoria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2011334,'','".AddSlashes(pg_result($resaco,0,'si125_dtlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2010862,'','".AddSlashes(pg_result($resaco,0,'si125_vllancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2010863,'','".AddSlashes(pg_result($resaco,0,'si125_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2010864,'','".AddSlashes(pg_result($resaco,0,'si125_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010354,2011638,'','".AddSlashes(pg_result($resaco,0,'si125_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si125_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ext212014 set ";
     $virgula = "";
     if(trim($this->si125_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_sequencial"])){ 
        if(trim($this->si125_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si125_sequencial"])){ 
           $this->si125_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si125_sequencial = $this->si125_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si125_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_tiporegistro"])){ 
       $sql  .= $virgula." si125_tiporegistro = $this->si125_tiporegistro ";
       $virgula = ",";
       if(trim($this->si125_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si125_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si125_codreduzidomov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_codreduzidomov"])){ 
        if(trim($this->si125_codreduzidomov)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si125_codreduzidomov"])){ 
           $this->si125_codreduzidomov = "0" ; 
        } 
       $sql  .= $virgula." si125_codreduzidomov = $this->si125_codreduzidomov ";
       $virgula = ",";
     }
     if(trim($this->si125_codext)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_codext"])){ 
        if(trim($this->si125_codext)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si125_codext"])){ 
           $this->si125_codext = "0" ; 
        } 
       $sql  .= $virgula." si125_codext = $this->si125_codext ";
       $virgula = ",";
     }
     if(trim($this->si125_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_codfontrecursos"])){ 
        if(trim($this->si125_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si125_codfontrecursos"])){ 
           $this->si125_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si125_codfontrecursos = $this->si125_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si125_categoria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_categoria"])){ 
        if(trim($this->si125_categoria)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si125_categoria"])){ 
           $this->si125_categoria = "0" ; 
        } 
       $sql  .= $virgula." si125_categoria = $this->si125_categoria ";
       $virgula = ",";
     }
     if(trim($this->si125_dtlancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si125_dtlancamento_dia"] !="") ){ 
       $sql  .= $virgula." si125_dtlancamento = '$this->si125_dtlancamento' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si125_dtlancamento_dia"])){ 
         $sql  .= $virgula." si125_dtlancamento = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si125_vllancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_vllancamento"])){ 
        if(trim($this->si125_vllancamento)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si125_vllancamento"])){ 
           $this->si125_vllancamento = "0" ; 
        } 
       $sql  .= $virgula." si125_vllancamento = $this->si125_vllancamento ";
       $virgula = ",";
     }
     if(trim($this->si125_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_mes"])){ 
       $sql  .= $virgula." si125_mes = $this->si125_mes ";
       $virgula = ",";
       if(trim($this->si125_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si125_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si125_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_reg20"])){ 
        if(trim($this->si125_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si125_reg20"])){ 
           $this->si125_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si125_reg20 = $this->si125_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si125_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si125_instit"])){ 
       $sql  .= $virgula." si125_instit = $this->si125_instit ";
       $virgula = ",";
       if(trim($this->si125_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si125_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si125_sequencial!=null){
       $sql .= " si125_sequencial = $this->si125_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si125_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010858,'$this->si125_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_sequencial"]) || $this->si125_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2010858,'".AddSlashes(pg_result($resaco,$conresaco,'si125_sequencial'))."','$this->si125_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_tiporegistro"]) || $this->si125_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2010859,'".AddSlashes(pg_result($resaco,$conresaco,'si125_tiporegistro'))."','$this->si125_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_codreduzidomov"]) || $this->si125_codreduzidomov != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2010860,'".AddSlashes(pg_result($resaco,$conresaco,'si125_codreduzidomov'))."','$this->si125_codreduzidomov',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_codext"]) || $this->si125_codext != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2011337,'".AddSlashes(pg_result($resaco,$conresaco,'si125_codext'))."','$this->si125_codext',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_codfontrecursos"]) || $this->si125_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2010861,'".AddSlashes(pg_result($resaco,$conresaco,'si125_codfontrecursos'))."','$this->si125_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_categoria"]) || $this->si125_categoria != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2011335,'".AddSlashes(pg_result($resaco,$conresaco,'si125_categoria'))."','$this->si125_categoria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_dtlancamento"]) || $this->si125_dtlancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2011334,'".AddSlashes(pg_result($resaco,$conresaco,'si125_dtlancamento'))."','$this->si125_dtlancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_vllancamento"]) || $this->si125_vllancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2010862,'".AddSlashes(pg_result($resaco,$conresaco,'si125_vllancamento'))."','$this->si125_vllancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_mes"]) || $this->si125_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2010863,'".AddSlashes(pg_result($resaco,$conresaco,'si125_mes'))."','$this->si125_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_reg20"]) || $this->si125_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2010864,'".AddSlashes(pg_result($resaco,$conresaco,'si125_reg20'))."','$this->si125_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si125_instit"]) || $this->si125_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010354,2011638,'".AddSlashes(pg_result($resaco,$conresaco,'si125_instit'))."','$this->si125_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ext212014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si125_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ext212014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si125_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si125_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si125_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si125_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010858,'$si125_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010354,2010858,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2010859,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2010860,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2011337,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_codext'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2010861,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2011335,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_categoria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2011334,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_dtlancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2010862,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_vllancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2010863,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2010864,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010354,2011638,'','".AddSlashes(pg_result($resaco,$iresaco,'si125_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ext212014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si125_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si125_sequencial = $si125_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ext212014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si125_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ext212014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si125_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si125_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ext212014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si125_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ext212014 ";
     $sql .= "      left  join ext202014  on  ext202014.si165_sequencial = ext212014.si125_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si125_sequencial!=null ){
         $sql2 .= " where ext212014.si125_sequencial = $si125_sequencial "; 
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
   function sql_query_file ( $si125_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ext212014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si125_sequencial!=null ){
         $sql2 .= " where ext212014.si125_sequencial = $si125_sequencial "; 
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
