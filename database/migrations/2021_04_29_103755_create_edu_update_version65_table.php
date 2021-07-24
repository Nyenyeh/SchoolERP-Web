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

class CreateEduUpdateVersion65Table extends Migration
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

                $name ="StudentAbsentNotification";
                        if (!Schema::hasColumn('sm_general_settings', $name)) {
                            Schema::table('sm_general_settings', function ($table) use ($name) {
                                $table->integer('StudentAbsentNotification')->default(1)->nullable();
                            });
                        }
                    $name ="attendance_layout";
                        if (!Schema::hasColumn('sm_general_settings', $name)) {
                            Schema::table('sm_general_settings', function ($table) use ($name) {
                                $table->integer('attendance_layout')->default(1)->nullable();
                            });
                        }

                //fees carryfoward menu manager and role permission 
                $module_id = 136;
                $exist = InfixModuleInfo::find($module_id);
                $exist2 = Sidebar::where('infix_module_id',$module_id)->first();

                //remove About menu 
                $exist3 = InfixModuleInfo::find(477);
                $exist4 = Sidebar::where('infix_module_id',477)->first();

                if($exist3){
                    $exist3->delete();
                }
                if($exist4){
                    $exist4->delete();
                }

                $menu_manage = MenuManage::where('module_id',477)->first();
                if($menu_manage){
                    $menu_manage->delete();
                }

                $user_menu = UserMenu::where('module_id',477)->first();
                if($menu_manage){
                    $menu_manage->delete();
                }

                $lang_pharse = SmLanguagePhrase::where('default_phrases','about_&_update')->first();
                if(! $lang_pharse){
                    $new_lang = new SmLanguagePhrase();
                }
                else{
                    $new_lang = $lang_pharse ;
                }

               
                $new_lang->modules  = 17;
                $new_lang->default_phrases  = "about_&_update";
                $new_lang->en  = "About & Update";
                $new_lang->es  = "About & Update";
                $new_lang->bn  = "সম্পর্ক এবং আপডেট";
                $new_lang->fr  = "About & Update";
                $new_lang->save();

                $new_lang->modules  = 17;
                $new_lang->default_phrases  = "add_days";
                $new_lang->en  = "Add Days";
                $new_lang->es  = "About & Update";
                $new_lang->bn  = "দিন যোগ করুন";
                $new_lang->fr  = "Add Days";
                $new_lang->save();
 

                $new_lang->modules  = 17;
                $new_lang->default_phrases  = "student_export";
                $new_lang->en  = "Student Export";
                $new_lang->es  = "Student Export";
                $new_lang->bn  = "ছাত্র রফতানি";
                $new_lang->fr  = "Student Exports";
                $new_lang->save();

                $new_lang->modules  = 8;
                $new_lang->default_phrases  = "previous_record";
                $new_lang->en  = "Previous Record";
                $new_lang->es  = "Previous Record";
                $new_lang->bn  = "আগে নথি";
                $new_lang->fr  = "Previous Record";
                $new_lang->save();

                //add fees carry forward if menu manage by super admin 

                $admin_menu = UserMenu::where('user_id',1)->where('role_id',1)->first();
                if($admin_menu){
                    $fees_forwarMenu = new UserMenu();
                    $fees_forwarMenu->module_id =136; 
                    $fees_forwarMenu->parent_id =108; 
                    $fees_forwarMenu->role_id =1; 
                    $fees_forwarMenu->user_id =1; 
                    $fees_forwarMenu->academic_id =1;
                    $fees_forwarMenu->school_id =1;
                    $fees_forwarMenu->active_status =1; 
                    $fees_forwarMenu->save();

                    $menu_man = new MenuManage();
                    $menu_man->module_id =136; 
                    $menu_man->parent_id =108; 
                    $menu_man->module_addons =5; 
                    $menu_man->active_status =1; 
                    $menu_man->parent_position_no =136; 
                    $menu_man->child_id =136; 
                    $menu_man->child_position_no =0;
                    $menu_man->child_active_status =1;
                    $menu_man->role_id =1;
                    $menu_man->user_id =1; 
                    $menu_man->academic_id =1;
                    $menu_man->school_id =1;
                    $menu_man->save();
                }


                //about and update menu 
               
                $about_menu = InfixModuleInfo::find(478);
                $previous_rec = InfixModuleInfo::find(540);
                $absent_time  = InfixModuleInfo::find(950);
                $report  = InfixModuleInfo::find(840);
                
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

                    $report_sidebar = Sidebar::where('infix_module_id',840)->first();
                    if($report_sidebar){
                        $report_sidebar->module_id  = 840;
                        $report_sidebar->infix_module_id  = 840;
                        $report_sidebar->parent_id  = 5;
                        $report_sidebar->child_id  = 0;
                        $report_sidebar->lan_name  = "report";
                        $report_sidebar->name  = "Report";
                        $report_sidebar->icon_class  = "";
                        $report_sidebar->is_saas  = 0;
                        $report_sidebar->route  = "";
                        $report_sidebar->active_status  = 1;
                        $report_sidebar->school_id = 1;
                        $report_sidebar->save();

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

                    $previous_sidebar = Sidebar::where('infix_module_id',540)->first();

                    $previous_sidebar->module_id  = 540;
                    $previous_sidebar->infix_module_id  = 540;
                    $previous_sidebar->parent_id  = 17;
                    $previous_sidebar->child_id  = 0;
                    $previous_sidebar->lan_name  = "previous-record";
                    $previous_sidebar->name  = "previous record";
                    $previous_sidebar->icon_class  = "";
                    $previous_sidebar->is_saas  = 0;
                    $previous_sidebar->route  = "previous-record";
                    $previous_sidebar->active_status  = 1;
                    $previous_sidebar->school_id = 1;
                    $previous_sidebar->save();
                }
                

                if(is_null($absent_time)){
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

                    $absent_sidebar = Sidebar::where('infix_module_id',950)->first();

                    $absent_sidebar->module_id  = 950;
                    $absent_sidebar->infix_module_id  = 950;
                    $absent_sidebar->parent_id  = 3;
                    $absent_sidebar->child_id  = 0;
                    $absent_sidebar->lan_name  = "time_setup";
                    $absent_sidebar->name  = "Time Setup";
                    $absent_sidebar->icon_class  = "";
                    $absent_sidebar->is_saas  = 0;
                    $absent_sidebar->route  = "notification_time_setup";
                    $absent_sidebar->active_status  = 1;
                    $absent_sidebar->school_id = 1;
                    $absent_sidebar->save();
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

                    $about_sidebar = Sidebar::where('infix_module_id',478)->first();

                    $about_sidebar->module_id  = 478;
                    $about_sidebar->infix_module_id  = 478;
                    $about_sidebar->parent_id  = 18;
                    $about_sidebar->child_id  = 0;
                    $about_sidebar->lan_name  = "about_&_update";
                    $about_sidebar->name  = "About & Update";
                    $about_sidebar->icon_class  = "";
                    $about_sidebar->is_saas  = 0;
                    $about_sidebar->route  = "update-system";
                    $about_sidebar->active_status  = 1;
                    $about_sidebar->school_id = 1;
                    $about_sidebar->save();
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

                    if(!$exist2){
                        $sidebar = new Sidebar();
                    }else{
                        $sidebar = Sidebar::where('infix_module_id',$module_id)->first();
                    }
                    $sidebar->module_id  = 136;
                    $sidebar->infix_module_id  = 136;
                    $sidebar->parent_id  = 5;
                    $sidebar->child_id  = 0;
                    $sidebar->lan_name  = "fees_forward";
                    $sidebar->name  = "Fees Carry Forward";
                    $sidebar->icon_class  = "";
                    $sidebar->is_saas  = 0;
                    $sidebar->route  = "fees_forward";
                    $sidebar->active_status  = 1;
                    $sidebar->school_id = 1;
                    $sidebar->save();

                    $general = SmGeneralSettings::first();
                    $general->software_version = "6.1.5";
                    $general-> system_version = "6.1.5";
                    $general->save();


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
            if(is_null($student_absent)){
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

            $module = InfixModuleInfo::find($onlineExamId);
            if(! $module){
                $sidebar = new Sidebar();       
                $sidebar->name=str_replace(['Menu','menu','module','Module'],'',$module->name);
                $sidebar->icon_class=$module->icon_class;
                $sidebar->lan_name=$module->lang_name;
                $sidebar->module_id =$module->module_id;
                $sidebar->parent_id =$module->parent_id;
                $sidebar->infix_module_id=$module->id;
                $sidebar->route=$module->route;        
                $sidebar->save();
            }

            $onlineExamMenuIds= [230,234,238];
            foreach($onlineExamMenuIds as $onlineExamMenuId){
                $store= InfixModuleInfo::find($onlineExamMenuId);
                $store->module_id =35;
                $store->parent_id = 875;
                $store->update();

                $moduleMenu=Sidebar::find($onlineExamMenuId);
                if($moduleMenu){
                    $moduleMenu->module_id =$module->module_id;
                    $moduleMenu->parent_id =$module->parent_id;        
                    $moduleMenu->update();
                }
            }

            $onlineExamSubMenuIds= [231,232,233,235,236,237,239,240,241,242,243,244];
            foreach($onlineExamSubMenuIds as $onlineExamSubMenuId){
                $store= InfixModuleInfo::find($onlineExamSubMenuId);
                if($store){
                    $store->module_id =35;
                    $store->update();
                }
                

                $moduleMenu=Sidebar::find($onlineExamSubMenuId);
                if($moduleMenu){
                    $moduleMenu->module_id =$module->module_id;   
                    $moduleMenu->update();
                }
            }

            $lang_pharse = SmLanguagePhrase::where('default_phrases','subject_attendance_layout')->first();
            if(! $lang_pharse){
                $new_lang = new SmLanguagePhrase();
            }
            else{
                $new_lang = $lang_pharse ;
            }

        
            $new_lang->modules  = 8;
            $new_lang->default_phrases  = "subject_attendance_layout";
            $new_lang->en  = "Subject Attendance Layout";
            $new_lang->es  = "Subject Attendance Layout";
            $new_lang->bn  = "বিষয় উপস্থিতি বিন্যাস";
            $new_lang->fr  = "Subject Attendance Layout";
            $new_lang->save();

            $lang_pharse = SmLanguagePhrase::where('default_phrases','layout')->first();
            if(! $lang_pharse){
                $new_lang = new SmLanguagePhrase();
            }
            else{
                $new_lang = $lang_pharse ;
            }

        
            $new_lang->modules  = 8;
            $new_lang->default_phrases  = "layout";
            $new_lang->en  = "Layout";
            $new_lang->es  = "Layout";
            $new_lang->bn  = "বিন্যাস";
            $new_lang->fr  = "Layout";
            $new_lang->save();
                   
        }catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
    
    public function down()
    {
        Schema::dropIfExists('update_version');
    }
}
