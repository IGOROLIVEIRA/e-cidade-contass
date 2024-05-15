<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE convconvenios
class cl_convconvenios {
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
   var $c206_sequencial = 0;
   var $c206_instit = 0;
   var $c206_nroconvenio = null;
   var $c206_dataassinatura_dia = null;
   var $c206_dataassinatura_mes = null;
   var $c206_dataassinatura_ano = null;
   var $c206_dataassinatura = null;
   var $c206_objetoconvenio = null;
   var $c206_datainiciovigencia_dia = null;
   var $c206_datainiciovigencia_mes = null;
   var $c206_datainiciovigencia_ano = null;
   var $c206_datainiciovigencia = null;
   var $c206_datafinalvigencia_dia = null;
   var $c206_datafinalvigencia_mes = null;
   var $c206_datafinalvigencia_ano = null;
   var $c206_datafinalvigencia = null;
   var $c206_vlconvenio = 0;
   var $c206_vlcontrapartida = 0;
   var $c206_datacadastro_dia = null;
   var $c206_datacadastro_mes = null;
   var $c206_datacadastro_ano = null;
   var $c206_datacadastro = null;
   var $c206_tipocadastro = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 c206_sequencial = int8 = sequencial
                 c206_instit = int8 = Instituição
                 c206_nroconvenio = varchar(30) = Número do  Convênio
                 c206_dataassinatura = date = Data da assinatura
                 c206_objetoconvenio = varchar(500) = Objeto do convênio
                 c206_datainiciovigencia = date = Data inicial da  vigência
                 c206_datafinalvigencia = date = Data final da  vigência
                 c206_vlconvenio = float8 = Valor do convênio
                 c206_vlcontrapartida = float8 = Valor da  contrapartida
                 c206_datacadastro = date = Data de Cadastro
                 c206_tipocadastro = int4 = Instituição
                 ";
   //funcao construtor da classe
   function cl_convconvenios() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("convconvenios");
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
       $this->c206_sequencial = ($this->c206_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_sequencial"]:$this->c206_sequencial);
       $this->c206_instit = ($this->c206_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_instit"]:$this->c206_instit);
       $this->c206_nroconvenio = ($this->c206_nroconvenio == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_nroconvenio"]:$this->c206_nroconvenio);
       if($this->c206_dataassinatura == ""){
         $this->c206_dataassinatura_dia = ($this->c206_dataassinatura_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_dataassinatura_dia"]:$this->c206_dataassinatura_dia);
         $this->c206_dataassinatura_mes = ($this->c206_dataassinatura_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_dataassinatura_mes"]:$this->c206_dataassinatura_mes);
         $this->c206_dataassinatura_ano = ($this->c206_dataassinatura_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_dataassinatura_ano"]:$this->c206_dataassinatura_ano);
         if($this->c206_dataassinatura_dia != ""){
            $this->c206_dataassinatura = $this->c206_dataassinatura_ano."-".$this->c206_dataassinatura_mes."-".$this->c206_dataassinatura_dia;
         }
       }
       $this->c206_objetoconvenio = ($this->c206_objetoconvenio == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_objetoconvenio"]:$this->c206_objetoconvenio);
       if($this->c206_datainiciovigencia == ""){
         $this->c206_datainiciovigencia_dia = ($this->c206_datainiciovigencia_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_datainiciovigencia_dia"]:$this->c206_datainiciovigencia_dia);
         $this->c206_datainiciovigencia_mes = ($this->c206_datainiciovigencia_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_datainiciovigencia_mes"]:$this->c206_datainiciovigencia_mes);
         $this->c206_datainiciovigencia_ano = ($this->c206_datainiciovigencia_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_datainiciovigencia_ano"]:$this->c206_datainiciovigencia_ano);
         if($this->c206_datainiciovigencia_dia != ""){
            $this->c206_datainiciovigencia = $this->c206_datainiciovigencia_ano."-".$this->c206_datainiciovigencia_mes."-".$this->c206_datainiciovigencia_dia;
         }
       }
       if($this->c206_datafinalvigencia == ""){
         $this->c206_datafinalvigencia_dia = ($this->c206_datafinalvigencia_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_datafinalvigencia_dia"]:$this->c206_datafinalvigencia_dia);
         $this->c206_datafinalvigencia_mes = ($this->c206_datafinalvigencia_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_datafinalvigencia_mes"]:$this->c206_datafinalvigencia_mes);
         $this->c206_datafinalvigencia_ano = ($this->c206_datafinalvigencia_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_datafinalvigencia_ano"]:$this->c206_datafinalvigencia_ano);
         if($this->c206_datafinalvigencia_dia != ""){
            $this->c206_datafinalvigencia = $this->c206_datafinalvigencia_ano."-".$this->c206_datafinalvigencia_mes."-".$this->c206_datafinalvigencia_dia;
         }
       }
       if($this->c206_datacadastro == ""){
         $this->c206_datacadastro_dia = ($this->c206_datacadastro_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_datacadastro_dia"]:$this->c206_datacadastro_dia);
         $this->c206_datacadastro_mes = ($this->c206_datacadastro_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_datacadastro_mes"]:$this->c206_datacadastro_mes);
         $this->c206_datacadastro_ano = ($this->c206_datacadastro_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_datacadastro_ano"]:$this->c206_datacadastro_ano);
         if($this->c206_datacadastro_dia != ""){
            $this->c206_datacadastro = $this->c206_datacadastro_ano."-".$this->c206_datacadastro_mes."-".$this->c206_datacadastro_dia;
         }
       }
       $this->c206_tipocadastro = ($this->c206_tipocadastro == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_tipocadastro"]:$this->c206_tipocadastro);
       $this->c206_vlconvenio = ($this->c206_vlconvenio == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_vlconvenio"]:$this->c206_vlconvenio);
       $this->c206_vlcontrapartida = ($this->c206_vlcontrapartida == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_vlcontrapartida"]:$this->c206_vlcontrapartida);
     }else{
       $this->c206_sequencial = ($this->c206_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c206_sequencial"]:$this->c206_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c206_sequencial){
      $this->atualizacampos();
     if($this->c206_instit == null ){
       $this->erro_sql = " Campo Instituição não Informado.";
       $this->erro_campo = "c206_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c206_nroconvenio == null ){
       $this->erro_sql = " Campo Número do  Convênio não Informado.";
       $this->erro_campo = "c206_nroconvenio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c206_dataassinatura == null ){
       $this->erro_sql = " Campo Data da assinatura não Informado.";
       $this->erro_campo = "c206_dataassinatura_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c206_objetoconvenio == null ){
       $this->erro_sql = " Campo Objeto do convênio não Informado.";
       $this->erro_campo = "c206_objetoconvenio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c206_datainiciovigencia == null ){
       $this->erro_sql = " Campo Data inicial da  vigência não Informado.";
       $this->erro_campo = "c206_datainiciovigencia_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c206_datafinalvigencia == null ){
       $this->erro_sql = " Campo Data final da  vigência não Informado.";
       $this->erro_campo = "c206_datafinalvigencia_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c206_vlconvenio == null ){
       $this->erro_sql = " Campo Valor do convênio não Informado.";
       $this->erro_campo = "c206_vlconvenio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c206_vlcontrapartida == null ){
       $this->erro_sql = " Campo Valor da  contrapartida não Informado.";
       $this->erro_campo = "c206_vlcontrapartida";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->c206_datacadastro == null) || ($this->c206_datacadastro == "") ){
       $this->erro_sql = " Campo Data de cadastro não Informado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->c206_tipocadastro == null) || ($this->c206_tipocadastro == "") ){
       $this->erro_sql = " Campo Tipo de Recurso não Informado.";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($c206_sequencial == "" || $c206_sequencial == null ){
       $result = db_query("select nextval('convconvenios_c206_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: convconvenios_c206_sequencial_seq do campo: c206_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->c206_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from convconvenios_c206_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c206_sequencial)){
         $this->erro_sql = " Campo c206_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c206_sequencial = $c206_sequencial;
       }
     }

     if(($this->c206_sequencial == null) || ($this->c206_sequencial == "") ){
       $this->erro_sql = " Campo c206_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->c206_objetoconvenio = str_pad(preg_replace( "/\r|\n/", "", $this->c206_objetoconvenio),500," ");  
     $sql = "insert into convconvenios(
                                       c206_sequencial
                                      ,c206_instit
                                      ,c206_nroconvenio
                                      ,c206_dataassinatura
                                      ,c206_objetoconvenio
                                      ,c206_datainiciovigencia
                                      ,c206_datafinalvigencia
                                      ,c206_vlconvenio
                                      ,c206_vlcontrapartida
                                      ,c206_datacadastro
                                      ,c206_tipocadastro
                       )
                values (
                                $this->c206_sequencial
                               ,$this->c206_instit
                               ,'$this->c206_nroconvenio'
                               ,".($this->c206_dataassinatura == "null" || $this->c206_dataassinatura == ""?"null":"'".$this->c206_dataassinatura."'")."
                               ,'$this->c206_objetoconvenio'
                               ,".($this->c206_datainiciovigencia == "null" || $this->c206_datainiciovigencia == ""?"null":"'".$this->c206_datainiciovigencia."'")."
                               ,".($this->c206_datafinalvigencia == "null" || $this->c206_datafinalvigencia == ""?"null":"'".$this->c206_datafinalvigencia."'")."
                               ,$this->c206_vlconvenio
                               ,$this->c206_vlcontrapartida
                               ,".($this->c206_datacadastro == "null" || $this->c206_datacadastro == ""?"null":"'".$this->c206_datacadastro."'")."
                               ,".($this->c206_tipocadastro == "null" || $this->c206_tipocadastro == ""?"null":"$this->c206_tipocadastro")."

                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "convconvenios ($this->c206_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "convconvenios já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "convconvenios ($this->c206_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c206_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->c206_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011382,'$this->c206_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010397,2011382,'','".AddSlashes(pg_result($resaco,0,'c206_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010397,2011383,'','".AddSlashes(pg_result($resaco,0,'c206_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010397,2011384,'','".AddSlashes(pg_result($resaco,0,'c206_nroconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010397,2011385,'','".AddSlashes(pg_result($resaco,0,'c206_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010397,2011386,'','".AddSlashes(pg_result($resaco,0,'c206_objetoconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010397,2011387,'','".AddSlashes(pg_result($resaco,0,'c206_datainiciovigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010397,2011388,'','".AddSlashes(pg_result($resaco,0,'c206_datafinalvigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010397,2011389,'','".AddSlashes(pg_result($resaco,0,'c206_vlconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010397,2011390,'','".AddSlashes(pg_result($resaco,0,'c206_vlcontrapartida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($c206_sequencial=null) {
      $this->atualizacampos();
     $sql = " update convconvenios set ";
     $virgula = "";
     if(trim($this->c206_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c206_sequencial"])){
       $sql  .= $virgula." c206_sequencial = $this->c206_sequencial ";
       $virgula = ",";
       if(trim($this->c206_sequencial) == null ){
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "c206_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c206_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c206_instit"])){
       $sql  .= $virgula." c206_instit = $this->c206_instit ";
       $virgula = ",";
       if(trim($this->c206_instit) == null ){
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "c206_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c206_nroconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c206_nroconvenio"])){
       $sql  .= $virgula." c206_nroconvenio = '$this->c206_nroconvenio' ";
       $virgula = ",";
       if(trim($this->c206_nroconvenio) == null ){
         $this->erro_sql = " Campo Número do  Convênio nao Informado.";
         $this->erro_campo = "c206_nroconvenio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c206_dataassinatura)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c206_dataassinatura_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c206_dataassinatura_dia"] !="") ){
       $sql  .= $virgula." c206_dataassinatura = '$this->c206_dataassinatura' ";
       $virgula = ",";
       if(trim($this->c206_dataassinatura) == null ){
         $this->erro_sql = " Campo Data da assinatura nao Informado.";
         $this->erro_campo = "c206_dataassinatura_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["c206_dataassinatura_dia"])){
         $sql  .= $virgula." c206_dataassinatura = null ";
         $virgula = ",";
         if(trim($this->c206_dataassinatura) == null ){
           $this->erro_sql = " Campo Data da assinatura nao Informado.";
           $this->erro_campo = "c206_dataassinatura_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->c206_objetoconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c206_objetoconvenio"])){
       $this->c206_objetoconvenio = str_pad(preg_replace( "/\r|\n/", "", $this->c206_objetoconvenio),500," "); 
       $sql  .= $virgula." c206_objetoconvenio = '$this->c206_objetoconvenio' ";
       $virgula = ",";
       if(trim($this->c206_objetoconvenio) == null ){
         $this->erro_sql = " Campo Objeto do convênio nao Informado.";
         $this->erro_campo = "c206_objetoconvenio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c206_datainiciovigencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c206_datainiciovigencia_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c206_datainiciovigencia_dia"] !="") ){
       $sql  .= $virgula." c206_datainiciovigencia = '$this->c206_datainiciovigencia' ";
       $virgula = ",";
       if(trim($this->c206_datainiciovigencia) == null ){
         $this->erro_sql = " Campo Data inicial da  vigência nao Informado.";
         $this->erro_campo = "c206_datainiciovigencia_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["c206_datainiciovigencia_dia"])){
         $sql  .= $virgula." c206_datainiciovigencia = null ";
         $virgula = ",";
         if(trim($this->c206_datainiciovigencia) == null ){
           $this->erro_sql = " Campo Data inicial da  vigência nao Informado.";
           $this->erro_campo = "c206_datainiciovigencia_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->c206_datafinalvigencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c206_datafinalvigencia_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c206_datafinalvigencia_dia"] !="") ){
       $sql  .= $virgula." c206_datafinalvigencia = '$this->c206_datafinalvigencia' ";
       $virgula = ",";
       if(trim($this->c206_datafinalvigencia) == null ){
         $this->erro_sql = " Campo Data final da  vigência nao Informado.";
         $this->erro_campo = "c206_datafinalvigencia_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["c206_datafinalvigencia_dia"])){
         $sql  .= $virgula." c206_datafinalvigencia = null ";
         $virgula = ",";
         if(trim($this->c206_datafinalvigencia) == null ){
           $this->erro_sql = " Campo Data final da  vigência nao Informado.";
           $this->erro_campo = "c206_datafinalvigencia_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["c206_datacadastro"])){
       $this->c206_datacadastro = $GLOBALS["HTTP_POST_VARS"]["c206_datacadastro"];
       $sql  .= $virgula." c206_datacadastro = '$this->c206_datacadastro' ";
       $virgula = ",";
       if(trim($this->c206_datacadastro) == null || empty($this->c206_datacadastro)){
         $this->erro_sql = " Campo Data de Cadastro do convênio não informado.";
         $this->erro_campo = "c206_datacadastro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["c206_tipocadastro"])){
       $this->c206_tipocadastro = $GLOBALS["HTTP_POST_VARS"]["c206_tipocadastro"];
       $sql  .= $virgula." c206_tipocadastro = '$this->c206_tipocadastro' ";
       $virgula = ",";
       if(trim($this->c206_tipocadastro) == null || empty($this->c206_tipocadastro)){
         $this->erro_sql = " Campo Tipo de Recurso do convênio não informado.";
         $this->erro_campo = "c206_tipocadastro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c206_vlconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c206_vlconvenio"])){
       $sql  .= $virgula." c206_vlconvenio = $this->c206_vlconvenio ";
       $virgula = ",";
       if(trim($this->c206_vlconvenio) == null ){
         $this->erro_sql = " Campo Valor do convênio nao Informado.";
         $this->erro_campo = "c206_vlconvenio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c206_vlcontrapartida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c206_vlcontrapartida"])){
       $sql  .= $virgula." c206_vlcontrapartida = $this->c206_vlcontrapartida ";
       $virgula = ",";
       if(trim($this->c206_vlcontrapartida) == null ){
         $this->erro_sql = " Campo Valor da  contrapartida nao Informado.";
         $this->erro_campo = "c206_vlcontrapartida";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($c206_sequencial!=null){
       $sql .= " c206_sequencial = $this->c206_sequencial";
     }

     $resaco = $this->sql_record($this->sql_query_file($this->c206_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011382,'$this->c206_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c206_sequencial"]) || $this->c206_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010397,2011382,'".AddSlashes(pg_result($resaco,$conresaco,'c206_sequencial'))."','$this->c206_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c206_instit"]) || $this->c206_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010397,2011383,'".AddSlashes(pg_result($resaco,$conresaco,'c206_instit'))."','$this->c206_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c206_nroconvenio"]) || $this->c206_nroconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010397,2011384,'".AddSlashes(pg_result($resaco,$conresaco,'c206_nroconvenio'))."','$this->c206_nroconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c206_dataassinatura"]) || $this->c206_dataassinatura != "")
           $resac = db_query("insert into db_acount values($acount,2010397,2011385,'".AddSlashes(pg_result($resaco,$conresaco,'c206_dataassinatura'))."','$this->c206_dataassinatura',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c206_objetoconvenio"]) || $this->c206_objetoconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010397,2011386,'".AddSlashes(pg_result($resaco,$conresaco,'c206_objetoconvenio'))."','$this->c206_objetoconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c206_datainiciovigencia"]) || $this->c206_datainiciovigencia != "")
           $resac = db_query("insert into db_acount values($acount,2010397,2011387,'".AddSlashes(pg_result($resaco,$conresaco,'c206_datainiciovigencia'))."','$this->c206_datainiciovigencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c206_datafinalvigencia"]) || $this->c206_datafinalvigencia != "")
           $resac = db_query("insert into db_acount values($acount,2010397,2011388,'".AddSlashes(pg_result($resaco,$conresaco,'c206_datafinalvigencia'))."','$this->c206_datafinalvigencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c206_vlconvenio"]) || $this->c206_vlconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010397,2011389,'".AddSlashes(pg_result($resaco,$conresaco,'c206_vlconvenio'))."','$this->c206_vlconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c206_vlcontrapartida"]) || $this->c206_vlcontrapartida != "")
           $resac = db_query("insert into db_acount values($acount,2010397,2011390,'".AddSlashes(pg_result($resaco,$conresaco,'c206_vlcontrapartida'))."','$this->c206_vlcontrapartida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "convconvenios nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c206_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "convconvenios nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c206_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c206_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($c206_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($c206_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011382,'$c206_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010397,2011382,'','".AddSlashes(pg_result($resaco,$iresaco,'c206_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010397,2011383,'','".AddSlashes(pg_result($resaco,$iresaco,'c206_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010397,2011384,'','".AddSlashes(pg_result($resaco,$iresaco,'c206_nroconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010397,2011385,'','".AddSlashes(pg_result($resaco,$iresaco,'c206_dataassinatura'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010397,2011386,'','".AddSlashes(pg_result($resaco,$iresaco,'c206_objetoconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010397,2011387,'','".AddSlashes(pg_result($resaco,$iresaco,'c206_datainiciovigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010397,2011388,'','".AddSlashes(pg_result($resaco,$iresaco,'c206_datafinalvigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010397,2011389,'','".AddSlashes(pg_result($resaco,$iresaco,'c206_vlconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010397,2011390,'','".AddSlashes(pg_result($resaco,$iresaco,'c206_vlcontrapartida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from convconvenios
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c206_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c206_sequencial = $c206_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "convconvenios nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c206_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "convconvenios nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c206_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c206_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:convconvenios";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $c206_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from convconvenios ";
     $sql2 = "";
     if($dbwhere==""){
       if($c206_sequencial!=null ){
         $sql2 .= " where convconvenios.c206_sequencial = $c206_sequencial ";
       }
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql
   function sql_query_file ( $c206_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from convconvenios ";
     $sql2 = "";
     if($dbwhere==""){
       if($c206_sequencial!=null ){
         $sql2 .= " where convconvenios.c206_sequencial = $c206_sequencial ";
       }
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
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
