

 --------------------------------Creacion del paquete personas---------------------------------------

------Procedimiento almacenado para insertar una nueva direccion para una persona----------
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
                SELECT CEDULA, NOMBRE, APELLIDO, NUMERO_DE_TELEFONO, ID_ROL, NOMBRE_ROL, DIRECCION_DE_CORREO, CORREO_DE_RESPALDO, DISTRITO, CANTON, PROVINCIA, ID_CANTON, ID_DISTRITO, ID_PROVINCIA
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
                SELECT CEDULA, NOMBRE, APELLIDO, NUMERO_DE_TELEFONO, ID_ROL, NOMBRE_ROL, DIRECCION_DE_CORREO, CORREO_DE_RESPALDO, DISTRITO, CANTON, PROVINCIA, ID_CANTON, ID_DISTRITO, ID_PROVINCIA
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

