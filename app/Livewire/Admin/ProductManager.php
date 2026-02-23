<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Livewire\Component;

class ProductManager extends Component
{
    public $products = [];
    public $categories = []; // For the dropdown
    public $productId = null;

    // Form fields
    public $name = '';
    public $slug = '';
    public $sku = '';
    public $description = '';
    public $price_cents = 0;
    public $stock = 0;
    public $is_active = true;
    public $is_featured = false;
    public $category_id = null;

    public $isEditing = false;

    // Internal display formatting
    public $price_formatted = 0;

    protected $listeners = ['refreshProducts' => '$refresh'];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Load all products and categories for the current tenant. 
        $this->products = Product::with('category')->get();
        $this->categories = Category::all();
    }

    public function updatedName($value)
    {
        if (!$this->isEditing || empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function updatedPriceFormatted($value)
    {
        // Convert input (dollars/euros) to cents
        $this->price_cents = (int)round($value * 100);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'price_cents' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if ($this->isEditing && $this->productId) {
            $product = Product::findOrFail($this->productId);

            $product->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'sku' => $this->sku,
                'description' => $this->description,
                'price_cents' => $this->price_cents,
                'stock' => $this->stock,
                'is_active' => $this->is_active,
                'is_featured' => $this->is_featured,
                'category_id' => $this->category_id ?: null,
            ]);

            session()->flash('message', 'Product updated successfully.');
        }
        else {
            Product::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'sku' => $this->sku,
                'description' => $this->description,
                'price_cents' => $this->price_cents,
                'stock' => $this->stock,
                'is_active' => $this->is_active,
                'is_featured' => $this->is_featured,
                'category_id' => $this->category_id ?: null,
            ]);

            session()->flash('message', 'Product created successfully.');
        }

        $this->resetForm();
        $this->loadData();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->sku = $product->sku;
        $this->description = $product->description;
        $this->price_cents = $product->price_cents;
        $this->price_formatted = number_format($product->price_cents / 100, 2, '.', '');
        $this->stock = $product->stock;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->category_id = $product->category_id;

        $this->isEditing = true;
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('message', 'Product deleted successfully.');
        $this->loadData();
    }

    public function cancel()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->productId = null;
        $this->name = '';
        $this->slug = '';
        $this->sku = '';
        $this->description = '';
        $this->price_cents = 0;
        $this->price_formatted = 0;
        $this->stock = 0;
        $this->is_active = true;
        $this->is_featured = false;
        $this->category_id = null;
        $this->isEditing = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.product-manager')
            ->layout('layouts.app');
    }
}
