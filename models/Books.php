<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property int|null $library_id
 * @property int|null $author_id
 * @property string|null $title
 * @property string|null $published_at
 * @property string|null $language
 * @property string|null $created_on
 *
 * @property Authors $author
 * @property Libraries $library
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
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
            [['library_id', 'author_id'], 'integer'],
            [['published_at', 'created_on'], 'safe'],
            [['title'], 'string', 'max' => 200],
            [['language'], 'string', 'max' => 100],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::className(), 'targetAttribute' => ['author_id' => 'id']],
            [['library_id'], 'exist', 'skipOnError' => true, 'targetClass' => Libraries::className(), 'targetAttribute' => ['library_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'library_id' => 'Library ID',
            'author_id' => 'Author ID',
            'title' => 'Title',
            'published_at' => 'Published At',
            'language' => 'Language',
            'created_on' => 'Created On',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Library]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibrary()
    {
        return $this->hasOne(Libraries::className(), ['id' => 'library_id']);
    }
}