<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessagingMenuSeeder extends Seeder
{
    public function run()
    {
        // Obtener el ID del menulist "sidebar menu"
        $menulist = DB::table('menulist')->where('name', 'sidebar menu')->first();

        if (!$menulist) {
            $this->command->error('No se encontró el menulist "sidebar menu".');
            return;
        }

        $menuId = $menulist->id;

        // Obtener la próxima secuencia disponible
        $maxSeq = DB::table('menus')->where('menu_id', $menuId)->max('sequence') ?? 0;

        // ── Item 1: MENSAJERÍA (solo admin) ──────────────────────────────────
        $existsAdmin = DB::table('menus')
            ->where('menu_id', $menuId)
            ->where('href', '/mensajeria')
            ->exists();

        if (!$existsAdmin) {
            $adminMenuId = DB::table('menus')->insertGetId([
                'slug'      => 'link',
                'name'      => 'MENSAJERÍA',
                'icon'      => 'cil-chat-bubble',
                'href'      => '/mensajeria',
                'menu_id'   => $menuId,
                'sequence'  => $maxSeq + 1,
                'parent_id' => null,
            ]);

            DB::table('menu_role')->insert([
                'role_name' => 'admin',
                'menus_id'  => $adminMenuId,
            ]);

            $this->command->info('Menú MENSAJERÍA creado para admin.');
        } else {
            $this->command->warn('Menú MENSAJERÍA ya existe, omitido.');
        }

        // ── Item 2: MIS MENSAJES (solo user) ─────────────────────────────────
        $existsUser = DB::table('menus')
            ->where('menu_id', $menuId)
            ->where('href', '/mensajes')
            ->exists();

        if (!$existsUser) {
            $userMenuId = DB::table('menus')->insertGetId([
                'slug'      => 'link',
                'name'      => 'MIS MENSAJES',
                'icon'      => 'cil-envelope-letter',
                'href'      => '/mensajes',
                'menu_id'   => $menuId,
                'sequence'  => $maxSeq + 2,
                'parent_id' => null,
            ]);

            DB::table('menu_role')->insert([
                'role_name' => 'user',
                'menus_id'  => $userMenuId,
            ]);

            $this->command->info('Menú MIS MENSAJES creado para user.');
        } else {
            $this->command->warn('Menú MIS MENSAJES ya existe, omitido.');
        }
    }
}
