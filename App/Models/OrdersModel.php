<?php

namespace App\Models;
use Libraries\Connection;
use PDO;

class OrdersModel
{
    //Renvoie la liste de toutes les commandes
    public function getAllOrders(): array
    {
        //connection à la base de données
        $connect = new Connection();
        $db = $connect->getPdo();
        
        //récupération des commandes
        $query = $db->prepare(
            'SELECT ord.orderNumber, ord.orderDate, ord.status, ord.customerNumber, cust.customerName
            FROM orders ord
            INNER JOIN customers cust ON ord.customerNumber = cust.customerNumber
            ORDER BY ord.orderNumber'
        );
        
        $query->execute();
        
        $orders = $query->fetchAll();
        
        return $orders;
    }
    
    
    public function getOrderDetail(int $orderId): array|false
    {
        $connect = new Connection();
        $db = $connect->getPdo();
    
        // Récupération des détails d'une commande avec l'orderId
        $query = $db->prepare(
            'SELECT orddet.orderNumber, orddet.productCode, prdct.productName, orddet.quantityOrdered, orddet.priceEach, (orddet.quantityOrdered * orddet.priceEach) AS subTotal
            FROM orderdetails orddet
            INNER JOIN products prdct ON orddet.productCode = prdct.productCode
            WHERE orddet.orderNumber = :orderId
            ORDER BY orddet.orderNumber'
        );
        
        $query->bindParam(':orderId', $orderId, PDO::PARAM_STR);
        
        $query->execute();
        
        $order = $query->fetchAll();
        
        return $order;
    }
    
    
    
    
    public function getTotal(int $orderId): float
    {
        $connect = new Connection();
        $db = $connect->getPdo();
        
        $query = $db->prepare(
            'SELECT SUM(priceEach * quantityOrdered) AS total
            FROM orderdetails
            WHERE orderNumber = :orderId
            '
        );
        
        $query->execute([
            'orderId' => $orderId
        ]);
        
        $result = $query->fetch();
        return $result['total'];
    }
    
}