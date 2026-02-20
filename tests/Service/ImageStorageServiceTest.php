<?php

namespace App\Tests\Service;

use App\Service\ImageStorageService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageStorageServiceTest extends TestCase
{
    public function testStore()
    {
        // Répertoire temporaire pour les tests
        $targetDirectory = sys_get_temp_dir();
        $service = new ImageStorageService($targetDirectory);

        // Création d'un fichier fictif pour le test
        $file = new UploadedFile(
            __DIR__ . '/test.jpg', // Chemin vers un fichier de test
            'test.jpg',            // Nom du fichier
            'image/jpeg',          // Type MIME
            null,                  // Taille (null pour le test)
            true                   // Test mode
        );

        // Appel de la méthode store
        $filename = $service->store($file);

        // Vérification que le fichier a été correctement enregistré
        $this->assertFileExists($targetDirectory . '/' . $filename);

        // Nettoyage après le test
        unlink($targetDirectory . '/' . $filename);
    }
}