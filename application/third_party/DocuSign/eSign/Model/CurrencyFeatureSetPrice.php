<?php
/**
 * CurrencyFeatureSetPrice
 *
 * PHP version 5
 *
 * @category Class
 * @package  DocuSign\eSign
 * @author   Swaagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * DocuSign REST API
 *
 * The DocuSign REST API provides you with a powerful, convenient, and simple Web services API for interacting with DocuSign.
 *
 * OpenAPI spec version: v2
 * Contact: devcenter@docusign.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace DocuSign\eSign\Model;

use \ArrayAccess;

/**
 * CurrencyFeatureSetPrice Class Doc Comment
 *
 * @category    Class
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class CurrencyFeatureSetPrice implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'currencyFeatureSetPrice';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'currency_code' => 'string',
        'currency_symbol' => 'string',
        'envelope_fee' => 'string',
        'fixed_fee' => 'string',
        'seat_fee' => 'string'
    ];

    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of attributes where the key is the local name, and the value is the original name
     * @var string[]
     */
    protected static $attributeMap = [
        'currency_code' => 'currencyCode',
        'currency_symbol' => 'currencySymbol',
        'envelope_fee' => 'envelopeFee',
        'fixed_fee' => 'fixedFee',
        'seat_fee' => 'seatFee'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'currency_code' => 'setCurrencyCode',
        'currency_symbol' => 'setCurrencySymbol',
        'envelope_fee' => 'setEnvelopeFee',
        'fixed_fee' => 'setFixedFee',
        'seat_fee' => 'setSeatFee'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'currency_code' => 'getCurrencyCode',
        'currency_symbol' => 'getCurrencySymbol',
        'envelope_fee' => 'getEnvelopeFee',
        'fixed_fee' => 'getFixedFee',
        'seat_fee' => 'getSeatFee'
    ];

    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    public static function setters()
    {
        return self::$setters;
    }

    public static function getters()
    {
        return self::$getters;
    }

    

    

    /**
     * Associative array for storing property values
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['currency_code'] = isset($data['currency_code']) ? $data['currency_code'] : null;
        $this->container['currency_symbol'] = isset($data['currency_symbol']) ? $data['currency_symbol'] : null;
        $this->container['envelope_fee'] = isset($data['envelope_fee']) ? $data['envelope_fee'] : null;
        $this->container['fixed_fee'] = isset($data['fixed_fee']) ? $data['fixed_fee'] : null;
        $this->container['seat_fee'] = isset($data['seat_fee']) ? $data['seat_fee'] : null;
    }

    /**
     * show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalid_properties = [];
        return $invalid_properties;
    }

    /**
     * validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properteis are valid
     */
    public function valid()
    {
        return true;
    }


    /**
     * Gets currency_code
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->container['currency_code'];
    }

    /**
     * Sets currency_code
     * @param string $currency_code Specifies the alternate ISO currency code for the account.
     * @return $this
     */
    public function setCurrencyCode($currency_code)
    {
        $this->container['currency_code'] = $currency_code;

        return $this;
    }

    /**
     * Gets currency_symbol
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->container['currency_symbol'];
    }

    /**
     * Sets currency_symbol
     * @param string $currency_symbol Specifies the alternate currency symbol for the account.
     * @return $this
     */
    public function setCurrencySymbol($currency_symbol)
    {
        $this->container['currency_symbol'] = $currency_symbol;

        return $this;
    }

    /**
     * Gets envelope_fee
     * @return string
     */
    public function getEnvelopeFee()
    {
        return $this->container['envelope_fee'];
    }

    /**
     * Sets envelope_fee
     * @param string $envelope_fee An incremental envelope cost for plans with envelope overages (when `isEnabled` is set to **true**.)
     * @return $this
     */
    public function setEnvelopeFee($envelope_fee)
    {
        $this->container['envelope_fee'] = $envelope_fee;

        return $this;
    }

    /**
     * Gets fixed_fee
     * @return string
     */
    public function getFixedFee()
    {
        return $this->container['fixed_fee'];
    }

    /**
     * Sets fixed_fee
     * @param string $fixed_fee Specifies a one-time fee associated with the plan (when `isEnabled` is set to **true**.)
     * @return $this
     */
    public function setFixedFee($fixed_fee)
    {
        $this->container['fixed_fee'] = $fixed_fee;

        return $this;
    }

    /**
     * Gets seat_fee
     * @return string
     */
    public function getSeatFee()
    {
        return $this->container['seat_fee'];
    }

    /**
     * Sets seat_fee
     * @param string $seat_fee Specifies an incremental seat cost for seat-based plans (when `isEnabled` is set to **true**.)
     * @return $this
     */
    public function setSeatFee($seat_fee)
    {
        $this->container['seat_fee'] = $seat_fee;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     * @param  integer $offset Offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     * @param  integer $offset Offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(\DocuSign\eSign\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        }

        return json_encode(\DocuSign\eSign\ObjectSerializer::sanitizeForSerialization($this));
    }
}


