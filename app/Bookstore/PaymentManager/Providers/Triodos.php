<?php


namespace App\Bookstore\PaymentManager\Providers;


use App\Bookstore\PaymentManager\Interfaces\FinancialInstitution;

class Triodos implements FinancialInstitution
{
    public function authorizeAccount()
    {
        return true;
    }

    public function executePayment(string $amount)
    {
        if ($amount > 50000.00) {
            return false;
        }

        return true;
    }
}
