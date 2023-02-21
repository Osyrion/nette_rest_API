<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Contacts;
use Nette\Application\AbortException;
use Nette\Application\Responses\JsonResponse;
use Nette\Application\UI\Presenter;
use Nette\Utils\JsonException;

class ApiPresenter extends Presenter
{
    public function __construct(
        private Contacts $contacts,
    )
    {
        parent::__construct();
    }

    /**
     * @throws AbortException|JsonException
     */
    public function actionDefault($parameter, $value)
    {
        if ($this->request->getMethod() === 'GET') {
            if (isset($parameter) && isset($value)) {
                $data = $this->contacts->getData($parameter, $value);
            } else {
                $data = $this->contacts->getData();
            }

            $this->sendJson($data);
        }
        else if ($this->request->getMethod() === 'POST') {
            $body = $this->getHttpRequest()->getRawBody();

            if ($this->contacts->postData($body)) {
                $this->sendStatus('Success', 200);
            } else {
                $this->sendStatus('Failed', 500);
            }

        }
        else if ($this->request->getMethod() === 'DELETE') {
            if (isset($parameter) && isset($value)) {

                if ($this->contacts->deleteData($parameter, $value)) {
                    $this->sendStatus('Success', 200);
                } else {
                    $this->sendStatus('Bad syntax', 400);
                }

            } else {
                $this->sendStatus('Failed', 500);
            }
        }
        else {
            $this->sendStatus('Method not allowed', 405);
        }
    }

    public function sendJson($data): void
    {
        $this->sendResponse(new JsonResponse($data));
    }
    /**
     * @throws AbortException
     */
    private function sendStatus(string $message, int $code): void
    {
        $this->sendResponse(new JsonResponse(['status' => $message, "code" => $code]));
    }
}
