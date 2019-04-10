<?
//MODULO: sicom
//CLASSE DA ENTIDADE projecaoatuarial10
class cl_projecaoatuarial10 { 
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
   var $si168_sequencial = 0; 
   var $si168_vlsaldofinanceiroexercicioanterior = 0; 
   var $si168_dtcadastro_dia = null; 
   var $si168_dtcadastro_mes = null; 
   var $si168_dtcadastro_ano = null; 
   var $si168_dtcadastro = null; 
   var $si168_instit = 0;
   var $si168_exercicio = 0;
   var $si168_vlreceitaprevidenciaria = 0;
   var $si168_vldespesaprevidenciaria = 0;
   var $si168_tipoplano = null;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si168_sequencial = int8 = sequencial 
                 si168_vlsaldofinanceiroexercicioanterior = float8 = Valor do Saldo financeiro 
                 si168_dtcadastro = date = Data de cadastro 
                 si168_instit = int8 = Instituição 
                 si168_vlreceitaprevidenciaria = float8 = valor de receita previdenciaria 
                 si168_vldespesaprevidenciaria = float8 = valor de despesa previdenciaria
                 si168_tipoplano = int4 = tipo de plano
                 ";
   //funcao construtor da classe 
   function cl_projecaoatuarial10() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("projecaoatuarial10"); 
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
       $this->si168_sequencial = ($this->si168_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_sequencial"]:$this->si168_sequencial);
       $this->si168_vlsaldofinanceiroexercicioanterior = ($this->si168_vlsaldofinanceiroexercicioanterior == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_vlsaldofinanceiroexercicioanterior"]:$this->si168_vlsaldofinanceiroexercicioanterior);
       if($this->si168_dtcadastro == ""){
         $this->si168_dtcadastro_dia = ($this->si168_dtcadastro_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_dtcadastro_dia"]:$this->si168_dtcadastro_dia);
         $this->si168_dtcadastro_mes = ($this->si168_dtcadastro_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_dtcadastro_mes"]:$this->si168_dtcadastro_mes);
         $this->si168_dtcadastro_ano = ($this->si168_dtcadastro_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_dtcadastro_ano"]:$this->si168_dtcadastro_ano);
         if($this->si168_dtcadastro_dia != ""){
            $this->si168_dtcadastro = $this->si168_dtcadastro_ano."-".$this->si168_dtcadastro_mes."-".$this->si168_dtcadastro_dia;
         }
       }
       $this->si168_instit = ($this->si168_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_instit"]:$this->si168_instit);
       $this->si168_exercicio = ($this->si168_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_exercicio"]:$this->si168_exercicio);
       $this->si168_vlreceitaprevidenciaria = ($this->si168_vlreceitaprevidenciaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_vlreceitaprevidenciaria"]:$this->si168_vlreceitaprevidenciaria);
       $this->si168_vldespesaprevidenciaria = ($this->si168_vldespesaprevidenciaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_vldespesaprevidenciaria"]:$this->si168_vldespesaprevidenciaria);
       $this->si168_tipoplano = ($this->si168_tipoplano == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_tipoplano"]:$this->si168_tipoplano);
     }else{
       $this->si168_sequencial = ($this->si168_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si168_sequencial"]:$this->si168_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si168_sequencial){ 
      $this->atualizacampos();
     if($this->si168_vlsaldofinanceiroexercicioanterior == null ){ 
       $this->erro_sql = " Campo Valor do Saldo financeiro nao Informado.";
       $this->erro_campo = "si168_vlsaldofinanceiroexercicioanterior";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si168_dtcadastro == null ){ 
       $this->erro_sql = " Campo Data de cadastro nao Informado.";
       $this->erro_campo = "si168_dtcadastro_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si168_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si168_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
    if($this->si168_exercicio == null ){ 
       $this->erro_sql = " Campo Exercício nao Informado.";
       $this->erro_campo = "si168_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si168_sequencial == "" || $si168_sequencial == null ){
       $result = db_query("select nextval('projecaoatuarial10_si168_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: projecaoatuarial10_si168_sequencial_seq do campo: si168_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si168_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from projecaoatuarial10_si168_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si168_sequencial)){
         $this->erro_sql = " Campo si168_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si168_sequencial = $si168_sequencial; 
       }
     }
     if(($this->si168_sequencial == null) || ($this->si168_sequencial == "") ){ 
       $this->erro_sql = " Campo si168_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       if($this->si168_vlreceitaprevidenciaria == null ){
           $this->erro_sql = " Campo valor de receita previdenciaria nao Informado.";
           $this->erro_campo = "si168_exercicio";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
       }

       if($this->si168_vldespesaprevidenciaria == null ){
           $this->erro_sql = " Campo valor de despesa previdenciaria nao Informado.";
           $this->erro_campo = "si168_exercicio";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
       }

       if($this->si168_tipoplano == null ){
           $this->erro_sql = " Campo tipo plano nao Informado.";
           $this->erro_campo = "si168_exercicio";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
       }

     $sql = "insert into projecaoatuarial10(
                                       si168_sequencial 
                                      ,si168_vlsaldofinanceiroexercicioanterior 
                                      ,si168_dtcadastro 
                                      ,si168_instit
                                      ,si168_exercicio
                                      ,si168_vlreceitaprevidenciaria
                                      ,si168_vldespesaprevidenciaria 
                                      ,si168_tipoplano 
                       )
                values (
                                $this->si168_sequencial 
                               ,$this->si168_vlsaldofinanceiroexercicioanterior 
                               ,".($this->si168_dtcadastro == "null" || $this->si168_dtcadastro == ""?"null":"'".$this->si168_dtcadastro."'")." 
                               ,$this->si168_instit 
                               ,$this->si168_exercicio
                               ,$this->si168_vlreceitaprevidenciaria
                               ,$this->si168_vldespesaprevidenciaria
                               ,$this->si168_tipoplano
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "projecaoatuarial ($this->si168_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "projecaoatuarial já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "projecaoatuarial ($this->si168_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si168_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si168_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011443,'$this->si168_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010402,2011443,'','".AddSlashes(pg_result($resaco,0,'si168_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010402,2011440,'','".AddSlashes(pg_result($resaco,0,'si168_vlsaldofinanceiroexercicioanterior'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010402,2011444,'','".AddSlashes(pg_result($resaco,0,'si168_dtcadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010402,2011445,'','".AddSlashes(pg_result($resaco,0,'si168_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si168_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update projecaoatuarial10 set ";
     $virgula = "";
     if(trim($this->si168_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si168_sequencial"])){ 
       $sql  .= $virgula." si168_sequencial = $this->si168_sequencial ";
       $virgula = ",";
       if(trim($this->si168_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si168_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si168_vlsaldofinanceiroexercicioanterior)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si168_vlsaldofinanceiroexercicioanterior"])){ 
       $sql  .= $virgula." si168_vlsaldofinanceiroexercicioanterior = $this->si168_vlsaldofinanceiroexercicioanterior ";
       $virgula = ",";
       if(trim($this->si168_vlsaldofinanceiroexercicioanterior) == null ){ 
         $this->erro_sql = " Campo Valor do Saldo financeiro nao Informado.";
         $this->erro_campo = "si168_vlsaldofinanceiroexercicioanterior";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si168_dtcadastro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si168_dtcadastro_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si168_dtcadastro_dia"] !="") ){ 
       $sql  .= $virgula." si168_dtcadastro = '$this->si168_dtcadastro' ";
       $virgula = ",";
       if(trim($this->si168_dtcadastro) == null ){ 
         $this->erro_sql = " Campo Data de cadastro nao Informado.";
         $this->erro_campo = "si168_dtcadastro_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si168_dtcadastro_dia"])){ 
         $sql  .= $virgula." si168_dtcadastro = null ";
         $virgula = ",";
         if(trim($this->si168_dtcadastro) == null ){ 
           $this->erro_sql = " Campo Data de cadastro nao Informado.";
           $this->erro_campo = "si168_dtcadastro_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si168_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si168_instit"])){ 
       $sql  .= $virgula." si168_instit = $this->si168_instit ";
       $virgula = ",";
       if(trim($this->si168_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si168_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si168_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si168_exercicio"])){ 
       $sql  .= $virgula." si168_exercicio = $this->si168_exercicio ";
       $virgula = ",";
       if(trim($this->si168_exercicio) == null ){ 
         $this->erro_sql = " Campo Exercício nao Informado.";
         $this->erro_campo = "si168_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }

       if(trim($this->si168_vlreceitaprevidenciaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si168_vlreceitaprevidenciaria"])){
           $sql  .= $virgula." si168_vlreceitaprevidenciaria = $this->si168_vlreceitaprevidenciaria ";
           $virgula = ",";
           if(trim($this->si168_vlreceitaprevidenciaria) == null ){
               $this->erro_sql = " Campo Valor Receita Previdenciaria nao Informado.";
               $this->erro_campo = "si168_vlreceitaprevidenciaria";
               $this->erro_banco = "";
               $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
               $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
               $this->erro_status = "0";
               return false;
           }
       }
       if(trim($this->si168_vldespesaprevidenciaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si168_vldespesaprevidenciaria"])){
           $sql  .= $virgula." si168_vldespesaprevidenciaria = $this->si168_vldespesaprevidenciaria ";
           $virgula = ",";
           if(trim($this->si168_vldespesaprevidenciaria) == null ){
               $this->erro_sql = " Campo valor de Despesa Previdenciaria não Informado.";
               $this->erro_campo = "si168_vldespesaprevidenciaria";
               $this->erro_banco = "";
               $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
               $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
               $this->erro_status = "0";
               return false;
           }
       }
       if(trim($this->si168_tipoplano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si168_tipoplano"])){
           $sql  .= $virgula." si168_tipoplano = $this->si168_tipoplano ";
           $virgula = ",";
           if(trim($this->si168_tipoplano) == null ){
               $this->erro_sql = " Campo Tipo Plano.";
               $this->erro_campo = "si168_tipoplano";
               $this->erro_banco = "";
               $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
               $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
               $this->erro_status = "0";
               return false;
           }
       }
     $sql .= " where ";
     if($si168_sequencial!=null){
       $sql .= " si168_sequencial = $this->si168_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si168_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011443,'$this->si168_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si168_sequencial"]) || $this->si168_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010402,2011443,'".AddSlashes(pg_result($resaco,$conresaco,'si168_sequencial'))."','$this->si168_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si168_vlsaldofinanceiroexercicioanterior"]) || $this->si168_vlsaldofinanceiroexercicioanterior != "")
           $resac = db_query("insert into db_acount values($acount,2010402,2011440,'".AddSlashes(pg_result($resaco,$conresaco,'si168_vlsaldofinanceiroexercicioanterior'))."','$this->si168_vlsaldofinanceiroexercicioanterior',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si168_dtcadastro"]) || $this->si168_dtcadastro != "")
           $resac = db_query("insert into db_acount values($acount,2010402,2011444,'".AddSlashes(pg_result($resaco,$conresaco,'si168_dtcadastro'))."','$this->si168_dtcadastro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si168_instit"]) || $this->si168_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010402,2011445,'".AddSlashes(pg_result($resaco,$conresaco,'si168_instit'))."','$this->si168_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "projecaoatuarial nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si168_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "projecaoatuarial nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si168_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si168_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si168_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si168_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011443,'$si168_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010402,2011443,'','".AddSlashes(pg_result($resaco,$iresaco,'si168_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010402,2011440,'','".AddSlashes(pg_result($resaco,$iresaco,'si168_vlsaldofinanceiroexercicioanterior'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010402,2011444,'','".AddSlashes(pg_result($resaco,$iresaco,'si168_dtcadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010402,2011445,'','".AddSlashes(pg_result($resaco,$iresaco,'si168_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from projecaoatuarial10
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si168_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si168_sequencial = $si168_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "projecaoatuarial nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si168_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "projecaoatuarial nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si168_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si168_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:projecaoatuarial10";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si168_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from projecaoatuarial10 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si168_sequencial!=null ){
         $sql2 .= " where projecaoatuarial10.si168_sequencial = $si168_sequencial "; 
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
   function sql_query_file ( $si168_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from projecaoatuarial10 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si168_sequencial!=null ){
         $sql2 .= " where projecaoatuarial10.si168_sequencial = $si168_sequencial "; 
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
