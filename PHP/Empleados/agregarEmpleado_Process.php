<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$cedula = $_POST['cedula'];
$departamento = $_POST['departamento'];
$puesto = $_POST['puesto'];
$salario = $_POST['salario'];
$comentario = $_POST['comentario'];

$sql = "BEGIN PKG_EMPLEADOS.AGREGAR_EMPLEADO(:departamento, :puesto, :salario, :cedula, :comentario); END;";
$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":departamento", $departamento);
oci_bind_by_name($stmt, ":puesto", $puesto);
oci_bind_by_name($stmt, ":salario", $salario);
oci_bind_by_name($stmt, ":cedula", $cedula);
oci_bind_by_name($stmt, ":comentario", $comentario);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
