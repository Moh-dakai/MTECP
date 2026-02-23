<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryManager extends Component
{
    public $categories = [];
    public $categoryId = null;

    // Form fields
    public $name = '';
    public $slug = '';
    public $description = '';
    public $parent_id = null;

    public $isEditing = false;

    // Listeners for updates
    protected $listeners = ['refreshCategories' => '$refresh'];

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        // Load all categories for the current tenant. 
        // The BelongsToTenant scope automatically filters this.
        $this->categories = Category::with('parent')->get();
    }

    public function updatedName($value)
    {
        // Auto-generate slug if we're not explicitly editing the slug
        if (!$this->isEditing || empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($this->isEditing && $this->categoryId) {
            $category = Category::findOrFail($this->categoryId);

            // Prevent self-nesting
            if ($this->parent_id == $category->id) {
                $this->addError('parent_id', 'A category cannot be its own parent.');
                return;
            }

            $category->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'parent_id' => $this->parent_id ?: null,
            ]);

            session()->flash('message', 'Category updated successfully.');
        }
        else {
            Category::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'parent_id' => $this->parent_id ?: null,
            ]);

            session()->flash('message', 'Category created successfully.');
        }

        $this->resetForm();
        $this->loadCategories();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->parent_id = $category->parent_id;
        $this->isEditing = true;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);

        // Cannot delete if it has children or products
        if ($category->children()->count() > 0) {
            session()->flash('error', 'Cannot delete this category. It contains child categories.');
            return;
        }

        if ($category->products()->count() > 0) {
            session()->flash('error', 'Cannot delete this category. It contains products.');
            return;
        }

        $category->delete();
        session()->flash('message', 'Category deleted successfully.');
        $this->loadCategories();
    }

    public function cancel()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->categoryId = null;
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->parent_id = null;
        $this->isEditing = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.category-manager')
            ->layout('layouts.app'); // Use the default generic auth layout constructed by Breeze
    }
}
