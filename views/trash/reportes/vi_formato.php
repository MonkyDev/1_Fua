<?php 
if ( isset($dis) ) :
?>
<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><font color="#009688">Datos del reporte</font></h3>
        </div>

      <form class="search">
        <div class="box-body">

        <div class="form-group col-md-6">
          <label>Año de participación</label>
          <input class="form-control" onkeyup="trun('dos',4,1)" id="dos" name="dos" value="<?= date('Y')?>" required />
        </div>

        <div class="form-group col-md-6">
          <label>Disciplina</label>
          <select class="form-control"  id="tres" name="tres">
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
          <a class="btn btn-danger " href="#" onclick="pdf()"  title="imprimir reporte"><i class="fa fa-file-pdf-o fa-md"></i></a>
      </div>

      </form>
      


    </div>
  </div>
</div>
<?php endif; ?>
<script>
function pdf(){
  var anio = document.getElementById('dos').value;
  var id_dis =  document.getElementById('tres').value;
  string = id_dis+"X"+anio;
  if (anio !="" && id_dis !="" ) {
    window.location = "../../reportes/imprimir/"+string;
  }
}
</script>