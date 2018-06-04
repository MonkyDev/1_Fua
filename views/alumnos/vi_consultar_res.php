<section class="content">
  <div class="row">
    <div class="col-md-12 col-xs-12">
      <div class="box box-default">

      	<div class="box-header with-border">
		     	<h3 class="box-title">Resultados de la busqueda...</h3>
		    </div>

		   	<div class="box-body">
		   		
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

        echo "
        			<table class='table'>
	      				<thead>
	                <tr>
	                  <th>Foto</th>	                  
	                  <th>Matricula</th>	                  
	                  <th>Nombre</th>	                  
	                  <th>Estatus</th>	                  
	                  <th>Acción</th>  	                                                        
	                </tr>
	              </thead>
              	<tbody>        				
		              <tr>
		                 <td>".$foto."</td>
		                 <td>".$row->matricula."</td>
		                 <td>".ucwords($row->NombreCompleto)."</td>
		                 <td>".ucwords($row->tipo_ingreso)."</td>
		                 <td class='text-center'>
		                 	<a href='".$helper->url($ctl, $acc, $c1.$row->id_alu.$c2)."'>
		                 	<div class='btn-group btn-group-xs'>		                 	
	                 		<button class='btn btn-warning' title='ver'>&nbsp;&nbsp;&nbsp;ver&nbsp;&nbsp;&nbsp;</button></div>
	                 		</a>
	                 	 </td>
		              </tr>
		            </tbody>
            	</table>
             ";

		} else {

				echo "
							<table class='table table-striped TableAdvanced'>
								<thead>
                  <tr>
                    <th>Foto</th>
                    <th>Matricula</th>
                    <th>Nombre</th>
                    <th>Estatus</th>
                    <th>Acción</th>                                      
                  </tr>
                </thead>
                <tbody>
             ";
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
								  <td>".ucwords($row->tipo_ingreso)."</td>
								  <td class='text-center'>
								  	<a href='".$helper->url($ctl, $acc, $c1.$row->id_alu.$c2)."'>
										<div class='btn-group btn-group-xs'>		                 	
	                 	<button class='btn btn-warning' title='ver'>&nbsp;&nbsp;&nbsp;ver&nbsp;&nbsp;&nbsp;</button></div>
	                 	</a>
	                </td>
								  </td>
								</tr>";                 
        }
      echo "</tbody></table>";
		}
			
		break;

	default :
   echo "No se encontraron resultados...";
}

?>

</div>
</div>
</div>
</div>
</section>