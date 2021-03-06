<?php

namespace Starter\Rest;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Silex\Application;
use Starter\Doctrine\Hydrator\Hydrator;
use Starter\Rest\Exception\RepositorySearchFunctionNotFoundException;
use Starter\Utils\Serializer;
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
     * Query parameters :
     * - "page"
     * index of the page
     * alias for : "_p"
     *
     * - "per_page"
     * number of rows per page
     * alias for : "_pp"
     *
     * - "sort"
     * sort columns, commas-separated  and prefixed by '-' for desc. order (eg : sort=-field1,field2)
     * alias for : "_s"
     *
     * - "embed"
     * embedded properties that are not included in the "jsonSerialize" function
     * alias for : "_e"
     *
     * - "mode"
     * perform a "and" or "or" query (default to "and")
     * alias for : "_m"
     *
     * - "<property-name>"
     * filter by any entity property (operator will be equal by default) (ex: field1=value)
     *
     * - "<property-name>-<operator>"
     * filter by any entity property and set the operator to apply
     * see doctrine expr operators
     *
     * By default, all entities will be retrieved, you can pass query parameters to limit or filter results
     * A custom response header named "X-REST-TOTAL" will contain the total number of rows.
     *
     * @param Request $request The current HTTP request.
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $query   = $request->query;
        $headers = [];

        // Pagination
        $limit  = null;
        $offset = null;

        $page     = $query->get('page', $query->get('_p', false));
        $per_page = $query->get('per_page', $query->get('_pp', false));

        if ($page && $per_page) {
            if ($page && $page <= 0) {
                $page = 1;
            }

            if ($per_page && $per_page <= 0) {
                $per_page = 25;
            }

            $limit  = $per_page;
            $offset = $per_page * ($page - 1);
        }

        // Sorting
        $orderBy = null;

        $sort = $query->get('sort', $query->get('_s', false));

        if ($sort) {
            foreach (explode(',', $sort) as $column) {
                $order = 'ASC';
                if (strrpos($column, '-') === 0) {
                    $order  = 'DESC';
                    $column = substr($column, 1);
                }
                $orderBy[$column] = $order;
            }
        }

        // Filtering
        $criteria = [];

        $params = $request->query->all();
        foreach ($params as $column => $value) {
            if (!in_array($column, ['sort', '_s', 'page', '_p', 'per_page', '_pp', 'mode', '_m', 'embed', '_e'])) {
                @list($property, $operator) = explode('-', $column);
                $criteria[] = [
                    'property' => $property,
                    'operator' => $operator ?? 'eq',
                    'value'    => $value
                ];
            }
        }

        // Mode
        $mode = $query->get('mode', $query->get('_m', 'and'));
        if (!in_array($mode, ['and', 'or'])) {
            $mode = 'and';
        }

        // Repository call
        $rows = $this->repository->{self::REPOSITORY_SEARCH_FUNCTION}($criteria, $orderBy, $mode, $limit, $offset);

        $total = sizeOf($rows);
        // Total for pagination
        if ($limit !== null && $offset !== null) {
            $total = sizeOf($this->repository->{self::REPOSITORY_SEARCH_FUNCTION}($criteria, $orderBy, $mode));
        }

        $headers['Access-Control-Expose-Headers'] = 'X-REST-TOTAL';
        $headers['X-REST-TOTAL'] = $total;

        return new JsonResponse($this->serializeAll($rows, $request), Response::HTTP_OK, $headers);
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
     * Query parameters :
     * - "embed"
     * embedded properties that are not included in the "jsonSerialize" function
     * alias for : "_e"
     *
     * @param mixed   $id      The primary key value of the entity to retrieve.
     * @param Request $request The current HTTP request.
     *
     * @return JsonResponse
     */
    public function get($id, Request $request): JsonResponse
    {
        /** @var RestEntity $row */
        $row = $this->repository->find($id);
        if (!$row) {
            return $this->notFoundResponse();
        }

        return new JsonResponse($this->serialize($row, $request));
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
     * Query parameters :
     * - "embed"
     * embedded properties that are not included in the "jsonSerialize" function
     * alias for : "_e"
     *
     * @param Request $request The current HTTP request.
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $className = $this->repository->getClassName();
        /** @var RestEntity $row */
        $row = new $className();

        $values = $request->request->all();

        $inputFilter = $row->getInputFilter($this->entityManager);
        $inputFilter->setData($values);
        if ($inputFilter->isValid()) {
            $values = $inputFilter->getValues();
        } else {
            return new JsonResponse($inputFilter->getMessages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->hydrate($values, $row);

        $this->entityManager->persist($row);
        $this->entityManager->flush();

        return new JsonResponse($this->serialize($row, $request));
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
     * Query parameters :
     * - "embed"
     * embedded properties that are not included in the "jsonSerialize" function
     * alias for : "_e"
     *
     * You can partially update the entity.
     *
     * @param mixed   $id      The primary key value of the entity to update.
     * @param Request $request The current HTTP request.
     *
     * @throws \Doctrine\ORM\OptimisticLockException
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

        $inputFilter = $row->getInputFilter($this->entityManager);
        $inputFilter->setData($this->merge($values, $row));
        if ($inputFilter->isValid()) {
            $values = $inputFilter->getValues();
        } else {
            return new JsonResponse($inputFilter->getMessages(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->hydrate($values, $row, true);

        $this->entityManager->flush();

        return new JsonResponse($this->serialize($row, $request));
    }

    /**
     * Remove an entity by its primary key value.
     *
     * URL    : http(s)://host.ext/url/to/this/function/<IDENTIFIER_VALUE>
     * Method : DELETE
     *
     * HTTP Status code :
     * - 204 : it's ok, entity removed
     * - 404 : entity not found
     * - 500 : internal error
     *
     * @param mixed   $id      The primary key value of the entity to remove.
     * @param Request $request The current HTTP request.
     *
     * @throws \Doctrine\ORM\OptimisticLockException
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

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
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
     * @param mixed[]    $data    Values to set.
     * @param RestEntity $object  Object to hydrate.
     * @param bool       $partial Should we partial hydrate the object ?
     *
     * @return object|RestEntity
     */
    protected function hydrate(array $data, RestEntity $object, bool $partial = false): RestEntity
    {
        if ($partial) {
            $this->merge($data, $object);
        }

        return $this->hydrator->hydrate($data, $object);
    }

    /**
     * Merge an array of values with the array representation of an object.
     *
     * @param array      $data   The array of values.
     * @param RestEntity $object The object to convert.
     *
     * @return array
     */
    protected function merge(array $data, RestEntity $object): array
    {
        $values = array_merge($this->hydrator->extract($object), $data);
        return $values;
    }

    /**
     * Serialize a row.
     *
     * Retrieve the "embed" query parameter to embed non default properties.
     *
     * @param RestEntity $object  The row to serialize.
     * @param Request    $request The request object to retrieve the "embed" query param..
     *
     * @return array
     */
    protected function serialize(RestEntity $object, Request $request): array
    {
        $query = $request->query;
        $res   = $object->jsonSerialize();

        $embed = $query->get('embed', $query->get('_e', false));
        if ($embed) {
            $embed        = explode(',', $embed);
            $res['embed'] = Serializer::serialize($object, $embed);
        }

        return $res;
    }

    /**
     * Serialize an array of rows.
     *
     * @param array   $objects The rows to serialize.
     * @param Request $request The request object to retrieve the "embed" query param.
     *
     * @return array
     */
    protected function serializeAll(array $objects, Request $request): array
    {
        $res = [];
        foreach ($objects as $object) {
            $res[] = $this->serialize($object, $request);
        }
        return $res;
    }
}
