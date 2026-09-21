<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SaleModel;

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
            return redirect()->back()->withInput()
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

        return redirect()->to('/products')
            ->with('success', 'Product added successfully.');
    }

    public function edit($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('products/edit', [
            'title'   => 'Edit Product',
            'product' => $product,
        ]);
    }

    public function update($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

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
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $imageName = $product['image'];

        if ($image && $image->isValid() && ! $image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/products', $imageName);

            if (! empty($product['image'])) {
                $oldImagePath = FCPATH . 'uploads/products/' . $product['image'];

                if (is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $productModel->update($id, [
            'name'           => trim((string) $this->request->getPost('name')),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
            'image'          => $imageName,
        ]);

        return redirect()->to('/products')
            ->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $productModel = new ProductModel();
        $product = $productModel->find($id);

        if (! $product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $saleModel = new SaleModel();
        $hasSales = $saleModel->where('product_id', $id)->first();

        if ($hasSales) {
            return redirect()->to('/products')
                ->with('error', 'This product cannot be deleted because it has sales history.');
        }

        if (! empty($product['image'])) {
            $imagePath = FCPATH . 'uploads/products/' . $product['image'];

            if (is_file($imagePath)) {
                unlink($imagePath);
            }
        }

        $productModel->delete($id);

        return redirect()->to('/products')
            ->with('success', 'Product deleted successfully.');
    }
}