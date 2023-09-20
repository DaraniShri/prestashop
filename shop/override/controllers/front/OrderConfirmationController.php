<?php
    class OrderConfirmationController extends OrderConfirmationControllerCore{
        public function initContent(){
            if (Configuration::isCatalogMode()) {
                Tools::redirect('index.php');
            }
    
            $order = new Order(Order::getIdByCartId((int) ($this->id_cart)));
            $presentedOrder = $this->order_presenter->present($order);
            $register_form = $this
                ->makeCustomerForm()
                ->setGuestAllowed(false)
                ->fillWith(Tools::getAllValues());
    
            parent::initContent();
    
            /* Kelkoo Sales Tracking */
            $order = new Order($this->id_order);
            $products = $order->getProducts();
            $productsKelkoo=array();
            foreach ($products as $product) {
                $productKelkoo=array('productname'=>$product['product_name'],
                                    'productid'=>$product['product_reference'],
                                    'svn1'=>$product['product_quantity'],
                                    'svn2'=>$product['unit_price_tax_incl']);
                array_push($productsKelkoo,$productKelkoo);
            }
            $this->context->smarty->assign(array(
                'HOOK_ORDER_CONFIRMATION' => $this->displayOrderConfirmation($order),
                'HOOK_PAYMENT_RETURN' => $this->displayPaymentReturn($order),
                'products_json' => json_encode($productsKelkoo),
                'sales' => $order->getOrdersTotalPaid(),
                'orderid' => $this->id_order,
                'order' => $presentedOrder,
                'register_form' => $register_form,
            ));
            /* end Kelkoo Sales Tracking*/
    
            if ($this->context->customer->is_guest) {
                /* If guest we clear the cookie for security reason */
                $this->context->customer->mylogout();
            }
            $this->setTemplate('checkout/order-confirmation');
        }
    }
?>