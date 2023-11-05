<?php

namespace App\Http\Services;

use App\Models\Category;
use App\Models\Product;

class ProductService
{
    protected $product;
    protected $category;

    function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    public function getProducts()
    {
        $products = $this->product->with('category')->get();
        return $products;
    }

    public function getProductById($productId)
    {
        $product = $this->product->find($productId);
        return $product;
    }

    public function getCategories()
    {
        $category = $this->category->get();
        return $category;
    }

    public function createProduct($data)
    {
        $product = $this->product->create($data);
        return $product;
    }

    public function updateProduct($data, $id)
    {
        $product = $this->product->find($id);
        $result = $product->update($data);
        return $result;
    }

    public function deleteProduct($id)
    {
        $product = $this->product->find($id);
        $result = $product->delete();
        return $result;
    }
}
