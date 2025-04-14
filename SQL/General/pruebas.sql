SELECT * FROM ESTADOS WHERE ESTADO = 'Inactivo';

SELECT * FROM VISTA_ROL_PERSONA;

SELECT * FROM PERSONAS;

SELECT * FROM CORREOS;

SELECT * FROM VISTA_PERSONAS_COMPLETA;

EXEC ACTUALIZAR_PERSONA(10001, 'Luis Mario', 'Monge', '888-888','Cliente', 1, 1, 6, 'luismario@gmail.com', 'lucho@gmail.com');

ROLLBACK;

CREATE OR REPLACE PROCEDURE ACTUALIZAR_PASSWORD(
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

        ------------------------------------------------------------
        --- Bloque Password                                     ----
        ------------------------------------------------------------
        
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

        INSERT INTO ENCRIPCION_PASSWORDS (PASSWORD_ID, PASSWORD_VAL, LLAVE) VALUES (V_ID_PASSWORD_ID, V_PASSWORD_RAW, V_LLAVE);   
        
        --Creacion del estado de la contrasena
        V_ESTADO_PASSWORD_ENCRIPCION_ID := CREAR_ENTRADA_ESTADO(V_ID_PASSWORD_ID,'ENCRIPCION_PASSWORDS', P_COMENTARIO);
        
        UPDATE ENCRIPCION_PASSWORDS
        SET ID_ESTADO = V_ESTADO_PASSWORD_ENCRIPCION_ID
        WHERE PASSWORD_ID = V_ID_PASSWORD_ID;


END;