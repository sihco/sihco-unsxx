<!--contenedor-->

      <!--panel-->
      <div class="panel panel-primary">

          <div class="panel-heading">
              <h3 class="panel-title">Odontograma</h3>
          </div>
          <!--cuerpo del panel-->
              <!--una fila-->
              <div class="row border border-warning">
                <div class="col-lg-2 col-md-2 col-sm-4 col-6">
                  <div class="form-check" id="fractura">
                    <input class="form-check-input" type="radio" name="options" id="options1"  checked>
                    <label class="form-check-label" for="options1">
                      Caries
                    </label>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-6" >
                  <div class="form-check" id="restauracion">
                    <input class="form-check-input" type="radio" name="options" id="options2">
                    <label class="form-check-label" for="options2">
                      Obturados
                    </label>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-6">
                  <div class="form-check" id="sellados">
                    <input class="form-check-input" type="radio" name="options" id="options3">
                    <label class="form-check-label" for="options3">
                      Sellados
                    </label>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-6">
                  <div class="form-check" id="perdido">
                    <input class="form-check-input" type="radio" name="options" id="options4">
                    <label class="form-check-label" for="options4">
                      Extraido o ausente
                    </label>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-6">
                  <div class="form-check" id="extraer">
                    <input class="form-check-input" type="radio" name="options" id="options5">
                    <label class="form-check-label" for="options5">
                      Exodoncia Indicada
                    </label>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-6">
                  <div class="form-check" id="extraccion">
                    <input class="form-check-input" type="radio" name="options" id="options6">
                    <label class="form-check-label" for="options6">
                      Necrosis pulpar
                    </label>
                  </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 col-6">
                  <div class="form-check" id="corona">
                    <input class="form-check-input" type="radio" name="options" id="options7">
                    <label class="form-check-label" for="options7">
                      Coronas
                    </label>
                  </div>
                </div>
              </div>
              <script type="text/javascript">
              function nextFocus(inputF, inputS) {
                document.getElementById(inputF).addEventListener('keydown', function(event) {
                  if (event.keyCode == 13) {
                    document.getElementById(inputS).focus();
                  }
                });
              }
              </script>
              <?php
              if(isset($pat["clinicalid"])&&($pat["clinicalid"]==15||$pat["clinicalid"]==7)){
                echo "<div class=\"row\">".
                "  <div class=\"col-12 col-sm-12 col-md-6 col-xl-6 pl-3\">".
                "<table>".
                "  <tr>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"8\" name=\"tl8\" id=\"tl8\" value=\"".(isset($pat["tl8"])?$pat['tl8']:'')."\" onkeypress=\"nextFocus('tl8', 'tl7')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"7\" name=\"tl7\" id=\"tl7\" value=\"".(isset($pat["tl7"])?$pat['tl7']:'')."\" onkeypress=\"nextFocus('tl7', 'tl6')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"6\" name=\"tl6\" id=\"tl6\" value=\"".(isset($pat["tl6"])?$pat['tl6']:'')."\" onkeypress=\"nextFocus('tl6', 'tl5')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"5\" name=\"tl5\" id=\"tl5\" value=\"".(isset($pat["tl5"])?$pat['tl5']:'')."\" onkeypress=\"nextFocus('tl5', 'tl4')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"4\" name=\"tl4\" id=\"tl4\" value=\"".(isset($pat["tl4"])?$pat['tl4']:'')."\" onkeypress=\"nextFocus('tl4', 'tl3')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"3\" name=\"tl3\" id=\"tl3\" value=\"".(isset($pat["tl3"])?$pat['tl3']:'')."\" onkeypress=\"nextFocus('tl3', 'tl2')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"2\" name=\"tl2\" id=\"tl2\" value=\"".(isset($pat["tl2"])?$pat['tl2']:'')."\" onkeypress=\"nextFocus('tl2', 'tl1')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"1\" name=\"tl1\" id=\"tl1\" value=\"".(isset($pat["tl1"])?$pat['tl1']:'')."\" onkeypress=\"nextFocus('tl1', 'tr8')\"></td>".
                "  </tr>".
                "</table>".
                "  </div>".
                "  <div class=\"col-12 col-sm-12 col-md-6 col-xl-6 pl-3\">".
                "<table>".
                "  <tr>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"1\" name=\"tr8\" id=\"tr8\" value=\"".(isset($pat["tr8"])?$pat['tr8']:'')."\" onkeypress=\"nextFocus('tr8', 'tr7')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"2\" name=\"tr7\" id=\"tr7\" value=\"".(isset($pat["tr7"])?$pat['tr7']:'')."\" onkeypress=\"nextFocus('tr7', 'tr6')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"3\" name=\"tr6\" id=\"tr6\" value=\"".(isset($pat["tr6"])?$pat['tr6']:'')."\" onkeypress=\"nextFocus('tr6', 'tr5')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"4\" name=\"tr5\" id=\"tr5\" value=\"".(isset($pat["tr5"])?$pat['tr5']:'')."\" onkeypress=\"nextFocus('tr5', 'tr4')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"5\" name=\"tr4\" id=\"tr4\" value=\"".(isset($pat["tr4"])?$pat['tr4']:'')."\" onkeypress=\"nextFocus('tr4', 'tr3')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"6\" name=\"tr3\" id=\"tr3\" value=\"".(isset($pat["tr3"])?$pat['tr3']:'')."\" onkeypress=\"nextFocus('tr3', 'tr2')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"7\" name=\"tr2\" id=\"tr2\" value=\"".(isset($pat["tr2"])?$pat['tr2']:'')."\" onkeypress=\"nextFocus('tr2', 'tr1')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"8\" name=\"tr1\" id=\"tr1\" value=\"".(isset($pat["tr1"])?$pat['tr1']:'')."\" onkeypress=\"nextFocus('tr1', 'bl8')\"></td>".
                "  </tr>".
                "</table>".
                "  </div>".
                "</div>";

              }
              ?>
              <div class="row">
                <div id="tr" class="col-12 col-sm-12 col-md-6 col-lg-6">
                </div>
                <div id="tl" class="col-12 col-sm-12 col-md-6 col-lg-6">
                </div>
                <div id="tlr" class="col-12 col-sm-12 col-md-6 col-lg-6 text-right">
                </div>
                <div id="tll" class="col-12 col-sm-12 col-md-6 col-lg-6">
                </div>
              </div>
              <!--CERRAMOS UN FILA-->
              <div class="row">
                  <div id="blr" class="col-12 col-sm-12 col-md-6 col-lg-6 text-right">
                  </div>
                  <div id="bll" class="col-12 col-sm-12 col-md-6 col-lg-6">
                  </div>
                  <div id="br" class="col-12 col-sm-12 col-md-6 col-lg-6">
                  </div>
                  <div id="bl" class="col-12 col-sm-12 col-md-6 col-lg-6">
                  </div>
              </div>
              <?php
              if(isset($pat["clinicalid"])&&($pat["clinicalid"]==15||$pat["clinicalid"]==7)){
                echo "<div class=\"row\">".
                "  <div class=\"col-12 col-sm-12 col-md-6 col-xl-6 pl-3\">".
                "<table>".
                "  <tr>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"8\" name=\"bl8\" id=\"bl8\" value=\"".(isset($pat["bl8"])?$pat['bl8']:'')."\" onkeypress=\"nextFocus('bl8', 'bl7')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"7\" name=\"bl7\" id=\"bl7\" value=\"".(isset($pat["bl7"])?$pat['bl7']:'')."\" onkeypress=\"nextFocus('bl7', 'bl6')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"6\" name=\"bl6\" id=\"bl6\" value=\"".(isset($pat["bl6"])?$pat['bl6']:'')."\" onkeypress=\"nextFocus('bl6', 'bl5')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"5\" name=\"bl5\" id=\"bl5\" value=\"".(isset($pat["bl5"])?$pat['bl5']:'')."\" onkeypress=\"nextFocus('bl5', 'bl4')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"4\" name=\"bl4\" id=\"bl4\" value=\"".(isset($pat["bl4"])?$pat['bl4']:'')."\" onkeypress=\"nextFocus('bl4', 'bl3')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"3\" name=\"bl3\" id=\"bl3\" value=\"".(isset($pat["bl3"])?$pat['bl3']:'')."\" onkeypress=\"nextFocus('bl3', 'bl2')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"2\" name=\"bl2\" id=\"bl2\" value=\"".(isset($pat["bl2"])?$pat['bl2']:'')."\" onkeypress=\"nextFocus('bl2', 'bl1')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"1\" name=\"bl1\" id=\"bl1\" value=\"".(isset($pat["bl1"])?$pat['bl1']:'')."\" onkeypress=\"nextFocus('bl1', 'br8')\"></td>".
                "  </tr>".
                "</table>".
                "  </div>".
                "  <div class=\"col-12 col-sm-12 col-md-6 col-xl-6 pl-3\">".
                "<table>".
                "  <tr>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"1\" name=\"br8\" id=\"br8\" value=\"".(isset($pat["br8"])?$pat['br8']:'')."\" onkeypress=\"nextFocus('br8', 'br7')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"2\" name=\"br7\" id=\"br7\" value=\"".(isset($pat["br7"])?$pat['br7']:'')."\" onkeypress=\"nextFocus('br7', 'br6')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"3\" name=\"br6\" id=\"br6\" value=\"".(isset($pat["br6"])?$pat['br6']:'')."\" onkeypress=\"nextFocus('br6', 'br5')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"4\" name=\"br5\" id=\"br5\" value=\"".(isset($pat["br5"])?$pat['br5']:'')."\" onkeypress=\"nextFocus('br5', 'br4')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"5\" name=\"br4\" id=\"br4\" value=\"".(isset($pat["br4"])?$pat['br4']:'')."\" onkeypress=\"nextFocus('br4', 'br3')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"6\" name=\"br3\" id=\"br3\" value=\"".(isset($pat["br3"])?$pat['br3']:'')."\" onkeypress=\"nextFocus('br3', 'br2')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"7\" name=\"br2\" id=\"br2\" value=\"".(isset($pat["br2"])?$pat['br2']:'')."\" onkeypress=\"nextFocus('br2', 'br1')\"></td>".
                "  <td><input type=\"text\" class=\"form-control\" placeholder=\"8\" name=\"br1\" id=\"br1\" value=\"".(isset($pat["br1"])?$pat['br1']:'')."\"></td>".
                "  </tr>".
                "</table>".
                "  </div>".
                "</div>";

              }
              ?>
              <div class="container">
                <!--INICIAMOS OTRA FILA-->
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                      <div style="height: 20px; width:20px; display:inline-block;" class="click-red"></div> = Fractura/Caries
                      <br>
                      <div style="height: 20px; width:20px; display:inline-block;" class="click-blue"></div> = Obturado

                      <br> Sellados = <i style="color:blue;" class="fa fa-solid fa-bacon fa-2x fa-fw"></i>

                      <br> Extraido o Ausente = <i style="color:blue;" class="fa fa-solid fa-grip-lines fa-2x fa-fw"></i>
                      <br>
                      <span style="display:inline:block;"> Necrosis pulpar</span> = <img style="display:inline:block;" src="../images/extraccion.png">
                      <br>
                      <span style="display:inline:block;"> Coronas</span> = <img style="display:inline:block;" src="../images/pieza/corona.png">

                      <br> Exodoncia Indicada = <i style="color:red;" class="fa fa-times fa-2x"></i>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">

                        <textarea id="areadiagnostico" class="form-control border border-primary"  name="areadiagnostico" rows="7" readonly onmousedown="return false;"><?php if(isset($pat["description"])) echo $pat["description"];  ?></textarea>

                    </div>


                </div>
              </div>



              <!--CERRAMOS OTRA FILA-->

      </div>
