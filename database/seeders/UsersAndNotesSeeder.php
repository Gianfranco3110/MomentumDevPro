<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\RoleHierarchy;
use Illuminate\Support\Facades\Hash;

class UsersAndNotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfUsers = 3;
        $numberOfNotes = 100;
        $usersIds = array();
        $statusIds = array();
        $userStatus = array(
            'Active',
            'Inactive',
        );
        /* Create roles */
        $adminRole = $roleAdmin = Role::create(['name' => 'admin']);
        RoleHierarchy::create([
            'role_id' => $adminRole->id,
            'hierarchy' => 1,
        ]);
        $userRole = Role::create(['name' => 'user']);
        RoleHierarchy::create([
            'role_id' => $userRole->id,
            'hierarchy' => 2,
        ]);
        $guestRole = Role::create(['name' => 'guest']);
        RoleHierarchy::create([
            'role_id' => $guestRole->id,
            'hierarchy' => 3,
        ]);

        $faker = Faker::create();
        /*  insert status  */
        DB::table('status')->insert([
            'name' => 'Activo',
            'class' => 'primary',
        ]);
        array_push($statusIds, DB::getPdo()->lastInsertId());
        DB::table('status')->insert([
            'name' => 'Inactivo',
            'class' => 'danger',
        ]);
        array_push($statusIds, DB::getPdo()->lastInsertId());
        /*  insert users   */
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'adress_all' => $faker->address(),
            'type_document' => "V",
            'number_document' => "051651645",
            'password' => Hash::make("password"), // password
            'remember_token' => Str::random(10),
            'menuroles' => 'user,admin',
            'status' => 'Active'
        ]);
        $user->assignRole('user');
        $user->assignRole($roleAdmin);
        for($i = 0; $i<$numberOfUsers; $i++){
            $user = User::create([
                'name' => $faker->name(),
                'adress_all' => $faker->address(),
                'type_document' => "V",
                'number_document' => "12002623262",
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make("123456"), // password
                'remember_token' => Str::random(10),
                'menuroles' => 'user',
                'status' => $userStatus[0]
            ]);
            $user->assignRole('user');
            array_push($usersIds, $user->id);
        }
        /*  insert notes  */
        for($i = 0; $i<$numberOfNotes; $i++){
            $noteType = $faker->word();
            if(random_int(0,1)){
                $noteType .= ' ' . $faker->word();
            }
            DB::table('notes')->insert([
                'title'         => $faker->sentence(4,true),
                'content'       => $faker->paragraph(3,true),
                'status_id'     => $statusIds[random_int(0,count($statusIds) - 1)],
                'note_type'     => $noteType,
                'applies_to_date' => $faker->date(),
                'users_id'      => $usersIds[random_int(0,$numberOfUsers-1)]
            ]);
        }
    }
}
