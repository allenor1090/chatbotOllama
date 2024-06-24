<?php
//incluir el archivo funciones
require_once 'funciones.php';

//var_dump($_POST);

// Verificar si se ha enviado una solicitud POST para crear o actualizar un set de preguntas
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crear_preguntas"])) {
    // Recuperar el id del curso
    $id_curso = $_POST["id_curso"];
    $resultado = contarRegistrosPorCurso((int) $id_curso);

    // Consultar el número de registros en la tabla para el curso especificado
    $num_registros = $resultado['num_registros'];
    $id_existente = $resultado['id'];

    // Recuperar las preguntas del formulario
    $preg1 = $_POST["preg1"];
    $preg2 = $_POST["preg2"];
    $preg3 = $_POST["preg3"];
    $prompt = $_POST["promptBase"];

    if ($num_registros > 0 && $id_existente !== null) {
        // Si hay registros, actualizar la secuencia de preguntas  
        actualizarPreguntas((int) $id_existente, $preg1, $preg2, $preg3, (int) $id_curso, $prompt);
        //header("Location: index.php");
        echo "Preguntas actualizadas exitosamente.";
    } else {
        // Si no hay registros, crear una nueva secuencia de preguntas  
        crearPreguntas($preg1, $preg2, $preg3, (int) $id_curso, $prompt);
        //header("Location: index.php");
        echo "Preguntas creadas exitosamente.";

    }
}

// Verificar si se ha enviado una solicitud POST para consultar una secuencia por su ID
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["consultarPreguntasPorId"])) {
    // Recuperar el ID de la secuencia a consultar
    $id = $_POST["id"];

    // Llamar a la función para consultar la secuencia por su ID
    $pregunta = consultarPreguntasPorId($id);

    //devolver los datos de la secuencia como json
    echo json_encode($pregunta);
    if ($pregunta) {
        // Haz algo con la secuencia consultada
        echo "Consulta por ID exitosa.";
    } else {
        echo "No se encontró ninguna secuencia con ese ID.";
    }
}

    function consultarPregIdCurso($id){
        return consultarPreguntasPorIdCurso($id);
    }

?>