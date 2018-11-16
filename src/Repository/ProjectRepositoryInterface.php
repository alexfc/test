<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-11-14
 * Time: 15:04
 */

namespace App\Repository;


use App\Entity\Project;

interface ProjectRepositoryInterface
{
    /**
     * @return Project[]
     */
    public function all();

    /**
     * @param int $id
     * @return Project|null
     */
    public function findById(int $id);

    /**
     * @param Project $entity
     * @return Project
     */
    public function save(Project $entity): Project;
}