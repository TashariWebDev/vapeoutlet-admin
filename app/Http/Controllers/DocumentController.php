<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
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
        Log::info($transaction);
        $model = $transaction;

        if (Str::startsWith($transaction->reference, 'INV00')) {
            $model = Order::with('items', 'items.product', 'items.product.features', 'customer')
                ->find(Str::after($transaction->reference, 'INV00'));
        }

        if (Str::startsWith($transaction->reference, 'CR00')) {
            $model = Credit::with('items', 'items.product', 'customer')
                ->find(Str::after($transaction->reference, 'CR00'));
        }

        $view = view("templates.pdf.{$transaction->type}", [
            "model" => $model
        ])->render();

        $url = storage_path("app/public/documents/{$transaction->uuid}.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 100)
            ->save($url);

        return response()->json(200);

    }


    public function getPriceList(Customer $customer)
    {
        Log::info($customer);

        $view = view("templates.pdf.price-list", [
            "products" => Product::query()
                ->with('features')
                ->where('is_active', true)
                ->orderBy('brand', 'asc')
                ->get(),
            'customer' => $customer
        ])->render();

        $url = storage_path("app/public/documents/price-list.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 100)
            ->save($url);

        return response()->json(200);
    }

    public function getPickList(Order $order)
    {
        Log::info($order);

        $order->load('items.product.features');

        $view = view("templates.pdf.pick-list", [
            "model" => $order,
        ])->render();

        $url = storage_path("app/public/pick-lists/{$order->number}.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 100)
            ->save($url);

        return response()->json(200);
    }

    public function getDeliveryNote(Order $order)
    {
        Log::info($order);

        $order->load('items.product.features');

        $view = view("templates.pdf.delivery-note", [
            "model" => $order,
        ])->render();

        $url = storage_path("app/public/delivery-note/{$order->number}.pdf");

        if (file_exists($url)) {
            unlink($url);
        }

        Browsershot::html($view)
            ->showBackground()
            ->emulateMedia("print")
            ->format("a4")
            ->paperSize(297, 210)
            ->setScreenshotType("pdf", 100)
            ->save($url);

        return response()->json(200);
    }

}
