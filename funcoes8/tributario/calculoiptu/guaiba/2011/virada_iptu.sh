
perc=5.25
anoatual=2010
anonew=2011

cmdpsql=$1
porta=$2
usuario=$3
base=$4
ip=$5

if [ "$#" != "5" ]
  then

  echo
  echo "parametros a serem utilizados: 1=comando 2=porta 3=usuario 4=base 5=ip"
  echo
  echo "exemplo: ./virada_iptu.sh psql 5432 dbportal nomedabase 192.168.0.10"
  echo
  exit

fi

echo "parametros: 1=comando 2=porta 3=usuario 4=base 5=ip"

sleep 3

vencatual=`$cmdpsql -t $base -U $usuario -p $porta -h $ip -c "select fc_startsession(); select j18_vencim from cfiptu where j18_anousu = $anoatual"`

maxvenc=`$cmdpsql -t $base -U $usuario -p $porta -h $ip -c "select fc_startsession(); select nextval('cadvencdesc_q92_codigo_seq')"`
maxvenc=`expr $maxvenc + 1`

echo "vencatual: $vencatual"
echo "maxvenc: $maxvenc"

tipoatual=`$cmdpsql -t $base -U $usuario -p $porta -h $ip -c "select fc_startsession();
                                                              select q92_tipo from cfiptu 
                                                              inner join cadvencdesc on j18_vencim = q92_codigo
                                                              where j18_anousu = $anoatual"`
                                                              
k00_tipo=`$cmdpsql -t $base -U $usuario -p $porta -h $ip -c "select fc_startsession(); 
                                                             select max(k00_tipo) + 1 from arretipo"`

$cmdpsql -t $base -U $usuario -p $porta -h $ip -c "select fc_startsession();
                                                   drop sequence arretipo_k00_tipo_seq;
                                                   create sequence arretipo_k00_tipo_seq start $k00_tipo"

comandos[0]="create temporary table w_arretipo_calculo as select * from arretipo where k00_tipo = $tipoatual;
             update w_arretipo_calculo set k00_tipo = $k00_tipo, k00_descr = 'IPTU $anonew';
             insert into arretipo select * from w_arretipo_calculo;"

comandos[1]="delete from iptutaxa where j19_anousu = $anonew"
comandos[2]="insert into iptutaxa select $anonew, j19_receit, j19_valor  from iptutaxa where j19_anousu = $anoatual"

comandos[3]="delete from carvalor where j71_anousu = $anonew"
comandos[4]="insert into carvalor (j71_codigo, j71_anousu, j71_caract, j71_descr, j71_valor, j71_ini, j71_fim, j71_quantini, j71_quantfim) select nextval('carvalor_j71_codigo_seq'), $anonew, j71_caract, j71_descr, j71_valor, j71_ini, j71_fim, j71_quantini, j71_quantfim from carvalor where j71_anousu = $anoatual"

comandos[5]="delete from caraliq where j73_anousu = $anonew"
comandos[6]="insert into caraliq select $anonew, j73_caract, j73_aliq from caraliq where j73_anousu = $anoatual"

comandos[7]="delete from carfator where j74_anousu = $anonew"
comandos[8]="insert into carfator select $anonew, j74_caract, j74_fator + ( j74_fator * $perc / 100 ), j74_corrig from carfator where j74_anousu = $anoatual and j74_corrig is true"
comandos[9]="insert into carfator select $anonew, j74_caract, j74_fator, j74_corrig from carfator where j74_anousu = $anoatual and j74_corrig is false"

comandos[10]="insert into cadvencdesc select $maxvenc, 'IPTU $anonew', $k00_tipo, q92_hist, q92_diasvcto from cadvencdesc where q92_codigo = $vencatual"
comandos[11]="insert into cadvenc     select $maxvenc, q82_parc, q82_venc + '1 year':: interval, q82_desc, q82_perc, q82_hist from cadvenc where q82_codigo = $vencatual"

