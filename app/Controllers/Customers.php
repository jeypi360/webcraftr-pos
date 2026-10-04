<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\SaleModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index()
    {
        return view('customers/index', ['customers' => (new CustomerModel())->findAll()]);
    }

    public function new()
    {
        return view('customers/form', ['customer' => [], 'errors' => []]);
    }

    public function create()
    {
        $values = $this->values();
        if (! $this->validateData($values, $this->rules())) {
            return view('customers/form', ['customer' => $values, 'errors' => $this->validator->getErrors()]);
        }
        (new CustomerModel())->insert($values + ['created_at' => date('Y-m-d H:i:s')]);
        return redirect()->to('/customers')->with('success', 'Customer created.');
    }

    public function edit(int $id)
    {
        $customer = (new CustomerModel())->find($id);
        if (! $customer) {
            throw PageNotFoundException::forPageNotFound();
        }
        return view('customers/form', ['customer' => $customer, 'errors' => []]);
    }

    public function update(int $id)
    {
        $model = new CustomerModel();
        if (! $model->find($id)) {
            throw PageNotFoundException::forPageNotFound();
        }
        $values = $this->values();
        if (! $this->validateData($values, $this->rules())) {
            return view('customers/form', ['customer' => ['id' => $id] + $values, 'errors' => $this->validator->getErrors()]);
        }
        $model->update($id, $values);
        return redirect()->to('/customers')->with('success', 'Customer updated.');
    }

    public function delete(int $id)
    {
        $model = new CustomerModel();
        if (! $model->find($id)) {
            throw PageNotFoundException::forPageNotFound();
        }
        if ((new SaleModel())->where('customer_id', $id)->first()) {
            return redirect()->to('/customers')->with('error', 'This customer has sales history and cannot be deleted.');
        }
        $model->delete($id);
        return redirect()->to('/customers')->with('success', 'Customer deleted.');
    }

    private function values(): array
    {
        return [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email' => trim((string) $this->request->getPost('email')),
            'phone' => trim((string) $this->request->getPost('phone')),
        ];
    }

    private function rules(): array
    {
        return ['full_name' => 'required|max_length[100]', 'email' => 'required|valid_email|max_length[100]', 'phone' => 'permit_empty|max_length[20]'];
    }
}
