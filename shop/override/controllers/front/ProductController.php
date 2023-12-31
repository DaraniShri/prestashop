<?php
    class ProductController extends ProductControllerCore{
    /**
     * Assign template vars related to page content.
     *
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        $id = 2;
        $product = new Product($id);
        var_dump($product->id);
        die();
        parent::initContent();
        if($this->product->quantity <= 5) {
            $product_quantity_update="Hurry! only ".$this->product->quantity."left";
        }
        else{
            $product_quantity_update=$this->product->quantity;
        }

        $this->context->smarty->assign([
            'product_quantity' => $product_quantity_update,
        ]);
        }
    }
?>