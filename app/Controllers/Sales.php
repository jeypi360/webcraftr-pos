<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;

class Sales extends BaseController
{
    public function new()
    {
        return view('sales/form', [
            'products' => (new ProductModel())->orderBy('name')->findAll(),
            'customers' => (new CustomerModel())->orderBy('full_name')->findAll(),
            'errors' => [],
            'values' => [],
        ]);
    }

    public function create()
    {
        $values = [
            'product_id' => (string) $this->request->getPost('product_id'),
            'customer_id' => (string) $this->request->getPost('customer_id'),
            'quantity' => (string) $this->request->getPost('quantity'),
        ];
        $rules = [
            'product_id' => 'required|is_natural_no_zero',
            'customer_id' => 'permit_empty|is_natural_no_zero',
            'quantity' => 'required|is_natural_no_zero',
        ];
        $errors = [];
        if (! $this->validateData($values, $rules)) {
            $errors = $this->validator->getErrors();
        }
        if (! $errors && $values['customer_id'] !== '' && ! (new CustomerModel())->find((int) $values['customer_id'])) {
            $errors['customer_id'] = 'Select an existing customer.';
        }
        if ($errors) {
            return $this->form($values, $errors);
        }

        $quantity = (int) $values['quantity'];
        $productId = (int) $values['product_id'];
        $db = db_connect();
        $db->transBegin();
        try {
            // A conditional UPDATE ensures concurrent sales cannot oversell stock.
            $db->query('UPDATE products SET stock_quantity = stock_quantity - ? WHERE id = ? AND stock_quantity >= ?', [$quantity, $productId, $quantity]);
            if ($db->affectedRows() !== 1) {
                $db->transRollback();
                $product = (new ProductModel())->find($productId);
                return $this->form($values, ['quantity' => $product ? 'Not enough stock available.' : 'Select an existing product.']);
            }
            $product = $db->table('products')->where('id', $productId)->get()->getRowArray();
            $total = number_format(round((float) $product['price'] * $quantity, 2), 2, '.', '');
            (new SaleModel())->insert([
                'product_id' => $productId,
                'customer_id' => $values['customer_id'] === '' ? null : (int) $values['customer_id'],
                'sold_by' => (int) session('user_id'),
                'quantity' => $quantity,
                'total_price' => $total,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            if ($db->transStatus() === false) {
                throw new \RuntimeException('Sale could not be saved.');
            }
            $db->transCommit();
        } catch (\Throwable $exception) {
            $db->transRollback();
            log_message('error', 'Sale failed: ' . $exception->getMessage());
            return $this->form($values, ['sale' => 'Could not record this sale. Please try again.']);
        }
        return redirect()->to('/sales')->with('success', 'Sale recorded and stock updated.');
    }

    private function form(array $values, array $errors)
    {
        return view('sales/form', [
            'products' => (new ProductModel())->orderBy('name')->findAll(),
            'customers' => (new CustomerModel())->orderBy('full_name')->findAll(),
            'values' => $values,
            'errors' => $errors,
        ]);
    }

    public function index()
    {
        $sales = (new SaleModel())
            ->select('sales.*, products.name AS product_name, customers.full_name AS customer_name, users.full_name AS staff_name')
            ->join('products', 'products.id = sales.product_id')
            ->join('customers', 'customers.id = sales.customer_id', 'left')
            ->join('users', 'users.id = sales.sold_by')
            ->orderBy('sales.id', 'DESC')->findAll();
        return view('sales/index', ['sales' => $sales]);
    }
}
