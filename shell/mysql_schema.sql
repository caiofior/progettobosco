# Converted with pg2mysql-1.9
# Converted on Mon, 29 Apr 2013 09:43:10 +0200
# Lightbox Technologies Inc. http://www.lightbox.ca

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone="+00:00";

CREATE TABLE abbevera (
    codice varchar(1) NOT NULL,
    descriz varchar(8)
) ;

CREATE TABLE acc_stra (
    codice varchar(1) NOT NULL,
    descriz varchar(16)
) ;

CREATE TABLE acc_via (
    codice varchar(1),
    descriz varchar(20)
) ;

CREATE TABLE accesso (
    codice varchar(1) NOT NULL,
    descriz varchar(20)
) ;

CREATE TABLE an_id_co (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    u varchar(2),
    f varchar(2),
    g varchar(2),
    sup_tot double precision,
    sp1 varchar(3),
    sp2 varchar(3),
    sp3 varchar(3),
    sp4 varchar(3),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE arb_colt (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE arboree (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coper varchar(1),
    cod_coltu varchar(3) NOT NULL,
    ordine_inser int(11),
    ord_ins varchar(38),
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE arboree2 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coper int(11) DEFAULT 0,
    cod_coltu varchar(3) NOT NULL,
    ordine_inser int(11),
    ord_ins varchar(38),
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE arboree4a (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coper int(11) DEFAULT 0,
    cod_coltu varchar(3) NOT NULL,
    ordine_inser int(11),
    ord_ins varchar(38),
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE arboree4b (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coper int(11) DEFAULT 0,
    cod_coltu varchar(3) NOT NULL,
    ordine_inser int(11),
    ord_ins varchar(38),
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE arbusti (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE arbusti2 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE arbusti3 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE archivi (
    id int(11) auto_increment ,
    archivio varchar(12) NOT NULL,
    nomecampo varchar(25) NOT NULL,
    arc_esteso varchar(50),
    valnerina bool DEFAULT 0,
    rer bool DEFAULT 0,
    progetto_bosco bool DEFAULT 0,
    tipo varchar(3),
    lunghezza varchar(4),
    decimali varchar(2) DEFAULT ' 0',
    ordine varchar(4),
    intesta varchar(60),
    chiave bool DEFAULT 0,
    indice bool DEFAULT 0,
    query bool DEFAULT 0,
    dizionario varchar(20),
    campo_rela varchar(10),
    issele bool DEFAULT 0,
    qordine double precision,
    pict_campo varchar(15),
    valida varchar(70),
    vf varchar(70),
    quando varchar(70),
    qf varchar(70),
    calcolato varchar(254),
    `default` varchar(50),
    visibile bool DEFAULT 0,
    visiquando varchar(70),
    modificabi bool DEFAULT 0,
    totale bool DEFAULT 0,
    media bool DEFAULT 0,
    note varchar(250),
    lavorata bool DEFAULT 0,
    co varchar(20),
    `to` varchar(3),
    lo varchar(4),
    `do` varchar(2),
    fc varchar(1) DEFAULT 'n',
    ft varchar(1) DEFAULT 'n',
    fl varchar(1) DEFAULT 'n',
    fd varchar(1) DEFAULT 'n',
    note_camilla varchar(255),
    modif_camilla bool,
    note_chiara varchar(255),
    modif_chiara bool
, PRIMARY KEY(`id`)
) ;

CREATE TABLE base_per_h (
    proprieta varchar(5),
    cod_part varchar(5),
    cod_fo varchar(2),
    tipo_ril varchar(1),
    data timestamp,
    specie varchar(3),
    diam smallint,
    h real,
    poll_matr varchar(1)
) ;

CREATE TABLE car_nove (
    codice varchar(1) NOT NULL,
    descriz varchar(30)
) ;

CREATE TABLE carico (
    codice varchar(1) NOT NULL,
    descriz varchar(9)
) ;

CREATE TABLE catasto (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    foglio varchar(5) NOT NULL,
    particella varchar(5) NOT NULL,
    sup_tot_cat double precision DEFAULT 0,
    sup_tot double precision,
    sup_bosc double precision,
    sum_sup_non_bosc double precision DEFAULT 0,
    note text,
    id_av varchar(12),
    porz_perc double precision DEFAULT 0,
    objectid int(11) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1'
) ;

CREATE TABLE clas_pro (
    codice varchar(1) NOT NULL,
    descriz varchar(31)
) ;

CREATE TABLE clas_via (
    codice varchar(1) NOT NULL,
    descriz varchar(31)
) ;

CREATE TABLE coltcast (
    codice varchar(1) NOT NULL,
    descriz varchar(25)
) ;

CREATE TABLE comp_arb (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE compcoti (
    codice varchar(1) NOT NULL,
    descriz varchar(40)
) ;

CREATE TABLE compo (
    codice varchar(1) NOT NULL,
    descrizion varchar(10)
) ;

CREATE TABLE compresa (
    proprieta varchar(5) NOT NULL,
    compresa varchar(3) NOT NULL,
    descrizion varchar(255),
    frase text,
    rice_b varchar(255),
    rice_b1 varchar(255),
    rice_arb varchar(255),
    rice_cat varchar(255),
    rice_b2 varchar(255),
    rice_b3 varchar(255),
    objectid int(11) NOT NULL,
    id_av_x_join varchar(50)
) ;

CREATE TABLE comuni (
    regione varchar(2) NOT NULL,
    provincia varchar(3) NOT NULL,
    comune varchar(3) NOT NULL,
    codice varchar(6),
    descriz varchar(70),
    comunita varchar(3),
    priorita bool DEFAULT 0,
    objectid int(11) NOT NULL,
    id_av_comuni varchar(255)
) ;

CREATE TABLE comunita (
    regione varchar(2) NOT NULL,
    codice varchar(3) NOT NULL,
    descrizion varchar(80),
    objectid int(11) NOT NULL
) ;

CREATE TABLE copmorta (
    codice varchar(2),
    descriz varchar(33)
) ;

CREATE TABLE crono (
    codice varchar(1),
    descriz varchar(3)
) ;

CREATE TABLE denscoti (
    codice varchar(1) NOT NULL,
    descriz varchar(19)
) ;

CREATE TABLE densita (
    codice varchar(1) NOT NULL,
    descriz varchar(15)
) ;

CREATE TABLE densita3 (
    codice varchar(1) NOT NULL,
    descriz varchar(15)
) ;

CREATE TABLE descr_pa (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    id_av varchar(12),
    fattori text,
    descrizion text,
    interventi text,
    funzione text,
    orientamen text,
    ipotesi text,
    dendrometri text,
    note text,
    objectid int(11) NOT NULL
) ;

CREATE TABLE disph2o (
    codice varchar(1) NOT NULL,
    descriz varchar(13)
) ;

CREATE TABLE diz_arbo (
    cod_coltu varchar(3) NOT NULL,
    nome_scien varchar(38),
    nome_per_trad varchar(33),
    nome_itali varchar(40),
    form_b varchar(8),
    codice double precision,
    cod_ifer double precision,
    cod_ifni varchar(8),
    cod_cartfo varchar(13),
    cod_cens double precision,
    priorita bool DEFAULT 0,
    objectid int(11) NOT NULL,
    per_filtro bool DEFAULT 0
) ;

CREATE TABLE diz_curve (
    cod_curva varchar(1) NOT NULL,
    nome varchar(50)
) ;

CREATE TABLE diz_erba (
    cod_coltu varchar(3) NOT NULL,
    nome varchar(23),
    priorita bool DEFAULT 0,
    objectid int(11) NOT NULL
) ;

CREATE TABLE diz_fung (
    cod_coltu varchar(3) NOT NULL,
    nome varchar(23),
    objectid int(11) NOT NULL
) ;

CREATE TABLE diz_regioni (
    codice varchar(2) NOT NULL,
    descriz varchar(50),
    objectid int(11) NOT NULL
) ;

CREATE TABLE diz_tavole (
    codice varchar(10) NOT NULL,
    descriz varchar(120),
    autore varchar(50),
    funzione text,
    tipo varchar(1),
    forma varchar(1),
    biomassa bool DEFAULT 0,
    assortimenti bool DEFAULT 0,
    d_min int(11) DEFAULT 0,
    d_max int(11) DEFAULT 0,
    classe_d int(11) DEFAULT 0,
    h_min double precision DEFAULT 0,
    h_max double precision DEFAULT 0,
    classe_h int(11) DEFAULT 0,
    note varchar(255),
    n_tariffa int(11) DEFAULT 0,
    objectid int(11) NOT NULL,
    per_filtro bool DEFAULT 0
) ;

CREATE TABLE diz_tavole2 (
    codice varchar(10) NOT NULL,
    tariffa int(11) DEFAULT 1 NOT NULL,
    d double precision DEFAULT 0 NOT NULL,
    h double precision DEFAULT 0 NOT NULL,
    v double precision,
    objectid int(11) NOT NULL
) ;

CREATE TABLE diz_tavole3 (
    codice varchar(10) NOT NULL,
    tariffa int(11) DEFAULT 1 NOT NULL,
    d double precision DEFAULT 0 NOT NULL,
    h double precision DEFAULT 0 NOT NULL,
    vgrezzo double precision,
    velaborato double precision,
    vdendr double precision,
    vcorm double precision,
    vblast double precision,
    vcimale double precision,
    legnameopera double precision,
    tronchi double precision,
    tronchetti double precision,
    legnaardere double precision,
    traverse double precision,
    fasciname double precision,
    altro double precision,
    objectid int(11) NOT NULL
) ;

CREATE TABLE diz_tavole4 (
    codice varchar(10) NOT NULL,
    vgrezzo varchar(50),
    velaborato varchar(50),
    vdendr varchar(50),
    vcorm varchar(50),
    vblast varchar(50),
    vcimale varchar(50),
    legnameopera varchar(50),
    tronchi varchar(50),
    tronchetti varchar(50),
    legnaardere varchar(50),
    traverse varchar(50),
    fasciname varchar(50),
    altro varchar(50),
    pf varchar(100),
    ps varchar(100),
    objectid int(11) NOT NULL
) ;

CREATE TABLE diz_tavole5 (
    codice varchar(10) NOT NULL,
    vgrezzo_f bool DEFAULT 0,
    velaborato_f bool DEFAULT 0,
    vdendr_f bool DEFAULT 0,
    vcorm_f bool DEFAULT 0,
    vblast_f bool DEFAULT 0,
    vcimale_f bool DEFAULT 0,
    legnameopera_f bool DEFAULT 0,
    tronchi_f bool DEFAULT 0,
    tronchetti_f bool DEFAULT 0,
    legnaardere_f bool DEFAULT 0,
    traverse_f bool DEFAULT 0,
    fasciname_f bool DEFAULT 0,
    altro_f bool DEFAULT 0,
    objectid int(11) NOT NULL
) ;

CREATE TABLE diz_tipi (
    regione varchar(2) NOT NULL,
    codice varchar(10) NOT NULL,
    descriz varchar(150),
    priorita bool DEFAULT 0,
    objectid int(11) NOT NULL
) ;

CREATE TABLE diz_tiporil (
    codice varchar(1) NOT NULL,
    descrizion varchar(50)
) ;

CREATE TABLE elab_dend (
    proprieta varchar(5) NOT NULL,
    cod_elab varchar(5) NOT NULL,
    tipo_ril varchar(1),
    aggr_riliev varchar(1),
    compresa varchar(3),
    aggr_specie varchar(1),
    calc_vol_ird varchar(1),
    objectid int(11) NOT NULL,
    id_av_dend varchar(50),
    aggr_riliev_curva varchar(1),
    compresa_curva varchar(3),
    k_schneider int(11) DEFAULT 0,
    mod_strati varchar(1),
    mod_curva varchar(1) DEFAULT 't',
    da_stampare bool DEFAULT 0
) ;

CREATE TABLE elab_dend2 (
    proprieta varchar(5) NOT NULL,
    cod_elab varchar(5) NOT NULL,
    gruppo_specie varchar(1) NOT NULL,
    tavola varchar(10),
    curva varchar(1),
    n_tariffa int(11) DEFAULT 0,
    ipso varchar(50),
    forma varchar(1),
    objectid int(11) NOT NULL,
    id_av_dend2 varchar(50),
    id_av_dend varchar(50),
    desc_gruppo_sp varchar(50)
) ;

CREATE TABLE elab_dend3 (
    proprieta varchar(5) NOT NULL,
    cod_elab varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    objectid int(11) NOT NULL,
    id_av_dend varchar(50)
) ;

CREATE TABLE elab_dend4 (
    proprieta varchar(5) NOT NULL,
    cod_elab varchar(5) NOT NULL,
    gruppo_specie varchar(2) NOT NULL,
    specie varchar(3) NOT NULL,
    objectid int(11) NOT NULL,
    id_av_dend2 varchar(50)
) ;

CREATE TABLE elab_dend5 (
    proprieta varchar(5) NOT NULL,
    cod_elab varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    objectid int(11) NOT NULL,
    id_av_dend varchar(50)
) ;

CREATE TABLE erbacee (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE erbacee2 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE erbacee3 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE erbacee4 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE espo (
    codice varchar(1) NOT NULL,
    descriz varchar(10)
) ;

CREATE TABLE espos (
    codice varchar(1),
    descriz varchar(5)
) ;

CREATE TABLE fito_sug (
    codice varchar(1),
    descriz varchar(8)
) ;

CREATE TABLE fondo (
    codice varchar(1) NOT NULL,
    descriz varchar(10)
) ;

CREATE TABLE frequenza (
    codice varchar(1),
    descriz varchar(6)
) ;

CREATE TABLE fruitori (
    codice varchar(1) NOT NULL,
    descriz varchar(7)
) ;

CREATE TABLE funzion2 (
    codice varchar(2) NOT NULL,
    descriz varchar(50)
) ;

CREATE TABLE funzione (
    codice varchar(2) NOT NULL,
    descriz varchar(50)
) ;

CREATE TABLE geometry_columns (
    f_table_catalog text NOT NULL,
    f_table_schema text NOT NULL,
    f_table_name text NOT NULL,
    f_geometry_column text NOT NULL,
    coord_dimension int(11) NOT NULL,
    srid int(11) NOT NULL,
    `type` varchar(30) NOT NULL
) ;

CREATE TABLE infestan (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE infr_past (
    codice varchar(2) NOT NULL,
    descriz varchar(60)
) ;

CREATE TABLE int_via (
    codice varchar(2) NOT NULL,
    descriz varchar(60)
) ;

CREATE TABLE interventi_localizzati_viabilita (
    objectid int(11) NOT NULL,
    shape text
) ;

CREATE TABLE interventi_localizzati_viabilita_shape_index (
    indexedobjectid int(11) NOT NULL,
    mingx int(11) NOT NULL,
    mingy int(11) NOT NULL,
    maxgx int(11) NOT NULL,
    maxgy int(11) NOT NULL
) ;

CREATE TABLE irrigaz (
    codice varchar(1),
    descriz varchar(16)
) ;

CREATE TABLE leg_note (
    archivio varchar(10),
    nomecampo varchar(20),
    intesta varchar(255),
    objectid int(11) NOT NULL
) ;

CREATE TABLE loc_dend (
    codice varchar(1),
    descriz varchar(25)
) ;

CREATE TABLE localizz (
    codice varchar(2),
    descriz varchar(25)
) ;

CREATE TABLE log (
    id int(11) NOT NULL,
    user_id int(11),
    username varchar(255),
    objectid int(11),
    description varchar(255),
    creation_datetime timestamp,
    text text
) ;

CREATE TABLE manufatt (
    codice varchar(1),
    descriz varchar(7)
) ;

CREATE TABLE manutenz (
    codice varchar(1) NOT NULL,
    descriz varchar(30)
) ;

CREATE TABLE matrici (
    codice int(11) NOT NULL,
    descriz varchar(15)
) ;

CREATE TABLE meccaniz (
    codice varchar(1) NOT NULL,
    descriz varchar(19)
) ;

CREATE TABLE migliora (
    codice varchar(1),
    descriz varchar(30)
) ;

CREATE TABLE mod_pasc (
    codice varchar(1) NOT NULL,
    descriz varchar(9)
) ;

CREATE TABLE moti_macchia (
    codice varchar(1) NOT NULL,
    descriz varchar(43)
) ;

CREATE TABLE nomi_arc (
    nome varchar(15) NOT NULL,
    descrizio varchar(40),
    tipo varchar(1),
    livello varchar(10),
    valnerina bool DEFAULT 0,
    progetto_bosco bool DEFAULT 0,
    rer bool DEFAULT 0,
    modificabi bool DEFAULT 0,
    appendi bool DEFAULT 0,
    query bool DEFAULT 0,
    issele bool DEFAULT 0,
    modo varchar(1),
    alto int(11),
    basso int(11),
    sinistro int(11),
    destro int(11),
    area int(11),
    flagprn bool DEFAULT 0,
    driver varchar(6),
    contatore double precision,
    dove varchar(1),
    modif_camilla bool,
    dubbi varchar(1),
    note_camilla varchar(255),
    modif_chiara bool,
    note_chiara varchar(255)
) ;

CREATE TABLE note_a (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_nota varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    id_av varchar(12)
) ;

CREATE TABLE note_b (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_nota varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE note_b2 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_nota varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE note_b3 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_nota varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE note_b4 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_nota varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE note_n (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_ev_int varchar(3) NOT NULL,
    cod_nota varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    id_av_n varchar(20)
) ;

CREATE TABLE novell (
    codice varchar(1) NOT NULL,
    descriz varchar(31)
) ;

CREATE TABLE novell2 (
    codice varchar(1) NOT NULL,
    descriz varchar(10)
) ;

CREATE TABLE op_logici (
    codice varchar(3),
    descriz varchar(41)
) ;

CREATE TABLE operator (
    codice varchar(3),
    descriz varchar(41)
) ;

CREATE TABLE origine (
    codice int(11) NOT NULL,
    descriz varchar(41),
    per_stampa varchar(37)
) ;

CREATE TABLE ostacoli (
    codice varchar(1) NOT NULL,
    descriz varchar(35)
) ;

CREATE TABLE partcomp (
    compresa_o varchar(3),
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    id_av varchar(12),
    sup double precision,
    sup_bosc double precision,
    abstract text,
    compresa varchar(3),
    objectid int(11) NOT NULL,
    id_av_x_join varchar(50)
) ;

CREATE TABLE per_arbo (
    codice varchar(1) NOT NULL,
    descriz varchar(6)
) ;

CREATE TABLE per_inter (
    codice varchar(1),
    descriz varchar(20)
) ;

CREATE TABLE pianota (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    anno varchar(4) DEFAULT '0000',
    per_inter varchar(1) DEFAULT ' ',
    id_av varchar(12),
    sup_tagl double precision,
    ripresa_vol_perc double precision DEFAULT 0,
    p2 varchar(2),
    p3 varchar(2),
    p4 text,
    objectid int(11) NOT NULL
) ;

CREATE TABLE piu1_3 (
    codice varchar(1) NOT NULL,
    descriz varchar(30)
) ;

CREATE TABLE piu2_3 (
    codice varchar(1) NOT NULL,
    descriz varchar(30)
) ;

CREATE TABLE pollmatr (
    codice varchar(1) NOT NULL,
    descriz varchar(9)
) ;

CREATE TABLE popolame (
    codice varchar(5) NOT NULL,
    popolament varchar(30),
    g_min double precision,
    g_max double precision,
    h_min double precision,
    h_max double precision,
    coeff_a double precision,
    coeff_b double precision,
    funz_cubat varchar(28),
    val_dendro varchar(100),
    objectid int(11) NOT NULL
) ;

CREATE TABLE posfisio (
    codice varchar(2) NOT NULL,
    descriz varchar(18)
) ;

CREATE TABLE prep_terr (
    codice varchar(1) NOT NULL,
    descriz varchar(15)
) ;

CREATE TABLE pres_ass (
    codice varchar(1) NOT NULL,
    valore varchar(8)
) ;

CREATE TABLE prescri2 (
    codice varchar(2) NOT NULL,
    descriz varchar(51)
) ;

CREATE TABLE prescri3 (
    codice varchar(2) NOT NULL,
    descriz varchar(40)
) ;

CREATE TABLE prescri_via (
    codice varchar(2) NOT NULL,
    descriz varchar(70)
) ;

CREATE TABLE prescriz (
    codice varchar(2) NOT NULL,
    descriz varchar(55)
) ;

CREATE TABLE prescriz_globale (
    codice varchar(2) NOT NULL,
    descriz varchar(55),
    schede varchar(11)
) ;

CREATE TABLE presstra (
    codice varchar(1),
    descriz varchar(9)
) ;

CREATE TABLE problemi_a (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    tabella varchar(2) NOT NULL,
    campo varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    id_av varchar(12)
) ;

CREATE TABLE problemi_b1 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tabella varchar(2) NOT NULL,
    campo varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE problemi_b2 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tabella varchar(2) NOT NULL,
    campo varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE problemi_b3 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tabella varchar(2) NOT NULL,
    campo varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE problemi_b4 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tabella varchar(2) NOT NULL,
    campo varchar(20) NOT NULL,
    nota varchar(255),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE profile (
    id int(11) NOT NULL,
    first_name varchar(50),
    last_name varchar(50),
    email varchar(50),
    phone varchar(20),
    web varchar(100),
    facebook varchar(100),
    google varchar(100),
    address_addres varchar(100),
    address_street_number varchar(10),
    address_city varchar(100),
    address_province varchar(2),
    address_zip varchar(6),
    lastupdate_datetime timestamp,
    organization varchar(255)
) ;

CREATE TABLE propriet (
    codice varchar(5) NOT NULL,
    descrizion varchar(50),
    regione varchar(2),
    objectid int(11) NOT NULL
) ;

CREATE TABLE province (
    regione varchar(2) NOT NULL,
    provincia varchar(3) NOT NULL,
    descriz varchar(30),
    sigla varchar(2),
    objectid int(11) NOT NULL,
    id_av_comuni varchar(255)
) ;

CREATE TABLE qual_fus (
    codice varchar(1),
    descriz varchar(55)
) ;

CREATE TABLE qual_pro (
    codice varchar(2) NOT NULL,
    descriz varchar(50)
) ;

CREATE TABLE qual_via (
    codice varchar(2) NOT NULL,
    descriz varchar(50)
) ;

CREATE TABLE relazion (
    padre varchar(15),
    figlio varchar(15),
    relazione varchar(255)
) ;

CREATE TABLE rete_stradale (
    objectid int(11) NOT NULL,
    shape text,
    id_av_e varchar(50),
    cod_str varchar(5),
    proprieta varchar(5),
    shape_length double precision
) ;

CREATE TABLE rilevato (
    codice varchar(3) NOT NULL,
    descriz varchar(20),
    objectid int(11) NOT NULL
) ;

CREATE TABLE rinnov (
    codice varchar(1) NOT NULL,
    descriz varchar(31)
) ;

CREATE TABLE rinnovaz (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE ris_dend1 (
    proprieta varchar(5) NOT NULL,
    cod_elab varchar(5) NOT NULL,
    gruppo_specie varchar(2) NOT NULL,
    verifica bool DEFAULT 0,
    sup_tot double precision DEFAULT 0,
    sup_bosc double precision DEFAULT 0,
    sup_impr double precision DEFAULT 0,
    sup_prod_non_bosc double precision DEFAULT 0,
    n_tot int(11),
    g_tot double precision,
    v_tot double precision DEFAULT 0,
    n_ha int(11),
    g_ha double precision,
    v_ha double precision DEFAULT 0,
    d_g double precision,
    d_dom double precision,
    i double precision DEFAULT 0,
    tp int(11) DEFAULT 0,
    pv double precision DEFAULT 0,
    ic double precision DEFAULT 0,
    ip double precision DEFAULT 0,
    n_ha_matr int(11) DEFAULT 0,
    n_ha_poll int(11) DEFAULT 0,
    n_ha_fust int(11) DEFAULT 0,
    g_ha_matr double precision DEFAULT 0,
    g_ha_poll double precision DEFAULT 0,
    g_ha_fust double precision DEFAULT 0,
    dg_matr double precision DEFAULT 0,
    dg_poll double precision DEFAULT 0,
    dg_fust double precision DEFAULT 0,
    n_tot_p int(11),
    g_tot_p double precision,
    v_tot_p double precision DEFAULT 0,
    n_ha_matr_p int(11) DEFAULT 0,
    n_ha_poll_p int(11) DEFAULT 0,
    n_ha_fust_p int(11) DEFAULT 0,
    g_ha_matr_p double precision DEFAULT 0,
    g_ha_poll_p double precision DEFAULT 0,
    g_ha_fust_p double precision DEFAULT 0,
    dg_matr_p double precision DEFAULT 0,
    dg_poll_p double precision DEFAULT 0,
    dg_fust_p double precision DEFAULT 0,
    note text,
    num_oss_h int(11) DEFAULT 0,
    c_b_semilog double precision,
    c_m_semilog double precision,
    c_b_log double precision,
    c_m_log double precision,
    c_b_rad double precision,
    c_m_rad double precision,
    c_b_parab double precision,
    c_m_parab double precision,
    c_m2_parab double precision,
    c_b_invparab double precision,
    c_m_invparab double precision,
    c_m2_invparab double precision,
    stat_r_semilog double precision DEFAULT 0,
    stat_f_semilog double precision DEFAULT 0,
    stat_r_log double precision DEFAULT 0,
    stat_f_log double precision DEFAULT 0,
    stat_r_rad double precision DEFAULT 0,
    stat_f_rad double precision DEFAULT 0,
    stat_r_parab double precision DEFAULT 0,
    stat_f_parab double precision DEFAULT 0,
    stat_r_invparab double precision DEFAULT 0,
    stat_f_invparab double precision DEFAULT 0,
    h_dom_semilog double precision DEFAULT 0,
    h_dom_log double precision DEFAULT 0,
    h_dom_rad double precision DEFAULT 0,
    h_dom_esterna double precision DEFAULT 0,
    h_dom_parab double precision DEFAULT 0,
    h_dom_invparab double precision DEFAULT 0,
    h_semilog double precision DEFAULT 0,
    h_log double precision DEFAULT 0,
    h_rad double precision DEFAULT 0,
    h_esterna double precision DEFAULT 0,
    h_parab double precision DEFAULT 0,
    h_invparab double precision DEFAULT 0,
    v_ha_semilog double precision DEFAULT 0,
    v_ha_log double precision DEFAULT 0,
    v_ha_rad double precision DEFAULT 0,
    v_ha_esterna double precision DEFAULT 0,
    v_ha_pop double precision DEFAULT 0,
    v_ha_parab double precision DEFAULT 0,
    v_ha_invparab double precision DEFAULT 0,
    n_ha_p int(11),
    g_ha_p double precision,
    v_ha_p double precision DEFAULT 0,
    d_g_p double precision,
    vgrezzo_ha_semilog double precision DEFAULT 0,
    velaborato_ha_semilog double precision DEFAULT 0,
    vdendr_ha_semilog double precision DEFAULT 0,
    vcorm_ha_semilog double precision DEFAULT 0,
    vblast_ha_semilog double precision DEFAULT 0,
    vcimale_ha_semilog double precision DEFAULT 0,
    legnameopera_ha_semilog double precision DEFAULT 0,
    tronchi_ha_semilog double precision DEFAULT 0,
    tronchetti_ha_semilog double precision DEFAULT 0,
    legnaardere_ha_semilog double precision DEFAULT 0,
    traverse_ha_semilog double precision DEFAULT 0,
    fasciname_ha_semilog double precision DEFAULT 0,
    altro_ha_semilog double precision DEFAULT 0,
    pf_ha_semilog double precision DEFAULT 0,
    ps_ha_semilog double precision DEFAULT 0,
    vgrezzo_ha_log double precision DEFAULT 0,
    velaborato_ha_log double precision DEFAULT 0,
    vdendr_ha_log double precision DEFAULT 0,
    vcorm_ha_log double precision DEFAULT 0,
    vblast_ha_log double precision DEFAULT 0,
    vcimale_ha_log double precision DEFAULT 0,
    legnameopera_ha_log double precision DEFAULT 0,
    tronchi_ha_log double precision DEFAULT 0,
    tronchetti_ha_log double precision DEFAULT 0,
    legnaardere_ha_log double precision DEFAULT 0,
    traverse_ha_log double precision DEFAULT 0,
    fasciname_ha_log double precision DEFAULT 0,
    altro_ha_log double precision DEFAULT 0,
    pf_ha_log double precision DEFAULT 0,
    ps_ha_log double precision DEFAULT 0,
    vgrezzo_ha_rad double precision DEFAULT 0,
    velaborato_ha_rad double precision DEFAULT 0,
    vdendr_ha_rad double precision DEFAULT 0,
    vcorm_ha_rad double precision DEFAULT 0,
    vblast_ha_rad double precision DEFAULT 0,
    vcimale_ha_rad double precision DEFAULT 0,
    legnameopera_ha_rad double precision DEFAULT 0,
    tronchi_ha_rad double precision DEFAULT 0,
    tronchetti_ha_rad double precision DEFAULT 0,
    legnaardere_ha_rad double precision DEFAULT 0,
    traverse_ha_rad double precision DEFAULT 0,
    fasciname_ha_rad double precision DEFAULT 0,
    altro_ha_rad double precision DEFAULT 0,
    pf_ha_rad double precision DEFAULT 0,
    ps_ha_rad double precision DEFAULT 0,
    vgrezzo_ha_esterna double precision DEFAULT 0,
    velaborato_ha_esterna double precision DEFAULT 0,
    vdendr_ha_esterna double precision DEFAULT 0,
    vcorm_ha_esterna double precision DEFAULT 0,
    vblast_ha_esterna double precision DEFAULT 0,
    vcimale_ha_esterna double precision DEFAULT 0,
    legnameopera_ha_esterna double precision DEFAULT 0,
    tronchi_ha_esterna double precision DEFAULT 0,
    tronchetti_ha_esterna double precision DEFAULT 0,
    legnaardere_ha_esterna double precision DEFAULT 0,
    traverse_ha_esterna double precision DEFAULT 0,
    fasciname_ha_esterna double precision DEFAULT 0,
    altro_ha_esterna double precision DEFAULT 0,
    pf_ha_esterna double precision DEFAULT 0,
    ps_ha_esterna double precision DEFAULT 0,
    objectid int(11) NOT NULL,
    id_av_dend2 varchar(50),
    id_av_dend varchar(50),
    vgrezzo_ha_parab double precision DEFAULT 0,
    velaborato_ha_parab double precision DEFAULT 0,
    vdendr_ha_parab double precision DEFAULT 0,
    vcorm_ha_parab double precision DEFAULT 0,
    vblast_ha_parab double precision DEFAULT 0,
    vcimale_ha_parab double precision DEFAULT 0,
    legnameopera_ha_parab double precision DEFAULT 0,
    tronchi_ha_parab double precision DEFAULT 0,
    tronchetti_ha_parab double precision DEFAULT 0,
    legnaardere_ha_parab double precision DEFAULT 0,
    traverse_ha_parab double precision DEFAULT 0,
    fasciname_ha_parab double precision DEFAULT 0,
    altro_ha_parab double precision DEFAULT 0,
    pf_ha_parab double precision DEFAULT 0,
    ps_ha_parab double precision DEFAULT 0,
    vgrezzo_ha_invparab double precision DEFAULT 0,
    velaborato_ha_invparab double precision DEFAULT 0,
    vdendr_ha_invparab double precision DEFAULT 0,
    vcorm_ha_invparab double precision DEFAULT 0,
    vblast_ha_invparab double precision DEFAULT 0,
    vcimale_ha_invparab double precision DEFAULT 0,
    legnameopera_ha_invparab double precision DEFAULT 0,
    tronchi_ha_invparab double precision DEFAULT 0,
    tronchetti_ha_invparab double precision DEFAULT 0,
    legnaardere_ha_invparab double precision DEFAULT 0,
    traverse_ha_invparab double precision DEFAULT 0,
    fasciname_ha_invparab double precision DEFAULT 0,
    altro_ha_invparab double precision DEFAULT 0,
    pf_ha_invparab double precision DEFAULT 0,
    ps_ha_invparab double precision DEFAULT 0
) ;

CREATE TABLE ris_dend2 (
    proprieta varchar(5) NOT NULL,
    cod_elab varchar(5) NOT NULL,
    gruppo_specie varchar(2) NOT NULL,
    conta varchar(38) NOT NULL,
    d int(11) DEFAULT 0,
    h int(11) DEFAULT 0,
    h_semilog double precision DEFAULT 0,
    h_log double precision DEFAULT 0,
    h_rad double precision DEFAULT 0,
    h_parab double precision DEFAULT 0,
    h_invparab double precision DEFAULT 0,
    h_esterna double precision DEFAULT 0,
    v_semilog int(11) DEFAULT 0,
    v_log int(11) DEFAULT 0,
    v_rad int(11) DEFAULT 0,
    v_parab int(11) DEFAULT 0,
    v_invparab int(11) DEFAULT 0,
    v_esterna int(11) DEFAULT 0,
    objectid int(11) NOT NULL,
    id_av_dend2 varchar(50)
) ;

CREATE TABLE ris_dend3 (
    proprieta varchar(5) NOT NULL,
    cod_elab varchar(5) NOT NULL,
    gruppo_specie varchar(2) NOT NULL,
    specie varchar(3) NOT NULL,
    d int(11) DEFAULT 0 NOT NULL,
    n int(11) DEFAULT 0,
    n_ha int(11) DEFAULT 0,
    g_ha double precision DEFAULT 0,
    v_ha double precision DEFAULT 0,
    n_ha_perc double precision DEFAULT 0,
    g_ha_perc double precision DEFAULT 0,
    v_ha_perc double precision DEFAULT 0,
    objectid int(11) NOT NULL,
    id_av_dend3 varchar(50)
) ;

CREATE TABLE scarpate (
    codice varchar(1),
    descriz varchar(5)
) ;

CREATE TABLE sched_b1 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    id_av varchar(12),
    sup double precision,
    l varchar(2),
    l1 varchar(50),
    e1 varchar(1),
    q1 double precision,
    q2 double precision,
    u varchar(2),
    g varchar(2),
    s varchar(2),
    m varchar(1),
    n_mat double precision,
    ce_mat varchar(1),
    turni double precision,
    o varchar(1),
    c1 double precision,
    c2 double precision,
    n_agam varchar(1),
    senescenti varchar(1),
    colt_cast varchar(1),
    sr varchar(1),
    se varchar(1),
    morta varchar(2),
    alberiterr varchar(1),
    prep_terr varchar(1),
    sesto_imp_tra_file double precision DEFAULT 0,
    sesto_imp_su_file double precision DEFAULT 0,
    buche int(11) DEFAULT 0,
    vig varchar(1),
    v varchar(1),
    ce double precision,
    d varchar(1),
    chiarie double precision,
    n1 varchar(1),
    n2 varchar(1),
    n3 varchar(1),
    spe_nov varchar(3),
    f varchar(2),
    f2 varchar(2),
    p2 varchar(2),
    p3 varchar(2),
    p4 varchar(20),
    g1 varchar(1),
    sub_viab varchar(1),
    d1 double precision,
    d2 double precision,
    d3 double precision,
    d7 double precision,
    d8 double precision,
    d9 double precision,
    d4 double precision,
    d5 double precision,
    d6 double precision,
    d14 double precision,
    d15 double precision,
    d16 double precision,
    note text,
    `int2` varchar(2),
    `int3` varchar(20),
    tipo varchar(3),
    objectid int(11) NOT NULL,
    d21 double precision,
    d22 double precision,
    d23 double precision,
    d24 double precision,
    d25 double precision,
    d26 double precision
) ;

CREATE TABLE sched_b2 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    codiope varchar(3),
    datasch timestamp,
    id_av varchar(12),
    u varchar(2),
    tipo varchar(50),
    anno_imp int(11) DEFAULT 0,
    anno_dest int(11) DEFAULT 0,
    comp_spe varchar(50),
    cod_coltup varchar(3),
    cod_coltus varchar(3),
    dist double precision DEFAULT 0,
    dist_princ double precision DEFAULT 0,
    sesto_imp_arb varchar(1),
    sesto_princ varchar(1),
    vig_arb_princ varchar(1),
    vig_arb_sec varchar(1),
    fall double precision DEFAULT 0,
    qual_pri varchar(1),
    colt_cast varchar(50),
    vig_cast varchar(1),
    sesto_imp_cast varchar(1),
    cod_coltub varchar(3),
    cod_coltua varchar(3),
    fungo_ospi varchar(3),
    sesto_imp_tart varchar(1),
    num_piante int(11) DEFAULT 0,
    piant_tart int(11) DEFAULT 0,
    c1 double precision DEFAULT 0,
    o varchar(1),
    vig_sug varchar(1),
    v varchar(1),
    d varchar(1),
    n1 varchar(1),
    n2 varchar(1),
    n3 varchar(1),
    spe_nov varchar(3),
    `int2` varchar(2),
    `int3` varchar(20),
    g varchar(2),
    ce double precision DEFAULT 0,
    sr varchar(1),
    se varchar(1),
    g1 varchar(50),
    sub_viab varchar(1),
    p2 varchar(2),
    p3 varchar(2),
    p4 varchar(20),
    note text,
    objectid int(11) NOT NULL,
    d1 double precision,
    d3 double precision,
    d5 double precision,
    d10 double precision,
    d11 double precision,
    d12 double precision,
    d13 double precision,
    fito_sug varchar(1),
    s varchar(1),
    tipo_int_sug varchar(1),
    tipo_prescr_sug varchar(1),
    estraz_passata varchar(4),
    estraz_futura varchar(4),
    fito_bio bool DEFAULT 0,
    fito_abio bool DEFAULT 0,
    fito_bio_spec varchar(50),
    fito_abio_spec varchar(50)
) ;

CREATE TABLE sched_b3 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    id_av varchar(12),
    sup double precision,
    l varchar(2),
    l1 varchar(50),
    e1 varchar(1),
    q1 double precision,
    q2 double precision,
    u varchar(2),
    h double precision,
    cop_arbu double precision,
    se varchar(1),
    cop_erba double precision,
    sr varchar(1),
    sr_perc int(11) DEFAULT 0,
    cop_arbo int(11) DEFAULT 0,
    comp_coti varchar(1),
    dens_coti varchar(1),
    infestanti varchar(1),
    modalpasco varchar(1),
    duratapasc double precision,
    fruitori varchar(1),
    caricopasc varchar(1),
    n_capi double precision,
    accespasc varchar(1),
    disph2o varchar(1),
    possirrig varchar(1),
    possmeccan varchar(1),
    possmungit varchar(1),
    infr_past varchar(1),
    n_abbevera double precision,
    stato_abbe varchar(1),
    n1 varchar(1),
    n2 varchar(1),
    f varchar(2),
    f2 varchar(2),
    p2 varchar(2),
    p3 varchar(2),
    p4 varchar(20),
    g1 varchar(1),
    sub_viab varchar(1),
    diffalbcol varchar(1),
    modi int(11) DEFAULT 0,
    note text,
    objectid int(11) NOT NULL
) ;

CREATE TABLE sched_b4 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    id_av varchar(12),
    sup double precision,
    u varchar(2),
    vert varchar(1),
    ce_min2 double precision,
    h_min2 double precision DEFAULT 0,
    ce_mag2 double precision,
    h_mag2 double precision DEFAULT 0,
    motivo1 varchar(1),
    motivo2 varchar(255),
    se varchar(1),
    `int2` varchar(2),
    `int3` varchar(20),
    f varchar(2),
    g varchar(2),
    p2 varchar(2),
    p3 varchar(2),
    p4 varchar(20),
    g1 varchar(1),
    sub_viab varchar(1),
    note text,
    tipo varchar(3),
    objectid int(11) NOT NULL
) ;

CREATE TABLE sched_c1 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    diam int(11) DEFAULT 0 NOT NULL,
    specie varchar(3) NOT NULL,
    rilievo int(11) DEFAULT 0,
    prelievo int(11) DEFAULT 0,
    poll_matr varchar(1),
    objectid int(11) NOT NULL,
    id_av varchar(12)
) ;

CREATE TABLE sched_c2 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    conta varchar(38) NOT NULL,
    id_av varchar(12),
    specie varchar(3),
    poll_matr varchar(1),
    diam int(11) DEFAULT 0,
    h double precision DEFAULT 0,
    i double precision DEFAULT 0,
    h_stim double precision DEFAULT 0,
    objectid int(11) NOT NULL
) ;

CREATE TABLE sched_d1 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    n_camp int(11) DEFAULT 0 NOT NULL,
    conta varchar(38) NOT NULL,
    id_av varchar(12),
    specie varchar(3),
    diam int(11) DEFAULT 0,
    h double precision DEFAULT 0,
    i double precision DEFAULT 0,
    p int(11) DEFAULT 0,
    h_stim double precision DEFAULT 0,
    poll_matr varchar(1),
    frequenza double precision DEFAULT 1,
    objectid int(11) NOT NULL,
    freq_prel double precision DEFAULT 0
) ;

CREATE TABLE sched_e1 (
    proprieta varchar(5) NOT NULL,
    strada varchar(4) NOT NULL,
    cod_inter varchar(2) NOT NULL,
    descrizione varchar(50),
    objectid int(11) NOT NULL,
    id_av_e varchar(20)
) ;

CREATE TABLE sched_f1 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    n_camp int(11) DEFAULT 0 NOT NULL,
    specie varchar(3) NOT NULL,
    id_av varchar(12),
    n_cont double precision DEFAULT 0,
    n_prel int(11) DEFAULT 0,
    objectid int(11) NOT NULL
) ;

CREATE TABLE sched_f2 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    n_camp int(11) DEFAULT 0 NOT NULL,
    conta varchar(38) NOT NULL,
    id_av varchar(12),
    specie varchar(3),
    diam int(11) DEFAULT 0,
    h double precision DEFAULT 0,
    h_stim double precision DEFAULT 0,
    objectid int(11) NOT NULL
) ;

CREATE TABLE sched_l1 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    num_alb varchar(5) NOT NULL,
    elemento varchar(1) NOT NULL,
    h_sez double precision NOT NULL,
    d_sez double precision,
    objectid int(11) NOT NULL,
    id_av varchar(50),
    id_av_l1 varchar(50)
) ;

CREATE TABLE sched_l1b (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    num_alb varchar(5) NOT NULL,
    elemento varchar(2) NOT NULL,
    sezione varchar(1),
    vol double precision DEFAULT 0,
    objectid int(11) NOT NULL,
    id_av varchar(12),
    id_av_l1b varchar(20),
    id_av_l1 varchar(50)
) ;

CREATE TABLE schede_a (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    id_av varchar(12),
    area_gis double precision,
    peri_gis double precision,
    datasch date,
    comune varchar(6),
    toponimo varchar(50),
    foglioctr varchar(10),
    sezionectr varchar(10),
    codiope varchar(3),
    sup_tot double precision,
    sup int(11) DEFAULT 0,
    am double precision,
    ama double precision,
    ap double precision,
    pm double precision,
    pp double precision,
    e1 varchar(1),
    pf1 varchar(2),
    a2 varchar(1),
    a3 varchar(1),
    a4 varchar(1),
    a5 varchar(1) DEFAULT '0',
    a6 varchar(1),
    a7 varchar(1),
    a8 varchar(20),
    r2 varchar(1),
    r3 varchar(1),
    r4 varchar(1),
    r5 varchar(1),
    r6 varchar(1),
    r7 varchar(20),
    f2 varchar(1),
    f3 varchar(1),
    f4 varchar(1),
    f5 varchar(1),
    f6 varchar(1),
    f7 varchar(1),
    f8 varchar(1),
    f9 varchar(1),
    f10 varchar(1),
    f11 varchar(1),
    f12 varchar(20),
    v1 double precision,
    v3 double precision,
    piazzali varchar(1),
    o varchar(1),
    p1 bool DEFAULT 0,
    p2 bool DEFAULT 0,
    p3 bool DEFAULT 0,
    p4 bool DEFAULT 0,
    p5 bool DEFAULT 0,
    p6 bool DEFAULT 0,
    p8 varchar(20),
    p7 varchar(1),
    p9 varchar(20),
    m1 bool DEFAULT 0,
    m2 bool DEFAULT 0,
    m3 bool DEFAULT 0,
    m4 bool DEFAULT 0,
    m5 bool DEFAULT 0,
    m6 bool DEFAULT 0,
    m7 bool DEFAULT 0,
    m8 bool DEFAULT 0,
    m9 bool DEFAULT 0,
    m10 bool DEFAULT 0,
    m11 bool DEFAULT 0,
    m12 bool DEFAULT 0,
    m13 bool DEFAULT 0,
    m14 bool DEFAULT 0,
    m15 bool DEFAULT 0,
    m16 bool DEFAULT 0,
    m17 bool DEFAULT 0,
    m18 bool DEFAULT 0,
    m19 varchar(20),
    m20 bool DEFAULT 0,
    m21 bool DEFAULT 0,
    m22 bool DEFAULT 0,
    m23 bool DEFAULT 0,
    c1 bool DEFAULT 0,
    c2 bool DEFAULT 0,
    c3 bool DEFAULT 0,
    c4 bool DEFAULT 0,
    c5 bool DEFAULT 0,
    c6 varchar(20),
    i1 double precision,
    i2 double precision,
    i3 bool DEFAULT 0,
    i4 bool DEFAULT 0,
    i5 bool DEFAULT 0,
    i6 bool DEFAULT 0,
    i7 bool DEFAULT 0,
    i8 varchar(20),
    i21 double precision,
    i22 double precision,
    n2 bool DEFAULT 0,
    n3 bool DEFAULT 0,
    n4 bool DEFAULT 0,
    n5 bool DEFAULT 0,
    n6 bool DEFAULT 0,
    n7 bool DEFAULT 0,
    n8 bool DEFAULT 0,
    n9 bool DEFAULT 0,
    n10 bool DEFAULT 0,
    n11 bool DEFAULT 0,
    n12 bool DEFAULT 0,
    n13 bool DEFAULT 0,
    n14 bool DEFAULT 0,
    n15 bool DEFAULT 0,
    n16 bool DEFAULT 0,
    n17 bool DEFAULT 0,
    n18 varchar(20) DEFAULT 'Specifiche',
    note text,
    delimitata varchar(1),
    localizzata varchar(50),
    objectid int(11) NOT NULL
) ;

CREATE TABLE schede_b (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    id_av varchar(12),
    u varchar(2) NOT NULL,
    area_gis double precision DEFAULT 0,
    peri_gis double precision DEFAULT 0,
    sup int(11) DEFAULT 0,
    t varchar(10),
    objectid int(11) NOT NULL
) ;

CREATE TABLE schede_c (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    id_av varchar(12),
    codiope varchar(3),
    c_anel int(11) DEFAULT 0,
    m_anel int(11) DEFAULT 0,
    note text,
    objectid int(11) NOT NULL
) ;

CREATE TABLE schede_d (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    n_camp int(11) DEFAULT 0 NOT NULL,
    codiope varchar(3),
    id_av varchar(12),
    p int(11) DEFAULT 0,
    x double precision DEFAULT 0,
    y double precision DEFAULT 0,
    t_camp varchar(1),
    rag double precision DEFAULT 0,
    rag2 double precision DEFAULT 0,
    f double precision DEFAULT 0,
    c_anel int(11) DEFAULT 0,
    m_anel int(11) DEFAULT 0,
    note text,
    objectid int(11) NOT NULL
) ;

CREATE TABLE schede_e (
    proprieta varchar(5) NOT NULL,
    strada varchar(4) NOT NULL,
    nome_strada varchar(50),
    da_valle varchar(50),
    a_monte varchar(50),
    lung_gis int(11) DEFAULT 0,
    data timestamp,
    codiope varchar(3),
    class_amm varchar(1),
    class_prop varchar(2),
    qual_att varchar(1),
    qual_prop varchar(1),
    accesso varchar(1),
    transitabi varchar(1),
    manutenzione varchar(1),
    urgenza varchar(1),
    scarpate bool DEFAULT 0,
    corsi_acqua bool DEFAULT 0,
    tombini bool DEFAULT 0,
    can_tras bool DEFAULT 0,
    can_lat bool DEFAULT 0,
    aib bool DEFAULT 0,
    piazzole bool DEFAULT 0,
    imposti bool DEFAULT 0,
    reg_accesso bool DEFAULT 0,
    manufatti bool DEFAULT 0,
    altro bool DEFAULT 0,
    specifica varchar(50),
    note text,
    abstract text,
    larg_min double precision DEFAULT 0,
    larg_prev double precision DEFAULT 0,
    raggio double precision DEFAULT 0,
    fondo varchar(1),
    pend_media int(11) DEFAULT 0,
    pend_max int(11) DEFAULT 0,
    contropend int(11) DEFAULT 0,
    q_piazzole varchar(1),
    objectid int(11) NOT NULL,
    id_av_e varchar(20)
) ;

CREATE TABLE schede_f (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    n_camp int(11) DEFAULT 0 NOT NULL,
    codiope varchar(3),
    id_av varchar(12),
    x double precision DEFAULT 0,
    y double precision DEFAULT 0,
    f double precision DEFAULT 0,
    note text,
    d_ogni int(11) DEFAULT 0,
    h_ogni int(11) DEFAULT 0,
    objectid int(11) NOT NULL
) ;

CREATE TABLE schede_g (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    n_ads int(11) DEFAULT 0 NOT NULL,
    id_av varchar(12),
    fatt_num int(11),
    codiope varchar(3),
    datasch timestamp,
    n_alb_cont int(11) DEFAULT 0,
    h1 double precision DEFAULT 0,
    h2 double precision DEFAULT 0,
    h3 double precision DEFAULT 0,
    h4 double precision DEFAULT 0,
    h5 double precision DEFAULT 0,
    d1 int(11) DEFAULT 0,
    d2 int(11) DEFAULT 0,
    d3 int(11) DEFAULT 0,
    d4 int(11) DEFAULT 0,
    d5 int(11) DEFAULT 0,
    d6 int(11) DEFAULT 0,
    d7 int(11) DEFAULT 0,
    tavola varchar(3),
    objectid int(11) NOT NULL
) ;

CREATE TABLE schede_g1 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    fatt_num int(11),
    codiope varchar(3),
    datasch timestamp,
    tavola varchar(3),
    id_av varchar(12),
    d_ogni int(11) DEFAULT 0,
    note text,
    objectid int(11) NOT NULL
) ;

