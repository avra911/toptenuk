<?php
/*******************************************
Mirasvit
This source file is subject to the Mirasvit Software License, which is available at http://mirasvit.com/license/.
Do not edit or add to this file if you wish to upgrade the to newer versions in the future.
If you wish to customize this module for your needs
Please refer to http://mirasvit.com for more information.
@category Mirasvit
@copyright Copyright (C) 2012 Mirasvit (http://mirasvit.com), Vladimir Drok <dva@mirasvit.com.ua>, Alexander Drok<alexander@mirasvit.com.ua>
*******************************************/


class Mirasvit_MCore_Helper_Config extends Mage_Core_Helper_Data
{
    const UPDATES_FEED_URL = 'http://mirasvit.com/blog/category/updates/feed/';
    const STORE_URL        = 'http://mirasvit.com/estore/';
}

if (!function_exists('pr')) {
    function pr($arr)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }
}