<!DOCTYPE html>
<html>
<head>
  <title>Lectura y Dictado por Voz</title>
</head>
<body>
  <h1>Lectura y Dictado por Voz</h1>

  <select id="opciones">
    <option value="">Seleccionar opción</option>
    <option value="opción 1">Opción 1</option>
    <option value="opción 2">Opción 2</option>
    <option value="opción 3">Opción 3</option>
  </select>

  <textarea id="textoDictado" rows="5"></textarea>
  <button id="startDictation">Iniciar dictado</button>
  <button id="leer">Leer texto</button>

  <script>
    var recognition = null;
    var selectOpciones = document.getElementById('opciones');
    var campoTextoDictado = document.getElementById('textoDictado');

    var botonDictado = document.getElementById('startDictation');
    var botonLeer = document.getElementById('leer');

    botonDictado.addEventListener('click', function() {
      if (!recognition) {
        recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition || window.mozSpeechRecognition || window.msSpeechRecognition)();
        recognition.lang = 'es-ES';
        recognition.interimResults = true;
        recognition.continuous = true;

        recognition.onresult = function(event) {
          handleRecognitionResult(event, campoTextoDictado);
        };
        recognition.onerror = handleRecognitionError;
        recognition.onend = handleRecognitionEnd;
      }

      recognition.start();
      botonDictado.disabled = true;
    });

    botonLeer.addEventListener('click', function() {
      var texto = selectOpciones.value;
      if (texto) {
        if ('speechSynthesis' in window) {
          var speech = new SpeechSynthesisUtterance(texto);
          window.speechSynthesis.speak(speech);
        } else {
          console.error('API de Text-to-Speech no compatible con el navegador.');
        }
      } else {
        console.warn('No se ha seleccionado ninguna opción para leer.');
      }
    });

    function handleRecognitionResult(event, textField) {
      var result = event.results[event.results.length - 1];
      var texto = result[0].transcript;

      textField.value = texto;
    }

    function handleRecognitionError(event) {
      console.error('Error de reconocimiento de voz:', event.error);
    }

    function handleRecognitionEnd() {
      console.log('Reconocimiento de voz finalizado.');
      recognition = null;
      botonDictado.disabled = false;
    }
  </script>
</body>
</html>
