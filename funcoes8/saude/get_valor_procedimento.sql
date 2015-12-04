-- Fun��o que retorna o valor do procedimento de acordo com o ano e m�s da compet�ncia passada.
-- Se no lugar do ano for passado null, obt�m o valor para a compet�ncia do ano mais recente para o m�s indicado.
-- Se no lugar do m�s for passado null, obt�m o valor para a compet�ncia do m�s mais recente para o ano indicado.
-- Se m�s e ano forem null, obt�m o valor para a compet�ncia mais recente.
CREATE OR REPLACE FUNCTION fc_get_valor_procedimento(sProcedimento CHAR(10), iAno INT4, iMes INT4)
RETURNS FLOAT4 AS $$

DECLARE
  nValor FLOAT4;
BEGIN

  IF iAno IS NULL AND iMes IS NULL THEN

    nValor = (SELECT (sau_procedimento.sd63_f_sh + sau_procedimento.sd63_f_sa + sau_procedimento.sd63_f_sp)
                FROM sau_procedimento
                  WHERE sau_procedimento.sd63_c_procedimento = sProcedimento
                    ORDER BY sau_procedimento.sd63_i_anocomp desc, sau_procedimento.sd63_i_mescomp desc 
                      LIMIT 1);
                
  ELSEIF iAno IS NULL THEN

    nValor = (SELECT (sau_procedimento.sd63_f_sh + sau_procedimento.sd63_f_sa + sau_procedimento.sd63_f_sp)
                FROM sau_procedimento
                  WHERE sau_procedimento.sd63_c_procedimento = sProcedimento
                    AND sau_procedimento.sd63_i_mescomp = iMes
                      ORDER BY sau_procedimento.sd63_i_anocomp desc, sau_procedimento.sd63_i_mescomp desc 
                        LIMIT 1);

  ELSEIF iMes IS NULL THEN

    nValor = (SELECT (sau_procedimento.sd63_f_sh + sau_procedimento.sd63_f_sa + sau_procedimento.sd63_f_sp)
                FROM sau_procedimento
                  WHERE sau_procedimento.sd63_c_procedimento = sProcedimento
                    AND sau_procedimento.sd63_i_anocomp = iAno
                      ORDER BY sau_procedimento.sd63_i_anocomp desc, sau_procedimento.sd63_i_mescomp desc 
                        LIMIT 1);

  ELSE

    nValor = (SELECT (sau_procedimento.sd63_f_sh + sau_procedimento.sd63_f_sa + sau_procedimento.sd63_f_sp)
                FROM sau_procedimento
                  WHERE sau_procedimento.sd63_c_procedimento = sProcedimento
                    AND sau_procedimento.sd63_i_anocomp = iAno
                    AND sau_procedimento.sd63_i_mescomp = iMes
                      ORDER BY sau_procedimento.sd63_i_anocomp desc, sau_procedimento.sd63_i_mescomp desc 
                        LIMIT 1);

  END IF;

  RETURN nValor;

END
$$ language 'plpgsql';

