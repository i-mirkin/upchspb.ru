<?php

/*
 * control theme site
 */

/**
 * Description of themeControl
 *
 * @author Shevtcoff
 */
class TwimGossiteColorControl {

    /**
     * Lightens/darkens a given colour (hex format), returning the altered colour in hex format.7
     * @param str $hex Colour as hexadecimal (with or without hash);
     * @percent float $percent Decimal ( 0.2 = lighten by 20%(), -0.4 = darken by 40%() )
     * @return str Lightened/Darkend colour as hexadecimal (with hash);
     */
    public static function colorLuminance($hex, $percent) {
        // validate hex string
        $hex = preg_replace('/[^0-9a-f]/i', '', $hex);
        $new_hex = '#';
        if (strlen($hex) < 6) {
            $hex = $hex[0] + $hex[0] + $hex[1] + $hex[1] + $hex[2] + $hex[2];
        }
        // convert to decimal and change luminosity
        for ($i = 0; $i < 3; $i++) {
            $dec = hexdec(substr($hex, $i * 2, 2));
            $dec = min(max(0, $dec + $dec * $percent), 255);
            $new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
        }
        return $new_hex;
    }

    // HEX to RGB
    public static function hexToRgb($color) {
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }
        if (strlen($color) == 6) {
            list($red, $green, $blue) = array(
                $color[0] . $color[1],
                $color[2] . $color[3],
                $color[4] . $color[5]
            );
        } elseif (strlen($cvet) == 3) {
            list($red, $green, $blue) = array(
                $color[0] . $color[0],
                $color[1] . $color[1],
                $color[2] . $color[2]
            );
        } else {
            return false;
        }
        $red = hexdec($red);
        $green = hexdec($green);
        $blue = hexdec($blue);
        return array(
            'red' => $red,
            'green' => $green,
            'blue' => $blue
        );
    }

    //RGB to HEX
    public static function rgbToHex($color) {
        $red = dechex($color[0]);
        $green = dechex($color[1]);
        $blue = dechex($color[2]);
        return "#" . $red . $green . $blue;
    }
    
    public static function getArColorNewReplace($colorMain, $colorSecond) {
        return array(
            $colorMain, 
            $colorSecond, 
            self::colorLuminance($colorSecond, -0.2), 
            implode(", ", self::hexToRgb($colorMain))
        );
    }
    
    public static function generateStyle($cssText, $arColorChange, $arColorNew){
        $patterns_cl = array(); // default color theme
        $patterns_cl[0] = '/'.$arColorChange[0].'/i'; // main color
        $patterns_cl[1] = '/'.$arColorChange[1].'/i'; // dark color
        $patterns_cl[2] = '/'.$arColorChange[2].'/i'; // darker color
        $patterns_cl[3] = '/'.$arColorChange[3].'/i'; // main color rgb  
        $css_new_style =  preg_replace($patterns_cl, $arColorNew, $cssText); // replace
        return $css_new_style;   
        
    }
}
