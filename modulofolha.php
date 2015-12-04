	    <?
	    if(db_getsession("DB_modulo")==952){

	      global $formAnousufolha,$formMesusufolha;
	      $resultano = pg_exec("select to_char(rh22_dtconv,'YYYY')::integer as rh22_anousu,to_char(rh_dtconv,'MM')::integer as rh22_mesusu, rh22_anoatu,rh22_mesatu from rhcfpess ");
	      if($resultano == false || pg_result($resultano)==0){
                $resultano = pg_exec("select ".date('Y',db_getsession("DB_datausu"))." as rh22_anousu,".date('m',db_getsession("DB_datausu"))." as rh22_mesusu,".date('Y',db_getsession("DB_datausu"))." as rh22_anoatu,".date('m',db_getsession("DB_datausu"))." as rh22_mesatu ");
	      }
              $formAnousuini   = pg_result($resultano,0,"rh22_anousu");
	      $formMesusuini   = pg_result($resultano,0,"rh22_mesusu");
	      $formAnousufolha = pg_result($resultano,0,"rh22_anoatu");
	      $formMesusufolha = pg_result($resultano,0,"rh22_mesatu");
	
	    ?>

            <tr> 
              <td>Exercício Folha:</td>
              <td> 
	        <select name="formAnousofolha" size="1" onChange="document.form1.submit()">
                <option value="">&nbsp;</option>
                <?
		  
                  for($i = 0;$i < pg_numrows($resultano);$i++) {
	             echo "<option value=\"".pg_result($resultano,$i,"rh22_anousu")."\">".pg_result($resultano,$i,"rh_anousu")."</option>\n";
	          }
	        ?>
                </select> 
	        <select name="formMesusofolha" size="1" onChange="document.form1.submit()">
                <option value="">&nbsp;</option>
                <?
		  
                  for($i = 0;$i < pg_numrows($resultano);$i++) {
	             echo "<option value=\"".pg_result($resultano,$i,"rh22_mesusu")."\">".pg_result($resultano,$i,"rh22_mesusu")."</option>\n";
	          }
	        ?>
                </select> 
	      </td>
            </tr>

            <?
	    
	    }
	    ?>


