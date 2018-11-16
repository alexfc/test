<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-11-14
 * Time: 15:08
 */

namespace App\Repository;


use App\Entity\Project;
use DateTime;
use Doctrine\DBAL\Connection;

class SQLProjectRepository implements ProjectRepositoryInterface
{
    /** @var Connection */
    private $connection;

    private const TABLE_NAME = 'projects';

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /** @inheritdoc */
    public function all(): array
    {
        $rows = $this->connection->fetchAll(sprintf('SELECT * FROM %s', self::TABLE_NAME));

        $entities = [];

        foreach ($rows as $row) {
            $entities[] = $this->toEntity($row);
        }

        return $entities;
    }

    /** @inheritdoc */
    public function findById(int $id): ?Project
    {
        $rows = $this->connection->fetchAll(sprintf('SELECT * FROM %s WHERE id = ?', self::TABLE_NAME), [$id]);

        if ($row = reset($rows)) {
            return $this->toEntity($row);
        }

        return null;
    }

    /** @inheritdoc */
    public function save(Project $entity): Project
    {
        $startDate = $entity->getStartDate() ? $entity->getStartDate()->format('Y-m-d') : null;
        $createdAt = $entity->getStartDate() ? $entity->getStartDate()->format('Y-m-d H:i:s') : null;
        $updatedAt = $entity->getStartDate() ? $entity->getStartDate()->format('Y-m-d H:i:s') : null;

        $stmt = $this->connection->prepare(
            sprintf('INSERT INTO %s (id, subject, description, parent_id, priority, done_ratio, start_date, ' .
                ' created_at, updated_at) VALUES (:id, :subject, :description, :parentId, :priority, :doneRatio, ' .
                ' :startDate, :createdAt, :updatedAt) ON DUPLICATE KEY UPDATE subject = :subject, ' .
                ' description = :description, parent_id = :parentId, priority = :priority, done_ratio = :doneRatio, ' .
                ' start_date = :startDate, created_at = :createdAt, updated_at = :updatedAt',
                self::TABLE_NAME));

        $stmt->bindValue('id', $entity->getId(), \PDO::PARAM_INT);
        $stmt->bindValue('subject', $entity->getSubject(), \PDO::PARAM_STR);
        $stmt->bindValue('description', $entity->getDescription(), \PDO::PARAM_STR);
        $stmt->bindValue('parentId', $entity->getParentId(), \PDO::PARAM_INT);
        $stmt->bindValue('priority', $entity->getPriority(), \PDO::PARAM_INT);
        $stmt->bindValue('doneRatio', $entity->isDone(), \PDO::PARAM_INT);
        $stmt->bindValue('startDate', $startDate, \PDO::PARAM_STR);
        $stmt->bindValue('createdAt', $createdAt, \PDO::PARAM_STR);
        $stmt->bindValue('updatedAt', $updatedAt, \PDO::PARAM_STR);

        $stmt->execute();

        if ($entity->getId() === null) {
            $entity->setId($this->connection->lastInsertId());
        }

        return $entity;
    }

    /**
     * @param array $row
     * @return Project
     */
    private function toEntity(array $row): Project
    {
        $entity = new Project();

        $entity->setId($row['id']);
        $entity->setSubject($row['subject']);
        $entity->setDescription($row['description']);
        $entity->setParentId($row['parent_id']);
        $entity->setPriority($row['priority']);
        $entity->setDone($row['done_ratio']);
        $entity->setStartDate(new DateTime($row['start_date']));
        $entity->setCreatedAt(new DateTime($row['created_at']));
        $entity->setUpdatedAt(new DateTime($row['updated_at']));

        return $entity;
    }
}