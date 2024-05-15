<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("classes/db_agendamentos_classe.php");
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
$clagendamentos = new cl_agendamentos;

 $unidade = str_replace("X",",",$unidades);
 $data1 = str_replace("X","-",$data1);
 $data2 = str_replace("X","-",$data2);
 $sql = "select sd03_i_codigo,
               sd23_c_atendimento,
               cgm.z01_numcgm,
               case when cgm.z01_numcgm is null then
                  cgs_und.z01_v_nome
               else
                  cgm.z01_nome
               end as z01_nome,
               cgm1.z01_nome as nomemed,
               to_char(sd23_d_consulta,'dd/mm/yyyy') as sd23_d_consulta
          from agendamentos
         inner join cgs     on cgs.z01_i_numcgs = agendamentos.sd23_i_numcgs
          left join cgs_cgm on cgs_cgm.z01_i_cgscgm = cgs.z01_i_numcgs
          left join cgm     on cgm.z01_numcgm       = cgs_cgm.z01_i_numcgm
          left join cgs_und on cgs_und.z01_i_cgsund = cgs.z01_i_numcgs
         inner join db_usuarios on db_usuarios.id_usuario = agendamentos.sd23_i_usuario
         inner join especialidades on especialidades.sd05_i_codigo = agendamentos.sd23_i_especialidade
         inner join unidades on unidades.sd02_i_codigo = agendamentos.sd23_i_unidade
         inner join medicos on medicos.sd03_i_id = agendamentos.sd23_i_medico
         inner join cgm as cgm1 on cgm1.z01_numcgm = medicos.sd03_i_codigo
         where sd02_i_codigo in ($unidade) ";

 if( (int)$medico != 0 ){
     $sql .= " and sd23_i_medico = $medico ";
 }
 $sql .= " and sd23_d_data BETWEEN '$data1' and '$data2'
         order by sd23_d_consulta";
//die( $sql );
$result = $clagendamentos->sql_record($sql);
if($clagendamentos->numrows == 0){
 echo "<table width='100%'>
        <tr>
         <td align='center'><font color='#FF0000' face='arial'><b>Nenhum Registro para o Relatório<br><input type='button' value='Fechar' onclick='window.close()'></b></font></td>
        </tr>
       </table>";
 exit;
}
$pdf = new PDF();
$pdf->Open(); 
$pdf->AliasNbPages(); 
$head2 = "Relatório dos Agendamentos";
$head3 = "Periodo:".substr($data1,8,2)."/".substr($data1,5,2)."/".substr($data1,0,4)." A ".substr($data2,8,2)."/".substr($data2,5,2)."/".substr($data2,0,4);
$pri = true;
 for ($i = 0;$i < $clagendamentos->numrows;$i++){
 db_fieldsmemory($result,$i);
  if(($pdf->gety() > $pdf->h -30)||$pri==true){
      $pdf->addpage();
      $pdf->setfillcolor(235);
      $pdf->setfont('arial','b',7);
      $pdf->cell(190,4,"Médico: ".$sd03_i_codigo." - ".$nomemed,1,1,"L",1);
      $pdf->cell(20,4,"Data",1,0,"C",1);
      $pdf->cell(20,4,"Atendimento",1,0,"C",1);
      $pdf->cell(15,4,"CGM",1,0,"C",1);
      $pdf->cell(80,4,"Paciente",1,0,"C",1);
      $pdf->cell(27,4,"Identidade",1,0,"C",1);
      $pdf->cell(28,4,"Assinatura",1,1,"C",1);
      $pri = false;
  }
  $pdf->setfont('arial','',7);
  $pdf->cell(20,4,$sd23_d_consulta,1,0,"L",0);
  $pdf->cell(20,4,$sd23_c_atendimento,1,0,"L",0);
  $pdf->cell(15,4,$z01_numcgm,1,0,"L",0);
  $pdf->cell(80,4,$z01_nome,1,0,"L",0);
  $pdf->cell(27,4,"",1,0,"C",0);
  $pdf->cell(28,4,"",1,1,"C",0);
 }
$pdf->Output();
?>
