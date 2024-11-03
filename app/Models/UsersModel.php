<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['google_id', 'username', 'email', 'password', 'profile', 'role', 'created_at', 'updated_at', 'deleted_at'];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function saveUserData($userData)
    {
        $data = [
            'google_id' => $userData->getId(),
            'username' => $userData->getName(),
            'email' => $userData->getEmail(),
            'profile' => $userData->getPicture(),
            'role' => 'siswa',
        ];
        $this->insert($data);
        return $this->getInsertID();
    }
}
