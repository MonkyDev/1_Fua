<?php
if ( isset($prm) ) {
?>
<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><font color="#009688">Datos del registro</font></h3>
        </div>

      <form class="form_crear_dis" action="<?= $helper->url($ctl, $acc, ID_DEFECTO)?>" method="POST"> 
        <input type="hidden" name="rndUnk" value="<?= $rndUnk?>">
        <div class="box-body">

        <div class="form-group col-md-6">
          <label>Descripción</label>
          <input class="form-control" onkeyup="trun('dos',255,4)" id="dos" name="dos" required />
        </div>

        <div class="form-group col-md-6">
          <label>Nombre del entrenador</label>
          <input class="form-control" onkeyup="trun('tres',255,4)" id="tres" name="tres" required />
        </div>

        <div class="form-group col-md-6">
          <label>Horario de entrenamiento</label>
          <input class="form-control" onkeyup="trun('cuatro',25,5)" id="cuatro" name="cuatro" required />
        </div>

        <div class="form-group col-md-6">
          <label>Lugar de entrenamiento</label>
          <input class="form-control" onkeyup="trun('cinco',255,4)" id="cinco" name="cinco" required />
        </div>

        <div class="box-footer text-right" id="action">
          <a class="btn btn-success exe" href="#"  id="_sav" title="Guardar"><b>Guardar</b></a>
          <input type="hidden" id="showNoty" value="null">
        </div>
        
      </form>

    </div>
  </div>
</section>


<?php  if($notify) {?>
<script>
  function noty(){
      document.getElementById('showNoty').click();
  }
  window.onload = noty;
</script>
<?php unset($notify); } }?>