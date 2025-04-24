<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$query = "
SELECT 
    P.CEDULA, P.NOMBRE, P.APELLIDO, R.NOMBRE_LARGO_TIPO AS ROL
FROM 
    PERSONAS P
JOIN 
    ROL_PERSONA R ON P.ID_ROL_PERSONA = R.ID_ROL_PERSONA
WHERE 
    R.NOMBRE_LARGO_TIPO NOT IN ('Clientes', 'Clientes VIP')
    AND P.CEDULA NOT IN (SELECT CEDULA FROM EMPLEADOS)
";

$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$personas = [];
while (($row = oci_fetch_assoc($stmt)) != false) {
    $personas[] = $row;
}

oci_free_statement($stmt);
oci_close($conn);

echo json_encode($personas);
?>
