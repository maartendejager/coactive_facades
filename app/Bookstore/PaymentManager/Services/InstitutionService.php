<?php


namespace App\Bookstore\PaymentManager\Services;


use App\Bookstore\PaymentManager\Providers\Bunq;

class InstitutionService
{
    public static function findPaymentInstitutionByName(string $InstitutionName)
    {
        return new Bunq();
    }

}
