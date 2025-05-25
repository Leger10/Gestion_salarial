<?php

namespace App\Providers; 
  
use Illuminate\Support\ServiceProvider; 
use App\Services\ClientService; 
  
class ClientServiceProvider extends ServiceProvider 
{ 
    /** 
     * Enregistre le service dans le conteneur de dépendances. 
     */ 
    public function register() 
    { 
        $this->app->singleton(ClientService::class, function ($app) { 
            return new ClientService(); 
        }); 
    } 
  
    public function boot() 
    { 
        // 
    } 
} 