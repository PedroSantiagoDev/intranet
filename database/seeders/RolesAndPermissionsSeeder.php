<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    private array $permissions = [
        'links' => ['create', 'edit', 'delete'],
        'news'  => ['create', 'edit', 'delete'],
    ];

    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->createPermissions();
        $this->createRoles();
    }

    private function createPermissions(): void
    {
        foreach ($this->permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name'       => "$action $module",
                    'guard_name' => 'web',
                ]);
            }
        }
    }

    private function createRoles(): void
    {
        // Função Admin: Todas as permissões
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web'])
            ->givePermissionTo(Permission::all());

        // Função Editor: Permissões de User + Edição de imagens
        $editorPermissions = array_merge(
            $this->getModulePermissions(['links', 'news']),
        );

        Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web'])
            ->givePermissionTo($editorPermissions);

        // Função User: Links e Reservas
        Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web'])
            ->givePermissionTo($this->getModulePermissions(['links']));
    }

    private function getModulePermissions(array $modules): array
    {
        $permissions = [];

        foreach ($modules as $module) {
            foreach ($this->permissions[$module] as $action) {
                $permissions[] = "$action $module";
            }
        }

        return $permissions;
    }

}
