<?php

namespace App\Http\Controllers\Fronted;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Auth,Artisan,Hash,File,Crypt;
use App\Models\Packages;
use App\Http\Controllers\Manage\EmailsController;

class PackagesController extends Controller
{
    
   public function allPackages()
   {
       $packages=Packages::take(3)->get();
       return view('Fronted.Packages.allPackages',compact('packages'));
   }


}
