<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Products;
use yii\helpers\Html;

/**
 * ProductsForm form
 * Muri Budiman
 */

class ProductsForm extends Model
{
    public $myid = 0;
    public $code;
    public $name;
    public $price;
 
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

            ['name', 'required'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'string', 'max' => 255],
            
            ['price', 'required'],
            ['price', 'integer', 'min' => 0],
        ];
    }

    public function validateCode($attribute, $params)
    {
        $find = Products::findOne(['code' => $this->$attribute]);
        if ($find && $find['id'] !== $this->myid) {
            $this->addError($attribute, "Kode Produk [{$this->code}] sudah tidak tersedia");
        }
    }
    
    /**
     * Create.
     *
     * @return Products|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {
        
            $create = new Products;
            $create->code = strtoupper(strip_tags($this->code));
            $create->name = strip_tags($this->name);
            $create->price = $this->price;
            $create->created_at = date('Y-m-d H:i:s');
            $create->updated_at = date('Y-m-d H:i:s');
            $create->user_id = Yii::$app->user->identity->id;
            if ($create->save(false)) {
                 return true;
            }
        }

        return null;
    }

    /**
     * Update.
     *
     * @return Products|null the saved model or null if saving fails
     */
    public function update($id)
    {
        if ($this->validate()) {
            $update = Products::findOne($id);
            $update->code = strtoupper(strip_tags($this->code));
            $update->name = strip_tags($this->name);
            $update->price = $this->price;
            $update->updated_at = date('Y-m-d H:i:s');
            if ($update->save(false)) {
                 return true;
            }
        }
           
        return null;
    }
	
    public function delete($id)
    {

        $delete = Products::findOne($id);
        if($delete)
        {
            return $delete->delete();
        }

        return null;  
    }

    public function getData($id)
    {
        $arrData = [];
        $get = Products::findOne($id);
        if($get)
        {
            $arrData = [
                'id' => $get['id'],
                'code' => $get['code'],
                'name' => $get['name'],
                'price' => $get['price'],
                'status' => $get['status'],
                'created_at' => $get['created_at'],
                'updated_at' => $get['updated_at'],
                'user_id' => $get['user_id'],
            ];
            
            
            return $arrData;
        }
            
        return null;
    }

    public function setStatus($id)
    {
        $set = Products::findOne($id);

        if($set)
        {
            if($set->status == 1)
            {
                $set->status = 0;
            }
            else
            {
                $set->status = 1;
            }
            $set->save(false);
            return $set->status;
        }

        return false;
    }
    
	/**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Kode',
            'name' => 'Nama Roti',
            'Price' => 'Harga',
        ];
    }
	
}
