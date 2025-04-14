

 --------------------------------Creacion del paquete personas---------------------------------------

------Procedimiento almacenado para insertar una nueva direccion para una persona----------

SELECT * FROM VISTA_PERSONAS_COMPLETA;

CREATE OR REPLACE PACKAGE PKT_PERSONAS AS

    PROCEDURE CREAR_PERSONA(
        P_CEDULA NUMBER, P_NOMBRE VARCHAR, P_APELLIDO VARCHAR, P_NUMERO_DE_TELEFONO VARCHAR, P_ID_ROL VARCHAR,
        P_ID_PROVINCIA NUMBER, P_ID_CANTON NUMBER, P_ID_DISTRITO NUMBER,
        P_CORREO VARCHAR, P_CORREO_RESPALDO VARCHAR,
        P_PASSWORD VARCHAR,
        P_COMENTARIO VARCHAR);

    PROCEDURE ENVIO_TOTAL_PERSONAS(P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
    PROCEDURE ENVIO_PERSONA(P_CEDULA NUMBER, P_CURSOR_RESULTADO OUT SYS_REFCURSOR);

    PROCEDURE ACTUALIZAR_PERSONA(
        P_CEDULA NUMBER, P_NOMBRE VARCHAR, P_APELLIDO VARCHAR, P_NUMERO_DE_TELEFONO VARCHAR, P_ID_ROL VARCHAR,
        P_ID_PROVINCIA NUMBER, P_ID_CANTON NUMBER, P_ID_DISTRITO NUMBER,
        P_CORREO VARCHAR, P_CORREO_RESPALDO VARCHAR
    );

    PROCEDURE ACTUALIZAR_PASSWORD( P_CEDULA NUMBER, P_PASSWORD VARCHAR);

END PKT_PERSONAS;

CREATE OR REPLACE PACKAGE BODY PKT_PERSONAS AS

    PROCEDURE CREAR_PERSONA(
        P_CEDULA NUMBER, P_NOMBRE VARCHAR, P_APELLIDO VARCHAR, P_NUMERO_DE_TELEFONO VARCHAR, P_ID_ROL VARCHAR, --Parametros de la persona
        P_ID_PROVINCIA NUMBER, P_ID_CANTON NUMBER, P_ID_DISTRITO NUMBER, --Parametros de la direcion
        P_CORREO VARCHAR, P_CORREO_RESPALDO VARCHAR, --Parametros del correo
        P_PASSWORD VARCHAR, --Parametros de la contraseña
        P_COMENTARIO VARCHAR
    )
    AS

        ---- Variables para estados ----
        V_ESTADO_PERSONA_ID VARCHAR(250); --Variable para almacenar el estado de la persona
        V_ESTADO_DIRECCION_PERSONA_ID VARCHAR(250); --Variable para almacenar el estado de la direccion de la persona
        V_ESTADO_CORREOS_ID VARCHAR(250); --Variable para almacenar el estado del correo de la persona
        V_ESTADO_PASSWORD_ENCRIPCION_ID VARCHAR(250); --Variable para almacenar el estado de la contraseña de la persona
        

        --- Variables de IDs ---
        V_ID_DIRECCION_PERSONA VARCHAR(100); -- Variable para almacenar el id de de la direccion
        V_ID_PASSWORD_ID VARCHAR(100); --Variable para almacenar el id de la contraeña
        
        --- Variables para la contraseña
        V_LLAVE RAW(32); --Variable para almacenar la llave de encriptacion
        V_PASSWORD_RAW RAW(2000); --Variable para almaacenar la contraseña encriptada
        V_PASSWORD_ID VARCHAR(100); -- Variable para almacenar el ID del password
        
    BEGIN

        ------------------------------------------------------------
        --- Bloque direccion                                    ----
        ------------------------------------------------------------
        
        --Insertamos la direccion de la persona en la tabla personas
        V_ID_DIRECCION_PERSONA := 'Dir_' || TO_CHAR(P_CEDULA); --Asignacion del valor del id de la direccion
        INSERT INTO DIRECCIONES_PERSONAS(ID_DIRECCION, ID_DISTRITO, ID_CANTON, ID_PROVINCIA) 
        VALUES (V_ID_DIRECCION_PERSONA, P_ID_DISTRITO, P_ID_CANTON, P_ID_PROVINCIA);
        
        --Creamos el estado de la direccion llamando a la funcion delegada
        V_ESTADO_DIRECCION_PERSONA_ID := CREAR_ENTRADA_ESTADO(V_ID_DIRECCION_PERSONA,'DIRECCIONES_PERSONAS', P_COMENTARIO);

        --Actualizamos el id del estado en la direccion
        UPDATE DIRECCIONES_PERSONAS
        SET ID_ESTADO = V_ESTADO_DIRECCION_PERSONA_ID
        WHERE ID_DIRECCION = V_ID_DIRECCION_PERSONA;
    
        ------------------------------------------------------------
        --- Bloque Correos                                      ----
        ------------------------------------------------------------

        INSERT INTO CORREOS(DIRECCION_DE_CORREO, CORREO_DE_RESPALDO)
        VALUES (P_CORREO, P_CORREO_RESPALDO);

        V_ESTADO_CORREOS_ID := CREAR_ENTRADA_ESTADO(P_CORREO,'CORREOS', P_COMENTARIO);

        --Actualizamos el id del estado en el correo
        UPDATE CORREOS
        SET ID_ESTADO = V_ESTADO_CORREOS_ID
        WHERE DIRECCION_DE_CORREO = P_CORREO;

        ------------------------------------------------------------
        --- Bloque Password                                     ----
        ------------------------------------------------------------
        
        V_PASSWORD_ID := 'Pwd_' || TO_CHAR(P_CEDULA);

        --Creacion de la contraseña encriptada
        V_LLAVE := DBMS_CRYPTO.RANDOMBYTES(32);
        
        V_PASSWORD_RAW := DBMS_CRYPTO.ENCRYPT(
                                src => UTL_RAW.CAST_TO_RAW(P_PASSWORD),
                                typ => DBMS_CRYPTO.ENCRYPT_AES256 + DBMS_CRYPTO.CHAIN_CBC + DBMS_CRYPTO.PAD_PKCS5,
                                key => V_LLAVE);

        --Insertamos la contraseña encriptada
        V_ID_PASSWORD_ID := 'Pwd_' || TO_CHAR(P_CEDULA);
        INSERT INTO ENCRIPCION_PASSWORDS (PASSWORD_ID, PASSWORD_VAL, LLAVE) VALUES (V_ID_PASSWORD_ID, V_PASSWORD_RAW, V_LLAVE);   
        
        --Creacion del estado de la contrasena
        V_ESTADO_PASSWORD_ENCRIPCION_ID := CREAR_ENTRADA_ESTADO(V_ID_PASSWORD_ID,'ENCRIPCION_PASSWORDS', P_COMENTARIO);
        
        UPDATE ENCRIPCION_PASSWORDS
        SET ID_ESTADO = V_ESTADO_PASSWORD_ENCRIPCION_ID
        WHERE PASSWORD_ID = V_ID_PASSWORD_ID;

        ------------------------------------------------------------
        --- Bloque PERSONAS                                     ----
        ------------------------------------------------------------
        
        INSERT INTO PERSONAS(CEDULA,NOMBRE, APELLIDO, NUMERO_DE_TELEFONO, ID_ROL_PERSONA, DIRECCION_DE_CORREO, PASSWORD_ID, ID_DIRECCION) 
        VALUES (P_CEDULA, P_NOMBRE, P_APELLIDO, P_NUMERO_DE_TELEFONO, P_ID_ROL, P_CORREO, V_ID_PASSWORD_ID, V_ID_DIRECCION_PERSONA);

        --Creacion de la persona
        V_ESTADO_PERSONA_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(P_CEDULA),'PERSONAS', P_COMENTARIO);

        --Asignamos el estado de la persona
        UPDATE PERSONAS
        SET ID_ESTADO = V_ESTADO_PERSONA_ID
        WHERE CEDULA = P_CEDULA;

        COMMIT;
    END CREAR_PERSONA;   


    --Procedimiento almacenado para leer todas las personas--

        PROCEDURE ENVIO_TOTAL_PERSONAS (
            P_CURSOR_RESULTADO OUT SYS_REFCURSOR
        )
        AS
        BEGIN
            OPEN P_CURSOR_RESULTADO FOR
                SELECT CEDULA, NOMBRE, APELLIDO, NUMERO_DE_TELEFONO, NOMBRE_ROL, DIRECCION_DE_CORREO, CORREO_DE_RESPALDO, DISTRITO, CANTON, PROVINCIA
                FROM VISTA_PERSONAS_COMPLETA;
        END ENVIO_TOTAL_PERSONAS;


    --Procedimiento almacenado para leer una persona
        PROCEDURE ENVIO_PERSONA (
            P_CEDULA NUMBER,
            P_CURSOR_RESULTADO OUT SYS_REFCURSOR
        )
        AS
        BEGIN
            OPEN P_CURSOR_RESULTADO FOR
                SELECT CEDULA, NOMBRE, APELLIDO, NUMERO_DE_TELEFONO, NOMBRE_ROL, DIRECCION_DE_CORREO, CORREO_DE_RESPALDO, DISTRITO, CANTON, PROVINCIA
                FROM VISTA_PERSONAS_COMPLETA
                WHERE CEDULA = P_CEDULA;

        END ENVIO_PERSONA;


