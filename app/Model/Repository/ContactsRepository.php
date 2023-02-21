<?php declare(strict_types=1);

namespace App\Model\Repository;

use App\Model\Persons;
use App\Model\Phones;
use Nette\Database\Explorer;

class ContactsRepository
{
    public function __construct(
        protected Explorer $database,
        protected Persons $persons,
        protected Phones $phones
    ) {}

    protected function findAllContacts(): array
    {
        return $this->database->query(
            'SELECT `persons`.`id`, `persons`.`email`, `persons`.`name`, `persons`.`surname`, `phones`.`phone` FROM '
            . $this->phones->getTableName() . ' LEFT JOIN ' . $this->persons->getTableName() .
            ' ON `persons`.`id` = `phones`.`person_id`')->fetchAll();
    }

    protected function findContactByPhoneNumber(string $phone): array
    {
        return $this->database->query(
            'SELECT `persons`.`id`, `persons`.`email`, `persons`.`name`, `persons`.`surname`, `phones`.`phone` FROM '
            . $this->phones->getTableName() . ' LEFT JOIN ' . $this->persons->getTableName() .
            ' ON `persons`.`id` = `phones`.`person_id` WHERE `phones`.`phone` = ?', $phone)->fetchAll();
    }

    protected function findContactBySurname(string $surname): array
    {
        return $this->database->query(
            'SELECT `persons`.`id`, `persons`.`email`, `persons`.`name`, `persons`.`surname`, `phones`.`phone` FROM '
            . $this->persons->getTableName() . ' LEFT JOIN ' . $this->phones->getTableName() .
            ' ON `persons`.`id` = `phones`.`person_id` WHERE `persons`.`surname` = ?', $surname)->fetchAll();
    }

    protected function findContactByName(string $name): array
    {
        return $this->database->query(
            'SELECT `persons`.`id`, `persons`.`email`, `persons`.`name`, `persons`.`surname`, `phones`.`phone` FROM '
            . $this->persons->getTableName() . ' LEFT JOIN ' . $this->phones->getTableName() .
            ' ON `persons`.`id` = `phones`.`person_id` WHERE `persons`.`name` = ?', $name)->fetchAll();
    }

    protected function findContactByPersonId(string $personId): array
    {
        $id = (int) $personId;
        return $this->database->query(
            'SELECT `persons`.`id`, `persons`.`email`, `persons`.`name`, `persons`.`surname`, `phones`.`phone` FROM '
            . $this->persons->getTableName() . ' LEFT JOIN ' . $this->phones->getTableName() .
            ' ON `persons`.`id` = `phones`.`person_id` WHERE `persons`.`id` = ?', $id)->fetchAll();
    }

    protected function findContactByEmail(string $email): array
    {
        return $this->database->query(
            'SELECT `persons`.`id`, `persons`.`email`, `persons`.`name`, `persons`.`surname`, `phones`.`phone` FROM '
            . $this->persons->getTableName() . ' LEFT JOIN ' . $this->phones->getTableName() .
            ' ON `persons`.`id` = `phones`.`person_id` WHERE `persons`.`email` = ?', $email)->fetchAll();
    }

    protected function deleteContactByPersonId(string $id): void
    {
        $personId = (int) $id;
        $this->database->table($this->phones->getTableName())->where('person_id', $personId)->delete();
        $this->database->table($this->persons->getTableName())->where('id', $personId)->delete();
    }

    protected function deletePhoneNumber(string $phoneNumber): void
    {
        $this->database->table($this->phones->getTableName())->where('phone', $phoneNumber)->delete();
    }
}
