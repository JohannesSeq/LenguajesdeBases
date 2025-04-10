---------------------- Correr en session de Playa Cacao---------------------
/*
Setup inicial de la base de datos, crea el usuario de administrador de la pagina web asi como una cantidad de entradas para empezar a trabajar con la pagina web
*/

EXEC CREAR_DISTRITO('San Antonio', 'Agregando distritos');
EXEC CREAR_DISTRITO('Zapoote', 'Agregando distritos');
EXEC CREAR_DISTRITO('Desamparados', 'Agregando distritos');
EXEC CREAR_DISTRITO('Merced', 'Agregando distritos');
EXEC CREAR_DISTRITO('Hospital', 'Agregando distritos');
EXEC CREAR_DISTRITO('Catedral', 'Agregando distritos');
EXEC CREAR_DISTRITO('San Francisco', 'Agregando distritos');
EXEC CREAR_DISTRITO('Carrizal', 'Agregando distritos');
EXEC CREAR_DISTRITO('San Isidro', 'Agregando distritos');
EXEC CREAR_DISTRITO('San Sebastián', 'Agregando distritos');
EXEC CREAR_DISTRITO('Hatillo', 'Agregando distritos');
EXEC CREAR_DISTRITO('Gravilias', 'Agregando distritos');

-- Creacion de Cantones
EXEC CREAR_Canton('Pérez Zeledón', 'Agregando Cantones');
EXEC CREAR_Canton('Escazú', 'Agregando Cantones');
EXEC CREAR_Canton('Moravia', 'Agregando Cantones');
EXEC CREAR_Canton('Alajuela', 'Agregando Cantones');
EXEC CREAR_Canton('San Ramón', 'Agregando Cantones');
EXEC CREAR_Canton('Grecia', 'Agregando Cantones');
EXEC CREAR_Canton('Atenas', 'Agregando Cantones');
EXEC CREAR_Canton('San Mateo', 'Agregando Cantones');
EXEC CREAR_Canton('Palmares', 'Agregando Cantones');
EXEC CREAR_Canton('Poás', 'Agregando Cantones');
EXEC CREAR_Canton('Orotina', 'Agregando Cantones');
EXEC CREAR_Canton('Desamparados', 'Agregando Cantones');

-- Creacion de provincias
EXEC CREAR_PROVINCIA('San Jose', 'Agregando Provincia');
EXEC CREAR_PROVINCIA('Puntarenas', 'Agregando Provincia');
EXEC CREAR_PROVINCIA('Limon', 'Agregando Provincia');
EXEC CREAR_PROVINCIA('Guanacaste', 'Agregando Provincia');
EXEC CREAR_PROVINCIA('Alajuela', 'Agregando Provincia');
EXEC CREAR_PROVINCIA('Heredia', 'Agregando Provincia');
EXEC CREAR_PROVINCIA('Cartago', 'Agregando Provincia');

--- Creacion de roles
EXEC CREAR_ROL('Cliente', 'Clientes', 'Clientes del restaurante', 'Prueba01');
EXEC CREAR_ROL('Empleado', 'Empleados', 'Empleados del restaurante', 'Creacion del rol');
EXEC CREAR_ROL('Gerente', 'Gerentes', 'Gerentes del restaurante', 'Creacion del rol');

--Creacion de personas
EXEC CREAR_PERSONA(1184401, 'Johannes', 'Sequeira', '123-456','Gerente', 1, 32, 32, 'js@playacacao.com', 'johannes@gmail.com','Password1234','Agregando personas');
EXEC CREAR_PERSONA(1345667, 'Steven', 'Guerra Fernandez', '222-356','Empleado', 1, 22, 31, 'steven@playacacao.com', 'steven@gmail.com','Password1234','Agregando personas');
EXEC CREAR_PERSONA(1200345, 'Nidia', 'Infante', '123-456','Cliente', 1, 21, 23, 'nidiaces@gmail.com', 'infante@gmail.com','Password1234','TestPersona');

--Creacion de puestos
EXEC CREAR_PUESTO('Mesero', 300000, 'Mesero del restaurante', 'Agregando puesto');

--Creacion de departamentos
EXEC CREAR_DEPARTAMENTO('Gerenncia','Departamento administrativo', 'Agregando Departamento');