<?php

namespace infotech\components;

class ImageProcessor
{
    public $url;
    public $thumbnailWidth = 100;
    public $thumbnailHeight = 100;
    public $largeWidth = 940;
    public $largeHeight = 705;

    private const METHOD_CROP = 'crop';
    private const METHOD_RESIZE = 'resize';

    /**
     * Генерирует ссылку на картинку, обрезанную по заданному разрешению
     */
    public function crop($url, $width, $height): ?string
    {
        if (!$url) {
            return null;
        }

        return implode('/', [
            rtrim($this->url, '/'),
            self::METHOD_CROP,
            $width,
            $height,
            ltrim(parse_url($url, PHP_URL_PATH), '/'),
        ]);
    }

    /**
     * Генерирует ссылку на картинку с пропорционально изменённым размером
     */
    public function resize($url, $width, $height): ?string
    {
        if (!$url) {
            return null;
        }

        return implode('/', [
            rtrim($this->url, '/'),
            self::METHOD_RESIZE,
            $width,
            $height,
            ltrim(parse_url($url, PHP_URL_PATH), '/'),
        ]);
    }

    /**
     * Генерирует ссылку на thumbnail-картинки с заданными по-умолчанию размерами
     */
    public function thumbnail($url): ?string
    {
        return $this->resize($url, $this->thumbnailWidth, $this->thumbnailHeight);
    }

    /**
     * Генерирует ссылку на large-картинки с заданными по-умолчанию размерами
     */
    public function large($url): ?string
    {
        return $this->resize($url, $this->largeWidth, $this->largeHeight);
    }
}
