<?php
/* @var $this MatriculaController */
/* @var $model Matricula */
?>

<?php
/*
$this->breadcrumbs=array(
	'Matriculas'=>array('index'),
	$model->mat_id=>array('view','id'=>$model->mat_id),
	'Update',
);
*/
?>
<div class="row">
	<div class="span12 text-center">
		<h2>Actualizando a : <?php echo $model->matAlu->alum_nombres." ".$model->matAlu->alum_apepat; ?></h2>
	</div>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,
											'alumno'=>$alumno,
											'region'=>$region,
											'genero'=>$genero,
											'estado'=>$estado,
											'ciudad'=>$ciudad,
											'religion' => $religion,
											'comuna'=>$comuna,
											'trans' => $trans,
											'otro' => $otro,
										    'vivienda' => $vivienda,
    										'constru' => $constru,
								            'baño_tipo' => $baño_tipo,
								            'nivel_edu' => $nivel_edu,
											'vive_con'	=> $vive_con,
											'otro_vive'	=> $otro_vive,

											)); ?>