CREATE TABLE schede_n (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_ev_int varchar(3) DEFAULT ' ',
    id_av varchar(12),
    eve_int varchar(1),
    datasch timestamp,
    dataeven timestamp,
    codiope varchar(3),
    l varchar(2),
    l1 varchar(50),
    sup double precision DEFAULT 0,
    lung double precision DEFAULT 0,
    evento varchar(1),
    spec_event varchar(255),
    desc_eve text,
    intervento varchar(2),
    spec_inter varchar(255),
    m_prev double precision DEFAULT 0,
    m_prel double precision DEFAULT 0,
    desc_modi text,
    desc_effet text,
    id_gesfore varchar(5),
    intervento_arbus varchar(2),
    intervento_specia varchar(2),
    intervento_viabil varchar(2),
    tipo_inter varchar(1),
    objectid int(11) NOT NULL,
    id_av_n varchar(20)
) ;

CREATE TABLE schede_x (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    tipo_ril varchar(1) NOT NULL,
    data timestamp NOT NULL,
    id_av varchar(12),
    objectid int(11) NOT NULL
) ;

CREATE TABLE senescen (
    codice varchar(1) NOT NULL,
    descriz varchar(19)
) ;

CREATE TABLE sesto (
    codice varchar(1) NOT NULL,
    descriz varchar(10)
) ;

