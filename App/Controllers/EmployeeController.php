<?php

namespace App\Controllers;
use Libraries\Controller;
use App\Models\EmployeeModel;

class EmployeeController extends Controller
{
    public function showEmployee(): void
    {
        // Récupération de la liste des employés
        $model = new EmployeeModel();
        $employees = $model->getAllEmployees();
        
        
        //Affiche la vue
        $this->render('employee.phtml', [
            'employees' => $employees
        ]);
    }
    
    public function showEmployeeDetail(): void
    {
        // Récupération de l'id de l'employé
        $model = new EmployeeModel();
        $employee = $model->getEmployeeById($_GET['id']);
        
        //Affiche la vue
        $this->render('detail_employee.phtml', [
            'employee' => $employee
        ]);
    }
}