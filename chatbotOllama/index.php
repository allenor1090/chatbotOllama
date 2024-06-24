<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/index.css">
</head>

<body>
  <?php
  require_once 'conexion.php';

  $data = array();
  $rolename = "";
  $idCurso = -1;
  if (isset($_GET['parametro'])) {
    $json_data_url = $_GET['parametro'];
    $data = json_decode(urldecode($json_data_url), true);
    $idCurso = $data[0];
    $rolename = $data[1];
  }

  global $conn;

  // Preparar la consulta
  $sql = "SELECT * FROM preguntas WHERE id_curso = $idCurso";

  // Preparar la declaración
  //$stmt = $conn->prepare($sql);
  $resultado = mysqli_query($conn, $sql);

  // Obtener la fila como un array asociativo
  $row = $resultado->fetch_assoc();

  $preguntas = json_encode($row);
  ?>
  <?php if ($rolename === "editingteacher") {?>

    <form action="crud.php" method="POST">
      <div class="contenedorPreguntas">
        <div class="pregunta">
          <div class="ms-3">
            <input type="hidden" name="crear_preguntas" value="">
          </div>
          <div class="ms-3">
            <label for="inputPromptBase">Prompt Base:</label>
            <textarea id="inputPromptBase" name="promptBase" rows="4" cols="50" class="form-control"><?php echo htmlspecialchars($row['prompt']); ?></textarea>

          </div>
          <div class="ms-3 mt-3">
            <label class="form-label">Pregunta 1</label>
            <input type="text" class="form-control" id="inputPregunta1" name="preg1"
              placeholder="<?php echo $row['preg1']; ?>">

          </div>
        </div>
        <div class="pregunta mt-3">
          <div class="ms-3">
            <label class="form-label">Pregunta 2</label>
            <input type="text" class="form-control" id="inputPregunta2" name="preg2"
              placeholder="<?php echo $row['preg2']; ?>">
          </div>
        </div>
        <div class="pregunta mt-3">
          <div class="ms-3">
            <label class="form-label">Pregunta 3</label>
            <input type="text" class="form-control" id="inputPregunta3" name="preg3"
              placeholder="<?php echo $row['preg2']; ?>">
          </div>
        </div>
        <input type="hidden" name="id_curso" value="<?php echo $data[0]; ?>">
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
  <?php } ?>

  <?php if ($rolename === "student") {?>
    <form>
    <div class="contenedorPreguntas">
        <div class="pregunta">
            <div class="ms-3 mt-3">
                <label class="form-label" style="font-weight: bold; font-size: larger;">Pregunta 1:</label>
                <div><?php echo htmlspecialchars($row['preg1']); ?></div>
            </div>
        </div>
        <div class="pregunta mt-3">
            <div class="ms-3">
                <label class="form-label" style="font-weight: bold; font-size: larger;">Pregunta 2:</label>
                <div><?php echo htmlspecialchars($row['preg2']); ?></div>
            </div>
        </div>
        <div class="pregunta mt-3">
            <div class="ms-3">
                <label class="form-label" style="font-weight: bold; font-size: larger;">Pregunta 3:</label>
                <div><?php echo htmlspecialchars($row['preg3']); ?></div>
            </div>
        </div>
        <input type="hidden" name="id_curso" value="<?php echo $data[0]; ?>">
    </div>
</form>


<?php }?>


  <div class="contenedor mt-5">
    <div class="ms-3">
      <label class="form-label" style="font-weight: bold; font-size: larger;">Pregunta</label>
      <input type="text" class="form-control" id="inputPregunta" placeholder="Pregúntame cualquier cosa">
    </div>
    <div class="ms-3 mt-3">
      <label class="form-label" style="font-weight: bold; font-size: larger;">Respuesta</label>
      <textarea class="form-control" id="textaRespuesta" rows="3"></textarea>
    </div>
    <div class="ms-3 mt-3">
      <button class="btn btn-primary" type="button" id="buscar">Enviar</button>
    </div>
  </div>
  <script src="js/index.js"></script>
</body>

</html>