CREATE TABLE si_no (
    codice varchar(1) NOT NULL,
    valore varchar(2)
) ;

CREATE TABLE si_no_num (
    codice varchar(1),
    valore varchar(2)
) ;

CREATE TABLE sistema (
    codice varchar(2) NOT NULL,
    descriz varchar(60)
) ;

CREATE TABLE sistema_sug (
    codice varchar(2),
    descriz varchar(60)
) ;

CREATE TABLE spatial_ref_sys (
    srid int(11) NOT NULL,
    auth_name text,
    auth_srid int(11),
    srtext text,
    proj4text text
) ;

CREATE TABLE specie_p (
    codice varchar(1) NOT NULL,
    descriz varchar(7)
) ;

CREATE TABLE stime_b1 (
    proprieta varchar(5) NOT NULL,
    cod_part varchar(5) NOT NULL,
    cod_fo varchar(2) DEFAULT ' 1',
    cod_coltu varchar(3) NOT NULL,
    cod_coper varchar(1),
    massa_tot int(11),
    id_av varchar(12)
) ;

CREATE TABLE strati (
    codice varchar(1) NOT NULL,
    descriz varchar(5)
) ;

CREATE TABLE strati2 (
    codice varchar(1) NOT NULL,
    descriz varchar(5)
) ;

