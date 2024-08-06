<?php

namespace App\Libraries\File;

use Illuminate\Support\Str;

class FileName
{
    private $fileName;
    private $rndName;
    private $extension;
    private $module;
    private $namePrefix;

    public function __construct(string $fileName, $module, $extension, $namePrefix)
    {
        $this->fileName = $fileName;
        $this->rndName = Str::random(32);
        $this->extension = !is_null($extension) ? $extension : $this->getOriginalExtension();
        $this->module = $module;
        $this->namePrefix = $namePrefix;
    }

    public function getOriginalFileName(): array|string
    {
        return pathinfo($this->fileName, PATHINFO_FILENAME);
    }

    public function getOriginalExtension(): array|string
    {
        return pathinfo($this->fileName, PATHINFO_EXTENSION);
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function getFullName(): string
    {
        if (is_null($this->namePrefix)) {
            return sprintf('%s.%s', $this->rndName, $this->getExtension());
        }
        return sprintf('%s-%s.%s', $this->namePrefix, $this->rndName, $this->getExtension());
    }

    public function getFullNameWithModule(): string
    {
        return sprintf('%s/%s', $this->module, $this->getFullName());
    }

    public function getOriginalFullName()
    {
        return sprintf('%s.%s', $this->getOriginalFileName(), $this->getOriginalExtension());
    }

    public function getOriginalFullNameWithModule()
    {
        return sprintf('%s/%s', $this->module, $this->getOriginalFullName());
    }

    public function getTmpPath()
    {
        return sprintf('tmp/tmp-%s', $this->getFullName());
    }

    public function getTmpFullPath()
    {
        return storage_path('app/'. $this->getTmpPath());
    }

}
