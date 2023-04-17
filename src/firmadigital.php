<style media="screen">
.signature-pad {
  position: relative;
 display: -webkit-box;
 display: -ms-flexbox;
 display: flex;
 -webkit-box-orient: vertical;
 -webkit-box-direction: normal;
     -ms-flex-direction: column;
         flex-direction: column;
 font-size: 10px;
 width: 100%;
 height: 30%;
 max-width: 600px;
 max-height: 460px;
 border: 1px solid #e8e8e8;
 background-color: #fff;
 box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
 border-radius: 4px;
 padding: 16px;
}

.signature-pad1 {
  position: relative;
 display: -webkit-box;
 display: -ms-flexbox;
 display: flex;
 -webkit-box-orient: vertical;
 -webkit-box-direction: normal;
     -ms-flex-direction: column;
         flex-direction: column;
 font-size: 10px;
 width: 100%;
 height: 30%;
 max-width: 700px;
 max-height: 460px;
 border: 1px solid #e8e8e8;
 background-color: #fff;
 box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
 border-radius: 4px;
 padding: 16px;
}

.signature-pad1::before,
.signature-pad1::after {
position: absolute;
z-index: -1;
content: "";
width: 40%;
height: 10px;
bottom: 10px;
background: transparent;
box-shadow: 0 8px 12px rgba(0, 0, 0, 0.4);
}

.signature-pad--body {
  position: relative;
  -webkit-box-flex: 1;
      -ms-flex: 1;
          flex: 1;
  border: 1px solid #f4f4f4;
}

.signature-pad--body1 {
  position: relative;
  -webkit-box-flex: 1;
      -ms-flex: 1;
          flex: 1;
  border: 1px solid #f4f4f4;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Basic Modal</h4>
      </div>
      <div class="modal-body">
        <div id="signature-pad" class="signature-pad">
                    <div class="signature-pad--body">
                        <canvas id="canvas" width="565" height="100"></canvas>
                    </div>
                    <div class="signature-pad--footer">
                        <div class="signature-pad--actions" style="margin-top: 10px;">
                            <div>
                                <button type="button" class="button clear" data-action="clear">Limpiar</button>
                            </div>
                        </div>
                    </div>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" onclick="save()" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="anotherModal" tabindex="-1" role="dialog" aria-labelledby="anotherModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Another Modal</h4>
      </div>
      <div class="modal-body">
        <div id="signature-pad1" class="signature-pad1">
                    <div class="signature-pad--body1">
                        <canvas id="canvas1" width="565" height="100"></canvas>
                    </div>
                    <div class="signature-pad--footer">
                        <div class="signature-pad--actions" style="margin-top: 10px;">
                            <div>
                                <button type="button" class="button clear" data-action="clear">Limpiar</button>
                            </div>
                        </div>
                    </div>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function () {
$('#basicModal').modal({ show: false});
$('#basicModal').modal('show');
});

function save() {
$('#basicModal').modal('toggle');
$('#anotherModal').modal('show');
}

var canvas = document.querySelector("canvas");

var signaturePad = new SignaturePad(canvas);

var signaturePad1 = new SignaturePad(canvas1);


//analisis

import SignaturePad from './SignaturePad.js';
var firmaText ="Firme Aqu铆";
var limpiarText ="Limpiar";
var getText ="Obtener Datos en consola (CTR+Shift+J)";// Creaci贸n canvas
var canvas_simple = document.createElement('canvas');
canvas_simple.setAttribute('width', '1000');
canvas_simple.setAttribute('height', '300');
canvas_simple.setAttribute('id',"idSignCaptureCanvas0");
canvas_simple.setAttribute('style',"border: 2px solid #000;cursor: crosshair");
document.body.appendChild(canvas_simple);
var espacio = document.createElement('BR');
document.body.appendChild(espacio);// Creaci贸n de bot贸n para limpiar textovar
button_clear = document.createElement('button');
button_clear.setAttribute('class', 'btn btn-info btn-block ');
button_clear.setAttribute('type', 'button');
button_clear.setAttribute('id', 'idCleanButton');
button_clear.innerHTML = limpiarText;document.body.appendChild(button_clear);// Creaci贸n de bot贸n para mostrar en consola datos capturados
var button_getdata = document.createElement('button');
button_getdata.setAttribute('class', 'btn btn-info btn-block ');
button_getdata.setAttribute('type', 'button');
button_getdata.setAttribute('id', 'idGetButton');
button_getdata.innerHTML = getText;
document.body.appendChild(button_getdata);
var sigPad = new SignaturePad( { canvas: document.getElementById("idSignCaptureCanvas0"), // Elemento canvas
 textFont: 'normal 15px monospace', // Fuente
 textStrokeColor: 'transparent', // Color de contorno del texto
 textFillColor: '#000', // Color del texto de marca de agua
 brushSize: 2, // Grosor del trazo
 splashText: firmaText // Texto de la marca de agua
} );document.querySelector( '#idCleanButton').onclick = function () { // Funci贸n para borrar el trazo del canvas
   sigPad.clear();
 }document.querySelector( '#idGetButton').onclick = function () { // Funci贸n que verifica si hay trazo
   console.log("isBlank:", sigPad.isBlank()); // Funci贸n para obtener la imagen dibujada en base64
   console.log("toDataURL:", sigPad.toDataURL()); // Funci贸n para obtener los datos X, Y y Dt en JSON
   console.log("getDataInJSON:", sigPad.getDataInJSON()); // Funci贸n para obtener los datos X, Y y Dt
   console.log("getData:", sigPad.getData());
 }

</script>
