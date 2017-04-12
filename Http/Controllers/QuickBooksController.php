<?php

namespace Ignite\Finance\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;

class QuickBooksController extends AdminBaseController {

    public function __construct() {
        parent::__construct();
    }

    public function addItem() {
        $ItemService = new \QuickBooks_IPP_Service_Item();

        $Item = new \QuickBooks_IPP_Object_Item();

        $Item->setName('My Item');
        $Item->setType('Inventory');
        $Item->setIncomeAccountRef('53');

        if ($resp = $ItemService->add($this->context, $this->realm, $Item)) {
            return $this->getId($resp);
        } else {
            print($ItemService->lastError($this->context));
        }
    }

    public function addInvoice($invoiceArray, $itemArray, $customerRef) {

        $InvoiceService = new \QuickBooks_IPP_Service_Invoice();

        $Invoice = new \QuickBooks_IPP_Object_Invoice();

        $Invoice = new QuickBooks_IPP_Object_Invoice();

        $Invoice->setDocNumber('WEB' . mt_rand(0, 10000));
        $Invoice->setTxnDate('2013-10-11');

        $Line = new QuickBooks_IPP_Object_Line();
        $Line->setDetailType('SalesItemLineDetail');
        $Line->setAmount(12.95 * 2);
        $Line->setDescription('Test description goes here.');

        $SalesItemLineDetail = new QuickBooks_IPP_Object_SalesItemLineDetail();
        $SalesItemLineDetail->setItemRef('8');
        $SalesItemLineDetail->setUnitPrice(12.95);
        $SalesItemLineDetail->setQty(2);

        $Line->addSalesItemLineDetail($SalesItemLineDetail);

        $Invoice->addLine($Line);

        $Invoice->setCustomerRef('67');

        if ($resp = $InvoiceService->add($this->context, $this->realm, $Invoice)) {
            return $this->getId($resp);
        } else {
            print($InvoiceService->lastError());
        }
    }

    public function getId($resp) {
        $resp = str_replace('{', '', $resp);
        $resp = str_replace('}', '', $resp);
        $resp = abs($resp);
        return $resp;
    }

}
