<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE consconsorcios
class cl_consconsorcios { 
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
   var $c200_sequencial; 
   var $c200_instit = 0; 
   var $c200_codconsorcio = 0; 
   var $c200_numcgm = 0; 
   var $c200_areaatuacao = 0; 
   var $c200_descrarea = null;
   var $c200_dataadesao_dia = null;
   var $c200_dataadesao_mes = null;
   var $c200_dataadesao_ano = null;
   var $c200_dataadesao = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 c200_sequencial = int8 = Código Sequencial 
                 c200_instit = int8 = Código Instituição 
                 c200_codconsorcio = int8 = Código do Consórcio no TCE 
                 c200_numcgm = int8 = Número do Cgm 
                 c200_areaatuacao = int8 = Área de atuação 
                 c200_descrarea = text = Descrição da Atuação
                 c200_dataadesao = date = Data de Adesão 
                 ";
   //funcao construtor da classe 
   function cl_consconsorcios() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("consconsorcios"); 
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
       $this->c200_sequencial = ($this->c200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_sequencial"]:$this->c200_sequencial);
       $this->c200_instit = ($this->c200_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_instit"]:$this->c200_instit);
       $this->c200_codconsorcio = ($this->c200_codconsorcio == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_codconsorcio"]:$this->c200_codconsorcio);
       $this->c200_numcgm = ($this->c200_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_numcgm"]:$this->c200_numcgm);
       $this->c200_areaatuacao = ($this->c200_areaatuacao == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_areaatuacao"]:$this->c200_areaatuacao);
       $this->c200_descrarea = ($this->c200_descrarea == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_descrarea"]:$this->c200_descrarea);
       if($this->c200_dataadesao == ""){
         $this->c200_dataadesao_dia = ($this->c200_dataadesao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_dataadesao_dia"]:$this->c200_dataadesao_dia);
         $this->c200_dataadesao_mes = ($this->c200_dataadesao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_dataadesao_mes"]:$this->c200_dataadesao_mes);
         $this->c200_dataadesao_ano = ($this->c200_dataadesao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_dataadesao_ano"]:$this->c200_dataadesao_ano);
         if($this->c200_dataadesao_dia != ""){
            $this->c200_dataadesao = $this->c200_dataadesao_ano."-".$this->c200_dataadesao_mes."-".$this->c200_dataadesao_dia;
         }
       }
       
     }else{
       $this->c200_sequencial = ($this->c200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c200_sequencial"]:$this->c200_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c200_sequencial){ 
      $this->atualizacampos();
     if($this->c200_instit == null ){ 
       $this->erro_sql = " Campo Código Instituição nao Informado.";
       $this->erro_campo = "c200_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c200_codconsorcio == null ){ 
       $this->erro_sql = " Campo Código do Consórcio no TCE nao Informado.";
       $this->erro_campo = "c200_codconsorcio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c200_numcgm == null ){ 
       $this->erro_sql = " Campo Número do Cgm nao Informado.";
       $this->erro_campo = "c200_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c200_areaatuacao == null ){ 
       $this->erro_sql = " Campo Área de atuação nao Informado.";
       $this->erro_campo = "c200_areaatuacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c200_descrarea == null ){ 
       $this->erro_sql = " Campo Descrição da Atuação nao Informado.";
       $this->erro_campo = "c200_descrarea";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c200_dataadesao == null ){
       $this->erro_sql = " Campo Data de Adesão nao Informado.";
       $this->erro_campo = "c200_dataadesao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($c200_sequencial == "" || $c200_sequencial == null ){
       $result = db_query("select nextval('consconsorcios_c200_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: consconsorcios_c200_sequencial_seq do campo: c200_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->c200_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from consconsorcios_c200_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c200_sequencial)){
         $this->erro_sql = " Campo c200_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c200_sequencial = $c200_sequencial; 
       }
     }
     if(($this->c200_sequencial == null) || ($this->c200_sequencial == "") ){ 
       $this->erro_sql = " Campo c200_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into consconsorcios(
                                       c200_sequencial 
                                      ,c200_instit 
                                      ,c200_codconsorcio 
                                      ,c200_numcgm 
                                      ,c200_areaatuacao 
                                      ,c200_descrarea
                                      ,c200_dataadesao
                       )
                values (
                                $this->c200_sequencial 
                               ,$this->c200_instit 
                               ,$this->c200_codconsorcio 
                               ,$this->c200_numcgm 
                               ,$this->c200_areaatuacao 
                               ,'$this->c200_descrarea'
                               ,".($this->c200_dataadesao == "null" || $this->c200_dataadesao == ""?"null":"'".$this->c200_dataadesao."'")."
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Consórcio ($this->c200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Consórcio já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Consórcio ($this->c200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c200_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->c200_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009406,'$this->c200_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010217,2009406,'','".AddSlashes(pg_result($resaco,0,'c200_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010217,2009407,'','".AddSlashes(pg_result($resaco,0,'c200_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010217,2009408,'','".AddSlashes(pg_result($resaco,0,'c200_codconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010217,2009409,'','".AddSlashes(pg_result($resaco,0,'c200_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010217,2009410,'','".AddSlashes(pg_result($resaco,0,'c200_areaatuacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010217,2009411,'','".AddSlashes(pg_result($resaco,0,'c200_descrarea'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($c200_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update consconsorcios set ";
     $virgula = "";
     if(trim($this->c200_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c200_sequencial"])){ 
       $sql  .= $virgula." c200_sequencial = $this->c200_sequencial ";
       $virgula = ",";
       if(trim($this->c200_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "c200_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c200_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c200_instit"])){ 
       $sql  .= $virgula." c200_instit = $this->c200_instit ";
       $virgula = ",";
       if(trim($this->c200_instit) == null ){ 
         $this->erro_sql = " Campo Código Instituição nao Informado.";
         $this->erro_campo = "c200_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c200_codconsorcio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c200_codconsorcio"])){ 
       $sql  .= $virgula." c200_codconsorcio = $this->c200_codconsorcio ";
       $virgula = ",";
       if(trim($this->c200_codconsorcio) == null ){ 
         $this->erro_sql = " Campo Código do Consórcio no TCE nao Informado.";
         $this->erro_campo = "c200_codconsorcio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c200_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c200_numcgm"])){ 
       $sql  .= $virgula." c200_numcgm = $this->c200_numcgm ";
       $virgula = ",";
       if(trim($this->c200_numcgm) == null ){ 
         $this->erro_sql = " Campo Número do Cgm nao Informado.";
         $this->erro_campo = "c200_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c200_areaatuacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c200_areaatuacao"])){ 
       $sql  .= $virgula." c200_areaatuacao = $this->c200_areaatuacao ";
       $virgula = ",";
       if(trim($this->c200_areaatuacao) == null ){ 
         $this->erro_sql = " Campo Área de atuação nao Informado.";
         $this->erro_campo = "c200_areaatuacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c200_descrarea)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c200_descrarea"])){ 
       $sql  .= $virgula." c200_descrarea = '$this->c200_descrarea' ";
       $virgula = ",";
       if(trim($this->c200_descrarea) == null ){ 
         $this->erro_sql = " Campo Descrição da Atuação nao Informado.";
         $this->erro_campo = "c200_descrarea";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c200_dataadesao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c200_dataadesao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c200_dataadesao_dia"] !="") ){
       $sql  .= $virgula." c200_dataadesao = '$this->c200_dataadesao' ";
       $virgula = ",";
       if(trim($this->c200_dataadesao) == null ){
         $this->erro_sql = " Campo Data de Adesão nao Informado.";
         $this->erro_campo = "c200_dataadesao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["c200_dataadesao_dia"])){
         $sql  .= $virgula." c200_dataadesao = null ";
         $virgula = ",";
         if(trim($this->c200_dataadesao) == null ){
           $this->erro_sql = " Campo Data de Adesão nao Informado.";
           $this->erro_campo = "c200_dataadesao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if($c200_sequencial!=null){
       $sql .= " c200_sequencial = $this->c200_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->c200_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009406,'$this->c200_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c200_sequencial"]) || $this->c200_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010217,2009406,'".AddSlashes(pg_result($resaco,$conresaco,'c200_sequencial'))."','$this->c200_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c200_instit"]) || $this->c200_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010217,2009407,'".AddSlashes(pg_result($resaco,$conresaco,'c200_instit'))."','$this->c200_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c200_codconsorcio"]) || $this->c200_codconsorcio != "")
           $resac = db_query("insert into db_acount values($acount,2010217,2009408,'".AddSlashes(pg_result($resaco,$conresaco,'c200_codconsorcio'))."','$this->c200_codconsorcio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c200_numcgm"]) || $this->c200_numcgm != "")
           $resac = db_query("insert into db_acount values($acount,2010217,2009409,'".AddSlashes(pg_result($resaco,$conresaco,'c200_numcgm'))."','$this->c200_numcgm',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c200_areaatuacao"]) || $this->c200_areaatuacao != "")
           $resac = db_query("insert into db_acount values($acount,2010217,2009410,'".AddSlashes(pg_result($resaco,$conresaco,'c200_areaatuacao'))."','$this->c200_areaatuacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c200_descrarea"]) || $this->c200_descrarea != "")
           $resac = db_query("insert into db_acount values($acount,2010217,2009411,'".AddSlashes(pg_result($resaco,$conresaco,'c200_descrarea'))."','$this->c200_descrarea',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Consórcio nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c200_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Consórcio nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($c200_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($c200_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009406,'$c200_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010217,2009406,'','".AddSlashes(pg_result($resaco,$iresaco,'c200_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010217,2009407,'','".AddSlashes(pg_result($resaco,$iresaco,'c200_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010217,2009408,'','".AddSlashes(pg_result($resaco,$iresaco,'c200_codconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010217,2009409,'','".AddSlashes(pg_result($resaco,$iresaco,'c200_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010217,2009410,'','".AddSlashes(pg_result($resaco,$iresaco,'c200_areaatuacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010217,2009411,'','".AddSlashes(pg_result($resaco,$iresaco,'c200_descrarea'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from consconsorcios
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c200_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c200_sequencial = $c200_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Consórcio nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c200_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Consórcio nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c200_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:consconsorcios";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $c200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consconsorcios ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = consconsorcios.c200_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($c200_sequencial!=null ){
         $sql2 .= " where consconsorcios.c200_sequencial = $c200_sequencial "; 
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
   function sql_query_file ( $c200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consconsorcios ";
     $sql2 = "";
     if($dbwhere==""){
       if($c200_sequencial!=null ){
         $sql2 .= " where consconsorcios.c200_sequencial = $c200_sequencial "; 
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
  
  function valida_inclusao_consorcio($numcgm){
  	
  	$sql = "select z01_cgccpf from consconsorcios 
  	join cgm on c200_numcgm = z01_numcgm where z01_cgccpf 
  	in(select z01_cgccpf from consconsorcios join cgm on c200_numcgm = z01_numcgm where z01_numcgm = $numcgm)";
  	$result = db_query($sql);
  	if (pg_num_rows($result) > 0) {
  		return false;
  	}
    return true;
  	
  }
}
?>
