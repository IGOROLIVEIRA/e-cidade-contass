<?php
class cl_liclicitaimportarjulgamento
{
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

    //pcorcam
    public string $pc20_dtate;
    public string $pc20_hrate;
    public string $pc20_obs;
    public string $pc20_prazoentrega;//data inicio proposta
    public int    $pc20_cotacaoprevia = 1;//1
    public int    $pc20_codorc;

    //pcorcamforne
    public int    $pc21_codorc;
    public int    $pc21_numcgm;
    public bool   $pc21_importado = true;
    public int    $pc21_orcamforne;

    //habilitacaoforne
    public int    $l206_fornecedor;
    public int    $l206_licitacao;
    public int    $l206_representante;
    public string $l206_datahab;

    //pcorcamitemlic
    public int    $pc22_liclicitem;
    public int    $pc22_orcamitem;

    //pcorcamitemlic
    public int    $pc26_liclicitem;
    public int    $pc26_orcamitem;


    //pcorcamval
    public int    $pc23_orcamforne;
    public int    $pc23_orcamitem;
    public float  $pc23_valor;
    public int    $pc23_quant;
    public string $pc23_obs;
    public float  $pc23_vlrun;
    public float  $pc23_validmin;
    public float  $pc23_percentualdesconto;
    public float  $pc23_perctaxadesctabela;

    //pcorcamjulg
    public int    $pc24_orcamitem;
    public int    $pc24_orcamforne;
    public int    $pc24_posicao;

    //liclicitasituacao
    public int    $l11_sequencial;
    public int    $l11_idusuario;
    public int    $l11_licsituacao;
    public int    $l11_liclicita;
    public string $l11_obs;
    public string $l11_data;
    public string $l11_hora;


    public function buscarModalidadeComObjeto($codigo)
    {
        $sql = "select distinct
        l20_codigo as id,
        l20_objeto as objeto,
        l20_numero as numeroprocesso,
        l20_anousu as anoprocesso,
        l20_licsituacao as situacao,
        l03_descr as modalidade
        from liclicita
        join cflicita on l03_codigo=l20_codtipocom
        where
        l20_codigo=".$codigo;
        return $this->sql_record($sql);
    }

    public function buscaFornecedor($cpnj)
    {
        $sql = "
        select pc60_cnpjcpf from pcforne where pc60_cnpjcpf ='$cpnj'
        ";
        return $this->sql_record($sql);
    }


    public function sql_record($sql)
    {
        $result = db_query($sql);
        if($result==false || $result == null) {
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
           $this->erro_sql   = "Record Vazio na Tabela:liclicitaproc";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
        return $result;
      }

      public function inserir(array $dados)
      {

      }

      private function inserePcorcam()
      {
        $this->pc20_obs =  'ORCAMENTO IMPORTADO - ID idLicitacao - NR_PROCESSO';

        $insert = "INSERT INTO
        pcorcam(pc20_dtate, pc20_hrate, pc20_obs, pc20_prazoentrega, pc20_validadeorcamento, pc20_cotacaoprevia )
        VALUES ($this->pc20_dtate, $this->pc20_hrate, $this->pc20_prazoentrega, NULL, 1 )
        RETURNING pc20_codorc;";

        return pg_exec($insert);
      }

      private function inserePcorcamforne()
      {
        $insert = "INSERT INTO
        pcorcamforne(pc21_codorc, pc21_numcgm, pc21_importado, pc21_prazoent, pc21_validadorc)
        VALUES($this->pc21_codorc, $this->pc21_numcgm, true, NULL, NULL)
        RETURNING pc21_orcamforne
        ";
        return pg_exec($insert);
      }

      private function insereHabilitacaoforn()
      {
       $insert = "INSERT INTO
       habilitacaoforn(l206_fornecedor, l206_licitacao, l206_representante, l206_datahab,
       l206_numcertidaoinss, l206_dataemissaoinss, l206_datavalidadeinss, l206_numcertidaofgts, l206_dataemissaofgts
       l206_datavalidadefgts, l206_numcertidaocndt, l206_dataemissaocndt, l206_datavalidadecndt)
       VALUES(
        $this->l206_fornecedor, $this->l206_licitacao, $this->l206_represente, $this->l206_dathab,
        NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL
        )
        RETURNING l206_sequencia
       ";
       return pg_exec($insert);
      }

      private function inserePcorcamitem()
      {
        $insert = "INSERT INTO
        pcorcamitem(pc22_codorc)
        VALUES($this->pc22_codorc)
        RETURNING pc26_orcamitem
        ";
        return pg_exec($insert);
      }

      private function inserePcorcamval()
      {
        $insert = "INSERT INTO
        pcorcamval(pc23_orcamforne, pc23_orcamitem, pc23_valor, pc23_quant,
        pc23_obs, pc23_vlrun, pc23_validmin, pc23_percentualdesconto, pc23_perctaxadesctabela
        VALUES($this->pc23_orcamforne, $this->pc23_orcamitem, $this->pc23_valor, $this->pc23_quant
        $this->pc23_obs, $this->pc23_vlrun, null, $this->pc23_percentualdesconto, $this->pc23_perctaxadesctabela
        )
        ";
        return pg_exec($insert);
      }

      private function inserePcorcamjulg()
      {
        $insert = "INSERT INTO
        pcorcamjulg(pc24_orcamitem, pc24_orcamitem,pc24_pontuacao)
        VALUES($this->pc24_orcamitem, $this->pc24_orcamitem, $this->pc24_pontuacao)
        ";
        return pg_exec($insert);
      }

}