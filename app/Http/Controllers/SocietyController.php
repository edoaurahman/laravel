<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Society;

class SocietyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $society = Society::all();
        return response()->json([
            'status' => "200",
            'data' => $society
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $society = Society::where('id_card_number', $request->id_card_number)->where('password', $request->password)->with('regional')->first();
        if ($society) {
            $society->login_tokens = md5($request->id_card_number);
            $society->save();
            return response()->json([
                'status' => "200",
                'data' => $society
            ]);
        }else{
            return response()->json([
                'status' => "401",
                'message' => "ID Card Number or Password incorrect"
            ]);
        }
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
    
    public function logout(Request $request){
        $society = Society::where('login_tokens', $request->token)->first();
        if ($society) {
            $society->login_tokens = null;
            $society->save();
           return response()->json([
               'status' => "200",
               'message' => "Logout success"
           ]);  
        }else{
            return response()->json([
                'status' => "401",
                'message' => "Invalid token"
            ]); 
        }
    }
}
