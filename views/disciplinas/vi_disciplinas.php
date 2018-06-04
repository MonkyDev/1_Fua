<?php 
if ( !is_bool($prm) && !is_null($prm)):
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
                <th>Deporte</th>
                <th>Entrenador</th>
                <th>Lugar entrenamiento</th>
                <th>Horario</th>
                <th>Acción</th>                                      
              </tr>
            </thead>
            <tbody>
              <?php 
                foreach ($prm as $row) {
                  $c1 = $this->secure->randing(20)."x";
                  $c2 = "x".$this->secure->randing(20);              
                  echo '
                    <tr>
                      <td>'.ucwords($row->descripcion).'</td>
                      <td>'.ucwords($row->entrenador).'</td>
                      <td>'.ucwords($row->lugar).'</td>
                      <td>'.ucwords($row->horario).'</td>
                      <td class="text-center">
                        <a href="'.$helper->url($ctl, $acc, $c1.$row->id.$c2).'">
                        <div class="btn-group btn-group-xs">                     
                      <button class="btn btn-warning" title="editar">&nbsp;&nbsp;&nbsp;editar&nbsp;&nbsp;&nbsp;</button></div>
                        </a>
                      </td>
                    </tr>
                  ';
                }         
              ?>
              
            </tbody>
          </table>
        </div>    
        <div class="box-footer">
          <div class="btn-group">
            <a class="btn btn-primary" href="<?=$helper->url($ctl, 'crear', ID_DEFECTO)?>" title="Nuevo registro">
              <b>Nuevo</b>
            </a>
          </div>
        </div>

      </div>
    </div>  
  </div>
</section>

<?php 
else:
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
                <th>Deporte</th>
                <th>Entrenador</th>
                <th>Lugar entrenamiento</th>
                <th>Horario</th>
                <th>Acción</th>                                      
              </tr>
            </thead>
          </table>
        </div>    
        <div class="box-footer">
          <div class="btn-group">
            <a class="btn btn-primary" href="<?=$helper->url($ctl, 'crear', ID_DEFECTO)?>" title="Nuevo registro">
              <b>Nuevo</b>
            </a>
          </div>
        </div>

      </div>
    </div>  
  </div>
</section>


<?php 
endif;
?>