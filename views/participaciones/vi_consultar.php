<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">

      <div class="box box-default">

      	<div class="box-header with-border">
		     	<h3 class="box-title">Buscar alumno para entrenamiento</h3>
		    </div>

	    	<form class="search" action="<?= $helper->url($ctl, $acc, ID_DEFECTO)?>" method="POST" role="form">
       		<div class="box-body">
            <div class="form-group col-md-8 col-md-offset-2">
               <label>Matricula / Apellidos</label>
               <input class="form-control" onkeyup="trun('src',255,5)" id="src" name="ipt_search" required autofocus>
						</div> 
					</div>
          <div class="box-footer text-center">
            <button class="btn btn-primary" type="submit" title="Consultar">Consultar</button>
          </div>
        </form>

      </div>  

		</div>
	</div>
</section>