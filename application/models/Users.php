<?php

namespace application\models;

use application\models\validators\UsersValidator;
use engine\classes\Model;
use engine\Debug;

class Users extends Model
{
    protected $id;
    protected $email;
    protected $phone;
    protected $avatar;
    protected $create_date;
    protected $update_date;
    protected $password;
    protected $confirm_password;
    protected $agreement;
    protected $table = 'users';

    protected $profile;
    
    public function __construct()
    {
        parent::__construct();
        $this->validator = new UsersValidator($this);
    }

    public function create()
    {
        if ($this->validate()) {
            return $this->save();
        }
        return false;
    }

    public function save()
    {
        $sql = 'INSERT INTO ' . $this->table . '(email, phone, password, avatar) VALUES(:email, :phone, :password, :avatar)';
        $this->connection->pdo->beginTransaction();
        try {
            $this->beforeSave();

            $password = password_hash($this->password, PASSWORD_DEFAULT);
            
            $statement = $this->connection->pdo->prepare($sql);
            $statement->bindParam(':email', $this->email, \PDO::PARAM_STR);
            $statement->bindParam(':phone', $this->phone, \PDO::PARAM_STR);
            $statement->bindParam(':password', $password, \PDO::PARAM_STR);
            $statement->bindParam(':avatar', $this->avatar, \PDO::PARAM_STR);
            $statement->execute();

            $this->id = $this->connection->pdo->lastInsertId();

            $this->afterSave();

            $this->connection->pdo->commit();
        } catch (\PDOException $e) {
            $this->connection->pdo->rollBack();
            Debug::logToFile($e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        } catch (\Exception $e) {
            $this->connection->pdo->rollBack();
            Debug::logToFile($e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
        return true;
    }
    
    protected function beforeSave()
    {
        $finfo = finfo_open( FILEINFO_MIME_TYPE );
        $mime_type = finfo_file( $finfo, $this->avatar['tmp_name']['avatar'] );

        $size = getimagesize($this->avatar['tmp_name']['avatar']);
        $balans = $size[0] / $size[1];

        if($size[0] < $size[1]){
            $new_height = $size[1] > 500 ? 500 : $size[1];
            $new_width = round($new_height * $balans);
            if($new_width > 1000){
                $new_width = 1000;
                $new_height = round($new_width / $balans);
            }
        }
        elseif($size[0] > $size[1]){
            $new_width = $size[0] > 1000 ? 1000 : $size[0];
            $new_height = round($new_width / $balans);
            if($new_height > 500){
                $new_height = 500;
                $new_width = round($new_height * $balans);
            }
        }
        else{
            $new_width = $size[0] > 500 ? 500 : $size[0];
            $new_height = $new_width;
        }
        switch($mime_type){
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                break;
            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                break;
            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                break;
        }

        $_new_name = uniqid('avatar_') . '.jpg';
        $fileName = realpath('') . '/uploads/' . $_new_name;

        $image_c = imagecreatetruecolor($new_width, $new_height);

        $new_image = $image_create_func($this->avatar['tmp_name']['avatar']);

        imagecopyresampled($image_c, $new_image, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
        if(imagejpeg($image_c, $fileName)){
            $this->avatar = $_new_name;
        } else {
            throw new \PDOException('can not save avatar');
        }

    }

    protected function afterSave()
    {
        $profile = new UserProfile();
        $profilePost = $_POST['Profile'];
        $profile->fullname = $profilePost['fullname'];
        $profile->user_id = $this->id;
        
        if (!$profile->validate()) {
            foreach ($profile->errors as $attr => $error) {
                $this->addError($attr, $error);
            }
            throw new \Exception("Profile validate error");
        } else {
            $profile->save();
        }
    }

    public function getProfile()
    {
        if ($this->profile === null) {
            $profileModel = new UserProfile();
            $this->profile = $profileModel->find('*', 'user_id=:user_id', [':user_id' => ['value' => $this->id, 'type' => \PDO::PARAM_INT]])->one();
        }
        return $this->profile;
    }
}