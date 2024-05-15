<?php
//MODULO: esocial
//CLASSE DA ENTIDADE arquivoretornodados
class cl_arquivoretornodados { 
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
  public $rh217_sequencial = 0; 
  public $rh217_cpf = null; 
  public $rh217_nis = null; 
  public $rh217_nome = null; 
  public $rh217_dn = null; 
  public $rh217_cod_nis_inv = 0; 
  public $rh217_cod_cpf_inv = 0; 
  public $rh217_cod_nome_inv = 0; 
  public $rh217_cod_dn_inv = 0; 
  public $rh217_cod_cnis_nis = 0; 
  public $rh217_cod_cnis_dn = 0; 
  public $rh217_cod_cnis_obito = 0; 
  public $rh217_cod_cnis_cpf = 0; 
  public $rh217_cod_cnis_cpf_nao_inf = 0; 
  public $rh217_cod_cpf_nao_consta = 0; 
  public $rh217_cod_cpf_nulo = 0; 
  public $rh217_cod_cpf_cancelado = 0; 
  public $rh217_cod_cpf_suspenso = 0; 
  public $rh217_cod_cpf_dn = 0; 
  public $rh217_cod_cpf_nome = 0; 
  public $rh217_cod_orientacao_cpf = 0; 
  public $rh217_cod_orientacao_nis = 0; 
  public $rh217_arquivoretorno = 0; 
  public $rh217_msg = null; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 rh217_sequencial = int8 = Código Sequencial 
                 rh217_cpf = varchar(11) = CPF 
                 rh217_nis = varchar(11) = NIS 
                 rh217_nome = varchar(100) = Nome 
                 rh217_dn = varchar(8) = Data Nascimento 
                 rh217_cod_nis_inv = int4 = NIS Inválido 
                 rh217_cod_cpf_inv = int4 = CPF Inválido 
                 rh217_cod_nome_inv = int4 = Nome Inválido 
                 rh217_cod_dn_inv = int4 = Data Nascimento Inválido 
                 rh217_cod_cnis_nis = int4 = NIS CNIS Inválido 
                 rh217_cod_cnis_dn = int4 = Data Nascimento CNIS Inválido 
                 rh217_cod_cnis_obito = int4 = Óbito CNIS Inválido 
                 rh217_cod_cnis_cpf = int4 = CPF CNIS Inválido 
                 rh217_cod_cnis_cpf_nao_inf = int4 = CPF CNIS Não Informado 
                 rh217_cod_cpf_nao_consta = int4 = CPF Não Consta 
                 rh217_cod_cpf_nulo = int4 = CPF Nulo 
                 rh217_cod_cpf_cancelado = int4 = CPF Cancelado 
                 rh217_cod_cpf_suspenso = int4 = CPF Suspenso 
                 rh217_cod_cpf_dn = int4 = CPF Data Nascimento Diverge 
                 rh217_cod_cpf_nome = int4 = CPF Nome Diverge 
                 rh217_cod_orientacao_cpf = int4 = Orientação CPF 
                 rh217_cod_orientacao_nis = int4 = Orientação NIS 
                 rh217_arquivoretorno = int8 = Cod. Arquivo Controle 
                 rh217_msg = array = Mensagens de Retorno 
                 ";
  public $aSqlAddInserts = array();
  public $bAddInserst = false;
  public $iNumberRowsInsert = 50;

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("arquivoretornodados"); 
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
       $this->rh217_sequencial = ($this->rh217_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_sequencial"]:$this->rh217_sequencial);
       $this->rh217_cpf = ($this->rh217_cpf == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cpf"]:$this->rh217_cpf);
       $this->rh217_nis = ($this->rh217_nis == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_nis"]:$this->rh217_nis);
       $this->rh217_nome = ($this->rh217_nome == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_nome"]:$this->rh217_nome);
       $this->rh217_dn = ($this->rh217_dn == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_dn"]:$this->rh217_dn);
       $this->rh217_cod_nis_inv = ($this->rh217_cod_nis_inv == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_nis_inv"]:$this->rh217_cod_nis_inv);
       $this->rh217_cod_cpf_inv = ($this->rh217_cod_cpf_inv == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_inv"]:$this->rh217_cod_cpf_inv);
       $this->rh217_cod_nome_inv = ($this->rh217_cod_nome_inv == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_nome_inv"]:$this->rh217_cod_nome_inv);
       $this->rh217_cod_dn_inv = ($this->rh217_cod_dn_inv == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_dn_inv"]:$this->rh217_cod_dn_inv);
       $this->rh217_cod_cnis_nis = ($this->rh217_cod_cnis_nis == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_nis"]:$this->rh217_cod_cnis_nis);
       $this->rh217_cod_cnis_dn = ($this->rh217_cod_cnis_dn == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_dn"]:$this->rh217_cod_cnis_dn);
       $this->rh217_cod_cnis_obito = ($this->rh217_cod_cnis_obito == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_obito"]:$this->rh217_cod_cnis_obito);
       $this->rh217_cod_cnis_cpf = ($this->rh217_cod_cnis_cpf == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_cpf"]:$this->rh217_cod_cnis_cpf);
       $this->rh217_cod_cnis_cpf_nao_inf = ($this->rh217_cod_cnis_cpf_nao_inf == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_cpf_nao_inf"]:$this->rh217_cod_cnis_cpf_nao_inf);
       $this->rh217_cod_cpf_nao_consta = ($this->rh217_cod_cpf_nao_consta == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_nao_consta"]:$this->rh217_cod_cpf_nao_consta);
       $this->rh217_cod_cpf_nulo = ($this->rh217_cod_cpf_nulo == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_nulo"]:$this->rh217_cod_cpf_nulo);
       $this->rh217_cod_cpf_cancelado = ($this->rh217_cod_cpf_cancelado == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_cancelado"]:$this->rh217_cod_cpf_cancelado);
       $this->rh217_cod_cpf_suspenso = ($this->rh217_cod_cpf_suspenso == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_suspenso"]:$this->rh217_cod_cpf_suspenso);
       $this->rh217_cod_cpf_dn = ($this->rh217_cod_cpf_dn == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_dn"]:$this->rh217_cod_cpf_dn);
       $this->rh217_cod_cpf_nome = ($this->rh217_cod_cpf_nome == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_nome"]:$this->rh217_cod_cpf_nome);
       $this->rh217_cod_orientacao_cpf = ($this->rh217_cod_orientacao_cpf == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_orientacao_cpf"]:$this->rh217_cod_orientacao_cpf);
       $this->rh217_cod_orientacao_nis = ($this->rh217_cod_orientacao_nis == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_cod_orientacao_nis"]:$this->rh217_cod_orientacao_nis);
       $this->rh217_arquivoretorno = ($this->rh217_arquivoretorno == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_arquivoretorno"]:$this->rh217_arquivoretorno);
       $this->rh217_msg = ($this->rh217_msg == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_msg"]:$this->rh217_msg);
     } else {
       $this->rh217_sequencial = ($this->rh217_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh217_sequencial"]:$this->rh217_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($rh217_sequencial) { 
      $this->atualizacampos();
     if ($this->rh217_cpf == null ) { 
       $this->erro_sql = " Campo CPF não informado.";
       $this->erro_campo = "rh217_cpf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_nis == null ) { 
       $this->erro_sql = " Campo NIS não informado.";
       $this->erro_campo = "rh217_nis";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_nome == null ) { 
       $this->erro_sql = " Campo Nome não informado.";
       $this->erro_campo = "rh217_nome";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_dn == null ) { 
       $this->erro_sql = " Campo Data Nascimento não informado.";
       $this->erro_campo = "rh217_dn";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_nis_inv == null ) { 
       $this->erro_sql = " Campo NIS Inválido não informado.";
       $this->erro_campo = "rh217_cod_nis_inv";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cpf_inv == null ) { 
       $this->erro_sql = " Campo CPF Inválido não informado.";
       $this->erro_campo = "rh217_cod_cpf_inv";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_nome_inv == null ) { 
       $this->erro_sql = " Campo Nome Inválido não informado.";
       $this->erro_campo = "rh217_cod_nome_inv";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_dn_inv == null ) { 
       $this->erro_sql = " Campo Data Nascimento Inválido não informado.";
       $this->erro_campo = "rh217_cod_dn_inv";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cnis_nis == null ) { 
       $this->erro_sql = " Campo NIS CNIS Inválido não informado.";
       $this->erro_campo = "rh217_cod_cnis_nis";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cnis_dn == null ) { 
       $this->erro_sql = " Campo Data Nascimento CNIS Inválido não informado.";
       $this->erro_campo = "rh217_cod_cnis_dn";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cnis_obito == null ) { 
       $this->erro_sql = " Campo Óbito CNIS Inválido não informado.";
       $this->erro_campo = "rh217_cod_cnis_obito";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cnis_cpf == null ) { 
       $this->erro_sql = " Campo CPF CNIS Inválido não informado.";
       $this->erro_campo = "rh217_cod_cnis_cpf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cnis_cpf_nao_inf == null ) { 
       $this->erro_sql = " Campo CPF CNIS Não Informado não informado.";
       $this->erro_campo = "rh217_cod_cnis_cpf_nao_inf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cpf_nao_consta == null ) { 
       $this->erro_sql = " Campo CPF Não Consta não informado.";
       $this->erro_campo = "rh217_cod_cpf_nao_consta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cpf_nulo == null ) { 
       $this->erro_sql = " Campo CPF Nulo não informado.";
       $this->erro_campo = "rh217_cod_cpf_nulo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cpf_cancelado == null ) { 
       $this->erro_sql = " Campo CPF Cancelado não informado.";
       $this->erro_campo = "rh217_cod_cpf_cancelado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cpf_suspenso == null ) { 
       $this->erro_sql = " Campo CPF Suspenso não informado.";
       $this->erro_campo = "rh217_cod_cpf_suspenso";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cpf_dn == null ) { 
       $this->erro_sql = " Campo CPF Data Nascimento Diverge não informado.";
       $this->erro_campo = "rh217_cod_cpf_dn";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_cpf_nome == null ) { 
       $this->erro_sql = " Campo CPF Nome Diverge não informado.";
       $this->erro_campo = "rh217_cod_cpf_nome";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_orientacao_cpf == null ) { 
       $this->erro_sql = " Campo Orientação CPF não informado.";
       $this->erro_campo = "rh217_cod_orientacao_cpf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_cod_orientacao_nis == null ) { 
       $this->erro_sql = " Campo Orientação NIS não informado.";
       $this->erro_campo = "rh217_cod_orientacao_nis";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh217_arquivoretorno == null ) { 
       $this->erro_sql = " Campo Cod. Arquivo Controle não informado.";
       $this->erro_campo = "rh217_arquivoretorno";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($rh217_sequencial == "" || $rh217_sequencial == null ) {
       $result = db_query("select nextval('arquivoretornodados_rh217_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: arquivoretornodados_rh217_sequencial_seq do campo: rh217_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh217_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from arquivoretornodados_rh217_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $rh217_sequencial)) {
         $this->erro_sql = " Campo rh217_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->rh217_sequencial = $rh217_sequencial; 
       }
     }
     if (($this->rh217_sequencial == null) || ($this->rh217_sequencial == "") ) { 
       $this->erro_sql = " Campo rh217_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into arquivoretornodados(
                                       rh217_sequencial 
                                      ,rh217_cpf 
                                      ,rh217_nis 
                                      ,rh217_nome 
                                      ,rh217_dn 
                                      ,rh217_cod_nis_inv 
                                      ,rh217_cod_cpf_inv 
                                      ,rh217_cod_nome_inv 
                                      ,rh217_cod_dn_inv 
                                      ,rh217_cod_cnis_nis 
                                      ,rh217_cod_cnis_dn 
                                      ,rh217_cod_cnis_obito 
                                      ,rh217_cod_cnis_cpf 
                                      ,rh217_cod_cnis_cpf_nao_inf 
                                      ,rh217_cod_cpf_nao_consta 
                                      ,rh217_cod_cpf_nulo 
                                      ,rh217_cod_cpf_cancelado 
                                      ,rh217_cod_cpf_suspenso 
                                      ,rh217_cod_cpf_dn 
                                      ,rh217_cod_cpf_nome 
                                      ,rh217_cod_orientacao_cpf 
                                      ,rh217_cod_orientacao_nis 
                                      ,rh217_arquivoretorno 
                                      ,rh217_msg 
                       )
                values (
                                $this->rh217_sequencial 
                               ,'$this->rh217_cpf' 
                               ,'$this->rh217_nis' 
                               ,'$this->rh217_nome' 
                               ,'$this->rh217_dn' 
                               ,$this->rh217_cod_nis_inv 
                               ,$this->rh217_cod_cpf_inv 
                               ,$this->rh217_cod_nome_inv 
                               ,$this->rh217_cod_dn_inv 
                               ,$this->rh217_cod_cnis_nis 
                               ,$this->rh217_cod_cnis_dn 
                               ,$this->rh217_cod_cnis_obito 
                               ,$this->rh217_cod_cnis_cpf 
                               ,$this->rh217_cod_cnis_cpf_nao_inf 
                               ,$this->rh217_cod_cpf_nao_consta 
                               ,$this->rh217_cod_cpf_nulo 
                               ,$this->rh217_cod_cpf_cancelado 
                               ,$this->rh217_cod_cpf_suspenso 
                               ,$this->rh217_cod_cpf_dn 
                               ,$this->rh217_cod_cpf_nome 
                               ,$this->rh217_cod_orientacao_cpf 
                               ,$this->rh217_cod_orientacao_nis 
                               ,$this->rh217_arquivoretorno 
                               ,'$this->rh217_msg' 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Arquivo Retorno eSocial ($this->rh217_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Arquivo Retorno eSocial já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Arquivo Retorno eSocial ($this->rh217_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh217_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh217_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009247,'$this->rh217_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,1009247,'','".AddSlashes(pg_result($resaco,0,'rh217_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009248,'','".AddSlashes(pg_result($resaco,0,'rh217_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009250,'','".AddSlashes(pg_result($resaco,0,'rh217_nis'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,0,'rh217_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,0,'rh217_dn'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_nis_inv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cpf_inv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_nome_inv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_dn_inv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cnis_nis'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cnis_dn'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cnis_obito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009260,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cnis_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009261,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cnis_cpf_nao_inf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009262,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cpf_nao_consta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009263,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cpf_nulo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009264,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cpf_cancelado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009265,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cpf_suspenso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009266,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cpf_dn'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009267,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_cpf_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009268,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_orientacao_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009269,'','".AddSlashes(pg_result($resaco,0,'rh217_cod_orientacao_nis'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009270,'','".AddSlashes(pg_result($resaco,0,'rh217_arquivoretorno'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009271,'','".AddSlashes(pg_result($resaco,0,'rh217_msg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($rh217_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update arquivoretornodados set ";
     $virgula = "";
     if (trim($this->rh217_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_sequencial"])) { 
       $sql  .= $virgula." rh217_sequencial = $this->rh217_sequencial ";
       $virgula = ",";
       if (trim($this->rh217_sequencial) == null ) { 
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "rh217_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cpf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cpf"])) { 
       $sql  .= $virgula." rh217_cpf = '$this->rh217_cpf' ";
       $virgula = ",";
       if (trim($this->rh217_cpf) == null ) { 
         $this->erro_sql = " Campo CPF não informado.";
         $this->erro_campo = "rh217_cpf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_nis)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_nis"])) { 
       $sql  .= $virgula." rh217_nis = '$this->rh217_nis' ";
       $virgula = ",";
       if (trim($this->rh217_nis) == null ) { 
         $this->erro_sql = " Campo NIS não informado.";
         $this->erro_campo = "rh217_nis";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_nome)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_nome"])) { 
       $sql  .= $virgula." rh217_nome = '$this->rh217_nome' ";
       $virgula = ",";
       if (trim($this->rh217_nome) == null ) { 
         $this->erro_sql = " Campo Nome não informado.";
         $this->erro_campo = "rh217_nome";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_dn)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_dn"])) { 
       $sql  .= $virgula." rh217_dn = '$this->rh217_dn' ";
       $virgula = ",";
       if (trim($this->rh217_dn) == null ) { 
         $this->erro_sql = " Campo Data Nascimento não informado.";
         $this->erro_campo = "rh217_dn";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_nis_inv)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_nis_inv"])) { 
       $sql  .= $virgula." rh217_cod_nis_inv = $this->rh217_cod_nis_inv ";
       $virgula = ",";
       if (trim($this->rh217_cod_nis_inv) == null ) { 
         $this->erro_sql = " Campo NIS Inválido não informado.";
         $this->erro_campo = "rh217_cod_nis_inv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cpf_inv)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_inv"])) { 
       $sql  .= $virgula." rh217_cod_cpf_inv = $this->rh217_cod_cpf_inv ";
       $virgula = ",";
       if (trim($this->rh217_cod_cpf_inv) == null ) { 
         $this->erro_sql = " Campo CPF Inválido não informado.";
         $this->erro_campo = "rh217_cod_cpf_inv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_nome_inv)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_nome_inv"])) { 
       $sql  .= $virgula." rh217_cod_nome_inv = $this->rh217_cod_nome_inv ";
       $virgula = ",";
       if (trim($this->rh217_cod_nome_inv) == null ) { 
         $this->erro_sql = " Campo Nome Inválido não informado.";
         $this->erro_campo = "rh217_cod_nome_inv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_dn_inv)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_dn_inv"])) { 
       $sql  .= $virgula." rh217_cod_dn_inv = $this->rh217_cod_dn_inv ";
       $virgula = ",";
       if (trim($this->rh217_cod_dn_inv) == null ) { 
         $this->erro_sql = " Campo Data Nascimento Inválido não informado.";
         $this->erro_campo = "rh217_cod_dn_inv";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cnis_nis)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_nis"])) { 
       $sql  .= $virgula." rh217_cod_cnis_nis = $this->rh217_cod_cnis_nis ";
       $virgula = ",";
       if (trim($this->rh217_cod_cnis_nis) == null ) { 
         $this->erro_sql = " Campo NIS CNIS Inválido não informado.";
         $this->erro_campo = "rh217_cod_cnis_nis";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cnis_dn)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_dn"])) { 
       $sql  .= $virgula." rh217_cod_cnis_dn = $this->rh217_cod_cnis_dn ";
       $virgula = ",";
       if (trim($this->rh217_cod_cnis_dn) == null ) { 
         $this->erro_sql = " Campo Data Nascimento CNIS Inválido não informado.";
         $this->erro_campo = "rh217_cod_cnis_dn";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cnis_obito)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_obito"])) { 
       $sql  .= $virgula." rh217_cod_cnis_obito = $this->rh217_cod_cnis_obito ";
       $virgula = ",";
       if (trim($this->rh217_cod_cnis_obito) == null ) { 
         $this->erro_sql = " Campo Óbito CNIS Inválido não informado.";
         $this->erro_campo = "rh217_cod_cnis_obito";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cnis_cpf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_cpf"])) { 
       $sql  .= $virgula." rh217_cod_cnis_cpf = $this->rh217_cod_cnis_cpf ";
       $virgula = ",";
       if (trim($this->rh217_cod_cnis_cpf) == null ) { 
         $this->erro_sql = " Campo CPF CNIS Inválido não informado.";
         $this->erro_campo = "rh217_cod_cnis_cpf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cnis_cpf_nao_inf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_cpf_nao_inf"])) { 
       $sql  .= $virgula." rh217_cod_cnis_cpf_nao_inf = $this->rh217_cod_cnis_cpf_nao_inf ";
       $virgula = ",";
       if (trim($this->rh217_cod_cnis_cpf_nao_inf) == null ) { 
         $this->erro_sql = " Campo CPF CNIS Não Informado não informado.";
         $this->erro_campo = "rh217_cod_cnis_cpf_nao_inf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cpf_nao_consta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_nao_consta"])) { 
       $sql  .= $virgula." rh217_cod_cpf_nao_consta = $this->rh217_cod_cpf_nao_consta ";
       $virgula = ",";
       if (trim($this->rh217_cod_cpf_nao_consta) == null ) { 
         $this->erro_sql = " Campo CPF Não Consta não informado.";
         $this->erro_campo = "rh217_cod_cpf_nao_consta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cpf_nulo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_nulo"])) { 
       $sql  .= $virgula." rh217_cod_cpf_nulo = $this->rh217_cod_cpf_nulo ";
       $virgula = ",";
       if (trim($this->rh217_cod_cpf_nulo) == null ) { 
         $this->erro_sql = " Campo CPF Nulo não informado.";
         $this->erro_campo = "rh217_cod_cpf_nulo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cpf_cancelado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_cancelado"])) { 
       $sql  .= $virgula." rh217_cod_cpf_cancelado = $this->rh217_cod_cpf_cancelado ";
       $virgula = ",";
       if (trim($this->rh217_cod_cpf_cancelado) == null ) { 
         $this->erro_sql = " Campo CPF Cancelado não informado.";
         $this->erro_campo = "rh217_cod_cpf_cancelado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cpf_suspenso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_suspenso"])) { 
       $sql  .= $virgula." rh217_cod_cpf_suspenso = $this->rh217_cod_cpf_suspenso ";
       $virgula = ",";
       if (trim($this->rh217_cod_cpf_suspenso) == null ) { 
         $this->erro_sql = " Campo CPF Suspenso não informado.";
         $this->erro_campo = "rh217_cod_cpf_suspenso";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cpf_dn)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_dn"])) { 
       $sql  .= $virgula." rh217_cod_cpf_dn = $this->rh217_cod_cpf_dn ";
       $virgula = ",";
       if (trim($this->rh217_cod_cpf_dn) == null ) { 
         $this->erro_sql = " Campo CPF Data Nascimento Diverge não informado.";
         $this->erro_campo = "rh217_cod_cpf_dn";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_cpf_nome)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_nome"])) { 
       $sql  .= $virgula." rh217_cod_cpf_nome = $this->rh217_cod_cpf_nome ";
       $virgula = ",";
       if (trim($this->rh217_cod_cpf_nome) == null ) { 
         $this->erro_sql = " Campo CPF Nome Diverge não informado.";
         $this->erro_campo = "rh217_cod_cpf_nome";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_orientacao_cpf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_orientacao_cpf"])) { 
       $sql  .= $virgula." rh217_cod_orientacao_cpf = $this->rh217_cod_orientacao_cpf ";
       $virgula = ",";
       if (trim($this->rh217_cod_orientacao_cpf) == null ) { 
         $this->erro_sql = " Campo Orientação CPF não informado.";
         $this->erro_campo = "rh217_cod_orientacao_cpf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_cod_orientacao_nis)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_orientacao_nis"])) { 
       $sql  .= $virgula." rh217_cod_orientacao_nis = $this->rh217_cod_orientacao_nis ";
       $virgula = ",";
       if (trim($this->rh217_cod_orientacao_nis) == null ) { 
         $this->erro_sql = " Campo Orientação NIS não informado.";
         $this->erro_campo = "rh217_cod_orientacao_nis";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_arquivoretorno)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_arquivoretorno"])) { 
       $sql  .= $virgula." rh217_arquivoretorno = $this->rh217_arquivoretorno ";
       $virgula = ",";
       if (trim($this->rh217_arquivoretorno) == null ) { 
         $this->erro_sql = " Campo Cod. Arquivo Controle não informado.";
         $this->erro_campo = "rh217_arquivoretorno";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh217_msg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh217_msg"])) { 
       $sql  .= $virgula." rh217_msg = '$this->rh217_msg' ";
       $virgula = ",";
       if (trim($this->rh217_msg) == null ) { 
         $this->erro_sql = " Campo Mensagens de Retorno não informado.";
         $this->erro_campo = "rh217_msg";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($rh217_sequencial!=null) {
       $sql .= " rh217_sequencial = $this->rh217_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh217_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009247,'$this->rh217_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_sequencial"]) || $this->rh217_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009247,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_sequencial'))."','$this->rh217_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cpf"]) || $this->rh217_cpf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009248,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cpf'))."','$this->rh217_cpf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_nis"]) || $this->rh217_nis != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009250,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_nis'))."','$this->rh217_nis',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_nome"]) || $this->rh217_nome != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_nome'))."','$this->rh217_nome',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_dn"]) || $this->rh217_dn != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_dn'))."','$this->rh217_dn',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_nis_inv"]) || $this->rh217_cod_nis_inv != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_nis_inv'))."','$this->rh217_cod_nis_inv',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_inv"]) || $this->rh217_cod_cpf_inv != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cpf_inv'))."','$this->rh217_cod_cpf_inv',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_nome_inv"]) || $this->rh217_cod_nome_inv != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_nome_inv'))."','$this->rh217_cod_nome_inv',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_dn_inv"]) || $this->rh217_cod_dn_inv != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_dn_inv'))."','$this->rh217_cod_dn_inv',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_nis"]) || $this->rh217_cod_cnis_nis != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cnis_nis'))."','$this->rh217_cod_cnis_nis',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_dn"]) || $this->rh217_cod_cnis_dn != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cnis_dn'))."','$this->rh217_cod_cnis_dn',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_obito"]) || $this->rh217_cod_cnis_obito != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009259,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cnis_obito'))."','$this->rh217_cod_cnis_obito',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_cpf"]) || $this->rh217_cod_cnis_cpf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009260,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cnis_cpf'))."','$this->rh217_cod_cnis_cpf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cnis_cpf_nao_inf"]) || $this->rh217_cod_cnis_cpf_nao_inf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009261,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cnis_cpf_nao_inf'))."','$this->rh217_cod_cnis_cpf_nao_inf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_nao_consta"]) || $this->rh217_cod_cpf_nao_consta != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009262,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cpf_nao_consta'))."','$this->rh217_cod_cpf_nao_consta',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_nulo"]) || $this->rh217_cod_cpf_nulo != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009263,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cpf_nulo'))."','$this->rh217_cod_cpf_nulo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_cancelado"]) || $this->rh217_cod_cpf_cancelado != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009264,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cpf_cancelado'))."','$this->rh217_cod_cpf_cancelado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_suspenso"]) || $this->rh217_cod_cpf_suspenso != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009265,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cpf_suspenso'))."','$this->rh217_cod_cpf_suspenso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_dn"]) || $this->rh217_cod_cpf_dn != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009266,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cpf_dn'))."','$this->rh217_cod_cpf_dn',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_cpf_nome"]) || $this->rh217_cod_cpf_nome != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009267,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_cpf_nome'))."','$this->rh217_cod_cpf_nome',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_orientacao_cpf"]) || $this->rh217_cod_orientacao_cpf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009268,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_orientacao_cpf'))."','$this->rh217_cod_orientacao_cpf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_cod_orientacao_nis"]) || $this->rh217_cod_orientacao_nis != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009269,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_cod_orientacao_nis'))."','$this->rh217_cod_orientacao_nis',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_arquivoretorno"]) || $this->rh217_arquivoretorno != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009270,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_arquivoretorno'))."','$this->rh217_arquivoretorno',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh217_msg"]) || $this->rh217_msg != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009271,'".AddSlashes(pg_result($resaco,$conresaco,'rh217_msg'))."','$this->rh217_msg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Arquivo Retorno eSocial nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh217_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Arquivo Retorno eSocial nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh217_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh217_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($rh217_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($rh217_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009247,'$rh217_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009247,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009248,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009250,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_nis'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_dn'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_nis_inv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cpf_inv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_nome_inv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_dn_inv'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cnis_nis'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cnis_dn'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cnis_obito'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009260,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cnis_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009261,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cnis_cpf_nao_inf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009262,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cpf_nao_consta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009263,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cpf_nulo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009264,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cpf_cancelado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009265,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cpf_suspenso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009266,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cpf_dn'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009267,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_cpf_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009268,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_orientacao_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009269,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_cod_orientacao_nis'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009270,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_arquivoretorno'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009271,'','".AddSlashes(pg_result($resaco,$iresaco,'rh217_msg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from arquivoretornodados
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($rh217_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " rh217_sequencial = $rh217_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Arquivo Retorno eSocial nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh217_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Arquivo Retorno eSocial nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh217_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh217_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:arquivoretornodados";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $rh217_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from arquivoretornodados ";
     $sql .= "      inner join arquivoretorno  on  arquivoretorno.rh216_sequencial = arquivoretornodados.rh217_arquivoretorno";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh217_sequencial!=null ) {
         $sql2 .= " where arquivoretornodados.rh217_sequencial = $rh217_sequencial "; 
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

  // funcao do sql 
  function sql_query_file ( $rh217_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from arquivoretornodados ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh217_sequencial!=null ) {
         $sql2 .= " where arquivoretornodados.rh217_sequencial = $rh217_sequencial "; 
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

  public function addInsertLine($aDados, $bInsert = false) {

    $iPosition = 0;
    if (count($aDados) > 0) {
      $this->aSqlAddInserts[] = "(
                                nextval('arquivoretornodados_rh217_sequencial_seq') 
                               ,'{$aDados[$iPosition++]}' 
                               ,'{$aDados[$iPosition++]}' 
                               ,'{$aDados[$iPosition++]}' 
                               ,'{$aDados[$iPosition++]}' 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition++]} 
                               ,{$aDados[$iPosition]}
                      )";
    }

    if(count($this->aSqlAddInserts) == $this->iNumberRowsInsert || $bInsert === true) {

      $sql = "insert into arquivoretornodados(
                                       rh217_sequencial 
                                      ,rh217_cpf 
                                      ,rh217_nis 
                                      ,rh217_nome 
                                      ,rh217_dn 
                                      ,rh217_cod_nis_inv 
                                      ,rh217_cod_cpf_inv 
                                      ,rh217_cod_nome_inv 
                                      ,rh217_cod_dn_inv 
                                      ,rh217_cod_cnis_nis 
                                      ,rh217_cod_cnis_dn 
                                      ,rh217_cod_cnis_obito 
                                      ,rh217_cod_cnis_cpf 
                                      ,rh217_cod_cnis_cpf_nao_inf 
                                      ,rh217_cod_cpf_nao_consta 
                                      ,rh217_cod_cpf_nulo 
                                      ,rh217_cod_cpf_cancelado 
                                      ,rh217_cod_cpf_suspenso 
                                      ,rh217_cod_cpf_dn 
                                      ,rh217_cod_cpf_nome 
                                      ,rh217_cod_orientacao_cpf 
                                      ,rh217_cod_orientacao_nis 
                                      ,rh217_arquivoretorno 
                                      ,rh217_msg 
                       )
                values "; 
        $sql .= implode(",", $this->aSqlAddInserts);
        $result = db_query($sql); 
        if ($result==false) {

          $this->erro_banco = str_replace("\n","",@pg_last_error());
          if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
            $this->erro_sql   = "Arquivo Retorno eSocial ($this->rh217_sequencial) nao Incluído. Inclusao Abortada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_banco = "Arquivo Retorno eSocial já Cadastrado";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          } else {
            $this->erro_sql   = "Arquivo Retorno eSocial ($this->rh217_sequencial) nao Incluído. Inclusao Abortada.";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          }
          $this->erro_status = "0";
          $this->numrows_incluir= 0;
          return false;
        }
        $this->erro_banco = "";
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $this->aSqlAddInserts = array();
    }
  }

}
?>
