

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.css">
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.js"></script>


<div class="row">
  <div class="span12">

	<?php 
    if( Yii::app()->user->checkAccess('admin')) $nombre = "admin"; ?>
        <h4>Cursos de: <?php if( $nombre )echo $nombre; ?></h4>

<?php  
    
    if(empty( $cur )){
        echo "Usted no tiene cursos en  este año.";
    }else{
        echo CHtml::dropDownList('cur_id','cur_id',$cur ,array('empty' => '-Seleccione Curso-',
                                                                'id'=> 'drop_curso',
                                                               'name' => 'drop_curso')); 
    }?>

	<div class="row">
		<div class="span10 offset3">
		  	<div id="lista" hidden>

		  	</div>
		</div>
	</div>
     


	</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#drop_curso').change( function() {

            $.ajax({
                    url: '<?php echo CController::createUrl("listacurso/lista_curso")?>',
                    type: "POST", 
                    data: {id: $(this).val() },
                    success: function(response) { 
                       $('#lista').html(response); 
                       $('#lista').show();


                       
                    }
            })
        })
    });
 

</script>