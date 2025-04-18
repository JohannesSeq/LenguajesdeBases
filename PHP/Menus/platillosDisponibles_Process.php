<?php
$conn = oci_connect("PlayaCacaoDB", "PlayaCacao12345", "localhost/XE");
$id_menu = $_GET['id_menu'];

$query = "
    SELECT P.ID_PLATILLO, P.NOMBRE_PLATILLO
    FROM PLATILLOS P
    WHERE P.ID_PLATILLO NOT IN (
        SELECT PM.ID_PLATILLO FROM PLATILLOS_MENU PM WHERE PM.ID_MENU = :ID_MENU
    )
    AND P.ID_ESTADO IS NOT NULL
";
$stmt = oci_parse($conn, $query);
oci_bind_by_name($stmt, ":ID_MENU", $id_menu);
oci_execute($stmt);

$platillos = [];
while ($row = oci_fetch_assoc($stmt)) {
    $platillos[] = $row;
}

echo json_encode($platillos);

oci_close($conn);
?>
