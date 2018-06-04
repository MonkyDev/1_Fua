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

        <div class="form-group col-md-4">
          <label>Periodo captura</label>
          <select class="form-control"  id="tres" name="tres">
            <option value="">-- Seleccione --</option>
            <option value="1"> Enero / Junio </option>
            <option value="2"> Julio / Diciembre </option>
          </select>
        </div>

        <div class="form-group col-md-4">
          <label>Año captura</label>
          <input class="form-control" onkeyup="trun('dos',4,1)" id="dos" name="dos" value="<?= date('Y')?>" required />
        </div>

        <div class="form-group col-md-4">
          <label>Registros de</label>
          <select class="form-control"  id="cuatro" name="cuatro">
            <option value="">-- Seleccione --</option>                  
            <option value="1"> Universiadas </option>                  
            <option value="2"> Entrenamientos </option>                  
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
  var perio =  document.getElementById('tres').value;
  var status =  document.getElementById('cuatro').value;
  string = perio+"X"+anio+"X"+status;

  if (perio !="" && anio !="") {
    window.location = "../../reportes/listatriny/"+string;
  }
}
</script>