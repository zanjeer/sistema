<?php

class InformeDesarrolloController extends Controller
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
				'actions'=>array('index','view','listaConcepto','inf_d','view_inf', 'menu'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','listaConcepto','inf_d','view_inf', 'menu'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','listaConcepto','inf_d','view_inf', 'menu'),
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

	public function actionMenu(){
        $this->render('menu');
    }


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new InformeDesarrollo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['InformeDesarrollo']))
		{
			$model->attributes=$_POST['InformeDesarrollo'];
			$model->id_descripcion = mb_strtoupper($model->id_descripcion,'utf-8');
			if($model->save()){
				//$this->redirect(array('view','id'=>$model->id_id));
				if(isset($model->id_id)){
					$id_informe = $model->id_id;
					$this->redirect(array('//area/nuevo','id'=>$id_informe));

				}else throw new CHttpException(404,'The requested page does not exist.');
			}
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

		if(isset($_POST['InformeDesarrollo']))
		{
			$model->attributes=$_POST['InformeDesarrollo'];
			$model->id_descripcion = mb_strtoupper($model->id_descripcion,'utf-8');
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_id));
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
		$dataProvider=new CActiveDataProvider('InformeDesarrollo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new InformeDesarrollo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['InformeDesarrollo']))
			$model->attributes=$_GET['InformeDesarrollo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return InformeDesarrollo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=InformeDesarrollo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param InformeDesarrollo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='informe-desarrollo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionListaConcepto(){
		$con = new Concepto;

		if(isset($_POST['id'])){
			$id_area = $_POST['id'];
			$concepto = CHtml::listData(Concepto::model()->findAll(array('condition'=>'con_area="'.$id_area.'"')),'con_id','con_descripcion');
			
			$this->renderPartial('conceptos',array('concepto'=>$concepto,'con'=>$con));
		}else{
			throw new CHttpException(404,'La consulta no existe.');
		}
	}

	public function actionInf_d(){
		$model=new InformeDesarrollo;

		$this->render('inf_d',array('model'=>$model));
	}

	public function actionView_inf($id){
		$informe = implode(CHtml::listData(InformeDesarrollo::model()->findAll(array('condition'=>'id_id="'.$id.'"')),'id_id','id_descripcion'));

		$area = Area::model()->findAll(array('condition'=>'are_infd="'.$id.'"'));
		$concepto = Concepto::model()->findAll();

		$this->render('view_inf',array('id'=>$id,'area'=>$area,'concepto'=>$concepto,'informe'=>$informe));
	}
}
