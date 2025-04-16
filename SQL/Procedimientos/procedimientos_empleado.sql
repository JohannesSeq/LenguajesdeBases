------Procedimiento almacenado para insertar un nuevo puesto para un empleado----------

CREATE OR REPLACE PACKAGE PUESTOS
AS
    PROCEDURE CREAR_PUESTO( P_NOMBRE_PUESTO VARCHAR, P_SALARIO_BASE NUMBER, P_DESCRIPCION VARCHAR, P_COMENTARIO VARCHAR);

END PUESTOS;

CREATE OR REPLACE PACKAGE BODY PUESTOS
AS

    PROCEDURE CREAR_PUESTO(
        P_NOMBRE_PUESTO VARCHAR,
        P_SALARIO_BASE NUMBER,
        P_DESCRIPCION VARCHAR,
        P_COMENTARIO VARCHAR
    )
    AS
        V_ESTADO_ID VARCHAR(250); --Variable para almacenar la id del estado del distrito
        V_ID_PUESTO NUMBER; --Variable para almacenar la id del distrito

    BEGIN
        --Insercion del distrito
        INSERT INTO PUESTOS(NOMBRE_PUESTO, SALARIO_BASE, DESCRIPCION)
        VALUES (P_NOMBRE_PUESTO, P_SALARIO_BASE, P_DESCRIPCION) 
        RETURNING ID_PUESTO INTO V_ID_PUESTO;
            
        --Creamos el estado del rol llamando a la funcion delegada
        V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_PUESTO),'PUESTOS', P_COMENTARIO);
        
        --Actualizamos el id del estado
        UPDATE PUESTOS
        SET ID_ESTADO = V_ESTADO_ID
        WHERE ID_PUESTO = V_ID_PUESTO;
        
        COMMIT;

    END CREAR_PUESTO;

END PUESTOS;


------Procedimiento almacenado para insertar un nuevo departamento para un empleado----------



CREATE OR REPLACE PROCEDURE CREAR_DEPARTAMENTO(
    P_NOMBRE_DEPARTAMENTO VARCHAR,
    P_DESCRIPCION VARCHAR,
    P_COMENTARIO VARCHAR
)
AS
    V_ESTADO_ID VARCHAR(250); --Variable para almacenar la id del estado del distrito
    V_ID_DEPARTAMENTO NUMBER; --Variable para almacenar la id del distrito

BEGIN
    --Insercion del distrito
    INSERT INTO DEPARTAMENTOS(NOMBRE_DEPARTAMENTO, DESCRIPCION)
     VALUES (P_NOMBRE_DEPARTAMENTO, P_DESCRIPCION);
    
    --Obtenemos el id del distrito por medio del nombre
    SELECT ID_DEPARTAMENTO
        INTO V_ID_DEPARTAMENTO
        FROM DEPARTAMENTOS
        WHERE NOMBRE_DEPARTAMENTO = P_NOMBRE_DEPARTAMENTO;
    
    --Creamos el estado del rol llamando a la funcion delegada
    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_DEPARTAMENTO),'DEPARTAMENTOS', P_COMENTARIO);
    
    --Actualizamos el id del estado
    UPDATE DEPARTAMENTOS
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_DEPARTAMENTO = V_ID_DEPARTAMENTO;
    
    COMMIT;

END;
/


------Procedimiento almacenado para insertar un nuevo empleado--------------------

CREATE OR REPLACE PROCEDURE CREAR_EMPLEADO(

    P_ID_EMPLEADO NUMBER,
    P_ID_DEPARTAMENTO NUMBER,
    P_ID_PUESTO NUMBER,
    P_SALARIO NUMBER,
    P_CEDULA NUMBER,
    P_COMENTARIO VARCHAR
)
AS

    V_ESTADO_ID VARCHAR(250); --Variable para almacenar el estado del empleado

BEGIN

    --Insertamos el empleado en la tabla
    INSERT INTO EMPLEADOS(ID_EMPLEADO,ID_DEPARTAMENTO, ID_PUESTO, SALARIO, CEDULA)
    VALUES (P_ID_EMPLEADO,P_ID_DEPARTAMENTO, P_ID_PUESTO, P_SALARIO, P_CEDULA);

    --Creamos el estado del rol llamando a la funcion delegada
    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(P_ID_EMPLEADO),'EMPLEADOS', P_COMENTARIO);

    UPDATE EMPLEADOS
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_EMPLEADO = P_ID_EMPLEADO;
    COMMIT;
END;
/