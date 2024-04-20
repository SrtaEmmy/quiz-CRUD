<?php 
 require_once('config/conn.php');
 require_once('helpers.php');
session_start();
$id_tema = $_SESSION['id_tema'];

$nombre_tema = get_nombre_tema($id_tema);


if($_SERVER['REQUEST_METHOD']==='POST'){

$pregunta = $_POST['pregunta'];
$opcion_a = $_POST['opcion_a'];
$opcion_b = $_POST['opcion_b'];
$opcion_c = $_POST['opcion_c'];
$correcta = $_POST['correcta'];

$sql = "INSERT INTO preguntas(id_tema, pregunta, opcion_a, opcion_b, opcion_c, correcta) VALUES('$id_tema','$pregunta', '$opcion_a', '$opcion_b', '$opcion_c', '$correcta')";
$connection->query($sql);



}

  
 
require_once('layout/header.php');
?>

<h1>Agregar preguntas a <?php echo $nombre_tema; ?></h1>

<form class="form-control" method="post">
    <div class="container container-inputs">
    <input class="form-control my-4 " type="text" name="pregunta" placeholder="pregunta" required>
    <input class="form-control my-4 " type="text" name="opcion_a" placeholder="opcion a" required>
    <input class="form-control my-4 " type="text" name="opcion_b" placeholder="opcion b" required>
    <input class="form-control my-4 " type="text" name="opcion_c" placeholder="opcion c" required>

    <span>A</span>
    <input type="radio" name="correcta" placeholder="" value="a" required>
    <span>B</span>
    <input type="radio" name="correcta" placeholder="" value="b" required>
    <span>C</span>
    <input type="radio" name="correcta" placeholder="" value="c" required>

    <input class="btn btn-send" type="submit" value="Agregar">
</div>

</form>




<?php require_once('layout/footer.php'); ?>