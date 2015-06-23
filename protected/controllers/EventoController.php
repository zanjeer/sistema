<?php

class EventoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
   {
      return array(array('CrugeAccessControlFilter'));
   }

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Evento;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Evento']))
		{
			$model->attributes=$_POST['Evento'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->eve_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Evento']))
		{
			$model->attributes=$_POST['Evento'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->eve_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Evento');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Evento('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Evento']))
			$model->attributes=$_GET['Evento'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Evento the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Evento::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Evento $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='evento-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionCalendario(){
		if(Usuario::model()->findAll(array('condition'=>'usu_iduser="'.Yii::app()->user->id.'"'))){
			$this->render('calendario');

		}else{
			Yii::app()->user->setFlash('error', "Usted no tiene calendario!");
			$this->redirect(array('Site/index'));
		}
		
	}

	public function actionInsertar(){
		if(isset($_POST['title']) AND isset($_POST['start']) AND isset($_POST['end'])){
			$titulo = $_POST['title'];
			$inicio = $_POST['start'];
			$fin = $_POST['end'];
			$usuario  = Usuario::model()->findAll(array('condition'=>'usu_iduser="'.Yii::app()->user->id.'"'));
			$id_usuario = $usuario[0]->usu_id;

			$model=new Evento;
			$model->eve_descripcion = $titulo;
			$model->eve_inicio = $inicio;
			$model->eve_fin = $fin;
			$model->eve_usuario = $id_usuario;

			$model->save();

		}else throw new CHttpException(404,'The requested page does not exist.');
	}

	public function actionEventos(){
		$usuario  = Usuario::model()->findAll(array('condition'=>'usu_iduser="'.Yii::app()->user->id.'"'));
		$id_usuario = $usuario[0]->usu_id;

		$con = Evento::model()->findAll(array('condition'=>'eve_usuario="'.$id_usuario.'"'));

		$evento = array();
		foreach ($con as $key) {
			$aux = array();
			$aux['title'] = $key->eve_descripcion;
			$aux['start'] = $key->eve_inicio;
			$aux['end'] = $key->eve_fin;

			array_push($evento, $aux);
		}

		echo json_encode($evento);
    	exit();
	}

	public function actionEliminar(){
		$usuario  = Usuario::model()->findAll(array('condition'=>'usu_iduser="'.Yii::app()->user->id.'"'));
		$id_usuario = $usuario[0]->usu_id;

		if(isset($_POST['title'])){
			$titulo = $_POST['title'];
			
			if(Evento::model()->findAll(array('condition'=>'eve_descripcion="'.$titulo.'" AND eve_usuario="'.$id_usuario.'"'))){
				$evento = Evento::model()->findByAttributes(array('eve_descripcion'=>$titulo,'eve_usuario'=>$id_usuario));
				$evento->delete();

			}else throw new CHttpException(404,'No puede eliminar este evento.');

		}else throw new CHttpException(404,'The requested page does not exist.');
	}
}
