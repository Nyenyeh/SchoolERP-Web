<?php

use App\InfixModuleManager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\Log;

class CreateInfixModuleManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infix_module_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('notes', 255)->nullable();
            $table->string('version', 200)->nullable();
            $table->string('update_url', 200)->nullable();
            $table->string('purchase_code', 200)->nullable();
            $table->string('checksum', 200)->nullable();
            $table->string('installed_domain', 200)->nullable();
            $table->boolean('is_default')->default(0);
            $table->string('addon_url')->nullable();
            $table->date('activated_date')->nullable();
            $table->timestamps();
        });

        try {
            // RolePermission
            $dataPath = 'Modules/RolePermission/RolePermission.json';
            $name = 'RolePermission';
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

            //MenuManage

            $dataPath = 'Modules/MenuManage/MenuManage.json';
            $name = 'MenuManage';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new InfixModuleManager();
            $s->name = $name;
            $s->is_default = 1;
            $s->email = 'support@spondonit.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            // Lesson Planner
            $dataPath = 'Modules/Lesson/Lesson.json';
            $name = 'Lesson';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = $notes;
            $s->is_default = 1;
            $s->version = $version;
            $s->update_url = $url;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            // Chat
            $dataPath = 'Modules/Chat/Chat.json';
            $name = 'Chat';
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


            // TemplateSettings
            $dataPath = 'Modules/TemplateSettings/TemplateSettings.json';
            $name = 'TemplateSettings';
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

            // StudentAbsentNotification
            $dataPath = 'Modules/StudentAbsentNotification/StudentAbsentNotification.json';
            $name = 'StudentAbsentNotification';
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


            // Zoom
            $name = 'Zoom';
            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = "This is Zoom module for live virtual class and meeting in this system at a time. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "https://codecanyon.net/item/infixedu-zoom-live-class/27623128?s_rank=12";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // ParentRegistration
            $name = 'ParentRegistration';
            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = "This is Parent Registration module for Registration. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "https://codecanyon.net/item/parent-registration-or-student-registration-module-for-infixedu/27762693?s_rank=10";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // RazorPay
            $dataPath = 'Modules/RazorPay/RazorPay.json';
            $name = 'RazorPay';

            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = "This is Razor Pay module for Online payemnt. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "https://codecanyon.net/item/razorpay-payment-gateway-for-infixedu/27721206?s_rank=11";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // BigBlueButton
            $name = 'BBB';
            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = "This is BigBlueButton module for live virtual class and meeting in this system at a time. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@spondonit.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // Jitsi
           
            $name = 'Jitsi';
            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = "This is Jitsi module for live virtual class and meeting in this system at a time. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@spondonit.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // Saas
           
            $name = 'Saas';
            $s = new InfixModuleManager();
            $s->name = $name;
            $s->email = 'support@spondonit.com';
            $s->notes = "This is Saas module for manage multiple school or institutes.Every school managed by individual admin. Thanks for using.";
            $s->version = "1.1";
            $s->update_url = "https://spondonit.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@spondonit.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();
                    
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infix_module_managers');
    }
}
