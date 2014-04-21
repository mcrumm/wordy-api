<?php

namespace Wordy\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Wordy\Entity\Collector;
use Wordy\Seed\Populator;

class SeedController
{
    private $populator;
    private $numWords;

    /**
     * @param Populator $populator
     * @param int $numWords The default number of words with which to seed the file.
     */
    public function __construct(Populator $populator, $numWords = 100)
    {
        $this->populator    = $populator;
        $this->numWords     = $numWords;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws BadRequestHttpException
     * @throws ServiceUnavailableHttpException
     */
    public function generateAction(Request $request)
    {
        try {
            $count      = $request->get('n', $this->numWords);
            $contents   = $this->populator->execute($count);
            $words      = Collector::fromPrimitive($contents);

            return new JsonResponse($words, 201);
        }
        catch (\InvalidArgumentException $badFile) {
            throw new BadRequestHttpException($badFile->getMessage());
        }
        catch (\Exception $ex) {
            throw new ServiceUnavailableHttpException(30, 'Failed to create the seed file.');
        }
    }

    /**
     * @param Request $request
     * @throws BadRequestHttpException
     * @throws ServiceUnavailableHttpException
     */
    public function populateAction(Request $request)
    {
        throw new ServiceUnavailableHttpException(null, 'Not implemented, yet.');
    }
}
