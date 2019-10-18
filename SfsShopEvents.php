<?php

namespace Softspring\ShopBundle;

class SfsShopEvents
{
    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_LIST_VIEW = 'sfs_shop.admin.customers.list_view';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_INITIALIZE = 'sfs_shop.admin.customers.create_initialize';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_FORM_VALID = 'sfs_shop.admin.customers.create_form_valid';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_SUCCESS = 'sfs_shop.admin.customers.create_success';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_FORM_INVALID = 'sfs_shop.admin.customers.create_form_invalid';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_CREATE_VIEW = 'sfs_shop.admin.customers.create_view';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_READ_VIEW = 'sfs_shop.admin.customers.read_view';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_CUSTOMERS_UPDATE_INITIALIZE = 'sfs_shop.admin.customers.update_initialize';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_CUSTOMERS_UPDATE_FORM_VALID = 'sfs_shop.admin.customers.update_form_valid';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_CUSTOMERS_UPDATE_SUCCESS = 'sfs_shop.admin.customers.update_success';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_CUSTOMERS_UPDATE_FORM_INVALID = 'sfs_shop.admin.customers.update_form_invalid';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_UPDATE_VIEW = 'sfs_shop.admin.customers.update_view';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_CUSTOMERS_DELETE_INITIALIZE = 'sfs_shop.admin.customers.delete_initialize';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_CUSTOMERS_DELETE_FORM_VALID = 'sfs_shop.admin.customers.delete_form_valid';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_CUSTOMERS_DELETE_SUCCESS = 'sfs_shop.admin.customers.delete_success';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_CUSTOMERS_DELETE_FORM_INVALID = 'sfs_shop.admin.customers.delete_form_invalid';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_CUSTOMERS_DELETE_VIEW = 'sfs_shop.admin.customers.delete_view';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_ORDERS_LIST_VIEW = 'sfs_shop.admin.orders.list_view';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_ORDERS_CREATE_INITIALIZE = 'sfs_shop.admin.orders.create_initialize';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_ORDERS_CREATE_FORM_VALID = 'sfs_shop.admin.orders.create_form_valid';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_ORDERS_CREATE_SUCCESS = 'sfs_shop.admin.orders.create_success';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_ORDERS_CREATE_FORM_INVALID = 'sfs_shop.admin.orders.create_form_invalid';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_ORDERS_CREATE_VIEW = 'sfs_shop.admin.orders.create_view';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_ORDERS_READ_VIEW = 'sfs_shop.admin.orders.read_view';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_ORDERS_UPDATE_INITIALIZE = 'sfs_shop.admin.orders.update_initialize';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_ORDERS_UPDATE_FORM_VALID = 'sfs_shop.admin.orders.update_form_valid';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_ORDERS_UPDATE_SUCCESS = 'sfs_shop.admin.orders.update_success';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_ORDERS_UPDATE_FORM_INVALID = 'sfs_shop.admin.orders.update_form_invalid';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_ORDERS_UPDATE_VIEW = 'sfs_shop.admin.orders.update_view';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_ORDERS_DELETE_INITIALIZE = 'sfs_shop.admin.orders.delete_initialize';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_ORDERS_DELETE_FORM_VALID = 'sfs_shop.admin.orders.delete_form_valid';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseEntityEvent")
     */
    const ADMIN_ORDERS_DELETE_SUCCESS = 'sfs_shop.admin.orders.delete_success';

    /**
     * @Event("Softspring\AdminBundle\Event\GetResponseFormEvent")
     */
    const ADMIN_ORDERS_DELETE_FORM_INVALID = 'sfs_shop.admin.orders.delete_form_invalid';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const ADMIN_ORDERS_DELETE_VIEW = 'sfs_shop.admin.orders.delete_view';

    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const CART_VIEW_VIEW = 'sfs_shop.cart.view_view';
    /**
     * @Event("Softspring\AdminBundle\Event\ViewEvent")
     */
    const CART_FINISHED_VIEW = 'sfs_shop.cart.finished_view';
}