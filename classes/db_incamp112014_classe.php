<?
//MODULO: sicom
//CLASSE DA ENTIDADE incamp112014
class cl_incamp112014 { 
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
   var $si161_sequencial = 0; 
   var $si161_tiporegistro = 0; 
   var $si161_idacao = null; 
   var $si161_idsubacao = null; 
   var $si161_descdubacao = null; 
   var $si161_finalidadesubacao = null; 
   var $si161_produtosubacao = null; 
   var $si161_unidademedida = null; 
   var $si161_metas1ano = 0; 
   var $si161_metas2ano = 0; 
   var $si161_metas3ano = 0; 
   var $si161_metas4ano = 0; 
   var $si161_recursos1ano = 0; 
   var $si161_recursos2ano = 0; 
   var $si161_recursos3ano = 0; 
   var $si161_recursos4ano = 0; 
   var $si161_mes = 0; 
   var $si161_reg10 = 0; 
   var $si161_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si161_sequencial = int8 = sequencial 
                 si161_tiporegistro = int8 = Tipo do  registro 
                 si161_idacao = varchar(4) = Código que  identifica a Ação 
                 si161_idsubacao = varchar(4) = Código da  SubAção 
                 si161_descdubacao = varchar(200) = Descrição da  SubAção 
                 si161_finalidadesubacao = varchar(500) = Finalidade da  SubAção 
                 si161_produtosubacao = varchar(50) = Produto da SubAção 
                 si161_unidademedida = varchar(15) = Unidade de medida 
                 si161_metas1ano = float8 = Metas Físicas  para o 1º ano 
                 si161_metas2ano = float8 = Metas Físicas  para o 2º ano 
                 si161_metas3ano = float8 = Metas Físicas  para o 3º ano 
                 si161_metas4ano = float8 = Metas Físicas  para o 4º ano 
                 si161_recursos1ano = float8 = Recursos do 1º  ano 
                 si161_recursos2ano = float8 = Recursos do 2º  ano 
                 si161_recursos3ano = float8 = Recursos do 3º  ano 
                 si161_recursos4ano = float8 = Recursos do 4º  ano 
                 si161_mes = int8 = Mês 
                 si161_reg10 = int8 = reg10 
                 si161_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_incamp112014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("incamp112014"); 
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
       $this->si161_sequencial = ($this->si161_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_sequencial"]:$this->si161_sequencial);
       $this->si161_tiporegistro = ($this->si161_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_tiporegistro"]:$this->si161_tiporegistro);
       $this->si161_idacao = ($this->si161_idacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_idacao"]:$this->si161_idacao);
       $this->si161_idsubacao = ($this->si161_idsubacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_idsubacao"]:$this->si161_idsubacao);
       $this->si161_descdubacao = ($this->si161_descdubacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_descdubacao"]:$this->si161_descdubacao);
       $this->si161_finalidadesubacao = ($this->si161_finalidadesubacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_finalidadesubacao"]:$this->si161_finalidadesubacao);
       $this->si161_produtosubacao = ($this->si161_produtosubacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_produtosubacao"]:$this->si161_produtosubacao);
       $this->si161_unidademedida = ($this->si161_unidademedida == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_unidademedida"]:$this->si161_unidademedida);
       $this->si161_metas1ano = ($this->si161_metas1ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_metas1ano"]:$this->si161_metas1ano);
       $this->si161_metas2ano = ($this->si161_metas2ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_metas2ano"]:$this->si161_metas2ano);
       $this->si161_metas3ano = ($this->si161_metas3ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_metas3ano"]:$this->si161_metas3ano);
       $this->si161_metas4ano = ($this->si161_metas4ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_metas4ano"]:$this->si161_metas4ano);
       $this->si161_recursos1ano = ($this->si161_recursos1ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_recursos1ano"]:$this->si161_recursos1ano);
       $this->si161_recursos2ano = ($this->si161_recursos2ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_recursos2ano"]:$this->si161_recursos2ano);
       $this->si161_recursos3ano = ($this->si161_recursos3ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_recursos3ano"]:$this->si161_recursos3ano);
       $this->si161_recursos4ano = ($this->si161_recursos4ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_recursos4ano"]:$this->si161_recursos4ano);
       $this->si161_mes = ($this->si161_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_mes"]:$this->si161_mes);
       $this->si161_reg10 = ($this->si161_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_reg10"]:$this->si161_reg10);
       $this->si161_instit = ($this->si161_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_instit"]:$this->si161_instit);
     }else{
       $this->si161_sequencial = ($this->si161_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si161_sequencial"]:$this->si161_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si161_sequencial){ 
      $this->atualizacampos();
     if($this->si161_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si161_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si161_metas1ano == null ){ 
       $this->si161_metas1ano = "0";
     }
     if($this->si161_metas2ano == null ){ 
       $this->si161_metas2ano = "0";
     }
     if($this->si161_metas3ano == null ){ 
       $this->si161_metas3ano = "0";
     }
     if($this->si161_metas4ano == null ){ 
       $this->si161_metas4ano = "0";
     }
     if($this->si161_recursos1ano == null ){ 
       $this->si161_recursos1ano = "0";
     }
     if($this->si161_recursos2ano == null ){ 
       $this->si161_recursos2ano = "0";
     }
     if($this->si161_recursos3ano == null ){ 
       $this->si161_recursos3ano = "0";
     }
     if($this->si161_recursos4ano == null ){ 
       $this->si161_recursos4ano = "0";
     }
     if($this->si161_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si161_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si161_reg10 == null ){ 
       $this->si161_reg10 = "0";
     }
     if($this->si161_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si161_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si161_sequencial == "" || $si161_sequencial == null ){
       $result = db_query("select nextval('incamp112014_si161_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: incamp112014_si161_sequencial_seq do campo: si161_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si161_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from incamp112014_si161_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si161_sequencial)){
         $this->erro_sql = " Campo si161_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si161_sequencial = $si161_sequencial; 
       }
     }
     if(($this->si161_sequencial == null) || ($this->si161_sequencial == "") ){ 
       $this->erro_sql = " Campo si161_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into incamp112014(
                                       si161_sequencial 
                                      ,si161_tiporegistro 
                                      ,si161_idacao 
                                      ,si161_idsubacao 
                                      ,si161_descdubacao 
                                      ,si161_finalidadesubacao 
                                      ,si161_produtosubacao 
                                      ,si161_unidademedida 
                                      ,si161_metas1ano 
                                      ,si161_metas2ano 
                                      ,si161_metas3ano 
                                      ,si161_metas4ano 
                                      ,si161_recursos1ano 
                                      ,si161_recursos2ano 
                                      ,si161_recursos3ano 
                                      ,si161_recursos4ano 
                                      ,si161_mes 
                                      ,si161_reg10 
                                      ,si161_instit 
                       )
                values (
                                $this->si161_sequencial 
                               ,$this->si161_tiporegistro 
                               ,'$this->si161_idacao' 
                               ,'$this->si161_idsubacao' 
                               ,'$this->si161_descdubacao' 
                               ,'$this->si161_finalidadesubacao' 
                               ,'$this->si161_produtosubacao' 
                               ,'$this->si161_unidademedida' 
                               ,$this->si161_metas1ano 
                               ,$this->si161_metas2ano 
                               ,$this->si161_metas3ano 
                               ,$this->si161_metas4ano 
                               ,$this->si161_recursos1ano 
                               ,$this->si161_recursos2ano 
                               ,$this->si161_recursos3ano 
                               ,$this->si161_recursos4ano 
                               ,$this->si161_mes 
                               ,$this->si161_reg10 
                               ,$this->si161_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "incamp112014 ($this->si161_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "incamp112014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "incamp112014 ($this->si161_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si161_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si161_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011241,'$this->si161_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010390,2011241,'','".AddSlashes(pg_result($resaco,0,'si161_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011242,'','".AddSlashes(pg_result($resaco,0,'si161_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011243,'','".AddSlashes(pg_result($resaco,0,'si161_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011244,'','".AddSlashes(pg_result($resaco,0,'si161_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011245,'','".AddSlashes(pg_result($resaco,0,'si161_descdubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011246,'','".AddSlashes(pg_result($resaco,0,'si161_finalidadesubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011247,'','".AddSlashes(pg_result($resaco,0,'si161_produtosubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011248,'','".AddSlashes(pg_result($resaco,0,'si161_unidademedida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011249,'','".AddSlashes(pg_result($resaco,0,'si161_metas1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011250,'','".AddSlashes(pg_result($resaco,0,'si161_metas2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011251,'','".AddSlashes(pg_result($resaco,0,'si161_metas3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011252,'','".AddSlashes(pg_result($resaco,0,'si161_metas4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011253,'','".AddSlashes(pg_result($resaco,0,'si161_recursos1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011254,'','".AddSlashes(pg_result($resaco,0,'si161_recursos2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011255,'','".AddSlashes(pg_result($resaco,0,'si161_recursos3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011256,'','".AddSlashes(pg_result($resaco,0,'si161_recursos4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011257,'','".AddSlashes(pg_result($resaco,0,'si161_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011258,'','".AddSlashes(pg_result($resaco,0,'si161_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010390,2011674,'','".AddSlashes(pg_result($resaco,0,'si161_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si161_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update incamp112014 set ";
     $virgula = "";
     if(trim($this->si161_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_sequencial"])){ 
        if(trim($this->si161_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_sequencial"])){ 
           $this->si161_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si161_sequencial = $this->si161_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si161_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_tiporegistro"])){ 
       $sql  .= $virgula." si161_tiporegistro = $this->si161_tiporegistro ";
       $virgula = ",";
       if(trim($this->si161_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si161_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si161_idacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_idacao"])){ 
       $sql  .= $virgula." si161_idacao = '$this->si161_idacao' ";
       $virgula = ",";
     }
     if(trim($this->si161_idsubacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_idsubacao"])){ 
       $sql  .= $virgula." si161_idsubacao = '$this->si161_idsubacao' ";
       $virgula = ",";
     }
     if(trim($this->si161_descdubacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_descdubacao"])){ 
       $sql  .= $virgula." si161_descdubacao = '$this->si161_descdubacao' ";
       $virgula = ",";
     }
     if(trim($this->si161_finalidadesubacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_finalidadesubacao"])){ 
       $sql  .= $virgula." si161_finalidadesubacao = '$this->si161_finalidadesubacao' ";
       $virgula = ",";
     }
     if(trim($this->si161_produtosubacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_produtosubacao"])){ 
       $sql  .= $virgula." si161_produtosubacao = '$this->si161_produtosubacao' ";
       $virgula = ",";
     }
     if(trim($this->si161_unidademedida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_unidademedida"])){ 
       $sql  .= $virgula." si161_unidademedida = '$this->si161_unidademedida' ";
       $virgula = ",";
     }
     if(trim($this->si161_metas1ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_metas1ano"])){ 
        if(trim($this->si161_metas1ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_metas1ano"])){ 
           $this->si161_metas1ano = "0" ; 
        } 
       $sql  .= $virgula." si161_metas1ano = $this->si161_metas1ano ";
       $virgula = ",";
     }
     if(trim($this->si161_metas2ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_metas2ano"])){ 
        if(trim($this->si161_metas2ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_metas2ano"])){ 
           $this->si161_metas2ano = "0" ; 
        } 
       $sql  .= $virgula." si161_metas2ano = $this->si161_metas2ano ";
       $virgula = ",";
     }
     if(trim($this->si161_metas3ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_metas3ano"])){ 
        if(trim($this->si161_metas3ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_metas3ano"])){ 
           $this->si161_metas3ano = "0" ; 
        } 
       $sql  .= $virgula." si161_metas3ano = $this->si161_metas3ano ";
       $virgula = ",";
     }
     if(trim($this->si161_metas4ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_metas4ano"])){ 
        if(trim($this->si161_metas4ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_metas4ano"])){ 
           $this->si161_metas4ano = "0" ; 
        } 
       $sql  .= $virgula." si161_metas4ano = $this->si161_metas4ano ";
       $virgula = ",";
     }
     if(trim($this->si161_recursos1ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos1ano"])){ 
        if(trim($this->si161_recursos1ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos1ano"])){ 
           $this->si161_recursos1ano = "0" ; 
        } 
       $sql  .= $virgula." si161_recursos1ano = $this->si161_recursos1ano ";
       $virgula = ",";
     }
     if(trim($this->si161_recursos2ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos2ano"])){ 
        if(trim($this->si161_recursos2ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos2ano"])){ 
           $this->si161_recursos2ano = "0" ; 
        } 
       $sql  .= $virgula." si161_recursos2ano = $this->si161_recursos2ano ";
       $virgula = ",";
     }
     if(trim($this->si161_recursos3ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos3ano"])){ 
        if(trim($this->si161_recursos3ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos3ano"])){ 
           $this->si161_recursos3ano = "0" ; 
        } 
       $sql  .= $virgula." si161_recursos3ano = $this->si161_recursos3ano ";
       $virgula = ",";
     }
     if(trim($this->si161_recursos4ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos4ano"])){ 
        if(trim($this->si161_recursos4ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos4ano"])){ 
           $this->si161_recursos4ano = "0" ; 
        } 
       $sql  .= $virgula." si161_recursos4ano = $this->si161_recursos4ano ";
       $virgula = ",";
     }
     if(trim($this->si161_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_mes"])){ 
       $sql  .= $virgula." si161_mes = $this->si161_mes ";
       $virgula = ",";
       if(trim($this->si161_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si161_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si161_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_reg10"])){ 
        if(trim($this->si161_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si161_reg10"])){ 
           $this->si161_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si161_reg10 = $this->si161_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si161_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si161_instit"])){ 
       $sql  .= $virgula." si161_instit = $this->si161_instit ";
       $virgula = ",";
       if(trim($this->si161_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si161_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si161_sequencial!=null){
       $sql .= " si161_sequencial = $this->si161_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si161_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011241,'$this->si161_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_sequencial"]) || $this->si161_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011241,'".AddSlashes(pg_result($resaco,$conresaco,'si161_sequencial'))."','$this->si161_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_tiporegistro"]) || $this->si161_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011242,'".AddSlashes(pg_result($resaco,$conresaco,'si161_tiporegistro'))."','$this->si161_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_idacao"]) || $this->si161_idacao != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011243,'".AddSlashes(pg_result($resaco,$conresaco,'si161_idacao'))."','$this->si161_idacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_idsubacao"]) || $this->si161_idsubacao != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011244,'".AddSlashes(pg_result($resaco,$conresaco,'si161_idsubacao'))."','$this->si161_idsubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_descdubacao"]) || $this->si161_descdubacao != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011245,'".AddSlashes(pg_result($resaco,$conresaco,'si161_descdubacao'))."','$this->si161_descdubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_finalidadesubacao"]) || $this->si161_finalidadesubacao != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011246,'".AddSlashes(pg_result($resaco,$conresaco,'si161_finalidadesubacao'))."','$this->si161_finalidadesubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_produtosubacao"]) || $this->si161_produtosubacao != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011247,'".AddSlashes(pg_result($resaco,$conresaco,'si161_produtosubacao'))."','$this->si161_produtosubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_unidademedida"]) || $this->si161_unidademedida != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011248,'".AddSlashes(pg_result($resaco,$conresaco,'si161_unidademedida'))."','$this->si161_unidademedida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_metas1ano"]) || $this->si161_metas1ano != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011249,'".AddSlashes(pg_result($resaco,$conresaco,'si161_metas1ano'))."','$this->si161_metas1ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_metas2ano"]) || $this->si161_metas2ano != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011250,'".AddSlashes(pg_result($resaco,$conresaco,'si161_metas2ano'))."','$this->si161_metas2ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_metas3ano"]) || $this->si161_metas3ano != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011251,'".AddSlashes(pg_result($resaco,$conresaco,'si161_metas3ano'))."','$this->si161_metas3ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_metas4ano"]) || $this->si161_metas4ano != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011252,'".AddSlashes(pg_result($resaco,$conresaco,'si161_metas4ano'))."','$this->si161_metas4ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos1ano"]) || $this->si161_recursos1ano != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011253,'".AddSlashes(pg_result($resaco,$conresaco,'si161_recursos1ano'))."','$this->si161_recursos1ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos2ano"]) || $this->si161_recursos2ano != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011254,'".AddSlashes(pg_result($resaco,$conresaco,'si161_recursos2ano'))."','$this->si161_recursos2ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos3ano"]) || $this->si161_recursos3ano != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011255,'".AddSlashes(pg_result($resaco,$conresaco,'si161_recursos3ano'))."','$this->si161_recursos3ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_recursos4ano"]) || $this->si161_recursos4ano != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011256,'".AddSlashes(pg_result($resaco,$conresaco,'si161_recursos4ano'))."','$this->si161_recursos4ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_mes"]) || $this->si161_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011257,'".AddSlashes(pg_result($resaco,$conresaco,'si161_mes'))."','$this->si161_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_reg10"]) || $this->si161_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011258,'".AddSlashes(pg_result($resaco,$conresaco,'si161_reg10'))."','$this->si161_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si161_instit"]) || $this->si161_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010390,2011674,'".AddSlashes(pg_result($resaco,$conresaco,'si161_instit'))."','$this->si161_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "incamp112014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si161_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "incamp112014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si161_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si161_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si161_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si161_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011241,'$si161_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010390,2011241,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011242,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011243,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011244,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011245,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_descdubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011246,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_finalidadesubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011247,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_produtosubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011248,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_unidademedida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011249,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_metas1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011250,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_metas2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011251,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_metas3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011252,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_metas4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011253,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_recursos1ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011254,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_recursos2ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011255,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_recursos3ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011256,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_recursos4ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011257,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011258,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010390,2011674,'','".AddSlashes(pg_result($resaco,$iresaco,'si161_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from incamp112014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si161_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si161_sequencial = $si161_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "incamp112014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si161_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "incamp112014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si161_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si161_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:incamp112014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si161_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from incamp112014 ";
     $sql .= "      left  join incamp102014  on  incamp102014.si160_sequencial = incamp112014.si161_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si161_sequencial!=null ){
         $sql2 .= " where incamp112014.si161_sequencial = $si161_sequencial "; 
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
   function sql_query_file ( $si161_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from incamp112014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si161_sequencial!=null ){
         $sql2 .= " where incamp112014.si161_sequencial = $si161_sequencial "; 
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
