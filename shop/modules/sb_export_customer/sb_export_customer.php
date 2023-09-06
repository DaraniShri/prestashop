<?php

    require_once 'vendor/autoload.php';  

    use PhpOffice\PhpSpreadsheet\Spreadsheet; 
    use PhpOffice\PhpSpreadsheet\Writer\Csv;
    
    class Sb_Export_Customer extends Module{
        public function __construct()
        {
            $this -> name = 'sb_export_customer';
            $this -> tab = 'back_office_features';
            $this -> version = '1.0.0';
            $this -> author = 'Prestashop';
            $this -> bootstrap = true;

            parent::__construct();

            $this ->displayName = $this -> l('Export Customers');
            $this ->description = $this ->l ('Exports the Shop Customers');
            $this ->confirmUninstall = $this -> l('Are you sure you want to uninstall?');
        }

        /**
         * @see Module::install()
         */
        public function install()
        {
            return (
                    parent::install()
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
            if(Tools::isSubmit('customer')){
                $this -> getCustomerDetails();
            }
            return $this -> getShopCustomersButton();
        }

        public function getCustomers(){
            $db = \Db::getInstance();
            $sql = "SELECT id_customer, CONCAT(firstname,lastname) AS name, email 
                    FROM " ._DB_PREFIX_. "customer
                    WHERE id_shop = 1 AND email NOT LIKE '%@prestashop.com'";
            $result = $db->executeS($sql);
            return $result;
        }

        public function getShopCustomersButton(){
            $this -> context -> smarty -> assign(
                [
                    'admin_url' => $this->context->link->getAdminLink('AdminModules', false) . '&token=' . Tools::getAdminTokenLite('AdminModules') . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name,
                ]
            );           
            return $this->display(__FILE__, 'getCustomer.tpl'); 
        }

        public function getCustomerDetails(){
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $customers = $this -> getCustomers();
            foreach($customers as $customer){
                $customerData[]=[
                    "customermail" => $customer['email'],
                    "customername" => $customer['name']
                ];
            }
            $sheet -> fromArray($customerData);
            $writer = new Csv($spreadsheet);
            $writer -> setDelimiter(';');
            $writer -> save(dirname(__DIR__)."\sb_export_customer\csv\customers.csv");
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment;filename=customers.csv');
            $file_path=dirname(__DIR__)."\sb_export_customer\csv\customers.csv";
            header('Content-Length: '.filesize($file_path));
            readfile($file_path);
        }
    }
?>