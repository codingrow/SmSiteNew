<?php
/**
 * User: Samuel
 * Date: 2/2/2015
 * Time: 9:35 PM
 */

namespace Sm\Core\File;


use Sm\Core\Abstraction\FileInterface;
use Sm\Core\Abstraction\IoC;

class File implements FileInterface{
    static $permitted_mime_arr;
    public $name;
    public $mime;
    /**
     * Based solely on  a provided string, try to guess what the extension will be
     * @param string $string the subject whose extension is to be guessed
     * @return string The extension in the format-->  .extension
     */
    public function guess_extension($string) {
        $string = strrev($string);
        return '.' . strrev(stristr($string, '.', true));
    }

    public function verify_extension($extension, $mime) {
        $extension = ltrim($extension, '.');
        if (array_key_exists($extension, static::$permitted_mime_arr)) {
            if (is_array(static::$permitted_mime_arr[$extension]) && in_array($mime, static::$permitted_mime_arr[$extension])) {
                return true;
            } else {
                if (static::$permitted_mime_arr[$extension] == $mime) {
                    return true;
                }
            }
        }
        return false;
    }

    public function process(&$file_post) {
        $file_ary = array();
        if (!is_array($file_post['name'])) {
            foreach ($file_post as $key => $value) {
                $file_post[$key] = [$value];
            }
        }
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        for ($i = 0; $i < $file_count; $i++) {
            $ext = $this->guess_extension($file_post['name'][$i]);
            if (!$this->verify_extension($ext, $file_post['type'][$i])) {
                continue;
            }
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
            $server_name = 'u' . IoC::$util->generate_random_string(20);
            $file_ary[$i]['server_name'] = $server_name . $ext;
        }
        return $file_post = $file_ary;
    }
}

