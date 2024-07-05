<?php

namespace App\Http\Middleware;

class MiddlewareConfig
{
    /**
     * @var array Holds the middleware configuration settings.
     * 
     * This array maps middleware names to their corresponding class implementations. 
     * It allows dynamic retrieval and updating of middleware classes used in the application.
     */
    private $middleware = [
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ];

    /**
     * Get the class associated with the 'admin' middleware.
     *
     * This method returns the fully qualified class name of the middleware responsible for handling
     * requests that require admin privileges.
     *
     * @return string The class name of the 'admin' middleware.
     */

    // Getter for the 'admin' middleware
    public function getAdminMiddleware()
    {
        return $this->middleware['admin'];
    }

     /**
     * Set a new class for the 'admin' middleware.
     *
     * This method allows updating the class responsible for handling requests requiring admin privileges.
     * It takes the fully qualified class name of the new middleware as an argument.
     *
     * @param string $adminMiddleware The new class name for the 'admin' middleware.
     */

    // Setter for the 'admin' middleware
    public function setAdminMiddleware($adminMiddleware)
    {
        $this->middleware['admin'] = $adminMiddleware;
    }
}

// Usage example


// Create an instance of the MiddlewareConfig class.
$config = new MiddlewareConfig();

// Retrieve and output the current 'admin' middleware class.
echo $config->getAdminMiddleware(); // Output: \App\Http\Middleware\AdminMiddleware::class

// Set a new class for the 'admin' middleware.
; // Output: \App\Http\Middleware\NewAdminMiddleware::class
