------------------------------ Paquete para adminisrar platillos ------------------------------------
CREATE OR REPLACE PACKAGE PKT_PLATILLOS AS

    PROCEDURE CREAR_PLATILLO( P_NOMBRE_PLATILLO VARCHAR, P_PRECIO_UNITARIO NUMBER, P_CANTIDAD NUMBER, P_COMENTARIO VARCHAR );
    PROCEDURE ENVIO_TOTAL_PLATILLOS (P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
    PROCEDURE ENVIO_PLATILLO_INDIVIDUAL(P_ID_PLATILLO NUMBER, P_CURSOR_RESULTADO OUT SYS_REFCURSOR);
    PROCEDURE ACTUALIZAR_PLATILLO( P_ID_PLATILLO NUMBER, P_NUEVO_NOMBRE VARCHAR, P_NUEVO_PRECIO NUMBER, P_NUEVA_CANTIDAD NUMBER);

END PKT_PLATILLOS;
/
CREATE OR REPLACE PACKAGE BODY PKT_PLATILLOS AS

--LEER PLATILLOS
    PROCEDURE CREAR_PLATILLO(
        P_NOMBRE_PLATILLO VARCHAR,
        P_PRECIO_UNITARIO NUMBER,
        P_CANTIDAD NUMBER,
        P_COMENTARIO VARCHAR
    )
    AS
        V_ID_PLATILLO NUMBER;
        V_ESTADO_ID VARCHAR(250);
    BEGIN
        INSERT INTO PLATILLOS(NOMBRE_PLATILLO, PRECIO_UNITARIO, CANTIDAD)
        VALUES (P_NOMBRE_PLATILLO, P_PRECIO_UNITARIO, P_CANTIDAD)
        RETURNING ID_PLATILLO INTO V_ID_PLATILLO;

        V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_PLATILLO), 'PLATILLOS', P_COMENTARIO);

        UPDATE PLATILLOS
        SET ID_ESTADO = V_ESTADO_ID
        WHERE ID_PLATILLO = V_ID_PLATILLO;

        COMMIT;
    END CREAR_PLATILLO;

--Enviar todos los platillos
    PROCEDURE ENVIO_TOTAL_PLATILLOS (
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
            OPEN P_CURSOR_RESULTADO FOR
                SELECT ID_PLATILLO, NOMBRE_PLATILLO, PRECIO_UNITARIO, CANTIDAD
                FROM VISTA_PLATILLOS;
    END ENVIO_TOTAL_PLATILLOS;

-- Leer un solo platillo
    PROCEDURE ENVIO_PLATILLO_INDIVIDUAL(
        P_ID_PLATILLO NUMBER,
        P_CURSOR_RESULTADO OUT SYS_REFCURSOR
    )
    AS
    BEGIN
            OPEN P_CURSOR_RESULTADO FOR
                SELECT ID_PLATILLO, NOMBRE_PLATILLO, PRECIO_UNITARIO, CANTIDAD
                FROM VISTA_PLATILLOS
                WHERE ID_PLATILLO = P_ID_PLATILLO;
    END ENVIO_PLATILLO_INDIVIDUAL;

--Actualizar platillo
    PROCEDURE ACTUALIZAR_PLATILLO(
        P_ID_PLATILLO NUMBER,
        P_NUEVO_NOMBRE VARCHAR,
        P_NUEVO_PRECIO NUMBER,
        P_NUEVA_CANTIDAD NUMBER
    )
    AS
    BEGIN
        UPDATE PLATILLOS
        SET NOMBRE_PLATILLO = P_NUEVO_NOMBRE,
            PRECIO_UNITARIO = P_NUEVO_PRECIO,
            CANTIDAD = P_NUEVA_CANTIDAD
        WHERE ID_PLATILLO = P_ID_PLATILLO;
        COMMIT;
    END ACTUALIZAR_PLATILLO;

END PKT_PLATILLOS;
/


------------------------------ CREAR MENU ----------------------------------------


CREATE OR REPLACE PROCEDURE CREAR_MENU(
    P_NOMBRE_MENU VARCHAR,
    P_DESCRIPCION VARCHAR,
    P_COMENTARIO VARCHAR
)
AS
    V_ID_MENU NUMBER;
    V_ESTADO_ID VARCHAR(250);
BEGIN
    INSERT INTO MENU(NOMBRE_MENU, DESCRIPCION)
    VALUES (P_NOMBRE_MENU, P_DESCRIPCION);

    SELECT ID_MENU 
    INTO V_ID_MENU
    FROM MENU
    WHERE NOMBRE_MENU = P_NOMBRE_MENU
    ORDER BY ID_MENU DESC FETCH FIRST 1 ROW ONLY;

    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_MENU), 'MENU', P_COMENTARIO);

    UPDATE MENU
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_MENU = V_ID_MENU;

    COMMIT;
END;
/

------------------------------ CREAR PLATILLO MENU -------------------------------



CREATE OR REPLACE PROCEDURE CREAR_PLATILLO_MENU(
    P_ID_PLATILLO NUMBER,
    P_ID_MENU NUMBER,
    P_COMENTARIO VARCHAR
)
AS
    V_ID_PLATILLOS_MENU NUMBER;
    V_ESTADO_ID VARCHAR(250);
BEGIN
    INSERT INTO PLATILLOS_MENU(ID_PLATILLO, ID_MENU)
    VALUES (P_ID_PLATILLO, P_ID_MENU);

    SELECT ID_PLATILLOS_MENU 
    INTO V_ID_PLATILLOS_MENU
    FROM PLATILLOS_MENU
    WHERE ID_PLATILLO = P_ID_PLATILLO
    ORDER BY ID_PLATILLOS_MENU DESC FETCH FIRST 1 ROW ONLY;

    V_ESTADO_ID := CREAR_ENTRADA_ESTADO(TO_CHAR(V_ID_PLATILLOS_MENU), 'PLATILLOS_MENU', P_COMENTARIO);

    UPDATE PLATILLOS_MENU
    SET ID_ESTADO = V_ESTADO_ID
    WHERE ID_PLATILLOS_MENU = V_ID_PLATILLOS_MENU;

    COMMIT;
END;
/


------------------------------ ACTUALIZAR MENU -----------------------------------------
CREATE OR REPLACE PROCEDURE ACTUALIZAR_MENU(
    P_ID_MENU NUMBER,
    P_NUEVO_NOMBRE_MENU VARCHAR,
    P_NUEVA_DESCRIPCION VARCHAR
)
AS
BEGIN
    UPDATE MENU
    SET NOMBRE_MENU = P_NUEVO_NOMBRE_MENU,
        DESCRIPCION = P_NUEVA_DESCRIPCION
    WHERE ID_MENU = P_ID_MENU;
    COMMIT;
END;
/
