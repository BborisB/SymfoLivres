<?php
namespace App\Service;

use App\Service\ImageResizeService;
use ErrorException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    public function __construct(
        private string $pfpDirectory,
        private SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $file, ImageResizeService $imageResizeService): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
            $imageResizeService->writeThumbnail($this->getTargetDirectory()."/".$fileName, 150, 150);
        }
        catch (FileException $e)
        {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function remove(string $fileName)
    {
        if($fileName!=="defaultUser.jpg")
        {
            $fileSystem = new Filesystem();
            $fileSystem->remove($this->getTargetDirectory()."/".$fileName);   
        }
    }

    public function getTargetDirectory(): string
    {
        return $this->pfpDirectory;
    }
}
?>