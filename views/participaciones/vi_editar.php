<?php
if ( isset($prm) ) {
  $row = $prm;
?>
<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><font color="#009688">Datos del registro</font></h3>
        </div>

     <form class="form_crear" action="<?= $helper->url($ctl, $acc, $_GET['id'])?>" method="POST"> 
      <div class="box-body">

        <input type="hidden" id="cuatro" name="cuatro" value="<?= $row->fk_alumno?>">
        
        <div class="form-group col-md-4">
          <label>Año de participación</label>
          <input class="form-control" onkeyup="trun('dos',4,1)" id="dos" name="dos" value="<?= $row->anio?>" required />
        </div>

        <div class="form-group col-md-4">
          <label>Ciclo Escolar</label>
            <select class="SelectAdvanced" style="width: 100%" id="seis" name="seis">
              <optgroup label="Buscar en Ciclos">
                <option value="">-- Seleccione --</option>
                <?=$ciclos?>
              </optgroup>        
            </select>
        </div>

        <div class="form-group col-md-4">
          <label>Disciplina</label>
          <select class="form-control"  id="cinco" name="cinco">
            <option value="">-- Seleccione --</option>                  
            <?php
            foreach ($dis as $di) {
              echo '<option value="'.$di->id.'">'.$di->descripcion.'</option>';
            }
            ?>               
          </select>
        </div>        

        <div class="form-group col-md-4">
          <label>Participa en</label>
          <select class="form-control" id="tres" name="tres">
            <option value="">-- Seleccione --</option>                  
            <option value="1"> Universiada</option>                  
            <option value="2"> Entrenamiento </option>                  
          </select>
        </div>

      </div>

        <div class="box-footer" id="make">
            <a class="btn btn-primary exe" href="#" id="_new" title="Nuevo"><i class="fa fa-plus fa-md"></i></a>
            <a class="btn btn-danger exe" href="#" id="_del" title="Eliminar"><i class="fa fa-minus fa-md"></i></a> 
            <input type="hidden" value="<?= $helper->url($ctl, "eliminar", $_GET['id'])?>"  id="_bam" name="_bam" />
        </div>
        <div class="box-footer text-right" id="action" style="display: none;">
          <a class="btn btn-success exe" href="#"  id="_sav" title="Guardar"><b>Guardar</b></a>
          <a class="btn btn-default exe" href="#" id="_cnc" title="Cancelar"><b>Cancelar</b></a>
          <input type="hidden" id="showNoty" value="null">
        </div>
      
      </form>

    </div>
  </div>
</section>
<script>
  document.getElementById("cinco").value = <?= $row->fk_disciplina?>;
  document.getElementById("seis").value = <?= $row->fk_ciclo?>;
  document.getElementById("tres").value = <?= $row->edo?>;
</script>
<?php } ?>