<?php
namespace Services;

use App\Models\Project;
use App\Models\Client;
use App\Models\Supplier;
use Controllers\DatabaseController;

class ProjectService {
    private Client $clientModel;
    private Supplier $supplierModel;
    private Project $projectModel;

    public function __construct(Project $projectModel, Client $clientModel, Supplier $supplierModel) {
        $this->projectModel = $projectModel;
        $this->clientModel = $clientModel;
        $this->supplierModel = $supplierModel;
    }

    public function createFullProject(array $data): void {
        $pdo = DatabaseController::getInstance()->getConnection();

        // 1. Create or find client
        $clientId = $this->clientModel->findOrCreate($data['client']);

        // 2. Create and configure the project object
        $project = clone $this->projectModel;
        $project->setProjectName($data['title']);
        $project->setSerialNumber($data['serial']);
        $project->setDescription($data['desc']);
        $project->setClientId($clientId);
        $project->setStartDate($data['start']);
        $project->setEndDate($data['end']);
        $project->setBufferDays(0); // Optional: calculate dynamically if needed
        $project->setStatus('prospecting');

        // 3. Insert into DB using your object method
        if (!$project->create($pdo)) {
            throw new \Exception("Failed to create project.");
        }

        $projectId = $project->getProjectId();

        // 4. Loop and process suppliers
        foreach ($data['suppliers'] as $supplier) {
            $supplierId = $this->supplierModel->findOrCreate([
                'name' => $supplier[0],
                'company' => $supplier[1],
                'email' => $supplier[2],
                'phone' => $supplier[3],
            ]);

            $this->supplierModel->linkToProject($supplierId, $projectId, $data['supplier_date']);
        }
    }
}