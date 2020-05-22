<?php

namespace infotech\components;

/**
 * Class ImageProcessorComponent
 * @package infotech\components
 */
class ImageProcessor
{
    public $url;
    public $thumbnailWidth = 100;
    public $thumbnailHeight = 100;

    private const METHOD_CROP = 'crop';
    private const METHOD_RESIZE = 'resize';

    /**
     * Генерирует ссылку на картинку обрезанную по заданному разрешению
     * @param     $url
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public function crop($url, $width, $height)
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
     * @param     $url
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public function resize($url, $width, $height)
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
     * Генерирует ссылку на thumbnail картинки с заданными по умолчанию размерами
     * @param $url
     * @return string|null
     */
    public function thumbnail($url)
    {
        return $this->resize($url, $this->thumbnailWidth, $this->thumbnailHeight);
    }
}
