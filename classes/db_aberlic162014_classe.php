<?
//MODULO: sicom
//CLASSE DA ENTIDADE aberlic162014
class cl_aberlic162014 { 
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
   var $si52_sequencial = 0; 
   var $si52_tiporegistro = 0; 
   var $si52_codorgaoresp = null; 
   var $si52_codunidadesubresp = null; 
   var $si52_exerciciolicitacao = 0; 
   var $si52_nroprocessolicitatorio = null; 
   var $si52_codorgao = null; 
   var $si52_codunidadesub = null; 
   var $si52_codfuncao = null; 
   var $si52_codsubfuncao = null; 
   var $si52_codprograma = null; 
   var $si52_idacao = null; 
   var $si52_idsubacao = null; 
   var $si52_naturezadespesa = 0; 
   var $si52_codfontrecursos = 0; 
   var $si52_vlrecurso = 0; 
   var $si52_mes = 0; 
   var $si52_reg10 = 0; 
   var $si52_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si52_sequencial = int8 = sequencial 
                 si52_tiporegistro = int8 = Tipo do  registro 
                 si52_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si52_codunidadesubresp = varchar(8) = Código da unidade 
                 si52_exerciciolicitacao = int8 = Exercício em que   foi instaurado 
                 si52_nroprocessolicitatorio = varchar(12) = Número sequencial do processo 
                 si52_codorgao = varchar(2) = Código do órgão 
                 si52_codunidadesub = varchar(8) = Código da unidade 
                 si52_codfuncao = varchar(2) = Código da função 
                 si52_codsubfuncao = varchar(3) = Código da   Subfunção 
                 si52_codprograma = varchar(4) = Código do   programa 
                 si52_idacao = varchar(4) = Código que   identifica a Ação 
                 si52_idsubacao = varchar(4) = Código que   identifica a SubAção 
                 si52_naturezadespesa = int8 = Código da   natureza da   despesa 
                 si52_codfontrecursos = int8 = Código da fonte   de recursos 
                 si52_vlrecurso = float8 = Previsão dos recursos orçamentários 
                 si52_mes = int8 = Mês 
                 si52_reg10 = int8 = reg10 
                 si52_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_aberlic162014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("aberlic162014"); 
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
       $this->si52_sequencial = ($this->si52_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_sequencial"]:$this->si52_sequencial);
       $this->si52_tiporegistro = ($this->si52_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_tiporegistro"]:$this->si52_tiporegistro);
       $this->si52_codorgaoresp = ($this->si52_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_codorgaoresp"]:$this->si52_codorgaoresp);
       $this->si52_codunidadesubresp = ($this->si52_codunidadesubresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_codunidadesubresp"]:$this->si52_codunidadesubresp);
       $this->si52_exerciciolicitacao = ($this->si52_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_exerciciolicitacao"]:$this->si52_exerciciolicitacao);
       $this->si52_nroprocessolicitatorio = ($this->si52_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_nroprocessolicitatorio"]:$this->si52_nroprocessolicitatorio);
       $this->si52_codorgao = ($this->si52_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_codorgao"]:$this->si52_codorgao);
       $this->si52_codunidadesub = ($this->si52_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_codunidadesub"]:$this->si52_codunidadesub);
       $this->si52_codfuncao = ($this->si52_codfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_codfuncao"]:$this->si52_codfuncao);
       $this->si52_codsubfuncao = ($this->si52_codsubfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_codsubfuncao"]:$this->si52_codsubfuncao);
       $this->si52_codprograma = ($this->si52_codprograma == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_codprograma"]:$this->si52_codprograma);
       $this->si52_idacao = ($this->si52_idacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_idacao"]:$this->si52_idacao);
       $this->si52_idsubacao = ($this->si52_idsubacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_idsubacao"]:$this->si52_idsubacao);
       $this->si52_naturezadespesa = ($this->si52_naturezadespesa == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_naturezadespesa"]:$this->si52_naturezadespesa);
       $this->si52_codfontrecursos = ($this->si52_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_codfontrecursos"]:$this->si52_codfontrecursos);
       $this->si52_vlrecurso = ($this->si52_vlrecurso == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_vlrecurso"]:$this->si52_vlrecurso);
       $this->si52_mes = ($this->si52_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_mes"]:$this->si52_mes);
       $this->si52_reg10 = ($this->si52_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_reg10"]:$this->si52_reg10);
       $this->si52_instit = ($this->si52_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_instit"]:$this->si52_instit);
     }else{
       $this->si52_sequencial = ($this->si52_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si52_sequencial"]:$this->si52_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si52_sequencial){ 
      $this->atualizacampos();
     if($this->si52_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si52_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si52_exerciciolicitacao == null ){ 
       $this->si52_exerciciolicitacao = "0";
     }
     if($this->si52_naturezadespesa == null ){ 
       $this->si52_naturezadespesa = "0";
     }
     if($this->si52_codfontrecursos == null ){ 
       $this->si52_codfontrecursos = "0";
     }
     if($this->si52_vlrecurso == null ){ 
       $this->si52_vlrecurso = "0";
     }
     if($this->si52_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si52_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si52_reg10 == null ){ 
       $this->si52_reg10 = "0";
     }
     if($this->si52_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si52_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si52_sequencial == "" || $si52_sequencial == null ){
       $result = db_query("select nextval('aberlic162014_si52_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: aberlic162014_si52_sequencial_seq do campo: si52_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si52_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from aberlic162014_si52_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si52_sequencial)){
         $this->erro_sql = " Campo si52_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si52_sequencial = $si52_sequencial; 
       }
     }
     if(($this->si52_sequencial == null) || ($this->si52_sequencial == "") ){ 
       $this->erro_sql = " Campo si52_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into aberlic162014(
                                       si52_sequencial 
                                      ,si52_tiporegistro 
                                      ,si52_codorgaoresp 
                                      ,si52_codunidadesubresp 
                                      ,si52_exerciciolicitacao 
                                      ,si52_nroprocessolicitatorio 
                                      ,si52_codorgao 
                                      ,si52_codunidadesub 
                                      ,si52_codfuncao 
                                      ,si52_codsubfuncao 
                                      ,si52_codprograma 
                                      ,si52_idacao 
                                      ,si52_idsubacao 
                                      ,si52_naturezadespesa 
                                      ,si52_codfontrecursos 
                                      ,si52_vlrecurso 
                                      ,si52_mes 
                                      ,si52_reg10 
                                      ,si52_instit 
                       )
                values (
                                $this->si52_sequencial 
                               ,$this->si52_tiporegistro 
                               ,'$this->si52_codorgaoresp' 
                               ,'$this->si52_codunidadesubresp' 
                               ,$this->si52_exerciciolicitacao 
                               ,'$this->si52_nroprocessolicitatorio' 
                               ,'$this->si52_codorgao' 
                               ,'$this->si52_codunidadesub' 
                               ,'$this->si52_codfuncao' 
                               ,'$this->si52_codsubfuncao' 
                               ,'$this->si52_codprograma' 
                               ,'$this->si52_idacao' 
                               ,'$this->si52_idsubacao' 
                               ,$this->si52_naturezadespesa 
                               ,$this->si52_codfontrecursos 
                               ,$this->si52_vlrecurso 
                               ,$this->si52_mes 
                               ,$this->si52_reg10 
                               ,$this->si52_instit 
                      )";
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "aberlic162014 ($this->si52_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "aberlic162014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "aberlic162014 ($this->si52_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si52_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si52_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009955,'$this->si52_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010281,2009955,'','".AddSlashes(pg_result($resaco,0,'si52_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009956,'','".AddSlashes(pg_result($resaco,0,'si52_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009957,'','".AddSlashes(pg_result($resaco,0,'si52_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009958,'','".AddSlashes(pg_result($resaco,0,'si52_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009959,'','".AddSlashes(pg_result($resaco,0,'si52_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009960,'','".AddSlashes(pg_result($resaco,0,'si52_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009961,'','".AddSlashes(pg_result($resaco,0,'si52_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009962,'','".AddSlashes(pg_result($resaco,0,'si52_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009963,'','".AddSlashes(pg_result($resaco,0,'si52_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009964,'','".AddSlashes(pg_result($resaco,0,'si52_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009965,'','".AddSlashes(pg_result($resaco,0,'si52_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009966,'','".AddSlashes(pg_result($resaco,0,'si52_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009967,'','".AddSlashes(pg_result($resaco,0,'si52_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009968,'','".AddSlashes(pg_result($resaco,0,'si52_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009969,'','".AddSlashes(pg_result($resaco,0,'si52_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009970,'','".AddSlashes(pg_result($resaco,0,'si52_vlrecurso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009971,'','".AddSlashes(pg_result($resaco,0,'si52_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2009972,'','".AddSlashes(pg_result($resaco,0,'si52_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010281,2011566,'','".AddSlashes(pg_result($resaco,0,'si52_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si52_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update aberlic162014 set ";
     $virgula = "";
     if(trim($this->si52_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_sequencial"])){ 
        if(trim($this->si52_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si52_sequencial"])){ 
           $this->si52_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si52_sequencial = $this->si52_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si52_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_tiporegistro"])){ 
       $sql  .= $virgula." si52_tiporegistro = $this->si52_tiporegistro ";
       $virgula = ",";
       if(trim($this->si52_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si52_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si52_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_codorgaoresp"])){ 
       $sql  .= $virgula." si52_codorgaoresp = '$this->si52_codorgaoresp' ";
       $virgula = ",";
     }
     if(trim($this->si52_codunidadesubresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_codunidadesubresp"])){ 
       $sql  .= $virgula." si52_codunidadesubresp = '$this->si52_codunidadesubresp' ";
       $virgula = ",";
     }
     if(trim($this->si52_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_exerciciolicitacao"])){ 
        if(trim($this->si52_exerciciolicitacao)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si52_exerciciolicitacao"])){ 
           $this->si52_exerciciolicitacao = "0" ; 
        } 
       $sql  .= $virgula." si52_exerciciolicitacao = $this->si52_exerciciolicitacao ";
       $virgula = ",";
     }
     if(trim($this->si52_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_nroprocessolicitatorio"])){ 
       $sql  .= $virgula." si52_nroprocessolicitatorio = '$this->si52_nroprocessolicitatorio' ";
       $virgula = ",";
     }
     if(trim($this->si52_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_codorgao"])){ 
       $sql  .= $virgula." si52_codorgao = '$this->si52_codorgao' ";
       $virgula = ",";
     }
     if(trim($this->si52_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_codunidadesub"])){ 
       $sql  .= $virgula." si52_codunidadesub = '$this->si52_codunidadesub' ";
       $virgula = ",";
     }
     if(trim($this->si52_codfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_codfuncao"])){ 
       $sql  .= $virgula." si52_codfuncao = '$this->si52_codfuncao' ";
       $virgula = ",";
     }
     if(trim($this->si52_codsubfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_codsubfuncao"])){ 
       $sql  .= $virgula." si52_codsubfuncao = '$this->si52_codsubfuncao' ";
       $virgula = ",";
     }
     if(trim($this->si52_codprograma)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_codprograma"])){ 
       $sql  .= $virgula." si52_codprograma = '$this->si52_codprograma' ";
       $virgula = ",";
     }
     if(trim($this->si52_idacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_idacao"])){ 
       $sql  .= $virgula." si52_idacao = '$this->si52_idacao' ";
       $virgula = ",";
     }
     if(trim($this->si52_idsubacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_idsubacao"])){ 
       $sql  .= $virgula." si52_idsubacao = '$this->si52_idsubacao' ";
       $virgula = ",";
     }
     if(trim($this->si52_naturezadespesa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_naturezadespesa"])){ 
        if(trim($this->si52_naturezadespesa)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si52_naturezadespesa"])){ 
           $this->si52_naturezadespesa = "0" ; 
        } 
       $sql  .= $virgula." si52_naturezadespesa = $this->si52_naturezadespesa ";
       $virgula = ",";
     }
     if(trim($this->si52_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_codfontrecursos"])){ 
        if(trim($this->si52_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si52_codfontrecursos"])){ 
           $this->si52_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si52_codfontrecursos = $this->si52_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si52_vlrecurso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_vlrecurso"])){ 
        if(trim($this->si52_vlrecurso)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si52_vlrecurso"])){ 
           $this->si52_vlrecurso = "0" ; 
        } 
       $sql  .= $virgula." si52_vlrecurso = $this->si52_vlrecurso ";
       $virgula = ",";
     }
     if(trim($this->si52_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_mes"])){ 
       $sql  .= $virgula." si52_mes = $this->si52_mes ";
       $virgula = ",";
       if(trim($this->si52_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si52_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si52_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_reg10"])){ 
        if(trim($this->si52_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si52_reg10"])){ 
           $this->si52_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si52_reg10 = $this->si52_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si52_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si52_instit"])){ 
       $sql  .= $virgula." si52_instit = $this->si52_instit ";
       $virgula = ",";
       if(trim($this->si52_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si52_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si52_sequencial!=null){
       $sql .= " si52_sequencial = $this->si52_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si52_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009955,'$this->si52_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_sequencial"]) || $this->si52_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009955,'".AddSlashes(pg_result($resaco,$conresaco,'si52_sequencial'))."','$this->si52_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_tiporegistro"]) || $this->si52_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009956,'".AddSlashes(pg_result($resaco,$conresaco,'si52_tiporegistro'))."','$this->si52_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_codorgaoresp"]) || $this->si52_codorgaoresp != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009957,'".AddSlashes(pg_result($resaco,$conresaco,'si52_codorgaoresp'))."','$this->si52_codorgaoresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_codunidadesubresp"]) || $this->si52_codunidadesubresp != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009958,'".AddSlashes(pg_result($resaco,$conresaco,'si52_codunidadesubresp'))."','$this->si52_codunidadesubresp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_exerciciolicitacao"]) || $this->si52_exerciciolicitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009959,'".AddSlashes(pg_result($resaco,$conresaco,'si52_exerciciolicitacao'))."','$this->si52_exerciciolicitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_nroprocessolicitatorio"]) || $this->si52_nroprocessolicitatorio != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009960,'".AddSlashes(pg_result($resaco,$conresaco,'si52_nroprocessolicitatorio'))."','$this->si52_nroprocessolicitatorio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_codorgao"]) || $this->si52_codorgao != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009961,'".AddSlashes(pg_result($resaco,$conresaco,'si52_codorgao'))."','$this->si52_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_codunidadesub"]) || $this->si52_codunidadesub != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009962,'".AddSlashes(pg_result($resaco,$conresaco,'si52_codunidadesub'))."','$this->si52_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_codfuncao"]) || $this->si52_codfuncao != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009963,'".AddSlashes(pg_result($resaco,$conresaco,'si52_codfuncao'))."','$this->si52_codfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_codsubfuncao"]) || $this->si52_codsubfuncao != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009964,'".AddSlashes(pg_result($resaco,$conresaco,'si52_codsubfuncao'))."','$this->si52_codsubfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_codprograma"]) || $this->si52_codprograma != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009965,'".AddSlashes(pg_result($resaco,$conresaco,'si52_codprograma'))."','$this->si52_codprograma',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_idacao"]) || $this->si52_idacao != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009966,'".AddSlashes(pg_result($resaco,$conresaco,'si52_idacao'))."','$this->si52_idacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_idsubacao"]) || $this->si52_idsubacao != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009967,'".AddSlashes(pg_result($resaco,$conresaco,'si52_idsubacao'))."','$this->si52_idsubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_naturezadespesa"]) || $this->si52_naturezadespesa != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009968,'".AddSlashes(pg_result($resaco,$conresaco,'si52_naturezadespesa'))."','$this->si52_naturezadespesa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_codfontrecursos"]) || $this->si52_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009969,'".AddSlashes(pg_result($resaco,$conresaco,'si52_codfontrecursos'))."','$this->si52_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_vlrecurso"]) || $this->si52_vlrecurso != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009970,'".AddSlashes(pg_result($resaco,$conresaco,'si52_vlrecurso'))."','$this->si52_vlrecurso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_mes"]) || $this->si52_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009971,'".AddSlashes(pg_result($resaco,$conresaco,'si52_mes'))."','$this->si52_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_reg10"]) || $this->si52_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2009972,'".AddSlashes(pg_result($resaco,$conresaco,'si52_reg10'))."','$this->si52_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si52_instit"]) || $this->si52_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010281,2011566,'".AddSlashes(pg_result($resaco,$conresaco,'si52_instit'))."','$this->si52_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aberlic162014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si52_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aberlic162014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si52_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si52_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si52_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si52_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009955,'$si52_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010281,2009955,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009956,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009957,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_codorgaoresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009958,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_codunidadesubresp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009959,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_exerciciolicitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009960,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_nroprocessolicitatorio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009961,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009962,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009963,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009964,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009965,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009966,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009967,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009968,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009969,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009970,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_vlrecurso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009971,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2009972,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010281,2011566,'','".AddSlashes(pg_result($resaco,$iresaco,'si52_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from aberlic162014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si52_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si52_sequencial = $si52_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "aberlic162014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si52_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "aberlic162014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si52_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si52_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:aberlic162014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si52_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aberlic162014 ";
     $sql .= "      left  join aberlic102014  on  aberlic102014.si46_sequencial = aberlic162014.si52_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si52_sequencial!=null ){
         $sql2 .= " where aberlic162014.si52_sequencial = $si52_sequencial "; 
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
   function sql_query_file ( $si52_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from aberlic162014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si52_sequencial!=null ){
         $sql2 .= " where aberlic162014.si52_sequencial = $si52_sequencial "; 
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