CREATE TABLE struttu (
    codice int(11) NOT NULL,
    descriz varchar(70),
    regione varchar(2)
) ;

CREATE TABLE struttu_sug (
    codice varchar(1) NOT NULL,
    descriz varchar(70)
) ;

CREATE TABLE struttu_vert (
    codice varchar(1) NOT NULL,
    descriz varchar(11)
) ;

CREATE TABLE tipi_for (
    proprieta varchar(3),
    cod_part varchar(5),
    cod_fo varchar(2) DEFAULT ' 1',
    tipo varchar(3),
    objectid int(11) NOT NULL
) ;

CREATE TABLE tipi_tav (
    codice varchar(1),
    descrizion varchar(15)
) ;

CREATE TABLE tipo_imp (
    codice varchar(1) NOT NULL,
    descrizion varchar(19)
) ;

CREATE TABLE tipo_int_sug (
    codice varchar(1) NOT NULL,
    descrizion varchar(138)
) ;

CREATE TABLE tipo_stampa (
    codice varchar(1),
    descrizion varchar(15)
) ;

CREATE TABLE tipo_tavola (
    codice varchar(1) NOT NULL,
    tipo_tavola varchar(50)
) ;

CREATE TABLE tipologi (
    codice varchar(3),
    descriz varchar(20),
    necesssita varchar(1)
) ;

