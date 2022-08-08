<?
//MODULO: sicom
//CLASSE DA ENTIDADE rsp212015
class cl_rsp212015 { 
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
   var $si116_sequencial = 0; 
   var $si116_tiporegistro = 0; 
   var $si116_codreduzidomov = 0; 
   var $si116_codfontrecursos = 0; 
   var $si116_vlmovimentacaofonte = 0; 
   var $si116_mes = 0; 
   var $si116_reg20 = 0; 
   var $si116_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si116_sequencial = int8 = sequencial 
                 si116_tiporegistro = int8 = Tipo do  registro 
                 si116_codreduzidomov = int8 = Código Identificador da Movimentação 
                 si116_codfontrecursos = int8 = Código da fonte de recursos 
                 si116_vlmovimentacaofonte = float8 = Valor da  Movimentação fonte de recurso 
                 si116_mes = int8 = Mês 
                 si116_reg20 = int8 = reg20 
                 si116_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_rsp212015() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("rsp212015"); 
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
       $this->si116_sequencial = ($this->si116_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si116_sequencial"]:$this->si116_sequencial);
       $this->si116_tiporegistro = ($this->si116_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si116_tiporegistro"]:$this->si116_tiporegistro);
       $this->si116_codreduzidomov = ($this->si116_codreduzidomov == ""?@$GLOBALS["HTTP_POST_VARS"]["si116_codreduzidomov"]:$this->si116_codreduzidomov);
       $this->si116_codfontrecursos = ($this->si116_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si116_codfontrecursos"]:$this->si116_codfontrecursos);
       $this->si116_vlmovimentacaofonte = ($this->si116_vlmovimentacaofonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si116_vlmovimentacaofonte"]:$this->si116_vlmovimentacaofonte);
       $this->si116_mes = ($this->si116_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si116_mes"]:$this->si116_mes);
       $this->si116_reg20 = ($this->si116_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si116_reg20"]:$this->si116_reg20);
       $this->si116_instit = ($this->si116_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si116_instit"]:$this->si116_instit);
     }else{
       $this->si116_sequencial = ($this->si116_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si116_sequencial"]:$this->si116_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si116_sequencial){ 
      $this->atualizacampos();
     if($this->si116_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si116_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si116_codreduzidomov == null ){ 
       $this->si116_codreduzidomov = "0";
     }
     if($this->si116_codfontrecursos == null ){ 
       $this->si116_codfontrecursos = "0";
     }
     if($this->si116_vlmovimentacaofonte == null ){ 
       $this->si116_vlmovimentacaofonte = "0";
     }
     if($this->si116_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si116_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si116_reg20 == null ){ 
       $this->si116_reg20 = "0";
     }
     if($this->si116_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si116_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si116_sequencial == "" || $si116_sequencial == null ){
       $result = db_query("select nextval('rsp212015_si116_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rsp212015_si116_sequencial_seq do campo: si116_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si116_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from rsp212015_si116_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si116_sequencial)){
         $this->erro_sql = " Campo si116_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si116_sequencial = $si116_sequencial; 
       }
     }
     if(($this->si116_sequencial == null) || ($this->si116_sequencial == "") ){ 
       $this->erro_sql = " Campo si116_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rsp212015(
                                       si116_sequencial 
                                      ,si116_tiporegistro 
                                      ,si116_codreduzidomov 
                                      ,si116_codfontrecursos 
                                      ,si116_vlmovimentacaofonte 
                                      ,si116_mes 
                                      ,si116_reg20 
                                      ,si116_instit 
                       )
                values (
                                $this->si116_sequencial 
                               ,$this->si116_tiporegistro 
                               ,$this->si116_codreduzidomov 
                               ,$this->si116_codfontrecursos 
                               ,$this->si116_vlmovimentacaofonte 
                               ,$this->si116_mes 
                               ,$this->si116_reg20 
                               ,$this->si116_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "rsp212015 ($this->si116_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "rsp212015 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "rsp212015 ($this->si116_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si116_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si116_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010771,'$this->si116_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010345,2010771,'','".AddSlashes(pg_result($resaco,0,'si116_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010345,2010772,'','".AddSlashes(pg_result($resaco,0,'si116_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010345,2010773,'','".AddSlashes(pg_result($resaco,0,'si116_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010345,2010774,'','".AddSlashes(pg_result($resaco,0,'si116_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010345,2010775,'','".AddSlashes(pg_result($resaco,0,'si116_vlmovimentacaofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010345,2010777,'','".AddSlashes(pg_result($resaco,0,'si116_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010345,2010778,'','".AddSlashes(pg_result($resaco,0,'si116_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010345,2011629,'','".AddSlashes(pg_result($resaco,0,'si116_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si116_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rsp212015 set ";
     $virgula = "";
     if(trim($this->si116_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si116_sequencial"])){ 
        if(trim($this->si116_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si116_sequencial"])){ 
           $this->si116_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si116_sequencial = $this->si116_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si116_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si116_tiporegistro"])){ 
       $sql  .= $virgula." si116_tiporegistro = $this->si116_tiporegistro ";
       $virgula = ",";
       if(trim($this->si116_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si116_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si116_codreduzidomov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si116_codreduzidomov"])){ 
        if(trim($this->si116_codreduzidomov)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si116_codreduzidomov"])){ 
           $this->si116_codreduzidomov = "0" ; 
        } 
       $sql  .= $virgula." si116_codreduzidomov = $this->si116_codreduzidomov ";
       $virgula = ",";
     }
     if(trim($this->si116_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si116_codfontrecursos"])){ 
        if(trim($this->si116_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si116_codfontrecursos"])){ 
           $this->si116_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si116_codfontrecursos = $this->si116_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si116_vlmovimentacaofonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si116_vlmovimentacaofonte"])){ 
        if(trim($this->si116_vlmovimentacaofonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si116_vlmovimentacaofonte"])){ 
           $this->si116_vlmovimentacaofonte = "0" ; 
        } 
       $sql  .= $virgula." si116_vlmovimentacaofonte = $this->si116_vlmovimentacaofonte ";
       $virgula = ",";
     }
     if(trim($this->si116_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si116_mes"])){ 
       $sql  .= $virgula." si116_mes = $this->si116_mes ";
       $virgula = ",";
       if(trim($this->si116_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si116_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si116_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si116_reg20"])){ 
        if(trim($this->si116_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si116_reg20"])){ 
           $this->si116_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si116_reg20 = $this->si116_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si116_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si116_instit"])){ 
       $sql  .= $virgula." si116_instit = $this->si116_instit ";
       $virgula = ",";
       if(trim($this->si116_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si116_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si116_sequencial!=null){
       $sql .= " si116_sequencial = $this->si116_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si116_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010771,'$this->si116_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si116_sequencial"]) || $this->si116_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010345,2010771,'".AddSlashes(pg_result($resaco,$conresaco,'si116_sequencial'))."','$this->si116_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si116_tiporegistro"]) || $this->si116_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010345,2010772,'".AddSlashes(pg_result($resaco,$conresaco,'si116_tiporegistro'))."','$this->si116_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si116_codreduzidomov"]) || $this->si116_codreduzidomov != "")
           $resac = db_query("insert into db_acount values($acount,2010345,2010773,'".AddSlashes(pg_result($resaco,$conresaco,'si116_codreduzidomov'))."','$this->si116_codreduzidomov',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si116_codfontrecursos"]) || $this->si116_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010345,2010774,'".AddSlashes(pg_result($resaco,$conresaco,'si116_codfontrecursos'))."','$this->si116_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si116_vlmovimentacaofonte"]) || $this->si116_vlmovimentacaofonte != "")
           $resac = db_query("insert into db_acount values($acount,2010345,2010775,'".AddSlashes(pg_result($resaco,$conresaco,'si116_vlmovimentacaofonte'))."','$this->si116_vlmovimentacaofonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si116_mes"]) || $this->si116_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010345,2010777,'".AddSlashes(pg_result($resaco,$conresaco,'si116_mes'))."','$this->si116_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si116_reg20"]) || $this->si116_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010345,2010778,'".AddSlashes(pg_result($resaco,$conresaco,'si116_reg20'))."','$this->si116_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si116_instit"]) || $this->si116_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010345,2011629,'".AddSlashes(pg_result($resaco,$conresaco,'si116_instit'))."','$this->si116_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rsp212015 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si116_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rsp212015 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si116_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si116_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si116_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si116_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010771,'$si116_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010345,2010771,'','".AddSlashes(pg_result($resaco,$iresaco,'si116_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010345,2010772,'','".AddSlashes(pg_result($resaco,$iresaco,'si116_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010345,2010773,'','".AddSlashes(pg_result($resaco,$iresaco,'si116_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010345,2010774,'','".AddSlashes(pg_result($resaco,$iresaco,'si116_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010345,2010775,'','".AddSlashes(pg_result($resaco,$iresaco,'si116_vlmovimentacaofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010345,2010777,'','".AddSlashes(pg_result($resaco,$iresaco,'si116_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010345,2010778,'','".AddSlashes(pg_result($resaco,$iresaco,'si116_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010345,2011629,'','".AddSlashes(pg_result($resaco,$iresaco,'si116_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from rsp212015
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si116_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si116_sequencial = $si116_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "rsp212015 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si116_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "rsp212015 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si116_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si116_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rsp212015";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si116_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rsp212015 ";
     $sql .= "      left  join rsp202015  on  rsp202015.si115_sequencial = rsp212015.si116_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si116_sequencial!=null ){
         $sql2 .= " where rsp212015.si116_sequencial = $si116_sequencial "; 
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
   function sql_query_file ( $si116_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rsp212015 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si116_sequencial!=null ){
         $sql2 .= " where rsp212015.si116_sequencial = $si116_sequencial "; 
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
