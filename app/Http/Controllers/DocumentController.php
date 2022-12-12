<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockTake;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use League\Glide\Filesystem\FileNotFoundException;
use Spatie\Browsershot\Browsershot;
use Spatie\Browsershot\Exceptions\CouldNotTakeBrowsershot;

class DocumentController extends Controller
{
    /**
     * @throws CouldNotTakeBrowsershot
     * @throws FileNotFoundException
     */
    public function saveDocument(Transaction $transaction)
    {
        $model = $transaction;

        if (Str::startsWith($transaction->reference, 'INV00')) {
            $model = Order::with(
                'items',
                'items.product',
                'items.product.features',
                'customer',
                'notes'
            )->find(Str::after($transaction->reference, 'INV00'));
        }

        if (Str::startsWith($transaction->reference, 'CR00')) {
            $model = Credit::with('items', 'items.product', 'customer')->find(
                Str::after($transaction->reference, 'CR00')
            );
        }

        $view = view("templates.pdf.$transaction->type", [
            'model' => $model,
        ])->render();

        $url = storage_path("app/public/documents/$transaction->number.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return response()->json(200);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getPriceList(Customer $customer)
    {
        Log::info($customer);

        $productsGroupedByCategory = Product::query()
            ->with('features')
            ->where('is_active', true)
            ->orderBy('brand')
            ->get()
            ->groupBy('category');

        $view = view('templates.pdf.price-list', [
            'productsGroupedByCategory' => $productsGroupedByCategory,
            'customer' => $customer,
        ])->render();

        $url = storage_path(
            "app/public/documents/price-list-{$customer->type()}.pdf"
        );

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return response()->json(200);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getPickList(Order $order)
    {
        Log::info($order);

        $order->load('items.product.features');

        $view = view('templates.pdf.pick-list', [
            'model' => $order,
        ])->render();

        $url = storage_path("app/public/pick-lists/$order->number.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return response()->json(200);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getDeliveryNote(Order $order)
    {
        Log::info($order);

        $order->load('items.product.features');

        $view = view('templates.pdf.delivery-note', [
            'model' => $order,
        ])->render();

        $url = storage_path("app/public/delivery-note/$order->number.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return response()->json(200);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getStockCount(StockTake $stockTake)
    {
        Log::info($stockTake);

        $stockTake->load('items.product.features');

        $view = view('templates.pdf.stock-count', [
            'model' => $stockTake,
        ])->render();

        $url = storage_path("app/public/stock-counts/$stockTake->id.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return response()->json(200);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getStockTake(StockTake $stockTake)
    {
        Log::info($stockTake);

        $stockTake->load('items.product.features');

        $view = view('templates.pdf.stock-take', [
            'model' => $stockTake,
        ])->render();

        $url = storage_path("app/public/stock-takes/$stockTake->id.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return response()->json(200);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getCreditsList()
    {
        $credits = Credit::whereBetween('created_at', [
            request('from'),
            request('to'),
        ])
            ->when(request('admin'), function ($query) {
                $query->whereCreatedBy(request('admin'));
            })
            ->get()
            ->groupBy('created_by');

        $view = view('templates.pdf.credits-report', [
            'credits' => $credits,
        ])->render();

        $url = storage_path('app/public/documents/credits.pdf');

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return response()->json(200);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getVariancesList()
    {
        $stocks = Stock::whereBetween('created_at', [
            request('from'),
            request('to'),
        ])
            ->where('type', '=', 'adjustment')
            ->where('qty', '!=', 0)
            ->get()
            ->sortBy('reference');

        $view = view('templates.pdf.variances-report', [
            'stocks' => $stocks,
        ])->render();

        $url = storage_path('app/public/documents/variances.pdf');

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return response()->json(200);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getSalesByDateRange()
    {
        $customers = Customer::withWhereHas('orders', function ($query) {
            $query
                ->whereBetween('created_at', [request('from'), request('to')])
                ->where('status', '!=', 'cancelled')
                ->whereNotNull('status');
        })
            ->select([
                'customers.id',
                'customers.name',
                'customers.salesperson_id',
            ])
            ->with('salesperson:id,name')
            ->when(request('salesperson_id'), function ($query) {
                $query->where(
                    'salesperson_id',
                    '=',
                    (int) request('salesperson_id')
                );
            })
            ->get()
            ->groupBy('salesperson.name');

        Log::info($customers);

        $url = storage_path('app/public/documents/salesByDateRange.pdf');

        if (file_exists($url)) {
            unlink($url);
        }

        $view = view('templates.pdf.sales-report', [
            'customers' => $customers,
        ])->render();

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 100)
            ->save($url);

        return response()->json(200);
    }

    /**
     * @throws CouldNotTakeBrowsershot
     */
    public function getStocksByDateRange()
    {
        $toDate = request('to');

        $products = Product::whereHas('stocks', function ($query) use (
            $toDate
        ) {
            $query->whereDate('created_at', '<=', Carbon::parse($toDate));
        })
            ->select(['id', 'name', 'cost', 'sku', 'brand'])
            ->withSum(
                [
                    'stocks' => function ($query) use ($toDate) {
                        $query->whereDate(
                            'created_at',
                            '<=',
                            Carbon::parse($toDate)
                        );
                    },
                ],
                'qty'
            )
            ->get();

        Log::info($products);

        $url = storage_path('app/public/documents/stockByDateRange.pdf');

        if (file_exists($url)) {
            unlink($url);
        }

        $view = view('templates.pdf.stock-report', [
            'products' => $products->filter(function ($product) {
                return $product->stocks_sum_qty > 0;
            }),
        ])->render();

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia('print')
            ->format('a4')
            ->paperSize(297, 210)
            ->setScreenshotType('pdf', 90)
            ->save($url);

        return response()->json(200);
    }
}
