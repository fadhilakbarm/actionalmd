<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Flasher\Prime\FlasherInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use DataTables;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }

    public function data()
    {
        $data = User::select('*');

        return DataTables::eloquent($data)
                ->addColumn('menu', function ($model) {
                    $column = '<div>
                        <a href="'. route('user.edit', $model->id) .'" class="btn btn-sm btn-primary">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <a class="btn btn-sm btn-danger text-white" onclick="deleteData('. $model->id .')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </a>    
                    </div>';

                    return $column;
                })
                ->rawColumns(['menu'])
                ->toJson();
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();
                        
            Validator::make($request->all(), [
                'first_name'    => 'required',
                'last_name'     => 'required',
                'age'           => 'required',
                'gender'        => 'required',
                'joined_date'   => 'required'
            ])->validate();

            $user = new User();
            $user->first_name     = $request->first_name;
            $user->last_name      = $request->last_name;
            $user->age            = $request->age;
            $user->gender         = $request->gender;
            $user->joined_date    = $request->joined_date;
            $user->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('user.index');
        } catch(Exception $e) {
            DB::rollback();

            $flasher->addError($e->getMessage(), "Validation Error", ['timer' => 10000]);
            
            return redirect()->back()->withInput();
        }
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);

        return view('user.edit', compact('data'));
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();
                        
            Validator::make($request->all(), [
                'first_name'    => 'required',
                'last_name'     => 'required',
                'age'           => 'required',
                'gender'        => 'required',
                'joined_date'   => 'required'
            ])->validate();

            $user = User::findOrFail($id);
            $user->first_name     = $request->first_name;
            $user->last_name      = $request->last_name;
            $user->age            = $request->age;
            $user->gender         = $request->gender;
            $user->joined_date    = $request->joined_date;
            $user->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('user.index');
        } catch(Exception $e) {
            DB::rollback();

            $flasher->addError($e->getMessage(), "Validation Error", ['timer' => 10000]);
            
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $data = User::findOrFail($id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

}