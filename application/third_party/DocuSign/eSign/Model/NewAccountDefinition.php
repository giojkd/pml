<?php
/**
 * NewAccountDefinition
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
 * NewAccountDefinition Class Doc Comment
 *
 * @category    Class
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class NewAccountDefinition implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'newAccountDefinition';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'account_name' => 'string',
        'account_settings' => '\DocuSign\eSign\Model\NameValue[]',
        'address_information' => '\DocuSign\eSign\Model\AccountAddress',
        'credit_card_information' => '\DocuSign\eSign\Model\CreditCardInformation',
        'distributor_code' => 'string',
        'distributor_password' => 'string',
        'initial_user' => '\DocuSign\eSign\Model\UserInformation',
        'plan_information' => '\DocuSign\eSign\Model\PlanInformation',
        'referral_information' => '\DocuSign\eSign\Model\ReferralInformation',
        'social_account_information' => '\DocuSign\eSign\Model\SocialAccountInformation'
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
        'account_name' => 'accountName',
        'account_settings' => 'accountSettings',
        'address_information' => 'addressInformation',
        'credit_card_information' => 'creditCardInformation',
        'distributor_code' => 'distributorCode',
        'distributor_password' => 'distributorPassword',
        'initial_user' => 'initialUser',
        'plan_information' => 'planInformation',
        'referral_information' => 'referralInformation',
        'social_account_information' => 'socialAccountInformation'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'account_name' => 'setAccountName',
        'account_settings' => 'setAccountSettings',
        'address_information' => 'setAddressInformation',
        'credit_card_information' => 'setCreditCardInformation',
        'distributor_code' => 'setDistributorCode',
        'distributor_password' => 'setDistributorPassword',
        'initial_user' => 'setInitialUser',
        'plan_information' => 'setPlanInformation',
        'referral_information' => 'setReferralInformation',
        'social_account_information' => 'setSocialAccountInformation'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'account_name' => 'getAccountName',
        'account_settings' => 'getAccountSettings',
        'address_information' => 'getAddressInformation',
        'credit_card_information' => 'getCreditCardInformation',
        'distributor_code' => 'getDistributorCode',
        'distributor_password' => 'getDistributorPassword',
        'initial_user' => 'getInitialUser',
        'plan_information' => 'getPlanInformation',
        'referral_information' => 'getReferralInformation',
        'social_account_information' => 'getSocialAccountInformation'
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
        $this->container['account_name'] = isset($data['account_name']) ? $data['account_name'] : null;
        $this->container['account_settings'] = isset($data['account_settings']) ? $data['account_settings'] : null;
        $this->container['address_information'] = isset($data['address_information']) ? $data['address_information'] : null;
        $this->container['credit_card_information'] = isset($data['credit_card_information']) ? $data['credit_card_information'] : null;
        $this->container['distributor_code'] = isset($data['distributor_code']) ? $data['distributor_code'] : null;
        $this->container['distributor_password'] = isset($data['distributor_password']) ? $data['distributor_password'] : null;
        $this->container['initial_user'] = isset($data['initial_user']) ? $data['initial_user'] : null;
        $this->container['plan_information'] = isset($data['plan_information']) ? $data['plan_information'] : null;
        $this->container['referral_information'] = isset($data['referral_information']) ? $data['referral_information'] : null;
        $this->container['social_account_information'] = isset($data['social_account_information']) ? $data['social_account_information'] : null;
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
     * Gets account_name
     * @return string
     */
    public function getAccountName()
    {
        return $this->container['account_name'];
    }

    /**
     * Sets account_name
     * @param string $account_name The account name for the new account.
     * @return $this
     */
    public function setAccountName($account_name)
    {
        $this->container['account_name'] = $account_name;

        return $this;
    }

    /**
     * Gets account_settings
     * @return \DocuSign\eSign\Model\NameValue[]
     */
    public function getAccountSettings()
    {
        return $this->container['account_settings'];
    }

    /**
     * Sets account_settings
     * @param \DocuSign\eSign\Model\NameValue[] $account_settings The list of account settings. These determine the features available for the account. Note that some features are determined by the plan used to create the account, and cannot be overridden.
     * @return $this
     */
    public function setAccountSettings($account_settings)
    {
        $this->container['account_settings'] = $account_settings;

        return $this;
    }

    /**
     * Gets address_information
     * @return \DocuSign\eSign\Model\AccountAddress
     */
    public function getAddressInformation()
    {
        return $this->container['address_information'];
    }

    /**
     * Sets address_information
     * @param \DocuSign\eSign\Model\AccountAddress $address_information
     * @return $this
     */
    public function setAddressInformation($address_information)
    {
        $this->container['address_information'] = $address_information;

        return $this;
    }

    /**
     * Gets credit_card_information
     * @return \DocuSign\eSign\Model\CreditCardInformation
     */
    public function getCreditCardInformation()
    {
        return $this->container['credit_card_information'];
    }

    /**
     * Sets credit_card_information
     * @param \DocuSign\eSign\Model\CreditCardInformation $credit_card_information
     * @return $this
     */
    public function setCreditCardInformation($credit_card_information)
    {
        $this->container['credit_card_information'] = $credit_card_information;

        return $this;
    }

    /**
     * Gets distributor_code
     * @return string
     */
    public function getDistributorCode()
    {
        return $this->container['distributor_code'];
    }

    /**
     * Sets distributor_code
     * @param string $distributor_code The code that identifies the billing plan groups and plans for the new account.
     * @return $this
     */
    public function setDistributorCode($distributor_code)
    {
        $this->container['distributor_code'] = $distributor_code;

        return $this;
    }

    /**
     * Gets distributor_password
     * @return string
     */
    public function getDistributorPassword()
    {
        return $this->container['distributor_password'];
    }

    /**
     * Sets distributor_password
     * @param string $distributor_password The password for the distributorCode.
     * @return $this
     */
    public function setDistributorPassword($distributor_password)
    {
        $this->container['distributor_password'] = $distributor_password;

        return $this;
    }

    /**
     * Gets initial_user
     * @return \DocuSign\eSign\Model\UserInformation
     */
    public function getInitialUser()
    {
        return $this->container['initial_user'];
    }

    /**
     * Sets initial_user
     * @param \DocuSign\eSign\Model\UserInformation $initial_user
     * @return $this
     */
    public function setInitialUser($initial_user)
    {
        $this->container['initial_user'] = $initial_user;

        return $this;
    }

    /**
     * Gets plan_information
     * @return \DocuSign\eSign\Model\PlanInformation
     */
    public function getPlanInformation()
    {
        return $this->container['plan_information'];
    }

    /**
     * Sets plan_information
     * @param \DocuSign\eSign\Model\PlanInformation $plan_information
     * @return $this
     */
    public function setPlanInformation($plan_information)
    {
        $this->container['plan_information'] = $plan_information;

        return $this;
    }

    /**
     * Gets referral_information
     * @return \DocuSign\eSign\Model\ReferralInformation
     */
    public function getReferralInformation()
    {
        return $this->container['referral_information'];
    }

    /**
     * Sets referral_information
     * @param \DocuSign\eSign\Model\ReferralInformation $referral_information
     * @return $this
     */
    public function setReferralInformation($referral_information)
    {
        $this->container['referral_information'] = $referral_information;

        return $this;
    }

    /**
     * Gets social_account_information
     * @return \DocuSign\eSign\Model\SocialAccountInformation
     */
    public function getSocialAccountInformation()
    {
        return $this->container['social_account_information'];
    }

    /**
     * Sets social_account_information
     * @param \DocuSign\eSign\Model\SocialAccountInformation $social_account_information
     * @return $this
     */
    public function setSocialAccountInformation($social_account_information)
    {
        $this->container['social_account_information'] = $social_account_information;

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


