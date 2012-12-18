<?php

namespace phpbit;
use phpecc;

class Bitcoin {

  private static $hexchars = "0123456789ABCDEF";
  private static $base58chars = "123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz";

  public static function newAddress() {

    $secp256k1 = new phpecc\CurveFp(
        '115792089237316195423570985008687907853269984665640564039457584007908834671663',
        '0', '7');
    $secp256k1_G = new phpecc\Point($secp256k1,
        '55066263022277343669578718895168534326250603453777594175500187360389116729240',
        '32670510020758816978083085130507043184471273380659243275938904335757337482424',
        '115792089237316195423570985008687907852837564279074904382605163141518161494337');

    $privBin = '';
    for ($i = 0; $i < 32; $i++) {
      $privBin .= chr(mt_rand(0, 255));
    }

    $point = phpecc\Point::mul(phpecc\Utilities\Bcmath::bin2bc("\x00" . $privBin), $secp256k1_G);

    $pubBinStr = "\x04" . str_pad(phpecc\Utilities\Bcmath::bc2bin($point->getX()), 32, "\x00", STR_PAD_LEFT) .
    str_pad(phpecc\Utilities\Bcmath::bc2bin($point->getY()), 32, "\x00", STR_PAD_LEFT);

    // create pubhash: ripemd160 * sha256
    $pubHash = hash('sha256', $pubBinStr, true);
    $pubHash = hash('ripemd160', $pubHash, true);

    return array('public' => self::base58Check(0x00, $pubHash), 'private' => self::base58Check(0x80, $privBin));
  }

  public static function base58Check($leadingByte, $bin) {
    $bin = chr($leadingByte) . $bin;

    $checkSum = substr(hash('sha256', hash('sha256', $bin, true), true), 0, 4);
    $bin .= $checkSum;

    $base58 = self::base58Encode(phpecc\Utilities\Bcmath::bin2bc($bin));

    // for each leading zero-byte, pad the base58 with a "1"
    for ($i = 0; $i < strlen($bin); $i++) {
      if ($bin[$i] != "\x00") {
        break; // <-- exit;
      }
      $base58 = '1' . $base58;
    }

    return $base58;
  }

  public static function base58Encode($num) {
    return phpecc\Utilities\Bcmath::dec2base($num, 58, '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz');
  }



}