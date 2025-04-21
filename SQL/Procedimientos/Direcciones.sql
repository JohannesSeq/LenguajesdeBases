 --------------------------------Creacion del paquete provincias---------------------------------------
CREATE OR REPLACE PACKAGE PKT_PROVINCIAS AS

    PROCEDURE CREAR_PROVINCIA( P_NOMBRE_PROVINCIA VARCHAR, P_COMENTARIO VARCHAR);
    PROCEDURE ENVIO_TOTAL_PROVINCIAS (P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
    PROCEDURE ENVIO_PROVINCIA (P_ID_PROVINCIA NUMBER, P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
    PROCEDURE ACTUALIZAR_PROVINCIA (P_ID_PROVINCIA NUMBER,P_NUEVO_NOMBRE VARCHAR);

END PKT_PROVINCIAS;

CREATE OR REPLACE PACKAGE BODY PKT_PROVINCIAS AS

--Procedimiento almacenado para insertar una nueva provincia--
    PROCEDURE CREAR_PROVINCIA(
        P_NOMBRE_PROVINCIA VARCHAR,
        P_COMENTARIO VARCHAR 
    )
    AS
        V_ESTADO_ID VARCHAR(250); --Variable para almacenar la id del estado de la provincia
        V_ID_PROVINCIA NUMBER; --Variable para almacenar la id de la provincia
    BEGIN
        
        --Insercion de la provincia
        INSERT INTO PROVINCIA(NOMBRE_PROVINCIA) VALUES (P_NOMBRE_PROVINCIA);
        
        --Obtenemos el id de la provincia por medio del nombre
        SELECT ID_PROVINCIA
            INTO V_ID_PROVINCIA
            FROM PROVINCIA
            WHERE NOMBRE_PROVINCIA = P_NOMBRE_PROVINCIA;
        
        --Creamos el estado del rol llamando a la funcion delegada
        V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_PROVINCIA),'PROVINCIA', P_COMENTARIO);

        --Actualizamos el id del estado
        UPDATE PROVINCIA
        SET ID_ESTADO = V_ESTADO_ID
        WHERE ID_PROVINCIA = V_ID_PROVINCIA;
        
        COMMIT;

    END CREAR_PROVINCIA;

