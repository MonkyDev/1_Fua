<?php
if ( isset($materias) && isset($alumno)) :
?>
<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">

      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title"><font color="#009688">Datos del registro</font></h3>
        </div>

      <form class="form_crear" action="<?= $helper->url($ctl, $acc, ID_DEFECTO)?>" method="POST"> 
        <input type="hidden" name="rndUnk" value="<?=$rndUnk?>">
        <div class="box-body">

        <input type="hidden" id="tres" name="tres" value="<?= $id_ciclo_back?>">
        <input type="hidden" id="cuatro" name="cuatro" value="<?= $alumno[0]->id?>">

        <?php $i=1; $ix=[NULL,"A","B","C","D","E","F","G","H","I","J","K","L","M"];
        foreach ($materias as $mat) { ?>
          <div class="form-group col-md-4"> 
            <label><?= ucwords($mat->nomb_mat)?></label>
            <input class="form-control" onkeyup="clf('dos_<?= $ix[$i]?>',2,1)" id="dos_<?= $ix[$i]?>" name="dos_<?= $ix[$i]?>" required />
            <input type="hidden" onkeyup="trun('cinco_<?= $ix[$i]?>',2,1)" id="cinco_<?= $ix[$i]?>" name="cinco_<?= $ix[$i]?>" value="<?= $mat->id_mat?>"/>
          </div>
        <?php
          $i++;
        }
        ?>
        </div>
        <div class="box-footer" id="make">
          <a class="btn btn-primary exe" href="#" id="_new" title="Nuevo"><i class="fa fa-plus fa-md"></i></a>
        </div>
        <div class="box-footer text-right" id="action" style="display: none;">
          <a class="btn btn-success exe" href="#"  id="_sav" title="Guardar"><b>Guardar</b></a>
        </div>
      </form>
      </div>
    </div>
  </div>
</section>
<?php else: die("No se pudo cargar la vista, por falta de complementos..."); endif; ?>