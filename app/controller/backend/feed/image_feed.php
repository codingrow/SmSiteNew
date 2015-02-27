<?php
/**
 * User: Samuel
 * Date: 2/7/2015
 * Time: 2:44 PM
 */
use Sm\Core\Abstraction\IoC;

$func = function(){
    $array = [];
    /** @var Model\User $user */
    $user = IoC::$session->get('user');
    if($user and $imgs = $user->findImages()){
        foreach ($imgs as $image  => $information) {
            $information->initUrl();
            $measurements = $information->getImageSize();
            $array[] =
                [
                    'name'      =>$information->getName(),
                    'src'       =>$information->getUrl(),
                    'caption'   =>$information->getCaption(),
                    'w'     =>$measurements[0].'px',
                    'h'     =>$measurements[1].'px',
                    'type'      =>$measurements['mime']
                ];
        }
    }
    return ($array);
};