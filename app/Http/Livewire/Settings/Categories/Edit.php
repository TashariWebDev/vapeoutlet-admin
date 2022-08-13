<?php

namespace App\Http\Livewire\Settings\Categories;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Category;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithPagination;
    use WithNotifications;

    public function updateCategory($categoryId, $name)
    {
        $category = Category::find($categoryId);

        DB::transaction(function () use ($category, $name) {
            foreach ($category->products as $product) {
                $product->update([
                    'category' => $name,
                ]);
            }

            $category->update(['name' => $name]);
        });
        $this->notify('category updated');
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.settings.categories.edit', [
            'categories' => Category::query()
                ->withCount('products')
                ->orderBy('name')
                ->paginate(6),
        ]);
    }
}
