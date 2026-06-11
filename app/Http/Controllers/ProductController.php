<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Ürünleri listele ve ana ekranda filtrele
    public function index(Request $request)
    {
        // Category modeli OLMADAN, Product tablosundaki mevcut kategori ID'lerini benzersiz olarak çekiyoruz
        $categories = Product::select('category_id')
            ->whereNotNull('category_id')
            ->distinct()
            ->get()
            ->map(function($product) {
                // Arayüzdeki butonların ismi için eşleştirme yapıyoruz
                $names = [
                    1 => 'Elektronik',
                    2 => 'Beyaz Eşya',
                    3 => 'Küçük Ev Aletleri'
                ];
                return (object)[
                    'id' => $product->category_id,
                    'name' => $names[$product->category_id] ?? 'Kategori ' . $product->category_id
                ];
            });

        $query = Product::latest();

        // Eğer üstteki menüden bir kategoriye tıklandıysa (?category=1 gibi) filtrele
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $products = $query->get();

        // Hem ürünleri hem de üst satırda listelenecek kategorileri view'a gönderiyoruz
        return view('products', compact('products', 'categories'));
    }

    // Yeni ürün ekleme formunu göster
    public function create()
    {
        // Formdaki açılır kutunun (select box) dolması için statik kategoriler tanımlıyoruz
        $categories = [
            (object)['id' => 1, 'name' => 'Elektronik'],
            (object)['id' => 2, 'name' => 'Beyaz Eşya'],
            (object)['id' => 3, 'name' => 'Küçük Ev Aletleri'],
        ];

        return view('products.create', compact('categories'));
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
            'category_id' => 'required|integer', // Formdan gelen kategori zorunlu
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
            'category_id.required' => 'Lütfen bir kategori seçin.',
        ]);

        // Yeni ürün oluştur
        $product = new Product();
        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id']; // SQL'e kaydeden satır

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
        return view('products.show', compact('product'));
    }

    // Ürün düzenleme formunu göster
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        // Düzenleme formundaki kategori seçimi için statik dizi
        $categories = [
            (object)['id' => 1, 'name' => 'Elektronik'],
            (object)['id' => 2, 'name' => 'Beyaz Eşya'],
            (object)['id' => 3, 'name' => 'Küçük Ev Aletleri'],
        ];

        return view('products.edit', compact('product', 'categories'));
    }

    // Ürünü güncelle
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'category_id' => 'required|integer', // Güncelleme alanına da ekledik
        ]);

        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id']; // Güncellenen kategoriyi SQL'e yazar

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

    // Ürünü sil
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