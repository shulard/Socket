<?php

/**
 * Hoa
 *
 *
 * @license
 *
 * New BSD License
 *
 * Copyright © 2007-2015, Hoa community. All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of the Hoa nor the names of its contributors may be
 *       used to endorse or promote products derived from this software without
 *       specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS AND CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Hoa\Socket\ApplicationLayer;

use Hoa\Socket\Exception;

/**
 * Class \Hoa\Socket\ApplicationLayer\Translate.
 *
 * Handle the application layer abstraction to identify,
 * transport / port to be used
 *
 * @copyright  Copyright © 2007-2015 Hoa community
 * @license    New BSD License
 */
class Translate
{
    /**
     * List of registered schemes with all meta data
     *
     * @var array
     * @static
     */
    private static $schemes = [];

    /**
     * Translate a scheme into it's transport details
     *
     * @param  string $scheme
     * @return Translation
     * @throws UnknownApplicationLayerException
     */
    public static function get($scheme) {
        if( !isset(self::$schemes[$scheme]) ) {
            throw new UnknownApplicationLayerException(
                sprintf("The scheme %s can't be translated because it is not registered !",$scheme)
            );
        }

        return new Translation(
            self::$schemes[$scheme]['transport'],
            self::$schemes[$scheme]['port'],
            self::$schemes[$scheme]['secured']
        );
    }

    /**
     * Register a new scheme that can be translated
     *
     * @param  string   $name
     * @param  string   $transport
     * @param  integer  $port
     * @param  boolean  $secured
     */
    public static function register($name, $transport, $port, $secured = false) {
        if( isset(self::$schemes[$name]) ) {
            throw new Exception(sprintf("Can't register %s, it is already defined!", $name));
        }

        self::$schemes[$name] = [
            'transport' => $transport,
            'port'      => $port,
            'secured'   => $secured
        ];
    }

    /**
     * Retrieved all the registered schemes
     *
     * @return array
     */
    public static function registered() {
        return self::$schemes;
    }
}
