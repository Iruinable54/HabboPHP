<?php
    class Factory
    {
        public static function load ($path,$classe,$arg = array())
        {
            $path = $path.'/class' ;
            if (file_exists ($path.'/class.'.$classe.'.php'))
            {
                require $path.'/class.'.$classe.'.php';
                return new $classe($arg);
            }
            else
                throw new RuntimeException ('La classe <strong>' . $classe . '</strong> n\'a pu être trouvée !');
        }
    }
?>