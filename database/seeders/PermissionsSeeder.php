<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Posts Permissions
        Permission::create(['name' => 'view_unpublished_posts']);
        Permission::create(['name' => 'create_posts']);
        Permission::create(['name' => 'edit_posts']);
        Permission::create(['name' => 'edit_own_posts']);
        Permission::create(['name' => 'delete_posts']);
        Permission::create(['name' => 'delete_own_posts']);
        Permission::create(['name' => 'restore_posts']);
        Permission::create(['name' => 'restore_own_posts']);
        Permission::create(['name' => 'force_delete_posts']);
        Permission::create(['name' => 'force_delete_own_posts']);
        Permission::create(['name' => 'publish_posts']);

        // Tags Permissions
        Permission::create(['name' => 'view_tags']);
        Permission::create(['name' => 'create_tags']);
        Permission::create(['name' => 'edit_tags']);
        Permission::create(['name' => 'delete_tags']);
        Permission::create(['name' => 'restore_tags']);
        Permission::create(['name' => 'force_delete_tags']);

        // Categories Permissions
        Permission::create(['name' => 'view_categories']);
        Permission::create(['name' => 'create_categories']);
        Permission::create(['name' => 'edit_categories']);
        Permission::create(['name' => 'delete_categories']);
        Permission::create(['name' => 'restore_categories']);
        Permission::create(['name' => 'force_delete_categories']);

        Permission::create(['name' => 'view_users']);
        Permission::create(['name' => 'create_users']);
        Permission::create(['name' => 'edit_users']);
        Permission::create(['name' => 'delete_users']);

        Permission::create(['name' => 'view_comments']);

        $administrator = Role::create(['name' => 'administrator']);
        $editor = Role::create(['name' => 'editor']);
        $author = Role::create(['name' => 'author']);
        $contributor = Role::create(['name' => 'contributor']);
        Role::create(['name' => 'subscriber']);

        $this->assignPermission($administrator);
        $administrator->givePermissionTo('view_users');
        $administrator->givePermissionTo('create_users');
        $administrator->givePermissionTo('edit_users');
        $administrator->givePermissionTo('delete_users');
        $administrator->givePermissionTo('view_comments');

        $this->assignPermission($editor);

        $contributor->givePermissionTo('create_posts');
        $contributor->givePermissionTo('edit_own_posts');
        $contributor->givePermissionTo('delete_own_posts');
        $contributor->givePermissionTo('restore_own_posts');
        $contributor->givePermissionTo('force_delete_own_posts');

        $author->givePermissionTo('create_posts');
        $author->givePermissionTo('edit_own_posts');
        $author->givePermissionTo('delete_own_posts');
        $author->givePermissionTo('restore_own_posts');
        $author->givePermissionTo('force_delete_own_posts');
        $author->givePermissionTo('publish_posts');

    }

    protected function assignPermission(\Spatie\Permission\Contracts\Role|Role $role): void
    {
        $role->givePermissionTo('view_unpublished_posts');
        $role->givePermissionTo('create_posts');
        $role->givePermissionTo('edit_posts');
        $role->givePermissionTo('edit_own_posts');
        $role->givePermissionTo('delete_posts');
        $role->givePermissionTo('delete_own_posts');
        $role->givePermissionTo('restore_posts');
        $role->givePermissionTo('restore_own_posts');
        $role->givePermissionTo('force_delete_posts');
        $role->givePermissionTo('force_delete_own_posts');
        $role->givePermissionTo('publish_posts');
        $role->givePermissionTo('view_tags');
        $role->givePermissionTo('create_tags');
        $role->givePermissionTo('edit_tags');
        $role->givePermissionTo('delete_tags');
        $role->givePermissionTo('restore_tags');
        $role->givePermissionTo('force_delete_tags');
        $role->givePermissionTo('view_categories');
        $role->givePermissionTo('create_categories');
        $role->givePermissionTo('edit_categories');
        $role->givePermissionTo('delete_categories');
        $role->givePermissionTo('restore_categories');
        $role->givePermissionTo('force_delete_categories');

    }
}
