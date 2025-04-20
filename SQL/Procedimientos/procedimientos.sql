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
SELECT * FROM PUESTOS;
SELECT * FROM DEPARTAMENTOS;
SELECT * FROM EMPLEADOS;
SELECT * FROM PLATILLOS;
SELECT * FROM MENU;
SELECT * FROM PLATILLOS_MENU;
SELECT * FROM PEDIDOS;
SELECT * FROM METODO_PAGO;
SELECT * FROM LISTA_PLATILLOS;
SELECT * FROM FACTURAS;

SELECT AUTENTICACION('nidiaces@gmail.com','Password1234') AS RESULTADO_AUTH FROM DUAL;
SELECT CALCULAR_TOTAL_PEDIDO(2) FROM DUAL;

--EXEC ACTUALIZAR_TOTAL_PEDIDO(2);
EXEC BORRADO_LOGICO('ST_584551_PERSONAS','Probando_borrado_logico');
*/

---------------------- Correr en session de Playa Cacao---------------------
-- Procedimientos almacenados

------------------- Funcion para crear estados -------------------------------------------------

CREATE OR REPLACE FUNCTION CREAR_ENTRADA_ESTADO(
    P_ID_ENTRADA VARCHAR, P_TABLA VARCHAR, P_COMENTARIO VARCHAR
    ) RETURN VARCHAR
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
/

------------------- Funcion para autenticar usuarios -------------------------------------------
CREATE OR REPLACE FUNCTION AUTENTICACION(
    P_EMAIL VARCHAR,
    P_PASSWORD VARCHAR
) RETURN VARCHAR
AS
    --- Variables para la contraseña
    V_LLAVE RAW(32); --Variable para almacenar la llave de encriptacion
    V_PASSWORD_RAW RAW(2000); --Variable para almaacenar la contraseña encriptada
    V_PASSWORD_ID VARCHAR(100); -- Variable para almacenar el ID del password
    V_PASSWORD_DESENCRIPTADO RAW(1000); --Variable para almacenar la contraseña desencriptada
    V_PASSWORD_DESENCRIPTADO_VARCHAR VARCHAR(100);

    V_RESULTADO VARCHAR(100); --Variable para almacenar el valor final de la operacion
    
BEGIN
    V_RESULTADO := 'FALSE'; --Variable para almacenar el valor final de la operacion

    --Obtenemos el valor del id de la contraseña
    SELECT 
        PASSWORD_ID,
        LLAVE_PASSWORD, 
        PASSWORD_VAL
    INTO V_PASSWORD_ID, V_LLAVE, V_PASSWORD_RAW
    FROM VISTA_AUTENTICACION
    WHERE DIRECCION_DE_CORREO = P_EMAIL;

        -- Desencriptar los datos
    V_PASSWORD_DESENCRIPTADO := DBMS_CRYPTO.DECRYPT(
                        src => V_PASSWORD_RAW,
                        typ => DBMS_CRYPTO.ENCRYPT_AES256 + DBMS_CRYPTO.CHAIN_CBC + DBMS_CRYPTO.PAD_PKCS5,
                        key => V_LLAVE);

    --Convertimos el password de RAW a Varchar
    V_PASSWORD_DESENCRIPTADO_VARCHAR := UTL_RAW.CAST_TO_VARCHAR2(V_PASSWORD_DESENCRIPTADO); 


    IF V_PASSWORD_DESENCRIPTADO_VARCHAR = P_PASSWORD THEN
        V_RESULTADO := 'TRUE';
    END IF;

    RETURN V_RESULTADO;
    
    EXCEPTION
    WHEN NO_DATA_FOUND THEN
        V_RESULTADO := 'FALSE';
        RETURN V_RESULTADO;
END;
/

------------ Procedimiento almacenado para enviar la info del usuario autenticado---------------

CREATE OR REPLACE PROCEDURE ENVIO_AUTENTICACION (
    P_CORREO VARCHAR,
    P_PASSWORD VARCHAR,
    P_CURSOR_RESULTADO OUT SYS_REFCURSOR
)
AS
    V_RESULTADO_AUTH VARCHAR(20) := 'False';
BEGIN
    V_RESULTADO_AUTH := AUTENTICACION(P_CORREO,P_PASSWORD);

    IF V_RESULTADO_AUTH = 'TRUE' THEN
        OPEN P_CURSOR_RESULTADO FOR
        SELECT NOMBRE, DIRECCION_DE_CORREO, ROL, NIVEL_PERMISO
        FROM VISTA_AUTENTICACION
        WHERE DIRECCION_DE_CORREO = P_CORREO;

    ELSE

        OPEN P_CURSOR_RESULTADO FOR
        SELECT NOMBRE, DIRECCION_DE_CORREO, ROL
        FROM VISTA_AUTENTICACION
        WHERE DIRECCION_DE_CORREO = 'Invalid';
    END IF;
END;
/

