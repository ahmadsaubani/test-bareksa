<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\User;
use App\Models\UserRegistrationEmailCode;
use App\Models\VerificationCodeChangeEmail;
use App\Models\VerificationCodePhoneNumber;

class GenerateUniqueInvoiceNumber
{
    protected $invoiceNumber;

    /**
     * Create a Invoice Number.
     *
     * @return int
     */
    public function createInvoiceNumber() : int
    {
        if (empty($this->invoiceNumber)) {
            // attempt to Generate Invoice Number
            do {
                $invoiceNumber = $this->invoiceNumber();
            } while (!$this->hasUniqueCode($invoiceNumber));

            $this->invoiceNumber = $invoiceNumber;
        }

        return $this->invoiceNumber;
    }

    /**
     * Generate Invoice Number.
     *
     * @return int
     */
    protected function invoiceNumber() : int
    {
        $invoiceNumber = rand(100000, 999999);
        return ($invoiceNumber);
    }

    /**
     * Check if the Invoice Number is Unique.
     *
     * @param  int  $invoiceNumber
     * @param  string  $type
     *
     * @return boolean
     */
    protected function hasUniqueCode(int $invoiceNumber) : bool
    {
        $invoice = Invoice::where("no", $invoiceNumber)->exists();

        return !empty($invoice) ? false : true;
    }
}
