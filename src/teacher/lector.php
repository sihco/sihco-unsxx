
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar sesión</title>
</head>
<body>
    <h2>Escanear el código QR para iniciar sesión</h2>
    <video id="scanner-container"></video>
    <div id="camera-options"></div>
    <!--<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>-->
    <script src="../assets/instascan.min.js"></script>
    <script>
        let scanner = new Instascan.Scanner({ video: document.getElementById('scanner-container') });
        scanner.addListener('scan', function (content) {
            // Enviar el contenido del código QR al servidor
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Redireccionar al usuario a la página correspondiente
                        window.location.href = xhr.responseText;
                    } else {
                        console.log('Error al iniciar sesión');
                    }
                }
            };
            xhr.open('POST', 'verificar_qr.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('qrContent=' + content);
            alert(content);
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                //scanner.start(cameras[0]);

                selectedCamera = cameras[0];
                if(cameras.length>1){
                  selectedCamera = cameras[1];
                  alert(cameras.length);
                }

                var cameraOptions = document.getElementById('camera-options');
                /*var frontCamera = cameras.find(function (camera) {
                  return camera.name.toLowerCase().includes('front');
                });
                var backCamera = cameras.find(function (camera){
                  return camera.name.toLowerCase().includes('back');
                });
                if(frontCamera && backCamera){
                  var cameraOptions = document.getElementById('camera-options');
                  var frontButton = document.createElement('button');
                  frontButton.textContent = 'Cámara Frontal';
                  frontButton.addEventListener('click', function(){
                    selectedCamera =frontCamera;
                    scanner.start(selectedCamera);
                  });
                  cameraOptions.appendChild(frontButton);
                  var backButton = document.createElement('button');
                  backButton.textContent = 'Cámera Trasera';
                  backButton.addEventListener('click', function(){
                    selectedCamera = backCamera;
                    scanner.start(selectedCamera);
                  });
                  cameraOptions.appendChild(backButton);
                }*/

                /*cameras.forEach(function (camera, index){
                  var button = document.createElement('button');
                  button.textContent = 'Cámara ' +camera+ (index+1);

                  button.addEventListener('click', function () {
                    selectedCamera = camera;
                    scanner.start(selectedCamera);
                  });
                  cameraOptions.appendChild(button);
                });*/

                scanner.start(selectedCamera);
            } else {
                console.error('No se encontró una cámara');
            }
        }).catch(function (e) {
            console.error(e);
        });
    </script>
</body>
</html>
