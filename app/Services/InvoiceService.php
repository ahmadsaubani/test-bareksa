<?php

namespace App\Services;

use App\Models\BillingAddress;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Item;
use Illuminate\Http\Request;
use Exception;

class InvoiceService
{
    public static function createService(Request $request)
    {
        $generateInvoiceNumber      = new GenerateUniqueInvoiceNumber();

        $invoiceNumber              = $generateInvoiceNumber->createInvoiceNumber();

        $fromBillingAddress         = BillingAddress::where("uuid", $request->from_billing_address_id)->first();

        if (! $fromBillingAddress) {
            throw new Exception(" from_billing_address_id tidak ditemukan", 403);
        }

        $toBillingAddress         = BillingAddress::where("uuid", $request->to_billing_address_id)->first();

        if (! $toBillingAddress) {
            throw new Exception(" to_billing_address_id tidak ditemukan", 403);
        }

        $createInvoice                          = new Invoice();
        $createInvoice->no                      = $invoiceNumber;
        $createInvoice->issue_date              = $request->issue_date;
        $createInvoice->due_date                = $request->due_date;
        $createInvoice->subject                 = $request->subject;
        $createInvoice->from_billing_address_id = $fromBillingAddress->id;
        $createInvoice->to_billing_address_id   = $toBillingAddress->id;
        $createInvoice->tax                     = $request->tax;
        $createInvoice->payments                = $request->payments;
        $createInvoice->save();

        if (count($request->items) >= 1) {
            $invoiceItem        = self::createInvoiceItemService($request, $createInvoice);
            $resultTax          = $invoiceItem * $createInvoice->tax / 100;
            $createInvoice->update([
                "sub_total"     => $invoiceItem,
                "amount_due"    => $resultTax + $invoiceItem - $createInvoice->payments
            ]);
        }
            
        return $createInvoice;
        
    }

    protected static function createInvoiceItemService(Request $request, Invoice $invoice)
    {
        $data = [];
        foreach ($request->items as $key) {
            $item = Item::where("uuid", $key["id"])->first();

            if (! $item) {
                throw new Exception("item uuid " . $key["id"] . " tidak ditemukan", 403);
            }

            InvoiceItem::create([
                "invoice_id" => $invoice->id,
                "item_id"    => $item->id,
                "quantity"   => $key["quantity"],
                "total"      => $item->price * $key["quantity"]
            ]);

            $data[] = $item->price * $key["quantity"];
        }

        return array_sum($data);
    }

    public static function editInvoiceService(Request $request, $uuid)
    {
        $invoice                    = Invoice::where("uuid", $uuid)->first();

        if (! $invoice) {
            throw new Exception(" invoice id tidak ditemukan", 403);
        }

        if (array_key_exists("from_billing_address_id", $request->all()) && $request->from_billing_address_id != null) {
            $fromBillingAddress         = BillingAddress::where("uuid", $request["from_billing_address_id"])->first();

            if (! $fromBillingAddress) {
                throw new Exception(" from_billing_address_id tidak ditemukan", 403);
            }
        } else {
            $fromBillingAddress = $invoice->from_billing_address_id;
        }

        
        if (array_key_exists("to_billing_address_id", $request->all()) && $request->to_billing_address_id != null) {
            $toBillingAddress         = BillingAddress::where("uuid", $request->to_billing_address_id)->first();

            if (! $toBillingAddress) {
                throw new Exception(" to_billing_address_id tidak ditemukan", 403);
            }
        } else {
            $fromBillingAddress = $invoice->to_billing_address_id;
        }
        

        $invoice->issue_date              = array_key_exists("issue_date", $request->all()) && $request->issue_date != null ? $request->issue_date  : $invoice->issue_date;
        $invoice->due_date                = array_key_exists("due_date", $request->all()) && $request->due_date != null ? $request->due_date : $invoice->due_date;
        $invoice->subject                 = array_key_exists("subject", $request->all()) && $request->subject != null ? $request->subject : $invoice->subject;
        $invoice->from_billing_address_id = $fromBillingAddress->id;
        $invoice->to_billing_address_id   = $toBillingAddress->id;
        $invoice->tax                     = array_key_exists("tax", $request->all()) && $request->tax != null ? $request->tax : $invoice->tax;
        $invoice->payments                = array_key_exists("payments", $request->all()) && $request->payments != null ? $request->payments : $invoice->payments;

        if (array_key_exists("items", $request->all()) && count($request->items) >= 1) {
            $invoiceItem        = self::editInvoiceItemService($request, $invoice);
            $resultTax          = $invoiceItem * $request->tax / 100;
            $invoice->sub_total = $invoiceItem;
            $amount             = 0;
            $invoicePlusTax     = $resultTax + $invoiceItem;
            if ($invoicePlusTax >= (int) $request->payments) {
                $amount = $invoicePlusTax - $request->payments;
            }

            $invoice->amount_due= $amount;
        }

        $invoice->save();

        return $invoice;
    }

    protected static function editInvoiceItemService(Request $request, Invoice $invoice)
    {
        $invoiceItems = InvoiceItem::where("invoice_id", $invoice->id)->get();
        if (count($invoiceItems) >= 1) {
            foreach ($invoiceItems as $itemForDelete) {
                $itemForDelete->delete();
            }
        }

        $data = [];
        foreach ($request->items as $key) {
            $item = Item::where("uuid", $key["id"])->first();

            if (! $item) {
                throw new Exception("item uuid " . $key["id"] . " tidak ditemukan", 403);
            }

            InvoiceItem::create([
                "invoice_id" => $invoice->id,
                "item_id"    => $item->id,
                "quantity"   => $key["quantity"],
                "total"      => $item->price * $key["quantity"]
            ]);

            $data[] = $item->price * $key["quantity"];
        }

        return array_sum($data);
    }
}