CREATE TABLE transit (
    codice varchar(1),
    descrizion varchar(7)
) ;

CREATE TABLE transita (
    codice varchar(1) NOT NULL,
    descriz varchar(7)
) ;

CREATE TABLE urg_via (
    codice varchar(1),
    descriz varchar(27)
) ;

CREATE TABLE urgenza (
    codice varchar(1) NOT NULL,
    descriz varchar(27)
) ;

CREATE TABLE `user` (
    id int(11) NOT NULL,
    username varchar(255),
    password varchar(255),
    active bool,
    confirmed bool,
    creation_datetime timestamp,
    lastlogin_datetime timestamp,
    is_admin bool,
    rule varchar(255),
    profile_id int(11),
    confirmation_code varchar(255),
    message text
) ;

CREATE TABLE user_diz_regioni (
    user_id int(11) NOT NULL,
    diz_regioni_codice varchar(2) NOT NULL,
    `write` bool
) ;

CREATE TABLE user_propriet (
    user_id int(11) NOT NULL,
    propriet_codice varchar(5) NOT NULL,
    `write` bit(1)
) ;

CREATE TABLE usosuol2 (
    codice varchar(1) NOT NULL,
    descriz varchar(21)
) ;

CREATE TABLE usosuolo (
    codice varchar(2) NOT NULL,
    descriz varchar(21)
) ;

