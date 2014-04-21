<?php

namespace Wordy\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class WerdsController extends AbstractController
{
    /**
     * Returns the collection of words as a top-level array.
     *
     * @return JsonResponse
     * @throws BadRequestHttpException
     * @throws ServiceUnavailableHttpException
     */
    public function indexAction()
    {
        try {
            $words = $this->wm->getAll();
            return new JsonResponse($words);
        }
        catch (\InvalidArgumentException $badFile) {
            throw new BadRequestHttpException($badFile->getMessage());
        }
        catch (\Exception $ex) {
            throw new ServiceUnavailableHttpException(30, 'An unknown error has occurred.', $ex);
        }
    }

}
