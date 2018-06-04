<?php 
if ( isset($dis) && isset($alu)) :
?>
<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><font color="#009688">Datos del registro</font></h3>
        </div>


      <form class="form_crear_par" action="<?= $helper->url($ctl, $acc, ID_DEFECTO)?>" method="POST"> 
        <input type="hidden" name="rndUnk" value="<?=$rndUnk?>">
        
        <div class="box-body">

        <input type="hidden" id="cuatro" name="cuatro" value="<?= $alu?>">
        
        <div class="form-group col-md-4">
          <label>Año de participación</label>
          <input class="form-control" onkeyup="trun('dos',4,1)" id="dos" name="dos" value="<?= date('Y')?>" required />
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
          <input type="hidden" value="1"  id="tres" name="tres" />
        </div>

      </div>

        <div class="box-footer text-right" id="action">
          <a class="btn btn-success exe" href="#"  id="_sav" title="Guardar"><b>Guardar</a>
          <input type="hidden" id="showNoty" value="null">
        </div>

      </form>
    </div>
  </div>
</div>
<?php else: echo 'No ay registros de disciplinas, agregue una...'; endif; ?>