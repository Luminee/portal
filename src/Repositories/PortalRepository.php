<?php

namespace Luminee\Portal\Repositories;

use Luminee\Base\Repositories\BaseRepository;

class PortalRepository extends BaseRepository
{
    public function __construct()
    {
        $this->db_models_path = realpath(__DIR__ . '/../Models');
    }

    public function findUser($value, $field = 'id', $equal = '=')
    {
        return $this->setModel('user')->where($field, $equal, $value)->getFirst();
    }

    public function findAccount($value, $field = 'id', $equal = '=')
    {
        return $this->setModel('account')->where($field, $equal, $value)->getFirst();
    }

    public function findType($value, $field = 'id')
    {
        return $this->setModel('type')->where($field, $value)->getFirst();
    }

    public function listAccount($user_id, $code = null)
    {
        $query = $this->setModel('account')->where('user_id', $user_id);
        isset($code) ? $query->whereHas('type', 'code', $code) : null;
        return $query->getCollection();
    }

    public function createUser($data)
    {
        return $this->setModel('user')->create($data);
    }

    public function createType($data)
    {
        return $this->setModel('type')->create($data);
    }

    public function createAccount($data)
    {
        return $this->setModel('account')->create($data);
    }

    public function insertAccount($data)
    {
        return $this->setModel('account')->insert($data);
    }

    public function updateUser($data)
    {
        return $this->setModel('user')->update($data);
    }

    public function updateAccount($data, $Fileds)
    {
        return $this->setModel('account')->update($data);
    }

    public function updateModel($model, $data)
    {
        return $this->updateModelByData($model, $data);
    }

    public function deleteUserById($id)
    {
        return $this->setModel('user')->delete($id);
    }

    public function deleteAccountById($id)
    {
        return $this->setModel('account')->delete($id);
    }


}