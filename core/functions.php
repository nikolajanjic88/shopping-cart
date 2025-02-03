<?php

function dd($arr)
{
    echo '<pre>'; 
    print_r($arr);
    echo '</pre>';
    die();
}


function urlIs($value) 
{
    return $_SERVER['REQUEST_URI'] === $value;   
}


function email($email) 
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


function passwordLength($password) 
{
    return (strlen($password) >= 6 && strlen($password) <= 20);
}


function compareValues($val1, $val2) 
{
    return $val1 === $val2;
}


function abort($code = 404) 
{
    http_response_code($code);
    require_once BASE_PATH . "views/$code.php";
    die();
}


function delTree($dir) 
{ 
    if(!file_exists($dir))
    {
        return false;
    }
 
    $files = array_diff(scandir($dir), array('.', '..')); 
    if($files)
    {
        foreach ($files as $file) 
        { 
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
        } 
    }        
    return rmdir($dir); 
} 


function is_image($path) 
{
    $a = getimagesize($path);
    if($a) 
    {
        $image_type = $a[2];
        if(in_array($image_type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP, IMAGETYPE_WEBP]))
        {
            return true;
        }
    }
    return false;
}


function validImageDimensions($image, $width, $height)
{
    if(!empty($image) && (getimagesize($image)[0] > $width || getimagesize($image)[1] > $height))
    {
        return false;
    }

    return true;
}


function issetCategory($value = null)
{
    if(isset($_GET['category']))
    {
        return $_GET['category'] === $value ? 'active' : '';
    }   
}

function redirect($route)
{
    header('location: /' . $route);
    exit;
}

function dateFormat($date)
{
    return date( "d/m/Y - H:i:s", strtotime($date));
}