<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sweet-alert.css">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/sweet-alert.min.js"></script>

<?php
/* @var $this CursoController */
/* @var $model Curso */
/*
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
*/
?>


<div class="row">
    <div class="span12 text-center">
        <h2><?php echo $niv ," ", $letra ?></h2>
    </div>
</div>
<div class="row">
    <div class="span8 offset2 text-center">
    <table class="table table-bordered table-hover" width="100%">
        <tr>
            <td width="50%" style="background-color: #5EB59A"><p class="text-right"><strong>Nivel</strong></p></td>
            <td width="50%"><p><?php echo $model->curNivel->par_descripcion;?></p></td>
        </tr>
        <tr>
            <td width="50%" style="background-color: #5EB59A"><p class="text-right"><strong>Letra</strong></p></td>
            <td width="50%"><p><?php echo $model->curLetra->par_descripcion;?></p></td>
        </tr>
        <tr>
            <td width="50%" style="background-color: #5EB59A"><p class="text-right"><strong>Jornada</strong></p></td>
            <td width="50%"><p><?php echo $model->curJornada->par_descripcion;?></p></td>
        </tr>
        <tr>
            <td width="50%" style="background-color: #5EB59A"><p class="text-right"><strong>Profesor Jefe</strong></p></td>
            <td width="50%"><p><?php echo $model->curPjefe->getNombrecorto();?></p></td>
        </tr>
     
        <tr>
            <td width="50%" style="background-color: #5EB59A"><p class="text-right"><strong>Notas por Periodo</strong></p></td>
            <td width="50%"><p><?php echo $model->cur_notas_periodo?></p></td>
        </tr>
          <tr>
            <td width="50%" style="background-color: #5EB59A"><p class="text-right"><strong>Numero Alumnos</strong></p></td>
            <td width="50%"><p><?php echo $num?></p></td>
        </tr>
    </table>
    </div>
</div>

<div class="row">
    <div class="span10 offset1">

        <h4 style="float: left; padding-right: 2px;">Asignaturas Inscritas </h4>

        <?php if( Yii::app()->user->isSuperAdmin  OR
                   Yii::app()->user->checkAccess('administrador')
        ){ ?>
        <?php echo TbHtml::button('', array('color'=>TbHtml::BUTTON_COLOR_WARNING, 
                                            'icon' => 'icon-refresh',
                                            'id' => 'refresh',
                                            )); ?>
        <?php } ?>
    </div>
   
</div>
<div class="row">
    <div class="span10 offset1">


    <table class="table table-striped">
      <thead>
        <tr>
          <th></th>
          <th>Asignatura</th>
          <th>Docente</th>
          <th>  </th>
        </tr>
      </thead>
      <tbody>
        <?php for ($i=0; $i <count($asignacion) ; $i++) { 
                    $nombre_doc = $prof[$asignacion[$i]->aa_docente];
                    $nombre_asi = $asignatura[$asignacion[$i]->aa_asignatura];
                    $id_asignacion = $asignacion[$i]->aa_id; 
        ?>
            <tr id="<?php echo $id_asignacion; ?>">
              <td><i class="icon-book"></i></td>
              <td><?php echo $nombre_asi;?> </td>
              <td><?php echo CHtml::link($nombre_doc,CController::createUrl('//usuario/view',array('id'=> $asignacion[$i]->aa_docente)),array('class'=>'link-negro'));?> </td>
              <?php if( $num == 0 ){ ?>
                <td>
                    <div class="text-center">
                        <button class="btn btn-danger elim"  title="Eliminar" id="<?php echo $id_asignacion; ?>">
                            <i  style="cursor:pointer; cursor:hand" 
                                class = 'icon-remove' 
                               > 
                            </i>
                        </button>
                    </div>
                </td>
                <?php } ?>
            </tr>
        <?php } ?>
      </tbody>
    </table>


        <div class="text-center">
                <?php echo TbHtml::button('Asignar Asignatura', array('submit' => array('//AAsignatura/create'), 
                                                                'color'=>TbHtml::BUTTON_COLOR_SUCCESS, )); ?>
        </div>

<br><br><br>
    </div>     
</div>



<script>

    $('.elim').on('click',function(){
            id = $(this).attr('id');
            swal({  title: "Estas seguro?",   
                text: "Estas Borrando una asignatura!",  
                type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   
                confirmButtonText: "Si, Borrar!",   closeOnConfirm: true }, 
                function(){ 
                        $.ajax({
                            type:'POST',
                            url: '<?php echo Yii::app()->createUrl("//AAsignatura/borrar_ajax"); ?>',
                            data: {id: id },
                            success: function(){
                                tr = "#"+id;
                                $(tr).empty();
                            } 
                        });  
                }
            );
    });



    

</script>

<script type="text/javascript">
    $('#refresh').on('click', function(){
        swal({  
            title: "Actualizar Matriculas",   
            text: "Se agregaran asignaturas nuevas y conceptos del informe personalidad en caso  de faltar!",  
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Actualizar!",   
            closeOnConfirm: false,
        }, 
            function(){ 
                    swal({   
                        title: "Cargando!",     
                        type: "info",   
                        showConfirmButton: false,
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                    });
                    $.ajax({
                        url: '<?php echo CController::createUrl("matricula/Refresh_curso")?>',
                        type: 'POST',
                        data: {id_curso: <?php echo $model->cur_id; ?> },
                        success: function(data){        
                            swal({   
                                title: "Actualizado!",     
                                timer: 600,
                                type: "success",   
                                showConfirmButton: false 
                            });
                        }
                    })
            }
        );
        
        
    });


 
</script>