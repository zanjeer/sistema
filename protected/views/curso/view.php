

<?php
/* @var $this CursoController */
/* @var $model Curso */

$this->breadcrumbs=array(
	'Cursos'=>array('index'),
	$model->cur_id,
);

$this->menu=array(
	array('label'=>'List Curso', 'url'=>array('index')),
	array('label'=>'Create Curso', 'url'=>array('create')),
	array('label'=>'Update Curso', 'url'=>array('update', 'id'=>$model->cur_id)),
	array('label'=>'Delete Curso', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cur_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Curso', 'url'=>array('admin')),
);


$asignatura = Asignatura::model()->findAll();
?>
<div class="row">
    <div class="span12">
        <h1>Ver Curso #<?php echo $model->cur_nivel ," ", $model->cur_letra; ?></h1>
    </div>
</div>
<div class="row">
    <div class="span12">
    <?php $this->widget('zii.widgets.CDetailView', array(
    	'data'=>$model,
    	'attributes'=>array(
    		'cur_id',
    		'cur_ano',
    		'cur_nivel',
    		'cur_jornada',
    		'cur_letra',
    		'cur_pjefe',
    		'cur_infd',
    		'cur_tperiodo',
    		'cur_notas_periodo',
    	),
    )); ?>
    </div>
</div>
<div class="row">
    <div class="span10">
        <h4>Asignaturas Inscritas</h4>
    </div>
    <div class="span2">
        <?php echo TbHtml::button('Agregar',array(
                                        'color'=> TbHtml::ALERT_COLOR_SUCCESS, 
                                        'style' => 'float: right',
                                        'id' =>'agregar',
                                        'data-toggle' => 'modal',
                                        'data-target' => '#cambio_modal',
                                        /*'ajax' =>
                                            array('type'=>'POST',
                                                'url'=>$this->createUrl('curso/bcxn'),
                                                //'update'=>'#ajax_op',
                                                'data'=>array('id'=>'js:getId','nombre'=>'js:getNombre()'),
                                                //'success'=> 'function(){location.reload();}'
                                            )*/
            ))?>

    </div>
</div>
<div class="row">
    <div class="span12">
    <?php $this->widget('bootstrap.widgets.TbGridView', array(
        'type' => TbHtml::GRID_TYPE_CONDENSED,
       'dataProvider' => $asig,
       //'filter' => $model,
       'template' => "{items}",
       'columns' => array(
            array(
                'name' => 'asi_id',
                'header' => '#',
                'htmlOptions' => array('color' =>'width: 60px'),
            ),
            array(
                'name' => 'asi_descripcion',
                'header' => 'Nombre Asignatura',
            ),
            array(
                'name' => 'asi_nombrecorto',
                'header' => 'Nombre Corto',
            ),
        ),
    )); ?>



         <!-- Asignar Asignatura !-->
         <?php $this->widget('bootstrap.widgets.TbModal', array(
                'id' => 'cambio_modal',
                'header' => '<h4>Asignar Asignatura</h4>',
                'content' => '<div id="cambio">  </div>',
                'htmlOptions' => array ('url' => Yii::app()->user->ui->getProfileUrl()),
                'footer' => array(
                        TbHtml::linkButton('Asignar',  array('data-dismiss' => 'modal', 'color' => TbHtml::BUTTON_COLOR_SUCCESS, 'url' =>'#','onclick' => '$("#aasignatura-form").submit()')),
                        TbHtml::button('Cancelar', array('data-dismiss' => 'modal',)),

                ),
        )); ?>    
    </div>     
</div>
<script >
$("#agregar").click(function(){
            $.ajax({
                type:  'POST',
                url: "<?php echo Yii::app()->createUrl('//aasignatura/create'); ?>" ,
                data: { 'id_curso': <?php echo $model->cur_id ?> },
                success: function(result){ 
                    $("#cambio").html(result)}
            });
})

</script>
