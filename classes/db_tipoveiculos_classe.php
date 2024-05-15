<?
//MODULO: sicom
//CLASSE DA ENTIDADE tipoveiculos
class cl_tipoveiculos { 
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
   var $si04_sequencial = 0; 
   var $si04_veiculos = 0; 
   var $si04_tipoveiculo = 0; 
   var $si04_especificacao = 0; 
   var $si04_situacao = 0; 
   var $si04_numcgm = null; 
   var $si04_descricao = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si04_sequencial = int8 = Sequencial 
                 si04_veiculos = int8 = Veiculos 
                 si04_tipoveiculo = int8 = Tipo de Veículo 
                 si04_especificacao = int8 = Especificação 
                 si04_situacao = int8 = Situação 
                 si04_numcgm = int8 = CGM
                 si04_descricao = text = Descrição 
                 ";
   //funcao construtor da classe 
   function cl_tipoveiculos() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("tipoveiculos"); 
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
       $this->si04_sequencial = ($this->si04_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si04_sequencial"]:$this->si04_sequencial);
       $this->si04_veiculos = ($this->si04_veiculos == ""?@$GLOBALS["HTTP_POST_VARS"]["si04_veiculos"]:$this->si04_veiculos);
       $this->si04_tipoveiculo = ($this->si04_tipoveiculo == ""?@$GLOBALS["HTTP_POST_VARS"]["si04_tipoveiculo"]:$this->si04_tipoveiculo);
       $this->si04_especificacao = ($this->si04_especificacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si04_especificacao"]:$this->si04_especificacao);
       $this->si04_situacao = ($this->si04_situacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si04_situacao"]:$this->si04_situacao);
       $this->si04_descricao = ($this->si04_descricao == ""?@$GLOBALS["HTTP_POST_VARS"]["si04_descricao"]:$this->si04_descricao);
     }else{
       $this->si04_sequencial = ($this->si04_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si04_sequencial"]:$this->si04_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si04_sequencial){ 
      $this->atualizacampos();
     if($this->si04_veiculos == null ){ 
       $this->erro_sql = " Campo Veiculos nao Informado.";
       $this->erro_campo = "si04_veiculos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si04_tipoveiculo == null ){ 
       $this->erro_sql = " Campo Tipo de Veículo nao Informado.";
       $this->erro_campo = "si04_tipoveiculo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si04_especificacao == null ){ 
       $this->erro_sql = " Campo Especificação nao Informado.";
       $this->erro_campo = "si04_especificacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si04_situacao == null ){ 
       $this->erro_sql = " Campo Situação nao Informado.";
       $this->erro_campo = "si04_situacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si04_numcgm == null && ($this->si04_situacao == 2 || $this->si04_situacao == 3)){ 
       $this->erro_sql = " Campo Cgm nao Informado.";
       $this->erro_campo = "si04_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si04_descricao == null ){ 
       $this->erro_sql = " Campo Descrição nao Informado.";
       $this->erro_campo = "si04_descricao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     if($si04_sequencial == "" || $si04_sequencial == null ){
       $result = db_query("select nextval('sic_tipoveiculos_si04_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: sic_tipoveiculos_si04_sequencial_seq do campo: si04_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si04_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from sic_tipoveiculos_si04_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si04_sequencial)){
         $this->erro_sql = " Campo si04_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si04_sequencial = $si04_sequencial; 
       }
     }
     if(($this->si04_sequencial == null) || ($this->si04_sequencial == "") ){ 
       $this->erro_sql = " Campo si04_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     
     $sql = "insert into tipoveiculos(
                                       si04_sequencial 
                                      ,si04_veiculos 
                                      ,si04_tipoveiculo 
                                      ,si04_especificacao 
                                      ,si04_situacao 
                                      ,si04_numcgm
                                      ,si04_descricao 
                       )
                values (
                                $this->si04_sequencial 
                               ,$this->si04_veiculos 
                               ,$this->si04_tipoveiculo 
                               ,$this->si04_especificacao 
                               ,$this->si04_situacao 
                               ,".($this->si04_numcgm == null ? 'null' : $this->si04_numcgm)." 
                               ,'$this->si04_descricao' 
                      )";
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Tipo de Veículo ($this->si04_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Tipo de Veículo já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Tipo de Veículo ($this->si04_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si04_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si04_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009285,'$this->si04_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010204,2009285,'','".AddSlashes(pg_result($resaco,0,'si04_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010204,2009287,'','".AddSlashes(pg_result($resaco,0,'si04_veiculos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010204,2009288,'','".AddSlashes(pg_result($resaco,0,'si04_tipoveiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010204,2009289,'','".AddSlashes(pg_result($resaco,0,'si04_especificacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010204,2009290,'','".AddSlashes(pg_result($resaco,0,'si04_situacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010204,2009291,'','".AddSlashes(pg_result($resaco,0,'si04_descricao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   
   
   //funcao verifica tabela
   function verifica ($si04_veiculos=null){
   	
   	$sSql = "select * from tipoveiculos where si04_veiculos =". $si04_veiculos;
   	$result = db_query($sSql);
   	return pg_num_rows($result);
   }
   
   // funcao para alteracao
   function alterar ($si04_veiculos=null) { 
      $this->atualizacampos();
     $sql = " update tipoveiculos set ";
     $virgula = "";
     if(trim($this->si04_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si04_sequencial"])){ 
       $sql  .= $virgula." si04_sequencial = $this->si04_sequencial ";
       $virgula = ",";
       if(trim($this->si04_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "si04_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si04_veiculos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si04_veiculos"])){ 
       $sql  .= $virgula." si04_veiculos = $this->si04_veiculos ";
       $virgula = ",";
       if(trim($this->si04_veiculos) == null ){ 
         $this->erro_sql = " Campo Veiculos nao Informado.";
         $this->erro_campo = "si04_veiculos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si04_tipoveiculo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si04_tipoveiculo"])){ 
       $sql  .= $virgula." si04_tipoveiculo = $this->si04_tipoveiculo ";
       $virgula = ",";
       if(trim($this->si04_tipoveiculo) == null ){ 
         $this->erro_sql = " Campo Tipo de Veículo nao Informado.";
         $this->erro_campo = "si04_tipoveiculo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si04_especificacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si04_especificacao"])){ 
       $sql  .= $virgula." si04_especificacao = $this->si04_especificacao ";
       $virgula = ",";
       if(trim($this->si04_especificacao) == null ){ 
         $this->erro_sql = " Campo Especificação nao Informado.";
         $this->erro_campo = "si04_especificacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si04_situacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si04_situacao"])){ 
       $sql  .= $virgula." si04_situacao = $this->si04_situacao ";
       $virgula = ",";
       if(trim($this->si04_situacao) == null ){ 
         $this->erro_sql = " Campo Situação nao Informado.";
         $this->erro_campo = "si04_situacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si04_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si04_numcgm"])){ 
       if(!empty($this->si04_numcgm)){
         $sql  .= $virgula." si04_numcgm = $this->si04_numcgm ";
       }else{
         $sql  .= $virgula." si04_numcgm = null";
       }
       $virgula = ",";
     }
     if(trim($this->si04_descricao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si04_descricao"])){ 
       $sql  .= $virgula." si04_descricao = '$this->si04_descricao' ";
       $virgula = ",";
       if(trim($this->si04_descricao) == null ){ 
         $this->erro_sql = " Campo Descrição nao Informado.";
         $this->erro_campo = "si04_descricao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si04_veiculos!=null){
       $sql .= " si04_veiculos = $si04_veiculos";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si04_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009285,'$this->si04_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si04_sequencial"]) || $this->si04_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010204,2009285,'".AddSlashes(pg_result($resaco,$conresaco,'si04_sequencial'))."','$this->si04_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si04_veiculos"]) || $this->si04_veiculos != "")
           $resac = db_query("insert into db_acount values($acount,2010204,2009287,'".AddSlashes(pg_result($resaco,$conresaco,'si04_veiculos'))."','$this->si04_veiculos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si04_tipoveiculo"]) || $this->si04_tipoveiculo != "")
           $resac = db_query("insert into db_acount values($acount,2010204,2009288,'".AddSlashes(pg_result($resaco,$conresaco,'si04_tipoveiculo'))."','$this->si04_tipoveiculo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si04_especificacao"]) || $this->si04_especificacao != "")
           $resac = db_query("insert into db_acount values($acount,2010204,2009289,'".AddSlashes(pg_result($resaco,$conresaco,'si04_especificacao'))."','$this->si04_especificacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si04_situacao"]) || $this->si04_situacao != "")
           $resac = db_query("insert into db_acount values($acount,2010204,2009290,'".AddSlashes(pg_result($resaco,$conresaco,'si04_situacao'))."','$this->si04_situacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si04_descricao"]) || $this->si04_descricao != "")
           $resac = db_query("insert into db_acount values($acount,2010204,2009291,'".AddSlashes(pg_result($resaco,$conresaco,'si04_descricao'))."','$this->si04_descricao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Tipo de Veículo nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si04_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Tipo de Veículo nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si04_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si04_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si04_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si04_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009285,'$si04_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010204,2009285,'','".AddSlashes(pg_result($resaco,$iresaco,'si04_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010204,2009287,'','".AddSlashes(pg_result($resaco,$iresaco,'si04_veiculos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010204,2009288,'','".AddSlashes(pg_result($resaco,$iresaco,'si04_tipoveiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010204,2009289,'','".AddSlashes(pg_result($resaco,$iresaco,'si04_especificacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010204,2009290,'','".AddSlashes(pg_result($resaco,$iresaco,'si04_situacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010204,2009291,'','".AddSlashes(pg_result($resaco,$iresaco,'si04_descricao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from tipoveiculos
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si04_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si04_sequencial = $si04_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Tipo de Veículo nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si04_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Tipo de Veículo nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si04_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si04_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:tipoveiculos";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si04_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from tipoveiculos ";
     $sql .= "      inner join veiculos  on  veiculos.ve01_codigo = tipoveiculos.si04_veiculos";
     $sql .= "      inner join ceplocalidades  on  ceplocalidades.cp05_codlocalidades = veiculos.ve01_ceplocalidades";
     $sql .= "      left join veiccadtipo  on  veiccadtipo.ve20_codigo = veiculos.ve01_veiccadtipo";
     $sql .= "      left join veiccadmarca  on  veiccadmarca.ve21_codigo = veiculos.ve01_veiccadmarca";
     $sql .= "      left join veiccadmodelo  on  veiccadmodelo.ve22_codigo = veiculos.ve01_veiccadmodelo";
     $sql .= "      left join veiccadcor  on  veiccadcor.ve23_codigo = veiculos.ve01_veiccadcor";
     $sql .= "      left join veiccadtipocapacidade  on  veiccadtipocapacidade.ve24_codigo = veiculos.ve01_veiccadtipocapacidade";
     $sql .= "      left join veiccadcategcnh  on  veiccadcategcnh.ve30_codigo = veiculos.ve01_veiccadcategcnh";
     $sql .= "      left join veiccadproced  on  veiccadproced.ve25_codigo = veiculos.ve01_veiccadproced";
     $sql .= "      left join veiccadpotencia  on  veiccadpotencia.ve31_codigo = veiculos.ve01_veiccadpotencia";
     $sql .= "      left join veiccadcateg  as a on   a.ve32_codigo = veiculos.ve01_veiccadcateg";
     $sql .= "      left join veictipoabast  on  veictipoabast.ve07_sequencial = veiculos.ve01_veictipoabast";
     $sql2 = "";
     if($dbwhere==""){
       if($si04_sequencial!=null ){
         $sql2 .= " where tipoveiculos.si04_sequencial = $si04_sequencial "; 
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
   function sql_query_file ( $si04_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from tipoveiculos ";
     $sql2 = "";
     if($dbwhere==""){
       if($si04_sequencial!=null ){
         $sql2 .= " where tipoveiculos.si04_sequencial = $si04_sequencial "; 
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
