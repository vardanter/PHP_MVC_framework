<?php

namespace application\models;

use application\models\validators\UserProfileValidator;
use engine\classes\Model;

class UserProfile extends Model
{
    protected $id;
    protected $user_id;
    protected $fullname;
    protected $table = 'user_profile';

    public function __construct()
    {
        parent::__construct();
        $this->validator = new UserProfileValidator($this);
    }
    
    public function save()
    {
        try {
            $stmt = $this->connection->pdo->prepare('INSERT INTO ' . $this->table . '(user_id, fullname) VALUES(:user_id, :fullname)');
            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':fullname', $this->fullname, \PDO::PARAM_STR);
            $stmt->execute();
        } catch (\PDOException $e) {
            if ($this->connection->pdo->inTransaction()) {
                $this->connection->pdo->rollBack();
            }
            Debug::logToFile($e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        }
    }
}