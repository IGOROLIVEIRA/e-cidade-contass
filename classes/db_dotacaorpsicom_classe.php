<?
//MODULO: sicom
//CLASSE DA ENTIDADE dotacaorpsicom
class cl_dotacaorpsicom { 
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
   var $si177_sequencial = 0; 
   var $si177_numemp = 0; 
   var $si177_codorgaotce = 0; 
   var $si177_codunidadesub = 0; 
   var $si177_codunidadesuborig = 0; 
   var $si177_codfuncao = 0; 
   var $si177_codsubfuncao = 0; 
   var $si177_codprograma = 0; 
   var $si177_idacao = 0; 
   var $si177_idsubacao = 0; 
   var $si177_naturezadespesa = 0; 
   var $si177_subelemento = 0; 
   var $si177_codfontrecursos = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si177_sequencial = int8 = Campo Sequencial 
                 si177_numemp = int8 = Sequencial do Empenho 
                 si177_codorgaotce = int8 = Código Orgão TCE 
                 si177_codunidadesub = int8 = Código Unidade/Subunidade 
                 si177_codunidadesuborig = int8 = Código Unidade/Subunidade Original 
                 si177_codfuncao = int8 = Código da Função 
                 si177_codsubfuncao = int8 = Código da Subfunção 
                 si177_codprograma = int8 = Código do Programa 
                 si177_idacao = int8 = Código da Ação 
                 si177_idsubacao = int8 = Código da subação 
                 si177_naturezadespesa = int8 = Natureza da Despesa 
                 si177_subelemento = int8 = Subelemento da Despesa 
                 si177_codfontrecursos = int8 = Fonte de Recursos 
                 ";
   //funcao construtor da classe 
   function cl_dotacaorpsicom() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dotacaorpsicom"); 
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
       $this->si177_sequencial = ($this->si177_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_sequencial"]:$this->si177_sequencial);
       $this->si177_numemp = ($this->si177_numemp == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_numemp"]:$this->si177_numemp);
       $this->si177_codorgaotce = ($this->si177_codorgaotce == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_codorgaotce"]:$this->si177_codorgaotce);
       $this->si177_codunidadesub = ($this->si177_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_codunidadesub"]:$this->si177_codunidadesub);
       $this->si177_codunidadesuborig = ($this->si177_codunidadesuborig == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_codunidadesuborig"]:$this->si177_codunidadesuborig);
       $this->si177_codfuncao = ($this->si177_codfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_codfuncao"]:$this->si177_codfuncao);
       $this->si177_codsubfuncao = ($this->si177_codsubfuncao == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_codsubfuncao"]:$this->si177_codsubfuncao);
       $this->si177_codprograma = ($this->si177_codprograma == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_codprograma"]:$this->si177_codprograma);
       $this->si177_idacao = ($this->si177_idacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_idacao"]:$this->si177_idacao);
       $this->si177_idsubacao = ($this->si177_idsubacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_idsubacao"]:$this->si177_idsubacao);
       $this->si177_naturezadespesa = ($this->si177_naturezadespesa == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_naturezadespesa"]:$this->si177_naturezadespesa);
       $this->si177_subelemento = ($this->si177_subelemento == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_subelemento"]:$this->si177_subelemento);
       $this->si177_codfontrecursos = ($this->si177_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_codfontrecursos"]:$this->si177_codfontrecursos);
     }else{
       $this->si177_sequencial = ($this->si177_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si177_sequencial"]:$this->si177_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si177_sequencial){ 
      $this->atualizacampos();
     if($this->si177_numemp == null ){ 
       $this->erro_sql = " Campo Sequencial do Empenho não informado.";
       $this->erro_campo = "si177_numemp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_codorgaotce == null ){ 
       $this->erro_sql = " Campo Código Orgão TCE não informado.";
       $this->erro_campo = "si177_codorgaotce";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_codunidadesub == null ){ 
       $this->erro_sql = " Campo Código Unidade/Subunidade não informado.";
       $this->erro_campo = "si177_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_codunidadesuborig == null ){ 
       $this->erro_sql = " Campo Código Unidade/Subunidade Original não informado.";
       $this->erro_campo = "si177_codunidadesuborig";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_codfuncao == null ){ 
       $this->erro_sql = " Campo Código da Função não informado.";
       $this->erro_campo = "si177_codfuncao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_codsubfuncao == null ){ 
       $this->erro_sql = " Campo Código da Subfunção não informado.";
       $this->erro_campo = "si177_codsubfuncao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_codprograma == null ){ 
       $this->erro_sql = " Campo Código do Programa não informado.";
       $this->erro_campo = "si177_codprograma";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_idacao == null ){ 
       $this->erro_sql = " Campo Código da Ação não informado.";
       $this->erro_campo = "si177_idacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_idsubacao == null ){ 
       $this->erro_sql = " Campo Código da subação não informado.";
       $this->erro_campo = "si177_idsubacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_naturezadespesa == null ){ 
       $this->erro_sql = " Campo Natureza da Despesa não informado.";
       $this->erro_campo = "si177_naturezadespesa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_subelemento == null ){ 
       $this->erro_sql = " Campo Subelemento da Despesa não informado.";
       $this->erro_campo = "si177_subelemento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si177_codfontrecursos == null ){ 
       $this->erro_sql = " Campo Fonte de Recursos não informado.";
       $this->erro_campo = "si177_codfontrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si177_sequencial == "" || $si177_sequencial == null ){
       $result = db_query("select nextval('dotacaorpsicom_si177_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dotacaorpsicom_si177_sequencial_seq do campo: si177_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si177_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from dotacaorpsicom_si177_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si177_sequencial)){
         $this->erro_sql = " Campo si177_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si177_sequencial = $si177_sequencial; 
       }
     }
     if(($this->si177_sequencial == null) || ($this->si177_sequencial == "") ){ 
       $this->erro_sql = " Campo si177_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dotacaorpsicom(
                                       si177_sequencial 
                                      ,si177_numemp 
                                      ,si177_codorgaotce 
                                      ,si177_codunidadesub 
                                      ,si177_codunidadesuborig 
                                      ,si177_codfuncao 
                                      ,si177_codsubfuncao 
                                      ,si177_codprograma 
                                      ,si177_idacao 
                                      ,si177_idsubacao 
                                      ,si177_naturezadespesa 
                                      ,si177_subelemento 
                                      ,si177_codfontrecursos 
                       )
                values (
                                $this->si177_sequencial 
                               ,$this->si177_numemp 
                               ,$this->si177_codorgaotce 
                               ,$this->si177_codunidadesub 
                               ,$this->si177_codunidadesuborig 
                               ,$this->si177_codfuncao 
                               ,$this->si177_codsubfuncao 
                               ,$this->si177_codprograma 
                               ,$this->si177_idacao 
                               ,$this->si177_idsubacao 
                               ,$this->si177_naturezadespesa 
                               ,$this->si177_subelemento 
                               ,$this->si177_codfontrecursos 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Alterar Dotação RP Sicom ($this->si177_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Alterar Dotação RP Sicom já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Alterar Dotação RP Sicom ($this->si177_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si177_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si177_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->si177_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,0,'si177_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009257,'','".AddSlashes(pg_result($resaco,0,'si177_numemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,0,'si177_codorgaotce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009246,'','".AddSlashes(pg_result($resaco,0,'si177_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,0,'si177_codunidadesuborig'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,0,'si177_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,0,'si177_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,0,'si177_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,0,'si177_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,0,'si177_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,0,'si177_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,0,'si177_subelemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009256,'','".AddSlashes(pg_result($resaco,0,'si177_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         */      
       }
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si177_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dotacaorpsicom set ";
     $virgula = "";
     if(trim($this->si177_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_sequencial"])){ 
       $sql  .= $virgula." si177_sequencial = $this->si177_sequencial ";
       $virgula = ",";
       if(trim($this->si177_sequencial) == null ){ 
         $this->erro_sql = " Campo Campo Sequencial não informado.";
         $this->erro_campo = "si177_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_numemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_numemp"])){ 
       $sql  .= $virgula." si177_numemp = $this->si177_numemp ";
       $virgula = ",";
       if(trim($this->si177_numemp) == null ){ 
         $this->erro_sql = " Campo Sequencial do Empenho não informado.";
         $this->erro_campo = "si177_numemp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_codorgaotce)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_codorgaotce"])){ 
       $sql  .= $virgula." si177_codorgaotce = $this->si177_codorgaotce ";
       $virgula = ",";
       if(trim($this->si177_codorgaotce) == null ){ 
         $this->erro_sql = " Campo Código Orgão TCE não informado.";
         $this->erro_campo = "si177_codorgaotce";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_codunidadesub"])){ 
       $sql  .= $virgula." si177_codunidadesub = $this->si177_codunidadesub ";
       $virgula = ",";
       if(trim($this->si177_codunidadesub) == null ){ 
         $this->erro_sql = " Campo Código Unidade/Subunidade não informado.";
         $this->erro_campo = "si177_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_codunidadesuborig)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_codunidadesuborig"])){ 
       $sql  .= $virgula." si177_codunidadesuborig = $this->si177_codunidadesuborig ";
       $virgula = ",";
       if(trim($this->si177_codunidadesuborig) == null ){ 
         $this->erro_sql = " Campo Código Unidade/Subunidade Original não informado.";
         $this->erro_campo = "si177_codunidadesuborig";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_codfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_codfuncao"])){ 
       $sql  .= $virgula." si177_codfuncao = $this->si177_codfuncao ";
       $virgula = ",";
       if(trim($this->si177_codfuncao) == null ){ 
         $this->erro_sql = " Campo Código da Função não informado.";
         $this->erro_campo = "si177_codfuncao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_codsubfuncao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_codsubfuncao"])){ 
       $sql  .= $virgula." si177_codsubfuncao = $this->si177_codsubfuncao ";
       $virgula = ",";
       if(trim($this->si177_codsubfuncao) == null ){ 
         $this->erro_sql = " Campo Código da Subfunção não informado.";
         $this->erro_campo = "si177_codsubfuncao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_codprograma)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_codprograma"])){ 
       $sql  .= $virgula." si177_codprograma = $this->si177_codprograma ";
       $virgula = ",";
       if(trim($this->si177_codprograma) == null ){ 
         $this->erro_sql = " Campo Código do Programa não informado.";
         $this->erro_campo = "si177_codprograma";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_idacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_idacao"])){ 
       $sql  .= $virgula." si177_idacao = $this->si177_idacao ";
       $virgula = ",";
       if(trim($this->si177_idacao) == null ){ 
         $this->erro_sql = " Campo Código da Ação não informado.";
         $this->erro_campo = "si177_idacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_idsubacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_idsubacao"])){ 
       $sql  .= $virgula." si177_idsubacao = $this->si177_idsubacao ";
       $virgula = ",";
       if(trim($this->si177_idsubacao) == null ){ 
         $this->erro_sql = " Campo Código da subação não informado.";
         $this->erro_campo = "si177_idsubacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_naturezadespesa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_naturezadespesa"])){ 
       $sql  .= $virgula." si177_naturezadespesa = $this->si177_naturezadespesa ";
       $virgula = ",";
       if(trim($this->si177_naturezadespesa) == null ){ 
         $this->erro_sql = " Campo Natureza da Despesa não informado.";
         $this->erro_campo = "si177_naturezadespesa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_subelemento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_subelemento"])){ 
       $sql  .= $virgula." si177_subelemento = $this->si177_subelemento ";
       $virgula = ",";
       if(trim($this->si177_subelemento) == null ){ 
         $this->erro_sql = " Campo Subelemento da Despesa não informado.";
         $this->erro_campo = "si177_subelemento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si177_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si177_codfontrecursos"])){ 
       $sql  .= $virgula." si177_codfontrecursos = $this->si177_codfontrecursos ";
       $virgula = ",";
       if(trim($this->si177_codfontrecursos) == null ){ 
         $this->erro_sql = " Campo Fonte de Recursos não informado.";
         $this->erro_campo = "si177_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si177_sequencial!=null){
       $sql .= " si177_sequencial = $this->si177_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si177_sequencial));
       if($this->numrows>0){

         /*for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->si177_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_sequencial"]) || $this->si177_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009244,'".AddSlashes(pg_result($resaco,$conresaco,'si177_sequencial'))."','$this->si177_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_numemp"]) || $this->si177_numemp != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'si177_numemp'))."','$this->si177_numemp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_codorgaotce"]) || $this->si177_codorgaotce != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009245,'".AddSlashes(pg_result($resaco,$conresaco,'si177_codorgaotce'))."','$this->si177_codorgaotce',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_codunidadesub"]) || $this->si177_codunidadesub != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009246,'".AddSlashes(pg_result($resaco,$conresaco,'si177_codunidadesub'))."','$this->si177_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_codunidadesuborig"]) || $this->si177_codunidadesuborig != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009247,'".AddSlashes(pg_result($resaco,$conresaco,'si177_codunidadesuborig'))."','$this->si177_codunidadesuborig',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_codfuncao"]) || $this->si177_codfuncao != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009248,'".AddSlashes(pg_result($resaco,$conresaco,'si177_codfuncao'))."','$this->si177_codfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_codsubfuncao"]) || $this->si177_codsubfuncao != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009250,'".AddSlashes(pg_result($resaco,$conresaco,'si177_codsubfuncao'))."','$this->si177_codsubfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_codprograma"]) || $this->si177_codprograma != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'si177_codprograma'))."','$this->si177_codprograma',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_idacao"]) || $this->si177_idacao != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'si177_idacao'))."','$this->si177_idacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_idsubacao"]) || $this->si177_idsubacao != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'si177_idsubacao'))."','$this->si177_idsubacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_naturezadespesa"]) || $this->si177_naturezadespesa != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'si177_naturezadespesa'))."','$this->si177_naturezadespesa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_subelemento"]) || $this->si177_subelemento != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'si177_subelemento'))."','$this->si177_subelemento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si177_codfontrecursos"]) || $this->si177_codfontrecursos != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'si177_codfontrecursos'))."','$this->si177_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }*/
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Alterar Dotação RP Sicom nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si177_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Alterar Dotação RP Sicom nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si177_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si177_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si177_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si177_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         /*for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009244,'$si177_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_numemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_codorgaotce'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009246,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_codunidadesuborig'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_codprograma'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_idacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_idsubacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_subelemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }*/
       }
     }
     $sql = " delete from dotacaorpsicom
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si177_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si177_sequencial = $si177_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Alterar Dotação RP Sicom nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si177_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Alterar Dotação RP Sicom nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si177_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si177_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dotacaorpsicom";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si177_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dotacaorpsicom ";
     $sql .= "      inner join empempenho  on  empempenho.e60_numemp = dotacaorpsicom.si177_numemp";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = empempenho.e60_numcgm";
     $sql .= "      inner join db_config  on  db_config.codigo = empempenho.e60_instit";
     $sql .= "      inner join orcdotacao  on  orcdotacao.o58_anousu = empempenho.e60_anousu and  orcdotacao.o58_coddot = empempenho.e60_coddot";
     $sql .= "      inner join pctipocompra  on  pctipocompra.pc50_codcom = empempenho.e60_codcom";
     $sql .= "      inner join emptipo  on  emptipo.e41_codtipo = empempenho.e60_codtipo";
     $sql .= "      inner join concarpeculiar  on  concarpeculiar.c58_sequencial = empempenho.e60_concarpeculiar";
     $sql2 = "";
     if($dbwhere==""){
       if($si177_sequencial!=null ){
         $sql2 .= " where dotacaorpsicom.si177_sequencial = $si177_sequencial "; 
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
   function sql_query_file ( $si177_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dotacaorpsicom ";
     $sql2 = "";
     if($dbwhere==""){
       if($si177_sequencial!=null ){
         $sql2 .= " where dotacaorpsicom.si177_sequencial = $si177_sequencial "; 
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
