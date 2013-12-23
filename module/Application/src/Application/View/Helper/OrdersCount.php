<?php
namespace Application\View\Helper;

use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;

class OrdersCount  extends AbstractHelper
{
    public function __construct(Request $request, $ordersCount) {
        $this->ordersCount = $ordersCount;
    }

    public function __invoke() {
        $ordersCount = $this->ordersCount;
        return  $ordersCount['ordersCount'];
    }
}