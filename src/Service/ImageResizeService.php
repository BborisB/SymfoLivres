<?php

namespace App\Service;

use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Imagine\Image\PointInterface;

class ImageResizeService
{

    /**
     * Write a thumbnail image using Imagine
     * 
     * @param string $thumbAbsPath full absolute path to attachment directory e.g. /var/www/project1/images/thumbs/
     */
    public function writeThumbnail($thumbAbsPath, $width, $height)
    {
        $imagine = new Imagine;
        $image   = $imagine->open($thumbAbsPath);
        $size    = new Box($width, $height);
        // $imageSize = $image->getSize();
        // $point = new Point($imageSize->getWidth(),0);

        $image->thumbnail($size, ImageInterface::THUMBNAIL_OUTBOUND)->save($thumbAbsPath);
        // $image->crop($point, $size)->save($thumbAbsPath);
    }
}