CREATE TABLE valori (
    codice varchar(3),
    descriz varchar(70)
) ;

CREATE TABLE var_sist (
    scelta_periodo bool DEFAULT 0,
    periodo varchar(1),
    annulla_operazione bool DEFAULT 0
) ;

CREATE TABLE vig_arb_cas (
    codice varchar(1) NOT NULL,
    descriz varchar(55)
) ;

CREATE TABLE vigoria (
    codice int(11) NOT NULL,
    descriz varchar(55)
) ;

ALTER TABLE abbevera
    ADD CONSTRAINT abbevera_pkey PRIMARY KEY (codice);
ALTER TABLE acc_stra
    ADD CONSTRAINT acc_stra_pkey PRIMARY KEY (codice);
ALTER TABLE accesso
    ADD CONSTRAINT accesso_pkey PRIMARY KEY (codice);
ALTER TABLE an_id_co
    ADD CONSTRAINT an_id_co_pkey PRIMARY KEY (proprieta, cod_part, cod_fo);
ALTER TABLE arb_colt
    ADD CONSTRAINT arb_colt_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE arboree2
    ADD CONSTRAINT arboree2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE arboree4a
    ADD CONSTRAINT arboree4a_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE arboree4b
    ADD CONSTRAINT arboree4b_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE arboree
    ADD CONSTRAINT arboree_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE arbusti2
    ADD CONSTRAINT arbusti2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE arbusti3
    ADD CONSTRAINT arbusti3_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE arbusti
    ADD CONSTRAINT arbusti_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE archivi
    ADD CONSTRAINT archivi_pkey1 PRIMARY KEY (archivio, nomecampo);
ALTER TABLE car_nove
    ADD CONSTRAINT car_nove_pkey PRIMARY KEY (codice);
ALTER TABLE carico
    ADD CONSTRAINT carico_pkey PRIMARY KEY (codice);
ALTER TABLE catasto
    ADD CONSTRAINT catasto_pkey PRIMARY KEY (objectid);
ALTER TABLE clas_pro
    ADD CONSTRAINT clas_pro_pkey PRIMARY KEY (codice);
ALTER TABLE clas_via
    ADD CONSTRAINT clas_via_pkey PRIMARY KEY (codice);
ALTER TABLE coltcast
    ADD CONSTRAINT coltcast_pkey PRIMARY KEY (codice);
ALTER TABLE comp_arb
    ADD CONSTRAINT comp_arb_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE compcoti
    ADD CONSTRAINT compcoti_pkey PRIMARY KEY (codice);
ALTER TABLE compo
    ADD CONSTRAINT compo_pkey PRIMARY KEY (codice);
ALTER TABLE compresa
    ADD CONSTRAINT compresa_pkey PRIMARY KEY (objectid);
ALTER TABLE comuni
    ADD CONSTRAINT comuni_pkey PRIMARY KEY (objectid);
ALTER TABLE comunita
    ADD CONSTRAINT comunita_pkey PRIMARY KEY (regione, codice);
ALTER TABLE denscoti
    ADD CONSTRAINT denscoti_pkey PRIMARY KEY (codice);
ALTER TABLE densita3
    ADD CONSTRAINT densita3_pkey PRIMARY KEY (codice);
ALTER TABLE densita
    ADD CONSTRAINT densita_pkey PRIMARY KEY (codice);
ALTER TABLE descr_pa
    ADD CONSTRAINT descr_pa_pkey PRIMARY KEY (proprieta, cod_part);
ALTER TABLE disph2o
    ADD CONSTRAINT disph2o_pkey PRIMARY KEY (codice);
ALTER TABLE diz_arbo
    ADD CONSTRAINT diz_arbo_pkey PRIMARY KEY (cod_coltu);
ALTER TABLE diz_curve
    ADD CONSTRAINT diz_curve_pkey PRIMARY KEY (cod_curva);
ALTER TABLE diz_erba
    ADD CONSTRAINT diz_erba_pkey PRIMARY KEY (cod_coltu);
ALTER TABLE diz_fung
    ADD CONSTRAINT diz_fung_pkey PRIMARY KEY (cod_coltu);
ALTER TABLE diz_regioni
    ADD CONSTRAINT diz_regioni_pkey PRIMARY KEY (codice);