-------------------------------------------------- Procedimiento para actualizar una persona -------------------------------------------------------------------

    PROCEDURE ACTUALIZAR_PERSONA(
        P_CEDULA NUMBER, P_NOMBRE VARCHAR, P_APELLIDO VARCHAR, P_NUMERO_DE_TELEFONO VARCHAR, P_ID_ROL VARCHAR,
        P_ID_PROVINCIA NUMBER, P_ID_CANTON NUMBER, P_ID_DISTRITO NUMBER,
        P_CORREO VARCHAR, P_CORREO_RESPALDO VARCHAR
    )
    AS
        --- Variables de IDs ---
        V_ID_DIRECCION_PERSONA VARCHAR(100) := 'Dir_' || TO_CHAR(P_CEDULA); -- Variable para almacenar el id de de la direccion
        
    BEGIN

        ------------------------------------------------------------
        --- Bloque direccion                                    ----
        ------------------------------------------------------------
        
        UPDATE DIRECCIONES_PERSONAS
            SET ID_DISTRITO = P_ID_DISTRITO,
                ID_CANTON = P_ID_CANTON,
                ID_PROVINCIA = P_ID_PROVINCIA
            WHERE ID_DIRECCION = V_ID_DIRECCION_PERSONA;
        
        ------------------------------------------------------------
        --- Bloque Correos                                      ----
        ------------------------------------------------------------

        --Borramos el correo para poder editarlo despues
        UPDATE PERSONAS
            SET DIRECCION_DE_CORREO = NULL
            WHERE CEDULA = P_CEDULA;

        --Actualizamos el correo
        UPDATE CORREOS
            SET DIRECCION_DE_CORREO = P_CORREO,
                CORREO_DE_RESPALDO = P_CORREO_RESPALDO
            WHERE DIRECCION_DE_CORREO = P_CORREO;


        ------------------------------------------------------------
        --- Bloque PERSONAS                                     ----
        ------------------------------------------------------------

        UPDATE PERSONAS
            SET NOMBRE = P_NOMBRE,
                APELLIDO = P_APELLIDO,
                NUMERO_DE_TELEFONO = P_NUMERO_DE_TELEFONO,
                ID_ROL_PERSONA = P_ID_ROL,
                DIRECCION_DE_CORREO = P_CORREO
            WHERE CEDULA = P_CEDULA;
        

        COMMIT;
    END ACTUALIZAR_PERSONA;

