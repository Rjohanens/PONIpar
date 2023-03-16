<?php

namespace PONIpar\ProductSubitem;

class ProductFormFeature extends Subitem
{
    // list 150
    public const TYPE_DIGITAL = "EA"; // PDF
    public const TYPE_DIGITAL_DOWNLOAD_ONINE = "EB"; // Epub
    public const TYPE_DIGITAL_ONLINE = "EC";
    public const TYPE_DIGITAL_DOWNLOAD = "ED"; // Epub

    /**
     * Type of the ProductForm
     *
     * @var string
     */
    protected $type = null;

    /**
     * ProductFormDetail
     *
     * @var string
     */
    protected $value = null;

    public function __construct($input)
    {
        parent::__construct($input);

        $type = $this->_getSingleChildElementText('ProductFormFeatureType');
        if (!preg_match('/^[0-9]{2}$/', $type)) {
            throw new ONIXException('Invalid format of ProductFormFeatureType');
        }
        $this->type = $type;
        $this->value = $this->_getSingleChildElementText('ProductFormFeatureValue');

        $this->_forgetSource();
    }


    /**
     * Returns the ProductForm
     *
     * @return string <ProductForm>
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Returns the ProductFormDetail
     *
     * @return string <ProductFormDetail>
     */
    public function getValue()
    {
        return $this->value;
    }
}