--Procedimiento almacenado para leer todas las provincias--

    PROCEDURE ENVIO_TOTAL_PROVINCIAS (
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
        OPEN P_CURSOR_RESULTADO FOR
            SELECT ID_PROVINCIA, NOMBRE_PROVINCIA
            FROM VISTA_PROVINCIAS;
    END ENVIO_TOTAL_PROVINCIAS;

--Procedimiento almacenado para leer una provincia --

    PROCEDURE ENVIO_PROVINCIA (
        P_ID_PROVINCIA NUMBER,
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
        OPEN P_CURSOR_RESULTADO FOR
            SELECT ID_PROVINCIA, NOMBRE_PROVINCIA
            FROM VISTA_PROVINCIAS
            WHERE ID_PROVINCIA = P_ID_PROVINCIA;
    END ENVIO_PROVINCIA;

--Procedimiento almacenado para actualizar una provincia--

    PROCEDURE ACTUALIZAR_PROVINCIA (
        P_ID_PROVINCIA NUMBER,
        P_NUEVO_NOMBRE VARCHAR
    )
    AS
    BEGIN

        UPDATE PROVINCIA
        SET NOMBRE_PROVINCIA = P_NUEVO_NOMBRE
        WHERE ID_PROVINCIA = P_ID_PROVINCIA;

        COMMIT;

    END ACTUALIZAR_PROVINCIA;

END PKT_PROVINCIAS;
---------------------------------Fin del paquete provincias----------------------------------------------

 --------------------------------Creacion del paquete cantones ------------------------------------------

CREATE OR REPLACE PACKAGE PKT_CANTONES AS

        PROCEDURE CREAR_CANTON(P_NOMBRE_CANTON VARCHAR,P_COMENTARIO VARCHAR );
        PROCEDURE ENVIO_TOTAL_CANTONES ( P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
        PROCEDURE ENVIO_CANTON ( P_ID_CANTON NUMBER, P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
        PROCEDURE ACTUALIZAR_CANTON ( P_ID_CANTON NUMBER, P_NUEVO_NOMBRE VARCHAR);

END PKT_CANTONES;

CREATE OR REPLACE PACKAGE BODY PKT_CANTONES AS

--Procedimiento  para insertar un nuevo Canton
    PROCEDURE CREAR_CANTON(
        P_NOMBRE_CANTON VARCHAR,
        P_COMENTARIO VARCHAR 
    )
    AS
        V_ESTADO_ID VARCHAR(250); --Variable para almacenar la id del estado del distrito
        V_ID_CANTON NUMBER; --Variable para almacenar la id del distrito
    BEGIN
        
        --Insercion del canton
        INSERT INTO CANTON(NOMBRE_CANTON) VALUES (P_NOMBRE_CANTON)
        RETURNING ID_CANTON INTO V_ID_CANTON;

        --Creamos el estado del rol llamando a la funcion delegada
        V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_CANTON),'CANTON', P_COMENTARIO);
        
        --Actualizamos el id del estado
        UPDATE CANTON
        SET ID_ESTADO = V_ESTADO_ID
        WHERE ID_CANTON = V_ID_CANTON;
        
        COMMIT;

    END CREAR_CANTON;


--Procedimiento almacenado para leer todas los cantones--

    PROCEDURE ENVIO_TOTAL_CANTONES (
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
        OPEN P_CURSOR_RESULTADO FOR
            SELECT ID_CANTON, NOMBRE_CANTON
            FROM VISTA_CANTONES;
    END ENVIO_TOTAL_CANTONES;

--Procedimiento almacenado para leer una provincia --

    PROCEDURE ENVIO_CANTON (
        P_ID_CANTON NUMBER,
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
        OPEN P_CURSOR_RESULTADO FOR
            SELECT ID_CANTON, NOMBRE_CANTON
            FROM VISTA_CANTONES
            WHERE ID_CANTON = P_ID_CANTON;
    END ENVIO_CANTON;

--Procedimiento almacenado para actualizar una provincia--

    PROCEDURE ACTUALIZAR_CANTON (
        P_ID_CANTON NUMBER,
        P_NUEVO_NOMBRE VARCHAR
    )
    AS
    BEGIN

        UPDATE CANTON
        SET NOMBRE_CANTON = P_NUEVO_NOMBRE
        WHERE ID_CANTON = P_ID_CANTON;

        COMMIT;

    END ACTUALIZAR_CANTON;

END PKT_CANTONES;
---------------------------------Fin del paquete cantones ------------------------------------------------

 --------------------------------Creacion del paquete Distritos ------------------------------------------

CREATE OR REPLACE PACKAGE PKT_DISTRITOS AS

    PROCEDURE CREAR_DISTRITO( P_NOMBRE_DISTRITO VARCHAR, P_COMENTARIO VARCHAR );
    PROCEDURE ENVIO_TOTAL_DISTRITOS ( P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
    PROCEDURE ENVIO_DISTRITO ( P_ID_DISTRITO NUMBER, P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
    PROCEDURE ACTUALIZAR_DISTRITO ( P_ID_DISTRITO NUMBER, P_NUEVO_NOMBRE VARCHAR);

END PKT_DISTRITOS;

CREATE OR REPLACE PACKAGE BODY PKT_DISTRITOS AS

--Procedimiento almacenado para insertar un nuevo Distrito

    PROCEDURE CREAR_DISTRITO(
        P_NOMBRE_DISTRITO VARCHAR,
        P_COMENTARIO VARCHAR 
    )
    AS
        V_ESTADO_ID VARCHAR(250); --Variable para almacenar la id del estado del distrito
        V_ID_DISTRITO NUMBER; --Variable para almacenar la id del distrito
    BEGIN
        
        --Insercion del distrito
        INSERT INTO DISTRITO(NOMBRE_DISTRITO) VALUES (P_NOMBRE_DISTRITO);
        
        --Obtenemos el id del distrito por medio del nombre
        SELECT ID_DISTRITO
            INTO V_ID_DISTRITO
            FROM DISTRITO
            WHERE NOMBRE_DISTRITO = P_NOMBRE_DISTRITO;
        
        --Creamos el estado del rol llamando a la funcion delegada
        V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_DISTRITO),'DISTRITO', P_COMENTARIO);
        
        --Actualizamos el id del estado
        UPDATE DISTRITO
        SET ID_ESTADO = V_ESTADO_ID
        WHERE ID_DISTRITO = V_ID_DISTRITO;
        
        COMMIT;

    END CREAR_DISTRITO;

--Procedimiento almacenado para leer todas los DISTRITOS--

    PROCEDURE ENVIO_TOTAL_DISTRITOS (
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
        OPEN P_CURSOR_RESULTADO FOR
            SELECT ID_DISTRITO, NOMBRE_DISTRITO
            FROM VISTA_DISTRITOS;
    END ENVIO_TOTAL_DISTRITOS;

--Procedimiento almacenado para leer una provincia --

    PROCEDURE ENVIO_DISTRITO (
        P_ID_DISTRITO NUMBER,
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
        OPEN P_CURSOR_RESULTADO FOR
            SELECT ID_DISTRITO, NOMBRE_DISTRITO
            FROM VISTA_DISTRITOS
            WHERE ID_DISTRITO = P_ID_DISTRITO;
    END ENVIO_DISTRITO;

--Procedimiento almacenado para actualizar una provincia--

    PROCEDURE ACTUALIZAR_DISTRITO (
        P_ID_DISTRITO NUMBER,
        P_NUEVO_NOMBRE VARCHAR
    )
    AS
    BEGIN

        UPDATE DISTRITO
        SET NOMBRE_DISTRITO = P_NUEVO_NOMBRE
        WHERE ID_DISTRITO = P_ID_DISTRITO;

        COMMIT;

    END ACTUALIZAR_DISTRITO;



END PKT_DISTRITOS;
---------------------------------Fin del paquete Distritos -----------------------------------------------

 --------------------------------Creacion del paquete Roles ----------------------------------------------

EXEC PKT_ROL_PERSONA.ACTUALIZAR_ROL_PERSONA('Prueba01', 'Prueba001', 'Prueba01', 'Limitado');
SELECT * FROM ROL_PERSONA;

CREATE OR REPLACE PACKAGE PKT_ROL_PERSONA AS

    PROCEDURE CREAR_ROL_PERSONA(P_ID_ROL VARCHAR,P_NOMBRE_LARGO_TIPO VARCHAR,P_DESCRIPCION VARCHAR, P_NIVEL VARCHAR, P_COMENTARIO VARCHAR);
    PROCEDURE ENVIO_TOTAL_ROL_PERSONA (P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
    PROCEDURE ENVIO_ROL_PERSONA (P_ID_ROL_PERSONA VARCHAR,P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
    PROCEDURE ACTUALIZAR_ROL_PERSONA (P_ID_ROL_PERSONA VARCHAR, P_NUEVO_NOMBRE_LARGO_TIPO VARCHAR, P_NUEVA_DESCRIPCION VARCHAR, P_NUEVO_NIVEL_PERMISO VARCHAR);

END PKT_ROL_PERSONA;


CREATE OR REPLACE PACKAGE BODY PKT_ROL_PERSONA AS

--Procedimiento almacenado para insertar un nuevo rol en la aplicacion

    PROCEDURE CREAR_ROL_PERSONA(
        P_ID_ROL VARCHAR,
        P_NOMBRE_LARGO_TIPO VARCHAR,
        P_DESCRIPCION VARCHAR,
        P_NIVEL VARCHAR,
        P_COMENTARIO VARCHAR
    )

    AS
        V_ESTADO_ID VARCHAR(250); --Variable para almacenar la id del estado del rol
    BEGIN
        --Insertamos el rol en tabla de roles
        INSERT INTO ROL_PERSONA(ID_ROL_PERSONA, NOMBRE_LARGO_TIPO, DESCRIPCION, NIVEL_PERMISO) VALUES
        (P_ID_ROL, P_NOMBRE_LARGO_TIPO, P_DESCRIPCION, P_NIVEL);

        --Creamos el estado del rol llamando a la funcion delegada
        V_ESTADO_ID := CREAR_ENTRADA_ESTADO(P_ID_ROL,'ROL_PERSONA', P_COMENTARIO);

        UPDATE ROL_PERSONA
        SET ID_ESTADO = V_ESTADO_ID
        WHERE ID_ROL_PERSONA = P_ID_ROL;

        COMMIT;
    END CREAR_ROL_PERSONA;

--Procedimiento almacenado para leer todas los ROL_PERSONA--

    PROCEDURE ENVIO_TOTAL_ROL_PERSONA (
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
        OPEN P_CURSOR_RESULTADO FOR
            SELECT ID_ROL_PERSONA, NOMBRE_LARGO_TIPO, DESCRIPCION, NIVEL_PERMISO
            FROM VISTA_ROL_PERSONA;
    END ENVIO_TOTAL_ROL_PERSONA;

--Procedimiento almacenado para leer un rol --

    PROCEDURE ENVIO_ROL_PERSONA (
        P_ID_ROL_PERSONA VARCHAR,
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
        OPEN P_CURSOR_RESULTADO FOR
            SELECT ID_ROL_PERSONA, NOMBRE_LARGO_TIPO, DESCRIPCION, NIVEL_PERMISO
            FROM VISTA_ROL_PERSONA
            WHERE ID_ROL_PERSONA = P_ID_ROL_PERSONA;
    END ENVIO_ROL_PERSONA;

--Procedimiento almacenado para actualizar un rol--

    PROCEDURE ACTUALIZAR_ROL_PERSONA (
        P_ID_ROL_PERSONA VARCHAR,
        P_NUEVO_NOMBRE_LARGO_TIPO VARCHAR,
        P_NUEVA_DESCRIPCION VARCHAR,
        P_NUEVO_NIVEL_PERMISO VARCHAR
    )
    AS
    BEGIN

        UPDATE ROL_PERSONA
        SET 
        
            NOMBRE_LARGO_TIPO = P_NUEVO_NOMBRE_LARGO_TIPO,
            DESCRIPCION = P_NUEVA_DESCRIPCION,
            NIVEL_PERMISO = P_NUEVO_NIVEL_PERMISO

        WHERE ID_ROL_PERSONA = P_ID_ROL_PERSONA;

        COMMIT;

    END ACTUALIZAR_ROL_PERSONA;

END PKT_ROL_PERSONA;

-------------- Procedimiento para eliminar un distrito  ----------------------

CREATE OR REPLACE PROCEDURE ELIMINAR_DISTRITO(
    P_ID_DISTRITO IN NUMBER,
    P_RESULTADO OUT VARCHAR
)
AS
    V_ID_ESTADO VARCHAR(250);
BEGIN
    SELECT ID_ESTADO INTO V_ID_ESTADO
    FROM DISTRITO
    WHERE ID_DISTRITO = P_ID_DISTRITO;
    DELETE FROM DISTRITO WHERE ID_DISTRITO = P_ID_DISTRITO;
    DELETE FROM ESTADOS WHERE ID_ESTADO = V_ID_ESTADO;
    COMMIT;

    P_RESULTADO := 'BORRADO_FISICO';

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        P_RESULTADO := 'NO_EXISTE_RESERVA';
END;

-------------- Procedimiento para eliminar un canton ----------------------

CREATE OR REPLACE PROCEDURE ELIMINAR_CANTON(
    P_ID_CANTON IN NUMBER,
    P_RESULTADO OUT VARCHAR
)
AS
    V_ID_ESTADO VARCHAR(250);
BEGIN
    SELECT ID_ESTADO INTO V_ID_ESTADO
    FROM CANTON
    WHERE ID_CANTON = P_ID_CANTON;
    DELETE FROM CANTON WHERE ID_CANTON = P_ID_CANTON;
    DELETE FROM ESTADOS WHERE ID_ESTADO = V_ID_ESTADO;
    COMMIT;

    P_RESULTADO := 'BORRADO_FISICO';

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        P_RESULTADO := 'NO_EXISTE_RESERVA';
END;
/
