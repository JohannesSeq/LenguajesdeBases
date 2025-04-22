-- Inserciones realistas para la tabla MENU
EXEC CREAR_MENU('Desayuno Tico', 'Clásico desayuno costarricense', 'Auto-generado');
EXEC CREAR_PLATILLO_MENU(1, 1, 'Menú de desayuno con gallo pinto');

EXEC CREAR_MENU('Menú Ejecutivo 1', 'Almuerzo rápido y nutritivo', 'Auto-generado');
EXEC CREAR_PLATILLO_MENU(2, 2, 'Casado tradicional con bebida');

EXEC CREAR_MENU('Menú Vegetariano', 'Sin carne, con vegetales frescos', 'Auto-generado');
EXEC CREAR_PLATILLO_MENU(3, 3, 'Incluye ensalada, sopa y arroz');

EXEC CREAR_MENU('Menú Infantil', 'Comida especial para niños', 'Auto-generado');
EXEC CREAR_PLATILLO_MENU(4, 4, 'Porciones pequeñas y saludables');

EXEC CREAR_MENU('Menú Italiano', 'Inspirado en la cocina italiana', 'Auto-generado');
EXEC CREAR_PLATILLO_MENU(5, 5, 'Incluye pasta y bebida');