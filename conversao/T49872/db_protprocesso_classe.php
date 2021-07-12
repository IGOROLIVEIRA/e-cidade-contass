<?
//MODULO: protocolo
//CLASSE DA ENTIDADE protprocesso
class cl_protprocesso { 
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
   var $p58_codproc = 0; 
   var $p58_codigo = 0; 
   var $p58_dtproc_dia = null; 
   var $p58_dtproc_mes = null; 
   var $p58_dtproc_ano = null; 
   var $p58_dtproc = null; 
   var $p58_id_usuario = 0; 
   var $p58_numcgm = 0; 
   var $p58_requer = null; 
   var $p58_coddepto = 0; 
   var $p58_codandam = 0; 
   var $p58_obs = null; 
   var $p58_despacho = null; 
   var $p58_hora = null; 
   var $p58_interno = 'f'; 
   var $p58_publico = 'f'; 
   var $p58_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 p58_codproc = int4 = Processo 
                 p58_codigo = int4 = Tipo 
                 p58_dtproc = date = data do processo 
                 p58_id_usuario = int4 = id do usuário 
                 p58_numcgm = int4 = Titular 
                 p58_requer = varchar(80) = Requerente 
                 p58_coddepto = int4 = Departamento Inicial 
                 p58_codandam = int4 = Andamento 
                 p58_obs = text = Observação 
                 p58_despacho = text = Despacho 
                 p58_hora = varchar(5) = Hora da inclusão do processo 
                 p58_interno = bool = Interno ou não 
                 p58_publico = bool = Despacho Publico 
                 p58_instit = int4 = Código da Instituição 
                 ";
   //funcao construtor da classe 
   function cl_protprocesso() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("protprocesso"); 
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
     }else{
     }
   }
   // funcao para inclusao
   function incluir ($p58_codproc){ 
      $this->atualizacampos();
     if($this->p58_codigo == null ){ 
       $this->erro_sql = " Campo Tipo nao Informado.";
       $this->erro_campo = "p58_codigo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->p58_dtproc == null ){ 
       $this->erro_sql = " Campo data do processo nao Informado.";
       $this->erro_campo = "p58_dtproc_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->p58_id_usuario == null ){ 
       $this->erro_sql = " Campo id do usuário nao Informado.";
       $this->erro_campo = "p58_id_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->p58_numcgm == null ){ 
       $this->erro_sql = " Campo Titular nao Informado.";
       $this->erro_campo = "p58_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->p58_requer == null ){ 
       $this->erro_sql = " Campo Requerente nao Informado.";
       $this->erro_campo = "p58_requer";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->p58_coddepto == null ){ 
       $this->erro_sql = " Campo Departamento Inicial nao Informado.";
       $this->erro_campo = "p58_coddepto";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p58_codandam == null){
       $this->p58_codandam = "0";
     }
/*     
     if($this->p58_codandam == null ){ 
       $this->erro_sql = " Campo Andamento nao Informado.";
       $this->erro_campo = "p58_codandam";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
*/     
     if($this->p58_interno == null ){ 
       $this->erro_sql = " Campo Interno ou não nao Informado.";
       $this->erro_campo = "p58_interno";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->p58_publico == null ){ 
       $this->erro_sql = " Campo Despacho Publico nao Informado.";
       $this->erro_campo = "p58_publico";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->p58_instit == null ){ 
       $this->erro_sql = " Campo Código da Instituição nao Informado.";
       $this->erro_campo = "p58_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($p58_codproc == "" || $p58_codproc == null ){
       $result = db_query("select nextval('protprocesso_p58_codproc_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: protprocesso_p58_codproc_seq do campo: p58_codproc"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->p58_codproc = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from protprocesso_p58_codproc_seq");
       if(($result != false) && (pg_result($result,0,0) < $p58_codproc)){
         $this->erro_sql = " Campo p58_codproc maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->p58_codproc = $p58_codproc; 
       }
     }
     if(($this->p58_codproc == null) || ($this->p58_codproc == "") ){ 
       $this->erro_sql = " Campo p58_codproc nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into protprocesso(
                                       p58_codproc 
                                      ,p58_codigo 
                                      ,p58_dtproc 
                                      ,p58_id_usuario 
                                      ,p58_numcgm 
                                      ,p58_requer 
                                      ,p58_coddepto 
                                      ,p58_codandam 
                                      ,p58_obs 
                                      ,p58_despacho 
                                      ,p58_hora 
                                      ,p58_interno 
                                      ,p58_publico 
                                      ,p58_instit 
                       )
                values (
                                $this->p58_codproc 
                               ,$this->p58_codigo 
                               ,".($this->p58_dtproc == "null" || $this->p58_dtproc == ""?"null":"'".$this->p58_dtproc."'")." 
                               ,$this->p58_id_usuario 
                               ,$this->p58_numcgm 
                               ,'$this->p58_requer' 
                               ,$this->p58_coddepto 
                               ,$this->p58_codandam 
                               ,'$this->p58_obs' 
                               ,'$this->p58_despacho' 
                               ,'$this->p58_hora' 
                               ,'$this->p58_interno' 
                               ,'$this->p58_publico' 
                               ,$this->p58_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->p58_codproc) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->p58_codproc) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p58_codproc;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ($p58_codproc=null) { 
      $this->atualizacampos();
     $sql = " update protprocesso set ";
     $virgula = "";
     if(trim($this->p58_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_codproc"])){ 
       $sql  .= $virgula." p58_codproc = $this->p58_codproc ";
       $virgula = ",";
       if(trim($this->p58_codproc) == null ){ 
         $this->erro_sql = " Campo Processo nao Informado.";
         $this->erro_campo = "p58_codproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p58_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_codigo"])){ 
       $sql  .= $virgula." p58_codigo = $this->p58_codigo ";
       $virgula = ",";
       if(trim($this->p58_codigo) == null ){ 
         $this->erro_sql = " Campo Tipo nao Informado.";
         $this->erro_campo = "p58_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p58_dtproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_dtproc_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["p58_dtproc_dia"] !="") ){ 
       $sql  .= $virgula." p58_dtproc = '$this->p58_dtproc' ";
       $virgula = ",";
       if(trim($this->p58_dtproc) == null ){ 
         $this->erro_sql = " Campo data do processo nao Informado.";
         $this->erro_campo = "p58_dtproc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["p58_dtproc_dia"])){ 
         $sql  .= $virgula." p58_dtproc = null ";
         $virgula = ",";
         if(trim($this->p58_dtproc) == null ){ 
           $this->erro_sql = " Campo data do processo nao Informado.";
           $this->erro_campo = "p58_dtproc_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->p58_id_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_id_usuario"])){ 
       $sql  .= $virgula." p58_id_usuario = $this->p58_id_usuario ";
       $virgula = ",";
       if(trim($this->p58_id_usuario) == null ){ 
         $this->erro_sql = " Campo id do usuário nao Informado.";
         $this->erro_campo = "p58_id_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p58_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_numcgm"])){ 
       $sql  .= $virgula." p58_numcgm = $this->p58_numcgm ";
       $virgula = ",";
       if(trim($this->p58_numcgm) == null ){ 
         $this->erro_sql = " Campo Titular nao Informado.";
         $this->erro_campo = "p58_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p58_requer)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_requer"])){ 
       $sql  .= $virgula." p58_requer = '$this->p58_requer' ";
       $virgula = ",";
       if(trim($this->p58_requer) == null ){ 
         $this->erro_sql = " Campo Requerente nao Informado.";
         $this->erro_campo = "p58_requer";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p58_coddepto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_coddepto"])){ 
       $sql  .= $virgula." p58_coddepto = $this->p58_coddepto ";
       $virgula = ",";
       if(trim($this->p58_coddepto) == null ){ 
         $this->erro_sql = " Campo Departamento Inicial nao Informado.";
         $this->erro_campo = "p58_coddepto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p58_codandam)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_codandam"])){ 
       $sql  .= $virgula." p58_codandam = $this->p58_codandam ";
       $virgula = ",";
       if(trim($this->p58_codandam) == null ){ 
         $this->erro_sql = " Campo Andamento nao Informado.";
         $this->erro_campo = "p58_codandam";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p58_obs)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_obs"])){ 
       $sql  .= $virgula." p58_obs = '$this->p58_obs' ";
       $virgula = ",";
     }
     if(trim($this->p58_despacho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_despacho"])){ 
       $sql  .= $virgula." p58_despacho = '$this->p58_despacho' ";
       $virgula = ",";
     }
     if(trim($this->p58_hora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_hora"])){ 
       $sql  .= $virgula." p58_hora = '$this->p58_hora' ";
       $virgula = ",";
     }
     if(trim($this->p58_interno)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_interno"])){ 
       $sql  .= $virgula." p58_interno = '$this->p58_interno' ";
       $virgula = ",";
       if(trim($this->p58_interno) == null ){ 
         $this->erro_sql = " Campo Interno ou não nao Informado.";
         $this->erro_campo = "p58_interno";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p58_publico)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_publico"])){ 
       $sql  .= $virgula." p58_publico = '$this->p58_publico' ";
       $virgula = ",";
       if(trim($this->p58_publico) == null ){ 
         $this->erro_sql = " Campo Despacho Publico nao Informado.";
         $this->erro_campo = "p58_publico";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->p58_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p58_instit"])){ 
       $sql  .= $virgula." p58_instit = $this->p58_instit ";
       $virgula = ",";
       if(trim($this->p58_instit) == null ){ 
         $this->erro_sql = " Campo Código da Instituição nao Informado.";
         $this->erro_campo = "p58_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($p58_codproc!=null){
       $sql .= " p58_codproc = $this->p58_codproc";
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->p58_codproc;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->p58_codproc;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p58_codproc;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($p58_codproc=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($p58_codproc));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     $sql = " delete from protprocesso
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($p58_codproc != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " p58_codproc = $p58_codproc ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$p58_codproc;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$p58_codproc;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$p58_codproc;
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
        $this->erro_sql   = "Record Vazio na Tabela:protprocesso";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query ( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from protprocesso ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
     $sql .= "      inner join db_config  on  db_config.codigo = protprocesso.p58_instit";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = protprocesso.p58_coddepto";
     $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
     $sql .= "      inner join db_config  as a on   a.codigo = db_depart.instit";
     $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc "; 
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
   function sql_query_alt ( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from protprocesso ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = protprocesso.p58_coddepto";
     $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
     $sql .= "      left join procandam  on  procandam.p61_codandam = protprocesso.p58_codandam and procandam.p61_codproc = protprocesso.p58_codproc";
     $sql .= "      left join proctransferproc  on   proctransferproc.p63_codproc = protprocesso.p58_codproc";
     $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc "; 
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
	function sql_query_andam_ouvidoria ( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from protprocesso ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
     $sql .= "      inner join db_depart a on  a.coddepto = protprocesso.p58_coddepto";
     $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
     $sql .= "      left join procandam  on  procandam.p61_codandam = protprocesso.p58_codandam";
     $sql .= "      left join db_depart b on  b.coddepto = procandam.p61_coddepto";
     $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc "; 
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
   function sql_query_andam ( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from protprocesso ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
     $sql .= "      inner join db_depart a on  a.coddepto = protprocesso.p58_coddepto";
     $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
     $sql .= "      inner join procandam  on  procandam.p61_codandam = protprocesso.p58_codandam";
     $sql .= "      inner join db_depart b on  b.coddepto = procandam.p61_coddepto";
     $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc "; 
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
   function sql_query_arq ( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from protprocesso ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = protprocesso.p58_coddepto";
     $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
     $sql .= "      inner join procandam  on  procandam.p61_codandam = protprocesso.p58_codandam";
     $sql .= "      left join arqproc  on p68_codproc = p58_codproc ";
     $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc ";
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
  function sql_query_deptand ( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from protprocesso ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = protprocesso.p58_numcgm";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";

     $sql .= "      inner join tipoproc  on  tipoproc.p51_codigo = protprocesso.p58_codigo";
     $sql .= "      inner join procandam  on  procandam.p61_codandam = protprocesso.p58_codandam";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = procandam.p61_coddepto";
     $sql .= "      left join arqproc  on p68_codproc = p58_codproc ";
     $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc ";
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
   function sql_query_andpadrao( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from protprocesso ";
     $sql .= "      inner join andpadrao on andpadrao.p53_codigo = protprocesso.p58_codigo";

     $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc ";
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
   function sql_query_deptarq ( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from protprocesso ";
     $sql .= "      inner join cgm					on  cgm.z01_numcgm				 = protprocesso.p58_numcgm";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protprocesso.p58_id_usuario";
     $sql .= "      inner join db_depart a	on  a.coddepto						 = protprocesso.p58_coddepto";
     $sql .= "      inner join tipoproc			on  tipoproc.p51_codigo		 = protprocesso.p58_codigo";
     $sql .= "      inner join procandam		on  procandam.p61_codandam = protprocesso.p58_codandam";
     $sql .= "      inner join db_depart b	on  b.coddepto						 = procandam.p61_coddepto";
     $sql .= "      left  join arqproc			on  p68_codproc					   = protprocesso.p58_codproc";  
		 $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc "; 
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
   function sql_query_file ( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from protprocesso ";
     $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc "; 
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
  
  function sql_query_transand( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){
  	 
    $sql = "select ";
    
    if($campos != "*" ){
      $campos_sql = explode("#",$campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    
      $sql .= " from protprocesso
						        inner join cgm           on cgm.z01_numcgm            = protprocesso.p58_numcgm
						        inner join tipoproc      on tipoproc.p51_codigo       = protprocesso.p58_codigo
						        left  join procandam     on procandam.p61_codandam    = protprocesso.p58_codandam
						        left  join db_usuarios   on db_usuarios.id_usuario    = procandam.p61_id_usuario
						        left  join db_depart     on db_depart.coddepto        = procandam.p61_coddepto
						        left  join proctransand  on proctransand.p64_codandam = procandam.p61_codandam
						        left  join proctransfer  on proctransfer.p62_codtran  = proctransand.p64_codtran
						        left  join db_usuarios a on a.id_usuario              = proctransfer.p62_id_usuario       
						        left  join db_depart   b on b.coddepto                = proctransfer.p62_coddepto
                    inner join db_usuarios c on c.id_usuario              = protprocesso.p58_id_usuario       
                    inner join db_depart   d on d.coddepto                = protprocesso.p58_coddepto
                    left  join arqproc       on arqproc.p68_codproc       = protprocesso.p58_codproc";
      
    
    $sql2 = "";
    
    if($dbwhere==""){
      if($p58_codproc!=null ) {
        $sql2 .= " where protprocesso.p58_codproc = $p58_codproc "; 
      } 
    } else if($dbwhere != "") {
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
  
  function sql_query_despachos( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){
     
    $sql = "select ";
    
    if($campos != "*" ){
      $campos_sql = explode("#",$campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++){
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    
    $sql .= " from protprocesso                                                                               ";
    $sql .= "      inner join cgm               on cgm.z01_numcgm               = protprocesso.p58_numcgm     ";  
    $sql .= "      inner join tipoproc          on tipoproc.p51_codigo          = protprocesso.p58_codigo     "; 
    $sql .= "      left  join proctransferproc  on proctransferproc.p63_codproc = protprocesso.p58_codproc    ";
    $sql .= "      left  join proctransfer      on proctransfer.p62_codtran     = proctransferproc.p63_codtran";
    $sql .= "      left  join proctransand      on proctransand.p64_codtran     = proctransfer.p62_codtran    ";
    $sql .= "      left  join procandam         on procandam.p61_codandam       = proctransand.p64_codandam   ";
    $sql .= "      left  join db_usuarios       on db_usuarios.id_usuario       = procandam.p61_id_usuario    ";
    $sql .= "      left  join db_depart         on db_depart.coddepto           = procandam.p61_coddepto      ";
    $sql .= "      left  join db_usuarios a     on a.id_usuario                 = proctransfer.p62_id_usuario ";
    $sql .= "      left  join db_depart   b     on b.coddepto                   = proctransfer.p62_coddepto   ";
    $sql .= "      inner join db_usuarios c     on c.id_usuario                 = protprocesso.p58_id_usuario ";       
    $sql .= "      inner join db_depart   d     on d.coddepto                   = protprocesso.p58_coddepto   ";
    
    $sql2 = "";
    
    if($dbwhere==""){
      if($p58_codproc!=null ) {
        $sql2 .= " where protprocesso.p58_codproc = $p58_codproc "; 
      } 
    } else if($dbwhere != "") {
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

   function sql_query_ouvidoria( $p58_codproc=null,$campos="*",$ordem=null,$dbwhere=""){
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
     
     $sql .= " from protprocesso ";
     $sql .= "      inner join cgm               on cgm.z01_numcgm                      = protprocesso.p58_numcgm    ";
     $sql .= "      inner join db_usuarios       on db_usuarios.id_usuario              = protprocesso.p58_id_usuario";
     $sql .= "      inner join db_depart         on db_depart.coddepto                  = protprocesso.p58_coddepto  ";
     $sql .= "      inner join tipoproc          on tipoproc.p51_codigo                 = protprocesso.p58_codigo    ";
     $sql .= "      left  join arqproc           on p68_codproc                         = p58_codproc                ";
     
     $sql2 = "";
     if($dbwhere==""){
       if($p58_codproc!=null ){
         $sql2 .= " where protprocesso.p58_codproc = $p58_codproc ";
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
