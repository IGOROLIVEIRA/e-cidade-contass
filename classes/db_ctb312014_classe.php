<?
//MODULO: sicom
//CLASSE DA ENTIDADE ctb312014
class cl_ctb312014 { 
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
   var $si100_sequencial = 0; 
   var $si100_tiporegistro = 0; 
   var $si100_codagentearrecadador = 0; 
   var $si100_codfontrecursos = 0; 
   var $si100_vlsaldoinicialagfonte = 0; 
   var $si100_vlentrada = 0; 
   var $si100_vlsaida = 0; 
   var $si100_vlsaldofinalagfonte = 0; 
   var $si100_mes = 0; 
   var $si100_reg30 = 0; 
   var $si100_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si100_sequencial = int8 = sequencial 
                 si100_tiporegistro = int8 = Tipo do  registro 
                 si100_codagentearrecadador = int8 = Código do agente arrecadador 
                 si100_codfontrecursos = int8 = Código da fonte de recursos 
                 si100_vlsaldoinicialagfonte = float8 = Valor do Saldo do  Início do Mês 
                 si100_vlentrada = float8 = Valor total das  entradas no mês 
                 si100_vlsaida = float8 = Valor total das  saídas no mês 
                 si100_vlsaldofinalagfonte = float8 = Valor do Saldo do  Final do Mês 
                 si100_mes = int8 = Mês 
                 si100_reg30 = int8 = reg30 
                 si100_instit = int4 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_ctb312014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ctb312014"); 
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
       $this->si100_sequencial = ($this->si100_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_sequencial"]:$this->si100_sequencial);
       $this->si100_tiporegistro = ($this->si100_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_tiporegistro"]:$this->si100_tiporegistro);
       $this->si100_codagentearrecadador = ($this->si100_codagentearrecadador == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_codagentearrecadador"]:$this->si100_codagentearrecadador);
       $this->si100_codfontrecursos = ($this->si100_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_codfontrecursos"]:$this->si100_codfontrecursos);
       $this->si100_vlsaldoinicialagfonte = ($this->si100_vlsaldoinicialagfonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_vlsaldoinicialagfonte"]:$this->si100_vlsaldoinicialagfonte);
       $this->si100_vlentrada = ($this->si100_vlentrada == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_vlentrada"]:$this->si100_vlentrada);
       $this->si100_vlsaida = ($this->si100_vlsaida == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_vlsaida"]:$this->si100_vlsaida);
       $this->si100_vlsaldofinalagfonte = ($this->si100_vlsaldofinalagfonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_vlsaldofinalagfonte"]:$this->si100_vlsaldofinalagfonte);
       $this->si100_mes = ($this->si100_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_mes"]:$this->si100_mes);
       $this->si100_reg30 = ($this->si100_reg30 == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_reg30"]:$this->si100_reg30);
       $this->si100_instit = ($this->si100_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_instit"]:$this->si100_instit);
     }else{
       $this->si100_sequencial = ($this->si100_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si100_sequencial"]:$this->si100_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si100_sequencial){ 
      $this->atualizacampos();
     if($this->si100_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si100_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si100_codagentearrecadador == null ){ 
       $this->si100_codagentearrecadador = "0";
     }
     if($this->si100_codfontrecursos == null ){ 
       $this->si100_codfontrecursos = "0";
     }
     if($this->si100_vlsaldoinicialagfonte == null ){ 
       $this->si100_vlsaldoinicialagfonte = "0";
     }
     if($this->si100_vlentrada == null ){ 
       $this->si100_vlentrada = "0";
     }
     if($this->si100_vlsaida == null ){ 
       $this->si100_vlsaida = "0";
     }
     if($this->si100_vlsaldofinalagfonte == null ){ 
       $this->si100_vlsaldofinalagfonte = "0";
     }
     if($this->si100_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si100_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si100_reg30 == null ){ 
       $this->si100_reg30 = "0";
     }
     if($this->si100_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si100_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si100_sequencial == "" || $si100_sequencial == null ){
       $result = db_query("select nextval('ctb312014_si100_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ctb312014_si100_sequencial_seq do campo: si100_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si100_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ctb312014_si100_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si100_sequencial)){
         $this->erro_sql = " Campo si100_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si100_sequencial = $si100_sequencial; 
       }
     }
     if(($this->si100_sequencial == null) || ($this->si100_sequencial == "") ){ 
       $this->erro_sql = " Campo si100_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ctb312014(
                                       si100_sequencial 
                                      ,si100_tiporegistro 
                                      ,si100_codagentearrecadador 
                                      ,si100_codfontrecursos 
                                      ,si100_vlsaldoinicialagfonte 
                                      ,si100_vlentrada 
                                      ,si100_vlsaida 
                                      ,si100_vlsaldofinalagfonte 
                                      ,si100_mes 
                                      ,si100_reg30 
                                      ,si100_instit 
                       )
                values (
                                $this->si100_sequencial 
                               ,$this->si100_tiporegistro 
                               ,$this->si100_codagentearrecadador 
                               ,$this->si100_codfontrecursos 
                               ,$this->si100_vlsaldoinicialagfonte 
                               ,$this->si100_vlentrada 
                               ,$this->si100_vlsaida 
                               ,$this->si100_vlsaldofinalagfonte 
                               ,$this->si100_mes 
                               ,$this->si100_reg30 
                               ,$this->si100_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ctb312014 ($this->si100_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ctb312014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ctb312014 ($this->si100_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si100_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si100_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010598,'$this->si100_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010329,2010598,'','".AddSlashes(pg_result($resaco,0,'si100_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2010599,'','".AddSlashes(pg_result($resaco,0,'si100_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2010600,'','".AddSlashes(pg_result($resaco,0,'si100_codagentearrecadador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2010601,'','".AddSlashes(pg_result($resaco,0,'si100_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2010602,'','".AddSlashes(pg_result($resaco,0,'si100_vlsaldoinicialagfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2010594,'','".AddSlashes(pg_result($resaco,0,'si100_vlentrada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2010595,'','".AddSlashes(pg_result($resaco,0,'si100_vlsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2010603,'','".AddSlashes(pg_result($resaco,0,'si100_vlsaldofinalagfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2010604,'','".AddSlashes(pg_result($resaco,0,'si100_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2010605,'','".AddSlashes(pg_result($resaco,0,'si100_reg30'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010329,2011612,'','".AddSlashes(pg_result($resaco,0,'si100_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si100_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ctb312014 set ";
     $virgula = "";
     if(trim($this->si100_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_sequencial"])){ 
        if(trim($this->si100_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si100_sequencial"])){ 
           $this->si100_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si100_sequencial = $this->si100_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si100_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_tiporegistro"])){ 
       $sql  .= $virgula." si100_tiporegistro = $this->si100_tiporegistro ";
       $virgula = ",";
       if(trim($this->si100_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si100_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si100_codagentearrecadador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_codagentearrecadador"])){ 
        if(trim($this->si100_codagentearrecadador)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si100_codagentearrecadador"])){ 
           $this->si100_codagentearrecadador = "0" ; 
        } 
       $sql  .= $virgula." si100_codagentearrecadador = $this->si100_codagentearrecadador ";
       $virgula = ",";
     }
     if(trim($this->si100_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_codfontrecursos"])){ 
        if(trim($this->si100_codfontrecursos)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si100_codfontrecursos"])){ 
           $this->si100_codfontrecursos = "0" ; 
        } 
       $sql  .= $virgula." si100_codfontrecursos = $this->si100_codfontrecursos ";
       $virgula = ",";
     }
     if(trim($this->si100_vlsaldoinicialagfonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_vlsaldoinicialagfonte"])){ 
        if(trim($this->si100_vlsaldoinicialagfonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si100_vlsaldoinicialagfonte"])){ 
           $this->si100_vlsaldoinicialagfonte = "0" ; 
        } 
       $sql  .= $virgula." si100_vlsaldoinicialagfonte = $this->si100_vlsaldoinicialagfonte ";
       $virgula = ",";
     }
     if(trim($this->si100_vlentrada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_vlentrada"])){ 
        if(trim($this->si100_vlentrada)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si100_vlentrada"])){ 
           $this->si100_vlentrada = "0" ; 
        } 
       $sql  .= $virgula." si100_vlentrada = $this->si100_vlentrada ";
       $virgula = ",";
     }
     if(trim($this->si100_vlsaida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_vlsaida"])){ 
        if(trim($this->si100_vlsaida)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si100_vlsaida"])){ 
           $this->si100_vlsaida = "0" ; 
        } 
       $sql  .= $virgula." si100_vlsaida = $this->si100_vlsaida ";
       $virgula = ",";
     }
     if(trim($this->si100_vlsaldofinalagfonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_vlsaldofinalagfonte"])){ 
        if(trim($this->si100_vlsaldofinalagfonte)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si100_vlsaldofinalagfonte"])){ 
           $this->si100_vlsaldofinalagfonte = "0" ; 
        } 
       $sql  .= $virgula." si100_vlsaldofinalagfonte = $this->si100_vlsaldofinalagfonte ";
       $virgula = ",";
     }
     if(trim($this->si100_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_mes"])){ 
       $sql  .= $virgula." si100_mes = $this->si100_mes ";
       $virgula = ",";
       if(trim($this->si100_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si100_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si100_reg30)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_reg30"])){ 
        if(trim($this->si100_reg30)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si100_reg30"])){ 
           $this->si100_reg30 = "0" ; 
        } 
       $sql  .= $virgula." si100_reg30 = $this->si100_reg30 ";
       $virgula = ",";
     }
     if(trim($this->si100_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si100_instit"])){ 
       $sql  .= $virgula." si100_instit = $this->si100_instit ";
       $virgula = ",";
       if(trim($this->si100_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si100_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si100_sequencial!=null){
       $sql .= " si100_sequencial = $this->si100_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si100_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010598,'$this->si100_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_sequencial"]) || $this->si100_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010598,'".AddSlashes(pg_result($resaco,$conresaco,'si100_sequencial'))."','$this->si100_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_tiporegistro"]) || $this->si100_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010599,'".AddSlashes(pg_result($resaco,$conresaco,'si100_tiporegistro'))."','$this->si100_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_codagentearrecadador"]) || $this->si100_codagentearrecadador != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010600,'".AddSlashes(pg_result($resaco,$conresaco,'si100_codagentearrecadador'))."','$this->si100_codagentearrecadador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_codfontrecursos"]) || $this->si100_codfontrecursos != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010601,'".AddSlashes(pg_result($resaco,$conresaco,'si100_codfontrecursos'))."','$this->si100_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_vlsaldoinicialagfonte"]) || $this->si100_vlsaldoinicialagfonte != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010602,'".AddSlashes(pg_result($resaco,$conresaco,'si100_vlsaldoinicialagfonte'))."','$this->si100_vlsaldoinicialagfonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_vlentrada"]) || $this->si100_vlentrada != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010594,'".AddSlashes(pg_result($resaco,$conresaco,'si100_vlentrada'))."','$this->si100_vlentrada',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_vlsaida"]) || $this->si100_vlsaida != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010595,'".AddSlashes(pg_result($resaco,$conresaco,'si100_vlsaida'))."','$this->si100_vlsaida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_vlsaldofinalagfonte"]) || $this->si100_vlsaldofinalagfonte != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010603,'".AddSlashes(pg_result($resaco,$conresaco,'si100_vlsaldofinalagfonte'))."','$this->si100_vlsaldofinalagfonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_mes"]) || $this->si100_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010604,'".AddSlashes(pg_result($resaco,$conresaco,'si100_mes'))."','$this->si100_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_reg30"]) || $this->si100_reg30 != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2010605,'".AddSlashes(pg_result($resaco,$conresaco,'si100_reg30'))."','$this->si100_reg30',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si100_instit"]) || $this->si100_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010329,2011612,'".AddSlashes(pg_result($resaco,$conresaco,'si100_instit'))."','$this->si100_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ctb312014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si100_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb312014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si100_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si100_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si100_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si100_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010598,'$si100_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010329,2010598,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2010599,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2010600,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_codagentearrecadador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2010601,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2010602,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_vlsaldoinicialagfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2010594,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_vlentrada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2010595,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_vlsaida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2010603,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_vlsaldofinalagfonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2010604,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2010605,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_reg30'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010329,2011612,'','".AddSlashes(pg_result($resaco,$iresaco,'si100_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ctb312014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si100_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si100_sequencial = $si100_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ctb312014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si100_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ctb312014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si100_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si100_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ctb312014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si100_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb312014 ";
     $sql .= "      left  join ctb302014  on  ctb302014.si99_sequencial = ctb312014.si100_reg30";
     $sql2 = "";
     if($dbwhere==""){
       if($si100_sequencial!=null ){
         $sql2 .= " where ctb312014.si100_sequencial = $si100_sequencial "; 
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
   function sql_query_file ( $si100_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ctb312014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si100_sequencial!=null ){
         $sql2 .= " where ctb312014.si100_sequencial = $si100_sequencial "; 
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