ALTER TABLE diz_tavole2
    ADD CONSTRAINT diz_tavole2_pkey PRIMARY KEY (codice, tariffa, d, h);
ALTER TABLE diz_tavole3
    ADD CONSTRAINT diz_tavole3_pkey PRIMARY KEY (codice, tariffa, d, h);
ALTER TABLE diz_tavole4
    ADD CONSTRAINT diz_tavole4_pkey PRIMARY KEY (codice);
ALTER TABLE diz_tavole5
    ADD CONSTRAINT diz_tavole5_pkey PRIMARY KEY (codice);
ALTER TABLE diz_tavole
    ADD CONSTRAINT diz_tavole_pkey PRIMARY KEY (codice);
ALTER TABLE diz_tipi
    ADD CONSTRAINT diz_tipi_pkey PRIMARY KEY (regione, codice);
ALTER TABLE diz_tiporil
    ADD CONSTRAINT diz_tiporil_pkey PRIMARY KEY (codice);
ALTER TABLE elab_dend2
    ADD CONSTRAINT elab_dend2_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie);
ALTER TABLE elab_dend3
    ADD CONSTRAINT elab_dend3_pkey PRIMARY KEY (proprieta, cod_elab, cod_part, cod_fo, tipo_ril, data);
ALTER TABLE elab_dend4
    ADD CONSTRAINT elab_dend4_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie, specie);
ALTER TABLE elab_dend5
    ADD CONSTRAINT elab_dend5_pkey PRIMARY KEY (proprieta, cod_elab, cod_part, cod_fo, tipo_ril, data);
ALTER TABLE elab_dend
    ADD CONSTRAINT elab_dend_pkey PRIMARY KEY (proprieta, cod_elab);
ALTER TABLE erbacee2
    ADD CONSTRAINT erbacee2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE erbacee3
    ADD CONSTRAINT erbacee3_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE erbacee4
    ADD CONSTRAINT erbacee4_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE erbacee
    ADD CONSTRAINT erbacee_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE espo
    ADD CONSTRAINT espo_pkey PRIMARY KEY (codice);
ALTER TABLE fondo
    ADD CONSTRAINT fondo_pkey PRIMARY KEY (codice);
ALTER TABLE fruitori
    ADD CONSTRAINT fruitori_pkey PRIMARY KEY (codice);
ALTER TABLE funzion2
    ADD CONSTRAINT funzion2_pkey PRIMARY KEY (codice);
ALTER TABLE funzione
    ADD CONSTRAINT funzione_pkey PRIMARY KEY (codice);
ALTER TABLE geometry_columns
    ADD CONSTRAINT geometry_columns_pk PRIMARY KEY (f_table_catalog, f_table_schema, f_table_name, f_geometry_column);
ALTER TABLE infestan
    ADD CONSTRAINT infestan_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE infr_past
    ADD CONSTRAINT infr_past_pkey PRIMARY KEY (codice);
ALTER TABLE int_via
    ADD CONSTRAINT int_via_pkey PRIMARY KEY (codice);
ALTER TABLE leg_note
    ADD CONSTRAINT leg_note_pkey PRIMARY KEY (objectid);
ALTER TABLE log
    ADD CONSTRAINT log_pkey PRIMARY KEY (id);
ALTER TABLE manutenz
    ADD CONSTRAINT manutenz_pkey PRIMARY KEY (codice);
ALTER TABLE matrici
    ADD CONSTRAINT matrici_pkey PRIMARY KEY (codice);
ALTER TABLE meccaniz
    ADD CONSTRAINT meccaniz_pkey PRIMARY KEY (codice);
ALTER TABLE mod_pasc
    ADD CONSTRAINT mod_pasc_pkey PRIMARY KEY (codice);
ALTER TABLE moti_macchia
    ADD CONSTRAINT moti_macchia_pkey PRIMARY KEY (codice);
ALTER TABLE nomi_arc
    ADD CONSTRAINT nomi_arc_pkey PRIMARY KEY (nome);
ALTER TABLE note_a
    ADD CONSTRAINT note_a_pkey PRIMARY KEY (objectid);
ALTER TABLE note_b2
    ADD CONSTRAINT note_b2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_nota);
ALTER TABLE note_b3
    ADD CONSTRAINT note_b3_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_nota);
ALTER TABLE note_b4
    ADD CONSTRAINT note_b4_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_nota);
ALTER TABLE note_b
    ADD CONSTRAINT note_b_pkey PRIMARY KEY (objectid);
ALTER TABLE note_n
    ADD CONSTRAINT note_n_pkey PRIMARY KEY (objectid);
ALTER TABLE novell2
    ADD CONSTRAINT novell2_pkey PRIMARY KEY (codice);
ALTER TABLE novell
    ADD CONSTRAINT novell_pkey PRIMARY KEY (codice);
ALTER TABLE origine
    ADD CONSTRAINT origine_pkey PRIMARY KEY (codice);
ALTER TABLE ostacoli
    ADD CONSTRAINT ostacoli_pkey PRIMARY KEY (codice);
ALTER TABLE partcomp
    ADD CONSTRAINT partcomp_pkey PRIMARY KEY (objectid);
ALTER TABLE per_arbo
    ADD CONSTRAINT per_arbo_codice PRIMARY KEY (codice);
ALTER TABLE pianota
    ADD CONSTRAINT pianota_pkey PRIMARY KEY (proprieta, cod_part, anno);
ALTER TABLE piu1_3
    ADD CONSTRAINT piu1_3_pkey PRIMARY KEY (codice);
ALTER TABLE piu2_3
    ADD CONSTRAINT piu2_3_pkey PRIMARY KEY (codice);
ALTER TABLE pollmatr
    ADD CONSTRAINT pollmatr_pkey PRIMARY KEY (codice);
ALTER TABLE popolame
    ADD CONSTRAINT popolame_pkey PRIMARY KEY (codice);
ALTER TABLE posfisio
    ADD CONSTRAINT posfisio_pkey PRIMARY KEY (codice);
ALTER TABLE prep_terr
    ADD CONSTRAINT prep_terr_pkey PRIMARY KEY (codice);
ALTER TABLE pres_ass
    ADD CONSTRAINT pres_ass_pkey PRIMARY KEY (codice);
ALTER TABLE prescri2
    ADD CONSTRAINT prescri2_pkey PRIMARY KEY (codice);
ALTER TABLE prescri3
    ADD CONSTRAINT prescri3_pkey PRIMARY KEY (codice);
ALTER TABLE prescri_via
    ADD CONSTRAINT prescri_via_pkey PRIMARY KEY (codice);
ALTER TABLE prescriz_globale
    ADD CONSTRAINT prescriz_globale_pkey PRIMARY KEY (codice);
ALTER TABLE prescriz
    ADD CONSTRAINT prescriz_pkey PRIMARY KEY (codice);
ALTER TABLE problemi_a
    ADD CONSTRAINT problemi_a_pkey PRIMARY KEY (proprieta, cod_part, tabella, campo);
ALTER TABLE problemi_b1
    ADD CONSTRAINT problemi_b1_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, campo, tabella);
ALTER TABLE problemi_b2
    ADD CONSTRAINT problemi_b2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, campo, tabella);
ALTER TABLE problemi_b3
    ADD CONSTRAINT problemi_b3_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, campo, tabella);
ALTER TABLE problemi_b4
    ADD CONSTRAINT problemi_b4_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, campo, tabella);
ALTER TABLE profile
    ADD CONSTRAINT profile_pkey PRIMARY KEY (id);
ALTER TABLE propriet
    ADD CONSTRAINT propriet_pkey PRIMARY KEY (codice);
ALTER TABLE province
    ADD CONSTRAINT province_pkey PRIMARY KEY (provincia);
ALTER TABLE qual_pro
    ADD CONSTRAINT qual_pro_pkey PRIMARY KEY (codice);
ALTER TABLE qual_via
    ADD CONSTRAINT qual_via_pkey PRIMARY KEY (codice);
ALTER TABLE rilevato
    ADD CONSTRAINT rilevato_pkey PRIMARY KEY (codice);
ALTER TABLE rinnov
    ADD CONSTRAINT rinnov_pkey PRIMARY KEY (codice);
ALTER TABLE rinnovaz
    ADD CONSTRAINT rinnovaz_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE ris_dend1
    ADD CONSTRAINT ris_dend1_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie);
ALTER TABLE ris_dend2
    ADD CONSTRAINT ris_dend2_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie, conta);
ALTER TABLE ris_dend3
    ADD CONSTRAINT ris_dend3_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie, specie, d);
ALTER TABLE sched_b1
    ADD CONSTRAINT sched_b1_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_b2
    ADD CONSTRAINT sched_b2_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_b3
    ADD CONSTRAINT sched_b3_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_b4
    ADD CONSTRAINT sched_b4_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_c1
    ADD CONSTRAINT sched_c1_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_c2
    ADD CONSTRAINT sched_c2_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_d1
    ADD CONSTRAINT sched_d1_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_e1
    ADD CONSTRAINT sched_e1_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_f1
    ADD CONSTRAINT sched_f1_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_f2
    ADD CONSTRAINT sched_f2_pkey PRIMARY KEY (objectid);
ALTER TABLE sched_l1
    ADD CONSTRAINT sched_l1_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, num_alb, elemento, h_sez);
ALTER TABLE sched_l1b
    ADD CONSTRAINT sched_l1b_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, num_alb, elemento);
ALTER TABLE schede_a
    ADD CONSTRAINT schede_a_pkey PRIMARY KEY (objectid);
ALTER TABLE schede_b
    ADD CONSTRAINT schede_b_pkey PRIMARY KEY (objectid);
ALTER TABLE schede_c
    ADD CONSTRAINT schede_c_pkey PRIMARY KEY (objectid);
ALTER TABLE schede_d
    ADD CONSTRAINT schede_d_pkey PRIMARY KEY (objectid);
ALTER TABLE schede_e
    ADD CONSTRAINT schede_e_pkey PRIMARY KEY (objectid);
ALTER TABLE schede_f
    ADD CONSTRAINT schede_f_pkey PRIMARY KEY (objectid);
