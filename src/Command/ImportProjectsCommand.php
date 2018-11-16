<?php

namespace App\Command;

use App\Entity\Project;
use App\Repository\ProjectRepositoryInterface;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportProjectsCommand extends Command
{
    private const ENDPOINT = 'http://bravik.ru/dev/projects';

    /** @var ProjectRepositoryInterface */
    private $projectRepository;

    protected static $defaultName = 'import:projects';

    public function __construct($name = null, ProjectRepositoryInterface $projectRepository)
    {
        parent::__construct($name);
        $this->projectRepository = $projectRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Команда для импорта проектов')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $client = new Client();
        $io->success('start import');

        $result = $client->get(self::ENDPOINT)->getBody()->getContents();
        $data = json_decode($result, true);

        foreach ($data['issues'] as $project) {
            $entity = new Project();

            $parentId = $project['parent']['id'] ?? 0;

            $entity->setRemoteId($project['id']);
            $entity->setSubject($project['subject']);
            $entity->setDescription($project['description']);
            $entity->setParentId($parentId);
            $entity->setPriority($project['priority']['id']);
            $entity->setDone((bool)$project['done_ratio']);
            $entity->setStartDate(new \DateTime($project['start_date']));
            $entity->setCreatedAt(new \DateTime($project['created_on']));
            $entity->setUpdatedAt(new \DateTime($project['updated_on']));

            $this->projectRepository->save($entity);
        }

        $io->success('done!');
    }
}
