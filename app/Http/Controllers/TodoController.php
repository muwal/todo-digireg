<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $todos = DB::table('todos')
            ->select('todos.*', 'priorities.name as priority')
            ->join('priorities', 'priorities.id', '=', 'todos.id_priority')
            ->get();
        $serTodos = $this->serializeArticle($todos, 'array');
        if ($serTodos) {
            return response([
                'success'   => true,
                'message'   => 'List Todo',
                'data'      => $serTodos
            ], 200);
        } else {
            return response([
                'success'   => true,
                'message'   => 'Data Not Found!',
                'data'      => []
            ], 200);
        }
    }

    public function store(Request $request)
    {
        //validate data
        $validator = Validator::make(
            $request->all(),
            [
                'tasks'      => 'required',
                'id_priority'      => 'required',
                'start_date'      => 'required',
                'deadline'      => 'required',
                'status'      => 'required',
            ],
            [
                'tasks'     => 'Tasks Is Required!',
                'id_priority'      => 'Priority Is Required!',
                'start_date'      => 'Start Date Is Required!',
                'deadline'      => 'Deadline Is Required!',
                'status'      => 'Status Is Required!',
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Please Fill The Required Fields!',
                'data'    => $validator->errors()
            ], 400);
        } else {

            $todo = Todo::create([
                'tasks'      => $request->input('tasks'),
                'id_priority'      => $request->input('id_priority'),
                'start_date'      => $request->input('start_date'),
                'deadline'      => $request->input('deadline'),
                'status'      => $request->input('status'),
            ]);

            if ($todo) {
                return response()->json([
                    'success' => true,
                    'message' => 'Success Create Data!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed Create Data!',
                ], 400);
            }
        }
    }

    public function show($id, Request $request)
    {

        $todo = DB::table('todos')
            ->select('todos.*', 'priorities.name as priority')
            ->join('priorities', 'priorities.id', '=', 'todos.id_priority')
            ->where('todos.id', '=', $id)
            ->get();
        $serTodo = $this->serializeArticle($todo, 'object');
        if ($serTodo) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Todo!',
                'data'    => $serTodo
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data Not Found!',
                'data'    => (object)array()
            ], 200);
        }
    }

    public function update($id, Request $request)
    {

        //validate data
        $validator = Validator::make(
            $request->all(),
            [
                'tasks'      => 'required',
                'id_priority'      => 'required',
                'start_date'      => 'required',
                'deadline'      => 'required',
                'status'      => 'required',
            ],
            [
                'tasks'     => 'Tasks Is Required!',
                'id_priority'      => 'Priority Is Required!',
                'start_date'      => 'Start Date Is Required!',
                'deadline'      => 'Deadline Is Required!',
                'status'      => 'Status Is Required!',
            ]
        );

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Please Fill The Required Fields!',
                'data'    => $validator->errors()
            ], 400);
        } else {

            //upload image            
            $todo = Todo::whereId($id)->first();

            $todo = $todo->update([
                'tasks'      => $request->input('tasks'),
                'id_priority'      => $request->input('id_priority'),
                'start_date'      => $request->input('start_date'),
                'deadline'      => $request->input('deadline'),
                'status'      => $request->input('status'),
            ]);

            if ($todo) {
                return response()->json([
                    'success' => true,
                    'message' => 'Success Update Data!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed Update Data!',
                ], 500);
            }
        }
    }

    public function destroy($id, Request $request)
    {

        $todo = Todo::findOrFail($id);
        $todo->delete();

        if ($todo) {
            return response()->json([
                'success' => true,
                'message' => 'Success Delete Data!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed Delete Data!',
            ], 500);
        }
    }

    public static function serializeArticle($todos, $type)
    {
        $data = array();
        foreach ($todos as $todo) {
            $item =  array(
                'id'    => $todo->id,
                'tasks'    => $todo->tasks,
                'priority'    => $todo->priority,
                'start_date'    => $todo->start_date,
                'deadline'    => $todo->deadline,
                'status'    => $todo->status,
                'created_at'    => $todo->created_at,
                'updated_at'    => $todo->updated_at,
            );

            if ($type == 'array') {
                $data[] = $item;
            } else {
                $data = $item;
            }
        }
        return $data;
    }
}
