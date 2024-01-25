<?php

use App\PaymentGateway;
use Illuminate\Database\Seeder;
use App\Status;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $status_lists = [ 'Active', 'Inactive' ];

        foreach($status_lists as $status){
            Status::updateOrCreate(
                ['name' => $status],
                ['name' => $status]
            );
        }

        //todo:: add code for insert status in datbase if not exists
        // $payment_gateway_markup =
        // [
        //     [
        //         'name' => 'authorizenet',
        //         'image' => 1,
        //         'description' => '',
        //         'status' => 1,
        //         'test_mode' => 1,
        //         'credentials'=> json_encode([
        //             'merchant_login_id' => '',
        //             'merchant_transaction_id'=> ''
        //         ])
        //     ],[
        //         'name' => 'pagali',
        //         'image' => 1,
        //         'description' => '',
        //         'status' => 1,
        //         'test_mode' => 1,
        //         'credentials'=> json_encode([
        //             'page_id' => '',
        //             'entity_id'=> ''
        //         ])
        //     ]
        // ];

        // PaymentGateway::insert($payment_gateway_markup);

//        foreach ($payment_gateway_markup as $payment_gate) {
//            PaymentGateway::create($payment_gate);
//        }

//        $this->call(UsersTableSeeder::class);
//        $permissions = [
//            'page-settings-wishlist-page',
//        ];
//
//        foreach ($permissions as $permission) {
//             \Spatie\Permission\Models\Permission::where(['name' => $permission])->delete();
//             \Spatie\Permission\Models\Permission::create(['name' => $permission, 'guard_name' => 'admin']);
//        }
    }
}
