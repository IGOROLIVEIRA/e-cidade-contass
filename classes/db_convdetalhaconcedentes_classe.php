<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE convdetalhaconcedentes
class cl_convdetalhaconcedentes {
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
   var $c207_sequencial = 0;
   var $c207_nrodocumento = null;
   var $c207_esferaconcedente = 0;
   var $c207_valorconcedido = 0;
   var $c207_codconvenio = 0;
   var $c207_cnpjcpf = null;
   var $c207_descrconcedente = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 c207_sequencial = int8 = sequencial
                 c207_nrodocumento = varchar(14) = Número do  Documento
                 c207_esferaconcedente = int8 = Esfera do  Concedente
                 c207_valorconcedido = float8 = Valor a ser  concedido
                 c207_codconvenio = int8 = Cod convenio
                 c207_cnpjcpf = varchar(15) = Cnpj
                 c207_descrconcedente = varchar(100) = Descrição do Concedente
                 ";
   //funcao construtor da classe
   function cl_convdetalhaconcedentes() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("convdetalhaconcedentes");
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
       $this->c207_sequencial = ($this->c207_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c207_sequencial"]:$this->c207_sequencial);
       $this->c207_nrodocumento = ($this->c207_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["c207_nrodocumento"]:$this->c207_nrodocumento);
       $this->c207_esferaconcedente = ($this->c207_esferaconcedente == ""?@$GLOBALS["HTTP_POST_VARS"]["c207_esferaconcedente"]:$this->c207_esferaconcedente);
       $this->c207_valorconcedido = ($this->c207_valorconcedido == ""?@$GLOBALS["HTTP_POST_VARS"]["c207_valorconcedido"]:$this->c207_valorconcedido);
       $this->c207_codconvenio = ($this->c207_codconvenio == ""?@$GLOBALS["HTTP_POST_VARS"]["c207_codconvenio"]:$this->c207_codconvenio);
       $this->c207_descrconcedente = ($this->c207_descrconcedente == ""?@$GLOBALS["HTTP_POST_VARS"]["c207_descrconcedente"]:$this->c207_descrconcedente);
     }else{
       $this->c207_sequencial = ($this->c207_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c207_sequencial"]:$this->c207_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c207_sequencial){
      $this->atualizacampos();
     /*if($this->c207_nrodocumento == null ){
       $this->erro_sql = " Campo Número do  Documento nao Informado.";
       $this->erro_campo = "c207_nrodocumento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
     if($this->c207_esferaconcedente == null ){
       $this->erro_sql = " Campo Esfera do  Concedente nao Informado.";
       $this->erro_campo = "c207_esferaconcedente";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c207_valorconcedido == null ){
       $this->erro_sql = " Campo Valor a ser  concedido nao Informado.";
       $this->erro_campo = "c207_valorconcedido";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c207_codconvenio == null ){
       $this->erro_sql = " Campo Cod convenio nao Informado.";
       $this->erro_campo = "c207_codconvenio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($c207_sequencial == "" || $c207_sequencial == null ){
       $result = db_query("select nextval('convdetalhaconcedentes_c207_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: convdetalhaconcedentes_c207_sequencial_seq do campo: c207_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->c207_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from convdetalhaconcedentes_c207_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c207_sequencial)){
         $this->erro_sql = " Campo c207_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c207_sequencial = $c207_sequencial;
       }
     }
     if(($this->c207_sequencial == null) || ($this->c207_sequencial == "") ){
       $this->erro_sql = " Campo c207_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into convdetalhaconcedentes(
                                       c207_sequencial
                                      ,c207_nrodocumento
                                      ,c207_esferaconcedente
                                      ,c207_valorconcedido
                                      ,c207_codconvenio
                                      ,c207_descrconcedente
                       )
                values (
                                $this->c207_sequencial
                               ,'$this->c207_nrodocumento'
                               ,$this->c207_esferaconcedente
                               ,$this->c207_valorconcedido
                               ,$this->c207_codconvenio
                               ,".($this->c207_descrconcedente == "null" || $this->c207_descrconcedente == ""?"null":"'".$this->c207_descrconcedente."'")."

                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "convdetalhaconcedentes ($this->c207_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "convdetalhaconcedentes já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "convdetalhaconcedentes ($this->c207_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c207_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->c207_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011391,'$this->c207_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010398,2011391,'','".AddSlashes(pg_result($resaco,0,'c207_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010398,2011393,'','".AddSlashes(pg_result($resaco,0,'c207_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010398,2011394,'','".AddSlashes(pg_result($resaco,0,'c207_esferaconcedente'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010398,2011395,'','".AddSlashes(pg_result($resaco,0,'c207_valorconcedido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010398,2011396,'','".AddSlashes(pg_result($resaco,0,'c207_codconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($c207_sequencial=null) {
      $this->atualizacampos();
     $sql = " update convdetalhaconcedentes set ";
     $virgula = "";
     if(trim($this->c207_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c207_sequencial"])){
       $sql  .= $virgula." c207_sequencial = $this->c207_sequencial ";
       $virgula = ",";
       if(trim($this->c207_sequencial) == null ){
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "c207_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c207_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c207_nrodocumento"])){
       $sql  .= $virgula." c207_nrodocumento = '$this->c207_nrodocumento' ";
       $virgula = ",";
       if(trim($this->c207_nrodocumento) == null ){
         $this->erro_sql = " Campo Número do  Documento nao Informado.";
         $this->erro_campo = "c207_nrodocumento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c207_esferaconcedente)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c207_esferaconcedente"])){
       $sql  .= $virgula." c207_esferaconcedente = $this->c207_esferaconcedente ";
       $virgula = ",";
       if(trim($this->c207_esferaconcedente) == null ){
         $this->erro_sql = " Campo Esfera do  Concedente nao Informado.";
         $this->erro_campo = "c207_esferaconcedente";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c207_valorconcedido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c207_valorconcedido"])){
       $sql  .= $virgula." c207_valorconcedido = $this->c207_valorconcedido ";
       $virgula = ",";
       if(trim($this->c207_valorconcedido) == null ){
         $this->erro_sql = " Campo Valor a ser  concedido nao Informado.";
         $this->erro_campo = "c207_valorconcedido";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["c207_descrconcedente"])){
       $this->c207_descrconcedente = $GLOBALS["HTTP_POST_VARS"]["c207_descrconcedente"];
       if (empty($this->c207_descrconcedente)) {
        $sql  .= $virgula." c207_descrconcedente = null ";
       } else {
          $sql  .= $virgula." c207_descrconcedente = $this->c207_descrconcedente ";
       }
       $virgula = ",";
     }
     if(trim($this->c207_codconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c207_codconvenio"])){
       $sql  .= $virgula." c207_codconvenio = $this->c207_codconvenio ";
       $virgula = ",";
       if(trim($this->c207_codconvenio) == null ){
         $this->erro_sql = " Campo Cod convenio nao Informado.";
         $this->erro_campo = "c207_codconvenio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($c207_sequencial!=null){
       $sql .= " c207_sequencial = $this->c207_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->c207_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011391,'$this->c207_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c207_sequencial"]) || $this->c207_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010398,2011391,'".AddSlashes(pg_result($resaco,$conresaco,'c207_sequencial'))."','$this->c207_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c207_nrodocumento"]) || $this->c207_nrodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010398,2011393,'".AddSlashes(pg_result($resaco,$conresaco,'c207_nrodocumento'))."','$this->c207_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c207_esferaconcedente"]) || $this->c207_esferaconcedente != "")
           $resac = db_query("insert into db_acount values($acount,2010398,2011394,'".AddSlashes(pg_result($resaco,$conresaco,'c207_esferaconcedente'))."','$this->c207_esferaconcedente',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c207_valorconcedido"]) || $this->c207_valorconcedido != "")
           $resac = db_query("insert into db_acount values($acount,2010398,2011395,'".AddSlashes(pg_result($resaco,$conresaco,'c207_valorconcedido'))."','$this->c207_valorconcedido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c207_codconvenio"]) || $this->c207_codconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010398,2011396,'".AddSlashes(pg_result($resaco,$conresaco,'c207_codconvenio'))."','$this->c207_codconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "convdetalhaconcedentes nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c207_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "convdetalhaconcedentes nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($c207_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($c207_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011391,'$c207_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010398,2011391,'','".AddSlashes(pg_result($resaco,$iresaco,'c207_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010398,2011393,'','".AddSlashes(pg_result($resaco,$iresaco,'c207_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010398,2011394,'','".AddSlashes(pg_result($resaco,$iresaco,'c207_esferaconcedente'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010398,2011395,'','".AddSlashes(pg_result($resaco,$iresaco,'c207_valorconcedido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010398,2011396,'','".AddSlashes(pg_result($resaco,$iresaco,'c207_codconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from convdetalhaconcedentes
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c207_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c207_sequencial = $c207_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "convdetalhaconcedentes nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c207_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "convdetalhaconcedentes nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c207_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c207_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:convdetalhaconcedentes";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $c207_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from convdetalhaconcedentes ";
     $sql .= "      inner join convconvenios  on  convconvenios.c206_sequencial = convdetalhaconcedentes.c207_codconvenio";
     $sql2 = "";
     if($dbwhere==""){
       if($c207_sequencial!=null ){
         $sql2 .= " where convdetalhaconcedentes.c207_sequencial = $c207_sequencial ";
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
   function sql_query_file ( $c207_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from convdetalhaconcedentes ";
     $sql2 = "";
     if($dbwhere==""){
       if($c207_sequencial!=null ){
         $sql2 .= " where convdetalhaconcedentes.c207_sequencial = $c207_sequencial ";
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
