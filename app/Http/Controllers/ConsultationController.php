<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Society;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get($token)
    {
        $society = Society::where('login_tokens', $token)->first();
        if ($society) {
            $consul = Consultation::where('society_id', $society->id)->get();
            return response()->json([
                'status' => "200",
                "consultation" => $consul
            ]);
        }else{
            return response()->json([
                'status' => "401",
                'message' => "Unauthorized user"
            ]); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reqconsul($token,Request $request)
    {
        $society = Society::where('login_tokens', $token)->first();
        if ($society) {
            $consul = new Consultation();
            $consul->society_id = $society->id;
            $consul->disease_history = $request->disease_history;
            $consul->current_symptoms = $request->current_symptoms;
            $consul->save();
            return response()->json([
                'status' => "200",
                "message" => "Request consultation sent successful"
            ]);
        }else{
            return response()->json([
                'status' => "401",
                'message' => "Unauthorized user"
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
}
