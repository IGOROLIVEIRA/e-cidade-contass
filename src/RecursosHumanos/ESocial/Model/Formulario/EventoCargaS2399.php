<?php

namespace ECidade\RecursosHumanos\ESocial\Model\Formulario;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\EventoCargaInterface;

/**
 * Classe respons�vel por retornar dados da carga
 * do evento 2399
 * @package ECidade\RecursosHumanos\ESocial\Model\Formulario
 */
class EventoCargaS2399 implements EventoCargaInterface
{

    /**
     * @var Integer
     */
    private $instit;

    /**
     * @var Integer
     */
    private $ano;

    /**
     * @var Integer
     */
    private $mes;

    public function __construct()
    {
        $this->ano = db_getsession("DB_anousu");
        $this->mes = date("m", db_getsession("DB_datausu"));
        $this->instit = db_getsession("DB_instit");
    }

    /**
     * Executa o sql da carga
     * @param integer|null $matricula
     * @return resource
     */
    public function execute($matricula = null)
    {
        $anofolha = db_anofolha();
        $mesfolha = db_mesfolha();
        $sql = "
    	SELECT distinct
        rh02_instit AS instituicao,
        cgm.z01_cgccpf as cpfTrab,
        cgm.z01_nome as nmTrab,
        rhpessoal.rh01_sexo AS sexo,
        CASE WHEN rhpessoal.rh01_raca = 2 THEN 1
            WHEN rhpessoal.rh01_raca = 4 THEN 2
            WHEN rhpessoal.rh01_raca = 6 THEN 4
            WHEN rhpessoal.rh01_raca = 8 THEN 3
            WHEN rhpessoal.rh01_raca = 1 THEN 5
            WHEN rhpessoal.rh01_raca = 9 THEN 6
            END AS racaCor,
            case when rhpessoal.rh01_estciv = 1 then 1
            when rhpessoal.rh01_estciv = 2 then 2
            when rhpessoal.rh01_estciv = 5 then 3
            when rhpessoal.rh01_estciv = 4 then 4
            when rhpessoal.rh01_estciv = 3 then 5
            else 1
            end as estCiv,
            case when rhpessoal.rh01_instru = 1 then '01'
            when rhpessoal.rh01_instru = 2 then '02'
            when rhpessoal.rh01_instru = 3 then '03'
            when rhpessoal.rh01_instru = 4 then '04'
            when rhpessoal.rh01_instru = 5 then '05'
            when rhpessoal.rh01_instru = 6 then '06'
            when rhpessoal.rh01_instru = 7 then '07'
            when rhpessoal.rh01_instru = 8 then '08'
            when rhpessoal.rh01_instru = 9 then '09'
            when rhpessoal.rh01_instru = 10 then '11' 
            when rhpessoal.rh01_instru = 11 then '12'
            when rhpessoal.rh01_instru = 0 then '01'
            end as grauInstr,
            '' as nmSoc,
            rhpessoal.rh01_nasc as dtNascto,
            '105' as paisNascto,
            '105' as paisNac,
            (SELECT j88_sigla from cgm intcgm
            inner join patrimonio.cgmendereco as cgmendereco on (intcgm.z01_numcgm=cgmendereco.z07_numcgm)
            inner join configuracoes.endereco as endereco on (cgmendereco.z07_endereco = endereco.db76_sequencial)
            inner join cadenderlocal on cadenderlocal.db75_sequencial = db76_sequencial
            inner join cadenderbairrocadenderrua on db87_sequencial = db75_cadenderbairrocadenderrua
             inner join cadenderbairro     on  db73_sequencial  = db87_cadenderbairro
             inner join cadenderrua        on  db74_sequencial  = db87_cadenderrua
             inner join cadendermunicipio  on  db72_sequencial  = db73_cadendermunicipio
             inner join cadendermunicipio  as a on a.db72_sequencial = db74_cadendermunicipio
             inner join cadenderestado     on  db71_sequencial  = a.db72_cadenderestado
             inner join cadenderpais       on  db70_sequencial  = db71_cadenderpais
             inner join cadenderruaruastipo on db85_cadenderrua = db74_sequencial
             inner join ruastipo           on  j88_codigo       = db85_ruastipo
            where z01_numcgm = intcgm.z01_numcgm limit 1) as tpLograd,
            cgm.z01_ender as dscLograd, 
            cgm.z01_numero  as nrLograd,
            cgm.z01_compl as complemento,
            cgm.z01_bairro as bairro,
            cgm.z01_cep as cep,
            (coalesce((select
                    db125_codigosistema
                from
                    cadendermunicipio
                inner join cadendermunicipiosistema on
                    cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
                    and cadendermunicipiosistema.db125_db_sistemaexterno = 4
                where to_ascii(db72_descricao) = to_ascii(trim(cgm.z01_munic)) limit 1), (select
                    db125_codigosistema
                from
                    cadendermunicipio
                inner join cadendermunicipiosistema on
                    cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
                    and cadendermunicipiosistema.db125_db_sistemaexterno = 4
                where to_ascii(db72_descricao) = to_ascii(trim((SELECT z01_munic FROM cgm join db_config ON z01_numcgm = numcgm WHERE codigo = fc_getsession('DB_instit')::int))) limit 1))
                ) AS codMunic,
            CASE WHEN cgm.z01_uf is null or trim(cgm.z01_uf) = '' then 'MG'
            else cgm.z01_uf end as uf,
            '' as tmpResid,
            '' as condIng,
            case when rh02_deficientefisico = true then 'S' else 'N' end as defFisica,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 3 then 'S' else 'N' end as defVisual,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 2 then 'S' else 'N' end as defAuditiva,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 7 then 'S' else 'N' end as defMental,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 4 then 'S' else 'N' end as defIntelectual,
            case when rh02_reabreadap = true then 'S' else 'N' end as reabReadap,
            '' as observacao,
            CASE WHEN rhpessoal.rh01_admiss <= '2021-11-22'::date then 'S' else 'N' end as cadIni,
            rhpessoal.rh01_regist as matricula,
            h13_categoria as codCateg,
            rhpessoal.rh01_admiss as dtInicio,
            rh37_descr as nmCargo,
            rh37_cbo as CBOCargo,
            round(rh02_salari,2) as vrSalFx,
            case when rh02_tipsal = 'M' then 5
        when rh02_tipsal = 'Q' then 4
        when rh02_tipsal = 'D' then 2
        when rh02_tipsal = 'H' then 1
            else 5 end as undSalFixo,
            '' as dscSalVar,
            '' as dtOpcFGTS,
            case when rhpessoal.rh01_tipadm in (3,4) then h13_categoria else NULL end as categOrig,
            case when rhpessoal.rh01_tipadm in (3,4) then rh02_cnpjcedente else '' end as cnpjCednt,
            case when rhpessoal.rh01_tipadm in (3,4) then rh02_mattraborgcedente else '' end as matricCed,
            case when rhpessoal.rh01_tipadm in (3,4) then rh02_dataadmisorgcedente else NULL end as dtAdmCed,
            case when rhpessoal.rh01_tipadm in (3,4) and rh30_regime in (1,3) then 2
            when rhpessoal.rh01_tipadm in (3,4) and rh30_regime = 2 then 1
            else NULL end as tpRegTrab,
            case 
            when rhpessoal.rh01_tipadm in (3,4) and r33_tiporegime in ('1','2') then r33_tiporegime
            else NULL end as tpRegPrev,
            case when h13_categoria = 304 then 'N' ELSE NULL end as indRemunCargo,
            case when h13_categoria = 304 and rh30_regime in (1,3) then 2 
            when h13_categoria = 304 and rh30_regime = 2 then 1 
            ELSE NULL end as tpRegTrabInfoMandElet,
            case when h13_categoria = 304 and r33_tiporegime = '1' then 1 
            when h13_categoria = 304 and r33_tiporegime = '2' then 2 
            else NULL end as tpRegPrevInfoMandElet,
            CASE 
            WHEN h83_naturezaestagio in ('O','N') THEN 'O'
            ELSE NULL
            END as natEstagio,
            CASE 
            WHEN h83_nivelestagio = 1 THEN 1
            WHEN h83_nivelestagio = 2 THEN 2
            WHEN h83_nivelestagio = 3 THEN 3
            WHEN h83_nivelestagio = 4 THEN 4
            WHEN h83_nivelestagio = 8 THEN 8
            WHEN h83_nivelestagio = 9 THEN 9
            ELSE NULL
            END as nivEstagio,
            h83_curso as areaAtuacao,
            h83_numapoliceseguro as nrApol,
            h83_dtfim as dtPrevTerm,
            h83_cnpjinstensino as cnpjInstEnsino,
            '' as cnpjAgntInteg,
            cgmsupervisor.z01_cgccpf as cpfSupervisor,
            '' as dtIniAfast,
            '' as codMotAfast,
            '' as dtDeslig,
            rh05_recis,
            cgc as nrinsc,
            rh30_regime,
            eso08_codempregadorlotacao as codLotacao,
            rhinssoutros.rh51_indicadesconto as indMV,
            rhinssoutros.rh51_cgcvinculo as nrInscremunOutrEmpr,
            rhinssoutros.rh51_categoria,
            rhinssoutros.rh51_basefo
            FROM rhpessoal
            join cgm on rhpessoal.rh01_numcgm = cgm.z01_numcgm
            join rhpessoalmov on rhpessoal.rh01_regist = rh02_regist and (rh02_anousu,rh02_mesusu) = ({$this->ano},{$this->mes})
            left join tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            left join rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            left join rhfuncao on rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
            and rhfuncao.rh37_instit = rhpessoalmov.rh02_instit
            left join db_cgmruas on cgm.z01_numcgm = db_cgmruas.z01_numcgm
        left join ruas on ruas.j14_codigo = db_cgmruas.j14_codigo
        left join ruastipo on j88_codigo = j14_tipo
        left join rhestagiocurricular on rhpessoal.rh01_regist = h83_regist
        left join rhpessoal as rhpessoalsupervisor on h83_supervisor = rhpessoalsupervisor.rh01_regist
        left join cgm as cgmsupervisor ON cgmsupervisor.z01_numcgm = rhpessoalsupervisor.rh01_numcgm
        left join inssirf on (r33_codtab::integer-2,r33_anousu,r33_mesusu) = (rh02_tbprev,{$anofolha},{$mesfolha})
        left join rhpesrescisao on rh05_seqpes = rh02_seqpes
        LEFT JOIN eventos1020 ON eventos1020.eso08_instit = {$this->instit}
        LEFT JOIN rhinssoutros ON rhpessoalmov.rh02_seqpes = rhinssoutros.rh51_seqpes
        LEFT JOIN db_config ON rhpessoal.rh01_instit = db_config.codigo
        WHERE rhpessoal.rh01_instit = {$this->instit} 
        AND h13_categoria in (304,701,711,712,721,722,723,731,734,738,771,901,903,410)
        AND rh30_vinculo = 'A'
        AND date_part('month',rh05_recis)::integer = {$this->mes}
        AND date_part('year',rh05_recis)::integer = {$this->ano}
    	";

        if (!empty($matricula)) {
            $sql .= " AND rhpessoal.rh01_regist in ({$matricula}) ";
        }
        
        $rsResult = \db_query($sql);
        // var_dump($sql);
        // db_criatabela($rsResult);exit;
        if (!$rsResult) {
            throw new \Exception("Erro ao buscar preenchimentos do S2399");
        }
        return $rsResult;
    }
}