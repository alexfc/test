<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-11-14
 * Time: 17:05
 */

namespace App\Controller;


use App\Repository\ProjectCriteria;
use App\Repository\ProjectRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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

    public function filter(Request $request)
    {
        $subject = $request->request->get('subject');
        $fromDate = $request->request->get('from');
        $toDate = $request->request->get('to');

        $criteria = (new ProjectCriteria())
            ->from($fromDate)
            ->to($toDate);

        if ($subject) {
            $criteria->contains(['subject' => $subject]);
        }

        $projects = [];

        foreach ($this->projectRepository->findByCriteria($criteria) as $project) {
            $projects[] = $project->toArray();
        }

        return $this->json($projects);
    }
}