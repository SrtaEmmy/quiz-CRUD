<?php 
 
function get_ids_temas(){
    require('config/conn.php');
    $sql = "SELECT id FROM temas";
    $result = $connection->query($sql);

    $ids = array();
    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            $ids[] = $row['id'];
        }
    }
    return $ids;
}

function get_ids_temas2(){
    require('config/conn.php');
    $sql = "SELECT id FROM temas ORDER BY id DESC";
    $result = $connection->query($sql);

    $ids = array();
    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            $ids[] = $row['id'];
        }
    }
    return $ids;
}


function get_nombre_tema($id_tema){
    require('config/conn.php');
    $sql = "SELECT nombre FROM temas WHERE id = $id_tema";
    $result = $connection->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row['nombre'];
    }
}

function get_preguntas_by_id_tema($id_tema){
    require('config/conn.php');
    $sql = "SELECT id, pregunta, opcion_a, opcion_b, opcion_c, correcta FROM preguntas WHERE id_tema = $id_tema";
    $result = $connection->query($sql);

    $preguntas = array();
    $_SESSION['total_preguntas'] = 5;
    if($result->num_rows >= $_SESSION['total_preguntas']){
        while ($row = $result->fetch_assoc()) {
            $preguntas[] = $row; 
        }
        return $preguntas;

    }
    else{
          return "Este tema no tiene la cantidad mínima de preguntas para jugar(5 preguntas)";
    }
}

function get_preguntas_by_id_tema2($id_tema){
    require('config/conn.php');
    $sql = "SELECT id, pregunta, opcion_a, opcion_b, opcion_c, correcta FROM preguntas WHERE id_tema = $id_tema";
    $result = $connection->query($sql);

    $preguntas = array();
    $_SESSION['total_preguntas'] = 5;
    if($result->num_rows >= $_SESSION['total_preguntas']){
        while ($row = $result->fetch_assoc()) {
            $preguntas[] = $row; 
        }
        return $preguntas;

    }elseif($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            $preguntas[] = $row; 
        }
        return $preguntas;
    }
    else{
          return "Este tema no tiene la cantidad mínima de preguntas para jugar(5 preguntas)";
    }
}



function get_preguntas_by_id($id_pregunta){
    require('config/conn.php');
    $sql = "SELECT id, pregunta, opcion_a, opcion_b, opcion_c, correcta FROM preguntas WHERE id = $id_pregunta";
    $result = $connection->query($sql);

    $_SESSION['total_preguntas'] = 5;
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row;

    }else{
          return "no preguntas";
    }
}

function get_default_by_id($id_tema){
    require('config/conn.php');
    $sql = "SELECT defecto FROM temas WHERE id = '$id_tema'";
    $result = $connection->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row['defecto'];
    }
    
} 


?>