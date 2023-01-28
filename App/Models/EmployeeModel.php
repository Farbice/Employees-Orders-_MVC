<?php

namespace App\Models;

use Libraries\Connection;

class EmployeeModel
{
    //Renvoie la liste de tous les employés
    public function getAllEmployees(): array
    {
        //connection à la base de données
        $connect = new Connection();
        $db = $connect->getPdo();
        
        //récupération des employees
        $query = $db->prepare(
            'SELECT emp.employeeNumber, emp.lastName, emp.firstName, emp.email, emp.jobTitle, off.city, man.firstName AS managerFirstName, man.lastName AS managerLastName
            FROM employees emp
            INNER JOIN offices off ON emp.officeCode = off.officeCode
            LEFT JOIN employees man ON emp.reportsTo = man.employeeNumber
            ORDER BY emp.firstName'
        );
        
        $query->execute();
    
        $employees = $query->fetchAll();
        
        return $employees;
    }
    
    
    public function getEmployeeById(int $id): array|false
    {
        $connect = new Connection();
        $db = $connect->getPdo();
    
        // Récupération des informations de l'employé à partir du numéro dans l'url (requête SQL)
        $query = $db->prepare(
            'SELECT emp.employeeNumber, emp.extension, emp.lastName, emp.firstName, emp.email, emp.jobTitle, off.city, man.firstName AS managerFirstName, man.lastName AS managerLastName
            FROM employees emp
            INNER JOIN offices off ON emp.officeCode = off.officeCode
            LEFT JOIN employees man ON emp.reportsTo = man.employeeNumber
            WHERE emp.employeeNumber = :employeeNumber'
        );
        
        $query->execute([
            'employeeNumber' => $id
        ]);
        
        $employee = $query->fetch();
        
        return $employee;
    }
}