<?php


namespace App\Bookstore\PaymentManager\Providers;


class Bunq implements \App\Bookstore\PaymentManager\Interfaces\Payment
{
    protected $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function authorizeAccount()
    {
        return true;
    }

    public function executePayment()
    {
        if ($this->amount > 15.00) {
            return false;
        }

        return true;
    }
}
