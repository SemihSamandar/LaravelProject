<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Ürünleri listele
    public function index()
    {
        $products = Product::latest()->get();
        return view('products', compact('products'));
    }

    // Yeni ürün ekleme formunu göster
    public function create()
    {
        return view('products.create');
    }

    

    // Ürünü veritabanına kaydet
    public function store(Request $request)
    {
        // Validasyon
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ], [
            'name.required' => 'Ürün adı zorunludur.',
            'name.max' => 'Ürün adı 255 karakterden uzun olamaz.',
            'description.required' => 'Açıklama zorunludur.',
            'price.required' => 'Fiyat zorunludur.',
            'price.numeric' => 'Fiyat bir sayı olmalıdır.',
            'price.min' => 'Fiyat 0 veya daha fazla olmalıdır.',
            'stock.required' => 'Stok zorunludur.',
            'stock.integer' => 'Stok bir tam sayı olmalıdır.',
            'stock.min' => 'Stok 0 veya daha fazla olmalıdır.',
            'image.required' => 'Lütfen bir görsel seçin.',
            'image.image' => 'Dosya bir görsel olmalıdır.',
            'image.mimes' => 'Görsel JPEG, PNG, JPG, GIF veya WebP formatında olmalıdır.',
            'image.max' => 'Görsel 5MB\'tan küçük olmalıdır.',
        ]);

        // Yeni ürün oluştur
        $product = new Product();
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];

        // Görseli storage'a kaydet
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('products.create')->with('success', '✅ Ürün başarıyla eklendi!');
    }

    public function show(Product $product)
{
    // Laravel'in "Route Model Binding" özelliği sayesinde, 
    // urldeki ID'ye ait ürün otomatik olarak bulunur ve $product içine yüklenir.
    
    return view('products.show', compact('product'));
}

    // Ürün düzenleme formunu göster (opsiyonel)
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    // Ürünü güncelle (opsiyonel)
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];

        if ($request->hasFile('image')) {
            // Eski görseli sil
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '✅ Ürün başarıyla güncellendi!');
    }

    // Ürünü sil (opsiyonel)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Görseli sil
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', '✅ Ürün başarıyla silindi!');
    }
}
