<?php

namespace App\Services;

use App\Libraries\File\FileName;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadService
{
    private string $disk;
    private string $baseDir;
    private ?string $convertExt;
    private string $module;

    public function __construct()
    {
        $this->disk = config('filesystems.default');
        $this->baseDir = config('image.cdn_dir');
        $this->convertExt = config('image.convert_ext');
        $this->module = 'public';
    }

    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }
    public function setConvertExt($extension)
    {
        $this->convertExt = $extension;
        return $this;
    }

    public function fileUpload(UploadedFile $uploadedFile, $namePrefix = null){
        $uploadedFileName = new FileName($uploadedFile->getClientOriginalName(), $this->module, $this->convertExt, $namePrefix);

        Storage::disk('local')->put($uploadedFileName->getTmpPath(), $uploadedFile->getContent());


        Storage::disk($this->disk)->put(
            sprintf('%s/%s', $this->baseDir, $uploadedFileName->getFullNameWithModule()),
            file_get_contents($uploadedFile)
        );

        Storage::disk('local')->delete($uploadedFileName->getTmpPath());

        return $uploadedFileName->getFullNameWithModule();
    }

    public function upload(UploadedFile $uploadedFile, $namePrefix = null)
    {
        $uploadedFileName = new FileName($uploadedFile->getClientOriginalName(), $this->module, $this->convertExt, $namePrefix);

        if ($this->disk === 'local' || $this->disk === 'public') {

            // Image upload and return path local public
            $upload = Storage::disk($this->disk)->put(
                sprintf('%s/%s', '/', $uploadedFileName->getFullNameWithModule()),
                $uploadedFile->getContent()
            );

            return $uploadedFileName->getFullNameWithModule();


        }


        Storage::disk('local')->put($uploadedFileName->getTmpPath(), $uploadedFile->getContent());
        try{
            $image = Image::make($uploadedFileName->getTmpFullPath());

            if (config('image.is_convert')) {
                $image->encode($this->convertExt, '90');
            }

            $image->save($uploadedFileName->getTmpFullPath())->__toString();

        }catch (\Exception $e){

            $image =  fopen($uploadedFileName->getTmpFullPath(), 'r+');
        }


        Storage::disk($this->disk)->put(
            sprintf('%s/%s', $this->baseDir, $uploadedFileName->getFullNameWithModule()),
            $image
        );

        Storage::disk('local')->delete($uploadedFileName->getTmpPath());

        return $uploadedFileName->getFullNameWithModule();
    }

    public function deleteExisting($path)
    {
        if (!is_null($path)) {
            Storage::disk($this->disk)->delete(sprintf('%s/%s', $this->baseDir, $path));
        }
        return $this;
    }

}
