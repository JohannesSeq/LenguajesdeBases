<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");

$id = $_POST['id'];
$departamento = $_POST['departamento'];
$puesto = $_POST['puesto'];
$salario = $_POST['salario'];

$sql = "BEGIN PKG_EMPLEADOS.MODIFICAR_EMPLEADO(:id, :departamento, :puesto, :salario); END;";
$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":departamento", $departamento);
oci_bind_by_name($stmt, ":puesto", $puesto);
oci_bind_by_name($stmt, ":salario", $salario);

oci_execute($stmt);
oci_free_statement($stmt);
oci_close($conn);
?>