File::$permitted_mime_arr = ['3g2' => 'video/3gpp2', '3gp' => 'video/3gp', '7zip' => array('application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip'), 'aac' => 'audio/x-acc', 'ac3' => 'audio/ac3', 'ai' => array('application/pdf', 'application/postscript'), 'aif' => array('audio/x-aiff', 'audio/aiff'), 'aifc' => 'audio/x-aiff', 'aiff' => array('audio/x-aiff', 'audio/aiff'), 'au' => 'audio/x-au', 'avi' => array('video/x-msvideo', 'video/msvideo', 'video/avi', 'application/x-troff-msvideo'), 'bin' => array('application/macbinary', 'application/mac-binary', 'application/octet-stream', 'application/x-binary', 'application/x-macbinary'), 'bmp' => array('image/bmp', 'image/x-bmp', 'image/x-bitmap', 'image/x-xbitmap', 'image/x-win-bitmap', 'image/x-windows-bmp', 'image/ms-bmp', 'image/x-ms-bmp', 'application/bmp', 'application/x-bmp', 'application/x-win-bitmap'), 'cdr' => array('application/cdr', 'application/coreldraw', 'application/x-cdr', 'application/x-coreldraw', 'image/cdr', 'image/x-cdr', 'zz-application/zz-winassoc-cdr'), 'cer' => array('application/pkix-cert', 'application/x-x509-ca-cert'), 'class' => 'application/octet-stream', 'cpt' => 'application/mac-compactpro', 'crl' => array('application/pkix-crl', 'application/pkcs-crl'), 'crt' => array('application/x-x509-ca-cert', 'application/x-x509-user-cert', 'application/pkix-cert'), 'csr' => 'application/octet-stream', 'css' => array('text/css', 'text/plain'), 'csv' => array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'), 'dcr' => 'application/x-director', 'der' => 'application/x-x509-ca-cert', 'dir' => 'application/x-director', 'dll' => 'application/octet-stream', 'dms' => 'application/octet-stream', 'doc' => array('application/msword', 'application/vnd.ms-office'), 'docx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword', 'application/x-zip'), 'dot' => array('application/msword', 'application/vnd.ms-office'), 'dotx' => array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword'), 'dvi' => 'application/x-dvi', 'dxr' => 'application/x-director', 'eml' => 'message/rfc822', 'eps' => 'application/postscript', 'exe' => array('application/octet-stream', 'application/x-msdownload'), 'f4v' => 'video/mp4', 'flac' => 'audio/x-flac', 'gif' => 'image/gif', 'gpg' => 'application/gpg-keys', 'gtar' => 'application/x-gtar', 'gz' => 'application/x-gzip', 'gzip' => 'application/x-gzip', 'htm' => array('text/html', 'text/plain'), 'html' => array('text/html', 'text/plain'), 'hqx' => array('application/mac-binhex40', 'application/mac-binhex', 'application/x-binhex40', 'application/x-mac-binhex40'), 'ical' => 'text/calendar', 'ics' => 'text/calendar', 'jar' => array('application/java-archive', 'application/x-java-application', 'application/x-jar', 'application/x-compressed'), 'jpe' => array('image/jpeg', 'image/pjpeg'), 'jpeg' => array('image/jpeg', 'image/pjpeg'), 'jpg' => array('image/jpeg', 'image/pjpeg'), 'js' => array('application/x-javascript', 'text/plain'), 'json' => array('application/json', 'text/json'), 'kdb' => 'application/octet-stream', 'kml' => array('application/vnd.google-earth.kml+xml', 'application/xml', 'text/xml'), 'kmz' => array('application/vnd.google-earth.kmz', 'application/zip', 'application/x-zip'), 'lha' => 'application/octet-stream', 'log' => array('text/plain', 'text/x-log'), 'lzh' => 'application/octet-stream', 'm3u' => 'text/plain', 'm4a' => 'audio/x-m4a', 'm4u' => 'application/vnd.mpegurl', 'mid' => 'audio/midi', 'midi' => 'audio/midi', 'mif' => 'application/vnd.mif', 'mov' => 'video/quicktime', 'movie' => 'video/x-sgi-movie', 'mp2' => 'audio/mpeg', 'mp3' => array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'), 'mp4' => 'video/mp4', 'mpe' => 'video/mpeg', 'mpeg' => 'video/mpeg', 'mpg' => 'video/mpeg', 'mpga' => 'audio/mpeg', 'oda' => 'application/oda', 'ogg' => 'audio/ogg', 'p10' => array('application/x-pkcs10', 'application/pkcs10'), 'p12' => 'application/x-pkcs12', 'p7a' => 'application/x-pkcs7-signature', 'p7c' => array('application/pkcs7-mime', 'application/x-pkcs7-mime'), 'p7m' => array('application/pkcs7-mime', 'application/x-pkcs7-mime'), 'p7r' => 'application/x-pkcs7-certreqresp', 'p7s' => 'application/pkcs7-signature', 'pdf' => array('application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'), 'pem' => array('application/x-x509-user-cert', 'application/x-pem-file', 'application/octet-stream'), 'pgp' => 'application/pgp', 'php' => array('application/x-httpd-php', 'application/php', 'application/x-php', 'text/php', 'text/x-php', 'application/x-httpd-php-source'), 'php3' => 'application/x-httpd-php', 'php4' => 'application/x-httpd-php', 'phps' => 'application/x-httpd-php-source', 'phtml' => 'application/x-httpd-php', 'png' => array('image/png', 'image/x-png'), 'ppt' => array('application/powerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.ms-office', 'application/msword'), 'pptx' => array('application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/x-zip', 'application/zip'), 'ps' => 'application/postscript', 'psd' => array('application/x-photoshop', 'image/vnd.adobe.photoshop'), 'qt' => 'video/quicktime', 'ra' => 'audio/x-realaudio', 'ram' => 'audio/x-pn-realaudio', 'rar' => array('application/x-rar', 'application/rar', 'application/x-rar-compressed'), 'rm' => 'audio/x-pn-realaudio', 'rpm' => 'audio/x-pn-realaudio-plugin', 'rsa' => 'application/x-pkcs7', 'rtf' => 'text/rtf', 'rtx' => 'text/richtext', 'rv' => 'video/vnd.rn-realvideo', 'sea' => 'application/octet-stream', 'shtml' => array('text/html', 'text/plain'), 'sit' => 'application/x-stuffit', 'smi' => 'application/smil', 'smil' => 'application/smil', 'so' => 'application/octet-stream', 'sst' => 'application/octet-stream', 'svg' => array('image/svg+xml', 'application/xml', 'text/xml'), 'swf' => 'application/x-shockwave-flash', 'tar' => 'application/x-tar', 'text' => 'text/plain', 'tgz' => array('application/x-tar', 'application/x-gzip-compressed'), 'tif' => 'image/tiff', 'tiff' => 'image/tiff', 'txt' => 'text/plain', 'vcf' => 'text/x-vcard', 'vlc' => 'application/videolan', 'wav' => array('audio/x-wav', 'audio/wave', 'audio/wav'), 'wbxml' => 'application/wbxml', 'webm' => 'video/webm', 'wma' => array('audio/x-ms-wma', 'video/x-ms-asf'), 'wmlc' => 'application/wmlc', 'wmv' => array('video/x-ms-wmv', 'video/x-ms-asf'), 'word' => array('application/msword', 'application/octet-stream'), 'xht' => 'application/xhtml+xml', 'xhtml' => 'application/xhtml+xml', 'xl' => 'application/excel', 'xls' => array('application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword'), 'xlsx' => array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip'), 'xml' => array('application/xml', 'text/xml', 'text/plain'), 'xsl' => array('application/xml', 'text/xsl', 'text/xml'), 'xspf' => 'application/xspf+xml', 'z' => 'application/x-compress', 'zip' => array('application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip'), 'zsh' => 'text/x-scriptzsh',];