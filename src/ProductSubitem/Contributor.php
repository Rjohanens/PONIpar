<?php

namespace PONIpar\ProductSubitem;

use PONIpar\ProductSubitem\Subitem;

/*
   This file is part of the PONIpar PHP Onix Parser Library.
   Copyright (c) 2012, [di] digitale informationssysteme gmbh
   All rights reserved.

   The software is provided under the terms of the new (3-clause) BSD license.
   Please see the file LICENSE for details.
*/

/**
 * A <Contributor> subitem.
 */
class Contributor extends Subitem
{

    // Mapping of constants to types.
    const ROLE_AUTHOR       = 'A01';
    const ROLE_NARRATOR     = 'E03';
    const ROLE_READBY       = 'E07';
    const ROLE_PERFORMER    = 'E99';

    /**
     * The ContributorRole of this Contributor
     */
    protected $role = null;

    /**
     * The contributor value.
     */
    protected $value = null;

    /**
     * Create a new Contributor.
     *
     * @param mixed $in The <Contributor> DOMDocument or DOMElement.
     */
    public function __construct($in)
    {
        parent::__construct($in);

        // Retrieve and check the type.
        $this->role = $this->_getSingleChildElementText('ContributorRole');

        // Get the value.
        $this->value = array();

        $this->value['ContributorRole'] = $this->role;

        try {
            $this->value['PersonName'] = $this->_getSingleChildElementText('PersonName');
        } catch (\Exception $e) {
        }
        try {
            $this->value['PersonNameInverted'] = $this->_getSingleChildElementText('PersonNameInverted');
        } catch (\Exception $e) {
        }
        try {
            $this->value['SequenceNumber'] = $this->_getSingleChildElementText('SequenceNumber');
        } catch (\Exception $e) {
        }
        try {
            $this->value['NamesBeforeKey'] = $this->_getSingleChildElementText('NamesBeforeKey');
        } catch (\Exception $e) {
        }
        try {
            $this->value['KeyNames'] = $this->_getSingleChildElementText('KeyNames');
        } catch (\Exception $e) {
        }
        try {
            $this->value['CorporateName'] = $this->_getSingleChildElementText('CorporateName');
        } catch (\Exception $e) {
        }
        try {
            $this->value['Bio'] = $this->_getSingleChildElementText('BiographicalNote');
        } catch (\Exception $e) {
        }

        if (isset($this->value['Bio'])) {
            $this->value['Bio'] = $this->clean($this->value['Bio']);
        }

        // Save memory.
        $this->_forgetSource();
    }


    /**
     * Get the name of the Contributor
     *
     * @return ?string|null
     */
    public function getName()
    {
        if (isset($this->value['PersonName'])) {
            return $this->value['PersonName'];
        }

        if (isset($this->value['NamesBeforeKey']) && isset($this->value['KeyNames'])) {
            return $this->value['NamesBeforeKey'] . ' ' . $this->value['KeyNames'];
        }

        if (isset($this->value['PersonNameInverted'])) {
            return preg_replace("/^(.+), (.+)$/", "$2 $1", $this->value['PersonNameInverted']);
        }

        if (isset($this->value['CorporateName'])) {
            return $this->value['CorporateName'];
        }

        return null;
    }

    /**
     * Retrieve the type of this identifier.
     *
     * @return string The contents of <ProductIDType>.
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Retrieve the actual value of this identifier.
     *
     * @return string The contents of <Contributor>.
     */
    public function getValue()
    {
        return $this->value;
    }

    private function clean($str)
    {
        $str = str_replace("<![CDATA[", "", $str);
        $str = preg_replace("/\]\]>*$/", "", $str);
        return $str;
    }
}
