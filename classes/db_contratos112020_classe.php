<?
//MODULO: sicom
//CLASSE DA ENTIDADE contratos112020
class cl_contratos112020 {
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
   var $si84_sequencial = 0;
   var $si84_tiporegistro = 0;
   var $si84_codcontrato = 0;
   var $si84_coditem = 0;
   var $si84_quantidadeitem = 0;
   var $si84_valorunitarioitem = 0;
   var $si84_tipomaterial = null;
   var $si84_coditemsinapi = null;
   var $si84_coditemsimcro = null;
   var $si84_descoutrosmateriais = null;
   var $si84_itemplanilha = null;
   var $si84_mes = 0;
   var $si84_reg10 = 0;
   var $si84_instit = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si84_sequencial = int8 = sequencial
                 si84_tiporegistro = int8 = Tipo do  registro
                 si84_codcontrato = int8 = Código do contrato
                 si84_coditem = int8 = Código do item
                 si84_quantidadeitem = float8 = Quantidade  contratada do item
                 si84_valorunitarioitem = float8 = Valor unitário do  item
                 si84_tipomaterial = int8 = tipo de material
                 si84_coditemsinapi = vachar = codigo do item sinapi
                 si84_coditemsimcro = vachar = codigo do item simcro
                 si84_descoutrosmateriais = text = descricao do material
                 si84_itemplanilha = int8 = codigo da planilha
                 si84_mes = int8 = Mês
                 si84_reg10 = int8 = reg10
                 si84_instit = int8 = Instituição
                 ";
   //funcao construtor da classe
   function cl_contratos112020() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("contratos112020");
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
       $this->si84_sequencial = ($this->si84_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_sequencial"]:$this->si84_sequencial);
       $this->si84_tiporegistro = ($this->si84_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_tiporegistro"]:$this->si84_tiporegistro);
       $this->si84_codcontrato = ($this->si84_codcontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_codcontrato"]:$this->si84_codcontrato);
       $this->si84_coditem = ($this->si84_coditem == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_coditem"]:$this->si84_coditem);
       $this->si84_quantidadeitem = ($this->si84_quantidadeitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_quantidadeitem"]:$this->si84_quantidadeitem);
       $this->si84_valorunitarioitem = ($this->si84_valorunitarioitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_valorunitarioitem"]:$this->si84_valorunitarioitem);
       $this->si84_mes = ($this->si84_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_mes"]:$this->si84_mes);
       $this->si84_reg10 = ($this->si84_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_reg10"]:$this->si84_reg10);
       $this->si84_instit = ($this->si84_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_instit"]:$this->si84_instit);
       $this->si84_tipomaterial = ($this->si84_tipomaterial == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_tipomaterial"]:$this->si84_tipomaterial);
       $this->si84_coditemsinapi = ($this->si84_coditemsinapi == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_coditemsinapi"]:$this->si84_coditemsinapi);
       $this->si84_coditemsimcro = ($this->si84_coditemsimcro == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_coditemsimcro"]:$this->si84_coditemsimcro);
       $this->si84_descoutrosmateriais = ($this->si84_descoutrosmateriais == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_descoutrosmateriais"]:$this->si84_descoutrosmateriais);
       $this->si84_itemplanilha = ($this->si84_itemplanilha == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_itemplanilha"]:$this->si84_itemplanilha);
     }else{
       $this->si84_sequencial = ($this->si84_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si84_sequencial"]:$this->si84_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si84_sequencial){
      $this->atualizacampos();
     if($this->si84_tiporegistro == null ){
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si84_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si84_codcontrato == null ){
       $this->si84_codcontrato = "0";
     }
     if($this->si84_coditem == null ){
       $this->si84_coditem = "0";
     }
     if($this->si84_quantidadeitem == null ){
       $this->si84_quantidadeitem = "0";
     }
     if($this->si84_valorunitarioitem == null ){
       $this->si84_valorunitarioitem = "0";
     }
     if($this->si84_tipomaterial == null){
       $this->si84_tipomaterial = "0";
     }
     if($this->si84_itemplanilha == null){
       $this->si84_itemplanilha = "0";
     }
     if($this->si84_mes == null ){
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si84_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si84_reg10 == null ){
       $this->si84_reg10 = "0";
     }
     if($this->si84_instit == null ){
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si84_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si84_sequencial == "" || $si84_sequencial == null ){
       $result = db_query("select nextval('contratos112020_si84_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contratos112020_si84_sequencial_seq do campo: si84_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si84_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from contratos112020_si84_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si84_sequencial)){
         $this->erro_sql = " Campo si84_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si84_sequencial = $si84_sequencial;
       }
     }
     if(($this->si84_sequencial == null) || ($this->si84_sequencial == "") ){
       $this->erro_sql = " Campo si84_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into contratos112020(
                                       si84_sequencial
                                      ,si84_tiporegistro
                                      ,si84_codcontrato
                                      ,si84_coditem
                                      ,si84_tipomaterial
                                      ,si84_coditemsinapi
                                      ,si84_coditemsimcro
                                      ,si84_descoutrosmateriais
                                      ,si84_itemplanilha
                                      ,si84_quantidadeitem
                                      ,si84_valorunitarioitem
                                      ,si84_mes
                                      ,si84_reg10
                                      ,si84_instit
                       )
                values (
                                $this->si84_sequencial
                               ,$this->si84_tiporegistro
                               ,$this->si84_codcontrato
                               ,$this->si84_coditem
                               ,$this->si84_tipomaterial
                               ,'$this->si84_coditemsinapi'
                               ,'$this->si84_coditemsimcro'
                               ,'$this->si84_descoutrosmateriais'
                               ,$this->si84_itemplanilha
                               ,$this->si84_quantidadeitem
                               ,$this->si84_valorunitarioitem
                               ,$this->si84_mes
                               ,$this->si84_reg10
                               ,$this->si84_instit
                      )";
     $result = db_query($sql);//die($sql);
     if($result==false){
       $this->erro_banco = str_replace("","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "contratos112020 ($this->si84_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "contratos112020 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "contratos112020 ($this->si84_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
     $this->erro_sql .= "Valores : ".$this->si84_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si84_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010427,'$this->si84_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010313,2010427,'','".AddSlashes(pg_result($resaco,0,'si84_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010313,2010428,'','".AddSlashes(pg_result($resaco,0,'si84_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010313,2010429,'','".AddSlashes(pg_result($resaco,0,'si84_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010313,2010430,'','".AddSlashes(pg_result($resaco,0,'si84_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010313,2010431,'','".AddSlashes(pg_result($resaco,0,'si84_quantidadeitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010313,2010432,'','".AddSlashes(pg_result($resaco,0,'si84_valorunitarioitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010313,2010433,'','".AddSlashes(pg_result($resaco,0,'si84_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010313,2010434,'','".AddSlashes(pg_result($resaco,0,'si84_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010313,2011597,'','".AddSlashes(pg_result($resaco,0,'si84_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($si84_sequencial=null) {
      $this->atualizacampos();
     $sql = " update contratos112020 set ";
     $virgula = "";
     if(trim($this->si84_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si84_sequencial"])){
        if(trim($this->si84_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si84_sequencial"])){
           $this->si84_sequencial = "0";
        }
       $sql  .= $virgula." si84_sequencial = $this->si84_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si84_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si84_tiporegistro"])){
       $sql  .= $virgula." si84_tiporegistro = $this->si84_tiporegistro ";
       $virgula = ",";
       if(trim($this->si84_tiporegistro) == null ){
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si84_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si84_codcontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si84_codcontrato"])){
        if(trim($this->si84_codcontrato)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si84_codcontrato"])){
           $this->si84_codcontrato = "0" ;
        }
       $sql  .= $virgula." si84_codcontrato = $this->si84_codcontrato ";
       $virgula = ",";
     }
     if(trim($this->si84_coditem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si84_coditem"])){
        if(trim($this->si84_coditem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si84_coditem"])){
           $this->si84_coditem = "0" ;
        }
       $sql  .= $virgula." si84_coditem = $this->si84_coditem ";
       $virgula = ",";
     }
     if(trim($this->si84_quantidadeitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si84_quantidadeitem"])){
        if(trim($this->si84_quantidadeitem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si84_quantidadeitem"])){
           $this->si84_quantidadeitem = "0" ;
        }
       $sql  .= $virgula." si84_quantidadeitem = $this->si84_quantidadeitem ";
       $virgula = ",";
     }
     if(trim($this->si84_valorunitarioitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si84_valorunitarioitem"])){
        if(trim($this->si84_valorunitarioitem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si84_valorunitarioitem"])){
           $this->si84_valorunitarioitem = "0" ;
        }
       $sql  .= $virgula." si84_valorunitarioitem = $this->si84_valorunitarioitem ";
       $virgula = ",";
     }
     if(trim($this->si84_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si84_mes"])){
       $sql  .= $virgula." si84_mes = $this->si84_mes ";
       $virgula = ",";
       if(trim($this->si84_mes) == null ){
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si84_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si84_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si84_reg10"])){
        if(trim($this->si84_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si84_reg10"])){
           $this->si84_reg10 = "0" ;
        }
       $sql  .= $virgula." si84_reg10 = $this->si84_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si84_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si84_instit"])){
       $sql  .= $virgula." si84_instit = $this->si84_instit ";
       $virgula = ",";
       if(trim($this->si84_instit) == null ){
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si84_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si84_sequencial!=null){
       $sql .= " si84_sequencial = $this->si84_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si84_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010427,'$this->si84_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si84_sequencial"]) || $this->si84_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010313,2010427,'".AddSlashes(pg_result($resaco,$conresaco,'si84_sequencial'))."','$this->si84_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si84_tiporegistro"]) || $this->si84_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010313,2010428,'".AddSlashes(pg_result($resaco,$conresaco,'si84_tiporegistro'))."','$this->si84_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si84_codcontrato"]) || $this->si84_codcontrato != "")
           $resac = db_query("insert into db_acount values($acount,2010313,2010429,'".AddSlashes(pg_result($resaco,$conresaco,'si84_codcontrato'))."','$this->si84_codcontrato',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si84_coditem"]) || $this->si84_coditem != "")
           $resac = db_query("insert into db_acount values($acount,2010313,2010430,'".AddSlashes(pg_result($resaco,$conresaco,'si84_coditem'))."','$this->si84_coditem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si84_quantidadeitem"]) || $this->si84_quantidadeitem != "")
           $resac = db_query("insert into db_acount values($acount,2010313,2010431,'".AddSlashes(pg_result($resaco,$conresaco,'si84_quantidadeitem'))."','$this->si84_quantidadeitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si84_valorunitarioitem"]) || $this->si84_valorunitarioitem != "")
           $resac = db_query("insert into db_acount values($acount,2010313,2010432,'".AddSlashes(pg_result($resaco,$conresaco,'si84_valorunitarioitem'))."','$this->si84_valorunitarioitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si84_mes"]) || $this->si84_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010313,2010433,'".AddSlashes(pg_result($resaco,$conresaco,'si84_mes'))."','$this->si84_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si84_reg10"]) || $this->si84_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010313,2010434,'".AddSlashes(pg_result($resaco,$conresaco,'si84_reg10'))."','$this->si84_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si84_instit"]) || $this->si84_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010313,2011597,'".AddSlashes(pg_result($resaco,$conresaco,'si84_instit'))."','$this->si84_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("","",@pg_last_error());
       $this->erro_sql   = "contratos112020 nao Alterado. Alteracao Abortada.\n";
       $this->erro_sql .= "Valores : ".$this->si84_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos112020 nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si84_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si84_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si84_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si84_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010427,'$si84_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010313,2010427,'','".AddSlashes(pg_result($resaco,$iresaco,'si84_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010313,2010428,'','".AddSlashes(pg_result($resaco,$iresaco,'si84_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010313,2010429,'','".AddSlashes(pg_result($resaco,$iresaco,'si84_codcontrato'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010313,2010430,'','".AddSlashes(pg_result($resaco,$iresaco,'si84_coditem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010313,2010431,'','".AddSlashes(pg_result($resaco,$iresaco,'si84_quantidadeitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010313,2010432,'','".AddSlashes(pg_result($resaco,$iresaco,'si84_valorunitarioitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010313,2010433,'','".AddSlashes(pg_result($resaco,$iresaco,'si84_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010313,2010434,'','".AddSlashes(pg_result($resaco,$iresaco,'si84_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010313,2011597,'','".AddSlashes(pg_result($resaco,$iresaco,'si84_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from contratos112020
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si84_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si84_sequencial = $si84_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("","",@pg_last_error());
       $this->erro_sql   = "contratos112020 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si84_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "contratos112020 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si84_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si84_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
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
       $this->erro_banco = str_replace("","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:contratos112020";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si84_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from contratos112020 ";
     $sql .= "      left  join contratos102020  on  contratos102020.si83_sequencial = contratos112020.si84_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si84_sequencial!=null ){
         $sql2 .= " where contratos112020.si84_sequencial = $si84_sequencial ";
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
   function sql_query_file ( $si84_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from contratos112020 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si84_sequencial!=null ){
         $sql2 .= " where contratos112020.si84_sequencial = $si84_sequencial ";
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
