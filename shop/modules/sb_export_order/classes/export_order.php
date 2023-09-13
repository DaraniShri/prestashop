<?php
class Export_Order extends ObjectModel{
    public $order_number;
    public $order_date;
    public $deliver_date;
    public $date_add;
    public $date_upd;
    public $customer_code;
    public $customer_businessname;
    public $customer_name;
    public $customer_address;
    public $customer_place;
    public $customer_postalcode;
    public $customer_zone;
    public $customer_country;
    public $customer_phone;
    public $mobile_customers;
    public $customer_fax;
    public $customer_email;
    public $delivery_code;
    public $delivery_businessname;
    public $delivery_name;
    public $delivery_address;
    public $delivery_place;
    public $delivery_postalcode;
    public $delivery_zone;
    public $delivery_country;
    public $delivery_phone;
    public $mobile_delivery;
    public $fax_delivery;
    public $email_delivery;
    public $carrier_code;
    public $carrier_businessname;
    public $carrier_name;
    public $carrier_address;
    public $carrier_place;
    public $carrier_postalcode;
    public $carrier_zone;
    public $carrier_country;
    public $carrier_phone;
    public $mobile_carrier;
    public $fax_carrier;
    public $email_carrier;
    public $order_linenumber;
    public $reference_order_linenumber;
    public $line_type;
    public $item_code;
    public $item_description;
    public $customer_itemcode;
    public $customer_itemdescription;
    public $customer_documentreference;
    public $lot;
    public $quantity_requested;
    public $annotations;
    public $response;
 
    /**
     * Summary of definition
     * @var array
     */
    public static $definition = [
        'table' => "export_order",
        'primary' => 'export_orderid',
        'fields' => [
            'order_number' => array('type' => self::TYPE_INT, 'required' => TRUE),
            'order_date' => array('type' => self::TYPE_DATE, 'required' => TRUE),
            'deliver_date' => array('type' => self::TYPE_DATE),
            'date_add' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'date_upd' => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
            'customer_code' => array('type' => self::TYPE_STRING),
            'customer_businessname' => array('type' => self::TYPE_STRING),
            'customer_name' => array('type' => self::TYPE_STRING),
            'customer_address' => array('type' => self::TYPE_STRING),
            'customer_place' => array('type' => self::TYPE_STRING),
            'customer_postalcode' => array('type' => self::TYPE_INT),
            'customer_zone' => array('type' => self::TYPE_STRING),
            'customer_country' => array('type' => self::TYPE_STRING),
            'customer_phone' => array('type' => self::TYPE_INT),
            'mobile_customers' => array('type' => self::TYPE_INT),
            'customer_fax' => array('type' => self::TYPE_INT),
            'customer_email' => array('type' => self::TYPE_STRING),
            'delivery_code' => array('type' => self::TYPE_STRING),
            'delivery_businessname' => array('type' => self::TYPE_STRING),
            'delivery_name' => array('type' => self::TYPE_STRING),
            'delivery_address' => array('type' => self::TYPE_STRING),
            'delivery_place' => array('type' => self::TYPE_STRING),
            'delivery_postalcode' => array('type' => self::TYPE_STRING),
            'delivery_zone' => array('type' => self::TYPE_STRING),
            'delivery_country' => array('type' => self::TYPE_STRING),
            'delivery_phone' => array('type' => self::TYPE_STRING),
            'mobile_delivery' => array('type' => self::TYPE_INT),
            'fax_delivery' => array('type' => self::TYPE_INT),
            'email_delivery' => array('type' => self::TYPE_STRING),
            'carrier_code' => array('type' => self::TYPE_STRING),
            'carrier_businessname' => array('type' => self::TYPE_STRING),
            'carrier_name' => array('type' => self::TYPE_STRING),
            'carrier_address' => array('type' => self::TYPE_STRING),
            'carrier_place' => array('type' => self::TYPE_STRING),
            'carrier_postalcode' => array('type' => self::TYPE_STRING),
            'carrier_zone' => array('type' => self::TYPE_STRING),
            'carrier_country' => array('type' => self::TYPE_STRING),
            'carrier_phone' => array('type' => self::TYPE_INT),
            'mobile_carrier' => array('type' => self::TYPE_INT),
            'fax_carrier' => array('type' => self::TYPE_INT),
            'email_carrier' => array('type' => self::TYPE_STRING),
            'order_linenumber' => array('type' => self::TYPE_INT, 'required' => TRUE),
            'reference_order_linenumber' => array('type' => self::TYPE_STRING, 'required' => TRUE),
            'line_type' => array('type' => self::TYPE_STRING, 'required' => TRUE),
            'item_code' => array('type' => self::TYPE_STRING, 'required' => TRUE),
            'item_description' => array('type' => self::TYPE_STRING),
            'customer_itemcode' => array('type' => self::TYPE_STRING),
            'customer_itemdescription' => array('type' => self::TYPE_STRING),
            'customer_documentreference' => array('type' => self::TYPE_STRING),
            'lot' => array('type' => self::TYPE_INT),
            'quantity_requested' => array('type' => self::TYPE_INT, 'required' => TRUE),
            'annotations' => array('type' => self::TYPE_STRING),
            'response' => array('type' => self::TYPE_STRING),
        ]
    ];

