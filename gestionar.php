<?php
require_once ('config/conn.php');
require_once ('helpers.php');

$ids_temas = get_ids_temas2();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $delete_id = $_POST['delete'];

    // borrar preguntas
    $deleting_questions = "DELETE FROM preguntas WHERE id_tema = '$delete_id'";
    $connection->query($deleting_questions);

    // borrar el tema
    $deleting_tema = "DELETE FROM temas WHERE id = '$delete_id'";
    $connection->query($deleting_tema);

    header('Location: gestionar.php');
}

// actualizar pregunta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_pregunta'])) {
    $id_pregunta = mysqli_real_escape_string($connection, $_POST['update']);
    $pregunta = mysqli_real_escape_string($connection, $_POST['update_pregunta']);
    $opcion_a = mysqli_real_escape_string($connection, $_POST['update_op_a']);
    $opcion_b = mysqli_real_escape_string($connection, $_POST['update_op_b']);
    $opcion_c = mysqli_real_escape_string($connection, $_POST['update_op_c']);
    $correcta = mysqli_real_escape_string($connection, $_POST['correcta']);

    $sql = "UPDATE preguntas SET pregunta = '$pregunta', opcion_a = '$opcion_a', opcion_b = '$opcion_b', opcion_c = '$opcion_c', correcta = '$correcta' WHERE id = '$id_pregunta'";
    $connection->query($sql);

    header('Location: gestionar.php');

}

// eliminar pregunta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_question'])) {
    $delete_id = $_POST['delete_question'];

    $sql = "DELETE FROM preguntas WHERE id = '$delete_id'";
    $connection->query($sql);

    header('Location: gestionar.php');
}

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['pregunta']) && isset($_POST['id_tema_update_pregunta'])){
    $id_tema_update = $_POST['id_tema_update_pregunta'];
    $pregunta = mysqli_real_escape_string($connection, $_POST['pregunta']);
    $opcion_a = mysqli_real_escape_string($connection, $_POST['opcion_a']);
    $opcion_b = mysqli_real_escape_string($connection, $_POST['opcion_b']);
    $opcion_c = mysqli_real_escape_string($connection, $_POST['opcion_c']);
    $correcta = mysqli_real_escape_string($connection, $_POST['correcta']);

    $sql = "INSERT INTO preguntas (id_tema, pregunta, opcion_a, opcion_b, opcion_c, correcta) VALUES('$id_tema_update','$pregunta', '$opcion_a', '$opcion_b', '$opcion_c', '$correcta')";
    $connection->query($sql);

    header('Location: gestionar.php');
}


require_once ('layout/header.php');
?>


<div id="miAlerta" class="alert alert-warning alert-dismissible fade show" role="alert" style="display: none">
  <strong>Temas por defectos</strong> no pueden ser manipulados. Pero puedes crear, editar y eliminar los <b>tuyos</b>.
</div>


<div class="container container-temas">
   <div class="container container-hijo">

    
