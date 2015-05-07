<div class="row">
	<div class="span12 text-center">
		<h2>Certificado de Alumno Regular</h2>
	</div>
	<div class="span12 text-center">
		<p class="text-info">Aqui se puede generar un <strong>Certificado de Alumno Regular</strong> para cualquier <strong>Alumno</strong> seleccionado</p>
		<br>
	</div>
</div>


<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'usuario-grid',
	'type' => TbHtml::GRID_TYPE_BORDERED,
	'dataProvider'=>$matricula->search(),
	'filter'=>$matricula,
	'columns'=>array(
		array(
			'header'=>'Rut',
			'value'=>'$data->matAlu->alum_rut',
		),
		array(
			'header'=>'Nombres',
			'value'=>'$data->matAlu->alum_nombres',
		),
		array(
			'header'=>'Apellido Paterno',
			'value'=>'$data->matAlu->alum_apepat',
		),
		array(
			'header'=>'Apellido Materno',
			'value'=>'$data->matAlu->alum_apemat',
		),
		array(
			'header'=>'Curso',
			'type'=>'raw',
			'value'=>array($this,'obtenerCurso'),
		),
		array(
			'name'=>'mat_estado',
			'type'=>'raw',
			'value'=>array($this,'gridEstado'),
			'filter'=>CHtml::listData(Parametro::model()->findAll(array('condition'=>'par_item="ESTADO"')),'par_id','par_descripcion'),
			'htmlOptions'=>array('style'=>'text-align:center'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{certificado}',
			'buttons'=>array(
				'certificado'=>array(
					'label'=>'<i class="icon-list-alt"></i>',
					'url'=>'Yii::app()->createUrl("Matricula/certificado",array("id"=>$data->mat_id))',
					'options'=>array(
						'class'=>"btn btn-info",
						'data-toggle'=>'tooltip',
						'title'=>'Certificado',

					),
				),
			),
		),
	),
)); ?>