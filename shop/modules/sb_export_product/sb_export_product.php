<?php
    use PhpOffice\PhpSpreadsheet\Spreadsheet; 
    use PhpOffice\PhpSpreadsheet\Writer\Csv; 

    if (!defined('_PS_VERSION_')) {
        exit;
    }

    class Sb_Export_Product extends Module{
        public function __construct()
        {
            $this->name = 'sb_export_product';
            $this->tab = 'front_office_features';
            $this->version = '1.0.0';
            $this->author = 'sb';
            $this->bootstrap = true;

            parent::__construct();

            $this->displayName = $this->l('Export Products');
            $this->description = $this->l('Admin Products');
            $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        }

        /**
         * @see Module::install()
         */
        public function install()
        {
            return (
                    parent::install()
                    && $this->registerHook('displayHome')
                ); 
        }

        /**
         * @see Module::uninstall()
         */
        public function uninstall()
        {
            return parent::uninstall();
        }  

        public function getContent(){
            if(Tools::getValue('submit')){
                $this->getProductDataArray();  
            }
            return $this->getAdminProduct();

        }

        public function getProductDataArray(){
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet(); 
            $products = $this->getProducts();
            $lang_id = (int) Configuration::get('PS_LANG_DEFAULT');
            $dataProduct[]=[
                "reference"=>"REFERENCE",
                "brand"=>"MARQUE",
                "bar code"=>"CODE BARRE",
                "name"=>"NOM",
                "decription long"=>"DESCRIPTION COURTE",
                "description short"=>"DESCRIPTION LONGUE",
                "price"=>"PRIX HT",
                "category"=>"CATEGORY",
                "quantity"=>"QTY",
                "img"=>"IMG",
                "weight"=>"WEIGHT",
                "active"=>"INVISIBLE"
            ]; 
            foreach($products as $product_id){
                $product=new Product($product_id['id_product'],false,$lang_id);
                $pName = $product->name;
                $pReference = $product->reference;
                $barcode = $product->ean13;
                $weight = $product->weight;
                $price = $product->price;
                $status = $product->active;
                $price=Product::getPriceStatic($product_id['id_product']);
                $quantity=StockAvailable::getQuantityAvailableByProduct($product_id['id_product']);
                $pdescription = $product->description;
                $pshort_description = $product->description_short;
                $pCategory = $product->category;
                $productImages = $product->getImages((int) $id_lang);
                if ($productImages && count($productImages) > 0) {
                    $link = new Link;
                    foreach ($productImages AS $key => $val) {
                        $id_image = $val['id_image'];
                        $imagePath = $link->getImageLink($product->link_rewrite[Context::getContext()->language->id], $id_image, 'home_default');
                    }
                } 
                $id_manufacturer=$product->id_manufacturer;
                $manufacturer=new Manufacturer($id_manufacturer,$id_lang);
                $mName = $manufacturer->name;
                $dataProduct[]=[
                    "reference"=>$pReference,
                    "brand"=>$mName,
                    "bar code"=>$barcode,
                    "name"=>$pName,
                    "decription long"=>$pdescription,
                    "description short"=>$pshort_description,
                    "price"=>$price,
                    "category"=>$pCategory,
                    "quantity"=>$quantity,
                    "img"=>$imagePath,
                    "weight"=>$weight,
                    "active"=>$status
                ];  
            }
            $sheet->fromArray($dataProduct);
            $writer = new Csv($spreadsheet);
            $writer->setDelimiter(';');
            $fileName=$writer->save(dirname(__DIR__)."\sb_export_product\csv\product.csv");           
        }

        public function HookDisplayHome(){
            return $this->display(__FILE__, 'sb_export_product.tpl');
        }

        public function getAdminProduct(){
            $this->context->smarty->assign(
                [
                    'admin_url' => $this->context->link->getAdminLink('AdminModules', false) . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name,
                ]
            );           
            return $this->display(__FILE__, 'getProducts.tpl');    
        }

        public function getProducts(){
            $db = \Db::getInstance();
            $request="SELECT id_product FROM ps_product;";
            $result=$db->executeS($request);
            return $result;
        }
    }
?>