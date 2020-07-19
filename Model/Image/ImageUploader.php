<?php

namespace Mjfox\Education\Model\Image;

class ImageUploader extends \Magento\Catalog\Model\ImageUploader
{
    const IMAGE_TMP_PATH = 'education/tmp';
    const IMAGE_PATH = 'education/images';

    /**
     * ImageUploader constructor.
     *
     * @param \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase
     * @param \Magento\Framework\Filesystem                      $filesystem
     * @param \Magento\MediaStorage\Model\File\UploaderFactory   $uploaderFactory
     * @param \Magento\Store\Model\StoreManagerInterface         $storeManager
     * @param \Psr\Log\LoggerInterface                           $logger
     * @param string                                             $baseTmpPath
     * @param string                                             $basePath
     * @param array                                              $allowedExtensions
     * @param array                                              $allowedMimeTypes
     */
    public function __construct(
        \Magento\MediaStorage\Helper\File\Storage\Database $coreFileStorageDatabase,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploaderFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Psr\Log\LoggerInterface $logger,
        $baseTmpPath = self::IMAGE_TMP_PATH,
        $basePath = self::IMAGE_PATH,
        $allowedExtensions = [],
        $allowedMimeTypes = []
    ) {
        parent::__construct(
            $coreFileStorageDatabase,
            $filesystem,
            $uploaderFactory,
            $storeManager,
            $logger,
            $baseTmpPath,
            $basePath,
            $allowedExtensions,
            $allowedMimeTypes
        );
    }
}