------------------------------ BORRADO LOGICO -----------------------------------------
CREATE OR REPLACE PROCEDURE BORRADO_LOGICO(
    P_TABLA VARCHAR,
    P_ID VARCHAR,
    P_COMENTARIO VARCHAR
)
AS
    V_ESTADO_ID VARCHAR(250);
    V_ID_ESTADO VARCHAR(250);
BEGIN

    V_ESTADO_ID := 'ST_' || TO_CHAR(P_ID) || '_' || P_TABLA;

    UPDATE ESTADOS
    SET ESTADO = 'Inactivo', FECHA_CAMBIO = CURRENT_DATE
    WHERE ID_ESTADO = V_ESTADO_ID;

    COMMIT;
END;
/
EXEC BORRADO_LOGICO('PLATILLOS',45,'Probando Borrado');

------------------------------ CREAR RESERVACION ---------------------------------
CREATE OR REPLACE PROCEDURE CREAR_RESERVACION(
    P_CEDULA_CLIENTE NUMBER,
    P_ID_MESA NUMBER,
    P_ID_HORARIO NUMBER,
    P_CONFIRMACION VARCHAR,
    P_COMENTARIO VARCHAR
)
AS
    V_ID_RESERVA NUMBER;
    V_ESTADO_ID VARCHAR(250);
BEGIN
    INSERT INTO RESERVACIONES(CONFIRMACION, CEDULA_CLIENTE, MESA, ID_HORARIO)
    VALUES (P_CONFIRMACION, P_CEDULA_CLIENTE, P_ID_MESA, P_ID_HORARIO);

    SELECT ID_RESERVA INTO V_ID_RESERVA
    FROM RESERVACIONES
    WHERE CEDULA_CLIENTE = P_CEDULA_CLIENTE
    ORDER BY ID_RESERVA DESC FETCH FIRST 1 ROW ONLY;

    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_RESERVA), 'RESERVACIONES', P_COMENTARIO);

    UPDATE RESERVACIONES
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_RESERVA = V_ID_RESERVA;

    COMMIT;
END;
/

------------------------------ ACTUALIZAR RESERVACION ----------------------------------
CREATE OR REPLACE PROCEDURE ACTUALIZAR_RESERVACION(
    P_ID_RESERVA NUMBER,
    P_NUEVA_CONFIRMACION VARCHAR
)
AS
BEGIN
    UPDATE RESERVACIONES
    SET CONFIRMACION = P_NUEVA_CONFIRMACION
    WHERE ID_RESERVA = P_ID_RESERVA;
    COMMIT;
END;
/






------------------------------ Procedimientos Horarios ----------------------------------

CREATE OR REPLACE PROCEDURE CREAR_HORARIO_MESA (
    P_DISPONIBILIDAD    VARCHAR,
    P_HORA_EXACTA       DATE,
    P_COMENTARIO        VARCHAR
)
AS
    V_ID_HORARIO   NUMBER;
    V_ESTADO_ID    VARCHAR2(250);
BEGIN
    -- Insertar nuevo horario (sin especificar ID_HORARIO)
    INSERT INTO HORARIOS_MESA (DISPONIBILIDAD, HORA_EXACTA, ID_ESTADO)
    VALUES (P_DISPONIBILIDAD, P_HORA_EXACTA, NULL) 
    RETURNING ID_HORARIO INTO V_ID_HORARIO;

    -- Crear entrada en historial de estados
    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_HORARIO), 'HORARIOS_MESA', P_COMENTARIO);

    -- Actualizar el horario con el ID de estado
    UPDATE HORARIOS_MESA
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_HORARIO = V_ID_HORARIO;

    COMMIT;

EXCEPTION
    WHEN OTHERS THEN
        ROLLBACK;
        RAISE_APPLICATION_ERROR(-20002, 'Error al crear el horario: ' || SQLERRM);
END CREAR_HORARIO_MESA;
/



----- Probando el Proceso Almacenado -----------


SELECT * FROM HORARIOS_MESA;

SHOW ERRORS PROCEDURE CREAR_HORARIO_MESA;

BEGIN
    CREAR_HORARIO_MESA(
        P_DISPONIBILIDAD => 'DISPONIBLE',
        P_HORA_EXACTA    => TO_DATE('2025-04-17 18:00', 'YYYY-MM-DD HH24:MI'),
        P_COMENTARIO     => 'Horario creado para prueba'
    );
END;
/


/*CREATE TABLE HORARIOS_MESA(
    ID_HORARIO NUMBER PRIMARY KEY,
    DISPONIBILIDAD VARCHAR(10),
    HORA_EXACTA DATE,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_HORARIOS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
*/

---------------------------- Proceso almacenado para actualizar Horario ----------------------------------

CREATE OR REPLACE PROCEDURE ACTUALIZAR_HORARIO_MESA (
    P_ID_HORARIO    NUMBER,
    P_DISPONIBILIDAD VARCHAR,
    P_HORA_EXACTA    DATE
)
AS
BEGIN
    UPDATE HORARIOS_MESA
    SET DISPONIBILIDAD = P_DISPONIBILIDAD,
        HORA_EXACTA = P_HORA_EXACTA
    WHERE ID_HORARIO = P_ID_HORARIO;

    COMMIT;
