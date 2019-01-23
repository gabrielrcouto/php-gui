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
class Image extends AbstractObject
{
    /** {@inheritDoc} */
    protected $lazarusClass = 'TImage';

    /**
     * The image file.
     *
     * @var string
     */
    protected $imgFile = null;

    /**
     * Stores all of the temporary files which have been
     * modified, e.g. resized.
     *
     * @var array
     */
    private $tmpFiles = [];

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
    private $imgData = [];

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

    /**
     * Set the size of the image and redraw it if the file
     * has been defined.
     *
     * @param int $width
     * @param int $height
     * @return self
     */
    public function setSize($width, $height)
    {
        $this->call(
            'image.setSize',
            [
                $width,
                $height,
            ]
        );

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
        return [
            $this->imgW ? $this->imgW :  $this->getWidth(),
            $this->imgH ? $this->imgH :  $this->getHeight(),
        ];
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
        $this->removeTempFiles();

        $image = null;
        list($imgw, $imgh) = $this->getSize();

        // If the size hasn't been set yet, use the images size.
        $resize = true;
        if (!$imgw && !$imgh) {
            $resize = false;
        }

        // Create a temporary file for the modified image.
        $hFile = tmpfile();
        $this->tmpFiles[] = &$hFile;
        $file = stream_get_meta_data($hFile)['uri'];

        if ($this->currentExt === self::EXT_IMAGICK) {
            $image = new \Imagick($this->getFile());

            if ($resize) {
                // Resize the image.
                $filter = $this->getResizeFilter() ? $this->getResizeFilter() : \Imagick::FILTER_LANCZOS;
                $image->resizeImage($imgw, $imgh, $filter, 1);
            } else {
                // Get the images size.
                $geo = $image->getImageGeometry();
                $this->imgW = $imgw = $geo['width'];
                $this->imgH = $imgh = $geo['height'];
            }

            // Write the image to the temp file.
            $image->writeImage($file);
        } elseif ($this->currentExt === self::EXT_GD) {
            list($w, $h, $type) = getimagesize($this->getFile());

            // Create the image resource.
            switch ($type) {
                case IMAGETYPE_GIF:
                    $image = imagecreatefromgif($this->getFile());
                    $writefunc = 'imagegif';
                    break;
                case IMAGETYPE_JPEG:
                    $image = imagecreatefromjpeg($this->getFile());
                    $writefunc = 'imagejpeg';
                    break;
                case IMAGETYPE_PNG:
                    $image = imagecreatefrompng($this->getFile());
                    $writefunc = 'imagepng';
                    break;
                case IMAGETYPE_BMP:
                    $image = imagecreatefrombmp($this->getFile());
                    $writefunc = 'imagebmp';
                    break;
                default:
                    throw new \Exception('The image type is not supported (GIF, JPEG, PNG, BMP).');
                    break;
            }

            if ($resize) {
                // Resize the image.
                imagescale($image, $imgw, $imgh);
            } else {
                // Get the images size.
                $this->imgW = $imgw = imagesx($image);
                $this->imgH = $imgh = imagesy($image);
            }

            // Write the image to the temp file.
            call_user_func($writefunc, $image, $file);
        }

        // If the size wasn't defined previously, the image needs to be resized.
        if (!$resize) {
            $this->call(
                'image.setSize',
                [
                    $imgw,
                    $imgh,
                ]
            );
        }

        // Load the image file.
        $this->call(
            'image.loadFromFile',
            [$file]
        );

        return $this;
    }

    public function removeTempFiles()
    {
        foreach ($this->tmpFiles as $file) {
            try {
                fclose($file);
            } catch (\Throwable $e) {
                // ...
            }
        }

        $this->tmpFiles = [];
    }

    public function __destruct()
    {
        $this->removeTempFiles();

        parent::__destruct();
    }
}
