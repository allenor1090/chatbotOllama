<?php

require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'consultarPreguntasPorId') {
            // Aquí manejas la consulta del ID y devuelves la respuesta en JSON
            $id = $_POST['id'];
            $resultado = consultarPreguntasPorId($id);

            // Comprueba si $resultado contiene datos
            if ($resultado) {
                echo json_encode($resultado);
                exit;
            } else {
                // Si no hay datos, devuelve un JSON vacío o un mensaje de error
                echo json_encode(array('error' => 'No se encontraron datos para el ID proporcionado'));
                exit;
            }
        }
    }

    function crearPreguntas($preg1, $preg2, $preg3, $id_curso, $prompt)
    {
        global $conn;
        $sql = "INSERT INTO preguntas (preg1, preg2, preg3, id_curso, prompt) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssis", $preg1, $preg2, $preg3, $id_curso, $prompt);

        if ($stmt->execute()) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    function actualizarPreguntas($id, $preg1, $preg2, $preg3, $id_curso, $prompt)
    {
        global $conn;
        $sql = "UPDATE preguntas SET preg1 = ?, preg2 = ?, preg3 = ?, id_curso = ?, prompt = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisi", $preg1, $preg2, $preg3, $id_curso, $prompt, $id);

        if ($stmt->execute()) {
            echo "La consulta se ejecutó correctamente.";
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->error;
        }
        $stmt->close();
    }

    // Función para consultar una secuencia por su ID
    function consultarPreguntasPorIdCurso($id_curso)
    {

        global $conn;

        // Preparar la consulta
        $sql = "SELECT * FROM preguntas WHERE id_curso = $id_curso";

        // Preparar la declaración
        //$stmt = $conn->prepare($sql);
        $resultado = mysqli_query($conn, $sql);

        // Obtener la fila como un array asociativo
        $row = $resultado->fetch_assoc();

        return json_encode($row);
    }

    // Función para consultar una secuencia por su ID
    function consultarPreguntasPorId($id)
    {

        global $conn;

        // Preparar la consulta
        $sql = "SELECT * FROM preguntas WHERE id = ?";

        // Preparar la declaración
        $stmt = $conn->prepare($sql);

        // Vincular parámetros
        $stmt->bind_param("i", $id);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        // Obtener la fila como un array asociativo
        $row = $result->fetch_assoc();

        // Cerrar la declaración
        $stmt->close();

        return json_encode($row);
    }

    // En el archivo funciones.php

    // Función para contar el número de registros en la tabla para un curso dado
    function contarRegistrosPorCurso($id_curso)
    {
        global $conn;
        // Crear la consulta SQL para contar los registros y obtener el ID
        $sql = "SELECT COUNT(*) AS num_registros, id FROM preguntas WHERE id_curso = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_curso);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Inicializar variables
        $num_registros = 0;
        $id = null;

        // Obtener los datos
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            $num_registros = $fila['num_registros'];
            $id = $fila['id'];
        }

        $stmt->close();

        // Devolver un array con el número de registros y el ID
        return array('num_registros' => $num_registros, 'id' => $id);
    }



}
?>