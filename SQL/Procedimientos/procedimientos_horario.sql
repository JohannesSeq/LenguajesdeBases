CREATE OR REPLACE PROCEDURE ELIMINAR_HORARIO (
    P_ID_HORARIO IN NUMBER,
    P_RESULTADO OUT VARCHAR
)
AS
    V_ID_ESTADO VARCHAR(250);
    V_EXISTE_REFERENCIA NUMBER := 0;
BEGIN
    -- Verificar si hay mesas que usan este horario
    SELECT COUNT(*) INTO V_EXISTE_REFERENCIA
    FROM MESAS
    WHERE ID_HORARIO = P_ID_HORARIO;

    IF V_EXISTE_REFERENCIA > 0 THEN
        P_RESULTADO := 'REFERENCIAS_ACTIVAS';
        RETURN;
    END IF;

    -- Verificar si hay reservaciones que usan este horario
    SELECT COUNT(*) INTO V_EXISTE_REFERENCIA
    FROM RESERVACIONES
    WHERE ID_HORARIO = P_ID_HORARIO;

    IF V_EXISTE_REFERENCIA > 0 THEN
        P_RESULTADO := 'REFERENCIAS_ACTIVAS';
        RETURN;
    END IF;

    -- Obtener ID_ESTADO del horario
    SELECT ID_ESTADO INTO V_ID_ESTADO
    FROM HORARIOS_MESA
    WHERE ID_HORARIO = P_ID_HORARIO;

    -- Eliminar el horario y su estado
    DELETE FROM HORARIOS_MESA WHERE ID_HORARIO = P_ID_HORARIO;
    DELETE FROM ESTADOS WHERE ID_ESTADO = V_ID_ESTADO;

    COMMIT;

    P_RESULTADO := 'BORRADO_FISICO';
END;
/
