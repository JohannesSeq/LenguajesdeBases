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