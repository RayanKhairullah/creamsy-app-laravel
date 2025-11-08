<?php

namespace App\Livewire\Manager\Products;

use App\Models\Product;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $name, $description, $price, $category, $image, $is_active = true, $stock_quantity;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'category' => 'required|string',
        'stock_quantity' => 'required|integer',
        'image' => 'nullable|image|max:10000', // 1MB Max
    ];

    public function save()
    {
        $this->validate();

        $imagePath = null;
        if ($this->image) {
            $imageName = Str::random(20) . '.webp';
            $imagePath = $this->image->storeAs('products', $imageName, 'public');

            // Convert to webp
            // Convert to webp
            $image = Image::read(storage_path("app/public/{$imagePath}"));
            $image->encodeByExtension(
                extension: 'webp',
                quality: 80,
                strip: config('image.options.strip')
            )->save(storage_path("app/public/{$imagePath}"));
        }

        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'category' => $this->category,
            'image' => $imagePath,
            'is_active' => $this->is_active,
            'stock_quantity' => $this->stock_quantity,
        ]);

        session()->flash('success', 'Product created successfully!');
        return redirect()->route('manager.products.index');
    }

    public function render()
    {
        return view('livewire.manager.products.create-product')
            ->layout('components.layouts.manager');
    }
}
