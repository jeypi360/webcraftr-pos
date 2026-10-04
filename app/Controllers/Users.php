<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SaleModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    public function index()
    {
        return view('users/index', ['users' => (new UserModel())->findAll()]);
    }

    public function new()
    {
        return view('users/form', ['user' => [], 'errors' => []]);
    }

    public function create()
    {
        return $this->save(null);
    }

    public function edit(int $id)
    {
        $user = (new UserModel())->find($id);
        if (! $user) {
            throw PageNotFoundException::forPageNotFound();
        }
        return view('users/form', ['user' => $user, 'errors' => []]);
    }

    public function update(int $id)
    {
        return $this->save($id);
    }

    private function save(?int $id)
    {
        $model = new UserModel();
        $existing = $id === null ? null : $model->find($id);
        if ($id !== null && ! $existing) {
            throw PageNotFoundException::forPageNotFound();
        }
        $values = [
            'username' => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];
        $password = (string) $this->request->getPost('password');
        $file = $this->request->getFile('avatar');
        $hasUpload = $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;
        $unique = $id === null ? 'is_unique[users.username]' : 'is_unique[users.username,id,' . $id . ']';
        $rules = [
            'username' => 'required|max_length[50]|' . $unique,
            'full_name' => 'required|max_length[100]',
            'password' => ($id === null ? 'required|' : 'permit_empty|') . 'min_length[8]',
        ];
        if ($hasUpload) {
            $rules['avatar'] = 'uploaded[avatar]|max_size[avatar,2048]|mime_in[avatar,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]';
        }
        // File rules inspect the request; never pass UploadedFile as validation data.
        if (! $this->validateData($values + ['password' => $password], $rules)) {
            return $this->form($id, $values, $existing, $this->validator->getErrors());
        }
        if ($password !== '') {
            $values['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $newPath = null;
        if ($hasUpload) {
            $info = $file->isValid() ? @getimagesize($file->getTempName()) : false;
            if ($info === false || ! in_array($info[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) {
                return $this->form($id, $values, $existing, ['avatar' => 'Choose a valid JPG or PNG.']);
            }
            $directory = FCPATH . 'uploads/avatars/';
            if (! is_dir($directory) && ! mkdir($directory, 0755, true) && ! is_dir($directory)) {
                return $this->form($id, $values, $existing, ['avatar' => 'Avatar folder is not writable.']);
            }
            $filename = bin2hex(random_bytes(16)) . ($info[2] === IMAGETYPE_PNG ? '.png' : '.jpg');
            $newPath = $directory . $filename;
            try {
                service('image')->withFile($file->getTempName())->fit(160, 160, 'center')->save($newPath, 85);
            } catch (\Throwable $exception) {
                if (is_file($newPath)) {
                    unlink($newPath);
                }
                log_message('error', 'Avatar preparation failed: ' . $exception->getMessage());
                return $this->form($id, $values, $existing, ['avatar' => 'Could not prepare the image. Check PHP GD and folder permissions.']);
            }
            $values['avatar'] = $filename;
        }
        try {
            if ($id === null) {
                $model->insert($values + ['created_at' => date('Y-m-d H:i:s')]);
            } else {
                $model->update($id, $values);
            }
        } catch (\Throwable $exception) {
            if ($newPath && is_file($newPath)) {
                unlink($newPath);
            }
            throw $exception;
        }
        if ($newPath && ! empty($existing['avatar'])) {
            $old = $directory . basename($existing['avatar']);
            if (is_file($old)) {
                unlink($old);
            }
        }
        return redirect()->to('/users')->with('success', $id === null ? 'Staff member created.' : 'Staff member updated.');
    }

    private function form(?int $id, array $values, ?array $existing, array $errors)
    {
        return view('users/form', ['user' => ['id' => $id, 'avatar' => $existing['avatar'] ?? null] + $values, 'errors' => $errors]);
    }

    public function delete(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);
        if (! $user) {
            throw PageNotFoundException::forPageNotFound();
        }
        if ((int) session('user_id') === $id) {
            return redirect()->to('/users')->with('error', 'You cannot delete your own account.');
        }
        if ((new SaleModel())->where('sold_by', $id)->first()) {
            return redirect()->to('/users')->with('error', 'This staff member has sales history and cannot be deleted.');
        }
        $model->delete($id);
        if (! empty($user['avatar'])) {
            $path = FCPATH . 'uploads/avatars/' . basename($user['avatar']);
            if (is_file($path)) {
                unlink($path);
            }
        }
        return redirect()->to('/users')->with('success', 'Staff member deleted.');
    }
}
