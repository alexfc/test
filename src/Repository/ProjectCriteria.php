<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-11-16
 * Time: 18:15
 */

namespace App\Repository;


class ProjectCriteria
{
    /** @var array */
    private $contains = [];

    /** @var string */
    private $fromStartDate;

    /** @var string */
    private $toStartDate;

    /**
     * @param array $contains
     * @return $this
     */
    public function contains(array $contains): self
    {
        $this->contains[] = $contains;
        return $this;
    }

    /**
     * @param string $from
     * @return $this
     */
    public function from(string $from): self
    {
        $this->fromStartDate = $from;
        return $this;
    }

    /**
     * @param string $to
     * @return $this
     */
    public function to(string $to): self
    {
        $this->toStartDate = $to;
        return $this;
    }

    /**
     * @return array
     */
    public function getContains(): array
    {
        return $this->contains;
    }

    /**
     * @return string
     */
    public function getFromStartDate(): string
    {
        return $this->fromStartDate;
    }

    /**
     * @return string
     */
    public function getToStartDate(): string
    {
        return $this->toStartDate;
    }

}