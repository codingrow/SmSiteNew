<?php
/**
 * User: Samuel
 * Date: 2/2/2015
 * Time: 9:38 PM
 */

namespace Sm\Core\Abstraction;


interface FileInterface {

    /**
     * Based solely on  a provided string, try to guess what the extension will be
     * @param string $string the subject whose extension is to be guessed
     * @return string The extension in the format-->  .extension
     */
    public function guess_extension($string);
    public function verify_extension($extension, $mime);
}