<h1 class="text-center text-white" >Temas</h1>
<?php foreach ($ids_temas as $id_tema): ?>
    <?php $default = get_default_by_id($id_tema); ?>

    <div style="background-color: white;" class="container container-gestion mt-4 pt-2">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    
                    <h3  ><?php echo get_nombre_tema($id_tema) ?></h3> <span class="default"> <?php echo $default=='true' ? 'tema por defecto' : ''; ?> </span>
                </div>
            </div>

            <div class="col-md-6 botones">
                <div class="d-flex align-items-center justify-content-end">
                    <div class=" mx-1 deffault">
                        <button type="button" class="btn btn-danger mb-2" data-bs-toggle="modal"
                            data-bs-target="#borrar<?php echo $id_tema ?>"
                            <?php echo $default=='true' ? 'disabled' : ''; ?> data-bs-whatever="@mdo">X</button>
                    </div>
                    <div>
                        <button id="btn-ver-preguntas" onclick="show_preguntas(<?php echo $id_tema; ?>)" type="button"
                            class="btn btn-primary mb-2">Preguntas</button>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
    <!-- caja de mostrar preguntas -->
    <div id="block-preguntas<?php echo $id_tema ?>" class="container container-gestion bg hidde-block ">
        <?php $preguntas = get_preguntas_by_id_tema2($id_tema); ?>

        <div class="deffault">
        <button type="button" <?php echo $default =='true' ? 'disabled' : ''; ?>
         class="btn mx-4 mt-2 btn-primary btn-sm btn-add " data-bs-toggle="modal"
        data-bs-target="#add<?php echo $id_tema?>" data-bs-whatever="@mdo">Agregar</button>
        </div>

        <?php if (is_array($preguntas)): ?>
            <?php foreach ($preguntas as $pregunta): ?>
                <div class=" row">
                    <div class="preguntas col-md-6">
                        <b><?php echo $pregunta['pregunta'] ?></b>
                        <p>A: <?php echo $pregunta['opcion_a'] ?></p>
                        <p>B: <?php echo $pregunta['opcion_b'] ?></p>
                        <p>C: <?php echo $pregunta['opcion_c'] ?></p>
                        <p>Respuesta: <b><?php echo strtoupper($pregunta['correcta']) ?></b></p>
                    </div>

                    <div class=" col-md-6 deffault">
                        <button type="button" <?php echo $default =='true' ? 'disabled' : ''; ?>
                         class="btn btn-success edit-btn btn-sm " data-bs-toggle="modal"
                            data-bs-target="#update<?php echo $pregunta['id'] ?>" data-bs-whatever="@mdo">Editar</button>

                        <div class="btn">
                            <form method="post">
                                <input type="hidden" name="delete_question" value="<?php echo $pregunta['id']; ?>">
                                <input class="btn btn-danger btn-sm deffault" <?php echo $default =='true' ? 'disabled' : ''; ?>
                                 type="submit" value="X">
                            </form>
                        </div>

                        <br>
                    </div>
                    <hr>
                </div>

                <!-- modal actualizar pregunta -->
                <div class="modal fade" id="update<?php echo $pregunta['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar pregunta</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="post">
                                    <?php $update_pregunta = get_preguntas_by_id($pregunta['id']);
                                    ;
                                    ?>
                                    <input type="hidden" name="update" value="<?php echo $pregunta['id'] ?>">
                                    <input class="form-control" type="text" name="update_pregunta"
                                        value="<?php echo $update_pregunta['pregunta'] ?>" required>
                                    <input class="form-control" type="text" name="update_op_a"
                                        value="<?php echo $update_pregunta['opcion_a'] ?>" required>
                                    <input class="form-control" type="text" name="update_op_b"
                                        value="<?php echo $update_pregunta['opcion_b'] ?>" required>
                                    <input class="form-control" type="text" name="update_op_c"
                                        value="<?php echo $update_pregunta['opcion_c'] ?>" required>

                                    <span>A</span>
                                    <input type="radio" name="correcta" value="a" <?php echo $update_pregunta['correcta'] == 'a' ? 'checked' : ''; ?> required>
                                    <span>B</span>
                                    <input type="radio" name="correcta" value="b" <?php echo $update_pregunta['correcta'] == 'b' ? 'checked' : ''; ?> required>
                                    <span>C</span>
                                    <input type="radio" name="correcta" value="c" <?php echo $update_pregunta['correcta'] == 'c' ? 'checked' : ''; ?> required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Este tema no tiene preguntas</p>
        <?php endif ?>

                                <!-- modal agregar pregunta -->
                                <div class="modal fade" id="add<?php echo $id_tema?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar pregunta a <?php echo get_nombre_tema($id_tema) ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="post">
                                    <input type="hidden" name="id_tema_update_pregunta" value="<?php echo $id_tema; ?>">
                                    <label for="pregunta">Pregunta: </label>
                                   <input class="form-control mb-4" type="text" name="pregunta" placeholder="pregunta" required>
                                   <label for="opcion_a">Opcion a: </label>
                                   <input class="form-control mb-4" type="text" name="opcion_a" placeholder="opcion a" required>
                                   <label for="opcion_b">Opcion b: </label>
                                   <input class="form-control mb-4" type="text" name="opcion_b" placeholder="opcion b" required>
                                   <label for="opcion_c">Opcion c: </label>
                                   <input class="form-control mb-4" type="text" name="opcion_c" placeholder="opcion c" required>

                                   <span>A</span>
                                   <input type="radio" name="correcta" value="a" required>
                                   <span>B</span>
                                   <input type="radio" name="correcta" value="b" required>
                                   <span>C</span>
                                   <input type="radio" name="correcta" value="c" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

    </div>

    <!-- modal borrar -->
    <div class="modal fade" id="borrar<?php echo $id_tema ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar tema tal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Seguro que quieres eliminar tema <b><?php echo get_nombre_tema($id_tema) ?></b> ?
                    <form method="post">
                        <input type="hidden" name="delete" value="<?php echo $id_tema ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                   
                    <div class="deffault">
                    <button type="submit" <?php echo $default=='true' ? 'disabled' : '';  ?> class="btn btn-danger deffault">Eliminar</button>
                    </div>    
                </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


</div>
</div>

<?php require_once ('layout/footer.php'); ?>