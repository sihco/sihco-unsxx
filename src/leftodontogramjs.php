
<script type="text/javascript">
//funcion para remplazar un patron
function replaceAll(find, replace, str) {
    return str.replace(new RegExp(find, 'g'), replace);
}
//crea odontograma
function createOdontogram() {
    var htmlLecheLeft = "",
        htmlLecheRight = "",
        htmlLeft = "",
        htmlRight = "",
        a = 1;
    var cl='';
    for (var i = 9 - 1; i >= 1; i--) {//generador de odontograma
        if(i==8){
          cl='x';
        }else{
          cl='';
        }
        //Dientes Definitivos Cuandrante Derecho (Superior/Inferior)
        htmlRight += '<div data-name="value" id="dienteindex' + i + '" class="diente'+cl+'">' +
            '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-info">index' + i + '</span>' +
            '<div id="tindex' + i + '" class="cuadro click">' +
            '</div>' +
            '<div id="lindex' + i + '" class="cuadro izquierdo click">' +
            '</div>' +
            '<div id="bindex' + i + '" class="cuadro debajo click">' +
            '</div>' +
            '<div id="rindex' + i + '" class="cuadro derecha click click">' +
            '</div>' +
            '<div id="cindex' + i + '" class="centro click">' +
            '</div>' +
            '</div>';
        //Dientes Definitivos Cuandrante Izquierdo (Superior/Inferior)
        htmlLeft += '<div id="dienteindex' + a + '" class="diente'+cl+'">' +
            '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-info">index' + a + '</span>' +
            '<div id="tindex' + a + '" class="cuadro click">' +
            '</div>' +
            '<div id="lindex' + a + '" class="cuadro izquierdo click">' +
            '</div>' +
            '<div id="bindex' + a + '" class="cuadro debajo click">' +
            '</div>' +
            '<div id="rindex' + a + '" class="cuadro derecha click click">' +
            '</div>' +
            '<div id="cindex' + a + '" class="centro click">' +
            '</div>' +
            '</div>';
        if (i <= 5) {
            //Dientes Temporales Cuandrante Derecho (Superior/Inferior)

            htmlLecheRight += '<div id="dientelecheindex' + i + '" style="left: 20%;" class="diente-leche'+cl+'">' +
                '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-primary">index' + i + '</span>' +
                '<div id="tlecheindex' + i + '" class="cuadro-leche top-leche click">' +
                '</div>' +
                '<div id="llecheindex' + i + '" class="cuadro-leche izquierdo-leche click">' +
                '</div>' +
                '<div id="blecheindex' + i + '" class="cuadro-leche debajo-leche click">' +
                '</div>' +
                '<div id="rlecheindex' + i + '" class="cuadro-leche derecha-leche click click">' +
                '</div>' +
                '<div id="clecheindex' + i + '" class="centro-leche click">' +
                '</div>' +
                '</div>';
        }
        if (a < 6) {
            //Dientes Temporales Cuandrante Izquierdo (Superior/Inferior)
            htmlLecheLeft += '<div id="dientelecheindex' + a + '" class="diente-leche'+cl+'">' +
                '<span style="margin-left: 45px; margin-bottom:5px; display: inline-block !important; border-radius: 10px !important;" class="label label-primary">index' + a + '</span>' +
                '<div id="tlecheindex' + a + '" class="cuadro-leche top-leche click">' +
                '</div>' +
                '<div id="llecheindex' + a + '" class="cuadro-leche izquierdo-leche click">' +
                '</div>' +
                '<div id="blecheindex' + a + '" class="cuadro-leche debajo-leche click">' +
                '</div>' +
                '<div id="rlecheindex' + a + '" class="cuadro-leche derecha-leche click click">' +
                '</div>' +
                '<div id="clecheindex' + a + '" class="centro-leche click">' +
                '</div>' +
                '</div>';
        }
        a++;
    }


    //aqui remplazar por lo que contiene en la vase de datos
    $("#tr").append(replaceAll('index', '1', htmlRight));
    $("#tl").append(replaceAll('index', '2', htmlLeft));
    $("#tlr").append(replaceAll('index', '5', htmlLecheRight));
    $("#tll").append(replaceAll('index', '6', htmlLecheLeft));


    $("#bl").append(replaceAll('index', '3', htmlLeft));
    $("#br").append(replaceAll('index', '4', htmlRight));
    $("#bll").append(replaceAll('index', '7', htmlLecheLeft));
    $("#blr").append(replaceAll('index', '8', htmlLecheRight));
}

