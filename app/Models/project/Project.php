<?php

namespace App\Models;

require_once dirname(__DIR__) . '/core/databasecontroller.php';

use Controllers\DatabaseController;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // Class properties to hold project details
    private ?int $projectId;          // ID of the project
    private string $projectName;      // Name of the project
    private ?string $creationTime;   // Creation timestamp of the project
    private ?string $startDate;      // Start date of the project
    private ?string $endDate;        // End date of the project
    private int $bufferDays;         // Buffer days for the project
    private ?string $bufferedDate;  // Buffered date, calculated from endDate + bufferDays

    /**
     * Constructor to initialize the project with essential details.
     *
     * @param int|null $projectId ID of the project (optional)
     * @param string $projectName Name of the project
     * @param int $bufferDays Number of buffer days for the project
     */
    public function __construct(?int $projectId, string $projectName, int $bufferDays)
    {
        $this->projectId = $projectId;
        $this->projectName = $projectName;
        $this->bufferDays = $bufferDays;
    }

    // Getter and setter methods for class properties

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

    /**
     * Creates a new project and stores it in the database.
     *
     * @param \PDO $pdo Database connection
     * @return bool Returns true if the project was successfully created
     */
    public function create(\PDO $pdo): bool
    {
        // Insert project data into the database
        $stmt = $pdo->prepare("
            INSERT INTO projects (projectName, bufferDays) 
            VALUES (:projectName, :bufferDays)
        ");

        // Execute the query with project data
        if ($stmt->execute([
            ':projectName' => $this->projectName,
            ':bufferDays' => $this->bufferDays
        ])) {
            // After inserting, get the newly inserted project ID
            $this->projectId = (int)$pdo->lastInsertId();

            // Fetch the project from the database to get the additional fields (e.g. dates)
            $fresh = self::selectById($pdo, $this->projectId);
            if ($fresh) {
                $this->creationTime = $fresh->getCreationTime();
                $this->startDate = $fresh->getStartDate();
                $this->endDate = $fresh->getEndDate();
                $this->bufferedDate = $fresh->getBufferedDate();
            }

            return true;
        }

        return false;
    }

    /**
     * Updates the project information in the database.
     *
     * @param \PDO $pdo Database connection
     * @param int $id Project ID
     * @return bool Returns true if the project was updated successfully
     */
    public function updateProject(\PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("
            UPDATE projects 
            SET projectName = :projectName, creationTime = :creationTime, startDate = :startDate, 
                endDate = :endDate, bufferDays = :bufferDays, bufferedDate = :bufferedDate 
            WHERE projectId = :id
        ");

        // Execute the update query with project data
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

    /**
     * Deletes a project from the database.
     *
     * @param \PDO $pdo Database connection
     * @param int $id Project ID
     * @return bool Returns true if the project was deleted successfully
     */
    public function deleteProject(\PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE projectId = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Selects a project by its ID from the database.
     *
     * @param \PDO $pdo Database connection
     * @param int $id Project ID
     * @return ?self Returns the project object if found, otherwise null
     */
    public static function selectById(\PDO $pdo, int $id): ?self
    {
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE projectId = :id");
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data) {
            // Create a new Project object and populate it with the data from the database
            $project = new self($data['projectId'], $data['projectName'], $data['bufferDays']);
            $project->setCreationTime($data['creationTime']);
            $project->setStartDate($data['startDate']);
            $project->setEndDate($data['endDate']);
            $project->setBufferedDate($data['bufferedDate']);
            return $project;
        }

        return null;
    }

    /**
     * Selects all projects from the database.
     *
     * @param \PDO $pdo Database connection
     * @return array Returns an array of Project objects
     */
    public static function selectAll(\PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM projects");
        $projects = [];

        // Loop through each result and create a Project object
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

    /**
     * Search for projects with specific filters.
     *
     * @param array $filters Filters to apply to the search query
     * @return array Returns an array of filtered projects
     */
    public static function searchWithFilters(array $filters)
    {
        $pdo = DatabaseController::getInstance()->getConnection();

        // Basic query to search for projects, joining with client and supplier tables
        $query = "
            SELECT 
                p.serial_number,
                p.project_name,
                p.project_description,
                p.status,
                c.client_name,
                s.supplier_name
            FROM Project p
            JOIN Client c ON p.client_id = c.client_id
            JOIN Supplier s ON p.supplier_id = s.supplier_id
            WHERE 1=1
        ";

        $params = [];

        // Add filters to the query dynamically based on user input
        if (!empty($filters['serialNumber'])) {
            $query .= " AND p.serial_number LIKE :serialNumber";
            $params[':serialNumber'] = '%' . $filters['serialNumber'] . '%';
        }

        if (!empty($filters['projectTitle'])) {
            $query .= " AND p.project_name LIKE :projectTitle";
            $params[':projectTitle'] = '%' . $filters['projectTitle'] . '%';
        }

        if (!empty($filters['projectStatus'])) {
            $query .= " AND p.status LIKE :projectStatus";
            $params[':projectStatus'] = '%' . $filters['projectStatus'] . '%';
        }

        if (!empty($filters['supplierName'])) {
            $query .= " AND s.supplier_name LIKE :supplierName";
            $params[':supplierName'] = '%' . $filters['supplierName'] . '%';
        }

        if (!empty($filters['clientName'])) {
            $query .= " AND c.client_name LIKE :clientName";
            $params[':clientName'] = '%' . $filters['clientName'] . '%';
        }

        // Prepare and execute the query
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        // Return the results as an associative array
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}