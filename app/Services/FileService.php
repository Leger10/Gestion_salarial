<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\UserExport;
use App\Imports\UserImport;
use Illuminate\Http\Request;

class FileService
{
    /**
     * Exporter des données vers un fichier Excel.
     *
     * @param  mixed  $data
     * @param  string  $filename
     * @param  string  $disk
     * @return string  Le chemin du fichier exporté
     */
    public function exportToExcel($data, $filename = 'export.xlsx', $disk = 'local')
    {
        // Exporter directement en utilisant la classe d'export
        Excel::store(new UserExport($data), $filename, $disk);

        // Si le disque est 'public', vous pouvez générer une URL
        if ($disk == 'public') {
            return asset('storage/' . $filename);  // Retourne l'URL du fichier exporté
        }

        // Si ce n'est pas un disque public, renvoyez le chemin du fichier
        return Storage::disk($disk)->path($filename);
    }

    /**
     * Importer des données depuis un fichier Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $filename
     * @param  string  $disk
     * @return mixed  Les données importées ou un message d'erreur
     */
    public function importFromExcel(Request $request, $filename, $disk = 'local')
    {
        // Charger le fichier depuis la requête
        $file = $request->file($filename);
        $path = $file->storeAs('imports', $file->getClientOriginalName(), $disk);

        try {
            // Importer le fichier en utilisant la classe d'importation appropriée
            Excel::import(new UserImport, Storage::disk($disk)->path($path));

            return response()->json(['success' => 'Fichier importé avec succès']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur d\'importation: ' . $e->getMessage()]);
        }
    }

    /**
     * Télécharger un fichier depuis un disque configuré.
     *
     * @param  string  $filename
     * @param  string  $disk
     * @return \Illuminate\Support\Facades\Response
     */
    public function downloadFile($filename, $disk = 'local')
    {
        // Vérifiez si le fichier existe et télécharger le fichier
        if (Storage::disk($disk)->exists($filename)) {
            $path = Storage::disk($disk)->path($filename);
            return response()->download($path); // Télécharger le fichier
        }

        return response()->json(['error' => 'Fichier introuvable'], 404);  // Retourner une erreur si le fichier n'existe pas
    }

    /**
     * Supprimer un fichier depuis un disque.
     *
     * @param  string  $filename
     * @param  string  $disk
     * @return bool
     */
    public function deleteFile($filename, $disk = 'local')
    {
        // Vérifiez si le fichier existe et supprimez-le
        if (Storage::disk($disk)->exists($filename)) {
            return Storage::disk($disk)->delete($filename);  // Supprimer le fichier
        }

        return false;  // Retourner false si le fichier n'existe pas
    }
}
