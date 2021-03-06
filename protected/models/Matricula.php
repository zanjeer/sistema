<?php

/**
 * This is the model class for table "matricula".
 *
 * The followings are the available columns in table 'matricula':
 * @property integer $mat_id
 * @property integer $mat_ano
 * @property string $mat_numero
 * @property string $mat_fingreso
 * @property string $mat_fretiro
 * @property string $mat_fcambio
 * @property integer $mat_asistencia_1
 * @property integer $mat_asistencia_2
 * @property integer $mat_asistencia_3
 * @property integer $mat_alu_id
 * @property integer $mat_estado
 *
 * The followings are the available model relations:
 * @property Evaluacion[] $evaluacions
 * @property Parametro $matEstado
 * @property Alumno $matAlu
 * @property Notas[] $notases
 * @property ProMat[] $proMats
 */
class Matricula extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'matricula';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $alumno_nombres;
	public $alumno_apepat;
	public $alumno_apemat;
	public $estado;


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mat_fingreso','required','message'=>'Debe registrar una fecha de ingreso'),
			array('mat_ano, mat_asistencia_1, mat_asistencia_2, mat_asistencia_3, mat_alu_id, mat_estado', 'numerical', 'integerOnly'=>true),
			array('mat_numero', 'length', 'max'=>11),
			array('mat_fingreso, mat_fretiro, mat_fcambio, mat_desc', 'safe'),
			array('alumno_nombres, mat_documentos, mat_otros_doc','safe'),
			array('alumno_apepat','safe'),
			array('alumno_apemat','safe'),
			array('estado','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('mat_id, mat_ano, mat_numero, mat_fingreso, mat_fretiro, mat_fcambio, mat_asistencia_1, 
				mat_asistencia_2, mat_asistencia_3, mat_alu_id, mat_estado', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'evaluacions' => array(self::HAS_MANY, 'Evaluacion', 'eva_matricula'),
			'matEstado' => array(self::BELONGS_TO, 'Parametro', 'mat_estado'),
			'matAlu' => array(self::BELONGS_TO, 'Alumno', 'mat_alu_id'),
			'notases' => array(self::HAS_MANY, 'Notas', 'not_mat'),
			'proMats' => array(self::HAS_MANY, 'ProMat', 'PRO_MATRI'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'mat_id' => 'ID',
			'mat_ano' => 'Ano',
			'mat_numero' => 'Numero Matricula',
			'mat_fingreso' => 'Fecha Ingreso',
			'mat_fretiro' => 'Fecha Retiro',
			'mat_fcambio' => 'Fecha Cambio',
			'mat_asistencia_1' => 'Asistencia 1',
			'mat_asistencia_2' => 'Asistencia 2',
			'mat_asistencia_3' => 'Asistencia 3',
			'mat_alu_id' => 'Alumno',
			'mat_estado' => 'Estado',
			'mat_documentos' => 'Documentos Recibidos',
			'mat_desc' 	=> 'Observacion',
			'mat_otros_doc'	=> 'Documentos Recibidos (Voluntariamente)',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('mat_id',$this->mat_id);
		$criteria->compare('mat_ano',$this->mat_ano);
		$criteria->compare('mat_numero',$this->mat_numero,true);
		$criteria->compare('mat_fingreso',$this->mat_fingreso,true);
		$criteria->compare('mat_fretiro',$this->mat_fretiro,true);
		$criteria->compare('mat_fcambio',$this->mat_fcambio,true);
		$criteria->compare('mat_asistencia_1',$this->mat_asistencia_1);
		$criteria->compare('mat_asistencia_2',$this->mat_asistencia_2);
		$criteria->compare('mat_asistencia_3',$this->mat_asistencia_3);
		$criteria->compare('mat_alu_id',$this->mat_alu_id);
		$criteria->compare('mat_estado',$this->mat_estado);
		$criteria->with = array('matAlu','matEstado');
        $criteria->addSearchCondition('matAlu.alum_nombres', $this->alumno_nombres);
        $criteria->addSearchCondition('matAlu.alum_apepat', $this->alumno_apepat);
        $criteria->addSearchCondition('matAlu.alum_apemat', $this->alumno_apemat);
        $criteria->addSearchCondition('matEstado.par_descripcion', $this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function buscar($ano)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('mat_ano',$ano);
		$criteria->compare('mat_id',$this->mat_id);
		$criteria->compare('mat_ano',$this->mat_ano);
		$criteria->compare('mat_numero',$this->mat_numero,true);
		$criteria->compare('mat_fingreso',$this->mat_fingreso,true);
		$criteria->compare('mat_fretiro',$this->mat_fretiro,true);
		$criteria->compare('mat_fcambio',$this->mat_fcambio,true);
		$criteria->compare('mat_asistencia_1',$this->mat_asistencia_1);
		$criteria->compare('mat_asistencia_2',$this->mat_asistencia_2);
		$criteria->compare('mat_asistencia_3',$this->mat_asistencia_3);
		$criteria->compare('mat_alu_id',$this->mat_alu_id);
		$criteria->compare('mat_estado',$this->mat_estado);
		$criteria->with = array('matAlu','matEstado');
        $criteria->addSearchCondition('matAlu.alum_nombres', $this->alumno_nombres);
        $criteria->addSearchCondition('matAlu.alum_apepat', $this->alumno_apepat);
        $criteria->addSearchCondition('matAlu.alum_apemat', $this->alumno_apemat);
        $criteria->addSearchCondition('matEstado.par_descripcion', $this->estado);

		return new CActiveDataProvider($this, array(
			 'pagination' => array(
		             'pageSize' => 35,
		        ),
			'criteria'=>$criteria,
		));
	}

	public function activo($estado,$ano)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('mat_ano',$ano);
		$criteria->compare('mat_id',$this->mat_id);
		$criteria->compare('mat_ano',$this->mat_ano);
		$criteria->compare('mat_numero',$this->mat_numero,true);
		$criteria->compare('mat_fingreso',$this->mat_fingreso,true);
		$criteria->compare('mat_fretiro',$this->mat_fretiro,true);
		$criteria->compare('mat_fcambio',$this->mat_fcambio,true);
		$criteria->compare('mat_asistencia_1',$this->mat_asistencia_1);
		$criteria->compare('mat_asistencia_2',$this->mat_asistencia_2);
		$criteria->compare('mat_asistencia_3',$this->mat_asistencia_3);
		$criteria->compare('mat_alu_id',$this->mat_alu_id);
		$criteria->compare('mat_estado',$estado);
		$criteria->with = array('matAlu','matEstado');
        $criteria->addSearchCondition('matAlu.alum_nombres', $this->alumno_nombres);
        $criteria->addSearchCondition('matAlu.alum_apepat', $this->alumno_apepat);
        $criteria->addSearchCondition('matAlu.alum_apemat', $this->alumno_apemat);
        $criteria->addSearchCondition('matEstado.par_descripcion', $this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Matricula the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function validateText($attribute, $params) {
    $pattern = '/^([a-zA-ZñÑÁÉÍÓÚáéíóú]+([[:space:]]{0,2}[a-zA-ZñÑÉÍÓÚáéíóú]+)*)$/';
        if($this->$attribute!=""){
	        if (!preg_match($pattern, $this->$attribute))
	            $this->addError($attribute,$params['message']);
    	}
	}

    public function validateText2($attribute, $params) {
        $pattern = '/^([a-zA-ZñÑÁÉÍÓÚáéíóú0-9º°\.\,\'\"\)\(\-\@\:\/\+]+([[:space:]]{0,2}[a-zA-ZñÑÁÉÍÓÚáéíóú0-9º°\.\,\'\"\)\(\-\@\:\/\+]+)*)$/';
        $pattern2 = '/^([0-9º°\.\,\'\"\)\(\-\@\:\/\+]+)$/';
        if($this->$attribute!=""){
	        if (!preg_match($pattern, $this->$attribute))
	            $this->addError($attribute, $attribute.': Se deben ingresar letras o letras y números, verifique que no tenga espacios al final o en medio.');
	        if (preg_match($pattern2, $this->$attribute))
	            $this->addError($attribute, $attribute.': Error No puede ser solo números o caracteres especiales');
    	}
    }
    public function validateText3($attribute, $params) {
        $pattern2 = '/(a{3}|e{3}|i{4}|o{3}|u{3}|b{3}|c{3}|d{3}|f{3}|g{3}|h{3}|j{3}|k{3}|l{4}|m{3}|n{3}|ñ{3}|p{3}|q{3}|r{3}|s{3}|t{3}|v{3}|w{4}|x{3}|y{3}|z{3}|º{2}|°{2}|\.{2}|\'{2}|\"{2}|\){2}|\({2}|\,{2}|\-{2}|\@{2}|\:{2}|\/{3}|\+{2})/i';
        $pattern3 = '/(A{3}|E{3}|I{4}|O{3}|U{3}|B{3}|C{3}|D{3}|F{3}|G{3}|H{3}|J{3}|K{3}|L{4}|M{3}|N{3}|Ñ{3}|P{3}|Q{3}|R{3}|S{3}|T{3}|V{3}|W{4}|X{3}|Y{3}|Z{3})/i';
        $pattern4 = '/(á{3}|Á{3}|é{3}|É{3}|í{3}|Í{3}|ó{3}|Ó{3}|ú{3}|Ú{3})/i';
        $pattern5 = '/([0-9]{13})/i';
        if($this->$attribute!=""){
	        if (preg_match($pattern2, $this->$attribute) OR preg_match($pattern3, $this->$attribute) OR preg_match($pattern4, $this->$attribute))
	            $this->addError($attribute, $attribute.': Verifique que no este repetidos continuamente los caracteres');
	        if (preg_match($pattern5, $this->$attribute))
	            $this->addError($attribute, $attribute.': No puede haber un número superior a 9999999999999');
    	}
    }
    public function validateFechaNacimiento($attribute, $params) {
    	if($this->$attribute!=""){
			if(strtotime($this->$attribute) && 1 === preg_match('~[0-9]~', $this->$attribute)){
			    $date1 = new DateTime(date('Y-m-d'));
				$date2 = new DateTime($this->$attribute);
				$interval = $date1->diff($date2);
				if(($interval->y) < 3){
				    $this->addError($attribute,'Fecha de Nacimiento: Solo se pueden ingresar mayores de 3 Años');
				}
			}else{
				$this->addError($attribute,'Fecha de Nacimiento: Ingrese una fecha valida');
			}
	    }
    }
    public function validateRut($attribute, $params) {
	 	$rut = str_split($this->$attribute);
	 	$array_rut = array();
	    for($i=0; $i< strlen($this->$attribute); $i++) {
	    	if($rut[$i]!='.'){
	    	  $array_rut[]=$rut[$i];
			}
	    }

	    $rut_attribute = implode("", $array_rut);
        if (strpos($rut_attribute, "-") == false) {
            $data[0] = substr($rut_attribute, 0, -1);
            $data[1] = substr($rut_attribute, -1);
        } else {
            $data = explode('-', $rut_attribute);
        }
        $evaluate = strrev(str_replace(".", "", trim($data[0])));
        $multiply = 2;
        $store = 0;
        for ($i = 0; $i < strlen($evaluate); $i++) {
            $store += $evaluate[$i] * $multiply;
            $multiply++;
            if ($multiply > 7)
                $multiply = 2;
        }
        isset($data[1]) ? $verifyCode = strtolower($data[1]) : $verifyCode = '';
        $result = 11 - ($store % 11);
        if ($result == 10)
            $result = 'k';
        if ($result == 11)
            $result = 0;
        if ($verifyCode != $result)
            $this->addError($attribute,'El Rut ingresado no es valido');
    }
    public function validateRutCaracter($attribute, $params) {
    	$rut = str_split($this->$attribute);
    	$array_rut = array();
	    for($i=0; $i< strlen($this->$attribute); $i++) {
	    	if($rut[$i]!='.'){
	    	  $array_rut[]=$rut[$i];
			}
	    }
	    $rut_attribute = implode("", $array_rut);
        $pattern = '/^([0-9.]+\-+[0-9kK]{1}+)$/';
        $pattern2 = '/^([0-9.]{1}+\-+[0-9kK]{1}+)$/';
        $pattern3 = '/^([0.]+\-+[0-9kK]{1}+)$/';
        if (!preg_match($pattern, $rut_attribute) OR preg_match($pattern2, $rut_attribute) OR preg_match($pattern3, $rut_attribute))
            $this->addError($attribute, 'El Rut ingresado no es valido');
    }
}
