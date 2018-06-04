<?php 
if ( isset($uni) AND !is_bool($uni) ) :
$ObjQuery = new ModeloBase('', $this->adapter);
?>

<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Registros</h3>
        </div>

        <div class="box-body">
          <table class='table table-striped TableAdvanced'>
            <thead>
              <tr>
                <th>#</th>
                <th>matricula</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Grupo</th>
                <th>Ciclo</th>
                <th>Acción</th>                                      
              </tr>
            </thead>
            <tbody>
              <?php
               
                if ( is_array($uni) == false ) :
                  $row = $uni[0];
                  $c1 = $this->secure->randing(20)."x";
                  $c2 = "x".$this->secure->randing(20);              
                  echo '
                    <tr>
                      <td>1</td>
                      <td>'.$row->matricula.'</td>
                      <td>'.ucwords($row->nomb_alumno).'</td>
                      <td>'.$row->nomb_carrera.'</td>
                      <td>'.$row->nomb_grupo.'</td>
                      <td>'.$this->ObjFmTxt->LetrasCiclo($row->desc_ciclo).'</td>
                      <td class="text-center">
                        <a href="'.$helper->url($ctl, $acc, $c1.$row->id_par.$c2).'">
                        <div class="btn-group btn-group-xs">                     
                      <button class="btn btn-danger" title="llenar fua">ver fua</button></div>
                        </a>
                      </td>
                    </tr>
                  ';
                else:
                  $i=0;
                  foreach ($uni as $row) {

                    $c1 = $this->secure->randing(20)."x";
                    $c2 = "x".$this->secure->randing(20);              
                    echo '
                      <tr>
                        <td>'.(++$i).'</td>
                        <td>'.$row->matricula.'</td>
                        <td>'.ucwords($row->nomb_alumno).'</td>
                        <td>'.$row->nomb_carrera.'</td>
                        <td>'.$row->nomb_grupo.'</td>
                        <td>'.$this->ObjFmTxt->LetrasCiclo($row->desc_ciclo).'</td>
                        <td class="text-center">
                          <a href="'.$helper->url($ctl, $acc, $c1.$row->id_par.$c2).'">
                          <div class="btn-group btn-group-xs">                     
                        <button class="btn btn-danger" title="llenar fua">ver fua</button></div>
                          </a>
                        </td>
                      </tr>
                    ';
                  }         
                endif;
              ?>
              
            </tbody>
          </table>
        </div>    
      </div>
    </div> 


    <div class="col-md-12">
      <div class="box box-default">

        <div class="box-header with-border">
          <h3 class="box-title"><font color="#009688">Reportes</font></h3>
        </div>

        <form class="search">

        <div class="box-body">

          <!-- <div class="form-group col-md-4">
            <label>Periodo captura</label>
            <select class="form-control"  id="periodo">
              <option value="">-- Seleccione --</option>
              <option value="1"> Enero / Junio </option>
              <option value="2"> Julio / Diciembre </option>
            </select>
          </div> -->

          <div class="form-group col-md-4">
            <label>Año</label>
            <input class="form-control" onkeyup="trun('anio',4,1)" id="anio" value="<?= date('Y')?>" required />
          </div>

          <div class="form-group col-md-4">
            <label>Disciplina</label>
            <select class="form-control"  id="disciplina">
              <option value="">-- Seleccione --</option>                  
              <option value="99"> General</option>                  
              <?php
              foreach ($dis as $di) {
                echo '<option value="'.$di->id.'">'.$di->descripcion.'</option>';
              }
              ?>               
            </select>
          </div>       
       
      </div>
      <div class="box-footer">
        <button class="btn btn-danger" type="button" title="imprimir reporte" onclick="pdf()">Generar</button>
      </div>

        </form>


      </div>
      </div>


  </div>
</section>

<?php else: /*CUANDO NO AY DATOS EN LA TABLA*/?>

<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Registros</h3>
        </div>

        <div class="box-body">
          <table class='table table-striped TableAdvanced'>
            <thead>
              <tr>
                <th>#</th>
                <th>matricula</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Grupo</th>
                <th>Ciclo</th>
                <th>Acción</th>                                      
              </tr>
            </thead>
          </table>             
        </div>    
      </div>
    </div>  
  </div>
</section>

<?php endif; ?>

<script>
function pdf(){
  var anio =  document.getElementById('anio').value;
  var id_dis =  document.getElementById('disciplina').value;
  string = id_dis+"X"+anio;
  if (anio != "")
    window.location = "../../reportes/imprimir/"+string;
}
</script>