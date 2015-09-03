<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/konami.js"></script>

<?php
/* @var $this SiteController */
$nombre = 'admin';
$modelo_usuario = Usuario::model()->findByAttributes(array('usu_iduser' => Yii::app()->user->id));
if ($modelo_usuario) {
    $nombre = "" . $modelo_usuario->usu_nombre1 . " " . $modelo_usuario->usu_apepat;
}


$this->pageTitle=Yii::app()->name;
?>

<div class="row">
	<div class="span12">

		<div class="span8"><h3 class="text-center">Noticias</h3>
			<br>
			<?php $this->actionVer(); ?>
		</div>

		<br><br>
		<br><br>

		<div class="span3 text-center hidden-phone">
			

			<?php echo CHtml::link('Mis Eventos',array('Evento/calendario'),array('class'=>'btn btn-success btn-block'));?>

			<br>

			<!-- Descomentar el boton para ver la funcionalidad de apoderados -->
			<?php echo CHtml::link('Ver Notas Apoderado',array('Apoderado/notas'),array('class'=>'btn btn-warning btn-block'));?>
		</div>
	</div>

</div>

<script type="text/javascript">
var easter_egg = new Konami(function() { 
	swal({   title: "Felicidades!!",   text: "Has descubierto el codigo konami, ahora a bailar!",   imageUrl: "http://gifdanceparty.giphy.com/dancers/pumpgirl.gif" });
});
</script>