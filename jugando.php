<?php
require_once ('config/conn.php');
require_once ('helpers.php');
session_start();

// variables
$id_tema = $_SESSION['id_tema'];

$preguntas = get_preguntas_by_id_tema($id_tema);


$respuesta_correcta = '';

if(!isset($_SESSION['total_preguntas'])){
    $_SESSION['total_preguntas'] = 5;
}

if (!isset($_SESSION['puntuacion'])) {
    $_SESSION['puntuacion'] = 0;
}


// si el usuario NO ha pulsado el boton de siguiente
if (!isset($_GET['next'])) {
    $_SESSION['pregunta_actual'] = 0;
} else {
    $respuesta_correcta = $preguntas[$_SESSION['pregunta_actual']]['correcta'];
    if ($_GET['respuesta'] === $respuesta_correcta) {
        $_SESSION['puntuacion']++;
    }

    if ($_SESSION['pregunta_actual'] < $_SESSION['total_preguntas'] - 1) {
        $_SESSION['pregunta_actual']++;
    } else {
        $_SESSION['pregunta_actual'] = 0;
        header('Location: resultados.php');
    }
}


require_once ('layout/header.php');
?>

<h2 class="text-center text-white" ><?php echo get_nombre_tema($id_tema); ?></h2>
<!-- el 0 es el registro y 'pregunta' es el campo -->

<div class="container container-preguntas">
    <?php if(is_array($preguntas)): ?>
        <p class="text-center" >Pregunta <?php echo $_SESSION['pregunta_actual'] + 1; ?> de <?php echo $_SESSION['total_preguntas'] ?></p>

    <h3 class='text-center'><?php echo $preguntas[$_SESSION['pregunta_actual']]['pregunta'] ?></h3>

    <form class="text-center" method="get">
        
        <label class="labelj"  for="r_a"> <?php echo $preguntas[$_SESSION['pregunta_actual']]['opcion_a']; ?> </label>
        <input class="hidde" type="radio" name="respuesta" value="a" id="r_a" required> <br>

        <label class="labelj" for="r_b"> <?php echo $preguntas[$_SESSION['pregunta_actual']]['opcion_b']; ?> </label>
        <input class="hidde" type="radio" name="respuesta" value="b" id="r_b" required> <br>

        <label class="labelj" for="r_c"> <?php echo $preguntas[$_SESSION['pregunta_actual']]['opcion_c']; ?> </label>
        <input class="hidde" type="radio" name="respuesta" value="c" id="r_c" required><br>

        <input type="submit" class="btn-send" name="next" value="Siguiente">
    </form>

    <p class="text-center score">Score: <?php echo $_SESSION['puntuacion'] ?></p>
<?php else: ?>
    <p class="text-center"><?php echo $preguntas ?></p>

    <div class="text-center">
    <a class="btn align btn-send m-3" href="addPreguntas.php">¡Agrégalas!</a><br>
    <a class="btn  align btn-azul mb-3" href="index.php">Volver</a>
    </div>

<?php endif; ?>

</div>

<?php require_once ('layout/footer.php'); ?>