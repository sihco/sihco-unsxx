<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <br><br>
    <label for="">Nombres:</label>
    <input type="text" name="" value="">
    <label for="">Primer apellido:</label>
    <input type="text" name="" value="">
    <label for="">Segundo apellido:</label>
    <input type="text" name="" value="">
    <label for="">Edad:</label>
    <input type="text" name="" value="">
    <br>
    <br>
    <br>
    <button type="button" name="bot" id="bot">Bot</button>


    <script>
    var botonLeer = document.getElementById('bot');
    var campoTexto = 'Tu Nombre?';//document.getElementById('texto');

    botonLeer.addEventListener('click', function() {
      var texto = campoTexto;//.value;

      if ('speechSynthesis' in window) {
        // Crear instancia de SpeechSynthesisUtterance
        var speech = new SpeechSynthesisUtterance();
        speech.text = texto;

        // Configurar opciones de la síntesis de voz
        speech.lang = 'es-ES';
        speech.rate = 1.0;
        speech.pitch = 1.0;
        speech.volume = 1.0; // Aumentar volumen
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
