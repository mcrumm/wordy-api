<?php

namespace Wordy\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class SearchController extends AbstractController
{
    public function indexAction(Request $request)
    {
        try {
            $word = $request->get('word');
            $found = $this->wm->find($word);
            if (false !== $found) {
                return new JsonResponse($fwound);
            }
        }
        catch (\InvalidArgumentException $badFile) {
            throw new BadRequestHttpException($badFile->getMessage());
        }
        catch (\RuntimeException $ex) {
            throw new ServiceUnavailableHttpException(30, 'An unknown error has occurred.', $ex);
        }

        throw new NotFoundHttpException(sprintf('Word not found.', $word));
    }

}
