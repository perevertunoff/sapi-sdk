<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class Method
{
    public function hiWorld()
    {
        return 'Hi World!';
    }

    public function select(DbRequest $dbRequest)
    {
        if ($result = $dbRequest->select()) {
            return $result;
        } else {
            return ['error' => 'Incorrect params'];
        }
    }

    public function insert(DbRequest $dbRequest)
    {
        if ($result = $dbRequest->insert()) {
            return ['result' => 'Success'];
        } else {
            return ['error' => 'Incorrect params'];
        }
    }

    public function update()
    {
        if ($result = $dbRequest->update()) {
            return ['result' => 'Success'];
        } else {
            return ['error' => 'Incorrect params'];
        }
    }

    public function delete()
    {
        if ($result = $dbRequest->delete()) {
            return ['result' => 'Success'];
        } else {
            return ['error' => 'Incorrect params'];
        }
    }
}
