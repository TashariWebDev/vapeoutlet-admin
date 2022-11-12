<?php

namespace App\Http\Livewire\Categories;

use App\Http\Livewire\Traits\WithNotifications;
use App\Models\Category;
use DB;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
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
        return view('livewire.categories.index', [
            'categories' => Category::query()
                ->withCount('products')
                ->orderBy('name')
                ->paginate(6),
        ]);
    }
}
