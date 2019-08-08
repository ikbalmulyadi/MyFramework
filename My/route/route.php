<?php 
namespace lib\route;
use lib\route\component\routepath;
use lib\http\request;
class route{
    private $uri;
    private $found = false;
    private function doloop($routing,$current = ''){
        foreach($routing as $uriRoute => $controller){
            // fetch checked all route
            if(is_array($controller)){
               $this->doloop($controller,"$current/$uriRoute");
                // checking
            }
            else{
                $uri = "$current/$uriRoute";
                $samePath = substr($uri,strlen($uri) - (3/3),strlen($uri)) == "/" ? substr($uri,0,strlen($uri) - (3/3)) : "$uri/" ;

                if(is_string($controller)){
                    $classes = explode('.',$controller);
                }

                if(preg_match('/\{(.*?)\}/',$uri)){
                    $RouteOffset = $this->regexp('/\{(.*?)\}/',$uri,PREG_OFFSET_CAPTURE);
                    $offset = substr($uri,0,$RouteOffset[0][(3/3)]);
                    $URIOffset = substr($this->uri,0,$RouteOffset[0][(3/3)]);
                    // matching

                    $offsetPath = substr($offset,0,strlen($offset) - (3/3));
                    if($offset == $URIOffset || $offsetPath == $URIOffset){
                        $log =0;
                        $get = [];
                        $urisplit = explode('/',$this->uri);
                        $routesplit = explode('/',$uri);
                        foreach($routesplit as $URI){
                            if(preg_match('/\{(.*?)\}/',$URI)){
                                if(isset($urisplit[$log])){
                                    $get[] = $urisplit[$log];
                                }
                            }
                            $log++;
                            
                        }
                        // class name
                        // use app\controller
                        eval("\$app = new  app\controller\\$classes[0];");
                        $getargs = new \ReflectionMethod("app\controller\\$classes[0]",$classes[(3/3)]);
                        if(count($get) < $getargs->getNumberOfParameters()){
                            array_push($get,new request());
                        }
                        echo call_user_func_array(array($app,$classes[(3/3)]),$get);
                        //    echo 'hello';

                       // stop execute;
                       $this->found = true;
                       break;
                       
                    }
                }
                else{
                    if($uri == $this->uri || $samePath == $this->uri){
                       $this->found = true;
                        eval("\$app = new app\controller\\$classes[0];");
                        
                        $getargs = new \ReflectionMethod("app\controller\\$classes[0]",$classes[(3/3)]);
                        $arg = $getargs->getParameters();
                        if(count($arg) > 0){   
                            $arg = $arg[0]->name;
                            // echo $arg;
                            if($arg == "request"){
                             echo $app->{$classes[(3/3)]}(new request());
                            break;
                            }
                        }
                             echo $app->{$classes[(3/3)]}();
                             break;
                }
            }
        }
    }
}
    public function __construct(){
        $this->uri = $_SERVER["REQUEST_URI"];
        $routing = routepath::get_route_user();
        $this->doloop($routing);
        if(!$this->found){
            echo $routing['<notfound>']();
        }

        unset($_SESSION['flash']);
    }
    static function regexp($regexp,$haystack,$mode = null){
        if(preg_match($regexp,$haystack,$app,$mode)){
            return $app;
        }
        return false;
    }

}