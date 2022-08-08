<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE convdetalhatermos
class cl_convdetalhatermos { 
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
   var $c208_sequencial = 0; 
   var $c208_nroseqtermo = 0; 
   var $c208_dscalteracao = null; 
   var $c208_dataassinaturatermoaditivo_dia = null; 
   var $c208_dataassinaturatermoaditivo_mes = null; 
   var $c208_dataassinaturatermoaditivo_ano = null; 
   var $c208_dataassinaturatermoaditivo = null; 
   var $c208_datafinalvigencia_dia = null; 
   var $c208_datafinalvigencia_mes = null; 
   var $c208_datafinalvigencia_ano = null; 
   var $c208_datafinalvigencia = null; 
   var $c208_valoratualizadoconvenio = 0; 
   var $c208_valoratualizadocontrapartida = 0; 
   var $c208_codconvenio = 0; 
   var $c208_tipotermoaditivo = 0;
   var $c208_dsctipotermoaditivo = 0;
   var $c208_datacadastro = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 c208_sequencial = int8 = sequencial 
                 c208_nroseqtermo = int8 = Sequencial  do Termo Aditivo 
                 c208_dscalteracao = varchar(500) = Descrição da  alteração 
                 c208_dataassinaturatermoaditivo = date = Data da assinatura 
                 c208_datafinalvigencia = date = Data final da  vigência 
                 c208_valoratualizadoconvenio = float8 = Valor atualizado do Convênio 
                 c208_valoratualizadocontrapartida = float8 = Valor atualizado da Contrapartida 
                 c208_codconvenio = int8 = Cod convenio 
                 c208_tipotermoaditivo = int8 = Tipo do Termo Aditivo
                 c208_dsctipotermoaditivo = varchar(250) = Descrição Tipo do Termo Aditivo
                 c208_datacadastro = date = Data de Cadastro
                 ";
   //funcao construtor da classe 
   function cl_convdetalhatermos() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("convdetalhatermos"); 
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
       $this->c208_sequencial = ($this->c208_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_sequencial"]:$this->c208_sequencial);
       $this->c208_nroseqtermo = ($this->c208_nroseqtermo == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_nroseqtermo"]:$this->c208_nroseqtermo);
       $this->c208_dscalteracao = ($this->c208_dscalteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_dscalteracao"]:$this->c208_dscalteracao);
       if($this->c208_dataassinaturatermoaditivo == ""){
         $this->c208_dataassinaturatermoaditivo_dia = ($this->c208_dataassinaturatermoaditivo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_dataassinaturatermoaditivo_dia"]:$this->c208_dataassinaturatermoaditivo_dia);
         $this->c208_dataassinaturatermoaditivo_mes = ($this->c208_dataassinaturatermoaditivo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_dataassinaturatermoaditivo_mes"]:$this->c208_dataassinaturatermoaditivo_mes);
         $this->c208_dataassinaturatermoaditivo_ano = ($this->c208_dataassinaturatermoaditivo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_dataassinaturatermoaditivo_ano"]:$this->c208_dataassinaturatermoaditivo_ano);
         if($this->c208_dataassinaturatermoaditivo_dia != ""){
            $this->c208_dataassinaturatermoaditivo = $this->c208_dataassinaturatermoaditivo_ano."-".$this->c208_dataassinaturatermoaditivo_mes."-".$this->c208_dataassinaturatermoaditivo_dia;
         }
       }
       if($this->c208_datafinalvigencia == ""){
         $this->c208_datafinalvigencia_dia = ($this->c208_datafinalvigencia_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_datafinalvigencia_dia"]:$this->c208_datafinalvigencia_dia);
         $this->c208_datafinalvigencia_mes = ($this->c208_datafinalvigencia_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_datafinalvigencia_mes"]:$this->c208_datafinalvigencia_mes);
         $this->c208_datafinalvigencia_ano = ($this->c208_datafinalvigencia_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_datafinalvigencia_ano"]:$this->c208_datafinalvigencia_ano);
         if($this->c208_datafinalvigencia_dia != ""){
            $this->c208_datafinalvigencia = $this->c208_datafinalvigencia_ano."-".$this->c208_datafinalvigencia_mes."-".$this->c208_datafinalvigencia_dia;
         }
       }
       if($this->c208_datacadastro == ""){
         $this->c208_datacadastro_dia = ($this->c208_datacadastro_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_datacadastro_dia"]:$this->c208_datacadastro_dia);
         $this->c208_datacadastro_mes = ($this->c208_datacadastro_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_datacadastro_mes"]:$this->c208_datacadastro_mes);
         $this->c208_datacadastro_ano = ($this->c208_datacadastro_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_datacadastro_ano"]:$this->c208_datacadastro_ano);
         if($this->c208_datacadastro_dia != ""){
           $this->c208_datacadastro = $this->c208_datacadastro_ano."-".$this->c208_datacadastro_mes."-".$this->c208_datacadastro_dia;
         }
       }
       $this->c208_valoratualizadoconvenio = ($this->c208_valoratualizadoconvenio == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_valoratualizadoconvenio"]:$this->c208_valoratualizadoconvenio);
       $this->c208_valoratualizadocontrapartida = ($this->c208_valoratualizadocontrapartida == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_valoratualizadocontrapartida"]:$this->c208_valoratualizadocontrapartida);
       $this->c208_codconvenio = ($this->c208_codconvenio == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_codconvenio"]:$this->c208_codconvenio);
       $this->c208_tipotermoaditivo = ($this->c208_tipotermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_tipotermoaditivo"]:$this->c208_tipotermoaditivo);
       $this->c208_dsctipotermoaditivo = ($this->c208_dsctipotermoaditivo == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_dsctipotermoaditivo"]:$this->c208_dsctipotermoaditivo);
     }else{
       $this->c208_sequencial = ($this->c208_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c208_sequencial"]:$this->c208_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c208_sequencial){ 
      $this->atualizacampos();
     if($this->c208_nroseqtermo == null ){ 
       $this->erro_sql = " Campo Sequencial  do Termo Aditivo nao Informado.";
       $this->erro_campo = "c208_nroseqtermo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c208_datacadastro == null ){
       $this->erro_sql = " Campo Data Cadastro nao Informado.";
       $this->erro_campo = "c208_datacadastro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c208_dscalteracao == null ){ 
       $this->erro_sql = " Campo Descrição da  alteração nao Informado.";
       $this->erro_campo = "c208_dscalteracao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c208_tipotermoaditivo == null ){
       $this->erro_sql = " Campo Tipo Termo Aditivo nao Informado.";
       $this->erro_campo = "c208_tipotermoaditivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c208_tipotermoaditivo == 99 && $this->c208_dsctipotermoaditivo == null){
       $this->erro_sql = " Campo Descrição do Tipo Termo Aditivo nao Informado.";
       $this->erro_campo = "c208_dsctipotermoaditivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c208_dataassinaturatermoaditivo == null ){ 
       $this->erro_sql = " Campo Data da assinatura nao Informado.";
       $this->erro_campo = "c208_dataassinaturatermoaditivo_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c208_datafinalvigencia == null ){ 
       $this->erro_sql = " Campo Data final da  vigência nao Informado.";
       $this->erro_campo = "c208_datafinalvigencia_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c208_valoratualizadoconvenio == null ){ 
       $this->erro_sql = " Campo Valor atualizado do Convênio nao Informado.";
       $this->erro_campo = "c208_valoratualizadoconvenio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c208_valoratualizadocontrapartida == null ){ 
       $this->erro_sql = " Campo Valor atualizado da Contrapartida nao Informado.";
       $this->erro_campo = "c208_valoratualizadocontrapartida";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c208_codconvenio == null ){ 
       $this->erro_sql = " Campo Cod convenio nao Informado.";
       $this->erro_campo = "c208_codconvenio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($c208_sequencial == "" || $c208_sequencial == null ){
       $result = db_query("select nextval('convdetalhatermos_c208_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: convdetalhatermos_c208_sequencial_seq do campo: c208_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->c208_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from convdetalhatermos_c208_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c208_sequencial)){
         $this->erro_sql = " Campo c208_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c208_sequencial = $c208_sequencial; 
       }
     }
     if(($this->c208_sequencial == null) || ($this->c208_sequencial == "") ){ 
       $this->erro_sql = " Campo c208_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = $this->sql_record($this->sql_query_file(null,"*", "", "c208_nroseqtermo = {$this->c208_nroseqtermo} and c208_codconvenio = {$this->c208_codconvenio}"));
     if(pg_num_rows($result) > 0) {
       $this->erro_sql = " Campo Numero do Aditivo ja existe.";
       $this->erro_banco = "";
       $this->erro_campo = "c208_nroseqtermo";
       $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
       $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into convdetalhatermos(
                                       c208_sequencial 
                                      ,c208_nroseqtermo 
                                      ,c208_dscalteracao 
                                      ,c208_dataassinaturatermoaditivo 
                                      ,c208_datafinalvigencia 
                                      ,c208_valoratualizadoconvenio 
                                      ,c208_valoratualizadocontrapartida 
                                      ,c208_codconvenio 
                                      ,c208_tipotermoaditivo
                                      ,c208_dsctipotermoaditivo
                                      ,c208_datacadastro
                       )
                values (
                                $this->c208_sequencial 
                               ,$this->c208_nroseqtermo 
                               ,'$this->c208_dscalteracao' 
                               ,".($this->c208_dataassinaturatermoaditivo == "null" || $this->c208_dataassinaturatermoaditivo == ""?"null":"'".$this->c208_dataassinaturatermoaditivo."'")." 
                               ,".($this->c208_datafinalvigencia == "null" || $this->c208_datafinalvigencia == ""?"null":"'".$this->c208_datafinalvigencia."'")." 
                               ,$this->c208_valoratualizadoconvenio 
                               ,$this->c208_valoratualizadocontrapartida 
                               ,$this->c208_codconvenio 
                               ,$this->c208_tipotermoaditivo
                               ,'$this->c208_dsctipotermoaditivo'
                               ,'$this->c208_datacadastro'
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "convdetalhatermos ($this->c208_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "convdetalhatermos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "convdetalhatermos ($this->c208_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c208_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->c208_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011397,'$this->c208_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010399,2011397,'','".AddSlashes(pg_result($resaco,0,'c208_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010399,2011398,'','".AddSlashes(pg_result($resaco,0,'c208_nroseqtermo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010399,2011399,'','".AddSlashes(pg_result($resaco,0,'c208_dscalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010399,2011400,'','".AddSlashes(pg_result($resaco,0,'c208_dataassinaturatermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010399,2011401,'','".AddSlashes(pg_result($resaco,0,'c208_datafinalvigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010399,2011402,'','".AddSlashes(pg_result($resaco,0,'c208_valoratualizadoconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010399,2011403,'','".AddSlashes(pg_result($resaco,0,'c208_valoratualizadocontrapartida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010399,2011404,'','".AddSlashes(pg_result($resaco,0,'c208_codconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($c208_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update convdetalhatermos set ";
     $virgula = "";
     if(trim($this->c208_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_sequencial"])){ 
       $sql  .= $virgula." c208_sequencial = $this->c208_sequencial ";
       $virgula = ",";
       if(trim($this->c208_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "c208_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c208_nroseqtermo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_nroseqtermo"])){ 
       $sql  .= $virgula." c208_nroseqtermo = $this->c208_nroseqtermo ";
       $virgula = ",";
       if(trim($this->c208_nroseqtermo) == null ){ 
         $this->erro_sql = " Campo Sequencial  do Termo Aditivo nao Informado.";
         $this->erro_campo = "c208_nroseqtermo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c208_dscalteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_dscalteracao"])){ 
       $sql  .= $virgula." c208_dscalteracao = '$this->c208_dscalteracao' ";
       $virgula = ",";
       if(trim($this->c208_dscalteracao) == null ){ 
         $this->erro_sql = " Campo Descrição da  alteração nao Informado.";
         $this->erro_campo = "c208_dscalteracao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c208_dataassinaturatermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_dataassinaturatermoaditivo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c208_dataassinaturatermoaditivo_dia"] !="") ){ 
       $sql  .= $virgula." c208_dataassinaturatermoaditivo = '$this->c208_dataassinaturatermoaditivo' ";
       $virgula = ",";
       if(trim($this->c208_dataassinaturatermoaditivo) == null ){ 
         $this->erro_sql = " Campo Data da assinatura nao Informado.";
         $this->erro_campo = "c208_dataassinaturatermoaditivo_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["c208_dataassinaturatermoaditivo_dia"])){ 
         $sql  .= $virgula." c208_dataassinaturatermoaditivo = null ";
         $virgula = ",";
         if(trim($this->c208_dataassinaturatermoaditivo) == null ){ 
           $this->erro_sql = " Campo Data da assinatura nao Informado.";
           $this->erro_campo = "c208_dataassinaturatermoaditivo_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->c208_datafinalvigencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_datafinalvigencia_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c208_datafinalvigencia_dia"] !="") ){ 
       $sql  .= $virgula." c208_datafinalvigencia = '$this->c208_datafinalvigencia' ";
       $virgula = ",";
       if(trim($this->c208_datafinalvigencia) == null ){ 
         $this->erro_sql = " Campo Data final da  vigência nao Informado.";
         $this->erro_campo = "c208_datafinalvigencia_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["c208_datafinalvigencia_dia"])){ 
         $sql  .= $virgula." c208_datafinalvigencia = null ";
         $virgula = ",";
         if(trim($this->c208_datafinalvigencia) == null ){ 
           $this->erro_sql = " Campo Data final da  vigência nao Informado.";
           $this->erro_campo = "c208_datafinalvigencia_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->c208_valoratualizadoconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_valoratualizadoconvenio"])){ 
       $sql  .= $virgula." c208_valoratualizadoconvenio = $this->c208_valoratualizadoconvenio ";
       $virgula = ",";
       if(trim($this->c208_valoratualizadoconvenio) == null ){ 
         $this->erro_sql = " Campo Valor atualizado do Convênio nao Informado.";
         $this->erro_campo = "c208_valoratualizadoconvenio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c208_valoratualizadocontrapartida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_valoratualizadocontrapartida"])){ 
       $sql  .= $virgula." c208_valoratualizadocontrapartida = $this->c208_valoratualizadocontrapartida ";
       $virgula = ",";
       if(trim($this->c208_valoratualizadocontrapartida) == null ){ 
         $this->erro_sql = " Campo Valor atualizado da Contrapartida nao Informado.";
         $this->erro_campo = "c208_valoratualizadocontrapartida";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c208_codconvenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_codconvenio"])){ 
       $sql  .= $virgula." c208_codconvenio = $this->c208_codconvenio ";
       $virgula = ",";
       if(trim($this->c208_codconvenio) == null ){ 
         $this->erro_sql = " Campo Cod convenio nao Informado.";
         $this->erro_campo = "c208_codconvenio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c208_tipotermoaditivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_tipotermoaditivo"])){
       $sql  .= $virgula." c208_tipotermoaditivo = $this->c208_tipotermoaditivo ";
       $virgula = ",";
       if(trim($this->c208_tipotermoaditivo) == null ){
         $this->erro_sql = " Campo Tipo Termo Aditivo nao Informado.";
         $this->erro_campo = "c208_tipotermoaditivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->c208_tipotermoaditivo == 99) {
       if (trim($this->c208_dsctipotermoaditivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["c208_dsctipotermoaditivo"])) {
         $sql .= $virgula . " c208_dsctipotermoaditivo = '$this->c208_dsctipotermoaditivo' ";
         $virgula = ",";
         if (trim($this->c208_dsctipotermoaditivo) == null) {
           $this->erro_sql = " Campo Descrição do Tipo Termo Aditivo nao Informado.";
           $this->erro_campo = "c208_dsctipotermoaditivo";
           $this->erro_banco = "";
           $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
           $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     } else {
       $sql .= $virgula . " c208_dsctipotermoaditivo = ''";
     }
     if(trim($this->c208_datacadastro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c208_datacadastro"])){
       $sql  .= $virgula." c208_datacadastro = '$this->c208_datacadastro' ";
       $virgula = ",";
       if(trim($this->c208_datacadastro) == null ){
         $this->erro_sql = "  Campo Data Cadastro nao Informado.";
         $this->erro_campo = "c208_datacadastro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($c208_sequencial!=null){
       $sql .= " c208_sequencial = $this->c208_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->c208_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011397,'$this->c208_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c208_sequencial"]) || $this->c208_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010399,2011397,'".AddSlashes(pg_result($resaco,$conresaco,'c208_sequencial'))."','$this->c208_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c208_nroseqtermo"]) || $this->c208_nroseqtermo != "")
           $resac = db_query("insert into db_acount values($acount,2010399,2011398,'".AddSlashes(pg_result($resaco,$conresaco,'c208_nroseqtermo'))."','$this->c208_nroseqtermo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c208_dscalteracao"]) || $this->c208_dscalteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010399,2011399,'".AddSlashes(pg_result($resaco,$conresaco,'c208_dscalteracao'))."','$this->c208_dscalteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c208_dataassinaturatermoaditivo"]) || $this->c208_dataassinaturatermoaditivo != "")
           $resac = db_query("insert into db_acount values($acount,2010399,2011400,'".AddSlashes(pg_result($resaco,$conresaco,'c208_dataassinaturatermoaditivo'))."','$this->c208_dataassinaturatermoaditivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c208_datafinalvigencia"]) || $this->c208_datafinalvigencia != "")
           $resac = db_query("insert into db_acount values($acount,2010399,2011401,'".AddSlashes(pg_result($resaco,$conresaco,'c208_datafinalvigencia'))."','$this->c208_datafinalvigencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c208_valoratualizadoconvenio"]) || $this->c208_valoratualizadoconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010399,2011402,'".AddSlashes(pg_result($resaco,$conresaco,'c208_valoratualizadoconvenio'))."','$this->c208_valoratualizadoconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c208_valoratualizadocontrapartida"]) || $this->c208_valoratualizadocontrapartida != "")
           $resac = db_query("insert into db_acount values($acount,2010399,2011403,'".AddSlashes(pg_result($resaco,$conresaco,'c208_valoratualizadocontrapartida'))."','$this->c208_valoratualizadocontrapartida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c208_codconvenio"]) || $this->c208_codconvenio != "")
           $resac = db_query("insert into db_acount values($acount,2010399,2011404,'".AddSlashes(pg_result($resaco,$conresaco,'c208_codconvenio'))."','$this->c208_codconvenio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     $result = $this->sql_record($this->sql_query_file(null,"*", "", "c208_nroseqtermo = {$this->c208_nroseqtermo} and c208_codconvenio = {$this->c208_codconvenio}"));
     if(pg_num_rows($result) > 1) {
       $this->erro_sql = " Campo Numero do Aditivo ja existe.";
       $this->erro_banco = "";
       $this->erro_campo = "c208_nroseqtermo";
       $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
       $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "convdetalhatermos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c208_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "convdetalhatermos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c208_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c208_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($c208_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($c208_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011397,'$c208_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010399,2011397,'','".AddSlashes(pg_result($resaco,$iresaco,'c208_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010399,2011398,'','".AddSlashes(pg_result($resaco,$iresaco,'c208_nroseqtermo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010399,2011399,'','".AddSlashes(pg_result($resaco,$iresaco,'c208_dscalteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010399,2011400,'','".AddSlashes(pg_result($resaco,$iresaco,'c208_dataassinaturatermoaditivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010399,2011401,'','".AddSlashes(pg_result($resaco,$iresaco,'c208_datafinalvigencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010399,2011402,'','".AddSlashes(pg_result($resaco,$iresaco,'c208_valoratualizadoconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010399,2011403,'','".AddSlashes(pg_result($resaco,$iresaco,'c208_valoratualizadocontrapartida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010399,2011404,'','".AddSlashes(pg_result($resaco,$iresaco,'c208_codconvenio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from convdetalhatermos
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c208_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c208_sequencial = $c208_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "convdetalhatermos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c208_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "convdetalhatermos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c208_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c208_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:convdetalhatermos";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $c208_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from convdetalhatermos ";
     $sql .= "      inner join convconvenios  on  convconvenios.c206_sequencial = convdetalhatermos.c208_codconvenio";
     $sql2 = "";
     if($dbwhere==""){
       if($c208_sequencial!=null ){
         $sql2 .= " where convdetalhatermos.c208_sequencial = $c208_sequencial "; 
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
   function sql_query_file ( $c208_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from convdetalhatermos ";
     $sql2 = "";
     if($dbwhere==""){
       if($c208_sequencial!=null ){
         $sql2 .= " where convdetalhatermos.c208_sequencial = $c208_sequencial "; 
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
