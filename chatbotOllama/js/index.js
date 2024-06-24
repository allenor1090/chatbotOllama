$(document).ready(function () {
    var promptsAnteriores = [];

    $("#buscar").on("click", function() {
        var promptBase = $("#inputPromptBase").val();
        var promptActual = $("#inputPregunta").val();

        var promptCompleto = promptBase+promptActual;
        
        var cuerpo = {
            "model": "llama3",
            "prompt": promptCompleto,
            "stream": true,
            "options": {
                "num_keep": 5,
                "seed": 42,
                "top_k": 20,
                "top_p": 0.9,
                "tfs_z": 0.5,
                "temperature": 0.8,
                "repeat_penalty": 1.2,
                "presence_penalty": 1.5,
                "frequency_penalty": 1.0,
                "num_thread": 8,
                "penalize_newline": true,
                "mirostat": 1,
                "mirostat_tau": 0.8,
                "mirostat_eta": 0.6,
            }
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
