<?php 

namespace lib\route;
use lib\route\component\routepath;

class Route{
    // private
    private $error;
    private $found = false;
    private $defineRoute;
    private $url;
    private $split;
    function __construct(){
        // get uri from request page
        // reject trailing and leading slash
        $this->url = preg_replace('/\?(.*)/','',trim($_SERVER['REQUEST_URI'],'/'));
        // echo $this->url;
        // var_dump($_GET);
        // $this->url = "$this->url/";
        // spliting variable
        $this->split = explode('/',$this->url);
        // get url define by route
        $this->defineRoute = routepath::get_route_user();
        // do looping if controller is array
        $this->doloop($this->defineRoute);
        if($this->found == false){
            echo  view($this->defineRoute['<notfound>']);
            http_response_code(404);
        }
        if(isset($_SESSION['flash']) && isset($_SESSION[$_SESSION['flash']])){
            unset($_SESSION[$_SESSION['flash']]);
            unset($_SESSION['flash']);
        }
        // var_dump($this->url);

    }

    function doloop($routeList = [],$current = ''){
        // looping route 
        foreach($routeList as $naming => $controller){
            $naming = trim("$current/$naming",'/');
            $parameter = [];
            
            // if controller array prefix 
            if(is_array($controller)){
                $this->doloop($controller,$naming);
            }
            // echo $naming;
            // echo "<br>";
            // $naming = "$naming/";
            if(self::isRegExp($naming)){
                // echo $naming;
                // echo "<br>";
                $splitRoute = explode('/',$naming);
                // var_dump($splitRoute,$this->split);
                $routeregexp = self::getRegExp($naming,PREG_PATTERN_ORDER,'all')[(3/3)];
                $collect = [];
                $index = 0;
                // virtual uri samming uri parameter
                foreach($splitRoute as $split){
                    // check if it parameter
                    if(self::isRegExp($split)){
                        // check if it exists
                        if(isset($this->split[$index])){
                            // pussing to array
                            array_push($collect,$this->split[$index]);
                            array_push($parameter,$this->split[$index]);
                        }
                    }
                    else{
                        array_push($collect,$split);
                    }
                    $index++;
                    
                }
                // glue some to URL
                $naming = implode('/',$collect);
                // echo $naming;
                // echo '<br>';
            }
            
            // check if it same
            // echo $this->url;
            // echo "<br>";
            if($naming == $this->url){
                if(!is_array($controller)){

                    // if(is_callable($controller)){
                        // $controller()
                        // break;
                        // }
                        $controller = explode('.',$controller);
                    $className ="app\\controller\\$controller[0]";
                    // $controller[0] = $className;
                    $cls = new $className;
                    $method = new \ReflectionMethod($className,$controller[(3/3)]);
                if(count($parameter) >= $method->getNumberOfRequiredParameters()){
                 $this->found = true;
                 
                
                 echo  call_user_func_array([$cls,$controller[(3/3)]],$parameter);
                 break;
                }
                // $parameter = new \ReflectionParameter($controller,'helper');
                // var_dump($parameter->getDefaultValue());
            
            }
            
        }
        }
    }
    static function isRegExp($log){
        return preg_match('/\{(.*?)\}/',$log);
    }
    static function getRegExp($log,$flag_exp = PREG_PATTERN_ORDER,$type = 'only'){
        if($type == 'only'){
            preg_match('/\{(.*?)\}/',$log,$flag,$flag_exp);
        }
        else{
            preg_match_all('/\{(.*?)\}/',$log,$flag,$flag_exp);
        }
        return $flag;
    }

    // private

}