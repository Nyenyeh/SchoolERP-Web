<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class UtilityController extends Controller
{
    public function index(){
        try {
            return view('backEnd.systemSettings.utilityView');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function action($action){
        try {

            $message = "";

            if($action =="optimize_clear"){
                
                \Artisan::call('optimize:clear');
                
                $message = "Your System Optimization Successfully Complete";
               
                
            }
            elseif($action =="clear_log"){
                file_put_contents(storage_path('logs/laravel.log'),'');

                $message = "Your System Log File Is Cleared";
            }
            elseif($action =="change_debug"){
                if(env('APP_DEBUG')){
                    envu([
                        'APP_ENV' => 'Production',
                        'APP_DEBUG'     =>  'false',
                        ]);

                        $message = "Debug Mode Disable Successfully ";
                }
                else{
                    envu([
                        'APP_ENV' => 'Production',
                        'APP_DEBUG'     =>  'true',
                        ]);

                        $message = "Debug Mode Enable Successfully ";
                }
                
            }
            elseif($action =="force_https"){
                if(env('FORCE_HTTPS')){
                    envu([
                        'FORCE_HTTPS'     =>  'false',
                        ]);

                        $message = "HTTPS Mode Disable Successfully ";
                }
                else{
                    envu([
                        'FORCE_HTTPS'     =>  'true',
                        ]);

                        $message = "HTTPS Mode Enable Successfully ";
                }
            }

            Toastr::success($message , 'Success');
            
            return redirect()->back();
      
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
