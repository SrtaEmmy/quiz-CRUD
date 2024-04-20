<?php 
 require_once('config/conn.php');

 $error_msg = '';

 if($_SERVER['REQUEST_METHOD']==='POST'){
    $tema = mysqli_real_escape_string($connection, $_POST['tema']);

    $tema = ucfirst($tema);

    try {
        $sql = "INSERT INTO temas (nombre) VALUES('$tema')";
        $connection->query($sql);

        $sql = "SELECT id FROM temas WHERE nombre = '$tema'";
        $result = $connection->query($sql);

        if($result->num_rows > 0){
            session_start();
            $row = $result->fetch_assoc();
            $_SESSION['id_tema'] = $row['id'];
        }

        header('Location: addPreguntas.php');
    } catch (mysqli_sql_exception $e) {
        if($e->getCode() == 1062){
            $error_msg = "El tema $tema ya existe, elige otro nombre";
        }else{
            $error_msg = 'Error al crear el tema';
        }
    }


 }
  
 
 require_once('layout/header.php');
?>

<div class="container-form">
   <div class="cont">
   <h2>Nuevo tema</h2>
<form method="post">
    <input type="text" name="tema" placeholder="nombre del tema" required autocomplete="off">
    <input type="submit" class="btn btn-send" value="Crear">
</form>
   </div>

</div>

<p class="text-center text-white" ><?php echo $error_msg; ?></p>

<?php  require_once('layout/footer.php'); ?>
