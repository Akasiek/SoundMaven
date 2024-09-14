<?php

namespace App\Helpers;

class FileExtensionFromString
{
    public function __invoke(string $string): ?string
    {
        $file = $this->clearOffDirectoryPath($string);

        if (! $this->verifyIfFileHasExtension($file)) {
            return null;
        }

        return $this->getFileExtension($file);
    }

    private function clearOffDirectoryPath(string $string): string
    {
        $parts = explode('/', $string);

        return end($parts);
    }

    private function verifyIfFileHasExtension(string $string): bool
    {
        return str_contains($string, '.');
    }

    private function getFileExtension(string $string): string
    {
        $parts = explode('.', $string);

        return mb_strtolower(end($parts));
    }
}
