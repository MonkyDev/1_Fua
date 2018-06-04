<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">

<?php 
switch ($load) {
	case 1: /*busqueda del alumno*/
		$c1 = $this->secure->randing(20)."x";
		$c2 = "x".$this->secure->randing(20);
		if ( count($datas) == 1 ) {
			$row = $datas[0] ;				
				if ($row->foto == "")
					$foto = "N/T"; 
				else 
   					$foto = "<img class='img-responsive' src='http://".$_SERVER['HTTP_HOST'].'/sia/'.(string)$row->foto."' width='50'/>";

        echo "<div class='box'><div class='box-body'><table class='table col-md-12'>
	      				<thead class='text-center'>
	                <tr>
	                  <th>Foto</th>	                  
	                  <th>Matricula</th>	                  
	                  <th>Nombre</th>	                  
	                  <th>Cursa</th>	                  
	                  <th>Estatus</th>	                  
	                  <th>Acción</th>  	                                                        
	                </tr>
	              </thead>
              	<tbody>        				
		              <tr>
		                <td>".$foto."</td>
		                <td>".$row->matricula."</td>
		                <td>".ucwords($row->NombreCompleto)."</td>
		                <td>".ucwords($row->grado)."°</td>
		                <td>".ucwords($row->tipo_ingreso)."</td>
		                <td class='text-center'>
			                <a href='".$helper->url($ctl, $acc, $c1.$row->id_alu.$c2)."'>
												<div class='btn-group btn-group-xs'>
													<button class='btn btn-success' title='Registrar entrenamiento'>Registrar entrenamiento</button>
												</div>
			                </a>
		                </td>
		              </tr>
		            </tbody>
            	</table></div></div>";

		} else {

				echo "<div class='box'><div class='box-body'><table class='table table-striped TableAdvanced'>
								<thead class='text-center'>
                  <tr>
                    <th>Foto</th>
                    <th>Matricula</th>
                    <th>Nombre</th>
                    <th>Cursa</th>
                    <th>Estatus</th>
                    <th>Acción</th>                                      
                  </tr>
                </thead>
                <tbody>";
				$max = 1;
				foreach($datas AS $row) { 
					$c1 = $this->secure->randing(20)."x";
					$c2 = "x".$this->secure->randing(20);
					/*if ($max <= 25) {} por la sobrecarga de datos*/
         	if ($row->foto == "") 
       			$foto = "N/T"; 
       		else 
       			$foto = "<img class='img-responsive' src='http://".$_SERVER['HTTP_HOST'].'/sia/'.(string)$row->foto."' width='50'/>";
          		echo "
								<tr>
								  <td>".$foto."</td>
								  <td>".$row->matricula."</td>
								  <td>".ucwords($row->NombreCompleto)."</td>
								  <td>".ucwords($row->grado)."°</td>
								  <td>".ucwords($row->tipo_ingreso)."</td>
								  <td class='text-center'>
		                <a href='".$helper->url($ctl, $acc, $c1.$row->id_alu.$c2)."'>
											<div class='btn-group btn-group-xs'>
												<button class='btn btn-success' title='Registrar entrenamiento'>Registrar entrenamiento</button>
											</div>
		                </a>
	                </td>
								</tr>";                 
        }
        echo "</tbody></table></div></div>";
		}
			
		break;

	default :
   echo "No se encontraron resultados...";
}

?>
</div>
</div>
</section>
