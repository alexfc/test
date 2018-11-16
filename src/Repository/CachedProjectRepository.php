<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-11-14
 * Time: 17:51
 */

namespace App\Repository;


use App\Entity\Project;
use Psr\SimpleCache\CacheInterface;

class CachedProjectRepository implements ProjectRepositoryInterface
{
    /** @var SQLProjectRepository */
    private $projectRepository;

    /** @var CacheInterface */
    private $cache;

    private const TTL = 1 * 60;
    private const CACHE_PREFIX_ALL = 'projects';
    private const CACHE_PREFIX_ITEM = 'project_';

    public function __construct(SQLProjectRepository $projectRepository, CacheInterface $cache)
    {
        $this->projectRepository = $projectRepository;
        $this->cache = $cache;
    }

    /**
     * @return Project[]|mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function all()
    {
        $cacheKey = $this->makeCacheKey(self::CACHE_PREFIX_ALL);

        $projects = $this->cache->get($cacheKey);

        if ($projects === null) {
            $projects = $this->projectRepository->all();
            $this->cache->set($cacheKey, $projects, self::TTL);
        }

        return $projects;
    }

    /**
     * @param int $id
     * @return Project|null
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function findById(int $id): ?Project
    {
        $cacheKey = $this->makeCacheKey(self::CACHE_PREFIX_ITEM, $id);

        $project = $this->cache->get($cacheKey);

        if ($project === null) {
            $project = $this->projectRepository->findById($id);
            $this->cache->set($cacheKey, $project, self::TTL);
        }

        return $project;
    }

    /**
     * @param Project $entity
     * @return Project
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function save(Project $entity): Project
    {
        $entity = $this->projectRepository->save($entity);

        //чистим кэш записи
        $this->cache->delete($this->makeCacheKey(self::CACHE_PREFIX_ITEM, $entity->getId()));

        //чистим кэш всех записей
        $this->cache->delete($this->makeCacheKey(self::CACHE_PREFIX_ALL));

        return $entity;
    }

    /**
     * @param mixed ...$args
     * @return string
     */
    private function makeCacheKey(...$args): string
    {
        return sha1(serialize($args));
    }
}