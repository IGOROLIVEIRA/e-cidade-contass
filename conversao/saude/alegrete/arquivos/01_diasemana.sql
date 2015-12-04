--
-- PostgreSQL database dump
--
--DROP TABLE:
DROP TABLE diasemana;


--
-- Name: diasemana; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--
CREATE TABLE diasemana (
    ed32_i_codigo integer DEFAULT 0 NOT NULL,
    ed32_c_descr character(15),
    ed32_c_abrev character(3)
);


--
-- Data for Name: diasemana; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO diasemana (ed32_i_codigo, ed32_c_descr, ed32_c_abrev) VALUES (1, 'DOMINGO        ', 'D  ');
INSERT INTO diasemana (ed32_i_codigo, ed32_c_descr, ed32_c_abrev) VALUES (2, 'SEGUNDA        ', 'S  ');
INSERT INTO diasemana (ed32_i_codigo, ed32_c_descr, ed32_c_abrev) VALUES (3, 'TERÇA          ', 'T  ');
INSERT INTO diasemana (ed32_i_codigo, ed32_c_descr, ed32_c_abrev) VALUES (4, 'QUARTA         ', 'Q  ');
INSERT INTO diasemana (ed32_i_codigo, ed32_c_descr, ed32_c_abrev) VALUES (5, 'QUINTA         ', 'Q  ');
INSERT INTO diasemana (ed32_i_codigo, ed32_c_descr, ed32_c_abrev) VALUES (6, 'SEXTA          ', 'S  ');
INSERT INTO diasemana (ed32_i_codigo, ed32_c_descr, ed32_c_abrev) VALUES (7, 'SABADO         ', 'S  ');


--
-- Name: diasemana_codi_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--
ALTER TABLE ONLY diasemana
    ADD CONSTRAINT diasemana_codi_pk PRIMARY KEY (ed32_i_codigo);

--
-- PostgreSQL database dump complete
--

