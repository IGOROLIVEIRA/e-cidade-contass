<?php
//MODULO: esocial
//CLASSE DA ENTIDADE avaliacaoS1000
class cl_avaliacaoS1000 {
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
    public $eso05_sequencial = 0;
    public $eso05_codclassificacaotributaria = 0;
    public $eso05_indicativocooperativa = 'f';
    public $eso05_indicativodeconstrutora = 'f';
    public $eso05_indicativodesoneracao = 'f';
    public $eso05_microempresa = 'f';
    public $eso05_registroeletronicodeempregados = 'f';
    public $eso05_cnpjdoentefederativoresp = null;
    public $eso05_indicativoprodutorrural = null;
    public $eso05_ideminlei = null;
    public $eso05_nrocertificado = null;
    public $eso05_dtemitcertificado = null;
    public $eso05_dtvalcertificado = null;
    public $eso05_protocolorenov = null;
    public $eso05_dtprotocolo = null;
    public $eso05_dtpublicacao = null;
    public $eso05_nropaginadou = null;
    public $eso05_veicpublicacao = null;
    public $eso05_indicativoacordo = null;

    public $eso05_instit = null;
    // cria propriedade com as variaveis do arquivo
    public $campos = "
                 eso05_sequencial = int8 = Sequencial
                 eso05_codclassificacaotributaria = int4 = Código da classificação Tributaria
                 eso05_indicativocooperativa = bool = Indicativo de cooperativa
                 eso05_indicativodeconstrutora = bool = Indicativo de Construtora
                 eso05_indicativodesoneracao = bool = Indicativo de desoneração da folha
                 eso05_microempresa = bool = Indicativo de microempresa - ME
                 eso05_registroeletronicodeempregados = bool = registro eletrônico de empregados
                 eso05_cnpjdoentefederativoresp = varchar(14) = CNPJ do Ente Federativo Responsável                 
                 eso05_indicativoprodutorrural = boll = eso05_indicativoprodutorrural
                 eso05_ideminlei = text = eso05_ideminlei
                 eso05_nrocertificado = int8 = eso05_nrocertificado
                 eso05_dtemitcertificado = date = eso05_dtemitcertificado
                 eso05_dtvalcertificado = date = eso05_dtvalcertificado
                 eso05_protocolorenov = int8 = eso05_protocolorenov
                 eso05_dtprotocolo = date = eso05_dtprotocolo
                 eso05_dtpublicacao = date = eso05_dtpublicacao
                 eso05_veicpublicacao = text = eso05_veicpublicacao
                 eso05_nropaginadou = text = eso05_nropaginadou
                 eso05_indicativoacordo = boll = eso05_indicativoacordo
                 eso05_instit = int4 = instituicao
                 ";

