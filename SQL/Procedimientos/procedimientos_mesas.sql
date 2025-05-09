CREATE OR REPLACE PACKAGE PKT_MESAS AS
    PROCEDURE CREAR_MESA(P_NOMBRE_MESA VARCHAR, P_ID_HORARIO NUMBER);
    PROCEDURE ACTUALIZAR_MESA(P_ID_MESA NUMBER, P_NOMBRE_MESA VARCHAR, P_ID_HORARIO NUMBER);
    PROCEDURE ENVIO_TOTAL_MESAS(P_CURSOR OUT SYS_REFCURSOR);
    PROCEDURE ENVIO_MESA_INDIVIDUAL(P_ID_MESA NUMBER, P_CURSOR OUT SYS_REFCURSOR);
END PKT_MESAS;
/

CREATE OR REPLACE PACKAGE BODY PKT_MESAS AS

    PROCEDURE CREAR_MESA(P_NOMBRE_MESA VARCHAR, P_ID_HORARIO NUMBER) AS
        V_ID_MESA NUMBER;
        V_ESTADO_ID VARCHAR(250);
    BEGIN
        INSERT INTO MESAS(NOMBRE_MESA, ID_HORARIO, ID_ESTADO)
        VALUES (P_NOMBRE_MESA, P_ID_HORARIO, NULL)
        RETURNING ID_MESA INTO V_ID_MESA;

        V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_MESA), 'MESAS', 'Creación de mesa');

        UPDATE MESAS
        SET ID_ESTADO = V_ESTADO_ID
        WHERE ID_MESA = V_ID_MESA;

        COMMIT;
    END;

    PROCEDURE ACTUALIZAR_MESA(P_ID_MESA NUMBER, P_NOMBRE_MESA VARCHAR, P_ID_HORARIO NUMBER) AS
    BEGIN
        UPDATE MESAS
        SET NOMBRE_MESA = P_NOMBRE_MESA,
            ID_HORARIO = P_ID_HORARIO
        WHERE ID_MESA = P_ID_MESA;
        COMMIT;
    END;

    PROCEDURE ENVIO_TOTAL_MESAS(P_CURSOR OUT SYS_REFCURSOR) AS
    BEGIN
        OPEN P_CURSOR FOR
        SELECT ID_MESA, NOMBRE_MESA, ID_HORARIO, ID_ESTADO
        FROM VISTA_MESAS;
    END;

    PROCEDURE ENVIO_MESA_INDIVIDUAL(P_ID_MESA NUMBER, P_CURSOR OUT SYS_REFCURSOR) AS
    BEGIN
        OPEN P_CURSOR FOR
        SELECT ID_MESA, NOMBRE_MESA, ID_HORARIO, ID_ESTADO
        FROM VISTA_MESAS
        WHERE ID_MESA = P_ID_MESA;
    END;

END PKT_MESAS;
/


CREATE OR REPLACE PROCEDURE ELIMINAR_MESA (
    P_ID_MESA IN NUMBER,
    P_RESULTADO OUT VARCHAR
)
AS
    V_ID_ESTADO VARCHAR(250);
    V_EXISTE_RESERVA NUMBER := 0;
BEGIN
    -- Verificar si existen reservaciones activas para esta mesa
    SELECT COUNT(*) INTO V_EXISTE_RESERVA
    FROM RESERVACIONES
    WHERE MESA = P_ID_MESA;

    IF V_EXISTE_RESERVA > 0 THEN
        P_RESULTADO := 'REFERENCIAS_ACTIVAS';
        RETURN;
    END IF;

    -- Obtener el ID_ESTADO asociado a la mesa
    SELECT ID_ESTADO INTO V_ID_ESTADO
    FROM MESAS
    WHERE ID_MESA = P_ID_MESA;

    -- Eliminar la mesa y su estado
    DELETE FROM MESAS WHERE ID_MESA = P_ID_MESA;
    DELETE FROM ESTADOS WHERE ID_ESTADO = V_ID_ESTADO;

    COMMIT;

    P_RESULTADO := 'BORRADO_FISICO';
END;
/
