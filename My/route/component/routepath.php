<?php 

namespace lib\route\component;
class routepath{
    static function get_route_user(){
        return require __ROOT__.'/routing/route.php';
    }
}