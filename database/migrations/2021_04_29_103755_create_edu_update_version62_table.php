<?php
use App\SmLanguagePhrase;
use App\SmGeneralSettings;
use App\InfixModuleManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Modules\MenuManage\Entities\Sidebar;
use Illuminate\Database\Schema\Blueprint;
use Modules\MenuManage\Entities\UserMenu;
use Modules\MenuManage\Entities\MenuManage;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixModuleStudentParentInfo;

class CreateEduUpdateVersion62Table extends Migration
{
    public function up()
    {
        try{
             //fees carryfoward new colum update 
                $name ="notes";
                if (!Schema::hasColumn('sm_fees_carry_forwards', $name)) {
                    Schema::table('sm_fees_carry_forwards', function ($table) use ($name) {
                        $table->string('notes',191)->default("Fees Carry Forward"); 
                    });
                }

                $name2 ="StudentAbsentNotification";
                        if (!Schema::hasColumn('sm_general_settings', $name2)) {
                            Schema::table('sm_general_settings', function ($table) use ($name2) {
                                $table->integer('StudentAbsentNotification')->default(1)->nullable();
                            });
                        }
                    $name3 ="attendance_layout";
                        if (!Schema::hasColumn('sm_general_settings', $name3)) {
                            Schema::table('sm_general_settings', function ($table) use ($name3) {
                                $table->integer('attendance_layout')->default(1)->nullable();
                            });
                        }

                        $name4 ="bank_id";
                        if (!Schema::hasColumn('sm_fees_payments', $name4)) {
                            Schema::table('sm_fees_payments', function ($table) use ($name4) {
                                $table->integer('bank_id')->nullable();
                            });
                        }

                        $XenditPayment ="XenditPayment";
                        if (!Schema::hasColumn('sm_general_settings', $XenditPayment)) {
                            Schema::table('sm_general_settings', function ($table) use ($XenditPayment) {
                                $table->integer('XenditPayment')->default(0)->nullable();
                            });
                        }       

                //fees carryfoward menu manager and role permission 
                $module_id = 136;
                $exist = InfixModuleInfo::find($module_id);
        
                //remove About menu 
                $exist3 = InfixModuleInfo::find(477);
               
                if($exist3){
                    $exist3->delete();
                }
                

                

                $student_export = InfixModuleInfo::find(663);
                if($student_export){
                    $student_export->lang_name = "student_export";
                    $student_export->name = "Student Export";
                    $student_export->save();
                }
                $type_three = InfixModuleInfo::whereIn('id',[436,706])->get();
                if( $type_three){
                    foreach($type_three as $type){
                        $type->type = 3;
                        $type->save();
                    }
                }

                $lang_pharse = SmLanguagePhrase::where('default_phrases','about_&_update')->first();
                if(! $lang_pharse){
                    $new_lang = new SmLanguagePhrase();
                }
                else{
                    $new_lang = $lang_pharse ;
                }
                $new_lang = new SmLanguagePhrase();
                $new_lang->modules  = 17;
                $new_lang->default_phrases  = "about_&_update";
                $new_lang->en  = "About & Update";
                $new_lang->es  = "About & Update";
                $new_lang->bn  = "সম্পর্ক এবং আপডেট";
                $new_lang->fr  = "About & Update";
                $new_lang->save();

                $new_lang3 = new SmLanguagePhrase();
                $new_lang3->modules  = 17;
                $new_lang3->default_phrases  = "add_days";
                $new_lang3->en  = "Add Days";
                $new_lang3->es  = "About & Update";
                $new_lang3->bn  = "দিন যোগ করুন";
                $new_lang3->fr  = "Add Days";
                $new_lang3->save();

                $new_lang3 = new SmLanguagePhrase();
                $new_lang3->modules  = 1;
                $new_lang3->default_phrases  = "utilities";
                $new_lang3->en  = "Utilities";
                $new_lang3->es  = "Utilities";
                $new_lang3->bn  = "উপযোগিতা";
                $new_lang3->fr  = "Utilities";
                $new_lang3->save();
 

                $new_lang4 = new SmLanguagePhrase();
                $new_lang4->default_phrases  = "student_export";
                $new_lang4->en  = "Student Export";
                $new_lang4->es  = "Student Export";
                $new_lang4->bn  = "ছাত্র রফতানি";
                $new_lang4->fr  = "Student Exports";
                $new_lang4->save();

                $new_lang5 = new SmLanguagePhrase();
                $new_lang5->modules  = 8;
                $new_lang5->default_phrases  = "previous_record";
                $new_lang5->en  = "Previous Record";
                $new_lang5->es  = "Previous Record";
                $new_lang5->bn  = "আগে নথি";
                $new_lang5->fr  = "Previous Record";
                $new_lang5->save();

    
                //about and update menu 
                $utility_menu = InfixModuleInfo::find(4000);
                $about_menu = InfixModuleInfo::find(478);
                $previous_rec = InfixModuleInfo::find(540);
                $absent_time  = InfixModuleInfo::find(950);
                $report  = InfixModuleInfo::find(840);
                if(! $utility_menu){
                    $utility = new InfixModuleInfo();
                    $utility->id = 4000 ;
                    $utility->module_id =18 ;
                    $utility->name = "Utilities";
                    $utility->type = 2;
                    $utility->parent_id = 398;
                    $utility->is_saas = 0;
                    $utility->route = "utility";
                    $utility->lang_name = "utilities";
                    $utility->icon_class = '';
                    $utility->active_status = 1;
                    $utility->school_id = 1;
                    $utility->save();
                }
                
                if($report){
                    $report->id = 840 ;
                    $report->module_id =5;
                    $report->name = "Report";
                    $report->parent_id = 108;
                    $report->type = 2;
                    $report->is_saas = 0;
                    $report->route = "";
                    $report->lang_name = "report";
                    $report->icon_class = '';
                    $report->active_status = 1;
                    $report->school_id = 1;
                    $report->save();
                }


                if($previous_rec){
                    $previous_rec->id = 540 ;
                    $previous_rec->module_id =17;
                    $previous_rec->name = "previous record";
                    $previous_rec->parent_id = 376;
                    $previous_rec->is_saas = 0;
                    $previous_rec->route = "previous-record";
                    $previous_rec->lang_name = "previous-record";
                    $previous_rec->icon_class = '';
                    $previous_rec->active_status = 1;
                    $previous_rec->school_id = 1;
                    $previous_rec->save();
                }
                

                if(is_null($absent_time)){
                    $absent_time = new InfixModuleInfo();
                    $absent_time->id = 950 ;
                    $absent_time->module_id =3 ;
                    $absent_time->name = "Time Setup";
                    $absent_time->type = 2;
                    $absent_time->parent_id = 61;
                    $absent_time->is_saas = 0;
                    $absent_time->route = "notification_time_setup";
                    $absent_time->lang_name = "time_setup";
                    $absent_time->icon_class = '';
                    $absent_time->active_status = 1;
                    $absent_time->school_id = 1;
                    $absent_time->save();
                }
                
                if($about_menu){
                    $about_menu->id = 478 ;
                    $about_menu->module_id =18 ;
                    $about_menu->name = "About & Update";
                    $about_menu->parent_id = 398;
                    $about_menu->is_saas = 0;
                    $about_menu->route = "update-system";
                    $about_menu->lang_name = "about_&_update";
                    $about_menu->icon_class = '';
                    $about_menu->active_status = 1;
                    $about_menu->school_id = 1;
                    $about_menu->save();
                }

                //Fees Carry Forward 
                if(!$exist){
                    $module_info = new InfixModuleInfo();
                }else{
                    $module_info = InfixModuleInfo::find($module_id);
                }
                    $module_info->id = 136 ;
                    $module_info->module_id =5 ;
                    $module_info->name = "Fees Carry Forward";
                    $module_info->parent_id = 108;
                    $module_info->is_saas = 0;
                    $module_info->route = "fees_forward";
                    $module_info->lang_name = "fees_forward";
                    $module_info->icon_class = '';
                    $module_info->active_status = 1;
                    $module_info->school_id = 1;
                    $module_info->save();

   


            $parent_info78 =  InfixModuleStudentParentInfo::find(78);
            if($parent_info78){
                $parent_info78->route = "parent-examination-schedule/{id}";
                $parent_info78->save();
            }

            $parent_info98 =  InfixModuleStudentParentInfo::find(98);
            if($parent_info98){
                $parent_info98->route = "lesson/parent/lessonPlan/{id}";
                $parent_info98->save();
            }

            $parent_info99 =  InfixModuleStudentParentInfo::find(99);
            if($parent_info99){
                $parent_info99->route = "lesson/parent/lessonPlan-overview/{id}";
                $parent_info99->save();
            }

             // StudentAbsentNotification

            $name = 'StudentAbsentNotification';
            $student_absent = InfixModuleManager::where('name',$name)->first();
            if(!($student_absent)){
                $dataPath = 'Modules/StudentAbsentNotification/StudentAbsentNotification.json';
                $strJsonFileContents = file_get_contents($dataPath);
                $array = json_decode($strJsonFileContents, true);
    
                $version = $array[$name]['versions'][0];
                $url = $array[$name]['url'][0];
                $notes = $array[$name]['notes'][0];
    
                $s = new InfixModuleManager();
                $s->name = $name;
                $s->email = 'support@spondonit.com';
                $s->notes = $notes;
                $s->version = $version;
                $s->update_url = $url;
                $s->is_default = 1;
                $s->purchase_code = time();
                $s->installed_domain = url('/');
                $s->activated_date = date('Y-m-d');
                $s->save();
            }

           
            
            $name2 = 'Saas';
            $saas = InfixModuleManager::where('name',$name2)->first();
            if( !($saas)){
                $s = new InfixModuleManager();
                $s->name = $name2;
                $s->email = 'support@spondonit.com';
                $s->notes = "This is Saas module for manage multiple school or institutes.Every school managed by individual admin. Thanks for using.";
                $s->version = "1.1";
                $s->update_url = "https://spondonit.com/contact";
                $s->is_default = 0;
                $s->addon_url = "mailto:support@spondonit.com";
                $s->installed_domain = url('/');
                $s->activated_date = date('Y-m-d');
                $s->save();
            }

            $Xendit = 'XenditPayment';
            $Xendit = InfixModuleManager::where('name',$Xendit)->first();
            if( !($Xendit)){
                $s = new InfixModuleManager();
                $s->name = "XenditPayment";
                $s->email = 'support@spondonit.com';
                $s->notes = "This is Xendit Payment gateway module for online payemnt in this system specially Philipine and Indonesia. Thanks for using.";
                $s->version = "1.0";
                $s->update_url = "https://spondonit.com/contact";
                $s->is_default = 0;
                $s->addon_url = "mailto:support@spondonit.com";
                $s->installed_domain = url('/');
                $s->activated_date = date('Y-m-d');
                $s->save();
            }

            $onlineExamId=875;
            $new= InfixModuleInfo::find($onlineExamId);
            if(!($new)){
                $new = new InfixModuleInfo();
                $new->id = 875 ;
                $new->module_id =35 ;
                $new->name = "Online Exam";
                $new->type = 0;
                $new->parent_id = 0;
                $new->is_saas = 0;
                $new->lang_name = "online_exam";
                $new->icon_class = 'flaticon-book-1';
                $new->active_status = 1;
                $new->school_id = 1;
                $new->save();
            }

           
            $onlineExamMenuIds= [230,234,238];
            foreach($onlineExamMenuIds as $onlineExamMenuId){
                $store= InfixModuleInfo::find($onlineExamMenuId);
                if( $store){
                    $store->module_id =35;
                    $store->parent_id = 875;
                    $store->update();
                }
               
            }

            $onlineExamSubMenuIds= [231,232,233,235,236,237,239,240,241,242,243,244];
            foreach($onlineExamSubMenuIds as $onlineExamSubMenuId){
                $store= InfixModuleInfo::find($onlineExamSubMenuId);
                if($store){
                    $store->module_id =35;
                    $store->update();
                }
            }

            $new_lang6 = SmLanguagePhrase::where('default_phrases','subject_attendance_layout')->first();
            if(! $new_lang6){
                $new_lang6 = new SmLanguagePhrase();
            }
            else{
                $new_lang6 = $lang_pharse ;
            }

        
            $new_lang6->modules  = 8;
            $new_lang6->default_phrases  = "subject_attendance_layout";
            $new_lang6->en  = "Subject Attendance Layout";
            $new_lang6->es  = "Subject Attendance Layout";
            $new_lang6->bn  = "বিষয় উপস্থিতি বিন্যাস";
            $new_lang6->fr  = "Subject Attendance Layout";
            $new_lang6->save();

            $new_lang7 = SmLanguagePhrase::where('default_phrases','layout')->first();
            if(! $new_lang7){
                $new_lang7 = new SmLanguagePhrase();
            }
            else{
                $new_lang7 = $lang_pharse ;
            }

        
            $new_lang7->modules  = 8;
            $new_lang7->default_phrases  = "layout";
            $new_lang7->en  = "Layout";
            $new_lang7->es  = "Layout";
            $new_lang7->bn  = "বিন্যাস";
            $new_lang7->fr  = "Layout";
            $new_lang7->save();

            $new_lang8 = SmLanguagePhrase::where('default_phrases','your')->first();
                if(! $new_lang8){
                    $new_lang8 = new SmLanguagePhrase();
                }
                else{
                    $new_lang8 = $lang_pharse;
                }

		        $new_lang8->modules  = 0;
                $new_lang8->default_phrases  = "your";
                $new_lang8->en  = "Your";
                $new_lang8->es  = "Your";
                $new_lang8->bn  = "তোমার";
                $new_lang8->fr  = "Your";
                $new_lang8->save();

                $lang_pharse9 = SmLanguagePhrase::where('default_phrases','no_data_available_in_table')->first();
                if(! $lang_pharse9){
                    $lang_pharse9 = new SmLanguagePhrase();
                }
                else{
                    $lang_pharse9 = $lang_pharse;
                }

                $lang_pharse9->modules  = 1;
                $lang_pharse9->default_phrases  = "no_data_available_in_table";
                $lang_pharse9->en  = "No data available in table";
                $lang_pharse9->es  = "No data available in table";
                $lang_pharse9->bn  = "সারণীতে কোনও ডেটা উপলব্ধ নেই";
                $lang_pharse9->fr  = "No data available in table";
                $lang_pharse9->save();

                $lang_pharse10 = new SmLanguagePhrase();
		        $lang_pharse10->modules  = 1;
                $lang_pharse10->default_phrases  = "entries";
                $lang_pharse10->en  = "Entries";
                $lang_pharse10->es  = "Entries";
                $lang_pharse10->bn  = "এন্ট্রি";
                $lang_pharse10->fr  = "Entries";
                $lang_pharse10->save();

                $lang_pharse11 = new SmLanguagePhrase();
		        $lang_pharse11->modules  = 1;
                $lang_pharse11->default_phrases  = "quick_search";
                $lang_pharse11->en  = "Quick Search";
                $lang_pharse11->es  = "Quick Search";
                $lang_pharse11->bn  = "দ্রুত অনুসন্ধান";
                $lang_pharse11->fr  = "Quick Search";
                $lang_pharse11->save();

                $lang_pharse12 = new SmLanguagePhrase();
		        $lang_pharse12->modules  = 1;
                $lang_pharse12->default_phrases  = "xendit";
                $lang_pharse12->en  = "xendit";
                $lang_pharse12->es  = "xendit";
                $lang_pharse12->bn  = "সেন্ডিত";
                $lang_pharse12->fr  = "xendit";
                $lang_pharse12->save();



            $path = base_path() . "/.env";
                
            $envFile = app()->environmentFilePath();
            $str = file_get_contents($envFile);
                    $envKey='FORCE_HTTPS';
                    $envValue='"'."false".'"';
                    $str .= "\n";
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
            $str = substr($str, 0, -1);
                   
        }catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
    
    public function down()
    {
        Schema::dropIfExists('update_version');
    }
}
