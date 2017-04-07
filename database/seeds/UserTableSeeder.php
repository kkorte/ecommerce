<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Hideyo\Backend\Models\Language as Language;
use Hideyo\Backend\Models\Company as Company;
use Hideyo\Backend\Models\Shop as Shop;
use Hideyo\Backend\Models\User as User;
use Hideyo\Backend\Models\Role as Role;
use Hideyo\Backend\Models\Permission as Permission;

class UserTableSeeder extends Seeder
{

    public function run()
    {
        $user = new User;

        DB::table($user->getTable())->delete();

        $user->username = 'admin@admin.com';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('admin');

        $shop = Shop::where('title', '=', 'hideyo')->first();
        $user->selected_shop_id = $shop->id;

        $user->confirmation_code = md5(uniqid(mt_rand(), true));
        $user->confirmed = 1;

        if (! $user->save()) {
            Log::info('Unable to create user '.$user->email, (array)$user->errors());
        } else {
            Log::info('Created user "'.$user->email.'" <'.$user->email.'>');
        }




    }
}
