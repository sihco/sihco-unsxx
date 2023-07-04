<!DOCTYPE html>
<html>
<head>
  <title>Dictado en Tiempo Real</title>
</head>
<body>
  <h1>Dictado en Tiempo Real</h1>

  <button id="startDictation">Iniciar dictado</button>
  <button id="stopDictation">Stop</button>
  <textarea id="textoDictado" cols="50" rows="20"></textarea>

  <script>
    var recognition = null;

    function startDictation() {
      if (!recognition) {
        recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition || window.mozSpeechRecognition || window.msSpeechRecognition)();
        recognition.lang = 'es-ES';
        recognition.interimResults = true;
        recognition.continuous = true;

        recognition.onresult = handleRecognitionResult;
        recognition.onerror = handleRecognitionError;
        recognition.onend = handleRecognitionEnd;
      }

      recognition.start();
      document.getElementById('startDictation').disabled = true;
    }

    function stopDictation() {
      if (recognition) {
        recognition.stop();
        recognition = null;
        document.getElementById('startDictation').disabled = false;
      }
    }

    function handleRecognitionResult(event) {
      var result = event.results[event.results.length - 1];
      var texto = result[0].transcript;
      document.getElementById('textoDictado').value = texto;
    }

    function handleRecognitionError(event) {
      console.error('Error de reconocimiento de voz:', event.error);
    }

    function handleRecognitionEnd() {
      console.log('Reconocimiento de voz finalizado.');
    }

    document.getElementById('startDictation').addEventListener('click', startDictation);
    document.getElementById('stopDictation').addEventListener('click', stopDictation);
  </script>
</body>
</html>
