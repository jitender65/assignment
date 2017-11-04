<?php

/*
 * Copyright 2016-2017 Appster Information Pvt. Ltd. 
 * All rights reserved.
 * File: ExportReportController.php
 * CodeLibrary/Project: Dance Card
 * Author: Abhijeet
 * CreatedOn: date (18/08/2017) 
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class XSS {

    /**
     * @param Request $request
     * @param Closure $next
     * @return type
     */
    public function handle(Request $request, Closure $next) {
        $input = $request->all();
        array_walk_recursive($input, function(&$input) {
            $input = htmlspecialchars($input);
        });

        $request->merge($input);

        $response = $next($request);

        return $response->setContent(preg_replace('/&amp;/', '&', $response->getContent()));
    }

}
