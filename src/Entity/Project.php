<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-11-14
 * Time: 12:36
 */

namespace App\Entity;


use DateTime;

class Project
{
    /** @var int|null */
    private $id;

    /** @var string */
    private $subject;

    /** @var string */
    private $description;

    /** @var int */
    private $parentId;

    /** @var int */
    private $priority;

    /** @var bool */
    private $doneRatio;

    /** @var DateTime|null */
    private $startDate;

    /** @var DateTime */
    private $createdAt;

    /** @var DateTime */
    private $updatedAt;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getRemoteId()
    {
        return $this->remoteId;
    }

    /**
     * @param mixed $remoteId
     */
    public function setRemoteId($remoteId): void
    {
        $this->remoteId = $remoteId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     */
    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority($priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->doneRatio;
    }

    /**
     * @param bool $doneRatio
     */
    public function setDone(bool $doneRatio): void
    {
        $this->doneRatio = $doneRatio;
    }

    /**
     * @return DateTime|null
     */
    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $startDate
     */
    public function setStartDate(DateTime $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'          => $this->getId(),
            'subject'     => $this->getSubject(),
            'description' => $this->getDescription(),
            'parent_id'   => $this->getParentId(),
            'priority'    => $this->getPriority(),
            'done_ratio'  => $this->isDone(),
            'start_date'  => $this->getStartDate(),
            'created_at'  => $this->getCreatedAt(),
            'updated_at'  => $this->getUpdatedAt()
        ];
    }
}