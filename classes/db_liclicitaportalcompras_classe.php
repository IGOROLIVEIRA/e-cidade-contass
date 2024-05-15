<?php
class cl_liclicitaportalcompras
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

    public function buscaLicitacoes($codigo)
    {
        $sql = "
        select distinct
        l20_codigo as id,
        l20_objeto as objeto,
        l03_descr as modalidade,
        l03_pctipocompratribunal as codigomodalidade,
        l20_tipnaturezaproced as naturezaprocedimento,
        l20_licsituacao as situacao,
        case when
                l03_presencial=true then 2
                else 1
        end as tiporealizacao,
        case when  l20_tipliticacao = null or l20_tipliticacao=0 then 1
        	else l20_tipliticacao
        end as tipojulgamento,
        l20_edital as numeroprocessointerno,
        l20_numero as numeroprocesso,
        l20_anousu as anoprocesso,
        l20_dataaberproposta as datainiciopropostas,
        l20_dataencproposta as datafinalpropostas,
        l20_dataaberproposta as datalimiteimpugnacao,
        l20_dataaberproposta as dataaberturapropostas,
        l20_dataencproposta as datalimiteesclarecimento,
        l20_orcsigiloso as orcamentosigiloso,
        l20_destexclusiva as exclusivompe,
        case when
                l20_destexclusiva = 1 then false
                else true
        end as aplica147,
        case when
                l20_destexclusiva = 1 then false
                else true
        end as beneficiolocal,
        null as exigegarantia,
        4 as casasdecimais,
        4 as casasdecimaisquantidade,
        case when
                l20_leidalicitacao = 1 then 3
                else 1
        end as legislacaoaplicavel,
        l20_mododisputa as tratamentofaselance,
        case when
                l20_criterioadjudicacao = 3 then 1
                else 2
        end as tipointervalolance,
        2 as valorintervalolance,
        case when
		        l20_tipojulg = 1 then 'f'
		        else 't'
        end as separarporlotes,
        case when
                l20_tipojulg = 1 then '2'
                else 1
        end as operacaolote,
        true as lotes,
        l04_codigo as numerolote, /*Gerar contador para definição do número do lote */
        l04_descricao as descricaolote,
        l20_destexclusiva as exclusivompe,
        l21_reservado as cotareservada,
        null as justificativa,
        null as itens,
        null as numerocatalogoopcional,
        l04_seq as numeroitem,
        l21_ordem as numerointerno,
        case when
                pc01_descrmater=pc01_complmater or pc01_complmater is null then pc01_descrmater
                else pc01_descrmater||'. '||pc01_complmater
        end as descricaoitem,
        1 as natureza,
        m61_abrev as siglaunidade,
        pc11_quant as quantidadetotal,
        case when
                pc11_reservado = 't' then pc11_quant
                else 0
        end as quantidadecota,
        null as arquivos,
        null as tipo,
        null as extensao,
        null as nome,
        null as conteudo,
        null as pregoeiro,
        null as autoridadeCompetenteopcional,
        null as equipeDeApoioopcional,
        null as documentosHabilitacaoopcional,
        null as declaracoesopcional,
        null as origensRecursosopcional,
        null as cdTipoOrigem,
        null as numeroOrigem,
        case when
                si02_criterioadjudicacao=3 then si02_vlprecoreferencia
                else si02_vlpercreferencia
        end as valorreferencia,
        pc54_datainicio as datainicio,
        pc54_datatermino as datatermino
        from liclicita
        join cflicita on l03_codigo=l20_codtipocom
        join liclicitem on l21_codliclicita = l20_codigo
        join liclicitemlote on l04_liclicitem=l21_codigo
        join pcprocitem on pc81_codprocitem=l21_codpcprocitem
        join solicitem on pc11_codigo=pc81_solicitem
        join solicita on pc10_numero = pc11_numero
        join solicitempcmater on pc16_solicitem=pc11_codigo
        join pcmater on pc01_codmater=pc16_codmater
        join solicitemunid on pc17_codigo=pc11_codigo
        join matunid on m61_codmatunid=pc17_unid
        left join pcorcamitemproc on pc31_pcprocitem=pc81_codprocitem
        left join pcorcamitem on pc22_orcamitem=pc31_orcamitem
        left join itemprecoreferencia on si02_itemproccompra=pc22_orcamitem
        left join solicitaregistropreco on pc54_solicita=pc10_numero
        where
        l20_codigo=$codigo";

        return $this->sql_record($sql);
    }

    public function buscaChaveDeAcesso($instituicao)
    {
        $sql = "
        select l12_keyapipcp as chaveacesso
        from licitaparam
        where
        l12_instit = '$instituicao';
        ";
        return $this->sql_record($sql);
    }

    public function buscaCodigoModalidade($codigo)
    {
        $sql = "select l03_pctipocompratribunal as codigomodalidade
        from  liclicita
        join cflicita on l03_codigo=l20_codtipocom
        where l20_codigo=$codigo";

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
           $this->erro_sql   = "Record Vazio na tabela.";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
        return $result;
      }
}
