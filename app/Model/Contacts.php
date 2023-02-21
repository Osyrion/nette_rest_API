<?php declare(strict_types=1);

namespace App\Model;

use App\Model\Repository\ContactsRepository;
use Exception;
use Nette\Utils\Json;
use Nette\Utils\JsonException;

final class Contacts extends ContactsRepository
{
    public function getData(string $parameter = null, string $value = null): array
    {
        if ($parameter === 'name') {
            return $this->findContactByName($value);
        }
        else if ($parameter === 'surname') {
            return $this->findContactBySurname($value);
        }
        else if ($parameter === 'id') {
            return $this->findContactByPersonId($value);
        }
        else if ($parameter === 'email') {
            return $this->findContactByEmail($value);
        }
        else if ($parameter === 'phone') {
            return $this->findContactByPhoneNumber($value);
        }
        else {
            return $this->findAllContacts();
        }
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    public function postData(string $rawBody): bool
    {
        $jsonData = Json::decode($rawBody);

        try {
            $this->database->beginTransaction();

            if (is_array($jsonData)) {
                foreach ($jsonData as $jsonItem) {
                    $this->dataInsertion($jsonItem);
                }
            } else {
                $this->dataInsertion($jsonData);
            }

            $this->database->commit();
        } catch (Exception $e) {
            $this->database->rollBack();
            throw new Exception('Insert data failed.');
        }

        return true;
    }

    public function deleteData(string $parameter, string $value): bool
    {
        if ($parameter === 'person') {
            $this->deleteContactByPersonId($value);
        }
        else if ($parameter === 'phone') {
            $this->deletePhoneNumber($value);
        }
        else {
            return false;
        }

        return true;
    }

    private function dataInsertion(object $data): void
    {
        if (($data->email && $data->surname) === false) {
            return;
        }

        $insertedId = $this->persons->createOrUpdate($data);

        if ($data->phone) {
            $this->phones->insertPhone($data, $insertedId);
        }
    }

}
