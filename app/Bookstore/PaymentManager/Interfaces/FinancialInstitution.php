<?php


namespace App\Bookstore\PaymentManager\Interfaces;


interface FinancialInstitution
{
    public function authorizeAccount();

    public function executePayment(string $amount);
}
