<?php


namespace App\Bookstore\PaymentManager\Interfaces;


interface Payment
{
    public function authorizeAccount();

    public function executePayment();
}
