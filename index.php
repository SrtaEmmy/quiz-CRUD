<?php
require_once ('config/conn.php');
require_once ('helpers.php');


$ids_temas = get_ids_temas();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_tema'])) {
    session_start();
    $_SESSION['id_tema'] = $_GET['id_tema'];
    header('Location: jugando.php');
}

require_once ('layout/header.php');
?>


<a class="btn btn-send m-1 crear " href="nuevo.php">Crear tema</a>

<div class="main-container">
    
    <div class="container " >
        <h1 class="text-center titulo">Elige el tema</h1>
        <div class="row row-cols-1 row-cols-md-4">
            <?php foreach ($ids_temas as $id_tema): ?>
                <div class="col m-3">
                    <form method="get">
                        <input type="hidden" name="id_tema" value="<?php echo $id_tema ?>">
                        <input id="btn-question" data-imagen='img/<?php echo get_nombre_tema($id_tema)?>.jpg' type="submit" class="btn btn- btn-tema btn-block mb-4 btn-<?php echo get_nombre_tema($id_tema)?>" value="<?php echo get_nombre_tema($id_tema) ?>">
                    </form>
                </div>
            <?php endforeach ?>
        </div>
        
    </div>
</div>


<script>


</script>


<?php require_once ('layout/footer.php'); ?>