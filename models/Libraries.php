<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "libraries".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $opening_time
 * @property string|null $closing_time
 * @property string|null $created_on
 *
 * @property Books[] $books
 */
class Libraries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libraries';
    }

    public function beforeSave($insert) {
        if ($insert) {
            $this->created_on = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['opening_time', 'closing_time', 'created_on'], 'safe'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'opening_time' => 'Opening Time',
            'closing_time' => 'Closing Time',
            'created_on' => 'Created On',
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Books::className(), ['library_id' => 'id']);
    }
}