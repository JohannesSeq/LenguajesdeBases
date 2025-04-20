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