<?php
    require_once 'vendor/autoload.php';  

    use PhpOffice\PhpSpreadsheet\Spreadsheet; 
    use PhpOffice\PhpSpreadsheet\Writer\Csv;
    use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;

    if (!defined('_PS_VERSION_')) {
        exit;
    }

    class Sb_Export_Product extends Module{
        public function __construct()
        {
            $this -> name  =  'sb_export_product';
            $this -> tab  =  'front_office_features';
            $this -> version  =  '1.0.0';
            $this -> author  =  'sb';
            $this -> bootstrap  =  true;

            parent::__construct();

            $this -> displayName  =  $this -> l('Export Products');
            $this -> description  =  $this -> l('Admin Products');
            $this -> confirmUninstall  =  $this -> l('Are you sure you want to uninstall?');
            
            $this -> registerHook('actionOrderGridQueryBuilderModifier');
        }

        /**
         * @see Module::install()
         */
        public function install()
        {
            return (
                    parent::install()
                    && $this -> registerHook('displayHome')
                    && $this -> registerHook('actionOrderGridDefinitionModifier')

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
                $this -> getProductDataArray();  
            }
            return $this -> getAdminProduct();
        }

        public function getProductDataArray(){
            $spreadsheet  =  new Spreadsheet();
            $sheet  =  $spreadsheet -> getActiveSheet(); 
            $products  =  $this -> getProducts();
            $lang_id  =  (int) Configuration::get('PS_LANG_DEFAULT');
            $dataProduct[] = [
                "reference" =>"REFERENCE",
                "brand" =>"MARQUE",
                "bar code" =>"CODE BARRE",
                "name" =>"NOM",
                "decription long" =>"DESCRIPTION COURTE",
                "description short" =>"DESCRIPTION LONGUE",
                "price" =>"PRIX HT",
                "category" =>"CATEGORY",
                "quantity" =>"QTY",
                "img" =>"IMG",
                "weight" =>"WEIGHT",
                "active" =>"INVISIBLE"
            ]; 
            foreach($products as $product_id){
                $product = new Product($product_id['id_product'],false,$lang_id);
                $pName  =  $product -> name;
                $pReference  =  $product -> reference;
                $barcode  =  $product -> ean13;
                $weight  =  $product -> weight;
                $price  =  $product -> price;
                $status  =  $product -> active;
                $price = Product::getPriceStatic($product_id['id_product']);
                $quantity = StockAvailable::getQuantityAvailableByProduct($product_id['id_product']);
                $pdescription  =  $product -> description;
                $pshort_description  =  $product -> description_short;
                $pCategory  =  $product -> category;
                $productImages  =  $product -> getImages((int) $lang_id);
                if ($productImages && count($productImages) > 0) {
                    $link  =  new Link;
                    foreach ($productImages AS $key  => $val) {
                        $id_image  =  $val['id_image'];
                        $imagePath  =  $link -> getImageLink($product -> link_rewrite[Context::getContext() -> language -> id], $id_image, 'home_default');
                    }
                } 
                $id_manufacturer = $product -> id_manufacturer;
                $manufacturer = new Manufacturer($id_manufacturer,$lang_id);
                $mName  =  $manufacturer -> name;
                $dataProduct[] = [
                    "reference" =>$pReference,
                    "brand" =>$mName,
                    "bar code" =>$barcode,
                    "name" =>$pName,
                    "decription long" =>$pdescription,
                    "description short" =>$pshort_description,
                    "price" =>$price,
                    "category" =>$pCategory,
                    "quantity" =>$quantity,
                    "img" =>$imagePath,
                    "weight" =>$weight,
                    "active" =>$status
                ];  
            }
            $sheet -> fromArray($dataProduct);
            $writer = new Csv($spreadsheet);
            $writer -> setDelimiter(';');
            $writer -> save(dirname(__DIR__) . "\sb_export_product\csv\product.csv");           
        }

        public function HookDisplayHome(){
        }

        public function getAdminProduct(){
            $this -> context -> smarty -> assign(
                [
                    'admin_url' => $this -> context -> link -> getAdminLink('AdminModules', false) . '&token = ' . Tools::getAdminTokenLite('AdminModules') . '&configure = ' . $this -> name . '&tab_module = ' . $this -> tab . '&module_name = ' . $this -> name,
                ]
            );           
            return $this -> display(__FILE__, 'getProducts.tpl');    
        }

        public function getProducts(){
            $db = \Db::getInstance();
            $request = "SELECT id_product FROM ps_product;";
            $result = $db -> executeS($request);
            return $result;
        }

        public function stockUpdate(){
            $db = \Db::getInstance();
            $sql = "SELECT p.id_product, sa.quantity
                    FROM "._DB_PREFIX_."product p LEFT JOIN "._DB_PREFIX_."stock_available sa
                    ON (p.id_product = sa.id_product) 
                    WHERE sa.id_shop = 1 AND sa.quantity< = 10";
            $result = $db -> executeS($sql);
            foreach($result as $product){
                StockAvailable::setQuantity((int) $product['id_product'],0,0);
            }
        }       

        public function getCarrierChoicesForFilter(){
            $db = \Db::getInstance();
            $sql = "SELECT DISTINCT ps_carrier.name, ps_orders.id_carrier
                    FROM ps_orders LEFT JOIN ps_carrier
                    ON ps_orders.id_carrier = ps_carrier.id_carrier";
            $result = $db -> executeS($sql);
            return $result;
        }

        public function hookActionOrderGridDefinitionModifier(array $params){
            $definition = $params['definition'];
            $column = new DataColumn('carrier_reference');
            $column -> setName($this->l('Carrier'));
            $column -> setOptions([
                'field' => 'carrier_name',
            ]);            
            $definition -> getColumns() -> addAfter('payment',$column);
            $choices = $this -> getCarrierChoicesForFilter();
            $filterChoice = [];
            foreach($choices as $choice){
                $filterChoice[$choice['name']]=$choice['id_carrier'];
            }
                $definition -> getFilters() -> add(
                    (new Filter('carrier_reference', ChoiceType::class))
                        -> setAssociatedColumn('carrier_reference')
                        -> setTypeOptions([
                            'required' => false,
                            'choices' => $filterChoice,
                        ])
                );           
        }

        public function getCarrierDetails(){
            $db = \Db::getInstance();
            $sql = "SELECT ps_orders.id_carrier, ps_carrier.name
                    FROM ps_orders LEFT JOIN ps_carrier
                    ON ps_orders.id_carrier = ps_carrier.id_carrier";
            $result = $db -> executeS($sql);
            return $result;
        }

        public function hookActionOrderGridQueryBuilderModifier(array $params)
        {
            $searchQueryBuilder = $params['search_query_builder'];
            $searchCriteria = $params['search_criteria'];
            $searchQueryBuilder->addSelect(
                'o.`id_carrier`, ps_carrier.`id_reference` AS `carrier_reference`, ps_carrier.`name` AS `carrier_name`'
            );
            $searchQueryBuilder->leftJoin(
                'o',
                '`' . _DB_PREFIX_ . 'carrier`',
                'ps_carrier',
                'ps_carrier.`id_carrier` = o.`id_carrier`'
            );
            if ('carrier_reference' === $searchCriteria->getOrderBy()) {
                $searchQueryBuilder->orderBy('ps_carrier.id_reference', $searchCriteria->getOrderWay());
            }
            foreach ($searchCriteria->getFilters() as $filterName => $filterValue) {
                if ('carrier_reference' === $filterName) {
                    $searchQueryBuilder->andWhere('ps_carrier.id_reference = :carrier_reference');
                    $searchQueryBuilder->setParameter('carrier_reference', $filterValue);
                }
            }
        }
    }
?>