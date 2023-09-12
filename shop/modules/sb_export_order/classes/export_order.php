<?php
class Export_Order extends ObjectModel{
    public $order_number;
    public $order_date;
    public $deliver_date;
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
}
?>