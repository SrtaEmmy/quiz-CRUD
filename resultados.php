<?php 
session_start();

$correctas = isset($_SESSION['puntuacion']) ? $_SESSION['puntuacion'] : 0;
$errores = isset($_SESSION['total_preguntas']) ? $_SESSION['total_preguntas'] - $correctas : 0;

$_SESSION['puntuacion'] = 0;

require_once('layout/header.php');
?>

<div class="container text-center mt-4 container-resultados">
    <h1>Resultados</h1>
    <b>Aciertos: </b><?php echo $correctas; ?> <br>
    <b>Errores: </b> <?php echo $errores; ?>

    <br>
    <br>
    
    <div class="d-flex justify-content-center">
        <canvas id="grafico" width="200" height="200"></canvas>
    </div>

    <br>
    <br>

    <a class="btn-send" href="index.php">VOLVER A INICIO</a>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Obtener el contexto del canvas
    var ctx = document.getElementById('grafico').getContext('2d');

    // Crear el gráfico
    var chart = new Chart(ctx, {
        type: 'doughnut', // Tipo de gráfico redondo
        data: {
            labels: ['Aciertos', 'Errores'],
            datasets: [{
                label: 'Resultados',
                data: [<?php echo $correctas; ?>, <?php echo $errores; ?>],
                backgroundColor: [
                    'green', // Color para aciertos
                    'red'    // Color para errores
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // No responsive para mantener el tamaño fijo del gráfico
            legend: {
                position: 'bottom' // Posición de la leyenda
            }
        }
    });
</script>

<?php require_once('layout/footer.php'); ?>
