<?php
/**
 * This file is part of PHP_Depend.
 * 
 * PHP Version 5
 *
 * Copyright (c) 2008, Manuel Pichler <mapi@pmanuel-pichler.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Util
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2008 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.manuel-pichler.de/
 */

/**
 * Simple utility class that is used to create different image formats. This 
 * class can use the ImageMagick cli tool <b>convert</b> and the pecl extension
 * <b>pecl/imagick</b>.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Util
 * @author     Manuel Pichler <mapi@manuel-pichler.de>
 * @copyright  2008 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://www.manuel-pichler.de/
 */
class PHP_Depend_Util_ImageConvert
{
    /**
     * Tries to converts the <b>$input</b> image into the <b>$output</b> format.
     *
     * @param string $input  The input file.
     * @param string $output The output file.
     * 
     * @return void
     */
    public static function convert($input, $output)
    {
        $inputType  = pathinfo($input, PATHINFO_EXTENSION);
        $outputType = pathinfo($output, PATHINFO_EXTENSION);
        
        if ($inputType === $outputType) {
            file_put_contents($output, file_get_contents($input));
        } else if (extension_loaded('imagick') === true) {
            $im = new Imagick($input);
            $im->setImageFormat($outputType);
            $im->writeImage($output);
            
            // The following code is not testable when imagick is installed
            // @codeCoverageIgnoreStart
        } else if (self::hasImagickConvert() === true) {
            $input  = escapeshellarg($input);
            $output = escapeshellarg($output);
            
            system("convert {$input} {$output}");
        } else {
            
            $fallback = substr($output, 0, -strlen($outputType)) . $inputType;
            
            echo "WARNING: Cannot generate image of type '{$outputType}'. This",
                 " feature needs either the\n         pecl/imagick extension or",
                 " the ImageMagick cli tool 'convert'.\n\n",
                 "Writing alternative image:\n{$fallback}\n\n";
            
            file_put_contents($fallback, file_get_contents($input));
        }
        // @codeCoverageIgnoreEnd
    }
    
    /**
     * Tests that the ImageMagick CLI tool <b>convert</b> exists.
     *
     * @return boolean
     */
    protected static function hasImagickConvert()
    {
        // @codeCoverageIgnoreStart
        $desc = array(
            0  =>  array('pipe', 'r'),
            1  =>  array('pipe', 'w'),
            2  =>  array('pipe', 'a'),
        );
        
        $proc = proc_open('convert', $desc, $pipes);
        if (is_resource($proc)) {
            fwrite($pipes[0], '-version');
            fclose($pipes[0]);
            
            return (0 === proc_close($proc));
        }
        return false;
        // @codeCoverageIgnoreEnd
    }
}