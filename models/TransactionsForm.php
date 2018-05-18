<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Products;
use app\models\Transactions;
use yii\helpers\Html;

/**
 * TransactionsForm form
 * Muri Budiman
 */

class TransactionsForm extends Model
{
    public $code;
    public $qty;
    private $create;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [		

            ['code', 'required'],
            ['code', 'filter', 'filter' => 'trim'],
            ['code', 'string', 'max' => 150],
            ['code', 'validateCode'],
            
            ['qty', 'required'],
            ['qty', 'integer', 'min' => 1],
        ];
    }

    public function validateCode($attribute, $params)
    {
        $find = $this->checkCode($this->$attribute);
        if (!$find) {
            $this->addError($attribute, "Kode Produk [{$this->code}] tidak tersedia");
        }
    }
    
    /**
     * Create.
     *
     * @return Transactions|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {
            $pro = $find = $this->checkCode($this->code);
            $create = new Transactions;
            $create->code = strtoupper(strip_tags($this->code));
            $create->price = $pro['price'];
            $create->qty = $this->qty;
            $create->created_at = date('Y-m-d H:i:s');
            $create->updated_at = date('Y-m-d H:i:s');
            $create->user_id = Yii::$app->user->identity->id;
            if ($create->save(false)) {
                $data = $this->getTransaction($create->id);
                $this->setCreate($data);
                return true;
            }
        }

        return null;
    }

	
    public function delete($id)
    {

        $delete = Transactions::findOne($id);
        if($delete)
        {
            return $delete->delete();
        }

        return null;  
    }

    
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Kode',
            'qty' => 'Jumlah',
        ];
    }
    
    private function checkCode($code = '') {
        $model = Products::findOne(['code' => $code]);
        return $model;
    }
    
    private function getTransaction($id = 0) {
        //$model = Transactions::findOne(['id' => $id]);
        
        $query = (new \yii\db\Query())
                ->select([
                    't.id',
                    't.code',
                    'p.name',
                    't.price',
                    't.qty',
                ])
                ->from('transactions t')
                ->leftJoin('products p', 't.code = p.code')
                ->where(['t.id' => $id])
                ->one();
        
        return $query;
    }
    
    public function setCreate($create) {
        $this->create = $create;
    }
    
    public function getCreate() {
        return $this->create;
    }

}
