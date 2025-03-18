---------------------- Correr en session de Playa Cacao---------------------
SET ROLE ACCESO_PLAYA_CACAO_DB;

--Inserciones de la tabla platillos 
INSERT INTO Menu (ID_MENU, NOMBRE_PLATILLO, DESCRIPCION, PRECIO, CATEGORIA, DISPONIBLE)
VALUES (1, 'Ensalada César', 'Ensalada fresca con pollo a la parrilla o Frito y aderezo César', 8.50, 'Entrada', 'S');
COMMIT;

INSERT INTO Menu (ID_MENU, NOMBRE_PLATILLO, DESCRIPCION, PRECIO, CATEGORIA, DISPONIBLE)
VALUES (2, 'Sopa de Mariscos', 'Sopa cremosa de Mariscos con leche de coco y mariscos frescos', 15.50, 'Plato fuerte', 'S');
COMMIT;

INSERT INTO Menu (ID_MENU, NOMBRE_PLATILLO, DESCRIPCION, PRECIO, CATEGORIA, DISPONIBLE)
VALUES (3, 'Lomito de Res 3 pimientas', 'Lomito de res a la parrilla con papas y verduras al vapor', 20.00, 'Plato fuerte', 'S');
COMMIT;

INSERT INTO Menu (ID_MENU, NOMBRE_PLATILLO, DESCRIPCION, PRECIO, CATEGORIA, DISPONIBLE)
VALUES (4, 'Pescado entero', 'Pescado entero acompañado de arroz y ensalada', 12.50, 'Plato fuerte', 'N');
COMMIT;

--Inserciones para la tabla Reserva
INSERT INTO Reserva (ID_MESA, DISPONIBILIDAD, HORA)
VALUES (1, 'S', TO_TIMESTAMP('2025-03-17 12:00:00', 'YYYY-MM-DD HH24:MI:SS'));
COMMIT;

INSERT INTO Reserva (ID_MESA, DISPONIBILIDAD, HORA)
VALUES (2, 'N', TO_TIMESTAMP('2025-03-17 13:00:00', 'YYYY-MM-DD HH24:MI:SS'));
COMMIT;

INSERT INTO Reserva (ID_MESA, DISPONIBILIDAD, HORA)
VALUES (3, 'S', TO_TIMESTAMP('2025-03-17 14:30:00', 'YYYY-MM-DD HH24:MI:SS'));
COMMIT;

INSERT INTO Reserva (ID_MESA, DISPONIBILIDAD, HORA)
VALUES (4, 'S', TO_TIMESTAMP('2025-03-17 15:45:00', 'YYYY-MM-DD HH24:MI:SS'));
COMMIT;

--Inserciones en la tabla Factura 

INSERT INTO Factura (ID_FACTURA, NOMBRE_PLATILLO, PRECIO, VUELTO)
VALUES (1, 'Ensalada César', 8.50, 2.50);


INSERT INTO Factura (ID_FACTURA, NOMBRE_PLATILLO, PRECIO, VUELTO)
VALUES (2, 'Sopa de Mariscos', 15.50, 1.00);


INSERT INTO Factura (ID_FACTURA, NOMBRE_PLATILLO, PRECIO, VUELTO)
VALUES (3, 'Lomito de Res 3 pimientas', 20.00, 0.50);


INSERT INTO Factura (ID_FACTURA, NOMBRE_PLATILLO, PRECIO, VUELTO)
VALUES (4, 'Pescado entero', 12.50, 1.00);


--Insercion de datos en la tabla de Clientes
INSERT INTO CLIENTES(CEDULA,NOMBRE,APELLIDO,NUMERO_DE_TELEFONO)
VALUES (1,'Johannes','Sequeira','1234-5678');
COMMIT;

--Insercion de datos en la tabla correo clientes
INSERT INTO CORREO_CLIENTES(DIRECCION_DE_CORREO,CORREO_DE_RESPALDO,CEDULA_CLIENTE)
VALUES ('Johannes@gmail.com','Sequeira@gmail.com',1);
COMMIT;

--Insercion de datos en la tabla de empleados
INSERT INTO EMPLEADOS(ID_EMPLEADO,ID_DEPARTAMENTO,ID_PUESTO,NOMBRE,APELLIDO,SALARIO,CEDULA)
VALUES (1,1,1,'Steven','Guerra',1000000,5678);
COMMIT;

--Insercion de datos en la tabla correo empleados
INSERT INTO CORREO_EMPLEADOS(DIRECCION_DE_CORREO,CORREO_DE_RESPALDO,ID_EMPLEADO_CORREO)
VALUES ('steven@playacacao.com','steven@gmail.com',1);
COMMIT;

--Insercion de datos en la tabla de Usuarios
INSERT INTO USUARIOS(ID_USUARIO,CORREO,PASSWORD,ROL_ID)
VALUES (1,'Johannes@gmail.com','ABC123',1);
COMMIT;

--Insercion de datos en la tabla de Usuarios
INSERT INTO USUARIOS(ID_USUARIO,CORREO,PASSWORD,ROL_ID)
VALUES (2,'Steven@playacacao.com','ABC123',2);
COMMIT;