ALTER TABLE schede_g1
    ADD CONSTRAINT schede_g1_pkey PRIMARY KEY (objectid);
ALTER TABLE schede_g
    ADD CONSTRAINT schede_g_pkey PRIMARY KEY (objectid);
ALTER TABLE schede_n
    ADD CONSTRAINT schede_n_pkey PRIMARY KEY (objectid);
ALTER TABLE schede_x
    ADD CONSTRAINT schede_x_pkey PRIMARY KEY (objectid);
ALTER TABLE senescen
    ADD CONSTRAINT senescen_pkey PRIMARY KEY (codice);
ALTER TABLE sesto
    ADD CONSTRAINT sesto_pkey PRIMARY KEY (codice);
ALTER TABLE si_no
    ADD CONSTRAINT si_no_pkey PRIMARY KEY (codice);
ALTER TABLE sistema
    ADD CONSTRAINT sistema_pkey PRIMARY KEY (codice);
ALTER TABLE spatial_ref_sys
    ADD CONSTRAINT spatial_ref_sys_pkey PRIMARY KEY (srid);
ALTER TABLE specie_p
    ADD CONSTRAINT specie_p_pkey PRIMARY KEY (codice);
ALTER TABLE stime_b1
    ADD CONSTRAINT stime_b1_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);
ALTER TABLE strati2
    ADD CONSTRAINT strati2_pkey PRIMARY KEY (codice);
ALTER TABLE strati
    ADD CONSTRAINT strati_pkey PRIMARY KEY (codice);
ALTER TABLE struttu
    ADD CONSTRAINT struttu_pkey PRIMARY KEY (codice);
ALTER TABLE struttu_sug
    ADD CONSTRAINT struttu_sug_pkey PRIMARY KEY (codice);
ALTER TABLE struttu_vert
    ADD CONSTRAINT struttu_vert_pkey PRIMARY KEY (codice);
ALTER TABLE tipo_imp
    ADD CONSTRAINT tipo_imp_pkey PRIMARY KEY (codice);
ALTER TABLE tipo_int_sug
    ADD CONSTRAINT tipo_int_sug_pkey PRIMARY KEY (codice);
ALTER TABLE tipo_tavola
    ADD CONSTRAINT tipo_tavola_pkey PRIMARY KEY (codice);
ALTER TABLE transita
    ADD CONSTRAINT transita_pkey PRIMARY KEY (codice);
ALTER TABLE urgenza
    ADD CONSTRAINT urgenza_pkey PRIMARY KEY (codice);
ALTER TABLE user_diz_regioni
    ADD CONSTRAINT user_id_iz_regioni PRIMARY KEY (user_id, diz_regioni_codice);
ALTER TABLE user_propriet
    ADD CONSTRAINT user_id_propriet_codice PRIMARY KEY (user_id, propriet_codice);
ALTER TABLE `user`
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);
ALTER TABLE usosuol2
    ADD CONSTRAINT usosuol2_pkey PRIMARY KEY (codice);
ALTER TABLE usosuolo
    ADD CONSTRAINT usosuolo_pri_key PRIMARY KEY (codice);
ALTER TABLE vig_arb_cas
    ADD CONSTRAINT vig_arb_cas_pkey PRIMARY KEY (codice);
ALTER TABLE vigoria
    ADD CONSTRAINT vigoria_pkey PRIMARY KEY (codice);
ALTER TABLE `arboree` ADD INDEX ( objectid ) ;
ALTER TABLE `leg_note` ADD INDEX ( archivio ) ;
ALTER TABLE `arboree` ADD INDEX ( cod_coltu ) ;
ALTER TABLE `arboree` ADD INDEX ( cod_coper ) ;
ALTER TABLE `schede_a` ADD INDEX ( cod_part ) ;
ALTER TABLE `note_a` ADD INDEX ( proprieta, cod_part ) ;
ALTER TABLE `comuni` ADD INDEX ( codice ) ;
ALTER TABLE `schede_a` ADD INDEX ( codiope ) ;
ALTER TABLE `log` ADD INDEX ( creation_datetime ) ;
ALTER TABLE `comuni` ADD INDEX ( descriz ) ;
ALTER TABLE `diz_tavole` ADD INDEX ( autore ) ;
ALTER TABLE `diz_tavole` ADD INDEX ( descriz ) ;
ALTER TABLE `diz_tipi` ADD INDEX ( descriz ) ;
ALTER TABLE `schede_g` ADD INDEX ( fatt_num ) ;
ALTER TABLE `arbusti` ADD INDEX ( proprieta, cod_part, cod_fo ) ;
ALTER TABLE `catasto` ADD INDEX ( proprieta, cod_part ) ;
ALTER TABLE `erbacee` ADD INDEX ( proprieta, cod_part, cod_fo ) ;
ALTER TABLE `catasto` ADD INDEX ( proprieta, cod_part ) ;
ALTER TABLE `note_b` ADD INDEX ( proprieta, cod_part, cod_fo ) ;
ALTER TABLE `partcomp` ADD INDEX ( compresa, proprieta ) ;
ALTER TABLE `partcomp` ADD INDEX ( proprieta, cod_part ) ;
ALTER TABLE `problemi_b1` ADD INDEX ( proprieta, cod_part, cod_fo ) ;
ALTER TABLE `sched_b1` ADD INDEX ( proprieta, cod_part, cod_fo ) ;
ALTER TABLE `schede_b` ADD INDEX ( proprieta, cod_part ) ;
ALTER TABLE `schede_x` ADD INDEX ( proprieta, cod_part, cod_fo ) ;
ALTER TABLE `stime_b1` ADD INDEX ( proprieta, cod_part, cod_fo ) ;
ALTER TABLE `comuni` ADD INDEX ( id_av_comuni ) ;
ALTER TABLE `an_id_co` ADD INDEX ( id_av ) ;
ALTER TABLE `elab_dend` ADD INDEX ( id_av_dend ) ;
ALTER TABLE `elab_dend2` ADD INDEX ( id_av_dend2 ) ;
ALTER TABLE `elab_dend3` ADD INDEX ( id_av_dend ) ;
ALTER TABLE `elab_dend4` ADD INDEX ( id_av_dend2 ) ;
ALTER TABLE `note_b2` ADD INDEX ( id_av ) ;
ALTER TABLE `note_b3` ADD INDEX ( id_av ) ;
ALTER TABLE `note_n` ADD INDEX ( id_av_n ) ;
ALTER TABLE `problemi_b1` ADD INDEX ( id_av ) ;
ALTER TABLE `problemi_b2` ADD INDEX ( id_av ) ;
ALTER TABLE `problemi_b3` ADD INDEX ( id_av ) ;
ALTER TABLE `province` ADD INDEX ( id_av_comuni ) ;
ALTER TABLE `ris_dend1` ADD INDEX ( id_av_dend2 ) ;
ALTER TABLE `ris_dend2` ADD INDEX ( id_av_dend2 ) ;
ALTER TABLE `sched_e1` ADD INDEX ( id_av_e ) ;
ALTER TABLE `sched_l1` ADD INDEX ( id_av_l1 ) ;
ALTER TABLE `sched_l1b` ADD INDEX ( id_av_l1 ) ;
ALTER TABLE `sched_l1b` ADD INDEX ( id_av_l1b ) ;
ALTER TABLE `schede_e` ADD INDEX ( id_av_e ) ;
ALTER TABLE `schede_n` ADD INDEX ( id_av_n ) ;
ALTER TABLE `sched_d1` ADD INDEX ( conta ) ;
ALTER TABLE `arb_colt` ADD INDEX ( id_av ) ;
ALTER TABLE `compresa` ADD INDEX ( id_av_x_join ) ;
ALTER TABLE `schede_n` ADD INDEX ( id_gesfore ) ;
ALTER TABLE `interventi_localizzati_viabilita_shape_index` ADD INDEX ( indexedobjectid ) ;
ALTER TABLE `leg_note` ADD INDEX ( intesta ) ;
ALTER TABLE `interventi_localizzati_viabilita_shape_index` ADD INDEX ( maxgx ) ;
ALTER TABLE `interventi_localizzati_viabilita_shape_index` ADD INDEX ( maxgy ) ;
ALTER TABLE `interventi_localizzati_viabilita_shape_index` ADD INDEX ( mingx ) ;
ALTER TABLE `interventi_localizzati_viabilita_shape_index` ADD INDEX ( mingy ) ;
ALTER TABLE `diz_arbo` ADD INDEX ( nome_itali ) ;
ALTER TABLE `diz_arbo` ADD INDEX ( nome_scien ) ;
ALTER TABLE `leg_note` ADD INDEX ( nomecampo ) ;
ALTER TABLE `sched_l1b` ADD INDEX ( num_alb ) ;
ALTER TABLE `ris_dend1` ADD INDEX ( num_oss_h ) ;
ALTER TABLE `sched_b2` ADD INDEX ( num_piante ) ;
ALTER TABLE `log` ADD INDEX ( objectid ) ;
ALTER TABLE `profile` ADD INDEX ( first_name ) ;
ALTER TABLE `profile` ADD INDEX ( last_name ) ;
ALTER TABLE `propriet` ADD INDEX ( descrizion ) ;
ALTER TABLE `propriet` ADD INDEX ( regione ) ;
ALTER TABLE `catasto` ADD INDEX ( proprieta, cod_part ) ;
ALTER TABLE `comuni` ADD INDEX ( provincia ) ;
ALTER TABLE `province` ADD INDEX ( regione ) ;
ALTER TABLE `ris_dend2` ADD INDEX ( proprieta ) ;
ALTER TABLE `sched_b1` ADD INDEX ( objectid ) ;
ALTER TABLE `sched_d1` ADD INDEX ( specie ) ;
ALTER TABLE `struttu` ADD INDEX ( descriz ) ;
ALTER TABLE `schede_a` ADD INDEX ( toponimo ) ;
ALTER TABLE `log` ADD INDEX ( user_id ) ;
ALTER TABLE `user` ADD INDEX ( password ) ;
ALTER TABLE `schede_b` ADD INDEX ( u ) ;
