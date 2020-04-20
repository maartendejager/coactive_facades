<?php

use Illuminate\Database\Seeder;
use \App\PaymentProvider;

class PaymentProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_providers')->delete();

        $payment_provider_bunq = new PaymentProvider([
                                                         'name' => 'bunq',
                                                         'api_address' => 'bunq.com/api',
                                                     ]);
        $payment_provider_bunq->save();

        $payment_provider_ing = new PaymentProvider([
                                                         'name' => 'ing',
                                                         'api_address' => 'ing.nl/api',
                                                     ]);
        $payment_provider_ing->save();

        $payment_provider_triodos = new PaymentProvider([
                                                         'name' => 'triodos',
                                                         'api_address' => 'triodos.nl/api',
                                                     ]);
        $payment_provider_triodos->save();
    }
}