--Procedimiento para actualizar contraseñas
    PROCEDURE ACTUALIZAR_PASSWORD(
        P_CEDULA NUMBER,
        P_PASSWORD VARCHAR
    )
    AS

        --- Variables para la contraseña
        V_ID_PASSWORD_ID VARCHAR(100); --Variable para almacenar el id de la contraeña
        V_LLAVE RAW(32); --Variable para almacenar la llave de encriptacion
        V_PASSWORD_RAW RAW(2000); --Variable para almaacenar la contraseña encriptada
        V_PASSWORD_ID VARCHAR(100); -- Variable para almacenar el ID del password

    BEGIN            
        V_PASSWORD_ID := 'Pwd_' || TO_CHAR(P_CEDULA);

        --Creacion de la nueva contraseña encriptada
        V_LLAVE := DBMS_CRYPTO.RANDOMBYTES(32);
        
        V_PASSWORD_RAW := DBMS_CRYPTO.ENCRYPT(
                                src => UTL_RAW.CAST_TO_RAW(P_PASSWORD),
                                typ => DBMS_CRYPTO.ENCRYPT_AES256 + DBMS_CRYPTO.CHAIN_CBC + DBMS_CRYPTO.PAD_PKCS5,
                                key => V_LLAVE);

        --Insertamos la contraseña encriptada
        V_ID_PASSWORD_ID := 'Pwd_' || TO_CHAR(P_CEDULA);

        UPDATE ENCRIPCION_PASSWORDS
            SET LLAVE = V_LLAVE,
                PASSWORD_VAL = V_PASSWORD_RAW
            WHERE PASSWORD_ID = V_ID_PASSWORD_ID;
        COMMIT;
    END ACTUALIZAR_PASSWORD;

END PKT_PERSONAS;

---------------------------------Fin del paquete personas----------------------------------------------

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
