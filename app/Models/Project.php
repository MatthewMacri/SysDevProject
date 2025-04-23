<?php

namespace App\Models;

class project
{
    private ?int $projectId;
    private string $projectName;
    /*All dates and times are nullable strings because they will be fetched from DB
      to ensure data consistency*/
    private ?string $creationTime;
    private ?string $startDate;
    private ?string $endDate;
    private int $bufferDays;
    private ?string $bufferedDate;

    /**
     * @param int|null $projectId
     * @param string $projectName
     * @param int $bufferDays
     */
    public function __construct(?int $projectId, string $projectName, int $bufferDays)
    {
        $this->projectId = $projectId;
        $this->projectName = $projectName;
        $this->bufferDays = $bufferDays;
    }

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setProjectId(?int $projectId): void
    {
        $this->projectId = $projectId;
    }

    public function getProjectName(): string
    {
        return $this->projectName;
    }

    public function setProjectName(string $projectName): void
    {
        $this->projectName = $projectName;
    }

    public function getCreationTime(): ?string
    {
        return $this->creationTime;
    }

    public function setCreationTime(?string $creationTime): void
    {
        $this->creationTime = $creationTime;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getBufferDays(): int
    {
        return $this->bufferDays;
    }

    public function setBufferDays(int $bufferDays): void
    {
        $this->bufferDays = $bufferDays;
    }

    public function getBufferedDate(): ?string
    {
        return $this->bufferedDate;
    }

    public function setBufferedDate(?string $bufferedDate): void
    {
        $this->bufferedDate = $bufferedDate;
    }
}

