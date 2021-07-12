<?
//MODULO: licitacao
//CLASSE DA ENTIDADE habilitacaoforn
class cl_habilitacaoforn { 
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
   var $l206_sequencial = 0; 
   var $l206_fornecedor = 0; 
   var $l206_licitacao = 0; 
   var $l206_representante = null; 
   var $l206_datahab_dia = null; 
   var $l206_datahab_mes = null; 
   var $l206_datahab_ano = null; 
   var $l206_datahab = null; 
   var $l206_numcertidaoinss = null; 
   var $l206_dataemissaoinss_dia = null; 
   var $l206_dataemissaoinss_mes = null; 
   var $l206_dataemissaoinss_ano = null; 
   var $l206_dataemissaoinss = null; 
   var $l206_datavalidadeinss_dia = null; 
   var $l206_datavalidadeinss_mes = null; 
   var $l206_datavalidadeinss_ano = null; 
   var $l206_datavalidadeinss = null; 
   var $l206_numcertidaofgts = null; 
   var $l206_dataemissaofgts_dia = null; 
   var $l206_dataemissaofgts_mes = null; 
   var $l206_dataemissaofgts_ano = null; 
   var $l206_dataemissaofgts = null; 
   var $l206_datavalidadefgts_dia = null; 
   var $l206_datavalidadefgts_mes = null; 
   var $l206_datavalidadefgts_ano = null; 
   var $l206_datavalidadefgts = null; 
   var $l206_numcertidaocndt = null; 
   var $l206_dataemissaocndt_dia = null; 
   var $l206_dataemissaocndt_mes = null; 
   var $l206_dataemissaocndt_ano = null; 
   var $l206_dataemissaocndt = null; 
   var $l206_datavalidadecndt_dia = null; 
   var $l206_datavalidadecndt_mes = null; 
   var $l206_datavalidadecndt_ano = null; 
   var $l206_datavalidadecndt = null;
   var $fisica_juridica = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 l206_sequencial = int4 = Sequencial 
                 l206_fornecedor = int4 = Fornecedor 
                 l206_licitacao = int8 = Código Licitação 
                 l206_representante = varchar(100) = Representante 
                 l206_datahab = date = Data Habilitação 
                 l206_numcertidaoinss = varchar(30) = Número Certidão INSS 
                 l206_dataemissaoinss = date = Data Emissão 
                 l206_datavalidadeinss = date = Data de Validade 
                 l206_numcertidaofgts = varchar(30) = Número Certidão FGTS 
                 l206_dataemissaofgts = date = Data Emissão 
                 l206_datavalidadefgts = date = Data de Validade 
                 l206_numcertidaocndt = varchar(30) = Número Certidão CNDT 
                 l206_dataemissaocndt = date = Data Emissão 
                 l206_datavalidadecndt = date = Data de Validade 
                 ";
   //funcao construtor da classe 
   function cl_habilitacaoforn() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("habilitacaoforn"); 
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
       $this->l206_sequencial = ($this->l206_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_sequencial"]:$this->l206_sequencial);
       $this->l206_fornecedor = ($this->l206_fornecedor == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_fornecedor"]:$this->l206_fornecedor);
       $this->l206_licitacao = ($this->l206_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_licitacao"]:$this->l206_licitacao);
       $this->l206_representante = ($this->l206_representante == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_representante"]:$this->l206_representante);
       if($this->l206_datahab == ""){
         $this->l206_datahab_dia = ($this->l206_datahab_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datahab_dia"]:$this->l206_datahab_dia);
         $this->l206_datahab_mes = ($this->l206_datahab_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datahab_mes"]:$this->l206_datahab_mes);
         $this->l206_datahab_ano = ($this->l206_datahab_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datahab_ano"]:$this->l206_datahab_ano);
         if($this->l206_datahab_dia != ""){
            $this->l206_datahab = $this->l206_datahab_ano."-".$this->l206_datahab_mes."-".$this->l206_datahab_dia;
         }
       }
       $this->l206_numcertidaoinss = ($this->l206_numcertidaoinss == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_numcertidaoinss"]:$this->l206_numcertidaoinss);
       if($this->l206_dataemissaoinss == ""){
         $this->l206_dataemissaoinss_dia = ($this->l206_dataemissaoinss_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_dataemissaoinss_dia"]:$this->l206_dataemissaoinss_dia);
         $this->l206_dataemissaoinss_mes = ($this->l206_dataemissaoinss_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_dataemissaoinss_mes"]:$this->l206_dataemissaoinss_mes);
         $this->l206_dataemissaoinss_ano = ($this->l206_dataemissaoinss_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_dataemissaoinss_ano"]:$this->l206_dataemissaoinss_ano);
         if($this->l206_dataemissaoinss_dia != ""){
            $this->l206_dataemissaoinss = $this->l206_dataemissaoinss_ano."-".$this->l206_dataemissaoinss_mes."-".$this->l206_dataemissaoinss_dia;
         }
       }
       if($this->l206_datavalidadeinss == ""){
         $this->l206_datavalidadeinss_dia = ($this->l206_datavalidadeinss_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datavalidadeinss_dia"]:$this->l206_datavalidadeinss_dia);
         $this->l206_datavalidadeinss_mes = ($this->l206_datavalidadeinss_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datavalidadeinss_mes"]:$this->l206_datavalidadeinss_mes);
         $this->l206_datavalidadeinss_ano = ($this->l206_datavalidadeinss_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datavalidadeinss_ano"]:$this->l206_datavalidadeinss_ano);
         if($this->l206_datavalidadeinss_dia != ""){
            $this->l206_datavalidadeinss = $this->l206_datavalidadeinss_ano."-".$this->l206_datavalidadeinss_mes."-".$this->l206_datavalidadeinss_dia;
         }
       }
       $this->l206_numcertidaofgts = ($this->l206_numcertidaofgts == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_numcertidaofgts"]:$this->l206_numcertidaofgts);
       if($this->l206_dataemissaofgts == ""){
         $this->l206_dataemissaofgts_dia = ($this->l206_dataemissaofgts_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_dataemissaofgts_dia"]:$this->l206_dataemissaofgts_dia);
         $this->l206_dataemissaofgts_mes = ($this->l206_dataemissaofgts_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_dataemissaofgts_mes"]:$this->l206_dataemissaofgts_mes);
         $this->l206_dataemissaofgts_ano = ($this->l206_dataemissaofgts_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_dataemissaofgts_ano"]:$this->l206_dataemissaofgts_ano);
         if($this->l206_dataemissaofgts_dia != ""){
            $this->l206_dataemissaofgts = $this->l206_dataemissaofgts_ano."-".$this->l206_dataemissaofgts_mes."-".$this->l206_dataemissaofgts_dia;
         }
       }
       if($this->l206_datavalidadefgts == ""){
         $this->l206_datavalidadefgts_dia = ($this->l206_datavalidadefgts_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datavalidadefgts_dia"]:$this->l206_datavalidadefgts_dia);
         $this->l206_datavalidadefgts_mes = ($this->l206_datavalidadefgts_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datavalidadefgts_mes"]:$this->l206_datavalidadefgts_mes);
         $this->l206_datavalidadefgts_ano = ($this->l206_datavalidadefgts_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datavalidadefgts_ano"]:$this->l206_datavalidadefgts_ano);
         if($this->l206_datavalidadefgts_dia != ""){
            $this->l206_datavalidadefgts = $this->l206_datavalidadefgts_ano."-".$this->l206_datavalidadefgts_mes."-".$this->l206_datavalidadefgts_dia;
         }
       }
       $this->l206_numcertidaocndt = ($this->l206_numcertidaocndt == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_numcertidaocndt"]:$this->l206_numcertidaocndt);
       if($this->l206_dataemissaocndt == ""){
         $this->l206_dataemissaocndt_dia = ($this->l206_dataemissaocndt_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_dataemissaocndt_dia"]:$this->l206_dataemissaocndt_dia);
         $this->l206_dataemissaocndt_mes = ($this->l206_dataemissaocndt_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_dataemissaocndt_mes"]:$this->l206_dataemissaocndt_mes);
         $this->l206_dataemissaocndt_ano = ($this->l206_dataemissaocndt_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_dataemissaocndt_ano"]:$this->l206_dataemissaocndt_ano);
         if($this->l206_dataemissaocndt_dia != ""){
            $this->l206_dataemissaocndt = $this->l206_dataemissaocndt_ano."-".$this->l206_dataemissaocndt_mes."-".$this->l206_dataemissaocndt_dia;
         }
       }
       if($this->l206_datavalidadecndt == ""){
         $this->l206_datavalidadecndt_dia = ($this->l206_datavalidadecndt_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datavalidadecndt_dia"]:$this->l206_datavalidadecndt_dia);
         $this->l206_datavalidadecndt_mes = ($this->l206_datavalidadecndt_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datavalidadecndt_mes"]:$this->l206_datavalidadecndt_mes);
         $this->l206_datavalidadecndt_ano = ($this->l206_datavalidadecndt_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_datavalidadecndt_ano"]:$this->l206_datavalidadecndt_ano);
         if($this->l206_datavalidadecndt_dia != ""){
            $this->l206_datavalidadecndt = $this->l206_datavalidadecndt_ano."-".$this->l206_datavalidadecndt_mes."-".$this->l206_datavalidadecndt_dia;
         }
       }
     }else{
       $this->l206_sequencial = ($this->l206_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l206_sequencial"]:$this->l206_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($l206_sequencial){ 
      $this->atualizacampos();
      $this->verifica_fisica_juridica($this->l206_fornecedor);
     if($this->l206_fornecedor == null ){ 
       $this->erro_sql = " Campo Fornecedor nao Informado.";
       $this->erro_campo = "l206_fornecedor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_licitacao == null ){ 
       $this->erro_sql = " Campo Código Licitação nao Informado.";
       $this->erro_campo = "l206_licitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     /*if($this->l206_representante == null ){ 
       $this->erro_sql = " Campo Representante nao Informado.";
       $this->erro_campo = "l206_representante";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
     if($this->l206_datahab == null){ 
       $this->erro_sql = " Campo Data Habilitação nao Informado.";
       $this->erro_campo = "l206_datahab_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_numcertidaoinss == null && $this->fisica_juridica == 'j'){ 
       $this->erro_sql = " Campo Número Certidão INSS nao Informado.";
       $this->erro_campo = "l206_numcertidaoinss";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_dataemissaoinss == null && $this->fisica_juridica == 'j'){ 
       $this->erro_sql = " Campo Data Emissão nao Informado.";
       $this->erro_campo = "l206_dataemissaoinss_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_datavalidadeinss == null && $this->fisica_juridica == 'j'){ 
       $this->erro_sql = " Campo Data de Validade nao Informado.";
       $this->erro_campo = "l206_datavalidadeinss_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_datavalidadeinss < $this->l206_datahab){
       $this->erro_sql = " Campo Data de Validade deve ser maior ou igual a Data Habilitação.";
       $this->erro_campo = "l206_datavalidadeinss_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_numcertidaofgts == null && $this->fisica_juridica == 'j'){ 
       $this->erro_sql = " Campo Número Certidão FGTS nao Informado.";
       $this->erro_campo = "l206_numcertidaofgts";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_dataemissaofgts == null && $this->fisica_juridica == 'j'){ 
       $this->erro_sql = " Campo Data Emissão nao Informado.";
       $this->erro_campo = "l206_dataemissaofgts_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_datavalidadefgts == null && $this->fisica_juridica == 'j'){ 
       $this->erro_sql = " Campo Data de Validade nao Informado.";
       $this->erro_campo = "l206_datavalidadefgts_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_datavalidadefgts < $this->l206_datahab){
       $this->erro_sql = " Campo Data de Validade deve ser maior ou igual a Data Habilitação.";
       $this->erro_campo = "l206_datavalidadefgts_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_numcertidaocndt == null && $this->fisica_juridica == 'j'){ 
       $this->erro_sql = " Campo Número Certidão CNDT nao Informado.";
       $this->erro_campo = "l206_numcertidaocndt";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_dataemissaocndt == null && $this->fisica_juridica == 'j'){ 
       $this->erro_sql = " Campo Data Emissão nao Informado.";
       $this->erro_campo = "l206_dataemissaocndt_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_datavalidadecndt == null && $this->fisica_juridica == 'j'){ 
       $this->erro_sql = " Campo Data de Validade nao Informado.";
       $this->erro_campo = "l206_datavalidadecndt_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l206_datavalidadecndt < $this->l206_datahab){
       $this->erro_sql = " Campo Data de Validade deve ser maior ou igual a Data Habilitação.";
       $this->erro_campo = "l206_datavalidadecndt_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($l206_sequencial == "" || $l206_sequencial == null ){
       $result = db_query("select nextval('habilitacaoforn_l206_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: habilitacaoforn_l206_sequencial_seq do campo: l206_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->l206_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from habilitacaoforn_l206_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $l206_sequencial)){
         $this->erro_sql = " Campo l206_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->l206_sequencial = $l206_sequencial; 
       }
     }
     if(($this->l206_sequencial == null) || ($this->l206_sequencial == "") ){ 
       $this->erro_sql = " Campo l206_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into habilitacaoforn(
                                       l206_sequencial 
                                      ,l206_fornecedor 
                                      ,l206_licitacao 
                                      ,l206_representante 
                                      ,l206_datahab 
                                      ,l206_numcertidaoinss 
                                      ,l206_dataemissaoinss 
                                      ,l206_datavalidadeinss 
                                      ,l206_numcertidaofgts 
                                      ,l206_dataemissaofgts 
                                      ,l206_datavalidadefgts 
                                      ,l206_numcertidaocndt 
                                      ,l206_dataemissaocndt 
                                      ,l206_datavalidadecndt 
                       )
                values (
                                $this->l206_sequencial 
                               ,$this->l206_fornecedor 
                               ,$this->l206_licitacao 
                               ,'$this->l206_representante' 
                               ,".($this->l206_datahab == "null" || $this->l206_datahab == ""?"null":"'".$this->l206_datahab."'")." 
                               ,'$this->l206_numcertidaoinss' 
                               ,".($this->l206_dataemissaoinss == "null" || $this->l206_dataemissaoinss == ""?"null":"'".$this->l206_dataemissaoinss."'")." 
                               ,".($this->l206_datavalidadeinss == "null" || $this->l206_datavalidadeinss == ""?"null":"'".$this->l206_datavalidadeinss."'")." 
                               ,'$this->l206_numcertidaofgts' 
                               ,".($this->l206_dataemissaofgts == "null" || $this->l206_dataemissaofgts == ""?"null":"'".$this->l206_dataemissaofgts."'")." 
                               ,".($this->l206_datavalidadefgts == "null" || $this->l206_datavalidadefgts == ""?"null":"'".$this->l206_datavalidadefgts."'")." 
                               ,'$this->l206_numcertidaocndt' 
                               ,".($this->l206_dataemissaocndt == "null" || $this->l206_dataemissaocndt == ""?"null":"'".$this->l206_dataemissaocndt."'")." 
                               ,".($this->l206_datavalidadecndt == "null" || $this->l206_datavalidadecndt == ""?"null":"'".$this->l206_datavalidadecndt."'")." 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Habilitação ($this->l206_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Habilitação já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Habilitação ($this->l206_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l206_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->l206_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009482,'$this->l206_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010232,2009482,'','".AddSlashes(pg_result($resaco,0,'l206_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009483,'','".AddSlashes(pg_result($resaco,0,'l206_fornecedor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009543,'','".AddSlashes(pg_result($resaco,0,'l206_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009544,'','".AddSlashes(pg_result($resaco,0,'l206_representante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009545,'','".AddSlashes(pg_result($resaco,0,'l206_datahab'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009566,'','".AddSlashes(pg_result($resaco,0,'l206_numcertidaoinss'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009567,'','".AddSlashes(pg_result($resaco,0,'l206_dataemissaoinss'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009568,'','".AddSlashes(pg_result($resaco,0,'l206_datavalidadeinss'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009569,'','".AddSlashes(pg_result($resaco,0,'l206_numcertidaofgts'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009570,'','".AddSlashes(pg_result($resaco,0,'l206_dataemissaofgts'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009571,'','".AddSlashes(pg_result($resaco,0,'l206_datavalidadefgts'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009572,'','".AddSlashes(pg_result($resaco,0,'l206_numcertidaocndt'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009573,'','".AddSlashes(pg_result($resaco,0,'l206_dataemissaocndt'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010232,2009574,'','".AddSlashes(pg_result($resaco,0,'l206_datavalidadecndt'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($l206_sequencial=null) { 
      $this->atualizacampos();
      $this->verifica_fisica_juridica($this->l206_fornecedor);
     $sql = " update habilitacaoforn set ";
     $virgula = "";
     if(trim($this->l206_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_sequencial"])){ 
       $sql  .= $virgula." l206_sequencial = $this->l206_sequencial ";
       $virgula = ",";
       if(trim($this->l206_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "l206_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l206_fornecedor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_fornecedor"])){ 
       $sql  .= $virgula." l206_fornecedor = $this->l206_fornecedor ";
       $virgula = ",";
       if(trim($this->l206_fornecedor) == null ){ 
         $this->erro_sql = " Campo Fornecedor nao Informado.";
         $this->erro_campo = "l206_fornecedor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l206_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_licitacao"])){ 
       $sql  .= $virgula." l206_licitacao = $this->l206_licitacao ";
       $virgula = ",";
       if(trim($this->l206_licitacao) == null ){ 
         $this->erro_sql = " Campo Código Licitação nao Informado.";
         $this->erro_campo = "l206_licitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l206_representante)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_representante"])){ 
       $sql  .= $virgula." l206_representante = '$this->l206_representante' ";
       $virgula = ",";
       /*if(trim($this->l206_representante) == null ){ 
         $this->erro_sql = " Campo Representante nao Informado.";
         $this->erro_campo = "l206_representante";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }*/
     }
     if(trim($this->l206_datahab)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_datahab_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l206_datahab_dia"] !="") ){ 
       $sql  .= $virgula." l206_datahab = '$this->l206_datahab' ";
       $virgula = ",";
       if(trim($this->l206_datahab) == null){ 
         $this->erro_sql = " Campo Data Habilitação nao Informado.";
         $this->erro_campo = "l206_datahab_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l206_datahab_dia"])){ 
         $sql  .= $virgula." l206_datahab = null ";
         $virgula = ",";
         if(trim($this->l206_datahab) == null){ 
           $this->erro_sql = " Campo Data Habilitação nao Informado.";
           $this->erro_campo = "l206_datahab_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->l206_numcertidaoinss)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_numcertidaoinss"])){ 
       $sql  .= $virgula." l206_numcertidaoinss = '$this->l206_numcertidaoinss' ";
       $virgula = ",";
       if(trim($this->l206_numcertidaoinss) == null && $this->fisica_juridica == 'j'){ 
         $this->erro_sql = " Campo Número Certidão INSS nao Informado.";
         $this->erro_campo = "l206_numcertidaoinss";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l206_dataemissaoinss)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaoinss_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaoinss_dia"] !="") ){ 
       $sql  .= $virgula." l206_dataemissaoinss = '$this->l206_dataemissaoinss' ";
       $virgula = ",";
       if(trim($this->l206_dataemissaoinss) == null && $this->fisica_juridica == 'j'){ 
         $this->erro_sql = " Campo Data Emissão nao Informado.";
         $this->erro_campo = "l206_dataemissaoinss_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaoinss_dia"])){ 
         $sql  .= $virgula." l206_dataemissaoinss = null ";
         $virgula = ",";
         if(trim($this->l206_dataemissaoinss) == null && $this->fisica_juridica == 'j'){ 
           $this->erro_sql = " Campo Data Emissão nao Informado.";
           $this->erro_campo = "l206_dataemissaoinss_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     
     if(trim($this->l206_datavalidadeinss)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadeinss_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadeinss_dia"] !="") ){ 
       $sql  .= $virgula." l206_datavalidadeinss = '$this->l206_datavalidadeinss' ";
       $virgula = ",";
       if(trim($this->l206_datavalidadeinss) == null && $this->fisica_juridica == 'j'){ 
         $this->erro_sql = " Campo Data de Validade nao Informado.";
         $this->erro_campo = "l206_datavalidadeinss_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadeinss_dia"])){ 
         $sql  .= $virgula." l206_datavalidadeinss = null ";
         $virgula = ",";
         if(trim($this->l206_datavalidadeinss) == null && $this->fisica_juridica == 'j'){ 
           $this->erro_sql = " Campo Data de Validade nao Informado.";
           $this->erro_campo = "l206_datavalidadeinss_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if($this->l206_datavalidadeinss < $this->l206_datahab){
       $this->erro_sql = " Campo Data de Validade deve ser maior ou igual a Data Habilitação.";
       $this->erro_campo = "l206_datavalidadeinss_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(trim($this->l206_numcertidaofgts)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_numcertidaofgts"])){ 
       $sql  .= $virgula." l206_numcertidaofgts = '$this->l206_numcertidaofgts' ";
       $virgula = ",";
       if(trim($this->l206_numcertidaofgts) == null && $this->fisica_juridica == 'j'){ 
         $this->erro_sql = " Campo Número Certidão FGTS nao Informado.";
         $this->erro_campo = "l206_numcertidaofgts";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l206_dataemissaofgts)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaofgts_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaofgts_dia"] !="") ){ 
       $sql  .= $virgula." l206_dataemissaofgts = '$this->l206_dataemissaofgts' ";
       $virgula = ",";
       if(trim($this->l206_dataemissaofgts) == null && $this->fisica_juridica == 'j'){ 
         $this->erro_sql = " Campo Data Emissão nao Informado.";
         $this->erro_campo = "l206_dataemissaofgts_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaofgts_dia"])){ 
         $sql  .= $virgula." l206_dataemissaofgts = null ";
         $virgula = ",";
         if(trim($this->l206_dataemissaofgts) == null && $this->fisica_juridica == 'j'){ 
           $this->erro_sql = " Campo Data Emissão nao Informado.";
           $this->erro_campo = "l206_dataemissaofgts_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->l206_datavalidadefgts)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadefgts_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadefgts_dia"] !="") ){ 
       $sql  .= $virgula." l206_datavalidadefgts = '$this->l206_datavalidadefgts' ";
       $virgula = ",";
       if(trim($this->l206_datavalidadefgts) == null && $this->fisica_juridica == 'j'){ 
         $this->erro_sql = " Campo Data de Validade nao Informado.";
         $this->erro_campo = "l206_datavalidadefgts_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadefgts_dia"])){ 
         $sql  .= $virgula." l206_datavalidadefgts = null ";
         $virgula = ",";
         if(trim($this->l206_datavalidadefgts) == null && $this->fisica_juridica == 'j'){ 
           $this->erro_sql = " Campo Data de Validade nao Informado.";
           $this->erro_campo = "l206_datavalidadefgts_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if($this->l206_datavalidadefgts < $this->l206_datahab){
       $this->erro_sql = " Campo Data de Validade deve ser maior ou igual a Data Habilitação.";
       $this->erro_campo = "l206_datavalidadefgts_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(trim($this->l206_numcertidaocndt)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_numcertidaocndt"])){ 
       $sql  .= $virgula." l206_numcertidaocndt = '$this->l206_numcertidaocndt' ";
       $virgula = ",";
       if(trim($this->l206_numcertidaocndt) == null && $this->fisica_juridica == 'j'){ 
         $this->erro_sql = " Campo Número Certidão CNDT nao Informado.";
         $this->erro_campo = "l206_numcertidaocndt";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l206_dataemissaocndt)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaocndt_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaocndt_dia"] !="") ){ 
       $sql  .= $virgula." l206_dataemissaocndt = '$this->l206_dataemissaocndt' ";
       $virgula = ",";
       if(trim($this->l206_dataemissaocndt) == null && $this->fisica_juridica == 'j'){ 
         $this->erro_sql = " Campo Data Emissão nao Informado.";
         $this->erro_campo = "l206_dataemissaocndt_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaocndt_dia"])){ 
         $sql  .= $virgula." l206_dataemissaocndt = null ";
         $virgula = ",";
         if(trim($this->l206_dataemissaocndt) == null && $this->fisica_juridica == 'j'){ 
           $this->erro_sql = " Campo Data Emissão nao Informado.";
           $this->erro_campo = "l206_dataemissaocndt_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->l206_datavalidadecndt)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadecndt_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadecndt_dia"] !="") ){ 
       $sql  .= $virgula." l206_datavalidadecndt = '$this->l206_datavalidadecndt' ";
       $virgula = ",";
       if(trim($this->l206_datavalidadecndt) == null && $this->fisica_juridica == 'j'){ 
         $this->erro_sql = " Campo Data de Validade nao Informado.";
         $this->erro_campo = "l206_datavalidadecndt_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadecndt_dia"])){ 
         $sql  .= $virgula." l206_datavalidadecndt = null ";
         $virgula = ",";
         if(trim($this->l206_datavalidadecndt) == null && $this->fisica_juridica == 'j'){ 
           $this->erro_sql = " Campo Data de Validade nao Informado.";
           $this->erro_campo = "l206_datavalidadecndt_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
   if($this->l206_datavalidadecndt < $this->l206_datahab){
       $this->erro_sql = " Campo Data de Validade deve ser maior ou igual a Data Habilitação.";
       $this->erro_campo = "l206_datavalidadecndt_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql .= " where ";
     if($l206_sequencial!=null){
       $sql .= " l206_sequencial = $this->l206_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->l206_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009482,'$this->l206_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_sequencial"]) || $this->l206_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009482,'".AddSlashes(pg_result($resaco,$conresaco,'l206_sequencial'))."','$this->l206_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_fornecedor"]) || $this->l206_fornecedor != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009483,'".AddSlashes(pg_result($resaco,$conresaco,'l206_fornecedor'))."','$this->l206_fornecedor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_licitacao"]) || $this->l206_licitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009543,'".AddSlashes(pg_result($resaco,$conresaco,'l206_licitacao'))."','$this->l206_licitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_representante"]) || $this->l206_representante != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009544,'".AddSlashes(pg_result($resaco,$conresaco,'l206_representante'))."','$this->l206_representante',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_datahab"]) || $this->l206_datahab != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009545,'".AddSlashes(pg_result($resaco,$conresaco,'l206_datahab'))."','$this->l206_datahab',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_numcertidaoinss"]) || $this->l206_numcertidaoinss != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009566,'".AddSlashes(pg_result($resaco,$conresaco,'l206_numcertidaoinss'))."','$this->l206_numcertidaoinss',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaoinss"]) || $this->l206_dataemissaoinss != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009567,'".AddSlashes(pg_result($resaco,$conresaco,'l206_dataemissaoinss'))."','$this->l206_dataemissaoinss',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadeinss"]) || $this->l206_datavalidadeinss != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009568,'".AddSlashes(pg_result($resaco,$conresaco,'l206_datavalidadeinss'))."','$this->l206_datavalidadeinss',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_numcertidaofgts"]) || $this->l206_numcertidaofgts != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009569,'".AddSlashes(pg_result($resaco,$conresaco,'l206_numcertidaofgts'))."','$this->l206_numcertidaofgts',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaofgts"]) || $this->l206_dataemissaofgts != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009570,'".AddSlashes(pg_result($resaco,$conresaco,'l206_dataemissaofgts'))."','$this->l206_dataemissaofgts',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadefgts"]) || $this->l206_datavalidadefgts != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009571,'".AddSlashes(pg_result($resaco,$conresaco,'l206_datavalidadefgts'))."','$this->l206_datavalidadefgts',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_numcertidaocndt"]) || $this->l206_numcertidaocndt != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009572,'".AddSlashes(pg_result($resaco,$conresaco,'l206_numcertidaocndt'))."','$this->l206_numcertidaocndt',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_dataemissaocndt"]) || $this->l206_dataemissaocndt != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009573,'".AddSlashes(pg_result($resaco,$conresaco,'l206_dataemissaocndt'))."','$this->l206_dataemissaocndt',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l206_datavalidadecndt"]) || $this->l206_datavalidadecndt != "")
           $resac = db_query("insert into db_acount values($acount,2010232,2009574,'".AddSlashes(pg_result($resaco,$conresaco,'l206_datavalidadecndt'))."','$this->l206_datavalidadecndt',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Habilitação nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->l206_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Habilitação nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->l206_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l206_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($l206_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($l206_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009482,'$l206_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010232,2009482,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009483,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_fornecedor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009543,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009544,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_representante'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009545,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_datahab'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009566,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_numcertidaoinss'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009567,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_dataemissaoinss'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009568,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_datavalidadeinss'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009569,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_numcertidaofgts'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009570,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_dataemissaofgts'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009571,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_datavalidadefgts'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009572,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_numcertidaocndt'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009573,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_dataemissaocndt'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010232,2009574,'','".AddSlashes(pg_result($resaco,$iresaco,'l206_datavalidadecndt'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from habilitacaoforn
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($l206_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " l206_sequencial = $l206_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Habilitação nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$l206_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Habilitação nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$l206_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$l206_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:habilitacaoforn";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $l206_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from habilitacaoforn ";
     $sql .= "      inner join pcforne  on  pcforne.pc60_numcgm = habilitacaoforn.l206_fornecedor";
     $sql .= "      inner join liclicita  on  liclicita.l20_codigo = habilitacaoforn.l206_licitacao";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = pcforne.pc60_numcgm";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = pcforne.pc60_usuario";
     $sql .= "      inner join db_config  on  db_config.codigo = liclicita.l20_instit";
     $sql .= "      inner join db_usuarios  as a on   a.id_usuario = liclicita.l20_id_usucria";
     $sql .= "      inner join cflicita  on  cflicita.l03_codigo = liclicita.l20_codtipocom";
     $sql .= "      inner join liclocal  on  liclocal.l26_codigo = liclicita.l20_liclocal";
     $sql .= "      inner join liccomissao  on  liccomissao.l30_codigo = liclicita.l20_liccomissao";
     $sql .= "      inner join licsituacao  on  licsituacao.l08_sequencial = liclicita.l20_licsituacao";
     //$sql .= "      inner join licpregao  on  licpregao.l45_sequencial = liclicita.l20_equipepregao";
     $sql2 = "";
     if($dbwhere==""){
       if($l206_sequencial!=null ){
         $sql2 .= " where habilitacaoforn.l206_sequencial = $l206_sequencial "; 
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
   function sql_query_file ( $l206_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from habilitacaoforn ";
     $sql2 = "";
     if($dbwhere==""){
       if($l206_sequencial!=null ){
         $sql2 .= " where habilitacaoforn.l206_sequencial = $l206_sequencial "; 
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
  
  function verifica_fisica_juridica($num_cgm) {
  	$sql = "select z01_cgccpf from cgm where z01_numcgm = $num_cgm";
  	$result = db_query($sql);
  	if (strlen(pg_result($result,0,0)) == 11) {
  		$this->fisica_juridica = 'f';
  	} else {
  		$this->fisica_juridica = 'j';
  	}
  }
}
?>
