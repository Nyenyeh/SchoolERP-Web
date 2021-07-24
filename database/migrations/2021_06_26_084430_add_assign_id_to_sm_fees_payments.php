<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\InfixModuleInfo;
use Modules\RolePermission\Entities\InfixPermissionAssign;

class AddAssignIdToSmFeesPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sm_fees_payments', function (Blueprint $table) {
            $name ="assign_id";
            if (!Schema::hasColumn('sm_fees_payments', $name)) {
                $table->integer('assign_id')->nullable()->unsigned()->after('amount');
                $table->foreign('assign_id')->references('id')->on('sm_fees_assigns')->onDelete('cascade');

            }
           
        });

        try {

          $sql = ("INSERT INTO `infix_module_infos` (`id`, `module_id`, `parent_id`, `type`, `is_saas`, `name`, `route`, `lang_name`, `icon_class`, `active_status`, `created_by`, `updated_by`, `school_id`, `created_at`, `updated_at`) VALUES 
        
        (1001, 5, 113, '3', 0,'Edit','','','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22'),
        (1002, 5, 113, '3', 0,'Delete','','','', 1, 1, 1, 1, '2019-07-25 02:21:21', '2019-07-25 04:24:22')
          ");
        DB::insert($sql);

        $admins = [1001,1002];

        foreach ($admins as $key => $value) {

            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info =InfixModuleInfo::find($value) ? InfixModuleInfo::find($value)->name :'';
            $permission->role_id = 5;
            $permission->save();
        }

        foreach ($admins as $key => $value) {

            $permission = new InfixPermissionAssign();
            $permission->module_id = $value;
            $permission ->module_info =InfixModuleInfo::find($value) ? InfixModuleInfo::find($value)->name :'';
            $permission->role_id = 6;
            $permission->save();
        }

          } catch (\Throwable $th) {
            Log::info($th);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sm_fees_payments', function (Blueprint $table) {
            //
            $table->dropColumn('assign_id');
        });
    }
}
