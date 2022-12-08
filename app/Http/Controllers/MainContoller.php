<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use App\Models\Employee;
use Image;

class MainContoller extends Controller
{

    public function index(){

        $employees = Employee::all();

        return view('dashboard', compact('employees'));
    }

    public function edit($id){

        $employee = Employee::where('id', $id)->first();

        return view('edit', compact('employee'));

    }

    public function update(Request $request,  $id){

        $request->validate([

            'name' => 'min:2|max:256|required',
            'email' => ['email','required',Rule::unique('employees')->ignore($id),],
            'amount_salary' => ['numeric','min:0','max:500'],
            'photo' => ['file', 'max:5000', 'image','dimensions:min_width=300,min_height=300'],

        ]);

        $image = $request->photo;

        $filename = $image->getClientOriginalName();

        $image = Image::make($image->getRealPath());

        $image->crop(300, 300)->save(Storage::path('/public/image/').'employees/'.$filename, 80);

        // $image->move(Storage::path('/public/image/').'employees/',$filename);

        $filename = Storage::url('image/employees/'.$filename);

        Employee::where('id', $id)->update([

            'name'=> $request->name,
            'email' => $request->email,
            'amount_salary' => $request->amount_salary,
            'photo' => $filename

        ]);

        return redirect()->route('dashboard')->with('message', 'User updated successfully');

    }

    public function delete($id){

        Employee::where('id', $id)->delete();

        return redirect()->back()->with('message', 'User deleted successfully');

    }

}
