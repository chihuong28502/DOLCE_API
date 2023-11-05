<?php

namespace App\Http\Controllers;

use App\Http\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $product = $this->productService->getProducts();

        if (!$product) {
            return response()->json([
                'status' => 1,
                'message' => 'Không có dữ liệu!'
            ], 400);
        }

        return response()->json([
            'status' => 0,
            'message' => "Lấy dữ liệu thành công!",
            'product' => $product
        ], 200);
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);
        $categories = $this->productService->getCategories();

        if (!$product) {
            return response()->json([
                'status' => 1,
                'message' => 'Không có dữ liệu!'
            ], 400);
        }

        return response()->json([
            'status' => 0,
            'message' => "Lấy dữ liệu thành công!",
            'product' => $product,
            'categories' => $categories
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_product' => 'required|max:191',
            'category_id' => 'required|numeric',
            'new_price' => 'required|numeric|min:1|max:10000000',
            'old_price' => 'required|numeric|min:1|max:10000000',
            'description_product' => 'required',
            'amount_product' => 'required|numeric|min:1|max:10000'
        ], [
            'title_product.required' => 'Tên sản phẩm không được bỏ trống.',
            'title_product.max' => 'Tên sản phẩm không được vượt quá 191 ký tự.',
            'description_product.required' => 'Mô tả không được bỏ trống.',
            'category_id.required' => 'Danh mục không được bỏ trống.',
            'category_id.numeric' => 'Danh mục phải là số.',
            'new_price.required' => 'Giá sản phẩm là bắt buộc.',
            'new_price.numeric' => 'Giá sản phẩm phải là số.',
            'new_price.min' => 'Giá sản phẩm không được nhỏ hơn 1.',
            'new_price.max' => 'Giá sản phẩm không được lớn hơn 1,000,000.',
            'old_price.required' => 'Giá cũ sản phẩm là bắt buộc.',
            'old_price.numeric' => 'Giá cũ sản phẩm phải là số.',
            'old_price.min' => 'Giá cũ sản phẩm không được nhỏ hơn 1.',
            'old_price.max' => 'Giá cũ sản phẩm không được lớn hơn 1,000,000.',
            'amount_product.required' => 'Số lượng sản phẩm không được bỏ trống.',
            'amount_product.numeric' => 'Số lượng sản phẩm phải là số.',
            'amount_product.min' => 'Số lượng sản phẩm tối thiểu là 1.',
            'amount_product.max' => 'Số lượng sản phẩm tối đa là 10,000.',
        ]);
        if ($validator->fails()) {
            $validator = $validator->errors();
            return $validator;
        }

        $data = $request->all();
        $product = $this->productService->createProduct($data);
        if ($product) {
            return response()->json([
                'status' => 0,
                'message' => "Thêm mới thành công!. ",
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 1,
                'message' => "Thêm mới thất bại!. ",
                'data' => $product
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title_product' => 'required|max:191',
            'category_id' => 'required|numeric',
            'new_price' => 'required|numeric|min:1|max:10000000',
            'old_price' => 'required|numeric|min:1|max:10000000',
            'description_product' => 'required',
            'amount_product' => 'required|numeric|min:1|max:10000'
        ], [
            'title_product.required' => 'Tên sản phẩm không được bỏ trống.',
            'title_product.max' => 'Tên sản phẩm không được vượt quá 191 ký tự.',
            'description_product.required' => 'Mô tả không được bỏ trống.',
            'category_id.required' => 'Danh mục không được bỏ trống.',
            'category_id.numeric' => 'Danh mục phải là số.',
            'new_price.required' => 'Giá sản phẩm là bắt buộc.',
            'new_price.numeric' => 'Giá sản phẩm phải là số.',
            'new_price.min' => 'Giá sản phẩm không được nhỏ hơn 1.',
            'new_price.max' => 'Giá sản phẩm không được lớn hơn 1,000,000.',
            'old_price.required' => 'Giá cũ sản phẩm là bắt buộc.',
            'old_price.numeric' => 'Giá cũ sản phẩm phải là số.',
            'old_price.min' => 'Giá cũ sản phẩm không được nhỏ hơn 1.',
            'old_price.max' => 'Giá cũ sản phẩm không được lớn hơn 1,000,000.',
            'amount_product.required' => 'Số lượng sản phẩm không được bỏ trống.',
            'amount_product.numeric' => 'Số lượng sản phẩm phải là số.',
            'amount_product.min' => 'Số lượng sản phẩm tối thiểu là 1.',
            'amount_product.max' => 'Số lượng sản phẩm tối đa là 10,000.',
        ]);
        if ($validator->fails()) {
            $validator = $validator->errors();
            return $validator;
        }

        $data = $request->all();
        $product = $this->productService->updateProduct($data, $id);
        if ($product) {
            return response()->json([
                'status' => 0,
                'message' => "Cập nhật thành công!. ",
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 1,
                'message' => "Cập nhật thất bại!. ",
                'data' => $product
            ], 400);
        }
    }

    public function destroy($id)
    {
        $product = $this->productService->deleteProduct($id);
        if ($product) {
            return response()->json([
                'status' => 0,
                'message' => "Xóa thành công!. ",
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 1,
                'message' => "Xóa thất bại!. ",
                'data' => $product
            ], 400);
        }
    }
}
