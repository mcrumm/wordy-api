<?php

namespace Wordy\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class WordsController extends AbstractController
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException
     */
    public function indexAction(Request $request)
    {
        try {
            $words  = $this->wm->getAll();
            $total  = count($words);
            $limit  = $request->query->get('limit', 10);
            $page   = (int)$request->query->get('page', 1);

            $data   = array(
                'meta' => array(
                    'total' => $total,
                    'page'  => $page,
                    'pages' => $total > $limit ? $total / $limit : 1
                ),
                'words' => array_slice($words, $page-1, $limit)
            );

            return new JsonResponse($data);
        }
        catch (\Exception $ex) {
            throw new ServiceUnavailableHttpException(30, $ex->getMessage(), $ex);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException
     */
    public function createAction(Request $request)
    {
        $word = $request->get('word');
        if (!$word) {
            throw new BadRequestHttpException('No word specified.');
        }

        try {
            $collection = $this->wm->add($word);
            $position   = array_search($word, $collection);

            return new Response('', 201, array(
                'Location' => sprintf('http://localhost:8787/words/%d', $position)
            ));
        }
        catch (\Exception $ex) {
            throw new ServiceUnavailableHttpException(30, 'The word could not be added at this time.');
        }
    }

    /**
     * @param int $pos
     * @return JsonResponse
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @throws \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException
     */
    public function getAction($pos = -1)
    {
        try {
            return new JsonResponse($this->wm->get($pos));
        }
        catch (\InvalidArgumentException $ex) {
            throw new BadRequestHttpException($ex->getMessage(), $ex);
        }
        catch (\Exception $ex) {
            throw new ServiceUnavailableHttpException(30, $ex->getMessage(), $ex);
        }
    }

    /**
     * @param int $pos
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException
     */
    public function deleteAction($pos = -1)
    {
        try {
            $this->wm->remove($pos);
            return new Response('', 204);
        }
        catch (\Exception $ex) {
            throw new ServiceUnavailableHttpException(30, $ex->getMessage(), $ex);
        }
    }

}
