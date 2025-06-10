<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Definição dos módulos e suas ações permitidas
     */
    private array $modules = [
        'news'       => ['create', 'edit', 'delete', 'view'],
        'auditorium' => ['create', 'edit', 'delete', 'view', 'change_status'],
    ];

    /**
     * Definição das roles e suas permissões
     */
    private array $rolePermissions = [
        'admin' => '*', // Todas as permissões
        'news'  => [
            'modules'      => ['news'],
            'restrictions' => [], // Sem restrições - pode fazer tudo com news
        ],
        'auditorium' => [
            'modules' => ['auditorium'],
            'actions' => ['view', 'edit', 'change_status'], // Só essas ações específicas
        ],
    ];

    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->createPermissions();
        $this->createRoles();

        $this->command->info('Roles and permissions created successfully!');
    }

    /**
     * Cria todas as permissões baseadas nos módulos definidos
     */
    private function createPermissions(): void
    {
        $this->command->info('Creating permissions...');

        foreach ($this->modules as $module => $actions) {
            foreach ($actions as $action) {
                $permissionName = $this->formatPermissionName($action, $module);

                Permission::firstOrCreate([
                    'name'       => $permissionName,
                    'guard_name' => 'web',
                ]);

                $this->command->line("  - Created: {$permissionName}");
            }
        }
    }

    /**
     * Cria as roles e atribui suas respectivas permissões
     */
    private function createRoles(): void
    {
        $this->command->info('Creating roles...');

        foreach ($this->rolePermissions as $roleName => $config) {
            $role = Role::firstOrCreate([
                'name'       => $roleName,
                'guard_name' => 'web',
            ]);

            // Limpa permissões existentes antes de atribuir novas
            $role->permissions()->detach();

            if ($config === '*') {
                // Admin tem todas as permissões
                $role->givePermissionTo(Permission::all());
                $this->command->line("  - Role '{$roleName}': ALL PERMISSIONS");
            } else {
                $permissions = $this->resolveRolePermissions($config);

                if (!empty($permissions)) {
                    $role->givePermissionTo($permissions);
                    $this->command->line("  - Role '{$roleName}': " . count($permissions) . " permissions");
                }
            }
        }
    }

    /**
     * Resolve as permissões específicas para uma role baseada na configuração
     */
    private function resolveRolePermissions(array $config): array
    {
        $permissions    = [];
        $modules        = $config['modules'] ?? [];
        $allowedActions = $config['actions'] ?? null;
        $restrictions   = $config['restrictions'] ?? [];

        foreach ($modules as $module) {
            if (!isset($this->modules[$module])) {
                continue;
            }

            $moduleActions = $this->modules[$module];

            // Se há ações específicas definidas, usa apenas essas
            if ($allowedActions !== null) {
                $moduleActions = array_intersect($moduleActions, $allowedActions);
            }

            // Remove ações restritas
            $moduleActions = array_diff($moduleActions, $restrictions);

            foreach ($moduleActions as $action) {
                $permissions[] = $this->formatPermissionName($action, $module);
            }
        }

        return $permissions;
    }

    /**
     * Formata o nome da permissão de forma consistente
     */
    private function formatPermissionName(string $action, string $module): string
    {
        return "{$action} {$module}";
    }

    /**
     * Método auxiliar para obter permissões de módulos específicos (mantido para compatibilidade)
     */
    private function getModulePermissions(array $modules, array $actions = null): array
    {
        $permissions = [];

        foreach ($modules as $module) {
            if (!isset($this->modules[$module])) {
                continue;
            }

            $moduleActions = $actions ?? $this->modules[$module];

            foreach ($moduleActions as $action) {
                if (in_array($action, $this->modules[$module])) {
                    $permissions[] = $this->formatPermissionName($action, $module);
                }
            }
        }

        return $permissions;
    }
}
