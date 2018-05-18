<?php
/**
 * ServiceInformation
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
 * ServiceInformation Class Doc Comment
 *
 * @category    Class
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ServiceInformation implements ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      * @var string
      */
    protected static $swaggerModelName = 'serviceInformation';

    /**
      * Array of property to type mappings. Used for (de)serialization
      * @var string[]
      */
    protected static $swaggerTypes = [
        'build_branch' => 'string',
        'build_branch_deployed_date_time' => 'string',
        'build_sha' => 'string',
        'build_version' => 'string',
        'linked_sites' => 'string[]',
        'service_versions' => '\DocuSign\eSign\Model\ServiceVersion[]'
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
        'build_branch' => 'buildBranch',
        'build_branch_deployed_date_time' => 'buildBranchDeployedDateTime',
        'build_sha' => 'buildSHA',
        'build_version' => 'buildVersion',
        'linked_sites' => 'linkedSites',
        'service_versions' => 'serviceVersions'
    ];


    /**
     * Array of attributes to setter functions (for deserialization of responses)
     * @var string[]
     */
    protected static $setters = [
        'build_branch' => 'setBuildBranch',
        'build_branch_deployed_date_time' => 'setBuildBranchDeployedDateTime',
        'build_sha' => 'setBuildSha',
        'build_version' => 'setBuildVersion',
        'linked_sites' => 'setLinkedSites',
        'service_versions' => 'setServiceVersions'
    ];


    /**
     * Array of attributes to getter functions (for serialization of requests)
     * @var string[]
     */
    protected static $getters = [
        'build_branch' => 'getBuildBranch',
        'build_branch_deployed_date_time' => 'getBuildBranchDeployedDateTime',
        'build_sha' => 'getBuildSha',
        'build_version' => 'getBuildVersion',
        'linked_sites' => 'getLinkedSites',
        'service_versions' => 'getServiceVersions'
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
        $this->container['build_branch'] = isset($data['build_branch']) ? $data['build_branch'] : null;
        $this->container['build_branch_deployed_date_time'] = isset($data['build_branch_deployed_date_time']) ? $data['build_branch_deployed_date_time'] : null;
        $this->container['build_sha'] = isset($data['build_sha']) ? $data['build_sha'] : null;
        $this->container['build_version'] = isset($data['build_version']) ? $data['build_version'] : null;
        $this->container['linked_sites'] = isset($data['linked_sites']) ? $data['linked_sites'] : null;
        $this->container['service_versions'] = isset($data['service_versions']) ? $data['service_versions'] : null;
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
     * Gets build_branch
     * @return string
     */
    public function getBuildBranch()
    {
        return $this->container['build_branch'];
    }

    /**
     * Sets build_branch
     * @param string $build_branch Reserved: TBD
     * @return $this
     */
    public function setBuildBranch($build_branch)
    {
        $this->container['build_branch'] = $build_branch;

        return $this;
    }

    /**
     * Gets build_branch_deployed_date_time
     * @return string
     */
    public function getBuildBranchDeployedDateTime()
    {
        return $this->container['build_branch_deployed_date_time'];
    }

    /**
     * Sets build_branch_deployed_date_time
     * @param string $build_branch_deployed_date_time Reserved: TBD
     * @return $this
     */
    public function setBuildBranchDeployedDateTime($build_branch_deployed_date_time)
    {
        $this->container['build_branch_deployed_date_time'] = $build_branch_deployed_date_time;

        return $this;
    }

    /**
     * Gets build_sha
     * @return string
     */
    public function getBuildSha()
    {
        return $this->container['build_sha'];
    }

    /**
     * Sets build_sha
     * @param string $build_sha Reserved: TBD
     * @return $this
     */
    public function setBuildSha($build_sha)
    {
        $this->container['build_sha'] = $build_sha;

        return $this;
    }

    /**
     * Gets build_version
     * @return string
     */
    public function getBuildVersion()
    {
        return $this->container['build_version'];
    }

    /**
     * Sets build_version
     * @param string $build_version Reserved: TBD
     * @return $this
     */
    public function setBuildVersion($build_version)
    {
        $this->container['build_version'] = $build_version;

        return $this;
    }

    /**
     * Gets linked_sites
     * @return string[]
     */
    public function getLinkedSites()
    {
        return $this->container['linked_sites'];
    }

    /**
     * Sets linked_sites
     * @param string[] $linked_sites 
     * @return $this
     */
    public function setLinkedSites($linked_sites)
    {
        $this->container['linked_sites'] = $linked_sites;

        return $this;
    }

    /**
     * Gets service_versions
     * @return \DocuSign\eSign\Model\ServiceVersion[]
     */
    public function getServiceVersions()
    {
        return $this->container['service_versions'];
    }

    /**
     * Sets service_versions
     * @param \DocuSign\eSign\Model\ServiceVersion[] $service_versions 
     * @return $this
     */
    public function setServiceVersions($service_versions)
    {
        $this->container['service_versions'] = $service_versions;

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