comandos[12]="delete from cfiptu where j18_anousu = $anonew"
comandos[13]="insert into cfiptu
              (
              j18_anousu,                           
              j18_vlrref,                           
              j18_dtoper,                           
              j18_rterri,                           
              j18_rpredi,                           
              j18_vencim,                           
              j18_logradauto,                       
              j18_segundavia,                       
              j18_utilizasetfisc,                   
              j18_testadanumero,                    
              j18_excconscalc,                      
              j18_infla,                            
              j18_textoprom,                        
              j18_calcvenc,                         
              j18_utilizaloc,                       
              j18_permvenc,                         
              j18_utidadosdiver,                    
              j18_dadoscertisen,                    
              j18_formatsetor,                      
              j18_formatquadra,                     
              j18_formatlote,                      
              j18_utilpontos,
              j18_ordendent,
              j18_iptuhistisen,
              j18_db_sysfuncoes,
              j18_tipoisen,
              j18_perccorrepadrao
              )
                                select    $anonew,
                                          j18_vlrref,
                                          '$anonew-01-01',
                                          j18_rterri,
                                          j18_rpredi,
                                          $maxvenc,
                                          j18_logradauto,
                                          j18_segundavia,
                                          j18_utilizasetfisc,
                                          j18_testadanumero,
                                          j18_excconscalc,
                                          j18_infla,
                                          j18_textoprom,
                                          j18_calcvenc,
                                          j18_utilizaloc,
                                          j18_permvenc,
                                          j18_utidadosdiver,
                                          j18_dadoscertisen,
                                          j18_formatsetor,
                                          j18_formatquadra,
                                          j18_formatlote,
                                          j18_utilpontos,
                                          j18_ordendent,
                                          j18_iptuhistisen,
                                          j18_db_sysfuncoes,
                                          j18_tipoisen,
                                          j18_perccorrepadrao
                  from cfiptu where j18_anousu = $anoatual"


comandos[14]="delete from infla using cfiptu where infla.i02_codigo = cfiptu.j18_infla and cfiptu.j18_anousu = $anonew and extract (year from infla.i02_data) = $anonew";
comandos[15]="insert into infla select infla.i02_codigo, infla.i02_data + '1 year'::interval, infla.i02_valor + (infla.i02_valor * $perc / 100) from infla inner join cfiptu on infla.i02_codigo = j18_infla 
              left join infla infla2 on infla2.i02_codigo = infla.i02_codigo and infla2.i02_data = infla.i02_data + '1 year'::interval 
              where j18_anousu = $anonew and extract (year from infla.i02_data) = $anoatual and infla2.i02_codigo is null;";

comandos[16]="select setval('iptucadtaxaexe_j08_iptucadtaxaexe_seq', (select max(j08_iptucadtaxaexe) from iptucadtaxaexe));";
comandos[17]="delete from iptucadtaxaexe where j08_anousu = $anonew"
comandos[18]="insert into iptucadtaxaexe (j08_iptucadtaxaexe,j08_iptucadtaxa,j08_tabrec,j08_valor,j08_aliq,j08_anousu,j08_iptucalh,j08_db_sysfuncoes,j08_histisen) select nextval('iptucadtaxaexe_j08_iptucadtaxaexe_seq'), j08_iptucadtaxa, j08_tabrec, j08_valor + (j08_valor * $perc / 100), j08_aliq, $anonew, j08_iptucalh, j08_db_sysfuncoes, j08_histisen from iptucadtaxaexe where j08_anousu = $anoatual"

comandos[19]="delete from zonasvalor where j51_anousu = $anonew"
comandos[20]="insert into zonasvalor(j51_zona, j51_anousu, j51_valorm2t, j51_valorm2c) select j51_zona, $anonew, j51_valorm2t + (j51_valorm2t * $perc / 100), j51_valorm2c + (j51_valorm2c * $perc / 100) from zonasvalor where j51_anousu = $anoatual"

echo "begin;" > /tmp/vira.sql

cont=0

while [ $cont -lt ${#comandos[@]} ]
  do

    $cmdpsql -t $base -U $usuario -p $porta -h $ip -c "select fc_startsession(); ${comandos[$cont]};" >> /tmp/vira.sql

    let "cont = cont + 1"

  done

