<!DOCTYPE html>
<html>
<head>
  <title>Lectura de Texto en Voz Alta</title>
</head>
<body>
  <h1>Lectura de Texto en Voz Alta</h1>

  <textarea id="texto" rows="5"></textarea>
  <button id="leer">Leer texto</button>

  <script>
    var botonLeer = document.getElementById('leer');
    var campoTexto = document.getElementById('texto');

    botonLeer.addEventListener('click', function() {
      var texto = campoTexto.value;

      if ('speechSynthesis' in window) {
        // Crear instancia de SpeechSynthesisUtterance
        var speech = new SpeechSynthesisUtterance();
        speech.text = texto;

        // Configurar opciones de la síntesis de voz
        speech.lang = 'es-ES';
        speech.rate = 1.0;
        speech.pitch = 1.0;

        // Obtener lista de voces disponibles
        var voices = window.speechSynthesis.getVoices();

        // Seleccionar una voz en español
        var voice = voices.find(function(voice) {
          return voice.lang === 'es-ES';
        });

        if (voice) {
          speech.voice = voice;
        } else {
          console.warn('No se encontró una voz en español.');
        }

        // Iniciar la síntesis de voz
        window.speechSynthesis.speak(speech);
      } else {
        console.error('API de Text-to-Speech no compatible con el navegador.');
      }
    });
  </script>
</body>
</html>
