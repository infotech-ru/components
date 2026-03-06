<?php

namespace infotech\components;

use Exception;
use Imagick;
use ImagickException;
use ImagickPixel;

class ImageResizer
{
    private int $quality = 100;
    private bool $strip = false;
    private bool $maintainAspect = false;

    public function __construct(private readonly string $sourcePath)
    {
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
     * @throws Exception
     * @throws ImagickException
     */
    public function resizeWithBg(string $targetPath, int|string $width, int|string $height, int|string $maxWidth, int|string $maxHeight): bool
    {
        if (extension_loaded('imagick')) {
            return $this->resizeWithBgImagick($targetPath, $width, $height, $maxWidth, $maxHeight);
        }

        if (extension_loaded('gd')) {
            return $this->resizeWithBgGd($targetPath, $width, $height, $maxWidth, $maxHeight);
        }

        throw new Exception('Не найдено расширение для работы с изображениями (GD или Imagick)');
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
                $width = (int)round($height * $ratio);
            } else {
                $height = (int)round($width / $ratio);
            }
        }

        $source = $this->createGdResource($type, $this->sourcePath);
        if (!$source) {
            return false;
        }

        $target = imagecreatetruecolor($width, $height);

        if ($type == IMAGETYPE_PNG) {
            imagealphablending($target, false);
            imagesavealpha($target, true);
        }

        imagecopyresampled($target, $source, 0, 0, 0, 0, $width, $height, $currentWidth, $currentHeight);

        $result = $this->saveGdResource($target, $targetPath, $type);

        imagedestroy($source);
        imagedestroy($target);

        return $result;
    }

    /**
     * @throws ImagickException
     * @throws \ImagickPixelException
     */
    private function resizeWithBgImagick(string $targetPath, int|string $width, int|string $height, int|string $maxWidth, int|string $maxHeight): bool
    {
        $image = new Imagick($this->sourcePath);

        $bg = $image->getImagePixelColor(0, 0)->getColor();
        $background = sprintf('rgb(%d,%d,%d)', $bg['r'], $bg['g'], $bg['b']);

        if ($this->strip) {
            $image->stripImage();
        }

        $image->trimImage(0);
        $image->setImagePage(0, 0, 0, 0);

        [$fitWidth, $fitHeight] = $this->fitSize($image->getImageWidth(), $image->getImageHeight(), $maxWidth, $maxHeight);
        if ($fitWidth > 0 && $fitHeight > 0) {
            $image->resizeImage($fitWidth, $fitHeight, Imagick::FILTER_LANCZOS, 1);
        }

        $canvas = new Imagick();
        $canvas->newImage($width, $height, new ImagickPixel($background));
        $canvas->setImageFormat($image->getImageFormat());

        $x = (int)floor(($width - $image->getImageWidth()) / 2);
        $y = (int)floor(($height - $image->getImageHeight()) / 2);
        $canvas->compositeImage($image, Imagick::COMPOSITE_DEFAULT, $x, $y);

        $canvas->setImageCompressionQuality($this->quality);
        $canvas->writeImage($targetPath);

        $image->clear();
        $canvas->clear();

        return true;
    }

    private function resizeWithBgGd(string $targetPath, int|string $width, int|string $height, int|string $maxWidth, int|string $maxHeight): bool
    {
        [$srcWidth, $srcHeight, $type] = getimagesize($this->sourcePath);

        $source = $this->createGdResource($type, $this->sourcePath);
        if (!$source) {
            return false;
        }

        $bgColor = imagecolorat($source, 0, 0);
        $r = ($bgColor >> 16) & 0xFF;
        $g = ($bgColor >> 8) & 0xFF;
        $b = $bgColor & 0xFF;

        [$fitWidth, $fitHeight] = $this->fitSize($srcWidth, $srcHeight, $maxWidth, $maxHeight);

        $resized = imagecreatetruecolor($fitWidth, $fitHeight);
        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
            imagefill($resized, 0, 0, $transparent);
        }

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $fitWidth, $fitHeight, $srcWidth, $srcHeight);

        $canvas = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($canvas, $r, $g, $b);
        imagefill($canvas, 0, 0, $bg);

        $x = (int)floor(($width - $fitWidth) / 2);
        $y = (int)floor(($height - $fitHeight) / 2);
        imagecopy($canvas, $resized, $x, $y, 0, 0, $fitWidth, $fitHeight);

        $result = $this->saveGdResource($canvas, $targetPath, $type);

        imagedestroy($source);
        imagedestroy($resized);
        imagedestroy($canvas);

        return $result;
    }

    private function fitSize(int $srcWidth, int $srcHeight, int $maxWidth, int $maxHeight): array
    {
        if ($srcWidth <= 0 || $srcHeight <= 0) {
            return [0, 0];
        }

        $scale = min($maxWidth / $srcWidth, $maxHeight / $srcHeight, 1);

        return [
            max(1, (int)floor($srcWidth * $scale)),
            max(1, (int)floor($srcHeight * $scale)),
        ];
    }

    private function createGdResource(int $type, string $path)
    {
        return match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($path),
            IMAGETYPE_PNG => imagecreatefrompng($path),
            IMAGETYPE_GIF => imagecreatefromgif($path),
            default => null,
        };
    }

    private function saveGdResource($resource, string $targetPath, int $type): bool
    {
        return match ($type) {
            IMAGETYPE_JPEG => imagejpeg($resource, $targetPath, $this->quality),
            IMAGETYPE_PNG => imagepng($resource, $targetPath, min(9, 10 - (int)round($this->quality / 10))),
            IMAGETYPE_GIF => imagegif($resource, $targetPath),
            default => false,
        };
    }
}