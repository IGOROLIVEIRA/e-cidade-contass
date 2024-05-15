<?
//MODULO: sicom
//CLASSE DA ENTIDADE ctb212016
class cl_ctb212016 { 
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
   var $si97_sequencial = 0; 
   var $si97_tiporegistro = 0; 
   var $si97_codctb = 0; 
   var $si97_codfontrecursos = 0; 
   var $si97_codreduzidomov = 0; 
   var $si97_tipomovimentacao = 0; 
   var $si97_tipoentrsaida = null; 
   var $si97_valorentrsaida = 0; 
   var $si97_codctbtransf = 0; 
   var $si97_codfontectbtransf = 0; 
   var $si97_mes = 0; 
   var $si97_reg20 = 0; 
   var $si97_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si97_sequencial = int8 = sequencial 
                 si97_tiporegistro = int8 = Tipo do  registro 
                 si97_codctb = int8 = Código Identificador da Conta Bancária 
                 si97_codfontrecursos = int8 = Código da fonte de  recursos 
                 si97_codreduzidomov = int8 = Código Identificador da Movimentação 
                 si97_tipomovimentacao = int8 = Tipo de  movimentação 
                 si97_tipoentrsaida = varchar(2) = Tipo de entrada ou  saída 
                 si97_valorentrsaida = float8 = Valor correspondente à entrada/saída 
                 si97_codctbtransf = int8 = Código Identificador da Conta Bancária 
                 si97_codfontectbtransf = int8 = Código da fonte de recursos ctb 
                 si97_mes = int8 = Mês 
                 si97_reg20 = int8 = reg20 
                 si97_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ctb212016() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ctb212016"); 
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
       $this->si97_sequencial = ($this->si97_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_sequencial"]:$this->si97_sequencial);
       $this->si97_tiporegistro = ($this->si97_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_tiporegistro"]:$this->si97_tiporegistro);
       $this->si97_codctb = ($this->si97_codctb == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codctb"]:$this->si97_codctb);
       $this->si97_codfontrecursos = ($this->si97_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codfontrecursos"]:$this->si97_codfontrecursos);
       $this->si97_codreduzidomov = ($this->si97_codreduzidomov == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codreduzidomov"]:$this->si97_codreduzidomov);
       $this->si97_tipomovimentacao = ($this->si97_tipomovimentacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_tipomovimentacao"]:$this->si97_tipomovimentacao);
       $this->si97_tipoentrsaida = ($this->si97_tipoentrsaida == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_tipoentrsaida"]:$this->si97_tipoentrsaida);
       $this->si97_valorentrsaida = ($this->si97_valorentrsaida == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_valorentrsaida"]:$this->si97_valorentrsaida);
       $this->si97_codctbtransf = ($this->si97_codctbtransf == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codctbtransf"]:$this->si97_codctbtransf);
       $this->si97_codfontectbtransf = ($this->si97_codfontectbtransf == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_codfontectbtransf"]:$this->si97_codfontectbtransf);
       $this->si97_mes = ($this->si97_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_mes"]:$this->si97_mes);
       $this->si97_reg20 = ($this->si97_reg20 == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_reg20"]:$this->si97_reg20);
       $this->si97_instit = ($this->si97_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_instit"]:$this->si97_instit);
     }else{
       $this->si97_sequencial = ($this->si97_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si97_sequencial"]:$this->si97_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si97_sequencial){ 
      $this->atualizacampos();
     if($this->si97_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si97_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si97_codctb == null ){ 
       $this->si97_codctb = "0";
     }
     if($this->si97_codfontrecursos == null ){ 
       $this->si97_codfontrecursos = "0";
     }
     if($this->si97_codreduzidomov == null ){ 
       $this->si97_codreduzidomov = "0";
     }
     if($this->si97_tipomovimentacao == null ){ 
       $this->si97_tipomovimentacao = "0";
     }
     if($this->si97_valorentrsaida == null ){ 
       $this->si97_valorentrsaida = "0";
     }
     if($this->si97_codctbtransf == null ){ 
       $this->si97_codctbtransf = "0";
     }
     if($this->si97_codfontectbtransf == null ){ 
       $this->si97_codfontectbtransf = "0";
     }
     if($this->si97_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si97_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si97_reg20 == null ){ 
       $this->si97_reg20 = "0";
     }
     if($this->si97_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si97_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si97_sequencial == "" || $si97_sequencial == null ){
       $result = db_query("select nextval('ctb212016_si97_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ctb212016_si97_sequencial_seq do campo: si97_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si97_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ctb212016_si97_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si97_sequencial)){
         $this->erro_sql = " Campo si97_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si97_sequencial = $si97_sequencial; 
       }
     }
     if(($this->si97_sequencial == null) || ($this->si97_sequencial == "") ){ 
       $this->erro_sql = " Campo si97_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ctb212016(
                                       si97_sequencial 
                                      ,si97_tiporegistro 
                                      ,si97_codctb 
                                      ,si97_codfontrecursos 
                                      ,si97_codreduzidomov 
                                      ,si97_tipomovimentacao 
                                      ,si97_tipoentrsaida 
                                      ,si97_valorentrsaida 
                                      ,si97_codctbtransf 
                                      ,si97_codfontectbtransf 
                                      ,si97_mes 
                                      ,si97_reg20 
                                      ,si97_instit 
                       )
                values (
                                $this->si97_sequencial 
                               ,$this->si97_tiporegistro 
                               ,$this->si97_codctb 
                               ,$this->si97_codfontrecursos 
                               ,$this->si97_codreduzidomov 
                               ,$this->si97_tipomovimentacao 
                               ,'$this->si97_tipoentrsaida' 
                               ,$this->si97_valorentrsaida 
                               ,$this->si97_codctbtransf 
                               ,$this->si97_codfontectbtransf 
                               ,$this->si97_mes 
                               ,$this->si97_reg20 
                               ,$this->si97_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ctb212016 ($this->si97_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ctb212016 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ctb212016 ($this->si97_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si97_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si97_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010569,'$this->si97_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010326,2010569,'','".AddSlashes(pg_result($resaco,0,'si97_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010570,'','".AddSlashes(pg_result($resaco,0,'si97_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010571,'','".AddSlashes(pg_result($resaco,0,'si97_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2011320,'','".AddSlashes(pg_result($resaco,0,'si97_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010572,'','".AddSlashes(pg_result($resaco,0,'si97_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010573,'','".AddSlashes(pg_result($resaco,0,'si97_tipomovimentacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010574,'','".AddSlashes(pg_result($resaco,0,'si97_tipoentrsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010576,'','".AddSlashes(pg_result($resaco,0,'si97_valorentrsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010577,'','".AddSlashes(pg_result($resaco,0,'si97_codctbtransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2011321,'','".AddSlashes(pg_result($resaco,0,'si97_codfontectbtransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2010578,'','".AddSlashes(pg_result($resaco,0,'si97_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2011322,'','".AddSlashes(pg_result($resaco,0,'si97_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010326,2011609,'','".AddSlashes(pg_result($resaco,0,'si97_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si97_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ctb212016 set ";
     $virgula = "";
     if(trim($this->si97_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_sequencial"])){ 
        if(trim($this->si97_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_sequencial"])){ 
           $this->si97_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si97_sequencial = $this->si97_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si97_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_tiporegistro"])){ 
       $sql  .= $virgula." si97_tiporegistro = $this->si97_tiporegistro ";
       $virgula = ",";
       if(trim($this->si97_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si97_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si97_codctb)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codctb"])){ 
        if(trim($this->si97_codctb)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codctb"])){ 
           $this->si97_codctb = "0" ; 
        } 
       $sql  .= $virgula." si97_codctb = $this->si97_codctb ";
       $virgula = ",";
     }
     if(trim($this->si97_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontrecursos"])){ 
        if(trim($this->si97_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontrecursos"])){ 
           $this->si97_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si97_codfontrecursos = $this->si97_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si97_codreduzidomov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codreduzidomov"])){ 
        if(trim($this->si97_codreduzidomov)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codreduzidomov"])){ 
           $this->si97_codreduzidomov = "0" ; 
        } 
       $sql  .= $virgula." si97_codreduzidomov = $this->si97_codreduzidomov ";
       $virgula = ",";
     }
     if(trim($this->si97_tipomovimentacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_tipomovimentacao"])){ 
        if(trim($this->si97_tipomovimentacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_tipomovimentacao"])){ 
           $this->si97_tipomovimentacao = "0" ; 
        } 
       $sql  .= $virgula." si97_tipomovimentacao = $this->si97_tipomovimentacao ";
       $virgula = ",";
     }
     if(trim($this->si97_tipoentrsaida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_tipoentrsaida"])){ 
       $sql  .= $virgula." si97_tipoentrsaida = '$this->si97_tipoentrsaida' ";
       $virgula = ",";
     }
     if(trim($this->si97_valorentrsaida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_valorentrsaida"])){ 
        if(trim($this->si97_valorentrsaida)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_valorentrsaida"])){ 
           $this->si97_valorentrsaida = "0" ; 
        } 
       $sql  .= $virgula." si97_valorentrsaida = $this->si97_valorentrsaida ";
       $virgula = ",";
     }
     if(trim($this->si97_codctbtransf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codctbtransf"])){ 
        if(trim($this->si97_codctbtransf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codctbtransf"])){ 
           $this->si97_codctbtransf = "0" ; 
        } 
       $sql  .= $virgula." si97_codctbtransf = $this->si97_codctbtransf ";
       $virgula = ",";
     }
     if(trim($this->si97_codfontectbtransf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontectbtransf"])){ 
        if(trim($this->si97_codfontectbtransf)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontectbtransf"])){ 
           $this->si97_codfontectbtransf = "0" ; 
        } 
       $sql  .= $virgula." si97_codfontectbtransf = $this->si97_codfontectbtransf ";
       $virgula = ",";
     }
     if(trim($this->si97_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_mes"])){ 
       $sql  .= $virgula." si97_mes = $this->si97_mes ";
       $virgula = ",";
       if(trim($this->si97_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si97_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si97_reg20)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_reg20"])){ 
        if(trim($this->si97_reg20)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si97_reg20"])){ 
           $this->si97_reg20 = "0" ; 
        } 
       $sql  .= $virgula." si97_reg20 = $this->si97_reg20 ";
       $virgula = ",";
     }
     if(trim($this->si97_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si97_instit"])){ 
       $sql  .= $virgula." si97_instit = $this->si97_instit ";
       $virgula = ",";
       if(trim($this->si97_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si97_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si97_sequencial!=null){
       $sql .= " si97_sequencial = $this->si97_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si97_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010569,'$this->si97_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_sequencial"]) || $this->si97_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010569,'".AddSlashes(pg_result($resaco,$conresaco,'si97_sequencial'))."','$this->si97_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_tiporegistro"]) || $this->si97_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010570,'".AddSlashes(pg_result($resaco,$conresaco,'si97_tiporegistro'))."','$this->si97_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codctb"]) || $this->si97_codctb != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010571,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codctb'))."','$this->si97_codctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontrecursos"]) || $this->si97_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2011320,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codfontrecursos'))."','$this->si97_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codreduzidomov"]) || $this->si97_codreduzidomov != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010572,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codreduzidomov'))."','$this->si97_codreduzidomov',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_tipomovimentacao"]) || $this->si97_tipomovimentacao != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010573,'".AddSlashes(pg_result($resaco,$conresaco,'si97_tipomovimentacao'))."','$this->si97_tipomovimentacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_tipoentrsaida"]) || $this->si97_tipoentrsaida != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010574,'".AddSlashes(pg_result($resaco,$conresaco,'si97_tipoentrsaida'))."','$this->si97_tipoentrsaida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_valorentrsaida"]) || $this->si97_valorentrsaida != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010576,'".AddSlashes(pg_result($resaco,$conresaco,'si97_valorentrsaida'))."','$this->si97_valorentrsaida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codctbtransf"]) || $this->si97_codctbtransf != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010577,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codctbtransf'))."','$this->si97_codctbtransf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_codfontectbtransf"]) || $this->si97_codfontectbtransf != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2011321,'".AddSlashes(pg_result($resaco,$conresaco,'si97_codfontectbtransf'))."','$this->si97_codfontectbtransf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_mes"]) || $this->si97_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2010578,'".AddSlashes(pg_result($resaco,$conresaco,'si97_mes'))."','$this->si97_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_reg20"]) || $this->si97_reg20 != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2011322,'".AddSlashes(pg_result($resaco,$conresaco,'si97_reg20'))."','$this->si97_reg20',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si97_instit"]) || $this->si97_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010326,2011609,'".AddSlashes(pg_result($resaco,$conresaco,'si97_instit'))."','$this->si97_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ctb212016 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si97_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb212016 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si97_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si97_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si97_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si97_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010569,'$si97_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010326,2010569,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010570,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010571,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2011320,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010572,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codreduzidomov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010573,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_tipomovimentacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010574,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_tipoentrsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010576,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_valorentrsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010577,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codctbtransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2011321,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_codfontectbtransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2010578,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2011322,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_reg20'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010326,2011609,'','".AddSlashes(pg_result($resaco,$iresaco,'si97_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ctb212016
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si97_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si97_sequencial = $si97_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ctb212016 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si97_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb212016 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si97_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si97_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ctb212016";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si97_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb212016 ";
     $sql .= "      left  join ctb202016  on  ctb202016.si96_sequencial = ctb212016.si97_reg20";
     $sql2 = "";
     if($dbwhere==""){
       if($si97_sequencial!=null ){
         $sql2 .= " where ctb212016.si97_sequencial = $si97_sequencial "; 
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
   function sql_query_file ( $si97_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb212016 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si97_sequencial!=null ){
         $sql2 .= " where ctb212016.si97_sequencial = $si97_sequencial "; 
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
