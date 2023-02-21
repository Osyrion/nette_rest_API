<?php declare(strict_types=1);

namespace App\Model;

final class Phones extends BaseManager
{
    private const TABLENAME = 'phones';

    public function getTableName(): string
    {
        return self::TABLENAME;
    }

    public function insertPhone(object $data, int $personId): void
    {
        $phone = str_replace(' ', '', $data->phone);
        $exists = $this->checkIfExists('phone', $phone);

        if (!$exists) {
            $this->database->table($this->getTableName())->insert([
                "phone" => $phone,
                "person_id" => $personId
            ]);
        }
    }
}
