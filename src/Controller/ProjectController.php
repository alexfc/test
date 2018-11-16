<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-11-14
 * Time: 17:05
 */

namespace App\Controller;


use App\Repository\ProjectRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProjectController extends AbstractController
{
    /** @var ProjectRepositoryInterface */
    private $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function index()
    {
        $projects = [];

        foreach ($this->projectRepository->all() as $project) {
            $projects[] = $project->toArray();
        }

        return $this->json($projects);
    }

    public function viewProject(int $id)
    {
        $project = $this->projectRepository->findById($id);

        if ($project) {
            return $this->json($project->toArray());
        }

        return $this->json(
            ['status' => 'error',
             'message' => 'project not found']
        );
    }
}