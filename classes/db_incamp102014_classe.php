<?
//MODULO: sicom
//CLASSE DA ENTIDADE incamp102014
class cl_incamp102014 { 
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
   var $si160_sequencial = 0; 
   var $si160_tiporegistro = 0; 
   var $si160_possuisubacao = 0; 
   var $si160_idacao = null; 
   var $si160_descacao = null; 
   var $si160_finalidadeacao = null; 
   var $si160_produto = null; 
   var $si160_unidademedida = null; 
   var $si160_metas1ano = 0; 
   var $si160_metas2ano = 0; 
   var $si160_metas3ano = 0; 
   var $si160_metas4ano = 0; 
   var $si160_recursos1ano = 0; 
   var $si160_recursos2ano = 0; 
   var $si160_recursos3ano = 0; 
   var $si160_recursos4ano = 0; 
   var $si160_mes = 0; 
   var $si160_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si160_sequencial = int8 = sequencial 
                 si160_tiporegistro = int8 = Tipo do  registro 
                 si160_possuisubacao = int8 = Informar se as  metas são  definidas 
                 si160_idacao = varchar(4) = Código que identifica a Ação 
                 si160_descacao = varchar(200) = Descrição da  Ação 
                 si160_finalidadeacao = varchar(500) = Finalidade da  Ação 
                 si160_produto = varchar(50) = Produto da Ação 
                 si160_unidademedida = varchar(15) = Unidade de  medida 
                 si160_metas1ano = float8 = Metas Físicas  para o 1º ano 
                 si160_metas2ano = float8 = Metas Físicas  para o 2º ano 
                 si160_metas3ano = float8 = Metas Físicas  para o 3º ano 
                 si160_metas4ano = float8 = Metas Físicas  para o 4º ano 
                 si160_recursos1ano = float8 = Recursos do 1º  ano 
                 si160_recursos2ano = float8 = Recursos do 2º  ano 
                 si160_recursos3ano = float8 = Recursos do 3º  ano 
                 si160_recursos4ano = float8 = Recursos do 4º  ano 
                 si160_mes = int8 = Mês 
                 si160_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_incamp102014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("incamp102014"); 
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
       $this->si160_sequencial = ($this->si160_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_sequencial"]:$this->si160_sequencial);
       $this->si160_tiporegistro = ($this->si160_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_tiporegistro"]:$this->si160_tiporegistro);
       $this->si160_possuisubacao = ($this->si160_possuisubacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_possuisubacao"]:$this->si160_possuisubacao);
       $this->si160_idacao = ($this->si160_idacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_idacao"]:$this->si160_idacao);
       $this->si160_descacao = ($this->si160_descacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_descacao"]:$this->si160_descacao);
       $this->si160_finalidadeacao = ($this->si160_finalidadeacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_finalidadeacao"]:$this->si160_finalidadeacao);
       $this->si160_produto = ($this->si160_produto == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_produto"]:$this->si160_produto);
       $this->si160_unidademedida = ($this->si160_unidademedida == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_unidademedida"]:$this->si160_unidademedida);
       $this->si160_metas1ano = ($this->si160_metas1ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_metas1ano"]:$this->si160_metas1ano);
       $this->si160_metas2ano = ($this->si160_metas2ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_metas2ano"]:$this->si160_metas2ano);
       $this->si160_metas3ano = ($this->si160_metas3ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_metas3ano"]:$this->si160_metas3ano);
       $this->si160_metas4ano = ($this->si160_metas4ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_metas4ano"]:$this->si160_metas4ano);
       $this->si160_recursos1ano = ($this->si160_recursos1ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_recursos1ano"]:$this->si160_recursos1ano);
       $this->si160_recursos2ano = ($this->si160_recursos2ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_recursos2ano"]:$this->si160_recursos2ano);
       $this->si160_recursos3ano = ($this->si160_recursos3ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_recursos3ano"]:$this->si160_recursos3ano);
       $this->si160_recursos4ano = ($this->si160_recursos4ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_recursos4ano"]:$this->si160_recursos4ano);
       $this->si160_mes = ($this->si160_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_mes"]:$this->si160_mes);
       $this->si160_instit = ($this->si160_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_instit"]:$this->si160_instit);
     }else{
       $this->si160_sequencial = ($this->si160_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si160_sequencial"]:$this->si160_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si160_sequencial){ 
      $this->atualizacampos();
     if($this->si160_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si160_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si160_possuisubacao == null ){ 
       $this->si160_possuisubacao = "0";
     }
     if($this->si160_metas1ano == null ){ 
       $this->si160_metas1ano = "0";
     }
     if($this->si160_metas2ano == null ){ 
       $this->si160_metas2ano = "0";
     }
     if($this->si160_metas3ano == null ){ 
       $this->si160_metas3ano = "0";
     }
     if($this->si160_metas4ano == null ){ 
       $this->si160_metas4ano = "0";
     }
     if($this->si160_recursos1ano == null ){ 
       $this->si160_recursos1ano = "0";
     }
     if($this->si160_recursos2ano == null ){ 
       $this->si160_recursos2ano = "0";
     }
     if($this->si160_recursos3ano == null ){ 
       $this->si160_recursos3ano = "0";
     }
     if($this->si160_recursos4ano == null ){ 
       $this->si160_recursos4ano = "0";
     }
     if($this->si160_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si160_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si160_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si160_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si160_sequencial == "" || $si160_sequencial == null ){
       $result = db_query("select nextval('incamp102014_si160_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: incamp102014_si160_sequencial_seq do campo: si160_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si160_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from incamp102014_si160_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si160_sequencial)){
         $this->erro_sql = " Campo si160_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si160_sequencial = $si160_sequencial; 
       }
     }
     if(($this->si160_sequencial == null) || ($this->si160_sequencial == "") ){ 
       $this->erro_sql = " Campo si160_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into incamp102014(
                                       si160_sequencial 
                                      ,si160_tiporegistro 
                                      ,si160_possuisubacao 
                                      ,si160_idacao 
                                      ,si160_descacao 
                                      ,si160_finalidadeacao 
                                      ,si160_produto 
                                      ,si160_unidademedida 
                                      ,si160_metas1ano 
                                      ,si160_metas2ano 
                                      ,si160_metas3ano 
                                      ,si160_metas4ano 
                                      ,si160_recursos1ano 
                                      ,si160_recursos2ano 
                                      ,si160_recursos3ano 
                                      ,si160_recursos4ano 
                                      ,si160_mes 
                                      ,si160_instit 
                       )
                values (
                                $this->si160_sequencial 
                               ,$this->si160_tiporegistro 
                               ,$this->si160_possuisubacao 
                               ,'$this->si160_idacao' 
                               ,'$this->si160_descacao' 
                               ,'$this->si160_finalidadeacao' 
                               ,'$this->si160_produto' 
                               ,'$this->si160_unidademedida' 
                               ,$this->si160_metas1ano 
                               ,$this->si160_metas2ano 
                               ,$this->si160_metas3ano 
                               ,$this->si160_metas4ano 
                               ,$this->si160_recursos1ano 
                               ,$this->si160_recursos2ano 
                               ,$this->si160_recursos3ano 
                               ,$this->si160_recursos4ano 
                               ,$this->si160_mes 
                               ,$this->si160_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "incamp102014 ($this->si160_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "incamp102014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "incamp102014 ($this->si160_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si160_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si160_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011224,'$this->si160_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010389,2011224,'','".AddSlashes(pg_result($resaco,0,'si160_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011225,'','".AddSlashes(pg_result($resaco,0,'si160_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011226,'','".AddSlashes(pg_result($resaco,0,'si160_possuisubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011227,'','".AddSlashes(pg_result($resaco,0,'si160_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011228,'','".AddSlashes(pg_result($resaco,0,'si160_descacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011229,'','".AddSlashes(pg_result($resaco,0,'si160_finalidadeacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011230,'','".AddSlashes(pg_result($resaco,0,'si160_produto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011231,'','".AddSlashes(pg_result($resaco,0,'si160_unidademedida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011232,'','".AddSlashes(pg_result($resaco,0,'si160_metas1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011233,'','".AddSlashes(pg_result($resaco,0,'si160_metas2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011234,'','".AddSlashes(pg_result($resaco,0,'si160_metas3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011235,'','".AddSlashes(pg_result($resaco,0,'si160_metas4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011236,'','".AddSlashes(pg_result($resaco,0,'si160_recursos1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011237,'','".AddSlashes(pg_result($resaco,0,'si160_recursos2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011238,'','".AddSlashes(pg_result($resaco,0,'si160_recursos3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011239,'','".AddSlashes(pg_result($resaco,0,'si160_recursos4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011240,'','".AddSlashes(pg_result($resaco,0,'si160_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010389,2011673,'','".AddSlashes(pg_result($resaco,0,'si160_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si160_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update incamp102014 set ";
     $virgula = "";
     if(trim($this->si160_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_sequencial"])){ 
        if(trim($this->si160_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_sequencial"])){ 
           $this->si160_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si160_sequencial = $this->si160_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si160_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_tiporegistro"])){ 
       $sql  .= $virgula." si160_tiporegistro = $this->si160_tiporegistro ";
       $virgula = ",";
       if(trim($this->si160_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si160_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si160_possuisubacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_possuisubacao"])){ 
        if(trim($this->si160_possuisubacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_possuisubacao"])){ 
           $this->si160_possuisubacao = "0" ; 
        } 
       $sql  .= $virgula." si160_possuisubacao = $this->si160_possuisubacao ";
       $virgula = ",";
     }
     if(trim($this->si160_idacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_idacao"])){ 
       $sql  .= $virgula." si160_idacao = '$this->si160_idacao' ";
       $virgula = ",";
     }
     if(trim($this->si160_descacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_descacao"])){ 
       $sql  .= $virgula." si160_descacao = '$this->si160_descacao' ";
       $virgula = ",";
     }
     if(trim($this->si160_finalidadeacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_finalidadeacao"])){ 
       $sql  .= $virgula." si160_finalidadeacao = '$this->si160_finalidadeacao' ";
       $virgula = ",";
     }
     if(trim($this->si160_produto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_produto"])){ 
       $sql  .= $virgula." si160_produto = '$this->si160_produto' ";
       $virgula = ",";
     }
     if(trim($this->si160_unidademedida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_unidademedida"])){ 
       $sql  .= $virgula." si160_unidademedida = '$this->si160_unidademedida' ";
       $virgula = ",";
     }
     if(trim($this->si160_metas1ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_metas1ano"])){ 
        if(trim($this->si160_metas1ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_metas1ano"])){ 
           $this->si160_metas1ano = "0" ; 
        } 
       $sql  .= $virgula." si160_metas1ano = $this->si160_metas1ano ";
       $virgula = ",";
     }
     if(trim($this->si160_metas2ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_metas2ano"])){ 
        if(trim($this->si160_metas2ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_metas2ano"])){ 
           $this->si160_metas2ano = "0" ; 
        } 
       $sql  .= $virgula." si160_metas2ano = $this->si160_metas2ano ";
       $virgula = ",";
     }
     if(trim($this->si160_metas3ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_metas3ano"])){ 
        if(trim($this->si160_metas3ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_metas3ano"])){ 
           $this->si160_metas3ano = "0" ; 
        } 
       $sql  .= $virgula." si160_metas3ano = $this->si160_metas3ano ";
       $virgula = ",";
     }
     if(trim($this->si160_metas4ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_metas4ano"])){ 
        if(trim($this->si160_metas4ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_metas4ano"])){ 
           $this->si160_metas4ano = "0" ; 
        } 
       $sql  .= $virgula." si160_metas4ano = $this->si160_metas4ano ";
       $virgula = ",";
     }
     if(trim($this->si160_recursos1ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos1ano"])){ 
        if(trim($this->si160_recursos1ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos1ano"])){ 
           $this->si160_recursos1ano = "0" ; 
        } 
       $sql  .= $virgula." si160_recursos1ano = $this->si160_recursos1ano ";
       $virgula = ",";
     }
     if(trim($this->si160_recursos2ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos2ano"])){ 
        if(trim($this->si160_recursos2ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos2ano"])){ 
           $this->si160_recursos2ano = "0" ; 
        } 
       $sql  .= $virgula." si160_recursos2ano = $this->si160_recursos2ano ";
       $virgula = ",";
     }
     if(trim($this->si160_recursos3ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos3ano"])){ 
        if(trim($this->si160_recursos3ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos3ano"])){ 
           $this->si160_recursos3ano = "0" ; 
        } 
       $sql  .= $virgula." si160_recursos3ano = $this->si160_recursos3ano ";
       $virgula = ",";
     }
     if(trim($this->si160_recursos4ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos4ano"])){ 
        if(trim($this->si160_recursos4ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos4ano"])){ 
           $this->si160_recursos4ano = "0" ; 
        } 
       $sql  .= $virgula." si160_recursos4ano = $this->si160_recursos4ano ";
       $virgula = ",";
     }
     if(trim($this->si160_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_mes"])){ 
       $sql  .= $virgula." si160_mes = $this->si160_mes ";
       $virgula = ",";
       if(trim($this->si160_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si160_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si160_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si160_instit"])){ 
       $sql  .= $virgula." si160_instit = $this->si160_instit ";
       $virgula = ",";
       if(trim($this->si160_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si160_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si160_sequencial!=null){
       $sql .= " si160_sequencial = $this->si160_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si160_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011224,'$this->si160_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_sequencial"]) || $this->si160_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011224,'".AddSlashes(pg_result($resaco,$conresaco,'si160_sequencial'))."','$this->si160_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_tiporegistro"]) || $this->si160_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011225,'".AddSlashes(pg_result($resaco,$conresaco,'si160_tiporegistro'))."','$this->si160_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_possuisubacao"]) || $this->si160_possuisubacao != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011226,'".AddSlashes(pg_result($resaco,$conresaco,'si160_possuisubacao'))."','$this->si160_possuisubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_idacao"]) || $this->si160_idacao != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011227,'".AddSlashes(pg_result($resaco,$conresaco,'si160_idacao'))."','$this->si160_idacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_descacao"]) || $this->si160_descacao != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011228,'".AddSlashes(pg_result($resaco,$conresaco,'si160_descacao'))."','$this->si160_descacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_finalidadeacao"]) || $this->si160_finalidadeacao != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011229,'".AddSlashes(pg_result($resaco,$conresaco,'si160_finalidadeacao'))."','$this->si160_finalidadeacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_produto"]) || $this->si160_produto != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011230,'".AddSlashes(pg_result($resaco,$conresaco,'si160_produto'))."','$this->si160_produto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_unidademedida"]) || $this->si160_unidademedida != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011231,'".AddSlashes(pg_result($resaco,$conresaco,'si160_unidademedida'))."','$this->si160_unidademedida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_metas1ano"]) || $this->si160_metas1ano != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011232,'".AddSlashes(pg_result($resaco,$conresaco,'si160_metas1ano'))."','$this->si160_metas1ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_metas2ano"]) || $this->si160_metas2ano != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011233,'".AddSlashes(pg_result($resaco,$conresaco,'si160_metas2ano'))."','$this->si160_metas2ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_metas3ano"]) || $this->si160_metas3ano != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011234,'".AddSlashes(pg_result($resaco,$conresaco,'si160_metas3ano'))."','$this->si160_metas3ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_metas4ano"]) || $this->si160_metas4ano != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011235,'".AddSlashes(pg_result($resaco,$conresaco,'si160_metas4ano'))."','$this->si160_metas4ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos1ano"]) || $this->si160_recursos1ano != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011236,'".AddSlashes(pg_result($resaco,$conresaco,'si160_recursos1ano'))."','$this->si160_recursos1ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos2ano"]) || $this->si160_recursos2ano != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011237,'".AddSlashes(pg_result($resaco,$conresaco,'si160_recursos2ano'))."','$this->si160_recursos2ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos3ano"]) || $this->si160_recursos3ano != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011238,'".AddSlashes(pg_result($resaco,$conresaco,'si160_recursos3ano'))."','$this->si160_recursos3ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_recursos4ano"]) || $this->si160_recursos4ano != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011239,'".AddSlashes(pg_result($resaco,$conresaco,'si160_recursos4ano'))."','$this->si160_recursos4ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_mes"]) || $this->si160_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011240,'".AddSlashes(pg_result($resaco,$conresaco,'si160_mes'))."','$this->si160_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si160_instit"]) || $this->si160_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010389,2011673,'".AddSlashes(pg_result($resaco,$conresaco,'si160_instit'))."','$this->si160_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "incamp102014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si160_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "incamp102014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si160_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si160_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si160_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si160_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011224,'$si160_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010389,2011224,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011225,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011226,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_possuisubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011227,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011228,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_descacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011229,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_finalidadeacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011230,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_produto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011231,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_unidademedida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011232,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_metas1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011233,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_metas2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011234,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_metas3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011235,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_metas4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011236,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_recursos1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011237,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_recursos2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011238,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_recursos3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011239,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_recursos4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011240,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010389,2011673,'','".AddSlashes(pg_result($resaco,$iresaco,'si160_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from incamp102014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si160_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si160_sequencial = $si160_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "incamp102014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si160_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "incamp102014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si160_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si160_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:incamp102014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si160_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from incamp102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si160_sequencial!=null ){
         $sql2 .= " where incamp102014.si160_sequencial = $si160_sequencial "; 
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
   function sql_query_file ( $si160_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from incamp102014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si160_sequencial!=null ){
         $sql2 .= " where incamp102014.si160_sequencial = $si160_sequencial "; 
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
