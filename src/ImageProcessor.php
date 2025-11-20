<?php

namespace infotech\components;

class ImageProcessor
{
    public $url;
    public $thumbnailWidth = 100;
    public $thumbnailHeight = 100;
    public $largeWidth = 940;
    public $largeHeight = 705;

    /* @deprecated — больше не используется, удалить после 04.2026 */
    public $containerUuid;

    private const METHOD_CROP = 'crop';
    private const METHOD_RESIZE = 'resize';

    /**
     * Генерирует ссылку на картинку, обрезанную по заданному разрешению
     */
    public function crop($url, $width, $height): ?string
    {
        return $this->createUrl($url, $width, $height, self::METHOD_CROP);
    }

    /**
     * Генерирует ссылку на картинку с пропорционально изменённым размером
     */
    public function resize($url, $width, $height): ?string
    {
        return $this->createUrl($url, $width, $height, self::METHOD_RESIZE);
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

    private function createUrl($url, $width, $height, $method): ?string
    {
        if (!$url) {
            return null;
        }

        $parts = parse_url($url);

        if (empty($parts['host']) || empty($parts['path'])) {
            return null;
        }

        if (preg_match('#^([^.]+)\.selstorage\.ru$#', $parts['host'], $matches)) {
            // новый формат ссылок selectel
            // https://59e1663f-0514-49b7-a4f7-58baec26e2f3.selstorage.ru/catalog/20121/4/393ceade86.jpg

            return implode('/', [
                rtrim($this->url, '/'),
                $method,
                $matches[1],
                $width,
                $height,
                ltrim($parts['path'], '/'),
            ]);
        }

        // старый формат ссылок selectel
        // https://195004.selcdn.ru/ref/catalog/20121/4/393ceade86.jpg

        return implode('/', [
            rtrim($this->url, '/'),
            $method,
            $width,
            $height,
            ltrim($parts['path'], '/'),
        ]);
    }
}
