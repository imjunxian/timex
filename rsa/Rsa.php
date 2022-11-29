<?php
namespace encryption;

class Rsa
{
    private $_config = [
        'public_key' => '',
        'private_key' => '',
    ];

    public function __construct($private_key_filepath, $public_key_filepath) {
        $this->_config['private_key'] = $this->_getContents($private_key_filepath);
        $this->_config['public_key'] = $this->_getContents($public_key_filepath);
    }

    /**
     * @uses get file content
     * @param $file_path string
     * @return bool|string
     */
    private function _getContents($file_path) {
        file_exists($file_path) or die ('private or public key error');
        return file_get_contents($file_path);
    }

    /**
     * @uses get private key
     * @return bool|resource
     */
    private function _getPrivateKey() {
        $priv_key = $this->_config['private_key'];
        return openssl_pkey_get_private($priv_key);
    }

    /**
     * @uses get public key
     * @return bool|resource
     */
    private function _getPublicKey() {
        $public_key = $this->_config['public_key'];
        return openssl_pkey_get_public($public_key);
    }

    /**
     * @uses private key encrypt
     * @param string $data
     * @return null|string
     */
    public function privEncrypt($data = '') {
        if (!is_string($data)) {
            return null;
        }
        return openssl_private_encrypt($data, $encrypted, $this->_getPrivateKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * @uses public key encrypt
     * @param string $data
     * @return null|string
     */
    public function publicEncrypt($data = '') {
        if (!is_string($data)) {
            return null;
        }
        return openssl_public_encrypt($data, $encrypted, $this->_getPublicKey()) ? base64_encode($encrypted) : null;
    }

    /**
     * @uses private key decrypt
     * @param string $encrypted
     * @return null
     */
    public function privDecrypt($encrypted = '') {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, $this->_getPrivateKey())) ? $decrypted : null;
    }

    /**
     * @uses public key decrypt
     * @param string $encrypted
     * @return null
     */
    public function publicDecrypt($encrypted = '') {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, $this->_getPublicKey())) ? $decrypted : null;
    }
}
?>