var arrayPuente = [];
$(document).ready(function() {

    createOdontogram();
    //funcion para click
    let examdiagnostico=[];
    var status='<?php echo $odontogramstatus; ?>';

    let pieza=[];
    pieza['c']=['Oclusal'];
    pieza['t']='Lingual';
    pieza['b']='Vestibular';
    pieza['l']='Distal';
    pieza['r']='Mesial';
    pieza['c2']='Borde';
    let pieza2=[];
    pieza2['c']=['Oclusal'];
    pieza2['t']='Vestibular';
    pieza2['b']='Paladar';
    pieza2['l']='Distal';
    pieza2['r']='Mesial';
    pieza2['c2']='Borde';

    let matriz=[
      [["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"]],
      [["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"]],
      [["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"]],
      [["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"]],
      [["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"]],
      [["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"]],
      [["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"]],
      [["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"]],
      [["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"],["t","l","c","r","b","f"]]
    ];
    if(status==="true"){
      var stred=`<?php echo $pat['description']; ?>`;
      examdiagnostico=stred.split('\n');
      examdiagnostico.pop();
      //para la matriz
      descript(`<?php echo trim($pat['draw']); ?>`);
      console.log(`<?php echo trim($pat['draw']); ?>`);
    }
    function descript(str){
      //para la matriz
      var dataf=str;
      var arrayd=dataf.split('}');
      for(var i=0;i<arrayd.length-1; i++){
        var fila=arrayd[i].split('[');
        //$fila=explode('[',$ma[$i]);

        var r=Number(fila[0].charAt(1));//1
        var c=Number(fila[0].charAt(2));//8
        var data=fila[1].split(']');
        //var data=explode(']',$fila[1]);
        //data=explode(',',$data[0]);
        data=data[0].split(',');
        matriz[r][c][0]=data[0];//t
        matriz[r][c][1]=data[1];//l
        matriz[r][c][2]=data[2];//c
        matriz[r][c][3]=data[3];//r
        matriz[r][c][4]=data[4];//b
        matriz[r][c][5]=data[5];//f
        //añadir   ...:c[1]=='click-red'||c[1]=='click-blue'||c[1]=='click-yellow'
        var pos='';
        if(r>=5&&r<=8){
          pos='leche';
        }
        if(data[0]=='tcaries'){$('#t'+pos+r+''+c).addClass('click-red');}
        if(data[1]=='lcaries'){$('#l'+pos+r+''+c).addClass('click-red');}
        if(data[2]=='ccaries'){$('#c'+pos+r+''+c).addClass('click-red');}
        if(data[3]=='rcaries'){$('#r'+pos+r+''+c).addClass('click-red');}
        if(data[4]=='bcaries'){$('#b'+pos+r+''+c).addClass('click-red');}
        //obturado
        if(data[0]=='tobturado'){$('#t'+pos+r+''+c).addClass('click-blue');}
        if(data[1]=='lobturado'){$('#l'+pos+r+''+c).addClass('click-blue');}
        if(data[2]=='cobturado'){$('#c'+pos+r+''+c).addClass('click-blue');}
        if(data[3]=='robturado'){$('#r'+pos+r+''+c).addClass('click-blue');}
        if(data[4]=='bobturado'){$('#b'+pos+r+''+c).addClass('click-blue');}


        if(data[5]=='necrosispulpar'){
          $('#diente'+pos+r+''+c).children().each(function(index, el) {
              if ($(el).hasClass("click")) {
                  if($(el).hasClass("click-delete")){
                    $(this).removeClass('click-delete');
                  }else{
                    $(el).addClass('click-delete');
                  }
              }
          });
        }
        if(data[5]=='corona'){
          $('#diente'+pos+r+''+c).children().each(function(index, el) {
              if ($(el).hasClass("click")) {
                if($(el).hasClass("bg-primary")){
                  $(this).removeClass('bg-primary');
                }else{
                  $(el).addClass('bg-primary');
                }
              }
          });
        }
        if(data[5]=='exodonciaindicada'){
          $('#diente'+pos+r+''+c).children().each(function(index, el) {
              if ($(el).hasClass("centro") || $(el).hasClass("centro-leche")) {// fa-fw
                  $(this).parent().append('<i style="color:red;" class="fa fa-times fa-2x"></i>');
                  if ($(el).hasClass("centro")) {
                      //console.log($(this).parent().children("i"))
                      $(this).parent().children("i").css({
                          "position": "absolute",
                          "top": "32%",
                          "left": "2.8ex"
                      });
                  } else {
                      $(this).parent().children("i").css({
                          "position": "absolute",
                          "top": "29%",
                          "left": "2.4ex"
                      });
                  }
              }
          });
        }
        if(data[5]=='sellados'){
          $('#diente'+pos+r+''+c).children().each(function(index, el) {
              if ($(el).hasClass("centro") || $(el).hasClass("centro-leche")) {
                  $(this).parent().append('<i style="color:blue;" class="fa fa-solid fa-bacon fa-2x"></i>');
                  if ($(el).hasClass("centro")) {
                      console.log($(this).parent().children("i"))
                      $(this).parent().children("i").css({
                          "position": "absolute",
                          "top": "31%",
                          "left": "2.2ex"
                      });
                  } else {
                      console.log($(this).parent().children("i"))
                      $(this).parent().children("i").css({
                          "position": "absolute",
                          "top": "28%",
                          "left": "2.1ex"
                      });
                  }
              }
          });
        }
        if(data[5]=='perdidoausente'){
          $('#diente'+pos+r+''+c).children().each(function(index, el) {
              if ($(el).hasClass("centro") || $(el).hasClass("centro-leche")) {
                  $(this).parent().append('<i style="color:blue;" class="fa fa-solid fa-grip-lines fa-2x "></i>');
                  if ($(el).hasClass("centro")) {
                      console.log($(this).parent().children("i"))
                      $(this).parent().children("i").css({
                          "position": "absolute",
                          "top": "31%",
                          "left": "2.5ex"
                      });
                  } else {
                      console.log($(this).parent().children("i"))
                      $(this).parent().children("i").css({
                          "position": "absolute",
                          "top": "30%",
                          "left": "2.1ex"
                      });
                  }
              }
          });
        }
      }
    }

    let type=[];
        type['t']=0;
        type['l']=1;
        type['c']=2;
        type['r']=3;
        type['b']=4;
    function encript(){
      var str='';
      for (var i = 1; i <= 8; i++) {
        for (var j = 1; j <= 8; j++) {
          str+='{'+i+''+j;
          str+='['+matriz[i][j][0]+','+matriz[i][j][1]+','+matriz[i][j][2]+','+matriz[i][j][3]+','+matriz[i][j][4]+','+matriz[i][j][5]+']';
          str+='}';
        }
      }
      $('#draw').val(str);
      //para imprimir
    }
    $(".click").click(function(event) {
        //todo el proceso para controles
        //var control = $("#controls").children().find('.active').attr('id');
        //console.log('inicio');
        var control = $('input:radio[name=options]:checked').parent().attr('id');
        //console.log('fin'+control);
        var cuadro = $(this).find("input[name=cuadro]:hidden").val();
        //mostramos a la consola
        console.log($(this).attr('id'))
        var desc=$(this).attr('id');//que es una X
        var size=desc.length;
        var indx,opdel, isdelete=false, valuearr;
        var optiondelete=['Caries', 'Obturado'];
        var optiondelete2=['Sellados', 'Perdido o Ausente', 'Exodoncia Indicada'];
        switch (control) {
            case "fractura":
            d=desc.substring(size-2);//numero de diente
            p=desc.substring(0,1);//numero de diente
            desc="Pieza "+d+" ";
            i=d.substring(0,1);
            j=d.substring(1);
            abajo=false;
            udt=false;
            if(i=='8' || i=='7' || i=='4' || i=='3')
              abajo=true;
            if(j=='1' || j=='2' || j=='3')
              udt=true;
            if(abajo){
              if(udt && p=='c')
                desc+=pieza['c2'];
              else
                desc+=pieza[p];
            }else{
              if(udt && p=='c')
                desc+=pieza2['c2'];
              else
                desc+=pieza2[p];
            }

            for (var x = 0; x < optiondelete.length; x++) {
              if(optiondelete[x]!='Caries'){
                opdel=desc+' - '+optiondelete[x];
                indx=examdiagnostico.indexOf(opdel);
                if(indx!=-1){
                  console.log(indx+'existe');
                  examdiagnostico.splice(indx, 1);
                }
              }
            }
            desc+=" - Caries";
            indx=examdiagnostico.indexOf(desc);
            if(indx==-1){
              console.log(indx+'no existe');
              examdiagnostico.push(desc);
            }else{
              console.log(indx+'existe');
              examdiagnostico.splice(indx, 1);
            }
            //examdiagnostico.push(desc);
            valuearr=p;
                if ($(this).hasClass("click-blue")) {
                    $(this).removeClass('click-blue');
                    $(this).addClass('click-red');
                    valuearr+='caries';
                } else {
                    if ($(this).hasClass("click-red")) {
                        $(this).removeClass('click-red');
                    } else {
                        $(this).addClass('click-red');
                        valuearr+='caries';
                    }
                }
                matriz[i][j][type[p]]=valuearr//p+'caries';//para guardar
                //para fractura
                encript();
                break;
            case "restauracion":
                d=desc.substring(size-2);//numero de diente
                p=desc.substring(0,1);//numero de diente
                desc="Pieza "+d+" ";
                i=d.substring(0,1);
                j=d.substring(1);
                abajo=false;
                udt=false;
                if(i=='8' || i=='7' || i=='4' || i=='3')
                  abajo=true;
                if(j=='1' || j=='2' || j=='3')
                  udt=true;
                if(abajo){
                  if(udt && p=='c')
                    desc+=pieza['c2'];
                  else
                    desc+=pieza[p];
                }else{
                  if(udt && p=='c')
                    desc+=pieza2['c2'];
                  else
                    desc+=pieza2[p];
                }

                for (var x = 0; x < optiondelete.length; x++) {
                  if(optiondelete[x]!='Obturado'){
                    opdel=desc+' - '+optiondelete[x];
                    indx=examdiagnostico.indexOf(opdel);
                    if(indx!=-1){
                      console.log(indx+'existe');
                      examdiagnostico.splice(indx, 1);
                    }
                  }
                }
                desc+=" - Obturado";
                indx=examdiagnostico.indexOf(desc);
                if(indx==-1){
                  console.log(indx+'no existe');
                  examdiagnostico.push(desc);
                }else{
                  console.log(indx+'existe');
                  examdiagnostico.splice(indx, 1);
                }



                //desc="Diente "+desc+" Tiene Necrosis Pulpar";
                valuearr=p;
                if ($(this).hasClass("click-red")) {
                    $(this).removeClass('click-red');
                    $(this).addClass('click-blue');
                    valuearr+='obturado';
                } else {
                    if ($(this).hasClass("click-blue")) {
                        $(this).removeClass('click-blue');
                    } else {
                        $(this).addClass('click-blue');
                        valuearr+='obturado';
                    }
                }
                matriz[i][j][type[p]]=valuearr;//p+'obturado';//para guardar
                encript();
                break;
            case "extraccion":
                var dientePosition = $(this).position();
                console.log($(this))
                console.log(dientePosition)
                p=desc.substring(0,1);//numero de diente
                desc=desc.substring(size-2);//numero de diente
                i=desc.substring(0,1);
                j=desc.substring(1);
                isdelete=false;

                desc="Pieza "+desc+" - Necrosis Pulpar";

                if(isdelete==false){
                  indx=examdiagnostico.indexOf(desc);
                  if(indx==-1){
                    console.log(indx+'no existe');
                    examdiagnostico.push(desc);
                  }else{
                    console.log(indx+'existe');
                    examdiagnostico.splice(indx, 1);
                  }
                  //examdiagnostico.push(desc);
                }
                //examdiagnostico.push(desc);
                valuearr='f';
                $(this).parent().children().each(function(index, el) {
                    if ($(el).hasClass("click")) {
                        if($(el).hasClass("click-delete")){
                          $(this).removeClass('click-delete');
                        }else{
                          $(el).addClass('click-delete');
                          valuearr='necrosispulpar';;
                        }
                    }
                });
                matriz[i][j][5]=valuearr;//para guardar
                //para diagnostico
                encript();
                break;
            case "corona":
                var dientePosition = $(this).position();
                console.log($(this))
                console.log(dientePosition)
                p=desc.substring(0,1);//numero de diente
                desc=desc.substring(size-2);//numero de diente
                i=desc.substring(0,1);
                j=desc.substring(1);

                isdelete=false;

                desc="Pieza "+desc+" - Corona";
                if(isdelete==false){
                  indx=examdiagnostico.indexOf(desc);
                  if(indx==-1){
                    console.log(indx+'no existe');
                    examdiagnostico.push(desc);
                  }else{
                    console.log(indx+'existe');
                    examdiagnostico.splice(indx, 1);
                  }
                  //examdiagnostico.push(desc);
                }
                //examdiagnostico.push(desc);
                valuearr='f';
                $(this).parent().children().each(function(index, el) {
                    if ($(el).hasClass("click")) {
                      if($(el).hasClass("bg-primary")){
                        $(this).removeClass('bg-primary');
                      }else{
                        $(el).addClass('bg-primary');
                        valuearr='corona';
                      }
                        //$(el).addClass('bg-primary');
                    }
                });
                matriz[i][j][5]=valuearr;//'corona';//para guardar
                encript();
                break;
            case "extraer":
                var dientePosition = $(this).position();
                //console.log($(this));
                console.log(dientePosition)
                //para capturar
                p=desc.substring(0,1);//numero de diente
                desc=desc.substring(size-2);//numero de diente
                i=desc.substring(0,1);
                j=desc.substring(1);

                isdelete=false;
                for (var x = 0; x < optiondelete2.length; x++) {
                  if(optiondelete2[x]!='Exodoncia Indicada'){
                    opdel='Pieza '+desc+' - '+optiondelete2[x];
                    indx=examdiagnostico.indexOf(opdel);
                    if(indx!=-1){
                      isdelete=true;
                      console.log(indx+'existe');
                      examdiagnostico.splice(indx, 1);
                    }
                  }
                }

                desc="Pieza "+desc+" - Exodoncia Indicada";
                if(isdelete==false){
                  indx=examdiagnostico.indexOf(desc);
                  if(indx==-1){
                    console.log(indx+'no existe');
                    examdiagnostico.push(desc);
                  }else{
                    console.log(indx+'existe');
                    examdiagnostico.splice(indx, 1);
                  }
                  //examdiagnostico.push(desc);
                }


                var cont=0;
                $(this).parent().children().each(function(index, el) {
                    console.log(index+"fabian:"+el);
                    cont++;
                });
                console.log('contador: '+cont);
                valuearr='f';
                if(cont>=6){
                  if(cont==6){
                    $(this).parent().children().each(function(index, el) {

                        if ($(el).hasClass("centro") || $(el).hasClass("centro-leche")) {// fa-fw
                            $(this).parent().append('<i style="color:red;" class="fa fa-times fa-2x"></i>');
                            valuearr='exodonciaindicada';
                            if ($(el).hasClass("centro")) {
                                //console.log($(this).parent().children("i"))
                                $(this).parent().children("i").css({
                                    "position": "absolute",

                                    "top": "32%",
                                    "left": "2.8ex"
                                });
                            } else {
                                $(this).parent().children("i").css({
                                    "position": "absolute",
                                    "top": "29%",
                                    "left": "2.4ex"
                                });
                            }
                        }
                    });
                  }else{
                    $(this).parent().children("svg").remove();
                  }
                }

                matriz[i][j][5]=valuearr;//para guardar
                encript();
                break;

            case "sellados":
                var dientePosition = $(this).position();
                console.log($(this))
                console.log(dientePosition)
                p=desc.substring(0,1);//numero de diente
                desc=desc.substring(size-2);//numero de diente
                i=desc.substring(0,1);
                j=desc.substring(1);

                isdelete=false;
                for (var x = 0; x < optiondelete2.length; x++) {
                  if(optiondelete2[x]!='Sellados'){
                    opdel='Pieza '+desc+' - '+optiondelete2[x];
                    indx=examdiagnostico.indexOf(opdel);
                    if(indx!=-1){
                      isdelete=true;
                      console.log(indx+'existe');
                      examdiagnostico.splice(indx, 1);
                    }
                  }
                }
                desc="Pieza "+desc+" - Sellados";

                if(isdelete==false){
                  indx=examdiagnostico.indexOf(desc);
                  if(indx==-1){
                    console.log(indx+'no existe');
                    examdiagnostico.push(desc);
                  }else{
                    console.log(indx+'existe');
                    examdiagnostico.splice(indx, 1);
                  }
                  //examdiagnostico.push(desc);
                }


                var cont=0;
                $(this).parent().children().each(function(index, el) {
                    console.log(index+"fabian:"+el);
                    cont++;
                });
                console.log('contador: '+cont);
                valuearr='f';
                if(cont>=6){
                  if(cont==6){
                    $(this).parent().children().each(function(index, el) {
                        if ($(el).hasClass("centro") || $(el).hasClass("centro-leche")) {
                            $(this).parent().append('<i style="color:blue;" class="fa fa-solid fa-bacon fa-2x"></i>');
                            if ($(el).hasClass("centro")) {
                                valuearr='sellados';
                                console.log($(this).parent().children("i"))

                                $(this).parent().children("i").css({
                                    "position": "absolute",
                                    "top": "31%",
                                    "left": "2.2ex"
                                });
                            } else {
                                console.log("fabain yes");
                                console.log($(this).parent().children("i"))
                                $(this).parent().children("i").css({
                                    "position": "absolute",
                                    "top": "28%",
                                    "left": "2.1ex"
                                });
                            }
                        }
                    });
                  }else{
                    $(this).parent().children("svg").remove();
                  }
                }
                matriz[i][j][5]=valuearr;//'sellados';//para guardar
                encript();
                break;

            case "perdido":
                var dientePosition = $(this).position();
                console.log($(this))
                console.log(dientePosition)
                p=desc.substring(0,1);//numero de diente
                desc=desc.substring(size-2);//numero de diente
                i=desc.substring(0,1);
                j=desc.substring(1);

                isdelete=false;
                for (var x = 0; x < optiondelete2.length; x++) {
                  if(optiondelete2[x]!='Perdido o Ausente'){
                    opdel='Pieza '+desc+' - '+optiondelete2[x];
                    indx=examdiagnostico.indexOf(opdel);
                    if(indx!=-1){
                      isdelete=true;
                      console.log(indx+'existe');
                      examdiagnostico.splice(indx, 1);
                    }
                  }
                }
                desc="Pieza "+desc+" - Perdido o Ausente";
                if(isdelete==false){
                  indx=examdiagnostico.indexOf(desc);
                  if(indx==-1){
                    console.log(indx+'no existe');
                    examdiagnostico.push(desc);
                  }else{
                    console.log(indx+'existe');
                    examdiagnostico.splice(indx, 1);
                  }
                  //examdiagnostico.push(desc);
                }
                //examdiagnostico.push(desc);

                var cont=0;
                $(this).parent().children().each(function(index, el) {
                    console.log(index+"fabian:"+el);
                    cont++;
                });
                console.log('contador: '+cont);
                valuearr='f';
                if(cont>=6){
                  if(cont==6){
                    $(this).parent().children().each(function(index, el) {
                        if ($(el).hasClass("centro") || $(el).hasClass("centro-leche")) {
                            $(this).parent().append('<i style="color:blue;" class="fa fa-solid fa-grip-lines fa-2x "></i>');
                            if ($(el).hasClass("centro")) {
                                valuearr='perdidoausente';
                                console.log($(this).parent().children("i"))

                                $(this).parent().children("i").css({
                                    "position": "absolute",
                                    "top": "31%",
                                    "left": "2.5ex"
                                });
                            } else {
                                console.log("fabain yes");
                                console.log($(this).parent().children("i"))
                                $(this).parent().children("i").css({
                                    "position": "absolute",
                                    "top": "30%",
                                    "left": "2.1ex"
                                });
                            }
                        }
                    });
                  }else{
                    $(this).parent().children("svg").remove();
                  }
                }

                matriz[i][j][5]=valuearr;//'perdidoausente';//para guardar
                encript();
                break;
            //
            case "puente":
                var dientePosition = $(this).offset(), leftPX;
                console.log($(this)[0].offsetLeft)
                var noDiente = $(this).parent().children().first().text();
                var cuadrante = $(this).parent().parent().attr('id');
                var left = 0,
                    width = 0;
                if (arrayPuente.length < 1) {
                    $(this).parent().children('.cuadro').css('border-color', 'red');
                    arrayPuente.push({
                        diente: noDiente,
                        cuadrante: cuadrante,
                        left: $(this)[0].offsetLeft,
                        father: null
                    });
                } else {
                    $(this).parent().children('.cuadro').css('border-color', 'red');
                    arrayPuente.push({
                        diente: noDiente,
                        cuadrante: cuadrante,
                        left: $(this)[0].offsetLeft,
                        father: arrayPuente[0].diente
                    });
                    var diferencia = Math.abs((parseInt(arrayPuente[1].diente) - parseInt(arrayPuente[1].father)));
                    if (diferencia == 1) width = diferencia * 60;
                    else width = diferencia * 50;

                    if(arrayPuente[0].cuadrante == arrayPuente[1].cuadrante) {
                        if(arrayPuente[0].cuadrante == 'tr' || arrayPuente[0].cuadrante == 'tlr' || arrayPuente[0].cuadrante == 'br' || arrayPuente[0].cuadrante == 'blr') {
                            if (arrayPuente[0].diente > arrayPuente[1].diente) {
                                console.log(arrayPuente[0])
                                leftPX = (parseInt(arrayPuente[0].left)+10)+"px";
                            }else {
                                leftPX = (parseInt(arrayPuente[1].left)+10)+"px";
                                //leftPX = "45px";
                            }
                        }else {
                            if (arrayPuente[0].diente < arrayPuente[1].diente) {
                                leftPX = "-45px";
                            }else {
                                leftPX = "45px";
                            }
                        }
                    }
                    console.log(leftPX)
                    /*$(this).parent().append('<div style="z-index: 9999; height: 5px; width:' + width + 'px;" id="puente" class="click-red"></div>');
                    $(this).parent().children().last().css({
                        "position": "absolute",
                        "top": "80px",
                        "left": "50px"
                    });*/
                    $(this).parent().append('<div style="z-index: 9999; height: 5px; width:' + width + 'px;" id="puente" class="click-red"></div>');
                    $(this).parent().children().last().css({
                        "position": "absolute",
                        "top": "80px",
                        "left": leftPX
                    });
                }
                encript();
                break;
            default:
                console.log("borrar case");
        }
        //para imprimir
        //para diagnostico
        var dat="";
        examdiagnostico.forEach(function(elemento, indice, array) {
            //console.log(elemento, indice);
            dat+=elemento+"\n";
        })

        $('#areadiagnostico').val(dat);

        return false;
    });

    //fin click funcion
    return false;

});


</script>
