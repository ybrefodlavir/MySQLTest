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
                    $this->create_answer(1, $question_id, $code, 0, $attempt_count, "Answer is wrong " . $validation['message']);
                    return response()->json(['status' => 'error', 'message' => "Answer is wrong " . $validation['message']]);
                } else {
                    DB::connection('mysql-test')->rollBack();
                    $this->create_answer(1, $question_id, $code, 1, $attempt_count, 'Code executed successfully');
                    return response()->json(['status' => 'success', 'message' => "Code executed successfully"]);
                }
            } else {
                $this->create_answer(1, $question_id, $code, 0, $attempt_count, "Your code can't be identified");
                return response()->json(['status' => 'error', 'message' => "Your code can't be identified"]);
            }
        } catch (\Throwable $error) {
            $this->create_answer(1, $question_id, $code, 0, $attempt_count, $error->getMessage());
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

        if ($question->type == Question::$InsertSingle || $question->type == Question::$InsertSingleSpecific) {
            $query = DB::connection('mysql-test')->table($validation_statement['tableName'])
                ->selectRaw($validation_statement['selectRaw'])
                ->whereRaw($validation_statement['whereRaw'])
                ->first();
            if ($question->type == Question::$InsertSingleSpecific) {
                $nullKey = $validation_statement['nullKey'];
                if ($query->$nullKey !== null) {
                    $valid['status'] = false;
                    $valid['message'] = $validation_statement['nullKey'] . " must be null";
                    return $valid;
                }
            }
            foreach ($validation_value as $property => $value) {
                if ($value !== $query->$property) {
                    $valid['status'] = false;
                    $valid['message'] = "The value doesn't match";
                    return $valid;
                } else {
                    $valid['status'] = true;
                }
            }
        } else if ($question->type == Question::$InsertMultiple || $question->type == Question::$InsertMultipleSpecific) {
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
        } else if ($question->type == Question::$UpdateAll) {
            $query = DB::connection('mysql-test')->table($validation_statement['tableName'])
                ->selectRaw($validation_statement['selectRaw'])
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
        } else if ($question->type == Question::$UpdateSpecific) {
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
        } else if ($question->type == Question::$DeleteSpecific) {
            $query = DB::connection('mysql-test')->table($validation_statement['tableName'])
                ->selectRaw($validation_statement['selectRaw'])
                ->whereRaw($validation_statement['whereRaw'])
                ->get();
            if (!$query->empty()) {
                $valid['status'] = false;
                $valid['message'] = "The data haven't been deleted";
                return $valid;
            } else {
                $valid['status'] = true;
            }
        } else if ($question->type == Question::$DeleteAll) {
            $query = DB::connection('mysql-test')->table($validation_statement['tableName'])
                ->get();
            if (!$query->empty()) {
                $valid['status'] = false;
                $valid['message'] = "The data haven't been deleted";
                return $valid;
            } else {
                $valid['status'] = true;
            }
        }


        return $valid;
    }

    private function create_answer($student_id, $question_id, $code, $status, $attempt_count, $message)
    {
        Answer::create([
            'student_id' => $student_id,
            'question_id' => $question_id,
            'code' => $code,
            'status' => $status,
            'attempt' => $attempt_count,
            'message' => $message
        ]);
    }
}
