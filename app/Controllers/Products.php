<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    public function index()
    {
        $productModel = new ProductModel();

        return view('products/index', [
            'title'    => 'Products',
            'products' => $productModel->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function create()
    {
        return view('products/create', [
            'title' => 'Add Product',
        ]);
    }

    public function store()
    {
        $rules = [
            'name'           => 'required|max_length[100]',
            'price'          => 'required|decimal',
            'stock_quantity' => 'required|integer|greater_than_equal_to[0]',
        ];

        $image = $this->request->getFile('image');

        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]';
        }

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imageName = null;

        if ($image && $image->isValid() && ! $image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $imageName);
        }

        $productModel = new ProductModel();

        $productModel->insert([
            'name'           => trim((string) $this->request->getPost('name')),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image'          => $imageName,
            'created_at'     => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/products')
            ->with('success', 'Product added successfully.');
    }
}