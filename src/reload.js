var msg = 0;
var rld  = 0;
var selecionando = 0;
var seg = 30;
function recarregar() {
	if (rld) {
		clearTimeout(rld);
    rld  = 0;
  }
  if (selecionando == 1) {
      if (msg<5) {
				msg++;
			}else {
				alert("Esta página intentó recargarse, pero parece que abrió una ventana modal. Para actualizar, haga clic en el botón Recargar en su navegador. Este mensaje no se volverá a mostrar.");
				msg=0;
			}
	} else
        document.location.reload();
  rld = setTimeout("recarregar()", seg * 1000);
}
function Comecar() {
	rld = setTimeout("recarregar()", seg * 1000);
}
function Parar() {
	if (rld) {
		clearTimeout(rld);
		rld  = 0;
	}
}
function Stop() {
	selecionando = 1;
}
function Restart() {
	msg=0;
	selecionando = 0;
}
