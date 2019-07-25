<?php

/**
 * Copyright © Ergonaut Sp. z o.o. All rights reserved.
 * See license.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Account\Application\Controller\Api;

use Ergonode\Account\Domain\Entity\UserId;
use Ergonode\Account\Domain\Query\LogQueryInterface;
use Ergonode\Account\Domain\Repository\UserRepositoryInterface;
use Ergonode\Account\Infrastructure\Grid\LogGrid;
use Ergonode\Authentication\Entity\User;
use Ergonode\Core\Application\Controller\AbstractApiController;
use Ergonode\Grid\RequestGridConfiguration;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;

/**
 */
class LogController extends AbstractApiController
{

    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * @var LogQueryInterface
     */
    private $query;

    /**
     * @var LogGrid
     */
    private $grid;

    /**
     * @param UserRepositoryInterface $repository
     * @param LogQueryInterface       $query
     * @param LogGrid                 $grid
     */
    public function __construct(UserRepositoryInterface $repository, LogQueryInterface $query, LogGrid $grid)
    {
        $this->repository = $repository;
        $this->query = $query;
        $this->grid = $grid;
    }

    /**
     * @Route("/profile/log", methods={"GET"})
     *
     * @SWG\Tag(name="Profile")
     *
     * @SWG\Parameter(
     *     name="limit",
     *     in="query",
     *     type="integer",
     *     required=true,
     *     default="50",
     *     description="Number of returned lines",
     * )
     * @SWG\Parameter(
     *     name="offset",
     *     in="query",
     *     type="integer",
     *     required=true,
     *     default="0",
     *     description="Number of start line",
     * )
     * @SWG\Parameter(
     *     name="field",
     *     in="query",
     *     required=false,
     *     type="string",
     *     enum={"id", "label","code", "hint"},
     *     description="Order field",
     * )
     * @SWG\Parameter(
     *     name="order",
     *     in="query",
     *     required=false,
     *     type="string",
     *     enum={"ASC","DESC"},
     *     description="Order",
     * )
     * @SWG\Parameter(
     *     name="filter",
     *     in="query",
     *     required=false,
     *     type="string",
     *     description="Filter"
     * )
     * @SWG\Parameter(
     *     name="show",
     *     in="query",
     *     required=false,
     *     type="string",
     *     enum={"COLUMN","DATA"},
     *     description="Specify what response should containts"
     * )
     * @SWG\Parameter(
     *     name="language",
     *     in="path",
     *     type="string",
     *     required=true,
     *     default="EN",
     *     description="Language Code",
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns User Log collection",
     * )
     * @SWG\Response(
     *     response=422,
     *     description="User entity not found",
     * )
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getLog(Request $request): Response
    {
        if ($this->getUser()) {
            $userId = new UserId($this->getUser()->getId()->toString());
            $user = $this->repository->load($userId);
            $configuration = new RequestGridConfiguration($request);

            $result = $this->renderGrid($this->grid, $configuration, $this->query->getDataSet($user->getId()), $user->getLanguage());

            return $this->createRestResponse($result);
        }

        throw new UnprocessableEntityHttpException();
    }
}