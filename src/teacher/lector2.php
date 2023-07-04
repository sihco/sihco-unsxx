<!DOCTYPE html>
<html>
<head>
  <title>QuaggaJS Test</title>
  <script src="../assets/quagga.min.js"></script>
</head>
<body>
  <div id="scanner-container"></div>
  <button onclick="switchCamera()">Cambiar cámara</button>

  <script>
    var scannerContainer = document.getElementById('scanner-container');
    var currentCamera = 'environment'; // Inicialmente, establecer la cámara trasera como predeterminada

    function switchCamera() {
      if (currentCamera === 'environment') {
        currentCamera = 'user'; // Cambiar a la cámara delantera
      } else {
        currentCamera = 'environment'; // Cambiar a la cámara trasera
      }

      // Detener QuaggaJS y volver a inicializarlo con la nueva cámara seleccionada
      Quagga.stop();
      Quagga.init({
        inputStream: {
          name: "Live",
          type: "LiveStream",
          target: scannerContainer,
          constraints: {
            facingMode: currentCamera // Establecer la nueva cámara seleccionada
          }
        },
        decoder: {
          readers: ["ean_reader"]
        }
      }, function (err) {
        if (err) {
          console.error("Error al inicializar Quagga:", err);
          return;
        }

        Quagga.start();
      });
    }

    Quagga.init({
      inputStream: {
        name: "Live",
        type: "LiveStream",
        target: scannerContainer,
        constraints: {
          facingMode: currentCamera // Establecer la cámara inicial
        }
      },
      decoder: {
        readers: ["ean_reader"]
      }
    }, function (err) {
      if (err) {
        console.error("Error al inicializar Quagga:", err);
        return;
      }

      Quagga.start();
      Quagga.onDetected(function(result) {
        var code = result.codeResult.code;
        alert('adsf');
      });
    });

    //Quagga.start();
  </script>
</body>
</html>
