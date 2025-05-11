<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
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

    public function create(\PDO $pdo): bool
{
    $stmt = $pdo->prepare("
        INSERT INTO projects (projectName, bufferDays) 
        VALUES (:projectName, :bufferDays)
    ");

    if ($stmt->execute([
        ':projectName' => $this->projectName,
        ':bufferDays' => $this->bufferDays
    ])) {
        $this->projectId = (int)$pdo->lastInsertId();

        //fetching again to get dates and times from database
        $fresh = self::selectById($pdo, $this->projectId);
        if ($fresh) {
            $this->creationTime = $fresh->getCreationTime();
            $this->startDate = $fresh->getStartDate();
            $this->endDate = $fresh->getEndDate();
            //TODO: revise if buffered date should be calculated here or in database
            $this->bufferedDate = $fresh->getBufferedDate();
        }

        return true;
    }

    return false;
}


public function updateProject(\PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare("
        UPDATE projects 
        SET projectName = :projectName, creationTime = :creationTime, startDate = :startDate, 
            endDate = :endDate, bufferDays = :bufferDays, bufferedDate = :bufferedDate 
        WHERE projectId = :id
    ");

    return $stmt->execute([
        ':id' => $id,
        ':projectName' => $this->projectName,
        ':creationTime' => $this->creationTime,
        ':startDate' => $this->startDate,
        ':endDate' => $this->endDate,
        ':bufferDays' => $this->bufferDays,
        ':bufferedDate' => $this->bufferedDate
    ]);
}

public function deleteProject(\PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare("DELETE FROM projects WHERE projectId = :id");
    return $stmt->execute([':id' => $id]);
}

public static function selectById(\PDO $pdo, int $id): ?self
{
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE projectId = :id");
    $stmt->execute([':id' => $id]);
    $data = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($data) {
        $project = new self($data['projectId'], $data['projectName'], $data['bufferDays']);
        $project->setCreationTime($data['creationTime']);
        $project->setStartDate($data['startDate']);
        $project->setEndDate($data['endDate']);
        $project->setBufferedDate($data['bufferedDate']);
        return $project;
    }

    return null;
}

public static function selectAll(\PDO $pdo): array
{
    $stmt = $pdo->query("SELECT * FROM projects");
    $projects = [];

    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
        $project = new self($row['projectId'], $row['projectName'], $row['bufferDays']);
        $project->setCreationTime($row['creationTime']);
        $project->setStartDate($row['startDate']);
        $project->setEndDate($row['endDate']);
        $project->setBufferedDate($row['bufferedDate']);
        $projects[] = $project;
    }

    return $projects;
}

public static function searchWithFilters(array $filters)
{
    $query = self::query();

    if (!empty($filters['serialNumber'])) {
        $query->where('serialNumber', 'like', '%' . $filters['serialNumber'] . '%');
    }

    if (!empty($filters['projectTitle'])) {
        $query->where('title', 'like', '%' . $filters['projectTitle'] . '%');
    }

    if (!empty($filters['projectStatus'])) {
        $query->where('status', 'like', '%' . $filters['projectStatus'] . '%');
    }

    if (!empty($filters['supplierName'])) {
        $query->where('supplierName', 'like', '%' . $filters['supplierName'] . '%');
    }

    if (!empty($filters['clientName'])) {
        $query->where('clientName', 'like', '%' . $filters['clientName'] . '%');
    }

    return $query->get();
}

}

