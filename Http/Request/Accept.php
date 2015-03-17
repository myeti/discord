<?php
/**
 * This file is part of the Discord package.
 *
 * Copyright Aymeric Assier <aymeric.assier@gmail.com>
 *
 * For the full copyright and license information, please view the `licence`
 * file that was distributed with this source code.
 */
namespace Discord\Http\Request;

class Accept
{

    /** @var array */
    public $medias = [];

    /** @var string */
    public $language;

    /** @var string */
    public $encoding;

    /** @var string */
    public $charset;


    /**
     * Custom HTTP Accept
     *
     * @param array $medias
     * @param string $language
     * @param string $encoding
     * @param string $charset
     */
    public function __construct(array $medias, $language, $encoding, $charset)
    {
        $this->medias = $medias;
        $this->language = $language;
        $this->encoding = $encoding;
        $this->charset = $charset;
    }


    /**
     * Negociate the best media
     *
     * @param array $medias
     *
     * @return string|bool
     */
    public function negociate(...$medias)
    {
        foreach($this->medias as $media => $quality) {
            if(in_array($media, $medias)) {
                return $media;
            }
        }

        return false;
    }


    /**
     * Parse from strings
     *
     * @param string $accept
     * @param string $acceptLanguage
     * @param string $acceptEncoding
     * @param string $acceptCharset
     *
     * @return static
     */
    public static function from($accept = null, $acceptLanguage = null, $acceptEncoding = null, $acceptCharset = null)
    {
        // parse medias
        $medias = [];
        if($accept) {
            $rows = explode(',', $accept);
            foreach($rows
                    as
                    $row)
            {
                @list($media, $quality) = explode(';', $row);
                if(!$quality) {
                    $quality = 1;
                }
                $medias[trim($media)] = (int)trim($quality);
            }
        }

        // parse language
        $language = null;
        if($acceptLanguage) {
            $language = $acceptLanguage;
        }

        // parse encoding
        $encoding = null;
        if($acceptEncoding) {
            $encoding = $acceptEncoding;
        }

        // parse charset
        $charset = null;
        if($acceptCharset) {
            $charset = $acceptCharset;
        }

        return new static($medias, $language, $encoding, $charset);
    }
}