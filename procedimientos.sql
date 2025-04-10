/*
Seccion de pruebas
SELECT * FROM ESTADOS;
SELECT * FROM DISTRITO;
SELECT * FROM CANTON;
SELECT * FROM PROVINCIA;
SELECT * FROM ROL_PERSONA;
SELECT * FROM PERSONAS;
SELECT * FROM DIRECCIONES_PERSONAS;
SELECT * FROM ENCRIPCION_PASSWORDS;
SELECT * FROM CORREOS;
*/


---------------------- Correr en session de Playa Cacao---------------------
-- Procedimientos almacenados

------------------- Funcion para crear estados -------------------------------------------------

CREATE OR REPLACE FUNCTION CREAR_ENTRADA_ESTADO(P_ID_ENTRADA VARCHAR, P_TABLA VARCHAR, P_COMENTARIO VARCHAR) RETURN VARCHAR
AS

    V_ESTADO_ID VARCHAR(250); --Variable para almacenar el ID Del estado

BEGIN

    --Creacion del valor para el ID de la entrada
    V_ESTADO_ID := 'ST_' || TO_CHAR(P_ID_ENTRADA) || '_' || P_TABLA;
    
    --Creacion del estado que lleva el control de la entrada
    INSERT INTO ESTADOS(ID_ESTADO, TABLA_ENTRADA, COMENTARIO, FECHA_CAMBIO, ESTADO) 
    VALUES (V_ESTADO_ID, P_TABLA, P_COMENTARIO, CURRENT_DATE, 'Activo');
    COMMIT;
    RETURN V_ESTADO_ID;
END;

--------------------Procedimiento almacenado para insertar un nuevo Distrito--------------------

CREATE OR REPLACE PROCEDURE CREAR_DISTRITO(
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

END;

--------------------Procedimiento almacenado para insertar un nuevo Canton----------------------
CREATE OR REPLACE PROCEDURE CREAR_CANTON(
    P_NOMBRE_CANTON VARCHAR,
    P_COMENTARIO VARCHAR 
)
AS
    V_ESTADO_ID VARCHAR(250); --Variable para almacenar la id del estado del distrito
    V_ID_CANTON NUMBER; --Variable para almacenar la id del distrito
BEGIN
    
    --Insercion del distrito
    INSERT INTO CANTON(NOMBRE_CANTON) VALUES (P_NOMBRE_CANTON);
    
    --Obtenemos el id del distrito por medio del nombre
    SELECT ID_CANTON
        INTO V_ID_CANTON
        FROM CANTON
        WHERE NOMBRE_CANTON = P_NOMBRE_CANTON;
    
    --Creamos el estado del rol llamando a la funcion delegada
    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_CANTON),'CANTON', P_COMENTARIO);
    
    --Actualizamos el id del estado
    UPDATE CANTON
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_CANTON = V_ID_CANTON;
    
    COMMIT;

END;

------------------Procedimiento almacenado para insertar una nueva provincia--------------------
CREATE OR REPLACE PROCEDURE CREAR_PROVINCIA(
    P_NOMBRE_PROVINCIA VARCHAR,
    P_COMENTARIO VARCHAR 
)
AS
    V_ESTADO_ID VARCHAR(250); --Variable para almacenar la id del estado del distrito
    V_ID_PROVINCIA NUMBER; --Variable para almacenar la id del distrito
BEGIN
    
    --Insercion del distrito
    INSERT INTO PROVINCIA(NOMBRE_PROVINCIA) VALUES (P_NOMBRE_PROVINCIA);
    
    --Obtenemos el id del distrito por medio del nombre
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

END;

------Procedimiento almacenado para insertar un nuevo rol en la aplicacion-----------------

CREATE OR REPLACE PROCEDURE CREAR_ROL(
    P_ID_ROL VARCHAR,
    P_NOMBRE_LARGO_TIPO VARCHAR,
    P_DESCRIPCION VARCHAR,
    P_COMENTARIO VARCHAR
)

