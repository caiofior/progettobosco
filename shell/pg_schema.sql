--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: addauth(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addauth(text) RETURNS boolean
    LANGUAGE plpgsql
    AS $_$ 
DECLARE
	lockid alias for $1;
	okay boolean;
	myrec record;
BEGIN
	-- check to see if table exists
	--  if not, CREATE TEMP TABLE mylock (transid xid, lockcode text)
	okay := 'f';
	FOR myrec IN SELECT * FROM pg_class WHERE relname = 'temp_lock_have_table' LOOP
		okay := 't';
	END LOOP; 
	IF (okay <> 't') THEN 
		CREATE TEMP TABLE temp_lock_have_table (transid xid, lockcode text);
			-- this will only work from pgsql7.4 up
			-- ON COMMIT DELETE ROWS;
	END IF;

	--  INSERT INTO mylock VALUES ( $1)
--	EXECUTE 'INSERT INTO temp_lock_have_table VALUES ( '||
--		quote_literal(getTransactionID()) || ',' ||
--		quote_literal(lockid) ||')';

	INSERT INTO temp_lock_have_table VALUES (getTransactionID(), lockid);

	RETURN true::boolean;
END;
$_$;


ALTER FUNCTION public.addauth(text) OWNER TO postgres;

--
-- Name: FUNCTION addauth(text); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION addauth(text) IS 'args: auth_token - Add an authorization token to be used in current transaction.';


--
-- Name: addgeometrycolumn(character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('','',$1,$2,$3,$4,$5) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- Name: FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION addgeometrycolumn(character varying, character varying, integer, character varying, integer) IS 'args: table_name, column_name, srid, type, dimension - Adds a geometry column to an existing table of attributes.';


--
-- Name: addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STABLE STRICT
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT AddGeometryColumn('',$1,$2,$3,$4,$5,$6) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- Name: FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, integer, character varying, integer) IS 'args: schema_name, table_name, column_name, srid, type, dimension - Adds a geometry column to an existing table of attributes.';


--
-- Name: addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	new_srid alias for $5;
	new_type alias for $6;
	new_dim alias for $7;
	rec RECORD;
	sr varchar;
	real_schema name;
	sql text;

BEGIN

	-- Verify geometry type
	IF ( NOT ( (new_type = 'GEOMETRY') OR
			   (new_type = 'GEOMETRYCOLLECTION') OR
			   (new_type = 'POINT') OR
			   (new_type = 'MULTIPOINT') OR
			   (new_type = 'POLYGON') OR
			   (new_type = 'MULTIPOLYGON') OR
			   (new_type = 'LINESTRING') OR
			   (new_type = 'MULTILINESTRING') OR
			   (new_type = 'GEOMETRYCOLLECTIONM') OR
			   (new_type = 'POINTM') OR
			   (new_type = 'MULTIPOINTM') OR
			   (new_type = 'POLYGONM') OR
			   (new_type = 'MULTIPOLYGONM') OR
			   (new_type = 'LINESTRINGM') OR
			   (new_type = 'MULTILINESTRINGM') OR
			   (new_type = 'CIRCULARSTRING') OR
			   (new_type = 'CIRCULARSTRINGM') OR
			   (new_type = 'COMPOUNDCURVE') OR
			   (new_type = 'COMPOUNDCURVEM') OR
			   (new_type = 'CURVEPOLYGON') OR
			   (new_type = 'CURVEPOLYGONM') OR
			   (new_type = 'MULTICURVE') OR
			   (new_type = 'MULTICURVEM') OR
			   (new_type = 'MULTISURFACE') OR
			   (new_type = 'MULTISURFACEM')) )
	THEN
		RAISE EXCEPTION 'Invalid type name - valid ones are:
	POINT, MULTIPOINT,
	LINESTRING, MULTILINESTRING,
	POLYGON, MULTIPOLYGON,
	CIRCULARSTRING, COMPOUNDCURVE, MULTICURVE,
	CURVEPOLYGON, MULTISURFACE,
	GEOMETRY, GEOMETRYCOLLECTION,
	POINTM, MULTIPOINTM,
	LINESTRINGM, MULTILINESTRINGM,
	POLYGONM, MULTIPOLYGONM,
	CIRCULARSTRINGM, COMPOUNDCURVEM, MULTICURVEM
	CURVEPOLYGONM, MULTISURFACEM,
	or GEOMETRYCOLLECTIONM';
		RETURN 'fail';
	END IF;


	-- Verify dimension
	IF ( (new_dim >4) OR (new_dim <0) ) THEN
		RAISE EXCEPTION 'invalid dimension';
		RETURN 'fail';
	END IF;

	IF ( (new_type LIKE '%M') AND (new_dim!=3) ) THEN
		RAISE EXCEPTION 'TypeM needs 3 dimensions';
		RETURN 'fail';
	END IF;


	-- Verify SRID
	IF ( new_srid != -1 ) THEN
		SELECT SRID INTO sr FROM spatial_ref_sys WHERE SRID = new_srid;
		IF NOT FOUND THEN
			RAISE EXCEPTION 'AddGeometryColumns() - invalid SRID';
			RETURN 'fail';
		END IF;
	END IF;


	-- Verify schema
	IF ( schema_name IS NOT NULL AND schema_name != '' ) THEN
		sql := 'SELECT nspname FROM pg_namespace ' ||
			'WHERE text(nspname) = ' || quote_literal(schema_name) ||
			'LIMIT 1';
		RAISE DEBUG '%', sql;
		EXECUTE sql INTO real_schema;

		IF ( real_schema IS NULL ) THEN
			RAISE EXCEPTION 'Schema % is not a valid schemaname', quote_literal(schema_name);
			RETURN 'fail';
		END IF;
	END IF;

	IF ( real_schema IS NULL ) THEN
		RAISE DEBUG 'Detecting schema';
		sql := 'SELECT n.nspname AS schemaname ' ||
			'FROM pg_catalog.pg_class c ' ||
			  'JOIN pg_catalog.pg_namespace n ON n.oid = c.relnamespace ' ||
			'WHERE c.relkind = ' || quote_literal('r') ||
			' AND n.nspname NOT IN (' || quote_literal('pg_catalog') || ', ' || quote_literal('pg_toast') || ')' ||
			' AND pg_catalog.pg_table_is_visible(c.oid)' ||
			' AND c.relname = ' || quote_literal(table_name);
		RAISE DEBUG '%', sql;
		EXECUTE sql INTO real_schema;

		IF ( real_schema IS NULL ) THEN
			RAISE EXCEPTION 'Table % does not occur in the search_path', quote_literal(table_name);
			RETURN 'fail';
		END IF;
	END IF;


	-- Add geometry column to table
	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD COLUMN ' || quote_ident(column_name) ||
		' geometry ';
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Delete stale record in geometry_columns (if any)
	sql := 'DELETE FROM geometry_columns WHERE
		f_table_catalog = ' || quote_literal('') ||
		' AND f_table_schema = ' ||
		quote_literal(real_schema) ||
		' AND f_table_name = ' || quote_literal(table_name) ||
		' AND f_geometry_column = ' || quote_literal(column_name);
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Add record in geometry_columns
	sql := 'INSERT INTO geometry_columns (f_table_catalog,f_table_schema,f_table_name,' ||
										  'f_geometry_column,coord_dimension,srid,type)' ||
		' VALUES (' ||
		quote_literal('') || ',' ||
		quote_literal(real_schema) || ',' ||
		quote_literal(table_name) || ',' ||
		quote_literal(column_name) || ',' ||
		new_dim::text || ',' ||
		new_srid::text || ',' ||
		quote_literal(new_type) || ')';
	RAISE DEBUG '%', sql;
	EXECUTE sql;


	-- Add table CHECKs
	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_srid_' || column_name)
		|| ' CHECK (ST_SRID(' || quote_ident(column_name) ||
		') = ' || new_srid::text || ')' ;
	RAISE DEBUG '%', sql;
	EXECUTE sql;

	sql := 'ALTER TABLE ' ||
		quote_ident(real_schema) || '.' || quote_ident(table_name)
		|| ' ADD CONSTRAINT '
		|| quote_ident('enforce_dims_' || column_name)
		|| ' CHECK (ST_NDims(' || quote_ident(column_name) ||
		') = ' || new_dim::text || ')' ;
	RAISE DEBUG '%', sql;
	EXECUTE sql;

	IF ( NOT (new_type = 'GEOMETRY')) THEN
		sql := 'ALTER TABLE ' ||
			quote_ident(real_schema) || '.' || quote_ident(table_name) || ' ADD CONSTRAINT ' ||
			quote_ident('enforce_geotype_' || column_name) ||
			' CHECK (GeometryType(' ||
			quote_ident(column_name) || ')=' ||
			quote_literal(new_type) || ' OR (' ||
			quote_ident(column_name) || ') is null)';
		RAISE DEBUG '%', sql;
		EXECUTE sql;
	END IF;

	RETURN
		real_schema || '.' ||
		table_name || '.' || column_name ||
		' SRID:' || new_srid::text ||
		' TYPE:' || new_type ||
		' DIMS:' || new_dim::text || ' ';
END;
$_$;


ALTER FUNCTION public.addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) OWNER TO postgres;

--
-- Name: FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION addgeometrycolumn(character varying, character varying, character varying, character varying, integer, character varying, integer) IS 'args: catalog_name, schema_name, table_name, column_name, srid, type, dimension - Adds a geometry column to an existing table of attributes.';


