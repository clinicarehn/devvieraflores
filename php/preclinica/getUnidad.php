<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli();

$servicio = $_POST['servicio'];

//CONSULTA LOS DATOS DE LA ENTIDAD CORPORACION
$consulta = "SELECT pc.puesto_id as 'puesto_id', pc.nombre as 'puesto'
              FROM servicios_puestos AS sp
              INNER JOIN colaboradores AS c
              ON sp.colaborador_id = c.colaborador_id
              INNER JOIN puesto_colaboradores AS pc
              ON c.puesto_id = pc.puesto_id
              WHERE sp.servicio_id = '$servicio' AND pc.puesto_id IN(2,4)
              GROUP BY pc.puesto_id";
echo $consulta."***";			  
$result = $mysqli->query($consulta);			  

if($result->num_rows>0){
    echo "<optgroup label='Unidad'>";	
	while($consulta2 = $result->fetch_assoc()){
		echo '<option value="'.$consulta2['puesto_id'].'">'.$consulta2['puesto'].'</option>';
	}
	echo "</optgroup>";	
}

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>