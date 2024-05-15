<?php
//MODULO: esocial
//CLASSE DA ENTIDADE evt5011consulta
class cl_evt5011consulta { 
  // cria variaveis de erro 
  public $rotulo     = null; 
  public $query_sql  = null; 
  public $numrows    = 0; 
  public $numrows_incluir = 0; 
  public $numrows_alterar = 0; 
  public $numrows_excluir = 0; 
  public $erro_status= null; 
  public $erro_sql   = null; 
  public $erro_banco = null;  
  public $erro_msg   = null;  
  public $erro_campo = null;  
  public $pagina_retorno = null; 
  // cria variaveis do arquivo 
  public $rh219_sequencial = 0; 
  public $rh219_perapurano = 0; 
  public $rh219_perapurmes = 0; 
  public $rh219_indapuracao = 0; 
  public $rh219_classtrib = 0; 
  public $rh219_cnaeprep = null; 
  public $rh219_aliqrat = 0; 
  public $rh219_fap = 0; 
  public $rh219_aliqratajust = 0; 
  public $rh219_fpas = null; 
  public $rh219_vrbccp00 = 0; 
  public $rh219_baseaposentadoria = 0; 
  public $rh219_vrsalfam = 0; 
  public $rh219_vrsalmat = 0; 
  public $rh219_vrdesccp = 0; 
  public $rh219_vrcpseg = 0; 
  public $rh219_vrcr = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 rh219_sequencial = int8 = Sequencial 
                 rh219_perapurano = int4 = Período Apuração Ano 
                 rh219_perapurmes = int4 = Período Apuração Mês 
                 rh219_indapuracao = int4 = Tipo de Folha 
                 rh219_classtrib = int8 = Classificação Tributária 
                 rh219_cnaeprep = varchar(10) = Código CNAE 
                 rh219_aliqrat = int8 = Alíquota RAT 
                 rh219_fap = float8 = Alíquota FAP 
                 rh219_aliqratajust = float8 = Alíquota RAT Ajustada 
                 rh219_fpas = varchar(10) = Código FPAS 
                 rh219_vrbccp00 = float8 = Base de Cálculo 
                 rh219_baseaposentadoria = float8 = Base de Cálculo Aposentadoria Especial 
                 rh219_vrsalfam = float8 = Valor Salário Família 
                 rh219_vrsalmat = float8 = Valor Salário Maternidade 
                 rh219_vrdesccp = float8 = Valor da Contribuição Descontada dos Segurados 
                 rh219_vrcpseg = float8 = Valor Calculado Pelo eSocial 
                 rh219_vrcr = float8 = Valor Total Devido à Previdência 
                 rh219_instit = int4 = Intituição 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("evt5011consulta"); 
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  //funcao erro 
  function erro($mostra,$retorna) { 
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )) {
      echo "<script>alert(\"".$this->erro_msg."\");</script>";
      if ($retorna==true) {
        echo "<script>location.href='".$this->pagina_retorno."'</script>";
      }
    }
  }

  // funcao para atualizar campos
  function atualizacampos($exclusao=false) {
    if ($exclusao==false) {
       $this->rh219_sequencial = ($this->rh219_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_sequencial"]:$this->rh219_sequencial);
       $this->rh219_perapurano = ($this->rh219_perapurano == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_perapurano"]:$this->rh219_perapurano);
       $this->rh219_perapurmes = ($this->rh219_perapurmes == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_perapurmes"]:$this->rh219_perapurmes);
       $this->rh219_indapuracao = ($this->rh219_indapuracao == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_indapuracao"]:$this->rh219_indapuracao);
       $this->rh219_classtrib = ($this->rh219_classtrib == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_classtrib"]:$this->rh219_classtrib);
       $this->rh219_cnaeprep = ($this->rh219_cnaeprep == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_cnaeprep"]:$this->rh219_cnaeprep);
       $this->rh219_aliqrat = ($this->rh219_aliqrat == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_aliqrat"]:$this->rh219_aliqrat);
       $this->rh219_fap = ($this->rh219_fap == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_fap"]:$this->rh219_fap);
       $this->rh219_aliqratajust = ($this->rh219_aliqratajust == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_aliqratajust"]:$this->rh219_aliqratajust);
       $this->rh219_fpas = ($this->rh219_fpas == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_fpas"]:$this->rh219_fpas);
       $this->rh219_vrbccp00 = ($this->rh219_vrbccp00 == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_vrbccp00"]:$this->rh219_vrbccp00);
       $this->rh219_baseaposentadoria = ($this->rh219_baseaposentadoria == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_baseaposentadoria"]:$this->rh219_baseaposentadoria);
       $this->rh219_vrsalfam = ($this->rh219_vrsalfam == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_vrsalfam"]:$this->rh219_vrsalfam);
       $this->rh219_vrsalmat = ($this->rh219_vrsalmat == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_vrsalmat"]:$this->rh219_vrsalmat);
       $this->rh219_vrdesccp = ($this->rh219_vrdesccp == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_vrdesccp"]:$this->rh219_vrdesccp);
       $this->rh219_vrcpseg = ($this->rh219_vrcpseg == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_vrcpseg"]:$this->rh219_vrcpseg);
       $this->rh219_vrcr = ($this->rh219_vrcr == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_vrcr"]:$this->rh219_vrcr);
       $this->rh219_instit = ($this->rh219_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_instit"]:$this->rh219_instit);
     } else {
       $this->rh219_sequencial = ($this->rh219_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh219_sequencial"]:$this->rh219_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($rh219_sequencial) {
      $this->atualizacampos();
     if ($this->rh219_perapurano == null ) { 
       $this->erro_sql = " Campo Período Apuração Ano não informado.";
       $this->erro_campo = "rh219_perapurano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh219_perapurmes == null ) { 
       $this->erro_sql = " Campo Período Apuração Mês não informado.";
       $this->erro_campo = "rh219_perapurmes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh219_indapuracao == null ) { 
       $this->erro_sql = " Campo Tipo de Folha não informado.";
       $this->erro_campo = "rh219_indapuracao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh219_classtrib == null ) { 
       $this->erro_sql = " Campo Classificação Tributária não informado.";
       $this->erro_campo = "rh219_classtrib";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh219_cnaeprep == null ) { 
       $this->erro_sql = " Campo Código CNAE não informado.";
       $this->erro_campo = "rh219_cnaeprep";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh219_aliqrat == null ) { 
       $this->erro_sql = " Campo Alíquota RAT não informado.";
       $this->erro_campo = "rh219_aliqrat";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh219_fap == null ) { 
       $this->erro_sql = " Campo Alíquota FAP não informado.";
       $this->erro_campo = "rh219_fap";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh219_aliqratajust == null ) { 
       $this->erro_sql = " Campo Alíquota RAT Ajustada não informado.";
       $this->erro_campo = "rh219_aliqratajust";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh219_fpas == null ) { 
       $this->erro_sql = " Campo Código FPAS não informado.";
       $this->erro_campo = "rh219_fpas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh219_instit == null ) { 
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "rh219_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($rh219_sequencial == "" || $rh219_sequencial == null ) {
       $result = db_query("select nextval('evt5011consulta_rh219_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: evt5011consulta_rh219_sequencial_seq do campo: rh219_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh219_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from evt5011consulta_rh219_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $rh219_sequencial)) {
         $this->erro_sql = " Campo rh219_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->rh219_sequencial = $rh219_sequencial; 
       }
     }
     if (($this->rh219_sequencial == null) || ($this->rh219_sequencial == "") ) { 
       $this->erro_sql = " Campo rh219_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into evt5011consulta(
                                       rh219_sequencial 
                                      ,rh219_perapurano 
                                      ,rh219_perapurmes 
                                      ,rh219_indapuracao 
                                      ,rh219_classtrib 
                                      ,rh219_cnaeprep 
                                      ,rh219_aliqrat 
                                      ,rh219_fap 
                                      ,rh219_aliqratajust 
                                      ,rh219_fpas 
                                      ,rh219_vrbccp00 
                                      ,rh219_baseaposentadoria 
                                      ,rh219_vrsalfam 
                                      ,rh219_vrsalmat 
                                      ,rh219_vrdesccp 
                                      ,rh219_vrcpseg 
                                      ,rh219_vrcr 
                                      ,rh219_instit
                       )
                values (
                                $this->rh219_sequencial 
                               ,$this->rh219_perapurano 
                               ,$this->rh219_perapurmes 
                               ,$this->rh219_indapuracao 
                               ,$this->rh219_classtrib 
                               ,'$this->rh219_cnaeprep' 
                               ,$this->rh219_aliqrat 
                               ,$this->rh219_fap 
                               ,$this->rh219_aliqratajust 
                               ,'$this->rh219_fpas' 
                               ,". ($this->rh219_vrbccp00 === NULL ? 0 : $this->rh219_vrbccp00). " 
                               ,". ($this->rh219_baseaposentadoria === NULL ? 0 : $this->rh219_baseaposentadoria). " 
                               ,". ($this->rh219_vrsalfam === NULL ? 0 : $this->rh219_vrsalfam). " 
                               ,". ($this->rh219_vrsalmat === NULL ? 0 : $this->rh219_vrsalmat). " 
                               ,". ($this->rh219_vrdesccp === NULL ? 0 : $this->rh219_vrdesccp). " 
                               ,". ($this->rh219_vrcpseg === NULL ? 0 : $this->rh219_vrcpseg). " 
                               ,". ($this->rh219_vrcr === NULL ? 0 : $this->rh219_vrcr). " 
                               ,$this->rh219_instit
                      )";
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Consulta do evento 5011 ($this->rh219_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Consulta do evento 5011 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Consulta do evento 5011 ($this->rh219_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh219_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
  }

  function alterar ($rh219_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update evt5011consulta set ";
     $virgula = "";
     if (trim($this->rh219_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_sequencial"])) { 
       $sql  .= $virgula." rh219_sequencial = $this->rh219_sequencial ";
       $virgula = ",";
       if (trim($this->rh219_sequencial) == null ) { 
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "rh219_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_perapurano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_perapurano"])) { 
       $sql  .= $virgula." rh219_perapurano = $this->rh219_perapurano ";
       $virgula = ",";
       if (trim($this->rh219_perapurano) == null ) { 
         $this->erro_sql = " Campo Período Apuração Ano não informado.";
         $this->erro_campo = "rh219_perapurano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_perapurmes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_perapurmes"])) { 
       $sql  .= $virgula." rh219_perapurmes = $this->rh219_perapurmes ";
       $virgula = ",";
       if (trim($this->rh219_perapurmes) == null ) { 
         $this->erro_sql = " Campo Período Apuração Mês não informado.";
         $this->erro_campo = "rh219_perapurmes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_indapuracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_indapuracao"])) { 
       $sql  .= $virgula." rh219_indapuracao = $this->rh219_indapuracao ";
       $virgula = ",";
       if (trim($this->rh219_indapuracao) == null ) { 
         $this->erro_sql = " Campo Tipo de Folha não informado.";
         $this->erro_campo = "rh219_indapuracao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_classtrib)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_classtrib"])) { 
       $sql  .= $virgula." rh219_classtrib = $this->rh219_classtrib ";
       $virgula = ",";
       if (trim($this->rh219_classtrib) == null ) { 
         $this->erro_sql = " Campo Classificação Tributária não informado.";
         $this->erro_campo = "rh219_classtrib";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_cnaeprep)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_cnaeprep"])) { 
       $sql  .= $virgula." rh219_cnaeprep = '$this->rh219_cnaeprep' ";
       $virgula = ",";
       if (trim($this->rh219_cnaeprep) == null ) { 
         $this->erro_sql = " Campo Código CNAE não informado.";
         $this->erro_campo = "rh219_cnaeprep";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_aliqrat)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_aliqrat"])) { 
       $sql  .= $virgula." rh219_aliqrat = $this->rh219_aliqrat ";
       $virgula = ",";
       if (trim($this->rh219_aliqrat) == null ) { 
         $this->erro_sql = " Campo Alíquota RAT não informado.";
         $this->erro_campo = "rh219_aliqrat";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_fap)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_fap"])) { 
       $sql  .= $virgula." rh219_fap = $this->rh219_fap ";
       $virgula = ",";
       if (trim($this->rh219_fap) == null ) { 
         $this->erro_sql = " Campo Alíquota FAP não informado.";
         $this->erro_campo = "rh219_fap";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_aliqratajust)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_aliqratajust"])) { 
       $sql  .= $virgula." rh219_aliqratajust = $this->rh219_aliqratajust ";
       $virgula = ",";
       if (trim($this->rh219_aliqratajust) == null ) { 
         $this->erro_sql = " Campo Alíquota RAT Ajustada não informado.";
         $this->erro_campo = "rh219_aliqratajust";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_fpas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_fpas"])) { 
       $sql  .= $virgula." rh219_fpas = '$this->rh219_fpas' ";
       $virgula = ",";
       if (trim($this->rh219_fpas) == null ) { 
         $this->erro_sql = " Campo Código FPAS não informado.";
         $this->erro_campo = "rh219_fpas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_vrbccp00)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_vrbccp00"])) { 
       $sql  .= $virgula." rh219_vrbccp00 = $this->rh219_vrbccp00 ";
       $virgula = ",";
       if (trim($this->rh219_vrbccp00) == null ) { 
         $this->erro_sql = " Campo Base de Cálculo não informado.";
         $this->erro_campo = "rh219_vrbccp00";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_baseaposentadoria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_baseaposentadoria"])) { 
       $sql  .= $virgula." rh219_baseaposentadoria = $this->rh219_baseaposentadoria ";
       $virgula = ",";
       if (trim($this->rh219_baseaposentadoria) == null ) { 
         $this->erro_sql = " Campo Base de Cálculo Aposentadoria Especial não informado.";
         $this->erro_campo = "rh219_baseaposentadoria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_vrsalfam)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_vrsalfam"])) { 
       $sql  .= $virgula." rh219_vrsalfam = $this->rh219_vrsalfam ";
       $virgula = ",";
       if (trim($this->rh219_vrsalfam) == null ) { 
         $this->erro_sql = " Campo Valor Salário Família não informado.";
         $this->erro_campo = "rh219_vrsalfam";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_vrsalmat)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_vrsalmat"])) { 
       $sql  .= $virgula." rh219_vrsalmat = $this->rh219_vrsalmat ";
       $virgula = ",";
       if (trim($this->rh219_vrsalmat) == null ) { 
         $this->erro_sql = " Campo Valor Salário Maternidade não informado.";
         $this->erro_campo = "rh219_vrsalmat";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_vrdesccp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_vrdesccp"])) { 
       $sql  .= $virgula." rh219_vrdesccp = $this->rh219_vrdesccp ";
       $virgula = ",";
       if (trim($this->rh219_vrdesccp) == null ) { 
         $this->erro_sql = " Campo Valor da Contribuição Descontada dos Segurados não informado.";
         $this->erro_campo = "rh219_vrdesccp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_vrcpseg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_vrcpseg"])) { 
       $sql  .= $virgula." rh219_vrcpseg = $this->rh219_vrcpseg ";
       $virgula = ",";
       if (trim($this->rh219_vrcpseg) == null ) { 
         $this->erro_sql = " Campo Valor Calculado Pelo eSocial não informado.";
         $this->erro_campo = "rh219_vrcpseg";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh219_vrcr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh219_vrcr"])) { 
       $sql  .= $virgula." rh219_vrcr = $this->rh219_vrcr ";
       $virgula = ",";
       if (trim($this->rh219_vrcr) == null ) { 
         $this->erro_sql = " Campo Valor Total Devido à Previdência não informado.";
         $this->erro_campo = "rh219_vrcr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($rh219_sequencial!=null) {
       $sql .= " rh219_sequencial = $this->rh219_sequencial";
     }
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Consulta do evento 5011 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh219_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Consulta do evento 5011 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh219_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh219_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  function excluir ($rh219_sequencial=null,$dbwhere=null) { 

     $sql = " delete from evt5011consulta
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($rh219_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " rh219_sequencial = $rh219_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Consulta do evento 5011 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh219_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Consulta do evento 5011 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh219_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh219_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
      }
    }
  }

  function sql_record($sql) { 
     $result = db_query($sql);
     if ($result==false) {
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if ($this->numrows==0) {
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:evt5011consulta";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  function sql_query ( $rh219_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
     $sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#", $campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     } else {
       $sql .= $campos;
     }
     $sql .= " from evt5011consulta ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh219_sequencial!=null ) {
         $sql2 .= " where evt5011consulta.rh219_sequencial = $rh219_sequencial "; 
       } 
     } else if ($dbwhere != "") {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if ($ordem != null ) {
       $sql .= " order by ";
       $campos_sql = explode("#", $ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
      }
    }
    return $sql;
  }

  function sql_query_file ( $rh219_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
     $sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#", $campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     } else {
       $sql .= $campos;
     }
     $sql .= " from evt5011consulta ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh219_sequencial!=null ) {
         $sql2 .= " where evt5011consulta.rh219_sequencial = $rh219_sequencial "; 
       } 
     } else if ($dbwhere != "") {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if ($ordem != null ) {
       $sql .= " order by ";
       $campos_sql = explode("#", $ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
      }
    }
    return $sql;
  }

  public function sqlInstitCgm($cgmEmpregador)
  {
    $sql = "select codigo from db_config
    where numcgm = {$cgmEmpregador}
    order by numcgm desc limit 1";
    $result = db_query($sql);
    return db_utils::fieldsMemory($result, 0)->codigo;
  }
}
?>
