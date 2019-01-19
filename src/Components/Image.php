<?php
namespace Gui\Components;

/**
 * This is the Image class.
 *
 * It is a visual component for the image.
 *
 * @author Isaac Skelton @kingga
 * @since 19/01/2019
 */
class Image extends Canvas
{
    /**
     * The image file.
     *
     * @var string
     */
    protected $imgFile = null;

    /**
     * The width of the image.
     *
     * @var integer
     */
    private $imgW = null;

    /**
     * The height of the image.
     *
     * @var integer
     */
    private $imgH = null;

    /**
     * A cache of the images data if loaded before the app
     * is ready.
     *
     * @var array
     */
    private $imgData = array();

    /**
     * Imagick extension ID.
     *
     * @var integer
     */
    const EXT_IMAGICK = 0;

    /**
     * GD extension ID.
     *
     * @var integer
     */
    const EXT_GD = 1;

    /**
     * Current extension, Imagick is favoured over GD.
     *
     * @var integer|null
     */
    private $currentExt = null;

    /**
     * The resize filter for Imagick, yet to support GD's
     * image filters.
     *
     * @var integer
     */
    private $resizeFilter = null;

    /**
     * Set the image file.
     *
     * @param string $file
     * @return self
     */
    public function setFile($file)
    {
        if (is_file($file)) {
            $this->imgFile = $file;
            $this->drawImage();
        } else {
            throw new \Exception('The file could not be found.');
        }

        return $this;
    }

    /**
     * Get the images file.
     *
     * @return string|null
     */
    public function getFile()
    {
        return $this->imgFile;
    }

    /**
     * Set the resize method for Imagick.
     *
     * @param integer $filter
     * @return self
     */
    public function setResizeFilter($filter)
    {
        $this->filter = $filter;
        return $this;
    }

    /**
     * Get the resize method for Imagick.
     *
     * @return integer|null
     */
    public function getResizeFilter()
    {
        return $this->resizeFilter;
    }

    /**
     * Check that either Imagick or GD is loaded as this
     * class requires them to draw.
     *
     * @throws \Exception If the Imagick or GD extension is not loaded.
     * @return self
     */
    private function checkExtensions()
    {
        if (extension_loaded('imagick')) {
            $this->currentExt = self::EXT_IMAGICK;
        } elseif (extension_loaded('gd')) {
            $this->currentExt = self::EXT_GD;
        } else {
            throw new \Exception('You must have imagick or gd installed to draw images.');
        }

        return $this;
    }

    /** {@inheritDoc} */
    public function setSize($width, $height)
    {
        parent::setSize($width, $height);

        $this->imgW = $width;
        $this->imgH = $height;

        if ($this->getFile()) {
            $this->drawImage();
        }

        return $this;
    }

    /**
     * Returns the images width and height.
     *
     * @return array
     */
    public function getSize()
    {
        return array(
            $this->imgW ? $this->imgW :  $this->getWidth(),
            $this->imgH ? $this->imgH :  $this->getHeight(),
        );
    }

    /**
     * Draw the image onto the canvas, this is called when a resize
     * function is called or a new image is loaded.
     * If GD is the only available extension then only GIF, JPEG, PNG
     * and BMP images are supported.
     *
     * @throws \Exception If GD is being used and the image isn't in the supported list.
     * @return self
     */
    protected function drawImage()
    {
        $this->checkExtensions();

        $image = null;
        list($imgw, $imgh) = $this->getSize();
        $pixels = [];

        if ($this->currentExt === self::EXT_IMAGICK) {
            $image = new \Imagick($this->getFile());

            // Resize the image.
            $filter = $this->getResizeFilter() ? $this->getResizeFilter() : \Imagick::FILTER_LANCZOS;
            $image->resizeImage($imgw, $imgh, $filter, 1);
        } elseif ($this->currentExt === self::EXT_GD) {
            list($w, $h, $type) = getimagesize($this->getFile());

            switch ($type) {
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($this->getFile());
                    break;
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($this->getFile());
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($this->getFile());
                    break;
                case IMAGETYPE_BMP:
                    $image = imagecreatefrombmp($this->getFile());
                    break;
                default:
                    throw new \Exception('The image type is not supported (GIF, JPEG, PNG, BMP).');
                    break;
            }

            imagescale($image, $imgw, $imgh);
        }

        for ($x = 0; $x < $imgw; $x++) {
            for ($y = 0; $y < $imgh; $y++) {
                if ($this->currentExt === self::EXT_IMAGICK) {
                    $pixel = $image->getImagePixelColor($x, $y);
                    $rgb = $pixel->getColor();
                } elseif ($this->currentExt === self::EXT_GD) {
                    $pixel = imagecolorat($image, $x, $y);
                    $rgb = array(
                        'r'     => ($pixel >> 16) & 0xFF,
                        'g'     => ($pixel >> 8) & 0xFF,
                        'b'     => $pixel & 0xFF,
                    );
                }
                
                $pixels[] = sprintf("#%02x%02x%02x", $rgb['r'], $rgb['g'], $rgb['b']);
            }
        }

        $this->putImageData($pixels);
        $this->imgData = $pixels;

        return $this;
    }
}
