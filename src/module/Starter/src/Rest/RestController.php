<?php

namespace Starter\Rest;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Silex\Application;
use Starter\Doctrine\Hydrator\Hydrator;
use Starter\Rest\Exception\RepositorySearchFunctionNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * The basic starter REST controller.
 *
 * The controller provides actions for listing (GET), creating (POST), updating (PUT) and removing (DELETE) entities.
 * Map theses actions to a route config to access them. The $entityClass should be a RestEntity child class and have
 * as repositoryClass an instance (or a child) of RestRepository.
 * Read the starter documentation to know how to write your own REST controller.
 *
 * TODO : Fields validation for create and update
 * TODO : Search params (query, pager ...)
 * TODO : Entity json serializing
 *
 * @package Starter\Rest
 * @author  Jules Bertrand <jules.brtrnd@gmail.com>
 */
class RestController
{
    /**
     * The function of the repository to call when accessing the search action.
     * Used to retrieve a list of rows.
     */
    const REPOSITORY_SEARCH_FUNCTION = 'search';

    /**
     * @var EntityManager The Doctrine entity manager.
     */
    protected $entityManager;

    /**
     * @var EntityRepository The repository for the REST entity.
     */
    protected $repository;

    /**
     * @var Hydrator The Doctrine hydrator.
     */
    protected $hydrator;

    /**
     * RestController constructor.
     *
     * @param string      $entityClass The entity full-named classed to manage.
     * @param Application $application The Silex container.
     *
     * @throws RepositorySearchFunctionNotFoundException If the repository don't contain the REST search function.
     */
    public function __construct(string $entityClass, Application $application)
    {
        $this->entityManager = $application['orm.em'];
        $this->repository    = $this->entityManager->getRepository($entityClass);
        $this->hydrator      = new Hydrator($this->entityManager);

        if (!method_exists($this->repository, self::REPOSITORY_SEARCH_FUNCTION)) {
            throw new RepositorySearchFunctionNotFoundException(self::REPOSITORY_SEARCH_FUNCTION, $entityClass);
        }
    }

    /**
     * Search in the complete list of entities.
     *
     * URL    : http(s)://host.ext/url/to/this/function
     * Method : GET
     *
     * HTTP Status code :
     * - 200 : it's ok, entities retrieved
     * - 500 : internal error
     *
     * By default, will call the "search" function of the repository.
     *
     * @param Request $request The current HTTP request.
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $rows = $this->repository->{self::REPOSITORY_SEARCH_FUNCTION}();

        return new JsonResponse($rows);
    }

    /**
     * Get an entity by its primary key value.
     *
     * URL    : http(s)://host.ext/url/to/this/function/<IDENTIFIER_VALUE>
     * Method : GET
     *
     * HTTP Status code :
     * - 200 : it's ok, entity retrieved
     * - 404 : entity not found
     * - 500 : internal error
     *
     * @param mixed   $id      The primary key value of the entity to retrieve.
     * @param Request $request The current HTTP request.
     *
     * @return JsonResponse
     */
    public function get($id, Request $request): JsonResponse
    {
        $row = $this->repository->find($id);
        if (!$row) {
            return $this->notFoundResponse();
        }

        return new JsonResponse($row);
    }

    /**
     * Create an entity.
     *
     * URL    : http(s)://host.ext/url/to/this/function
     * Method : POST
     * Body   :
     * {
     *     "field_1": <FIELD1_VALUE>,
     *     "field_2": <FIELD2_VALUE>,
     *     ...
     * }
     *
     * HTTP Status code :
     * - 200 : it's ok, entity created
     * - 422 : fields validation failed
     * - 500 : internal error
     *
     * @param Request $request The current HTTP request.
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $className = $this->repository->getClassName();

        /** @var RestEntity $row */
        $row = new $className();

        $values = $request->request->all();
        $this->hydrate($values, $row);

        $row->setCreated(new \DateTime());

        $this->entityManager->persist($row);
        $this->entityManager->flush();

        return new JsonResponse($row);
    }

    /**
     * Update an entity by its primary key value.
     *
     * URL    : http(s)://host.ext/url/to/this/function/<IDENTIFIER_VALUE>
     * Method : PUT
     * Body   :
     * {
     *     "field_1": <FIELD1_VALUE>,
     *     "field_2": <FIELD2_VALUE>,
     *     ...
     * }
     *
     * HTTP Status code :
     * - 200 : it's ok, entity updated
     * - 404 : entity not found
     * - 422 : fields validation failed
     * - 500 : internal error
     *
     * @param mixed   $id      The primary key value of the entity to update.
     * @param Request $request The current HTTP request.
     *
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        /** @var RestEntity $row */
        $row = $this->repository->find($id);
        if (!$row) {
            return $this->notFoundResponse();
        }

        $values = $request->request->all();
        $this->hydrate($values, $row);

        $row->setUpdated(new \DateTime());

        $this->entityManager->flush();

        return new JsonResponse($row);
    }

    /**
     * Remove an entity by its primary key value.
     *
     * URL    : http(s)://host.ext/url/to/this/function/<IDENTIFIER_VALUE>
     * Method : DELETE
     *
     * HTTP Status code :
     * - 200 : it's ok, entity removed
     * - 404 : entity not found
     * - 500 : internal error
     *
     * @param mixed   $id      The primary key value of the entity to remove.
     * @param Request $request The current HTTP request.
     *
     * @return JsonResponse
     */
    public function remove($id, Request $request): JsonResponse
    {
        /** @var RestEntity $row */
        $row = $this->repository->find($id);
        if (!$row) {
            return $this->notFoundResponse();
        }

        $this->entityManager->remove($row);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_OK);
    }

    /**
     * Send a 404 NOT FOUND response.
     *
     * @return JsonResponse
     */
    protected function notFoundResponse(): JsonResponse
    {
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * Hydrate an object from array values.
     *
     * @param mixed[]    $data   Values to set.
     * @param RestEntity $object Object to hydrate.
     *
     * @return object|RestEntity
     */
    protected function hydrate(array $data, RestEntity $object): RestEntity
    {
        return $this->hydrator->hydrate($data, $object);
    }
}
