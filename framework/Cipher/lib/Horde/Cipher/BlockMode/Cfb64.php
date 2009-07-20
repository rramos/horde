<?php
/**
 * The Horde_Cipher_BlockMode_Cfb64:: class implements Horde_Cipher_BlockMode
 * using a 64 bit cipher feedback.
 *
 * This can be used to encrypt any length string and the encrypted
 * version will be the same length.
 *
 * Copyright 2002-2009 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @author  Mike Cochrane <mike@graftonhall.co.nz>
 * @package Horde_Cipher
 */
class Horde_Cipher_BlockMode_Cfb64 extends Horde_Cipher_BlockMode
{
    /**
     * Encrypt a string.
     *
     * @param Horde_Cipher $cipher  Cipher algorithm to use for encryption.
     * @param string $plaintext     The data to encrypt.
     *
     * @return string  The encrypted data.
     */
    public function encrypt($cipher, $plaintext)
    {
        $encrypted = '';

        $n = 0;
        $jMax = strlen($plaintext);
        for ($j = 0; $j < $jMax; ++$j) {
            if ($n == 0) {
                $this->_iv = $cipher->encryptBlock($this->_iv);
            }

            $c = $plaintext[$j] ^ $this->_iv[$n];
            $this->_iv = substr($this->_iv, 0, $n) . $c . substr($this->_iv, $n + 1);
            $encrypted .= $c;

            $n = (++$n) & 0x07;
        }

        return $encrypted;
    }

    /**
     * Decrypt a string.
     *
     * @param Horde_Cipher $cipher  Cipher algorithm to use for decryption.
     * @param string $ciphertext    The data to decrypt.
     *
     * @return string  The decrypted data.
     */
    public function decrypt($cipher, $ciphertext)
    {
        $decrypted = '';

        $n = 0;
        $jMax = strlen($ciphertext);
        for ($j = 0; $j < $jMax; ++$j) {
            if ($n == 0) {
                $this->_iv = $cipher->encryptBlock($this->_iv);
            }

            $c = $ciphertext[$j] ^ $this->_iv[$n];
            $this->_iv = substr($this->_iv, 0, $n) . substr($ciphertext, $j, 1) . substr($this->_iv, $n + 1);
            $decrypted .= $c;

            $n = (++$n) & 0x07;
        }

        // Remove trailing \0's used to pad the last block.
        while (substr($decrypted, -1, 1) == "\0") {
            $decrypted = substr($decrypted, 0, -1);
        }

        return $decrypted;
    }

}
