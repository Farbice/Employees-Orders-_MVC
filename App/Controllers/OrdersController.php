<?php

namespace App\Controllers;
use Libraries\Controller;
use App\Models\OrdersModel;

class OrdersController extends Controller
{
    public function showOrders(): void
    {
        
        //Récupération de la liste des commandes
        $model = new OrdersModel();
        $orders = $model->getAllOrders();
        
        
        //Affichage de la vue
        $this->render('orders.phtml', [
            'orders' => $orders
        ]);
        
    }
    
    public function showOrderDetail(): void
    {
        //Récupération de l'order id
        $model = new OrdersModel();
        $order = $model->getOrderDetail($_GET['id']);
        $total = $model->getTotal($_GET['id']);
        //var_dump($order);
        
        //Affichage de la vue
        $this->render('detail_order.phtml', [
            'order' => $order,
            'total' => $total,
        ]);
    }
    
}