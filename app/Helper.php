<?php

// use Session;

function menuSubmenu($menu, $submenu)
{
    $request = request();
    $request->session()->forget(['lsbm','lsbsm']);
    $request->session()->put(['lsbm'=>$menu,'lsbsm'=>$submenu]);
    return true;
}

function menuSubmenuSubsubmeny($menu, $submenu, $subsubmenu)
{
    $request = request();
    $request->session()->forget(['lsbm','lsbsm','lsbssm']);
    $request->session()->put(['lsbm'=>$menu,'lsbsm'=>$submenu,'lsbssm'=>$subsubmenu]);
    return true;
}

function custom_name($text, $limit)
{
  if(strlen($text) > $limit)
  {
    return str_pad(mb_substr($text, 0, ($limit - 2),"utf-8"), ($limit +1),'.');
    // return str_pad(substr($text, 0, ($limit - 2)), ($limit +1),'.');
  }
  else
  {
    return $text;
  }
}

function custom_slug($text)
{

    $string = Str::slug($text);

    $string = substr($string, 0,100);
    return $string;
}

function getNameValue($name_bn,$name_en)
{
    if(Session::get('lang') == 'en'){
        return $name_en;
    }
    return $name_bn;
}

function orderStatus()
{
    $delivery_status = array(
        0 => 'Pending',
        1 => 'Order Accept',
        2 => 'Order Decline',
        // 3 => 'SSL integration',
    );

    return $delivery_status;
}

function deliveryStatus()
{
    $delivery_status = array(
        1 => 'Pending',
        2 => 'On Delivery',
        3 => 'Delivered',
        // 4 => 'Returned',
    );

    return $delivery_status;
}

function paymentStatus()
{
    $payment_status = array(
        1 => 'Pending',
        2 => 'Recieved',
        3 => 'Rejected',
        4 => 'Returned',
    );

    return $payment_status;
}