    //funcao construtor da classe
    function __construct() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("avaliacaoS1000");
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
            $this->eso05_sequencial = ($this->eso05_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_sequencial"]:$this->eso05_sequencial);
            $this->eso05_codclassificacaotributaria = ($this->eso05_codclassificacaotributaria == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_codclassificacaotributaria"]:$this->eso05_codclassificacaotributaria);
            $this->eso05_indicativocooperativa = ($this->eso05_indicativocooperativa == "f"?@$GLOBALS["HTTP_POST_VARS"]["eso05_indicativocooperativa"]:$this->eso05_indicativocooperativa);
            $this->eso05_indicativodeconstrutora = ($this->eso05_indicativodeconstrutora == "f"?@$GLOBALS["HTTP_POST_VARS"]["eso05_indicativodeconstrutora"]:$this->eso05_indicativodeconstrutora);
            $this->eso05_indicativodesoneracao = ($this->eso05_indicativodesoneracao == "f"?@$GLOBALS["HTTP_POST_VARS"]["eso05_indicativodesoneracao"]:$this->eso05_indicativodesoneracao);
            $this->eso05_microempresa = ($this->eso05_microempresa == "f"?@$GLOBALS["HTTP_POST_VARS"]["eso05_microempresa"]:$this->eso05_microempresa);
            $this->eso05_registroeletronicodeempregados = ($this->eso05_registroeletronicodeempregados == "f"?@$GLOBALS["HTTP_POST_VARS"]["eso05_registroeletronicodeempregados"]:$this->eso05_registroeletronicodeempregados);
            $this->eso05_cnpjdoentefederativoresp = ($this->eso05_cnpjdoentefederativoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_cnpjdoentefederativoresp"]:$this->eso05_cnpjdoentefederativoresp);
            $this->eso05_indicativoprodutorrural = ($this->eso05_indicativoprodutorrural == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_indicativoprodutorrural"]:$this->eso05_indicativoprodutorrural);
            $this->eso05_ideminlei = ($this->eso05_ideminlei == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_ideminlei"]:$this->eso05_ideminlei);
            $this->eso05_nrocertificado = ($this->eso05_nrocertificado == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_nrocertificado"]:$this->eso05_nrocertificado);
            $this->eso05_dtemitcertificado = ($this->eso05_dtemitcertificado == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_dtemitcertificado"]:$this->eso05_dtemitcertificado);
            $this->eso05_dtvalcertificado = ($this->eso05_dtvalcertificado == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_dtvalcertificado"]:$this->eso05_dtvalcertificado);
            $this->eso05_protocolorenov = ($this->eso05_protocolorenov == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_protocolorenov"]:$this->eso05_protocolorenov);
            $this->eso05_dtprotocolo = ($this->eso05_dtprotocolo == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_dtprotocolo"]:$this->eso05_dtprotocolo);
            $this->eso05_dtpublicacao = ($this->eso05_dtpublicacao == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_dtpublicacao"]:$this->eso05_dtpublicacao);
            $this->eso05_veicpublicacao = ($this->eso05_veicpublicacao == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_veicpublicacao"]:$this->eso05_veicpublicacao);
            $this->eso05_nropaginadou = ($this->eso05_nropaginadou == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_nropaginadou"]:$this->eso05_nropaginadou);
            $this->eso05_indicativoacordo = ($this->eso05_indicativoacordo == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_indicativoacordo"]:$this->eso05_indicativoacordo);
            $this->eso05_instit = ($this->eso05_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["eso05_instit"]:$this->eso05_instit);
        }
    }

    // funcao para inclusao
    function incluir () {
        $this->atualizacampos();
        if ($this->eso05_sequencial == null ) {
            $result = db_query("select nextval('avaliacaoS1000_eso05_sequencial_seq')");
            if($result==false){
                $this->erro_banco = str_replace("\n","",@pg_last_error());
                $this->erro_sql   = "Verifique o cadastro da sequencia: avaliacaoS1000_eso05_sequencial_seq do campo: eso05_sequencial";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
            $this->eso05_sequencial = pg_result($result,0,0);
        }
        if ($this->eso05_codclassificacaotributaria == null ) {
            $this->erro_sql = " Campo Código da classificação Tributaria não informado.";
            $this->erro_campo = "eso05_codclassificacaotributaria";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso05_indicativocooperativa == null ) {
            $this->erro_sql = " Campo Indicativo de cooperativa não informado.";
            $this->erro_campo = "eso05_indicativocooperativa";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso05_indicativodeconstrutora == null ) {
            $this->erro_sql = " Campo Indicativo de Construtora não informado.";
            $this->erro_campo = "eso05_indicativodeconstrutora";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if ($this->eso05_indicativodesoneracao == null ) {
            $this->erro_sql = " Campo Indicativo de desoneração da folha não informado.";
            $this->erro_campo = "eso05_indicativodesoneracao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        if ($this->eso05_cnpjdoentefederativoresp == "") {
            $this->eso05_cnpjdoentefederativoresp = "";
        }

        if ($this->eso05_indicativoprodutorrural == "") {
            $this->eso05_indicativoprodutorrural = "null";
        }

        if ($this->eso05_nrocertificado == "") {
            $this->eso05_nrocertificado = "null";
        }

        if ($this->eso05_protocolorenov == "") {
            $this->eso05_protocolorenov = "null";
        }

        if ($this->eso05_veicpublicacao == "") {
            $this->eso05_veicpublicacao = null;
        }

        if ($this->eso05_indicativoacordo == "") {
            $this->eso05_indicativoacordo = "0";
        }

//        if ($this->eso05_microempresa == "0" ) {
//            $this->eso05_microempresa = "null";
//        }

        if ($this->eso05_registroeletronicodeempregados == "" ) {
            $this->eso05_registroeletronicodeempregados ="null";
        }

        $sql = "insert into avaliacaoS1000(
                                       eso05_sequencial
                                      ,eso05_codclassificacaotributaria
                                      ,eso05_indicativocooperativa
                                      ,eso05_indicativodeconstrutora
                                      ,eso05_indicativodesoneracao
                                      ,eso05_microempresa
                                      ,eso05_registroeletronicodeempregados
                                      ,eso05_cnpjdoentefederativoresp
                                      ,eso05_indicativoprodutorrural
                                      ,eso05_ideminlei
                                      ,eso05_nrocertificado
                                      ,eso05_dtemitcertificado
                                      ,eso05_dtvalcertificado
                                      ,eso05_protocolorenov
                                      ,eso05_dtprotocolo
                                      ,eso05_dtpublicacao
                                      ,eso05_veicpublicacao
                                      ,eso05_nropaginadou
                                      ,eso05_indicativoacordo
                                      ,eso05_instit
                       )
                values (
                                $this->eso05_sequencial
                               ,$this->eso05_codclassificacaotributaria
                               ,$this->eso05_indicativocooperativa
                               ,'$this->eso05_indicativodeconstrutora'
                               ,'$this->eso05_indicativodesoneracao'
                               ,'$this->eso05_microempresa'
                               ,$this->eso05_registroeletronicodeempregados
                               ,'$this->eso05_cnpjdoentefederativoresp'
                               ,'$this->eso05_indicativoprodutorrural'
                               ,'$this->eso05_ideminlei'
                               ,$this->eso05_nrocertificado
                               ,".($this->eso05_dtemitcertificado == "null" || $this->eso05_dtemitcertificado == ""?"null":"'".$this->eso05_dtemitcertificado."'")."
                               ,".($this->eso05_dtvalcertificado == "null" || $this->eso05_dtvalcertificado == ""?"null":"'".$this->eso05_dtvalcertificado."'")."
                               ,$this->eso05_protocolorenov
                               ,".($this->eso05_dtprotocolo == "null" || $this->eso05_dtprotocolo == ""?"null":"'".$this->eso05_dtprotocolo."'")."
                               ,".($this->eso05_dtpublicacao == "null" || $this->eso05_dtpublicacao == ""?"null":"'".$this->eso05_dtpublicacao."'")."
                               ,'$this->eso05_veicpublicacao'
                               ,'$this->eso05_nropaginadou'
                               ,'$this->eso05_indicativoacordo'
                               ,$this->eso05_instit
                      )";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
                $this->erro_sql   = "avaliacaoS1000 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "avaliacaoS1000 já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            } else {
                $this->erro_sql   = "avaliacaoS1000 () nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
        if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
                && ($lSessaoDesativarAccount === false))) {

        }
        return true;
    }

    // funcao para alteracao
    function alterar ( $eso05_sequencial=null ) {
        $this->atualizacampos();
        $sql = " update avaliacaoS1000 set ";
        $virgula = "";
        if (trim($this->eso05_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_sequencial"])) {
            $sql  .= $virgula." eso05_sequencial = $this->eso05_sequencial ";
            $virgula = ",";
            if (trim($this->eso05_sequencial) == null ) {
                $this->erro_sql = " Campo Sequencial não informado.";
                $this->erro_campo = "eso05_sequencial";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso05_codclassificacaotributaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_codclassificacaotributaria"])) {
            $sql  .= $virgula." eso05_codclassificacaotributaria = $this->eso05_codclassificacaotributaria ";
            $virgula = ",";
            if (trim($this->eso05_codclassificacaotributaria) == null ) {
                $this->erro_sql = " Campo Código da classificação Tributaria não informado.";
                $this->erro_campo = "eso05_codclassificacaotributaria";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso05_indicativocooperativa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_indicativocooperativa"])) {
            $sql  .= $virgula." eso05_indicativocooperativa = '$this->eso05_indicativocooperativa' ";
            $virgula = ",";
            if (trim($this->eso05_indicativocooperativa) == null ) {
                $this->erro_sql = " Campo Indicativo de cooperativa não informado.";
                $this->erro_campo = "eso05_indicativocooperativa";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso05_indicativodeconstrutora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_indicativodeconstrutora"])) {
            $sql  .= $virgula." eso05_indicativodeconstrutora = '$this->eso05_indicativodeconstrutora' ";
            $virgula = ",";
            if (trim($this->eso05_indicativodeconstrutora) == null ) {
                $this->erro_sql = " Campo Indicativo de Construtora não informado.";
                $this->erro_campo = "eso05_indicativodeconstrutora";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso05_indicativodesoneracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_indicativodesoneracao"])) {
            $sql  .= $virgula." eso05_indicativodesoneracao = '$this->eso05_indicativodesoneracao' ";
            $virgula = ",";
            if (trim($this->eso05_indicativodesoneracao) == null ) {
                $this->erro_sql = " Campo Indicativo de desoneração da folha não informado.";
                $this->erro_campo = "eso05_indicativodesoneracao";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso05_microempresa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_microempresa"])) {
            $sql  .= $virgula." eso05_microempresa = '$this->eso05_microempresa' ";
            $virgula = ",";
            if (trim($this->eso05_microempresa) == null ) {
                $this->erro_sql = " Campo Indicativo de microempresa - ME não informado.";
                $this->erro_campo = "eso05_microempresa";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso05_registroeletronicodeempregados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_registroeletronicodeempregados"])) {
            $sql  .= $virgula." eso05_registroeletronicodeempregados = '$this->eso05_registroeletronicodeempregados' ";
            $virgula = ",";
            if (trim($this->eso05_registroeletronicodeempregados) == null ) {
                $this->erro_sql = " Campo registro eletrônico de empregados não informado.";
                $this->erro_campo = "eso05_registroeletronicodeempregados";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if (trim($this->eso05_cnpjdoentefederativoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_cnpjdoentefederativoresp"])) {
            $sql  .= $virgula." eso05_cnpjdoentefederativoresp = '$this->eso05_cnpjdoentefederativoresp' ";
            $virgula = ",";
            if (trim($this->eso05_cnpjdoentefederativoresp) == null ) {
                $this->erro_sql = " Campo CNPJ do Ente Federativo Responsável não informado.";
                $this->erro_campo = "eso05_cnpjdoentefederativoresp";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->eso05_indicativoprodutorrural)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_indicativoprodutorrural"])) {
            $sql  .= $virgula." eso05_indicativoprodutorrural = '$this->eso05_indicativoprodutorrural' ";
            $virgula = ",";
            if (trim($this->eso05_indicativoprodutorrural) == null ) {
                $this->erro_sql = "  Sigla e nome do Ministério ou Lei que concedeu o Certificado não informado.";
                $this->erro_campo = "eso05_indicativoprodutorrural";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        if (trim($this->eso05_ideminlei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["eso05_ideminlei"])) {
            $sql  .= $virgula." eso05_ideminlei = '$this->eso05_ideminlei' ";
            $virgula = ",";
            if (trim($this->eso05_ideminlei) == null ) {
                $this->eso05_ideminlei = "null";
            }
        }
        if ($this->eso05_nrocertificado != "") {
            $sql  .= $virgula." eso05_nrocertificado = '$this->eso05_nrocertificado' ";
            $virgula = ",";
            if (trim($this->eso05_nrocertificado) == null ) {
                $this->eso05_nrocertificado = "null";
            }
        }

        if ($this->eso05_dtemitcertificado != "") {
            $sql  .= $virgula." eso05_dtemitcertificado = '$this->eso05_dtemitcertificado' ";
            $virgula = ",";
            if (trim($this->eso05_dtemitcertificado) == null ) {
                $this->eso05_dtemitcertificado = "null";
            }
        }

        if ($this->eso05_dtvalcertificado != "") {
            $sql  .= $virgula." eso05_dtvalcertificado = '$this->eso05_dtvalcertificado' ";
            $virgula = ",";
            if (trim($this->eso05_dtvalcertificado) == null ) {
                $this->eso05_dtvalcertificado = "null";
            }
        }

        if ($this->eso05_protocolorenov != "") {
            $sql  .= $virgula." eso05_protocolorenov = '$this->eso05_protocolorenov' ";
            $virgula = ",";
            if (trim($this->eso05_protocolorenov) == null ) {
                $this->eso05_protocolorenov = "null";
            }
        }

        if ($this->eso05_dtprotocolo != "") {
            $sql  .= $virgula." eso05_dtprotocolo = '$this->eso05_dtprotocolo' ";
            $virgula = ",";
            if (trim($this->eso05_dtprotocolo) == null ) {
                $this->eso05_dtprotocolo = "null";
            }
        }

        if ($this->eso05_dtpublicacao != "") {
            $sql  .= $virgula." eso05_dtpublicacao = '$this->eso05_dtpublicacao' ";
            $virgula = ",";
            if (trim($this->eso05_dtpublicacao) == null ) {
                $this->eso05_dtpublicacao = "null";
            }
        }

        if ($this->eso05_nropaginadou != "") {
            $sql  .= $virgula." eso05_nropaginadou = '$this->eso05_nropaginadou' ";
            $virgula = ",";
            if (trim($this->eso05_nropaginadou) == null ) {
                $this->eso05_nropaginadou = "null";
            }
        }

        if ($this->eso05_indicativoacordo != "") {
            $sql  .= $virgula." eso05_indicativoacordo = '$this->eso05_indicativoacordo' ";
            $virgula = ",";
            if (trim($this->eso05_indicativoacordo) == null ) {
                $this->eso05_indicativoacordo = "null";
            }
        }

        $sql .= " where ";
        $sql .= "eso05_sequencial = $this->eso05_sequencial";
        $result = db_query($sql);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "avaliacaoS1000 nao Alterado. Alteracao Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "avaliacaoS1000 nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }

    // funcao para exclusao
    function excluir ( $eso05_sequencial=null ,$dbwhere=null) {

        $sql = " delete from avaliacaoS1000
                    where ";
        $sql2 = "";
        if ($dbwhere==null || $dbwhere =="") {
            $sql2 = "eso05_sequencial = $this->eso05_sequencial";
        } else {
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if ($result==false) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "avaliacaoS1000 nao Excluído. Exclusão Abortada.\\n";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        } else {
            if (pg_affected_rows($result)==0) {
                $this->erro_banco = "";
                $this->erro_sql = "avaliacaoS1000 nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            } else {
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
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
            $this->erro_sql   = "Record Vazio na Tabela:avaliacaoS1000";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }

    // funcao do sql
    function sql_query ( $eso05_sequencial = null,$campos="avaliacaoS1000.eso05_sequencial,*",$ordem=null,$dbwhere="") {
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
        $sql .= " from avaliacaoS1000 ";
        $sql2 = "";
        if ($dbwhere=="") {
            if ( $eso05_sequencial != "" && $eso05_sequencial != null) {
                $sql2 = " where avaliacaoS1000.eso05_sequencial = '$eso05_sequencial'";
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
    function sql_query_file ( $eso05_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from avaliacaoS1000 ";
        $sql2 = "";
        if ($dbwhere=="") {
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
}
?>
