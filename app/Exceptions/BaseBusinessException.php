<?php

namespace App\Exceptions;

use Exception;

/**
 * BaseBusinessException
 * 
 * Exception de base pour toutes les erreurs métier du domaine.
 * Permet un traitement structuré et uniforme des erreurs applicatives.
 */
abstract class BaseBusinessException extends Exception
{
    /**
     * @var int Code HTTP par défaut (Bad Request)
     */
    protected $httpStatusCode = 400;

    /**
     * @return int Le code de statut HTTP à retourner.
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * Rapport personnalisé de l'exception (optionnel).
     */
    public function report(): void
    {
        // Possibilité de logger dans des outils de monitoring spécifiques
    }

    /**
     * Rendu personnalisé de l'exception (optionnel).
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function render($request)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'error' => class_basename($this),
                'message' => $this->getMessage(),
            ], $this->getHttpStatusCode());
        }

        return back()->with('error', $this->getMessage());
    }
}
