<?php

namespace App\Service;

class Method
{
    private $dbRequest;

    public function __construct(DbRequest $dbRequest)
    {
        $this->dbRequest = $dbRequest;
    }

    public function hiWorld()
    {
        return 'Hi World!';
    }

    public function select()
    {
        if ($result = $this->dbRequest->select()) {
            return $result;
        } else {
            return ['error' => 'Incorrect params'];
        }
    }

    public function insert()
    {
        if ($result = $this->dbRequest->insert()) {
            return ['result' => 'Success'];
        } else {
            return ['error' => 'Incorrect params'];
        }
    }

    public function update()
    {
        if ($result = $this->dbRequest->update()) {
            return ['result' => 'Success'];
        } else {
            return ['error' => 'Incorrect params'];
        }
    }

    public function delete()
    {
        if ($result = $this->dbRequest->delete()) {
            return ['result' => 'Success'];
        } else {
            return ['error' => 'Incorrect params'];
        }
    }
}
