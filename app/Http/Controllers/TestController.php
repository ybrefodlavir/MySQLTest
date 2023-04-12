<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TestController extends Controller
{
    public function index(Request $request)
    {
        DB::connection('mysql-test')->beginTransaction();
        $question_id = $request->input('question_id');
        $attempt_count = Answer::where([['student_id', 1], ['question_id', $question_id]])->count();
        $attempt_count = $attempt_count != 0 ? $attempt_count + 1 : 1;


        $code = $request->input('code');
        try {
            if (preg_match('(drop|create|alter|select)i', $code) === 1) {
                return response()->json(['status' => 'error', 'message' => "Code not allowed"]);
            } else if (preg_match('(insert|update|delete)i', $code) === 1) {
                DB::connection('mysql-test')->statement($code);


                // validation here
                $validation = $this->statementValidation($question_id);

                if ($validation['status'] == false) {
                    DB::connection('mysql-test')->rollBack();
                    return response()->json(['status' => 'error', 'message' => "Answer is wrong " . $validation['message']]);
                } else {
                    DB::connection('mysql-test')->rollBack();
                    Answer::create([
                        'student_id' => 1,
                        'question_id' => $question_id,
                        'code' => $code,
                        'status' => 1,
                        'attempt' => $attempt_count,
                        'message' => 'Code executed successfully'
                    ]);
                    return response()->json(['status' => 'success', 'message' => "Code executed successfully"]);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => "Your code can't be identified"]);
            }
        } catch (\Throwable $error) {
            Answer::create([
                'student_id' => 1,
                'question_id' => $question_id,
                'code' => $code,
                'status' => 0,
                'attempt' => $attempt_count,
                'message' => $error->getMessage()
            ]);
            DB::connection('mysql-test')->rollBack();
            return response()->json(['status' => 'error', 'message' =>  $error->getMessage()]);
        }
    }
    private function statementValidation($question_id)
    {
        $question = Question::find($question_id);
        $validation_statement = json_decode($question->validation_statement, true);
        $validation_value = json_decode($question->validation_value, true);
        $valid = [
            'status' => false,
            'message' => '',
        ];
        if ($question->type == "insert single") {
            $query = DB::connection('mysql-test')->table($validation_statement['tableName'])
                ->selectRaw($validation_statement['selectRaw'])
                ->whereRaw($validation_statement['whereRaw'])
                ->first();
            foreach ($validation_value as $property => $value) {
                if ($value !== $query->$property) {
                    $valid['status'] = false;
                    $valid['message'] = "The value doesn't match";
                    return $valid;
                } else {
                    $valid['status'] = true;
                }
            }
        } else if ($question->type == "insert multiple") {
            $query = DB::connection('mysql-test')->table($validation_statement['tableName'])
                ->selectRaw($validation_statement['selectRaw'])
                ->whereRaw($validation_statement['whereRaw'])
                ->get();
            foreach ($validation_value as $key => $row) {
                foreach ($row as $property => $value) {
                    if ($value !== $query[$key]->$property) {
                        $valid['status'] = false;
                        $valid['message'] = "The value doesn't match";
                        return $valid;
                    } else {
                        $valid['status'] = true;
                    }
                }
            }
        }
        return $valid;
    }
}
