<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\DBAL\Driver\Connection;

class DbRequest
{
    private $requestStack;
    private $connection;

    public function __construct(RequestStack $requestStack, Connection $connection)
    {
        $this->requestStack = $requestStack;
        $this->connection = $connection;
    }

    private function returnSelectString(?array $select = null)
    {
        if ($select === null) {
            return "SELECT *";
        } else if ($select) {
            return "SELECT " . implode(', ', $var);
        }

        return false;
    }

    private function returnWhereString(?array $where = null)
    {
        if ($where) {
            foreach ($where as $key => $value) {
                if (is_int($key)) {
                    $string = (isset($string) && $string ? "$string $value" : $string = $value);
                } else if (is_string($key)) {
                    switch (substr($key, 0, 2)) {
                        case '==':
                            $substr = substr($key, 2) . "='$value'";
                            break;
                        case '<>':
                            $substr = substr($key, 2) . "<>'$value'";
                            break;
                        case '!=':
                            $substr = substr($key, 2) . "!='$value'";
                            break;
                        case '>>':
                            $substr = substr($key, 2) . ">'$value'";
                            break;
                        case '>=':
                            $temp = '>=';
                            $substr = substr($key, 2) . ">='$value'";
                            break;
                        case '<<':
                            $substr = substr($key, 2) . "<'$value'";
                            break;
                        case '<=':
                            $substr = substr($key, 2) . "<='$value'";
                            break;
                        default:
                            $substr = "$key='$value'";
                    }
                    if (isset($substr) && $substr) {
                        $string = (isset($string) && $string ? "$string $substr" : $string = $substr);
                    }
                }
            }
            if (isset($string) && $string) return "WHERE $string";
        }

        return false;
    }

    private function returnOrderString(?array $order = null)
    {
        if ($order) {
            foreach ($order as $key => $value) {
                if (is_int($key)) {
                    $temp_substring = "$value";
                } else if (is_string($key)) {
                    $temp_substring = "$key $value";
                }

                if (isset($temp_substring) && $temp_substring) {
                    $string = (isset($string) && $string ? "$string, $temp_substring" : $string = $temp_substring;);
                }
            }
            if (isset($string) && $string) return "ORDER BY $string";
        }

        return false;
    }

    private function returnLimitString(?numeric $limit = null)
    {
        if ($limit) return "LIMIT $limit";
        return false;
    }

    private function returnOffsetString(?numeric $offset = null)
    {
        if ($offset) return "OFFSET $offset";
        return false;
    }

    public function select(?string $table = null, array $select = ['*'], ?array $where = null, ?array $order = null, ?numeric $limit = null, ?numeric $offset = null)
    {
        if (!$table) $table = $this->requestStack->getCurrentRequest()->get('table');
        if (!$select) $select = $this->requestStack->getCurrentRequest()->get('select');
        if (!$where) $where = $this->requestStack->getCurrentRequest()->get('where');
        if (!$order) $order = $this->requestStack->getCurrentRequest()->get('order');
        if (!$limit) $limit = $this->requestStack->getCurrentRequest()->get('limit');
        if (!$offset) $offset = $this->requestStack->getCurrentRequest()->get('offset');

        if (is_string($table) && $table) {
            $sql = $this->returnSelectString($select) . " FROM $table";

            if (is_array($where)) $sql .= ' ' . $this->returnWhereString($where);
            if (is_array($order)) $sql .= ' ' . $this->returnOrderString($order);
            if (is_numeric($limit)) $sql .= ' ' . $this->returnLimitString($limit);
            if (is_numeric($offset)) $sql .= ' ' . $this->returnOffsetString($offset);

            return $this->connection->fetchAll($sql);
        }

        return false;
    }

    public function insert(?string $table = null, ?array $data = null)
    {
        if (!$table) $table = $this->requestStack->getCurrentRequest()->get('table');
        if (!$data) $data = $this->requestStack->getCurrentRequest()->get('data');

        if (is_string($table) && $table && is_array($data) && $data) {
            return $this->connection->insert($table, $data);
        }

        return false;
    }

    public function update(?string $table = null, ?array $data = null, ?array $where = null)
    {
        if (!$table) $table = $this->requestStack->getCurrentRequest()->get('table');
        if (!$data) $data = $this->requestStack->getCurrentRequest()->get('data');
        if (!$where) $where = $this->requestStack->getCurrentRequest()->get('where');

        if (is_string($table) && $table && is_array($data) && $data && is_array($where) && $where) {
            return $this->connection->update($table, $data, $where);
        }

        return false;
    }

    public function delete(?string $table = null, ?array $where = null)
    {
        if (!$table) $table = $this->requestStack->getCurrentRequest()->get('table');
        if (!$where) $where = $this->requestStack->getCurrentRequest()->get('where');

        if (is_string($table) && $table && is_array($where) && $where) {
            return $this->connection->delete($table, $data, $where);
        }

        return false;
    }
}
