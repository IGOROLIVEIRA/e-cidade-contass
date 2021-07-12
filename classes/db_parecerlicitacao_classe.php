<?
//MODULO: licitacao
//CLASSE DA ENTIDADE parecerlicitacao
class cl_parecerlicitacao { 
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
   var $l200_sequencial = 0; 
   var $l200_licitacao = 0; 
   var $l200_exercicio = 0; 
   var $l200_data_dia = null; 
   var $l200_data_mes = null; 
   var $l200_data_ano = null; 
   var $l200_data = null; 
   var $l200_tipoparecer = 0; 
   var $l200_numcgm = 0; 

   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 l200_sequencial = int4 = Sequencial 
                 l200_licitacao = int4 = Licicitação 
                 l200_exercicio = int4 = exercício 
                 l200_data = date = Data do parecer 
                 l200_tipoparecer = int4 = Tipo de parecer 
                 l200_numcgm = int4 = Número do CGM 
                 pc50_descr
                 ";
   //funcao construtor da classe 
   function cl_parecerlicitacao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("parecerlicitacao"); 
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
       $this->l200_sequencial = ($this->l200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l200_sequencial"]:$this->l200_sequencial);
       $this->l200_licitacao = ($this->l200_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l200_licitacao"]:$this->l200_licitacao);
       $this->l200_exercicio = ($this->l200_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["l200_exercicio"]:$this->l200_exercicio);
       if($this->l200_data == ""){
         $this->l200_data_dia = ($this->l200_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l200_data_dia"]:$this->l200_data_dia);
         $this->l200_data_mes = ($this->l200_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l200_data_mes"]:$this->l200_data_mes);
         $this->l200_data_ano = ($this->l200_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l200_data_ano"]:$this->l200_data_ano);
         if($this->l200_data_dia != ""){
            $this->l200_data = $this->l200_data_ano."-".$this->l200_data_mes."-".$this->l200_data_dia;
         }
       }
       $this->l200_tipoparecer = ($this->l200_tipoparecer == ""?@$GLOBALS["HTTP_POST_VARS"]["l200_tipoparecer"]:$this->l200_tipoparecer);
       $this->l200_numcgm = ($this->l200_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["l200_numcgm"]:$this->l200_numcgm);
     }else{
       $this->l200_sequencial = ($this->l200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l200_sequencial"]:$this->l200_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($l200_sequencial){ 
      $this->atualizacampos();
     if($this->l200_licitacao == null ){ 
       $this->erro_sql = " Campo Licitação nao Informado.";
       $this->erro_campo = "l200_licitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l200_exercicio == null ){ 
       $this->erro_sql = " Campo exercício nao Informado.";
       $this->erro_campo = "l200_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l200_data == null ){ 
       $this->erro_sql = " Campo Data do parecer nao Informado.";
       $this->erro_campo = "l200_data_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l200_tipoparecer == null ){ 
       $this->erro_sql = " Campo Tipo de parecer nao Informado.";
       $this->erro_campo = "l200_tipoparecer";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l200_numcgm == null ){ 
       $this->erro_sql = " Campo Número do CGM nao Informado.";
       $this->erro_campo = "l200_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

       if($l200_sequencial == "" || $l200_sequencial == null ){
       $result = db_query("select nextval('parecerlicitacao_l200_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: parecerlicitacao_l200_sequencial_seq do campo: l200_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->l200_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from parecerlicitacao_l200_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $l200_sequencial)){
         $this->erro_sql = " Campo l200_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->l200_sequencial = $l200_sequencial; 
       }
     }
       
     if(($this->l200_sequencial == null) || ($this->l200_sequencial == "") ){ 
       $this->erro_sql = " Campo l200_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into parecerlicitacao(
                                       l200_sequencial 
                                      ,l200_licitacao 
                                      ,l200_exercicio 
                                      ,l200_data 
                                      ,l200_tipoparecer 
                                      ,l200_numcgm 
                       )
                values (
                                $this->l200_sequencial 
                               ,$this->l200_licitacao 
                               ,$this->l200_exercicio 
                               ,".($this->l200_data == "null" || $this->l200_data == ""?"null":"'".$this->l200_data."'")." 
                               ,$this->l200_tipoparecer 
                               ,$this->l200_numcgm 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Cadastro de parecer ($this->l200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro de parecer já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Cadastro de parecer ($this->l200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l200_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->l200_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009394,'$this->l200_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010215,2009394,'','".AddSlashes(pg_result($resaco,0,'l200_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010215,2009405,'','".AddSlashes(pg_result($resaco,0,'l200_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010215,2009398,'','".AddSlashes(pg_result($resaco,0,'l200_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010215,2009401,'','".AddSlashes(pg_result($resaco,0,'l200_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010215,2009402,'','".AddSlashes(pg_result($resaco,0,'l200_tipoparecer'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010215,2009403,'','".AddSlashes(pg_result($resaco,0,'l200_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($l200_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update parecerlicitacao set ";
     $virgula = "";
     if(trim($this->l200_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l200_sequencial"])){ 
       $sql  .= $virgula." l200_sequencial = $this->l200_sequencial ";
       $virgula = ",";
       if(trim($this->l200_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "l200_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l200_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l200_licitacao"])){ 
       $sql  .= $virgula." l200_licitacao = $this->l200_licitacao ";
       $virgula = ",";
       if(trim($this->l200_licitacao) == null ){ 
         $this->erro_sql = " Campo Licitação nao Informado.";
         $this->erro_campo = "l200_licitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l200_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l200_exercicio"])){ 
       $sql  .= $virgula." l200_exercicio = $this->l200_exercicio ";
       $virgula = ",";
       if(trim($this->l200_exercicio) == null ){ 
         $this->erro_sql = " Campo exercício nao Informado.";
         $this->erro_campo = "l200_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l200_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l200_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l200_data_dia"] !="") ){ 
       $sql  .= $virgula." l200_data = '$this->l200_data' ";
       $virgula = ",";
       if(trim($this->l200_data) == null ){ 
         $this->erro_sql = " Campo Data do parecer nao Informado.";
         $this->erro_campo = "l200_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l200_data_dia"])){ 
         $sql  .= $virgula." l200_data = null ";
         $virgula = ",";
         if(trim($this->l200_data) == null ){ 
           $this->erro_sql = " Campo Data do parecer nao Informado.";
           $this->erro_campo = "l200_data_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->l200_tipoparecer)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l200_tipoparecer"])){ 
       $sql  .= $virgula." l200_tipoparecer = $this->l200_tipoparecer ";
       $virgula = ",";
       if(trim($this->l200_tipoparecer) == null ){ 
         $this->erro_sql = " Campo Tipo de parecer nao Informado.";
         $this->erro_campo = "l200_tipoparecer";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l200_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l200_numcgm"])){ 
       $sql  .= $virgula." l200_numcgm = $this->l200_numcgm ";
       $virgula = ",";
       if(trim($this->l200_numcgm) == null ){ 
         $this->erro_sql = " Campo Número do CGM nao Informado.";
         $this->erro_campo = "l200_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($l200_sequencial!=null){
       $sql .= " l200_sequencial = $this->l200_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->l200_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009394,'$this->l200_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l200_sequencial"]) || $this->l200_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010215,2009394,'".AddSlashes(pg_result($resaco,$conresaco,'l200_sequencial'))."','$this->l200_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l200_licitacao"]) || $this->l200_licitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010215,2009405,'".AddSlashes(pg_result($resaco,$conresaco,'l200_licitacao'))."','$this->l200_licitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l200_exercicio"]) || $this->l200_exercicio != "")
           $resac = db_query("insert into db_acount values($acount,2010215,2009398,'".AddSlashes(pg_result($resaco,$conresaco,'l200_exercicio'))."','$this->l200_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l200_data"]) || $this->l200_data != "")
           $resac = db_query("insert into db_acount values($acount,2010215,2009401,'".AddSlashes(pg_result($resaco,$conresaco,'l200_data'))."','$this->l200_data',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l200_tipoparecer"]) || $this->l200_tipoparecer != "")
           $resac = db_query("insert into db_acount values($acount,2010215,2009402,'".AddSlashes(pg_result($resaco,$conresaco,'l200_tipoparecer'))."','$this->l200_tipoparecer',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l200_numcgm"]) || $this->l200_numcgm != "")
           $resac = db_query("insert into db_acount values($acount,2010215,2009403,'".AddSlashes(pg_result($resaco,$conresaco,'l200_numcgm'))."','$this->l200_numcgm',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de parecer nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->l200_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de parecer nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->l200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($l200_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($l200_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009394,'$l200_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010215,2009394,'','".AddSlashes(pg_result($resaco,$iresaco,'l200_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010215,2009405,'','".AddSlashes(pg_result($resaco,$iresaco,'l200_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010215,2009398,'','".AddSlashes(pg_result($resaco,$iresaco,'l200_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010215,2009401,'','".AddSlashes(pg_result($resaco,$iresaco,'l200_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010215,2009402,'','".AddSlashes(pg_result($resaco,$iresaco,'l200_tipoparecer'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010215,2009403,'','".AddSlashes(pg_result($resaco,$iresaco,'l200_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from parecerlicitacao
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($l200_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " l200_sequencial = $l200_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de parecer nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$l200_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de parecer nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$l200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$l200_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:parecerlicitacao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $l200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from parecerlicitacao ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = parecerlicitacao.l200_numcgm";
     $sql .= "      inner join liclicita  on  liclicita.l20_codigo = parecerlicitacao.l200_licitacao";
     $sql .= "      inner join db_config  on  db_config.codigo = liclicita.l20_instit";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = liclicita.l20_id_usucria";
     $sql .= "      inner join cflicita  on  cflicita.l03_codigo = liclicita.l20_codtipocom";
     $sql .= "      inner join liclocal  on  liclocal.l26_codigo = liclicita.l20_liclocal";
     $sql .= "      inner join liccomissao  on  liccomissao.l30_codigo = liclicita.l20_liccomissao";
     $sql .= "      inner join licsituacao  on  licsituacao.l08_sequencial = liclicita.l20_licsituacao";
     $sql .= "      inner join pctipocompra on pctipocompra.pc50_codcom = cflicita.l03_codcom";
     $sql2 = "";
     if($dbwhere==""){
       if($l200_sequencial!=null ){
         $sql2 .= " where parecerlicitacao.l200_sequencial = $l200_sequencial "; 
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
   function sql_query_file ( $l200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from parecerlicitacao ";
     $sql2 = "";
     if($dbwhere==""){
       if($l200_sequencial!=null ){
         $sql2 .= " where parecerlicitacao.l200_sequencial = $l200_sequencial "; 
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
