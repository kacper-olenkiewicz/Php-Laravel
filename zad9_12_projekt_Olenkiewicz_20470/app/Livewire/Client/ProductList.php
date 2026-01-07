<?php
namespace App\Livewire\Client;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rental;

class ProductList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedRentalId = null;
    public $selectedCategoryId = null;
    public $sortBy = 'name';
    public $rentals;
    public $categories;

    protected $queryString = ['search', 'selectedRentalId', 'selectedCategoryId', 'sortBy'];

    public function mount()
    {
        $this->rentals = Rental::all(['id', 'name']);
        $this->categories = Category::all(['id', 'name']);
    }

    public function render()
    {
        $query = Product::query()
            ->with(['rental', 'categories']);

        // Filtr wypożyczalni
        if ($this->selectedRentalId) {
            $query->where('rental_id', $this->selectedRentalId);
        }

        // Filtr kategorii
        if ($this->selectedCategoryId) {
            $query->whereHas('categories', function ($q) {
                $q->where('categories.id', $this->selectedCategoryId);
            });
        }

        // Wyszukiwanie
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Sortowanie
        switch ($this->sortBy) {
            case 'price_asc':
                $query->orderBy('daily_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('daily_price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $products = $query->paginate(12);

        return view('livewire.client.product-list', [
            'products' => $products,
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedRentalId()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategoryId()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }
}