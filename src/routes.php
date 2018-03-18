<?php

use Fr3ddy\Laratoor\AccountApi;
use Illuminate\Http\Request;

Route::group(['middleware' => ['web']], function () {
    Route::get('/toornament/redirect',function(Request $request){
        $accountApi = new AccountApi();
        if(session('toornament_state') == $request->state){
            session(['toornament_code' => $request->code]);
            $accountApi->authorize();
            return redirect(session('toornament_redirect_url'));
        }else{
            echo "<b>Authorization went wrong!</b>";
        }
    });
});