    /**
     * Summary of create
     * @return bool
     */
    public function create()
    {
        $db = \Db::getInstance();
        $sql = "CREATE TABLE IF NOT EXISTS " . _DB_PREFIX_ . "export_order(
                export_orderid int(50) AUTO_INCREMENT,
                order_number int(50) NOT NULL UNIQUE,
                order_date date NOT NULL,
                deliver_date date,
                customer_code varchar(50),
                customer_businessname varchar(255),
                customer_name varchar(255),
                customer_address varchar(255),
                customer_place varchar(50),
                customer_postalcode int(50),
                customer_zone varchar(50),
                customer_country varchar(50),
                customer_phone int(20),
                mobile_customers int(20),
                customer_fax int(20),
                customer_email varchar(255),
                delivery_code varchar(50),
                delivery_businessname varchar(255),
                delivery_name varchar(255),
                delivery_address varchar(255),
                delivery_place varchar(50),
                delivery_postalcode varchar(50),
                delivery_zone varchar(50),
                delivery_country varchar(50),
                delivery_phone int(20),
                mobile_delivery int(20),
                fax_delivery int(20),
                email_delivery varchar(255),
                carrier_code varchar(50),
                carrier_businessname varchar(255),
                carrier_name varchar(255),
                carrier_address varchar(255),
                carrier_place varchar(50),
                carrier_postalcode varchar(50),
                carrier_zone varchar(50),
                carrier_country varchar(50),
                carrier_phone int(20),
                mobile_carrier int(20),
                fax_carrier int(20),
                email_carrier varchar(255),
                order_linenumber int(50) NOT NULL,
                reference_order_linenumber varchar(50) NOT NULL,
                line_type varchar(1) NOT NULL,
                item_code varchar(50) NOT NULL,
                item_description varchar(200),
                customer_itemcode varchar(50),
                customer_itemdescription varchar(200),
                customer_documentreference varchar(50),
                lot int(50),
                quantity_requested int(10) NOT NULL,
                annotations varchar(255),
                date_add datetime,
                date_upd datetime,
                response varchar(255),
                status varchar(255),
                PRIMARY KEY (export_orderid)
            )";
        $result = $db -> execute($sql);
        return $result;
    }

    /**
     * Summary of getDetailsToDisplay
     * @return PDOStatement|array|bool|mysqli_result|resource|null
     */
    public function getDetailsToDisplay()
    {
        $sql = 'SELECT *
                FROM `' . _DB_PREFIX_ . self::$definition['table'] . '`';

        return Db::getInstance()->executeS($sql);
    }

    public function insert($order)
    {
        $export_order = new Export_Order();
        $order = new Order($order -> id);
        $customer = new Customer($order -> id_customer);
        $address = new Address($order -> id_address_delivery);
        $state = new State ($address -> id_state);
        $country = new Country ($address -> id_country);
        $carrier = new Carrier ($order -> id_carrier);
        $carrier_code = $carrier -> id_reference;
        $carrier_name = $carrier -> name;
        $carrier_delay = $carrier -> delay;
        $customer_name = $address->firstname.' '. $address->lastname;
        $customercompany = $address -> company;
        $customeraddress1 = $address -> address1;
        $customeraddress2 = $address -> address2;
        $other = $address -> other;
        $customermail = $customer -> email;
        $customercity = $address -> city;
        $postcode = $address -> postcode;
        $customerphone = $address -> phone;
        $phonemobile = $address -> phone_mobile;
        $countrycode = $country -> iso_code;
        $stateDetails = $state->name.' - '. $state->iso_code;
        $export_order -> order_number = $order;
        $export_order -> customer_businessname = $customercompany;
        $export_order -> customer_name = $customer_name;
        $export_order -> customer_address = $customeraddress1;
        $export_order -> customer_place = $customercity;
        $export_order -> customer_postalcode = $postcode;
        $export_order -> customer_zone = $stateDetails;
        $export_order -> customer_country = $countrycode;
        $export_order -> customer_phone = $customerphone;
        $export_order -> mobile_customers = $phonemobile;
        $export_order -> customer_email = $customermail;
        $export_order -> add();
        $export_order -> add(true, false);
    }
}

?>