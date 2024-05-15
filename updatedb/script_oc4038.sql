BEGIN;

ALTER TABLE materialestoquegrupoconta
ADD COLUMN m66_codcontransf int4 NULL DEFAULT NULL,
ADD COLUMN m66_codcontransfvpd int4 NULL DEFAULT NULL,
ADD COLUMN m66_codcondoacao int4 NULL DEFAULT NULL,
ADD COLUMN m66_codcondoacaovpd int4 NULL DEFAULT NULL,
ADD COLUMN m66_codconperdaativo int4 NULL DEFAULT NULL,
ADD COLUMN m66_codconperdaativovpd int4 NULL DEFAULT NULL;

COMMIT;


-- CHAVES ESTRANGEIRAS TRANSFERÊNCIAS
BEGIN;

ALTER TABLE materialestoquegrupoconta
ADD CONSTRAINT materialestoquegrupoconta_codcontransf_ae_fk FOREIGN KEY (m66_codcontransf,m66_anousu)
REFERENCES conplano;

ALTER TABLE materialestoquegrupoconta
ADD CONSTRAINT materialestoquegrupoconta_codcontransfvpd_ae_fk FOREIGN KEY (m66_codcontransfvpd,m66_anousu)
REFERENCES conplano;

COMMIT;


-- CHAVES ESTRANGEIRAS DOAÇÕES
BEGIN;

ALTER TABLE materialestoquegrupoconta
ADD CONSTRAINT materialestoquegrupoconta_codcondoacao_ae_fk FOREIGN KEY (m66_codcondoacao,m66_anousu)
REFERENCES conplano;

ALTER TABLE materialestoquegrupoconta
ADD CONSTRAINT materialestoquegrupoconta_codcondoacaovpd_ae_fk FOREIGN KEY (m66_codcondoacaovpd,m66_anousu)
REFERENCES conplano;

COMMIT;


-- CHAVES ESTRANGEIRAS PERDA DE ATIVO
BEGIN;

ALTER TABLE materialestoquegrupoconta
ADD CONSTRAINT materialestoquegrupoconta_codconperdaativo_ae_fk FOREIGN KEY (m66_codconperdaativo,m66_anousu)
REFERENCES conplano;

ALTER TABLE materialestoquegrupoconta
ADD CONSTRAINT materialestoquegrupoconta_codconperdaativovpd_ae_fk FOREIGN KEY (m66_codconperdaativovpd,m66_anousu)
REFERENCES conplano;

COMMIT;
