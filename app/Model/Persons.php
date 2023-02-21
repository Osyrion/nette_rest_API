<?php declare(strict_types=1);

namespace App\Model;

use Nette;

final class Persons extends BaseManager
{
    private const TABLENAME = 'persons';

    public function getTableName(): string
    {
        return self::TABLENAME;
    }

    public function createOrUpdate(object $data): int
    {
        $exists = $this->checkIfExists('email', $data->email);

        if (!$exists) {
            $this->database->table($this->getTableName())->insert([
                "email" => $data->email,
                "name" => $data->name,
                "surname" => $data->surname,
            ]);
        }

        return $this->getPersonId('email', $data->email);
    }

    public function getPersonId(string $parameter, string $value): int
    {
        return $this->database->table($this->getTableName())->where($parameter, $value)->fetch()['id'];
    }
}
