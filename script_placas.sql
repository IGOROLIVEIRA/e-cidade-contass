BEGIN;

SELECT fc_startsession();

CREATE FUNCTION copia_placas(bem bigint, data date, ident integer ) RETURNS void AS $$

  INSERT INTO bensplaca VALUES (nextval('bensplaca_t41_codigo_seq'),$1,$3,$3,'ajuste',$2,63);

$$ LANGUAGE SQL;

SELECT setval('bensplaca_t41_codigo_seq',(SELECT max(t41_codigo)+1 AS codigo FROM bensplaca));

SELECT copia_placas(t52_bem,t52_dtaqu,t52_ident::integer) FROM bens LEFT JOIN bensplaca ON t41_bem = t52_bem WHERE t52_bem NOT IN (SELECT t41_bem FROM bensplaca);

COMMIT;