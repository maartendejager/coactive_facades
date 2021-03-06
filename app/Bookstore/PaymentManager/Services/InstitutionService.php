<?php


namespace App\Bookstore\PaymentManager\Services;


use App\Bookstore\PaymentManager\Providers\Ing;
use App\Bookstore\PaymentManager\Providers\Bunq;
use App\Bookstore\PaymentManager\Providers\Triodos;

class InstitutionService
{
    public static function findPaymentInstitutionByName(string $InstitutionName)
    {
        switch ($InstitutionName) {
            case 1 :
                return new Bunq();
                break;
            case 2:
                return new Ing();
                break;
            case 3:
                return new Triodos();
                break;
            default:
                return new Bunq();
        }
    }

}