--
-- Name: checkauth(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION checkauth(text, text) RETURNS integer
    LANGUAGE sql
    AS $_$ SELECT CheckAuth('', $1, $2) $_$;


ALTER FUNCTION public.checkauth(text, text) OWNER TO postgres;

--
-- Name: FUNCTION checkauth(text, text); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION checkauth(text, text) IS 'args: a_table_name, a_key_column_name - Creates trigger on a table to prevent/allow updates and deletes of rows based on authorization token.';


--
-- Name: checkauth(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION checkauth(text, text, text) RETURNS integer
    LANGUAGE plpgsql
    AS $_$ 
DECLARE
	schema text;
BEGIN
	IF NOT LongTransactionsEnabled() THEN
		RAISE EXCEPTION 'Long transaction support disabled, use EnableLongTransaction() to enable.';
	END IF;

	if ( $1 != '' ) THEN
		schema = $1;
	ELSE
		SELECT current_schema() into schema;
	END IF;

	-- TODO: check for an already existing trigger ?

	EXECUTE 'CREATE TRIGGER check_auth BEFORE UPDATE OR DELETE ON ' 
		|| quote_ident(schema) || '.' || quote_ident($2)
		||' FOR EACH ROW EXECUTE PROCEDURE CheckAuthTrigger('
		|| quote_literal($3) || ')';

	RETURN 0;
END;
$_$;


ALTER FUNCTION public.checkauth(text, text, text) OWNER TO postgres;

--
-- Name: FUNCTION checkauth(text, text, text); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION checkauth(text, text, text) IS 'args: a_schema_name, a_table_name, a_key_column_name - Creates trigger on a table to prevent/allow updates and deletes of rows based on authorization token.';


--
-- Name: disablelongtransactions(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION disablelongtransactions() RETURNS text
    LANGUAGE plpgsql
    AS $$ 
DECLARE
	rec RECORD;

BEGIN

	--
	-- Drop all triggers applied by CheckAuth()
	--
	FOR rec IN
		SELECT c.relname, t.tgname, t.tgargs FROM pg_trigger t, pg_class c, pg_proc p
		WHERE p.proname = 'checkauthtrigger' and t.tgfoid = p.oid and t.tgrelid = c.oid
	LOOP
		EXECUTE 'DROP TRIGGER ' || quote_ident(rec.tgname) ||
			' ON ' || quote_ident(rec.relname);
	END LOOP;

	--
	-- Drop the authorization_table table
	--
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorization_table' LOOP
		DROP TABLE authorization_table;
	END LOOP;

	--
	-- Drop the authorized_tables view
	--
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorized_tables' LOOP
		DROP VIEW authorized_tables;
	END LOOP;

	RETURN 'Long transactions support disabled';
END;
$$;


ALTER FUNCTION public.disablelongtransactions() OWNER TO postgres;

--
-- Name: FUNCTION disablelongtransactions(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION disablelongtransactions() IS 'Disable long transaction support. This function removes the long transaction support metadata tables, and drops all triggers attached to lock-checked tables.';


--
-- Name: dropgeometrycolumn(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret text;
BEGIN
	SELECT DropGeometryColumn('','',$1,$2) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying) OWNER TO postgres;

--
-- Name: FUNCTION dropgeometrycolumn(character varying, character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION dropgeometrycolumn(character varying, character varying) IS 'args: table_name, column_name - Removes a geometry column from a spatial table.';


--
-- Name: dropgeometrycolumn(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret text;
BEGIN
	SELECT DropGeometryColumn('',$1,$2,$3) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying) OWNER TO postgres;

--
-- Name: FUNCTION dropgeometrycolumn(character varying, character varying, character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION dropgeometrycolumn(character varying, character varying, character varying) IS 'args: schema_name, table_name, column_name - Removes a geometry column from a spatial table.';


--
-- Name: dropgeometrycolumn(character varying, character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrycolumn(character varying, character varying, character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	myrec RECORD;
	okay boolean;
	real_schema name;

BEGIN


	-- Find, check or fix schema_name
	IF ( schema_name != '' ) THEN
		okay = 'f';

		FOR myrec IN SELECT nspname FROM pg_namespace WHERE text(nspname) = schema_name LOOP
			okay := 't';
		END LOOP;

		IF ( okay <> 't' ) THEN
			RAISE NOTICE 'Invalid schema name - using current_schema()';
			SELECT current_schema() into real_schema;
		ELSE
			real_schema = schema_name;
		END IF;
	ELSE
		SELECT current_schema() into real_schema;
	END IF;

	-- Find out if the column is in the geometry_columns table
	okay = 'f';
	FOR myrec IN SELECT * from geometry_columns where f_table_schema = text(real_schema) and f_table_name = table_name and f_geometry_column = column_name LOOP
		okay := 't';
	END LOOP;
	IF (okay <> 't') THEN
		RAISE EXCEPTION 'column not found in geometry_columns table';
		RETURN 'f';
	END IF;

	-- Remove ref from geometry_columns table
	EXECUTE 'delete from geometry_columns where f_table_schema = ' ||
		quote_literal(real_schema) || ' and f_table_name = ' ||
		quote_literal(table_name)  || ' and f_geometry_column = ' ||
		quote_literal(column_name);

	-- Remove table column
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) || '.' ||
		quote_ident(table_name) || ' DROP COLUMN ' ||
		quote_ident(column_name);

	RETURN real_schema || '.' || table_name || '.' || column_name ||' effectively removed.';

END;
$_$;


ALTER FUNCTION public.dropgeometrycolumn(character varying, character varying, character varying, character varying) OWNER TO postgres;

--
-- Name: FUNCTION dropgeometrycolumn(character varying, character varying, character varying, character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION dropgeometrycolumn(character varying, character varying, character varying, character varying) IS 'args: catalog_name, schema_name, table_name, column_name - Removes a geometry column from a spatial table.';


--
-- Name: dropgeometrytable(character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrytable(character varying) RETURNS text
    LANGUAGE sql STRICT
    AS $_$ SELECT DropGeometryTable('','',$1) $_$;


ALTER FUNCTION public.dropgeometrytable(character varying) OWNER TO postgres;

--
-- Name: FUNCTION dropgeometrytable(character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION dropgeometrytable(character varying) IS 'args: table_name - Drops a table and all its references in geometry_columns.';


--
-- Name: dropgeometrytable(character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrytable(character varying, character varying) RETURNS text
    LANGUAGE sql STRICT
    AS $_$ SELECT DropGeometryTable('',$1,$2) $_$;


ALTER FUNCTION public.dropgeometrytable(character varying, character varying) OWNER TO postgres;

--
-- Name: FUNCTION dropgeometrytable(character varying, character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION dropgeometrytable(character varying, character varying) IS 'args: schema_name, table_name - Drops a table and all its references in geometry_columns.';


--
-- Name: dropgeometrytable(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION dropgeometrytable(character varying, character varying, character varying) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	real_schema name;

BEGIN

	IF ( schema_name = '' ) THEN
		SELECT current_schema() into real_schema;
	ELSE
		real_schema = schema_name;
	END IF;

	-- Remove refs from geometry_columns table
	EXECUTE 'DELETE FROM geometry_columns WHERE ' ||
		'f_table_schema = ' || quote_literal(real_schema) ||
		' AND ' ||
		' f_table_name = ' || quote_literal(table_name);

	-- Remove table
	EXECUTE 'DROP TABLE '
		|| quote_ident(real_schema) || '.' ||
		quote_ident(table_name);

	RETURN
		real_schema || '.' ||
		table_name ||' dropped.';

END;
$_$;


ALTER FUNCTION public.dropgeometrytable(character varying, character varying, character varying) OWNER TO postgres;

--
-- Name: FUNCTION dropgeometrytable(character varying, character varying, character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION dropgeometrytable(character varying, character varying, character varying) IS 'args: catalog_name, schema_name, table_name - Drops a table and all its references in geometry_columns.';


--
-- Name: enablelongtransactions(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION enablelongtransactions() RETURNS text
    LANGUAGE plpgsql
    AS $$ 
DECLARE
	"query" text;
	exists bool;
	rec RECORD;

BEGIN

	exists = 'f';
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorization_table'
	LOOP
		exists = 't';
	END LOOP;

	IF NOT exists
	THEN
		"query" = 'CREATE TABLE authorization_table (
			toid oid, -- table oid
			rid text, -- row id
			expires timestamp,
			authid text
		)';
		EXECUTE "query";
	END IF;

	exists = 'f';
	FOR rec IN SELECT * FROM pg_class WHERE relname = 'authorized_tables'
	LOOP
		exists = 't';
	END LOOP;

	IF NOT exists THEN
		"query" = 'CREATE VIEW authorized_tables AS ' ||
			'SELECT ' ||
			'n.nspname as schema, ' ||
			'c.relname as table, trim(' ||
			quote_literal(chr(92) || '000') ||
			' from t.tgargs) as id_column ' ||
			'FROM pg_trigger t, pg_class c, pg_proc p ' ||
			', pg_namespace n ' ||
			'WHERE p.proname = ' || quote_literal('checkauthtrigger') ||
			' AND c.relnamespace = n.oid' ||
			' AND t.tgfoid = p.oid and t.tgrelid = c.oid';
		EXECUTE "query";
	END IF;

	RETURN 'Long transactions support enabled';
END;
$$;


ALTER FUNCTION public.enablelongtransactions() OWNER TO postgres;

--
-- Name: FUNCTION enablelongtransactions(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION enablelongtransactions() IS 'Enable long transaction support. This function creates the required metadata tables, needs to be called once before using the other functions in this section. Calling it twice is harmless.';


--
-- Name: find_srid(character varying, character varying, character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION find_srid(character varying, character varying, character varying) RETURNS integer
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
DECLARE
	schem text;
	tabl text;
	sr int4;
BEGIN
	IF $1 IS NULL THEN
	  RAISE EXCEPTION 'find_srid() - schema is NULL!';
	END IF;
	IF $2 IS NULL THEN
	  RAISE EXCEPTION 'find_srid() - table name is NULL!';
	END IF;
	IF $3 IS NULL THEN
	  RAISE EXCEPTION 'find_srid() - column name is NULL!';
	END IF;
	schem = $1;
	tabl = $2;
-- if the table contains a . and the schema is empty
-- split the table into a schema and a table
-- otherwise drop through to default behavior
	IF ( schem = '' and tabl LIKE '%.%' ) THEN
	 schem = substr(tabl,1,strpos(tabl,'.')-1);
	 tabl = substr(tabl,length(schem)+2);
	ELSE
	 schem = schem || '%';
	END IF;

	select SRID into sr from geometry_columns where f_table_schema like schem and f_table_name = tabl and f_geometry_column = $3;
	IF NOT FOUND THEN
	   RAISE EXCEPTION 'find_srid() - couldnt find the corresponding SRID - is the geometry registered in the GEOMETRY_COLUMNS table?  Is there an uppercase/lowercase missmatch?';
	END IF;
	return sr;
END;
$_$;


ALTER FUNCTION public.find_srid(character varying, character varying, character varying) OWNER TO postgres;

--
-- Name: FUNCTION find_srid(character varying, character varying, character varying); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION find_srid(character varying, character varying, character varying) IS 'args: a_schema_name, a_table_name, a_geomfield_name - The syntax is find_srid(<db/schema>, <table>, <column>) and the function returns the integer SRID of the specified column by searching through the GEOMETRY_COLUMNS table.';


--
-- Name: fix_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION fix_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	mislinked record;
	result text;
	linked integer;
	deleted integer;
	foundschema integer;
BEGIN

	-- Since 7.3 schema support has been added.
	-- Previous postgis versions used to put the database name in
	-- the schema column. This needs to be fixed, so we try to
	-- set the correct schema for each geometry_colums record
	-- looking at table, column, type and srid.
	UPDATE geometry_columns SET f_table_schema = n.nspname
		FROM pg_namespace n, pg_class c, pg_attribute a,
			pg_constraint sridcheck, pg_constraint typecheck
			WHERE ( f_table_schema is NULL
		OR f_table_schema = ''
			OR f_table_schema NOT IN (
					SELECT nspname::varchar
					FROM pg_namespace nn, pg_class cc, pg_attribute aa
					WHERE cc.relnamespace = nn.oid
					AND cc.relname = f_table_name::name
					AND aa.attrelid = cc.oid
					AND aa.attname = f_geometry_column::name))
			AND f_table_name::name = c.relname
			AND c.oid = a.attrelid
			AND c.relnamespace = n.oid
			AND f_geometry_column::name = a.attname

			AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(srid(% = %)'
			AND sridcheck.consrc ~ textcat(' = ', srid::text)

			AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype(%) = ''%''::text) OR (% IS NULL))'
			AND typecheck.consrc ~ textcat(' = ''', type::text)

			AND NOT EXISTS (
					SELECT oid FROM geometry_columns gc
					WHERE c.relname::varchar = gc.f_table_name
					AND n.nspname::varchar = gc.f_table_schema
					AND a.attname::varchar = gc.f_geometry_column
			);

	GET DIAGNOSTICS foundschema = ROW_COUNT;

	-- no linkage to system table needed
	return 'fixed:'||foundschema::text;

END;
$$;


ALTER FUNCTION public.fix_geometry_columns() OWNER TO postgres;

--
-- Name: get_proj4_from_srid(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION get_proj4_from_srid(integer) RETURNS text
    LANGUAGE plpgsql IMMUTABLE STRICT
    AS $_$
BEGIN
	RETURN proj4text::text FROM spatial_ref_sys WHERE srid= $1;
END;
$_$;


ALTER FUNCTION public.get_proj4_from_srid(integer) OWNER TO postgres;

--
-- Name: lockrow(text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text) RETURNS integer
    LANGUAGE sql STRICT
    AS $_$ SELECT LockRow(current_schema(), $1, $2, $3, now()::timestamp+'1:00'); $_$;


ALTER FUNCTION public.lockrow(text, text, text) OWNER TO postgres;

--
-- Name: FUNCTION lockrow(text, text, text); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION lockrow(text, text, text) IS 'args: a_table_name, a_row_key, an_auth_token - Set lock/authorization for specific row in table';


--
-- Name: lockrow(text, text, text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text, text) RETURNS integer
    LANGUAGE sql STRICT
    AS $_$ SELECT LockRow($1, $2, $3, $4, now()::timestamp+'1:00'); $_$;


ALTER FUNCTION public.lockrow(text, text, text, text) OWNER TO postgres;

--
-- Name: lockrow(text, text, text, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text, timestamp without time zone) RETURNS integer
    LANGUAGE sql STRICT
    AS $_$ SELECT LockRow(current_schema(), $1, $2, $3, $4); $_$;


ALTER FUNCTION public.lockrow(text, text, text, timestamp without time zone) OWNER TO postgres;

--
-- Name: FUNCTION lockrow(text, text, text, timestamp without time zone); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION lockrow(text, text, text, timestamp without time zone) IS 'args: a_table_name, a_row_key, an_auth_token, expire_dt - Set lock/authorization for specific row in table';


--
-- Name: lockrow(text, text, text, text, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION lockrow(text, text, text, text, timestamp without time zone) RETURNS integer
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	myschema alias for $1;
	mytable alias for $2;
	myrid   alias for $3;
	authid alias for $4;
	expires alias for $5;
	ret int;
	mytoid oid;
	myrec RECORD;
	
BEGIN

	IF NOT LongTransactionsEnabled() THEN
		RAISE EXCEPTION 'Long transaction support disabled, use EnableLongTransaction() to enable.';
	END IF;

	EXECUTE 'DELETE FROM authorization_table WHERE expires < now()'; 

	SELECT c.oid INTO mytoid FROM pg_class c, pg_namespace n
		WHERE c.relname = mytable
		AND c.relnamespace = n.oid
		AND n.nspname = myschema;

	-- RAISE NOTICE 'toid: %', mytoid;

	FOR myrec IN SELECT * FROM authorization_table WHERE 
		toid = mytoid AND rid = myrid
	LOOP
		IF myrec.authid != authid THEN
			RETURN 0;
		ELSE
			RETURN 1;
		END IF;
	END LOOP;

	EXECUTE 'INSERT INTO authorization_table VALUES ('||
		quote_literal(mytoid::text)||','||quote_literal(myrid)||
		','||quote_literal(expires::text)||
		','||quote_literal(authid) ||')';

	GET DIAGNOSTICS ret = ROW_COUNT;

	RETURN ret;
END;
$_$;


ALTER FUNCTION public.lockrow(text, text, text, text, timestamp without time zone) OWNER TO postgres;

--
-- Name: FUNCTION lockrow(text, text, text, text, timestamp without time zone); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION lockrow(text, text, text, text, timestamp without time zone) IS 'args: a_schema_name, a_table_name, a_row_key, an_auth_token, expire_dt - Set lock/authorization for specific row in table';


--
-- Name: longtransactionsenabled(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION longtransactionsenabled() RETURNS boolean
    LANGUAGE plpgsql
    AS $$ 
DECLARE
	rec RECORD;
BEGIN
	FOR rec IN SELECT oid FROM pg_class WHERE relname = 'authorized_tables'
	LOOP
		return 't';
	END LOOP;
	return 'f';
END;
$$;


ALTER FUNCTION public.longtransactionsenabled() OWNER TO postgres;

--
-- Name: populate_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION populate_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	inserted    integer;
	oldcount    integer;
	probed      integer;
	stale       integer;
	gcs         RECORD;
	gc          RECORD;
	gsrid       integer;
	gndims      integer;
	gtype       text;
	query       text;
	gc_is_valid boolean;

BEGIN
	SELECT count(*) INTO oldcount FROM geometry_columns;
	inserted := 0;

	EXECUTE 'TRUNCATE geometry_columns';

	-- Count the number of geometry columns in all tables and views
	SELECT count(DISTINCT c.oid) INTO probed
	FROM pg_class c,
		 pg_attribute a,
		 pg_type t,
		 pg_namespace n
	WHERE (c.relkind = 'r' OR c.relkind = 'v')
	AND t.typname = 'geometry'
	AND a.attisdropped = false
	AND a.atttypid = t.oid
	AND a.attrelid = c.oid
	AND c.relnamespace = n.oid
	AND n.nspname NOT ILIKE 'pg_temp%';

	-- Iterate through all non-dropped geometry columns
	RAISE DEBUG 'Processing Tables.....';

	FOR gcs IN
	SELECT DISTINCT ON (c.oid) c.oid, n.nspname, c.relname
		FROM pg_class c,
			 pg_attribute a,
			 pg_type t,
			 pg_namespace n
		WHERE c.relkind = 'r'
		AND t.typname = 'geometry'
		AND a.attisdropped = false
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND n.nspname NOT ILIKE 'pg_temp%'
	LOOP

	inserted := inserted + populate_geometry_columns(gcs.oid);
	END LOOP;

	-- Add views to geometry columns table
	RAISE DEBUG 'Processing Views.....';
	FOR gcs IN
	SELECT DISTINCT ON (c.oid) c.oid, n.nspname, c.relname
		FROM pg_class c,
			 pg_attribute a,
			 pg_type t,
			 pg_namespace n
		WHERE c.relkind = 'v'
		AND t.typname = 'geometry'
		AND a.attisdropped = false
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
	LOOP

	inserted := inserted + populate_geometry_columns(gcs.oid);
	END LOOP;

	IF oldcount > inserted THEN
	stale = oldcount-inserted;
	ELSE
	stale = 0;
	END IF;

	RETURN 'probed:' ||probed|| ' inserted:'||inserted|| ' conflicts:'||probed-inserted|| ' deleted:'||stale;
END

$$;


ALTER FUNCTION public.populate_geometry_columns() OWNER TO postgres;

--
-- Name: FUNCTION populate_geometry_columns(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION populate_geometry_columns() IS 'Ensures geometry columns have appropriate spatial constraints and exist in the geometry_columns table.';


--
-- Name: populate_geometry_columns(oid); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION populate_geometry_columns(tbl_oid oid) RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
	gcs         RECORD;
	gc          RECORD;
	gsrid       integer;
	gndims      integer;
	gtype       text;
	query       text;
	gc_is_valid boolean;
	inserted    integer;

BEGIN
	inserted := 0;

	-- Iterate through all geometry columns in this table
	FOR gcs IN
	SELECT n.nspname, c.relname, a.attname
		FROM pg_class c,
			 pg_attribute a,
			 pg_type t,
			 pg_namespace n
		WHERE c.relkind = 'r'
		AND t.typname = 'geometry'
		AND a.attisdropped = false
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND n.nspname NOT ILIKE 'pg_temp%'
		AND c.oid = tbl_oid
	LOOP

	RAISE DEBUG 'Processing table %.%.%', gcs.nspname, gcs.relname, gcs.attname;

	DELETE FROM geometry_columns
	  WHERE f_table_schema = quote_ident(gcs.nspname)
	  AND f_table_name = quote_ident(gcs.relname)
	  AND f_geometry_column = quote_ident(gcs.attname);

	gc_is_valid := true;

	-- Try to find srid check from system tables (pg_constraint)
	gsrid :=
		(SELECT replace(replace(split_part(s.consrc, ' = ', 2), ')', ''), '(', '')
		 FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s
		 WHERE n.nspname = gcs.nspname
		 AND c.relname = gcs.relname
		 AND a.attname = gcs.attname
		 AND a.attrelid = c.oid
		 AND s.connamespace = n.oid
		 AND s.conrelid = c.oid
		 AND a.attnum = ANY (s.conkey)
		 AND s.consrc LIKE '%srid(% = %');
	IF (gsrid IS NULL) THEN
		-- Try to find srid from the geometry itself
		EXECUTE 'SELECT srid(' || quote_ident(gcs.attname) || ')
				 FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gsrid := gc.srid;

		-- Try to apply srid check to column
		IF (gsrid IS NOT NULL) THEN
			BEGIN
				EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
						 ADD CONSTRAINT ' || quote_ident('enforce_srid_' || gcs.attname) || '
						 CHECK (srid(' || quote_ident(gcs.attname) || ') = ' || gsrid || ')';
			EXCEPTION
				WHEN check_violation THEN
					RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not apply constraint CHECK (srid(%) = %)', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname), quote_ident(gcs.attname), gsrid;
					gc_is_valid := false;
			END;
		END IF;
	END IF;

	-- Try to find ndims check from system tables (pg_constraint)
	gndims :=
		(SELECT replace(split_part(s.consrc, ' = ', 2), ')', '')
		 FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s
		 WHERE n.nspname = gcs.nspname
		 AND c.relname = gcs.relname
		 AND a.attname = gcs.attname
		 AND a.attrelid = c.oid
		 AND s.connamespace = n.oid
		 AND s.conrelid = c.oid
		 AND a.attnum = ANY (s.conkey)
		 AND s.consrc LIKE '%ndims(% = %');
	IF (gndims IS NULL) THEN
		-- Try to find ndims from the geometry itself
		EXECUTE 'SELECT ndims(' || quote_ident(gcs.attname) || ')
				 FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gndims := gc.ndims;

		-- Try to apply ndims check to column
		IF (gndims IS NOT NULL) THEN
			BEGIN
				EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
						 ADD CONSTRAINT ' || quote_ident('enforce_dims_' || gcs.attname) || '
						 CHECK (ndims(' || quote_ident(gcs.attname) || ') = '||gndims||')';
			EXCEPTION
				WHEN check_violation THEN
					RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not apply constraint CHECK (ndims(%) = %)', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname), quote_ident(gcs.attname), gndims;
					gc_is_valid := false;
			END;
		END IF;
	END IF;

	-- Try to find geotype check from system tables (pg_constraint)
	gtype :=
		(SELECT replace(split_part(s.consrc, '''', 2), ')', '')
		 FROM pg_class c, pg_namespace n, pg_attribute a, pg_constraint s
		 WHERE n.nspname = gcs.nspname
		 AND c.relname = gcs.relname
		 AND a.attname = gcs.attname
		 AND a.attrelid = c.oid
		 AND s.connamespace = n.oid
		 AND s.conrelid = c.oid
		 AND a.attnum = ANY (s.conkey)
		 AND s.consrc LIKE '%geometrytype(% = %');
	IF (gtype IS NULL) THEN
		-- Try to find geotype from the geometry itself
		EXECUTE 'SELECT geometrytype(' || quote_ident(gcs.attname) || ')
				 FROM ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gtype := gc.geometrytype;
		--IF (gtype IS NULL) THEN
		--    gtype := 'GEOMETRY';
		--END IF;

		-- Try to apply geometrytype check to column
		IF (gtype IS NOT NULL) THEN
			BEGIN
				EXECUTE 'ALTER TABLE ONLY ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				ADD CONSTRAINT ' || quote_ident('enforce_geotype_' || gcs.attname) || '
				CHECK ((geometrytype(' || quote_ident(gcs.attname) || ') = ' || quote_literal(gtype) || ') OR (' || quote_ident(gcs.attname) || ' IS NULL))';
			EXCEPTION
				WHEN check_violation THEN
					-- No geometry check can be applied. This column contains a number of geometry types.
					RAISE WARNING 'Could not add geometry type check (%) to table column: %.%.%', gtype, quote_ident(gcs.nspname),quote_ident(gcs.relname),quote_ident(gcs.attname);
			END;
		END IF;
	END IF;

	IF (gsrid IS NULL) THEN
		RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the srid', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSIF (gndims IS NULL) THEN
		RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the number of dimensions', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSIF (gtype IS NULL) THEN
		RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine the geometry type', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
	ELSE
		-- Only insert into geometry_columns if table constraints could be applied.
		IF (gc_is_valid) THEN
			INSERT INTO geometry_columns (f_table_catalog,f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, type)
			VALUES ('', gcs.nspname, gcs.relname, gcs.attname, gndims, gsrid, gtype);
			inserted := inserted + 1;
		END IF;
	END IF;
	END LOOP;

	-- Add views to geometry columns table
	FOR gcs IN
	SELECT n.nspname, c.relname, a.attname
		FROM pg_class c,
			 pg_attribute a,
			 pg_type t,
			 pg_namespace n
		WHERE c.relkind = 'v'
		AND t.typname = 'geometry'
		AND a.attisdropped = false
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND n.nspname NOT ILIKE 'pg_temp%'
		AND c.oid = tbl_oid
	LOOP
		RAISE DEBUG 'Processing view %.%.%', gcs.nspname, gcs.relname, gcs.attname;

		EXECUTE 'SELECT ndims(' || quote_ident(gcs.attname) || ')
				 FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gndims := gc.ndims;

		EXECUTE 'SELECT srid(' || quote_ident(gcs.attname) || ')
				 FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gsrid := gc.srid;

		EXECUTE 'SELECT geometrytype(' || quote_ident(gcs.attname) || ')
				 FROM ' || quote_ident(gcs.nspname) || '.' || quote_ident(gcs.relname) || '
				 WHERE ' || quote_ident(gcs.attname) || ' IS NOT NULL LIMIT 1'
			INTO gc;
		gtype := gc.geometrytype;

		IF (gndims IS NULL) THEN
			RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine ndims', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
		ELSIF (gsrid IS NULL) THEN
			RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine srid', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
		ELSIF (gtype IS NULL) THEN
			RAISE WARNING 'Not inserting ''%'' in ''%.%'' into geometry_columns: could not determine gtype', quote_ident(gcs.attname), quote_ident(gcs.nspname), quote_ident(gcs.relname);
		ELSE
			query := 'INSERT INTO geometry_columns (f_table_catalog,f_table_schema, f_table_name, f_geometry_column, coord_dimension, srid, type) ' ||
					 'VALUES ('''', ' || quote_literal(gcs.nspname) || ',' || quote_literal(gcs.relname) || ',' || quote_literal(gcs.attname) || ',' || gndims || ',' || gsrid || ',' || quote_literal(gtype) || ')';
			EXECUTE query;
			inserted := inserted + 1;
		END IF;
	END LOOP;

	RETURN inserted;
END

$$;


ALTER FUNCTION public.populate_geometry_columns(tbl_oid oid) OWNER TO postgres;

--
-- Name: FUNCTION populate_geometry_columns(tbl_oid oid); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION populate_geometry_columns(tbl_oid oid) IS 'args: relation_oid - Ensures geometry columns have appropriate spatial constraints and exist in the geometry_columns table.';


--
-- Name: postgis_full_version(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_full_version() RETURNS text
    LANGUAGE plpgsql IMMUTABLE
    AS $$
DECLARE
	libver text;
	projver text;
	geosver text;
	libxmlver text;
	usestats bool;
	dbproc text;
	relproc text;
	fullver text;
BEGIN
	SELECT postgis_lib_version() INTO libver;
	SELECT postgis_proj_version() INTO projver;
	SELECT postgis_geos_version() INTO geosver;
	SELECT postgis_libxml_version() INTO libxmlver;
	SELECT postgis_uses_stats() INTO usestats;
	SELECT postgis_scripts_installed() INTO dbproc;
	SELECT postgis_scripts_released() INTO relproc;

	fullver = 'POSTGIS="' || libver || '"';

	IF  geosver IS NOT NULL THEN
		fullver = fullver || ' GEOS="' || geosver || '"';
	END IF;

	IF  projver IS NOT NULL THEN
		fullver = fullver || ' PROJ="' || projver || '"';
	END IF;

	IF  libxmlver IS NOT NULL THEN
		fullver = fullver || ' LIBXML="' || libxmlver || '"';
	END IF;

	IF usestats THEN
		fullver = fullver || ' USE_STATS';
	END IF;

	-- fullver = fullver || ' DBPROC="' || dbproc || '"';
	-- fullver = fullver || ' RELPROC="' || relproc || '"';

	IF dbproc != relproc THEN
		fullver = fullver || ' (procs from ' || dbproc || ' need upgrade)';
	END IF;

	RETURN fullver;
END
$$;


ALTER FUNCTION public.postgis_full_version() OWNER TO postgres;

--
-- Name: FUNCTION postgis_full_version(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION postgis_full_version() IS 'Reports full postgis version and build configuration infos.';


--
-- Name: postgis_scripts_build_date(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_scripts_build_date() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$SELECT '2010-05-17 12:52:19'::text AS version$$;


ALTER FUNCTION public.postgis_scripts_build_date() OWNER TO postgres;

--
-- Name: FUNCTION postgis_scripts_build_date(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION postgis_scripts_build_date() IS 'Returns build date of the PostGIS scripts.';


--
-- Name: postgis_scripts_installed(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION postgis_scripts_installed() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$SELECT '1.5 r5385'::text AS version$$;


ALTER FUNCTION public.postgis_scripts_installed() OWNER TO postgres;

--
-- Name: FUNCTION postgis_scripts_installed(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION postgis_scripts_installed() IS 'Returns version of the postgis scripts installed in this database.';


--
-- Name: probe_geometry_columns(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION probe_geometry_columns() RETURNS text
    LANGUAGE plpgsql
    AS $$
DECLARE
	inserted integer;
	oldcount integer;
	probed integer;
	stale integer;
BEGIN

	SELECT count(*) INTO oldcount FROM geometry_columns;

	SELECT count(*) INTO probed
		FROM pg_class c, pg_attribute a, pg_type t,
			pg_namespace n,
			pg_constraint sridcheck, pg_constraint typecheck

		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid
		AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(srid('||a.attname||') = %)'
		AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype('||a.attname||') = ''%''::text) OR (% IS NULL))'
		;

	INSERT INTO geometry_columns SELECT
		''::varchar as f_table_catalogue,
		n.nspname::varchar as f_table_schema,
		c.relname::varchar as f_table_name,
		a.attname::varchar as f_geometry_column,
		2 as coord_dimension,
		trim(both  ' =)' from
			replace(replace(split_part(
				sridcheck.consrc, ' = ', 2), ')', ''), '(', ''))::integer AS srid,
		trim(both ' =)''' from substr(typecheck.consrc,
			strpos(typecheck.consrc, '='),
			strpos(typecheck.consrc, '::')-
			strpos(typecheck.consrc, '=')
			))::varchar as type
		FROM pg_class c, pg_attribute a, pg_type t,
			pg_namespace n,
			pg_constraint sridcheck, pg_constraint typecheck
		WHERE t.typname = 'geometry'
		AND a.atttypid = t.oid
		AND a.attrelid = c.oid
		AND c.relnamespace = n.oid
		AND sridcheck.connamespace = n.oid
		AND typecheck.connamespace = n.oid
		AND sridcheck.conrelid = c.oid
		AND sridcheck.consrc LIKE '(st_srid('||a.attname||') = %)'
		AND typecheck.conrelid = c.oid
		AND typecheck.consrc LIKE
		'((geometrytype('||a.attname||') = ''%''::text) OR (% IS NULL))'

			AND NOT EXISTS (
					SELECT oid FROM geometry_columns gc
					WHERE c.relname::varchar = gc.f_table_name
					AND n.nspname::varchar = gc.f_table_schema
					AND a.attname::varchar = gc.f_geometry_column
			);

	GET DIAGNOSTICS inserted = ROW_COUNT;

	IF oldcount > probed THEN
		stale = oldcount-probed;
	ELSE
		stale = 0;
	END IF;

	RETURN 'probed:'||probed::text||
		' inserted:'||inserted::text||
		' conflicts:'||(probed-inserted)::text||
		' stale:'||stale::text;
END

$$;


ALTER FUNCTION public.probe_geometry_columns() OWNER TO postgres;

--
-- Name: FUNCTION probe_geometry_columns(); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION probe_geometry_columns() IS 'Scans all tables with PostGIS geometry constraints and adds them to the geometry_columns table if they are not there.';


--
-- Name: rename_geometry_table_constraints(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION rename_geometry_table_constraints() RETURNS text
    LANGUAGE sql IMMUTABLE
    AS $$
SELECT 'rename_geometry_table_constraint() is obsoleted'::text
$$;


ALTER FUNCTION public.rename_geometry_table_constraints() OWNER TO postgres;

--
-- Name: st_area(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_area(text) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Area($1::geometry);  $_$;


ALTER FUNCTION public.st_area(text) OWNER TO postgres;

--
-- Name: st_asbinary(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asbinary(text) RETURNS bytea
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsBinary($1::geometry);  $_$;


ALTER FUNCTION public.st_asbinary(text) OWNER TO postgres;

--
-- Name: st_asgeojson(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgeojson(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsGeoJson($1::geometry);  $_$;


ALTER FUNCTION public.st_asgeojson(text) OWNER TO postgres;

--
-- Name: st_asgml(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_asgml(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsGML($1::geometry);  $_$;


ALTER FUNCTION public.st_asgml(text) OWNER TO postgres;

--
-- Name: st_askml(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_askml(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsKML($1::geometry);  $_$;


ALTER FUNCTION public.st_askml(text) OWNER TO postgres;

--
-- Name: st_assvg(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_assvg(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsSVG($1::geometry);  $_$;


ALTER FUNCTION public.st_assvg(text) OWNER TO postgres;

--
-- Name: st_astext(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_astext(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_AsText($1::geometry);  $_$;


ALTER FUNCTION public.st_astext(text) OWNER TO postgres;

--
-- Name: st_coveredby(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_coveredby(text, text) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_CoveredBy($1::geometry, $2::geometry);  $_$;


ALTER FUNCTION public.st_coveredby(text, text) OWNER TO postgres;

--
-- Name: st_covers(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_covers(text, text) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Covers($1::geometry, $2::geometry);  $_$;


ALTER FUNCTION public.st_covers(text, text) OWNER TO postgres;

--
-- Name: st_distance(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_distance(text, text) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Distance($1::geometry, $2::geometry);  $_$;


ALTER FUNCTION public.st_distance(text, text) OWNER TO postgres;

--
-- Name: st_dwithin(text, text, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_dwithin(text, text, double precision) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_DWithin($1::geometry, $2::geometry, $3);  $_$;


ALTER FUNCTION public.st_dwithin(text, text, double precision) OWNER TO postgres;

--
-- Name: st_intersects(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_intersects(text, text) RETURNS boolean
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Intersects($1::geometry, $2::geometry);  $_$;


ALTER FUNCTION public.st_intersects(text, text) OWNER TO postgres;

--
-- Name: st_length(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION st_length(text) RETURNS double precision
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$ SELECT ST_Length($1::geometry);  $_$;


ALTER FUNCTION public.st_length(text) OWNER TO postgres;

--
-- Name: unlockrows(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION unlockrows(text) RETURNS integer
    LANGUAGE plpgsql STRICT
    AS $_$ 
DECLARE
	ret int;
BEGIN

	IF NOT LongTransactionsEnabled() THEN
		RAISE EXCEPTION 'Long transaction support disabled, use EnableLongTransaction() to enable.';
	END IF;

	EXECUTE 'DELETE FROM authorization_table where authid = ' ||
		quote_literal($1);

	GET DIAGNOSTICS ret = ROW_COUNT;

	RETURN ret;
END;
$_$;


ALTER FUNCTION public.unlockrows(text) OWNER TO postgres;

--
-- Name: FUNCTION unlockrows(text); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION unlockrows(text) IS 'args: auth_token - Remove all locks held by specified authorization id. Returns the number of locks released.';


--
-- Name: updategeometrysrid(character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT UpdateGeometrySRID('','',$1,$2,$3) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, integer) OWNER TO postgres;

--
-- Name: FUNCTION updategeometrysrid(character varying, character varying, integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION updategeometrysrid(character varying, character varying, integer) IS 'args: table_name, column_name, srid - Updates the SRID of all features in a geometry column, geometry_columns metadata and srid table constraint';


--
-- Name: updategeometrysrid(character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	ret  text;
BEGIN
	SELECT UpdateGeometrySRID('',$1,$2,$3,$4) into ret;
	RETURN ret;
END;
$_$;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, character varying, integer) OWNER TO postgres;

--
-- Name: FUNCTION updategeometrysrid(character varying, character varying, character varying, integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION updategeometrysrid(character varying, character varying, character varying, integer) IS 'args: schema_name, table_name, column_name, srid - Updates the SRID of all features in a geometry column, geometry_columns metadata and srid table constraint';


--
-- Name: updategeometrysrid(character varying, character varying, character varying, character varying, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION updategeometrysrid(character varying, character varying, character varying, character varying, integer) RETURNS text
    LANGUAGE plpgsql STRICT
    AS $_$
DECLARE
	catalog_name alias for $1;
	schema_name alias for $2;
	table_name alias for $3;
	column_name alias for $4;
	new_srid alias for $5;
	myrec RECORD;
	okay boolean;
	cname varchar;
	real_schema name;

BEGIN


	-- Find, check or fix schema_name
	IF ( schema_name != '' ) THEN
		okay = 'f';

		FOR myrec IN SELECT nspname FROM pg_namespace WHERE text(nspname) = schema_name LOOP
			okay := 't';
		END LOOP;

		IF ( okay <> 't' ) THEN
			RAISE EXCEPTION 'Invalid schema name';
		ELSE
			real_schema = schema_name;
		END IF;
	ELSE
		SELECT INTO real_schema current_schema()::text;
	END IF;

	-- Find out if the column is in the geometry_columns table
	okay = 'f';
	FOR myrec IN SELECT * from geometry_columns where f_table_schema = text(real_schema) and f_table_name = table_name and f_geometry_column = column_name LOOP
		okay := 't';
	END LOOP;
	IF (okay <> 't') THEN
		RAISE EXCEPTION 'column not found in geometry_columns table';
		RETURN 'f';
	END IF;

	-- Update ref from geometry_columns table
	EXECUTE 'UPDATE geometry_columns SET SRID = ' || new_srid::text ||
		' where f_table_schema = ' ||
		quote_literal(real_schema) || ' and f_table_name = ' ||
		quote_literal(table_name)  || ' and f_geometry_column = ' ||
		quote_literal(column_name);

	-- Make up constraint name
	cname = 'enforce_srid_'  || column_name;

	-- Drop enforce_srid constraint
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||
		' DROP constraint ' || quote_ident(cname);

	-- Update geometries SRID
	EXECUTE 'UPDATE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||
		' SET ' || quote_ident(column_name) ||
		' = setSRID(' || quote_ident(column_name) ||
		', ' || new_srid::text || ')';

	-- Reset enforce_srid constraint
	EXECUTE 'ALTER TABLE ' || quote_ident(real_schema) ||
		'.' || quote_ident(table_name) ||
		' ADD constraint ' || quote_ident(cname) ||
		' CHECK (srid(' || quote_ident(column_name) ||
		') = ' || new_srid::text || ')';

	RETURN real_schema || '.' || table_name || '.' || column_name ||' SRID changed to ' || new_srid::text;

END;
$_$;


ALTER FUNCTION public.updategeometrysrid(character varying, character varying, character varying, character varying, integer) OWNER TO postgres;

--
-- Name: FUNCTION updategeometrysrid(character varying, character varying, character varying, character varying, integer); Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON FUNCTION updategeometrysrid(character varying, character varying, character varying, character varying, integer) IS 'args: catalog_name, schema_name, table_name, column_name, srid - Updates the SRID of all features in a geometry column, geometry_columns metadata and srid table constraint';


SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: abbevera; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE abbevera (
    codice character varying(1) NOT NULL,
    descriz character varying(8)
);


ALTER TABLE public.abbevera OWNER TO postgres;

--
-- Name: acc_stra; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE acc_stra (
    codice character varying(1) NOT NULL,
    descriz character varying(16)
);


ALTER TABLE public.acc_stra OWNER TO postgres;

--
-- Name: acc_via; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE acc_via (
    codice character varying(1),
    descriz character varying(20)
);


ALTER TABLE public.acc_via OWNER TO postgres;

--
-- Name: accesso; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE accesso (
    codice character varying(1) NOT NULL,
    descriz character varying(20)
);


ALTER TABLE public.accesso OWNER TO postgres;

--
-- Name: an_id_co; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE an_id_co (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    u character varying(2),
    f character varying(2),
    g character varying(2),
    sup_tot double precision,
    sp1 character varying(3),
    sp2 character varying(3),
    sp3 character varying(3),
    sp4 character varying(3),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.an_id_co OWNER TO postgres;

--
-- Name: an_id_co_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE an_id_co_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.an_id_co_objectid_seq OWNER TO postgres;

--
-- Name: an_id_co_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE an_id_co_objectid_seq OWNED BY an_id_co.objectid;


--
-- Name: arb_colt; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE arb_colt (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.arb_colt OWNER TO postgres;

--
-- Name: arb_colt_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE arb_colt_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arb_colt_objectid_seq OWNER TO postgres;

--
-- Name: arb_colt_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE arb_colt_objectid_seq OWNED BY arb_colt.objectid;


--
-- Name: arboree; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE arboree (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coper character varying(1),
    cod_coltu character varying(3) NOT NULL,
    ordine_inser integer,
    ord_ins character varying(38),
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.arboree OWNER TO postgres;

--
-- Name: arboree2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE arboree2 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coper integer DEFAULT 0,
    cod_coltu character varying(3) NOT NULL,
    ordine_inser integer,
    ord_ins character varying(38),
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.arboree2 OWNER TO postgres;

--
-- Name: arboree2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE arboree2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arboree2_objectid_seq OWNER TO postgres;

--
-- Name: arboree2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE arboree2_objectid_seq OWNED BY arboree2.objectid;


--
-- Name: arboree4a; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE arboree4a (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coper integer DEFAULT 0,
    cod_coltu character varying(3) NOT NULL,
    ordine_inser integer,
    ord_ins character varying(38),
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.arboree4a OWNER TO postgres;

--
-- Name: arboree4a_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE arboree4a_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arboree4a_objectid_seq OWNER TO postgres;

--
-- Name: arboree4a_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE arboree4a_objectid_seq OWNED BY arboree4a.objectid;


--
-- Name: arboree4b; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE arboree4b (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coper integer DEFAULT 0,
    cod_coltu character varying(3) NOT NULL,
    ordine_inser integer,
    ord_ins character varying(38),
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.arboree4b OWNER TO postgres;

--
-- Name: arboree4b_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE arboree4b_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arboree4b_objectid_seq OWNER TO postgres;

--
-- Name: arboree4b_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE arboree4b_objectid_seq OWNED BY arboree4b.objectid;


--
-- Name: arboree_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE arboree_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arboree_objectid_seq OWNER TO postgres;

--
-- Name: arboree_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE arboree_objectid_seq OWNED BY arboree.objectid;


--
-- Name: arbusti; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE arbusti (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.arbusti OWNER TO postgres;

--
-- Name: arbusti2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE arbusti2 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.arbusti2 OWNER TO postgres;

--
-- Name: arbusti2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE arbusti2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arbusti2_objectid_seq OWNER TO postgres;

--
-- Name: arbusti2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE arbusti2_objectid_seq OWNED BY arbusti2.objectid;


--
-- Name: arbusti3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE arbusti3 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.arbusti3 OWNER TO postgres;

--
-- Name: arbusti3_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE arbusti3_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arbusti3_objectid_seq OWNER TO postgres;

--
-- Name: arbusti3_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE arbusti3_objectid_seq OWNED BY arbusti3.objectid;


--
-- Name: arbusti_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE arbusti_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.arbusti_objectid_seq OWNER TO postgres;

--
-- Name: arbusti_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE arbusti_objectid_seq OWNED BY arbusti.objectid;


--
-- Name: archivi_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE archivi_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.archivi_id_seq OWNER TO postgres;

--
-- Name: archivi; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE archivi (
    id integer DEFAULT nextval('archivi_id_seq'::regclass),
    archivio character varying(12) NOT NULL,
    nomecampo character varying(25) NOT NULL,
    arc_esteso character varying(50),
    valnerina boolean DEFAULT false,
    rer boolean DEFAULT false,
    progetto_bosco boolean DEFAULT false,
    tipo character varying(3),
    lunghezza character varying(4),
    decimali character varying(2) DEFAULT ' 0'::character varying,
    ordine character varying(4),
    intesta character varying(60),
    chiave boolean DEFAULT false,
    indice boolean DEFAULT false,
    query boolean DEFAULT false,
    dizionario character varying(20),
    campo_rela character varying(10),
    issele boolean DEFAULT false,
    qordine double precision,
    pict_campo character varying(15),
    valida character varying(70),
    vf character varying(70),
    quando character varying(70),
    qf character varying(70),
    calcolato character varying(254),
    "default" character varying(50),
    visibile boolean DEFAULT false,
    visiquando character varying(70),
    modificabi boolean DEFAULT false,
    totale boolean DEFAULT false,
    media boolean DEFAULT false,
    note character varying(250),
    lavorata boolean DEFAULT false,
    co character varying(20),
    "to" character varying(3),
    lo character varying(4),
    "do" character varying(2),
    fc character varying(1) DEFAULT 'n'::character varying,
    ft character varying(1) DEFAULT 'n'::character varying,
    fl character varying(1) DEFAULT 'n'::character varying,
    fd character varying(1) DEFAULT 'n'::character varying,
    note_camilla character varying(255),
    modif_camilla boolean,
    note_chiara character varying(255),
    modif_chiara boolean
);


ALTER TABLE public.archivi OWNER TO postgres;

--
-- Name: base_per_h; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE base_per_h (
    proprieta character varying(5),
    cod_part character varying(5),
    cod_fo character varying(2),
    tipo_ril character varying(1),
    data timestamp with time zone,
    specie character varying(3),
    diam smallint,
    h real,
    poll_matr character varying(1)
);


ALTER TABLE public.base_per_h OWNER TO postgres;

--
-- Name: car_nove; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE car_nove (
    codice character varying(1) NOT NULL,
    descriz character varying(30)
);


ALTER TABLE public.car_nove OWNER TO postgres;

--
-- Name: carico; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE carico (
    codice character varying(1) NOT NULL,
    descriz character varying(9)
);


ALTER TABLE public.carico OWNER TO postgres;

--
-- Name: catasto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE catasto (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    foglio character varying(5) NOT NULL,
    particella character varying(5) NOT NULL,
    sup_tot_cat double precision DEFAULT 0,
    sup_tot double precision,
    sup_bosc double precision,
    sum_sup_non_bosc double precision DEFAULT 0,
    note text,
    id_av character varying(12),
    porz_perc double precision DEFAULT 0,
    objectid integer NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying
);


ALTER TABLE public.catasto OWNER TO postgres;

--
-- Name: catasto_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE catasto_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.catasto_objectid_seq OWNER TO postgres;

--
-- Name: catasto_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE catasto_objectid_seq OWNED BY catasto.objectid;


--
-- Name: clas_pro; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE clas_pro (
    codice character varying(1) NOT NULL,
    descriz character varying(31)
);


ALTER TABLE public.clas_pro OWNER TO postgres;

--
-- Name: clas_via; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE clas_via (
    codice character varying(1) NOT NULL,
    descriz character varying(31)
);


ALTER TABLE public.clas_via OWNER TO postgres;

--
-- Name: coltcast; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE coltcast (
    codice character varying(1) NOT NULL,
    descriz character varying(25)
);


ALTER TABLE public.coltcast OWNER TO postgres;

--
-- Name: comp_arb; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE comp_arb (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.comp_arb OWNER TO postgres;

--
-- Name: comp_arb_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE comp_arb_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comp_arb_objectid_seq OWNER TO postgres;

--
-- Name: comp_arb_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE comp_arb_objectid_seq OWNED BY comp_arb.objectid;


--
-- Name: compcoti; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE compcoti (
    codice character varying(1) NOT NULL,
    descriz character varying(40)
);


ALTER TABLE public.compcoti OWNER TO postgres;

--
-- Name: compo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE compo (
    codice character varying(1) NOT NULL,
    descrizion character varying(10)
);


ALTER TABLE public.compo OWNER TO postgres;

--
-- Name: compresa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE compresa (
    proprieta character varying(5) NOT NULL,
    compresa character varying(3) NOT NULL,
    descrizion character varying(255),
    frase text,
    rice_b character varying(255),
    rice_b1 character varying(255),
    rice_arb character varying(255),
    rice_cat character varying(255),
    rice_b2 character varying(255),
    rice_b3 character varying(255),
    objectid integer NOT NULL,
    id_av_x_join character varying(50)
);


ALTER TABLE public.compresa OWNER TO postgres;

--
-- Name: compresa_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE compresa_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.compresa_objectid_seq OWNER TO postgres;

--
-- Name: compresa_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE compresa_objectid_seq OWNED BY compresa.objectid;


--
-- Name: comuni; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE comuni (
    regione character varying(2) NOT NULL,
    provincia character varying(3) NOT NULL,
    comune character varying(3) NOT NULL,
    codice character varying(6),
    descriz character varying(70),
    comunita character varying(3),
    priorita boolean DEFAULT false,
    objectid integer NOT NULL,
    id_av_comuni character varying(255)
);


ALTER TABLE public.comuni OWNER TO postgres;

--
-- Name: comuni_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE comuni_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comuni_objectid_seq OWNER TO postgres;

--
-- Name: comuni_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE comuni_objectid_seq OWNED BY comuni.objectid;


--
-- Name: comunita; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE comunita (
    regione character varying(2) NOT NULL,
    codice character varying(3) NOT NULL,
    descrizion character varying(80),
    objectid integer NOT NULL
);


ALTER TABLE public.comunita OWNER TO postgres;

--
-- Name: comunita_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE comunita_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comunita_objectid_seq OWNER TO postgres;

--
-- Name: comunita_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE comunita_objectid_seq OWNED BY comunita.objectid;


--
-- Name: copmorta; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE copmorta (
    codice character varying(2),
    descriz character varying(33)
);


ALTER TABLE public.copmorta OWNER TO postgres;

--
-- Name: crono; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE crono (
    codice character varying(1),
    descriz character varying(3)
);


ALTER TABLE public.crono OWNER TO postgres;

--
-- Name: denscoti; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE denscoti (
    codice character varying(1) NOT NULL,
    descriz character varying(19)
);


ALTER TABLE public.denscoti OWNER TO postgres;

--
-- Name: densita; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE densita (
    codice character varying(1) NOT NULL,
    descriz character varying(15)
);


ALTER TABLE public.densita OWNER TO postgres;

--
-- Name: densita3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE densita3 (
    codice character varying(1) NOT NULL,
    descriz character varying(15)
);


ALTER TABLE public.densita3 OWNER TO postgres;

--
-- Name: descr_pa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE descr_pa (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying,
    id_av character varying(12),
    fattori text,
    descrizion text,
    interventi text,
    funzione text,
    orientamen text,
    ipotesi text,
    dendrometri text,
    note text,
    objectid integer NOT NULL
);


ALTER TABLE public.descr_pa OWNER TO postgres;

--
-- Name: descr_pa_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE descr_pa_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.descr_pa_objectid_seq OWNER TO postgres;

--
-- Name: descr_pa_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE descr_pa_objectid_seq OWNED BY descr_pa.objectid;


--
-- Name: disph2o; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE disph2o (
    codice character varying(1) NOT NULL,
    descriz character varying(13)
);


ALTER TABLE public.disph2o OWNER TO postgres;

--
-- Name: diz_arbo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_arbo (
    cod_coltu character varying(3) NOT NULL,
    nome_scien character varying(38),
    nome_per_trad character varying(33),
    nome_itali character varying(40),
    form_b character varying(8),
    codice double precision,
    cod_ifer double precision,
    cod_ifni character varying(8),
    cod_cartfo character varying(13),
    cod_cens double precision,
    priorita boolean DEFAULT false,
    objectid integer NOT NULL,
    per_filtro boolean DEFAULT false
);


ALTER TABLE public.diz_arbo OWNER TO postgres;

--
-- Name: diz_arbo_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_arbo_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_arbo_objectid_seq OWNER TO postgres;

--
-- Name: diz_arbo_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_arbo_objectid_seq OWNED BY diz_arbo.objectid;


--
-- Name: diz_curve; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_curve (
    cod_curva character varying(1) NOT NULL,
    nome character varying(50)
);


ALTER TABLE public.diz_curve OWNER TO postgres;

--
-- Name: diz_erba; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_erba (
    cod_coltu character varying(3) NOT NULL,
    nome character varying(23),
    priorita boolean DEFAULT false,
    objectid integer NOT NULL
);


ALTER TABLE public.diz_erba OWNER TO postgres;

--
-- Name: diz_erba_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_erba_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_erba_objectid_seq OWNER TO postgres;

--
-- Name: diz_erba_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_erba_objectid_seq OWNED BY diz_erba.objectid;


--
-- Name: diz_fung; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_fung (
    cod_coltu character varying(3) NOT NULL,
    nome character varying(23),
    objectid integer NOT NULL
);


ALTER TABLE public.diz_fung OWNER TO postgres;

--
-- Name: diz_fung_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_fung_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_fung_objectid_seq OWNER TO postgres;

--
-- Name: diz_fung_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_fung_objectid_seq OWNED BY diz_fung.objectid;


--
-- Name: diz_regioni; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_regioni (
    codice character varying(2) NOT NULL,
    descriz character varying(50),
    objectid integer NOT NULL
);


ALTER TABLE public.diz_regioni OWNER TO postgres;

--
-- Name: diz_regioni_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_regioni_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_regioni_objectid_seq OWNER TO postgres;

--
-- Name: diz_regioni_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_regioni_objectid_seq OWNED BY diz_regioni.objectid;


--
-- Name: diz_tavole; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_tavole (
    codice character varying(10) NOT NULL,
    descriz character varying(120),
    autore character varying(50),
    funzione text,
    tipo character varying(1),
    forma character varying(1),
    biomassa boolean DEFAULT false,
    assortimenti boolean DEFAULT false,
    d_min integer DEFAULT 0,
    d_max integer DEFAULT 0,
    classe_d integer DEFAULT 0,
    h_min double precision DEFAULT 0,
    h_max double precision DEFAULT 0,
    classe_h integer DEFAULT 0,
    note character varying(255),
    n_tariffa integer DEFAULT 0,
    objectid integer NOT NULL,
    per_filtro boolean DEFAULT false
);


ALTER TABLE public.diz_tavole OWNER TO postgres;

--
-- Name: diz_tavole2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_tavole2 (
    codice character varying(10) NOT NULL,
    tariffa integer DEFAULT 1 NOT NULL,
    d double precision DEFAULT 0 NOT NULL,
    h double precision DEFAULT 0 NOT NULL,
    v double precision,
    objectid integer NOT NULL
);


ALTER TABLE public.diz_tavole2 OWNER TO postgres;

--
-- Name: diz_tavole2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_tavole2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_tavole2_objectid_seq OWNER TO postgres;

--
-- Name: diz_tavole2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_tavole2_objectid_seq OWNED BY diz_tavole2.objectid;


--
-- Name: diz_tavole3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_tavole3 (
    codice character varying(10) NOT NULL,
    tariffa integer DEFAULT 1 NOT NULL,
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
    objectid integer NOT NULL
);


ALTER TABLE public.diz_tavole3 OWNER TO postgres;

--
-- Name: diz_tavole3_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_tavole3_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_tavole3_objectid_seq OWNER TO postgres;

--
-- Name: diz_tavole3_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_tavole3_objectid_seq OWNED BY diz_tavole3.objectid;


--
-- Name: diz_tavole4; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_tavole4 (
    codice character varying(10) NOT NULL,
    vgrezzo character varying(50),
    velaborato character varying(50),
    vdendr character varying(50),
    vcorm character varying(50),
    vblast character varying(50),
    vcimale character varying(50),
    legnameopera character varying(50),
    tronchi character varying(50),
    tronchetti character varying(50),
    legnaardere character varying(50),
    traverse character varying(50),
    fasciname character varying(50),
    altro character varying(50),
    pf character varying(100),
    ps character varying(100),
    objectid integer NOT NULL
);


ALTER TABLE public.diz_tavole4 OWNER TO postgres;

--
-- Name: diz_tavole4_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_tavole4_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_tavole4_objectid_seq OWNER TO postgres;

--
-- Name: diz_tavole4_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_tavole4_objectid_seq OWNED BY diz_tavole4.objectid;


--
-- Name: diz_tavole5; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_tavole5 (
    codice character varying(10) NOT NULL,
    vgrezzo_f boolean DEFAULT false,
    velaborato_f boolean DEFAULT false,
    vdendr_f boolean DEFAULT false,
    vcorm_f boolean DEFAULT false,
    vblast_f boolean DEFAULT false,
    vcimale_f boolean DEFAULT false,
    legnameopera_f boolean DEFAULT false,
    tronchi_f boolean DEFAULT false,
    tronchetti_f boolean DEFAULT false,
    legnaardere_f boolean DEFAULT false,
    traverse_f boolean DEFAULT false,
    fasciname_f boolean DEFAULT false,
    altro_f boolean DEFAULT false,
    objectid integer NOT NULL
);


ALTER TABLE public.diz_tavole5 OWNER TO postgres;

--
-- Name: diz_tavole5_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_tavole5_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_tavole5_objectid_seq OWNER TO postgres;

--
-- Name: diz_tavole5_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_tavole5_objectid_seq OWNED BY diz_tavole5.objectid;


--
-- Name: diz_tavole_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_tavole_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_tavole_objectid_seq OWNER TO postgres;

--
-- Name: diz_tavole_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_tavole_objectid_seq OWNED BY diz_tavole.objectid;


--
-- Name: diz_tipi; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_tipi (
    regione character varying(2) NOT NULL,
    codice character varying(10) NOT NULL,
    descriz character varying(150),
    priorita boolean DEFAULT false,
    objectid integer NOT NULL
);


ALTER TABLE public.diz_tipi OWNER TO postgres;

--
-- Name: diz_tipi_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE diz_tipi_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.diz_tipi_objectid_seq OWNER TO postgres;

--
-- Name: diz_tipi_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE diz_tipi_objectid_seq OWNED BY diz_tipi.objectid;


--
-- Name: diz_tiporil; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE diz_tiporil (
    codice character varying(1) NOT NULL,
    descrizion character varying(50)
);


ALTER TABLE public.diz_tiporil OWNER TO postgres;

--
-- Name: elab_dend; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE elab_dend (
    proprieta character varying(5) NOT NULL,
    cod_elab character varying(5) NOT NULL,
    tipo_ril character varying(1),
    aggr_riliev character varying(1),
    compresa character varying(3),
    aggr_specie character varying(1),
    calc_vol_ird character varying(1),
    objectid integer NOT NULL,
    id_av_dend character varying(50),
    aggr_riliev_curva character varying(1),
    compresa_curva character varying(3),
    k_schneider integer DEFAULT 0,
    mod_strati character varying(1),
    mod_curva character varying(1) DEFAULT 't'::character varying,
    da_stampare boolean DEFAULT false
);


ALTER TABLE public.elab_dend OWNER TO postgres;

--
-- Name: elab_dend2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE elab_dend2 (
    proprieta character varying(5) NOT NULL,
    cod_elab character varying(5) NOT NULL,
    gruppo_specie character varying(1) NOT NULL,
    tavola character varying(10),
    curva character varying(1),
    n_tariffa integer DEFAULT 0,
    ipso character varying(50),
    forma character varying(1),
    objectid integer NOT NULL,
    id_av_dend2 character varying(50),
    id_av_dend character varying(50),
    desc_gruppo_sp character varying(50)
);


ALTER TABLE public.elab_dend2 OWNER TO postgres;

--
-- Name: elab_dend2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE elab_dend2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.elab_dend2_objectid_seq OWNER TO postgres;

--
-- Name: elab_dend2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE elab_dend2_objectid_seq OWNED BY elab_dend2.objectid;


--
-- Name: elab_dend3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE elab_dend3 (
    proprieta character varying(5) NOT NULL,
    cod_elab character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    objectid integer NOT NULL,
    id_av_dend character varying(50)
);


ALTER TABLE public.elab_dend3 OWNER TO postgres;

--
-- Name: elab_dend3_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE elab_dend3_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.elab_dend3_objectid_seq OWNER TO postgres;

--
-- Name: elab_dend3_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE elab_dend3_objectid_seq OWNED BY elab_dend3.objectid;


--
-- Name: elab_dend4; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE elab_dend4 (
    proprieta character varying(5) NOT NULL,
    cod_elab character varying(5) NOT NULL,
    gruppo_specie character varying(2) NOT NULL,
    specie character varying(3) NOT NULL,
    objectid integer NOT NULL,
    id_av_dend2 character varying(50)
);


ALTER TABLE public.elab_dend4 OWNER TO postgres;

--
-- Name: elab_dend4_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE elab_dend4_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.elab_dend4_objectid_seq OWNER TO postgres;

--
-- Name: elab_dend4_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE elab_dend4_objectid_seq OWNED BY elab_dend4.objectid;


--
-- Name: elab_dend5; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE elab_dend5 (
    proprieta character varying(5) NOT NULL,
    cod_elab character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    objectid integer NOT NULL,
    id_av_dend character varying(50)
);


ALTER TABLE public.elab_dend5 OWNER TO postgres;

--
-- Name: elab_dend5_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE elab_dend5_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.elab_dend5_objectid_seq OWNER TO postgres;

--
-- Name: elab_dend5_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE elab_dend5_objectid_seq OWNED BY elab_dend5.objectid;


--
-- Name: elab_dend_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE elab_dend_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.elab_dend_objectid_seq OWNER TO postgres;

--
-- Name: elab_dend_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE elab_dend_objectid_seq OWNED BY elab_dend.objectid;


--
-- Name: erbacee; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE erbacee (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.erbacee OWNER TO postgres;

--
-- Name: erbacee2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE erbacee2 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.erbacee2 OWNER TO postgres;

--
-- Name: erbacee2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE erbacee2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.erbacee2_objectid_seq OWNER TO postgres;

--
-- Name: erbacee2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE erbacee2_objectid_seq OWNED BY erbacee2.objectid;


--
-- Name: erbacee3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE erbacee3 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.erbacee3 OWNER TO postgres;

--
-- Name: erbacee3_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE erbacee3_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.erbacee3_objectid_seq OWNER TO postgres;

--
-- Name: erbacee3_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE erbacee3_objectid_seq OWNED BY erbacee3.objectid;


--
-- Name: erbacee4; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE erbacee4 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.erbacee4 OWNER TO postgres;

--
-- Name: erbacee4_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE erbacee4_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.erbacee4_objectid_seq OWNER TO postgres;

--
-- Name: erbacee4_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE erbacee4_objectid_seq OWNED BY erbacee4.objectid;


--
-- Name: erbacee_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE erbacee_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.erbacee_objectid_seq OWNER TO postgres;

--
-- Name: erbacee_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE erbacee_objectid_seq OWNED BY erbacee.objectid;


--
-- Name: espo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE espo (
    codice character varying(1) NOT NULL,
    descriz character varying(10)
);


ALTER TABLE public.espo OWNER TO postgres;

--
-- Name: espos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE espos (
    codice character varying(1),
    descriz character varying(5)
);


ALTER TABLE public.espos OWNER TO postgres;

--
-- Name: fito_sug; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE fito_sug (
    codice character varying(1),
    descriz character varying(8)
);


ALTER TABLE public.fito_sug OWNER TO postgres;

--
-- Name: fondo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE fondo (
    codice character varying(1) NOT NULL,
    descriz character varying(10)
);


ALTER TABLE public.fondo OWNER TO postgres;

--
-- Name: frequenza; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE frequenza (
    codice character varying(1),
    descriz character varying(6)
);


ALTER TABLE public.frequenza OWNER TO postgres;

--
-- Name: fruitori; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE fruitori (
    codice character varying(1) NOT NULL,
    descriz character varying(7)
);


ALTER TABLE public.fruitori OWNER TO postgres;

--
-- Name: funzion2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE funzion2 (
    codice character varying(2) NOT NULL,
    descriz character varying(50)
);


ALTER TABLE public.funzion2 OWNER TO postgres;

--
-- Name: funzione; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE funzione (
    codice character varying(2) NOT NULL,
    descriz character varying(50)
);


ALTER TABLE public.funzione OWNER TO postgres;

SET default_with_oids = true;

--
-- Name: geometry_columns; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE geometry_columns (
    f_table_catalog character varying(256) NOT NULL,
    f_table_schema character varying(256) NOT NULL,
    f_table_name character varying(256) NOT NULL,
    f_geometry_column character varying(256) NOT NULL,
    coord_dimension integer NOT NULL,
    srid integer NOT NULL,
    type character varying(30) NOT NULL
);


ALTER TABLE public.geometry_columns OWNER TO postgres;

SET default_with_oids = false;

--
-- Name: infestan; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE infestan (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.infestan OWNER TO postgres;

--
-- Name: infestan_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE infestan_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.infestan_objectid_seq OWNER TO postgres;

--
-- Name: infestan_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE infestan_objectid_seq OWNED BY infestan.objectid;


--
-- Name: infr_past; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE infr_past (
    codice character varying(2) NOT NULL,
    descriz character varying(60)
);


ALTER TABLE public.infr_past OWNER TO postgres;

--
-- Name: int_via; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE int_via (
    codice character varying(2) NOT NULL,
    descriz character varying(60)
);


ALTER TABLE public.int_via OWNER TO postgres;

--
-- Name: interventi_localizzati_viabilita; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE interventi_localizzati_viabilita (
    objectid integer NOT NULL,
    shape text
);


ALTER TABLE public.interventi_localizzati_viabilita OWNER TO postgres;

--
-- Name: interventi_localizzati_viabilita_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE interventi_localizzati_viabilita_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.interventi_localizzati_viabilita_objectid_seq OWNER TO postgres;

--
-- Name: interventi_localizzati_viabilita_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE interventi_localizzati_viabilita_objectid_seq OWNED BY interventi_localizzati_viabilita.objectid;


--
-- Name: interventi_localizzati_viabilita_shape_index; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE interventi_localizzati_viabilita_shape_index (
    indexedobjectid integer NOT NULL,
    mingx integer NOT NULL,
    mingy integer NOT NULL,
    maxgx integer NOT NULL,
    maxgy integer NOT NULL
);


ALTER TABLE public.interventi_localizzati_viabilita_shape_index OWNER TO postgres;

--
-- Name: irrigaz; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE irrigaz (
    codice character varying(1),
    descriz character varying(16)
);


ALTER TABLE public.irrigaz OWNER TO postgres;

--
-- Name: leg_note; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE leg_note (
    archivio character varying(10),
    nomecampo character varying(20),
    intesta character varying(255),
    objectid integer NOT NULL
);


ALTER TABLE public.leg_note OWNER TO postgres;

--
-- Name: leg_note_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE leg_note_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.leg_note_objectid_seq OWNER TO postgres;

--
-- Name: leg_note_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE leg_note_objectid_seq OWNED BY leg_note.objectid;


--
-- Name: loc_dend; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE loc_dend (
    codice character varying(1),
    descriz character varying(25)
);


ALTER TABLE public.loc_dend OWNER TO postgres;

--
-- Name: localizz; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE localizz (
    codice character varying(2),
    descriz character varying(25)
);


ALTER TABLE public.localizz OWNER TO postgres;

--
-- Name: log; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE log (
    id integer NOT NULL,
    user_id integer,
    username character varying,
    objectid integer,
    description character varying,
    creation_datetime timestamp without time zone,
    text text
);


ALTER TABLE public.log OWNER TO postgres;

--
-- Name: log_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_id_seq OWNER TO postgres;

--
-- Name: log_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE log_id_seq OWNED BY log.id;


--
-- Name: manufatt; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE manufatt (
    codice character varying(1),
    descriz character varying(7)
);


ALTER TABLE public.manufatt OWNER TO postgres;

--
-- Name: manutenz; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE manutenz (
    codice character varying(1) NOT NULL,
    descriz character varying(30)
);


ALTER TABLE public.manutenz OWNER TO postgres;

--
-- Name: matrici; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE matrici (
    codice integer NOT NULL,
    descriz character varying(15)
);


ALTER TABLE public.matrici OWNER TO postgres;

--
-- Name: matrici_codice_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE matrici_codice_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.matrici_codice_seq OWNER TO postgres;

--
-- Name: matrici_codice_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE matrici_codice_seq OWNED BY matrici.codice;


--
-- Name: meccaniz; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE meccaniz (
    codice character varying(1) NOT NULL,
    descriz character varying(19)
);


ALTER TABLE public.meccaniz OWNER TO postgres;

--
-- Name: migliora; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE migliora (
    codice character varying(1),
    descriz character varying(30)
);


ALTER TABLE public.migliora OWNER TO postgres;

--
-- Name: mod_pasc; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE mod_pasc (
    codice character varying(1) NOT NULL,
    descriz character varying(9)
);


ALTER TABLE public.mod_pasc OWNER TO postgres;

--
-- Name: moti_macchia; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE moti_macchia (
    codice character(1) NOT NULL,
    descriz character(43)
);


ALTER TABLE public.moti_macchia OWNER TO postgres;

--
-- Name: mytable_myid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE mytable_myid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.mytable_myid_seq OWNER TO postgres;

--
-- Name: nomi_arc; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE nomi_arc (
    nome character varying(15) NOT NULL,
    descrizio character varying(40),
    tipo character varying(1),
    livello character varying(10),
    valnerina boolean DEFAULT false,
    progetto_bosco boolean DEFAULT false,
    rer boolean DEFAULT false,
    modificabi boolean DEFAULT false,
    appendi boolean DEFAULT false,
    query boolean DEFAULT false,
    issele boolean DEFAULT false,
    modo character varying(1),
    alto integer,
    basso integer,
    sinistro integer,
    destro integer,
    area integer,
    flagprn boolean DEFAULT false,
    driver character varying(6),
    contatore double precision,
    dove character varying(1),
    modif_camilla boolean,
    dubbi character(1),
    note_camilla character varying(255),
    modif_chiara boolean,
    note_chiara character varying(255)
);


ALTER TABLE public.nomi_arc OWNER TO postgres;

--
-- Name: note_a; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE note_a (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_nota character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying,
    id_av character varying(12)
);


ALTER TABLE public.note_a OWNER TO postgres;

--
-- Name: note_a_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE note_a_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.note_a_objectid_seq OWNER TO postgres;

--
-- Name: note_a_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE note_a_objectid_seq OWNED BY note_a.objectid;


--
-- Name: note_b; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE note_b (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_nota character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.note_b OWNER TO postgres;

--
-- Name: note_b2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE note_b2 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_nota character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.note_b2 OWNER TO postgres;

--
-- Name: note_b2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE note_b2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.note_b2_objectid_seq OWNER TO postgres;

--
-- Name: note_b2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE note_b2_objectid_seq OWNED BY note_b2.objectid;


--
-- Name: note_b3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE note_b3 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_nota character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.note_b3 OWNER TO postgres;

--
-- Name: note_b3_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE note_b3_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.note_b3_objectid_seq OWNER TO postgres;

--
-- Name: note_b3_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE note_b3_objectid_seq OWNED BY note_b3.objectid;


--
-- Name: note_b4; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE note_b4 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_nota character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.note_b4 OWNER TO postgres;

--
-- Name: note_b4_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE note_b4_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.note_b4_objectid_seq OWNER TO postgres;

--
-- Name: note_b4_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE note_b4_objectid_seq OWNED BY note_b4.objectid;


--
-- Name: note_b_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE note_b_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.note_b_objectid_seq OWNER TO postgres;

--
-- Name: note_b_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE note_b_objectid_seq OWNED BY note_b.objectid;


--
-- Name: note_n; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE note_n (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_ev_int character varying(3) NOT NULL,
    cod_nota character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    id_av_n character varying(20)
);


ALTER TABLE public.note_n OWNER TO postgres;

--
-- Name: note_n_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE note_n_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.note_n_objectid_seq OWNER TO postgres;

--
-- Name: note_n_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE note_n_objectid_seq OWNED BY note_n.objectid;


--
-- Name: novell; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE novell (
    codice character varying(1) NOT NULL,
    descriz character varying(31)
);


ALTER TABLE public.novell OWNER TO postgres;

--
-- Name: novell2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE novell2 (
    codice character varying(1) NOT NULL,
    descriz character varying(10)
);


ALTER TABLE public.novell2 OWNER TO postgres;

--
-- Name: op_logici; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE op_logici (
    codice character varying(3),
    descriz character varying(41)
);


ALTER TABLE public.op_logici OWNER TO postgres;

--
-- Name: operator; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE operator (
    codice character varying(3),
    descriz character varying(41)
);


ALTER TABLE public.operator OWNER TO postgres;

--
-- Name: origine; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE origine (
    codice integer NOT NULL,
    descriz character varying(41),
    per_stampa character varying(37)
);


ALTER TABLE public.origine OWNER TO postgres;

--
-- Name: origine_codice_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE origine_codice_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.origine_codice_seq OWNER TO postgres;

--
-- Name: origine_codice_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE origine_codice_seq OWNED BY origine.codice;


--
-- Name: ostacoli; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ostacoli (
    codice character varying(1) NOT NULL,
    descriz character varying(35)
);


ALTER TABLE public.ostacoli OWNER TO postgres;

--
-- Name: partcomp; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE partcomp (
    compresa_o character varying(3),
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying,
    id_av character varying(12),
    sup double precision,
    sup_bosc double precision,
    abstract text,
    compresa character varying(3),
    objectid integer NOT NULL,
    id_av_x_join character varying(50)
);


ALTER TABLE public.partcomp OWNER TO postgres;

--
-- Name: partcomp_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE partcomp_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.partcomp_objectid_seq OWNER TO postgres;

--
-- Name: partcomp_objectid_seq1; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE partcomp_objectid_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.partcomp_objectid_seq1 OWNER TO postgres;

--
-- Name: partcomp_objectid_seq1; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE partcomp_objectid_seq1 OWNED BY partcomp.objectid;


--
-- Name: particellare_gid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE particellare_gid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.particellare_gid_seq OWNER TO postgres;

--
-- Name: per_arbo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE per_arbo (
    codice character varying(1) NOT NULL,
    descriz character varying(6)
);


ALTER TABLE public.per_arbo OWNER TO postgres;

--
-- Name: per_inter; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE per_inter (
    codice character varying(1),
    descriz character varying(20)
);


ALTER TABLE public.per_inter OWNER TO postgres;

--
-- Name: pianota; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pianota (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying,
    anno character varying(4) DEFAULT '0000'::character varying NOT NULL,
    per_inter character varying(1) DEFAULT ' '::character varying,
    id_av character varying(12),
    sup_tagl double precision,
    ripresa_vol_perc double precision DEFAULT 0,
    p2 character varying(2),
    p3 character varying(2),
    p4 text,
    objectid integer NOT NULL
);


ALTER TABLE public.pianota OWNER TO postgres;

--
-- Name: pianota_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pianota_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pianota_objectid_seq OWNER TO postgres;

--
-- Name: pianota_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pianota_objectid_seq OWNED BY pianota.objectid;


--
-- Name: piu1_3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE piu1_3 (
    codice character varying(1) NOT NULL,
    descriz character varying(30)
);


ALTER TABLE public.piu1_3 OWNER TO postgres;

--
-- Name: piu2_3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE piu2_3 (
    codice character varying(1) NOT NULL,
    descriz character varying(30)
);


ALTER TABLE public.piu2_3 OWNER TO postgres;

--
-- Name: pollmatr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pollmatr (
    codice character varying(1) NOT NULL,
    descriz character varying(9)
);


ALTER TABLE public.pollmatr OWNER TO postgres;

--
-- Name: popolame; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE popolame (
    codice character varying(5) NOT NULL,
    popolament character varying(30),
    g_min double precision,
    g_max double precision,
    h_min double precision,
    h_max double precision,
    coeff_a double precision,
    coeff_b double precision,
    funz_cubat character varying(28),
    val_dendro character varying(100),
    objectid integer NOT NULL
);


ALTER TABLE public.popolame OWNER TO postgres;

--
-- Name: popolame_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE popolame_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.popolame_objectid_seq OWNER TO postgres;

--
-- Name: popolame_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE popolame_objectid_seq OWNED BY popolame.objectid;


--
-- Name: posfisio; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE posfisio (
    codice character varying(2) NOT NULL,
    descriz character varying(18)
);


ALTER TABLE public.posfisio OWNER TO postgres;

--
-- Name: prep_terr; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE prep_terr (
    codice character varying(1) NOT NULL,
    descriz character varying(15)
);


ALTER TABLE public.prep_terr OWNER TO postgres;

--
-- Name: pres_ass; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pres_ass (
    codice character varying(1) NOT NULL,
    valore character varying(8)
);


ALTER TABLE public.pres_ass OWNER TO postgres;

--
-- Name: prescri2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE prescri2 (
    codice character varying(2) NOT NULL,
    descriz character varying(51)
);


ALTER TABLE public.prescri2 OWNER TO postgres;

--
-- Name: prescri3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE prescri3 (
    codice character varying(2) NOT NULL,
    descriz character varying(40)
);


ALTER TABLE public.prescri3 OWNER TO postgres;

--
-- Name: prescri_via; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE prescri_via (
    codice character varying(2) NOT NULL,
    descriz character varying(70)
);


ALTER TABLE public.prescri_via OWNER TO postgres;

--
-- Name: prescriz; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE prescriz (
    codice character varying(2) NOT NULL,
    descriz character varying(55)
);


ALTER TABLE public.prescriz OWNER TO postgres;

--
-- Name: prescriz_globale; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE prescriz_globale (
    codice character varying(2) NOT NULL,
    descriz character varying(55),
    schede character varying(11)
);


ALTER TABLE public.prescriz_globale OWNER TO postgres;

--
-- Name: presstra; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE presstra (
    codice character varying(1),
    descriz character varying(9)
);


ALTER TABLE public.presstra OWNER TO postgres;

--
-- Name: problemi_a; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE problemi_a (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    tabella character varying(2) NOT NULL,
    campo character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying,
    id_av character varying(12)
);


ALTER TABLE public.problemi_a OWNER TO postgres;

--
-- Name: problemi_a_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE problemi_a_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.problemi_a_objectid_seq OWNER TO postgres;

--
-- Name: problemi_a_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE problemi_a_objectid_seq OWNED BY problemi_a.objectid;


--
-- Name: problemi_b1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE problemi_b1 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tabella character varying(2) NOT NULL,
    campo character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.problemi_b1 OWNER TO postgres;

--
-- Name: problemi_b1_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE problemi_b1_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.problemi_b1_objectid_seq OWNER TO postgres;

--
-- Name: problemi_b1_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE problemi_b1_objectid_seq OWNED BY problemi_b1.objectid;


--
-- Name: problemi_b2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE problemi_b2 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tabella character varying(2) NOT NULL,
    campo character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.problemi_b2 OWNER TO postgres;

--
-- Name: problemi_b2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE problemi_b2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.problemi_b2_objectid_seq OWNER TO postgres;

--
-- Name: problemi_b2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE problemi_b2_objectid_seq OWNED BY problemi_b2.objectid;


--
-- Name: problemi_b3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE problemi_b3 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tabella character varying(2) NOT NULL,
    campo character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.problemi_b3 OWNER TO postgres;

--
-- Name: problemi_b3_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE problemi_b3_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.problemi_b3_objectid_seq OWNER TO postgres;

--
-- Name: problemi_b3_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE problemi_b3_objectid_seq OWNED BY problemi_b3.objectid;


--
-- Name: problemi_b4; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE problemi_b4 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tabella character varying(2) NOT NULL,
    campo character varying(20) NOT NULL,
    nota character varying(255),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.problemi_b4 OWNER TO postgres;

--
-- Name: problemi_b4_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE problemi_b4_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.problemi_b4_objectid_seq OWNER TO postgres;

--
-- Name: problemi_b4_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE problemi_b4_objectid_seq OWNED BY problemi_b4.objectid;


--
-- Name: profile; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE profile (
    id integer NOT NULL,
    first_name character varying(50),
    last_name character varying(50),
    email character varying(50),
    phone character varying(20),
    web character varying(100),
    facebook character varying(100),
    google character varying(100),
    address_addres character varying(100),
    address_street_number character varying(10),
    address_city character varying(100),
    address_province character varying(2),
    address_zip character varying(6),
    lastupdate_datetime timestamp without time zone,
    organization character varying
);


ALTER TABLE public.profile OWNER TO postgres;

--
-- Name: profile_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE profile_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.profile_id_seq OWNER TO postgres;

--
-- Name: profile_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE profile_id_seq OWNED BY profile.id;


--
-- Name: propriet; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE propriet (
    codice character varying(5) NOT NULL,
    descrizion character varying(50),
    regione character varying(2),
    objectid integer NOT NULL
);


ALTER TABLE public.propriet OWNER TO postgres;

--
-- Name: propriet_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE propriet_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.propriet_objectid_seq OWNER TO postgres;

--
-- Name: propriet_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE propriet_objectid_seq OWNED BY propriet.objectid;


--
-- Name: province; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE province (
    regione character varying(2) NOT NULL,
    provincia character varying(3) NOT NULL,
    descriz character varying(30),
    sigla character varying(2),
    objectid integer NOT NULL,
    id_av_comuni character varying(255)
);


ALTER TABLE public.province OWNER TO postgres;

--
-- Name: province_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE province_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.province_objectid_seq OWNER TO postgres;

--
-- Name: province_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE province_objectid_seq OWNED BY province.objectid;


--
-- Name: qual_fus; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE qual_fus (
    codice character varying(1),
    descriz character varying(55)
);


ALTER TABLE public.qual_fus OWNER TO postgres;

--
-- Name: qual_pro; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE qual_pro (
    codice character varying(2) NOT NULL,
    descriz character varying(50)
);


ALTER TABLE public.qual_pro OWNER TO postgres;

--
-- Name: qual_via; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE qual_via (
    codice character varying(2) NOT NULL,
    descriz character varying(50)
);


ALTER TABLE public.qual_via OWNER TO postgres;

--
-- Name: relazion; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE relazion (
    padre character varying(15),
    figlio character varying(15),
    relazione character varying(255)
);


ALTER TABLE public.relazion OWNER TO postgres;

--
-- Name: rete_stradale; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE rete_stradale (
    objectid integer NOT NULL,
    shape text,
    id_av_e character varying(50),
    cod_str character varying(5),
    proprieta character varying(5),
    shape_length double precision
);


ALTER TABLE public.rete_stradale OWNER TO postgres;

--
-- Name: rete_stradale_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE rete_stradale_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rete_stradale_objectid_seq OWNER TO postgres;

--
-- Name: rete_stradale_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE rete_stradale_objectid_seq OWNED BY rete_stradale.objectid;


--
-- Name: rilevato; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE rilevato (
    codice character varying(3) NOT NULL,
    descriz character varying(20),
    objectid integer NOT NULL
);


ALTER TABLE public.rilevato OWNER TO postgres;

--
-- Name: rilevato_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE rilevato_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rilevato_objectid_seq OWNER TO postgres;

--
-- Name: rilevato_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE rilevato_objectid_seq OWNED BY rilevato.objectid;


--
-- Name: rinnov; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE rinnov (
    codice character varying(1) NOT NULL,
    descriz character varying(31)
);


ALTER TABLE public.rinnov OWNER TO postgres;

--
-- Name: rinnovaz; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE rinnovaz (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.rinnovaz OWNER TO postgres;

--
-- Name: rinnovaz_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE rinnovaz_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.rinnovaz_objectid_seq OWNER TO postgres;

--
-- Name: rinnovaz_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE rinnovaz_objectid_seq OWNED BY rinnovaz.objectid;


--
-- Name: ris_dend1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ris_dend1 (
    proprieta character varying(5) NOT NULL,
    cod_elab character varying(5) NOT NULL,
    gruppo_specie character varying(2) NOT NULL,
    verifica boolean DEFAULT false,
    sup_tot double precision DEFAULT 0,
    sup_bosc double precision DEFAULT 0,
    sup_impr double precision DEFAULT 0,
    sup_prod_non_bosc double precision DEFAULT 0,
    n_tot integer,
    g_tot double precision,
    v_tot double precision DEFAULT 0,
    n_ha integer,
    g_ha double precision,
    v_ha double precision DEFAULT 0,
    d_g double precision,
    d_dom double precision,
    i double precision DEFAULT 0,
    tp integer DEFAULT 0,
    pv double precision DEFAULT 0,
    ic double precision DEFAULT 0,
    ip double precision DEFAULT 0,
    n_ha_matr integer DEFAULT 0,
    n_ha_poll integer DEFAULT 0,
    n_ha_fust integer DEFAULT 0,
    g_ha_matr double precision DEFAULT 0,
    g_ha_poll double precision DEFAULT 0,
    g_ha_fust double precision DEFAULT 0,
    dg_matr double precision DEFAULT 0,
    dg_poll double precision DEFAULT 0,
    dg_fust double precision DEFAULT 0,
    n_tot_p integer,
    g_tot_p double precision,
    v_tot_p double precision DEFAULT 0,
    n_ha_matr_p integer DEFAULT 0,
    n_ha_poll_p integer DEFAULT 0,
    n_ha_fust_p integer DEFAULT 0,
    g_ha_matr_p double precision DEFAULT 0,
    g_ha_poll_p double precision DEFAULT 0,
    g_ha_fust_p double precision DEFAULT 0,
    dg_matr_p double precision DEFAULT 0,
    dg_poll_p double precision DEFAULT 0,
    dg_fust_p double precision DEFAULT 0,
    note text,
    num_oss_h integer DEFAULT 0,
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
    n_ha_p integer,
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
    objectid integer NOT NULL,
    id_av_dend2 character varying(50),
    id_av_dend character varying(50),
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
);


ALTER TABLE public.ris_dend1 OWNER TO postgres;

--
-- Name: ris_dend1_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ris_dend1_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ris_dend1_objectid_seq OWNER TO postgres;

--
-- Name: ris_dend1_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ris_dend1_objectid_seq OWNED BY ris_dend1.objectid;


--
-- Name: ris_dend2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ris_dend2 (
    proprieta character varying(5) NOT NULL,
    cod_elab character varying(5) NOT NULL,
    gruppo_specie character varying(2) NOT NULL,
    conta character varying(38) NOT NULL,
    d integer DEFAULT 0,
    h integer DEFAULT 0,
    h_semilog double precision DEFAULT 0,
    h_log double precision DEFAULT 0,
    h_rad double precision DEFAULT 0,
    h_parab double precision DEFAULT 0,
    h_invparab double precision DEFAULT 0,
    h_esterna double precision DEFAULT 0,
    v_semilog integer DEFAULT 0,
    v_log integer DEFAULT 0,
    v_rad integer DEFAULT 0,
    v_parab integer DEFAULT 0,
    v_invparab integer DEFAULT 0,
    v_esterna integer DEFAULT 0,
    objectid integer NOT NULL,
    id_av_dend2 character varying(50)
);


ALTER TABLE public.ris_dend2 OWNER TO postgres;

--
-- Name: ris_dend2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ris_dend2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ris_dend2_objectid_seq OWNER TO postgres;

--
-- Name: ris_dend2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ris_dend2_objectid_seq OWNED BY ris_dend2.objectid;


--
-- Name: ris_dend3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ris_dend3 (
    proprieta character varying(5) NOT NULL,
    cod_elab character varying(5) NOT NULL,
    gruppo_specie character varying(2) NOT NULL,
    specie character varying(3) NOT NULL,
    d integer DEFAULT 0 NOT NULL,
    n integer DEFAULT 0,
    n_ha integer DEFAULT 0,
    g_ha double precision DEFAULT 0,
    v_ha double precision DEFAULT 0,
    n_ha_perc double precision DEFAULT 0,
    g_ha_perc double precision DEFAULT 0,
    v_ha_perc double precision DEFAULT 0,
    objectid integer NOT NULL,
    id_av_dend3 character varying(50)
);


ALTER TABLE public.ris_dend3 OWNER TO postgres;

--
-- Name: ris_dend3_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ris_dend3_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ris_dend3_objectid_seq OWNER TO postgres;

--
-- Name: ris_dend3_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE ris_dend3_objectid_seq OWNED BY ris_dend3.objectid;


--
-- Name: scarpate; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE scarpate (
    codice character varying(1),
    descriz character varying(5)
);


ALTER TABLE public.scarpate OWNER TO postgres;

--
-- Name: sched_b1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_b1 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    id_av character varying(12),
    sup double precision,
    l character varying(2),
    l1 character varying(50),
    e1 character varying(1),
    q1 double precision,
    q2 double precision,
    u character varying(2),
    g character varying(2),
    s character varying(2),
    m character varying(1),
    n_mat double precision,
    ce_mat character varying(1),
    turni double precision,
    o character varying(1),
    c1 double precision,
    c2 double precision,
    n_agam character varying(1),
    senescenti character varying(1),
    colt_cast character varying(1),
    sr character varying(1),
    se character varying(1),
    morta character varying(2),
    alberiterr character varying(1),
    prep_terr character varying(1),
    sesto_imp_tra_file double precision DEFAULT 0,
    sesto_imp_su_file double precision DEFAULT 0,
    buche integer DEFAULT 0,
    vig character varying(1),
    v character varying(1),
    ce double precision,
    d character varying(1),
    chiarie double precision,
    n1 character varying(1),
    n2 character varying(1),
    n3 character varying(1),
    spe_nov character varying(3),
    f character varying(2),
    f2 character varying(2),
    p2 character varying(2),
    p3 character varying(2),
    p4 character varying(20),
    g1 character varying(1),
    sub_viab character varying(1),
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
    int2 character varying(2),
    int3 character varying(20),
    tipo character varying(3),
    objectid integer NOT NULL,
    d21 double precision,
    d22 double precision,
    d23 double precision,
    d24 double precision,
    d25 double precision,
    d26 double precision
);


ALTER TABLE public.sched_b1 OWNER TO postgres;

--
-- Name: sched_b1_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_b1_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_b1_objectid_seq OWNER TO postgres;

--
-- Name: sched_b1_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_b1_objectid_seq OWNED BY sched_b1.objectid;


--
-- Name: sched_b2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_b2 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    codiope character varying(3),
    datasch timestamp without time zone,
    id_av character varying(12),
    u character varying(2),
    tipo character varying(50),
    anno_imp integer DEFAULT 0,
    anno_dest integer DEFAULT 0,
    comp_spe character varying(50),
    cod_coltup character varying(3),
    cod_coltus character varying(3),
    dist double precision DEFAULT 0,
    dist_princ double precision DEFAULT 0,
    sesto_imp_arb character varying(1),
    sesto_princ character varying(1),
    vig_arb_princ character varying(1),
    vig_arb_sec character varying(1),
    fall double precision DEFAULT 0,
    qual_pri character varying(1),
    colt_cast character varying(50),
    vig_cast character varying(1),
    sesto_imp_cast character varying(1),
    cod_coltub character varying(3),
    cod_coltua character varying(3),
    fungo_ospi character varying(3),
    sesto_imp_tart character varying(1),
    num_piante integer DEFAULT 0,
    piant_tart integer DEFAULT 0,
    c1 double precision DEFAULT 0,
    o character varying(1),
    vig_sug character varying(1),
    v character varying(1),
    d character varying(1),
    n1 character varying(1),
    n2 character varying(1),
    n3 character varying(1),
    spe_nov character varying(3),
    int2 character varying(2),
    int3 character varying(20),
    g character varying(2),
    ce double precision DEFAULT 0,
    sr character varying(1),
    se character varying(1),
    g1 character varying(50),
    sub_viab character varying(1),
    p2 character varying(2),
    p3 character varying(2),
    p4 character varying(20),
    note text,
    objectid integer NOT NULL,
    d1 double precision,
    d3 double precision,
    d5 double precision,
    d10 double precision,
    d11 double precision,
    d12 double precision,
    d13 double precision,
    fito_sug character varying(1),
    s character varying(1),
    tipo_int_sug character varying(1),
    tipo_prescr_sug character varying(1),
    estraz_passata character varying(4),
    estraz_futura character varying(4),
    fito_bio boolean DEFAULT false,
    fito_abio boolean DEFAULT false,
    fito_bio_spec character varying(50),
    fito_abio_spec character varying(50)
);


ALTER TABLE public.sched_b2 OWNER TO postgres;

--
-- Name: sched_b2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_b2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_b2_objectid_seq OWNER TO postgres;

--
-- Name: sched_b2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_b2_objectid_seq OWNED BY sched_b2.objectid;


--
-- Name: sched_b3; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_b3 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    id_av character varying(12),
    sup double precision,
    l character varying(2),
    l1 character varying(50),
    e1 character varying(1),
    q1 double precision,
    q2 double precision,
    u character varying(2),
    h double precision,
    cop_arbu double precision,
    se character varying(1),
    cop_erba double precision,
    sr character varying(1),
    sr_perc integer DEFAULT 0,
    cop_arbo integer DEFAULT 0,
    comp_coti character varying(1),
    dens_coti character varying(1),
    infestanti character varying(1),
    modalpasco character varying(1),
    duratapasc double precision,
    fruitori character varying(1),
    caricopasc character varying(1),
    n_capi double precision,
    accespasc character varying(1),
    disph2o character varying(1),
    possirrig character varying(1),
    possmeccan character varying(1),
    possmungit character varying(1),
    infr_past character varying(1),
    n_abbevera double precision,
    stato_abbe character varying(1),
    n1 character varying(1),
    n2 character varying(1),
    f character varying(2),
    f2 character varying(2),
    p2 character varying(2),
    p3 character varying(2),
    p4 character varying(20),
    g1 character varying(1),
    sub_viab character varying(1),
    diffalbcol character varying(1),
    modi integer DEFAULT 0,
    note text,
    objectid integer NOT NULL
);


ALTER TABLE public.sched_b3 OWNER TO postgres;

--
-- Name: sched_b3_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_b3_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_b3_objectid_seq OWNER TO postgres;

--
-- Name: sched_b3_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_b3_objectid_seq OWNED BY sched_b3.objectid;


--
-- Name: sched_b4; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_b4 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    id_av character varying(12),
    sup double precision,
    u character varying(2),
    vert character varying(1),
    ce_min2 double precision,
    h_min2 double precision DEFAULT 0,
    ce_mag2 double precision,
    h_mag2 double precision DEFAULT 0,
    motivo1 character varying(1),
    motivo2 character varying(255),
    se character varying(1),
    int2 character varying(2),
    int3 character varying(20),
    f character varying(2),
    g character varying(2),
    p2 character varying(2),
    p3 character varying(2),
    p4 character varying(20),
    g1 character varying(1),
    sub_viab character varying(1),
    note text,
    tipo character varying(3),
    objectid integer NOT NULL
);


ALTER TABLE public.sched_b4 OWNER TO postgres;

--
-- Name: sched_b4_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_b4_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_b4_objectid_seq OWNER TO postgres;

--
-- Name: sched_b4_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_b4_objectid_seq OWNED BY sched_b4.objectid;


--
-- Name: sched_c1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_c1 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    diam integer DEFAULT 0 NOT NULL,
    specie character varying(3) NOT NULL,
    rilievo integer DEFAULT 0,
    prelievo integer DEFAULT 0,
    poll_matr character varying(1),
    objectid integer NOT NULL,
    id_av character varying(12)
);


ALTER TABLE public.sched_c1 OWNER TO postgres;

--
-- Name: sched_c1_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_c1_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_c1_objectid_seq OWNER TO postgres;

--
-- Name: sched_c1_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_c1_objectid_seq OWNED BY sched_c1.objectid;


--
-- Name: sched_c2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_c2 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    conta character varying(38) NOT NULL,
    id_av character varying(12),
    specie character varying(3),
    poll_matr character varying(1),
    diam integer DEFAULT 0,
    h double precision DEFAULT 0,
    i double precision DEFAULT 0,
    h_stim double precision DEFAULT 0,
    objectid integer NOT NULL
);


ALTER TABLE public.sched_c2 OWNER TO postgres;

--
-- Name: sched_c2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_c2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_c2_objectid_seq OWNER TO postgres;

--
-- Name: sched_c2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_c2_objectid_seq OWNED BY sched_c2.objectid;


--
-- Name: sched_d1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_d1 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    n_camp integer DEFAULT 0 NOT NULL,
    conta character varying(38) NOT NULL,
    id_av character varying(12),
    specie character varying(3),
    diam integer DEFAULT 0,
    h double precision DEFAULT 0,
    i double precision DEFAULT 0,
    p integer DEFAULT 0,
    h_stim double precision DEFAULT 0,
    poll_matr character varying(1),
    frequenza double precision DEFAULT 1,
    objectid integer NOT NULL,
    freq_prel double precision DEFAULT 0
);


ALTER TABLE public.sched_d1 OWNER TO postgres;

--
-- Name: sched_d1_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_d1_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_d1_objectid_seq OWNER TO postgres;

--
-- Name: sched_d1_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_d1_objectid_seq OWNED BY sched_d1.objectid;


--
-- Name: sched_e1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_e1 (
    proprieta character varying(5) NOT NULL,
    strada character varying(4) NOT NULL,
    cod_inter character varying(2) NOT NULL,
    descrizione character varying(50),
    objectid integer NOT NULL,
    id_av_e character varying(20)
);


ALTER TABLE public.sched_e1 OWNER TO postgres;

--
-- Name: sched_e1_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_e1_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_e1_objectid_seq OWNER TO postgres;

--
-- Name: sched_e1_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_e1_objectid_seq OWNED BY sched_e1.objectid;


--
-- Name: sched_f1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_f1 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    n_camp integer DEFAULT 0 NOT NULL,
    specie character varying(3) NOT NULL,
    id_av character varying(12),
    n_cont double precision DEFAULT 0,
    n_prel integer DEFAULT 0,
    objectid integer NOT NULL
);


ALTER TABLE public.sched_f1 OWNER TO postgres;

--
-- Name: sched_f1_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_f1_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_f1_objectid_seq OWNER TO postgres;

--
-- Name: sched_f1_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_f1_objectid_seq OWNED BY sched_f1.objectid;


--
-- Name: sched_f2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_f2 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    n_camp integer DEFAULT 0 NOT NULL,
    conta character varying(38) NOT NULL,
    id_av character varying(12),
    specie character varying(3),
    diam integer DEFAULT 0,
    h double precision DEFAULT 0,
    h_stim double precision DEFAULT 0,
    objectid integer NOT NULL
);


ALTER TABLE public.sched_f2 OWNER TO postgres;

--
-- Name: sched_f2_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_f2_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_f2_objectid_seq OWNER TO postgres;

--
-- Name: sched_f2_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_f2_objectid_seq OWNED BY sched_f2.objectid;


--
-- Name: sched_l1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_l1 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    num_alb character varying(5) NOT NULL,
    elemento character varying(1) NOT NULL,
    h_sez double precision NOT NULL,
    d_sez double precision,
    objectid integer NOT NULL,
    id_av character varying(50),
    id_av_l1 character varying(50)
);


ALTER TABLE public.sched_l1 OWNER TO postgres;

--
-- Name: sched_l1_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_l1_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_l1_objectid_seq OWNER TO postgres;

--
-- Name: sched_l1_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_l1_objectid_seq OWNED BY sched_l1.objectid;


--
-- Name: sched_l1b; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sched_l1b (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    num_alb character varying(5) NOT NULL,
    elemento character varying(2) NOT NULL,
    sezione character varying(1),
    vol double precision DEFAULT 0,
    objectid integer NOT NULL,
    id_av character varying(12),
    id_av_l1b character varying(20),
    id_av_l1 character varying(50)
);


ALTER TABLE public.sched_l1b OWNER TO postgres;

--
-- Name: sched_l1b_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sched_l1b_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sched_l1b_objectid_seq OWNER TO postgres;

--
-- Name: sched_l1b_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sched_l1b_objectid_seq OWNED BY sched_l1b.objectid;


--
-- Name: schede_a; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_a (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying,
    id_av character varying(12),
    area_gis double precision,
    peri_gis double precision,
    datasch date,
    comune character varying(6),
    toponimo character varying(50),
    foglioctr character varying(10),
    sezionectr character varying(10),
    codiope character varying(3),
    sup_tot double precision,
    sup integer DEFAULT 0,
    am double precision,
    ama double precision,
    ap double precision,
    pm double precision,
    pp double precision,
    e1 character varying(1),
    pf1 character varying(2),
    a2 character varying(1),
    a3 character varying(1),
    a4 character varying(1),
    a5 character varying(1) DEFAULT '0'::character varying,
    a6 character varying(1),
    a7 character varying(1),
    a8 character varying(20),
    r2 character varying(1),
    r3 character varying(1),
    r4 character varying(1),
    r5 character varying(1),
    r6 character varying(1),
    r7 character varying(20),
    f2 character varying(1),
    f3 character varying(1),
    f4 character varying(1),
    f5 character varying(1),
    f6 character varying(1),
    f7 character varying(1),
    f8 character varying(1),
    f9 character varying(1),
    f10 character varying(1),
    f11 character varying(1),
    f12 character varying(20),
    v1 double precision,
    v3 double precision,
    piazzali character varying(1),
    o character varying(1),
    p1 boolean DEFAULT false,
    p2 boolean DEFAULT false,
    p3 boolean DEFAULT false,
    p4 boolean DEFAULT false,
    p5 boolean DEFAULT false,
    p6 boolean DEFAULT false,
    p8 character varying(20),
    p7 character varying(1),
    p9 character varying(20),
    m1 boolean DEFAULT false,
    m2 boolean DEFAULT false,
    m3 boolean DEFAULT false,
    m4 boolean DEFAULT false,
    m5 boolean DEFAULT false,
    m6 boolean DEFAULT false,
    m7 boolean DEFAULT false,
    m8 boolean DEFAULT false,
    m9 boolean DEFAULT false,
    m10 boolean DEFAULT false,
    m11 boolean DEFAULT false,
    m12 boolean DEFAULT false,
    m13 boolean DEFAULT false,
    m14 boolean DEFAULT false,
    m15 boolean DEFAULT false,
    m16 boolean DEFAULT false,
    m17 boolean DEFAULT false,
    m18 boolean DEFAULT false,
    m19 character varying(20),
    m20 boolean DEFAULT false,
    m21 boolean DEFAULT false,
    m22 boolean DEFAULT false,
    m23 boolean DEFAULT false,
    c1 boolean DEFAULT false,
    c2 boolean DEFAULT false,
    c3 boolean DEFAULT false,
    c4 boolean DEFAULT false,
    c5 boolean DEFAULT false,
    c6 character varying(20),
    i1 double precision,
    i2 double precision,
    i3 boolean DEFAULT false,
    i4 boolean DEFAULT false,
    i5 boolean DEFAULT false,
    i6 boolean DEFAULT false,
    i7 boolean DEFAULT false,
    i8 character varying(20),
    i21 double precision,
    i22 double precision,
    n2 boolean DEFAULT false,
    n3 boolean DEFAULT false,
    n4 boolean DEFAULT false,
    n5 boolean DEFAULT false,
    n6 boolean DEFAULT false,
    n7 boolean DEFAULT false,
    n8 boolean DEFAULT false,
    n9 boolean DEFAULT false,
    n10 boolean DEFAULT false,
    n11 boolean DEFAULT false,
    n12 boolean DEFAULT false,
    n13 boolean DEFAULT false,
    n14 boolean DEFAULT false,
    n15 boolean DEFAULT false,
    n16 boolean DEFAULT false,
    n17 boolean DEFAULT false,
    n18 character varying(20) DEFAULT 'Specifiche'::character varying,
    note text,
    delimitata character varying(1),
    localizzata character varying(50),
    objectid integer NOT NULL
);


ALTER TABLE public.schede_a OWNER TO postgres;

--
-- Name: schede_a_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_a_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_a_objectid_seq OWNER TO postgres;

--
-- Name: schede_a_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_a_objectid_seq OWNED BY schede_a.objectid;


--
-- Name: schede_b; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_b (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    id_av character varying(12),
    u character varying(2) NOT NULL,
    area_gis double precision DEFAULT 0,
    peri_gis double precision DEFAULT 0,
    sup integer DEFAULT 0,
    t character varying(10),
    objectid integer NOT NULL
);


ALTER TABLE public.schede_b OWNER TO postgres;

--
-- Name: schede_b_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_b_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_b_objectid_seq OWNER TO postgres;

--
-- Name: schede_b_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_b_objectid_seq OWNED BY schede_b.objectid;


--
-- Name: schede_c; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_c (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    id_av character varying(12),
    codiope character varying(3),
    c_anel integer DEFAULT 0,
    m_anel integer DEFAULT 0,
    note text,
    objectid integer NOT NULL
);


ALTER TABLE public.schede_c OWNER TO postgres;

--
-- Name: schede_c_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_c_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_c_objectid_seq OWNER TO postgres;

--
-- Name: schede_c_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_c_objectid_seq OWNED BY schede_c.objectid;


--
-- Name: schede_d; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_d (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    n_camp integer DEFAULT 0 NOT NULL,
    codiope character varying(3),
    id_av character varying(12),
    p integer DEFAULT 0,
    x double precision DEFAULT 0,
    y double precision DEFAULT 0,
    t_camp character varying(1),
    rag double precision DEFAULT 0,
    rag2 double precision DEFAULT 0,
    f double precision DEFAULT 0,
    c_anel integer DEFAULT 0,
    m_anel integer DEFAULT 0,
    note text,
    objectid integer NOT NULL
);


ALTER TABLE public.schede_d OWNER TO postgres;

--
-- Name: schede_d_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_d_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_d_objectid_seq OWNER TO postgres;

--
-- Name: schede_d_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_d_objectid_seq OWNED BY schede_d.objectid;


--
-- Name: schede_e; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_e (
    proprieta character varying(5) NOT NULL,
    strada character varying(4) NOT NULL,
    nome_strada character varying(50),
    da_valle character varying(50),
    a_monte character varying(50),
    lung_gis integer DEFAULT 0,
    data timestamp without time zone,
    codiope character varying(3),
    class_amm character varying(1),
    class_prop character varying(2),
    qual_att character varying(1),
    qual_prop character varying(1),
    accesso character varying(1),
    transitabi character varying(1),
    manutenzione character varying(1),
    urgenza character varying(1),
    scarpate boolean DEFAULT false,
    corsi_acqua boolean DEFAULT false,
    tombini boolean DEFAULT false,
    can_tras boolean DEFAULT false,
    can_lat boolean DEFAULT false,
    aib boolean DEFAULT false,
    piazzole boolean DEFAULT false,
    imposti boolean DEFAULT false,
    reg_accesso boolean DEFAULT false,
    manufatti boolean DEFAULT false,
    altro boolean DEFAULT false,
    specifica character varying(50),
    note text,
    abstract text,
    larg_min double precision DEFAULT 0,
    larg_prev double precision DEFAULT 0,
    raggio double precision DEFAULT 0,
    fondo character varying(1),
    pend_media integer DEFAULT 0,
    pend_max integer DEFAULT 0,
    contropend integer DEFAULT 0,
    q_piazzole character varying(1),
    objectid integer NOT NULL,
    id_av_e character varying(20)
);


ALTER TABLE public.schede_e OWNER TO postgres;

--
-- Name: schede_e_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_e_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_e_objectid_seq OWNER TO postgres;

--
-- Name: schede_e_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_e_objectid_seq OWNED BY schede_e.objectid;


--
-- Name: schede_f; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_f (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    n_camp integer DEFAULT 0 NOT NULL,
    codiope character varying(3),
    id_av character varying(12),
    x double precision DEFAULT 0,
    y double precision DEFAULT 0,
    f double precision DEFAULT 0,
    note text,
    d_ogni integer DEFAULT 0,
    h_ogni integer DEFAULT 0,
    objectid integer NOT NULL
);


ALTER TABLE public.schede_f OWNER TO postgres;

--
-- Name: schede_f_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_f_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_f_objectid_seq OWNER TO postgres;

--
-- Name: schede_f_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_f_objectid_seq OWNED BY schede_f.objectid;


--
-- Name: schede_g; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_g (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    n_ads integer DEFAULT 0 NOT NULL,
    id_av character varying(12),
    fatt_num integer,
    codiope character varying(3),
    datasch timestamp without time zone,
    n_alb_cont integer DEFAULT 0,
    h1 double precision DEFAULT 0,
    h2 double precision DEFAULT 0,
    h3 double precision DEFAULT 0,
    h4 double precision DEFAULT 0,
    h5 double precision DEFAULT 0,
    d1 integer DEFAULT 0,
    d2 integer DEFAULT 0,
    d3 integer DEFAULT 0,
    d4 integer DEFAULT 0,
    d5 integer DEFAULT 0,
    d6 integer DEFAULT 0,
    d7 integer DEFAULT 0,
    tavola character varying(3),
    objectid integer NOT NULL
);


ALTER TABLE public.schede_g OWNER TO postgres;

--
-- Name: schede_g1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_g1 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    fatt_num integer,
    codiope character varying(3),
    datasch timestamp without time zone,
    tavola character varying(3),
    id_av character varying(12),
    d_ogni integer DEFAULT 0,
    note text,
    objectid integer NOT NULL
);


ALTER TABLE public.schede_g1 OWNER TO postgres;

--
-- Name: schede_g1_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_g1_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_g1_objectid_seq OWNER TO postgres;

--
-- Name: schede_g1_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_g1_objectid_seq OWNED BY schede_g1.objectid;


--
-- Name: schede_g_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_g_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_g_objectid_seq OWNER TO postgres;

--
-- Name: schede_g_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_g_objectid_seq OWNED BY schede_g.objectid;


--
-- Name: schede_n; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_n (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_ev_int character varying(3) DEFAULT ' '::character varying NOT NULL,
    id_av character varying(12),
    eve_int character varying(1),
    datasch timestamp without time zone,
    dataeven timestamp without time zone,
    codiope character varying(3),
    l character varying(2),
    l1 character varying(50),
    sup double precision DEFAULT 0,
    lung double precision DEFAULT 0,
    evento character varying(1),
    spec_event character varying(255),
    desc_eve text,
    intervento character varying(2),
    spec_inter character varying(255),
    m_prev double precision DEFAULT 0,
    m_prel double precision DEFAULT 0,
    desc_modi text,
    desc_effet text,
    id_gesfore character varying(5),
    intervento_arbus character varying(2),
    intervento_specia character varying(2),
    intervento_viabil character varying(2),
    tipo_inter character varying(1),
    objectid integer NOT NULL,
    id_av_n character varying(20)
);


ALTER TABLE public.schede_n OWNER TO postgres;

--
-- Name: schede_n_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_n_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_n_objectid_seq OWNER TO postgres;

--
-- Name: schede_n_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_n_objectid_seq OWNED BY schede_n.objectid;


--
-- Name: schede_x; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE schede_x (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    tipo_ril character varying(1) NOT NULL,
    data timestamp without time zone NOT NULL,
    id_av character varying(12),
    objectid integer NOT NULL
);


ALTER TABLE public.schede_x OWNER TO postgres;

--
-- Name: schede_x_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE schede_x_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.schede_x_objectid_seq OWNER TO postgres;

--
-- Name: schede_x_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE schede_x_objectid_seq OWNED BY schede_x.objectid;


--
-- Name: senescen; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE senescen (
    codice character varying(1) NOT NULL,
    descriz character varying(19)
);


ALTER TABLE public.senescen OWNER TO postgres;

--
-- Name: sesto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sesto (
    codice character varying(1) NOT NULL,
    descriz character varying(10)
);


ALTER TABLE public.sesto OWNER TO postgres;

--
-- Name: si_no; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE si_no (
    codice character varying(1) NOT NULL,
    valore character varying(2)
);


ALTER TABLE public.si_no OWNER TO postgres;

--
-- Name: si_no_num; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE si_no_num (
    codice character varying(1),
    valore character varying(2)
);


ALTER TABLE public.si_no_num OWNER TO postgres;

--
-- Name: sistema; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sistema (
    codice character varying(2) NOT NULL,
    descriz character varying(60)
);


ALTER TABLE public.sistema OWNER TO postgres;

--
-- Name: sistema_sug; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sistema_sug (
    codice character varying(2),
    descriz character varying(60)
);


ALTER TABLE public.sistema_sug OWNER TO postgres;

--
-- Name: spatial_ref_sys; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE spatial_ref_sys (
    srid integer NOT NULL,
    auth_name character varying(256),
    auth_srid integer,
    srtext character varying(2048),
    proj4text character varying(2048)
);


ALTER TABLE public.spatial_ref_sys OWNER TO postgres;

--
-- Name: specie_p; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE specie_p (
    codice character varying(1) NOT NULL,
    descriz character varying(7)
);


ALTER TABLE public.specie_p OWNER TO postgres;

--
-- Name: stime_b1; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE stime_b1 (
    proprieta character varying(5) NOT NULL,
    cod_part character varying(5) NOT NULL,
    cod_fo character varying(2) DEFAULT ' 1'::character varying NOT NULL,
    cod_coltu character varying(3) NOT NULL,
    cod_coper character varying(1),
    massa_tot integer,
    id_av character varying(12)
);


ALTER TABLE public.stime_b1 OWNER TO postgres;

--
-- Name: strati; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE strati (
    codice character varying(1) NOT NULL,
    descriz character varying(5)
);


ALTER TABLE public.strati OWNER TO postgres;

--
-- Name: strati2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE strati2 (
    codice character varying(1) NOT NULL,
    descriz character varying(5)
);


ALTER TABLE public.strati2 OWNER TO postgres;

--
-- Name: struttu; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE struttu (
    codice integer NOT NULL,
    descriz character varying(70),
    regione character varying(2)
);


ALTER TABLE public.struttu OWNER TO postgres;

--
-- Name: struttu_codice_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE struttu_codice_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.struttu_codice_seq OWNER TO postgres;

--
-- Name: struttu_codice_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE struttu_codice_seq OWNED BY struttu.codice;


--
-- Name: struttu_sug; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE struttu_sug (
    codice character varying(1) NOT NULL,
    descriz character varying(70)
);


ALTER TABLE public.struttu_sug OWNER TO postgres;

--
-- Name: struttu_vert; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE struttu_vert (
    codice character(1) NOT NULL,
    descriz character(11)
);


ALTER TABLE public.struttu_vert OWNER TO postgres;

--
-- Name: tipi_for; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipi_for (
    proprieta character varying(3),
    cod_part character varying(5),
    cod_fo character varying(2) DEFAULT ' 1'::character varying,
    tipo character varying(3),
    objectid integer NOT NULL
);


ALTER TABLE public.tipi_for OWNER TO postgres;

--
-- Name: tipi_for_objectid_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipi_for_objectid_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipi_for_objectid_seq OWNER TO postgres;

--
-- Name: tipi_for_objectid_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipi_for_objectid_seq OWNED BY tipi_for.objectid;


--
-- Name: tipi_tav; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipi_tav (
    codice character varying(1),
    descrizion character varying(15)
);


ALTER TABLE public.tipi_tav OWNER TO postgres;

--
-- Name: tipo_imp; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_imp (
    codice character varying(1) NOT NULL,
    descrizion character varying(19)
);


ALTER TABLE public.tipo_imp OWNER TO postgres;

--
-- Name: tipo_int_sug; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_int_sug (
    codice character varying(1) NOT NULL,
    descrizion character varying(138)
);


ALTER TABLE public.tipo_int_sug OWNER TO postgres;

--
-- Name: tipo_stampa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_stampa (
    codice character varying(1),
    descrizion character varying(15)
);


ALTER TABLE public.tipo_stampa OWNER TO postgres;

--
-- Name: tipo_tavola; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_tavola (
    codice character varying(1) NOT NULL,
    tipo_tavola character varying(50)
);


ALTER TABLE public.tipo_tavola OWNER TO postgres;

--
-- Name: tipologi; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipologi (
    codice character varying(3),
    descriz character varying(20),
    necesssita character varying(1)
);


ALTER TABLE public.tipologi OWNER TO postgres;

--
-- Name: tmp_schede_a; Type: VIEW; Schema: public; Owner: postgres
--

CREATE VIEW tmp_schede_a AS
    SELECT schede_a.codiope, schede_a.datasch, schede_a.sup_tot, schede_a.sup, schede_a.cod_part, schede_a.toponimo, schede_a.ap, schede_a.pp, schede_a.comune, schede_a.delimitata, schede_a.e1, schede_a.pf1, schede_a.a2, schede_a.a3, schede_a.a4, schede_a.a5, schede_a.a6, schede_a.a7, schede_a.a8, schede_a.r2, schede_a.r3, schede_a.r4, schede_a.r5, schede_a.r6, schede_a.r7, schede_a.f2, schede_a.f3, schede_a.f4, schede_a.f5, schede_a.f6, schede_a.f7, schede_a.f8, schede_a.f10, schede_a.f11, schede_a.f12, schede_a.v3, schede_a.v1, schede_a.o, schede_a.c1, schede_a.c2, schede_a.c3, schede_a.c4, schede_a.c5, schede_a.c6, schede_a.p1, schede_a.p2, schede_a.p3, schede_a.p4, schede_a.p5, schede_a.p6, schede_a.p7, schede_a.p8, schede_a.p9, schede_a.i1, schede_a.i2, schede_a.i3, schede_a.i4, schede_a.i5, schede_a.i6, schede_a.i7, schede_a.i8, schede_a.i21, schede_a.i22, schede_a.m1, schede_a.m2, schede_a.m21, schede_a.m3, schede_a.m4, schede_a.m22, schede_a.m20, schede_a.m5, schede_a.m6, schede_a.m7, schede_a.m8, schede_a.m9, schede_a.m10, schede_a.m12, schede_a.m13, schede_a.m15, schede_a.m14, schede_a.m23, schede_a.m16, schede_a.m17, schede_a.m18, schede_a.m19, schede_a.note FROM schede_a WHERE (((schede_a.proprieta)::text = '14003'::text) AND ((schede_a.cod_part)::text = '0001 '::text));


ALTER TABLE public.tmp_schede_a OWNER TO postgres;

--
-- Name: transit; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE transit (
    codice character varying(1),
    descrizion character varying(7)
);


ALTER TABLE public.transit OWNER TO postgres;

--
-- Name: transita; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE transita (
    codice character varying(1) NOT NULL,
    descriz character varying(7)
);


ALTER TABLE public.transita OWNER TO postgres;

--
-- Name: urg_via; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE urg_via (
    codice character varying(1),
    descriz character varying(27)
);


ALTER TABLE public.urg_via OWNER TO postgres;

--
-- Name: urgenza; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE urgenza (
    codice character varying(1) NOT NULL,
    descriz character varying(27)
);


ALTER TABLE public.urgenza OWNER TO postgres;

--
-- Name: user; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "user" (
    id integer NOT NULL,
    username character varying,
    password character varying,
    active boolean,
    confirmed boolean,
    creation_datetime timestamp without time zone,
    lastlogin_datetime timestamp without time zone,
    is_admin boolean,
    rule character varying,
    profile_id integer,
    confirmation_code character varying,
    message text
);


ALTER TABLE public."user" OWNER TO postgres;

--
-- Name: user_diz_regioni; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE user_diz_regioni (
    user_id integer NOT NULL,
    diz_regioni_codice character varying(2) NOT NULL,
    write boolean
);


ALTER TABLE public.user_diz_regioni OWNER TO postgres;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO postgres;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


--
-- Name: user_propriet; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE user_propriet (
    user_id integer NOT NULL,
    propriet_codice character varying(5) NOT NULL,
    write bit(1)
);


ALTER TABLE public.user_propriet OWNER TO postgres;

--
-- Name: usosuol2; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usosuol2 (
    codice character varying(1) NOT NULL,
    descriz character varying(21)
);


ALTER TABLE public.usosuol2 OWNER TO postgres;

--
-- Name: usosuolo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usosuolo (
    codice character varying(2) NOT NULL,
    descriz character varying(21)
);


ALTER TABLE public.usosuolo OWNER TO postgres;

--
-- Name: valori; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE valori (
    codice character varying(3),
    descriz character varying(70)
);


ALTER TABLE public.valori OWNER TO postgres;

--
-- Name: var_sist; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE var_sist (
    scelta_periodo boolean DEFAULT false,
    periodo character varying(1),
    annulla_operazione boolean DEFAULT false
);


ALTER TABLE public.var_sist OWNER TO postgres;

--
-- Name: vig_arb_cas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vig_arb_cas (
    codice character varying(1) NOT NULL,
    descriz character varying(55)
);


ALTER TABLE public.vig_arb_cas OWNER TO postgres;

--
-- Name: vigoria; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE vigoria (
    codice integer NOT NULL,
    descriz character varying(55)
);


ALTER TABLE public.vigoria OWNER TO postgres;

--
-- Name: vigoria_codice_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE vigoria_codice_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.vigoria_codice_seq OWNER TO postgres;

--
-- Name: vigoria_codice_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE vigoria_codice_seq OWNED BY vigoria.codice;


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY an_id_co ALTER COLUMN objectid SET DEFAULT nextval('an_id_co_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arb_colt ALTER COLUMN objectid SET DEFAULT nextval('arb_colt_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arboree ALTER COLUMN objectid SET DEFAULT nextval('arboree_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arboree2 ALTER COLUMN objectid SET DEFAULT nextval('arboree2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arboree4a ALTER COLUMN objectid SET DEFAULT nextval('arboree4a_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arboree4b ALTER COLUMN objectid SET DEFAULT nextval('arboree4b_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arbusti ALTER COLUMN objectid SET DEFAULT nextval('arbusti_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arbusti2 ALTER COLUMN objectid SET DEFAULT nextval('arbusti2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arbusti3 ALTER COLUMN objectid SET DEFAULT nextval('arbusti3_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY catasto ALTER COLUMN objectid SET DEFAULT nextval('catasto_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY comp_arb ALTER COLUMN objectid SET DEFAULT nextval('comp_arb_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY compresa ALTER COLUMN objectid SET DEFAULT nextval('compresa_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY comuni ALTER COLUMN objectid SET DEFAULT nextval('comuni_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY comunita ALTER COLUMN objectid SET DEFAULT nextval('comunita_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY descr_pa ALTER COLUMN objectid SET DEFAULT nextval('descr_pa_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_arbo ALTER COLUMN objectid SET DEFAULT nextval('diz_arbo_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_erba ALTER COLUMN objectid SET DEFAULT nextval('diz_erba_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_fung ALTER COLUMN objectid SET DEFAULT nextval('diz_fung_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_regioni ALTER COLUMN objectid SET DEFAULT nextval('diz_regioni_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tavole ALTER COLUMN objectid SET DEFAULT nextval('diz_tavole_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tavole2 ALTER COLUMN objectid SET DEFAULT nextval('diz_tavole2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tavole3 ALTER COLUMN objectid SET DEFAULT nextval('diz_tavole3_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tavole4 ALTER COLUMN objectid SET DEFAULT nextval('diz_tavole4_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tavole5 ALTER COLUMN objectid SET DEFAULT nextval('diz_tavole5_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tipi ALTER COLUMN objectid SET DEFAULT nextval('diz_tipi_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend ALTER COLUMN objectid SET DEFAULT nextval('elab_dend_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend2 ALTER COLUMN objectid SET DEFAULT nextval('elab_dend2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend3 ALTER COLUMN objectid SET DEFAULT nextval('elab_dend3_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend4 ALTER COLUMN objectid SET DEFAULT nextval('elab_dend4_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend5 ALTER COLUMN objectid SET DEFAULT nextval('elab_dend5_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY erbacee ALTER COLUMN objectid SET DEFAULT nextval('erbacee_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY erbacee2 ALTER COLUMN objectid SET DEFAULT nextval('erbacee2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY erbacee3 ALTER COLUMN objectid SET DEFAULT nextval('erbacee3_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY erbacee4 ALTER COLUMN objectid SET DEFAULT nextval('erbacee4_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY infestan ALTER COLUMN objectid SET DEFAULT nextval('infestan_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY interventi_localizzati_viabilita ALTER COLUMN objectid SET DEFAULT nextval('interventi_localizzati_viabilita_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY leg_note ALTER COLUMN objectid SET DEFAULT nextval('leg_note_objectid_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log ALTER COLUMN id SET DEFAULT nextval('log_id_seq'::regclass);


--
-- Name: codice; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY matrici ALTER COLUMN codice SET DEFAULT nextval('matrici_codice_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_a ALTER COLUMN objectid SET DEFAULT nextval('note_a_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_b ALTER COLUMN objectid SET DEFAULT nextval('note_b_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_b2 ALTER COLUMN objectid SET DEFAULT nextval('note_b2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_b3 ALTER COLUMN objectid SET DEFAULT nextval('note_b3_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_b4 ALTER COLUMN objectid SET DEFAULT nextval('note_b4_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_n ALTER COLUMN objectid SET DEFAULT nextval('note_n_objectid_seq'::regclass);


--
-- Name: codice; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY origine ALTER COLUMN codice SET DEFAULT nextval('origine_codice_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY partcomp ALTER COLUMN objectid SET DEFAULT nextval('partcomp_objectid_seq1'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pianota ALTER COLUMN objectid SET DEFAULT nextval('pianota_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY popolame ALTER COLUMN objectid SET DEFAULT nextval('popolame_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_a ALTER COLUMN objectid SET DEFAULT nextval('problemi_a_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_b1 ALTER COLUMN objectid SET DEFAULT nextval('problemi_b1_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_b2 ALTER COLUMN objectid SET DEFAULT nextval('problemi_b2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_b3 ALTER COLUMN objectid SET DEFAULT nextval('problemi_b3_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_b4 ALTER COLUMN objectid SET DEFAULT nextval('problemi_b4_objectid_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY profile ALTER COLUMN id SET DEFAULT nextval('profile_id_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY propriet ALTER COLUMN objectid SET DEFAULT nextval('propriet_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY province ALTER COLUMN objectid SET DEFAULT nextval('province_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY rete_stradale ALTER COLUMN objectid SET DEFAULT nextval('rete_stradale_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY rilevato ALTER COLUMN objectid SET DEFAULT nextval('rilevato_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY rinnovaz ALTER COLUMN objectid SET DEFAULT nextval('rinnovaz_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ris_dend1 ALTER COLUMN objectid SET DEFAULT nextval('ris_dend1_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ris_dend2 ALTER COLUMN objectid SET DEFAULT nextval('ris_dend2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ris_dend3 ALTER COLUMN objectid SET DEFAULT nextval('ris_dend3_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_b1 ALTER COLUMN objectid SET DEFAULT nextval('sched_b1_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_b2 ALTER COLUMN objectid SET DEFAULT nextval('sched_b2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_b3 ALTER COLUMN objectid SET DEFAULT nextval('sched_b3_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_b4 ALTER COLUMN objectid SET DEFAULT nextval('sched_b4_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_c1 ALTER COLUMN objectid SET DEFAULT nextval('sched_c1_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_c2 ALTER COLUMN objectid SET DEFAULT nextval('sched_c2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_d1 ALTER COLUMN objectid SET DEFAULT nextval('sched_d1_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_e1 ALTER COLUMN objectid SET DEFAULT nextval('sched_e1_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_f1 ALTER COLUMN objectid SET DEFAULT nextval('sched_f1_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_f2 ALTER COLUMN objectid SET DEFAULT nextval('sched_f2_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_l1 ALTER COLUMN objectid SET DEFAULT nextval('sched_l1_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_l1b ALTER COLUMN objectid SET DEFAULT nextval('sched_l1b_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_a ALTER COLUMN objectid SET DEFAULT nextval('schede_a_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_b ALTER COLUMN objectid SET DEFAULT nextval('schede_b_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_c ALTER COLUMN objectid SET DEFAULT nextval('schede_c_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_d ALTER COLUMN objectid SET DEFAULT nextval('schede_d_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_e ALTER COLUMN objectid SET DEFAULT nextval('schede_e_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_f ALTER COLUMN objectid SET DEFAULT nextval('schede_f_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_g ALTER COLUMN objectid SET DEFAULT nextval('schede_g_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_g1 ALTER COLUMN objectid SET DEFAULT nextval('schede_g1_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_n ALTER COLUMN objectid SET DEFAULT nextval('schede_n_objectid_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_x ALTER COLUMN objectid SET DEFAULT nextval('schede_x_objectid_seq'::regclass);


--
-- Name: codice; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY struttu ALTER COLUMN codice SET DEFAULT nextval('struttu_codice_seq'::regclass);


--
-- Name: objectid; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipi_for ALTER COLUMN objectid SET DEFAULT nextval('tipi_for_objectid_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- Name: codice; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY vigoria ALTER COLUMN codice SET DEFAULT nextval('vigoria_codice_seq'::regclass);


--
-- Name: PARTCOMP_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY partcomp
    ADD CONSTRAINT "PARTCOMP_pkey" UNIQUE (proprieta, cod_part);


--
-- Name: abbevera_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY abbevera
    ADD CONSTRAINT abbevera_pkey PRIMARY KEY (codice);


--
-- Name: acc_stra_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY acc_stra
    ADD CONSTRAINT acc_stra_pkey PRIMARY KEY (codice);


--
-- Name: accesso_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY accesso
    ADD CONSTRAINT accesso_pkey PRIMARY KEY (codice);


--
-- Name: an_id_co_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY an_id_co
    ADD CONSTRAINT an_id_co_pkey PRIMARY KEY (proprieta, cod_part, cod_fo);


--
-- Name: arb_colt_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY arb_colt
    ADD CONSTRAINT arb_colt_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: arboree2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY arboree2
    ADD CONSTRAINT arboree2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: arboree4a_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY arboree4a
    ADD CONSTRAINT arboree4a_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: arboree4b_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY arboree4b
    ADD CONSTRAINT arboree4b_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: arboree_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY arboree
    ADD CONSTRAINT arboree_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: arbusti2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY arbusti2
    ADD CONSTRAINT arbusti2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: arbusti3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY arbusti3
    ADD CONSTRAINT arbusti3_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: arbusti_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY arbusti
    ADD CONSTRAINT arbusti_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: archivi_pkey1; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY archivi
    ADD CONSTRAINT archivi_pkey1 PRIMARY KEY (archivio, nomecampo);


--
-- Name: car_nove_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY car_nove
    ADD CONSTRAINT car_nove_pkey PRIMARY KEY (codice);


--
-- Name: carico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY carico
    ADD CONSTRAINT carico_pkey PRIMARY KEY (codice);


--
-- Name: catasto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY catasto
    ADD CONSTRAINT catasto_pkey PRIMARY KEY (objectid);


--
-- Name: catasto_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY catasto
    ADD CONSTRAINT catasto_unique UNIQUE (proprieta, cod_part, foglio, particella);


--
-- Name: clas_pro_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY clas_pro
    ADD CONSTRAINT clas_pro_pkey PRIMARY KEY (codice);


--
-- Name: clas_via_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY clas_via
    ADD CONSTRAINT clas_via_pkey PRIMARY KEY (codice);


--
-- Name: coltcast_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY coltcast
    ADD CONSTRAINT coltcast_pkey PRIMARY KEY (codice);


--
-- Name: comp_arb_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY comp_arb
    ADD CONSTRAINT comp_arb_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: compcoti_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY compcoti
    ADD CONSTRAINT compcoti_pkey PRIMARY KEY (codice);


--
-- Name: compo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY compo
    ADD CONSTRAINT compo_pkey PRIMARY KEY (codice);


--
-- Name: compresa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY compresa
    ADD CONSTRAINT compresa_pkey PRIMARY KEY (objectid);


--
-- Name: compresa_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY compresa
    ADD CONSTRAINT compresa_unique UNIQUE (proprieta, compresa);


--
-- Name: comuni_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY comuni
    ADD CONSTRAINT comuni_pkey PRIMARY KEY (objectid);


--
-- Name: comuni_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY comuni
    ADD CONSTRAINT comuni_unique UNIQUE (regione, provincia, comune);


--
-- Name: comunita_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY comunita
    ADD CONSTRAINT comunita_pkey PRIMARY KEY (regione, codice);


--
-- Name: denscoti_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY denscoti
    ADD CONSTRAINT denscoti_pkey PRIMARY KEY (codice);


--
-- Name: densita3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY densita3
    ADD CONSTRAINT densita3_pkey PRIMARY KEY (codice);


--
-- Name: densita_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY densita
    ADD CONSTRAINT densita_pkey PRIMARY KEY (codice);


--
-- Name: descr_pa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY descr_pa
    ADD CONSTRAINT descr_pa_pkey PRIMARY KEY (proprieta, cod_part);


--
-- Name: disph2o_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY disph2o
    ADD CONSTRAINT disph2o_pkey PRIMARY KEY (codice);


--
-- Name: diz_arbo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_arbo
    ADD CONSTRAINT diz_arbo_pkey PRIMARY KEY (cod_coltu);


--
-- Name: diz_curve_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_curve
    ADD CONSTRAINT diz_curve_pkey PRIMARY KEY (cod_curva);


--
-- Name: diz_erba_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_erba
    ADD CONSTRAINT diz_erba_pkey PRIMARY KEY (cod_coltu);


--
-- Name: diz_fung_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_fung
    ADD CONSTRAINT diz_fung_pkey PRIMARY KEY (cod_coltu);


--
-- Name: diz_regioni_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_regioni
    ADD CONSTRAINT diz_regioni_pkey PRIMARY KEY (codice);


--
-- Name: diz_tavole2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_tavole2
    ADD CONSTRAINT diz_tavole2_pkey PRIMARY KEY (codice, tariffa, d, h);


--
-- Name: diz_tavole3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_tavole3
    ADD CONSTRAINT diz_tavole3_pkey PRIMARY KEY (codice, tariffa, d, h);


--
-- Name: diz_tavole4_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_tavole4
    ADD CONSTRAINT diz_tavole4_pkey PRIMARY KEY (codice);


--
-- Name: diz_tavole5_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_tavole5
    ADD CONSTRAINT diz_tavole5_pkey PRIMARY KEY (codice);


--
-- Name: diz_tavole_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_tavole
    ADD CONSTRAINT diz_tavole_pkey PRIMARY KEY (codice);


--
-- Name: diz_tipi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_tipi
    ADD CONSTRAINT diz_tipi_pkey PRIMARY KEY (regione, codice);


--
-- Name: diz_tiporil_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY diz_tiporil
    ADD CONSTRAINT diz_tiporil_pkey PRIMARY KEY (codice);


--
-- Name: elab_dend2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY elab_dend2
    ADD CONSTRAINT elab_dend2_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie);


--
-- Name: elab_dend3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY elab_dend3
    ADD CONSTRAINT elab_dend3_pkey PRIMARY KEY (proprieta, cod_elab, cod_part, cod_fo, tipo_ril, data);


--
-- Name: elab_dend4_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY elab_dend4
    ADD CONSTRAINT elab_dend4_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie, specie);


--
-- Name: elab_dend5_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY elab_dend5
    ADD CONSTRAINT elab_dend5_pkey PRIMARY KEY (proprieta, cod_elab, cod_part, cod_fo, tipo_ril, data);


--
-- Name: elab_dend_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY elab_dend
    ADD CONSTRAINT elab_dend_pkey PRIMARY KEY (proprieta, cod_elab);


--
-- Name: erbacee2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY erbacee2
    ADD CONSTRAINT erbacee2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: erbacee3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY erbacee3
    ADD CONSTRAINT erbacee3_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: erbacee4_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY erbacee4
    ADD CONSTRAINT erbacee4_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: erbacee_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY erbacee
    ADD CONSTRAINT erbacee_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: espo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY espo
    ADD CONSTRAINT espo_pkey PRIMARY KEY (codice);


--
-- Name: fondo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY fondo
    ADD CONSTRAINT fondo_pkey PRIMARY KEY (codice);


--
-- Name: fruitori_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY fruitori
    ADD CONSTRAINT fruitori_pkey PRIMARY KEY (codice);


--
-- Name: funzion2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY funzion2
    ADD CONSTRAINT funzion2_pkey PRIMARY KEY (codice);


--
-- Name: funzione_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY funzione
    ADD CONSTRAINT funzione_pkey PRIMARY KEY (codice);


--
-- Name: geometry_columns_pk; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY geometry_columns
    ADD CONSTRAINT geometry_columns_pk PRIMARY KEY (f_table_catalog, f_table_schema, f_table_name, f_geometry_column);


--
-- Name: infestan_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY infestan
    ADD CONSTRAINT infestan_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: infr_past_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY infr_past
    ADD CONSTRAINT infr_past_pkey PRIMARY KEY (codice);


--
-- Name: int_via_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY int_via
    ADD CONSTRAINT int_via_pkey PRIMARY KEY (codice);


--
-- Name: interventi_localizzati_viabilita_objectid_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY interventi_localizzati_viabilita
    ADD CONSTRAINT interventi_localizzati_viabilita_objectid_key UNIQUE (objectid);


--
-- Name: leg_note_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY leg_note
    ADD CONSTRAINT leg_note_pkey PRIMARY KEY (objectid);


--
-- Name: log_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY log
    ADD CONSTRAINT log_pkey PRIMARY KEY (id);


--
-- Name: manutenz_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY manutenz
    ADD CONSTRAINT manutenz_pkey PRIMARY KEY (codice);


--
-- Name: matrici_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY matrici
    ADD CONSTRAINT matrici_pkey PRIMARY KEY (codice);


--
-- Name: meccaniz_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY meccaniz
    ADD CONSTRAINT meccaniz_pkey PRIMARY KEY (codice);


--
-- Name: mod_pasc_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY mod_pasc
    ADD CONSTRAINT mod_pasc_pkey PRIMARY KEY (codice);


--
-- Name: moti_macchia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY moti_macchia
    ADD CONSTRAINT moti_macchia_pkey PRIMARY KEY (codice);


--
-- Name: nomi_arc_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY nomi_arc
    ADD CONSTRAINT nomi_arc_pkey PRIMARY KEY (nome);


--
-- Name: note_a_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY note_a
    ADD CONSTRAINT note_a_pkey PRIMARY KEY (objectid);


--
-- Name: note_b2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY note_b2
    ADD CONSTRAINT note_b2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_nota);


--
-- Name: note_b3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY note_b3
    ADD CONSTRAINT note_b3_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_nota);


--
-- Name: note_b4_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY note_b4
    ADD CONSTRAINT note_b4_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_nota);


--
-- Name: note_b_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY note_b
    ADD CONSTRAINT note_b_pkey PRIMARY KEY (objectid);


--
-- Name: note_b_proprieta_cod_part_cod_fo_cod_nota_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY note_b
    ADD CONSTRAINT note_b_proprieta_cod_part_cod_fo_cod_nota_key UNIQUE (proprieta, cod_part, cod_fo, cod_nota);


--
-- Name: note_n_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY note_n
    ADD CONSTRAINT note_n_pkey PRIMARY KEY (objectid);


--
-- Name: note_n_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY note_n
    ADD CONSTRAINT note_n_unique UNIQUE (proprieta, cod_part, cod_fo, cod_ev_int, cod_nota);


--
-- Name: novell2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY novell2
    ADD CONSTRAINT novell2_pkey PRIMARY KEY (codice);


--
-- Name: novell_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY novell
    ADD CONSTRAINT novell_pkey PRIMARY KEY (codice);


--
-- Name: origine_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY origine
    ADD CONSTRAINT origine_pkey PRIMARY KEY (codice);


--
-- Name: ostacoli_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ostacoli
    ADD CONSTRAINT ostacoli_pkey PRIMARY KEY (codice);


--
-- Name: partcomp_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY partcomp
    ADD CONSTRAINT partcomp_pkey PRIMARY KEY (objectid);


--
-- Name: per_arbo_codice; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY per_arbo
    ADD CONSTRAINT per_arbo_codice PRIMARY KEY (codice);


--
-- Name: pianota_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pianota
    ADD CONSTRAINT pianota_pkey PRIMARY KEY (proprieta, cod_part, anno);


--
-- Name: piu1_3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY piu1_3
    ADD CONSTRAINT piu1_3_pkey PRIMARY KEY (codice);


--
-- Name: piu2_3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY piu2_3
    ADD CONSTRAINT piu2_3_pkey PRIMARY KEY (codice);


--
-- Name: pollmatr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pollmatr
    ADD CONSTRAINT pollmatr_pkey PRIMARY KEY (codice);


--
-- Name: popolame_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY popolame
    ADD CONSTRAINT popolame_pkey PRIMARY KEY (codice);


--
-- Name: posfisio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY posfisio
    ADD CONSTRAINT posfisio_pkey PRIMARY KEY (codice);


--
-- Name: prep_terr_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY prep_terr
    ADD CONSTRAINT prep_terr_pkey PRIMARY KEY (codice);


--
-- Name: pres_ass_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pres_ass
    ADD CONSTRAINT pres_ass_pkey PRIMARY KEY (codice);


--
-- Name: prescri2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY prescri2
    ADD CONSTRAINT prescri2_pkey PRIMARY KEY (codice);


--
-- Name: prescri3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY prescri3
    ADD CONSTRAINT prescri3_pkey PRIMARY KEY (codice);


--
-- Name: prescri_via_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY prescri_via
    ADD CONSTRAINT prescri_via_pkey PRIMARY KEY (codice);


--
-- Name: prescriz_globale_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY prescriz_globale
    ADD CONSTRAINT prescriz_globale_pkey PRIMARY KEY (codice);


--
-- Name: prescriz_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY prescriz
    ADD CONSTRAINT prescriz_pkey PRIMARY KEY (codice);


--
-- Name: problemi_a_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY problemi_a
    ADD CONSTRAINT problemi_a_pkey PRIMARY KEY (proprieta, cod_part, tabella, campo);


--
-- Name: problemi_b1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY problemi_b1
    ADD CONSTRAINT problemi_b1_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, campo, tabella);


--
-- Name: problemi_b2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY problemi_b2
    ADD CONSTRAINT problemi_b2_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, campo, tabella);


--
-- Name: problemi_b3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY problemi_b3
    ADD CONSTRAINT problemi_b3_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, campo, tabella);


--
-- Name: problemi_b4_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY problemi_b4
    ADD CONSTRAINT problemi_b4_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, campo, tabella);


--
-- Name: profile_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY profile
    ADD CONSTRAINT profile_pkey PRIMARY KEY (id);


--
-- Name: prop_part_nota; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY note_a
    ADD CONSTRAINT prop_part_nota UNIQUE (proprieta, cod_part, cod_nota);


--
-- Name: propriet_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY propriet
    ADD CONSTRAINT propriet_pkey PRIMARY KEY (codice);


--
-- Name: province_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY province
    ADD CONSTRAINT province_pkey PRIMARY KEY (provincia);


--
-- Name: qual_pro_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY qual_pro
    ADD CONSTRAINT qual_pro_pkey PRIMARY KEY (codice);


--
-- Name: qual_via_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY qual_via
    ADD CONSTRAINT qual_via_pkey PRIMARY KEY (codice);


--
-- Name: rete_stradale_objectid_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rete_stradale
    ADD CONSTRAINT rete_stradale_objectid_key UNIQUE (objectid);


--
-- Name: rilevato_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rilevato
    ADD CONSTRAINT rilevato_pkey PRIMARY KEY (codice);


--
-- Name: rinnov_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rinnov
    ADD CONSTRAINT rinnov_pkey PRIMARY KEY (codice);


--
-- Name: rinnovaz_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY rinnovaz
    ADD CONSTRAINT rinnovaz_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: ris_dend1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ris_dend1
    ADD CONSTRAINT ris_dend1_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie);


--
-- Name: ris_dend2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ris_dend2
    ADD CONSTRAINT ris_dend2_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie, conta);


--
-- Name: ris_dend3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ris_dend3
    ADD CONSTRAINT ris_dend3_pkey PRIMARY KEY (proprieta, cod_elab, gruppo_specie, specie, d);


--
-- Name: sched_b1_fkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_b1
    ADD CONSTRAINT sched_b1_fkey UNIQUE (proprieta, cod_part, cod_fo);


--
-- Name: sched_b1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_b1
    ADD CONSTRAINT sched_b1_pkey PRIMARY KEY (objectid);


--
-- Name: sched_b2_fkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_b2
    ADD CONSTRAINT sched_b2_fkey UNIQUE (proprieta, cod_part, cod_fo);


--
-- Name: sched_b2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_b2
    ADD CONSTRAINT sched_b2_pkey PRIMARY KEY (objectid);


--
-- Name: sched_b3_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_b3
    ADD CONSTRAINT sched_b3_pkey PRIMARY KEY (objectid);


--
-- Name: sched_b3_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_b3
    ADD CONSTRAINT sched_b3_unique UNIQUE (proprieta, cod_part, cod_fo);


--
-- Name: sched_b4_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_b4
    ADD CONSTRAINT sched_b4_pkey PRIMARY KEY (objectid);


--
-- Name: sched_b4_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_b4
    ADD CONSTRAINT sched_b4_unique UNIQUE (proprieta, cod_part, cod_fo);


--
-- Name: sched_c1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_c1
    ADD CONSTRAINT sched_c1_pkey PRIMARY KEY (objectid);


--
-- Name: sched_c2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_c2
    ADD CONSTRAINT sched_c2_pkey PRIMARY KEY (objectid);


--
-- Name: sched_d1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_d1
    ADD CONSTRAINT sched_d1_pkey PRIMARY KEY (objectid);


--
-- Name: sched_e1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_e1
    ADD CONSTRAINT sched_e1_pkey PRIMARY KEY (objectid);


--
-- Name: sched_e1_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_e1
    ADD CONSTRAINT sched_e1_unique UNIQUE (proprieta, strada, cod_inter);


--
-- Name: sched_f1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_f1
    ADD CONSTRAINT sched_f1_pkey PRIMARY KEY (objectid);


--
-- Name: sched_f1_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_f1
    ADD CONSTRAINT sched_f1_unique UNIQUE (proprieta, cod_part, cod_fo, tipo_ril, data, n_camp, specie);


--
-- Name: sched_f2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_f2
    ADD CONSTRAINT sched_f2_pkey PRIMARY KEY (objectid);


--
-- Name: sched_f2_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_f2
    ADD CONSTRAINT sched_f2_unique UNIQUE (proprieta, cod_part, cod_fo, tipo_ril, data, n_camp, conta);


--
-- Name: sched_l1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_l1
    ADD CONSTRAINT sched_l1_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, num_alb, elemento, h_sez);


--
-- Name: sched_l1b_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sched_l1b
    ADD CONSTRAINT sched_l1b_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, num_alb, elemento);


--
-- Name: scheda_field; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY leg_note
    ADD CONSTRAINT scheda_field UNIQUE (archivio, nomecampo);


--
-- Name: schede_a_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_a
    ADD CONSTRAINT schede_a_pkey PRIMARY KEY (objectid);


--
-- Name: schede_a_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_a
    ADD CONSTRAINT schede_a_unique UNIQUE (proprieta, cod_part);


--
-- Name: schede_b_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_b
    ADD CONSTRAINT schede_b_pkey PRIMARY KEY (objectid);


--
-- Name: schede_b_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_b
    ADD CONSTRAINT schede_b_unique UNIQUE (proprieta, cod_part, cod_fo);


--
-- Name: schede_c_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_c
    ADD CONSTRAINT schede_c_pkey PRIMARY KEY (objectid);


--
-- Name: schede_c_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_c
    ADD CONSTRAINT schede_c_unique UNIQUE (proprieta, cod_part, cod_fo, tipo_ril, data);


--
-- Name: schede_d_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_d
    ADD CONSTRAINT schede_d_pkey PRIMARY KEY (objectid);


--
-- Name: schede_d_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_d
    ADD CONSTRAINT schede_d_unique UNIQUE (proprieta, cod_part, cod_fo, tipo_ril, data, n_camp);


--
-- Name: schede_e_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_e
    ADD CONSTRAINT schede_e_pkey PRIMARY KEY (objectid);


--
-- Name: schede_e_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_e
    ADD CONSTRAINT schede_e_unique UNIQUE (proprieta, strada);


--
-- Name: schede_f_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_f
    ADD CONSTRAINT schede_f_pkey PRIMARY KEY (objectid);


--
-- Name: schede_f_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_f
    ADD CONSTRAINT schede_f_unique UNIQUE (proprieta, cod_part, cod_fo, tipo_ril, data, n_camp);


--
-- Name: schede_g1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_g1
    ADD CONSTRAINT schede_g1_pkey PRIMARY KEY (objectid);


--
-- Name: schede_g1_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_g1
    ADD CONSTRAINT schede_g1_unique UNIQUE (proprieta, cod_part, cod_fo, tipo_ril, data);


--
-- Name: schede_g_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_g
    ADD CONSTRAINT schede_g_pkey PRIMARY KEY (objectid);


--
-- Name: schede_g_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_g
    ADD CONSTRAINT schede_g_unique UNIQUE (proprieta, cod_part, cod_fo, tipo_ril, data, n_ads);


--
-- Name: schede_n_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_n
    ADD CONSTRAINT schede_n_pkey PRIMARY KEY (objectid);


--
-- Name: schede_n_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_n
    ADD CONSTRAINT schede_n_unique UNIQUE (proprieta, cod_part, cod_fo, cod_ev_int);


--
-- Name: schede_x_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_x
    ADD CONSTRAINT schede_x_pkey PRIMARY KEY (objectid);


--
-- Name: schede_x_unique; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY schede_x
    ADD CONSTRAINT schede_x_unique UNIQUE (proprieta, cod_part, cod_fo, tipo_ril, data);


--
-- Name: senescen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY senescen
    ADD CONSTRAINT senescen_pkey PRIMARY KEY (codice);


--
-- Name: sesto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sesto
    ADD CONSTRAINT sesto_pkey PRIMARY KEY (codice);


--
-- Name: si_no_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY si_no
    ADD CONSTRAINT si_no_pkey PRIMARY KEY (codice);


--
-- Name: sistema_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sistema
    ADD CONSTRAINT sistema_pkey PRIMARY KEY (codice);


--
-- Name: spatial_ref_sys_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY spatial_ref_sys
    ADD CONSTRAINT spatial_ref_sys_pkey PRIMARY KEY (srid);


--
-- Name: specie_p_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY specie_p
    ADD CONSTRAINT specie_p_pkey PRIMARY KEY (codice);


--
-- Name: stime_b1_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY stime_b1
    ADD CONSTRAINT stime_b1_pkey PRIMARY KEY (proprieta, cod_part, cod_fo, cod_coltu);


--
-- Name: strati2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY strati2
    ADD CONSTRAINT strati2_pkey PRIMARY KEY (codice);


--
-- Name: strati_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY strati
    ADD CONSTRAINT strati_pkey PRIMARY KEY (codice);


--
-- Name: struttu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY struttu
    ADD CONSTRAINT struttu_pkey PRIMARY KEY (codice);


--
-- Name: struttu_sug_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY struttu_sug
    ADD CONSTRAINT struttu_sug_pkey PRIMARY KEY (codice);


--
-- Name: struttu_vert_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY struttu_vert
    ADD CONSTRAINT struttu_vert_pkey PRIMARY KEY (codice);


--
-- Name: tipo_imp_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_imp
    ADD CONSTRAINT tipo_imp_pkey PRIMARY KEY (codice);


--
-- Name: tipo_int_sug_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_int_sug
    ADD CONSTRAINT tipo_int_sug_pkey PRIMARY KEY (codice);


--
-- Name: tipo_tavola_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_tavola
    ADD CONSTRAINT tipo_tavola_pkey PRIMARY KEY (codice);


--
-- Name: transita_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY transita
    ADD CONSTRAINT transita_pkey PRIMARY KEY (codice);


--
-- Name: urgenza_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY urgenza
    ADD CONSTRAINT urgenza_pkey PRIMARY KEY (codice);


--
-- Name: user_id_iz_regioni; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY user_diz_regioni
    ADD CONSTRAINT user_id_iz_regioni PRIMARY KEY (user_id, diz_regioni_codice);


--
-- Name: user_id_propriet_codice; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY user_propriet
    ADD CONSTRAINT user_id_propriet_codice PRIMARY KEY (user_id, propriet_codice);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: usosuol2_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usosuol2
    ADD CONSTRAINT usosuol2_pkey PRIMARY KEY (codice);


--
-- Name: usosuolo_pri_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usosuolo
    ADD CONSTRAINT usosuolo_pri_key PRIMARY KEY (codice);


--
-- Name: vig_arb_cas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY vig_arb_cas
    ADD CONSTRAINT vig_arb_cas_pkey PRIMARY KEY (codice);


--
-- Name: vigoria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY vigoria
    ADD CONSTRAINT vigoria_pkey PRIMARY KEY (codice);


--
-- Name: arboree_objectid; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX arboree_objectid ON arboree USING btree (objectid);


--
-- Name: archivio; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX archivio ON leg_note USING btree (archivio);


--
-- Name: cod_coltu; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX cod_coltu ON arboree USING btree (cod_coltu);


--
-- Name: cod_coper; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX cod_coper ON arboree USING btree (cod_coper);


--
-- Name: cod_part_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX cod_part_index ON schede_a USING btree (cod_part);


--
-- Name: cod_part_proprieta; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX cod_part_proprieta ON note_a USING btree (proprieta, cod_part);


--
-- Name: codice; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX codice ON comuni USING btree (codice);


--
-- Name: codiope_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX codiope_index ON schede_a USING btree (codiope);


--
-- Name: creationdatetime_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX creationdatetime_idx ON log USING btree (creation_datetime);


--
-- Name: descriz; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX descriz ON comuni USING btree (descriz);


--
-- Name: diz_tavole_autore; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX diz_tavole_autore ON diz_tavole USING btree (autore);


--
-- Name: diz_tavole_descriz; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX diz_tavole_descriz ON diz_tavole USING btree (descriz);


--
-- Name: diz_tipi_descriz; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX diz_tipi_descriz ON diz_tipi USING btree (descriz);


--
-- Name: fatt_num; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fatt_num ON schede_g USING btree (fatt_num);


--
-- Name: fki_arbusti_sched_b1_fkey; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_arbusti_sched_b1_fkey ON arbusti USING btree (proprieta, cod_part, cod_fo);


--
-- Name: fki_catasto_schede_a; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_catasto_schede_a ON catasto USING btree (proprieta, cod_part);


--
-- Name: fki_erbacee_sched_b1_fkey; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_erbacee_sched_b1_fkey ON erbacee USING btree (proprieta, cod_part, cod_fo);


--
-- Name: fki_note_a_schede_a; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_note_a_schede_a ON catasto USING btree (proprieta, cod_part);


--
-- Name: fki_note_b_sched_b1_fkey; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_note_b_sched_b1_fkey ON note_b USING btree (proprieta, cod_part, cod_fo);


--
-- Name: fki_partcomt_compresa_fkey; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_partcomt_compresa_fkey ON partcomp USING btree (compresa, proprieta);


--
-- Name: fki_partcomt_schedea_fkey; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_partcomt_schedea_fkey ON partcomp USING btree (proprieta, cod_part);


--
-- Name: fki_problemi_b1_sched_b1_fkey; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_problemi_b1_sched_b1_fkey ON problemi_b1 USING btree (proprieta, cod_part, cod_fo);


--
-- Name: fki_sched_b1_sched_b; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_sched_b1_sched_b ON sched_b1 USING btree (proprieta, cod_part, cod_fo);


--
-- Name: fki_schede_b_schede_a; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_schede_b_schede_a ON schede_b USING btree (proprieta, cod_part);


--
-- Name: fki_schede_x_fkey; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_schede_x_fkey ON schede_x USING btree (proprieta, cod_part, cod_fo);


--
-- Name: fki_stime_b1_sched_b1_fkey; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX fki_stime_b1_sched_b1_fkey ON stime_b1 USING btree (proprieta, cod_part, cod_fo);


--
-- Name: gdb_10_id_av_com; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_10_id_av_com ON comuni USING btree (id_av_comuni);


--
-- Name: gdb_1_id_av; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_1_id_av ON an_id_co USING btree (id_av);


--
-- Name: gdb_24_id_av_den; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_24_id_av_den ON elab_dend USING btree (id_av_dend);


--
-- Name: gdb_25_id_av_den; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_25_id_av_den ON elab_dend2 USING btree (id_av_dend2);


--
-- Name: gdb_26_id_av_den; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_26_id_av_den ON elab_dend3 USING btree (id_av_dend);


--
-- Name: gdb_27_id_av_den; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_27_id_av_den ON elab_dend4 USING btree (id_av_dend2);


--
-- Name: gdb_34_id_av; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_34_id_av ON note_b2 USING btree (id_av);


--
-- Name: gdb_35_id_av; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_35_id_av ON note_b3 USING btree (id_av);


--
-- Name: gdb_36_id_av_n; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_36_id_av_n ON note_n USING btree (id_av_n);


--
-- Name: gdb_41_id_av; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_41_id_av ON problemi_b1 USING btree (id_av);


--
-- Name: gdb_42_id_av; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_42_id_av ON problemi_b2 USING btree (id_av);


--
-- Name: gdb_43_id_av; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_43_id_av ON problemi_b3 USING btree (id_av);


--
-- Name: gdb_45_id_av_com; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_45_id_av_com ON province USING btree (id_av_comuni);


--
-- Name: gdb_48_id_av_den; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_48_id_av_den ON ris_dend1 USING btree (id_av_dend2);


--
-- Name: gdb_49_id_av_den; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_49_id_av_den ON ris_dend2 USING btree (id_av_dend2);


--
-- Name: gdb_56_id_av_e; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_56_id_av_e ON sched_e1 USING btree (id_av_e);


--
-- Name: gdb_59_id_av_l1; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_59_id_av_l1 ON sched_l1 USING btree (id_av_l1);


--
-- Name: gdb_60_id_av_l1; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_60_id_av_l1 ON sched_l1b USING btree (id_av_l1);


--
-- Name: gdb_60_id_av_l1b; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_60_id_av_l1b ON sched_l1b USING btree (id_av_l1b);


--
-- Name: gdb_65_id_av_e; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_65_id_av_e ON schede_e USING btree (id_av_e);


--
-- Name: gdb_70_id_av_n; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX gdb_70_id_av_n ON schede_n USING btree (id_av_n);


--
-- Name: id_; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX id_ ON sched_d1 USING btree (conta);


--
-- Name: id_av; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX id_av ON arb_colt USING btree (id_av);


--
-- Name: id_av_x_join; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX id_av_x_join ON compresa USING btree (id_av_x_join);


--
-- Name: id_gesfore; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX id_gesfore ON schede_n USING btree (id_gesfore);


--
-- Name: indexedobjectid_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX indexedobjectid_index ON interventi_localizzati_viabilita_shape_index USING btree (indexedobjectid);


--
-- Name: intesta; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX intesta ON leg_note USING btree (intesta);


--
-- Name: maxgx_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX maxgx_index ON interventi_localizzati_viabilita_shape_index USING btree (maxgx);


--
-- Name: maxgy_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX maxgy_index ON interventi_localizzati_viabilita_shape_index USING btree (maxgy);


--
-- Name: mingx_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX mingx_index ON interventi_localizzati_viabilita_shape_index USING btree (mingx);


--
-- Name: mingy_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX mingy_index ON interventi_localizzati_viabilita_shape_index USING btree (mingy);


--
-- Name: nome_itali; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX nome_itali ON diz_arbo USING btree (nome_itali);


--
-- Name: nome_scien; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX nome_scien ON diz_arbo USING btree (nome_scien);


--
-- Name: nomecampo; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX nomecampo ON leg_note USING btree (nomecampo);


--
-- Name: num_alb; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX num_alb ON sched_l1b USING btree (num_alb);


--
-- Name: num_oss_h; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX num_oss_h ON ris_dend1 USING btree (num_oss_h);


--
-- Name: num_piante; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX num_piante ON sched_b2 USING btree (num_piante);


--
-- Name: objcteid_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX objcteid_idx ON log USING btree (objectid);


--
-- Name: profile_first_name_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX profile_first_name_idx ON profile USING btree (first_name);


--
-- Name: profile_last_name_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX profile_last_name_idx ON profile USING btree (last_name);


--
-- Name: propriet_descrizion_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX propriet_descrizion_idx ON propriet USING btree (descrizion);


--
-- Name: propriet_regione_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX propriet_regione_idx ON propriet USING btree (regione);


--
-- Name: proprieta_cod_part; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX proprieta_cod_part ON catasto USING btree (proprieta, cod_part);


--
-- Name: provincia; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX provincia ON comuni USING btree (provincia);


--
-- Name: regione; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX regione ON province USING btree (regione);


--
-- Name: ris_dendproprieta; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX ris_dendproprieta ON ris_dend2 USING btree (proprieta);


--
-- Name: sched_b1_objectid; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX sched_b1_objectid ON sched_b1 USING btree (objectid);


--
-- Name: sched_d1_specie; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX sched_d1_specie ON sched_d1 USING btree (specie);


--
-- Name: struttu_descriz; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX struttu_descriz ON struttu USING btree (descriz);


--
-- Name: toponimo_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX toponimo_index ON schede_a USING btree (toponimo);


--
-- Name: user_ids; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX user_ids ON log USING btree (user_id);


--
-- Name: user_password_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX user_password_idx ON "user" USING btree (password);


--
-- Name: user_username_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX user_username_idx ON "user" USING btree (username);


--
-- Name: usosuolo_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX usosuolo_index ON schede_b USING btree (u);


--
-- Name: an_id_co_schede_b_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY an_id_co
    ADD CONSTRAINT an_id_co_schede_b_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES schede_b(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: arboree2_sched_b2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arboree2
    ADD CONSTRAINT arboree2_sched_b2_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b2(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: arboree4b_sched_b4_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arboree4b
    ADD CONSTRAINT arboree4b_sched_b4_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b4(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: arbusti3_sched_b3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arbusti3
    ADD CONSTRAINT arbusti3_sched_b3_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b3(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: arbusti_sched_b1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY arbusti
    ADD CONSTRAINT arbusti_sched_b1_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b1(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: catasto_schede_a; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY catasto
    ADD CONSTRAINT catasto_schede_a FOREIGN KEY (proprieta, cod_part) REFERENCES schede_a(proprieta, cod_part) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: comp_arb_sched_b3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY comp_arb
    ADD CONSTRAINT comp_arb_sched_b3_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b3(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: compresa_propriet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY compresa
    ADD CONSTRAINT compresa_propriet_fkey FOREIGN KEY (proprieta) REFERENCES propriet(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: descr_pa_schede_a_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY descr_pa
    ADD CONSTRAINT descr_pa_schede_a_fkey FOREIGN KEY (proprieta, cod_part) REFERENCES schede_a(proprieta, cod_part) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: diz_regioni; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_diz_regioni
    ADD CONSTRAINT diz_regioni FOREIGN KEY (diz_regioni_codice) REFERENCES diz_regioni(codice);


--
-- Name: diz_tavole2_diz_tavole_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tavole2
    ADD CONSTRAINT diz_tavole2_diz_tavole_fkey FOREIGN KEY (codice) REFERENCES diz_tavole(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: diz_tavole3_diz_tavole_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tavole3
    ADD CONSTRAINT diz_tavole3_diz_tavole_fkey FOREIGN KEY (codice) REFERENCES diz_tavole(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: diz_tavole4_diz_tavole_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tavole4
    ADD CONSTRAINT diz_tavole4_diz_tavole_fkey FOREIGN KEY (codice) REFERENCES diz_tavole(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: diz_tavole5_diz_tavole_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY diz_tavole5
    ADD CONSTRAINT diz_tavole5_diz_tavole_fkey FOREIGN KEY (codice) REFERENCES diz_tavole(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: elab_dend2_elab_dend_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend2
    ADD CONSTRAINT elab_dend2_elab_dend_fkey FOREIGN KEY (proprieta, cod_elab) REFERENCES elab_dend(proprieta, cod_elab) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: elab_dend3_elab_dend_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend3
    ADD CONSTRAINT elab_dend3_elab_dend_fkey FOREIGN KEY (proprieta, cod_elab) REFERENCES elab_dend(proprieta, cod_elab) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: elab_dend4_elab_dend2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend4
    ADD CONSTRAINT elab_dend4_elab_dend2_fkey FOREIGN KEY (proprieta, cod_elab, gruppo_specie) REFERENCES elab_dend2(proprieta, cod_elab, gruppo_specie) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: elab_dend5_elab_dend_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend5
    ADD CONSTRAINT elab_dend5_elab_dend_fkey FOREIGN KEY (proprieta, cod_elab) REFERENCES elab_dend(proprieta, cod_elab) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: elab_dend_propriet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY elab_dend
    ADD CONSTRAINT elab_dend_propriet_fkey FOREIGN KEY (proprieta) REFERENCES propriet(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: erbacee2_sched_b2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY erbacee2
    ADD CONSTRAINT erbacee2_sched_b2_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b2(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: erbacee3_sched_b3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY erbacee3
    ADD CONSTRAINT erbacee3_sched_b3_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b3(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: erbacee4_sched_b4_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY erbacee4
    ADD CONSTRAINT erbacee4_sched_b4_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b4(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: erbacee_sched_b1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY erbacee
    ADD CONSTRAINT erbacee_sched_b1_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b1(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: infestan_sched_b3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY infestan
    ADD CONSTRAINT infestan_sched_b3_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b3(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: note_a_schede_a; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_a
    ADD CONSTRAINT note_a_schede_a FOREIGN KEY (proprieta, cod_part) REFERENCES schede_a(proprieta, cod_part) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: note_b2_sched_b2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_b2
    ADD CONSTRAINT note_b2_sched_b2_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b2(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: note_b3_sched_b3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_b3
    ADD CONSTRAINT note_b3_sched_b3_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b3(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: note_b4_sched_b4_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_b4
    ADD CONSTRAINT note_b4_sched_b4_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b4(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: note_b_sched_b1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_b
    ADD CONSTRAINT note_b_sched_b1_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b1(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: note_n_schede_n_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY note_n
    ADD CONSTRAINT note_n_schede_n_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, cod_ev_int) REFERENCES schede_n(proprieta, cod_part, cod_fo, cod_ev_int) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: partcomt_compresa_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY partcomp
    ADD CONSTRAINT partcomt_compresa_fkey FOREIGN KEY (compresa, proprieta) REFERENCES compresa(compresa, proprieta) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: partcomt_schedea_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY partcomp
    ADD CONSTRAINT partcomt_schedea_fkey FOREIGN KEY (proprieta, cod_part) REFERENCES schede_a(proprieta, cod_part) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: problemi_a_schede_a_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_a
    ADD CONSTRAINT problemi_a_schede_a_fkey FOREIGN KEY (proprieta, cod_part) REFERENCES schede_a(proprieta, cod_part) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: problemi_b1_sched_b1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_b1
    ADD CONSTRAINT problemi_b1_sched_b1_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b1(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: problemi_b2_sched_b2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_b2
    ADD CONSTRAINT problemi_b2_sched_b2_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b2(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: problemi_b3_sched_b3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_b3
    ADD CONSTRAINT problemi_b3_sched_b3_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b3(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: problemi_b4_sched_b4_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY problemi_b4
    ADD CONSTRAINT problemi_b4_sched_b4_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b4(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: propriet_codice; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_propriet
    ADD CONSTRAINT propriet_codice FOREIGN KEY (propriet_codice) REFERENCES propriet(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: propriet_user_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_propriet
    ADD CONSTRAINT propriet_user_id FOREIGN KEY (user_id) REFERENCES "user"(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: rinnovaz_sched_b3_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY rinnovaz
    ADD CONSTRAINT rinnovaz_sched_b3_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b3(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ris_dend1_elab_dend_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ris_dend1
    ADD CONSTRAINT ris_dend1_elab_dend_fkey FOREIGN KEY (proprieta, cod_elab) REFERENCES elab_dend(proprieta, cod_elab) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ris_dend2_ris_dend1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ris_dend2
    ADD CONSTRAINT ris_dend2_ris_dend1_fkey FOREIGN KEY (proprieta, cod_elab, gruppo_specie) REFERENCES ris_dend1(proprieta, cod_elab, gruppo_specie) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: ris_dend3_ris_dend1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY ris_dend3
    ADD CONSTRAINT ris_dend3_ris_dend1_fkey FOREIGN KEY (proprieta, cod_elab, gruppo_specie) REFERENCES ris_dend1(proprieta, cod_elab, gruppo_specie) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_b1_sched_b; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_b1
    ADD CONSTRAINT sched_b1_sched_b FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES schede_b(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_b2_schede_b_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_b2
    ADD CONSTRAINT sched_b2_schede_b_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES schede_b(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_b3_schede_b_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_b3
    ADD CONSTRAINT sched_b3_schede_b_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES schede_b(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_b4_schede_b_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_b4
    ADD CONSTRAINT sched_b4_schede_b_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES schede_b(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_c1_schede_c_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_c1
    ADD CONSTRAINT sched_c1_schede_c_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data) REFERENCES schede_c(proprieta, cod_part, cod_fo, tipo_ril, data) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_c2_schede_c_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_c2
    ADD CONSTRAINT sched_c2_schede_c_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data) REFERENCES schede_c(proprieta, cod_part, cod_fo, tipo_ril, data) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_d1_schede_d_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_d1
    ADD CONSTRAINT sched_d1_schede_d_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data, n_camp) REFERENCES schede_d(proprieta, cod_part, cod_fo, tipo_ril, data, n_camp) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_e1_schede_e_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_e1
    ADD CONSTRAINT sched_e1_schede_e_fkey FOREIGN KEY (proprieta, strada) REFERENCES schede_e(proprieta, strada) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_f1_schede_f_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_f1
    ADD CONSTRAINT sched_f1_schede_f_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data, n_camp) REFERENCES schede_f(proprieta, cod_part, cod_fo, tipo_ril, data, n_camp) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_f2_schede_f_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_f2
    ADD CONSTRAINT sched_f2_schede_f_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data, n_camp) REFERENCES schede_f(proprieta, cod_part, cod_fo, tipo_ril, data, n_camp) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: sched_l1_sched_l1b_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sched_l1
    ADD CONSTRAINT sched_l1_sched_l1b_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, num_alb, elemento) REFERENCES sched_l1b(proprieta, cod_part, cod_fo, num_alb, elemento) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_a_propriet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_a
    ADD CONSTRAINT schede_a_propriet_fkey FOREIGN KEY (proprieta) REFERENCES propriet(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_b_schede_a; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_b
    ADD CONSTRAINT schede_b_schede_a FOREIGN KEY (proprieta, cod_part) REFERENCES schede_a(proprieta, cod_part) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_c_schede_x_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_c
    ADD CONSTRAINT schede_c_schede_x_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data) REFERENCES schede_x(proprieta, cod_part, cod_fo, tipo_ril, data) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_d_schede_x_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_d
    ADD CONSTRAINT schede_d_schede_x_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data) REFERENCES schede_x(proprieta, cod_part, cod_fo, tipo_ril, data) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_e_propriet_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_e
    ADD CONSTRAINT schede_e_propriet_fkey FOREIGN KEY (proprieta) REFERENCES propriet(codice) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_f_schede_x_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_f
    ADD CONSTRAINT schede_f_schede_x_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data) REFERENCES schede_x(proprieta, cod_part, cod_fo, tipo_ril, data) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_g1_schede_x_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_g1
    ADD CONSTRAINT schede_g1_schede_x_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data) REFERENCES schede_x(proprieta, cod_part, cod_fo, tipo_ril, data) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_g_schede_g1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_g
    ADD CONSTRAINT schede_g_schede_g1_fkey FOREIGN KEY (proprieta, cod_part, cod_fo, tipo_ril, data) REFERENCES schede_g1(proprieta, cod_part, cod_fo, tipo_ril, data) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_n_schede_b_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_n
    ADD CONSTRAINT schede_n_schede_b_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES schede_b(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: schede_x_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY schede_x
    ADD CONSTRAINT schede_x_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b1(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: stime_b1_sched_b1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY stime_b1
    ADD CONSTRAINT stime_b1_sched_b1_fkey FOREIGN KEY (proprieta, cod_part, cod_fo) REFERENCES sched_b1(proprieta, cod_part, cod_fo) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: user_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_diz_regioni
    ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES "user"(id);


--
-- Name: user_profile_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_profile_id_fkey FOREIGN KEY (profile_id) REFERENCES profile(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

