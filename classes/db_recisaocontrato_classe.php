<?
//MODULO: Sicom
//CLASSE DA ENTIDADE recisaocontrato
class cl_recisaocontrato { 
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
   var $si01_codigo = 0; 
   var $si01_numcontrato = null; 
   var $si01_dataassinatura_dia = null; 
   var $si01_dataassinatura_mes = null; 
   var $si01_dataassinatura_ano = null; 
   var $si01_dataassinatura = null; 
   var $si01_datarecisao_dia = null; 
   var $si01_datarecisao_mes = null; 
   var $si01_datarecisao_ano = null; 
   var $si01_datarecisao = null; 
   var $si01_valorcancelado = 0; 
   var $si01_ano = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si01_codigo = int8 = codigo 
                 si01_numcontrato = varchar(20) = Numero Contrato 
                 si01_dataassinatura = date = Data da Assinatura 
                 si01_datarecisao = date = Data da Recisao 
                 si01_valorcancelado = float8 = Valor Cancelado 
                 si01_ano = int8 = Ano Contrato 
                 ";
   //funcao construtor da classe 
   function cl_recisaocontrato() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("recisaocontrato"); 
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
       $this->si01_codigo = ($this->si01_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_codigo"]:$this->si01_codigo);
       $this->si01_numcontrato = ($this->si01_numcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_numcontrato"]:$this->si01_numcontrato);
       if($this->si01_dataassinatura == ""){
         $this->si01_dataassinatura_dia = ($this->si01_dataassinatura_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_dataassinatura_dia"]:$this->si01_dataassinatura_dia);
         $this->si01_dataassinatura_mes = ($this->si01_dataassinatura_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_dataassinatura_mes"]:$this->si01_dataassinatura_mes);
         $this->si01_dataassinatura_ano = ($this->si01_dataassinatura_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_dataassinatura_ano"]:$this->si01_dataassinatura_ano);
         if($this->si01_dataassinatura_dia != ""){
            $this->si01_dataassinatura = $this->si01_dataassinatura_ano."-".$this->si01_dataassinatura_mes."-".$this->si01_dataassinatura_dia;
         }
       }
       if($this->si01_datarecisao == ""){
         $this->si01_datarecisao_dia = ($this->si01_datarecisao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_datarecisao_dia"]:$this->si01_datarecisao_dia);
         $this->si01_datarecisao_mes = ($this->si01_datarecisao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_datarecisao_mes"]:$this->si01_datarecisao_mes);
         $this->si01_datarecisao_ano = ($this->si01_datarecisao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_datarecisao_ano"]:$this->si01_datarecisao_ano);
         if($this->si01_datarecisao_dia != ""){
            $this->si01_datarecisao = $this->si01_datarecisao_ano."-".$this->si01_datarecisao_mes."-".$this->si01_datarecisao_dia;
         }
       }
       $this->si01_valorcancelado = ($this->si01_valorcancelado == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_valorcancelado"]:$this->si01_valorcancelado);
       $this->si01_ano = ($this->si01_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_ano"]:$this->si01_ano);
     }else{
       $this->si01_codigo = ($this->si01_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["si01_codigo"]:$this->si01_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($si01_codigo){ 
      $this->atualizacampos();
     if($this->si01_numcontrato == null ){ 
       $this->erro_sql = " Campo Numero Contrato nao Informado.";
       $this->erro_campo = "si01_numcontrato";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si01_dataassinatura == null ){ 
       $this->si01_dataassinatura = "null";
     }
     if($this->si01_datarecisao == null ){ 
       $this->si01_datarecisao = "null";
     }
     if($this->si01_valorcancelado == null ){ 
       $this->si01_valorcancelado = "0";
     }
     if($this->si01_ano == null ){ 
       $this->si01_ano = "0";
     }
     if($si01_codigo == "" || $si01_codigo == null ){
       $result = db_query("select nextval('recisaocontrato_si01_codigo_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: recisaocontrato_si01_codigo_seq do campo: si01_codigo"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si01_codigo = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from recisaocontrato_si01_codigo_seq");
       if(($result != false) && (pg_result($result,0,0) < $si01_codigo)){
         $this->erro_sql = " Campo si01_codigo maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si01_codigo = $si01_codigo; 
       }
     }
     if(($this->si01_codigo == null) || ($this->si01_codigo == "") ){ 
       $this->erro_sql = " Campo si01_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into recisaocontrato(
                                       si01_codigo 
                                      ,si01_numcontrato 
                                      ,si01_dataassinatura 
                                      ,si01_datarecisao 
                                      ,si01_valorcancelado 
                                      ,si01_ano 
                       )
                values (
                                $this->si01_codigo 
                               ,'$this->si01_numcontrato' 
                               ,".($this->si01_dataassinatura == "null" || $this->si01_dataassinatura == ""?"null":"'".$this->si01_dataassinatura."'")." 
                               ,".($this->si01_datarecisao == "null" || $this->si01_datarecisao == ""?"null":"'".$this->si01_datarecisao."'")." 
                               ,$this->si01_valorcancelado 
                               ,$this->si01_ano 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Recisao do Contrato ($this->si01_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Recisao do Contrato já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Recisao do Contrato ($this->si01_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si01_codigo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si01_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,1009251,'$this->si01_codigo','I')");
       $resac = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,0,'si01_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,0,'si01_numcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,0,'si01_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,0,'si01_datarecisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,0,'si01_valorcancelado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,1010192,1009256,'','".AddSlashes(pg_result($resaco,0,'si01_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si01_codigo=null) { 
      $this->atualizacampos();
     $sql = " update recisaocontrato set ";
     $virgula = "";
     if(trim($this->si01_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_codigo"])){ 
       $sql  .= $virgula." si01_codigo = $this->si01_codigo ";
       $virgula = ",";
       if(trim($this->si01_codigo) == null ){ 
         $this->erro_sql = " Campo codigo nao Informado.";
         $this->erro_campo = "si01_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si01_numcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_numcontrato"])){ 
       $sql  .= $virgula." si01_numcontrato = '$this->si01_numcontrato' ";
       $virgula = ",";
       if(trim($this->si01_numcontrato) == null ){ 
         $this->erro_sql = " Campo Numero Contrato nao Informado.";
         $this->erro_campo = "si01_numcontrato";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si01_dataassinatura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_dataassinatura_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si01_dataassinatura_dia"] !="") ){ 
       $sql  .= $virgula." si01_dataassinatura = '$this->si01_dataassinatura' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si01_dataassinatura_dia"])){ 
         $sql  .= $virgula." si01_dataassinatura = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si01_datarecisao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_datarecisao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si01_datarecisao_dia"] !="") ){ 
       $sql  .= $virgula." si01_datarecisao = '$this->si01_datarecisao' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si01_datarecisao_dia"])){ 
         $sql  .= $virgula." si01_datarecisao = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si01_valorcancelado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_valorcancelado"])){ 
        if(trim($this->si01_valorcancelado)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si01_valorcancelado"])){ 
           $this->si01_valorcancelado = "0" ; 
        } 
       $sql  .= $virgula." si01_valorcancelado = $this->si01_valorcancelado ";
       $virgula = ",";
     }
     if(trim($this->si01_ano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si01_ano"])){ 
        if(trim($this->si01_ano)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si01_ano"])){ 
           $this->si01_ano = "0" ; 
        } 
       $sql  .= $virgula." si01_ano = $this->si01_ano ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($si01_codigo!=null){
       $sql .= " si01_codigo = $this->si01_codigo";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si01_codigo));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009251,'$this->si01_codigo','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_codigo"]) || $this->si01_codigo != "")
           $resac = db_query("insert into db_acount values($acount,1010192,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'si01_codigo'))."','$this->si01_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_numcontrato"]) || $this->si01_numcontrato != "")
           $resac = db_query("insert into db_acount values($acount,1010192,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'si01_numcontrato'))."','$this->si01_numcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_dataassinatura"]) || $this->si01_dataassinatura != "")
           $resac = db_query("insert into db_acount values($acount,1010192,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'si01_dataassinatura'))."','$this->si01_dataassinatura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_datarecisao"]) || $this->si01_datarecisao != "")
           $resac = db_query("insert into db_acount values($acount,1010192,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'si01_datarecisao'))."','$this->si01_datarecisao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_valorcancelado"]) || $this->si01_valorcancelado != "")
           $resac = db_query("insert into db_acount values($acount,1010192,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'si01_valorcancelado'))."','$this->si01_valorcancelado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si01_ano"]) || $this->si01_ano != "")
           $resac = db_query("insert into db_acount values($acount,1010192,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'si01_ano'))."','$this->si01_ano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Recisao do Contrato nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si01_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Recisao do Contrato nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si01_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si01_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si01_codigo=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si01_codigo));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009251,'$si01_codigo','E')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_numcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_datarecisao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_valorcancelado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'si01_ano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from recisaocontrato
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si01_codigo != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si01_codigo = $si01_codigo ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Recisao do Contrato nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si01_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Recisao do Contrato nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si01_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si01_codigo;
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
        $this->erro_sql   = "Record Vazio na Tabela:recisaocontrato";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si01_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from recisaocontrato ";
     $sql2 = "";
     if($dbwhere==""){
       if($si01_codigo!=null ){
         $sql2 .= " where recisaocontrato.si01_codigo = $si01_codigo "; 
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
   function sql_query_file ( $si01_codigo=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from recisaocontrato ";
     $sql2 = "";
     if($dbwhere==""){
       if($si01_codigo!=null ){
         $sql2 .= " where recisaocontrato.si01_codigo = $si01_codigo "; 
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