AS
    V_ESTADO_ID VARCHAR(250); --Variable para almacenar la id del estado del rol
BEGIN
    --Insertamos el rol en tabla de roles
    INSERT INTO ROL_PERSONA(ID_ROL_PERSONA, NOMBRE_LARGO_TIPO, DESCRIPCION) VALUES
    (P_ID_ROL, P_NOMBRE_LARGO_TIPO, P_DESCRIPCION);

    --Creamos el estado del rol llamando a la funcion delegada
    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(P_ID_ROL,'ROL_PERSONA', P_COMENTARIO);

    UPDATE ROL_PERSONA
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_ROL_PERSONA = P_ID_ROL;

    COMMIT;
END;

------Procedimiento almacenado para insertar una nueva direccion para una persona----------
CREATE OR REPLACE PROCEDURE CREAR_PERSONA(
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
END;   




------------------------------------------------------------------------------------------------------------------------------------------------------------------------


-- Procedimientos almacenados
-- Inserta un nuevo cliente
CREATE OR REPLACE PROCEDURE INSERTAR_CLIENTE(
    P_CEDULA NUMBER, P_NOMBRE VARCHAR, P_APELLIDO VARCHAR, P_NUMERO_TELEFONO VARCHAR
) AS
BEGIN
    INSERT INTO CLIENTES (CEDULA, NOMBRE, APELLIDO, NUMERO_DE_TELEFONO)
    VALUES (P_CEDULA, P_NOMBRE, P_APELLIDO, P_NUMERO_TELEFONO);
    COMMIT;
END;
 
-- Inserta un nuevo empleado
CREATE OR REPLACE PROCEDURE INSERTAR_EMPLEADO(
    P_ID_EMPLEADO NUMBER, P_ID_DEPARTAMENTO NUMBER, P_ID_PUESTO NUMBER,
    P_NOMBRE VARCHAR, P_APELLIDO VARCHAR, P_SALARIO NUMBER, P_CEDULA NUMBER
) AS
BEGIN
    INSERT INTO EMPLEADOS (ID_EMPLEADO, ID_DEPARTAMENTO, ID_PUESTO, NOMBRE, APELLIDO, SALARIO, CEDULA)
    VALUES (P_ID_EMPLEADO, P_ID_DEPARTAMENTO, P_ID_PUESTO, P_NOMBRE, P_APELLIDO, P_SALARIO, P_CEDULA);
    COMMIT;
END;
 
-- Elimina un cliente por su c�dula
CREATE OR REPLACE PROCEDURE ELIMINAR_CLIENTE(P_CEDULA NUMBER) AS
BEGIN
    DELETE FROM CLIENTES WHERE CEDULA = P_CEDULA;
    COMMIT;
END;
 
-- Actualiza el salario de un empleado
CREATE OR REPLACE PROCEDURE ACTUALIZAR_SALARIO_EMPLEADO(P_ID_EMPLEADO NUMBER, P_NUEVO_SALARIO NUMBER) AS
BEGIN
    UPDATE EMPLEADOS SET SALARIO = P_NUEVO_SALARIO WHERE ID_EMPLEADO = P_ID_EMPLEADO;
    COMMIT;
END;
 
-- Recupera informaci�n de un cliente
CREATE OR REPLACE PROCEDURE OBTENER_CLIENTE(P_CEDULA NUMBER) AS
    CURSOR CUR_CLIENTE IS SELECT * FROM CLIENTES WHERE CEDULA = P_CEDULA;
    REG CLIENTES%ROWTYPE;
BEGIN
    OPEN CUR_CLIENTE;
    FETCH CUR_CLIENTE INTO REG;
    CLOSE CUR_CLIENTE;
END;
 
-- Inserta un usuario
CREATE OR REPLACE PROCEDURE INSERTAR_USUARIO(P_ID_USUARIO NUMBER, P_CORREO VARCHAR, P_PASSWORD VARCHAR, P_ROL_ID NUMBER) AS
BEGIN
    INSERT INTO USUARIOS (ID_USUARIO, CORREO, PASSWORD, ROL_ID)
    VALUES (P_ID_USUARIO, P_CORREO, P_PASSWORD, P_ROL_ID);
    COMMIT;
END;
 
-- Elimina un usuario
CREATE OR REPLACE PROCEDURE ELIMINAR_USUARIO(P_ID_USUARIO NUMBER) AS
BEGIN
    DELETE FROM USUARIOS WHERE ID_USUARIO = P_ID_USUARIO;
    COMMIT;
END;

-- Inserta una nueva direcci�n de correo para un cliente
CREATE OR REPLACE PROCEDURE INSERTAR_CORREO_CLIENTE(
    P_CORREO VARCHAR, P_CORREO_RESPALDO VARCHAR, P_CEDULA_CLIENTE NUMBER
) AS
BEGIN
    INSERT INTO CORREO_CLIENTES (DIRECCION_DE_CORREO, CORREO_DE_RESPALDO, CEDULA_CLIENTE)
    VALUES (P_CORREO, P_CORREO_RESPALDO, P_CEDULA_CLIENTE);
    COMMIT;
END;
 
-- Inserta una nueva direcci�n de correo para un empleado
CREATE OR REPLACE PROCEDURE INSERTAR_CORREO_EMPLEADO(
    P_CORREO VARCHAR, P_CORREO_RESPALDO VARCHAR, P_ID_EMPLEADO NUMBER
) AS
BEGIN
    INSERT INTO CORREO_EMPLEADOS (DIRECCION_DE_CORREO, CORREO_DE_RESPALDO, ID_EMPLEADO_CORREO)
    VALUES (P_CORREO, P_CORREO_RESPALDO, P_ID_EMPLEADO);
    COMMIT;
END;
 
-- Obtiene todos los clientes
CREATE OR REPLACE PROCEDURE OBTENER_TODOS_CLIENTES AS
    CURSOR CUR_CLIENTES IS SELECT * FROM CLIENTES;
BEGIN
    FOR REG IN CUR_CLIENTES LOOP
        DBMS_OUTPUT.PUT_LINE(REG.NOMBRE || ' ' || REG.APELLIDO);
    END LOOP;
END;

-- Obtiene todos los empleados
CREATE OR REPLACE PROCEDURE OBTENER_TODOS_EMPLEADOS AS
    CURSOR CUR_EMPLEADOS IS SELECT * FROM EMPLEADOS;
BEGIN
    FOR REG IN CUR_EMPLEADOS LOOP
        DBMS_OUTPUT.PUT_LINE(REG.NOMBRE || ' ' || REG.APELLIDO);
    END LOOP;
END;
 
-- Actualiza el correo de un usuario
CREATE OR REPLACE PROCEDURE ACTUALIZAR_CORREO_USUARIO(
    P_ID_USUARIO NUMBER, P_NUEVO_CORREO VARCHAR
) AS
BEGIN
    UPDATE USUARIOS SET CORREO = P_NUEVO_CORREO WHERE ID_USUARIO = P_ID_USUARIO;
    COMMIT;
END;
 
-- Elimina un correo de cliente
CREATE OR REPLACE PROCEDURE ELIMINAR_CORREO_CLIENTE(P_CORREO VARCHAR) AS
BEGIN
    DELETE FROM CORREO_CLIENTES WHERE DIRECCION_DE_CORREO = P_CORREO;
    COMMIT;
END;
 
-- Elimina un correo de empleado
CREATE OR REPLACE PROCEDURE ELIMINAR_CORREO_EMPLEADO(P_CORREO VARCHAR) AS
BEGIN
    DELETE FROM CORREO_EMPLEADOS WHERE DIRECCION_DE_CORREO = P_CORREO;
    COMMIT;
END;