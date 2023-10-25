<!DOCTYPE html>
<html>
  <head>
    <title>Lector de códigos QR</title>
    <style>
      #video {
        width: 100%;
        height: auto;
      }
    </style>
  </head>
  <body>

    <h1>Lector de códigos QR <button type="button" id="scanBtn">Escanear QR</button></h1>
    <div id="scannerContainer">
      <video id="video" autoplay></video>
    </div>
    <script src="https://rawgit.com/LazarSoft/jsqrcode/master/src/qr_packed.js"></script>
    <script>
      var video = document.getElementById('video');
      var canvas = document.createElement('canvas');
      var context = canvas.getContext('2d');
      var scanning = false;

      function startScanning() {
        scanning = true;
        requestAnimationFrame(scan);
      }

      function stopScanning() {
        scanning = false;
      }

      function scan() {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
          canvas.width = video.videoWidth;
          canvas.height = video.videoHeight;
          context.drawImage(video, 0, 0, canvas.width, canvas.height);
          var imageData = context.getImageData(0, 0, canvas.width, canvas.height);
          var code = jsQR(imageData.data, imageData.width, imageData.height);
          if (code) {
            console.log('Código QR detectado:', code.data);
            stopScanning();

            // Realizar alguna acción con el código QR escaneado

            // Restaurar el botón de escaneo y el video
            video.srcObject.getTracks().forEach(track => track.stop());
            document.getElementById('scanBtn').style.display = 'block';
            document.getElementById('scannerContainer').removeChild(canvas);
            video.style.display = 'none';
          }
        }
        if (scanning) {
          requestAnimationFrame(scan);
        }
      }

      document.getElementById('scanBtn').addEventListener('click', function() {
        // Ocultar el botón de escaneo y mostrar el video
        this.style.display = 'none';
        video.style.display = 'block';

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
          navigator.mediaDevices
            .getUserMedia({ video: true })
            .then(function(stream) {
              video.srcObject = stream;
              video.play();
              startScanning();
            })
            .catch(function(error) {
              console.error('Error al acceder a la cámara:', error);
              // Restaurar el botón de escaneo y ocultar el video
              document.getElementById('scanBtn').style.display = 'block';
              video.style.display = 'none';
            });
        } else {
          console.error('getUserMedia no es compatible con este navegador.');
          // Restaurar el botón de escaneo y ocultar el video
          document.getElementById('scanBtn').style.display = 'block';
          video.style.display = 'none';
        }
      });
    </script>
  </body>
</html>
