<?
//MODULO: sicom
//CLASSE DA ENTIDADE arc112016
class cl_arc112016 { 
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
   var $si29_sequencial = 0; 
   var $si29_tiporegistro = 0; 
   var $si29_codcorrecao = 0; 
   var $si29_codfontereduzida = 0; 
   var $si29_vlreduzidofonte = 0; 
   var $si29_reg10 = 0; 
   var $si29_mes = 0; 
   var $si29_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si29_sequencial = int8 = sequencial 
                 si29_tiporegistro = int8 = Tipo do  registro 
                 si29_codcorrecao = int8 = Código que  identifica 
                 si29_codfontereduzida = int8 = Código da fonte 
                 si29_vlreduzidofonte = float8 = Valor reduzido 
                 si29_reg10 = int8 = reg10 
                 si29_mes = int8 = Mês 
                 si29_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_arc112016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("arc112016"); 
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
       $this->si29_sequencial = ($this->si29_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si29_sequencial"]:$this->si29_sequencial);
       $this->si29_tiporegistro = ($this->si29_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si29_tiporegistro"]:$this->si29_tiporegistro);
       $this->si29_codcorrecao = ($this->si29_codcorrecao == ""?@$GLOBALS["HTTP_POST_VARS"]["si29_codcorrecao"]:$this->si29_codcorrecao);
       $this->si29_codfontereduzida = ($this->si29_codfontereduzida == ""?@$GLOBALS["HTTP_POST_VARS"]["si29_codfontereduzida"]:$this->si29_codfontereduzida);
       $this->si29_vlreduzidofonte = ($this->si29_vlreduzidofonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si29_vlreduzidofonte"]:$this->si29_vlreduzidofonte);
       $this->si29_reg10 = ($this->si29_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si29_reg10"]:$this->si29_reg10);
       $this->si29_mes = ($this->si29_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si29_mes"]:$this->si29_mes);
       $this->si29_instit = ($this->si29_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si29_instit"]:$this->si29_instit);
     }else{
       $this->si29_sequencial = ($this->si29_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si29_sequencial"]:$this->si29_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si29_sequencial){ 
      $this->atualizacampos();
     if($this->si29_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si29_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si29_codcorrecao == null ){ 
       $this->si29_codcorrecao = "0";
     }
     if($this->si29_codfontereduzida == null ){ 
       $this->si29_codfontereduzida = "0";
     }
     if($this->si29_vlreduzidofonte == null ){ 
       $this->si29_vlreduzidofonte = "0";
     }
     if($this->si29_reg10 == null ){ 
       $this->si29_reg10 = "0";
     }
     if($this->si29_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si29_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si29_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si29_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si29_sequencial == "" || $si29_sequencial == null ){
       $result = db_query("select nextval('arc112016_si29_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: arc112016_si29_sequencial_seq do campo: si29_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si29_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from arc112016_si29_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si29_sequencial)){
         $this->erro_sql = " Campo si29_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si29_sequencial = $si29_sequencial; 
       }
     }
     if(($this->si29_sequencial == null) || ($this->si29_sequencial == "") ){ 
       $this->erro_sql = " Campo si29_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into arc112016(
                                       si29_sequencial 
                                      ,si29_tiporegistro 
                                      ,si29_codcorrecao 
                                      ,si29_codfontereduzida 
                                      ,si29_vlreduzidofonte 
                                      ,si29_reg10 
                                      ,si29_mes 
                                      ,si29_instit 
                       )
                values (
                                $this->si29_sequencial 
                               ,$this->si29_tiporegistro 
                               ,$this->si29_codcorrecao 
                               ,$this->si29_codfontereduzida 
                               ,$this->si29_vlreduzidofonte 
                               ,$this->si29_reg10 
                               ,$this->si29_mes 
                               ,$this->si29_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "arc112016 ($this->si29_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "arc112016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "arc112016 ($this->si29_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si29_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si29_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009703,'$this->si29_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010257,2009703,'','".AddSlashes(pg_result($resaco,0,'si29_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010257,2009704,'','".AddSlashes(pg_result($resaco,0,'si29_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010257,2009705,'','".AddSlashes(pg_result($resaco,0,'si29_codcorrecao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010257,2009706,'','".AddSlashes(pg_result($resaco,0,'si29_codfontereduzida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010257,2009707,'','".AddSlashes(pg_result($resaco,0,'si29_vlreduzidofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010257,2009708,'','".AddSlashes(pg_result($resaco,0,'si29_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010257,2009746,'','".AddSlashes(pg_result($resaco,0,'si29_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010257,2011544,'','".AddSlashes(pg_result($resaco,0,'si29_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si29_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update arc112016 set ";
     $virgula = "";
     if(trim($this->si29_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si29_sequencial"])){ 
        if(trim($this->si29_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si29_sequencial"])){ 
           $this->si29_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si29_sequencial = $this->si29_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si29_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si29_tiporegistro"])){ 
       $sql  .= $virgula." si29_tiporegistro = $this->si29_tiporegistro ";
       $virgula = ",";
       if(trim($this->si29_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si29_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si29_codcorrecao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si29_codcorrecao"])){ 
        if(trim($this->si29_codcorrecao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si29_codcorrecao"])){ 
           $this->si29_codcorrecao = "0" ; 
        } 
       $sql  .= $virgula." si29_codcorrecao = $this->si29_codcorrecao ";
       $virgula = ",";
     }
     if(trim($this->si29_codfontereduzida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si29_codfontereduzida"])){ 
        if(trim($this->si29_codfontereduzida)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si29_codfontereduzida"])){ 
           $this->si29_codfontereduzida = "0" ; 
        } 
       $sql  .= $virgula." si29_codfontereduzida = $this->si29_codfontereduzida ";
       $virgula = ",";
     }
     if(trim($this->si29_vlreduzidofonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si29_vlreduzidofonte"])){ 
        if(trim($this->si29_vlreduzidofonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si29_vlreduzidofonte"])){ 
           $this->si29_vlreduzidofonte = "0" ; 
        } 
       $sql  .= $virgula." si29_vlreduzidofonte = $this->si29_vlreduzidofonte ";
       $virgula = ",";
     }
     if(trim($this->si29_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si29_reg10"])){ 
        if(trim($this->si29_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si29_reg10"])){ 
           $this->si29_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si29_reg10 = $this->si29_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si29_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si29_mes"])){ 
       $sql  .= $virgula." si29_mes = $this->si29_mes ";
       $virgula = ",";
       if(trim($this->si29_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si29_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si29_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si29_instit"])){ 
       $sql  .= $virgula." si29_instit = $this->si29_instit ";
       $virgula = ",";
       if(trim($this->si29_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si29_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si29_sequencial!=null){
       $sql .= " si29_sequencial = $this->si29_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si29_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009703,'$this->si29_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si29_sequencial"]) || $this->si29_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010257,2009703,'".AddSlashes(pg_result($resaco,$conresaco,'si29_sequencial'))."','$this->si29_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si29_tiporegistro"]) || $this->si29_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010257,2009704,'".AddSlashes(pg_result($resaco,$conresaco,'si29_tiporegistro'))."','$this->si29_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si29_codcorrecao"]) || $this->si29_codcorrecao != "")
           $resac = db_query("insert into db_acount values($acount,2010257,2009705,'".AddSlashes(pg_result($resaco,$conresaco,'si29_codcorrecao'))."','$this->si29_codcorrecao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si29_codfontereduzida"]) || $this->si29_codfontereduzida != "")
           $resac = db_query("insert into db_acount values($acount,2010257,2009706,'".AddSlashes(pg_result($resaco,$conresaco,'si29_codfontereduzida'))."','$this->si29_codfontereduzida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si29_vlreduzidofonte"]) || $this->si29_vlreduzidofonte != "")
           $resac = db_query("insert into db_acount values($acount,2010257,2009707,'".AddSlashes(pg_result($resaco,$conresaco,'si29_vlreduzidofonte'))."','$this->si29_vlreduzidofonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si29_reg10"]) || $this->si29_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010257,2009708,'".AddSlashes(pg_result($resaco,$conresaco,'si29_reg10'))."','$this->si29_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si29_mes"]) || $this->si29_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010257,2009746,'".AddSlashes(pg_result($resaco,$conresaco,'si29_mes'))."','$this->si29_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si29_instit"]) || $this->si29_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010257,2011544,'".AddSlashes(pg_result($resaco,$conresaco,'si29_instit'))."','$this->si29_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "arc112016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si29_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "arc112016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si29_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si29_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si29_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si29_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009703,'$si29_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010257,2009703,'','".AddSlashes(pg_result($resaco,$iresaco,'si29_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010257,2009704,'','".AddSlashes(pg_result($resaco,$iresaco,'si29_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010257,2009705,'','".AddSlashes(pg_result($resaco,$iresaco,'si29_codcorrecao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010257,2009706,'','".AddSlashes(pg_result($resaco,$iresaco,'si29_codfontereduzida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010257,2009707,'','".AddSlashes(pg_result($resaco,$iresaco,'si29_vlreduzidofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010257,2009708,'','".AddSlashes(pg_result($resaco,$iresaco,'si29_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010257,2009746,'','".AddSlashes(pg_result($resaco,$iresaco,'si29_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010257,2011544,'','".AddSlashes(pg_result($resaco,$iresaco,'si29_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from arc112016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si29_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si29_sequencial = $si29_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "arc112016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si29_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "arc112016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si29_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si29_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:arc112016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si29_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arc112016 ";
     $sql .= "      left  join arc102016  on  arc102016.si28_sequencial = arc112016.si29_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si29_sequencial!=null ){
         $sql2 .= " where arc112016.si29_sequencial = $si29_sequencial "; 
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
   function sql_query_file ( $si29_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from arc112016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si29_sequencial!=null ){
         $sql2 .= " where arc112016.si29_sequencial = $si29_sequencial "; 
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
