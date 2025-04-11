---------------------- Correr en session de Playa Cacao---------------------

/*
Drops de todas las tablas para debugging
DROP TABLE FACTURAS;
DROP TABLE METODO_PAGO;
DROP TABLE PEDIDOS;
DROP TABLE LISTA_PLATILLOS;

DROP TABLE MENU;
DROP TABLE PLATILLOS_MENU;
DROP TABLE PLATILLOS;

DROP TABLE RESERVACIONES;
DROP TABLE MESAS;
DROP TABLE HORARIOS_MESA;

DROP TABLE EMPLEADOS;
DROP TABLE DEPARTAMENTOS;
DROP TABLE PUESTOS;

DROP TABLE PERSONAS;
DROP TABLE ENCRIPCION_PASSWORDS;
DROP TABLE DIRECCIONES_PERSONAS;
DROP TABLE PROVINCIA;
DROP TABLE CANTON;
DROP TABLE DISTRITO;
DROP TABLE ROL_PERSONA;
DROP TABLE CORREOS;



DROP TABLE ESTADOS;
*/

--Creacion de la tabla estados
CREATE TABLE ESTADOS(
    ID_ESTADO VARCHAR(250) PRIMARY KEY,
    TABLA_ENTRADA VARCHAR(50) NOT NULL,
    COMENTARIO VARCHAR(250),
    FECHA_CAMBIO DATE,
    ESTADO VARCHAR(10) NOT NULL
);
ALTER TABLE ESTADOS MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla correos
CREATE TABLE CORREOS(
    DIRECCION_DE_CORREO VARCHAR(100) PRIMARY KEY,
    CORREO_DE_RESPALDO VARCHAR(100) NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_CORREOS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE CORREOS MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla para almacenar el tipo de usuario
CREATE TABLE ROL_PERSONA(
    ID_ROL_PERSONA VARCHAR(50) PRIMARY KEY,
    NOMBRE_LARGO_TIPO VARCHAR(100) NOT NULL,
    DESCRIPCION VARCHAR(250) NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_ROL_PERSONA_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE ROL_PERSONA MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla distrito
CREATE TABLE DISTRITO(
    ID_DISTRITO NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    NOMBRE_DISTRITO VARCHAR(50) NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_DISTRITO_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE DISTRITO MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla canton
CREATE TABLE CANTON(
    ID_CANTON NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    NOMBRE_CANTON VARCHAR(50) NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_CANTON_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE CANTON MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla Provincia
CREATE TABLE PROVINCIA(
    ID_PROVINCIA NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    NOMBRE_PROVINCIA VARCHAR(50) NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_PROVINCIA_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE PROVINCIA MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla direccion personas
CREATE TABLE DIRECCIONES_PERSONAS(
    ID_DIRECCION VARCHAR(100) PRIMARY KEY,
    ID_DISTRITO NUMBER
                     CONSTRAINT DISTRITO_FK
                     REFERENCES DISTRITO(ID_DISTRITO),
    ID_CANTON NUMBER
                     CONSTRAINT CANTON_FK
                     REFERENCES CANTON(ID_CANTON),
    ID_PROVINCIA NUMBER
                     CONSTRAINT PROVINCIA_FK
                     REFERENCES PROVINCIA(ID_PROVINCIA),
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_DIRECCIONES_PERSONAS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE DIRECCIONES_PERSONAS MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla para almacenar la encripcion de las contraseñas
CREATE TABLE ENCRIPCION_PASSWORDS(
    PASSWORD_ID VARCHAR(100) PRIMARY KEY,
    PASSWORD_VAL RAW(200) NOT NULL,
    LLAVE RAW(32),
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_ENCRIPCION_PASSWORDS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE ENCRIPCION_PASSWORDS MOVE TABLESPACE PLAYA_CACAO_TBS;


--Creacion de la tabla personas
CREATE TABLE PERSONAS(
    CEDULA NUMBER PRIMARY KEY,
    NOMBRE VARCHAR(50) NOT NULL,
    APELLIDO VARCHAR(50) NOT NULL,
    NUMERO_DE_TELEFONO VARCHAR(20) NOT NULL,
    ID_ROL_PERSONA VARCHAR(50)
                     CONSTRAINT ROL_PERSONA_FK
                     REFERENCES ROL_PERSONA(ID_ROL_PERSONA),
   DIRECCION_DE_CORREO VARCHAR(100)
                     CONSTRAINT CORREO_FK
                     REFERENCES CORREOS(DIRECCION_DE_CORREO),
    PASSWORD_ID VARCHAR(100)
                     CONSTRAINT PASSWORD_FK
                     REFERENCES ENCRIPCION_PASSWORDS(PASSWORD_ID),
    ID_DIRECCION VARCHAR(100)
                     CONSTRAINT DIRECCION_FK
                     REFERENCES DIRECCIONES_PERSONAS(ID_DIRECCION),
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_PERSONAS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE PERSONAS MOVE TABLESPACE PLAYA_CACAO_TBS;

--CREACION DE LA TABLA PUESTOS
CREATE TABLE PUESTOS(
    ID_PUESTO NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    NOMBRE_PUESTO VARCHAR(50) NOT NULL,
    SALARIO_BASE NUMBER NOT NULL,
    DESCRIPCION VARCHAR(255) NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_PUESTOS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE PUESTOS MOVE TABLESPACE PLAYA_CACAO_TBS;

--CREACION DE LA TABLA DEPARTAMENTOS
CREATE TABLE DEPARTAMENTOS(
    ID_DEPARTAMENTO NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    NOMBRE_DEPARTAMENTO VARCHAR(50) NOT NULL,
    DESCRIPCION VARCHAR(255) NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_DEPARTAMENTOS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE DEPARTAMENTOS MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla de empleados
CREATE TABLE EMPLEADOS(
    ID_EMPLEADO NUMBER PRIMARY KEY,
    ID_DEPARTAMENTO NUMBER
                     CONSTRAINT DEPARTAMENTOS_FK
                     REFERENCES DEPARTAMENTOS(ID_DEPARTAMENTO),
    ID_PUESTO NUMBER
                     CONSTRAINT PUESTOS_FK
                     REFERENCES PUESTOS(ID_PUESTO),
    SALARIO NUMBER,
    CEDULA NUMBER
                     CONSTRAINT EMPLEADO_PERSONA_FK
                     REFERENCES PERSONAS(CEDULA),
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_EMPLEADOS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE EMPLEADOS MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla horarios
CREATE TABLE HORARIOS_MESA(
    ID_HORARIO NUMBER PRIMARY KEY,
    DISPONIBILIDAD VARCHAR(10),
    HORA_EXACTA DATE,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_HORARIOS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE HORARIOS_MESA MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla Mesas
CREATE TABLE MESAS(
    ID_MESA NUMBER PRIMARY KEY,
    ID_HORARIO NUMBER
                     CONSTRAINT HORARIO_MESA_FK
                     REFERENCES HORARIOS_MESA(ID_HORARIO),
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_MESAS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE MESAS MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla de RESERVAS
CREATE TABLE RESERVACIONES (
    ID_RESERVA NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    CONFIRMACION VARCHAR(10) NOT NULL,
    CEDULA_CLIENTE NUMBER
                     CONSTRAINT CEDULA_CLIENTE_RESERVA_FK
                     REFERENCES PERSONAS(CEDULA),
    MESA NUMBER
                     CONSTRAINT MESA_RESERVA_FK
                     REFERENCES MESAS(ID_MESA),
    ID_HORARIO NUMBER
                     CONSTRAINT HORARIO_RESERVA_FK
                     REFERENCES HORARIOS_MESA(ID_HORARIO),
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_RESERVACIONES_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE RESERVACIONES MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla Platillos
CREATE TABLE PLATILLOS(
    ID_PLATILLO NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    NOMBRE_PLATILLO VARCHAR(250) NOT NULL,
    PRECIO_UNITARIO NUMBER NOT NULL,
    CANTIDAD NUMBER NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_PLATILLOS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE PLATILLOS MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla de MENU
CREATE TABLE MENU (
    ID_MENU NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    NOMBRE_MENU VARCHAR2(100) NOT NULL,
    DESCRIPCION VARCHAR2(255) NOT NULL, 
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_MENU_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE MENU MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la lista platillos menu, que almacena los platillos del menu
CREATE TABLE PLATILLOS_MENU(
    ID_PLATILLOS_MENU NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    ID_PLATILLO NUMBER 
                     CONSTRAINT LISTADO_PLATILLO_FK
                     REFERENCES PLATILLOS(ID_PLATILLO),
    ID_MENU NUMBER
                    CONSTRAINT LISTADO_MENU_FK
                    REFERENCES MENU(ID_MENU),
    ID_ESTADO VARCHAR(250) 
                     CONSTRAINT ESTADO_PLATILLOS_MENU_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE PLATILLOS_MENU MOVE TABLESPACE PLAYA_CACAO_TBS;


--Creacion de la tabla de Pedidos
CREATE TABLE PEDIDOS(
    ID_PEDIDO NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    CEDULA_CLIENTE NUMBER
                     CONSTRAINT CEDULA_CLIENTE_PEDIDO_FK
                     REFERENCES PERSONAS(CEDULA),
    MONTO_ESTIMADO NUMBER NOT NULL,
    ESTADO_PEDIDO VARCHAR(20),
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_PEDIDOS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE PEDIDOS MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla metodos de pago
CREATE TABLE METODO_PAGO(
    ID_METODO NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    NOMBRE_METODO VARCHAR(50) NOT NULL,
    DESCRIPCION VARCHAR(250) NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_METODO_PAGO_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE METODO_PAGO MOVE TABLESPACE PLAYA_CACAO_TBS;

--Creacion de la tabla de Facturas
CREATE TABLE FACTURAS (
    ID_FACTURA NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    CEDULA_CLIENTE NUMBER
                     CONSTRAINT CEDULA_CLIENTE_FACTURA_FK
                     REFERENCES PERSONAS(CEDULA),
    ID_PEDIDO NUMBER
                     CONSTRAINT FACTURA_PEDIDO_FK
                     REFERENCES PEDIDOS(ID_PEDIDO),
    ID_METODO NUMBER
                     CONSTRAINT METODO_PAGO_FACTURA_FK
                     REFERENCES METODO_PAGO(ID_METODO),
    MONTO_TOTAL NUMBER NOT NULL,
    NOMBRE_CLIENTE VARCHAR(100),
    VUELTO NUMBER NOT NULL,
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_FACTURAS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE FACTURAS MOVE TABLESPACE PLAYA_CACAO_TBS;


--Creacion de la lista de los platillos en un pedido y factura
CREATE TABLE LISTA_PLATILLOS(
    ID_LISTA_PLATILLOS NUMBER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    ID_PLATILLO NUMBER
                     CONSTRAINT LISTADO_PLATILLO_LISTA_FK
                     REFERENCES PLATILLOS(ID_PLATILLO),
    ID_PEDIDO NUMBER
                    CONSTRAINT LISTADO_PLATILLOS_PEDIDO_FK
                    REFERENCES PEDIDOS(ID_PEDIDO),
    ID_FACTURA NUMBER
                    CONSTRAINT LISTA_PLATILLO_FACTURA_FK
                    REFERENCES FACTURAS(ID_FACTURA),
    ID_ESTADO VARCHAR(250)
                     CONSTRAINT ESTADO_LISTA_PLATILLOS_FK
                     REFERENCES ESTADOS(ID_ESTADO)
);
ALTER TABLE LISTA_PLATILLOS MOVE TABLESPACE PLAYA_CACAO_TBS;



