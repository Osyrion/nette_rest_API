<?php declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;

abstract class BaseManager
{
    public function __construct(
        protected Explorer $database,
    ) {}

    abstract function getTableName();

    public function findAll(): Selection
    {
        return $this->database->table($this->getTableName());
    }

    public function findBy(string $parameter, string $value): Selection
    {
        return $this->database->table($this->getTableName())->where($parameter, $value);
    }

    public function checkIfExists(string $param, string $value): int
    {
        return $this->database->table($this->getTableName())->where($param, $value)->count();
    }
}
