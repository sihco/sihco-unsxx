
//inicio funciones qr
var scanner = new Instascan.Scanner({
    video: document.getElementById('preview'),
    scanPeriod: 5,
    mirror: false
});
var scanning = false;
scanner.addListener('scan', function (content) {
    //alert(content);
    //var remission = $('#remissionid').val();
    registerqr(content);
    stopScanning();
    $('#modalqr').modal('hide');
});

function startScanning() {
    scanning = true;

    Instascan.Camera.getCameras().then(function (cameras) {
      if (cameras.length > 0) {
        //alert('Camaras: '+ cameras.length);
        scanner.start(cameras[0]);
        $('[name="options"]').on('change', function () {
          if ($(this).val() == 1) {
            if (cameras[0] != "") {
              scanner.start(cameras[0]);
            } else {
              alert('No Front camera found!');
            }
          } else if ($(this).val() == 2) {
            if (cameras[1] != "") {
              scanner.start(cameras[1]);
            } else {
              alert('No Back camera 1 found!');
            }
          } else if ($(this).val() == 3) {
            if (cameras[2] != "") {
              scanner.start(cameras[2]);
            } else {
              alert('No Back camera 2 found!');
            }
          }
        });
      } else {
        console.error('No encontrado camara.');
        alert('No encontrado camara.');
      }
    }).catch(function (e) {
      console.error(e);
      alert(e);
    });
}

function stopScanning() {
  scanner.stop();
  scanning = false;
}

function readqr(e, fname){
  document.getElementById('inputqr').value=e;
  document.getElementById('functionname').value=fname;
  //iniciar camara
  startScanning();
}
document.getElementById('modalqr').addEventListener('hidden.bs.modal', event => {
  //alert('alert fin modal');
  //parar camara
  stopScanning();
});
