<?php


namespace App\Bookstore\PaymentManager\Providers;


use App\Bookstore\PaymentManager\Interfaces\FinancialInstitution;

class Ing implements FinancialInstitution
{
    public function authorizeAccount()
    {
        return true;
    }

    public function executePayment(string $amount)
    {
        if ($amount > 150.00) {
            return false;
        }

        return true;
    }
}