END;
/

-------------------------------- Para probar la actualizacion -------------------------------

BEGIN
    ACTUALIZAR_HORARIO_MESA(
        P_ID_HORARIO     => 1,  -- Reemplazar por un ID real
        P_DISPONIBILIDAD => 'Ocupado',
        P_HORA_EXACTA    => TO_DATE('2025-04-20 19:00:00', 'YYYY-MM-DD HH24:MI:SS')
    );
END;
/

-- Verificá que se actualizó:
SELECT * FROM VISTA_HORARIOS;



------------------------------ Procedimiento para obtener pedidos cliente ----------------------------

CREATE OR REPLACE PROCEDURE OBTENER_PEDIDOS_CLIENTE (
    P_CEDULA IN NUMBER,
    P_CURSOR OUT SYS_REFCURSOR
)
AS
BEGIN
    OPEN P_CURSOR FOR
        SELECT * 
        FROM VISTA_PEDIDOS_CLIENTE
        WHERE CEDULA_CLIENTE = P_CEDULA;
END;
/

------------------------------ Procedimiento para obtener pedidos cliente ----------------------------
/*
CREATE OR REPLACE PROCEDURE CREAR_HORARIO_MESA (
    P_DISPONIBILIDAD    VARCHAR,
    P_HORA_EXACTA       DATE,
    P_COMENTARIO        VARCHAR
)
AS
    V_ID_HORARIO   NUMBER;
    V_ESTADO_ID    VARCHAR2(250);
BEGIN
    -- Insertar nuevo horario (sin especificar ID_HORARIO)
    INSERT INTO HORARIOS_MESA (DISPONIBILIDAD, HORA_EXACTA, ID_ESTADO)
    VALUES (P_DISPONIBILIDAD, P_HORA_EXACTA, NULL) 
    RETURNING ID_HORARIO INTO V_ID_HORARIO;

    -- Crear entrada en historial de estados
    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_HORARIO), 'HORARIOS_MESA', P_COMENTARIO);

    -- Actualizar el horario con el ID de estado
    UPDATE HORARIOS_MESA
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_HORARIO = V_ID_HORARIO;

    COMMIT;

EXCEPTION
    WHEN OTHERS THEN
        ROLLBACK;
        RAISE_APPLICATION_ERROR(-20002, 'Error al crear el horario: ' || SQLERRM);
END CREAR_HORARIO_MESA;
/
*/

CREATE OR REPLACE PROCEDURE CREAR_METODO_PAGO (
    P_NOMBRE_METODO    VARCHAR2,
    P_DESCRIPCION      VARCHAR2,
    P_COMENTARIO       VARCHAR2
)
AS
    V_ID_METODO   NUMBER;
    V_ESTADO_ID   VARCHAR2(250);
BEGIN
    -- Validar entrada mínima
    IF P_NOMBRE_METODO IS NULL OR P_DESCRIPCION IS NULL THEN
        RAISE_APPLICATION_ERROR(-20001, 'El nombre y la descripción del método de pago son obligatorios.');
    END IF;

    -- Insertar nuevo método de pago (ID_ESTADO se actualiza después)
    INSERT INTO METODO_PAGO (NOMBRE_METODO, DESCRIPCION, ID_ESTADO)
    VALUES (P_NOMBRE_METODO, P_DESCRIPCION, NULL)
    RETURNING ID_METODO INTO V_ID_METODO;

    -- Crear entrada en historial de estados
    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_METODO), 'METODO_PAGO', P_COMENTARIO);

    -- Actualizar el método con el ID de estado generado
    UPDATE METODO_PAGO
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_METODO = V_ID_METODO;

    -- Confirmar transacción
    COMMIT;

EXCEPTION
    WHEN OTHERS THEN
        -- Deshacer cambios y mostrar mensaje personalizado
        ROLLBACK;
        RAISE_APPLICATION_ERROR(-20002, 'Error al crear el método de pago: ' || SQLERRM);
END CREAR_METODO_PAGO;
/


DECLARE
    -- Parámetros de entrada para el procedimiento
    V_NOMBRE_METODO   VARCHAR2(50) := 'Tarjeta de Crédito';
    V_DESCRIPCION     VARCHAR2(250) := 'Pago mediante tarjeta de crédito bancaria.';
    V_COMENTARIO      VARCHAR2(250) := 'Método de pago creado desde script de prueba.';
BEGIN
    -- Llamar al procedimiento
    CREAR_METODO_PAGO(
        P_NOMBRE_METODO => V_NOMBRE_METODO,
        P_DESCRIPCION   => V_DESCRIPCION,
        P_COMENTARIO    => V_COMENTARIO
    );

    DBMS_OUTPUT.PUT_LINE('Método de pago creado correctamente.');
EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('Error: ' || SQLERRM);
END;
/

SELECT * FROM METODO_PAGO;