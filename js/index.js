$(document).ready(function () {
    var promptsAnteriores = [];

    $("#buscar").on("click", function() {
        var promptBase = $("#inputPromptBase").val();
        var promptActual = $("#inputPregunta").val();

        var promptCompleto = promptBase+promptActual;
        
        var cuerpo = {
            "model": "llama3",
            "prompt": promptCompleto,
            "stream": true
        };

        $.ajax({
            type: "POST",
            url: "http://localhost:11434/api/generate",
            data: JSON.stringify(cuerpo),
            dataType: 'json', // Espera respuesta tipo JSON
            xhrFields: {
                onprogress: function(e) {
                    var response = e.currentTarget.response;
                    var lines = response.split('\n');
                    var textoAnterior = $("#textaRespuesta").text();
                    lines.forEach(function(line) {
                        if (line.trim() !== '') {
                            var responseObject = JSON.parse(line);
                            console.log(responseObject);
                            $("#textaRespuesta").text(`${textoAnterior}${responseObject.response}`);
                        }
                    });
                }
            }
        }).done(function(data) {
            // Guardar hasta 5 respuestas anteriores
            promptsAnteriores.push(promptActual);
            if (promptsAnteriores.length > 5) {
                promptsAnteriores.shift(); // Eliminar la respuesta más antigua si hay más de 5
            }
            console.log(data);
        });
    });
});
