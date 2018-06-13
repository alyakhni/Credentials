<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Response;
use Laravel\Passport;

class Clients extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $hint = NULL;
      if (empty($request->name)) {
        $hint = "name";
      }

      if(empty($request->redirect)){
        $hint = "redirect";
      }

      if(!empty($hint)){
        return Response::error(
          $response,
          array(
            "error" => "invalid_request",
            "message" => Response::MISSING_PARAMS,
            "hint" => "Check the `$hint` parameter"
          )
        );
      }

      $password_client = FALSE;

      if(!empty($request->password_client) && $request->password_client == TRUE){
          $password_client = TRUE;
      }

      DB::table('users')->insert(
        ['name' => $request->name, 'redirect' => $request->redirect]
      );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
