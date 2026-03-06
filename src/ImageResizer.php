<?php

namespace infotech\components;

use Exception;
use Imagick;
use ImagickException;

class ImageResizer
{
    private string $sourcePath;
    private int $quality = 100;
    private bool $strip = false;
    private bool $maintainAspect = false;

    public function __construct(string $sourcePath)
    {
        $this->sourcePath = $sourcePath;
    }

    public function setQuality(int $quality): static
    {
        $this->quality = $quality;

        return $this;
    }

    public function setStrip(bool $strip): static
    {
        $this->strip = $strip;

        return $this;
    }

    public function setMaintainAspect(bool $maintainAspect): static
    {
        $this->maintainAspect = $maintainAspect;

        return $this;
    }

    /**
     * @throws ImagickException
     * @throws Exception
     */
    public function resize(string $targetPath, int|string $width, int|string $height): bool
    {
        if (extension_loaded('imagick')) {
            return $this->resizeImagick($targetPath, $width, $height);
        } elseif (extension_loaded('gd')) {
            return $this->resizeGd($targetPath, $width, $height);
        } else {
            throw new Exception('Не найдено расширение для работы с изображениями (GD или Imagick)');
        }
    }

    /**
     * @throws ImagickException
     */
    private function resizeImagick(string $targetPath, int|string $width, int|string $height): true
    {
        $imagick = new Imagick($this->sourcePath);

        $currentWidth = $imagick->getImageWidth();
        $currentHeight = $imagick->getImageHeight();

        // Проверяем, нужно ли изменять размер
        if ($currentWidth > $width || $currentHeight > $height) {
            if ($this->maintainAspect) {
                $imagick->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1, true);
            } else {
                $imagick->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
            }
        }
        if ($this->strip) {
            $imagick->stripImage();
        }
        $imagick->setImageCompressionQuality($this->quality);
        $imagick->writeImage($targetPath);
        $imagick->clear();

        return true;
    }

    private function resizeGd(string $targetPath, int|string $width, int|string $height): bool
    {
        [$currentWidth, $currentHeight, $type] = getimagesize($this->sourcePath);

        if ($currentWidth <= $width && $currentHeight <= $height) {
            return copy($this->sourcePath, $targetPath);
        }

        if ($this->maintainAspect) {
            $ratio = $currentWidth / $currentHeight;
            if ($width / $height > $ratio) {
                $width = $height * $ratio;
            } else {
                $height = $width / $ratio;
            }
        }

        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($targetPath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($targetPath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($targetPath);
                break;
            default:
                return false;
        }

        $target = imagecreatetruecolor($width, $height);

        if ($type == IMAGETYPE_PNG) {
            imagealphablending($target, false);
            imagesavealpha($target, true);
        }

        imagecopyresampled($target, $source, 0, 0, 0, 0, $width, $height, $width, $height);

        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($target, $targetPath, $this->quality);
                break;
            case IMAGETYPE_PNG:
                imagepng($target, $targetPath, min(9, 10 - round($this->quality / 10)));
                break;
            case IMAGETYPE_GIF:
                imagegif($target, $targetPath);
                break;
        }

        imagedestroy($source);
        imagedestroy($target);

        return true;
    }
}