<?php
require_once 'php/models/BaseModel.php';
require_once 'php/models/UserModel.php';
require_once 'php/models/WebshopModel.php';
require_once 'php/models/CartModel.php';

abstract class ModelManager
{
    protected static array $models = [];
    
    public static function getBaseModel() : BaseModel
    {
        return self::getModel('BaseModel');
    }    

    public static function getUserModel() : UserModel
    {
        return self::getModel('UserModel');
    }    

    public static function getShopModel() : WebshopModel
    {
        return self::getModel('WebshopModel');
    }    

    public static function getCartModel() : CartModel
    {
        return self::getModel('CartModel');
    }

    protected static function getModel(string $modelclass) : BaseModel
    {
        if (isset(self::$models[$modelclass])===false)
        {
            self::$models[$modelclass] = new $modelclass();
        } 
        return self::$models[$modelclass];
    }    
}
