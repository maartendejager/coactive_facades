<?php


namespace App\Bookstore\PaymentManager\Providers;


use \App\Bookstore\PaymentManager\Interfaces\FinancialInstitution;


class Bunq implements FinancialInstitution
{
    public function authorizeAccount()
    {
        return true;
    }

    public function executePayment(string $amount)
    {
        if ($amount > 15.00) {
            return false;
        }

        return true;
    }
}
