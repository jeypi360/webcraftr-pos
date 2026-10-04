<?php

namespace App\Commands;

use App\Models\UserModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SetupStaff extends BaseCommand
{
    protected $group = 'Accounts';
    protected $name = 'staff:setup';
    protected $description = 'Set a staff password or create the first account locally.';
    protected $arguments = ['username' => 'Existing username, or new username for an empty users table.'];

    public function run(array $params)
    {
        $username = trim((string) ($params[0] ?? ''));
        if (! preg_match('/\A[a-zA-Z0-9_.-]{1,50}\z/', $username)) {
            CLI::error('Provide a username (letters, digits, underscore, dot, or hyphen).');
            return;
        }
        $model = new UserModel();
        $existing = $model->where('username', $username)->first();
        if (! $existing && $model->countAllResults() > 0) {
            CLI::error('For an existing database, use an existing username. New users can be added after logging in.');
            return;
        }
        $password = CLI::prompt('New password (input may be visible on screen)');
        if (strlen($password) < 8) {
            CLI::error('Password must be at least 8 characters.');
            return;
        }
        if ($existing) {
            $model->update($existing['id'], ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        } else {
            $name = trim(CLI::prompt('Full name'));
            if ($name === '' || mb_strlen($name) > 100) {
                CLI::error('A full name of at most 100 characters is required.');
                return;
            }
            $model->insert(['username' => $username, 'full_name' => $name, 'password' => password_hash($password, PASSWORD_DEFAULT), 'created_at' => date('Y-m-d H:i:s')]);
        }
        CLI::write('Staff account is ready.');
    }
}
