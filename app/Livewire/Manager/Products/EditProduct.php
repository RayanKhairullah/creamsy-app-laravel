<?php

namespace App\Livewire\Manager\Products;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditProduct extends Component
{
    use WithFileUploads;

    public Product $product;
    public $name, $description, $price, $category, $is_active, $stock_quantity;
    public $new_image;
    public $existing_image;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'stock_quantity' => 'required|integer',
            'is_active' => 'required|boolean',
            'new_image' => 'nullable|image|max:1024', // 1MB Max
        ];
    }

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->category = $product->category;
        $this->is_active = $product->is_active;
        $this->stock_quantity = $product->stock_quantity;
        $this->existing_image = $product->image;
    }

    public function update()
    {
        $validatedData = $this->validate();

        if ($this->new_image) {
            // Delete old image if it exists
            if ($this->product->image) {
                Storage::disk('public')->delete($this->product->image);
            }

            // Store new image
            $imageName = Str::random(20) . '.webp';
            $imagePath = $this->new_image->storeAs('products', $imageName, 'public');

            // Convert to webp
            $image = Image::read(storage_path("app/public/{$imagePath}"));
            $image->encodeByExtension(
                extension: 'webp',
                quality: 80,
                strip: config('image.options.strip')
            )->save(storage_path("app/public/{$imagePath}"));

            $validatedData['image'] = $imagePath;
        } else {
            $validatedData['image'] = $this->product->image;
        }

        // Unset new_image from validated data as it's not a DB column
        unset($validatedData['new_image']);

        $this->product->update($validatedData);

        session()->flash('success', 'Product updated successfully!');
        return redirect()->route('manager.products.index');
    }

    public function render()
    {
        return view('livewire.manager.products.edit-product')
        ->layout('components.layouts.manager');
    }
}
